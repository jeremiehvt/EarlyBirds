<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 09/06/2018
 * Time: 09:29
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

ini_set('memory_limit', '-1');
set_time_limit(0);
class User extends Fixture
{
    /**
     * @var EncoderFactoryInterface
     */
    private $encoder;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * User constructor.
     * @param EncoderFactoryInterface $encoder
     */
    public function __construct(EncoderFactoryInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     *
     * @return mixed
     */
//    protected function loadData(ObjectManager $manager)
//    {
//        $this->createMany(Users::class, 10, function (Users $user, $count) {
//            $user->
//            $user->setEmail($this->faker->email);
//            $user->setPassword($this->faker->password);
//            $user->setRoles(['ROLE_USER']);
//            $user->setImg($this->faker->imageUrl(1920, 1080, 'people', true, 'user'.$this->faker->unique(), false));
//            $user->setLastname($this->faker->lastName);
//            $user->setFirstname($this->faker->firstName);
//            $user->setNickname($this->faker->userName);
//            $user->setCreatedAt($this->faker->dateTimeBetween('-1 year', 'now'));
//            $user->setScore(($this->faker->numberBetween(1, 300) * 10) + 100);
//        });
//
//        $manager->flush();
//    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->encoder->getEncoder(\App\Domain\Models\User::class);

        $this->faker = Factory::create("fr_FR");

        for ($i = 0; $i < 20; $i++) {
            $user = new \App\Domain\Models\User(
                $this->faker->email,
                $this->faker->password,
                \Closure::fromCallable([$encoder, 'encodePassword']),
                ['ROLE_USER'],
                null,
                $this->faker->userName,
                $this->faker->firstName,
                $this->faker->lastName,
                $this->faker->imageUrl(1920, 1080, 'people', true, 'user', false),
                $this->faker->numberBetween(100, 22000),
                null
            );

            $manager->persist($user);
        }

        $manager->flush();
    }
}
