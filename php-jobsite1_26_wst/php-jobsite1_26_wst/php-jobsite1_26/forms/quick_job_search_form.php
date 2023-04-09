<?php include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_JOB_FORM);?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_FIND, "auth_sess", $bx_session);?>" method="get" name="search_job">
<INPUT type="hidden" name="action" value="search">
<INPUT type="hidden" name="auth_sess" value="<?php echo $bx_session;?>">
<INPUT type="hidden" name="ref" value="<?php echo substr(md5(time()),0,25);?>">
<table bgcolor="<?php echo LEFT_NAV_BG_COLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
         <td><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="#000000" height="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></td>
  </tr>
 <tr>
    <td align="left" valign="top" nowrap><font face="<?php echo TEXT_FONT_FACE;?>" size="2" color="<?php echo TEXT_COMPANY_FONT_COLOR;?>"><b><?php echo TEXT_QUICK_JOB_SEARCH;?></b></font></td>
  </tr>
  <TR>
      <TD valign="top" width="76%">
        <font size="2"><SELECT name="jids[]" class="smallselect">
        <OPTION selected value=00><?php echo TEXT_ALL_CATEGORIES;?></OPTION>
        <?php
        $title_query=bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng."");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($title_result=bx_db_fetch_array($title_query))
        {
        echo '<option value="'.$title_result['jobcategoryid'].'"';
        if (strstr($job_result['jobcategoryid'],$title_result['jobcategoryid'])) {echo "selected";}
        echo '>'.$title_result['jobcategory'].'</option>';
        }
        ?>
        </SELECT></font>
      </TD>
    </TR>
    <TR>
      <TD valign="top" width="76%">
            <font size="2"><SELECT name="lids[]" class="smallselect">
            <OPTION selected value="000"><?php echo TEXT_ALL_LOCATIONS;?></OPTION>
        <?php
          $location_query=bx_db_query("select * from ".$bx_table_prefix."_locations_".$bx_table_lng."");
          while ($location_result=bx_db_fetch_array($location_query))
          {
          echo '<option value="'.$location_result['locationid'].'"';
          if (strstr($job_result['locationid'],$location_result['locationid'])) {echo "selected";}
          echo '>'.$location_result['location'].'</option>';
          }
          ?>
        </SELECT></font>
      </TD>
    </TR>
    <tr>
        <td valign="top" width="100%"><font size="2"><input type="text" name="kwd" value="" size="20" style="width: 130px"></font></td>
    </tr>
    <TR>
      <TD align="center" valign="top" width="100%"><INPUT type="submit" name="cmdSearch" value="<?php echo TEXT_BUTTON_SEARCH;?>"></TD>
    </TR>
</form></table>