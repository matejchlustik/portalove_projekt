<?php

namespace portalove;

class DB {
    private $host;
    private $dbName;
    private $username;
    private $password;
    private $port;

    private $connection;

    public function __construct($host, $dbName, $username, $password, $port = 3306) {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;

        try {
            $this->connection = new \PDO("mysql:host=$host;dbname=$dbName;port=$port", $username, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getMenuItems() {
        $menuItems = [];
        $sql = "SELECT * FROM menu";

        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch()) {
                $menuItems[] = [
                    'name' => $row['name'],
                    'url' => $row['url'],
                    'icon' => $row['icon']
                ];
            }
            return  $menuItems;
        } catch (\PDOException $e) {
            return [];
        }
    }
}
