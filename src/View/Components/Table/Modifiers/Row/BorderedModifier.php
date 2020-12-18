<?php

namespace Tovitch\BladeUI\View\Components\Table\Modifiers\Row;

use Tovitch\BladeUI\View\Components\Table\Modifiers\Modifier;

class BorderedModifier extends Modifier
{
    /**
     * The classes to add to the row.
     *
     * @return string
     */
    public function classes(): string
    {
        return 'border-b dark:border-gray-600';
    }

    /**
     * Determines if the modifier should be rendered on the row.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        return ! $this->loop->last;
    }
}
