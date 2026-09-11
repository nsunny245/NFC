<?php

namespace Tests\Feature;

use App\Filament\Pages\SeatingMap;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeatingMapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_the_seating_map_page()
    {
        $user = User::factory()->create(['role' => 'admin', 'is_active' => true]);

        $this->actingAs($user, 'admin');

        $this->get('/admin/seating-map')
            ->assertStatus(200);
    }

    /** @test */
    public function it_correctly_calculates_table_statuses_based_on_reservations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today();

        // Create a seated reservation assigned to "Table 1" for today
        $seated = Reservation::create([
            'guest_name' => 'Seated Guest',
            'guest_phone' => '03118484987',
            'guest_count' => 4,
            'reservation_time' => $today->copy()->setTime(19, 30),
            'table_number' => 'Table 1',
            'status' => 'seated',
        ]);

        // Create a confirmed reservation assigned to "Table 2" for today
        $confirmed = Reservation::create([
            'guest_name' => 'Confirmed Guest',
            'guest_phone' => '03118484988',
            'guest_count' => 6,
            'reservation_time' => $today->copy()->setTime(20, 00),
            'table_number' => 'Table 2',
            'status' => 'confirmed',
        ]);

        // Create a pending reservation with no table number
        $pending = Reservation::create([
            'guest_name' => 'Pending Guest',
            'guest_phone' => '03118484989',
            'guest_count' => 2,
            'reservation_time' => $today->copy()->setTime(18, 00),
            'table_number' => null,
            'status' => 'pending',
        ]);

        Livewire::test(SeatingMap::class)
            ->assertSet('selectedDate', Carbon::today()->format('Y-m-d'))
            ->assertSee('Table 1')
            ->assertSee('Table 2')
            ->assertSee('Seated Guest')
            ->assertSee('Confirmed Guest')
            ->assertSee('Pending Guest');
    }

    /** @test */
    public function it_can_assign_a_pending_reservation_to_a_table()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today();

        $pending = Reservation::create([
            'guest_name' => 'Pending Guest',
            'guest_phone' => '03118484989',
            'guest_count' => 4,
            'reservation_time' => $today->copy()->setTime(18, 00),
            'table_number' => null,
            'status' => 'pending',
        ]);

        Livewire::test(SeatingMap::class)
            ->call('handleTableClick', 'Table 3')
            ->assertSet('selectedTableId', 'Table 3')
            ->assertSet('isAssignModalOpen', true)
            ->set('selectedReservationId', $pending->id)
            ->set('assignmentStatus', 'seated')
            ->call('assignReservation')
            ->assertSet('isAssignModalOpen', false)
            ->assertSet('selectedTableId', null);

        $this->assertDatabaseHas('reservations', [
            'id' => $pending->id,
            'table_number' => 'Table 3',
            'status' => 'seated',
        ]);
    }

    /** @test */
    public function it_can_mark_a_confirmed_reservation_as_seated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today();

        $reservation = Reservation::create([
            'guest_name' => 'Confirmed Guest',
            'guest_phone' => '03118484989',
            'guest_count' => 4,
            'reservation_time' => $today->copy()->setTime(18, 00),
            'table_number' => 'Table 4',
            'status' => 'confirmed',
        ]);

        Livewire::test(SeatingMap::class)
            ->call('handleTableClick', 'Table 4')
            ->assertSet('selectedTableId', 'Table 4')
            ->assertSet('isDetailsModalOpen', true)
            ->call('markAsSeated', $reservation->id)
            ->assertSet('isDetailsModalOpen', false);

        $this->assertEquals('seated', $reservation->fresh()->status);
    }

    /** @test */
    public function it_can_release_a_table_assignment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today();

        $reservation = Reservation::create([
            'guest_name' => 'Seated Guest',
            'guest_phone' => '03118484989',
            'guest_count' => 4,
            'reservation_time' => $today->copy()->setTime(18, 00),
            'table_number' => 'Table 5',
            'status' => 'seated',
        ]);

        Livewire::test(SeatingMap::class)
            ->call('handleTableClick', 'Table 5')
            ->assertSet('selectedTableId', 'Table 5')
            ->assertSet('isDetailsModalOpen', true)
            ->call('clearAssignment', $reservation->id)
            ->assertSet('isDetailsModalOpen', false);

        $fresh = $reservation->fresh();
        $this->assertNull($fresh->table_number);
        $this->assertEquals('pending', $fresh->status);
    }

    /** @test */
    public function it_can_cancel_a_reservation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today();

        $reservation = Reservation::create([
            'guest_name' => 'Seated Guest',
            'guest_phone' => '03118484989',
            'guest_count' => 4,
            'reservation_time' => $today->copy()->setTime(18, 00),
            'table_number' => 'Table 6',
            'status' => 'seated',
        ]);

        Livewire::test(SeatingMap::class)
            ->call('handleTableClick', 'Table 6')
            ->assertSet('selectedTableId', 'Table 6')
            ->assertSet('isDetailsModalOpen', true)
            ->call('cancelReservation', $reservation->id)
            ->assertSet('isDetailsModalOpen', false);

        $fresh = $reservation->fresh();
        $this->assertNull($fresh->table_number);
        $this->assertEquals('cancelled', $fresh->status);
    }

    /** @test */
    public function it_can_toggle_edit_mode_and_add_table()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(SeatingMap::class)
            ->call('toggleEditMode')
            ->assertSet('isEditMode', true)
            ->call('openAddTableModal', 'main_dining')
            ->assertSet('isAddTableModalOpen', true)
            ->set('newTableName', 'VIP Terrace 1')
            ->set('newTableSection', 'main_dining')
            ->set('newTableCapacity', 6)
            ->set('newTableShape', 'round')
            ->call('addTable')
            ->assertSet('isAddTableModalOpen', false)
            ->assertSee('VIP Terrace 1');

        $this->assertDatabaseHas('pos_settings', [
            'key' => 'seating_layout_plan',
        ]);
    }

    /** @test */
    public function it_can_edit_an_existing_table_configuration()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(SeatingMap::class)
            ->call('openEditTableModal', 'Table 1')
            ->assertSet('isEditTableModalOpen', true)
            ->assertSet('editingTableId', 'Table 1')
            ->set('editTableName', 'VIP Table 1')
            ->set('editTableCapacity', 8)
            ->set('editTableShape', 'banquet')
            ->call('updateTable')
            ->assertSet('isEditTableModalOpen', false)
            ->assertSee('VIP Table 1');
    }

    /** @test */
    public function it_can_delete_a_table_and_reset_to_default_plan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(SeatingMap::class)
            ->call('deleteTable', 'Table 10')
            ->assertDontSee('Table 10')
            ->call('resetToDefaultPlan')
            ->assertSee('Table 10');
    }
}
