<?php
// src/AppBundle/Controller/LoginController.php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
    $authenticationUtils = $this->get('security.authentication_utils');
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();
    return $this->render('security/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
        'action'	    => 'Log in',
    ));
    }

}