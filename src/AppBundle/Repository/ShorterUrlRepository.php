<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ShorterUrlRepository extends EntityRepository {

    public function getLastCreatedLink($max = 5) {
        $req = $this->createQueryBuilder('shorter_url')
            ->orderBy('shorter_url.id', 'DESC')
            ->setMaxResults($max);

        return $req->getQuery()->getResult();
    }

    public function getLastVisitedLink($max = 5) {
        $req = $this->createQueryBuilder('shorter_url')
            ->innerJoin('shorter_url.stats', 'stats')
            ->orderBy('stats.date', 'DESC')
            ->setMaxResults($max);

        return $req->getQuery()->getResult();
    }

    public function getMoreVisitedLink($max = 5) {
        $req = $this->createQueryBuilder('shorter_url')
            ->addSelect('count(stats.id) as countStats')
            ->leftJoin('shorter_url.stats', 'stats')
            ->groupBy('shorter_url')
            ->orderBy('countStats', 'DESC')
            ->setMaxResults($max);

        return $req->getQuery()->getScalarResult();
    }

}
