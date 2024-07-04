<?php

namespace Kenepa\Banner\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Kenepa\Banner\BannerServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kenepa\\Banner\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__ . '/../database/migrations/create_banner_table.php.stub';
        $migration->up();
    }

    public function generateRawBannerData(): array
    {
        return [
            'id' => uniqid(),
            'name' => fake()->name,
            'content' => fake()->randomHtml(),
            'is_active' => false,
            'active_since' => null,
            'icon' => 'fa-fire',
            'background_type' => 'gradient',
            'start_color' => fake()->hexColor,
            'end_color' => fake()->hexColor,
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
            'can_be_closed_by_user' => fake()->boolean,
            'text_color' => fake()->hexColor,
            'icon_color' => fake()->hexColor,
            'render_location' => 'header',
            'scope' => ['all', 'homepage', 'product_page'],
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            BannerServiceProvider::class,
        ];
    }
}
