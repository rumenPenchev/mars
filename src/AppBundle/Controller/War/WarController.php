<?php

namespace AppBundle\Controller\War;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AssetOnRoad;
use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyAssets;

class WarController extends Controller
{
    /**
     * @Route("/war", name="war" )
     */
    public function war(){
        $userId = $this->getUser()->getId();
        $json = [];

        $assets = $this->get('app.addAssets');
        $war = $this->get('app.war');
        $underAttack = $war->inDanger($userId);

        $warId = $war->warTime($userId);
        $em = $this->getDoctrine()->getManager();

        if($warId){

            $users = $em->getRepository('AppBundle:Army')->findOneBy(['id' => $warId]);

            $assets->addAssets($users->getUserId());
            $assets->addAssets($users->getTargetId());

            $distTimeCalc = $this->get('app.calculateDistTime');
            $interval=$distTimeCalc->calcTime($users->getUserId(), $users->getTargetId());
            $now = new \DateTime("now");
            $now = $now->add(new \DateInterval($interval));

            if($war->setTheConflict($warId)){
                //attacker Wins
                $rools = $em->getRepository('AppBundle:Setting')->findOneBy(['key'=>'assetsCostGive'])->getValue();
                foreach ($rools as $key => $rool){
                    if ($rool['production']='auto'){
                        $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['descrId' => $key, 'userId'=>$users->getTargetId()]);
                        if ($asset){
                            $assets_on_road = new  AssetOnRoad;
                            $assets_on_road->setDescrId($asset->getDescrId());
                            $assets_on_road->setUserId($users->getUserId());
                            $assets_on_road->setQtty($asset->getQtty());
                            $assets_on_road->setReadyOn($now);
                            $em->persist($assets_on_road);
                            $em->flush();

                            $asset->setQtty(0);
                            $em->persist($asset);
                            $em->flush();
                        }
                    }
                }

            } else {
                //Deffender Wins
                $armyassets= $this->em->getRepository('AppBundle:ArmyAssets')->findOneBy(['armiId' => $warId]);
                foreach ($armyAssets as $armyAsset) {
                    $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['descrId' => $armyAsset->qetDescrId(), 'userId' => $users->getTargetId()]);
                    $asset->setQtty($armyAsset->getQtty());
                    $em->persist($asset);
                    $em->flush();

                    $em->remove($armyAsset);
                    $em->flush();
                }
                $army= $this->em->getRepository('AppBundle:Army')->findOneBy(['id' => $warId]);
                $em->remove($army);
                $em->flush();
            }
        }

        $now = new \DateTime("now");
        $army= $em->getRepository('AppBundle:Army')->findOneBy(['userId' => $userId]);

        if($army){
            if($army->getGetBackOn()< $now){
                $army->setGetBackOn(null);
                $em->persist($army);
                $em->flush();
            }
        }

        if ($underAttack){
            $json['danger'] = 'ENEMY '. $underAttack . ' IS ATTACKING UOU!!!';
        }

        return $this->json($json);
    }

}