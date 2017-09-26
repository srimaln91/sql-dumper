<?php
namespace App\Database;

use App\Datbase\Connection;

class DumpService 
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function dump()
    {

    }
}
