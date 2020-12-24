<?php

namespace Tovitch\BladeUI\Tests\Mocks;

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;

class Filesystem extends \Illuminate\FileSystem\FileSystem
{
    protected array $puts = [];

    public function put($path, $contents, $lock = false): self
    {
        $relativePath = Str::after($path, '/vendor/orchestra/testbench-core/');

        $this->puts[$relativePath] = $contents;

        return $this;
    }

    public function assertWrittenTo($path): self
    {
        Assert::assertArrayHasKey($path, $this->puts, "Did not write to '{$path}'");

        return $this;
    }
}
