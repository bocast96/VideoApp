<?php

require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
$title = trim($_POST['title']);
$id = $_SESSION['userId'];
$dao = new DAO();
$body = 'The video '.$title.' has been deleted <br><br>';
$result = $dao->deleteVideo($id, $title);
$body .= '<form action="videoTable.php">
                            <input type="submit" value="Back to videos"/>
                        </form>';
echo generatePage($body);
?>