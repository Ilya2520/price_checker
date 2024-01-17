<?php

namespace App\Service;

use App\Repository\SubscriptionsRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
}