<?php

namespace DBDump\Lib;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Runner
{

    private $processBuilder;
    private $input;
    private $output;

    public function __construct(InputInterface $input, OutputInterface $output, ProcessBuilder $processBuilder)
    {
        $this->processBuilder = $processBuilder;
        $this->input = $input;
        $this->output = $output;
    }

    public function run()
    {
        $process = $this->processBuilder->getProcess();

        try {

            $process->mustRun();
            $this->output->writeln($process->getOutput());

        } catch (ProcessFailedException $e) {

            $this->output->writeln('<error>'.$e->getMessage().'</error>');

        }
    }
}
