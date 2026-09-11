<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image_path',
        'is_available',
        'is_hero_item',
        'details',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_hero_item' => 'boolean',
        'details' => 'array',
    ];

    protected $appends = ['resolved_image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'category_id');
    }

    public function recipeItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RecipeItem::class);
    }

    public function getResolvedImageAttribute(): string
    {
        if ($this->image_path && file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        $name = strtolower($this->name);
        $cat = strtolower($this->category->name ?? '');

        if (str_contains($name, 'pizza')) {
            return asset('images/dishes/tikka_pizza.jpg');
        } elseif (str_contains($name, 'doner') || str_contains($name, 'shawarma') || str_contains($name, 'roll') || str_contains($name, 'wrap') || str_contains($cat, 'doner') || str_contains($cat, 'roll') || str_contains($cat, 'shawarma')) {
            return asset('images/dishes/doner_wrap.jpg');
        } elseif (str_contains($name, 'wing') || str_contains($name, 'nugget') || str_contains($name, 'broast') || str_contains($name, 'fried chicken') || str_contains($cat, 'appetizer')) {
            return asset('images/dishes/crispy_wings.jpg');
        } elseif (str_contains($name, 'fries') || str_contains($name, 'finger') || str_contains($cat, 'fries')) {
            return asset('images/dishes/french_fries.jpg');
        } elseif (str_contains($name, 'burger') || str_contains($name, 'sandwich') || str_contains($cat, 'burger')) {
            return asset('images/dishes/beef_burger.jpg');
        } elseif (str_contains($name, 'pasta') || str_contains($name, 'macaroni') || str_contains($name, 'lasagna') || str_contains($cat, 'pasta')) {
            return asset('images/dishes/baked_pasta.jpg');
        } elseif (str_contains($name, 'chowmein') || str_contains($name, 'noodle') || str_contains($cat, 'chinese')) {
            return asset('images/dishes/chowmein.jpg');
        } elseif (str_contains($name, 'rice') || str_contains($name, 'biryani') || str_contains($name, 'pulao') || str_contains($name, 'manchurian')) {
            return asset('images/dishes/manchurian_rice.jpg');
        } elseif (str_contains($name, 'mutton') || str_contains($name, 'lamb')) {
            return asset('images/dishes/mutton_karahi.jpg');
        } elseif (str_contains($name, 'karahi') || str_contains($name, 'handi') || str_contains($name, 'qorma')) {
            return asset('images/dishes/chicken_karahi.jpg');
        } elseif (str_contains($name, 'malai') || str_contains($name, 'boti')) {
            return asset('images/dishes/malai_boti.jpg');
        } elseif (str_contains($name, 'kebab') || str_contains($name, 'kabab') || str_contains($name, 'platter') || str_contains($cat, 'bbq') || str_contains($cat, 'platter')) {
            return asset('images/dishes/seekh_kebab.jpg');
        }

        return asset('images/dishes/tikka_pizza.jpg');
    }
}
