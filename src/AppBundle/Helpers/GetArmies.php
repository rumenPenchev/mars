<?php

namespace AppBundle\Helpers;
use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyAssets;
use Doctrine\ORM\EntityManager;

class GetArmies
{
    private $em;

    /**
     *
     * @var EntityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        return $this;
    }

    public function getMyArmies($id)
    {
        if ($this->em->getRepository('AppBundle:Army')->findOneBy(['userId' => $id]))
        {
            $armies = $this->em->getRepository('AppBundle:Army')->getAvailable($id);
            foreach ($armies as $army){
                if($army->getGetThereOn() === null || $army->getGetBackOn() === null ) {
                    $armyAssets = $this->em->getRepository('AppBundle:ArmyAssets')->findBy(['armyId' => $army->getId()]);
                    foreach ($armyAssets as $armyAsset) {
                        $army->addArmyAsset($armyAsset);
                    }
                }
            }
        }else{
            return null;
        }
        return $armies;
    }

}
