<?php

namespace Tovitch\BladeUI;

class BladeUI
{
    static ?string $paginationView = null;

    public static function setPaginationView(string $view)
    {
        static::$paginationView = $view;
    }
}
