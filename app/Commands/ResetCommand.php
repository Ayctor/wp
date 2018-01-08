<?php

namespace Ayctor\Commands;

/**
 * Class ResetCommand to reset values
 */
class ResetCommand extends \WP_CLI_Command
{
    /**
     * Command to reset OpCache
     */
    public function opcache()
    {
        opcache_reset();
        \WP_CLI::log('OpCache reset');
    }
}
