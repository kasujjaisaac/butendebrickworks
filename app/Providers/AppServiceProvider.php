<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for older MySQL versions: set default string length
        Schema::defaultStringLength(191);

        RateLimiter::for('talk-to-us', function (Request $request) {
            $email = Str::lower((string) $request->input('email', 'guest'));

            return [
                Limit::perMinute((int) config('monitoring.talk_to_us.per_minute', 5))
                    ->by('talk-to-us:minute:'.$request->ip()),
                Limit::perHour((int) config('monitoring.talk_to_us.per_hour', 30))
                    ->by('talk-to-us:hour:'.$request->ip().':'.$email),
            ];
        });
    }
}
