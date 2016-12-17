<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetsOnRoad
 *
 * @ORM\Table(name="assets_on_road")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AssetOnRoadRepository")
 */
class AssetOnRoad
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
     * @ORM\Column(name="descr_id", type="integer")
     */
    private $descrId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="qtty", type="integer")
     */
    private $qtty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ready_on", type="datetime")
     */
    private $readyOn;


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
     * Set descrId
     *
     * @param integer $descrId
     *
     * @return AssetsOnRoad
     */
    public function setDescrId($descrId)
    {
        $this->descrId = $descrId;

        return $this;
    }

    /**
     * Get descrId
     *
     * @return int
     */
    public function getDescrId()
    {
        return $this->descrId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return AssetsOnRoad
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set qtty
     *
     * @param integer $qtty
     *
     * @return AssetsOnRoad
     */
    public function setQtty($qtty)
    {
        $this->qtty = $qtty;

        return $this;
    }

    /**
     * Get qtty
     *
     * @return int
     */
    public function getQtty()
    {
        return $this->qtty;
    }

    /**
     * Set readyOn
     *
     * @param \DateTime $readyOn
     *
     * @return AssetsOnRoad
     */
    public function setReadyOn($readyOn)
    {
        $this->readyOn = $readyOn;

        return $this;
    }

    /**
     * Get readyOn
     *
     * @return \DateTime
     */
    public function getReadyOn()
    {
        return $this->readyOn;
    }
}

