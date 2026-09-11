<?php

namespace App\Livewire;

use App\Models\Reservation;
use Carbon\Carbon;
use Livewire\Component;

class ReservationForm extends Component
{
    public $guest_name = '';
    public $guest_email = '';
    public $guest_phone = '';
    public $reservation_date = '';
    public $reservation_time = '';
    public $guest_count = 2;
    public $special_requests = '';

    public $successMessage = null;

    protected function rules()
    {
        return [
            'guest_name' => 'required|min:3|max:100',
            'guest_email' => 'nullable|email|max:100',
            'guest_phone' => 'required|min:10|max:20',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guest_count' => 'required|integer|min:1|max:30',
            'special_requests' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'guest_name.required' => 'Please provide a name for the reservation.',
        'guest_phone.required' => 'We need your mobile number to text you the confirmation details.',
        'reservation_date.after_or_equal' => 'Reservations cannot be booked for past dates.',
        'reservation_time.required' => 'Please select a dining time.',
    ];

    public function mount()
    {
        $this->reservation_date = Carbon::today()->format('Y-m-d');
    }

    public function submit()
    {
        $this->validate();

        $dateTimeString = $this->reservation_date . ' ' . $this->reservation_time;
        
        try {
            $reservationTime = Carbon::parse($dateTimeString);
        } catch (\Exception $e) {
            $this->addError('reservation_time', 'Invalid date or time format.');
            return;
        }

        $reservation = Reservation::create([
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
            'reservation_time' => $reservationTime,
            'guest_count' => $this->guest_count,
            'special_requests' => $this->special_requests,
            'status' => 'pending',
        ]);

        // Create an internal notification for Admin and Cashier
        \App\Models\InternalNotification::create([
            'type' => 'table_reservation',
            'title' => '📅 New Table Reservation',
            'message' => "Requested by {$reservation->guest_name} for {$reservation->guest_count} guests on " . $reservation->reservation_time->format('M d, h:i A'),
            'notifiable_role' => 'all',
            'related_id' => $reservation->id,
        ]);

        $this->successMessage = "Your table for {$this->guest_count} guests on " . $reservationTime->format('M d, Y \a\t h:i A') . " has been requested successfully! We will contact you at {$this->guest_phone} shortly.";

        $this->reset(['guest_name', 'guest_email', 'guest_phone', 'special_requests', 'reservation_time']);
        $this->reservation_date = Carbon::today()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.reservation-form');
    }
}
