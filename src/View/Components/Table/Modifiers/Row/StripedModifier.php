<?php

namespace Tovitch\BladeUI\View\Components\Table\Modifiers\Row;

use Tovitch\BladeUI\View\Components\Table\Modifiers\Modifier;

class StripedModifier extends Modifier
{
    /**
     * The classes to add to the row.
     *
     * @return string
     */
    public function classes(): string
    {
        return 'bg-gray-100';
    }

    /**
     * The classes to add to the row.
     *
     * @return string
     */
    public function shouldRender(): bool
    {
        return $this->loop->odd;
    }
}
