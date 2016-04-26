<?php

namespace NoticeBoardBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comment {
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
     * @ORM\Column(name="comment_text", type="text")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=3)
     */
    private $commentText;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="User")
     *
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Notice", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $notice;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set notice
     *
     * @param integer $notice
     * @return Comment
     */
    public function setNotice($notice) {
        $this->notice = $notice;

        return $this;
    }

    /**
     * Get notice
     *
     * @return integer
     */
    public function getNotice() {
        return $this->notice;
    }

    /**
     * Set commentText
     *
     * @param string $commentText
     * @return Comment
     */
    public function setCommentText($commentText) {
        $this->commentText = $commentText;

        return $this;
    }

    /**
     * Get commentText
     *
     * @return string
     */
    public function getCommentText() {
        return $this->commentText;
    }

    /**
     * Set user
     *
     * @param integer $user
     * @return Comment
     */
    public function setUser(User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser() {
        return $this->user;
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
    public function setCreationDate(\DateTime $creationDate) {
        $this->creationDate = $creationDate;
    }



}
