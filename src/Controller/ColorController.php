<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Color;


class ColorController extends AbstractController
{


    public function color($color, $width, $height, $nb)
    {

        return $this->render('color/color.html.twig', array(

            'color' => $color,
            'width' => $width,
            'height' => $height,
            'nb' => $nb

        ));
    }

    public function add(Request $request)
    {

//        var_dump($_POST);
//        var_dump($request);
//        echo  $request->getMethod();
        // Accès aux paramètres URL des requêtes GET
//        echo $request->query->get('Test'); // Pour Accéder au paramètres URL  : http://127.0.0.1:8000/color/add?Test=Dufour Renvcie Dufour

        $success = false; // Sert à déterminer si l'enregistrement de la couleur a bien eu lieu par valeur par défaut false
        $method = $request->getMethod();
        if($method === 'POST'){

            $nameEn = $request->request->get('nameEn');
            $nameFr = $request->request->get('nameFr');
            $hexa = $request->request->get('hexa');

            //Insertion en BD
            $em = $this->getDoctrine()->getManager(); // L'Objet manager permet d'écrire en DB

            //Création d'un objet color à partir des donnés postées
            $color = new Color();
            $color->setNameEn($nameEn);
            $color->setNameFr($nameFr);
            $color->setHexa($hexa);
//            var_dump($color);

            $em->persist($color); // Persiste

            $em->flush(); // Flusher en DB

            if($color->getId() != NULL){

                $success = true;
            }else{
                $success = false;
            }

        }

        return $this->render('color/add.html.twig', array(

            'success' => $success,
            'method' => $method
        ));

    }

    public function list()
    {

        // Récupérer les Couleurs dans la BD (lecture)
        $repo = $this
                    ->getDoctrine()
                    ->getRepository(Color::class);

        $colors = $repo->findAll();

        return $this->render('color/list.html.twig', array(

            'colors' => $colors
//            'method' => $method
        ));

    }

    public function edit($id, Request $request)
    {

        $success = false;
        $method = $request->getMethod();

        // Récupération de la couleur en DB
        $em = $this->getDoctrine()->getManager();
        // Appel au repository à partir du manager avantage : dans le cas d'un UPDATE toute modification apporter à l'objet récupéré par le repository généra une requête de mise à jour en DB dès lorsque flush() est appelée depuis le manger;
        $color = $em->getRepository(Color::class)->find($id); // Cette méthode uniquement dans la solution update, connection de deux éléments

        if($method === 'POST'){

            $nameEn = $request->request->get('nameEn');
            $nameFr = $request->request->get('nameFr');
            $hexa = $request->request->get('hexa');

            $color->setNameEn($nameEn);
            $color->setNameFr($nameFr);
            $color->setHexa($hexa);

            $em->flush();
            //$success = true;

            // Redirection vers page d'accueil
            return $this->redirectToRoute('index');

        }

        //var_dump($color);

        return $this->render('color/edit.html.twig', array(

            'method' => $method,
            'color' => $color,
            'success' => $success

    ));

    }

    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $color = $em->getRepository(Color::class)->find($id);

        $em->remove($color);
        $em->flush();

        return $this->redirectToRoute('index');

    }
}
