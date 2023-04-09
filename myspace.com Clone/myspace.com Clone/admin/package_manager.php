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
$err_mess=form_get("err_mess");
admin_test($adsess);
show_ad_header($adsess);
if(empty($_GET['page'])) $page=1;
else $page=$_GET['page'];
$lines50=50;
$l_count=($page-1)*$lines50+$lcoun;
$sql_testi="select * from member_package order by package_amt LIMIT ".($page-1)*$lines50.",".$lines50;
$res_testi=mysql_query($sql_testi);
?>
<tr>
    <td width="780" align="center"><br><br>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="body">
     <tr align="center"> 
        <td align="left" height="20" class="lined title"><strong>&nbsp;Package Manager</strong></td>
     </tr>
      <tr>
    <td class="lined padded-6"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
	            <tr align="center">
              <td align="right"><a href="admin.php?mode=package_add&adsess=<?=$adsess?>">New Package</a>&nbsp;</td>
            </tr>
            <?php	if(!empty($err_mess))	{	?>
            <tr align="center"> 
              <td> 
                <font color="#FF0000"><?=ucwords($err_mess)?></font>
              </td>
            </tr>
            <?php	}	?>
            <tr align="center"> 
              <td>&nbsp;</td>
            </tr>
            <?php	if(!mysql_num_rows($res_testi))	{	?>
            <tr align="center"> 
              <td height="20" valign="middle"><font color="#FF0000">No Packages 
                Are Available!!</font></td>
            </tr>
            <tr align="center"> 
              <td>&nbsp;</td>
            </tr>
            <?php	}	else	{	?>
            <tr> 
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="body">
                  <tr> 
                    <td width="8%">&nbsp;<strong><?=$words_lang[406]?></strong></td>
                    <td width="32%"><strong><?=$words_lang[404]?></strong></td>
                    <td width="18%"><strong><?=$words_lang[405]?></strong></td>
                    <td class="text">&nbsp;</td>
                  </tr>
                  <?php
	$co=1;
	while($row_testi=mysql_fetch_object($res_testi))	{
?>
                  <tr> 
                    <td>&nbsp; 
                      <?=$co?>
                    </td>
                    <td> 
                      <?=stripslashes($row_testi->package_nam)?>
                    </td>
                    <td> 
                      <?=$row_testi->package_amt?>
                    </td>
                    <td width="19%" align="right"><a href="admin.php?mode=mod_package&adsess=<?=$adsess?>&seid=<?=$row_testi->package_id?>&page=<?=$page?>">Edit</a> 
                      / <a href="admin.php?mode=manage_pack&act_me=rem&adsess=<?=$adsess?>&seid=<?=$row_testi->package_id?>&page=<?=$page?>">Delete</a>&nbsp;&nbsp;</td>
                  </tr>
                  <?php
		$co++;
	}	?>
                  <tr> 
                    <td colspan="5" class="text">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
            <tr align="right" valign="middle"> 
              <td height="20" colspan="4" class="text"> 
                <?php show_page_nos($sql_testi,"index.php?act=$act",$lines50,$page,$wh); ?>
                &nbsp;&nbsp;</td>
            </tr>
            <?php	}	?>
          </table></td>
  </tr>
</table><br>
	</td>
</tr>
<script language="JavaScript1.2">
var windowW=500 // wide
var windowH=300 // high
var windowX=20 // from left
var windowY=170 // from top
var title="Testimonialdetails"
var autoclose = false
s = "width="+windowW+",height="+windowH;
var beIE = document.all?true:false
function view_me(id){
var urlPop="view_testidet.php?seid="+id;
  if (beIE){
    NFW = window.open("","popFrameless","fullscreen,"+s)     
    NFW.blur()
    window.focus()       
    NFW.resizeTo(windowW,windowH)
    NFW.moveTo(windowX,windowY)
    var frameString=""+
"<html>"+
"<head>"+
"<title>"+title+"</title>"+
"</head>"+
"<frameset rows='*,0' framespacing=0 border=0 frameborder=0>"+
"<frame name='top' src='"+urlPop+"' scrolling=auto>"+
"<frame name='bottom' src='about:blank' scrolling='no'>"+
"</frameset>"+
"</html>"
    NFW.document.open();
    NFW.document.write(frameString)
    NFW.document.close()
  } else {
    NFW=window.open(urlPop,"popFrameless","scrollbars,"+s)
    NFW.blur()
    window.focus() 
    NFW.resizeTo(windowW,windowH)
    NFW.moveTo(windowX,windowY)
  }   
  NFW.focus()   
  if (autoclose){
    window.onunload = function(){NFW.close()}
  }
}
</script>
<?php
 show_footer();
/*	function show_page_nos($sql,$url,$lines,$page,$sor){
	    $tmp	=explode("LIMIT",$sql);
	    if(count($tmp)<1) $tmp	=explode("limit",$sql);
	  	$pgsql	=$tmp[0];
	    include 'show_pagenos.php';
	} */
?>