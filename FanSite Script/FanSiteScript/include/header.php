<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<?php include ("include/header.txt") ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/admin/favicon.ico" />
</head><body>

<div id="frame">
    <div style="position:absolute; margin-top:45px; margin-left:510px;"><FORM METHOD="post" ACTION="search.php"> 

	<INPUT TYPE="TEXT" NAME="search_term">
	<INPUT TYPE="SUBMIT" NAME="submit" VALUE="������">

</FORM> </div>
	<div id="contentheader"><img src="images/header.jpg" width="750" height="104" /></div>
	<div id="contentleft">
	<br />		
<div id="navcontainer">
<ul id="navlist">
<li><a href="index.php">�������</a></li>
<li><a href="movies.php">������</a></li>
<li><a href="articles.php">������</a></li>
<li><a href="contact.php">����� � ����</a></li>
</ul>
</div>
<div id="sidetxt">
<strong>�������:</strong> <?PHP include ("include/count_movies.txt");?><br />
<strong>������:</strong> <?PHP include ("include/count_articles.txt");?><br /><br />
<!-- ��� ����� �������� ��� ���� ������� :) -->
</div>


</div>
    <div id="contentcenter">
	