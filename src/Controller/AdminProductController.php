<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProductController extends AbstractController
{
    /**
     * @Route("/admin/products", name="admin_products_index")
     */
    public function index(ProductRepository $repo)
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $repo->findAll()
        ]);
    }

    /**
     * Permet d'affiche rle formulaire d'édition
     * @Route("/admin/products/{id}/edit", name="admin_products_edit")
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'annonce <strong>{$product->getTitle()}</strong> a bien été modifiée !"
            );
        }
        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }
}
