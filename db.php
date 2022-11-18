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

    public function login($username, $password) {

        $hash = sha1($password);

        $sql = "SELECT COUNT(id) AS user_count FROM user WHERE username = '{$username}' AND password = '{$hash}'";

        try {
            $query = $this->connection->query($sql);
            $userExists = $query->fetch(\PDO::FETCH_ASSOC);
            if (intval($userExists['user_count']) === 1) {
                $user_id = $this->connection->query("SELECT id FROM user WHERE username = '{$username}' AND password = '{$hash}'")->fetch(\PDO::FETCH_ASSOC);
                return $user_id['id'];
            } else {
                return "Wrong credentials";
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function register($username, $password, $img, $first_name, $last_name) {
        $sql = "SELECT COUNT(id) AS user_count FROM user WHERE username = '{$username}'";

        try {
            $query = $this->connection->query($sql);
            $userExists = $query->fetch(\PDO::FETCH_ASSOC);

            if (intval($userExists['user_count']) === 0) {
                $hash = sha1($password);

                $this->connection->query("INSERT INTO user(username, password, img, first_name, last_name)
                                        VALUE('{$username}', '{$hash}','{$img}','{$first_name}','{$last_name}')");
                $user_id = $this->connection->query("SELECT id FROM user WHERE username = '{$username}' AND password = '{$hash}'")->fetch(\PDO::FETCH_ASSOC);
                return $user_id['id'];
            } else {
                return "Username already taken";
            }
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getCategories() {
        $categories = [];
        $sql = "SELECT * FROM category";

        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch()) {
                $categories[$row['category']] = $row['id'];
            }
            return  $categories;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function addPost($formData) {

        $postSql = "INSERT INTO post(title,content,img,created_at,updated_at,posted_by)
                    VALUE('{$formData['title']}','{$formData['content']}','{$formData['img']}', NOW(), NOW(), {$_SESSION['user_id']} )";

        try {
            $this->connection->query($postSql);
            $postId = $this->connection->lastInsertId();
            unset($formData['title']);
            unset($formData['content']);
            unset($formData['img']);
            foreach ($formData as $key => $value) {
                $categorySql = "INSERT INTO post_category(post_id, category_id) VALUE('{$postId}', '{$key}')";
                $this->connection->query($categorySql);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
