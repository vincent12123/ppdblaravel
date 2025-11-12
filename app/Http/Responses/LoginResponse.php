<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\LoginResponse as ResponsesLoginResponse;
use Filament\Pages\Dashboard;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse extends ResponsesLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        // Map roles from seeder: admin, tu, calon_siswa
        if ($user->hasRole('admin')) {
            return redirect()->to(Dashboard::getUrl(panel: 'admin'));
        }

        if ($user->hasRole('tu')) {
            // Using the existing admin panel until a dedicated TU panel exists
            return redirect()->to(Dashboard::getUrl(panel: 'admin'));
        }

        // Default for calon_siswa or other roles: send to homepage/public area
        return redirect()->to('/');
    }
}
