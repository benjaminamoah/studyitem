<?php
	session_start();
	if(!isset($_SESSION['username_t'])){
		header("location:admin_login.php");
	}

	require("includes/login.php");

	$manage_db = new manage_db();

	$fname = $_SESSION['fname'];

	if(isset($_POST['cm'])){
		$_SESSION['cm'] = $_POST['cm'];
		header("location:teacher_edit.php");
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
<div id="container">
<img src="images/logo02.png" /><hr />
	<h3>Welcome <?php echo $fname; ?>! <br />Choose a Curriculum to Add Content to...</h3>

<form action="teacher_choose_cm.php" method="POST">
<?php
	$query = $manage_db->return_query("select * from curricula");

	echo "<table>";

	for($i=0; $i<mysql_num_rows($query); $i++){
		$cm_result = mysql_result($query, $i, "curriculum");
		$active_result = mysql_result($query, $i, "active");

		echo "<tr><td id='teacher_cm'><input type='submit' name='cm' value='".$cm_result."' /></td></tr>";
	}
	echo "</table>";

?>
</form>
</div>
</body>

</html>