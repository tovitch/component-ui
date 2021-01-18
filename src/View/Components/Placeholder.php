<?php

namespace Tovitch\BladeUI\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Placeholder extends Component
{
    public bool $text;
    public bool $block;
    public bool $round;
    public string $size;

    public function __construct(bool $text = false, bool $block = false, bool $round = false, string $size = '')
    {
        $this->text = $text;
        $this->block = $block;
        $this->round = $round;
        $this->size = $size ?: (app()->environment('testing') ? 5 : rand(10, 15));
    }

    public function render()
    {
        return View::make('component-ui::placeholder');
    }

    public function classes(): string
    {
        $classes = [
            'animate-pulse',
            'text-transparent',
            'bg-gray-300',
            'dark:bg-gray-600',
        ];

        if ($this->block) {
            $classes = array_merge($classes, [
                'rounded-sm',
                'block',
            ]);
        } elseif ($this->round) {
            $classes = array_merge($classes, [
                'rounded-full',
                'inline-block',
            ]);
        } else {
            $classes[] = 'rounded-sm';
        }

        return implode(' ', $classes);
    }

    public function styles(): string
    {
        $styles = [];

        if ($this->block) {
            $styles[] = "height:{$this->size}";
        } elseif ($this->round) {
            $styles = array_merge([
                "width:{$this->size}",
                "height:{$this->size}",
            ], $styles);
        }

        return implode(';', $styles);
    }
}
