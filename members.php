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
    echo "<a class='button' href='messages.php?view=$view'> View $name messages </a><br><br>";
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
for ($j = 0; $j < $num; $j++)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;
    echo "<li><a href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result = queryMysql("SELECT * FROM friends WHERE user='" .  $row['user'] . "' AND friend='$user'");
    $t1 = $result->num_rows;
    $result = queryMysql("SELECT * FROM friends WHERE user='$user' AND friends='".$row['user']. "'");
    $t2 = $result->num_rows;

    if (($t1+$t2) > 1) echo "&harr; is mutual friend";
    elseif ($t1>1) echo '&larr; you are following';
    elseif ($t2>1) {
        echo "&rarr; is following you";
        $follow = "recip";
    }

    if (!$t1) echo "[a href='members.php?add=" . $row['user'].  "'>drop</a>";
}
?>

</ul></div>
</body>
</html>
