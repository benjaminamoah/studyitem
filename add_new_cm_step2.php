<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	if(isset($_POST['submit_nxt'])){
		$_SESSION['topics_inp'] = $_POST['topics_inp'];
		header("location:add_new_cm_step3.php");
	}else if(isset($_POST['submit_pre'])){
		$_SESSION['topics_inp'] = $_POST['topics_inp'];
		header("location:add_new_cm_step1.php");
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
	<h3><a href="cm_control_panel.php">Home </a>: Add New Curriculum - Step 2 - Topics</h3>
	<div id="contain">
	<form action="add_new_cm_step2.php" method="POST">

			<?php
			$cm_title = $_SESSION['cm_title'];
			$subjects = $_SESSION['subjects_inp'];
			$len = count($subjects);

			echo "<h4>".$cm_title."</h4><hr /><table>";

			for($i=0; $i<$len; $i++){

			if(strlen($subjects[$i]) != 0){
				$temp = "'templ$i'";
				$aldvs = "'alldvs$i'";

				echo '<tr><td>'.$subjects[$i].'</td><td>';
					echo '<div id="alldvs'.$i.'">';
						echo '<div id="templ'.$i.'">';
							echo '<input type="text" name="topics_inp['.$i.'][]" />';
						echo '</div>';
					echo '</div>';


						echo '<input type="button" value="Add More Topics" onClick="javascript:addElement('.$temp.','.$aldvs.')" /></td></tr>';
			}
			}
			echo "</table>";
			?>

			<br /><br /><br />

			<input type="submit" name="submit_pre" value="Previous" />&#160;&#160;&#160;&#160;

			<input type="submit" name="submit_nxt" value="Next" />

		</form>
</center></body>

</html>