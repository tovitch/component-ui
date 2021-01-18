<?php

namespace Tovitch\BladeUI\Tests\Components\Table;

use Illuminate\Support\HtmlString;
use Tovitch\BladeUI\Tests\ComponentTestCase;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\Pagination\LengthAwarePaginator;
use Tovitch\BladeUI\View\Components\Table\Table;
use Tovitch\BladeUI\Tests\Mocks\UserInformationRow;
use Tovitch\BladeUI\View\Components\Table\TableColumn;

class TableComponentTest extends ComponentTestCase
{
    /** @test */
    public function it_render_the_component()
    {
        $data = [['username' => 'John Doe']];

        $actual = <<<'blade'
            <x-blade-ui-table :data="$data">
                <x-blade-ui-table-column name="User" attribute="username" />
            </x-blade-ui-table>
            blade;

        $expected = <<<'html'
<div class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg" style="-webkit-overflow-scrolling: touch;">
    <table class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg">
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
            <tr>
                <th class="py-5 px-2 font-semibold whitespace-nowrap">
    User </th>
            </tr>
        </thead>
        <tbody>
            <tr wire:key="216247e34f16c61cd61b806711636bb1">
                <td class="px-2 whitespace-nowrap py-5">
                    <div class="hidden" wire:loading.delay.class.remove="hidden">
    <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">_____</span>
</div>
                    <div wire:loading.delay.remove>
    John Doe
</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
html;

        $this->assertComponentRenders($expected, $actual, ['data' => $data]);
    }

    /** @test */
    public function it_can_display_nested_attributes()
    {
        $data = [['company' => ['name' => 'Acme']]];

        $actual = <<<'blade'
            <x-blade-ui-table :data="$data">
                <x-blade-ui-table-column name="Company" attribute="company.name" />
            </x-blade-ui-table>
            blade;

        $expected = <<<'html'
<div class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg" style="-webkit-overflow-scrolling: touch;">
    <table class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg">
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
            <tr>
                <th class="py-5 px-2 font-semibold whitespace-nowrap">
    Company </th>
            </tr>
        </thead>
        <tbody>
            <tr wire:key="36873f1a198d7af9940cdd96852e58d1">
                <td class="px-2 whitespace-nowrap py-5">
                    <div class="hidden" wire:loading.delay.class.remove="hidden">
    <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">_____</span>
</div>
                    <div wire:loading.delay.remove>
    Acme
</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
html;

        $this->assertComponentRenders($expected, $actual, ['data' => $data]);
    }

    /** @test */
    public function it_display_formatted_date()
    {
        $data = [['created_at' => '2021-01-18 10:42:21']];

        $actual = <<<'blade'
            <x-blade-ui-table :data="$data">
                <x-blade-ui-table-column name="Created At" attribute="created_at" date="d/m/Y" />
            </x-blade-ui-table>
            blade;

        $expected = <<<'html'
<div class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg" style="-webkit-overflow-scrolling: touch;">
    <table class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg">
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
            <tr>
                <th class="py-5 px-2 font-semibold whitespace-nowrap">
    Created At </th>
            </tr>
        </thead>
        <tbody>
            <tr wire:key="e77b986f3c8aa80203773bf825337ada">
                <td class="px-2 whitespace-nowrap py-5">
                    <div class="hidden" wire:loading.delay.class.remove="hidden">
    <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">_____</span>
</div>
                    <div wire:loading.delay.remove>
    <span title="2021-01-18 10:42:21">
    18/01/2021 </span>
</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
html;

        $this->assertComponentRenders($expected, $actual, ['data' => $data]);
    }

    /** @test */
    public function it_display_nothing_when_the_date_is_null()
    {
        $data = [['created_at' => null]];

        $actual = <<<'blade'
            <x-blade-ui-table :data="$data">
                <x-blade-ui-table-column name="Created At" attribute="created_at" date="d/m/Y" />
            </x-blade-ui-table>
            blade;

        $expected = <<<'html'
<div class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg" style="-webkit-overflow-scrolling: touch;">
    <table class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg">
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
            <tr>
                <th class="py-5 px-2 font-semibold whitespace-nowrap">
    Created At </th>
            </tr>
        </thead>
        <tbody>
            <tr wire:key="94cbba0ff15cd0209d484e1eec4d78d7">
                <td class="px-2 whitespace-nowrap py-5">
                    <div class="hidden" wire:loading.delay.class.remove="hidden">
    <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">_____</span>
</div>
                    <div wire:loading.delay.remove>
    <span title="">
    </span>
</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
html;

        $this->assertComponentRenders($expected, $actual, ['data' => $data]);
    }

    /** @test */
    public function it_display_the_provided_empty_message_when_the_date_is_null()
    {
        $data = [['created_at' => null]];

        $actual = <<<'blade'
            <x-blade-ui-table :data="$data">
                <x-blade-ui-table-column name="Created At" attribute="created_at" date="d/m/Y" empty-message="Date is empty" />
            </x-blade-ui-table>
            blade;

        $expected = <<<'html'
<div class="max-w-full overflow-auto overflow-y-hidden shadow rounded-lg" style="-webkit-overflow-scrolling: touch;">
    <table class="bg-white dark:bg-gray-700 dark:text-white overflow-hidden w-full rounded-lg">
        <thead class="text-gray-300 bg-gray-800 dark:bg-gray-600 text-sm font-medium text-left">
            <tr>
                <th class="py-5 px-2 font-semibold whitespace-nowrap" empty-message="Date is empty">
    Created At </th>
            </tr>
        </thead>
        <tbody>
            <tr wire:key="94cbba0ff15cd0209d484e1eec4d78d7">
                <td class="px-2 whitespace-nowrap py-5 ">
                    <div class="hidden" wire:loading.delay.class.remove="hidden">
    <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">_____</span>
</div>
                    <div wire:loading.delay.remove>
    <span title="">
    Date is empty </span>
</div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
html;

        $this->assertComponentRenders($expected, $actual, ['data' => $data]);
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

        $this->assertStringContainsString('<tr class="bg-gray-100"', $content);
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

        $this->assertStringContainsString("<tr class=\"{$expectedClasses}\"", $content);
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
