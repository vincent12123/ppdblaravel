<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse;
use App\Http\Responses\LogoutResponse;
use Carbon\Carbon;
use Filament\Auth\Http\Responses\LoginResponse as ResponsesLoginResponse;
use Filament\Auth\Http\Responses\LogoutResponse as ResponsesLogoutResponse;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The container singletons that should be registered.
     *
     * @var array<class-string, class-string>
     */
    public $singletons = [
        ResponsesLoginResponse::class => LoginResponse::class,
        ResponsesLogoutResponse::class => LogoutResponse::class,
    ];

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
        // Ensure PHP processes (CLI, queue, scheduler) use the configured timezone
        $tz = config('app.timezone');
        if (is_string($tz) && $tz !== '') {
            date_default_timezone_set($tz);
        }

        // Set Carbon locale for human-readable dates in Indonesian
        $locale = config('app.locale');
        if (is_string($locale) && $locale !== '') {
            Carbon::setLocale($locale);
        }
    }
}
