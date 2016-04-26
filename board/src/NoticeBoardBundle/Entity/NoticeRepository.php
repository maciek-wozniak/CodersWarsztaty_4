<?php

namespace NoticeBoardBundle\Entity;

use Doctrine\ORM\EntityRepository;

class NoticeRepository extends EntityRepository {

    public function findNotExpiredNotices() {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n WHERE n.expirationDate >= :dateNow ORDER BY n.expirationDate'
        )->setParameter('dateNow', new \DateTime())->getResult();
    }

    public function findExpiredNotices() {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n WHERE n.expirationDate < :dateNow ORDER BY n.expirationDate DESC'
        )->setParameter('dateNow', new \DateTime())->getResult();
    }

    public function findNotExpiredNoticesById($category) {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n
             JOIN n.categories c
             WHERE
             c.id= :id AND
             n.expirationDate >= :dateNow ORDER BY n.expirationDate'
        )->setParameter('dateNow', new \DateTime())->setParameter('id', $category)->getResult();
    }

    public function findNotExpiredNoticesByUser($user) {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n
             JOIN n.user u
             WHERE
             u.id= :id AND
             n.expirationDate >= :dateNow ORDER BY n.expirationDate'
        )->setParameter('dateNow', new \DateTime())->setParameter('id', $user)->getResult();
    }

    public function findExpiredNoticesByUser($user) {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n
             JOIN n.user u
             WHERE
             u.id= :id AND
             n.expirationDate < :dateNow ORDER BY n.expirationDate DESC '
        )->setParameter('dateNow', new \DateTime())->setParameter('id', $user)->getResult();
    }

}