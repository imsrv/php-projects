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
// =================  Get the movie and which piece of info to edit ( submit -> film + type )
		?> 
	 	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
		<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование</h1><br /><br /> 
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
					<TD>Что изменить</TD>
					<TD>
					<SELECT NAME="type"> 
						<OPTION VALUE="movie_data" SELECTED="SELECTED">Информацию о фильме</OPTION> 
						<OPTION VALUE="movie_image">Картинку фильма</OPTION>
						<OPTION VALUE="article">Статьи / обзоры</OPTION>
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
				<INPUT TYPE="Submit" NAME="submit" VALUE="Вперед"></TD> 
		  </TR> 
		</TABLE> </FORM> </div>
		<?PHP 
}
	

















if ($submit) 
{
// ================== We now have film + type, display list of possible entries ( Need to send type + id ( submit1 )

		if ($type == "link")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование ссылки</h1><br /><br /> 
	<div class="boxbgr"></div>
<div class="boxbg">  <TABLE WIDTH="65%"> 
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
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="link"> 
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Изменить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
			}
		if ($type == "award")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование наград / номинаций</h1><br /><br /> 
	 <div class="boxbgr"></div>
<div class="boxbg"> <TABLE WIDTH="65%"> 
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
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="award"> 
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Изменить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
			}		
		if ($type == "article")
			{
?>
	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование статей</h1><br /><br /> 
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
					print "<SELECT name=id>\n"; while ($myrow = mysql_fetch_array($result)) { print "
					<OPTION VALUE=$myrow[id]>$myrow[title]</OPTION>";} print " 
					</SELECT>\n"; ?> 
					<INPUT TYPE="HIDDEN" NAME="type" VALUE="article"> 
					</TD> 
				</TR> 
			</TABLE> 
		  </TD> 
		</TR> 
		<TR> 
  			<TD COLSPAN="2"> <INPUT TYPE="Submit" NAME="submit1" VALUE="Изменить"></TD> 
		</TR> 
	  </TABLE> 
	 </FORM> </div>
	<?PHP  	
			}				
		if ($type == "movie_data")
			{
{
?>
		 
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	 <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование информации о фильме</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		  <TR> 
			 <TD ALIGN="left"> 
				<TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3">
				 <?php $tempid = $id;

$sql = "SELECT * FROM ds_movies WHERE seo_url = '$film'";
$result = mysql_query($sql);


?>				  
				  <TR> 
					 <TD>Название</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="title" VALUE="<?php print mysql_result($result,0,"title")?>"></TD> 
				  </TR> 
				  <TR> 
					 <TD>Дата выпуска</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="release_date" VALUE="<?php print mysql_result($result,0,"release_date")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Может быть в любом формате, например 21/10/04, Октябрь 2004', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Обзор</TD> 
					 <TD><TEXTAREA NAME="summary" ROWS="15" COLS="50"><?php print mysql_result($result,0,"summary")?></TEXTAREA></TD> 
				  </TR> 
				  <TR> 
					 <TD>Форум</TD>  
					 <TD><INPUT TYPE="TEXT" NAME="forum" VALUE="<?php print mysql_result($result,0,"forum")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Формат: http://www.ruscript.net', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Продолжительность</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="running_time" VALUE="<?php print mysql_result($result,0,"running_time")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Может быть в любом формате. 1 час 20 минут, 80 минут', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Формат/пропорции</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="aspect_ratio" VALUE="<?php print mysql_result($result,0,"aspect_ratio")?>"></TD> 
				  </TR> 
				  <TR> 
					 <TD>Рейтинг MPAA</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="mpaa_rating" VALUE="<?php print mysql_result($result,0,"mpaa_rating")?>"></TD> 
				  </TR> 
				  <TR> 
					 <TD>Бюджет</TD>  
					 <TD><INPUT TYPE="TEXT" NAME="budget" VALUE="<?php print mysql_result($result,0,"budget")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Формат: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Внутренние сборы</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="domestic_gross" VALUE="<?php print mysql_result($result,0,"domestic_gross")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Формат: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Международные сборы</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="international_gross" VALUE="<?php print mysql_result($result,0,"international_gross")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Формат: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>RSS</TD>
					 <TD><INPUT TYPE="TEXT" NAME="rss_newsfeed" VALUE="<?php print mysql_result($result,0,"rss_newsfeed")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Если Вы хотите указать RSS для конкретного фильма, введите его здесь', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>Мировые сборы</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="worldwide_gross" VALUE="<?php print mysql_result($result,0,"worldwide_gross")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Формат: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
				  <TR> 
					 <TD>Met название</TD> 
					 <TD><TEXTAREA NAME="meta_title" ROWS="5" COLS="50"><?php print mysql_result($result,0,"meta_title")?></TEXTAREA></TD> 
				  </TR> 
					<TR> 
					 <TD>Meta описание</TD> 
					 <TD><TEXTAREA NAME="meta_description" ROWS="5" COLS="50"><?php print mysql_result($result,0,"meta_description")?></TEXTAREA></TD> 
				  </TR>
                <TR> 
					 <TD>Meta ключевые слова</TD> 
					 <TD><TEXTAREA NAME="meta_keywords" ROWS="5" COLS="50"><?php print mysql_result($result,0,"meta_keywords")?></TEXTAREA></TD> 
				  </TR>
				  <tr>
				  
</tr>					
				  
				  <TR>
				  <TD>
	
</TD>										

</TR>


													
				</TABLE>
				</TD> 
		  </TR> 
		  <TR> 
			 <TD COLSPAN="2">

<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php print ($film);?>">			 
<INPUT TYPE="HIDDEN" NAME="type" VALUE="movie_data">			 
				<INPUT TYPE="Submit" NAME="submit2" VALUE="Изменить"></TD> 
		  </TR> 
		</TABLE> </FORM> </div><?PHP	
	}
			}



			
		if ($type == "movie_image")
			{

$sql = "SELECT id,image,title FROM ds_movies WHERE seo_url = '$film'";
$result = mysql_query($sql);
$id = mysql_result($result,0,"id");
$image_number = mysql_result($result,0,"image");
$title = mysql_result($result,0,"title");
	
?>
<br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование картинки</h1><br /><br /> 
<div class="boxbgr"></div>
<div class="boxbg"> 
<?PHP 
include ("../include/display_full_image_admin.txt");
include ("../include/connect.txt");

		$sql = "SELECT description,id FROM ds_images WHERE id = '$image_number'";
		$result = mysql_query($sql);
		$description = mysql_result($result,0,"description");



?>
<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"
	  ENCTYPE="multipart/form-data">
	   
<br><br><br>Описание картинки при наведении (alt)<BR>
<INPUT TYPE="text" NAME="form_description" SIZE="40" value ="<?php print $description;?>"> <a href="#" class="hintanchor" onMouseover="showhint('Это будет альтернативный текст для пользователей, кто отключил картинки. Alt тэг так же помогает в SEO.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a>
<INPUT TYPE="hidden" NAME="MAX_FILE_SIZE" VALUE="1000000"> <BR>Картинка для загрузки:<BR> <INPUT TYPE="file" NAME="form_data" SIZE="40"><br>
<INPUT TYPE="hidden" NAME="id" VALUE="<?php print mysql_result($result,0,"id");?>">				 
<INPUT TYPE="hidden" NAME="type" VALUE="movie_image">
<INPUT TYPE="hidden" NAME="title" VALUE="<?php print $title;?>">				
<INPUT TYPE="Submit" NAME="submit2" VALUE="Изменить">
</form>	</div>			
				
				<?php
			}			
			
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
if ($submit1) 
{
// ================== display the info from id .... submit the form changes (submit2) 

		if ($type == "link")
			{
	
	?>
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	 <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование ссылки</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		  <TR> 
			 <TD ALIGN="left"> 
				<TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3"> 
				  <TR> 
						<td> 
						 <?php
							$sql = "SELECT * FROM ds_links WHERE id = ($id)";
							$resultLink = mysql_query($sql);					 
 ?>
					  	</TD>
				  </TR> 
				  <TR> 
					 <TD>URL</TD>
					 <TD><INPUT TYPE="TEXT" NAME="link" VALUE="<?php print mysql_result($resultLink,0,"link")?>" size="40"></TD>
					 <TD><a href="#" class="hintanchor" onMouseover="showhint('Формат: http://www.ruscript.net', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
				  <TR> 
					 <TD>Название</TD>
					 <TD><INPUT TYPE="TEXT" NAME="description" VALUE="<?php print mysql_result($resultLink,0,"description")?>" size="40"></TD> 
				  </TR>
				</TABLE>
			 </TD> 
		  </TR> 
		  <TR> 
			 <TD COLSPAN="2">
				<INPUT TYPE="HIDDEN" NAME="type" VALUE="link">
				<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php print $id; ?>">			 
				<INPUT TYPE="Submit" NAME="submit2" VALUE="Сохранить изменения"></TD> 
		  </TR> 
		</TABLE> 
	  </FORM> </div>
	<?PHP 	
	}
		if ($type == "award")
			{

				
	?>	 
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	 <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование Наград / номинаций</h1><br /><br /> 
	<div class="boxbgr"></div>
<div class="boxbg">	<TABLE WIDTH="65%" > 
		  <TR> 
			 <TD> 
				<TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3" > 
				  <TR> 
					
					 <td> 
					 <?php $tempid = $id;
					 $sql = "SELECT * FROM ds_awards WHERE id = ($id)";
					 $resultAward = mysql_query($sql);					 
					 ?>
					  </TD>
				  </TR> 
				  <TR> 
					 <TD>Тип</TD><TD><SELECT NAME="type2"> 
					 <OPTION VALUE="win" 
					 <?php
					 if ( mysql_result($resultAward,0,"type") == "win" )
						 {
			 				print " SELECTED=\"SELECTED\" ";
			 			 }
			 		 ?>
			 		 >Награда</OPTION> 
			 		<OPTION VALUE="nomination" 
			 		<?php
			 			if ( mysql_result($resultAward,0,"type") == "nomination" )
			 				{
			 					print " SELECTED=\"SELECTED\" ";
							}
					 ?>
			 		 >Номинация</OPTION>			 
		  			 </SELECT> 
					</TD>
				  </TR> 
				  <TR> 
					 <TD>Описание</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="description" VALUE="<?php print mysql_result($resultAward,0,"description")?>"></TD> 
				  </TR>
				</TABLE>
			  </TD> 
		  </TR> 
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php print ($tempid);?>">			 
				<INPUT TYPE="HIDDEN" NAME="type" VALUE="award">			 
				<INPUT TYPE="Submit" NAME="submit2" VALUE="Сохранить изменения">
			 </TD> 
		  </TR> 
		</TABLE> 
	  </FORM> </div>
	 <?PHP 	
	}		
		if ($type == "article")
			{
{
?>
		
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"
	  ENCTYPE="multipart/form-data">
	  <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Редактирование статей</h1><br /><br /> 
		 
			<div class="boxbgr"></div>
<div class="boxbg">	<TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3"> 
				  <TR> 
					 
<td> 
					 <?php $tempid = $id;
$sql = "SELECT * FROM ds_articles WHERE id = ($id)";
$resultArticle = mysql_query($sql);					 

?> 
</TD>
				  </TR> 
					 <TR> 
					 <TD>Название статьи</TD> 
					 <TD><TEXTAREA NAME="title" ROWS="1" COLS="40" ><?php print mysql_result($resultArticle,0,"title")?></TEXTAREA></TD> 
				  </TR> 
				  <TR> 
					 <TD>Статья</TD> 
					 <TD><TEXTAREA NAME="article" ROWS="15" COLS="50"><?php print mysql_result($resultArticle,0,"article")?></TEXTAREA></TD> 
				  </TR> 
				   <TR>
					<TD>Тип</TD>
				 	<TD> <SELECT NAME="type2">
			 		<OPTION VALUE="article" 
					<?php
					if ( mysql_result($resultArticle,0,"type" )== "article" )
					{
					print " SELECTED=\"SELECTED\" ";
					}
					?>
					>Статья</OPTION>
			 		<OPTION VALUE="review"
					<?php
					if ( mysql_result($resultArticle,0,"type") == "review" )
					{
					print " SELECTED=\"SELECTED\" ";
					}
					?>
					
					>Обзор</OPTION>
		 			 </SELECT> </TD>
				  </TR>
				  <TR> 
					 <TD>Ссылка</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="reference" VALUE="<?php print mysql_result($resultArticle,0,"reference")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Ссылка на оригинал статьи', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
					 <TR> 
					 <TD>Meta название</TD> 
					 <TD><TEXTAREA NAME="meta_title" ROWS="5" COLS="50"><?php print mysql_result($resultArticle,0,"meta_title")?></TEXTAREA></TD> 
				  </TR> 
					<TR> 
					 <TD>Meta описание</TD> 
					 <TD><TEXTAREA NAME="meta_description" ROWS="5" COLS="50"><?php print mysql_result($resultArticle,0,"meta_description")?></TEXTAREA></TD> 
				  </TR>
                <TR> 
					 <TD>Meta ключевые слова</TD> 
					 <TD><TEXTAREA NAME="meta_keywords" ROWS="5" COLS="50"><?php print mysql_result($resultArticle,0,"meta_keywords")?></TEXTAREA></TD> 
				  </TR> 							   




			 
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php print ($tempid);?>">			 
<INPUT TYPE="HIDDEN" NAME="type" VALUE="article">			 
				<INPUT TYPE="Submit" NAME="submit2" VALUE="Сохранить изменения"></TD> 
		  </TR> 
		</TABLE> </FORM> </div><?PHP 
	
	}
			}			
		if ($type == "movie_data")
			{

			}			
		if ($type == "movie_image")
			{

			}			
			
}










if ($submit2) 
{
// ============================  write data 

		if ($type == "link")
			{
			$sql = "UPDATE ds_links SET link = '$link',description='$description' WHERE id='$id'";
			$result = mysql_query($sql);			
			}
		if ($type == "award")
			{
			$sql = "UPDATE ds_awards SET type = '$type2',description = '$description' WHERE id='$id'";	  
			$result = mysql_query($sql); 
			}			
		if ($type == "article")
			{
			if ($meta_title == "" )
				 {
					 $meta_title = $title;
				 }
			if ($meta_description == "" )
				 {
  					   $meta_description = $title;
				 }	 
			if ($meta_keywords == "" )
				 {
  					   $meta_keywords = $title;
				 }
	
			$sql = "UPDATE ds_articles SET article = '$article',type = '$type2',reference = '$reference',meta_title = '$meta_title',meta_description = '$meta_description',meta_keywords = '$meta_keywords',title = '$title' WHERE id='$id'";	  
			$result = mysql_query($sql);	
			}			
		if ($type == "movie_data")
			
			{
				if ($meta_title == "" )
					{
						$meta_title = $title;
					}
				if ($meta_description == "" )
	 {
     $meta_description = $title;
	 }	 
if ($meta_keywords == "" )
	 {
     $meta_keywords = $title;
	 }	 	 
$sql = "UPDATE ds_movies SET title = '$title',release_date = '$release_date',summary = '$summary',forum = '$forum',running_time = '$running_time',aspect_ratio = '$aspect_ratio',mpaa_rating = '$mpaa_rating',budget = '$budget',domestic_gross = '$domestic_gross',international_gross = '$international_gross',worldwide_gross = '$worldwide_gross',meta_title = '$meta_title',meta_description = '$meta_description',meta_keywords = '$meta_keywords',rss_newsfeed = '$rss_newsfeed' WHERE seo_url='$id'";	  
$result = mysql_query($sql);	
	}					
		if ($type == "movie_image")
			{
				if (filesize($form_data)>0)
					{
						$data = addslashes(fread(fopen($form_data, "r"), filesize($form_data)));
						if ($form_description == "")
							{
								$form_description = $title;
							}

						$sql = "UPDATE ds_images SET description = '$form_description',bin_data = '$data',filename = '$form_data_name',filesize = '$form_data_size',filetype = '$form_data_type' WHERE id='$id'";	  
						$result = mysql_query($sql);
					 
					}
				else
					{
						if ($form_description == "")
							{
								$form_description = $title;
							}
						$sql = "UPDATE ds_images SET description = '$form_description' WHERE id='$id'";	  
						$result = mysql_query($sql);	
					}		 
			}			
		?>
	<TABLE><tr><td>
	<P><A HREF="edit_data.php">Вернуться</A></P> 
	<P><A HREF="index.php">Гланвая Панели Администратора</A></P>
	</td></tr></TABLE>
	<?php	
	}






?>
	</BODY>
</HTML>

<?PHP include ("inc/footer.php"); ?>