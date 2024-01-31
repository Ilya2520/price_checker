<?php

namespace App\Service;

use App\Repository\SubscriptionsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SubscriptionService
{
    private $subscriptionRepository;

    public function __construct(SubscriptionsRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    function subscriptionToJson($id)
    {
        $subscription = $this->subscriptionsRepository->find($id);
        if (!$subscription) {
            return
                [
                    "status" => 404,
                    'message' => "not found"
                ];
        }

        $subscription->getUpdatedAt() ? $upd = $subscription->getUpdatedAt()->format("D, d M y H:i:s") : $upd = null;
        return [
            "status" => 200,
            "message" =>
                [
                    'id' => $subscription->getId(),
                    'User_mail' => $subscription->getUserId()->getEmail(),
                    'User_name' => $subscription->getUserId()->getName(),
                    "price" => $subscription->getPrice(),
                    "url" => $subscription->getUrl(),
                    "created_at" => $subscription->getCreatedAt()->format("D, d M y H:i:s"),
                    "updated_at" => $upd
                ]
        ];
    }

}