<?php
	session_start();
	if(!isset($_SESSION['username_s'])){
		header("location:student_home.php");
	}

	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$manage_db = new manage_db();

	$fname = $_SESSION['fname'];
	$mname = $_SESSION['mname'];
	$lname = $_SESSION['lname'];

	if(isset($_POST['cm'])){
		$_SESSION['cm'] = $_POST['cm'];
		header("location:student_learning_area.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		TEACHER - CHOOSE CURRICULUM FOR CONTENT EDITING
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />
</head>

<body>
<div id="container_stu_profile">
<center><img src="images/logo02.png" /></center><hr /><br />
	<div id="student_pic"><img src="images/student_default_pic.png" /></div>
	<h3><?php echo $fname." ".$mname." ".$lname; ?></h3>
	<a href="">Change Profile Picture</a>
<form action="student_profile.php" method="POST">
<?php
	$query = $manage_db->return_query("select * from curricula");

	echo "<table>";

	for($i=0; $i<mysql_num_rows($query); $i++){
		$cm_result = mysql_result($query, $i, "curriculum");
		$active_result = mysql_result($query, $i, "active");

		echo "<tr><td id='student_cm'><input type='submit' name='cm' value='".$cm_result."' /></td></tr>";
	}
	echo "</table>";

?>
</form>
</div>
</body>

</html>