<?php

require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
$dao = new DAO();
$id = $_SESSION['userId'];

$body = '<h1>Videos</h1>';

if(isset($_POST['all'])){
    $result = $dao->getAllVideos();

    if ($result and $result->num_rows > 0) {
        $body .= createAllTable($result);
    }
    else{
        $body .= 'You have not added any videos yet. Please add a video. <br><br>';
    }

    $body .= '<form action="login.php">
                            <input type="submit" value="Go back"/>
                        </form>';

}
else {
    $result = $dao->getVideosForUser($id);
    if ($result and $result->num_rows > 0) {
        $body .= createTable($result);
    } else {
        $body .= 'You have not added any videos yet. Please add a video. <br><br>';
    }

    $body .= '<form action="submitVideo.php">
                            <input type="submit" value="Add a video"/>
                        </form>';
}



echo generatePage($body);

function createTable($videos){
    $body =  '<table border="1">';
    $body .= '<tr><td>Name</td><td>Author</td><td>Description</td><td>Category</td><td>Video</td><td>Date Added</td><td>Delete Video</td></tr>';
    while($row = mysqli_fetch_row($videos))
    {
        $body .= '<tr><td>'.$row[1].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[2].'</td>
        <form method="post" action="playVideo.php"><td><input type="hidden" name="video" value="'.$row[5].'"><input type="submit" value="Watch Video"></td></form>
        <td>'.$row[6].'</td>
        <form method="post" action="delete.php"><td><input type="hidden" name="title" value="'.$row[1].'"><input type="submit" value="Delete"></td></form></tr>';
    }
    $body .= '</table><br><br>';
    return $body;
}

function createAllTable($videos){
    $body =  '<table border="1">';
    $body .= '<tr><td>Name</td><td>Author</td><td>Description</td><td>Category</td><td>Video</td><td>Date Added</td></tr>';
    while($row = mysqli_fetch_row($videos))
    {
        $body .= '<tr><td>'.$row[1].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[2].'</td>
        <form method="post" action="playVideo.php"><td><input type="hidden" name="video" value="'.$row[5].'"><input type="submit" value="Watch Video"></td></form>
        <td>'.$row[6].'</td></tr>';
    }
    $body .= '</table><br><br>';
    return $body;
}

?>