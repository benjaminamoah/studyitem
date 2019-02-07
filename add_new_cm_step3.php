<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$err="";

/***
	if(isset($_POST['submit_nxt'])){
	$tst=$_POST['subtopics_inp'];
		if(isset($tst)){
			$_SESSION['subtopics_inp'] = $_POST['subtopics_inp'];
			header("location:add_new_cm_confirmation.php");
		}else{
			$err= "Please Specify Subtopics!";
		}
	}else if(isset($_POST['submit_pre'])){
		$_SESSION['subtopics_inp'] = $_POST['subtopics_inp'];
		header("location:add_new_cm_step2.php");
	}
***/

	if(isset($_POST['submit_nxt'])){
		$_SESSION['subtopics_inp'] = $_POST['subtopics_inp'];
		header("location:add_new_cm_confirmation.php");
	}else if(isset($_POST['submit_pre'])){
		$_SESSION['subtopics_inp'] = $_POST['subtopics_inp'];
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
	<h3><a href="cm_control_panel.php">Home </a>: Add New Curriculum - Step 3 - Subtopics</h3>
	<div id="contain">
	<form action="add_new_cm_step3.php" method="POST">

			<?php
			$cm_title = $_SESSION['cm_title'];
			$subjects = $_SESSION['subjects_inp'];
			$topics = $_SESSION['topics_inp'];

			echo "<h4>".$cm_title."</h4><hr />";
			$len1 = count($subjects);

			echo "<table>";

			for($x=0 ; $x<$len1; $x++){

				$len2 = count($topics[$x]);
				$rspan = $len2+1;
				if(strlen($subjects[$x]) != 0){
					echo "<tr><td rowspan='".$rspan."'>".$subjects[$x]."</td></tr>";
				}

				for($i=0; $i<$len2; $i++){

					$temp = "'templ$x$i'";
					$aldvs = "'alldvs$x$i'";

					if(strlen($topics[$x][$i]) != 0){
						echo '<tr><td>'.$topics[$x][$i].'</td><td>';
							echo '<div id="alldvs'.$x.$i.'">';
								echo '<div id="templ'.$x.$i.'">';
									echo '<input type="text" name="subtopics_inp['.$x.']['.$i.'][]" />';
								echo '</div>';
							echo '</div>';


							echo '<input type="button" value="Add More Subtopics" onClick="javascript:addElement('.$temp.','.$aldvs.')" /></td></tr>';
					}
				}

			}
			echo "</table><br/>";
			echo "<div style='color:#f00; font-style:italic'>".$err."<div>";

			?>

			<br /><br />

			<input type="submit" name="submit_pre" value="Previous" />&#160;&#160;&#160;&#160;

			<input type="submit" name="submit_nxt" value="Next" />

		</form>
</center></body>

</html>