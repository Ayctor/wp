<?php

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Ayctor\Commands\BlueprintCommand;
use Ayctor\Commands\ResetCommand;

require __DIR__ . '/vendor/autoload.php';

// Better errors
if (defined('WP_DEBUG') && WP_DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

// Load Dotenv
try {
    (new Dotenv(__DIR__))->load();
} catch (InvalidPathException $e) {
    //
}

// Load Bootstrap
new \Ayctor\Bootstrap\Blade;
new \Ayctor\Bootstrap\Bootstrap;
new \Ayctor\Bootstrap\Mail;
new \Ayctor\Bootstrap\Plugin;

// Load Commands
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('blueprint', BlueprintCommand::class);
    WP_CLI::add_command('reset', ResetCommand::class);
}

// Load Models
new \Ayctor\Models\Example;

// Load Shortcodes
