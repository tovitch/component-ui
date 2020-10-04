<?php

namespace Tovitch\Skeleton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tovitch\Skeleton\Skeleton
 */
class SkeletonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
