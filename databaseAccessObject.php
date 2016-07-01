<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/29/2016
 * Time: 7:37 PM
 */

/**
 * Class DAO creates abstraction and handles all database connections
 */
class DAO {
    private $host = "localhost";
    private $user = "group";
    private $password = "terps";
    private $database = "videoappdb";

    /**
     * @return bool|mysqli establishes connection
     */
    private function setConnection(){
        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($db->connect_error) {
            return false;
        }

        return $db;
    }

    /**
     * @param $username user's username
     * @param $psw user's password
     * @param $img profile pick
     * @param $type image file type
     */
    public function insertNewUser($username, $psw, $img, $type) {
        $conn = $this->setConnection();
        $fileData = addslashes(file_get_contents($img));
        $query = "insert into users (name, password, profile_pic, image_type) values ('{$username}', '{$psw}', '{$fileData}', '{$type}')";
        $conn->query($query);
        $id = $conn->insert_id;
        $conn->close();

        return $id;
    }

    public function login($username, $psw) {
        $conn = $this->setConnection();
        $query = "select * from users where name='{$username}' and password='{$psw}'";

        $result = $conn->query($query);
        $conn->close();

        return $result;
    }

    public function getUser($id) {
        $conn = $this->setConnection();
        $query = "select * from users where id='{$id}'";
        $result = $conn->query($query);
        $conn->close();

        return $result;
    }
}