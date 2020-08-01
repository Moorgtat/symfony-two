<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products_index")
     */
    public function index(ProductRepository $repo)
    {
        $products = $repo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
    *@Route("/product/new", name="product_create")
    *@IsGranted("ROLE_USER")
    *@return Response
    */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            foreach($product->getImages() as $image) {
                $image->setProduct($product);
                $manager->persist($image);
            }

            $product->setAuthor($this->getUser());

            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$product->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('product_show', [
                'slug' => $product->getSlug()
            ]);
        }

        return $this->render('product/newProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route("/product/{slug}/edit", name="product_edit")
     *@Security("is_granted('ROLE_USER') and user === product.getAuthor()", message="Cette annonce ne vous appartient pas, vous ne pouvez pas la modifier.")
     * @return Response
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $manager) {
      
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            foreach($product->getImages() as $image) {
                $image->setProduct($product);
                $manager->persist($image);
            }

            $manager->persist($product);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$product->getTitle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('product_show', [
                'slug' => $product->getSlug()
            ]);
        }

        return$this->render('product/editProduct.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }

     /**
     * @Route("/product/{slug}", name="product_show")
     * @return Response
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * Undocumented function
     *@Route("/product/{slug}/delete", name="product_delete")
     *@Security("is_granted('ROLE_USER') and user === product.getAuthor()", message="Cette annonce ne vous appartient pas, vous ne pouvez pas la supprimer.")
     * @param Product $product
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Product $product, EntityManagerInterface $manager){
        $manager->remove($product);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'annonce <strong>{$product->getTitle()}</strong> a bien été supprimée !"
        );

    return $this->redirectToRoute("account_index");
    }

}
