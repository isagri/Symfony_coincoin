<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 14:48
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
class MainController extends Controller
{
    /**
     * @Route("/public", name="home")
     */
    public function home() {
        return $this->render('main/home.html.twig', ['project_name' => 'Coincoin']);
    }

}