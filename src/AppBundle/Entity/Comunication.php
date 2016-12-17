<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comunication
 *
 * @ORM\Table(name="comunication")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComunicationRepository")
 */
class Comunication
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="sender_id", type="integer")
     */
    private $senderId;

    /**
     * @var int
     *
     * @ORM\Column(name="recipient_id", type="integer")
     */
    private $recipientId;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_new", type="boolean")
     */
    private $isNew;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set senderId
     *
     * @param integer $senderId
     *
     * @return Comunication
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;

        return $this;
    }

    /**
     * Get senderId
     *
     * @return int
     */
    public function getSenderId()
    {
        return $this->senderId;
    }

    /**
     * Set recipientId
     *
     * @param integer $recipientId
     *
     * @return Comunication
     */
    public function setRecipientId($recipientId)
    {
        $this->recipientId = $recipientId;

        return $this;
    }

    /**
     * Get recipientId
     *
     * @return int
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Comunication
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Comunication
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return bool
     */
    public function getIsNew()
    {
        return $this->isNew;
    }
}

