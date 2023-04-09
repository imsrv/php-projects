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
if($act=='')	 events();
elseif($act=='create')	create_event();
elseif($act=='create_done')	create_done();
elseif($act=='viewevent')	viewevent();
elseif($act=='edevent')	mode_event();
elseif($act=='modev_done')	mode_done();
elseif($act=='more')	more();
elseif($act=='remeven')	remeven();
elseif($act=='publish')	publish();
function 	publish()	{
	$mode=form_get("mode");
	$seid=form_get("seid");
	mysql_query("update event_list set even_active='Y' where even_id=$seid");
	error_screen(33);
}
function events()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$dt=form_get("dt");
	$dis=array();
	$page=getpages();
	$l_count=($page-1)*$lines10+$lcoun;
	if(!empty($cat))	$sql_eve="select * from event_list where even_cat=$cat and even_active='Y' order by even_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
	elseif(!empty($dt))	$sql_eve="select * from event_list where even_stat='$dt' and even_active='Y' order by even_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
	else	$sql_eve="select * from event_list where even_active='Y' order by even_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
	$res_eve=mysql_query($sql_eve);
	if(!empty($cat))	{
  		$sql_query="select event_nam from event_cat where event_id=$cat";
		$cats=sql_execute($sql_query,'get');
		$sho="&nbsp;-->&nbsp;".$cats->event_nam;
	}
	show_header();
	?>
	<tr>
  <td valign="top" width="780">
    <table width="780" border="0" align="center" cellpadding="0" cellspacing="0" class="body">
      <tr> 
        <td width="173" valign="top" class="title"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="title">Browse Categories</td>
            </tr>
            <tr>
              <td height="74" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td class="body"> <br>
                      <?php
		//Coded by Jose
		$sql_catlist="select * from event_cat";
		$res_catlist=mysql_query($sql_catlist);
		while($row_catlist=mysql_fetch_object($res_catlist))	{ 
				  		$sql_eno="select count(even_id) as nos from event_list where even_cat=$row_catlist->event_id";
						$res_eno=mysql_query($sql_eno);
						if(mysql_num_rows($res_eno)) { 
	                        $row_eno=mysql_fetch_object($res_eno);
							$cat_no=$row_eno->nos;
							?> <a href="index.php?mode=<?=$mode?>&cat=<?=$row_catlist->event_id?>&page=<?=$page?>"><?=$row_catlist->event_nam?></a> <?php echo " (".$cat_no.")<br>";
						}
		}
		?>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
        <td width="607"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="title">&nbsp;Events in Your Network 
                <?=$sho?>
              </td>
            </tr>
            <tr>
              <td align="right" class="body">
			  <form action='index.php' method=post name='searchEvent'>
			  <table width="100%" border="0" cellspacing="0" cellpadding="4" class="lined">
                  <tr> 
                      <td align="center" valign="middle" class="body">
					  <input type=hidden name="act" value="events"><input type=hidden name="mode" value="search">
                        Keywords 
                        <input name='keywords' type=text size="5">
                        Category 
                        <select name="RootCategory"><? events_cats(''); ?></select> Degrees <select name="degree">
				<option value="any">anyone
				<option value="4">within 4&deg of me
				<option value="3">within 3&deg of me
				<option value="2">within 2&deg of me
				<option value="1">a friend
				</select><br>Distance 
                        <select name="distance">
                          <option value="any">any distance 
                          <option value="5">5 miles 
                          <option value="10">10 miles 
                          <option value="25">25 miles 
                          <option value="100">100 miles 
                        </select>
                        From 
                        <input type=text size=7 name=zip value='<?
                $sql_query="select zip from members where mem_id='$m_id'";
                $mem=sql_execute($sql_query,'get');
                echo $mem->zip;
                ?>'>
                      </td>
                  </tr>
                  <tr>
                    <td align="center" valign="middle" class="body">
