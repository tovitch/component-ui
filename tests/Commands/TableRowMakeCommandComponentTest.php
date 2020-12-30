<?php

namespace Tovitch\BladeUI\Tests\Commands;

use Illuminate\Support\Str;
use PHPUnit\Framework\Assert;
use Tovitch\BladeUI\Tests\ComponentTestCase;
use Illuminate\Filesystem\Filesystem;
use Tovitch\BladeUI\Tests\Mocks\Filesystem as FilesystemMock;
use Tovitch\BladeUI\Commands\TableRowMakeCommand;

class TableRowMakeCommandComponentTest extends ComponentTestCase
{
    protected $filesystem;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystem = new FilesystemMock;

        $this->app
            ->when(TableRowMakeCommand::class)
            ->needs(Filesystem::class)
            ->give(function () {
                return $this->filesystem;
            });
    }

    /** @test */
    public function it_can_make_a_new_table_row_class()
    {
        $this->artisan('make:table-row', ['name' => 'UserInformationRow'])
            ->assertExitCode(0);

        $this->filesystem->assertWrittenTo('laravel/app/View/TableRows/UserInformationRow.php');
    }
}
