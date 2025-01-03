<?php

require_once __DIR__ . "/../config/database.php";

class UserModel
{

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    private $conn;

    function __construct($username = null, $email = null, $password = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
        $this->role = "user";
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * Searches for user by provided id
     * @param string $id user id
     * @return void
     */
    function getById($id)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE id = '$id';");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $this->id = $result["id"];
            $this->username = $result["name"];
            $this->email = $result["email"];
            $this->password = $result["password"];
            $this->role = $result["role"];
        }
    }

    /**
     * Searches for user by probided email
     * @param string $email
     * @return void
     */
    function getByEmail($email)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE email='$email';");
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $this->id = $result["id"];
            $this->username = $result["name"];
            $this->email = $result["email"];
            $this->password = $result["password"];
            $this->role = $result["role"];
        }
    }

    /**
     * Adds user class to database
     * @return void
     */
    function add()
    {
        if (!$this->id) {
            $this->id = uniqid();
            $query = $this->conn->prepare("INSERT INTO users 
                (id, name, email, password, role) VALUES 
                ('$this->id', '$this->username', '$this->email', '$this->password', '$this->role');");

            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Removes user and ALL sets and cards owned by him
     * @return void
     */
    function remove()
    {
        $query = $this->conn->prepare("DELETE FROM users
        WHERE id='$this->id';");
        $query->execute();

        $query = $this->conn->prepare("SELECT * FROM card_sets
        WHERE author_id='$this->id';");
        $query->execute();

        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $r) {
            $set = new Set();
            $set->find_by_id($r["id"]);
            $set->remove();
        }
    }

    /**
     * Checks if this user exists in database
     * @return bool true if exists
     */
    function exists()
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE
        id = '$this->id'");
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        return ($results && $results["id"] == $this->id);
    }

    /**
     * Checks if user has role admin
     * @return bool true if is admin
     */
    function isAdmin()
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE
        id = '$this->id'");
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        return ($results && $results["id"] == $this->id && $results["role"] == "admin");
    }

    /**
     * returns array with all users with role "user"
     * @return array all found users
     */
    function getAll()
    {
        $query = $this->conn->prepare("SELECT * FROM users
        WHERE role='user';");
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        $usersArr = [];
        foreach ($results as $r) {
            $user = new UserModel();
            $user->getById($r["id"]);
            array_push($usersArr, $user);
        }

        return $usersArr;
    }
}
