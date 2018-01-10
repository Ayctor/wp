<?php

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Ayctor\Commands\ResetCommand;

require __DIR__ . '/vendor/autoload.php';

// Load Dotenv
try {
    (new Dotenv(__DIR__))->load();
} catch (InvalidPathException $e) {
    //
}

// Load Bootstrap
new \Ayctor\Bootstrap;

// Load Commands
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('reset', ResetCommand::class);
}

// Load Models
new \Ayctor\Models\Example;

// Load Shortcodes
