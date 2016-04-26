<?php

namespace NoticeBoardBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use NoticeBoardBundle\Entity\Category;
use NoticeBoardBundle\Entity\Comment;
use NoticeBoardBundle\Entity\Picture;
use NoticeBoardBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="NoticeBoardBundle\Entity\NoticeRepository")
 */
class Notice {

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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=5, max=255)
     *
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=10)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration_date", type="datetime")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\DateTime()
     */
    private $expirationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="notices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="notices")
     */
    private $categories;

    /**
     * @ORM\OneToOne(targetEntity="Picture")
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="notice", cascade={"remove"})
     */
    private $comments;

    /**
     * Constructor
     */
    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Notice
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Notice
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set expirationDate
     *
     * @param \DateTime $expirationDate
     * @return Notice
     */
    public function setExpirationDate($expirationDate) {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * Get expirationDate
     *
     * @return \DateTime
     */
    public function getExpirationDate() {
        return $this->expirationDate;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Notice
     */
    public function setUser(User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Add categories
     *
     * @param Category $categories
     * @return Notice
     */
    public function addCategory(Category $categories) {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $categories
     */
    public function removeCategory(Category $categories) {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Set picture
     *
     * @param Picture $picture
     * @return Notice
     */
    public function setPicture(Picture $picture = null) {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return Picture
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Set comments
     *
     * @param Comment $comments
     * @return Notice
     */
    public function setComments(Comment $comments = null) {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return Comment
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * Add comments
     *
     * @param \NoticeBoardBundle\Entity\Comment $comments
     * @return Notice
     */
    public function addComment(Comment $comments) {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \NoticeBoardBundle\Entity\Comment $comments
     */
    public function removeComment(Comment $comments) {
        $this->comments->removeElement($comments);
    }

    /**
     * @return mixed
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
    }

}
