<?php

namespace NoticeBoardBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NoticeBoardBundle\Entity\Notice;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Name cannot be empty")
     * @Assert\NotNull(message="Name cannot be empty")
     * @Assert\Length(min=3, max=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Notice", mappedBy="categories")
     */
    private $notices;

    /**
     * Constructor
     */
    public function __construct() {
        $this->notices = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Add notices
     *
     * @param Notice $notices
     * @return Category
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
