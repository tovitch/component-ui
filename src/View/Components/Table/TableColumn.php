<?php

namespace Tovitch\BladeUI\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\App;
use Illuminate\View\ComponentAttributeBag;

class TableColumn extends Component
{
    public string $name;
    public ?string $attribute;
    public ?string $date;
    public ?string $component;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  string|null  $attribute
     * @param  string|null  $date
     * @param  string|null  $component
     */
    public function __construct(
        string $name,
        string $attribute = null,
        string $date = null,
        string $component = null
    )
    {
        $this->name = $name;
        $this->attribute = $attribute;
        $this->date = $date;
        $this->component = $component;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return function ($data) {
            $properties = collect($data)
                ->only(array_keys($this->extractPublicProperties()))
                ->map(function ($property) {
                    if ($property instanceof ComponentAttributeBag) {
                        return $property->getAttributes();
                    }

                    return $property;
                });

            return json_encode($properties) . ',';
        };
    }

    public function renderComponentView($row)
    {
        $instance = App::make($this->component, ['component' => $this]);

        return $instance->render($row);
    }

    /**
     * Determines if we should align the content.
     *
     * @return HtmlString
     */
    public function alignment(): HtmlString
    {
        if (! $this->attributes->get('align')) {
            return new HtmlString();
        }

        return new HtmlString("align=\"{$this->attributes->get('align')}\"");
    }

    /**
     * Determines if the row will be a date.
     *
     * @return bool
     */
    public function isDate(): bool
    {
        return $this->date !== null;
    }

    /**
     * Determines if the row will be a boolean.
     *
     * @return bool
     */
    public function isBoolean(): bool
    {
        return $this->attributes->get('boolean') !== null;
    }
}
