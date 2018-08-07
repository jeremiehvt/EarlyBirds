<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 20/07/2018
 * Time: 12:37
 */

namespace App\Command;

use App\Domain\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemovePointsCommand extends Command
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * RemovePointsCommand constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function configure(): void
    {
        $this->setName('app:remove-points')
            ->setDescription('Remove points to an user')
            ->setHelp('This command remove gamification points to an user')
            ->addArgument(
                'user-mail',
                InputArgument::REQUIRED,
                'User mail to remove points'
            )
            ->addArgument(
                'nb-of-points',
                InputArgument::REQUIRED,
                'Number of points to remove at the selected user'
            )
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputUser      = $input->getArgument('user-mail');
        $pointsToRemove = $input->getArgument('nb-of-points');

        $user = $this->repository->findOneBy(['email' => $inputUser]);

        if ($user) {
            $score = $user->getScore();
            if (!$score) {
                $score = 0;
            }
            if ("all" === $pointsToRemove) {
                $newScore = 0;
            } else {
                $newScore = $score - $pointsToRemove;
            }
            if ($newScore >= 0) {
                $user->setScore($newScore);
                $this->repository->update();

                $output->writeln($pointsToRemove.' points succesfully removed to '.$inputUser);
                $output->writeln('New score: '.$newScore);
            } else {
                $output->writeln('Amount '.$pointsToRemove.' is not correct');
            }
        } else {
            $output->writeln('user '.$inputUser.' not found');
            $output->writeln('Please enter a valid registred user mail');
        }
    }
}