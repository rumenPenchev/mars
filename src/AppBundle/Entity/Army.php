<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Army
 *
 * @ORM\Table(name="armies")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyRepository")
 */
class Army
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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="target_id", type="integer", nullable=true)
     */
    private $targetId;

    /**
     * @ORM\OneToMany(targetEntity="ArmyAssets", mappedBy="armyId")
     */
    private $armyAsset;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="get_there_on", type="datetime", nullable=true)
     */
    private $getThereOn;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="get_back_on", type="datetime", nullable=true)
     */
    private $getBackOn;


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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Army
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
     * Set targetId
     *
     * @param integer $targetId
     *
     * @return Army
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * Get targetId
     *
     * @return int
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * Set getThereOn
     *
     * @param \DateTime $getThereOn
     *
     * @return Army
     */
    public function setGetThereOn($getThereOn)
    {
        $this->getThereOn = $getThereOn;

        return $this;
    }

    /**
     * Get getThereOn
     *
     * @return \DateTime
     */
    public function getGetThereOn()
    {
        return $this->getThereOn;
    }

    /**
     * Set getBackOn
     *
     * @param \DateTime $getBackOn
     *
     * @return Army
     */
    public function setGetBackOn($getBackOn)
    {
        $this->getBackOn = $getBackOn;

        return $this;
    }

    /**
     * Get getBackOn
     *
     * @return \DateTime
     */
    public function getGetBackOn()
    {
        return $this->getBackOn;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->armyAsset = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add armyAsset
     *
     * @param \AppBundle\Entity\ArmyAssets $armyAsset
     *
     * @return Army
     */
    public function addArmyAsset(\AppBundle\Entity\ArmyAssets $armyAsset)
    {
        $this->armyAsset[] = $armyAsset;

        return $this;
    }

    /**
     * Remove armyAsset
     *
     * @param \AppBundle\Entity\ArmyAssets $armyAsset
     */
    public function removeArmyAsset(\AppBundle\Entity\ArmyAssets $armyAsset)
    {
        $this->armyAsset->removeElement($armyAsset);
    }

    /**
     * Get armyAsset
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArmyAsset()
    {
        return $this->armyAsset;
    }
}
