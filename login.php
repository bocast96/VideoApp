<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/30/2016
 * Time: 11:59 AM
 */
require_once "suppor.php";
require_once "databaseAccessObject.php";
session_start();
if (isset($_SESSION['userId'])){
    $user = $_SESSION['userName'];
    $image = "<p><img src=\"imageRetriever.php\" alt=\"Image To Display\" height='200' width='200'/></p>";
    echo generatePage(getWelcomePage($image, $user));
}

else if (isset($_POST['submitLogin'])) {
    $username = trim($_POST['username']);
    $password = sha1(trim($_POST['psw']));

    $dao = new DAO();
    $result = $dao->login($username, $password);

    if ($result and $result->num_rows > 0){
        $result = $result->fetch_assoc();

        $_SESSION['userId'] = $result['id'];
        $_SESSION['userName'] = $username;
        $image = "<p><img src=\"imageRetriever.php\" alt=\"Image To Display\" height='200' width='200'/></p>";

        echo generatePage(getWelcomePage($image, $username));
    } else {
        $body = makeLoginPage("The provided username and password do not match our records,<br> Please try again.");
        echo generatePage($body);
    }

} else {
    echo generatePage(makeLoginPage());
}

function makeLoginPage($msg="") {
    $body = <<<BOD
    <form action='login.php' method='post' />
        <p>
        <table>
            <tr><td>Username:</td><td><input type='text' name='username' maxlength='50' required/></td></tr>
            <tr><td>Password:</td><td><input type='password' name='psw' maxlength='20' required/></td></tr>
        </table>
        </p>
        <p>
            <input type="submit" name="submitLogin" value="Login" class="button"/>
        </p>
        <p>
            $msg
        </p>
    </form>
BOD;

    return $body;
}

function getWelcomePage($img, $user) {
    $body = <<<BOD
    <!--<form>-->
        <h1>Welcome Back $user</h1>
        <p>
        $img
            <table>
                <tr>
                    <td>
                        <form action="submitVideo.php">
                            <input type='submit' name='addVids' value='Add to videos'/>
                        </form>
                    </td>
                    <td>
                        <form action="videoTable.php">
                            <input type='submit' name='goToVids' value='Go to videos'/>
                        </form>
                    </td>
                    <td>
                        <form action="logout.php">
                            <input type='submit' name='logout' value='Logout'/>
                        </form>
                    </td>

                </tr>
            </table>
        </p>
    <!--</form>-->
BOD;

    return $body;
}







