<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'terminal_code',
        'user_id',
        'waiter_id',
        'order_number',
        'table_number',
        'customer_name',
        'customer_phone',
        'customer_address',
        'rider_name',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'cash_received',
        'change_returned',
        'transaction_reference',
        'type',
        'special_notes',
        'synced_at',
        'served_at',
        'bill_requested',
        'bill_requested_at',
    ];

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (empty($order->uuid)) {
                $order->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'cash_received' => 'decimal:2',
        'change_returned' => 'decimal:2',
        'bill_requested' => 'boolean',
        'served_at' => 'datetime',
        'bill_requested_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function waiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
