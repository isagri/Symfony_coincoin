<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 13:54
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Service\MailGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailGenerator $mailGenerator) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        // après validation
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password=$passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $mailGenerator->sendRegisterMail($user);
            return $this->redirectToRoute('home');

        }
        return $this->render('registration/register.html.twig', array('form' => $form->createView(), 'screenName' => '/Register'));
    }
}