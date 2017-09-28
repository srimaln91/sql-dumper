<?php
namespace App\Database;

use Symfony\Component\Process\Process;
use App\Exception\EmptyDatabaseException;
use App\Exception\NonEmptyDumpFolderException;
use App\Lib\FileSystem;
use App\Database\DatabaseService;

class DumpService extends DatabaseService
{

    /**
     * Create a database dump
     *
     * @return void
     */
    public function dump()
    {
        //Get list of tables
        $args = sprintf('--user="%s" --password="%s" --host="%s" "%s" -e "show tables;"',
            $this->connection->getUserName(),
            $this->connection->getPassword(),
            $this->connection->getHostName(),
            $this->connection->getDatabase()
        );

        $process = new Process($this->binaries['mysql'].' '.$args);
        $process->run();
        $response =  $process->getOutput();

        //Slice command response to array of database tables
        $tables = array_slice(explode(PHP_EOL, $response), 1, -1);
        
        //Check for empty databases
        if (empty($tables)) {
            throw new EmptyDatabaseException("There are no tables in the database.");
            return false;
        }

        //Remove comments if we are going to overwrite existing backups
        // if (! FileSystem::isDirEmpty($this->dumpPath) ) {
        //     throw new NonEmptyDumpFolderException($this->dumpPath." is not empty.");
        //     return false;
        // }
        
        foreach($tables as $table){
            
            $args = sprintf(
                '--user="%s" --password="%s" --host="%s" --lock-all-tables --skip-dump-date "%s" "%s" > "%s"',
                $this->connection->getUserName(),
                $this->connection->getPassword(),
                $this->connection->getHostName(),
                $this->connection->getDatabase(),
                $table,
                $this->dumpPath.$table.'.sql'
            );

            $process = new Process($this->binaries['mysqldump'].' '.$args);
            $process->run();
        }
    }
}
