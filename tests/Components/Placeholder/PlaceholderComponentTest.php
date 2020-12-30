<?php

namespace Tovitch\BladeUI\Tests\Components\Placeholder;

use Tovitch\BladeUI\Tests\ComponentTestCase;

class PlaceholderComponentTest extends ComponentTestCase
{
    /** @test */
    public function the_component_can_be_rendered()
    {
        $actual = '<x-blade-ui-placeholder text size="10" />';

        $expected = <<<'html'
            <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm" style="">__________</span>
            html;

        $this->assertComponentRenders($expected, $actual);
    }

    /** @test */
    public function it_can_render_a_block()
    {
        $actual = '<x-blade-ui-placeholder block size="10px" />';

        $expected = <<<'html'
            <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-sm block" style="height:10px"></span>
            html;

        $this->assertComponentRenders($expected, $actual);
    }

    /** @test */
    public function it_can_render_a_circle()
    {
        $actual = '<x-blade-ui-placeholder round size="10px" />';

        $expected = <<<'html'
            <span class="animate-pulse text-transparent bg-gray-300 dark:bg-gray-600 rounded-full inline-block" style="width:10px;height:10px"></span>
            html;

        $this->assertComponentRenders($expected, $actual);
    }
}
