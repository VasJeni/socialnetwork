<?php
/**
 * Created by PhpStorm.
 * User: Vasilyev
 * Date: 22.01.2019
 * Time: 17:34
 */

require_once 'functions.php';
echo <<<_END
<script>
function checkUser(user)
{
    if (user.value == '')
        {
            O('info').innerHTML = '';
            return
        }
    params = "user=" + user.value;
    request = new ajaxRequest();
    request.open('POST', 'checkuser.php', true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.setRequestHeader('Content-length', params.length);
    request.setRequestHeader('Connection', "close");
    
    request.onreadystatechange = function()
    {
        if (this.readyState == 4)
            if (this.statusText == 200)
                if (this.responseText != null)
                    O('info').innerHTML = this.responseText
    }
    request.send(params);
}
function ajaxRequest(){
    try {var request = new XMLHttpRequest()}
    catch(e1){
        try {request = new ActiveXObject("Msxml2.XMLHTTP")}
        catch (e2) {
          try {request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch (e3) {
                request = false
          }
        }
    }
    return request;
}
</script>
<div class="main"> <h3>Please enter your details to sign up</h3></div>
_END;

$error = $user = $pass = "";
if (isset($_SESSION['user'])) destroySession();

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == '' || $pass == '')
    {
        $error = 'данные введены не во все поля';
    } else {
        $result = queryMysql("SELECT * FROM members WHERE user ='$user' ");
        if ($result->num_rows)
        {
            $error = 'Такое имя уже существует';
        } else {
            queryMysql("INSERT INTO members VALUES ('$user', '$pass')");
            die ('Account created pls log in. <br><br>');
        }
    }
}
echo <<<_END
<form method="post" action="signup.php"> $error
<span class="fieldname">Username</span>
<input type="text" maxlength="16" name="user" value="$user" onBlur="checkUser(this)"><span id="info"></span><br>
<span class="filedname">Password</span>
<input type="text" maxlength="16" name="pass" value="$pass"><br>
_END;
?>
<span class="filednema">&nbsp;</span>
<input type="submit" value="Sign up">
</form></div><br>
</body>
</html>


