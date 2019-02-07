<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$c = 0;

	if(isset($_POST['submit'])){
		$manage_db = new manage_db();
		$query = $manage_db->return_query("select * from curricula");
		for($i=0; $i<mysql_num_rows($query); $i++){
			$result = mysql_result($query, $i, "curriculum");
			if($result == $_POST['cm_title'] || strlen($_POST['cm_title']) == 0){
				$update = "<div style='color:#f00; font-style: italic'>Curriculum already exists</div><input type='submit' name='submit' value='Correction made, continue!' />  <input type='submit' name='submit1' value='No correction needed. Update Curriculum!' />";
				$c = 1;
			}else{
				$i = mysql_num_rows($query);
				$c = 0;
			}
		}

		if($c == 0){
			$_SESSION['subjects_inp'] = $_POST['subjects_inp'];
			$_SESSION['cm_title'] = $_POST['cm_title'];
			$_SESSION['update'] = "no";
			header("location:add_new_cm_step2.php");
		}
	}

	if(isset($_POST['submit1']) && strlen($_POST['submit1']) != 0){
		$_SESSION['update'] = "yes";
		$_SESSION['subjects_inp'] = $_POST['subjects_inp'];
		$_SESSION['cm_title'] = $_POST['cm_title'];
		header("location:add_new_cm_step2.php");
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		ADD NEW CURRICULUM TO QUEST E
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />

	<script language="javascript" src="includes/jscript.js" ></script>

</head>

<body><center><img src="images/logo02.png" />
<h3><a href="cm_control_panel.php">Home </a>: Add New Curriculum - Step 1 - Curriculum and Subjects</h3>
<div id="contain">
Curriculum Title
		<form action='add_new_cm_step1.php' method='POST'>
				<td><input type='text' name='cm_title' /></td>
				<br />
				<br />
				<br />
<table><tr><td>
		Subjects</td><td>
				<div id='aldvs'>
					<div id='templ'>
						<input type='text' name='subjects_inp[]'>
					</div>
				</div>
		<input type='button' value='Add More Subjects' onClick="javascript:addElement('templ','aldvs')">
</td></tr></table>
<br />
<br />
		<?php
		if($c==1){
			echo $update;
		}else{
			echo "<input type='submit' name='submit' value='Next' />";
		}
		?>
		</form>
</div>
</center></body>

</html>