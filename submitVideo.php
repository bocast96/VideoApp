<?php

require_once "suppor.php";
require_once "databaseAccessObject.php";

session_start();


if (!isset($_POST['submit'])){
    if ($_SESSION['userId']) {
            $body = <<<BOD
        <form action="submitVideo.php" method="post" enctype="multipart/form-data">
        <p>
            <h1>Submit Video</h1>
        </p>
        <p>
            Title: <input type="text" name="title" maxlength="50" required /><br>
            Author: <input type="text" name="author" maxlength="20" /><br>
            Description: <input type="text" name="description" maxlength="200" /><br>
            Video URL: <input type="text" name="link" maxlength="200" /><br>
            Genre: <br>
            <input type="radio" name="genre" id="genre" value='music'/> Music
            <input type="radio" name="genre" id="genre" value='news'/> News
            <input type="radio" name="genre" id="genre" value='sports'/> Sports
            <input type="radio" name="genre" id="genre" value='DIY'/> DIY
            <input type="radio" name="genre" id="genre" value='comedy'/> Comedy
            <input type="radio" name="genre" id="genre" value='art'/> Art
            <input type="radio" name="genre" id="genre" value='science'/> Science
            <input type="radio" name="genre" id="genre" value='misc'/> Misc
        <p>
            <input type="submit" name="submit"/>
        </p>
    </form>
BOD;
    
    } else {
        $body = <<<BOD
        <form action='index.html'>
            <h1>Not logged in</h1>
            <p>Please return to the main menu</p>
            <p>
                <input type='submit' name='begin' value='Main Menu' />
            </p>
        </form>
BOD;
    }
    echo generatePage($body);
} else {
     if ($_SESSION['userId']) {
         $userId = $_SESSION['userId'];
         $title = $_POST['title'];
         $genre = $_POST['genre'];
         $author = $_POST['author'];
         $description = $_POST['description'];
         $link =$_POST['link'];

         $dao = new DAO();
         $result = $dao->storeVideo($userId, $title, $genre, $author, $description, $link);
        $body = <<<BOD
        <form action="videoTable.php">
            <p>
                <h1>Video Uploaded</h1>
            </p>
            <p>
            <p>
                <input value="Go To Videos" type="submit" name="submit"/>
            </p>
        </form>
BOD;
    
    } else {
        $body = <<<BOD
        <form action='index.html'>
            <h1>Not logged in</h1>
            <p>Please return to the main menu</p>
            <p>
                <input type='submit' name='begin' value='Main Menu' />
            </p>
        </form>
BOD;

    
    }

    echo generatePage($body);

}