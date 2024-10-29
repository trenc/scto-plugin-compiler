<?php

declare(strict_types=1);

namespace Scto\PluginCompiler;

class PluginData
{
    private array $content = [];

    public function setManifest(array $manifestContent): void
    {
        $this->content = [...$manifestContent];
    }

    public function setHelp(string $help): void
    {
        $this->content['help'] = $help;
    }

    public function setTextpack(string $textpack): void
    {
        $this->content['textpack'] = $textpack;
    }

    public function setVersion(string $version): void
    {
        $this->content['version'] = $version;
    }

    public function setName(string $name): void
    {
        $this->content['name'] = $name;
    }

    public function addCode(string $code): void
    {
        $this->content['code'] = $this->content['code'] ?? '';
        $this->content['code'] .= $code . "\n\n";
    }

    public function setMd5(string $code): void
    {
        $this->content['md5'] = md5($code);
    }

    public function getCode(): string
    {
        return $this->content['code'];
    }

    public function getName(): string
    {
        return $this->content['name'];
    }

    public function getVersion(): string
    {
        return $this->content['version'];
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
