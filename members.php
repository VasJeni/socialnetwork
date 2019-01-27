<?php
require_once 'header.php';
if (!$loggedin) die();
echo "<div class='main>'";

if (isset($_GET['view']))
{
    $view = sanitizeString($_GET['view']);
    if ($view == $user)
    {
        $name = "Your";
    } else {
        $name = "$view's";
    }
    echo "<h3>$name profile</h3>";
    showProfile($view);
    echo "<a class='button' href='message.php?view=$view'> View $name messages </a><br><br>";
    die("</div></body></html>");
}
if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);
    $result = queryMysql("SELECT * FROM friend WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
    {
        queryMysql("SELECT * FROM friend VALUES ('$add','$user')");
    }
} elseif ($_GET['remote'])
{
    $remote = sanitizeString($_GET['remote']);
    queryMysql("DELETE FROM friend WHERE user='$remote' AND friend='user'");
}
$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = !$result->num_rows;

echo "<h3>Othe users</h3><ul>";
for

