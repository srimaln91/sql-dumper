<?php

namespace App\Database;

use Symfony\Component\Process\Process;
use App\Exception\EmptyDatabaseException;
use App\Exception\NonEmptyDumpFolderException;
use App\Lib\FileSystem;
use App\Database\DatabaseService;
use App\Exception\EmptyBackupDirectoryException;

class RestoreService extends DatabaseService
{

    public function restore()
    {
        //Get .sql files
        $files = FileSystem::getDirectory($this->dumpPath);

        if( false == $files){
            throw new EmptyBackupDirectoryException('No .sql files found in the dorectory!');
            return;
        }

        foreach ($files as $file){
            
            //Get list of tables
            $command = sprintf('/usr/bin/mysql --user="%s" --password="%s" --host="%s" "%s" < "%s"',
                $this->connection->getUserName(),
                $this->connection->getPassword(),
                $this->connection->getHostName(),
                $this->connection->getDatabase(),
                $this->dumpPath.'/'.$file
            );

            $process = new Process($command);
            $process->run();

        }

    }
}