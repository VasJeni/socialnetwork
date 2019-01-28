<?php
require_once 'header.php';

if (isset($_SESSION['user']))
{
    destroySession();
    echo "<div class='main'>You have been logged out. Please <a href='index.php'>press here to refresh the screen</a>";
} else {
  echo "<div class='main'><br>You can not log out becouse you not logged in</div>";
}
?>
<br></div>
</body>
</html>

