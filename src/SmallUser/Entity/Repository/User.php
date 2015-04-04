<?php


namespace SmallUser\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use SmallUser\Entity\UserInterface;

class User extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return null|UserInterface
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUser4Id( $id )
    {
        $query = $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.usrId = :usrid')
            ->setParameter('usrid', $id)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}