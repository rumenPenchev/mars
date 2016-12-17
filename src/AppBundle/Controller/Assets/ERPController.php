<?php

namespace AppBundle\Controller\Assets;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\AssetOnRoad;

class ERPController extends Controller
{
    public function indexAction()
    {
        $userId = $this->getUser()->getId();
        $resources = $this->get('app.getResources');
        $assets = $resources->getAll($userId);

        return $this->render('assets/resources.html.twig', array('assets' => $assets));
    }

    /**
     * @Route("/resource/{id}/{enemy}", name="resource")
     */
    public function resource($id, $enemy= null)
    {
        $userId = $this->getUser()->getId();
        $resources = $this->get('app.getResources');
        $assets = $resources->getAll($userId, $id);

        return $this->render(
            'assets/resource.html.twig',
            array(
                'asset' => $assets[0],
                'enemy' => $enemy
            ));
    }

    /**
     * @Route("/order/", name="order")
     */
    public function newOrder(Request $request)
    {
        $descrId = $request->request->get('descr_id');
        $in_production = $request->request->get('in_production');

        $userId = $this->getUser()->getId();
        $now = new \DateTime("now");

        $em=$this->getDoctrine()->getManager();
        $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['descrId'=> $descrId, 'userId' => $userId]);

        $asset->setInProdSince($now);
        $asset->setInProduction($in_production);
        $em->persist($asset);
        $em->flush();

        return $this->json(array('descrId' => $descrId, 'in_production'=>$in_production));
    }

    /**
     * @Route("/level/", name="level")
     */
    public function newLevel(Request $request)
    {
        $descrId = $request->request->get('descr_id');
        $in_production = $request->request->get('in_production');

        $userId = $this->getUser()->getId();
        $now = new \DateTime("now");

        $em=$this->getDoctrine()->getManager();
        $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['descrId'=> $descrId, 'userId' => $userId]);

        $asset->setInProdSince($now);
        $asset->setInProduction($in_production);
        $em->persist($asset);
        $em->flush();

        return $this->json(array('descrId' => $descrId, 'in_production'=>$in_production));
    }

    /**
     * @Route("/send/", name="send")
     */
    public function send(Request $request)
    {
        $descrId = $request->request->get('descr_id');
        $qtty = $request->request->get('qtty');
        $to_id = preg_replace("/[^0-9,.\s]/", "", $request->request->get('to_id'));

        $userId = $this->getUser()->getId();
        $em=$this->getDoctrine()->getManager();
        $asset = $em->getRepository('AppBundle:Asset')->findOneBy(['userId'=>$userId, 'descrId'=>$descrId]);

        if ($asset->getQtty() - $qtty > -1 ) {
            $asset->setQtty($asset->getQtty() - $qtty);
            $em->persist($asset);
            $em->flush();

            $distTimeCalc = $this->get('app.calculateDistTime');
            $interval=$distTimeCalc->calcTime($userId, $to_id);

            $now = new \DateTime("now");
            $now = $now->add(new \DateInterval($interval));

            $assets_on_road = new  AssetOnRoad;

            $assets_on_road->setDescrId($descrId);
            $assets_on_road->setUserId($to_id);
            $assets_on_road->setQtty($qtty);
            $assets_on_road->setReadyOn($now);
            $em->persist($assets_on_road);
            $em->flush();
            return $this->json(array('success' => 'OK'));
        }
        return $this->json(array('error' => 'Not sufficient resources'));
    }
}