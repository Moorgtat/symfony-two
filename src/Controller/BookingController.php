<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Product;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/product/{slug}/book", name="booking_create")
     * @isGranted("ROLE_USER")
     */
    public function book(Product $product, Request $request, EntityManagerInterface $manager)
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            
            $booking->setBooker($user)
                    ->setProduct($product);

            if(!$booking->isBookableDates()){
                $this->addFlash(
                    "warning",
                    "Ces dates ne sont pas disponible pour cette annonce."
                );
            } else {
                $manager->persist($booking);
                $manager->flush();
    
                return $this->redirectToRoute('booking_show', ['id' => $booking->getId()]);
            }
        }

        return $this->render('booking/book.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route("/booking/{id}",name="booking_show")
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking) {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }

}
