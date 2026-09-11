<?php

namespace Illuminate\Support {
    if (!function_exists('Illuminate\Support\extension_loaded')) {
        function extension_loaded($name) {
            if ($name === 'intl') {
                return true;
            }
            return \extension_loaded($name);
        }
    }
}

namespace {
    if (!class_exists('NumberFormatter')) {
        class NumberFormatter {
            public const DECIMAL = 1;
            public const SPELLOUT = 2;
            public const ORDINAL = 3;
            public const PERCENT = 4;
            public const CURRENCY = 5;

            public const MAX_FRACTION_DIGITS = 6;
            public const FRACTION_DIGITS = 7;
            public const DEFAULT_RULESET = 8;

            public const TYPE_DEFAULT = 1;
            public const TYPE_INT32 = 2;
            public const TYPE_DOUBLE = 3;

            private $locale;
            private $style;
            private $attributes = [];
            private $textAttributes = [];

            public function __construct(string $locale, int $style, ?string $pattern = null) {
                $this->locale = $locale;
                $this->style = $style;
            }

            public function setAttribute(int $attr, $value): bool {
                $this->attributes[$attr] = $value;
                return true;
            }

            public function setTextAttribute(int $attr, string $value): bool {
                $this->textAttributes[$attr] = $value;
                return true;
            }

            public function format($value, int $type = self::TYPE_DEFAULT) {
                if ($this->style === self::PERCENT) {
                    $decimals = $this->attributes[self::FRACTION_DIGITS] ?? 0;
                    return number_format($value * 100, $decimals) . '%';
                }

                if ($this->style === self::SPELLOUT || $this->style === self::ORDINAL) {
                    return (string) $value;
                }

                $decimals = $this->attributes[self::FRACTION_DIGITS] ?? ($this->attributes[self::MAX_FRACTION_DIGITS] ?? 0);
                return number_format($value, $decimals);
            }

            public function formatCurrency(float $value, string $currency) {
                $decimals = $this->attributes[self::FRACTION_DIGITS] ?? 2;
                if ($currency === 'PKR' || $currency === 'Rs' || $currency === 'Rs.') {
                    return 'Rs. ' . number_format($value, 0);
                }
                return $currency . ' ' . number_format($value, $decimals);
            }

            public function parse(string $value, int $type = self::TYPE_DOUBLE, ?int &$position = null) {
                $clean = preg_replace('/[^\d\.]/', '', $value);
                return $type === self::TYPE_INT32 ? (int) $clean : (float) $clean;
            }
        }
    }
}
