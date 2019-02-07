<?php
	session_start();
	if(!isset($_SESSION['username_s'])){
		header("location:student_home.php");
	}

	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$manage_db = new manage_db();

	$fname = $_SESSION['fname'];
	$cm = $_SESSION['cm'];
	$cm_query = $manage_db->return_query("select * from curricula where curriculum = '$cm'");
	$cm_id = mysql_result($cm_query, 0, "curriculum_id");
	$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm."<h4>";
	$tbl_name = "curricula";
	$id = $cm_id;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		TEACHER - EDIT CONTENT
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />

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

			http.open("POST", "content.php", true);

			http.onreadystatechange = function(){
				if(http.readyState == 4 && http.status == 200){
					document.getElementById('content').innerHTML = http.responseText;
				}
			}

			http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			http.send("table="+table+"&id="+id);
		}
	</script>
</head>

<body>

<div id="cm_pane">

<?php
	$query_cm = $manage_db->return_query("select * from curricula where curriculum='$cm'");

	$cm_id_result = mysql_result($query_cm, 0, "curriculum_id");
	$cm_table = '"curricula"';

	echo "<div id='inp_cm'><input type='submit' value='".$cm."' name='cm' id='cm' onclick='getContent(".$cm_table.", ".$cm_id_result.")' /></div>";

	$query_subjects = $manage_db->return_query("select * from subjects where curriculum_ref='$cm_id_result'");

	for($i=0; $i<mysql_num_rows($query_subjects); $i++){
		$subjects_id_result = mysql_result($query_subjects, $i, "subject_id");

		$subject_result = mysql_result($query_subjects, $i, "subject");
		$subject_id_result = mysql_result($query_subjects, $i, "subject_id");
		$subject_table= "'subjects'";

		echo '<div id="inp_subjects"><input type="submit" value="'.$subject_result.'" name="subject" id="subject" onClick="getContent('.$subject_table.', '.$subject_id_result.')" /></div>';

		$query_topics = $manage_db->return_query("select * from topics where subject_ref='$subjects_id_result'");

			for($j=0; $j<mysql_num_rows($query_topics); $j++){
				$topics_id_result = mysql_result($query_topics, $j, "topic_id");

				$topic_result = mysql_result($query_topics, $j, "topic");
				$topic_id_result = mysql_result($query_topics, $j, "topic_id");
				$topic_table = '"topics"';

				echo "<div id='inp_topics'><input type='submit' value='".$topic_result."' name='topic' onClick='getContent(".$topic_table.", ".$topic_id_result.")' /></div>";

				$query_subtopics = $manage_db->return_query("select * from subtopics where topic_ref='$topics_id_result'");

				for($k=0; $k<mysql_num_rows($query_subtopics); $k++){

						$subtopic_result = mysql_result($query_subtopics, $k, "subtopic");
						$subtopic_id_result = mysql_result($query_subtopics, $k, "subtopic_id");
						$subtopic_table = '"subtopics"';

						echo "<div id='inp_subtopics'><input type='submit' value='".$subtopic_result."' name='subtopic' onClick='getContent(".$subtopic_table.", ".$subtopic_id_result.")' /></div>";

				}

			}

	}
?>


</div>

<div id="content_pane">
<img src="images/logo02.png" /><hr />

<div id="content">
<h3><?php echo $nav; ?></h3>

<?php
	$query_content = $manage_db->return_query("select * from contents where table_name='$tbl_name' and record_id='$id'");
	for($i=0; $i<mysql_num_rows($query_content); $i++){

		$cnt = mysql_result($query_content, $i, "content");
		$cnt_id = mysql_result($query_content, $i, "content_id");
		echo $cnt;

	}
?>
</div>
</div>
</body>

</html>