<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asset_descr
 *
 * @ORM\Table(name="assets_descr")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Asset_descrRepository")
 */
class Asset_descr
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var interger
     *
     * @ORM\Column(name="sort_order", type="integer")
     */
    private $sortOrder;
    /**
     * @ORM\OneToMany(targetEntity="Asset", mappedBy="asset_descr")
     */
    private $asset;

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
     * Set name
     *
     * @param string $name
     *
     * @return Assets_descr
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->assets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add asset
     *
     * @param \AppBundle\Entity\Asset $asset
     *
     * @return Asset_descr
     */
    public function addAsset(\AppBundle\Entity\Asset $asset)
    {
        $this->assets[] = $asset;

        return $this;
    }

    /**
     * Remove asset
     *
     * @param \AppBundle\Entity\Asset $asset
     */
    public function removeAsset(\AppBundle\Entity\Asset $asset)
    {
        $this->assets->removeElement($asset);
    }

    /**
     * Get assets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsset()
    {
        return $this->asset;
    }
}
