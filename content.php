<?php
	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$manage_db = new manage_db();

if(isset($_POST['table'])){
	$id = $_POST['id'];
	$tbl_name = $_POST['table'];

//nav definition area
	if($_POST['table'] == "curricula"){
		$cm_id = $id;
		$cm_query = $manage_db->return_query("select * from curricula where curriculum_id = '$cm_id'");
		$cm = mysql_result($cm_query, 0, "curriculum");
		$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm."<h4>";
		$tbl_name = "curricula";

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if($_POST['table'] == "subjects"){
		$subject_id = $id;
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$cm_ref = mysql_result($subject_query, 0, "curriculum_ref");
		$cm_query = $manage_db->return_query("select * from curricula where curriculum_id = '$cm_ref'");
		$cm = mysql_result($cm_query, 0, "curriculum");
		$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm.": ".$subject."<h4>";
		$tbl_name = "subjects";

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if($_POST['table'] == "topics"){
		$topic_id = $id;
		$topic_query = $manage_db->return_query("select * from topics where topic_id='$id'");
		$topic = mysql_result($topic_query, 0, "topic");
		$subject_id = mysql_result($topic_query, 0, "subject_ref");
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$cm_ref = mysql_result($subject_query, 0, "curriculum_ref");
		$cm_query = $manage_db->return_query("select * from curricula where curriculum_id = '$cm_ref'");
		$cm = mysql_result($cm_query, 0, "curriculum");
		$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm.": ".$subject.": ".$topic."<h4>";
		$tbl_name = "topics";
		$id = $topic_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if($_POST['table'] == "subtopics"){
		$subtopic_id = $id;
		$subtopic_query = $manage_db->return_query("select * from subtopics where subtopic_id='$id'");
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
		$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm.": ".$subject.": ".$topic.": ".$subtopic."<h4>";
		$tbl_name = "subtopics";
		$id = $subtopic_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if(isset($_POST['cm'])){
		$cm_query = $manage_db->return_query("select * from curricula where curriculum = '$cm'");
		$cm_id = mysql_result($cm_query, 0, "curriculum_id");
		$nav = "<h4><a href='student_profile.php'>Home: </a>".$cm."<h4>";
		$tbl_name = "curricula";
		$id = $cm_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}

	echo $nav;

//content display
	$query_content = $manage_db->return_query("select * from contents where table_name='$tbl_name' and record_id='$id'");

	for($i=0; $i<mysql_num_rows($query_content); $i++){
		$cnt = mysql_result($query_content, $i, "content");
		echo $cnt;
	}
}
?>