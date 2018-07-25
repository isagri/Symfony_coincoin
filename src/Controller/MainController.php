<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 14:48
 */

namespace App\Controller;


use App\Entity\Advertisment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
class MainController extends Controller
{
    private $advertisments;

    /**
     * @Route("/", name="home")
     */
    public function home() {
        $em = $this->getDoctrine()->getManager();
        $this->advertisments = $em->getRepository(Advertisment::class)->findAll();
        return $this->render('main/home.html.twig', ['advertisments' => $this->advertisments]);
    }

}