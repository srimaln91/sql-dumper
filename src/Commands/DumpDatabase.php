<?php

namespace App\Commands;

use Pimple\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Yaml\Yaml;
use App\Lib\Runner;

class DumpDatabase extends Command 
{
    
    protected $processBuilder;
    protected $config;
    protected $connection;

    public function __construct(Container $container)
    {
        parent::__construct();
        $this->processBuilder = new ProcessBuilder();
        $this->config = $container->get('config');
        $this->connection = $container->get('connection');
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
        
        // $this->processBuilder->setPrefix($this->config->get('binaries.mysql'))
        //     ->setArguments(['-h', $this->config->get('database.host')] )
        //     ->setArguments(['-u', $this->config->get('database.user')] )
        //     ->setArguments([ $this->config->get('database.database')] )
        //     ->setArguments(['-p', $this->config->get('database.password')] )
        //     ->setArguments(['--add-drop-table'] )
        //     ->setArguments(['>', $this->config->get('directory.db')] );

        $runner = new Runner($input, $output, $this->processBuilder);
        $runner->run();

    }

}
