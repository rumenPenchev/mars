<?php

namespace AppBundle\Helpers;
use AppBundle\Entity\Army;
use AppBundle\Entity\ArmyAssets;
use Doctrine\ORM\EntityManager;

class War
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

    public function inDanger($id)
    {
        if ($this->em->getRepository('AppBundle:Army')->findOneBy(['targetId' => $id])) {
            $target = $this->em->getRepository('AppBundle:Army')->findOneBy(['targetId' => $id]);
            if ($target->getGetThereOn() != null && $target->getGetBackOn() != null) {
                return $target->getUserId();
            }
        } else {
            return null;
        }
    }


    public function warTime($id)
    {
        $now = new \DateTime("now");

        $target = $this->em->getRepository('AppBundle:Army')->findOneBy(['targetId' => $id]);
        if ($target) {
            if ($target->getGetThereOn() && $now < $target->getGetThereOn()) {
                $target->setGetThereOn(null);
                $this->em->persist($target);
                $this->em->flush();
                return $target->getId();
            }
        }
        $target = $this->em->getRepository('AppBundle:Army')->findOneBy(['userId' => $id]);
        if ($target) {
            if ($target->getGetThereOn() && $now < $target->getGetThereOn()) {
                $target->setGetThereOn(null);
                $this->em->persist($target);
                $this->em->flush();
                return $target->getId();
            }
        }
        return false;
    }

    public function setTheConflict($warId){
        $conflict= $this->em->getRepository('AppBundle:Army')->findOneBy(['id' => $warId]);
        $attacker = $conflict->getUserId();
        $defender = $conflict->getTargetId();

        $rools = $this->em->getRepository('AppBundle:Setting')->findOneBy(['key'=>'assetsCostGive'])->getValue();
        $attackerMP = 0;
        $deffenderMP = 0;
        foreach ($rools as $key => $rool){
            if(isset($rool['military-power'])){
                $attackerArmy = $this->em->getRepository('AppBundle:ArmyAssets')->findOneBy(['descrId' => $key, 'armyId'=>$warId]);
                if($attackerArmy){
                    $attackerMP = $attackerArmy->getQtty()*$rool['military-power'];
                }
                $defenderAssets = $this->em->getRepository('AppBundle:Asset')->findOneBy(['descrId' => $key, 'userId'=>$defender]);
                if($defenderAssets){
                    $deffenderMP = $defenderAssets->getQtty()*$rool['military-power'];
                }
            }
        }

        if(!$deffenderMP){
            return true;
        }
        return (($attackerMP / $deffenderMP)>=2);
    }
}
