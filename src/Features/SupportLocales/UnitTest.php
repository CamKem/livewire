<?php

namespace Livewire\Features\SupportLocales;

use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\Livewire;

class UnitTest extends \Tests\TestCase
{
    public function test_a_livewire_component_can_persist_its_locale()
    {
        // Set locale
        App::setLocale('en');
        $this->assertEquals(App::getLocale(), 'en');

        // Mount component and new ensure locale is set
        $component = Livewire::test(ComponentForLocalePersistanceHydrationMiddleware::class);
        $this->assertEquals(App::getLocale(), 'es');

        // Reset locale to ensure it isn't persisted in the test session
        App::setLocale('en');
        $this->assertEquals(App::getLocale(), 'en');

        // Verify locale is persisted from component mount
        $component->call('$refresh');
        $this->assertEquals(App::getLocale(), 'es');
    }
}

class ComponentForLocalePersistanceHydrationMiddleware extends Component
{
    public function mount()
    {
        App::setLocale('es');
    }

    public function render()
    {
        return view('null-view');
    }
}
