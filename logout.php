<?php
session_start();
echo 'You have been logged out';
unset($_SESSION['userId']);
unset($_SESSION['userName']);

echo '<form action="index.html">
                            <input type="submit" value="Return to login"/>
                        </form>';