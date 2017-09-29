<?php

namespace DBDump\Database;

use DBDump\Database\Connection;

class DatabaseService
{

    /**
     * @var DBDump\Database\Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $dumpPath;

    /**
     * @var array
     */
    protected $binaries;


    /**
     * @param Connection $connection
     * @param string $dumpPath
     */
    public function __construct(Connection $connection, array $binaries, $dumpPath)
    {

        $this->connection = $connection;
        $this->dumpPath = $dumpPath;
        $this->binaries = $binaries;

    }
}
