<?php
	require("includes/login.php");

	$err = "";

	if(isset($_POST['submit'])){
	$user = $_POST['username'];
	$pass = $_POST['password'];
		$login = new login();
		$manage_db = new manage_db();

		if($login->check_admin_user($user, $pass, "CM")){
			session_start();
			$_SESSION['username'] = $user;
			$msg= "gets here";
			header("location:cm_control_panel.php");
		}else if($login->check_admin_user($user, $pass, "CT")){
			$query = $manage_db->return_query("select * from admin_users where username='$user' and password='$pass' and access_level='CT'");
			$fname = mysql_result($query, 0, "first_name");
			session_start();
			$_SESSION['username_t'] = $user;
			$_SESSION['fname'] = $fname;
			$msg= "gets here";
			header("location:teacher_choose_cm.php");
		}else{
			$err = "Please enter a valid username and password!";
		}

	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		ADMIN LOGIN
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />
</head>

<body>

	<center><img src="images/logo02.png" /></center>
	<div id="admin">
		<center><h3 style="color:#66f; font-family:arial">ADMIN LOGIN</h3>

		<hr /><br />

		<form action="admin_login.php" method="POST">
			<table><tr><td>
				Username&#160;&#160;&#160;
			</td><td>
				<input type="text" name="username" id="username" />
			</td></tr>
			<tr><td>
				Password&#160;&#160;&#160;
			</td><td>
				<input type="password" name="password" id="password" />
			</td></tr>
			<tr><td> </td><td>
				<dl><dd><input type="submit" name="submit" value="Login" id="submit" /></dl>
			</td></tr></table>
		</form>

		<?php
			echo "<br /><br /><div style='color: #f00'>".$err."</div>";
		?>
	</div>
</body>

</html>