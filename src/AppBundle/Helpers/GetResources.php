<?php
// src/AppBundle/Controller/Helpers/getResources.php
namespace AppBundle\Helpers;

use Doctrine\ORM\EntityManager;
/**
* 
*/
class GetResources
{

	private $em;
	
    /**
     *
     * @var EntityManager 
     */
	public function __construct(EntityManager $entityManager)
	{
	    $this->em = $entityManager;
	}

	public function getAll($userID, $asset_id=null){
        $rools = $this->em->getRepository('AppBundle:Setting')->findOneBy(["key"=>'assetsCostGive'])->getValue();

        $assets = [];
        $assetsDescr = $this->em->getRepository("AppBundle:Asset_descr")->findBy([], ['sortOrder' => 'ASC']);

        foreach ($assetsDescr as $assetDescr){
            $asset = $this->em->getRepository("AppBundle:Asset")->findOneBy(['userId' => $userID, 'descrId'=>$assetDescr->getId()]);
            $costs = [];
            foreach ($rools[$assetDescr->getId()]['costs'] as $key => $cost){
                $name = $this->em->getRepository("AppBundle:Asset_descr")->findOneBy(['id' => $key])->getName();
                $costs[$name]= $cost;
            }
            if($asset_id === null || $asset_id == $assetDescr->getId()) {
                $prodLevelFactor=1;
                if (isset($rools[$asset->getDescrId()]['origin'])){
                    $origin = $rools[$asset->getDescrId()]['origin'];
                    $originLevel = $available = $this->em->getRepository('AppBundle:Asset')->findOneBy(['userId' => $userID, 'descrId' => $origin])->getLevel();
                    $productivityToLevelFactor = $this->em->getRepository('AppBundle:Setting')->findOneBy(["key"=>'productivityToLevel'])->getValue()['productivityToLevel'];
                    for($i=2; $i<=$originLevel; $i += 1){
                        $prodLevelFactor = floatval($prodLevelFactor) * floatval($productivityToLevelFactor);
                    }
                }
                if (isset($asset)) {
                    $assets[] = [
                        'id' => $assetDescr->getId(),
                        'name' => $assetDescr->getName(),
                        'level' => $asset->getLevel(),
                        'qtty' => ($asset->getQtty() > 0 ? $asset->getQtty() : ''),
                        'costs' => $costs,
                        'time' => $rools[$assetDescr->getId()]['time'] * $prodLevelFactor,
                        'production' => $rools[$assetDescr->getId()]['production'],

                    ];
                }
            }
        }
        return $assets;
	}

    public function getMiltary($userID){
        $rools = $this->em->getRepository('AppBundle:Setting')->findOneBy(["key"=>'assetsCostGive'])->getValue();

        $assets = [];
        $assetsDescr = $this->em->getRepository("AppBundle:Asset_descr")->findBy([], ['sortOrder' => 'ASC']);

        foreach ($assetsDescr as $assetDescr){
            $asset = $this->em->getRepository("AppBundle:Asset")->findOneBy(['userId' => $userID, 'descrId'=>$assetDescr->getId()]);
            $costs = [];
            foreach ($rools[$assetDescr->getId()]['costs'] as $key => $cost){
                $name = $this->em->getRepository("AppBundle:Asset_descr")->findOneBy(['id' => $key])->getName();
                $costs[$name]= $cost;
            }
            if(isset($rools[$assetDescr->getId()]['military-power'])) {
                if (isset($asset)) {
                    $assets[] = [
                        'id' => $assetDescr->getId(),
                        'name' => $assetDescr->getName(),
                        'level' => $asset->getLevel(),
                        'qtty' => 0,
                        'costs' => $costs,
                        'time' => $rools[$assetDescr->getId()]['time'],
                        'production' => $rools[$assetDescr->getId()]['production'],

                    ];
                }
            }
        }
        return $assets;
    }
}