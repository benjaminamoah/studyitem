<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}

	require("includes/login.php");

	$manage_db = new manage_db();

	if(isset($_POST['activation'])){
			$cm_id = $_POST['cm_id_activation'];
		if($_POST['activation'] == "Activate"){
			$manage_db->query("update curricula set active = 'yes' WHERE curriculum_id='$cm_id' ");
		}else if($_POST['activation'] == "Deactivate"){
			$manage_db->query("update curricula set active = 'no' WHERE curriculum_id='$cm_id' ");
		}
	}


	if(isset($_POST['update'])){
		$cm_id = $_POST['cm_id_update'];
		$_SESSION['cm_id'] = $cm_id;
		header("location:update_cm.php");
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		CURRICULUM CONTROL PANEL
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />
</head>

<body><center><img src="images/logo02.png" />
	<h3>Curriculum Control Panel</h3>

	<div id="contain">
<?php
	$query = $manage_db->return_query("select * from curricula");

	echo "<table>";
	echo "<tr><th style='background-color: #ddf; padding: 5px'>Curricula</th><th style='background-color: #ddf; padding: 5px'>Update Curriculum</th><th style='background-color: #ddf; padding: 5px'>Activate/Deactivate Curriculum</th></tr>";

	for($i=0; $i<mysql_num_rows($query); $i++){
		$cm_id_result = mysql_result($query, $i, "curriculum_id");
		$cm_result = mysql_result($query, $i, "curriculum");
		$active_result = mysql_result($query, $i, "active");

		if($active_result == "yes"){
			$active = "Deactivate";
		}else if($active_result == "no"){
			$active = "Activate";
		}

		echo "<tr><td>".$cm_result."</td><td><form action='cm_control_panel.php' method='POST'><input type='submit' name='update' value='Update' /><input type='hidden' name='cm_id_update' value='".$cm_id_result."' /></form></td><td><form action='cm_control_panel.php' method='POST'><input type='submit' name='activation' value='".$active."' /><input type='hidden' name='cm_id_activation' value='".$cm_id_result."' /></form></td></tr>";
	}
	echo "</table>";

	echo "<br /><a href='add_new_cm_step1.php' >Add a Curriculum</a><br />";

?>
</div>
</center></body>

</html>