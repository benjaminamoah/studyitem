<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header("location:admin_login.php");
	}

	require($_SERVER['DOCUMENT_ROOT']."/quest_e/includes/login.php");

	$manage_db = new manage_db();

	if(isset($_SESSION['cm_id'])){
		$cm_id = $_SESSION['cm_id'];
		$query = $manage_db->return_query("select * from curricula WHERE curriculum_id='$cm_id' ");
		$cm = mysql_result($query, 0, "curriculum");
	}

	if(isset($_GET['edit_subject'])){
		$subject = $_GET['subject'];
		$subject_id = $_GET['subject_id'];
		$manage_db->query("UPDATE subjects SET subject='$subject' WHERE subject_id='$subject_id'");
	}

	if(isset($_GET['add_subject'])){
		$subject = $_GET['subject'];
		$manage_db->query("INSERT INTO subjects VALUES(null, '$subject','$cm_id', 'yes')");
	}

	if(isset($_GET['act_subject'])){
		$subject_id = $_GET['subject_id'];
		$active = $_GET['active'];
		if($active == "activate"){
			$manage_db->return_query("UPDATE subjects SET active='yes' WHERE subject_id='$subject_id'");
		}else if($active == "deactivate"){
			$manage_db->return_query("UPDATE subjects SET active='no' WHERE subject_id='$subject_id'");
		}
	}

	if(isset($_GET['del_subject'])){
		$subject_id = $_GET['subject_id'];
		$query_topics =  $manage_db->return_query("SELECT * FROM topics WHERE subject_ref='$subject_id'");
		while($row = mysql_fetch_array($query_topics)){
			$topic_id = $row['topic_id'];
			$query_subtop =  $manage_db->return_query("SELECT * FROM subtopics WHERE topic_ref='$topic_id'");
			while($row = mysql_fetch_array($query_subtop)){
				$subtopic_id = $row['subtopic_id'];
				$manage_db->query("DELETE FROM contents WHERE record_id='$subject_id' AND table_name='subjects'");
				$manage_db->query("DELETE FROM contents WHERE record_id='$topic_id' AND table_name='topics'");
				$manage_db->query("DELETE FROM contents WHERE record_id='$subtopic_id' AND table_name='subtopics'");
			}
			$manage_db->query("DELETE FROM subtopics WHERE topic_ref='$topic_id'");
		}
		$manage_db->query("DELETE FROM topics WHERE subject_ref='$subject_id'");
		$manage_db->query("DELETE FROM subjects WHERE subject_id='$subject_id'");
	}

	if(isset($_GET['edit_topic'])){
		$topic = $_GET['topic'];
		$topic_id = $_GET['topic_id'];
		$manage_db->query("UPDATE topics SET topic='$topic' WHERE topic_id='$topic_id'");
	}

	if(isset($_GET['add_topic'])){
		$topic = $_GET['topic'];
		$subject_id = $_GET['subject_id'];
		$manage_db->query("INSERT INTO topics VALUES(null, '$topic', '$subject_id', 'yes')");
	}

	if(isset($_GET['act_topic'])){
		$topic_id = $_GET['topic_id'];
		$active = $_GET['top_active'];
		if($active == "activate"){
			$manage_db->return_query("UPDATE topics SET active='yes' WHERE topic_id='$topic_id'");
		}else if($active == "deactivate"){
			$manage_db->return_query("UPDATE topics SET active='no' WHERE topic_id='$topic_id'");
		}
	}

	if(isset($_GET['del_topic'])){
	$topic_id = $_GET['topic_id'];
	$query_subtop =  $manage_db->return_query("SELECT * FROM subtopics WHERE topic_ref='$topic_id'");
	while($row = mysql_fetch_array($query_subtop)){
		$subtopic_id = $row['subtopic_id'];
		$manage_db->query("DELETE FROM contents WHERE record_id='$topic_id' AND table_name='topics'");
		$manage_db->query("DELETE FROM contents WHERE record_id='$subtopic_id' AND table_name='subtopics'");
	}
	$manage_db->query("DELETE FROM subtopics WHERE topic_ref='$topic_id'");
	$manage_db->query("DELETE FROM topics WHERE topic_id='$topic_id'");
	}

	if(isset($_GET['edit_subtopic'])){
		$subtopic = $_GET['subtopic'];
		$subtopic_id = $_GET['subtopic_id'];
		$manage_db->query("UPDATE subtopics SET subtopic='$subtopic' WHERE subtopic_id='$subtopic_id'");
	}

	if(isset($_GET['add_subtopic'])){
		$subtopic = $_GET['subtopic'];
		$topic_id = $_GET['topic_id'];
		$manage_db->query("INSERT INTO subtopics VALUES(null, '$subtopic', '$topic_id', 'yes')");
	}

	if(isset($_GET['del_sub_topic'])){
		$subtopic_id = $_GET['sub_topic_id'];
		$manage_db->query("DELETE FROM contents WHERE record_id='$subtopic_id' AND table_name='subtopics'");
		$manage_db->query("DELETE FROM subtopics WHERE subtopic_id='$subtopic_id'");
	}

	if(isset($_GET['act_sub_topic'])){
		$subtopic_id = $_GET['sub_topic_id'];
		$active = $_GET['active'];
		if($active == "activate"){
			$manage_db->return_query("UPDATE subtopics SET active='yes' WHERE subtopic_id='$subtopic_id'");
		}else if($active == "deactivate"){
			$manage_db->return_query("UPDATE subtopics SET active='no' WHERE subtopic_id='$subtopic_id'");
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		CURRICULUM CONTROL PANEL
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />

<script type="text/javascript">
function editSub(subject_id, subject){
	var subject_td_id = "subject"+subject_id;
	var sub_input = "<form action='update_cm.php' method='GET'><input type='text' name='subject' value='"+subject+"' /><input type='hidden' name='subject_id' value='"+subject_id+"' /><input type='submit' name='edit_subject' value='save' /></form>";
	document.getElementById(subject_td_id).innerHTML = sub_input;
}

function addSub(subject_id, subject){
	var subject_td_id = "subject"+subject_id;
	var sub_input = subject+"<br /><b>new subject:</b> <form action='update_cm.php' method='GET'><input type='text' name='subject' /><input type='submit' name='add_subject' value='save' /></form>";
	document.getElementById(subject_td_id).innerHTML = sub_input;
}

function actSub(subject_id, subject, active){
	var subject_td_id = "subject"+subject_id;
	var sub_input = "<br />Are you sure you want to "+active+" "+subject+"?<br /><form action='update_cm.php' method='GET'><input type='hidden' value='"+subject_id+"' name='subject_id' /><input type='hidden' value='"+active+"' name='active' /><input type='submit' name='act_subject' value='"+active+"' /></form>";
	document.getElementById(subject_td_id).innerHTML = sub_input;
}

function delSub(subject_id, subject){
	var subject_td_id = "subject"+subject_id;
	var sub_input = "<br />Are you sure you want to delete "+subject+"?<br />(All contents of this subject would be deleted) <form action='update_cm.php' method='GET'><input type='hidden' value='"+subject_id+"' name='subject_id' /><input type='submit' name='del_subject' value='delete' /></form>";
	document.getElementById(subject_td_id).innerHTML = sub_input;
}

function editTop(topic_id, topic){
	var topic_td_id = "topic"+topic_id;
	var top_input = "<form action='update_cm.php' method='GET'><input type='text' name='topic' value='"+topic+"' /><input type='hidden' name='topic_id' value='"+topic_id+"' /><input type='submit' name='edit_topic' value='save' /></form>";
	document.getElementById(topic_td_id).innerHTML = top_input;
}

function addTop(topic_id, topic, subject_id){
	var topic_td_id = "topic"+topic_id;
	var top_input = topic+"<br /><b>new topic:</b> <form action='update_cm.php' method='GET'><input type='text' name='topic' /><input type='hidden' name='subject_id' value='"+subject_id+"' /><input type='submit' name='add_topic' value='save' /></form>";
	document.getElementById(topic_td_id).innerHTML = top_input;
}

function addFirstTop(subject_id){
	var topic_td_id = "first_topic"+subject_id;
	var top_input = "<br /><b>new topic:</b> <form action='update_cm.php' method='GET'><input type='text' name='topic' /><input type='hidden' name='subject_id' value='"+subject_id+"' /><input type='submit' name='add_topic' value='save' /></form>";
	document.getElementById(topic_td_id).innerHTML = top_input;
}

function actTop(topic_id, topic, active){
	var topic_td_id = "topic"+topic_id;
	var top_input =  "<br />Are you sure you want to "+active+" "+topic+"?<br /><form action='update_cm.php' method='GET'><input type='hidden' value='"+topic_id+"' name='topic_id' /><input type='hidden' value='"+active+"' name='top_active' /><input type='submit' name='act_topic' value='"+active+"' /></form>";
	document.getElementById(topic_td_id).innerHTML = top_input;
}

function delTop(topic_id, topic){
	var topic_td_id = "topic"+topic_id;
	var top_input =  "<br />Are you sure you want to delete "+topic+"?<br />(All contents of this topic would be deleted) <form action='update_cm.php' method='GET'><input type='hidden' value='"+topic_id+"' name='topic_id' /><input type='submit' name='del_topic' value='delete' /></form>";
	document.getElementById(topic_td_id).innerHTML = top_input;
}

function editSubtop(sub_topic_id, sub_topic){
	var sub_topic_td_id = "subtopic"+sub_topic_id;
	var subtop_input = "<form action='update_cm.php' method='GET'><input type='text' name='subtopic' value='"+sub_topic+"' /><input type='hidden' name='subtopic_id' value='"+sub_topic_id+"' /><input type='submit' name='edit_subtopic' value='save' /></form>";
	document.getElementById(sub_topic_td_id).innerHTML = subtop_input;
}

function addSubtop(sub_topic_id, sub_topic, topic_id){
	var subtop_td_id = "subtopic"+sub_topic_id;
	var subtop_input = sub_topic+"<br /><b>new subtopic:</b> <form action='update_cm.php' method='GET'><input type='text' name='subtopic' /><input type='hidden' name='topic_id' value='"+topic_id+"' /><input type='submit' name='add_subtopic' value='save' /></form>";
	document.getElementById(subtop_td_id).innerHTML = subtop_input;
}

function addFirstSubtop(topic_id){
	var subtop_td_id = "first_subtop"+topic_id;
	var subtop_input = "<br /><b>new subtopic:</b> <form action='update_cm.php' method='GET'><input type='text' name='subtopic' /><input type='hidden' name='topic_id' value='"+topic_id+"' /><input type='submit' name='add_subtopic' value='save' /></form>";
	document.getElementById(subtop_td_id).innerHTML = subtop_input;
}

function actSubtop(sub_topic_id, sub_topic, active){
	var sub_topic_td_id = "subtopic"+sub_topic_id;
	var subtop_input =  "<br />Are you sure you want to "+active+" "+sub_topic+"?<br /> <form action='update_cm.php' method='GET'><input type='hidden' value='"+sub_topic_id+"' name='sub_topic_id' /><input type='hidden' value='"+active+"' name='active' /><input type='submit' name='act_sub_topic' value='"+active+"' /></form>";
	document.getElementById(sub_topic_td_id).innerHTML = subtop_input;
}

function delSubtop(sub_topic_id, sub_topic){
	var sub_topic_td_id = "subtopic"+sub_topic_id;
	var subtop_input =  "<br />Are you sure you want to delete "+sub_topic+"?<br />(All contents of this subtopic would be deleted) <form action='update_cm.php' method='GET'><input type='hidden' value='"+sub_topic_id+"' name='sub_topic_id' /><input type='submit' name='del_sub_topic' value='delete' /></form>";
	document.getElementById(sub_topic_td_id).innerHTML = subtop_input;
}
</script>

</head>

<body><center><img src="images/logo02.png" />
	<h3>Update <?php echo $cm; ?></h3>

	<div id="contain">
<form action="cm_control_panel.php" method="POST">
<?php

	echo "<table>";
	echo "<tr><th style='background-color: #ddf; padding: 5px'>Subject</th><th style='background-color: #ddf; padding: 5px'>Topic</th><th style='background-color: #ddf; padding: 5px'>Sub-topic</th></tr>";

		$query_sub = $manage_db->return_query("select * from subjects WHERE curriculum_ref='$cm_id' ");
		while($row = mysql_fetch_array($query_sub)){
			$subject = $row['subject'];
			$subject_id = $row['subject_id'];
			$subject01 = '"'.$subject.'"';
			$sub_active = $row['active'];
			if($sub_active == "yes"){
				$sub_active = "deactivate";
			}else if($sub_active == "no"){
				$sub_active = "activate";
			}
			$sub_active01 = '"'.$sub_active.'"';

			$query_top01 = $manage_db->return_query("select * from subjects sub inner join topics top inner join subtopics subtop on sub.subject_id='$subject_id' and sub.subject_id=top.subject_ref and  top.topic_id=subtop.topic_ref ");
			$query_top02 = $manage_db->return_query("select * from topics where subject_ref='$subject_id' ");
			$c = 0;
			while($row = mysql_fetch_array($query_top02)){
				$topic_id = $row['topic_id'];
				$query_top03 = $manage_db->return_query("select * from subtopics where topic_ref='$topic_id' ");
				$num_rows = mysql_num_rows($query_top03);
				if($num_rows == 0){
					$c++;
				}
			}

			$topic_rows = mysql_num_rows($query_top01);
			$topic_rows = $topic_rows+$c+1;

			$query_top = $manage_db->return_query("select * from topics where subject_ref='$subject_id' ");
			$subject_td_id = "subject".$subject_id;

			echo "<tr><td id='".$subject_td_id."' rowspan='".$topic_rows."'>".$subject."<input type='button' value='edit' onClick='editSub(".$subject_id.",".$subject01.")' /><input type='button' value='".$sub_active."' onClick='actSub(".$subject_id.",".$subject01.",".$sub_active01.")' /><input type='button' value='add' onClick='addSub(".$subject_id.",".$subject01.")' /><input type='button' onClick='delSub(".$subject_id.",".$subject01.")' value='delete' /></td>";

			$first_topic_td_id = "first_topic".$subject_id;
			if(mysql_num_rows($query_top) == 0){
				echo "<td id='".$first_topic_td_id."'><input type='button' value='add first topic' onClick='addFirstTop(".$subject_id.")'  /></td><td id='".$sub_topic_td_id."'><!--<input type='text' name='subtopic' /><input type='button' value='add' onClick='addSubtop(".$sub_topic_id.",".$sub_topic01.")'  />-->Subtopic</td></tr>";
			}

			while($row = mysql_fetch_array($query_top)){
				$topic = $row['topic'];
				$topic_id = $row['topic_id'];
				$topic01 = '"'.$topic.'"';
				$top_active = $row['active'];
				if($top_active == "yes"){
					$top_active = "deactivate";
				}else if($top_active == "no"){
					$top_active = "activate";
				}
				$top_active01 = '"'.$top_active.'"';

				$query_sub_top = $manage_db->return_query("select * from topics top inner join subtopics subtop WHERE top.topic_id='$topic_id' AND top.topic_id=subtop.topic_ref");
				$sub_topic_rows = mysql_num_rows($query_sub_top);
				$topic_td_id = "topic".$topic_id;

				if($sub_topic_rows == 0){
					$sub_topic_rows = 1;
				}
				echo "<tr><td id='".$topic_td_id."' rowspan='".$sub_topic_rows."'>".$topic."<input type='button' value='edit' onClick='editTop(".$topic_id.",".$topic01.")' /><input type='button' value='".$top_active."' onClick='actTop(".$topic_id.",".$topic01.",".$top_active01.")' /><input type='button' value='add' onClick='addTop(".$topic_id.",".$topic01.",".$subject_id.")' /><input type='button' value='delete' onClick='delTop(".$topic_id.",".$topic01.")' /></td>";

				$first_subtop_td_id = "first_subtop".$topic_id;
				if(mysql_num_rows($query_sub_top) == 0){
					echo "<td id='".$first_subtop_td_id."'><input type='button' value='add first subtopic' onClick='addFirstSubtop(".$topic_id.")'  /></td></tr>";
				}

				while($row = mysql_fetch_array($query_sub_top)){
					$sub_topic = $row['subtopic'];
					$sub_topic_id = $row['subtopic_id'];
					$sub_topic_td_id = "subtopic".$sub_topic_id;
					$sub_topic01 = '"'.$sub_topic.'"';
					$subtop_active = $row['active'];
					if($subtop_active == "yes"){
						$subtop_active = "deactivate";
					}else if($subtop_active == "no"){
						$subtop_active = "activate";
					}
					$subtop_active01 = '"'.$subtop_active.'"';

					echo "<td id='".$sub_topic_td_id."'>".$sub_topic."<input type='button' value='edit' onClick='editSubtop(".$sub_topic_id.",".$sub_topic01.")'  /><input type='button' value='".$subtop_active."' onClick='actSubtop(".$sub_topic_id.",".$sub_topic01.",".$subtop_active01.")'  /><input type='button' value='add' onClick='addSubtop(".$sub_topic_id.",".$sub_topic01.",".$topic_id.")'  /><input type='button' value='delete' onClick='delSubtop(".$sub_topic_id.",".$sub_topic01.")' /></td></tr>";
				}
			}
			echo "</tr>";
		}

	echo "</table>";

?>
</form>
</div>
</center></body>

</html>