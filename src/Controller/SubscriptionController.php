<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\SubscriptionsRepository;
use App\Service\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Subscriptions;
use Twig\Environment;
use Symfony\Component\HttpFoundation\JsonResponse;
class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'subscriptions')]
    public function index(SubscriptionsRepository $subscriptionsRepository): Response
    {
        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptionsRepository->findAll(),
        ]);

    }
    #[Route('/subscription/{id}', name: 'subscription')]
    public function show(Environment $twig, Subscriptions $subscription): Response
    {
        return new Response($twig->render('subscription/show.html.twig', [
            'subscription' => $subscription,
        ]));
    }
    #[Route('api/subscription/{id}', name: 'subscription')]
    public function shows($id, SubscriptionService $subscriptionsService)
    {
        return $subscriptionsService->getResponseToShowConcreate($id);
    }
}
