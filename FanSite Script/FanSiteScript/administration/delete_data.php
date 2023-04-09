<?php include ("inc/security.inc") ?>
<?PHP include ("inc/header.php"); ?>
<?PHP include ("../include/connect.txt"); ?>
<?php

?>



<!DOCTYPE HTML PUBLIC "-//SoftQuad Software//DTD HoTMetaL PRO 6.0::19990601::extensions to HTML 4.0//EN" "hmpro6.dtd">
<html>
<body>

<?PHP 






if (!((isset($submit)) | (isset($submit1)) | (isset($submit2))))
{
// =================  Get the movie and which piece of info to delete ( submit -> film + type )
		?> 
	 	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
		<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%" > 
			<TR> 
				<TD> 
					<TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3" > 
				  <TR> 
					<TD>Фильм</TD>
					<td> 
					<?php
					$query = "SELECT seo_url,title FROM ds_movies ORDER BY title";
					$result = mysql_query($query);
					print "<SELECT name=film>\n";
					while ($myrow = mysql_fetch_array($result)) 
						{ 
							print "<OPTION VALUE=$myrow[seo_url]>$myrow[title]</OPTION>";
						} 
					print " </SELECT>\n"; 
					?> 
					</TD>
				  </TR> 
				  <TR> 
					<TD></TD>
					<TD>
					<SELECT NAME="type"> 
						<OPTION VALUE="movie" SELECTED="SELECTED">Фильма</OPTION>
						<OPTION VALUE="image">Картинки</OPTION> 
						<OPTION VALUE="article">Статьи / обзора</OPTION>
						<OPTION VALUE="award">Награды</OPTION>
						<OPTION VALUE="link">Ссылки</OPTION>															 
		  			</SELECT> 
					</TD>
				  </TR> 
					</TABLE>
				
				</TD> 
			  </TR> 
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="add" VALUE="award">			 
				<INPUT TYPE="Submit" NAME="submit" VALUE="Далее"></TD> 
		  </TR> 
		</TABLE> </FORM></div> 
		<?PHP 
}
	




if ($submit) 
{
// ================== We now have film + type, display list of possible entries ( Need to send type + id ( submit1 )

		if ($type == "link")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление ссылки</h1><br /><br /> 
	  <div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		 <TR> 
			<TD> 
			  <TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				 <TR> 
					<TD>Ссылка</TD> 
					<td> 
					<?php
					$query = "SELECT id,link,description FROM ds_links WHERE film='$film' ORDER BY description";
					$result = mysql_query($query);
					print "<SELECT name=id>\n"; while ($myrow = mysql_fetch_array($result)) { print "
					<OPTION VALUE=$myrow[id]>$myrow[description]</OPTION>";} print " 
					</SELECT>\n"; ?> 
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="links">  					
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Удалить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
			}
		if ($type == "award")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление наград/номинаций</h1><br /><br /> 
	  <div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		 <TR> 
			<TD> 
			  <TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				 <TR> 
					<TD>Награда</TD> 
					<td> 
					<?php
					$query = "SELECT id,description FROM ds_awards WHERE film='$film' ORDER BY description";
					$result = mysql_query($query);
					print "<SELECT name=id>\n"; while ($myrow = mysql_fetch_array($result)) { print "
					<OPTION VALUE=$myrow[id]>$myrow[description]</OPTION>";} print " 
					</SELECT>\n"; ?> 
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="awards"> 
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Удалить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
			}		
		if ($type == "article")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление стати</h1><br /><br /> 
	 <div class="boxbgr"></div>
<div class="boxbg"> <TABLE WIDTH="65%"> 
		 <TR> 
			<TD> 
			  <TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				 <TR> 
					<TD>Статья</TD> 
					<td> 
					<?php
					$query = "SELECT id,title FROM ds_articles WHERE film='$film' ORDER BY title";
					$result = mysql_query($query);
					print "<SELECT name=id>\n"; 
					while ($myrow = mysql_fetch_array($result)) 
						{	print "
							<OPTION VALUE=$myrow[id]>$myrow[title]</OPTION>";
						} 
					print " 
					</SELECT>\n"; ?> 
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="articles"> 
					
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Удалить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP 
 	
	}
		if ($type == "movie")
				{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление фильма</h1><br /><br /> 
	  <div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		 <TR> 
			<TD> 
			  <TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				 <TR> 
					<TD><?php printf ("Вы уверены, что хотите удалить фильм %s ?",$film); ?></TD> 
					<td> 
					
					<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php printf("%s",$film); ?>">
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="movies">					 
					
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Удалить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
	}

if ($type == "image")
				{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Удаление картинки</h1><br /><br /> 
	 <div class="boxbgr"></div>
<div class="boxbg"> <TABLE WIDTH="65%"> 
		 <TR> 
			<TD> 
			  <TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				 <TR> 
					<TD><?php printf ("Вы уверены, что хотите удалить картинку для фильма %s ?",$film); ?></TD> 
					<td> 
					
					<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php printf("%s",$film); ?>">
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="image">					 
					
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Удалить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
	}
}



	
if ($submit1) 
{
// ================== delete 
;
		
		if ($type == "movies")
			{
$sql = "DELETE FROM ds_articles WHERE film='$id'";
$result = mysql_query($sql);

$sql = "DELETE FROM ds_awards WHERE film='$id'";
$result = mysql_query($sql);

$sql = "DELETE FROM ds_links WHERE film='$id'";
$result = mysql_query($sql);

$sql = "SELECT * FROM ds_movies WHERE seo_url = '$id'";
$result = mysql_query($sql);
$imagenumber = mysql_result($result,0,"image");

$sql = "DELETE FROM ds_images WHERE id='$imagenumber'";
$result = mysql_query($sql);

$sql = "DELETE FROM ds_movies WHERE seo_url='$id'";
$result = mysql_query($sql);
			
			}	
			else
			{
				if($type =="image")
					{

						$sql = "SELECT * FROM ds_movies WHERE seo_url = '$id'";
						$result = mysql_query($sql);
						$imagenumber = mysql_result($result,0,"image");
						$sql = "UPDATE `ds_images` SET `filename` = '',`filesize` = '',`filetype` = '' WHERE id='$imagenumber'";
						$result = mysql_query($sql);

					}
				else
					{

						$sql = "DELETE FROM ds_$type WHERE id='$id'"; 
						$result = mysql_query($sql);
					}
			}					
	?>
		<TABLE><tr><td>
	<P><A HREF="delete_data.php">Вернуться</A></P> 
	<P><A HREF="index.php">Главная Контрольной панели</A></P>
	</td></tr></TABLE>
	<?php		
			
}

	
?>
	</BODY>
</HTML>
<?PHP include ("inc/footer.php"); ?>