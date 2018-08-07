<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/07/2018
 * Time: 23:52
 */

namespace App\Services;

use App\Domain\Models\User;
use App\Domain\Repository\LevelRepository;
use App\Domain\Repository\UserRepository;

/**
 * Class Gamification
 */
class Gamification
{
    /**
     * @var LevelRepository
     */
    private $levelRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Gamification constructor.
     * @param LevelRepository $levelRepository
     * @param UserRepository  $userRepository
     */
    public function __construct(
        LevelRepository $levelRepository,
        UserRepository $userRepository
    ) {
        $this->levelRepository = $levelRepository;
        $this->userRepository  = $userRepository;
    }

    public function getLevel(User $user)
    {
        $levels = $this->levelRepository->findAllOrderByPrice();

        $userScore = $user->getScore();
        if (!$userScore) {
            $userScore = 0;

            $user->setScore($userScore);
            $this->userRepository->update();
        }

        $level['level']         = $this->getActualLevel($levels, $userScore);
        $level['nextLevel']     = $this->nextLevel($levels, $userScore);
        $level['previousLevel'] = $this->previousLevel($levels, $userScore);

        return $level;
    }

    /**
     * @param array    $levels
     * @param int|null $userScore
     *
     * @return mixed
     */
    public function getActualLevel(array $levels, int $userScore)
    {
        foreach ($levels as $level) {
            if ($level->getPoints() > $userScore) {
                $levelReturned = $level;
            }
            if (isset($levelReturned)) {
                return $levelReturned;
            }
        }

        return false;
    }

    /**
     * @param array $levels
     * @param int   $userScore
     *
     * @return mixed
     */
    public function nextLevel(array $levels, int $userScore)
    {
        $index = 0;
        foreach ($levels as $level) {
            if ($level->getPoints() > $userScore) {
                $levelReturned = $level;
                $index         = $index + 1;
            }
            if (isset($levelReturned) && 2 === $index) {
                return $levelReturned;
            }
        }

        return false;
    }

    /**
     * @param array $levels
     * @param int   $userScore
     *
     * @return mixed
     */
    public function previousLevel(array $levels, int $userScore)
    {
        foreach ($levels as $level) {
            if ($level->getPoints() <= $userScore) {
                $levelReturned = $level;
            }
        }
        if (!isset($levelReturned)) {
            return null;
        }

        return $levelReturned;
    }
}
