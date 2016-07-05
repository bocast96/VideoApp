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

    /**
     * @param $userId user's id
     * @param $url video url to store
     */
    public function storeVideo ($userId, $title, $genre, $author, $desc, $url) {
        $conn = $this->setConnection();
        $date = date('Y-m-d H:i:s');
        
        $query = 
                "INSERT INTO videos (
                    userId,
                    title,
                    genre,
                    author,
                    description,
                    link,
                    date_added
                )
                 VALUES (
                     '{$userId}',  
                     '{$title}', 
                     '{$genre}', 
                     '{$author}',
                     '{$desc}',
                     '{$url}',
                     '{$date}' 
                 )";

        $result =  $conn->query($query);
        $conn->close();

        if ($result) {
            return $result;
        } else{
            return $query;
        }

    }

    /**
     * @param $userId user's id
     * @param $descriptor value that identifies video. 
     * @return array of video columns
    */
    public function fetchVideo ($userId, $descriptor) {
        $conn = $this->setConnection();
        $column = ((gettype($descriptor) == "string") ? "title" : "userVideoId");
        $query = 
                "SELECT * 
                 FROM videos
                 WHERE userId='{$userId}'
                 AND {$column}='{$descriptor}'";
        $result = $conn->query($query);
        $conn->close();

        return (($result) ? $result->fetch_array() : $result);
        //return $query;
    }

    /**
     * @param $userId user's id
     * @param $descriptor value that identifies video. 
     * can be title string or index integer 
    */
    public function deleteVideo ($userId, $descriptor) {
        $conn = $this->setConnection();
        //$endIndex = maxVideoIndexForUser ($user);
        $column = ((gettype($descriptor) == "string") ? "title" : "userVideoId");
        $query = 
                "DELETE FROM videos
                 WHERE userId='{$userId}'
                 AND '{$column}'='{$descriptor}'";
        $result = $conn->query($query);
        $conn->close();

        return $result;
    }

    public function getVideosForUser ($userId) {
        $conn = $this->setConnection();
        $query = 
                "SELECT * 
                 FROM videos
                 WHERE userId='{$userId}'";
        $result = $conn->query($query);
        $conn->close();

        return $result;
    }

}