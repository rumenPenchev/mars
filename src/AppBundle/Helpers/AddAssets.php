<?php

namespace AppBundle\Helpers;

use AppBundle\Entity\Asset;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints\DateTime;
class AddAssets
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

    public function addAssets($userId){

        $now = new \DateTime("now");

        $rools = $this->em->getRepository('AppBundle:Setting')->findOneBy(["key"=>'assetsCostGive'])->getValue();

        $assets = $this->em->getRepository('AppBundle:Asset_descr')->findAll();
        foreach ($assets as $asset){

            $theAsset = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId'=>$userId, 'descrId'=>$asset->getId()]);
            if (isset($theAsset)) {
                if ($theAsset->getInProdSince() !== null)
                {
                    //Ptoduction Level Factor
                    $prodLevelFactor = 1;
                    if (isset($rools[$asset->getId()]['origin'])){
                        $origin = $rools[$asset->getId()]['origin'];
                        $originLevel = $available = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userId, 'descrId' => $origin])->getLevel();
                        $productivityToLevelFactor = $this->em->getRepository('AppBundle:Setting')->findOneBy(["key"=>'productivityToLevel'])->getValue()['productivityToLevel'];
                        for($i=2; $i<=$originLevel; $i += 1){
                            $prodLevelFactor = floatval($prodLevelFactor) * floatval($productivityToLevelFactor);
                        }
                    }

                    if ($now->format('U') - $theAsset->getInProdSince()->format('U') > ($rools[$asset->getId()]['time'] *$prodLevelFactor)) {

                        $timeIntervals = 1;
                        if ($rools[$asset->getId()]['production'] == 'auto') {
                            $timeIntervals = ($now->format('U') - $theAsset->getInProdSince()->format('U')) / ($rools[$asset->getId()]['time'] * $prodLevelFactor );
                        }
                        $qtty = $theAsset->getInProduction() * $timeIntervals;

                        $hasResorses = true;
                        foreach ($rools[$asset->getId()]['costs'] as $key => $costs) {
                            $available = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userId, 'descrId' => $key])->getQtty();
                            if (!$available || ($available - $qtty * $costs) < 0) {
                                $hasResorses = false;
                                break;
                            }
                        }

                        if ($hasResorses) {
                            foreach ($rools[$asset->getId()]['costs'] as $key => $costs) {
                                $available = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userId, 'descrId' => $key])->getQtty();
                                $available = $available - $qtty * $costs;
                                $ingred = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userId, 'descrId' => $key]);
                                $ingred->setQtty($available);
                                $this->em->persist($ingred);
                                $this->em->flush();
                            }

                            if ($rools[$asset->getId()]['production'] != 'auto') {
                                $theAsset->setInProdSince(null);
                                $theAsset->setInProduction(0);
                            } else {
                                $theAsset->setInProdSince($now);
                            }

                            if ($theAsset->getLevel() === -1) {
                                $theAsset->setQtty($qtty + $theAsset->getQtty());
                            } else {
                                $theAsset->setLevel(1 + $theAsset->getLevel());
                                $theAsset->setQtty(1);
                                foreach ($rools[$asset->getId()]['gives'] as $give => $nomather) {
                                    $temp = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userId, 'descrId' => $give]);
                                    $temp ->setInProdSince($now);
                                    $this->em->persist($temp);
                                    $this->em->flush();
                                }
                            }
                            $this->em->persist($theAsset);
                            $this->em->flush();
                        } else {
                            $theAsset->setInProdSince($now);
                            $this->em->persist($theAsset);
                            $this->em->flush();
                        }
                    }
                }
            }
            $assetOnRoad = $this->em->getRepository('AppBundle:AssetOnRoad')->findOneBy(['userId'=>$userId, 'descrId'=>$asset->getId()]);
            if (isset($assetOnRoad)){
              if($now > $assetOnRoad->getReadyOn()){
                  $formRoadAsset = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId'=>$userId, 'descrId'=>$asset->getId()]);
                  $formRoadAsset->setQtty($formRoadAsset->getQtty() + $assetOnRoad->getQtty());
                  $this->em->persist($formRoadAsset);
                  $this->em->flush();
                  $this->em->remove($assetOnRoad);
                  $this->em->flush();
              }
            }
        }
    }
}
