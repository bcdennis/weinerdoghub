<?php

namespace Smile\Core\Mailers;

use Illuminate\Contracts\Mail\Mailer as MailerContract;

abstract class Mailer
{
    /**
     * @var MailerContract
     */
    private $mailer;

    /**
     * @param MailerContract $mailer
     */
    public function __construct(MailerContract $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send email
     *
     * @param $view
     * @param $data
     * @param $subject
     * @param $to
     */
    public function send($view, array $data, $subject, $to)
    {
        $this->mailer->send($view, $data, function ($message) use ($subject, $to) {
            $message->to($to)->subject($subject);
        });
    }

    /**
     * Send raw message
     *
     * @param $text
     * @param $subject
     * @param $to
     */
    public function sendRaw($text, $subject, $to)
    {
        $this->mailer->raw($text, function ($message) use ($subject, $to) {
            $message->to($to)->subject($subject);
        });
    }

}
