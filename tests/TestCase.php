<?php

namespace Tovitch\BladeUI\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Tovitch\BladeUI\BladeUIServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'Tovitch\\BladeUI\\Database\\Factories\\' . class_basename(
                    $modelName
                ) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set(
            'database.connections.sqlite',
            [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]
        );

        /*
        include_once __DIR__.'/../database/migrations/create_component_ui_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            BladeUIServiceProvider::class,
        ];
    }
}
