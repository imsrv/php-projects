<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
<TR>
      <TD colspan="2"  width="100%" align="center" class="headertdjob"><?php echo TEXT_FEATURED_COMPANIES;?></TD>
</TR>
<tr><td colspan="2"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table>
</td></tr>
</table>
<table bgcolor="#FF9966" width="100%" border="0" cellspacing="1" cellpadding="2">
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
     <TR bgcolor="<?php echo TABLE_FEATURED_BGCOLOR;?>">
      <TD width="40%" align="center">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php
       $image_location = DIR_LOGO. $result_companies['logo'];
       if ((!empty($result_companies['logo'])) && (file_exists($image_location))) {
                  echo "<a href=\"".bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$result_companies['compid'], "auth_sess", $bx_session)."\" class=\"featured\"><img src=\"".HTTP_LOGO.$result_companies['logo']."\" border=0 align=\"absmiddle\"></a>";
       }//end if (file_exists($image_location))
       else {
                 echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"1\" color=\"".ERROR_TEXT_FONT_COLOR."\"><b>".TEXT_LOGO_NOT_AVAILABLE."</b></font>";
       }//end else if (file_exists($image_location))
       ?></font>
       </TD>
      <TD valign="middle" width="60%" align="center">
       <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$result_companies['compid'], "auth_sess", $bx_session);?>" class="featured"><?php echo $result_companies['company'];?></a></font>
      </TD>
      </TR>
    <?php
      if($i==FEATURED_COMPANIES_NUMBER){
            break;
      }
      $i++;
   }
}
else {
 ?>
   <TR bgcolor="<?php echo TABLE_FEATURED_BGCOLOR;?>">
      <TD colspan="2" align="center" valign="middle"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="#FF0000"><b><?php echo TEXT_NO_FEATURED_COMPANY;?></b></font></TD>
   </TR>
 <?php
}
?>
</table><br>