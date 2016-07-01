<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/29/2016
 * Time: 7:08 PM
 */

if (isset($_POST['register'])){
    include "register.php";
} else {
    include "login.php";
}