<?php

declare(strict_types=1);

namespace Scto\PluginCompiler;

use Scto\PluginCompiler\Interfaces\ProcessorInterface;

class FileProcessor implements ProcessorInterface
{
    private PluginData $pluginData;

    public function __construct(PluginData $pluginData)
    {
        $this->pluginData = $pluginData;
    }

    public function process(string $filePath, ?string $type = null): void
    {
        $content = file_get_contents($filePath);

        switch ($type) {
            case 'manifest':
                $manifest = json_decode(file_get_contents($filePath), true);
                $this->pluginData->setManifest($manifest);
                break;
            case 'help':
                $parser = new \Netcarver\Textile\Parser('html5');
                $help = @$parser->parse(file_get_contents($filePath));
                $this->pluginData->setHelp($help);
                break;
            case 'textpack':
                $textpack = file_get_contents($filePath);
                $this->pluginData->setTextpack($textpack);
                break;
            case 'code':
                $code = $this->processCode(file_get_contents($filePath));
                $this->pluginData->addCode($code);
                break;
            default:
                break;
        }
    }

    private function processCode(string $code): string
    {
        static $pass = 0;

        $strictPattern = '/\s*declare\s*\(\s*strict_types\s*=\s*1\s*\)\s*;\s*/i';

        $code = trim($code);
        $code = mb_substr($code, 0, 5) === '<?php' ? mb_substr($code, 5) : $code;
        $code = mb_substr($code, -2, 2) === '?>' ? mb_substr($code, 0, -2) : $code;

        // leave first strict_type declaration in place
        if ($pass > 0 && preg_match($strictPattern, $code)) {
            $code = preg_replace($strictPattern, '', $code);
        }

        $pass++;

        return trim($code);
    }
}
