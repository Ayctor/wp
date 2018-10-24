<?php

namespace Ayctor\Utils;

/**
 * Utils functions for front and back
 */
class Bugsnag
{
    /**
     * Initialize Bugsnag
     *
     * @return void
     */
    public static function init(): void
    {
        if (getenv('BUGSNAG_API_KEY')) {
            $bugsnag = \Bugsnag\Client::make(getenv('BUGSNAG_API_KEY'));
            $bugsnag->setReleaseStage(getenv('WP_ENV') ?: 'prod');

            if (function_exists('shell_exec')) {
                $bugsnag->setAppVersion(static::getCurrentGitVersion());
            }

            $bugsnag->registerCallback(function ($report) {
                if (is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    $report->setUser([
                        'id' => $current_user->ID,
                        'name' => $current_user->display_name,
                        'email' => $current_user->user_email,
                    ]);
                } else {
                    $report->setUser([
                        'id' => $_SERVER['REMOTE_ADDR'],
                        'name' => 'anonymous',
                    ]);
                }
            });

            \Bugsnag\Handler::register($bugsnag);
        }
    }

    /**
     * Get the current Git version
     *
     * @return string
     */
    public static function getCurrentGitVersion(): string
    {
        if (is_dir(get_template_directory() . '/.git')) {
            return trim(shell_exec('cd ' . get_template_directory() . '/ && git rev-parse --verify HEAD'));
        }

        return '';
    }
}
