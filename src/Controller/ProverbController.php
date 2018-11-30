<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Proverb;
use App\Form\ProverbType;


class ProverbController extends AbstractController
{
    /**
     * @Route("/proverb", name="proverb")
     */
    public function index()
    {
        $proverbs = $this->getDoctrine()

                ->getRepository(Proverb::class)
                ->findAll();

        return $this->render('proverb/index.html.twig', [
            'proverbs' => $proverbs,
        ]);
    }

    /**
     * @Route("/proverb/add", name="proverb_add")
     */
    public function add(Request $request)
    {

        $proverb = new Proverb();

        $form = $this->createForm(ProverbType::class, $proverb);


        // Traitement du submit
        $form->handleRequest($request); //Prends en charge de la requête, mise en relation on connecte le formulaire avec la requête

        if($form->isSubmitted()){ // On Hydrate l'objet topic avec les données envoyées/postées par le formulaire

            $proverb = $form->getData(); //var_dump($proverb->getBody());
            $em = $this->getDoctrine()->getManager();
            $em->persist($proverb);
            $em->flush();
            return $this->redirectToRoute('proverb');
        }

        return $this->render('proverb/add.html.twig', [

            'form' => $form->createView()
        ]);

    }
}
