<?php

namespace App\database;

use Exception;
use PDO;
use PDOException;
require_once dirname(__DIR__) . '\config\envs.plugin.php';

class Mysql
{    
    private $database;
    private $username;
    private $host;
    private $password;    

    public function __construct()
    {
        $this->host = $_ENV['MYSQL_HOST'];
        $this->database = $_ENV['MYSQL_DATABASE'];
        $this->username = $_ENV['MYSQL_USERNAME'];
        $this->password = $_ENV['MYSQL_PASSWORD'];
    }

    public function connect(): ?PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database}";                

        try {
            return ( new PDO($dsn, $this->username, $this->password ) );
        } catch (PDOException $e) {
            throw new Exception('Error in database connection. ' . $e);
        }
    }    

}
