<?php

namespace Tovitch\BladeUI\Tests\Mocks;

use Tovitch\BladeUI\View\Components\Table\TableRow;

class UserInformationRow extends TableRow
{
    public function render($row)
    {
        return <<<blade
<div>
    <p>{$row['username']}</p>
    <p>{$row['email']}</p>
</div>
blade;
    }
}
