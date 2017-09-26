<?php

namespace App\Commands;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Yaml\Yaml;
use App\Database\Connection;
use App\Database\DumpService;

class DumpDatabase extends Command 
{
    
    protected $processBuilder;
    protected $config;
    protected $connection;

    public function __construct(Container $container)
    {
        parent::__construct();
        $this->processBuilder = new ProcessBuilder();
        $this->config = $container['config'];
        $this->connection = $container['connection'];
    }

    protected function configure()
    {
        $this->setName('db:dump')
            ->setDescription("Create a database dump")
            ->setHelp("This command allows you to create a dump of current database");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->config->get('database.password');

        if(!file_exists($this->config->get('directory.db'))){
            mkdir($this->config->get('directory.db'));
        }

        $dumpService = new DumpService($this->connection, $this->config->get('directory.db'));
        $dumpService->dump();

    }
}
