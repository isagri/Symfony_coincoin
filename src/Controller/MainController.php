<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 14:48
 */

namespace App\Controller;


use App\Entity\Advertisment;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class MainController extends Controller
{
    private $advertisments;

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, EntityManagerInterface $em) {

        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchTitle = $form->get('searchTitle')->getData();
            $region = $form->get('region')->getData();

            if ($region != null && $searchTitle != null) {
                $this->advertisments = $em->getRepository(Advertisment::class)->searchByRegionTitle($region, $searchTitle);
                dump($region);
                dump($searchTitle);
            } else if ($region != null) {
                $this->advertisments = $em->getRepository(Advertisment::class)->searchByRegion($region);
                dump($region);
            } else if ($searchTitle != null) {
                $this->advertisments = $em->getRepository(Advertisment::class)->searchByTitle($searchTitle);
                dump($searchTitle);
            } else {
                $this->advertisments = $em->getRepository(Advertisment::class)->findAll();
            }
        } else {
            $this->advertisments = $em->getRepository(Advertisment::class)->findAll();
        }

        return $this->render('main/home.html.twig', ['form' => $form->createView(), 'advertisments' => $this->advertisments]);
    }

}