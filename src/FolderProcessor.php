<?php

declare(strict_types=1);

namespace Yab\PluginCompiler;

use Yab\PluginCompiler\Interfaces\ProcessorInterface;

class FolderProcessor implements ProcessorInterface
{
    private PluginData $pluginData;
    private FileProcessor $fileProcessor;

    public function __construct(PluginData $pluginData)
    {
        $this->pluginData = $pluginData;
        $this->fileProcessor = new FileProcessor($pluginData);
    }

    public function process(string $folderPath): void
    {
        $dir = new \RecursiveDirectoryIterator($folderPath, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($dir, \RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $this->fileProcessor->process($file->getPathname(), 'code');
        }
    }
}
