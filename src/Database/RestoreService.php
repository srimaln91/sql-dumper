<?php

namespace DBDump\Database;

use Symfony\Component\Process\Process;
use DBDump\Exception\EmptyDatabaseException;
use DBDump\Exception\NonEmptyDumpFolderException;
use DBDump\Lib\FileSystem;
use DBDump\Database\DatabaseService;
use DBDump\Exception\EmptyBackupDirectoryException;

class RestoreService extends DatabaseService
{

    public function restore()
    {
        //Get .sql files
        $files = FileSystem::getDirectory($this->dumpPath);

        if (false == $files) {
            throw new EmptyBackupDirectoryException('No .sql files found in the dorectory!');
            return;
        }

        foreach ($files as $file) {

            //Process only .sql files
            $info = pathinfo($this->dumpPath.'/'.$file);
            if ($info["extension"] != "sql") {
                break;
            }

            //Get list of tables
            $args = sprintf(
                "--user='%s' --password='%s' --host='%s' '%s' < '%s'",
                $this->connection->getUserName(),
                $this->connection->getPassword(),
                $this->connection->getHostName(),
                $this->connection->getDatabase(),
                $this->dumpPath.'/'.$file
            );

            $process = new Process($this->binaries['mysql'].' '.$args);
            $process->run();

        }

    }
}
