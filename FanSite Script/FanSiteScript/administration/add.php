<?php include ("inc/security.inc") ?>
<?PHP include ("inc/header.php"); ?>
<?PHP 
include ("../include/connect.txt");


if ($submit) 
	{	
		if ( $add == "movie" )
			{
if ($form_data != "")
{
				$data = addslashes(fread(fopen($form_data, "r"), filesize($form_data)));
					if ($form_description == "")
						{
							$form_description = $title;
						}
				$result=MYSQL_QUERY("INSERT INTO ds_images (description,bin_data,filename,filesize,filetype) ".
 			       "VALUES ('$form_description','$data','$form_data_name','$form_data_size','$form_data_type')");

   				$imageid= mysql_insert_id();
}
else
{
					if ($form_description == "")
						{
							$form_description = $title;
						}
$data ="";
$form_data_name="";
$form_data_size="";
$form_data_type="";
				$result=MYSQL_QUERY("INSERT INTO ds_images (description,bin_data,filename,filesize,filetype) ".
 			       "VALUES ('$form_description','$data','$form_data_name','$form_data_size','$form_data_type')");

   				$imageid= mysql_insert_id();
}


				$seo = $title;
				$seo=ereg_replace("[^a-z,A-Z,0-9, ]","",$seo);
				if ($meta_title == "" )
					{
						$meta_title = $seo;
					}
				if ($meta_description == "" )
					{
     						$meta_description = $seo;
	 				}	 
				if ($meta_keywords == "" )
	 				{
     						$meta_keywords = $seo;
	 				}	 	 

				$seo = str_replace(" ","_",$seo);
				$worldWide = $domestic_gross + $international_gross;
				$sql = "INSERT INTO ds_movies (title,release_date,summary,forum,image,running_time,aspect_ratio,mpaa_rating,budget,domestic_gross,international_gross,worldwide_gross,meta_title,meta_description,meta_keywords,seo_url,rss_newsfeed) VALUES ('$title','$release_date','$summary','$forum','$imageid','$running_time','$aspect_ratio','$mpaa_rating','$budget','$domestic_gross','$international_gross','$worldWide','$meta_title','$meta_description','$meta_keywords','$seo','$rss_newsfeed')"; 
				$result = mysql_query($sql);
			}

		if ( $add == "article" )
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

	 	 
				  $sql = "INSERT INTO ds_articles (film,article,type,reference,meta_title,meta_description,meta_keywords,title) VALUES ('$film','$article','$type','$reference','$meta_title','$meta_description','$meta_keywords','$title')"; 
				  $result = mysql_query($sql);
				  $id= mysql_insert_id();
				  $title=ereg_replace("[^a-z,A-Z,0-9, ]","",$title);
				  $seo = str_replace(" ","_",$title);
				  $film=ereg_replace("[^a-z,A-Z,0-9, ]","",$film);
				  $seo2 = str_replace(" ","_",$film);
				  $seo_url = $seo."_".$seo2."_".$id;

	 	 
				  $sql = "UPDATE ds_articles SET seo_url = '$seo_url' WHERE id='$id'";
				  $result = mysql_query($sql);	  
			   }
		if ( $add == "award" )
			{
				$sql = "INSERT INTO ds_awards (film,type,description) VALUES ('$film','$type','$description')"; 
				$result = mysql_query($sql); 
			}
		if ( $add == "link" )
			{
				if ($description =="")
					{
						$description = $link;
					}
				$sql = "INSERT INTO ds_links (film,link,description) VALUES ('$film','$link','$description')"; 
				$result = mysql_query($sql);
			}

		printf("%s added<br>",$add);
		?>
		<TABLE>  
		<P><A HREF="index.php">�����</A></P> 
		</TABLE> 
		<?php
	} 

if ($add == "link")
	{
		?>
		<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"><br />
		<h1><img src="../images/admin/bullet.gif" alt="" /> ���������� ������</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
			<TR> 
				<TD ALIGN="left"> 
					<TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3"> 
				  		<TR> 
					 		<TD>�����</TD>
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
							 <TD>URL</TD> 
							 <TD><INPUT TYPE="TEXT" NAME="link" size="40"></TD>
							 <TD><a href="#" class="hintanchor" onMouseover="showhint('������: http://www.ruscript.net', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD>					  
						</TR>
						  <TR> 
							 <TD>��������</TD> 
							 <TD><INPUT TYPE="TEXT" NAME="description" size="40"></TD>
												  
						</TR>
					</TABLE>
				</TD> 
			</TR> 
			<TR> 
			<TD COLSPAN="2">
			<INPUT TYPE="HIDDEN" NAME="add" VALUE="link">			 
			<INPUT TYPE="Submit" NAME="submit" VALUE="��������">
			</TD> 
			</TR> 
		</TABLE> 
		</FORM> </div>
		<?PHP 
	}
