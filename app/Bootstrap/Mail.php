<?php

namespace Ayctor\Bootstrap;

/**
 * Class Mail for smtp parameters
 */
class Mail
{
    /**
     * Actions and filters to edit smtp parameters
     */
    public function __construct()
    {
        add_action('phpmailer_init', [$this, 'smptCredentials']);
        add_filter('wp_mail_from', [$this, 'setMailFromAddress']);
        add_filter('wp_mail_from_name', [$this, 'setMailFromName']);
    }

    /**
     * Edit smtp parameters
     * @param  \PHPMailer $mail PHPMailer instance
     * @return \PHPMailer       Edited PHPMailer instance
     */
    public function smptCredentials(\PHPMailer $mail)
    {
        $mail->IsSMTP();
        $mail->SMTPAuth = env('MAIL_USERNAME') && env('MAIL_PASSWORD');

        $mail->Host = env('MAIL_HOST');
        $mail->Port = env('MAIL_PORT', 587);
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');

        return $mail;
    }

    /**
     * Set mail from address
     */
    public function setMailFromAddress()
    {
        define('MAIL_FROM_ADDRESS', env('MAIL_FROM_ADDRESS'));
        return MAIL_FROM_ADDRESS;
    }

    /**
     * Set mail from name
     */
    public function setMailFromName()
    {
        define('MAIL_FROM_NAME', env('MAIL_FROM_NAME'));
        return MAIL_FROM_NAME;
    }
}
