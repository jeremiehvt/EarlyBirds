<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 16/07/2018
 * Time: 00:18
 */

namespace App\Command;

use App\Domain\Models\Badge;
use App\Domain\Repository\BadgeRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateBadgesCommand extends Command
{
    /**
     * @var BadgeRepository
     */
    private $repository;

    /**
     * UpdateBadgesCommand constructor.
     * @param BadgeRepository $repository
     */
    public function __construct(BadgeRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }
    protected function configure()
    {
        $this->setName('app:update-badges')
            ->setDescription('Update gamification badges')
            ->setHelp('This command update gamification badges');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Udating levels...");

        foreach ($this->repository->findAll() as $badge) {
            $removeState = $this->repository->remove($badge);
            if ($removeState) {
                $output->writeln("deleted badge ".$badge->getName());
            }
        }

        $newAccount = new Badge();

        $newAccount->setName('Compte créé');
        $newAccount->setPrice(100);

        $newAccountStatus = $this->repository->save($newAccount);
        if ($newAccountStatus) {
            $output->writeln("Created badge ".$newAccount->getName());
        }

        $observeCreated = new Badge();

        $observeCreated->setName('Première observation crée');
        $observeCreated->setPrice(20);

        $observeCreatedStatus = $this->repository->save($observeCreated);
        if ($observeCreatedStatus) {
            $output->writeln("Created badge ".$observeCreated->getName());
        }

        $observeValidated = new Badge();

        $observeValidated->setName('Première observation validée');
        $observeValidated->setPrice(40);

        $observeValidatedStatus = $this->repository->save($observeValidated);
        if ($observeValidatedStatus) {
            $output->writeln("Created badge ".$observeValidated->getName());
        }

        $output->writeln('Badges Updated');
    }
}
