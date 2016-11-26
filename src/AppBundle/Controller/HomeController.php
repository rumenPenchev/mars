<?php
// src/AppBundle/Controller/HomeController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function homeAction()
    {
    return new Response(
            '<html><body>Lucky number: '.'This is home'.'</body></html>'
    );        
    }

}