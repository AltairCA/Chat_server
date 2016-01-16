
<html>
<head>
<title> Chat Registration</title>
<style>
#name{
		text-transform:lowercase;
}
</style>
<script>
function allLetter(inputtxt)
      { 
      var letters = /^[A-Za-z]+$/;
      if(inputtxt.value.match(letters))
      {
      
      return true;
      }
      else
      {
      alert('Please input alphabet characters only for the Username');
      return false;
      }
      }
</script>
</head>
<body>
<div>
<form action="submit.php" method="post" name="form1" onSubmit="return allLetter(document.form1.name)">
<table>
<th>Chat Registraions form</th>
<tr>
	<td>Name
    </td>
    <td>
    <input type="text" name="name" id="name" />
    </td>
</tr>
<tr>
	<td>Password
    </td>
    <td>
    <input type="password" name="password" />
    </td>
    
</tr>
<tr>
<td>Retype Password
</td>
<td>
<input type="password" name="repass" />
</td>
</tr>
<tr>
	<td>Email
    </td>
    <td>
    <input type="email" name="email" />
    </td>
</tr>
<tr>
<td></td>
<td>
<?php
         require_once('config/recaptchalib.php');
			 $publickey = "6LcjCQATAAAAAA0E1QzWgDDytCmmp4gjNrkLVO2A"; // you got this from the signup page
          echo recaptcha_get_html($publickey,true);
        ?>

</td>
</tr>
<tr>
<td>
</td>
<td>
<input type="submit" name="submit" value="submit">
</td>
</tr>
<tr></tr>
<tr><td></td>
<td><a href="index.php">Regsitration</a></td>
</tr>
<tr><td></td>
<td><a href="resend.php">Email Resend</a></td>
</tr>
<tr>
<td></td>
<td><a href="forget_password.php">Forget Password</a></td>
</tr>
<tr>
<td></td>
<td>
<a href="passreset.php">Password Reset</a></td>
</tr>
</table>
</form>
<div>
</body>

</html>