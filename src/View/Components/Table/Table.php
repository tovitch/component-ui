<?php

namespace Tovitch\BladeUI\View\Components\Table;

use Illuminate\View\Component;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Tovitch\BladeUI\View\Components\Table\Modifiers\Modifier;

class Table extends Component
{
    public string $emptyMessage;
    public $data;

    /**
     * Create a new component instance.
     *
     * @param  \Illuminate\Support\Collection|\Illuminate\Pagination\LengthAwarePaginator  $data
     * @param  string  $emptyMessage
     */
    public function __construct($data, string $emptyMessage = 'No Data')
    {
        $this->data = $data;
        $this->emptyMessage = $emptyMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return function ($data) {
            $__children = $this->parseSlot($data['slot']->toHtml());

            $data = array_merge([
                '__children' => $__children,
                'data' => $this->data,
            ], $this->data());

            return View::make('component-ui::table', $data)
                ->render(function ($view, $html) {
                    // Remove ugly html attributes like striped="striped".
                    $patterns = collect($view->attributes)
                        ->map(fn($value, $attribute) => "/{$attribute}=\"{$attribute}\"/")
                        ->toArray();

                    return preg_replace($patterns, '', $html);
                });
        };
    }

    protected function parseSlot(string $slot): Collection
    {
        return collect(json_decode('[' . trim($slot, ',') . ']'))
            ->map(
                fn($child) => (new TableColumn($child->name, $child->attribute, $child->date, $child->component))
                    ->withAttributes((array) $child->attributes)
            );
    }

    /**
     * Determines the row style based on the table attributes and loop state.
     *
     * @param  object  $loop
     *
     * @return HtmlString
     */
    public function resolveRowStyle(object $loop, $data): HtmlString
    {
        $registeredClasses = collect($this->attributes->getAttributes())
            ->map(function ($value, $attribute) use ($loop, $data) {
                foreach (Modifier::getRowModifiers() as $dataModifier) {
                    if ($attribute !== strtolower(class_basename($dataModifier))) {
                        continue;
                    }

                    $modifier = new $dataModifier($value, $loop, $data);

                    if ($modifier->shouldRender()) {
                        return $modifier->classes();
                    }
                }
            })
            ->filter();

        $classes = collect($this->attributes->getAttributes())
            ->map(function ($value, $attribute) use ($loop, $data) {
                $modifier = Modifier::resolveRowModifier($attribute, $loop, $value, $data);

                if ($modifier && $modifier->shouldRender()) {
                    return $modifier->classes();
                }
            })
            ->merge($registeredClasses)
            ->filter()
            ->join(' ');

        return new HtmlString($classes ? "class=\"{$classes}\"" : '');
    }

    /**
     * Determines the data field style based on the table attributes and loop state.
     *
     * @param  object  $loop
     * @param $data
     *
     * @return HtmlString
     */
    public function resolveDataStyle(object $loop, $data, $child): HtmlString
    {
        $registeredClasses = collect($child->attributes->getAttributes())
            ->map(function ($value, $attribute) use ($loop, $data, $child) {
                foreach (Modifier::getDataModifiers() as $dataModifier) {
                    if ($attribute !== strtolower(class_basename($dataModifier))) {
                        continue;
                    }

                    $modifier = new $dataModifier($value, $loop, $data, $child);

                    if ($modifier->shouldRender()) {
                        return $modifier->classes();
                    }
                }
            });

        $classes = collect($this->attributes->getAttributes())
            ->map(function ($value, $attribute) use ($loop, $data, $child) {
                $modifier = Modifier::resolveDataModifier($attribute, $loop, $data, $child);

                if ($modifier && $modifier->shouldRender()) {
                    return $modifier->classes();
                }
            })
            ->filter()
            ->merge($registeredClasses)
            ->prepend($this->attributes->get('narrow') ? 'py-2' : 'py-5')
            ->prepend('px-2 whitespace-nowrap')
            ->unique()
            ->join(' ');

        return new HtmlString($classes ? "class=\"{$classes}\"" : '');
    }
}
