<?php

namespace App\DataFixtures;

use App\Entity\Books;
use App\Entity\Comments;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BooksFixtures extends Fixture
{
  public function load(ObjectManager $manager)
  {

    $faker = \Faker\Factory::create("en_EN");

    $Genre = ["novel", "fiction", "thriller", "romance", "drama"];

    for ($k = 0; $k < 5; $k++) {
      $user = new User();
      $user->setEmail($faker->freeEmail)
        ->setUsername($faker->userName)
        ->setPassword($faker->password);
      $manager->persist($user);

      for ($i = 0; $i < 2; $i++) {

        $book = new Books();
        $book->setTitle($faker->sentence(2))
          ->setAuthor($faker->name)
          ->setImage($faker->imageUrl(400, 600))
          ->setGenre($Genre[$i])
          ->setDescription($faker->text(80))
          ->setDatePublished($faker->dateTimeBetween("-3 years"))
          ->setNumberOfPages(mt_rand(60, 380))
          ->setAvailibility(true);
        $manager->persist($book);

        for ($j = 0; $j < mt_rand(3, 4); $j++) {
          $comment = new Comments();
          $comment->setContent($faker->paragraph())
            ->setCreatedAt($faker->dateTimeBetween("-6 month"))
            ->setAuthor($user)
            ->setBook($book);
          $manager->persist($comment);
        }
      }
    }
    $manager->flush();
  }
}
