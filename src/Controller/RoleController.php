<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Role;
use App\Form\RoleType;


class RoleController extends AbstractController
{
    /**
     * @Route("/role", name="role")
     */
    public function index()
    {
//        $roles = $this->getDoctrine()
//
//            ->getRepository(Role::class)
//            ->findAll();

        return $this->render('role/index.html.twig', [
//            'roles' => $roles,
            'controller_name' => 'RoleController',
        ]);
    }

    /**
     * @Route("/role/add", name="role_add")
     */
    public function add(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role );

        // Traitement du submit
        $form->handleRequest($request); //Prends en charge de la requête, mise en relation on connecte le formulaire avec la requête

        if($form->isSubmitted()){ // On Hydrate l'objet topic avec les données envoyées/postées par le formulaire

            $role = $form->getData(); //var_dump($proverb->getBody());
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();
            return $this->redirectToRoute('role');
        }

        return $this->render('role/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
