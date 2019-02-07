<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	if(isset($_POST['submit_yes'])){
		header("location:includes/add_cm.php");
	}else if(isset($_POST['submit_no'])){
		header("location:add_new_cm_step3.php");
	}

	if(isset($_SESSION['err'])){
		$err = $_SESSION['err'];
	}else{
		$err = "";
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
	<h3><a href="cm_control_panel.php">Home </a>: Add New Curriculum - Confirmation</h3>
	<div id="contain">
	Is the following information correct?
	<form action="add_new_cm_confirmation.php" method="POST">

			<?php
			$cm_title = $_SESSION['cm_title'];
			$subjects = $_SESSION['subjects_inp'];
			$topics = $_SESSION['topics_inp'];
			$subtopics = $_SESSION['subtopics_inp'];

			$len1 = count($subjects);

			echo "<h4>".$cm_title."</h4><hr />";

			echo "<table>";

			for($x=0 ; $x<$len1; $x++){

				$len2 = count($topics[$x]);

				$b=0;
				for($a=0; $a<$len2 ;$a++){
					$b=$b+count($subtopics[$x][$a])+1;
				}

				$rspan1=$b+1;
				if(strlen($subjects[$x]) != 0){
					echo "<tr><td style='background-color:#9999aa; color:#fff; font-size: 18px' rowspan='".$rspan1."'>".$subjects[$x]."</td></tr>";


				for($i=0; $i<$len2; $i++){

				$len3 = count($subtopics[$x][$i]);
				$rspan2 = $len3+1;
					if(strlen($topics[$x][$i]) != 0){
						echo "<tr><td rowspan='".$rspan2."'>".$topics[$x][$i]."</td></tr>";

						for($a=0 ; $a<$len3; $a++){
							if(strlen($subtopics[$x][$i][$a]) != 0){
								echo "<tr><td style='background-color:#ddddff;'>".$subtopics[$x][$i][$a]."</td></tr>";
							}
						}
					}
				}

				}

			}

			echo "</table>".$err;
			?>

			<br /><br /><br />

			<input type="submit" name="submit_no" value="No! Return to Previous Page." />

			<input type="submit" name="submit_yes" value="Yes! Save changes." />

		</form>
</center></body>

</html>