<?php

namespace Tovitch\BladeUI\View\Components\Table;

abstract class TableRow
{
    protected TableColumn $component;

    /**
     * TableRowInterface constructor.
     *
     * @param  TableColumn  $component
     */
    public function __construct(TableColumn $component)
    {
        $this->component = $component;
    }

    /**
     * Get the view / contents that represent the row.
     *
     * @param mixed $row
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    abstract public function render($row);
}
