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

    public function sendEmail()
    {
        $res = [];
        $arr = $this->subscriptionsRepository->findByExampleField();
        foreach ($arr as $ar){
             $res[]= [$ar->getUserId()->getEmail(),$ar->getUserId()->getEmail(), $ar->getPrice() ];
        }
        foreach($res as $a){
            echo "$a[0], $a[1], $a[2] \n" ;
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

        return "send";
    }
}