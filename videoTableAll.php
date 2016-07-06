<?php
require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
$dao = new DAO();
$id = $_SESSION['userId'];
$genres = array();
$body = '<h1>Videos</h1>';
$script = $_SERVER["PHP_SELF"];
$htmlcode = <<<EOBODY
            <form action="$script" method="post">
            <fieldset>
            <legend><em>Genres</em></legend>
            <input type="checkbox" name="music" value="music">Music
            <input type="checkbox" name="news" value="news">News
            <input type="checkbox" name="sports" value="sports">Sports
            <input type="checkbox" name="diy" value="DIY">DIY
            <input type="checkbox" name="comedy" value="comedy">Comedy
            <input type="checkbox" name="art" value="art">Art
            <input type="checkbox" name="science" value="science">Science
            <input type="checkbox" name="misc" value="misc">Misc
            <input type="submit" name="filter" value="Search"/>
        </fieldset></form><br>
EOBODY;
$body = $htmlcode . $body;

if(isset($_POST['music'])){
    array_push($genres, "music");
}
if(isset($_POST['news'])){
    array_push($genres, "news");
}
if(isset($_POST['sports'])){
    array_push($genres, "sports");
}
if(isset($_POST['diy'])){
    array_push($genres, "DIY");
}
if(isset($_POST['comedy'])){
    array_push($genres, "comedy");
}
if(isset($_POST['art'])){
    array_push($genres, "art");
}
if(isset($_POST['science'])){
    array_push($genres, "science");
}
if(isset($_POST['misc'])){
    array_push($genres, "misc");
}

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

}else if((isset($_POST['music']) || isset($_POST['news']) || isset($_POST['sports']) || isset($_POST['diy']) || isset($_POST['comedy'])
    || isset($_POST['art']) || isset($_POST['science']) || isset($_POST['misc']))) {
    $genre = "'".implode("','", $genres)."'";
    $result = $dao->fetchVideoAll($genre);
    if ($result and $result->num_rows > 0) {
        $body .= "Genre(s): " .$genre;
        $body .= createAllTable($result);
    } else {
        $body .= "Genre(s): " .$genre. '<br>';
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
