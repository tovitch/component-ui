<?php

namespace Tovitch\BladeUI\Tests\Components\Table;

use Illuminate\Support\HtmlString;
use Tovitch\BladeUI\Tests\TestCase;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Pagination\LengthAwarePaginator;
use Tovitch\BladeUI\View\Components\Table\Table;
use Tovitch\BladeUI\Tests\Mocks\UserInformationRow;
use Tovitch\BladeUI\View\Components\Table\TableColumn;

class TableTest extends TestCase
{
    /** @test */
    public function it_render_the_component()
    {
        $data = new LengthAwarePaginator(collect([['username' => 'John Doe']]), 1, 15);

        $component = new Table($data);
        $column = new TableColumn('User', 'username');
        $component->attributes = new ComponentAttributeBag;

        $view = $component->render();

        $content = $view([
            'slot' => new HtmlString($column->render()($column->data())),
        ]);

        $this->assertStringContainsString('User', $content);
        $this->assertStringContainsString('John Doe', $content);
    }

    /** @test */
    public function it_display_text_when_there_are_no_data()
    {
        $data = new LengthAwarePaginator(collect([]), 0, 15);

        $component = new Table($data);
        $component->attributes = new ComponentAttributeBag(['empty-message' => 'Foobar']);

        $column = new TableColumn('User', 'username');

        $view = $component->render();

        $content = $view([
            'slot' => new HtmlString($column->render()($column->data())),
        ]);

        $this->assertStringContainsString('Foobar', $content);
    }

    /** @test */
    public function it_handles_row_modifier()
    {
        $data = new LengthAwarePaginator(collect([['username' => 'John Doe']]), 1, 15);

        $component = new Table($data);
        $component->attributes = new ComponentAttributeBag(['striped' => true]);

        $column = new TableColumn('User', 'username');

        $view = $component->render();

        $content = $view([
            'slot' => new HtmlString($column->render()($column->data())),
        ]);

        $this->assertStringContainsString('<tr class="bg-gray-100">', $content);
    }

    /**
     * @test
     * @dataProvider modifiers
     */
    public function it_has_default_modifiers(string $attribute, string $expectedClasses)
    {
        $data = new LengthAwarePaginator(collect([
            ['username' => 'John Doe'],
            ['username' => 'Jane Doe']
        ]), 2, 15);

        $component = new Table($data);
        $component->attributes = new ComponentAttributeBag([$attribute => true]);

        $column = new TableColumn('User', 'username');

        $view = $component->render();

        $content = $view([
            'slot' => new HtmlString($column->render()($column->data())),
        ]);

        $this->assertStringContainsString("<tr class=\"{$expectedClasses}\">", $content);
    }

    public function modifiers()
    {
        return [
            'striped modifier'   => [
                'striped', 'bg-gray-100',
            ],
            'hoverable modifier' => [
                'hoverable', 'hover:bg-gray-100',
            ],
            'bordered modifier'  => [
                'bordered', 'border-b dark:border-gray-600',
            ],
        ];
    }

    /** @test */
    public function it_render_a_table_row_component()
    {
        $data = new LengthAwarePaginator(
            collect([['username' => 'John Doe', 'email' => 'john@example.com']]),
            1,
            15
        );

        $component = new Table($data);
        $component->attributes = new ComponentAttributeBag;

        $column = new TableColumn(
            'User',
            'username',
            null,
            UserInformationRow::class
        );

        $view = $component->render();

        $content = $view([
            'slot' => new HtmlString($column->render()($column->data())),
        ]);

        $needle = <<<blade
<div>
    <p>John Doe</p>
    <p>john@example.com</p>
</div>
blade;

        $this->assertStringContainsString($needle, $content);
    }
}
