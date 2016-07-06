<?php
/**
 * Created by PhpStorm.
 * User: Boris
 * Date: 6/29/2016
 * Time: 7:33 PM
 * @param $body
 * @param string $title page tittle
 * @return string proper html page
 */

function generatePage($body, $title="YourTube") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>$title</title>
    </head>

    <body>
    <header>
        <img src="images/home.png" onclick="window.location='login.php'" height="30" width="30"/>
        <hr>
    </header>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}

function generatePageJS($body, $js, $title="YourTube") {
    $page = <<<EOPAGE
<!doctype html>
<html>
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>$title</title>
        <script src="$js"></script>
    </head>

    <body>
    <header>
        <img src="images/home.png" onclick="window.location='index.html'" height="30" width="30"/>
        <hr>
    </header>
            $body
    </body>
</html>
EOPAGE;

    return $page;
}