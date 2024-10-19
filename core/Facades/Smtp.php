<?php

namespace Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Mail\SentMessage|null sendText(object|array|string $to, object|array|string $subject = '', string $text = '')
 * @method static \Illuminate\Mail\SentMessage|null sendHtml(object|array|string $to, object|array|string $subject = '', string $html = '')
 *
 * @see \Core\Service\SmtpService
 */
class Smtp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'core.service.smtp';
    }
}