<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
class MailerService
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($name, $price, $mailTo):bool
    {
        $email = (new Email())
                ->from('randreq@inbox.ru')
                ->to($mailTo)
                ->subject('Price check')
                ->text("Hello $name, there are a new price on your subscribe, price: $price");
            try {
                $this->mailer->send($email);
                return true;
            } catch (TransportExceptionInterface $e) {
                return false;
            }
    }
}