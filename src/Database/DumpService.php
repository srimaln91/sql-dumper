<?php
namespace App\Database;

use App\Datbase\Connection;
use Symfony\Component\Process\Process;

class DumpService 
{
    protected $connection;
    protected $dumpPath;

    public function __construct(Connection $connection, $dumpPath)
    {

        $this->connection = $connection;
        $this->dumpPath = $dumpPath;
    }

    public function dump()
    {
        $command = sprintf(
            'mysqldump --user="%s" --password="%s" --host="%s" --lock-all-tables "%s" > "%s"',
            $this->connection->getUserName(),
            $this->connection->getPassword(),
            $this->connection->getHostName(),
            $this->connection->getDatabase(),
            $this->dumpPath
        );
        $process = new Process($command);
        $process->run();

    }
}
