<?php

declare(strict_types=1);

namespace Yab\PluginCompiler;

class CompilerApp
{
    private PluginData $pluginData;

    public function __construct()
    {
        $this->pluginData = new PluginData();
    }

    public function run(array $args): void
    {
        $validator = new ArgumentValidator($args);
        $validatedArgs = $validator->validate();

        [$manifest, $help, $textpack, $src, $dist] = $validatedArgs;

        $fileProcessor = new FileProcessor($this->pluginData);
        $fileProcessor->process($manifest, 'manifest');
        $fileProcessor->process($help, 'help');
        $fileProcessor->process($textpack, 'textpack');

        $folderProcessor = new FolderProcessor($this->pluginData);
        $folderProcessor->process($src);

        $name = basename(dirname($manifest));
        $this->pluginData->setName($name);

        $code = $this->pluginData->getCode();
        $this->pluginData->setMd5($code);

        $compiler = new Compiler($this->pluginData);

        $compiled = $compiler->compile();
        $compiledZip = $compiler->compile(true);

        $this->saveToDisk($compiled, $dist);
        $this->saveToDisk($compiledZip, $dist, true);
    }

    public function saveToDisk(string $content, string $folder, bool $zip = false): void
    {
        $name = $this->pluginData->getName();
        $version = $this->pluginData->getVersion();

        $fileName = $zip
            ? "{$name}_{$version}.txt"
            : "{$name}_{$version}_zip.txt";

        file_put_contents($folder . '/' . $fileName, $content);
    }
}
