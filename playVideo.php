<?php

require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
$video = trim($_POST['video']);
$src = "https://www.youtube.com/embed/".$video;
$body = '<iframe width="960" height="540" align="middle" src="'.$src.'" frameborder="0" allowfullscreen></iframe><br><br>';
$body .= '<form action="videoTable.php">
                            <input type="submit" value="Back to videos"/>
                        </form>';
echo generatePage($body);