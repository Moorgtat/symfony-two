<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(ProductRepository $productRepo, UserRepository $userRepo) {
        return $this->render('home/home.html.twig', [
          'products' => $productRepo->findBestAds(3),
          'users' => $userRepo->findBestUsers(4)
        ]);
    }
}
