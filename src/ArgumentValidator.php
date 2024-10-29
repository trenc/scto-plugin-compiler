<?php

declare(strict_types=1);

namespace Scto\PluginCompiler;

class ArgumentValidator
{
    private array $arguments;

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
    }

    public function validate(): array
    {
        if (count($this->arguments) !== 5) {
            throw new \InvalidArgumentException('Expected 5 arguments: 3 files, 1 folder, and an output folder.');
        }

        for ($i = 0; $i <= 2; $i++) {
            if (!is_file($this->arguments[$i])) {
                throw new \InvalidArgumentException("File {$this->arguments[$i]} does not exist.");
            }
        }

        if (!is_dir($this->arguments[3])) {
            throw new \InvalidArgumentException("Folder {$this->arguments[3]} does not exist.");
        }

        $outputFolder = $this->arguments[4];
        if (!is_dir($outputFolder)) {
            mkdir($outputFolder, 0755, true);
        }

        return $this->arguments;
    }
}
