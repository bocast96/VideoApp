<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/27/2016
 * Time: 12:49 AM
 */

$host = "localhost";
$user = "group";
$password = "terps";
$database = "videoappdb";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Established Connection<br>";
}

// creates the main user table
$sql = "CREATE TABLE users (
id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL,
profile_pic LONGBLOB,
image_type varchar(512)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error, "<br>";
}

// creates the video table
$sql = "CREATE TABLE videos (
userId int NOT NULL,
title VARCHAR(50),
genre ENUM('music','news','sports','DIY','comedy','art','science','misc') NOT NULL,
author VARCHAR(20),
description VARCHAR(200),
link longtext NOT NULL,
date_added DATE NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'sample' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error, "<br>";
}

$conn->close();