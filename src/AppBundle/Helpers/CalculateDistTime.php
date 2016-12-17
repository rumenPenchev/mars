<?php

namespace AppBundle\Helpers;
use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyAssets;
use Doctrine\ORM\EntityManager;

class CalculateDistTime
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

    public function calcTime($id, $recId)
    {
            $me = $this->em->getRepository('AppBundle:Colony')->findOneBy(['user_id' => $id]);
            $recipient = $this->em->getRepository('AppBundle:Colony')->findOneBy(['user_id' => $recId]);
            $dX = $me->getX() - $recipient->getX();
            $dY = $me->getY() - $recipient->getY();

            $distance = sqrt($dX * $dX + $dY * $dY);
            $distanceToTimeParameter = $this->em->getRepository('AppBundle:Setting')->findOneBy(['key' => 'distanceToTimeParameter']);

            $time_per_mile = $distanceToTimeParameter->getValue()['time_per_mile'];
            $interval = floor($time_per_mile*$distance);
            return 'PT' . $interval . 'S';
    }

}
