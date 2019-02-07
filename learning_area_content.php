<?php
	require("includes/login.php");

if(isset($_POST['subject'])){
	$file = "traffick_learn.txt";
	$current = file_get_contents($file);
	$current++;
	file_put_contents($file, $current);

	$subject = $_POST['subject'];
	$subject_id = $_POST['subject_id'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		StudyItem | <?php echo $subject; ?>
	</title>

	<meta name="google-site-verification" content="6vkppqSVS8d1H3Zg5_GtaQGgUO3YePIl5ZMZ6ZI2xGA" />

	<meta name="description" content="Revision Notes and Excercises for Ghanaian students.  Notes, Excercies, and Exam Questions and Answers for JHS, SHS and Tertiary students.">
	<meta name="keywords" content="Ghanian, syllabus, JHS, SHS, University, students, notes, revision, exams, Questions, answers">
	<meta name="author" content="StudyItem">
	<meta charset="UTF-8">

	<link type="text/css" rel="stylesheet" href="main.css" />


	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<script type="text/javascript" language="javascript">
		function getXMLHttp(){
			if(window.XMLHttpRequest){
				return new XMLHttpRequest();
			}else if(window.ActiveXObject){
				return new ActiveXObject("Microsoft.XMLHTTP");
			}else{
				alert("Sorry, Your browser does not support Ajax!");
			}
		}

		function getContent(table, id){

			var http = getXMLHttp();

			document.getElementById('main_right').innerHTML = "<img src='images/ajax-loader.gif' />";
			http.open("POST", "content_pane.php", true);

			http.onreadystatechange = function(){
				if(http.readyState == 4 && http.status == 200){
					document.getElementById('main_right').innerHTML = http.responseText;
				}
			}

			http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			http.send("table="+table+"&id="+id);
		}
	</script>
</head>

<body>
		<div id="main_top">
			<div id="main_top_left">
				<img src="images/logo1.png" />
			</div>
			<div id="main_top_right">
				<a href="index.php"><div id="menu_item">Home</div></a>
				<a href="app_downloads.php"><div id="menu_item">Downloads</div></a>
				<a href="contacts.php"><div id="menu_item">Contacts</div></a>
				<a href="faq.php"><div id="menu_item">FAQ</div></a>
			</div>
		</div>

	<div id="main_container">
	<div id="main"><br />
		<div id="main_left">
	<?php
			$manage_db = new manage_db();
			$query_cm = $manage_db->return_query("select * from curricula where active='yes'");

			for($c=0; $c<mysql_num_rows($query_cm); $c++){
				$cm_id_result = mysql_result($query_cm, $c, "curriculum_id");
				$cm_result = mysql_result($query_cm, $c, "curriculum");
				$cm_table = '"curricula"';

				$query_subjects = $manage_db->return_query("select * from subjects where curriculum_ref='$cm_id_result'");

				echo '<h3>'.$cm_result.'</h3>';
				for($i=0; $i<mysql_num_rows($query_subjects); $i++){
					$subjects_id_result = mysql_result($query_subjects, $i, "subject_id");

					$subject_result = mysql_result($query_subjects, $i, "subject");
					$subject_id_result = mysql_result($query_subjects, $i, "subject_id");
					$subject_table= "'subjects'";

					echo '<form action="learning_area.php" method="POST"><input type="hidden" name="subject_id" value="'.$subject_id_result.'" /><input type="submit" value="'.$subject_result.'" name="subject"  /></form>';

					$query_topics = $manage_db->return_query("select * from topics where subject_ref='$subjects_id_result'");

			}
		}

			?>
		</div>

		<div id="main_right" style="padding-top:24px;">
			<?php
			$manage_db = new manage_db();
if(isset($_POST['subtopic_id'])){
		$subtopic_id = $_POST['subtopic_id'];
		$subtopic_query = $manage_db->return_query("select * from subtopics where subtopic_id='$subtopic_id'");
		$subtopic = mysql_result($subtopic_query, 0, "subtopic");
		$topic_id = mysql_result($subtopic_query, 0, "topic_ref");
		$topic_query = $manage_db->return_query("select * from topics where topic_id='$topic_id'");
		$topic = mysql_result($topic_query, 0, "topic");
		$subject_id = mysql_result($topic_query, 0, "subject_ref");
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$cm_ref = mysql_result($subject_query, 0, "curriculum_ref");
		$cm_query = $manage_db->return_query("select * from curricula where curriculum_id = '$cm_ref'");
		$cm = mysql_result($cm_query, 0, "curriculum");
		$nav = "<form action='learning_area.php' method='POST' style='float:left; padding:0px; margin-top: -2px;'><input type='hidden' name='subject_id' value='".$subject_id."' /><input type='submit' value='".$topic.": ".$subject."' name='subject'  /></form>".$subtopic."<h4><hr />";
		$tbl_name = "subtopics";
		$id = $subtopic_id;

		//record subtopic
			$file = "traffick_dest.txt";
			$date = date("Y/m/d")." ".date("h:i:sa");
			$current = " and <br />\n".$date." ".$cm." ".$subtopic;
			file_put_contents($file, $current, FILE_APPEND | LOCK_EX);
		//

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;


	echo $nav;

//content display
	$query_content = $manage_db->return_query("select * from contents where table_name='$tbl_name' and record_id='$id'");

	for($i=0; $i<mysql_num_rows($query_content); $i++){
		$cnt = mysql_result($query_content, $i, "content");
		echo $cnt;
	}

	if(strlen($cnt) < 1){
		echo "You wanted notes on ".$subtopic.". Don't worry! We're still working on this.";
	}
}
			?>
		</div>

		<div id="main_sn">
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fstudyitem&amp;width=200&amp;height=80&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;send=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:80px;" allowTransparency="true">
		</iframe>
		</div><!--end of main sn-->
	</div><!--end of main-->

	</div><!--end of main container-->
	<div id="footer"><div id="footer_text">StudyItem &#169; <?php echo date(Y);?><br />Designed by Jaminweb</div></div>
</body>

</html>