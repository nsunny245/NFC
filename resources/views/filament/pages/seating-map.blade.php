<x-filament-panels::page>
    <style>
        /* =========================================================================
         * NAWABI FOOD CORNER - ROYAL SEATING & FLOOR ARCHITECTURE STYLING
         * Scoped CSS Architecture: 100% resilient across Light and Dark modes
         * ========================================================================= */

        .nfc-seating-container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            width: 100%;
            font-family: inherit;
        }

        /* 1. Header Command Bar */
        .nfc-floor-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #261e0f 100%);
            border: 1.5px solid rgba(212, 164, 55, 0.45);
            border-radius: 1.5rem;
            padding: 1.25rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.25rem;
            box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.25);
            color: #ffffff !important;
        }

        /* Legend Badges */
        .nfc-legend-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .nfc-legend-vacant {
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid rgba(16, 185, 129, 0.45);
            color: #6ee7b7 !important;
        }

        .nfc-legend-reserved {
            background: rgba(245, 158, 11, 0.18);
            border: 1px solid rgba(245, 158, 11, 0.45);
            color: #fde68a !important;
        }

        .nfc-legend-occupied {
            background: rgba(239, 68, 68, 0.18);
            border: 1px solid rgba(239, 68, 68, 0.45);
            color: #fca5a5 !important;
        }

        /* Section Block */
        .nfc-section-block {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nfc-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1.25rem;
            border-radius: 1.15rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
        }

        .dark .nfc-section-header {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .nfc-sec-gold { border-left: 5px solid #d4a437; }
        .nfc-sec-purple { border-left: 5px solid #8b5cf6; }
        .nfc-sec-emerald { border-left: 5px solid #10b981; }

        /* Tables Grid */
        .nfc-tables-grid {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
            gap: 1rem !important;
            width: 100% !important;
        }

        /* Table Card Architecture */
        .nfc-table-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.15rem 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 0.85rem;
            box-shadow: 0 3px 12px -2px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .dark .nfc-table-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 16px -2px rgba(0, 0, 0, 0.35);
        }

        .nfc-table-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -4px rgba(0, 0, 0, 0.12);
        }

        .dark .nfc-table-card:hover {
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.45);
        }

        /* Status Ring Accents */
        .nfc-table-card.status-vacant {
            border-top: 4px solid #10b981;
        }
        .nfc-table-card.status-reserved {
            border-top: 4px solid #f59e0b;
        }
        .nfc-table-card.status-occupied {
            border-top: 4px solid #ef4444;
        }

        /* Card Elements */
        .nfc-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .nfc-table-id {
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .dark .nfc-table-id {
            color: #f8fafc;
        }

        .nfc-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .badge-vacant {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .dark .badge-vacant {
            background: rgba(22, 101, 52, 0.35);
            color: #86efac;
            border-color: rgba(34, 197, 94, 0.4);
        }

        .badge-reserved {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .dark .badge-reserved {
            background: rgba(180, 83, 9, 0.35);
            color: #fde047;
            border-color: rgba(245, 158, 11, 0.4);
        }

        .badge-occupied {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
        }
        .dark .badge-occupied {
            background: rgba(185, 28, 28, 0.35);
            color: #fca5a5;
            border-color: rgba(239, 68, 68, 0.4);
        }

        .nfc-card-body {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .nfc-capacity-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.725rem;
            font-weight: 800;
            color: #475569;
        }

        .dark .nfc-capacity-tag {
            color: #94a3b8;
        }

        .nfc-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.65rem;
            border-top: 1px solid #f1f5f9;
            font-size: 0.725rem;
        }

        .dark .nfc-card-footer {
            border-top-color: #334155;
        }

        /* Buttons */
        .nfc-btn-action {
            padding: 4px 10px;
            border-radius: 0.65rem;
            font-size: 0.675rem;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .nfc-btn-seat {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
        }

        .nfc-btn-edit {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35);
        }

        .nfc-btn-delete {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.35);
        }

        /* Modals */
        .nfc-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(6px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .nfc-modal-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            width: 100%;
            max-width: 520px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .dark .nfc-modal-box {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .nfc-modal-header {
            padding: 1.25rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dark .nfc-modal-header {
            background: #0f172a;
            border-bottom-color: #334155;
        }

        .nfc-modal-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nfc-modal-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .dark .nfc-modal-footer {
            background: #0f172a;
            border-top-color: #334155;
        }

        .nfc-input {
            width: 100%;
            border-radius: 0.75rem;
            border: 1.5px solid #cbd5e1;
            padding: 0.65rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
            background: #ffffff;
        }

        .dark .nfc-input {
            background: #0f172a;
            border-color: #475569;
            color: #f8fafc;
        }
    </style>

    <div class="nfc-seating-container">

        <!-- Top Command Bar: Layout Manager & Live Shift Date -->
        <div class="nfc-floor-header">
            <!-- Brand & Info -->
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 3.25rem; height: 3.25rem; border-radius: 9999px; border: 2px solid #d4a437; background: #ffffff; padding: 1px; overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 10px rgba(212, 164, 55, 0.4); flex-shrink: 0;">
                    <img src="{{ asset('images/logo_circular.png') }}" alt="NFC Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 9999px;">
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.2rem; font-weight: 900; letter-spacing: -0.02em; color: #ffffff;">
                            Floor Layout Architecture
                        </span>
                        <span style="padding: 2px 8px; border-radius: 9999px; background: rgba(212, 164, 55, 0.2); border: 1px solid rgba(212, 164, 55, 0.4); color: #fef08a; font-size: 0.65rem; font-weight: 900; text-transform: uppercase;">
                            {{ $isEditMode ? 'Plan Editor Mode' : 'Live Seating Engine' }}
                        </span>
                    </div>
                    <div style="font-size: 0.725rem; color: #cbd5e1; margin-top: 0.2rem;">
                        Real-time interactive table status indicator, reservation assignments, and custom floor plan management.
                    </div>
                </div>
            </div>

            <!-- Date Selector & Legend -->
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <!-- Date Selector -->
                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.85rem; padding: 4px 10px;">
                    <label for="shift-date-input" style="font-size: 0.7rem; font-weight: 800; color: #fef08a; text-transform: uppercase;">Shift Date:</label>
                    <input id="shift-date-input" type="date" wire:model.live="selectedDate"
                           style="background: transparent; border: none; color: #ffffff; font-size: 0.8rem; font-weight: 800; outline: none; cursor: pointer;">
                    <button type="button" wire:click="$set('selectedDate', '{{ date('Y-m-d') }}')"
                            style="padding: 2px 7px; border-radius: 6px; background: rgba(212, 164, 55, 0.25); border: 1px solid rgba(212, 164, 55, 0.4); color: #fef08a; font-size: 0.65rem; font-weight: 900; cursor: pointer;"
                            title="Reset to today">
                        Today
                    </button>
                </div>

                <!-- Legend Indicators -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <span class="nfc-legend-pill nfc-legend-vacant">
                        <span style="width: 7px; height: 7px; border-radius: 9999px; background: #10b981; box-shadow: 0 0 6px #10b981;"></span>
                        <span>Vacant</span>
                    </span>
                    <span class="nfc-legend-pill nfc-legend-reserved">
                        <span style="width: 7px; height: 7px; border-radius: 9999px; background: #f59e0b; box-shadow: 0 0 6px #f59e0b;"></span>
                        <span>Reserved</span>
                    </span>
                    <span class="nfc-legend-pill nfc-legend-occupied">
                        <span style="width: 7px; height: 7px; border-radius: 9999px; background: #ef4444; box-shadow: 0 0 6px #ef4444;"></span>
                        <span>Seated</span>
                    </span>
                </div>

                <!-- Plan Editor Toggle Button -->
                <div style="display: flex; align-items: center; gap: 0.4rem;">
                    <button type="button" wire:click="toggleEditMode"
                            style="padding: 6px 14px; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s ease; {{ $isEditMode ? 'background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; box-shadow: 0 2px 10px rgba(245, 158, 11, 0.4);' : 'background: rgba(255, 255, 255, 0.12); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.25);' }}"
                            title="Toggle between Live Operations and Floor Plan Customization mode">
                        <span>{{ $isEditMode ? '👁️ Done Editing' : '✏️ Edit Floor Plan' }}</span>
                    </button>

                    <!-- Add Table Button -->
                    <button type="button" wire:click="openAddTableModal('main_dining')"
                            style="padding: 6px 14px; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; border: none; cursor: pointer; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; box-shadow: 0 2px 10px rgba(16, 185, 129, 0.4); display: inline-flex; align-items: center; gap: 0.35rem;"
                            title="Add a new table to the floor plan">
                        <span>➕ Add Table</span>
                    </button>

                    @if($isEditMode)
                        <button type="button" wire:click="resetToDefaultPlan"
                                onclick="return confirm('Restore factory default 18-table floor plan?')"
                                style="padding: 6px 12px; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; border: 1px solid rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.2); color: #fca5a5; cursor: pointer;"
                                title="Reset to original Nawabi Dera blueprint">
                            🔄 Reset
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sections & Tables Workflow -->
        @php
            $sectionsData = $this->getSectionsData();
        @endphp

        @foreach($sectionsData as $sectionKey => $section)
            @php
                $tableCount = count($section['tables']);
                $totalCapacity = array_sum(array_column($section['tables'], 'capacity'));
                $vacantCount = count(array_filter($section['tables'], fn($t) => $t['status'] === 'vacant'));
                $occupiedCount = count(array_filter($section['tables'], fn($t) => $t['status'] === 'occupied'));
                $reservedCount = count(array_filter($section['tables'], fn($t) => $t['status'] === 'reserved'));

                $secBorderClass = $sectionKey === 'main_dining' ? 'nfc-sec-gold' : ($sectionKey === 'family_room' ? 'nfc-sec-purple' : 'nfc-sec-emerald');
                $secIcon = $sectionKey === 'main_dining' ? '🍽️' : ($sectionKey === 'family_room' ? '👨‍👩‍👧' : '🏕️');
            @endphp

            <div class="nfc-section-block">
                <!-- Section Header Bar -->
                <div class="nfc-section-header {{ $secBorderClass }}">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span style="font-size: 1.35rem;">{{ $secIcon }}</span>
                        <div>
                            <div style="font-size: 1.05rem; font-weight: 900; letter-spacing: -0.02em;" class="text-slate-900 dark:text-white">
                                {{ $section['name'] }}
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.1rem;" class="dark:text-slate-400">
                                {{ $tableCount }} Tables • {{ $totalCapacity }} Total Seats
                                &nbsp;•&nbsp;
                                <span style="color: #10b981; font-weight: 800;">{{ $vacantCount }} Vacant</span>,
                                <span style="color: #f59e0b; font-weight: 800;">{{ $reservedCount }} Reserved</span>,
                                <span style="color: #ef4444; font-weight: 800;">{{ $occupiedCount }} Seated</span>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        @if($isEditMode)
                            <button type="button" wire:click="openAddTableModal('{{ $sectionKey }}')"
                                    style="padding: 4px 10px; border-radius: 0.65rem; font-size: 0.7rem; font-weight: 800; background: rgba(212, 164, 55, 0.15); border: 1px solid rgba(212, 164, 55, 0.4); color: #d97706; cursor: pointer;"
                                    title="Add table directly into this section">
                                ➕ Add Table Here
                            </button>
                        @endif

                        <span style="padding: 3px 9px; border-radius: 9999px; background: #e2e8f0; color: #475569; font-size: 0.675rem; font-weight: 900;" class="dark:bg-slate-800 dark:text-slate-300">
                            {{ $tableCount }} Tables
                        </span>
                    </div>
                </div>

                <!-- Tables Grid -->
                <div class="nfc-tables-grid">
                    @forelse($section['tables'] as $table)
                        @php
                            $status = $table['status'];
                            $isVacant = $status === 'vacant';
                            $isReserved = $status === 'reserved';
                            $isOccupied = $status === 'occupied';

                            $cardClass = 'status-' . $status;
                            $badgeClass = 'badge-' . $status;
                            $badgeLabel = $isVacant ? '🟢 Vacant' : ($isReserved ? '🟡 Reserved' : '🔴 Seated');

                            $shape = $table['shape'] ?? 'square';
                            $shapeIcon = $shape === 'round' ? '⭕' : ($shape === 'banquet' ? '🛋️' : ($shape === 'charpai' ? '🛏️' : '🔲'));
                        @endphp

                        <div class="nfc-table-card {{ $cardClass }}"
                             wire:click="handleTableClick('{{ $table['id'] }}')">
                            
                            <!-- Card Top: Table Number & Status Badge -->
                            <div class="nfc-card-top">
                                <div class="nfc-table-id">
                                    <span>{{ $shapeIcon }}</span>
                                    <span>{{ $table['id'] }}</span>
                                </div>
                                <span class="nfc-status-badge {{ $badgeClass }}">
                                    {{ $badgeLabel }}
                                </span>
                            </div>

                            <!-- Card Body: Capacity & Guest Info -->
                            <div class="nfc-card-body">
                                <div class="nfc-capacity-tag">
                                    <span>👥 Capacity: <b>{{ $table['capacity'] }} Guests</b></span>
                                    <span>•</span>
                                    <span style="text-transform: capitalize;">{{ $shape }}</span>
                                </div>

                                @if($isReserved && $table['reservation'])
                                    <div style="padding: 6px 10px; border-radius: 0.65rem; background: #fef3c7; border: 1px solid #fde68a; font-size: 0.725rem;" class="dark:bg-amber-950/40 dark:border-amber-800">
                                        <div style="font-weight: 900; color: #b45309;" class="dark:text-amber-300">
                                            👤 {{ $table['reservation']['guest_name'] }}
                                        </div>
                                        <div style="color: #78350f; font-size: 0.675rem; margin-top: 0.15rem;" class="dark:text-amber-200">
                                            ⏰ Time: <b>{{ $table['reservation']['time'] }}</b> ({{ $table['reservation']['guest_count'] }} Guests)
                                        </div>
                                    </div>
                                @elseif($isOccupied && $table['reservation'])
                                    <div style="padding: 6px 10px; border-radius: 0.65rem; background: #fee2e2; border: 1px solid #fca5a5; font-size: 0.725rem;" class="dark:bg-rose-950/40 dark:border-rose-800">
                                        <div style="font-weight: 900; color: #b91c1c;" class="dark:text-rose-300">
                                            🍽️ {{ $table['reservation']['guest_name'] }}
                                        </div>
                                        <div style="color: #7f1d1d; font-size: 0.675rem; margin-top: 0.15rem;" class="dark:text-rose-200">
                                            Dining Active • {{ $table['reservation']['guest_count'] }} Guests Seated
                                        </div>
                                    </div>
                                @else
                                    <div style="font-size: 0.725rem; color: #10b981; font-weight: 700;">
                                        ✓ Available for immediate walk-in
                                    </div>
                                @endif
                            </div>

                            <!-- Card Footer: Quick Actions or Plan Editor Controls -->
                            <div class="nfc-card-footer">
                                @if($isEditMode)
                                    <!-- Plan Editor Controls -->
                                    <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                                        <button type="button"
                                                wire:click.stop="openEditTableModal('{{ $table['id'] }}')"
                                                class="nfc-btn-action nfc-btn-edit">
                                            ✏️ Edit Table
                                        </button>
                                        <button type="button"
                                                wire:click.stop="deleteTable('{{ $table['id'] }}')"
                                                onclick="return confirm('Remove {{ $table['id'] }} from floor plan?')"
                                                class="nfc-btn-action nfc-btn-delete">
                                            🗑️ Remove
                                        </button>
                                    </div>
                                @else
                                    <!-- Operations Mode Actions -->
                                    @if($isVacant)
                                        <span style="color: #64748b; font-size: 0.7rem;">Click to Assign</span>
                                        <button type="button"
                                                wire:click.stop="handleTableClick('{{ $table['id'] }}')"
                                                class="nfc-btn-action nfc-btn-seat">
                                            ➕ Seat Guests
                                        </button>
                                    @elseif($isReserved)
                                        <button type="button"
                                                wire:click.stop="markAsSeated({{ $table['reservation']['id'] }})"
                                                class="nfc-btn-action nfc-btn-seat">
                                            🍽️ Mark Seated
                                        </button>
                                        <button type="button"
                                                wire:click.stop="clearAssignment({{ $table['reservation']['id'] }})"
                                                style="background: #e2e8f0; color: #334155;" class="nfc-btn-action dark:bg-slate-700 dark:text-slate-200">
                                            Release
                                        </button>
                                    @else
                                        <span style="color: #ef4444; font-weight: 800;">Dining Active</span>
                                        <button type="button"
                                                wire:click.stop="clearAssignment({{ $table['reservation']['id'] }})"
                                                style="background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;" class="nfc-btn-action dark:bg-rose-950/60 dark:text-rose-300">
                                            Clear Table
                                        </button>
                                    @endif
                                @endif
                            </div>

                        </div>
                    @empty
                        <div style="grid-column: 1 / -1; padding: 2rem; text-align: center; border: 2px dashed #cbd5e1; border-radius: 1rem; color: #64748b;" class="dark:border-slate-700 dark:text-slate-400">
                            No tables in this section. Click <b>➕ Add Table Here</b> to place a table.
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach

        <!-- ================================================================= -->
        <!-- UNASSIGNED PENDING BOOKINGS QUEUE (WAITING LIST) -->
        <!-- ================================================================= -->
        @php
            $pendingBookings = $this->unassignedReservations;
        @endphp
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 1.5rem; padding: 1.5rem; box-shadow: 0 4px 16px -2px rgba(0,0,0,0.05);" class="dark:!bg-slate-800 dark:!border-slate-700">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.75rem;" class="dark:border-slate-700">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-size: 1.35rem;">📋</span>
                    <div>
                        <div style="font-size: 1rem; font-weight: 900;" class="text-slate-900 dark:text-white">
                            Pending Bookings Awaiting Table Assignment ({{ $pendingBookings->count() }})
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b;" class="dark:text-slate-400">
                            Active reservations on shift without assigned table numbers. Click any vacant table above to seat them.
                        </div>
                    </div>
                </div>
                <a href="{{ url('/admin/reservations') }}" style="font-size: 0.75rem; font-weight: 800; color: #d97706; text-decoration: none;" class="hover:underline">
                    Manage All Bookings in Back Office →
                </a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 0.75rem;">
                @forelse($pendingBookings as $pBooking)
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; padding: 0.85rem 1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;" class="dark:!bg-slate-900 dark:!border-slate-700">
                        <div>
                            <div style="font-weight: 900; font-size: 0.85rem;" class="text-slate-900 dark:text-white">
                                👤 {{ $pBooking->guest_name }}
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.15rem;" class="dark:text-slate-400">
                                ⏰ <b>{{ $pBooking->reservation_time->format('h:i A') }}</b> • 👥 {{ $pBooking->guest_count }} Guests • {{ $pBooking->guest_phone }}
                            </div>
                        </div>
                        <span style="padding: 3px 8px; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.35); color: #d97706; font-size: 0.65rem; font-weight: 900; text-transform: uppercase;">
                            Pending
                        </span>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; padding: 1.25rem; text-align: center; color: #64748b; font-size: 0.75rem;">
                        ✓ No unassigned pending bookings for today. All booked guests have been placed or no pending requests.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL 1: ASSIGN RESERVATION TO TABLE -->
        <!-- ================================================================= -->
        @if($isAssignModalOpen)
            <div class="nfc-modal-backdrop" wire:click.self="resetModalState">
                <div class="nfc-modal-box">
                    <div class="nfc-modal-header">
                        <div style="font-weight: 900; font-size: 1.05rem;" class="text-slate-900 dark:text-white">
                            🪑 Seat or Assign Table: <span style="color: #d4a437;">{{ $selectedTableId }}</span>
                        </div>
                        <button type="button" wire:click="resetModalState" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>

                    <form wire:submit.prevent="assignReservation">
                        <div class="nfc-modal-body">
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                    Select Pending Booking:
                                </label>
                                @php
                                    $unassigned = $this->unassignedReservations;
                                @endphp
                                @if($unassigned->count() > 0)
                                    <select wire:model="selectedReservationId" class="nfc-input" required>
                                        <option value="">-- Choose Reservation --</option>
                                        @foreach($unassigned as $res)
                                            <option value="{{ $res->id }}">
                                                {{ $res->guest_name }} ({{ $res->guest_count }} Guests) • {{ $res->reservation_time->format('h:i A') }} • {{ $res->guest_phone }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <div style="padding: 1rem; border-radius: 0.75rem; background: #fef3c7; border: 1px solid #fde68a; font-size: 0.775rem; color: #b45309;">
                                        No unassigned pending bookings for today. You can create a new booking in <a href="{{ url('/admin/reservations') }}" style="text-decoration: underline; font-weight: 800;">Reservations</a>.
                                    </div>
                                @endif
                                @error('selectedReservationId') <span style="color: #ef4444; font-size: 0.7rem; font-weight: 700;">{{ $message }}</span> @enderror
                            </div>

                            @if($unassigned->count() > 0)
                                <div>
                                    <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                        Status on Assignment:
                                    </label>
                                    <select wire:model="assignmentStatus" class="nfc-input">
                                        <option value="confirmed">🟡 Confirmed (Table Reserved)</option>
                                        <option value="seated">🔴 Seated (Guests Currently Dining)</option>
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="nfc-modal-footer">
                            <button type="button" wire:click="resetModalState" style="padding: 0.55rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; background: #e2e8f0; border: none; cursor: pointer;" class="dark:bg-slate-700 dark:text-slate-200">
                                Cancel
                            </button>
                            @if($unassigned->count() > 0)
                                <button type="submit" style="padding: 0.55rem 1.25rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">
                                    Confirm Assignment
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- ================================================================= -->
        <!-- MODAL 2: TABLE DETAILS & ACTIVE BOOKING ACTIONS -->
        <!-- ================================================================= -->
        @if($isDetailsModalOpen)
            <div class="nfc-modal-backdrop" wire:click.self="resetModalState">
                <div class="nfc-modal-box">
                    <div class="nfc-modal-header">
                        <div style="font-weight: 900; font-size: 1.05rem;" class="text-slate-900 dark:text-white">
                            Table Details: <span style="color: #d4a437;">{{ $selectedTableId }}</span>
                        </div>
                        <button type="button" wire:click="resetModalState" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>

                    <div class="nfc-modal-body">
                        @if(!empty($activeReservationData))
                            <div style="display: flex; flex-direction: column; gap: 0.65rem;">
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.4rem;">
                                    <span style="color: #64748b; font-size: 0.75rem;">Guest Name:</span>
                                    <span style="font-weight: 800; font-size: 0.85rem;" class="text-slate-900 dark:text-white">{{ $activeReservationData['guest_name'] }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.4rem;">
                                    <span style="color: #64748b; font-size: 0.75rem;">Contact:</span>
                                    <span style="font-weight: 700; font-size: 0.8rem;">{{ $activeReservationData['guest_phone'] }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.4rem;">
                                    <span style="color: #64748b; font-size: 0.75rem;">Party Size:</span>
                                    <span style="font-weight: 800; color: #d97706;">👥 {{ $activeReservationData['guest_count'] }} Guests</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.4rem;">
                                    <span style="color: #64748b; font-size: 0.75rem;">Booking Schedule:</span>
                                    <span style="font-weight: 700; font-size: 0.75rem;">{{ $activeReservationData['reservation_time'] }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 0.4rem;">
                                    <span style="color: #64748b; font-size: 0.75rem;">Current Status:</span>
                                    <span style="font-weight: 900; text-transform: uppercase; font-size: 0.75rem; {{ $activeReservationData['status'] === 'seated' ? 'color: #ef4444;' : 'color: #f59e0b;' }}">
                                        {{ $activeReservationData['status'] }}
                                    </span>
                                </div>
                                @if(!empty($activeReservationData['special_requests']))
                                    <div style="padding: 0.65rem; border-radius: 0.65rem; background: #f8fafc; border: 1px solid #e2e8f0; font-size: 0.725rem;" class="dark:bg-slate-800 dark:border-slate-700">
                                        <b>Special Requests:</b> {{ $activeReservationData['special_requests'] }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="nfc-modal-footer">
                        @if($activeReservationData['status'] !== 'seated')
                            <button type="button" wire:click="markAsSeated({{ $activeReservationData['id'] }})"
                                    style="padding: 0.55rem 1.15rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">
                                🍽️ Mark Seated
                            </button>
                        @endif

                        <button type="button" wire:click="clearAssignment({{ $activeReservationData['id'] }})"
                                style="padding: 0.55rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; background: #f8fafc; border: 1.5px solid #cbd5e1; color: #334155; cursor: pointer;" class="dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700">
                            Release Table
                        </button>

                        <button type="button" wire:click="cancelReservation({{ $activeReservationData['id'] }})"
                                onclick="return confirm('Cancel this reservation completely?')"
                                style="padding: 0.55rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; cursor: pointer;">
                            Cancel Booking
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- ================================================================= -->
        <!-- MODAL 3: EDIT TABLE IN FLOOR PLAN -->
        <!-- ================================================================= -->
        @if($isEditTableModalOpen)
            <div class="nfc-modal-backdrop" wire:click.self="resetModalState">
                <div class="nfc-modal-box">
                    <div class="nfc-modal-header">
                        <div style="font-weight: 900; font-size: 1.05rem;" class="text-slate-900 dark:text-white">
                            ✏️ Edit Table Configuration: <span style="color: #d4a437;">{{ $editingTableId }}</span>
                        </div>
                        <button type="button" wire:click="resetModalState" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>

                    <form wire:submit.prevent="updateTable">
                        <div class="nfc-modal-body">
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                    Table Number / Name:
                                </label>
                                <input type="text" wire:model="editTableName" class="nfc-input" required>
                                @error('editTableName') <span style="color: #ef4444; font-size: 0.7rem; font-weight: 700;">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                    Floor Section:
                                </label>
                                <select wire:model="editTableSection" class="nfc-input">
                                    <option value="main_dining">🍽️ Main Dining Hall</option>
                                    <option value="family_room">👨‍👩‍👧 Family Room & Suites</option>
                                    <option value="outdoor_dera">🏕️ Outdoor Punjabi Dera</option>
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                        Seating Capacity:
                                    </label>
                                    <input type="number" min="1" max="30" wire:model="editTableCapacity" class="nfc-input" required>
                                </div>

                                <div>
                                    <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                        Table Shape / Style:
                                    </label>
                                    <select wire:model="editTableShape" class="nfc-input">
                                        <option value="square">🔲 Square / Booth (4-top)</option>
                                        <option value="round">⭕ Round Table (2-4 seats)</option>
                                        <option value="banquet">🛋️ Long Banquet (6-12 seats)</option>
                                        <option value="charpai">🛏️ Punjabi Charpai (Dera)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="nfc-modal-footer">
                            <button type="button" wire:click="resetModalState" style="padding: 0.55rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; background: #e2e8f0; border: none; cursor: pointer;" class="dark:bg-slate-700 dark:text-slate-200">
                                Cancel
                            </button>
                            <button type="submit" style="padding: 0.55rem 1.25rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.4);">
                                Save Table Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- ================================================================= -->
        <!-- MODAL 4: ADD NEW TABLE TO FLOOR PLAN -->
        <!-- ================================================================= -->
        @if($isAddTableModalOpen)
            <div class="nfc-modal-backdrop" wire:click.self="resetModalState">
                <div class="nfc-modal-box">
                    <div class="nfc-modal-header">
                        <div style="font-weight: 900; font-size: 1.05rem;" class="text-slate-900 dark:text-white">
                            ➕ Add New Table to Floor Plan
                        </div>
                        <button type="button" wire:click="resetModalState" style="background: none; border: none; font-size: 1.25rem; cursor: pointer;" class="text-slate-400 hover:text-slate-600">✕</button>
                    </div>

                    <form wire:submit.prevent="addTable">
                        <div class="nfc-modal-body">
                            <div>
                                <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                    Table Number / Identifier:
                                </label>
                                <input type="text" wire:model="newTableName" placeholder="e.g. Table 11, VIP Dera 5" class="nfc-input" required>
                                @error('newTableName') <span style="color: #ef4444; font-size: 0.7rem; font-weight: 700;">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                    Target Floor Section:
                                </label>
                                <select wire:model="newTableSection" class="nfc-input">
                                    <option value="main_dining">🍽️ Main Dining Hall</option>
                                    <option value="family_room">👨‍👩‍👧 Family Room & Suites</option>
                                    <option value="outdoor_dera">🏕️ Outdoor Punjabi Dera</option>
                                </select>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                        Seating Capacity:
                                    </label>
                                    <input type="number" min="1" max="30" wire:model="newTableCapacity" class="nfc-input" required>
                                </div>

                                <div>
                                    <label style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: #64748b; display: block; margin-bottom: 0.35rem;">
                                        Table Shape / Style:
                                    </label>
                                    <select wire:model="newTableShape" class="nfc-input">
                                        <option value="square">🔲 Square / Booth (4-top)</option>
                                        <option value="round">⭕ Round Table (2-4 seats)</option>
                                        <option value="banquet">🛋️ Long Banquet (6-12 seats)</option>
                                        <option value="charpai">🛏️ Punjabi Charpai (Dera)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="nfc-modal-footer">
                            <button type="button" wire:click="resetModalState" style="padding: 0.55rem 1rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 800; background: #e2e8f0; border: none; cursor: pointer;" class="dark:bg-slate-700 dark:text-slate-200">
                                Cancel
                            </button>
                            <button type="submit" style="padding: 0.55rem 1.25rem; border-radius: 0.75rem; font-size: 0.75rem; font-weight: 900; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">
                                ➕ Add Table
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
