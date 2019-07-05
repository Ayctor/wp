<?php

require __DIR__ . '/vendor/autoload.php';

// Load Bootstrap
new \Ayctor\Bootstrap;

// Load Commands
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('reset', Ayctor\Commands\ResetCommand::class);
    WP_CLI::add_command('schedule', Ayctor\Commands\ScheduleCommand::class);
}

// Load Models
new \Ayctor\Models\Example;

// Load Shortcodes
new \Ayctor\Shortcodes\ExampleShortcode;

// Load Pages
new \Ayctor\Pages\ExamplePage;
