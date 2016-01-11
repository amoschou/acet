<?php

/*
  This class from Stack Overflow:
  http://stackoverflow.com/questions/2047264/use-of-pdo-in-classes
  and is attributed to Guillaume Boschini
  (http://stackoverflow.com/users/246248/guillaume-boschini)
  licenced under CC BY-SA 3.0 (http://creativecommons.org/licenses/by-sa/3.0/)
  with attribution required.
  This file is also distributed under the same license.
*/

class Core
{
    public $dbh; // handle of the db connexion
    private static $instance;

    private function __construct()
    {
        // building data source name from config
        $dsn = Config::read('db.prefix').':host=' . Config::read('db.host') .
               ';dbname='    . Config::read('db.basename') .
               ';port='      . Config::read('db.port') .
               ';connect_timeout=15';
        // getting DB user from config                
        $user = Config::read('db.user');
        // getting DB password from config                
        $password = Config::read('db.password');

        $this->dbh = new PDO($dsn, $user, $password);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }

    // others global functions
}