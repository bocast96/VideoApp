<?php
require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
$dao = new DAO();
$id = $_SESSION['userId'];

$body = '<h1>Videos</h1>';
$script = $_SERVER["PHP_SELF"];
$htmlcode = <<<EOBODY
            <form action="$script" method="post">
            <fieldset>
            <legend><em>Genres</em></legend>
            <input type="radio" name="genre" value="music">Music
            <input type="radio" name="genre" value="news">News
            <input type="radio" name="genre" value="sports">Sports
            <input type="radio" name="genre" value="DIY">DIY
            <input type="radio" name="genre" value="comedy">Comedy
            <input type="radio" name="genre" value="art">Art
            <input type="radio" name="genre" value="science">Science
            <input type="radio" name="genre" value="misc">Misc
            <input type="submit" name="filter" value="Search"/>
        </fieldset></form><br>
EOBODY;
$body = $htmlcode . $body;

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

}else if(isset($_POST['genre'])) {
    $genre = $_POST['genre'];
    $result = $dao->fetchVideoAll($genre);
    if ($result and $result->num_rows > 0) {
        $body .= "Genre: " .$genre;
        $body .= createAllTable($result);
    } else {
        $body .= "Genre: " .$genre. '<br>';
        $body .= 'You have not added any videos yet. Please add a video. <br><br>';
    }

    $body .= '<form action="login.php">
                            <input type="submit" value="Go back"/>
                        </form>';
}

echo generatePage($body);

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
