<?php
namespace App\Database;

class Connection
{

    /**
     * @var string
     */
    private $hostname;


    /**
     * @var int
     */
    private $port = 3306;

    
    /**
     * @var string
     */
    private $database;


    /**
     * @var string
     */
    private $username;


    /**
     * @var string
     */
    private $password;


    /**
     * @return string
     */
    public function getHostName()
    {
        return $this->hostname;
    }



    /**
     * @param string $hostname
     * @return void
     */
    public function setHostName($hostname)
    {
        $this->hostname = $hostname;
    }



    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }



    /**
     * @param int $port
     * @return void
     */
    public function setPort($port)
    {
        $this->port = $port;
    }



    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }



    /**
     * @param string $database
     * @return void
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }



    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->username;
    }


    /**
     * @param string $username
     * @return void
     */
    public function setUserName($username)
    {
        $this->username = $username;
    }



    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }



    /**
     * @param string $password
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
