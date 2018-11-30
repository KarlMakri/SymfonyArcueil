<?php
/**
 * Created by PhpStorm.
 * User: Barkaoui
 * Date: 26/11/2018
 * Time: 12:33
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class DemoController extends AbstractController
{

    private $title = 'Joueurs';

    public function players()
    {

        $res = new Response('<h1>'.$this->title.'</h1>');

        return $res;

    }

    public function test()
    {

//        $calcul = 2*23;
//        return new Response($calcul);
        $colors = ['Vert', 'Blanc', 'Rouge'];
        $colorsDict = [

            ['fr' => 'Vert', 'en' => 'Green', 'active' => true],
            ['fr' => 'Blanc', 'en' => 'White', 'active' => false],
            ['fr' => 'Rouge', 'en' => 'Red','active' => true]
        ];

        return $this->render('demo/test.html.twig', array(
            'title' => 'Template Test',
            'colors' => $colors,
            'colorsDict' => $colorsDict
        ));

    }

}