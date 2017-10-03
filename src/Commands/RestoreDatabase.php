<?php

namespace DBDump\Commands;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DBDump\Database\Connection;
use DBDump\Database\RestoreService;
use DBDump\Lib\FileSystem;

class RestoreDatabase extends Command
{
    /**
     * @var DBDump\Lib\Config
     */
    protected $config;


    /**
     * @var DBDump\Database\Connection
     */
    protected $connection;


    /**
     * @param Pimple\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct();
        $this->config = $container['config'];
        $this->connection = $container['connection'];
    }


    /**
     * Command Configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('db:restore')
        ->setDescription("Restore a database dump")
        ->setHelp("This command allows you to restore a database dump")
        ->addArgument('db_dir', InputArgument::OPTIONAL, 'Please tell me where your db backup files stored?');
    }


    /**
     * Execute a command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Get backup directory
        $dbBackupDir = $input->getArgument('db_dir');
        $dbBackupDir = ($dbBackupDir == null) ? $this->config->get('directory.db') : $dbBackupDir ;

        if (FileSystem::isDirEmpty($dbBackupDir)) {

            $output->writeln("<error>Dump directory is empty!</error>");
            return;
        }

        $restoreService = new RestoreService(
            $this->connection,
            $this->config->get('binaries'),
            $dbBackupDir
        );

        try {
            $restoreService->restore();
            $output->writeln("<info>Successfully restored.</info>");
        } catch (Exception $e) {
            $output->writeln("<error>{ $e->getMessage() }</error>");
        }
    }
}
