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

    public function getPosts() {
        $posts = [];
        $sql = "SELECT post.id, post.title, post.content, post.img, post.created_at, post.posted_by, category.category, user.first_name, user.last_name
                FROM post 
                INNER JOIN post_category ON post.id = post_category.post_id
                INNER JOIN category ON post_category.category_id = category.id
                INNER JOIN user ON post.posted_by = user.id";
        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                if (isset($posts[$row['id']])) {
                    $posts[$row['id']]['categories'][] = $row['category'];
                } else {
                    $posts[$row['id']] = [
                        'categories' => [
                            $row['category']
                        ],
                        'title' => $row['title'],
                        'content' => $row['content'],
                        'img' => $row['img'],
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'created_at' => $row['created_at']
                    ];
                }
            }
            return  $posts;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getPost($id) {
        $post = [];
        $sql = "SELECT post.id, post.title, post.content, post.img, post.created_at, post.posted_by, category.category, user.first_name, user.last_name
                FROM post 
                INNER JOIN post_category ON post.id = post_category.post_id
                INNER JOIN category ON post_category.category_id = category.id
                INNER JOIN user ON post.posted_by = user.id
                WHERE post.id = {$id}";
        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                if (isset($post['title'])) {
                    $post['categories'][] = $row['category'];
                } else {
                    $post = [
                        'categories' => [
                            $row['category']
                        ],
                        'title' => $row['title'],
                        'content' => $row['content'],
                        'img' => $row['img'],
                        'first_name' => $row['first_name'],
                        'last_name' => $row['last_name'],
                        'created_at' => $row['created_at']
                    ];
                }
            }
            return  $post;
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getPostsByUser($userId) {
        $sql = "SELECT * FROM post WHERE posted_by = {$userId}";
        $posts = [];
        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                $posts[$row['id']] = [
                    'id' => $row['id'],
                    'created_at' => $row['created_at'],
                    'title' => $row['title'],
                ];
            }

            return $posts;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function deletePost($postId) {
        $sql = "DELETE FROM post WHERE id = {$postId}";

        try {
            $this->connection->query($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function updatePost($formData, $postId) {

        $sqlPost = "UPDATE post 
                    SET title = '{$formData['title']}', content = '{$formData['content']}',img = '{$formData['img']}', updated_at = NOW()
                    WHERE id = {$postId}";
        try {
            $this->connection->query($sqlPost);
            $this->connection->query("DELETE FROM post_category WHERE post_id = {$postId}");
            unset($formData['title']);
            unset($formData['content']);
            unset($formData['img']);
            unset($formData['submit']);
            foreach ($formData as $key => $value) {
                $categorySql = "INSERT INTO post_category(post_id, category_id) VALUE('{$postId}', '{$key}')";
                $this->connection->query($categorySql);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function addComment($comment, $postId) {
        $sql = "INSERT INTO comment(content,created_at,updated_at,post,comment_by)
                VALUE('{$comment}', NOW(), NOW(), '{$postId}', '{$_SESSION['user_id']}')";
        try {
            $this->connection->query($sql);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getComments($postId) {
        $sql = "SELECT * FROM comment WHERE post = {$postId}";
        $comments = [];
        try {
            $query = $this->connection->query($sql);
            while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {

                $userId = $row['comment_by'];
                $userSql = "SELECT * FROM user WHERE id = {$userId}";
                $userQuery = $this->connection->query($userSql);
                $user = $userQuery->fetch(\PDO::FETCH_ASSOC);

                $comments[$row['id']] = [
                    'content' => $row['content'],
                    'created_at' => $row['created_at'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'img' => $user['img']
                ];
            }

            return $comments;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
