<?php
session_start();
echo "<!DOCTYPE html>\n<html lang=\"ru\"><head><meta charset=\"UTF-8\">";
require_once "function.php";

if (isset($_SESSION['user']))
{
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = " ($user)";
} else $loggedin = FALSE;

echo "<title>$appname$userstr</title><link rel='stylesheet'".
    "href='style.css' type='text/scc'>".
    "</head><body><center><canvas id='logo' width='624' height='96'>$appname</canvas> </center>" .
    "<div class='appname'>$appname$userstr</div>" .
    "<script src='javascript.js'></script>";
if ($loggedin)
{
    echo "<br> <ul class='menu'>" .
         "<li><a href='members.php?view=$user'>Home</a></li>" .
         "<li> <a href='members.php'>Members</a></li>" .
         "<li> <a href='friends.php'>Friends</a> </li>" .
         "<li> <a href='message.php'>Massage</a></li>" .
         "<li> <a href='profile.php'>Edit Profile</a></li>" .
         "<li> <a href='logout.php'>Log out</a></li> </ul><br>";
} else {
    echo ("<br> <ul class='menu'>" .
        "<li><a href='index.php'>Home</a></li>" .
        "<li><a href='signup.php'>Sign up</a></li>" .
        "<li><a href='ligin.php'>Log in</a></li>" .
        "<span class='info'> You must be kogged in to view this page.</span><br><br>");
}