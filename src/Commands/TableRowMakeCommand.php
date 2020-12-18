<?php

namespace Tovitch\BladeUI\Commands;

use Illuminate\Console\GeneratorCommand;

class TableRowMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:table-row';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom TableRow class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/table-row.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\View\TableRows';
    }
}
