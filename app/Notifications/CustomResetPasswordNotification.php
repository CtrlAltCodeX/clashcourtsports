<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends BaseResetPassword
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the reset password email message.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Password Reset- Clash Court Sports') // Custom Subject
            ->greeting('Hello!') // Custom Greeting
            ->line('Dear User,  Thank you for reaching out to us. Your password reset link is:')
            ->action('Reset Password', $resetUrl) // Custom Reset Link
            ->line('Kindly login and change your password. For any further questions feel free to reach out to us at support@clashcourtsports.com. See you on the courts!.')
            ->salutation('Sincerely, Clash Court Sports Team');
    }
}
