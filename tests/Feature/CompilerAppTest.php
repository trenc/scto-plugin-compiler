<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use Scto\PluginCompiler\CompilerApp;
use InvalidArgumentException;

class CompilerAppTest extends TestCase
{
    public $pluginName = 'my_plugin';

    public $fixturesPath = '/tests/Fixtures';

    public $args = [
        'manifest.json',
        'README.textile',
        'textpack.txt',
        'src',
        'dist',
    ];

    public function setUp(): void
    {
        $this->args = array_map(function ($item) {
            return getcwd() . $this->fixturesPath . '/' . $this->pluginName . '/' . $item;
        }, $this->args);
    }

    public function testThrowsExceptionWhenArgumentIsMissing(): void
    {
        $args = $this->args;
        unset($args[3]);
        $app = new CompilerApp();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected 5 arguments: 3 files, 1 folder, and an output folder.');

        $app->run($args);
    }

    public function testThrowsExceptionWhenFileArgumentIsInvalid(): void
    {
        $args = $this->args;
        $args[1] = 'does-not-exists.';
        $app = new CompilerApp();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File $args[1] does not exist.");

        $app->run($args);
    }

    public function testThrowsExceptionWhenSrcArgumentIsInvalid(): void
    {
        $args = $this->args;
        $args[3] = 'wrong-src';
        $app = new CompilerApp();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Folder $args[3] does not exist.");

        $app->run($args);
    }

    public function testCompilerCompilesSuccessfully(): void
    {
        $args = $this->args;
        $expected = file_get_contents(
            getcwd() . $this->fixturesPath . "/expected/{$this->pluginName}_0.1.0.txt",
        );
        $expectedZip = file_get_contents(
            getcwd() . $this->fixturesPath . "/expected/{$this->pluginName}_0.1.0_zip.txt",
        );
        $app = new CompilerApp();

        $app->run($args);

print_r($app);
        $compiled = file_get_contents($this->args[4] . "/{$this->pluginName}_0.1.0.txt");
print_r($compiled);
        $compiledZip = file_get_contents($this->args[4] . "/{$this->pluginName}_0.1.0_zip.txt");

        $this->assertTrue(($compiled === $expected));
        $this->assertTrue(($compiledZip === $expectedZip));
    }
}
