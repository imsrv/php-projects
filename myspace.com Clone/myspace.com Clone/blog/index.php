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

require('../data.php');
require('includes/functions.php');
sql_connect();
global $lines10,$lcoun;
$seid=form_get("seid");
show_header();
$page=getpages();
$l_count=($page-1)*$lines10+$lcoun;
$sql_mails="select * from blogs where blog_own=$seid order by blog_dt desc LIMIT ".($page-1)*$lines10.",".$lines10;
$res_mails=mysql_query($sql_mails);
?>
	<tr>
	  <td valign="top" width="780"><table width="760" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr> 
				  <td width="67" align="left" valign="top">&nbsp;</td>
				  <td width="663" align="left" valign="top" class="text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr> 
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr> 
							  <td width="86%" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" class="body">
								  <tr> 
									<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="lined">
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle" class="lined title">&nbsp;&nbsp;Blog</td>
                                    </tr>
                                    <?php if(!mysql_num_rows($res_mails)) { ?>
                                    <tr>
                                      <td colspan="2" align="center" valign="middle" class="body">&nbsp;</td>
                                    </tr>
                                    <tr> 
                                      <td height="20" colspan="2" align="center" valign="middle" class="body">Blog 
                                        Is Empty!</td>
                                    </tr>
                                    <?php } else { ?>
                                    <tr> 
                                      <td height="20" colspan="2" align="left" valign="middle"> 
                                        <table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr> 
                                            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <?php $chk=1; ?>
                                                <?php while($row_mails=mysql_fetch_object($res_mails))	{
														if(empty($row_mails->blog_img))	$imgdis="<img src='../blog/noimage.jpg' width='100' height='100' border='0'>";
														else	$imgdis="<img src='../".$row_mails->blog_img."' width='100' height='100' border='0'>";
											  ?>
                                                <tr> 
                                                  <td> 
                                                    <?=$imgdis?>
                                                  </td>
                                                  <td valign="middle"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr> 
                                                        <td class="body"><b> 
                                                          <?=stripslashes($row_mails->blog_memf)?>
                                                          <?=stripslashes($row_mails->blog_meml)?>
                                                          </b>&nbsp;&nbsp;</td>
                                                      </tr>
                                                      <tr> 
                                                        <td class="body">&nbsp;&nbsp; 
                                                          <?=stripslashes($row_mails->blog_matt)?>
                                                        </td>
                                                      </tr>
                                                    </table></td>
                                                  <td align="right" class="body"> 
                                                    <?=format_date($row_mails->blog_dt)?>
                                                    &nbsp;&nbsp; </td>
                                                </tr>
                                                <tr> 
                                                  <td colspan="3">&nbsp;</td>
                                                </tr>
                                                <?php $chk++; ?>
                                                <?php } ?>
                                                <tr> 
                                                  <td colspan="3" class="text">&nbsp;</td>
                                                </tr>
                                                <tr> 
                                                  <td width="9%" align="left">&nbsp;</td>
                                                  <td width="9%" align="left">&nbsp;</td>
                                                  <td width="20%" align="right">&nbsp; 
                                                  </td>
                                                </tr>
                                              </table></td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                    <tr> 
                                      <td width="93%" height="20" align="right" valign="middle" class="body"> 
                                        <?php show_page_nos($sql_mails,"index.php?mode=$mode",$lines10,$page,$wh); ?>
                                      </td>
                                      <?php } ?>
                                      <td width="7%" align="center" valign="middle" class="text">&nbsp;</td>
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
?>