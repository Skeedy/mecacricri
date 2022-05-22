<?php

namespace App\Controller;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@Route ("/", name="home")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(PrestationRepository $prestationRepository)
    {
        $unpayeds = $prestationRepository->findBy(['payed'=> false]);
        return $this->render('base.html.twig',
        ['unpayeds' => $unpayeds]);
    }

}
