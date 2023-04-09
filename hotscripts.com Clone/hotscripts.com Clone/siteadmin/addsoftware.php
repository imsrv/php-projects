<?
include "logincheck.php";
include_once "../config.php";

function main()
{
?>

<link href="../styles/style.css" rel="stylesheet" type="text/css">
<script language="javascript">
   //<!--
    function category(box)
{

str="choosecategory.php?box="  + box;

window.open(str,"Category","top=5,left=30,toolbars=no,maximize=yes,resize=yes,width=550,height=450,location=no,directories=no,scrollbars=yes");


}
	  function Validate(form) {
         if(form.program_name.value == "") {
            alert('Please enter a Program name.');
            return false;
         }
         if(form.cat_name1.value == "") {
            alert('Please choose category for the software');
            return false;
         }
        if(form.screenshot_location.value == "http://" || form.screenshot_location.value == "") {
            alert('Please enter a Screenshot location.');
            return false;
         }
         if(form.home_page.value == "http://" || form.home_page.value == "") {
            alert('Please enter a Home page URL.');
            return false;
         }
         if(form.long_description.value == "[Enter a 1,500 maximum character description of your product]") {
            alert('Please enter a Program description.');
            return false;
         }
         return true;
      }
   //-->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
  <tr> 
    <td valign="top" bgcolor="#0066FF"><div align="center"><font color="#FFFFFF" size="3"><strong>Enter 
        Software Details</strong></font></div></td>
  </tr>
 
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
 
  <tr> 
    <td width="80%" valign="top"> <form name="frm1" onSubmit="return Validate(this);" action="insertsoft.php" method="post">
             
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Program 
              name:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="program_name" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Category 
              :</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <TD valign="center"> <div align="left"><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666"> 
                <input style="FONT-FAMILY: courier, monospace" name = "cat_name1" type = "text" id="cat_name1"  size="45" readonly>
                <input name = "cat1" type = "hidden" id="cat1" readonly >
                <input type=BUTTON name=btn_name22 value="Select A Category" onClick=category('1')>
                <font face="Arial, Helvetica, sans-serif" size="2">&nbsp; </font> 
                </font>&nbsp;&nbsp;<font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                </font></div></TD>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Evaluation 
              period:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="eval_period" MAXLENGTH="120" style="font-family: courier,monospace;" SIZE="15">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Currency:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="currency_symbol_id">
                <option value="">Select a value</option>
                <?
			  $cats=mysql_query("select * from sbwmd_currency ");
			  while($rst=mysql_fetch_array($cats))
			  {
			  		  ?>
                <option value="<? echo $rst["id"]; ?>" ><? echo $rst["cur_name"]; ?></option>
                <?
					}//end while
					 ?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Cost:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="cost" maxlength="120" size="10" style="font-family: courier,monospace;">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Screen 
              shot location:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="screenshot_location" MAXLENGTH="255" SIZE="35" style="font-family: courier,monospace;">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Home 
              page URL:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="home_page" MAXLENGTH="255" SIZE="35" style="font-family: courier,monospace;">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Major 
              features:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="major_features" rows="2" COLS="30" style="font-family: courier,monospace; width: 340;"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Additional 
              software required:</b><br>
              <small>( Minimum requirements for Games )</small></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="addl_required" rows="2" COLS="30" style="font-family: courier,monospace; width: 340;" ></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Program 
              description:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="long_description" ROWS="10" COLS="30" style="font-family: courier,monospace; width: 340;"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Author 
              notes:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="notes" ROWS="10" COLS="30" style="font-family: courier,monospace; width: 340;"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Admin 
              Description:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="admin_desc" ROWS="10" COLS="30" style="font-family: courier,monospace; width: 340;"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>License:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="license_id">
                <option value="">Select a value</option>
                <?
			  $cats=mysql_query("select * from sbwmd_licence_types ");
			  while($rst=mysql_fetch_array($cats))
			  {
			  		  ?>
                <option value="<? echo $rst["id"]; ?>"><? echo $rst["licence_name"]; ?></option>
                <?
					}//end while
					 ?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Operating 
              system:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php
					   $cnt=1;
					   $rs_query_t=mysql_query("select * from sbwmd_platforms where cid=" . $rs0["cid"] );
					   while($rs_t=mysql_fetch_array($rs_query_t))
					   {
					   ?>
                <?php if ($cnt%2==1) { ?>
                <tr> 
                  <?php } ?>
                  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input  type="checkbox" value="yes" name="plat_name<?php echo $rs_t["id"];?>" 
						  		>
                    <?php echo $rs_t["plat_name"] ;?> </font></td>
                  <?php if ($cnt%2==0) { ?>
                </tr>
                <?php } ?>
                <?php
						$cnt++;
					   }
					   ?>
              </table></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Release 
              date:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <table border="0" cellpadding="0" cellspacing="0">
                <td width="20%" valign="top"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_month">
                    <option value="">Select Month 
                    <option   value="01">January 
                    <option   value="02">February 
                    <option   value="03">March 
                    <option   value="04">April 
                    <option   value="05">May 
                    <option   value="06">June 
                    <option   value="07">July 
                    <option   value="08">August 
                    <option   value="09">September 
                    <option   value="10">October 
                    <option   value="11">November 
                    <option   value="12">December 
                  </select>
                  </font></td>
                <td width="20%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_day">
                    <option value="">Select Day 
                    <option  value="01">1st 
                    <option  value="02">2nd 
                    <option  value="03">3rd 
                    <option  value="04">4th 
                    <option  value="05">5th 
                    <option  value="06">6th 
                    <option  value="07">7th 
                    <option  value="08">8th 
                    <option  value="09">9th 
                    <option  value="10">10th 
                    <option  value="11">11th 
                    <option  value="12">12th 
                    <option  value="13">13th 
                    <option  value="14">14th 
                    <option  value="15">15th 
                    <option  value="16">16th 
                    <option  value="17">17th 
                    <option  value="18">18th 
                    <option  value="19">19th 
                    <option  value="20">20th 
                    <option  value="21">21st 
                    <option  value="22">22nd 
                    <option  value="23">23rd 
                    <option  value="24">24th 
                    <option  value="25">25th 
                    <option  value="26">26th 
                    <option  value="27">27th 
                    <option  value="28">28th 
                    <option  value="29">29th 
                    <option  value="30">30th 
                    <option  value="31">31st 
                  </select>
                  </font></td>
                <td width="20%" valign="top"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_year">
                    <option value="">Select Year 
                    <option  value="1998">1998 
                    <option  value="1999">1999 
                    <option  value="2000">2000 
                    <option  value="2001">2001 
                    <option  value="2002">2002 
                    <option  value="2003">2003 
                    <option  value="2004">2004 
                  </select>
                  </font></td>
              </table></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Size 
              </b><font size="1">(in bytes) </font><b>:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="size" size="10" style="font-family: courier,monospace; width: 80;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Version 
              number:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="version" size="10" style="font-family: courier,monospace; width: 80;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Digital 
              River ID:</b></font></td>
            <td align="right"><font color="red" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="digital_river_id" MAXLENGTH="30" SIZE="10"  style="font-family: courier,monospace; width: 100;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Software 
              URL:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="location" MAXLENGTH="255" SIZE="40" style="font-family: courier,monospace; width: 360;">
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="next" type="submit" class="submit" value="Add"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
            </form></td>
  </tr>

</table>

<p>&nbsp; </p>
<p><br>
 <?
}// end main
include "template.php";
?> 

