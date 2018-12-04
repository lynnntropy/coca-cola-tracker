<?php

namespace App\Command;

use App\Service\SnapshotService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TakeSnapshotCommand extends Command
{
    protected static $defaultName = 'app:take-snapshot';

    /**
     * @var SnapshotService
     */
    private $snapshotService;

    /**
     * TakeSnapshotCommand constructor.
     */
    public function __construct(SnapshotService $snapshotService)
    {
        $this->snapshotService = $snapshotService;

        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription('Updates the rewards and takes snapshots of their quantities.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->snapshotService->takeSnapshot();

        $io->success('Snapshot successfully taken.');
    }
}
