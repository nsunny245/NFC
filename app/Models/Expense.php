<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'amount',
        'expense_date',
        'recipient',
        'description',
        'invoice_number',
        'receipt_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];
}
