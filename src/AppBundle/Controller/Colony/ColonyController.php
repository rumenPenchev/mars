<?php
// src/AppBundle/Controller/Colony/ColonyController.php
namespace AppBundle\Controller\Colony;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ColonyController extends Controller
{
    /**
     * @Route("/", name="colony")
     */
    public function homeAction()
    {
        $userId = $this->getUser()->getId();

        $colonies = $this->get('app.getEnemies')->getThemAll($userId);
        $me = $this->get('app.getEnemies')->getMe($userId);

        return $this->render(
            'colony/colony.html.twig',
                array(
                    'colonies' => $colonies,
                    'me'       => $me
                )
        );
    }

}