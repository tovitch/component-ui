<?php

namespace Tovitch\BladeUI\View\Components\Table\Modifiers;

use Tovitch\BladeUI\View\Components\Table\TableColumn;

abstract class Modifier
{
    protected static array $rowModifiers = [];
    protected static array $dataModifiers = [];
    protected string $attribute;
    protected object $loop;
    protected $data;
    protected ?TableColumn $child;

    /**
     * Modifier constructor.
     *
     * @param  string  $attribute
     * @param  object  $loop
     * @param $data
     * @param $child
     */
    public function __construct(string $attribute, object $loop, $data, $child = null)
    {
        $this->loop = $loop;
        $this->data = $data;
        $this->attribute = $attribute;
        $this->child = $child;
    }

    public static function resolveRowModifier(string $attribute, object $loop, $data, $child)
    {
        return static::resolve($attribute, $loop, $data, $child, 'row');
    }

    /**
     * Resolve the modifier.
     *
     * @param  string  $attribute
     * @param  object  $loop
     * @param  mixed  $data
     * @param $child
     * @param  string  $element
     *
     * @return static|null
     */
    public static function resolve(string $attribute, object $loop, $data, $child, $element)
    {
        $class = '\\Tovitch\\BladeUI\\View\\Components\\Table\\Modifiers\\'
            . ucfirst($element)
            . '\\'
            . ucfirst($attribute)
            . 'Modifier';

        if (! class_exists($class)) {
            return null;
        }

        return new $class($attribute, $loop, $data);
    }

    public static function resolveDataModifier(string $attribute, object $loop, $data, $child)
    {
        return static::resolve($attribute, $loop, $data, $child, 'data');
    }

    public static function registerRowModifier(string $modifier)
    {
        static::$rowModifiers[] = $modifier;
    }

    public static function registerDataModifier(string $modifier)
    {
        static::$dataModifiers[] = $modifier;
    }

    public static function getRowModifiers()
    {
        return static::$rowModifiers;
    }

    public static function getDataModifiers()
    {
        return static::$dataModifiers;
    }

    /**
     * Determines if the modifier should be rendered on the row.
     *
     * @return bool
     */
    public function shouldRender(): bool
    {
        return true;
    }

    /**
     * The classes to add to the row.
     *
     * @return string
     */
    abstract public function classes(): string;
}
