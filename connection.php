<?php

class Database
{

    public static $connection;

    public static function setUpConnection()
    {
        if (!isset(Database::$connection)) {
            require __DIR__ . '/vendor/autoload.php';

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            $db_host = $_ENV['DB_HOST'];
            $db_username = $_ENV['DB_USERNAME'];
            $db_password = $_ENV['DB_PASSWORD'];
            $db_name = $_ENV['DB_NAME'];
            Database::$connection = new mysqli($db_host, $db_username, $db_password, $db_name, 3306);
        }
    }

    public static function search($query)
    {
        Database::setUpConnection();
        $rs = Database::$connection->query($query);
        return $rs;
    }

    public static function iud($query)
    {
        Database::setUpConnection();
        Database::$connection->query($query);
    }
}
