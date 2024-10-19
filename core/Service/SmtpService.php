<?php

namespace Core\Service;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SmtpService
{
    /**
     * Email of sender.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new smtp service instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $configuration = config('mail.mailers.smtp');

        $this->from = $configuration['username'];
    }

    /**
     * Create a new mailable instance.
     *
     * @param  object|array|string    $from
     * @param  object|array|string    $to
     * @param  string                 $subject
     * @param  array<string, string>  $options
     * @return \Illuminate\Mail\Mailable
     */
    protected function mailable($from, $to, $subject, array $options = [])
    {
        $mailable = (new Mailable)->from($from)->to($to)->subject($subject);

        if (array_key_exists('text', $options)) {
            $mailable = $mailable->text($options['text']);
        } elseif (array_key_exists('html', $options)) {
            $mailable = $mailable->html($options['html']);
        }

        return $mailable;
    }

    /**
     * Send a message text to the recipient.
     *
     * @param  object|array|string  $to
     * @param  object|array|string  $subject
     * @param  string               $text
     * @return \Illuminate\Mail\SentMessage|null
     */
    public function sendText(string $to, string $subject = '', string $text = '')
    {
        return Mail::send($this->mailable($this->from, $to, $subject, ['text' => $text]));
    }

    /**
     * Send a message html to the recipient.
     *
     * @param  object|array|string  $to
     * @param  object|array|string  $subject
     * @param  string               $text
     * @return \Illuminate\Mail\SentMessage|null
     */
    public function sendHtml(string $to, string $subject = '', string $html = '')
    {
        return Mail::send($this->mailable($this->from, $to, $subject, ['html' => $html]));
    }
}