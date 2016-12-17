<?php
// src/AppBundle/Controller/AdminController.php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Setting;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        //Assets Settings
        $assetsCostGive = [
            // People
            '1' =>
                [
                    'costs'=>
                        [
                            '2'=>20, //Oxygen
                            '3'=>3, //Water
                            '4'=>3, //Food
                        ],
                    'time'       => 200,
                    'production' => 'on demand',
                ],
            // Oxigen
            '2' =>
                [
                    'costs'=>
                        [
                            '9'=>0, //Greenery
                        ],
                    'time'       => 50,
                    'origin'     => 8,
                    'production' => 'auto',
                ],
            // Water
            '3' =>
                [
                    'costs'=>
                        [
                            '8'=>0, //Well
                        ],
                    'time'       => 50,
                    'origin'     => 8,
                    'production' => 'auto',
                ],
            // Food
            '4' =>
                [
                    'costs'=>
                        [
                            '9'=>0, //Greenery
                        ],
                    'time'       => 50,
                    'origin'     => 9,
                    'production' => 'auto',
                ],
            // Tank
            '5' =>
                [
                    'costs'=>
                        [
                            '11'=>0, //Tank Factory
                        ],
                    'time'       => 150,
                    'origin'     => 11,
                    'production' => 'auto',
                    'military-power' => 1
                ],
            // Aircraft
            '6' =>
                [
                    'costs'=>
                        [
                            '12'=>0, //Aircraft Factory
                        ],
                    'time'       => 250,
                    'origin'     => 12,
                    'production' => 'auto',
                    'military-power' => 2
                ],
            // Gold
            '7' =>
                [
                    'costs'=>
                        [
                            '10'=>0, //Mine
                        ],
                    'time'       => 80,
                    'origin'     => 10,
                    'production' => 'auto',
                ],
            // well
            '8' =>
                [
                    'costs'=>
                        [
                            '1'=>1, //people
                            '7'=>10, //gold
                        ],
                    'gives'=>
                        [
                            '2'=>true, //Oxigen
                            '3'=>true //Waret
                        ],
                    'time'       => 50,
                    'production' => 'on demand',
                ],
            // Greenery
            '9' =>
                [
                    'costs'=>
                        [
                            '1'=>1, //people
                            '7'=>7, //gold
                        ],
                    'gives'=>
                        [
                            '4'=>true //Food
                        ],
                    'time'       => 150,
                    'production' => 'on demand',
                ],
            // Mine
            '10' =>
                [
                    'costs'=>
                        [
                            '1'=>5, //people
                        ],
                    'gives'=>
                        [
                            '7'=>true // Gold
                        ],
                    'time'       => 150,
                    'production' => 'on demand',
                ],
            // Tank Factory
            '11' =>
                [
                    'costs'=>
                        [
                            '1'=>10, //people
                            '7'=>15, //Gold
                        ],
                    'gives'=>
                        [
                            '5'=>true //tank
                        ],
                    'time'       => 250,
                    'production' => 'on demand',
                ],
            // Aircraft Facory
            '12' =>
                [
                    'costs'=>
                        [
                            '1'=>15, //people
                            '7'=>18, //Gold
                        ],
                    'gives'=>
                        [
                            '6'=>true //Aircraft
                        ],
                    'time'       => 250,
                    'production' => 'on demand',
                ],

        ];
        $setting = new Setting;
        $setting->setKey('assetsCostGive');

        $setting->setValue($assetsCostGive);
        $em->persist($setting);
        $em->flush();

        // Spped Factor
        $setting = new Setting;
        $speed = ['time_per_mile' => '0.4'];
        $setting->setKey('distanceToTimeParameter');
        $setting->setValue($speed);
        $em->persist($setting);
        $em->flush();

        //Productivity To Level Factor
        $setting = new Setting;
        $productivity = ['productivityToLevel' => '0.9'];   //(time = time * productivityToLevel) exponent (origin Level)
        $setting->setKey('productivityToLevel');
        $setting->setValue($productivity);
        $em->persist($setting);
        $em->flush();
        return new Response(
            '<html><body>Lucky number: '.'$number'.'</body></html>'
        );
    }

}