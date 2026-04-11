<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class EditableSiteContent
{
    protected static ?array $settings = null;

    public static function flushCache(): void
    {
        static::$settings = null;
    }

    public static function company(): array
    {
        return static::setting('company', SiteContent::company());
    }

    public static function stats(): array
    {
        return static::setting('stats', SiteContent::stats());
    }

    public static function capabilities(): array
    {
        return static::setting('capabilities', SiteContent::capabilities());
    }

    public static function process(): array
    {
        return static::setting('process', SiteContent::process());
    }

    public static function testimonials(): array
    {
        return static::setting('testimonials', SiteContent::testimonials());
    }

    public static function partners(): array
    {
        return static::setting('partners', SiteContent::partners());
    }

    public static function heroSlides(): array
    {
        return static::setting('hero_slides', SiteContent::heroSlides());
    }

    public static function projectsInUse(): array
    {
        return static::setting('projects_in_use', SiteContent::projectsInUse());
    }

    protected static function setting(string $key, array $default): array
    {
        $settings = static::all();
        $value = $settings[$key] ?? null;

        if (! is_array($value) || $value === []) {
            return $default;
        }

        if (array_is_list($default)) {
            return $value;
        }

        return array_replace_recursive($default, $value);
    }

    protected static function all(): array
    {
        if (static::$settings !== null) {
            return static::$settings;
        }

        if (! Schema::hasTable('site_settings')) {
            return static::$settings = [];
        }

        return static::$settings = SiteSetting::query()
            ->get()
            ->mapWithKeys(fn (SiteSetting $setting) => [$setting->key => $setting->value])
            ->all();
    }
}
