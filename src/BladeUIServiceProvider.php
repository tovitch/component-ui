<?php

namespace Tovitch\BladeUI;

use Illuminate\Support\ServiceProvider;
use Tovitch\BladeUI\Commands\BladeUICommand;

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
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/component-ui'),
                ],
                'views'
            );

            $migrationFileName = 'create_component_ui_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes(
                    [
                        __DIR__
                        . "/../database/migrations/{$migrationFileName}.stub" => database_path(
                            'migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName
                        ),
                    ],
                    'migrations'
                );
            }

            $this->commands(
                [
                    BladeUICommand::class,
                ]
            );
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'component-ui');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/component-ui.php', 'component-ui');
    }
}
