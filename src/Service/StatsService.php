<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsService {
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    public function getUsersCount() {
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getProductsCount() {
        return $this->manager->createQuery('SELECT COUNT(p) FROM App\Entity\Product p')->getSingleScalarResult();
    }

    public function getBookingsCount() {
        return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\Booking b')->getSingleScalarResult();
    }

    public function getCommentsCount() {
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();
    }

    public function getStats() {
        $users = $this->getUsersCount();
        $products = $this->getProductsCount();
        $bookings = $this->getBookingsCount();
        $comments = $this->getCommentsCount();

        return compact('users', 'products', 'bookings', 'comments');
    }

    public function getAdsStats($direction) {
        return $this->manager->createQuery(
            'SELECT AVG(c.rating) as note, p.title, p.id, u.firstName, u.lastName, u.picture
            FROM App\Entity\Comment c
            JOIN c.product p
            JOIN p.author u
            GROUP BY p
            ORDER BY note ' . $direction
        )
        ->setMaxResults(10)
        ->getResult();  
    }
}