<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'reservation_time',
        'guest_count',
        'table_number',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'reservation_time' => 'datetime',
        'guest_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
