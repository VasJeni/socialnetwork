<?php
/**
 * Created by PhpStorm.
 * User: nummu
 * Date: 26.01.2019
 * Time: 16:10
 */
require_once 'header.php';
echo '<div class="main"> Please enter your details to log in';

$error = $user = $pass = '';

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == '' || $pass == "")
    {
        $error = "Not all fields were entered";
    } else {
        $result = queryMysql("SELECT user.pass FROM members WHERE user='$user' AND pass='$pass'");
        if ($result->num_rows=="0")
        {
            $error = "<span class='error'> Invalid username or password </span><br><br>";
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die ('You are log in now. Please <a href="members.php">lick here</a> to continue.<br><br>');
        }
    }
}
echo <<<_END
<form action=login,php method="POST">$error
<span class="fieldname">Username</span><br>
<input type="text" maxlength="16" name="user" value='$user'><br>
<span class="fieldname">Password</span><br>
<input type="text" maxlength="16" name="pass" value='$pass'><br>
_END;
?>
<br>
<span class="fieldname">&nbsp;</span>
<input type="submit" value="Login">
</form><br></div>
</body>
</html>


