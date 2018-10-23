<?php

namespace Ayctor\Commands;

/**
 * Class ResetCommand to reset values
 */
class ResetCommand extends \WP_CLI_Command
{
    /**
     * Command to reset OpCache
     *
     * @return void
     */
    public function opcache(): void
    {
        opcache_reset();
        \WP_CLI::log('OpCache reset');
    }
}
