<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'category',
        'quantity',
        'unit',
        'minimum_qty',
        'unit_cost',
        'supplier_name',
        'last_restocked_at',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'minimum_qty' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'last_restocked_at' => 'datetime',
    ];

    public function recipeItems(): HasMany
    {
        return $this->hasMany(RecipeItem::class);
    }
}
