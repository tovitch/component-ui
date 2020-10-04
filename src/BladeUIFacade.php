<?php

namespace Tovitch\BladeUI;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tovitch\BladeUI\BladeUI
 */
class BladeUIFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'component-ui';
    }
}
