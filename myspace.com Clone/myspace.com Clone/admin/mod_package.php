<script language="JavaScript1.2" src="admin/jsfunction.js"></script>
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

global $words_lang,$blocks_lang,$frazes_lang,$buttons_lang,$titles_lang,$lang_def,$date_format;
$adsess=form_get("adsess");
$mode=form_get("mode");
$err_mess=form_get("err_mess");
admin_test($adsess);
$seid=form_get("seid");
$T1=form_get("T1");
$T2=form_get("T2");
$T3=form_get("T3");
$T4=form_get("T4");
$T5=form_get("T5");
$T6=form_get("T6");
$T7=form_get("T7");
$T8=form_get("T8");
$T9=form_get("T9");
show_ad_header($adsess);
$sql="select * from member_package where package_id=$seid";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
if(empty($T1))	$T1=stripslashes($row->package_nam);
if(empty($T2))	$T2=$row->package_amt;
if(empty($T3))	$T3=$row->package_grp;
if(empty($T4))	$T4=$row->package_list;
if(empty($T5))	$T5=$row->package_eve;
if(empty($T6))	$T6=$row->package_nphot;
if(empty($T7))	$T7=$row->package_blog;
if(empty($T8))	$T8=$row->package_chat;
if(empty($T9))	$T9=$row->package_forum;
?>
<tr>
    <td width="780" align="center"><br><br><br>
	<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="body">
     <tr> 
        <td height="20" align="left" valign="middle" class="lined title">&nbsp;<strong>Modify Package</strong></td>
     </tr>
     <tr>
    <td class="lined title"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
            <tr>
              <td><form name="form1" method="post" action="admin.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                    <tr> 
                      <td width="3%">&nbsp;</td>
                      <td width="97%">* fields are mandatory!</td>
                    </tr>
                    <?php	if(!empty($err_mess))	{	?>
                    <tr align="center"> 
                      <td colspan="2"><font color="#FF0000"><?=ucwords($err_mess)?></font></td>
                    </tr>
                    <?php	}	?>
                    <tr> 
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                          <tr> 
                            <td height="30">&nbsp;</td>
                            <td width="36%" height="30">Package Name *</td>
                            <td width="60%" height="30"> 
                              <input name="pack_capt" type="text" id="pack_capt" value="<?=$T1?>" size="25"></td>
                          </tr>
                          <tr> 
                            <td height="30">&nbsp;</td>
                            <td height="30">Amount *</td>
                            <td height="30">
<input name="amt" type="text" id="amt" value="<?=$T2?>" size="10" onBlur="this.value=getNumeric(this.value)"> 
                            </td>
                          </tr>
                          <tr> 
                            <td width="4%">&nbsp;</td>
                            <td>Options</td>
                            <td>
							<?php 
								if($T3=="Y")	$gsel="checked";
								else	$gsel="";
								if($T4=="Y")	$lsel="checked";
								else	$lsel="";
								if($T5=="Y")	$esel="checked";
								else	$esel="";
								if($T7=="Y")	$bsel="checked";
								else	$bsel="";
								if($T8=="Y")	$csel="checked";
								else	$csel="";
								if($T9=="Y")	$fsel="checked";
								else	$fsel="";
							?>
							  <input name="grp" type="checkbox" id="grp" value="Y" <?=$gsel?>>
                              Groups<br> <input name="list" type="checkbox" id="list" value="Y" <?=$lsel?>>
                              Listings<br> <input name="eve" type="checkbox" id="eve" value="Y" <?=$esel?>>
                              Events<br> <input name="blog" type="checkbox" id="blog" value="Y" <?=$bsel?>>
                              Blog<br> <input name="chat" type="checkbox" id="chat" value="Y" <?=$csel?>>
                              Chat<br> <input name="forum" type="checkbox" id="forum" value="Y" <?=$fsel?>>
                              Forum<br>
                              <input name="act_me" type="hidden" id="act_me" value="Mod Pack"> 
                              <input name="second" type="hidden" id="second" value="set"> 
							  <input name="seid" type="hidden" id="seid" value="<?=$seid?>">
							  <input name="mode" type="hidden" id="mode" value="manage_pack">
							  <input name="adsess" type="hidden" id="adsess" value="<?=$adsess?>">
                            </td>
                          </tr>
                          <tr> 
                            <td height="30">&nbsp;</td>
                            <td height="30">Photos</td>
                            <td height="30"> 
                              <input name="nop" type="text" id="nop" value="<?=$T6?>" size="10" onBlur="this.value=Numeric(this.value)">
                            </td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr> 
                            <td>&nbsp;</td>
                            <td colspan="2" align="center"><input type="submit" name="Submit" value="Modify package">
                              <input type="reset" name="Submit" value="Reset Entry"> 
                            </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                </form></td>
            </tr>
          </table></td>
  </tr>
</table><br>
	</td>
</tr>
<?php
 show_footer();
?>