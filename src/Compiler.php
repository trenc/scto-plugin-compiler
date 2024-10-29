<?php

declare(strict_types=1);

namespace Yab\PluginCompiler;

class Compiler
{
    private PluginData $pluginData;

    public function __construct(PluginData $pluginData)
    {
        $this->pluginData = $pluginData;
    }

    public function compile(bool $zip = false): string
    {
        $plugin = $this->pluginData->getContent();
        $zipString = $zip ? ' (compressed)' : '';
        $types = ['Public', 'Admin/Public', 'Library', 'Admin', 'Admin/Ajax', 'Admin/Public/Ajax'];

        $header = <<<EOF
# Name:  {$plugin['name']} v{$plugin['version']}{$zipString}
# Type: {$types[$plugin['type']]} plugin
# {$plugin['description']}
# Author: {$plugin['author']}
# URL: {$plugin['author_uri']}
# Recommended load order: {$plugin['order']}
# .....................................................................
# This is a plugin for Textpattern CMS - http://textpattern.com/
# To install: textpattern > admin > plugins
# Paste the following text into the 'Install plugin' box:
# .....................................................................
EOF;

        $pluginString = serialize($plugin);
        $encodedPlugin = $zip ? base64_encode(gzencode($pluginString)) : base64_encode($pluginString);

        return $header . "\n" . chunk_split($encodedPlugin, 72);
    }
}
