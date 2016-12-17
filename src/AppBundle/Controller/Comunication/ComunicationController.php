<?php

namespace AppBundle\Controller\Comunication;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comunication;

class ComunicationController extends Controller
{
    public function cominicateAction()
    {
        return $this->render(
            'comunication/comunication.html.twig'
        );
    }

    /**
     * @Route("/send_message", name="send_message")
     */
    function sendMessage(Request $request)
    {
        $userId = $this->getUser()->getId();
        $mTo = preg_replace("/[^0-9,.\s]/", "", $request->request->get('m_to'));
        $messge = $request->request->get('message');

        $em = $this->getDoctrine()->getManager();
        $comunication = new Comunication();
        $comunication->setSenderId($userId);
        $comunication->setRecipientId($mTo);
        $comunication->setMessage($messge);
        $comunication->setIsNew(1);
        $em->persist($comunication);
        $em->flush();
        return $this->json(array('success' => 'OK'));
    }

    /**
     * @Route("/read-messages", name="read_messages")
     */
    function getMessages()
    {
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository("AppBundle:Comunication")->findBy(['recipientId'=>$userId], ['id' => 'DESC'],10);
        return $this->render(
            'comunication/messages.html.twig',
            ['messages' => $messages]
        );
    }
}