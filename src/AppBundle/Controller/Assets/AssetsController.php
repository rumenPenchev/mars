<?php

namespace AppBundle\Controller\Assets;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AssetsController extends Controller
{
    /**
     * @Route("/assets/{user}", name="assets")
     */
    public function showAction($user=null)
    {
        $userId = $this->getUser()->getId();

        $this->get('app.addAssets')->addAssets($userId);

        $em = $this->getDoctrine()->getManager();
        $assets = [];
        $assets_descr = $em->getRepository("AppBundle:Asset_descr")->findBy([], ['sortOrder' => 'ASC']);

        foreach ($assets_descr as $asset_descr){
            $asset = $em->getRepository("AppBundle:Asset")->findOneBy(['userId' => $userId, 'descrId'=>$asset_descr->getId()]);
            if (isset($asset)) {
                $assets[] = [
                    'id' => $asset_descr->getId(),
                    'name'  => $asset_descr->getName(),
                    'level' => ($asset->getLevel() > 0 ? $asset->getLevel() : ''),
                    'qtty'  => ($asset->getQtty() > 0 ? $asset->getQtty() : ''),
                ];
            }
        }
        return $this->render(
            'assets/assets.html.twig',
            array(
                'assets' => $assets,
            ));
    }
}
