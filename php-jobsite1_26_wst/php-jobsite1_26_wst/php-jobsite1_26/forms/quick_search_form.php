<?php include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_JOB_FORM);?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOB_FIND, "auth_sess", $bx_session);?>" method="get" name="search_job">
<INPUT type="hidden" name="action" value="search">
<INPUT type="hidden" name="auth_sess" value="<?php echo $bx_session;?>">
<INPUT type="hidden" name="ref" value="<?php echo substr(md5(time()),0,25);?>">
<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR>
      <TD colspan="3" width="100%" align="center" class="headertdjob"><?php echo TEXT_QUICK_JOB_SEARCH;?></TD>
   </TR>
   <TR><TD colspan="3"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
       </table></TD>
   </TR>
   <TR>
     <TD colspan="3"><hr></TD>
   </TR>
   <TR>
      <TD width="10%">&nbsp;</TD>
	  <TD valign="top" width="25%" align="right">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_JOB_CATEGORY;?>:<BR></STRONG></FONT>
        <font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD valign="top" width="65%" align="left">
        <SELECT name="jids[]" multiple size="5">
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
        </SELECT>
      </TD>
    </TR>
    <TR>
	  <TD width="10%">&nbsp;</TD>
      <TD valign="top" width="25%" align="right">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_LOCATION;?>:</STRONG></FONT><br>
                <font face="verdana" size="1"><?php echo TEXT_CTRL_CLICK;?></FONT>
      </TD>
      <TD valign="top" width="65%" align="left">
            <SELECT name="lids[]" multiple size="5">
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
        </SELECT>
      </TD>
    </TR>
    <TR>
	  <TD width="10%">&nbsp;</TD>
      <TD valign="top" width="25%" align="right" nowrap>
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><STRONG><?php echo TEXT_KEYWORDS;?>:</STRONG></FONT></TD>
      <TD valign="top" width="65%" align="left">
            <input type="text" name="kwd" value="" size="30">
      </TD>
    </TR>
     <TR>
      <TD align="center" colspan="3" valign="top" width="100%">
        <P><INPUT type="reset" value=<?php echo TEXT_BUTTON_RESET;?>>
        <INPUT type="submit" name="cmdSearch" value="  <?php echo TEXT_BUTTON_SEARCH;?>  "></P>
      </TD>
    </TR>
    <TR>
     <TD colspan="3"><hr></TD>
    </TR>
</table>
</form>