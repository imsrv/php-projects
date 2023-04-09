<?
include "config.php";

setcookie ("test_cookies",1);

$get_rows = mysql_db_query ($dbname,"Select title,url from top_user Where sid=$site",$db) or die (mysql_error());
if (!@mysql_num_rows($get_rows) OR @mysql_num_rows ($get_rows) < 1) { header("location: $url_to_folder"); }
$rows = mysql_fetch_array($get_rows);

if (!$submit) {
	include "header.php";
	?>
	<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Vote no site for <? echo $rows[title];?> usando a caixa abaixo.<BR>
	<center>
	<form action="rate.php" method="post">
		<select name=vote>
			<option value=0>Selecione seu Voto</option>	
			<option value=1>1 (péssimo)</option>	
			<option value=2>2</option>	
			<option value=3>3</option>	
			<option value=4>4</option>	
			<option value=5>5</option>	
			<option value=6>6</option>	
			<option value=7>7</option>	
			<option value=8>8</option>	
			<option value=9>9</option>	
			<option value=10>10 (Super Sites Mesmo)</option>	
		</select>
		<input type=hidden name=site value=<? echo $site?>>
		<input type=submit name=submit value="Vote">
	</form>
	</center>
	</font><BR>
	<?
}
else {
	if ($test_cookies == 1 AND $REQUEST_METHOD == "POST" AND $vote >= 1 AND $vote <=10 AND $phptopsites_rating[$site] != 1) {
		setcookie ("phptopsites_rating[$site]",1,time()+86400);
		if ($use_review == 1) {
			setcookie ("phptopsites_review[$site]", $vote,time()+86400);

		}
		include "header.php";
		mysql_db_query ($dbname,"update top_user set votes=votes+1,rank=rank+$vote Where sid=$site",$db) or die (mysql_error());
		?>
		<BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>"><B><? echo $rows[title];?></B> has been successfully rated...<BR>
		<A HREF="<? echo $url_to_folder?>">Return to <? echo $top_name?></A>
		</FONT>
		<?
	}
	else {
		include "header.php";
		?>
		<BR>
		<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Sorry, <B><? echo $rows[title];?></B> hasn't been successfully rated...<BR>
		<A HREF="<? echo $url_to_folder?>">Return to <? echo $top_name?></A>
		</FONT>
		<?
	}
}
include "footer.php";
?>
