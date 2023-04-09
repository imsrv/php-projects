<?php include ("inc/security.inc") ?>

<?PHP include ("inc/header.php"); ?>

	 <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Добро пожаловать в панель администратора <?PHP 
include ("../include/connect.txt");

$result = mysql_query("SELECT site_name FROM ds_options WHERE id = '0'");  
while ($myrow = mysql_fetch_row($result)) 

printf("%s",mysql_result($result,0,"site_name"));  


include ("../include/close.txt");

?> </h1><br /><br />

<div class="boxbgr"></div>
<div class="boxbg">
Меню слева поможет Вам редактировать и удалять фильмы, ссылки, статьи и т.д...<br /><br />

На данный момент у Вас <strong><?PHP 
include ("../include/connect.txt");
$result = mysql_query("SELECT id FROM ds_movies");
$count = mysql_num_rows($result);
printf("%s",$count);

include ("../include/close.txt");

?> Фильмов</strong> и <strong><?PHP 
include ("../include/connect.txt");
$result = mysql_query("SELECT id FROM ds_articles");
$count = mysql_num_rows($result);
printf("%s",$count);

include ("../include/close.txt");

?> Статей</strong> в Вашей БД.</div><br /><br />

<h1><img src="../images/admin/bullet.gif" alt="" /> Заметки <a href="#" class="hintanchor" onMouseover="showhint('Тут Вы можете написать что-то, чтобы потом это что-то сделать :).', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></h1><br /><br />
<div class="boxbgr"></div>
<div class="boxbg">

	 <?php include("../include/admin_note.txt"); ?></div>
	 <?PHP
	 ?>
  </BODY>
</HTML>

<?PHP include ("inc/footer.php"); ?>
