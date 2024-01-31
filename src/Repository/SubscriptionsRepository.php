<?php

namespace App\Repository;

use App\Entity\Subscriptions;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subscriptions>
 *
 * @method Subscriptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscriptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscriptions[]    findAll()
 * @method Subscriptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscriptions::class);
    }

    public function findNewUpdatedPrice(): array
    {
        $arr = $this->createQueryBuilder('s')
            ->andWhere('s.price > 0 and s.updatedAt is not null')
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult();
        return $arr;
    }

    public function updateSelectedPrice($id, $price)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "
            update App\Entity\Subscriptions as p 
            SET p.price = $price, p.updatedAt = CURRENT_TIMESTAMP()
            where p.id = $id
            "
        );
        return $query->getResult();
    }
}
