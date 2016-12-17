<?php
// src/AppBundle/Controller/MakeColonyController.php
namespace AppBundle\Helpers;

use AppBundle\Entity\Colony;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
/**
* 
*/
class MakeColony extends Controller
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

	public function newColony($userID){
		$fieldDimention = $this->em->getRepository('AppBundle:Setting')->getSettingByKey('field_dimentions')->getValue();
        $xMin = $fieldDimention['gameField_X_min'];
        $xMax = $fieldDimention['gameField_X_max'];
		$yMin = $fieldDimention['gameField_Y_min'];
		$yMax = $fieldDimention['gameField_Y_max'];
		
		$colony = new Colony();
		$colony->setUserId($userID);
		$colony->setX(rand ( $xMin, $xMax ));
		$colony->setY(rand ( $yMin, $yMax  ));

        $this->em->persist($colony);
        $this->em->flush();
	}
}