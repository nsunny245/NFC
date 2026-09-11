<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // Use protected $table = 'equipments' since pluralization might resolve differently (e.g. equipment)
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'quantity',
        'category',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'functional_status',
        'last_maintenance_date',
        'next_maintenance_date',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'purchase_date' => 'date',
        'purchase_cost' => 'decimal:2',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
    ];
}
