<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 23/07/2018
 * Time: 13:48
 */

namespace App\Controller;


use App\Entity\Advertisment;
use App\Entity\User;
use App\Form\AdvertismentType;
use App\Service\FileUpLoader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdvertismentController extends Controller
{
    /**
     * @Route("/advertisment/add",name="advertisment_add")
     */
    function add(Request $request, FileUpLoader $fileUpLoader) {
        /** @var User $user */

        $user = $this->getUser();

        $advertisment = new Advertisment();
        $advertisment
            ->setAuthor($user)
            ->setRegion($user->getRegion());

        $form = $this->createForm(AdvertismentType::class, $advertisment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // photo upload   $file stores the uploaded file
            $file = $form->get("uploadPhoto")->getData();
            if ($file != null ) {
                $fileName = $fileUpLoader->upload($file);
                $advertisment->setPhoto($fileName);
                dump($advertisment);
            }

            // maj $advertisment en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($advertisment);
            $em->flush();
//            $user->addAdvertisment($advertisment);

            return $this->redirectToRoute('advertisment_all');
        }


        return $this->render('/advertisment/add.html.twig',array('form' => $form->createView(), 'advertisment' => $advertisment, 'screenName' => '/Add Advertisment'));
    }

    /**
     * @Route("/advertisment/update/{advertisment}",name="advertisment_update")
     */
    function update(Request $request, Advertisment $advertisment, FileUpLoader $fileUpLoader) {

        // pour éviter une modif par un user qui n'est pas le propriétaire (accès direct par l'url)
        if ($advertisment->getauthor()->getId() != $this->getUser()->getId())
            return $this->redirectToRoute('logout');


        $form = $this->createForm(AdvertismentType::class, $advertisment);

//        $form = $this->createFormBuilder($advertisment)
//            ->add("title",TextType::class)
//            ->add("description",TextType::class)
//            ->add("creationDate",DateType::class)
//            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // photo upload   $file stores the uploaded file
            $file = $form->get("uploadPhoto")->getData();
            if ($file != null ) {
                if ($advertisment->getPhoto() != null) {
                    $fileUpLoader->deleteUpload($advertisment->getPhoto());
                }

                $fileName = $fileUpLoader->upload($file);
                $advertisment->setPhoto($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('advertisment_all');
        }

        return $this->render('/advertisment/add.html.twig',array('form' => $form->createView(), 'advertisment' => $advertisment, 'screenName' => '/Update Advertisment'));
    }

    /**
     * @Route("/advertisment/hide/{advertisment}",name="advertisment_hide")
     */
    function hide(Advertisment $advertisment) {

        // pour éviter un hide/show par un user qui n'est pas modérateur (accès direct par l'url)
        if ( !$this->isGranted("ROLE_MODERATEUR"))
            return $this->redirectToRoute('logout');

        $advertisment->getActive() ? $advertisment->setActive(false) : $advertisment->setActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('home');
    }

    /**
     * @Route("/advertisment/show/{advertisment}",name="advertisment_show")
     */
    function show(Advertisment $advertisment) {

        return $this->render('/advertisment/show.html.twig',array("advertisment" => $advertisment, 'screenName' => '/Show Advertisment'));
    }


    /**
     * @Route("/advertisment/delete/{advertisment}",name="advertisment_delete")
     */
    function delete(Request $request, Advertisment $advertisment, FileUpLoader $fileUpLoader) {
        /** @var User $user */

        // pour éviter une delete par un user qui n'est pas le propriétaire (accès direct par l'url)
        if ($advertisment->getauthor()->getId() != $this->getUser()->getId())
            return $this->redirectToRoute('logout');

        if ($advertisment->getPhoto() != null) {
            $fileUpLoader->deleteUpload($advertisment->getPhoto());
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($advertisment);
        $em->flush();

        return $this->redirectToRoute('advertisment_all');
    }


    /**
     * @Route("/advertisment/all",name="advertisment_all")
     */
    function all(Request $request) {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('/advertisment/all.html.twig',array("advertisments" => $user->getAdvertisments(), 'screenName' => '/My Advertisments'));
    }

}