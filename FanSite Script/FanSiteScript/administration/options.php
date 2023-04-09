<?php include ("inc/security.inc") ?>
<?PHP include ("inc/header.php"); ?>
<?PHP 
include ("../include/connect.txt");
if ($submit)
{


if ( $new_password == "" )
	{
$sql = "UPDATE ds_options SET thumbnail = '$thumbnail',currency = '$currency',amazon = '$amazon',rating = '$rating', movie_page ='$movie_page',movie_summary = '$movie_summary',article_page = '$article_page',
article_summary = '$article_summary',rss_default = '$rss_default',rss_count = '$rss_count',rss_advert_text ='$rss_advert_text',rss_advert_link = '$rss_advert_link',e_mail = '$e_mail',site_url = '$site_url',site_name = '$site_name',search_number = '$search_number',e_mail_subject = '$e_mail_subject',username = '$new_username',meta_title = '$meta_title', meta_description = '$meta_description', meta_keywords = '$meta_keywords' WHERE id='0'";	  
	}
	else
	{
 $salt = substr($new_password, 0, 2);
  $encrypted_pswd = crypt($new_password, $salt);
$sql = "UPDATE ds_options SET thumbnail = '$thumbnail',currency = '$currency',amazon = '$amazon',rating = '$rating', movie_page ='$movie_page',movie_summary = '$movie_summary',article_page = '$article_page',
article_summary = '$article_summary',rss_default = '$rss_default',rss_count = '$rss_count',rss_advert_text ='$rss_advert_text',rss_advert_link = '$rss_advert_link',e_mail = '$e_mail',site_url = '$site_url',site_name = '$site_name',search_number = '$search_number',e_mail_subject = '$e_mail_subject',username = '$new_username',password = '$encrypted_pswd',meta_title = '$meta_title', meta_description = '$meta_description', meta_keywords = '$meta_keywords' WHERE id='0'";	  
	}
$result = mysql_query($sql);	


	
	?>
	<TABLE><tr><td>
		<P><A HREF="index.php">Вернуться</A></P> 
	</td></tr></TABLE>
	<?php
}
else
{
	?>
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>">
	 <br /><h1><img src="../images/admin/bullet.gif" alt="" /> Настройки</h1><br /><br /> 
	<div class="boxbgr"></div>
<div class="boxbg">	<TABLE WIDTH="100%"> 
		  <TR> 
			 <TD ALIGN="left"> 
				<TABLE WIDTH="100%" CELLPADDING="3"
				 CELLSPACING="3"> 
				  <TR> 
					 <TD><B>Options</B></TD>
						<td> 
						 <?php
							$sql = "SELECT * FROM ds_options WHERE id = '0'";
							$result = mysql_query($sql);					  
						  ?> 
						  
					  	</TD>
				  </TR> 
				  <TR> 
					 <TD>Ширина миниатюр</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="thumbnail" VALUE="<?php print mysql_result($result,0,"thumbnail")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Вы можете изменять ширину миниатюр, которые создаются для картинок, которые Вы загружаете.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
<TR> 
					 <TD>Валюта</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="currency" VALUE="<?php print mysql_result($result,0,"currency")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Смените валюту на ту, которую хотите использовать, RUR, $ и т.д...', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
<TR> 
					 <TD>Amazon ID</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="amazon" VALUE="<?php print mysql_result($result,0,"amazon")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Для начала заработка - введите идентификационный номер на Amazon.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
<TR> 
					 <TD>Тип рейтинга фильма</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rating" VALUE="<?php print mysql_result($result,0,"rating")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Вы можете сменить тип рейтинга, по-умолчанию MPAA.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>	
<TR> 
					 <TD>Количество фильмов на странице</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="movie_page" VALUE="<?php print mysql_result($result,0,"movie_page")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Вы можете изменить количество фильмов на странице.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
					 <TD>Количество символов для обзора фильма</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="movie_summary" VALUE="<?php print mysql_result($result,0,"movie_summary")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Количество символов Вы хотите отобразить в списке фильмов для обзора.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>				  
<TR> 
					 <TD>Количество статей на странице</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="article_page" VALUE="<?php print mysql_result($result,0,"article_page")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Вы можете изменить количество статей на странице.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
					 <TD>Количество символов для статей</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="article_summary" VALUE="<?php print mysql_result($result,0,"article_summary")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Количество символов Вы хотите отобразить в списке фильмов для статей.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>	
<TR> 
					 <TD>Подписка RSS по-умолчанию</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rss_default" VALUE="<?php print mysql_result($result,0,"rss_default")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Подписка RSS по-умолчанию', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD>
					  
				  </TR>
<TR> 
					 <TD>Количество подписок RSS</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rss_count" VALUE="<?php print mysql_result($result,0,"rss_count")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Если Вы хотите ограничить количество новостей для отображения в RSS- введите число.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
					 <TD>RSS заголовок рекламы</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rss_advert_text" VALUE="<?php print mysql_result($result,0,"rss_advert_text")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Эта функция отобразит ссылку перед новостями для каждого фильма.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
					 <TD>RSS URL рекламы</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rss_advert_link" VALUE="<?php print mysql_result($result,0,"rss_advert_link")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Эта функция отобразит ссылку перед новостями для каждого фильма.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>	
<TR> 
					 <TD>E-Mail администратора</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="e_mail" VALUE="<?php print mysql_result($result,0,"e_mail")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Это позволит пользователям связаться с Вами по email через контактную форму.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
<TR> 
					 <TD>E-Mail Тема</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="e_mail_subject" VALUE="<?php print mysql_result($result,0,"e_mail_subject")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Здесь можно указать тему сообщения', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>

					 <TD>URL сайта</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="site_url" VALUE="<?php print mysql_result($result,0,"site_url")?>"></TD> 
				  </TR>	
<TR> 
					 <TD>Название сайта</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="site_name" VALUE="<?php print mysql_result($result,0,"site_name")?>"></TD> 
				  </TR>
<TR> 
					 <TD>Результатов в поиске на страницу</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="search_number" VALUE="<?php print mysql_result($result,0,"search_number")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Какое количество фильмов отобразится на странице с результатами поиска', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
				  <TR> 
					 <TD>Meta название</TD> 
					 <TD><TEXTAREA NAME="meta_title" ROWS="2" COLS="40"><?php print mysql_result($result,0,"meta_title")?></TEXTAREA></TD> 
				  </TR> 
					<TR> 
					 <TD>Meta описание</TD> 
					 <TD><TEXTAREA NAME="meta_description" ROWS="5" COLS="40"><?php print mysql_result($result,0,"meta_description")?></TEXTAREA></TD> 
				  </TR>
                <TR> 
					 <TD>Meta ключевые слова</TD> 
					 <TD><TEXTAREA NAME="meta_keywords" ROWS="5" COLS="40"><?php print mysql_result($result,0,"meta_keywords")?></TEXTAREA></TD> 
				  </TR>	
<TR> 
					 <TD>Имя пользователя</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="new_username" VALUE="<?php print mysql_result($result,0,"username")?>"> <a href="#" class="hintanchor" onMouseover="showhint('Ваш логин для входа в админ-панель', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
<TR> 
					 <TD>Пароль</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="new_password"> <a href="#" class="hintanchor" onMouseover="showhint('Ваш пароль для входа в админ-панель', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>				  								  				  					  					  			  					  					  			  				  
			   </TABLE>
			 </TD> 
		  </TR> 
		  <TR> 
			 <TD COLSPAN="2">

				<INPUT TYPE="HIDDEN" NAME="id" VALUE="<?php print $id; ?>">			 
				<INPUT TYPE="Submit" NAME="submit" VALUE="Сохранить изменения"></TD> 
		  </TR> 
	   </TABLE> 
	  </FORM> </div>
	<?PHP 	
	}

?>
<?PHP include ("inc/footer.php"); ?>