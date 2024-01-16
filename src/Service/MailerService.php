<?php
namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\SubscriptionsRepository;
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
        $arr = $this->subscriptionsRepository->findByExampleField();
        foreach ($arr as $ar){
            $name = $ar->getUserId()->getName();
            $price = $ar->getPrice();
            $email = (new Email())
                ->from('randreq@inbox.ru')
                ->to($ar->getUserId()->getEmail())
                ->subject('Price check')
                ->text("Hello $name, there are a new price on your subscribe, price: $price");
            $this->mailer->send($email);
        }
//        $email = (new Email())
//            ->from('randreq@inbox.ru')
//            ->to('ilyaemelyanov2003@mail.ru')
//            //->cc('cc@example.com')
//            //->bcc('bcc@example.com')
//            //->replyTo('fabien@example.com')
//            //->priority(Email::PRIORITY_HIGH)
//            ->subject('Time for Symfony Mailer!')
//            ->text('Sending emails is fun again!')
//            ->html('<p>See Twig integration for better HTML integration!</p>');
//
//        $this->mailer->send($email);
    }
}