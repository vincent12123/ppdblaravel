<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

class RedirectToProperPanelMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $currentPanel = Filament::getCurrentPanel()?->getId();

            // Allow admin & tu to access the admin panel; redirect others away
            if ($user->hasAnyRole(['admin', 'tu'])) {
                if ($currentPanel !== 'admin') {
                    return redirect()->to(Dashboard::getUrl(panel: 'admin'));
                }
            } else {
                // calon_siswa or other roles: keep them out of the admin panel
                if ($currentPanel === 'admin') {
                    return redirect()->to('/');
                }
            }
        }

        return $next($request);
    }
}
