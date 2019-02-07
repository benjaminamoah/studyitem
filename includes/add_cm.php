<?php
session_start();
if(!isset($_SESSION['username'])){
	header("location:admin_login.php");
}

require($_SERVER['DOCUMENT_ROOT']."/studyitem/includes/login.php");

$cm_title = $_SESSION['cm_title'];
$subjects = $_SESSION['subjects_inp'];
$topics = $_SESSION['topics_inp'];
$subtopics = $_SESSION['subtopics_inp'];

$manage_db = new manage_db();
$query = $manage_db->return_query("select * from curricula");

if($_SESSION['update'] == "yes"){
	//insert subjects
		$num_of_sub = count($subjects);
		$query_cm = $manage_db->return_query("select * from curricula where curriculum = '$cm_title'");
		$cm_ref = mysql_result($query_cm, 0, "curriculum_id");

		$manage_db->query("delete from subjects where curriculum_ref = '$cm_ref'");

	for($i=0; $i<$num_of_sub; $i++){
		$sub = $subjects[$i];
		if(strlen($sub) != 0){
			$manage_db->query("insert into subjects values(null, '$sub', '$cm_ref', 'yes')");
		}

	//insert topics
			$num_of_top = count($topics[$i]);
			$query_sub = $manage_db->return_query("select * from subjects where subject = '$sub' and curriculum_ref = '$cm_ref'");
			$sub_ref = mysql_result($query_sub, 0, "subject_id");

			$manage_db->query("delete from topics where subject_ref = '$sub_ref'");

			for($c=0; $c<$num_of_top; $c++){
				$top = $topics[$i][$c];
				if(strlen($top) != 0){
					$manage_db->query("insert into topics values(null, '$top', '$sub_ref', 'yes')");
				}

	//insert subtopics
				$num_of_subtop = count($subtopics[$i][$c]);
				$query_top = $manage_db->return_query("select * from topics where topic = '$top' and subject_ref = '$sub_ref'");
				$top_ref = mysql_result($query_top, 0, "topic_id");

				$manage_db->query("delete from subtopics where topic_ref = '$top_ref'");

				for($k=0; $k<$num_of_subtop; $k++){
					$subtop = $subtopics[$i][$c][$k];
					if(strlen($subtop) != 0){
						$manage_db->query("insert into subtopics values(null, '$subtop', '$top_ref', 'yes')");
					}
				}
			}

	}
	header("location:../cm_control_panel.php");
}else if($_SESSION['update'] == "no"){
//insert curriculum title
	$manage_db->query("insert into curricula values(null, '$cm_title', 'yes')");

//insert subjects
	$num_of_sub = count($subjects);
	$query_cm = $manage_db->return_query("select * from curricula where curriculum = '$cm_title'");
	$cm_ref = mysql_result($query_cm, 0, "curriculum_id");

	for($i=0; $i<$num_of_sub; $i++){
		$sub = $subjects[$i];
		if(strlen($sub) != 0){
			$manage_db->query("insert into subjects values(null, '$sub', '$cm_ref', 'yes')");
		}

//insert topics
		$num_of_top = count($topics[$i]);
		$query_sub = $manage_db->return_query("select * from subjects where subject = '$sub' and curriculum_ref = '$cm_ref'");
		$sub_ref = mysql_result($query_sub, 0, "subject_id");

		for($c=0; $c<$num_of_top; $c++){
			$top = $topics[$i][$c];
			if(strlen($top) != 0){
				$manage_db->query("insert into topics values(null, '$top', '$sub_ref', 'yes')");
			}

//insert subtopics
			$num_of_subtop = count($subtopics[$i][$c]);
			$query_top = $manage_db->return_query("select * from topics where topic = '$top' and subject_ref = '$sub_ref'");
			$top_ref = mysql_result($query_top, 0, "topic_id");
echo $num_of_subtop;
			for($k=0; $k<$num_of_subtop; $k++){
				$subtop = $subtopics[$i][$c][$k];
				if(strlen($subtop) != 0){
					$manage_db->query("insert into subtopics values(null, '$subtop', '$top_ref', 'yes')");
				}
			}
		}

	}
	header("location:../cm_control_panel.php");
}

?>