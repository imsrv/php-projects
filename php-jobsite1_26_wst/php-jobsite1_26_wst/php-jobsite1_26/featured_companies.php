<?php include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);
function bx_js_prepare($l_str){
    $l_str = eregi_replace("\015\012|\015|\012", ' ', $l_str);
    $l_str = eregi_replace("'","&#039;",$l_str);
    $l_str = eregi_replace("\\\\","\\\\",$l_str);
    return $l_str;
}
header("Content-type: text/html");?>
if (!pjs_titleBGColor) {
    var pjs_titleBGColor='<?php echo TABLE_BGCOLOR;?>';
}
if (!pjs_title) {
    var pjs_title='<b><?php echo bx_js_prepare(TEXT_FEATURED_COMPANIES);?>  - <a href="<?php echo bx_js_prepare(HTTP_SERVER);?>"><?php echo bx_js_prepare(SITE_NAME);?></a></b>';
}
if (!pjs_bigFont) {
    var pjs_bigFont='<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">';
}
if(!pjs_tableBGColor){
    var pjs_tableBGColor='<?php echo TABLE_FEATURED_BGCOLOR;?>';
}
if (!pjs_linkStyle) {
    var pjs_linkStyle='style="color: #0000FF; font-size: 12px; font-weight: normal;"';
}
document.write('<table width="100%" border="0" cellspacing="0" cellpadding="0">');
document.write('<TR>');
document.write('      <TD colspan="2"  width="100%" align="center" bgcolor="'+pjs_titleBGColor+'">'+pjs_bigFont+pjs_title+'</font></TD>');
document.write('</TR>');
document.write('</table>');
document.write('<table width="100%" border="0" cellspacing="1" cellpadding="2">');
<?php
  $array_comps=array();
if (FEATURED_COMPANY_ORDER==1 || FEATURED_COMPANY_ORDER==2) {
    $query = "SELECT company, compid, signupdate, logo FROM ".$bx_table_prefix."_companies WHERE TO_DAYS(".$bx_table_prefix."_companies.expire)>=TO_DAYS(NOW()) and featured='1'";
    srand((double)microtime()*1000000); // seed the random number generator
    if (FEATURED_COMPANY_ORDER==2) {
            $array_date=array();
            $array_ordcomps=array();
    }
}
else {
    $query = "SELECT company, compid, signupdate, logo FROM ".$bx_table_prefix."_companies WHERE TO_DAYS(".$bx_table_prefix."_companies.expire)>=TO_DAYS(NOW()) and featured='1' order by ".$bx_table_prefix."_companies.signupdate desc, ".$bx_table_prefix."_companies.compid desc";
}
$empty=0;
$result_featured_companies=bx_db_query($query);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$count_companies=bx_db_num_rows($result_featured_companies);
   if ($count_companies!=0) {
      if ($count_companies>=FEATURED_COMPANIES_NUMBER) {
          $number_random=FEATURED_COMPANIES_NUMBER;
      }
      else {
        $number_random=$count_companies;
      }
      for($i=0;$i<$number_random;$i++) {
               $rand_row = @rand(0, ($count_companies - 1));
               $exist=random_once($array_comps,$rand_row);
               if($exist!=1) {
                  $array_comps[$i]=$rand_row;
               }
               else {
                   $i--;
               }
      } 
      if (FEATURED_COMPANY_ORDER==1) {
                  
      }
      elseif (FEATURED_COMPANY_ORDER==2) {
           $i=0;
           while($i<sizeof($array_comps))            
                {
                  $company=bx_db_data_seek($result_featured_companies, $array_comps[$i]);
                  $result_companies=bx_db_fetch_array($result_featured_companies);
                  $array_date[$array_comps[$i]] =$result_companies['signupdate']; 
                  $i++;
                } 
                arsort($array_date);
                while(list($key)=each($array_date)) {
                        $array_ordcomps[]=$key;    
                }
                $array_comps=$array_ordcomps;
      }
      else {
              for($i=0;$i<$number_random;$i++) {
                  $array_comps[$i]=$i;
              }
      }
    }  
    else {
           $empty=1;
    }
    $i=0;
    if($empty!=1) {  
       while($i<sizeof($array_comps)) {
         $record=bx_db_data_seek($result_featured_companies, $array_comps[$i]);
         $result_companies=bx_db_fetch_array($result_featured_companies);
         ?>
document.write('     <TR>');
document.write('      <TD width="40%" align="center" bgcolor="'+pjs_tableBGColor+'">');
document.write('       <?php $image_location = DIR_LOGO. $result_companies['logo'];
       if ((!empty($result_companies['logo'])) && (file_exists($image_location))) {
                  echo "<a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$result_companies['compid'], "auth_sess", $bx_session)."\" target=\"_blank\" '+pjs_linkStyle+'><img src=\"".HTTP_LOGO.$result_companies['logo']."\" border=0 align=\"absmiddle\"></a>";
       }//end if (file_exists($image_location))
       else {
                 echo "'+pjs_bigFont+'".bx_js_prepare(TEXT_LOGO_NOT_AVAILABLE)."</font>";
       }//end else if (file_exists($image_location))
       ?></font>');
document.write('       </TD>');
document.write('      <TD valign="middle" width="60%" align="center" bgcolor="'+pjs_tableBGColor+'">');
document.write('       <a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$result_companies['compid'], "auth_sess", $bx_session);?>" target="_blank" '+pjs_linkStyle+'><?php echo bx_js_prepare($result_companies['company']);?></a>');
document.write('      </TD>');
document.write('      </TR>');
     <?php
        if($i==FEATURED_COMPANIES_NUMBER) {
                 break;
        }
        $i++;
    }
}
else {
?>
document.write('   <TR>');
document.write('      <TD colspan="2" align="center" valign="middle" bgcolor="'+pjs_tableBGColor+'">'+pjs_bigFont+'<?php echo bx_js_prepare(TEXT_NO_FEATURED_COMPANY);?></font></TD>');
document.write('   </TR>');
<?php
}
?>
document.write('</table><br>');