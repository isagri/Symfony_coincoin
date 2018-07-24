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
    function add(Request $request) {
        /** @var User $user */
        $user = $this->getUser();

        $advertisment = new Advertisment($user);
        $form = $this->createFormBuilder($advertisment)
            ->add("title",TextType::class)
            ->add("description",TextType::class)
            ->add("creationDate",DateType::class)
            ->getForm();

        $form->handleRequest($request);

        dump($advertisment);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advertisment);
            $em->flush();

            $user->addAdvertisment($advertisment);
            return $this->redirectToRoute('advertisment_show');
        }

        return $this->render('/advertisment/add.html.twig',array('form' => $form->createView(),"advertisment" => $advertisment));
    }

    /**
     * @Route("/advertisment/update/{advertisment}",name="advertisment_update")
     */
    function update(Request $request, Advertisment $advertisment) {

        $form = $this->createFormBuilder($advertisment)
            ->add("title",TextType::class)
            ->add("description",TextType::class)
            ->add("creationDate",DateType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('advertisment_show');
        }

        return $this->render('/advertisment/add.html.twig',array('form' => $form->createView(),"advertisment" => $advertisment));
    }

    /**
     * @Route("/advertisment/delete/{advertisment}",name="advertisment_delete")
     */
    function delete(Request $request, Advertisment $advertisment) {
        /** @var User $user */
        $user=$this->getUser();
        $user->removeAdvertisment($advertisment);

        $em = $this->getDoctrine()->getManager();
        $em->remove($advertisment);
        $em->flush();

        return $this->redirectToRoute('advertisment_show');
    }


    /**
     * @Route("/advertisment/show",name="advertisment_show")
     */
    function show(Request $request) {
        /** @var User $user */
        $user = $this->getUser();
        dump($user->getAdvertisments());

        return $this->render('/advertisment/show.html.twig',array("advertisments" => $user->getAdvertisments()));
    }

}