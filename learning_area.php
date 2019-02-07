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

		<div id="main_right">
			<?php
			$manage_db = new manage_db();

			$query_subjects = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
			$query_topics = $manage_db->return_query("select * from topics where subject_ref='$subject_id'");

			$subject_result = mysql_result($query_subjects, 0, "subject");
			for($j=0; $j<mysql_num_rows($query_topics); $j++){
				$topics_id_result = mysql_result($query_topics, $j, "topic_id");

				$topic_result = mysql_result($query_topics, $j, "topic");
				$topic_id_result = mysql_result($query_topics, $j, "topic_id");
				$topic_table = '"topics"';

				echo "<div id='inp_topics'><h4>".$topic_result.": ".$subject_result."</h4></div><hr />";

				$query_subtopics = $manage_db->return_query("select * from subtopics where topic_ref='$topics_id_result'");

				for($k=0; $k<mysql_num_rows($query_subtopics); $k++){

						$subtopic_result = mysql_result($query_subtopics, $k, "subtopic");
						$subtopic_id_result = mysql_result($query_subtopics, $k, "subtopic_id");
						$subtopic_table = '"subtopics"';

						//color of links
						$query_contents = $manage_db->return_query("select * from contents where record_id='$subtopic_id_result' and table_name='subtopics'");
						if(mysql_num_rows($query_contents) > 0){
							echo '<form action="learning_area_content.php" method="POST"><input type="hidden" name="subtopic_id" value="'.$subtopic_id_result.'" /><input type="submit" value="'.$subtopic_result.'" name="subject"  /></form>';
						}else{
							echo '<form action="learning_area_content.php" method="POST"><input type="hidden" name="subtopic_id" value="'.$subtopic_id_result.'" /><input type="submit" value="'.$subtopic_result.'" name="subject" style="color: #aab" /></form>';
						}
				}

			echo "<br />";
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