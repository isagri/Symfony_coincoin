<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 23/07/2018
 * Time: 16:22
 */

namespace App\Service;


use App\Entity\User;

class MailGenerator
{
    private $swiftMailer;
    private $twig_Environment;

    public function __construct( \Swift_Mailer $swift_Mailer, \Twig_Environment $twig_Environment )
    {
        $this->swiftMailer = $swift_Mailer;
        $this->twig_Environment = $twig_Environment;
    }

    public function sendRegisterMail(User $user) {

        $message = new \Swift_Message('Registration in Coincoin');
        $message
            ->setFrom('isabelle.grillet6@orange.fr')
            ->setTo($user->getEmail())
            //->setBody('registered to coincoin');   pour mettre un texte structuré :
            ->setBody(
                    $this->twig_Environment->render(
                        'emails/registration.html.twig',
                        array('name' => $user->getFirstname() . ' ' . $user->getLastname() ) ),
                    'text/html' );

        $this->swiftMailer->send($message);
    }
}