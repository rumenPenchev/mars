<?php

namespace AppBundle\Controller\Army;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AssetOnRoad;
use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyAssets;

class ArmiesController extends Controller
{
    /**
    * @Route("/generate-army-field", name="army-field" )
    */
    public function indexAction()
    {
        $userId = $this->getUser()->getId();
        $armyHelper = $this->get('app.GetArmies');
        $armies = $armyHelper->getMyArmies($userId);

        return $this->render('army/army.html.twig', array('armies' => $armies));
    }

    /**
     * @Route("/new-army/{armyId}", name="newArmy" )
     */
    public function resource($armyId=null)
    {
        $userId = $this->getUser()->getId();
        $resources = $this->get('app.getResources');
        $results = $resources->getMiltary($userId);
        $assets = [];
            if($armyId != null)
            {
                $em=$this->getDoctrine()->getManager();
                foreach ($results as $result) {
                    $temp = $em->getRepository('AppBundle:ArmyAssets')->findOneBy(['armyId'=> $armyId, 'descrId' => $result['id']]);
                    if ($temp){
                        $qtty = $temp->getQtty();
                    } else {
                        $qtty = 0;
                    }

                    $assets[] =
                    [
                       'id'  => $result['id'],
                       'name' => $result['name'],
                       'qtty' => $qtty
                    ];
                }
            } else {
            $assets = $results;
        }
        return $this->render(
            'army/armyResource.html.twig',
            array(
                'assets' => $assets,
                'armyId' =>$armyId
            ));
    }

    /**
     * @Route("/make-new-army/", name="make_new_army")
     */
    public function makeChange(Request $request)
    {
        //to do check Qtty
        $em=$this->getDoctrine()->getManager();
        $resources = $request->request->get('res');
        $armyId = $request->request->get('army_id');

        $userId = $this->getUser()->getId();
        if(!$armyId){
            $army = new Army();
            $army->setUserId($userId);
            $em->persist($army);
            $em->flush();
        } else{
            $army = $em->getRepository('AppBundle:Army')->findOneBy(['id' => $armyId, 'userId' => $userId]);
        }

        foreach ($resources as $resource => $qtty){
            $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['descrId' => $resource, 'userId' => $userId]);
            if(!$armyId) {
                if ($asset->getQtty() > $qtty) {
                    $armyAsset = new ArmyAssets();
                    $armyAsset->setDescrId($resource);
                    $armyAsset->setQtty($qtty);
                    $armyAsset->setArmyId($army->getId());
                    $armyAsset->setArmy($army);
                    $em->persist($armyAsset);
                    $em->flush();

                    $asset->setQtty($asset->getQtty() - $qtty);
                    $em->persist($asset);
                    $em->flush();
                }
            } else{
                $armyAsset = $em->getRepository('AppBundle:ArmyAssets')->findOneBy(['armyId' => $armyId, 'descrId' => $resource]);
                if ($armyAsset){
                    $amyAssQtty = $armyAsset->getQtty();
                    $asset->setQtty($asset->getQtty()+ $amyAssQtty - $qtty);
                    $em->persist($asset);
                    $em->flush();

                    $armyAsset->setQtty($qtty);
                    $armyAsset->setArmy($army);
                    $em->persist($armyAsset);
                    $em->flush();
                }
            }
        }

        return $this->json(array('res' => $resources));
    }

    /**
     * @Route("/disband/{armyId}", name="disband" )
     */
    public function disbandArmy($armyId=null)
    {
        $em=$this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $army = $em->getRepository('AppBundle:Army')->findOneBy(['userId' => $userId, 'id' => $armyId]);
        if($army){
            $armyAssets = $em->getRepository('AppBundle:Armyassets')->findBy(['armyId' => $armyId]);
            foreach ($armyAssets as $armyAsset){
                $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['userId'=> $userId, 'descrId' => $armyAsset->getDescrId()]);
                $asset->setQtty($asset->getQtty()+$armyAsset->getQtty());
                $em->persist($asset);
                $em->flush();
                $em->remove($armyAsset);
                $em->flush();
            }
            $em->remove($army);
            $em->flush();
            return $this->json(array('success' => 'OK'));
        }
        return $this->json(array('error' => 'problem'));
    }

    /**
     * @Route("/set-target", name="set_target" )
     */
    public function setTarget(Request $request){
        $armyId = $request->request->get('army_id');
        $target = preg_replace("/[^0-9,.\s]/", "", $request->request->get('target'));
        $userId = $this->getUser()->getId();

        $em=$this->getDoctrine()->getManager();

        $army = $em->getRepository('AppBundle:Army')->findOneBy(['userId' => $userId, 'id' => $armyId]);
        if ($army){
            $army->setTargetId($target);
            $em->persist($army);
            $em->flush();
            return $this->json(array('success' => 'OK'));
        }
        return $this->json(array('error' => 'problem'));
    }

    /**
     * @Route("/send-on-war", name="send_on_war" )
     */
    public function startWar(Request $request){
        $armyId = $request->request->get('army_id');
        $userId = $this->getUser()->getId();

        $em=$this->getDoctrine()->getManager();
        $army = $em->getRepository('AppBundle:Army')->findOneBy(['userId' => $userId, 'id' => $armyId]);
        if ($army){

            $distTimeCalc = $this->get('app.calculateDistTime');
            $interval=$distTimeCalc->calcTime($userId, $army->getTargetId());

            $now = new \DateTime("now");

            $getThere = $now->add(new \DateInterval($interval));

            $army->setGetThereOn($getThere);
            $em->persist($army);
            $em->flush();

            $getBack = $now->add(new \DateInterval($interval))->add(new \DateInterval($interval));

            $army->setGetBackOn($getBack);
            $em->persist($army);
            $em->flush();
            return $this->json(array('success' => $interval));
        }
        return $this->json(array('error' => 'problem'));
    }

}