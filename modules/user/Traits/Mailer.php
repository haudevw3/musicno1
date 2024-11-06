<?php

namespace Modules\User\Traits;

use Core\Facades\Smtp;
use Modules\User\Models\User;

trait Mailer
{
    /**
     * @param  \Modules\User\Models\User  $user
     * @param  array                      $options
     * @param  array                      $excepts
     * @return void
     */
    protected function sendMailToVerify(User $user, array $options = [], array $excepts = [])
    {
        if (! isset($options['subject'])) {
            $options = array_merge($options, [
                'subject' => config('user.label.EMAIL_SUBJECT_VERIFY_ACCOUNT'),
                'content' => config('user.label.EMAIL_CONTENT_VERIFY_ACCOUNT'),
                'url' => route('verify-account-page', $user->id),
                'btn_name' => 'Link xác thực của bạn',
            ]);
        }

        $options = array_merge($options, [
            'name' => $user->name,
            'token' => $user->token_send_mail
        ]);

        $subject = $options['subject'];
        $content = $options['content'];
        unset($options['subject'], $options['content']);

        if (! empty($excepts)) {
            foreach ($excepts as $key) {
                $options[$key] = '';
            }
        }

        Smtp::sendHtml(
            $user->email, $subject,
            template_email($subject, $content, $options)
        );
    }
}