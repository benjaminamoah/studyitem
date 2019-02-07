<?php
	require("includes/manage_db.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>
		Welcome to StudyItem
	</title>

	<link type="text/css" rel="stylesheet" href="main.css" />
</head>

<body>
<?php
$manage_db = new manage_db();
$query = $manage_db->return_query("select * from user_tags order by user_tag desc");
$number = mysql_result($query, 0, "user_tag");
echo $number;
echo "<br /><br />";
echo "<a href='apps/AudioRecoderDemo.apk'>Test link</a>";
?>
</body>

</html>