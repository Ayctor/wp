<?php

namespace Ayctor\Mails;

use WpCore\Mails\Mail;

/**
 * Class Example for example mail
 */
class ExampleMail extends Mail
{
    /**
     * Subject of the mail
     *
     * @var string
     */
    protected $subject = 'Example';

    /**
     * Template of the mail
     *
     * @var string
     */
    protected $template = 'mails.example';
}
