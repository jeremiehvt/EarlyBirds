<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 20/07/2018
 * Time: 18:20
 */

namespace App\DataFixtures;

use App\Domain\Repository\UserRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Post extends AbstractBaseFixture implements DependentFixtureInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Post constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
     *
     * @return mixed
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(\App\Domain\Models\Post::class, 20, function (\App\Domain\Models\Post $post, $count) {

            $rand   = array_rand($this->userRepository->findAll());
            $author = $this->userRepository->findAll()[$rand];

            $post->setImg($this->faker->imageUrl(1920, 1080, 'nature', true, 'post', false));
            $post->setCategory("fixtures");
            $post->setAuthor($author);
            $post->setContent($this->faker->paragraph(10));
            $post->setTitle($this->faker->sentence(4));
        });

        $manager->flush();
    }


}
