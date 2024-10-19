<?php

namespace Core\Service;

use Mailgun\Mailgun;
use Psr\Http\Client\ClientInterface;

class MailgunService
{
    /**
     * Domain of mail gun.
     *
     * @var string
     */
    protected $domain;

    /**
     * The secret key of the mail gun.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Email of sender.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new mail gun service instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $configuration = config('mail.mailers.mailgun');

        $this->domain = $configuration['domain'];
        $this->apiKey = $configuration['secret'];
        $this->from = $configuration['username'];
    }

    /**
     * Create a new mail gun instance.
     *
     * @return \Mailgun\Mailgun
     */
    protected function mailgun()
    {
        return Mailgun::create($this->apiKey);
    }

    /**
     * Send a message text to the recipient.
     *
     * @param  string  $to
     * @param  string  $subject
     * @param  string  $text
     * @return \Mailgun\Model\Message\SendResponse|\Psr\Http\Message\ResponseInterface
     * 
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function sendText(string $to, string $subject = '', string $text = '')
    {
        try {
            $parameters = [
                'from' => $this->from,
                'to' => $to,
                'subject' => $subject,
                'text' => $text,
            ];
    
            return $this->mailgun()->messages()->send(
                $this->domain, $parameters
            );
        } catch (ClientInterface $e) {

        }
    }

    /**
     * Send a message html to the recipient.
     *
     * @param  string  $to
     * @param  string  $subject
     * @param  string  $html
     * @return \Mailgun\Model\Message\SendResponse|\Psr\Http\Message\ResponseInterface
     * 
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function sendHtml(string $to, string $subject = '', string $html = '')
    {
        try {
            $parameters = [
                'from' => $this->from,
                'to' => $to,
                'subject' => $subject,
                'html' => $html,
            ];
    
            return $this->mailgun()->messages()->send(
                $this->domain, $parameters
            );
        } catch (ClientInterface $e) {

        }
    }
}