<input name="submit" type='submit' value='Search'>
                    </td>
                  </tr>
                </table></form></td>
            </tr>
            <tr> 
              <td align="right" class="body"><a href="index.php?mode=<?=$mode?>&cat=<?=$cat?>&act=create&page=<?=$page?>">New 
                Event</a>&nbsp;</td>
            </tr>
            <?php if(!mysql_num_rows($res_eve))	{	?>
            <tr> 
              <td height="20" align="center" class="form-comment">No Events Are 
                Posted!</td>
            </tr>
            <?php } else { ?>
            <tr> 
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                  <tr valign="middle"> 
                    <td height="20" class="body">&nbsp;Event</td>
                    <td height="20" class="body">&nbsp;Start Date</td>
                    <td height="20" class="body">&nbsp;End Date</td>
                    <td height="20" class="body">&nbsp;Location</td>
                    <td height="20" class="body">&nbsp;Views</td>
                  </tr>
                  <tr valign="top"> 
                    <td height="20" colspan="5" class="body"> <hr width="100%" size="1" color="#C0C0C0"></td>
                  </tr>
                  <?php while($row_eve=mysql_fetch_object($res_eve))	{ ?>
                  <?php
				  		$sql_cf="select event_nam from event_cat where event_id=$row_eve->even_cat";
						$res_cf=mysql_query($sql_cf);
						$st=explode("-",$row_eve->even_stat);
						$stat=$st[1]."-".$st[2]."-".$st[0];
						$en=explode("-",$row_eve->even_end);
						$end=$en[1]."-".$en[2]."-".$en[0];
						if(strlen($row_eve->even_title)>30)	{
							$titl=substr($row_eve->even_title,0,30)."...";
						}	else	$titl=$row_eve->even_title;
				  ?>
                  <tr> 
                    <td class="body">&nbsp;<font size="2"> <a href="index.php?mode=<?=$mode?>&act=viewevent&seid=<?=$row_eve->even_id?>&page=<?=$page?>"> 
                      <?=stripslashes($titl)?>
                      </a></font> 
                      <?php if(mysql_num_rows($res_cf)) { ?>
                      <br> 
                      <?php $row_cf=mysql_fetch_object($res_cf); ?>
                      <font size="1">&nbsp; <a href="index.php?mode=<?=$mode?>&cat=<?=$row_eve->even_cat?>&page=<?=$page?>"> 
                      <?=stripslashes($row_cf->event_nam)?>
                      </a> </font> 
                      <?php } ?>
                    </td>
                    <td class="body">&nbsp; 
                      <?=$stat?>
                    </td>
                    <td class="body">&nbsp; 
                      <?=$end?>
                    </td>
                    <td class="body">&nbsp; 
                      <?=stripslashes($row_eve->even_loc)?>
                    </td>
                    <td class="body">&nbsp; 
                      <?=$row_eve->even_hits?>
                    </td>
                  </tr>
                  <?php } ?>
                  <tr> 
                    <td class="body">&nbsp;</td>
                    <td align="right" class="body">&nbsp;</td>
                    <td align="right" class="body">&nbsp;</td>
                    <td align="right" class="body">&nbsp;</td>
                    <td align="right" class="body"> 
                      <?php show_page_nos($sql_eve,"index.php?mode=$mode&cat=$cat&dt=$dt",$lines10,$page,$wh); ?>
                      &nbsp;</td>
                  </tr>
                </table></td>
            </tr>
            <?php } ?>
          </table></td>
      </tr>
    </table>
    <br>
    <br>
	  </td>
	</tr>
	<?php
	show_footer();
}
function create_event()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	$cat=form_get("cat");
	$sql_trcat="select * from event_cat order by event_nam";
	$res_trcat=mysql_query($sql_trcat);
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
                    <td align="right" class="body"><a href="index.php?mode=events&page=<?=$page?>">Back</a>&nbsp;&nbsp;</td>
                  </tr>
                  <tr> 
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title">&nbsp;&nbsp;New Event</td>
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
                                          <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Title</td>
                                              <td height="30"> <input name="tr_nam" type="text" id="tr_nam" size="30"></td>
                                            </tr>
                                            <?php if(empty($cat)) { ?>
                                            <tr> 
                                              <td class="body" height="30">&nbsp;&nbsp;Category</td>
                                              <td height="30"> <select name="cat" id="cat">
                                                  <?php if(mysql_num_rows($res_trcat)) {
													while($row_trcat=mysql_fetch_object($res_trcat)) { ?>
                                                  <option value="<?=$row_trcat->event_id?>"> 
                                                  <?=stripslashes($row_trcat->event_nam)?>
                                                  </option>
                                                  <?php	}	}	?>
                                                </select></td>
                                            </tr>
                                            <?php } ?>
                                            <tr> 
                                              <td width="44%" height="20" class="body">&nbsp;&nbsp;Description</td>
                                              <td width="56%" height="20"> <textarea name="blogmatt" cols="30" rows="3" id="blogmatt"></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>"> 
                                                <?php if(!empty($cat)) { ?>
                                                <input name="cat" type="hidden" id="cat" value="<?=$cat?>"> 
                                                <?php } ?>
                                                <input name="act" type="hidden" id="act" value="create_done"> 
                                                <input name="page" type="hidden" id="page" value="<?=$page?>"> 
                                              </td>
                                            </tr>
                                            <script language="JavaScript1.2">
