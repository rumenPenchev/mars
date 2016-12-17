<?php
// src/AppBundle/Controller/Security/RegisterController.php
namespace AppBundle\Controller\Security;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Helpers\MakeColonyController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class RegisterController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'login', array('ROLE_USER'));
            $this->get('security.token_storage')->setToken($token);

            $user = $this->get('security.token_storage')->getToken()->getUser();            
            
            $colony = $this->get('app.colonyCreator');
            $colony->newColony($user->getId());
            $setAssets = $this->get('app.setAssets');
            $setAssets->newUsetAssets($user->getId());


            return $this->redirectToRoute('colony');
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView(), 'action'=>'REGISTER')
        );
    }
}