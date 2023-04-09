<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOBFIND_FORM);
function make_search_link($link,$vars,$exclude=array()){
   $new_link=$link;
   while (list($header, $value) = each($vars)) {
         if (!in_array($header, $exclude)) {
            if(is_array($value)){
                for ( $i=0 ;$i<sizeof($value);$i++) {
                    $new_link.="&".$header."[]=".urlencode(bx_stripslashes($value[$i]));
                }
            }
            else {
                $new_link.="&".$header."=".urlencode(bx_stripslashes($value));
            }
         }
   }
   return $new_link;
}
if ($HTTP_GET_VARS['f']) {
  $item_from=$HTTP_GET_VARS['f'];
  $item_to=$item_from+NR_DISPLAY;
}
else {
  $item_from=0;
  $item_to=NR_DISPLAY;
}
if ($HTTP_POST_VARS['query']) {
   $sql_statement=bx_stripslashes(urldecode($HTTP_POST_VARS['query']));
}
else {
      if (empty($sql_statement)) {
          $sql_statement="select ".$bx_table_prefix."_jobs.jobid,".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.hide_compname, ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_locations_".$bx_table_lng.".location , ".$bx_table_prefix."_jobs.jobdate, ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory, ".$bx_table_prefix."_companies.company, concat(if (".$bx_table_prefix."_jobs.city='','',concat(".$bx_table_prefix."_jobs.city, ' - ')),if (".$bx_table_prefix."_jobs.province='','', concat(".$bx_table_prefix."_jobs.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location as location from ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs, ".$bx_table_prefix."_locations_".$bx_table_lng." , ".$bx_table_prefix."_companies where ".$bx_table_prefix."_jobs.compid = ".$bx_table_prefix."_companies.compid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid=".$bx_table_prefix."_jobs.jobcategoryid GROUP BY ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc";
      }
}
$job_querry=bx_db_query($sql_statement);
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$no_of_jobs=bx_db_num_rows($job_querry);
if ($no_of_jobs<$item_to) {
	 $item_to=$no_of_jobs;
}
?>
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="5" width="100%" align="center" class="headertdjob"><?php echo TEXT_SEARCH_RESULTS." (".$item_from." ".TEXT_TO." ".$item_to." ".TEXT_FROM." ".$no_of_jobs.")";?></TD>
   </TR>
   <TR><TD colspan="5"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
               </table></TD>
   </TR>
  </table><br>
<?php
if ($no_of_jobs <= NR_DISPLAY) {  
   $num_pages = 1;  
} else if (($no_of_jobs % NR_DISPLAY) == 0) {  
   $num_pages = ($no_of_jobs / NR_DISPLAY);  
} else {  
   $num_pages = ($no_of_jobs / NR_DISPLAY) + 1;  
}  
$num_pages = (int) $num_pages;  
if($no_of_jobs && $num_pages>1){?>  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr bgcolor="<?php echo TABLE_BGCOLOR;?>">
      <td align="right"><?php echo TEXT_PAGE;?>: 
 <?php
  $show=10;
  if ($show%2==0) {
      $to_show=round($show/2);
  }
  else {
      $to_show=floor($show/2);
  }
  $cur_page=(int)($item_from/NR_DISPLAY);
  $cur_page++;
  if ($cur_page<$to_show) {
     if ($num_pages>=$to_show) {
         $left=0;
         $right=$cur_page+$to_show+($to_show-$cur_page);
     }
     else {
         $left=0;
         $right=$num_pages;
     }
  }
  elseif ($cur_page==$to_show) {
     $left=$cur_page-$to_show;
     $right=$cur_page+$to_show;
  }
  elseif($cur_page>$to_show && (($cur_page+$to_show)*NR_DISPLAY)<=$no_of_jobs){
     $left=$cur_page-$to_show;
     $right=$cur_page+$to_show;
  }
  elseif($cur_page>$to_show && (($cur_page+$to_show)*NR_DISPLAY)>$no_of_jobs){
     $left=$cur_page-$to_show-($to_show-($num_pages-$cur_page));
     $right=$num_pages;
  }
  if (($cur_page-$left)>1) {
      print "<a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".(($cur_page-2)*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">&#171; ".PREVIOUS."</a> ";
      if ($cur_page>($to_show+1) && $left>0) {
          print "...";    
      }
      else {
         print "   "; 
      }
  }
  for ($i = 1; $i <= $num_pages; $i++) {  
       if ($i != $cur_page){
           $show_it=true;
           if ($i>=$left && $i<=$right) {
               $show_it=true;
               if ($i>=$left && $i<=$cur_page) {
                   $my_left++;
               }
               if ($i<=$right && $i>=$cur_page) {
                   $my_right++;
               }
           }
           else {
               $show_it=false;
           }
           if ($show_it) {
                   echo " <a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".(($i-1)*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">".$i."</a> ";  
           }
       } else {
           echo " <font size=2><b>".$i."</b></font> ";  
       }  
  }  
  if (($right-$cur_page)>0) {
     if ($cur_page<($num_pages-$to_show) && $num_pages>$right) {
          print "...";    
     }
     else {
         print "   "; 
     }
     print " <a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".($cur_page*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">".NEXT." &#187;</a>";
  }
  ?>
  <td>
  </tr>
</table><br>
<?php }?>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>
  <table bgcolor="<?php echo LIST_BORDER_COLOR;?>" width="100%" border="0" cellspacing="1" cellpadding="4">
          <tr bgcolor="<?php echo LIST_HEADER_COLOR;?>">
            <td width="15%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
<B>&nbsp;<?php echo TEXT_POST_DATE;?>&nbsp;</B></font></td>
            <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
<b>&nbsp;<?php echo TEXT_TITLE;?>&nbsp;</b></font></td>
            <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
<b>&nbsp;<?php echo TEXT_COMPANY;?>&nbsp;</b></font></td>
            <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>">
<b>&nbsp;<?php echo TEXT_LOCATION;?>&nbsp;</b></font></td>
          </tr>
<?php
 if ($no_of_jobs) {
 while ($job_result=bx_db_fetch_array($job_querry))
 {
  $rows++;
  $item++;
   if (($item<=$item_to) and ($item>=$item_from+1))
   {
 ?>
 <tr <?php if(floor($rows/2) == ($rows/2)) {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_FIRST.'"';
    } else {
      echo 'bgcolor="'.DISPLAY_LINE_BGCOLOR_SECOND.'"';
    }?>>
    <td align="left" width="15%"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo bx_format_date($job_result['jobdate'], DATE_FORMAT);?></font></td>
    <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?job_id=".$job_result['jobid']."&type=search", "auth_sess", $bx_session);?>"><?php echo $job_result['jobtitle'];?></a></font></td>
    <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php if($job_result['hide_compname']!='yes' && $job_result['compid']!=0){?><a href="<?php echo bx_make_url(HTTP_SERVER.FILENAME_VIEW."?company_id=".$job_result['compid']."&type=search", "auth_sess", $bx_session);?>"><?php echo $job_result['company'];?></a><?php }else{echo TEXT_HIDDEN_INFORMATION;}?></font></td>
    <td width="30%" align="center"><font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><?php echo $job_result['location'];?></font></td>
  </tr>
 <?php
    } //end if
   } //end while
 } //end if num_rows
 else
 {
  ?>
  <tr bgcolor="<?php echo TABLE_BGCOLOR;?>"><td colspan="5" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_NO_RESULT;?></b></font></td></tr>
  <?php
 } //end else num_rows
$item_back_from=$item_from;
$item_from=$item_to;
$item_to=$item_from+NR_DISPLAY;
?>
  </table></td></tr></table><br>
<?php if($no_of_jobs && $num_pages>1){?>  
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr bgcolor="<?php echo TABLE_BGCOLOR;?>">
      <td align="right" valign="middle"><?php echo TEXT_PAGE;?>: 
 <?php
  if (($cur_page-$left)>1) {
      print "<a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".(($cur_page-2)*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">&#171; ".PREVIOUS."</a> ";
       if ($cur_page>($to_show+1) && $left>0) {
          print "...";    
      }
      else {
         print "   "; 
      }
  }
  for ($i = 1; $i <= $num_pages; $i++) {  
       if ($i != $cur_page){
           $show_it=true;
           if ($i>=$left && $i<=$right) {
               $show_it=true;
               if ($i>=$left && $i<=$cur_page) {
                   $my_left++;
               }
               if ($i<=$right && $i>=$cur_page) {
                   $my_right++;
               }
           }
           else {
               $show_it=false;
           }
           if ($show_it) {
                   echo " <a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".(($i-1)*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">".$i."</a> ";  
           }
       } else {
           echo " <font size=2><b>".$i."</b></font> ";  
       }  
  }  
  if (($right-$cur_page)>0) {
     if ($cur_page<($num_pages-$to_show) && $num_pages>$right) {
          print "...";    
     }
     else {
         print "   "; 
     } 
     print " <a href=\"".bx_make_url(make_search_link(HTTP_SERVER.FILENAME_JOB_FIND."?f=".($cur_page*NR_DISPLAY),$HTTP_GET_VARS,array("f")), "auth_sess", $bx_session)."\" class=\"search\">".NEXT." &#187;</a>";
  }
  ?>
  <td>
  </tr>
</table>
<?php }?>