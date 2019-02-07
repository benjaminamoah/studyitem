<?php
	session_start();
	if(!isset($_SESSION['username_t'])){
		header("location:admin_login.php");
	}

	require("includes/login.php");

	$manage_db = new manage_db();

	$fname = $_SESSION['fname'];
	$cm = $_SESSION['cm'];

if(!isset($_SESSION['trck'])){
	$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm."<h4>";
	$tbl_name = "curricula";
	$cm_query = $manage_db->return_query("select * from curricula where curriculum = '$cm'");
	$cm_id = mysql_result($cm_query, 0, "curriculum_id");
	$id = $cm_id;
	$_SESSION['trck'] = 1;
}

//navigation area
	if(isset($_POST['subject'])){
		$subject_id = $_POST['hid_subject'];
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject."<h4>";
		$tbl_name = "subjects";
		$id = $subject_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if(isset($_POST['topic'])){
		$topic_id = $_POST['hid_topic'];
		$topic_query = $manage_db->return_query("select * from topics where topic_id='$topic_id'");
		$topic = mysql_result($topic_query, 0, "topic");
		$subject_id = mysql_result($topic_query, 0, "subject_ref");
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic."<h4>";
		$tbl_name = "topics";
		$id = $topic_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if(isset($_POST['subtopic'])){
		$subtopic_id = $_POST['hid_subtopic'];
		$subtopic_query = $manage_db->return_query("select * from subtopics where subtopic_id='$subtopic_id'");
		$subtopic = mysql_result($subtopic_query, 0, "subtopic");
		$topic_id = mysql_result($subtopic_query, 0, "topic_ref");
		$topic_query = $manage_db->return_query("select * from topics where topic_id='$topic_id'");
		$topic = mysql_result($topic_query, 0, "topic");
		$subject_id = mysql_result($topic_query, 0, "subject_ref");
		$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
		$subject = mysql_result($subject_query, 0, "subject");
		$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic.": ".$subtopic."<h4>";
		$tbl_name = "subtopics";
		$id = $subtopic_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else if(isset($_POST['cm'])){
		$cm_query = $manage_db->return_query("select * from curricula where curriculum = '$cm'");
		$cm_id = mysql_result($cm_query, 0, "curriculum_id");
		$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm."<h4>";
		$tbl_name = "curricula";
		$id = $cm_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}else{
		$cm_query = $manage_db->return_query("select * from curricula where curriculum = '$cm'");
		$cm_id = mysql_result($cm_query, 0, "curriculum_id");
		$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm."<h4>";
		$tbl_name = "curricula";
		$id = $cm_id;

		$_SESSION['nav'] = $nav;
		$_SESSION['id'] = $id;
		$_SESSION['tbl_name'] = $tbl_name;
	}

//post content
	if(isset($_POST['submit'])){
		if($_POST['submit'] == "POST CONTENT!"){
			$tbl_name = $_POST['table_name'];
			$rec_id = $_POST['rec_id'];
			$content = $_POST['content'];

			$manage_db->query("insert into contents values(null, '$content', '$tbl_name', '$rec_id')");
			$nav = $_POST['nav'];
			$id = $_POST['id'];
			$tbl_name = $_POST['tbl_name'];
		}else if($_POST['submit'] == "UPDATE CONTENT!"){
			$tbl_name = $_POST['table_name'];
			$rec_id = $_POST['rec_id'];
			$content = $_POST['content'];
			$cnt_id = $_POST['cnt_id'];

			$manage_db->query("update contents set content = '$content' where content_id='$cnt_id'");
			$nav = $_POST['nav'];
			$id = $_POST['id'];
			$tbl_name = $_POST['tbl_name'];
			$post_or_upd = "POST CONTENT!";
		}
	}

//update content
	if(isset($_POST['submit_update'])){
		$cnt_id = $_POST['cnt_id'];
		$cnt_id_query = $manage_db->return_query("select * from contents where content_id='$cnt_id'");

		$cnt = mysql_result($cnt_id_query, 0, "content");
		$post_or_upd = "UPDATE CONTENT!";
		$id = $_POST['id'];
		$tbl_name = $_POST['tbl_name'];

		if($tbl_name == "curricula"){
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm."<h4>";
		}else if($tbl_name == "subjects"){
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject."<h4>";
		}else if($tbl_name == "topics"){
			$topic_query = $manage_db->return_query("select * from topics where topic_id='$id'");
			$topic = mysql_result($topic_query, 0, "topic");
			$subject_id = mysql_result($topic_query, 0, "subject_ref");
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic."<h4>";
		}else if($tbl_name == "subtopics"){
			$subtopic_query = $manage_db->return_query("select * from subtopics where subtopic_id='$id'");
			$subtopic = mysql_result($subtopic_query, 0, "subtopic");
			$topic_id = mysql_result($subtopic_query, 0, "topic_ref");
			$topic_query = $manage_db->return_query("select * from topics where topic_id='$topic_id'");
			$topic = mysql_result($topic_query, 0, "topic");
			$subject_id = mysql_result($topic_query, 0, "subject_ref");
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic.": ".$subtopic."<h4>";
		}
	}else{
		$post_or_upd = "POST CONTENT!";
		$cnt = "";
	}

	if(isset($_POST['submit_delete'])){
		$cnt_id = $_POST['cnt_id'];
		$cnt_id_query = $manage_db->return_query("delete from contents where content_id='$cnt_id'");

		$post_or_upd = "POST CONTENT!";

		$id = $_POST['id'];
		$tbl_name = $_POST['tbl_name'];

		if($tbl_name == "curricula"){
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm."<h4>";
		}else if($tbl_name == "subjects"){
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject."<h4>";
		}else if($tbl_name == "topics"){
			$topic_query = $manage_db->return_query("select * from topics where topic_id='$id'");
			$topic = mysql_result($topic_query, 0, "topic");
			$subject_id = mysql_result($topic_query, 0, "subject_ref");
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic."<h4>";
		}else if($tbl_name == "subtopics"){
			$subtopic_query = $manage_db->return_query("select * from subtopics where subtopic_id='$id'");
			$subtopic = mysql_result($subtopic_query, 0, "subtopic");
			$topic_id = mysql_result($subtopic_query, 0, "topic_ref");
			$topic_query = $manage_db->return_query("select * from topics where topic_id='$topic_id'");
			$topic = mysql_result($topic_query, 0, "topic");
			$subject_id = mysql_result($topic_query, 0, "subject_ref");
			$subject_query = $manage_db->return_query("select * from subjects where subject_id='$subject_id'");
			$subject = mysql_result($subject_query, 0, "subject");
			$nav = "<h4><a href='teacher_choose_cm.php'>Home: </a>".$cm.": ".$subject.": ".$topic.": ".$subtopic."<h4>";
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		TEACHER - EDIT CONTENT
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />

<script language="javascript" type="text/javascript" src="../jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	mode : "textareas"});
</script>
</head>

<body>

<div id="cm_pane">

<?php
	$query_cm = $manage_db->return_query("select * from curricula where curriculum='$cm'");

	$cm_id_result = mysql_result($query_cm, 0, "curriculum_id");

	echo "<form action='teacher_edit.php' method='POST'>";
	echo "<input style='background-color: #fff' type='hidden' value='".$cm_id_result."' name='hid_cm' />";
	echo "<div id='inp_cm'><input type='submit' value='".$cm."' name='cm' /></div>";
	echo "</form>";

	$query_subjects = $manage_db->return_query("select * from subjects where curriculum_ref='$cm_id_result'");

	for($i=0; $i<mysql_num_rows($query_subjects); $i++){
		$subjects_id_result = mysql_result($query_subjects, $i, "subject_id");

		$subject_result = mysql_result($query_subjects, $i, "subject");
		$subject_id_result = mysql_result($query_subjects, $i, "subject_id");

		echo "<form action='teacher_edit.php' method='POST'>";
		echo "<input type='hidden' value='".$subject_id_result."' name='hid_subject' />";
		echo "<div id='inp_subjects'><input type='submit' value='".$subject_result."' name='subject' /></div>";
		echo "</form>";

		$query_topics = $manage_db->return_query("select * from topics where subject_ref='$subjects_id_result'");

			for($j=0; $j<mysql_num_rows($query_topics); $j++){
				$topics_id_result = mysql_result($query_topics, $j, "topic_id");

				$topic_result = mysql_result($query_topics, $j, "topic");
				$topic_id_result = mysql_result($query_topics, $j, "topic_id");

				echo "<form action='teacher_edit.php' method='POST'>";
				echo "<input type='hidden' value='".$topic_id_result."' name='hid_topic' />";
				echo "<div id='inp_topics'><input type='submit' value='".$topic_result."' name='topic' /></div>";
				echo "</form>";

				$query_subtopics = $manage_db->return_query("select * from subtopics where topic_ref='$topics_id_result'");

				for($k=0; $k<mysql_num_rows($query_subtopics); $k++){

						$subtopic_result = mysql_result($query_subtopics, $k, "subtopic");
						$subtopic_id_result = mysql_result($query_subtopics, $k, "subtopic_id");

						echo "<form action='teacher_edit.php' method='POST'>";
						echo "<input type='hidden' value='".$subtopic_id_result."' name='hid_subtopic' />";
						echo "<div id='inp_subtopics'><input type='submit' value='".$subtopic_result."' name='subtopic' /></div>";
						echo "</form>";
				}

			}

	}
?>


</div>

<div id="content_pane">
<img src="images/logo02.png" /><hr />
	<h3><?php echo $nav; ?></h3>

<form action="teacher_edit.php" name="myform" method="POST">
	<textarea name="content"><?php echo $cnt; ?></textarea>
	<input type="hidden" name="table_name" value="<?php echo $tbl_name; ?>" />
	<input type="hidden" name="rec_id" value="<?php echo $id; ?>" />
	<input type="hidden" name="cnt_id" value="<?php echo $cnt_id; ?>" />
	<input type="hidden" name="nav" value="<?php echo $nav; ?>" />
	<input type="hidden" name="tbl_name" value="<?php echo $tbl_name; ?>" />
	<input type="hidden" name="id" value="<?php echo $id; ?>" />
	<input type="submit" name="submit" value="<?php echo $post_or_upd; ?>"  id="post_content" />
</form>

<?php
	$query_content = $manage_db->return_query("select * from contents where table_name='$tbl_name' and record_id='$id'");
	for($i=0; $i<mysql_num_rows($query_content); $i++){

		$cnt = mysql_result($query_content, $i, "content");
		$cnt_id = mysql_result($query_content, $i, "content_id");
		echo $cnt;

		echo "<div id='edt_del'>
		<div id='edt'>
		<form action='teacher_edit.php' method='POST'>
			<input type='hidden' name='cnt_id' value='".$cnt_id."' />
			<input type='hidden' name='tbl_name' value='".$tbl_name."' />
			<input type='hidden' name='id' value='".$id."' />
			<input type='submit' name='submit_update' value='UPDATE'  id='update_content' />
		</form>
		</div>";

		echo "<div id='del'>
		<form action='teacher_edit.php' method='POST'>
			<input type='hidden' name='cnt_id' value='".$cnt_id."' />
			<input type='hidden' name='tbl_name' value='".$tbl_name."' />
			<input type='hidden' name='id' value='".$id."' />
			<input type='submit' name='submit_delete' value='DELETE'  id='delete_content' />
		</form>
		</div>
		</div>
		<br />
		";
	}
?>
<div>
</body>

</html>