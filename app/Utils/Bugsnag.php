<?php

namespace Ayctor\Utils;

/**
 * Utils functions for front and back
 */
class Bugsnag
{
    use Singleton;

    public $bugsnag;

    /**
     * Initialize Bugsnag
     *
     * @return void
     */
    private function __construct()
    {
        if (env('BUGSNAG_API_KEY')) {
            $this->bugsnag = \Bugsnag\Client::make(env('BUGSNAG_API_KEY'));

            $this->bugsnag->setReleaseStage(env('WP_ENV', 'production'));
            $this->bugsnag->setAppVersion($this->getCurrentGitVersion());

            $this->bugsnag->registerCallback(function ($report) {
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

            \Bugsnag\Handler::register($this->bugsnag);
        }
    }

    /**
     * Get the current Git version
     *
     * @return string
     */
    private function getCurrentGitVersion(): string
    {
        if (is_dir(get_template_directory() . '/.git')) {
            return trim(shell_exec('cd ' . get_template_directory() . '/ && git rev-parse --verify HEAD'));
        }

        return '';
    }
}
