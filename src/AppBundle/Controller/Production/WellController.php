<?php

namespace AppBundle\Controller\Production;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Asset;
use AppBundle\Entity\Setting;

class WellController extends Controller
{
    /**
    * @Route("/well", name="well")
    */
    public function makeWell()
    {
        //sleep(20);
        $em = $this->getDoctrine()->getManager();

        $asset_descr = $em->getRepository("AppBundle:Property_descr")->findOneById(2);
        $asset = new Asset();
        $asset->setAssetsDescr($asset_descr)->setQtty(1);

      //  var_dump($property);

        $em->persist($property_descr);
        $em->persist($asset);
        $em->flush();

        // returns '{"username":"jane.doe"}' and sets the proper Content-Type header
        return $this->json(array('username' => 'jane.doe'));
    }
}
