<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Subscriptions;
use DateTimeImmutable;
use DateTimeZone;
class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $enMn= $doctrine->getManager();
        $subscription = new Subscriptions();
        $subscription->setUrl('url');
        $subscription->setPrice(100);
        $now = new DateTimeImmutable('now', new DateTimeZone('Europe/Moscow'));
        $subscription->setCreatedAt($now);
        $us= new Users();
        $us->setEmail("ilya@mail.ru");
        $us->setName("ilya emelyanov");
        $enMn->persist($us);
        $enMn->flush();
        $subscription->setUserId($us);
        $subscription->setUpdatedAt($now);

        $enMn->persist($subscription);

        // действительно выполните запросы (например, запрос INSERT)
        $enMn->flush();

        return new Response('Saved new product with id '.$subscription->getId());
    }
}
