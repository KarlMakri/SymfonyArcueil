<?php

namespace App\Controller;

//use http\Env\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Topic;
use App\Form\TopicType; // Import du constructeur de formulaire pour l'entité Topic

class TopicController extends AbstractController
{
    /**
     * @Route("/topic", name="topic")
     */
    public function index()
    {
        $topics =
            $this->getDoctrine()
                ->getRepository(Topic::class)
                //->findAll();
                ->findBy([], ['name' => 'ASC']);

        return $this->render('topic/index.html.twig', [
            'topics' => $topics,
        ]);
    }

    /**
     * @Route("/topic/add", name="topic_add")
     */
    public function add(Request $request)
    {
        $topic = new Topic();

        // Création Formulaire sur $topic
        $form = $this->createFormBuilder($topic)

                ->add('name', TextType::class)
                ->add('submit', SubmitType::class)
                //->add('id', HiddenType::class)
                ->getForm();

        $form->handleRequest($request); //Prends en charge de la requête, mise en relation on connecte le formulaire avec la requête

        if($form->isSubmitted()){ // On Hydrate l'objet topic avec les données envoyées/postées par le formulaire

            $topic = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();
            return $this->redirectToRoute('topic');
        }


        return $this->render('topic/add.html.twig', [

            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/topic/new", name="topic_new")
     */
    public function new(Request $request){

        $topic = new Topic();

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request); //Prends en charge de la requête, mise en relation on connecte le formulaire avec la requête

        if($form->isSubmitted()){ // On Hydrate l'objet topic avec les données envoyées/postées par le formulaire

            $topic = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();
            return $this->redirectToRoute('topic');
        }

        return $this->render('topic/add.html.twig', [

            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/topic/{id}/delete", name="topic_delete")
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $topic = $em->getRepository(topic::class)->find($id);

        $em->remove($topic);
        $em->flush();

        return $this->redirectToRoute('topic');

    }
}