function del()	{
	gfPop.fStartPop(document.form1.stat,Date);
}
function me()	{
	gfPop.fStartPop(document.form1.end,Date);
}
</script>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Start 
                                                Date</td>
                                              <td height="30"> <input name="stat" value="" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:del();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="33" class="body">&nbsp;&nbsp;End 
                                                Date</td>
                                              <td height="33"> <input name="end" value="" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:me();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Location</td>
                                              <td height="30"><input name="loc" type="text" id="loc" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Location 
                                                Address </td>
                                              <td height="30"> <textarea name="loc1" cols="30" rows="3" id="loc1"></textarea></td>
                                            </tr>
                                            <tr>
                                              <td height="30" class="body">&nbsp;&nbsp;Zip</td>
                                              <td height="30"><input name="zip" type="text" id="zip" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Phone 
                                                no.</td>
                                              <td height="30"> <input name="phon" type="text" id="phon" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;URL</td>
                                              <td height="30"> <input name="url" type="text" id="url" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Image</td>
                                              <td height="30"> <input name="photo" type="file" id="photo" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" colspan="2" align="center">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Publish Event"></td>
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
<iframe width=168 height=175 name="gToday:normal:styles/agenda.js" id="gToday:normal:styles/agenda.js" src="styles/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<?php
	show_footer();
}
function create_done()	{
	global $main_url,$_FILES,$base_path,$system_mail;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$page=form_get("page");
	$act=form_get("act");
	$sql_query="select * from members where mem_id='$m_id'";
	$mem=sql_execute($sql_query,'get');
	$blogmatt=form_get("blogmatt");
	$tr_nam=form_get("tr_nam");
	$stat=form_get("stat");
	$end=form_get("end");
	$phon=form_get("phon");
	$url=form_get("url");
	$loc=form_get("loc");
	$loc1=form_get("loc1");
	$zip=form_get("zip");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($tr_nam) or empty($stat) or empty($end) or empty($blogmatt) or empty($loc) or empty($zip))	{
		$matt="please enter the details.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&cat=$cat&page=$page&err_mess=$matt";
		$er_id=31;
	}	else	{
		$st=explode("/",$stat);
		$stat=$st[2]."-".$st[0]."-".$st[1];
		$en=explode("/",$end);
		$end=$en[2]."-".$en[0]."-".$en[1];
		$sql_ins="insert into event_list (even_own,even_cat,even_title,even_desc,even_stat,even_end,even_phon,even_url,even_loc,even_loc1,even_zip,even_dt) values (";
		$sql_ins.="$m_id,$cat,'".addslashes($tr_nam)."','".addslashes($blogmatt)."','".$stat."','".$end."','".addslashes($phon)."','".$url."','".addslashes($loc)."','".addslashes($loc1)."','".$zip."',now())";
		mysql_query($sql_ins);
		$prim=mysql_insert_id();
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,$base_path."/events/".$newname.$p_type);
			$photo="events/".$newname.$p_type;
			$sql_img="update event_list set even_img='".$photo."' where even_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="this entry added to our list.";
		$hed=$main_url."/index.php?mode=$mode&err_mess=$matt";
		$er_id=32;
		require('event_mail.php');
		$data=array();
		$data[]="Activate your event";
		$data[]=$matt;
		$sql_query="select * from members where mem_id='$m_id'";
		$mem=sql_execute($sql_query,'get');
		$data[]=$system_mail;
		messages(cookie_get("mem_em"),7,$data);
	}