if ($add == "award")
	{
		?> 
	 	<FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"><br />
		<h1><img src="../images/admin/bullet.gif" alt="" /> ���������� ������� / ���������</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%" > 
			<TR> 
				<TD> 
					<TABLE WIDTH="65%" CELLPADDING="3" CELLSPACING="3" > 
				  <TR> 
					<TD>�����</TD>
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
					<TD>���</TD>
					<TD>
					<SELECT NAME="type"> 
						<OPTION VALUE="win" SELECTED="SELECTED">�������</OPTION> 
						<OPTION VALUE="nomination" SELECTED="SELECTED">���������</OPTION>			 
		  			</SELECT> 
					</TD>
				  </TR> 
				  <TR> 
					 <TD>��������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="description" size="50"></TD> 
				  </TR>
				  
					</TABLE>
				
				</TD> 
			  </TR> 
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="add" VALUE="award">			 
				<INPUT TYPE="Submit" NAME="submit" VALUE="��������"></TD> 
		  </TR> 
		</TABLE> </FORM></div> <?PHP 
}
if ($add == "article")
{
?>
		
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"
	  ENCTYPE="multipart/form-data"> <br />
		<h1><img src="../images/admin/bullet.gif" alt="" /> ���������� ������</h1><br /><br />
				<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3"> 
				  <TR> 
					 <TD>�����</TD>
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
					 <TD>�������� ������</TD> 
					 <TD><INPUT TYPE="TEXT"  NAME="title"></TD> 
				  </TR> 
				  <TR> 
					 <TD>������</TD> 
					 <TD><TEXTAREA NAME="article" ROWS="15" COLS="50"></TEXTAREA></TD> 
				  </TR> 
				   <TR>
					<TD>���</TD>
				 	<TD> <SELECT NAME="type">
			 		<OPTION VALUE="article" SELECTED="SELECTED">������</OPTION>
			 		<OPTION VALUE="review">�����</OPTION>
		 			 </SELECT> </TD>
				  </TR>
				  <TR> 
					 <TD>������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="reference"> <a href="#" class="hintanchor" onMouseover="showhint('�� ������� �����, ������ ���� ����� ������ - ��� ����� ���� URL ��� ��������.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR>
					 <TR> 
					 <TD>Meta ��������</TD> 
					 <TD><TEXTAREA NAME="meta_title" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR> 
					<TR> 
					 <TD>Meta ��������</TD> 
					 <TD><TEXTAREA NAME="meta_description" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR>
                <TR> 
					 <TD>Meta �������� �����</TD> 
					 <TD><TEXTAREA NAME="meta_keywords" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR> 							   




			
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="add" VALUE="article">			 
				<INPUT TYPE="Submit" NAME="submit" VALUE="��������"></TD> 
		  </TR> 
		</TABLE> </FORM></div> <?PHP 

}
if ($add == "movie")
{
?>
		 
	 <FORM METHOD="post" ACTION="<?php echo $PHP_SELF?>"
	  ENCTYPE="multipart/form-data"><br />
	  <h1><img src="../images/admin/bullet.gif" alt="" /> ���������� ������</h1><br /><br /> 
		<div class="boxbgr"></div>
<div class="boxbg"><TABLE WIDTH="65%"> 
		  <TR> 
			 <TD ALIGN="left"> 
				<TABLE WIDTH="65%" CELLPADDING="3"
				 CELLSPACING="3"> 
				  <TR> 
					 <TD>��������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="title"></TD> 
				  </TR> 
				  <TR> 
					 <TD>���� �������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="release_date"> <a href="#" class="hintanchor" onMouseover="showhint('����� ���� � ����� �������, �������� 21/10/04, ������� 2004', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>�����</TD> 
					 <TD><TEXTAREA NAME="summary" ROWS="15" COLS="50"></TEXTAREA></TD> 
				  </TR> 
				  <TR> 
					 <TD>�����</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="forum"> <a href="#" class="hintanchor" onMouseover="showhint('������: http://www.ruscript.net', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>�����������������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="running_time"> <a href="#" class="hintanchor" onMouseover="showhint('����� ���� � ����� �������. 1 ��� 20 �����, 80 �����', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>������/���������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="aspect_ratio"></TD> 
				  </TR> 
				  <TR> 
					 <TD>������� MPAA</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="mpaa_rating"></TD> 
				  </TR> 
				  <TR> 
					 <TD>������</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="budget"> <a href="#" class="hintanchor" onMouseover="showhint('������: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>���������� �����</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="domestic_gross"> <a href="#" class="hintanchor" onMouseover="showhint('������: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>������������� �����</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="international_gross"> <a href="#" class="hintanchor" onMouseover="showhint('������: 145.3', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  <TR> 
					 <TD>RSS</TD> 
					 <TD><INPUT TYPE="TEXT" NAME="rss_newsfeed"> 
					 <a href="#" class="hintanchor" onMouseover="showhint('���� �� ������ ������� RSS ��� ����������� ������, ������� ��� �����.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a></TD> 
				  </TR> 
				  
				  <TR> 
					 <TD>Meta ��������</TD> 
					 <TD><TEXTAREA NAME="meta_title" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR> 
					<TR> 
					 <TD>Meta ��������</TD> 
					 <TD><TEXTAREA NAME="meta_description" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR>
                <TR> 
					 <TD>Meta �������� �����</TD> 
					 <TD><TEXTAREA NAME="meta_keywords" ROWS="5" COLS="50"></TEXTAREA></TD> 
				  </TR> 				   				  				  
				  			   
				</TABLE><div style="text-align:left;">�������� �������� ��� ��������� (alt):<BR>
				<INPUT TYPE="text" NAME="form_description" SIZE="40"> <a href="#" class="hintanchor" onMouseover="showhint('��� ����� �������������� ����� ��� �������������, ��� �������� ��������. Alt ��� ��� �� �������� � SEO.', this, event, '150px')"><img src="../images/admin/helpicon.gif" border="0" /></a>
				<INPUT TYPE="hidden" NAME="MAX_FILE_SIZE" VALUE="1000000"> <BR>�������� ��� ��������:<BR> <INPUT TYPE="file" NAME="form_data" SIZE="40"></div>
				</TD> 
		  </TR> 
		  <TR> 
			 <TD COLSPAN="2">
<INPUT TYPE="HIDDEN" NAME="add" VALUE="movie">			 
				<INPUT TYPE="Submit" NAME="submit" VALUE="��������"></TD> 
		  </TR> 
		</TABLE> </FORM></div> <?PHP
} // end if


include ("../include/close.txt");



?>
<?PHP include ("inc/footer.php"); ?>