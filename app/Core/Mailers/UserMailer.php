<?php

namespace Smile\Core\Mailers;

use Smile\Core\Persistence\Models\User;

class UserMailer extends Mailer
{

    /**
     * Send user confirmation email
     *
     * @param User $user
     */
    public function confirm(User $user)
    {
        $view = 'emails.confirm';
        $subject = 'Confirming your account';
        $email = $user->email;
        $data = ['user' => $user];

        $this->send($view, $data, $subject, $email);
    }

    /**
     * Send email for contact form
     *
     * @param array $data
     */
    public function contact(array $data)
    {
        $email = setting('email.support');
        $subject = 'Contact: '.$data['subject'];
        $view = 'emails.contact';

        $this->send($view, $data, $subject, $email);
    }

}
