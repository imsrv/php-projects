<?php include("include/header.php"); ?>
<br /><h1><img src="images/bullet.gif" /> Contact - <?PHP include ("include/site_name.txt");?></h1><br /><br />
���� �� ������ ��������� � �������������� <?PHP include ("include/site_name.txt");?> ��������� ��������� �����
<br /><br />
<div>
<form action="form-send.php" method="post">
<div><img src="images/bullet.gif" /> ���� ���:</div>
<div><input type="text" name="name">
</div>
<br />
<div><img src="images/bullet.gif" /> ��� Email:</div>

<div><input type="text" name="email"></div>
<br />
<div><img src="images/bullet.gif" /> ���� ���������:</div>

<div><textarea name="enquiry" cols="50" rows="5" id="enquiry"></textarea><br>
<input type="submit" name="Submit" value="���������">
<input name="Reset" type="reset" id="Reset" value="��������">
</div>
 
</form>
</div>
<?php include("include/footer.php"); ?>