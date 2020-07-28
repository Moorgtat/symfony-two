<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder) {
      $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager)
  {
    $faker = Factory::create('FR-fr');

    $user = [];

    $genres = ['male', 'female'];

    for ($i = 1; $i <= 10; $i++) {
        $user = new User();

        $genre = $faker->randomElement($genres);

        $picture= 'https://randomuser.me/api/portraits/';
        $pictureId = $faker->numberBetween(1, 99) . '.jpg'; 
        $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
      
        $hash = $this->encoder->encodePassword($user, 'password');

        $user->setFirstName($faker->firstname($genre))
             ->setLastName($faker->lastname)
             ->setEmail($faker->email)
             ->setIntroduction($faker->sentence())
             ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
             ->setHash($hash)
             ->setPicture($picture);

        $manager->persist($user);
        $users[] = $user;
    }

    for ($i = 1; $i <= 30; $i++) {

      $product = new Product();

      $title = $faker->sentence();
      $coverImage = $faker->imageUrl(450, 200);
      $introduction = $faker->paragraph(2);
      $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

      $user = $users[mt_rand(0, count($users) - 1)];

      $product->setTitle($title)
              ->setCoverImage($coverImage)
              ->setIntroduction($introduction)
              ->setContent($content)
              ->setPrice(mt_rand(39, 289))
              ->setRooms(mt_rand(1, 7))
              ->setAuthor($user);

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
