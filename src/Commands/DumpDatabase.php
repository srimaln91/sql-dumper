<?php

namespace DBDump\Commands;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use DBDump\Database\Connection;
use DBDump\Database\DumpService;

class DumpDatabase extends Command
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
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct();
        $this->config = $container['config'];
        $this->connection = $container['connection'];
    }


    /**
     * Command configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('db:dump')
            ->setDescription("Create a database dump")
            ->setHelp("This command allows you to create a dump of current database");
    }


    /**
     * Command Execution
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->config->get('database.password');

        if (!file_exists($this->config->get('directory.db'))) {
            mkdir($this->config->get('directory.db'));
        }

        $dumpService = new DumpService(
            $this->connection,
            $this->config->get('binaries'),
            $this->config->get('directory.db')
        );

        try {
            $dumpService->dump();
            $output->writeln("<info>Successfully created a backup</info>");
        } catch (Exception $e) {
            $output->writeln("<error>Operation Unsuccessful</error>");
        }

    }
}
