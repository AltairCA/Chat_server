<html>
<head>
<title>
Forget Password
</title>
<style>
#name{
		text-transform:lowercase;
}
</style>
<script>

</script>
</head>
<body>
<form action="passresend.php" method="post" name="form1">
	<table>
<th>Forget Password</th>

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

</body>

</html>