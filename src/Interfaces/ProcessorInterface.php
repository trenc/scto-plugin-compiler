<?php

declare(strict_types=1);

namespace Yab\PluginCompiler\Interfaces;

interface ProcessorInterface
{
    public function process(string $path): void;
}
