<?php

namespace Tovitch\BladeUI\Tests;

use Tovitch\Svg\SvgServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tovitch\BladeUI\BladeUIServiceProvider;

class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            BladeUIServiceProvider::class,
            SvgServiceProvider::class,
        ];
    }
}
