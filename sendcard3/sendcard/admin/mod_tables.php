<?php include("prepend.php"); ?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF">
<?php

include (DOCROOT . "sendcard_setup.php");
include (DOCROOT . "include/" . $dbfile);
include (DOCROOT . "include/template.inc");
include (DOCROOT . "functions.php");
$db = new DB_Sendcard;

if (isset($make_tbl)) {

$sql="CREATE TABLE " . $tbl_name ."_tables (
  tablename char(30) NOT NULL
)";
$db->query($sql);

$sql="CREATE TABLE $tbl_name (
  image varchar(150),
  caption text,
  bgcolor varchar(7),
  towho varchar(50),
  to_email varchar(50) NOT NULL,
  fromwho varchar(50),
  from_email varchar(50) NOT NULL,
  fontcolor varchar(7),
  fontface varchar(100),
  message text,
  music varchar(70),
  id varchar(14) NOT NULL,
  notify char(1) default 1,
  emailsent char(1) default 1,
  template varchar(30),
  des varchar(30),
  img_width char(3),
  img_height char(3),
  applet_name char(40),
  user1 varchar(50),
  user2 varchar(50),
  PRIMARY KEY (id)
)";
$db->query($sql);

$sql="INSERT INTO " . $tbl_name ."_tables VALUES ('$tbl_name')";
$db->query($sql);

echo("<h1>Tables created!</h1>");
}

if ( isset ($del_tbl) ) {
	$db->query("Drop table $tbl_name");
	echo("<h1>Table deleted</h1>");
}
?>

<form method="post" action="<?php echo ("http://".$HTTP_HOST.$PHP_SELF); ?>">
  <p>Now we'll create the table required for sendcard. This only needs to be done 
	once. You have chosen to name the main table <i><?php echo ($tbl_name); ?></i>. 
	If you want to change this name you go to &quot;Configure&quot; and do so. 
	Otherwise all you need to do is to push the button below to create the table.</p>
  <p>Please note: you must already have a database created.</p>
  <p>
	<input type="submit" name="make_tbl" value="Create the table">
     <br>
  </p>
</form>
<form method="post" action="<?php echo ("http://".$HTTP_HOST.$PHP_SELF); ?>">
	<input type="submit" name="del_tbl" value="Delete the table">
</form>
</body>
</html>