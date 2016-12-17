<?php

namespace AppBundle\Helpers;

use AppBundle\Entity\Asset;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;
class SetAssets
{
    private $em;

    /**
     *
     * @var EntityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function newUsetAssets($userID){

        $now = new \DateTime("now");

        //People
        $asset = new Asset();
        $asset->getDescrId(1);
        $asset->setQtty(5);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(1));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();

        //Oxygen
        $asset = new Asset();
        $asset->getDescrId(2);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(2));
        $asset->setInProdSince($now);
        $asset->setInProduction(rand(5, 10));
        $this->em->persist($asset);
        $this->em->flush();

        //Water
        $asset = new Asset();
        $asset->getDescrId(3);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(3));
        $asset->setInProdSince($now);
        $asset->setInProduction(rand(1,3));
        $this->em->persist($asset);
        $this->em->flush();

        //Food
        $asset = new Asset();
        $asset->getDescrId(4);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(4));
        $asset->setInProdSince($now);
        $asset->setInProduction(rand(1,3));
        $this->em->persist($asset);
        $this->em->flush();

        //Tank
        $asset = new Asset();
        $asset->getDescrId(5);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(5));
        $asset->setInProduction(1);
        $this->em->persist($asset);
        $this->em->flush();

        //Aircraft
        $asset = new Asset();
        $asset->getDescrId(6);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(6));
        $asset->setInProduction(1);
        $this->em->persist($asset);
        $this->em->flush();

        //Gold
        $asset = new Asset();
        $asset->getDescrId(7);
        $asset->setQtty(0);
        $asset->setLevel(-1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(7));
        $asset->setInProdSince($now);
        $asset->setInProduction(rand(1,3));
        $this->em->persist($asset);
        $this->em->flush();

        //Well
        $asset = new Asset();
        $asset->getDescrId(8);
        $asset->setQtty(1);
        $asset->setLevel(1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(8));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();

        //Greenery
        $asset = new Asset();
        $asset->getDescrId(9);
        $asset->setQtty(1);
        $asset->setLevel(1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(9));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();

        //Mine
        $asset = new Asset();
        $asset->getDescrId(10);
        $asset->setQtty(1);
        $asset->setLevel(1);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(10));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();

        //Tank Factory
        $asset = new Asset();
        $asset->getDescrId(11);
        $asset->setQtty(0);
        $asset->setLevel(0);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(11));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();

        //Aircraft Facory
        $asset = new Asset();
        $asset->getDescrId(12);
        $asset->setQtty(0);
        $asset->setLevel(0);
        $asset->setUserId($userID);
        $asset->setAssetDescr($this->em->getRepository('AppBundle:Asset_descr')->find(12));
        $asset->setInProduction(0);
        $this->em->persist($asset);
        $this->em->flush();
    }
}
