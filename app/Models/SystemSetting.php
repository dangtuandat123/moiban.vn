<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Model SystemSetting
 * Cấu hình hệ thống (key-value store)
 */
class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    // =========== STATIC METHODS ===========

    /**
     * Lấy giá trị setting theo key
     * @param string $key Key của setting
     * @param mixed $default Giá trị mặc định nếu không tìm thấy
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Lưu giá trị setting
     */
    public static function set(string $key, mixed $value, ?string $group = null): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Lấy tất cả settings theo group
     */
    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Xóa cache của setting
     */
    public static function clearCache(string $key): void
    {
        Cache::forget("setting.{$key}");
    }

    /**
     * Xóa toàn bộ cache settings
     */
    public static function clearAllCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }
}
