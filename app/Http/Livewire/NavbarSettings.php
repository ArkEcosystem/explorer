<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\SettingsStorage;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

final class NavbarSettings extends Component
{
    public array $state = [];

    public function mount(): void
    {
        $this->state = app(SettingsStorage::class)->all();
    }

    public function updatedState(): void
    {
        $settings = app(SettingsStorage::class);

        $originalCurrency = Arr::get($settings->all(), 'currency');
        $newCurrency      = Arr::get($this->state, 'currency');

        $originalTheme = Arr::get($settings->all(), 'darkTheme');
        $newTheme      = Arr::get($this->state, 'darkTheme');

        Cookie::queue('settings', json_encode($this->state), 60 * 24 * 365 * 5);

        if ($originalCurrency !== $newCurrency) {
            $this->emit('currencyChanged', $newCurrency);
        }

        if ($originalTheme !== $newTheme) {
            $this->emit('toggleDarkMode', $settings->theme());
        }
    }
}
