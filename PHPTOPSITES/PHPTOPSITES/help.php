<?
include "header.php";
include "config.php";

	?>
	<Table Border="0" CellPadding="0" CellSpacing="0" Align="Center">
	<TR><TD>
	<form action="help.php" method="post">
	<font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">Entre com seu ID :</font><BR>
	<input type="text" name="site" size="25" value="<? echo $site?>"><BR>
	<input type="submit" name="submit"><BR>
	</form>
	</TD></TR>
	</Table>
	<?

if ($site) {
	$get_rows = mysql_db_query ($dbname,"Select sid from top_user Where sid=$site",$db) or die (mysql_error());
	if (@mysql_num_rows($get_rows)<1) {
		?>
		<center>
		<font color="red" face="<? echo $font_face;?>" size="<? echo $font_size;?>">No Such Site in Our Database.</font>
		</center>
		<?
	}
	else {
		$sid = $site;
	}
}

if (!$sid) $sid = "XXXXXXXXX";
?>
      <font color="<? echo $font_color;?>" face="<? echo $font_face;?>" size="<? echo $font_size;?>">
      <LI><B>Link Simples:</B><BR>&lt;a 
      href="<? echo "$url_to_folder/in.php?site=$sid";?>" 
      target="_blank"&gt;<? echo $top_name?>&lt;/a&gt; 
      <P>
      <HR>
      <B>
      <LI>Link com Imagem:</B><BR>&lt;a 
      href="<? echo "$url_to_folder/in.php?site=$sid";?>" 
      target="_blank"&gt;<BR>&lt;img 
      src="<? echo $vote_image_url?>" alt="Enter to <? echo $top_name?> 
       and Vote for this Site!!!" border=0&gt;&lt;/a&gt; 
      <P>
      <CENTER><IMG 
      src="<? echo $vote_image_url?>"><BR>Salve esta imagem em seu servidor, se para maior segurança.<BR>(Botão direito - Salvar como ...)</CENTER><BR>
      <P>
      <HR>
      </font>
<?
include "footer.php";
?>
