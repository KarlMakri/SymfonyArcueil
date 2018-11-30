<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Country;
use App\Form\CountryType;


class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country")
     */
    public function index()
    {
        $countries =
            $this->getDoctrine()
                ->getRepository(Country::class)
                //->findAll();
                ->findBy([], ['name' => 'ASC']); //findBy permet de paramètrer la recherche le premier argument (tableau asscociative) permet de filtrer, le deuxième argument pertmet le trie

        return $this->render('country/index.html.twig', [
            'countries' => $countries
        ]);
    }

    /**
     * @Route("/country/add", name="country_add")
     */
    public function add(Request $request)
    {
        if($request->isMethod('POST')){

            $name = $request->request->get('name');
            $em = $this->getDoctrine()->getManager();
            $country = new Country(ucfirst($name));
            $em->persist($country);
            $em->flush();
             return $this->redirectToRoute('country');
        }

        return $this->render('country/add.html.twig', []);
    }

    /**
     * @Route("/country/new", name="country_new")
     */
    public function new(Request $request)
    {
        $file = '';
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);

        // On connecte le formulaire avec la requête
        $form->handleRequest($request);

//        if($request->isMethod('POST')){
        if ($form->isSubmitted()) {

//            $name = $request->request->get('name');
            $country = $form->getData();

            //Gestion des traitement du fichier uploaded
            $file = $form->get('flag')->getData();
            $fileName = $file->getClientOriginalName();

            try{

                $file->move($this->getParameter('flags_folder'), $fileName );

            }catch (FileException $e){

                echo 'Error';
            }

            $country->setFlag($fileName);

            $em = $this->getDoctrine()->getManager();
            //$country = new Country(ucfirst($name));
            $em->persist($country);
            $em->flush();
            return $this->redirectToRoute('country');
        }

        return $this->render('country/form.html.twig', [

            'form' => $form->createView()//,
//            'country' => $country,
//            'file' => $file
        ]);
    }

    /**
     * @Route("/country/{id}/edit", name="country_edit")
     */
    public function edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager(); // Requête qui permet la modication dans la BD
        // Récupération des données du pays à modifier
        $country = $em
                    ->getRepository(Country::class)
                    ->find($id);
       $form =  $this->createForm(CountryType::class, $country);

       $form->handleRequest($request);

       if($form->isSubmitted()){
           // Modifie l'objet country avec les données postées
           $country = $form->getData();
           $em->flush();
       }

        return $this->render('country/form.html.twig', [

            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/country/{id}/delete", name="country_delete")
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $country = $em->getRepository(country::class)->find($id);

        $em->remove($country);
        $em->flush();

        return $this->redirectToRoute('country');

    }

    /**
     * @Route("/country/test", name="country_test")
     */
    public function test()
    {
        $countries = $this

                ->getDoctrine()
                ->getRepository(Country::class)
                ->findByPopNumber(5000)
                //->findAllCustom()
                //->findBySearch('te')
                //->findAllRaw()
                ;

        return $this->render('country/test.html.twig',[

            'countries' => $countries
        ]);
    }
}
