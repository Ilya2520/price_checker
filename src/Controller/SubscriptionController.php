<?php

namespace App\Controller;

use App\Service\SubscriptionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscriptionController extends AbstractController
{
    #[Route('api/subscription/{id}', name: 'subscription')]
    public function getConcreteSubscription($id, SubscriptionService $subscriptionsService)
    {
        $json = $subscriptionsService->subscriptionToJson($id);
        $response = new JsonResponse($json['message']);
        return $response->setStatusCode($json['status']);
    }
}
