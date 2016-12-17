<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArmyAssets
 *
 * @ORM\Table(name="army_assets")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArmyAssetsRepository")
 */
class ArmyAssets
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
     * @ORM\Column(name="qtty", type="integer", nullable=true)
     */
    private $qtty;

    /**
     * @var int
     *
     * @ORM\Column(name="army_id", type="integer", nullable=true)
     */
    private $armyId;

    /**
     * @var Army
     *
     * @ORM\ManyToOne(targetEntity="Army", inversedBy="armyAsset")
     * @ORM\JoinColumn(name="army_id", referencedColumnName="id")
     */
    private $army;
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
     * @return ArmyAssets
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
     * Set qtty
     *
     * @param integer $qtty
     *
     * @return ArmyAssets
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
     * Set armyId
     *
     * @param integer $armyId
     *
     * @return ArmyAssets
     */
    public function setArmyId($armyId)
    {
        $this->armyId = $armyId;

        return $this;
    }

    /**
     * Get armyId
     *
     * @return int
     */
    public function getArmyId()
    {
        return $this->armyId;
    }

    /**
     * Set army
     *
     * @param \AppBundle\Entity\Army $army
     *
     * @return ArmyAssets
     */
    public function setArmy(\AppBundle\Entity\Army $army = null)
    {
        $this->army = $army;

        return $this;
    }

    /**
     * Get army
     *
     * @return \AppBundle\Entity\Army
     */
    public function getArmy()
    {
        return $this->army;
    }
}
