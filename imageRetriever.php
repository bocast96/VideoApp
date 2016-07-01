<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/30/2016
 * Time: 1:56 PM
 */

require_once "databaseAccessObject.php";

$dao = new DAO();

session_start();
$id = $_SESSION['userId'];

$result = $dao->getUser($id);
$list = $result->fetch_assoc();

header("Content-type: "."{$list['image_type']}");
echo $list['profile_pic'];
mysqli_free_result($result);