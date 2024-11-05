<div align="right">

[![Run tests](https://github.com/trenc/scto-plugin-compiler/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/trenc/scto-plugin-compiler/actions/workflows/run-tests.yml)

</div>

# Scto Plugin Compiler

Compiler for creating installable plugin files for the [Textpattern CMS](https://textpattern.com).

## Installation

```
$ composer require scto/plugin-compiler --dev
```

## Usage

The compiler binary can has up to five arguments.

N.B.: The name of the plugin is created from the name of the current woking directory.

```
$ ./vendor/bin/scto-compile manifest.json help.textile textpack.txt srcFolder outputFolder
```

The plugin compiler can also be used as library:

```
use Scto\PluginCompiler\CompilerApp;


public $args = [
    'manifest.json', // manifest file
    'help.textile',  // help file in textile markup
    'textpack.txt',  // combined textpack file with all localisation strings
    'src',           // directory with the PHP source code
    'dist',          // directory for the compiled plugins
];

$app = new CompilerApp();
$app->run($args);
```

## Alternatives

* https://github.com/gocom/MassPlugCompiler
* https://github.com/Bloke/ied_plugin_composer
* https://github.com/alieninternet/ais_txpplugin_packager
