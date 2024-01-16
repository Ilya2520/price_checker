<?php
namespace App\Service;
use App\Repository\SubscriptionsRepository;

class SubscriptionService
{
    private $subscriptionsRepository;

    public function __construct(SubscriptionsRepository $subscriptionsRepository)
    {
        $this->subscriptionsRepository=$subscriptionsRepository;
    }

    public function getArrToEmail():array
    {
        $arr = [];
        $this->subscriptionsRepository->findByExampleField();
        return $arr;
    }

    public function updPrice()
    {

    }
}