error_screen($er_id);
//	show_screen($hed);
}
function mode_done()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$cat=form_get("cat");
	$page=form_get("page");
	$act=form_get("act");
	$seid=form_get("seid");
	$blogmatt=form_get("blogmatt");
	$tr_nam=form_get("tr_nam");
	$stat=form_get("stat");
	$end=form_get("end");
	$phon=form_get("phon");
	$url=form_get("url");
	$loc=form_get("loc");
	$loc1=form_get("loc1");
	$zip=form_get("zip");
	$tmpfname=$_FILES['photo']['tmp_name'];
    $ftype=$_FILES['photo']['type'];
    $fsize=$_FILES['photo']['size'];
	if(empty($tr_nam) or empty($stat) or empty($end) or empty($blogmatt) or empty($loc) or empty($zip))	{
		$matt="please enter the details.";
		$hed=$main_url."/index.php?mode=$mode&act=$act&cat=$cat&page=$page&err_mess=$matt";
	}	else	{
		$st=explode("/",$stat);
		$stat=$st[2]."-".$st[0]."-".$st[1];
		$en=explode("/",$end);
		$end=$en[2]."-".$en[0]."-".$en[1];
		$sql_ins="update event_list set even_cat=$cat,even_title='".addslashes($tr_nam)."',even_desc='".addslashes($blogmatt)."',even_stat='".$stat."'";
		$sql_ins.=",even_end='".$end."',even_phon='".addslashes($phon)."',even_url='".$url."',even_loc='".addslashes($loc)."',even_loc1='".addslashes($loc1)."',even_zip='".$zip."' where even_id=$seid";
		mysql_query($sql_ins);
		$prim=$seid;
		if($tmpfname!='')	{
			if($ftype=='image/bmp')	$p_type=".bmp";
			elseif(($ftype=='image/jpeg')||($ftype='image/pjpeg'))	$p_type=".jpeg";
			elseif($ftype='image/gif')	$p_type=".gif";
			else	error_screen(9);
			$rand=rand(0,10000);
			$newname=md5($m_id.time().$rand);
			move_uploaded_file($tmpfname,$base_path."/events/".$newname.$p_type);
			$photo="events/".$newname.$p_type;
			$sql_img="update event_list set even_img='".$photo."' where even_id=".$prim;
			mysql_query($sql_img);
		}
		$matt="this entry updated to our list.";
		$hed=$main_url."/index.php?mode=$mode&act=edevent&seid=$seid&page=$page&err_mess=$matt";
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
	$sql_fcat="select * from event_cat where event_id=$cat";
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
                    <td class="title">&nbsp;&nbsp;Events</td>
                  </tr>
                  <tr> 
                    <td class="title">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
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
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">List 
                                        Is Empty!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <?php while($row_fcat=mysql_fetch_object($res_fcat))	{	?>
                                    <?php
											$sql_for="select * from event_list where even_cat=$row_fcat->event_id order by even_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
											$res_for=mysql_query($sql_for);
									?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="body"> 
                                        &nbsp;&nbsp;<u><b><?=stripslashes($row_fcat->event_nam)?></b></u></td>
                                    </tr>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" valign="middle" class="body"><a href="index.php?mode=<?=$mode?>&act=create&page=<?=$page?>&cat=<?=$row_fcat->event_id?>">New 
                                        Event</a>&nbsp;</td>
                                    </tr>
                                    <?php if(!mysql_num_rows($res_for)) { ?>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">No 
                                        Events Are In This Category!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr align="right"> 
                                      <td height="20" colspan="2" align="left" valign="middle"><table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_for=mysql_fetch_object($res_for))	{ ?>
                                                <tr> 
                                                  <td width="18%" valign="top" class="body"> 
                                                    <?=show_photo($row_for->even_own);?>
                                                    <br> 
                                                    <?=show_online($row_for->even_own);?>
                                                  </td>
                                                  <td width="56%" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_for->even_title)?>
                                                          </b></td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body">&nbsp;-&nbsp; 
                                                          Start date 
                                                          <?=$row_for->even_stat?>
                                                          / End date 
                                                          <?=$row_for->even_end?>
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td class="body">&nbsp;&nbsp;&nbsp;-&nbsp; 
                                                          <?=stripslashes($row_for->even_desc)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                  <td width="26%" align="right" valign="top" class="body"> 
                                                    Posted On 
                                                    <?=format_date($row_for->even_dt)?>
                                                    &nbsp;&nbsp;<br>
													<a href="index.php?mode=<?=$mode?>&act=viewevent&seid=<?=$row_for->even_id?>&page=<?=$page?>">View</a>
                                                    <?php if($m_id==$row_for->even_own) { ?>
                                                    &nbsp;<a href="index.php?mode=<?=$mode?>&act=edevent&seid=<?=$row_for->even_id?>&page=<?=$page?>">Edit</a>&nbsp;&nbsp;<a href="index.php?mode=<?=$mode?>&act=remeven&seid=<?=$row_for->even_id?>&page=<?=$page?>">Delete</a> 
                                                    <?php } ?>
													</td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                              </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php } ?>
                                    <?php }	?>
                                    <tr align="right">
                                      <td height="20" colspan="2" align="right" valign="middle"> 
                                        <?php show_page_nos($sql_for,"index.php?mode=$mode",$lines10,$page,$wh); ?>&nbsp;
                                      </td>
                                    </tr>
                                    <?php } ?>
                                  </table></td>
                              </tr>
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
function remeven()	{
	global $main_url,$_FILES,$base_path;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
	$page=form_get("page");
	mysql_query("delete from event_list where even_id=$seid");
	$matt="removal completed";
	$hed=$main_url."/index.php?mode=events&err_mess=$matt";
	show_screen($hed);
}
function viewevent()	{
	global $lines10,$lcoun;
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$seid=form_get("seid");
  	$sql="select * from event_list where even_id=$seid";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	$ev_hits=$row->even_hits+1;
	mysql_query("update event_list set even_hits=$ev_hits where even_id=$seid");
	$sql_cat="select event_nam from event_cat where event_id=$row->even_cat";
	$res_cat=mysql_query($sql_cat);
	$row_cat=mysql_fetch_object($res_cat);
	$st=explode("-",$row->even_stat);
	$stat=$st[1]."-".$st[2]."-".$st[0];
	$en=explode("-",$row->even_end);
	$end=$en[1]."-".$en[2]."-".$en[0];
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
                    <td class="title"><strong>&nbsp;&nbsp;<a href="index.php?mode=events">Events</a> &gt;&gt; 
					<a href="index.php?mode=events&cat=<?=$row->even_cat?>"><?=stripslashes($row_cat->event_nam)?></a> &gt;&gt; View Event</strong></td>
                  </tr>
                  <tr> 
                    <td class="title">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="body"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="86%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                              <tr>
                                <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                                    <?php	if(!empty($err_mess))	{	?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="form-comment"> 
                                        <?=ucwords($err_mess)?>
                                      </td>
                                    </tr>
                                    <?php	}	?>
                                    <?php if(!mysql_num_rows($res)) { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">No Such Entry Found In Our Event List!</td>
                                    </tr>
                                    <?php } else {
											if(empty($row->even_img))	$imgdis="<img src='./blog/noimage.jpg' width='100' height='100' border='0'>";
											else	$imgdis="<img src='./".$row->even_img."' width='100' height='100' border='0'>";
									?>
                                    <tr align="right"> 
                                      <td colspan="2" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr> 
                                            <td width="5%" align="center" valign="middle">&nbsp;</td>
                                            <td width="87%" colspan="2">&nbsp;</td>
                                            <td width="8%" align="right" valign="top">&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td>&nbsp;</td>
                                            <td class="body"><font size="5"><strong>
                                              <?=stripslashes($row->even_title)?>
                                              </strong></font><br> 
                                              <?=$ev_hits?>
                                              views since posting on 
                                              <?=format_date($row->even_dt)?>
                                              .<br><br>
                                              <table cellpadding="0" cellspacing="0" border="0" class="body">
                                                <tr valign="top"> 
                                                  <th width="92" align="left"><strong>Start 
                                                    Date :<br>
                                                    End Date :</strong></th>
                                                  <td width="250"> 
                                                    <?=$stat?>
                                                    <br> 
                                                    <?=$end?>
                                                    <a href="index.php?mode=events&dt=<?=$row->even_stat?>">more 
                                                    on this date</a> </td>
                                                </tr>
                                                <tr valign="top"> 
                                                  <th align="left">&nbsp;</th>
                                                  <td>&nbsp;</td>
                                                </tr>
                                                <tr valign="top"> 
                                                  <th align="left">Location:</th>
                                                  <td> 
                                                    <?=stripslashes($row->even_loc)?>
                                                    <br> 
                                                    <?=stripslashes($row->even_loc11)?>
													<?php if(!empty($row->even_phon)) { ?>
													<br>
													Ph: <?=stripslashes($row->even_phon)?>
													<?php } ?>
													<?php if(!empty($row->even_url)) { ?>
													<br>
													Url: <?=stripslashes($row->even_url)?>
													<?php } ?>
                                                  </td>
                                                </tr>
                                                <tr valign="top">
                                                  <th align="left">&nbsp;</th>
                                                  <td>&nbsp;</td>
                                                </tr>
                                              </table>
                                              <br>
                                              <?=stripslashes($row->even_desc)?>
                                              <br><br>
                                              <table class="lined" cellpadding="0" cellspacing="0">
                                                <tr valign="top"> 
                                                  <td>
                                                    <?=show_photo($row->even_own);?><br>
                                                    <?=show_online($row->even_own);?>
                                                  </td>
                                                </tr>
                                              </table></td>
                                            <td align="center" valign="top" class="body">
                                              <?=$imgdis?>
											  <?php if($m_id==$row->even_own)	{	?>
                                              <br>
                                              <a href="index.php?mode=events&act=edevent&seid=<?=$seid?>">Edit</a> / <a href="index.php?mode=events&act=remeven&seid=<?=$seid?>">Delete</a>&nbsp;
											  <?php } ?>
										  </td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr> 
                                            <td align="center" valign="middle">&nbsp;</td>
                                            <td colspan="2">&nbsp;</td>
                                            <td align="right" valign="top">&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <?php }	?>
                                  </table></td>
                              </tr>
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
function mode_event()	{
	$m_id=cookie_get("mem_id");
	$m_pass=cookie_get("mem_pass");
	login_test($m_id,$m_pass);
	$mode=form_get("mode");
	$page=form_get("page");
	$cat=form_get("cat");
	$seid=form_get("seid");
  	$sql="select * from event_list where even_id=$seid";
	$res=mysql_query($sql);
	$row=mysql_fetch_object($res);
	$sql_cat="select event_nam from event_cat where event_id=$row->even_cat";
	$res_cat=mysql_query($sql_cat);
	$row_cat=mysql_fetch_object($res_cat);
	$sql_trcat="select * from event_cat order by event_nam";
	$res_trcat=mysql_query($sql_trcat);
	$st=explode("-",$row->even_stat);
	$stat=$st[1]."/".$st[2]."/".$st[0];
	$en=explode("-",$row->even_end);
	$end=$en[1]."/".$en[2]."/".$en[0];
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
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr> 
                          <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="lined">
                              <tr> 
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr> 
                                      <td height="20" align="left" valign="middle" class="lined title"><strong>&nbsp;&nbsp;<a href="index.php?mode=events">Events</a> 
                                        &gt;&gt; <a href="index.php?mode=events&cat=<?=$row->even_cat?>"><?=stripslashes($row_cat->event_nam)?></a> &gt;&gt; Modify Event</strong></td>
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
                                          <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr> 
                                              <td class="body">&nbsp;</td>
                                              <td>&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Title</td>
                                              <td height="30"> <input name="tr_nam" type="text" id="tr_nam" value="<?=stripslashes($row->even_title)?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td class="body" height="30">&nbsp;&nbsp;Category</td>
                                              <td height="30"> <select name="cat" id="cat">
                                                  <?php if(mysql_num_rows($res_trcat)) {
													while($row_trcat=mysql_fetch_object($res_trcat)) { ?>
                                                  <?php if($row->even_cat==$row_trcat->event_id)	$selme="Selected";
													else	$selme="";	?>
                                                  <option value="<?=$row_trcat->event_id?>" <?=$selme?>> 
                                                  <?=stripslashes($row_trcat->event_nam)?>
                                                  </option>
                                                  <?php	}	}	?>
                                                </select></td>
                                            </tr>
                                            <tr> 
                                              <td width="44%" class="body">&nbsp;&nbsp;Description</td>
                                              <td width="56%"><textarea name="blogmatt" cols="35" rows="3" id="blogmatt"><?=stripslashes($row->even_desc)?></textarea> 
                                                <input name="second" type="hidden" id="second" value="set"> 
                                                <input name="mode" type="hidden" id="mode" value="<?=$mode?>"> 
                                                <input name="seid" type="hidden" id="seid" value="<?=$seid?>"> 
                                                <input name="act" type="hidden" id="act" value="modev_done"> 
                                                <input name="page" type="hidden" id="page" value="<?=$page?>"> 
                                              </td>
                                            </tr>
                                            <script language="JavaScript1.2">
function del()	{
	gfPop.fStartPop(document.form1.stat,Date);
}
function me()	{
	gfPop.fStartPop(document.form1.end,Date);
}
</script>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Start 
                                                Date</td>
                                              <td height="30"> <input name="stat" value="<?=$stat?>" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:del();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;End 
                                                Date</td>
                                              <td height="30"> <input name="end" value="<?=$end?>" size="20" onfocus="this.blur()" readonly> 
                                                <a href="javascript:void(0)" onclick="javascript:me();return false;" HIDEFOCUS><img name="popcal" align="absbottom" src="images/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Location</td>
                                              <td height="30"><input name="loc" type="text" id="loc" value="<?=$row->even_loc?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Location 
                                                Address </td>
                                              <td height="30"> <textarea name="loc1" cols="30" rows="3" id="loc1"><?=$row->even_loc1?></textarea></td>
                                            </tr>
                                            <tr>
                                              <td height="30" class="body">&nbsp;&nbsp;Zip</td>
                                              <td height="30"><input name="zip" type="text" id="zip" value="<?=$row->even_zip?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Phone 
                                                no.</td>
                                              <td height="30"> <input name="phon" type="text" id="phon" value="<?=$row->even_phon?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;URL</td>
                                              <td height="30"> <input name="url" type="text" id="url" value="<?=$row->even_url?>" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td height="30" class="body">&nbsp;&nbsp;Image</td>
                                              <td height="30"> <input name="photo" type="file" id="photo" size="30"></td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td colspan="2" align="center"><input type="submit" name="Submit" value="Update Event"></td>
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
<iframe width=168 height=175 name="gToday:normal:styles/agenda.js" id="gToday:normal:styles/agenda.js" src="styles/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>
<?php
	show_footer();
}
?>