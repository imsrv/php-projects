<?php

/*
           .ÜÜÜÜÜÜÜÜÜÜÜÜ,                                  .ÜÜÜÜÜÜÜÜÜ:     ,ÜÜÜÜÜÜÜÜ:
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                             .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ             D O N          ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ                           ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ          ÜÜÜÜÜÜÜ;        .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜ;
         ,ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜ        ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜ;
          ÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜ      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜÜÜ
          ÜÜÜÜÜÜÜÜ: ÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜ;;ÜÜÜÜÜÜ;      :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ.
         ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ   ;ÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜ     .ÜÜÜÜÜÜÜÜ;ÜÜÜÜÜÜÜ;ÜÜÜÜÜÜ
        :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜ,,,ÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
        ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
       ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ, ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  .ÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
     .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
    ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ .ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ :ÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
   ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ,ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
  ;ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.  :ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ;     ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ:
 ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ.      ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ,  ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ
 ,ÜÜÜÜLiquidIceÜÜÜÜÜÜ          ÜÜÜÜÜÜÜÜÜÜÜÜÜÜ    ÜÜÜÜÜÜÜÜÜÜÜÜÜÜÜ  ÜÜÜÜÜÜÜÜÜÜÜÜÜ
    .ÜÜÜÜÜÜÜÜÜÜ;                 ÜÜÜÜÜÜÜÜÜ        .ÜÜÜÜÜÜÜÜÜÜÜ    .ÜÜÜÜÜÜÜÜÜÜ,

*/

$act=form_get("act");
$err_mess=form_get("err_mess");
if($act=='')	 blogs();
elseif($act=='create')	create_blog();
elseif($act=='create_done')	create_done();
elseif($act=='edblog')	edblog();
elseif($act=='modblog')	modblog();
elseif($act=='remblog')	remblog();
function blogs()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_mails="select * from blogs where blog_own=$m_id order by blog_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
	$res_mails=mysql_query($sql_mails);
	show_header();
	?>
	<tr>
	  <td valign="top" width="780"><table width="780" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
				  <td align="left" valign="top" class="text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td align="right" class="body"><a href="index.php?mode=blogs&act=create">Add 
						  Blog</a>&nbsp;&nbsp;</td>
					  </tr>
					  <tr> 
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							  <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
								  <tr> 
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
										<tr> 
										  <td height="20" colspan="2" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Blog</td>
										</tr>
										<tr> 
										  <td height="20" colspan="2" align="right" valign="middle" class="form-comment">Blog 
											URL : http://<?=$_SERVER['HTTP_HOST']?>/friends/blog/<?=$m_id?>&nbsp;&nbsp;
										  </td>
										</tr>
										<?php	if(!empty($err_mess))	{	?>
										<tr> 
										  <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
											<?=ucwords($err_mess)?></td>
										</tr>
										<?php	}	?>
										<?php if(!mysql_num_rows($res_mails)) { ?>
										<tr> 
										  <td height="20" colspan="2" align="center" valign="middle" class="body">Blog 
											Is Empty!</td>
										</tr>
										<?php } else { ?>
										<tr> 
										  <td height="20" colspan="2" align="left" valign="middle"> 
											<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
											  <tr> 
												<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
													<?php $chk=1; ?>
													<?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(empty($row_mails->blog_img))	$imgdis="<img src='./blog/noimage.jpg' width='100' height='100' border='0'>";
														else	$imgdis="<img src='./".$row_mails->blog_img."' width='100' height='100' border='0'>";
											  ?>
													<tr> 
													  <td> 
														<?=$imgdis?>
													  </td>
													  
                                                  <td valign="middle"><table width="148%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_mails->blog_memf)?>
                                                          <?=stripslashes($row_mails->blog_meml)?>
                                                          </b>&nbsp;&nbsp;</td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body">&nbsp;&nbsp; 
                                                          <?=stripslashes($row_mails->blog_matt)?>
                                                        </td>
                                                      </tr>
                                                    </table> </td>
													  <td align="right" class="body"> 
														<a href="index.php?mode=blogs&act=edblog&seid=<?=$row_mails->blog_id?>">Edit</a>&nbsp;&nbsp;<a href="index.php?mode=blogs&act=remblog&seid=<?=$row_mails->blog_id?>&page=<?=$page?>">Delete</a>&nbsp;&nbsp;<br> 
														<?=format_date($row_mails->blog_dt)?>
														&nbsp;&nbsp; </td>
													</tr>
													<tr> 
													  <td colspan="3">&nbsp;</td>
													</tr>
													<?php $chk++; ?>
													<?php } ?>
													<tr> 
													  <td colspan="3" class="text">&nbsp;</td>
													</tr>
													<tr> 
													  <td width="17%" align="left">&nbsp;</td>
													  <td width="70%" align="left">&nbsp;</td>
													  <td width="13%" align="right">&nbsp; 
													  </td>
													</tr>
												  </table></td>
											  </tr>
											</table></td>
										</tr>
										<tr> 
										  <td width="93%" height="20" align="right" valign="middle" class="body"> 
											<?php show_page_nos($sql_mails,"index.php?mode=$mode",$lines10,$page,$wh); ?>
										  </td>
										  <?php } ?>
										  <td width="7%" align="center" valign="middle" class="text">&nbsp;</td>
										</tr>
									  </table></td>
								  </tr>
								</table></td>
							</tr>
						  </table></td>
					  </tr>
					</table></td>
				</tr>
			  </table></td>
		  </tr>
		</table>
		<br>
		<br>
	</td></tr>
	<?php
	show_footer();
}
function create_blog()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	show_header();
?>
<tr> 
  <td valign="top" width="780"><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="780" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="67" align="left" valign="top">&nbsp;</td>
              <td width="663" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="index.php?mode=blogs">Blog 
                      List</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Create 
                                        Blog</td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <tr> 
                                      <td align="left" valign="middle" class="text"> 
                                        <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td width="44%" class="body">&nbsp;&nbsp;Entry</td>
                                              <td width="56%"><textarea name="blogmatt" cols="35" rows="5" id="blogmatt" class="field"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set">
                                                <input name="mode" type="hidden" id="act" value="<?=$mode?>"> 
                                                <input name="act" type="hidden" id="act" value="create_done"></td>
                                            </tr>
                                            <tr> 
                                              <td class="body">&nbsp;&nbsp;Image</td>
                                              <td height="30"> <input name="photo" type="file" id="photo" size="30" class="field"> 
                                              </td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Create"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"></td>
                                            </tr>
                                          </table>
                                        </form></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="50" align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br>
    <br>
