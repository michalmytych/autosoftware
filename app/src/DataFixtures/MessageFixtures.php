<?php

namespace App\DataFixtures;

use App\Entity\Message;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MessageFixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 200; ++$i) {
            $message = new Message();
            $message->setRelativeFilePath($this->faker->filePath());
            $message->setCreatedAt(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );

            $manager->persist($message);
        }

        $manager->flush();
    }
}