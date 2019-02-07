<?php
	require("includes/login.php");

	$file = "traffick.txt";
	$current = file_get_contents($file);
	$current++;
	file_put_contents($file, $current);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		Welcome to StudyItem
	</title>

	<meta name="google-site-verification" content="6vkppqSVS8d1H3Zg5_GtaQGgUO3YePIl5ZMZ6ZI2xGA" />

	<meta name="description" content="Revision Notes and Excercises for Ghanaian students.  Notes, Excercies, and Exam Questions and Answers for JHS, SHS and Tertiary students.">
	<meta name="keywords" content="Ghanian, syllabus, JHS, SHS, University, students, notes, revision, exams, Questions, answers">
	<meta name="author" content="StudyItem">
	<meta charset="UTF-8">

	<link type="text/css" rel="stylesheet" href="main.css" />
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
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
		<h3>StudyItem Intro...</h3>
			Hi! <b>StudyItem</b> is all about helping you do well in school. Notes and excercies
			are available here for free as well as through our mobile applications.</p>

			<p>To download StudyItem's mobile app follow the link below.</p>

			<p><a href="app_downloads.php"><img src="images/download.png"> StudyItem mobile app downloads</a><br />
		</div>

		<div id="main_sn">
		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fstudyitem&amp;width=200&amp;height=80&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;send=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:80px;" allowTransparency="true">
		</iframe>

		<!--comments-->
		<br />
		<h4>Please give us some feedback</h4>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

		<div class="fb-comments" data-href="http://studyitem.com" data-width="200px" data-numposts="5" data-colorscheme="light"></div>
		<!--end of comments-->
		</div>
	</div>
	</div><!--end of main container-->
	<div id="footer"><div id="footer_text">StudyItem &#169; <?php echo date(Y);?><br />Designed by Jaminweb</div></div>
</body>

</html>