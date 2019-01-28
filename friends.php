<?php
require_once 'header.php';

if (!$loggedin) die ();

if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else                      $view = $user;
if ($view == $user)
{
    $name1 = $name2 = "Your";
    $name3= "You are";
} else {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = $view . " is";
}
echo "<div class='main'>";

$followers = array();
$followings = array();
$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
$num = $result->num_rows;

for ($j=0; $j<$num; $j++)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['friend'];
}

$result = queryMysql("SELECT * FROM friends WHERE friend = '$view'");
$num = $result->num_rows;

for ($j = 0; $j < $num; $j++)
{
$row = $result->fetch_array(MYSQLI_ASSOC);
$followings[$j] = $row['user'];
}

$mutual = array_intersect($followings, $followers);
$followers = array_diff($followers, $mutual);
$followings = array_diff($followings, $mutual);
$friends = FALSE;

if (sizeof($mutual))
{
    echo "<span class='subhead'>$name2 mutual friends </span><ul>";
    foreach ($mutual as $friend)
        echo "<li> <a href='members.php?view=$friend'>$friend</a></li>";
    echo "</ul>";
    $friends = TRUE;
}

if (sizeof($followers))
{
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach ($followings as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a></li>";
    echo "</ul>";
    $friends = TRUE;
}

if (sizeof($followings))
{
    echo "<span class='subhead'>$name3 following </span><ul>";
    foreach($followings as $friend)
        echo "<li><a href='members.php?view=$friend'>$friend</a></li>";
    echo "</ul>";
    $friends= TRUE;
}
if ($friends) echo "<br>You don't have any friends yet.<br><br>";
echo "<a class='button' href='members.php?view=$view'>$view View $name2 massages</a>";
?>
</div><br>
</body>
</html>