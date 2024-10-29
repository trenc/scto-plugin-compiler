<?php

declare(strict_types=1);

namespace Scto\PluginCompiler\Interfaces;

interface ProcessorInterface
{
    public function process(string $path): void;
}
