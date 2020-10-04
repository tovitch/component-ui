<?php

namespace Tovitch\BladeUI\Commands;

use Illuminate\Console\Command;

class BladeUICommand extends Command
{
    public $signature = 'component-ui';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
