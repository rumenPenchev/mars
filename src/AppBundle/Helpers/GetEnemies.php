<?php

namespace AppBundle\Helpers;
use Doctrine\ORM\EntityManager;

class GetEnemies
{
    private $em;

    /**
     *
     * @var EntityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        return $this;
    }

    public function getThemAll($id)
    {
        return  $this->em->getRepository('AppBundle:Colony')->getEnemies($id);
    }

    public function getMe($id)
    {
        return  $this->em->getRepository('AppBundle:Colony')->findBy(array('user_id' => $id));
    }
}
