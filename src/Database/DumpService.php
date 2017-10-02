<?php
namespace DBDump\Database;

use Symfony\Component\Process\Process;
use DBDump\Exception\EmptyDatabaseException;
use DBDump\Exception\NonEmptyDumpFolderException;
use DBDump\Lib\FileSystem;
use DBDump\Database\DatabaseService;

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
        $args = sprintf(
            '--user=%s --password=%s --host=%s %s -e "show tables;"',
            escapeshellarg($this->connection->getUserName()),
            escapeshellarg($this->connection->getPassword()),
            escapeshellarg($this->connection->getHostName()),
            escapeshellarg($this->connection->getDatabase())
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

        foreach ($tables as $table) {

            $args = sprintf(
                '--user=%s --password=%s --host=%s --lock-all-tables --skip-dump-date --skip-comments %s %s > %s',
                escapeshellarg($this->connection->getUserName()),
                escapeshellarg($this->connection->getPassword()),
                escapeshellarg($this->connection->getHostName()),
                escapeshellarg($this->connection->getDatabase()),
                escapeshellarg($table),
                escapeshellarg($this->dumpPath.$table.'.sql')
            );

            $process = new Process($this->binaries['mysqldump'].' '.$args);
            $process->run();
        }
    }
}
