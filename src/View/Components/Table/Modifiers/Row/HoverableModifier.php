<?php

namespace Tovitch\BladeUI\View\Components\Table\Modifiers\Row;

use Tovitch\BladeUI\View\Components\Table\Modifiers\Modifier;

class HoverableModifier extends Modifier
{
    /**
     * The classes to add to the row.
     *
     * @return string
     */
    public function classes(): string
    {
        return 'hover:bg-gray-100';
    }
}
