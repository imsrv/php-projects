<?php/*
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
if($act=='')	 forums();
elseif($act=='viewcat')	viewcat();
elseif($act=='viewforum')	viewforum();
elseif($act=='create')	create_forum();
elseif($act=='create_done')	create_done();
elseif($act=='more')	more();
elseif($act=='remfor')	remfor();
function forums()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$dis=array();
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_fcat="select * from f_categories LIMIT ".($page-1)*$lines10.",".$lines10;
	$res_fcat=mysql_query($sql_fcat);
	show_header();
	?>
	<tr>
  <td valign="top" width="780">
    <table width="760" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="67" align="left" valign="top" class="body">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="19" class="title">&nbsp;&nbsp;Forums</td>
                  </tr>
                  <tr> 
                    <td class="title">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                              <?php if(!mysql_num_rows($res_fcat)) { ?>
                              <tr> 
                                <td align="center" class="form-comment">Forum 
                                  is empty!</td>
                              </tr>
								<?php } else { ?>
                              <tr>
                                <td align="center" class="body"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                                    <tr valign="middle"> 
                                      <td width="54%" height="25" class="title">Forums</td>
                                      <td width="13%" height="25" align="center" class="title">Topics</td>
                                      <td width="11%" height="25" align="center" class="title">Posts</td>
                                      <td width="22%" height="25" align="center" class="title">Last 
                                        Post</td>
                                    </tr>
                                    <tr valign="middle"> 
                                      <td colspan="4"><hr width="100%" size="1" color="#C0C0C0"></td>
                                    </tr>
                                    <?php while($row_fcat=mysql_fetch_object($res_fcat)) { ?>
                                    <tr> 
                                      <td width="54%" valign="top" class="form-comment"> 
                                        <font size="2"><strong><a href="index.php?mode=forums&act=viewcat&seid=<?=$row_fcat->f_cat_id?>"> 
                                        <?=stripslashes($row_fcat->name)?>
                                        </a></strong></font> 
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr> 
                                            <td class="body"> 
                                              <?=stripslashes($row_fcat->descr)?>
                                            </td>
                                          </tr>
                                        </table></td>
                                      <td width="13%" align="center" valign="top" class="body"> 
                                        <?=tot_top($row_fcat->f_cat_id);?>
                                      </td>
                                      <td width="11%" align="center" valign="top" class="body"> 
                                        <?=tot_pos($row_fcat->f_cat_id);?>
                                      </td>
                                      <td width="22%" align="center" valign="top" class="body"> 
                                        <?=lpost_pos($row_fcat->f_cat_id);?>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td colspan="4" valign="top" class="form-comment">&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                    <tr> 
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td align="right"> 
                                        <?php show_page_nos($sql_fcat,"index.php?mode=$mode&cat=$cat&dt=$dt",$lines10,$page,$wh); ?>
                                        &nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
							  <?php } ?>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="50" align="left" valign="top" class="body">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table> <br>
    <br>
	  </td>
	</tr>
	<?php
	show_footer();
}
function viewcat()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$dis=array();
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_f="select * from forums where f_c_id=$seid and f_st='P' LIMIT ".($page-1)*$lines10.",".$lines10;
	$res_f=mysql_query($sql_f);
	$res_fcat=mysql_query("select * from f_categories where f_cat_id=$seid");
	$row_fcat=mysql_fetch_object($res_fcat);
	show_header();
	?>
	<tr>
  <td valign="top" width="780">
    <table width="760" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="67" align="left" valign="top" class="body">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="19" class="title">&nbsp;&nbsp;<a href="index.php?mode=forums&page=<?=$page?>">Forums</a> 
                      &nbsp;>>&nbsp;<a href="index.php?mode=forums&act=viewcat&seid=<?=$seid?>"><?=stripslashes($row_fcat->name)?></a>
					  &nbsp;>>&nbsp;View Forum</td>
                  </tr>
                  <tr> 
                    <td align="center" valign="middle" class="body">
                      <?=stripslashes($row_f->descr)?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="body">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="body">&nbsp;<a href="index.php?mode=forums&act=create&cat=<?=$seid?>&pr=p">Start a New 
                      Topic</a></td>
                  </tr>
                  <tr> 
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                              <?php if(!mysql_num_rows($res_f)) { ?>
                              <tr> 
                                <td align="center" class="form-comment">List 
                                  is empty!</td>
                              </tr>
                              <?php } else { ?>
                              <tr> 
                                <td align="center" class="body"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                                    <tr valign="middle"> 
                                      <td width="52%" height="25" class="title">Topics</td>
                                      <td width="15%" height="25" align="center" class="title">Topic 
                                        Starter</td>
                                      <td width="11%" height="25" align="center" class="title">Replies</td>
                                      <td width="22%" height="25" align="center" class="title">Last 
                                        Post</td>
                                    </tr>
                                    <tr valign="middle"> 
                                      <td colspan="4"><hr width="100%" size="1" color="#C0C0C0"></td>
                                    </tr>
                                    <?php while($row_f=mysql_fetch_object($res_f)) { ?>
                                    <tr valign="middle"> 
                                      <td width="52%" height="30" class="body"> 
                                        <font size="2"><strong><a href="index.php?mode=forums&act=viewforum&cats=<?=$seid?>&seid=<?=$row_f->f_id?>&page=<?=$page?>"> 
                                        <?=stripslashes($row_f->f_matt)?>
                                        </a></strong></font> </td>
                                      <td width="15%" height="30" align="center" class="body"> 
                                        <?=show_memnam($row_f->f_own);?>
                                      </td>
                                      <td width="11%" height="30" align="center" class="body"> 
                                        <?=tot_ros($row_f->f_id);?>
                                      </td>
                                      <td width="22%" height="30" align="center" class="body"> 
                                        <?=lpost_ros($row_f->f_id);?>
                                      </td>
                                    </tr>
                                    <tr valign="middle" bgcolor="#FFFFFF"> 
                                      <td colspan="4" class="body">&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                    <tr> 
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                      <td align="right"> 
                                        <?php show_page_nos($sql_f,"index.php?mode=$mode&cat=$cat",$lines10,$page,$wh); ?>
                                        &nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <?php } ?>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="50" align="left" valign="top" class="body">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table> <br>
    <br>
	  </td>
	</tr>
	<?php
	show_footer();
}
function viewforum()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$cats=form_get("cats");
	$dis=array();
	$sql_co="select * from forums where f_rid=$seid and f_st='R'";
	$res_co=mysql_query($sql_co);
	$co=mysql_num_rows($res_co);
	$sql_h="select * from forums where f_id=$seid and f_st='P'";
	$res_h=mysql_query($sql_h);
	$row_h=mysql_fetch_object($res_h);
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_f="select * from forums where f_rid=$seid and f_st='R' LIMIT ".($page-1)*$lines10.",".$lines10;
	$res_f=mysql_query($sql_f);
	$res_fcat=mysql_query("select * from f_categories where f_cat_id=$cats");
	$row_fcat=mysql_fetch_object($res_fcat);
	show_header();
	?>
	<tr>
  <td valign="top" width="780">
    <table width="760" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="67" align="left" valign="top" class="body">&nbsp;</td>
              <td width="663" align="left" valign="top" class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="19" class="title">&nbsp;&nbsp;<a href="index.php?mode=forums&page=<?=$page?>">Forums</a> 
                      &nbsp;>>&nbsp;<a href="index.php?mode=forums&act=viewcat&seid=<?=$cats?>"><?=stripslashes($row_fcat->name)?></a> &nbsp;>>&nbsp;View Replies</td>
                  </tr>
                  <tr>
                    <td height="19" class="title">&nbsp;&nbsp;Topic : <a href="index.php?mode=forums&act=viewforum&cats=<?=$cats?>&seid=<?=$seid?>&page=<?=$page?>"><?=stripslashes($row_h->f_matt)?></a></td>
                  </tr>
                  <tr> 
                    <td align="center" valign="middle" class="body"> 
                      <?=stripslashes($row_f->descr)?>
                    </td>
                  </tr>
                  <tr> 
                    <td align="center" valign="middle" class="body">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td align="left" valign="middle" class="body">&nbsp;<a href="index.php?mode=forums&act=create&cat=<?=$cats?>&pr=r&qst=<?=$seid?>">Post 
                      a Reply</a></td>
                  </tr>
                  <tr> 
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                              <?php if(!mysql_num_rows($res_f)) { ?>
                              <tr> 
                                <td align="center" class="form-comment">List is 
                                  empty!</td>
                              </tr>
                              <?php } else { ?>
                              <tr> 
                                <td align="center" class="body"><table width="98%" border="0" cellspacing="0" cellpadding="0">
                                    <tr valign="middle"> 
                                      <td width="14%" height="25" align="center" class="title">Author</td>
                                      <td width="35%" height="25" align="center" class="title">Replies</td>
                                      <td width="51%" align="right" class="title">Total 
                                        Replies: 
                                        <?=$co?>
                                        &nbsp; </td>
                                    </tr>
                                    <tr valign="middle"> 
                                      <td colspan="3"><hr width="100%" size="1" color="#C0C0C0"></td>
                                    </tr>
                                    <?php while($row_f=mysql_fetch_object($res_f)) { ?>
                                    <tr> 
                                      <td width="14%" align="center" valign="top" class="body"> 
                                        <font> 
                                        <?=show_photo($row_f->f_own);?>
                                        <br>
                                        <?=show_online($row_f->f_own);?>
                                        </font></td>
                                      <td colspan="2" align="center" valign="middle" class="body"> 
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td class="body"><?=format_date($row_f->f_dt)?>
                                              <hr align="center" width="98%" size="1"></td>
                                          </tr>
                                          <tr> 
                                            <td class="body"><font color="#666666" size="2"> 
                                              <?=stripslashes($row_f->f_matt)?>
                                              </font></td>
                                          </tr>
                                        </table>
                                      </td>
                                    </tr>
                                    <tr> 
                                      <td colspan="3" align="center" valign="top" class="body">&nbsp;</td>
                                    </tr>
                                    <?php } ?>
                                    <tr> 
                                      <td>&nbsp;</td>
                                      <td colspan="2" align="right"> 
                                        <?php show_page_nos($sql_f,"index.php?mode=$mode&cat=$cat",$lines10,$page,$wh); ?>
                                        &nbsp;</td>
                                    </tr>
                                  </table></td>
                              </tr>
                              <?php } ?>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td width="50" align="left" valign="top" class="body">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table> <br>
    <br>
	  </td>
	</tr>
	<?php
	show_footer();
}
function create_forum()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	$cat=form_get("cat");
	$pr=form_get("pr");
	$qst=form_get("qst");
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
                    <td align="right" class="body"><a href="index.php?mode=forums&page=<?=$page?>">Back</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;<?php if($pr=='p') { ?>Post Thread<?php } elseif($pr=='r') { ?>Post Reply<?php } ?></td>
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
                                        <form name="form1" method="post" action="index.php">
                                          <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td width="44%" class="body">&nbsp;&nbsp;<?php if($pr=='p') { ?>Thread<?php } elseif($pr=='r') { ?>Reply<?php } ?></td>
                                              <td width="56%"><textarea name="blogmatt" cols="35" rows="5" id="blogmatt" class="field"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>">
												<input name="cat" type="hidden" id="cat" value="<?=$cat?>">
                                                <input name="act" type="hidden" id="act" value="create_done">
                                                <input name="page" type="hidden" id="page" value="<?=$page?>">
												<input name="pr" type="hidden" id="pr" value="<?=$pr?>">
												<input name="qst" type="hidden" id="qst" value="<?=$qst?>"></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2" align="center">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="<?php if($pr=='p') { ?>Post Thread<?php } elseif($pr=='r') { ?>Post Reply<?php } ?>"></td>
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
	$cat=form_get("cat");
	$page=form_get("page");
	$act=form_get("act");
	$pr=form_get("pr");
	$qst=form_get("qst");
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$blogmatt=form_get("blogmatt");
	if(empty($blogmatt))	{
		$matt="please enter the thread.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&cat=$cat&page=$page&err_mess=$matt";
	}	else	{
		if($pr=='p')	{
			$sql_ins="insert into forums (f_c_id,f_own,f_memf,f_meml,f_matt,f_dt,f_st) values (";
			$sql_ins.="$cat,$m_id,'".$mem->fname."','".$mem->lname."','".addslashes($blogmatt)."',now(),'P')";
			mysql_query($sql_ins);
			$prim=mysql_insert_id();
			mysql_query("update f_categories set lpost=$prim where f_cat_id=$cat");
			$matt="this entry added to our list.";
			$hed=$main_url."/index.php?mode=$mode&act=viewcat&seid=$cat&err_mess=$matt";
		}	elseif($pr=='r')	{
			$sql_ins="insert into forums (f_c_id,f_own,f_memf,f_meml,f_matt,f_dt,f_st,f_rid,f_last) values (";
			$sql_ins.="$cat,$m_id,'".$mem->fname."','".$mem->lname."','".addslashes($blogmatt)."',now(),'R',$qst,now())";
			mysql_query($sql_ins);
			$matt="this entry added to our list.";
			$hed=$main_url."/index.php?mode=$mode&act=viewforum&cats=$cat&seid=$qst&err_mess=$matt";
		}
	}
	show_screen($hed);
}
function more()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$dis=array();
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	$sql_fcat="select * from f_categories where f_cat_id=$cat";
	$res_fcat=mysql_query($sql_fcat);
	show_header();
	?>
	<tr>
	  <td valign="top" width="780"><table width="760" cellpadding="0" cellspacing="0">
		  <tr>
			<td><table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr> 
				  <td width="67" align="left" valign="top">&nbsp;</td>
				  <td width="663" align="left" valign="top" class="text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td class="title">&nbsp;&nbsp;Forums</td>
					  </tr>
					  <tr> 
						<td class="title">&nbsp;</td>
					  </tr>
					  <tr> 
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							  <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
								  <tr> 
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <?php if(!mysql_num_rows($res_fcat)) { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">Forum 
                                        Is Empty!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <?php while($row_fcat=mysql_fetch_object($res_fcat))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="body">&nbsp;&nbsp;<u><b><?=stripslashes($row_fcat->name)?></b></u></td>
                                    </tr>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" valign="middle" class="body"><a href="index.php?mode=<?=$mode?>&act=create&page=<?=$page?>&cat=<?=$row_fcat->f_cat_id?>&pr=p">New 
                                        Thread</a>&nbsp;</td>
                                    </tr>
                                    <?php
											$sql_for="select * from forums where f_c_id=$row_fcat->f_cat_id and f_st='P' order by f_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
											$res_for=mysql_query($sql_for);
										?>
                                    <?php if(!mysql_num_rows($res_for)) { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body"> 
                                        No Threads Are In This Category!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle"> 
                                        <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_for=mysql_fetch_object($res_for))	{ ?>
                                                <?php
														$sql_forr="select * from forums where f_c_id=$row_fcat->f_cat_id and f_rid=$row_for->f_id and f_st='R' order by f_dt desc";
														$res_forr=mysql_query($sql_forr);
												?>
                                                <tr> 
                                                  <td width="18%"> 
                                                    <?=show_photo($row_for->f_own);?>
                                                    <?=show_online($row_for->f_own);?>
                                                  </td>
                                                  <td width="52%" valign="middle"> 
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_for->f_matt)?>
                                                          </b></td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <?php if(!mysql_num_rows($res_forr)) { ?>
                                                            <tr> 
                                                              <td height="20" colspan="2" align="center" valign="middle" class="body">No 
                                                                Posts For This 
                                                                Thread!</td>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <?php while($row_forr=mysql_fetch_object($res_forr))	{ ?>
                                                            <tr> 
                                                              <td height="25" valign="bottom" class="body">&nbsp;&nbsp; 
                                                                <?=show_online($row_forr->f_own)?>
                                                                Posted reply on 
                                                                <?=format_date($row_forr->f_dt)?>
                                                              </td>
                                                            </tr>
                                                            <tr> 
                                                              <td class="body">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp; 
                                                                <?=stripslashes($row_forr->f_matt)?>
                                                              </td>
                                                            </tr>
                                                            <?php } } ?>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                  <td width="30%" align="right" valign="top" class="body"> 
                                                    Posted On <?=format_date($row_for->f_dt)?>
                                                    &nbsp;&nbsp;<br>
                                                    <?php if($m_id==$row_for->f_own) { ?>
                                                    <a href="index.php?mode=<?=$mode?>&act=remfor&seid=<?=$row_for->f_id?>&page=<?=$page?>">Delete</a>
                                                    <?php } ?>&nbsp;&nbsp;<a href="index.php?mode=<?=$mode?>&act=create&page=<?=$page?>&cat=<?=$row_fcat->f_cat_id?>&qst=<?=$row_for->f_id?>&pr=r">Post Reply</a>&nbsp;&nbsp;
													</td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                                <tr> 
                                                  <td colspan="3" align="left">&nbsp;</td>
                                                </tr>
                                                <?php } ?>
                                              </table>
											  </td>
                                          </tr>
                                        </table><?php } ?></td>
                                    </tr>
                                    <tr> 
                                      <td width="93%" height="20" align="right" valign="middle" class="body"> 
                                        <?php show_page_nos($sql_for,"index.php?mode=$mode",$lines10,$page,$wh); ?>
                                      </td>
                                      <?php } ?>
                                      <td width="7%" align="center" valign="middle" class="body">&nbsp;</td>
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
function remfor()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
  	$sql_messrem="delete from forums where f_id=$seid";
	mysql_query($sql_messrem);
	mysql_query("delete from forums where f_rid=$seid");
	$matt="removal completed";
	$hed=$main_url."/index.php?mode=$mode&err_mess=$matt&page=$page";
	show_screen($hed);
}
function tot_top($id)	{
	$sql="select count(f_id) as coun from forums where f_st='P' and f_c_id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	return $row->coun;
}
function tot_pos($id)	{
	$sql="select count(f_id) as coun from forums where f_c_id=$id";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	return $row->coun;
}
function tot_ros($id)	{
	$sql="select count(f_id) as coun from forums where f_rid=$id and f_st='R'";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	return $row->coun;
}
function lpost_pos($id)	{
	$res_mx=mysql_query("select lpost from f_categories where f_cat_id=$id");
	$row_mx=mysql_fetch_object($res_mx);
	$max_id=$row_mx->lpost;
	if(!empty($max_id))	{
		$sql="select * from forums where f_st='P' and f_id=$max_id";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		if(strlen($row->f_matt)>30)	{
			$titl=substr($row->f_matt,0,30)."...";
		}	else	$titl=$row->f_matt;
		echo "<a href='index.php?mode=forums&act=viewforum&cats=$id&seid=$max_id'>".$titl."</a>";
		echo "<br>".format_date($row->f_dt);
		echo "<br>by ";
		echo show_online($row->f_own);
		echo " -> ";
	}	else	echo "Empty!";
}
function lpost_ros($id)	{
	$res_mx=mysql_query("select max(f_id) as maxs from forums where f_st='R' and f_rid=$id");
	$row_mx=mysql_fetch_object($res_mx);
	$max_id=$row_mx->maxs;
	if(!empty($max_id))	{
		$sql="select * from forums where f_st='R' and f_id=$max_id";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		if(strlen($row->f_matt)>30)	{
			$titl=substr($row->f_matt,0,30)."...";
		}	else	$titl=$row->f_matt;
		echo "<u>".$titl."</u>";
		echo "<br>".format_date($row->f_dt);
		echo "<br>by ";
		echo show_online($row->f_own);
		echo " -> ";
	}	else	echo "Empty!";
}
?>