<?php

namespace App\Service;

use App\Repository\SubscriptionsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubscriptionService
{
    private $subscriptionsRepository;
    private $client;

    public function __construct(SubscriptionsRepository $subscriptionsRepository, HttpClientInterface $client)
    {
        $this->subscriptionsRepository = $subscriptionsRepository;
        $this->client = $client;

    }

    public function updPrice()
    {
        $subs = $this->subscriptionsRepository->findAll();
        $total = 0;
        foreach ($subs as $sub) {
            $url = $sub->getUrl();
            $response = $this->client->request(
                'GET',
                $url
            );
            $status = $response->getStatusCode();
            if ($status == 200) {
                $contentType = $response->getHeaders()['content-type'][0];
                if ($contentType == "application/json; charset=utf-8") {
                    $content = $response->toArray();
                    if (array_key_exists('price', $content)) {
                        $a = $this->subscriptionsRepository->update($sub->getId(), $content['price']);
                        echo $url . " - " . $content['price'] . "\n";
                        $total += 1;
                    } else {
                        echo $url . "   key price doesnt exist\n , current price: 0 ";
                    }
                } else {
                    echo $url . "  $contentType - incorrect format of content type, change url at admin panel, current price: 0 \n";
                }
            }
            else echo "$url - your status code: $status change url, current price: 0  \n";
        }
        echo "Total: $total\n";
    }


    function getResponseToShowConcreate($id)
    {
        $subscription =  $this->subscriptionsRepository->find($id);
        if (!$subscription) {
            $response = new JsonResponse(['message'=>"not found"]);
            return $response->setStatusCode("404");
        }
        $subscription->getUpdatedAt() ? $upd = $subscription->getUpdatedAt()->format("D, d M y H:i:s") : $upd = null ;
        return new JsonResponse(['id' => $subscription->getId(),
            'User_mail' => $subscription->getUserId()->getEmail(),
            'User_name' => $subscription->getUserId()->getName(),
            "price" => $subscription->getPrice(),
            "url" => $subscription->getUrl(),
            "created_at" => $subscription->getCreatedAt()->format("D, d M y H:i:s"),
            "updated_at" => $upd
        ]);
    }
}