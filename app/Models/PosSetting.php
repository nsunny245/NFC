<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class PosSetting extends Model
{
    protected $table = 'pos_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Default settings dictionary.
     */
    protected static array $defaults = [
        'vat_enabled' => '1',
        'vat_percentage' => '16.00',
        'vat_label' => 'GST Tax (16%)',
        'service_fee_enabled' => '0',
        'service_fee_percentage' => '5.00',
        'service_fee_type' => 'percentage', // percentage or fixed
        'service_fee_amount' => '0.00',
        'card_payment_enabled' => '1',
        'card_fee_percentage' => '0.00',
        'card_terminal_name' => 'Bank POS / Cards',
    ];

    /**
     * Storage fallback path for JSON persistence.
     */
    protected static function getStoragePath(): string
    {
        return storage_path('app/pos_settings.json');
    }

    /**
     * Ensure database table exists if accessed directly.
     */
    protected static function ensureTableExists(): bool
    {
        try {
            if (! Schema::hasTable('pos_settings')) {
                Schema::create('pos_settings', function ($table) {
                    $table->id();
                    $table->string('key')->unique();
                    $table->text('value')->nullable();
                    $table->timestamps();
                });
            }
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Retrieve a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $default = $default ?? (static::$defaults[$key] ?? null);

        return Cache::remember("pos_setting_{$key}", 300, function () use ($key, $default) {
            // Try database first
            if (static::ensureTableExists()) {
                try {
                    $record = static::where('key', $key)->first();
                    if ($record) {
                        return $record->value;
                    }
                } catch (\Throwable $e) {
                    // Fallback to JSON
                }
            }

            // Fallback to JSON file
            $path = static::getStoragePath();
            if (File::exists($path)) {
                $data = json_decode(File::get($path), true) ?: [];
                if (isset($data[$key])) {
                    return $data[$key];
                }
            }

            return $default;
        });
    }

    /**
     * Store or update a setting value.
     */
    public static function set(string $key, mixed $value): void
    {
        $stringValue = is_bool($value) ? ($value ? '1' : '0') : (string)$value;

        // 1. Update Database if available
        if (static::ensureTableExists()) {
            try {
                static::updateOrCreate(
                    ['key' => $key],
                    ['value' => $stringValue]
                );
            } catch (\Throwable $e) {
                // Silently fallback to JSON
            }
        }

        // 2. Persist to local JSON file
        try {
            $path = static::getStoragePath();
            $dir = dirname($path);
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $data = File::exists($path) ? (json_decode(File::get($path), true) ?: []) : [];
            $data[$key] = $stringValue;
            File::put($path, json_encode($data, JSON_PRETTY_PRINT));
        } catch (\Throwable $e) {
            // Log or ignore
        }

        // 3. Invalidate cache
        Cache::forget("pos_setting_{$key}");
    }

    /**
     * Helper accessors.
     */
    public static function isVatEnabled(): bool
    {
        return (bool)static::get('vat_enabled', '1');
    }

    public static function getVatPercentage(): float
    {
        return (float)static::get('vat_percentage', '16.00');
    }

    public static function isServiceFeeEnabled(): bool
    {
        return (bool)static::get('service_fee_enabled', '0');
    }

    public static function getServiceFeePercentage(): float
    {
        return (float)static::get('service_fee_percentage', '5.00');
    }

    public static function isCardPaymentEnabled(): bool
    {
        return (bool)static::get('card_payment_enabled', '1');
    }

    public static function getCardFeePercentage(): float
    {
        return (float)static::get('card_fee_percentage', '0.00');
    }
}
