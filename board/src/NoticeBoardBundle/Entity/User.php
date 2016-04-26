<?php

namespace NoticeBoardBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use NoticeBoardBundle\Entity\Notice;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Notice", mappedBy="user")
     */
    private $notices;

    public function __construct() {
        parent::__construct();
        $this->notices = new ArrayCollection();
    }

    /**
     * Add notices
     *
     * @param Notice $notices
     * @return User
     */
    public function addNotice(Notice $notices) {
        $this->notices[] = $notices;

        return $this;
    }

    /**
     * Remove notices
     *
     * @param Notice $notices
     */
    public function removeNotice(Notice $notices) {
        $this->notices->removeElement($notices);
    }

    /**
     * Get notices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotices() {
        return $this->notices;
    }
}
