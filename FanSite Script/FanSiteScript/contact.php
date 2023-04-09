<?php include("include/header.php"); ?>
<br /><h1><img src="images/bullet.gif" /> Contact - <?PHP include ("include/site_name.txt");?></h1><br /><br />
Если Вы хотите связаться с администрацией <?PHP include ("include/site_name.txt");?> заполните следующую форму
<br /><br />
<div>
<form action="form-send.php" method="post">
<div><img src="images/bullet.gif" /> Ваше имя:</div>
<div><input type="text" name="name">
</div>
<br />
<div><img src="images/bullet.gif" /> Ваш Email:</div>

<div><input type="text" name="email"></div>
<br />
<div><img src="images/bullet.gif" /> Ваше сообщение:</div>

<div><textarea name="enquiry" cols="50" rows="5" id="enquiry"></textarea><br>
<input type="submit" name="Submit" value="Отправить">
<input name="Reset" type="reset" id="Reset" value="Сбросить">
</div>
 
</form>
</div>
<?php include("include/footer.php"); ?>