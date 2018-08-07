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
 * Class UpgradeUserCommand
 */
class UpgradeUserCommand extends Command
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
        $this->setName('app:upgrade-user')
            ->setDescription('Upgrade an User to Admin')
            ->setHelp('This command upgrade an User to Admin')
            ->addArgument(
                'user-mail',
                InputArgument::REQUIRED,
                'User mail to upgrade'
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
        $inputUser = $input->getArgument('user-mail');
        $user      = $this->repository->findOneBy(['email' => $inputUser]);

        if ($user) {
            $output->writeln("User found");

            if (!in_array("ROLE_ADMIN", $user->getRoles())) {
                $output->writeln("Upgrading user...");
                $user->addRole("ROLE_ADMIN");
                $status = $this->repository->update();
            } else {
                $output->writeln('User has already role Admin');
                $status = false;
            }

            if ($status) {
                $output->writeln($inputUser.' is now Admin');
            }
        } else {
            $output->writeln('user '.$inputUser.' not found');
            $output->writeln('Please enter a valid registred user mail');
        }
    }
}
