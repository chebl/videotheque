<?php

namespace App\Services;

use Exception;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

class Mail
{
    public function sendEmail($to_email, $from, $subject, $content)
    {
        $transport = Transport::fromDsn('smtp://username:password@smtp.gmail.com');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from($from)
            ->to($to_email)
            ->subject($subject)
            ->text($content);
         try {
            $mailer->send($email);
         }
         catch(Exception $e){}
    }
}
