<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 14/06/2018
 * Time: 22:40
 */

namespace App\DataFixtures;

use App\Domain\Models\Observe as ObserveClassName;
use App\Domain\Models\TaxRef;
use App\Domain\Repository\TaxRefRepository;
use App\Domain\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Observe extends AbstractBaseFixture implements DependentFixtureInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var TaxRefRepository
     */
    private $taxRefRepository;

    /**
     * Observe constructor.
     * @param TaxRefRepository $taxRefRepository
     * @param UserRepository   $userRepository
     */
    public function __construct(
        TaxRefRepository $taxRefRepository,
        UserRepository $userRepository
    ) {
        $this->userRepository   = $userRepository;
        $this->taxRefRepository = $taxRefRepository;
    }
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            User::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager): void
    {
//        $this->user = array_rand($manager->getRepository(\App\Domain\Models\User::class)->findAll());

        $taxref = null;
        $this->createMany(ObserveClassName::class, 100, function (ObserveClassName $observe, $count) {
            /** @var TaxRef $taxref */
            while (!isset($taxref) || null === $taxref->getNomVern()) {
                $taxref = $this->taxRefRepository->findOneBy(['id' => rand(0, 100)]);
            }

            $rand      = array_rand($this->userRepository->findAll());
            $rand2     = array_rand($this->userRepository->findAll());
            $user      = $this->userRepository->findAll()[$rand];
            $validator = $this->userRepository->findAll()[$rand2];

            $indexes = [];
            for ($i = 0; $i < 10; $i++) {
                array_push($indexes, array_rand($this->userRepository->findAll()));
            }
            array_unique($indexes);

            $observe->setAuthor($user);
            if ($this->faker->boolean(85)) {
                $observe->setRef($taxref);
            }
            $observe->setLatitude($this->faker->latitude(42, 51));
            $observe->setDescription($this->faker->text);
            $observe->setLongitude($this->faker->longitude(-5, 8));
            $observe->setImg($this->faker->imageUrl(1920, 1080, 'animals', true, 'observe', false));
            if ($this->faker->boolean(75)) {
                $observe->setValidator($validator);
            }
            $date = $this->faker->dateTimeBetween('-1 year', 'now');
            $observe->setCreatedAt($date);
            $observe->setUpdatedAt($date);
            $observe->setObsDate($date);
            foreach ($indexes as $index) {
                $observe->addUpvoter($this->userRepository->findAll()[$index]);
            }
        });

        $manager->flush();
    }
}