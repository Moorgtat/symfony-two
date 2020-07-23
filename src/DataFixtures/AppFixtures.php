<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Image;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {
    $faker = Factory::create('FR-fr');

    for ($i = 1; $i <= 30; $i++) {

      $product = new Product();

      $title = $faker->sentence();
      $coverImage = $faker->imageUrl(450, 200);
      $introduction = $faker->paragraph(2);
      $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

      $product->setTitle($title)
              ->setCoverImage($coverImage)
              ->setIntroduction($introduction)
              ->setContent($content)
              ->setPrice(mt_rand(39, 289))
              ->setRooms(mt_rand(1, 7));

      for ($j = 1; $j <= mt_rand(2, 5); $j++) {

        $image = new Image();

        $image->setUrl($faker->imageUrl())
              ->setCaption($faker->sentence())
              ->setProduct($product);
        $manager->persist($image);
      }

      $manager->persist($product);

    }

    $manager->flush();
  }
}
