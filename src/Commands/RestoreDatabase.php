<?php

namespace DBDump\Commands;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
        ->setHelp("This command allows you to restore a database dump");
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

        if (FileSystem::isDirEmpty($this->config->get('directory.db'))) {

            $output->writeln("<error>Dump directory is empty!</error>");
            return;
        }

        $restoreService = new RestoreService(
            $this->connection,
            $this->config->get('binaries'),
            $this->config->get('directory.db')
        );

        try {
            $restoreService->restore();
            $output->writeln("<info>Successfully restored.</info>");
        } catch (Exception $e) {
            $output->writeln("<error>{ $e->getMessage() }</error>");
        }
    }
}
