<?php

namespace App\Service;

use App\Repository\SubscriptionsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SubscriptionService
{
    function subscriptionToJson($subscription)
    {
        $subscription->getUpdatedAt() ? $upd = $subscription->getUpdatedAt()->format("D, d M y H:i:s") : $upd = null;
        return ['id' => $subscription->getId(),
            'User_mail' => $subscription->getUserId()->getEmail(),
            'User_name' => $subscription->getUserId()->getName(),
            "price" => $subscription->getPrice(),
            "url" => $subscription->getUrl(),
            "created_at" => $subscription->getCreatedAt()->format("D, d M y H:i:s"),
            "updated_at" => $upd
        ];
    }

}