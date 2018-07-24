<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 16:53
 */

namespace App\Controller;


use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{

    /**
     * @Route("/user/update",name="user_update")
     */
    function update(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        /** @var User $user */

        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add("firstname",TextType::class)
            ->add("lastname",TextType::class)
            ->add('plainPassword',RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password') ))
            ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            if (!empty($user->getPlainPassword())) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        return $this->render('/user/update.html.twig',array('form' => $form->createView(),"user" => $user));
    }
}