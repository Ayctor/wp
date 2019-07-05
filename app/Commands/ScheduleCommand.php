<?php

namespace Ayctor\Commands;

use WpCore\Commands\Kernel;

/**
 * Class ScheduleCommand to reset values
 */
class ScheduleCommand extends \WP_CLI_Command
{
    /**
     * Command for scheduler
     *
     * ex : * * * * * cd /path/to/project && wp schedule cron >> /dev/null 2>&1
     *
     * @return void
     */
    public function cron(): void
    {   
        $kernel = new Kernel();

        $kernel->add('wp reset opcache', '*/5 * * * *');

        $kernel->run();
    }
}
