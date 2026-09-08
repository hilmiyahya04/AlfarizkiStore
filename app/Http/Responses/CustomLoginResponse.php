<?php

namespace App\Http\Responses;

use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        if ($user->hasRole('customer')) {
            return redirect()->route('home');
        }

        return redirect()->intended(filament()->getUrl());
    }
}