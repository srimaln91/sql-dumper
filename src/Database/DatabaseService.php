<?php

namespace App\Database;

use App\Database\Connection;

class DatabaseService
{

    /**
     * @var App\Database\Connection
     */
    protected $connection;
    
    /**
     * @var string
     */
    protected $dumpPath;


    /**
     * @param Connection $connection
     * @param string $dumpPath
     */
    public function __construct(Connection $connection, $dumpPath)
    {

        $this->connection = $connection;
        $this->dumpPath = $dumpPath;
    }
        
}