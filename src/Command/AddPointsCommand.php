<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/07/2018
 * Time: 14:41
 */

namespace App\Command;

use App\Domain\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AddPointsCommand
 */
class AddPointsCommand extends Command
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * AddPointsCommand constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('app:add-points')
            ->setDescription('Add points to an user')
            ->setHelp('This command add gamification points to an user')
            ->addArgument(
                'user-mail',
                InputArgument::REQUIRED,
                'User mail to add points'
            )
            ->addArgument(
                'nb-of-points',
                InputArgument::OPTIONAL,
                'Number of points to add at the selected user',
                0
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
        $inputUser  = $input->getArgument('user-mail');
        $pointToAdd = $input->getArgument('nb-of-points');

        $user = $this->repository->findOneBy(['email' => $inputUser]);

        if ($user) {
            $score = $user->getScore();
            if (!$score) {
                $score = 0;
            }
            $newScore = $score + $pointToAdd;
            if ($newScore >= 0) {
                $user->setScore($newScore);
                $this->repository->update();

                $output->writeln($pointToAdd.' points succesfully added to '.$inputUser);
                $output->writeln('New score: '.$newScore);
            } else {
                $output->writeln('Amount '.$pointToAdd.' is not correct');
            }
        } else {
            $output->writeln('user '.$inputUser.' not found');
            $output->writeln('Please enter a valid registred user mail');
        }
    }
}
