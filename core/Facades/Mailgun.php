<?php

namespace Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Mailgun\Model\Message\SendResponse|\Psr\Http\Message\ResponseInterface sendText(string $to, string $subject = '', string $text = '')
 * @method static \Mailgun\Model\Message\SendResponse|\Psr\Http\Message\ResponseInterface sendHtml(string $to, string $subject = '', string $html = '')
 *
 * @see \Core\Service\MailgunService
 */
class Mailgun extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'core.service.mailgun';
    }
}