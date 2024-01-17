<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\SubscriptionsRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
class MailerService
{
    private $mailer;
    private $subscriptionsRepository;
    public function __construct(MailerInterface $mailer, SubscriptionsRepository $subscriptionsRepository)
    {
        $this->mailer = $mailer;
        $this->subscriptionsRepository=$subscriptionsRepository;
    }

    public function sendEmail():void
    {
        $arr = $this->subscriptionsRepository->findUpdPrice();
        $send_emails = 0;
        foreach ($arr as $ar){
            $name = $ar->getUserId()->getName();
            $price = $ar->getPrice();
            $email = (new Email())
                ->from('randreq@inbox.ru')
                ->to($ar->getUserId()->getEmail())
                ->subject('Price check')
                ->text("Hello $name, there are a new price on your subscribe, price: $price");
            try {
                $this->mailer->send($email);
                $send_emails += 1;
            } catch (TransportExceptionInterface $e) {
                echo "Error send\n";
            }
        }
        echo "Total: $send_emails\n";
    }
}