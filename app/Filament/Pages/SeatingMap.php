<?php

namespace App\Filament\Pages;

use App\Models\Reservation;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SeatingMap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static string $view = 'filament.pages.seating-map';

    protected static ?string $navigationLabel = 'Seating Layout Map';

    protected static ?string $title = 'Interactive Seating Layout Map';

    // Default seating layout static blueprint
    public const SECTIONS = [
        'main_dining' => [
            'name' => 'Main Dining Hall',
            'tables' => [
                ['id' => 'Table 1', 'capacity' => 4, 'shape' => 'square'],
                ['id' => 'Table 2', 'capacity' => 4, 'shape' => 'square'],
                ['id' => 'Table 3', 'capacity' => 6, 'shape' => 'banquet'],
                ['id' => 'Table 4', 'capacity' => 6, 'shape' => 'banquet'],
                ['id' => 'Table 5', 'capacity' => 2, 'shape' => 'round'],
                ['id' => 'Table 6', 'capacity' => 2, 'shape' => 'round'],
                ['id' => 'Table 7', 'capacity' => 8, 'shape' => 'banquet'],
                ['id' => 'Table 8', 'capacity' => 8, 'shape' => 'banquet'],
                ['id' => 'Table 9', 'capacity' => 4, 'shape' => 'square'],
                ['id' => 'Table 10', 'capacity' => 4, 'shape' => 'square'],
            ]
        ],
        'family_room' => [
            'name' => 'Family Room & Suites',
            'tables' => [
                ['id' => 'Family Table 1', 'capacity' => 4, 'shape' => 'square'],
                ['id' => 'Family Table 2', 'capacity' => 4, 'shape' => 'square'],
                ['id' => 'Family Suite A', 'capacity' => 8, 'shape' => 'banquet'],
                ['id' => 'Family Suite B', 'capacity' => 8, 'shape' => 'banquet'],
                ['id' => 'Family Room 1', 'capacity' => 6, 'shape' => 'round'],
                ['id' => 'Family Room 2', 'capacity' => 6, 'shape' => 'round'],
            ]
        ],
        'outdoor_dera' => [
            'name' => 'Outdoor Punjabi Dera',
            'tables' => [
                ['id' => 'Dera Charpai 1', 'capacity' => 4, 'shape' => 'charpai'],
                ['id' => 'Dera Charpai 2', 'capacity' => 4, 'shape' => 'charpai'],
                ['id' => 'Dera Corner 3', 'capacity' => 6, 'shape' => 'charpai'],
                ['id' => 'Royal Tent A', 'capacity' => 10, 'shape' => 'banquet'],
                ['id' => 'Royal Tent B', 'capacity' => 10, 'shape' => 'banquet'],
                ['id' => 'Dera Dewan 1', 'capacity' => 8, 'shape' => 'charpai'],
            ]
        ]
    ];

    // Livewire state
    public $selectedDate;
    public $selectedTableId = null;
    public $selectedReservationId = null;
    public $assignmentStatus = 'confirmed';
    
    public $isAssignModalOpen = false;
    public $isDetailsModalOpen = false;
    public $activeReservationData = [];

    // Floor Plan Editing State
    public bool $isEditMode = false;
    public bool $isEditTableModalOpen = false;
    public bool $isAddTableModalOpen = false;

    // Edit Table form fields
    public string $editingTableId = '';
    public string $editTableName = '';
    public string $editTableSection = 'main_dining';
    public int $editTableCapacity = 4;
    public string $editTableShape = 'square';

    // Add Table form fields
    public string $newTableName = '';
    public string $newTableSection = 'main_dining';
    public int $newTableCapacity = 4;
    public string $newTableShape = 'square';

    public function mount(): void
    {
        $this->selectedDate = date('Y-m-d');
    }

    /**
     * Retrieve customizable floor plan from database settings or fallback to default blueprint.
     */
    public function getPlanData(): array
    {
        $record = DB::table('pos_settings')->where('key', 'seating_layout_plan')->first();
        if ($record && !empty($record->value)) {
            $decoded = json_decode($record->value, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }
        return self::SECTIONS;
    }

    /**
     * Persist customized floor plan into pos_settings.
     */
    public function savePlanData(array $plan): void
    {
        DB::table('pos_settings')->updateOrInsert(
            ['key' => 'seating_layout_plan'],
            ['value' => json_encode($plan), 'updated_at' => now()]
        );
    }

    /**
     * Toggle between Live Operations and Floor Plan Editor mode.
     */
    public function toggleEditMode(): void
    {
        $this->isEditMode = !$this->isEditMode;
        $this->resetModalState();
    }

    /**
     * Get all active assigned reservations for the selected date.
     */
    public function getAssignedReservationsProperty()
    {
        return Reservation::whereIn('status', ['confirmed', 'seated'])
            ->whereNotNull('table_number')
            ->whereDate('reservation_time', $this->selectedDate)
            ->get();
    }

    /**
     * Get all unassigned pending or confirmed reservations to assign.
     */
    public function getUnassignedReservationsProperty()
    {
        return Reservation::whereIn('status', ['pending', 'confirmed'])
            ->whereNull('table_number')
            ->orderBy('reservation_time', 'asc')
            ->get();
    }

    /**
     * Compile table data with reservations and dynamic statuses for rendering.
     */
    public function getSectionsData(): array
    {
        $assigned = $this->getAssignedReservationsProperty();
        $sections = $this->getPlanData();

        foreach ($sections as $sectionKey => &$section) {
            foreach ($section['tables'] as &$table) {
                $tableReservation = $assigned->firstWhere('table_number', $table['id']);
                
                if ($tableReservation) {
                    $table['status'] = $tableReservation->status === 'seated' ? 'occupied' : 'reserved';
                    $table['reservation'] = [
                        'id' => $tableReservation->id,
                        'guest_name' => $tableReservation->guest_name,
                        'guest_phone' => $tableReservation->guest_phone,
                        'guest_count' => $tableReservation->guest_count,
                        'time' => $tableReservation->reservation_time->format('h:i A'),
                    ];
                } else {
                    $table['status'] = 'vacant';
                    $table['reservation'] = null;
                }
            }
        }

        return $sections;
    }

    /**
     * Handle click event on a table.
     */
    public function handleTableClick(string $tableId): void
    {
        if ($this->isEditMode) {
            $this->openEditTableModal($tableId);
            return;
        }

        $this->selectedTableId = $tableId;

        // Check if table is already assigned on the selected date
        $reservation = Reservation::whereIn('status', ['confirmed', 'seated'])
            ->where('table_number', $tableId)
            ->whereDate('reservation_time', $this->selectedDate)
            ->first();

        if ($reservation) {
            $this->activeReservationData = [
                'id' => $reservation->id,
                'guest_name' => $reservation->guest_name,
                'guest_phone' => $reservation->guest_phone,
                'guest_email' => $reservation->guest_email,
                'guest_count' => $reservation->guest_count,
                'reservation_time' => $reservation->reservation_time->format('M d, Y \a\t h:i A'),
                'status' => $reservation->status,
                'special_requests' => $reservation->special_requests,
            ];
            $this->isDetailsModalOpen = true;
        } else {
            $this->selectedReservationId = null;
            $this->assignmentStatus = 'confirmed';
            $this->isAssignModalOpen = true;
        }
    }

    /**
     * Open Add Table Modal.
     */
    public function openAddTableModal(?string $sectionKey = 'main_dining'): void
    {
        $this->newTableSection = in_array($sectionKey, ['main_dining', 'family_room', 'outdoor_dera']) ? $sectionKey : 'main_dining';
        $this->newTableCapacity = 4;
        $this->newTableShape = 'square';
        
        // Suggest automatic next table number
        $plan = $this->getPlanData();
        $count = 0;
        foreach ($plan as $sec) {
            $count += count($sec['tables']);
        }
        $this->newTableName = 'Table ' . ($count + 1);

        $this->isAddTableModalOpen = true;
    }

    /**
     * Add a new table to the plan.
     */
    public function addTable(): void
    {
        $this->validate([
            'newTableName' => 'required|string|min:1|max:50',
            'newTableSection' => 'required|string',
            'newTableCapacity' => 'required|integer|min:1|max:30',
            'newTableShape' => 'required|string|in:square,round,banquet,charpai',
        ]);

        $plan = $this->getPlanData();
        $targetSection = $this->newTableSection;

        if (!isset($plan[$targetSection])) {
            $plan[$targetSection] = [
                'name' => ucwords(str_replace('_', ' ', $targetSection)),
                'tables' => [],
            ];
        }

        // Ensure unique ID
        $newId = trim($this->newTableName);
        foreach ($plan as $secKey => $sec) {
            foreach ($sec['tables'] as $tbl) {
                if (strtolower($tbl['id']) === strtolower($newId)) {
                    $this->addError('newTableName', 'A table with this name/number already exists in the floor plan.');
                    return;
                }
            }
        }

        $plan[$targetSection]['tables'][] = [
            'id' => $newId,
            'capacity' => (int)$this->newTableCapacity,
            'shape' => $this->newTableShape,
        ];

        $this->savePlanData($plan);

        \Filament\Notifications\Notification::make()
            ->title('Table Added to Floor Plan')
            ->body("Created {$newId} with capacity for {$this->newTableCapacity} guests.")
            ->success()
            ->send();

        $this->isAddTableModalOpen = false;
    }

    /**
     * Open Edit Table Modal for a specific table.
     */
    public function openEditTableModal(string $tableId): void
    {
        $plan = $this->getPlanData();

        foreach ($plan as $sectionKey => $section) {
            foreach ($section['tables'] as $table) {
                if ($table['id'] === $tableId) {
                    $this->editingTableId = $tableId;
                    $this->editTableName = $table['id'];
                    $this->editTableSection = $sectionKey;
                    $this->editTableCapacity = (int)($table['capacity'] ?? 4);
                    $this->editTableShape = $table['shape'] ?? 'square';
                    $this->isEditTableModalOpen = true;
                    return;
                }
            }
        }
    }

    /**
     * Save edited table details into the floor plan.
     */
    public function updateTable(): void
    {
        $this->validate([
            'editTableName' => 'required|string|min:1|max:50',
            'editTableSection' => 'required|string',
            'editTableCapacity' => 'required|integer|min:1|max:30',
            'editTableShape' => 'required|string|in:square,round,banquet,charpai',
        ]);

        $plan = $this->getPlanData();
        $oldId = $this->editingTableId;
        $newId = trim($this->editTableName);
        $newSection = $this->editTableSection;

        // Verify name collision if name changed
        if (strtolower($oldId) !== strtolower($newId)) {
            foreach ($plan as $secKey => $sec) {
                foreach ($sec['tables'] as $tbl) {
                    if (strtolower($tbl['id']) === strtolower($newId)) {
                        $this->addError('editTableName', 'A table with this name already exists.');
                        return;
                    }
                }
            }
        }

        // Find and remove old table entry
        $tableData = null;
        foreach ($plan as $secKey => &$sec) {
            foreach ($sec['tables'] as $idx => $tbl) {
                if ($tbl['id'] === $oldId) {
                    $tableData = $tbl;
                    unset($sec['tables'][$idx]);
                    $sec['tables'] = array_values($sec['tables']);
                    break 2;
                }
            }
        }

        // Insert into target section with updated fields
        if (!isset($plan[$newSection])) {
            $plan[$newSection] = [
                'name' => ucwords(str_replace('_', ' ', $newSection)),
                'tables' => [],
            ];
        }

        $plan[$newSection]['tables'][] = [
            'id' => $newId,
            'capacity' => (int)$this->editTableCapacity,
            'shape' => $this->editTableShape,
        ];

        $this->savePlanData($plan);

        // Also update any active reservation assigned to this table if name was changed
        if ($oldId !== $newId) {
            Reservation::where('table_number', $oldId)->update(['table_number' => $newId]);
        }

        \Filament\Notifications\Notification::make()
            ->title('Floor Plan Updated')
            ->body("Updated {$newId} ({$this->editTableCapacity} seats) in {$plan[$newSection]['name']}.")
            ->success()
            ->send();

        $this->isEditTableModalOpen = false;
    }

    /**
     * Delete a table from the floor plan.
     */
    public function deleteTable(string $tableId): void
    {
        $plan = $this->getPlanData();
        $deleted = false;

        foreach ($plan as $secKey => &$sec) {
            foreach ($sec['tables'] as $idx => $tbl) {
                if ($tbl['id'] === $tableId) {
                    unset($sec['tables'][$idx]);
                    $sec['tables'] = array_values($sec['tables']);
                    $deleted = true;
                    break 2;
                }
            }
        }

        if ($deleted) {
            $this->savePlanData($plan);

            // Release any reservation assigned to this table
            Reservation::where('table_number', $tableId)->update(['table_number' => null, 'status' => 'pending']);

            \Filament\Notifications\Notification::make()
                ->title('Table Removed')
                ->body("Deleted {$tableId} from the floor plan.")
                ->warning()
                ->send();
        }

        $this->resetModalState();
    }

    /**
     * Reset floor plan to standard factory blueprint.
     */
    public function resetToDefaultPlan(): void
    {
        $this->savePlanData(self::SECTIONS);

        \Filament\Notifications\Notification::make()
            ->title('Floor Plan Reset')
            ->body('Restored factory default blueprint (18 tables across 3 sections).')
            ->info()
            ->send();

        $this->resetModalState();
    }

    /**
     * Assign a reservation to the selected table.
     */
    public function assignReservation(): void
    {
        $this->validate([
            'selectedReservationId' => 'required|exists:reservations,id',
            'assignmentStatus' => 'required|in:confirmed,seated',
        ], [
            'selectedReservationId.required' => 'Please select a reservation to assign.',
        ]);

        $reservation = Reservation::find($this->selectedReservationId);
        if ($reservation) {
            $reservation->update([
                'table_number' => $this->selectedTableId,
                'status' => $this->assignmentStatus,
            ]);

            \Filament\Notifications\Notification::make()
                ->title('Table Assigned Successfully')
                ->body("Assigned {$reservation->guest_name} to {$this->selectedTableId}.")
                ->success()
                ->send();
        }

        $this->resetModalState();
    }

    /**
     * Mark an existing reservation as seated (occupied).
     */
    public function markAsSeated(int $reservationId): void
    {
        $reservation = Reservation::find($reservationId);
        if ($reservation) {
            $reservation->update(['status' => 'seated']);

            \Filament\Notifications\Notification::make()
                ->title('Guests Seated')
                ->body("{$reservation->guest_name} is now seated at {$reservation->table_number}.")
                ->success()
                ->send();
        }

        $this->resetModalState();
    }

    /**
     * Clear seating assignment for a reservation (releases table back to vacant).
     */
    public function clearAssignment(int $reservationId): void
    {
        $reservation = Reservation::find($reservationId);
        if ($reservation) {
            $guestName = $reservation->guest_name;
            $tableNum = $reservation->table_number;
            
            $reservation->update([
                'table_number' => null,
                'status' => 'pending',
            ]);

            \Filament\Notifications\Notification::make()
                ->title('Table Released')
                ->body("Released {$tableNum}. Reservation for {$guestName} was moved to pending.")
                ->info()
                ->send();
        }

        $this->resetModalState();
    }

    /**
     * Cancel reservation completely and release table.
     */
    public function cancelReservation(int $reservationId): void
    {
        $reservation = Reservation::find($reservationId);
        if ($reservation) {
            $guestName = $reservation->guest_name;
            $reservation->update([
                'status' => 'cancelled',
                'table_number' => null,
            ]);

            \Filament\Notifications\Notification::make()
                ->title('Reservation Cancelled')
                ->body("Reservation for {$guestName} has been cancelled.")
                ->danger()
                ->send();
        }

        $this->resetModalState();
    }

    /**
     * Reset modal states.
     */
    public function resetModalState(): void
    {
        $this->isAssignModalOpen = false;
        $this->isDetailsModalOpen = false;
        $this->isEditTableModalOpen = false;
        $this->isAddTableModalOpen = false;
        $this->selectedTableId = null;
        $this->selectedReservationId = null;
        $this->activeReservationData = [];
    }
}
