<?php

namespace Tests\Feature;

use App\Livewire\ReservationForm;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_the_reservation_form()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSeeLivewire(ReservationForm::class);
    }

    /** @test */
    public function it_can_successfully_book_a_table()
    {
        Livewire::test(ReservationForm::class)
            ->set('guest_name', 'Mian Muhammad')
            ->set('guest_phone', '03118484987')
            ->set('guest_email', 'mian@example.com')
            ->set('guest_count', 4)
            ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
            ->set('reservation_time', '19:30')
            ->set('special_requests', 'Need an outdoor Dera seating section, mild spices.')
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('successMessage', "Your table for 4 guests on " . Carbon::tomorrow()->setTime(19, 30)->format('M d, Y \a\t h:i A') . " has been requested successfully! We will contact you at 03118484987 shortly.");

        $this->assertDatabaseHas('reservations', [
            'guest_name' => 'Mian Muhammad',
            'guest_phone' => '03118484987',
            'guest_email' => 'mian@example.com',
            'guest_count' => 4,
            'special_requests' => 'Need an outdoor Dera seating section, mild spices.',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_requires_guest_name_phone_date_and_time()
    {
        Livewire::test(ReservationForm::class)
            ->set('guest_name', '')
            ->set('guest_phone', '')
            ->set('reservation_date', '')
            ->set('reservation_time', '')
            ->call('submit')
            ->assertHasErrors([
                'guest_name' => 'required',
                'guest_phone' => 'required',
                'reservation_date' => 'required',
                'reservation_time' => 'required',
            ]);
    }

    /** @test */
    public function it_validates_guest_count_limits()
    {
        Livewire::test(ReservationForm::class)
            ->set('guest_name', 'Muhammad Ali')
            ->set('guest_phone', '03118484987')
            ->set('guest_count', 35) // Greater than maximum 30
            ->call('submit')
            ->assertHasErrors(['guest_count']);
    }

    /** @test */
    public function it_prevents_past_date_booking()
    {
        Livewire::test(ReservationForm::class)
            ->set('guest_name', 'Ali Raza')
            ->set('guest_phone', '03118484987')
            ->set('reservation_date', Carbon::yesterday()->format('Y-m-d'))
            ->call('submit')
            ->assertHasErrors(['reservation_date']);
    }
}
