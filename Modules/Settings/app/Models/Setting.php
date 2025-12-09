<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'group', 'type', 'autoload'];

    protected $casts = ['autoload' => 'boolean'];

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn($value) => match ($this->type) {
                'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                'integer' => (int) $value,
                'array', 'json' => json_decode($value, true),
                default => $value,
            },
            set: function ($value) {
                return match (gettype($value)) {
                    'array' => json_encode($value),
                    'boolean' => $value ? '1' : '0',
                    'integer' => (string) $value,
                    default => (string) $value,
                };
            }
        );
    }

    public static function allCached(): array
    {
        return cache()->rememberForever('settings.autoload', function () {
            return self::where('autoload', true)->pluck('value', 'key')->toArray();
        });
    }

    public static function clearCache(): void
    {
        cache()->forget('settings.autoload');
    }
}
