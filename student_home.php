<?php
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$err = "";

	if(isset($_POST['submit'])){
	$user = $_POST['username'];
	$pass = $_POST['password'];
		$login = new login();
		$manage_db = new manage_db();

		if($login->check_student_user($user, $pass)){
			$query = $manage_db->return_query("select * from students where username='$user' and password='$pass'");
			$fname = mysql_result($query, 0, "first_name");
			$mname = mysql_result($query, 0, "middle_name");
			$lname = mysql_result($query, 0, "last_name");
			session_start();
			$_SESSION['fname'] = $fname;
			$_SESSION['mname'] = $mname;
			$_SESSION['lname'] = $lname;
			$_SESSION['username_s'] = $user;
			$msg= "gets here";
			header("location:student_profile.php");
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
	<div id="admin"><br />
		<center><h4 style="color:#88f; font-family:arial">Login</h4>

		<hr /><br />

		<form action="student_home.php" method="POST">
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
			echo "<br /><br /><div style='color: #f00; font-family: arial'>".$err."</div>";
		?>
	</div>
</body>

</html>