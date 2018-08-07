<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 15/07/2018
 * Time: 14:41
 */

namespace App\Command;

use App\Domain\Models\Level;
use App\Domain\Repository\LevelRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateLevelsCommand extends Command
{
    /**
     * @var LevelRepository
     */
    private $repository;

    /**
     * UpdateLevelsCommand constructor.
     * @param LevelRepository $repository
     */
    public function __construct(LevelRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    protected function configure()
    {
        $this->setName('app:update-levels')
            ->setDescription('Update gamification levels')
            ->setHelp('This command update gamification levels');
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

        foreach ($this->repository->findAll() as $level) {
            $removeState = $this->repository->remove($level);
            if ($removeState) {
                $output->writeln("deleted level ".$level->getName());
            }
        }

        $debutant = new Level();

        $debutant->setName('Débutant');
        $debutant->setPoints(130);

        $debutantStatus = $this->repository->save($debutant);
        if ($debutant) {
            $output->writeln("created level ".$debutant->getName());
        }

        $roitelet = new Level();

        $roitelet->setName('Roitelet');
        $roitelet->setPoints(460);

        $roiteletStatus = $this->repository->save($roitelet);
        if ($roiteletStatus) {
            $output->writeln("created level ".$roitelet->getName());
        }

        $cacatoes = new Level();

        $cacatoes->setName('Cacatoès');
        $cacatoes->setPoints(820);

        $cactoesStatus = $this->repository->save($cacatoes);
        if ($cactoesStatus) {
            $output->writeln("created level ".$cacatoes->getName());
        }

        $toucan = new Level();

        $toucan->setName('Toucan');
        $toucan->setPoints(1540);

        $toucanStatus = $this->repository->save($toucan);
        if ($toucanStatus) {
            $output->writeln("created level ".$toucan->getName());
        }

        $hibou = new Level();

        $hibou->setName('Hibou');
        $hibou->setPoints(2260);

        $hibouStatus = $this->repository->save($hibou);
        if ($hibouStatus) {
            $output->writeln("created level ".$hibou->getName());
        }

        $heron = new Level();

        $heron->setName('Héron');
        $heron->setPoints(8100);

        $heronStatus = $this->repository->save($heron);
        if ($heronStatus) {
            $output->writeln("created level ".$heron->getName());
        }

        $cygne = new Level();

        $cygne->setName('Cygne');
        $cygne->setPoints(22000);

        $cygneStatus = $this->repository->save($cygne);
        if ($cygneStatus) {
            $output->writeln("created level ".$cygne->getName());
        }

        $phenix = new Level();

        $phenix->setName('Phénix');
        $phenix->setPoints(60000);

        $phenixStatus = $this->repository->save($phenix);
        if ($phenixStatus) {
            $output->writeln("created level ".$phenix->getName());
        }

        $output->writeln('Levels Updated');
    }
}