<?php

namespace Tovitch\BladeUI;

use Tovitch\Svg\Svg;
use Illuminate\Support\ServiceProvider;
use Tovitch\BladeUI\Commands\BladeUICommand;
use Tovitch\BladeUI\View\Components\Table\Table;
use Tovitch\BladeUI\Commands\TableRowMakeCommand;
use Tovitch\BladeUI\View\Components\Table\TableColumn;

class BladeUIServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/component-ui.php' => config_path('component-ui.php'),
                ],
                'config'
            );

            $this->publishes(
                [
                    __DIR__ . '/../resources/views' => base_path(
                        'resources/views/vendor/component-ui'
                    ),
                ],
                'views'
            );

            $this->publishes(
                [
                    __DIR__ . "/../resources/views/table.blade.php" => base_path(
                        'resources/views/vendor/component-ui/table.blade.php'
                    ),
                ],
                'table'
            );

            $this->commands([
                BladeUICommand::class,
                TableRowMakeCommand::class,
            ]);
        }

        $this->loadViewComponentsAs(config('component-ui.prefix'), [
            'svg'          => Svg::class,
            'table'        => Table::class,
            'table-column' => TableColumn::class,
        ]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'component-ui');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/component-ui.php', 'component-ui');
    }
}