</td></tr>
<?php
	show_footer();
}
function create_done()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$blogmatt=form_get("blogmatt");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($blogmatt))	{
		$matt="please enter the blog matter.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&err_mess=$matt";
	}	else	{
		$sql_ins="insert into blogs (blog_own,blog_memf,blog_meml,blog_matt,blog_dt) values (";
		$sql_ins.="$m_id,'".$mem->fname."','".$mem->lname."','".addslashes($blogmatt)."',now())";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,$base_path."/blog/".$newname.$p_type);
			$photo="blog/".$newname.$p_type;
			$sql_img="update blogs set blog_img='".$photo."' where blog_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="this blog added to our list.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&err_mess=$matt";
	}
	show_screen($hed);
}
function edblog()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$T1=form_get("T1");
	$sql_query="select * from blogs where blog_id='$seid'";
	$row=sql_execute($sql_query,'get');
	if(empty($T1))	$T1=stripslashes($row->blog_matt);
	show_header();
?>
<tr>
    
  <td valign="top" width="780" ><table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr> 
              <td width="67" align="left" valign="top">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td align="right" class="body"><a href="index.php?mode=blogs">Blog 
                      List</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Edit 
                                        Blog</td>
                                    </tr>
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="body">&nbsp;</td>
                                    </tr>
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <tr> 
                                      <td align="left" valign="middle" class="body"> 
                                        <form name="form1" method="post" action="index.php" enctype="multipart/form-data">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="46%" class="body">&nbsp;&nbsp;Matter</td>
                                              <td width="54%"> <textarea name="blogmatt" cols="35" rows="5" id="blogmatt" class="field"><?=$T1?></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>">
                                                <input name="act" type="hidden" id="act" value="modblog"> 
                                                <input name="seid" type="hidden" id="seid" value="<?=$seid?>"> 
                                              </td>
                                            </tr>
                                            <tr> 
                                              <td class="body">&nbsp;&nbsp;Image</td>
                                              <td height="30"><input name="photo" type="file" id="photo" size="30" class="field"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Modify"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"></td>
                                            </tr>
                                          </table>
                                        </form></td>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="50" align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
    <br>
    <br>
</td></tr>
<?php
	show_footer();
}
function modblog()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$blogmatt=form_get("blogmatt");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($blogmatt))	{
		$matt="please enter the blog matter.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&err_mess=$matt";
	}	else	{
		$sql_ins="update blogs set blog_matt='".addslashes($blogmatt)."' where blog_id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,$base_path."/blog/".$newname.$p_type);
			$photo="blog/".$newname.$p_type;
			$sql_img="update blogs set blog_img='".$photo."' where blog_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="this blog added to our list.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&err_mess=$matt";
	}
	show_screen($hed);
}
function remblog()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
	$sql_query="select * from blogs where blog_id='$seid'";
	$num=sql_execute($sql_query,'num');
	if($num!=0)	{
		$row_img=sql_execute($sql_query,'get');
		$pic_out="./".$row_img->blog_img;
		if(file_exists($pic_out))	@unlink($pic_out);
	}
  	$sql_messrem="delete from blogs where blog_id=$seid";
	mysql_query($sql_messrem);
	$matt="removal completed";
	$hed=$main_url."/index.php?mode=$mode&err_mess=$matt&page=$page";
	show_screen($hed);
}
?>