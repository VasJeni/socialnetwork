<?php
require_once 'dbsetings.php'; // подключаем файл с юзером и паролем для базы данных
$dbhost = 'localhost'; //адрес базы данных
$dbname = 'vasjeninest'; // название базы данных
$dbuser = $dbu; // взято с dbsettings
$dbpass = $dbp; // взято с dbsettings
$appname = "Vasjeni's Nest";

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbpass);
if ($connection->connect_error) die ($connection->connect_error);

function createTable ($name, $query )
{
    queryMysql("CREATE TABLE IF NOT EXIST $name($query)");
    echo "Таблица '$name' создана или уже существует <bd>";
}

function queryMysql ($query)
{
    global $connection;
    $result = $connection->query($query);
    if (!$result) die ($connection->error);
    return $result;
}

function destroySession()
{
    $_SESSION = array();
    if (session_id != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(). '' . time()-2592000 . '/');
    session_destroy();
}
function sentitizeString ($var)
{
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

function showProfile ($user)
{
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' align='left'>";
}

$result = queryMysql("SELECT * FROM profile WHERE user='$user'");

if ($result->num_rows)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo stripslashes($row['text']) . "<br style='clear:left'> <br>";
}