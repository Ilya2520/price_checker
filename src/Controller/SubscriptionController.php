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
    #[Route('api/subscription/{id}', name: 'subscription')]
    public function shows($id, SubscriptionService $subscriptionsService)
    {
        $json =  $subscriptionsService->subscriptionToJson($id);
        $response = new JsonResponse($json['message']);
        return $response->setStatusCode($json['status']);
    }
}
