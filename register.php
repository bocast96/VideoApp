<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/29/2016
 * Time: 8:36 PM
 */
require_once "suppor.php";
require_once "databaseAccessObject.php";

if (isset($_POST['submit'])){
    $username = trim($_POST['name']);
    $psw = sha1(trim($_POST['psw']));

    if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
        if (!is_dir('temp/')) {
            mkdir('temp/', 0777, true);
        }
        $image = "temp/". basename($_FILES["file"]["name"]);
        move_uploaded_file($_FILES["file"]["tmp_name"], $image);
        $img = true;
    } else {
        $image = "images/stock.png";
        $img = false;
    }
    $type = substr($image, -3);
    $type = "image/jpeg";
    $dao = new DAO();
    $id = $dao->insertNewUser($username, $psw, $image, $type);
    if ($img) {
        unlink($image);
    }
    
    session_start();
    $_SESSION['userId'] = $id;
    $image = "<p><img src=\"imageRetriever.php\" alt=\"Image To Display\" height='200' width='200'/></p>";


    $body = <<<BOD
    <form >
        <h1>congratulations</h1>
        <p>Your profile has been created. now you can begin storing your favorite videos</p>
        <p>
            Username: $username <br/><br/>
            $image
        </p>
        <p>
            <form method="post" action="submitVideo.php">
                <input type='submit' name='begin' value='Add Videos' />
            </form>
        </p>
    </form>
BOD;
    //todo add transision to start adding videos

    echo generatePage($body);
} else {

    $body = <<<BOD
    <form action="register.php" method="post" enctype="multipart/form-data">
        <p>
            <h1>Create a Profile</h1>
        </p>
        <p>
        <table>
            <tr><td>Username:</td><td><input type="text" name="name" maxlength="50" required /></td></tr>
            <tr><td>Password:</td><td><input type="password" name="psw" id="psw" maxlength="20" required /></td></tr>
            <tr><td>Verify Password:</td><td><input type="password" id="psw2" maxlength="20" required /></td></tr>
            <tr><td>Profile Picture:</td><td><input type="file" name="file" /></td></tr>
        </table>
        <p>
            <input type="submit" name="submit"/>
        </p>
    </form>
BOD;

    echo generatePageJS($body, "validatePsw.js");
}