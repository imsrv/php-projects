<table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,2,0,"alt1");?></td>
  </tr>
  <TR>
      <TD align="center" valign="middle" width="100%">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><I><?php echo TEXT_ACCOUNT_INFORMATION;?></i></B></FONT>
      </TD>
    </TR>
     <tr bgcolor="#000000">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"alt1");?></td>
   </tr>
  <?php
  $account_query=bx_db_query("select * from ".$bx_table_prefix."_companycredits where ".$bx_table_prefix."_companycredits.compid='".$HTTP_SESSION_VARS['employerid']."'");
  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
  $account_result=bx_db_fetch_array($account_query);
 ?>
  <TR>
     <TD valign="top" align="left">
      <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="#339900"><b><?php echo TEXT_CAN_POST;?>:&nbsp;</b></font>
       <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><B><?php if($account_result['jobs']!="999") {echo $account_result['jobs'];} else {echo TEXT_UNLIMITED;}?> <?php echo TEXT_JOBS;?></B></font>
      </TD>
  </TR>
  <?php if(USE_FEATURED_JOBS == "yes") {?>
  <TR>
     <TD valign="top" align="left">
      <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="#339900"><b><?php echo TEXT_CAN_POST;?>:&nbsp;</b></font>
      <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><B><?php echo $account_result['featuredjobs']." ".TEXT_FEATURED_JOBS_RIGHT;?></B></font>
      </TD>
  </TR>
  <?php }?> 
  <TR>
     <TD valign="top" align="left">
      <font face="<?php echo TEXT_FONT_FACE;?>" size="1" color="#339900"><b><?php echo TEXT_CAN_CONSULT;?>:&nbsp;</b></font>
       <font face="<?php echo DISPLAY_TEXT_FONT_FACE;?>" size="<?php echo DISPLAY_TEXT_FONT_SIZE;?>" color="<?php echo DISPLAY_TEXT_FONT_COLOR;?>"><b><?php if($account_result['contacts']!="999") {echo $account_result['contacts'];} else {echo TEXT_UNLIMITED;}?> <?php echo TEXT_RESUMES;?></b></font>
      </TD>
  </TR>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr bgcolor="<?php echo TABLE_EMPLOYER;?>">
         <td colspan="2"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,2,0,"alt1");?></td>
  </tr>
</table>