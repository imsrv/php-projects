<?
include "logincheck.php";
include_once "../config.php";

function main()
{
$rs0=mysql_fetch_array(mysql_query("select *,UNIX_TIMESTAMP(rel_date) as t from sbwmd_softwares where id=".$_REQUEST["id"]));
$rs1=mysql_fetch_array(mysql_query("select * from sbwmd_soft_desc where sid=".$_REQUEST["id"]));

$date_arr=getdate($rs0["t"]);
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

         if(form.home_page.value == "http://" || form.home_page.value == "") {
            alert('Please enter a Home page URL.');
            return false;
         }
         if(form.long_description.value == "[Enter a 1,500 maximum character description of your product]") {
            alert('Please enter a Program description.');
            return false;
         }
    
	
	
			 if(form.size.value == "" ) {
            alert('Please enter a Size of program.');
            return false;
         }
		 if( isNaN(form.size.value) ) {
            alert('Please enter Numeric Value for the Size of program.');
            return false;
         }

	
	
	
	     return true;
      }
   //-->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
  <tr> 
    <td valign="top" bgcolor="#0066FF"><div align="center"><font color="#FFFFFF" size="3"><strong>Update 
        Software Details</strong></font></div></td>
  </tr>
 
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
 
  <tr> 
    <td width="80%" valign="top"> <form name="frm1" onSubmit="return Validate(this);" action="updatesoft.php" method="post">
          <input type="hidden" name=id value="<? echo $_REQUEST["id"];?>">   
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
              <input type="text" name="program_name" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="<? echo $rs0["s_name"];?>">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Category 
              :</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <TD valign="center"> <div align="left"><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#666666"> 
                <input style="FONT-FAMILY: courier, monospace" name = "cat_name1" type = "text" id="cat_name1"  size="45" value="<? 
				$rs_t=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=".$rs0["cid"]));
				echo $rs_t["cat_name"];?>" readonly>
                <input name = "cat1" type = "hidden" id="cat1" readonly  value="<? echo $rs0["cid"]; ?>">
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
              <input type="text" name="eval_period" MAXLENGTH="120" style="font-family: courier,monospace;" SIZE="15" value="<? echo $rs0["eval_period"];?>">
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
                <option value="<? echo $rst["id"]; ?>" <? if($rst["id"]==$rs0["cur_id"]) echo "selected";?>><? echo $rst["cur_name"]; ?></option>
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
              <input type="text" name="cost" MAXLENGTH="120" SIZE="10" style="font-family: courier,monospace;" value="<? echo $rs0["price"];?>">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Home 
              page URL:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="home_page" MAXLENGTH="255" SIZE="35" style="font-family: courier,monospace;" value="<? echo $rs0["home_url"];?>">
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Major 
              features:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="major_features" rows="2" COLS="30" style="font-family: courier,monospace; width: 340;"><? echo str_replace("/n","<br>",$rs1["major_features"]);?></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Additional 
              software required:</b><br>
              <small>( Minimum requirements for Games )</small></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="addl_required" rows="2" COLS="30" style="font-family: courier,monospace; width: 340;" ><? echo str_replace("/n","<br>",$rs1["addnl_soft"]);?></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Program 
              description:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="long_description" COLS="30" ROWS="10" id="long_description" style="font-family: courier,monospace; width: 340;"><? echo str_replace("/n","<br>",$rs1["prog_desc"]);?></textarea>
              </font></td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Author 
              notes:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="notes" ROWS="10" COLS="30" style="font-family: courier,monospace; width: 340;"><? echo str_replace("/n","<br>",$rs1["author_notes"]);?></textarea>
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Admin 
              Description:</b></font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="admin_desc" ROWS="10" COLS="30" style="font-family: courier,monospace; width: 340;"><? echo str_replace("/n","<br>",$rs0["admin_desc"]);?></textarea>
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
                <option value="<? echo $rst["id"]; ?>"<? if($rst["id"]==$rs0["lid"]) echo " selected ";?>><? echo $rst["licence_name"]; ?></option>
                <?
					}//end while
					 ?>
              </select>
              </font></td>
          </tr>
          <?
/////////////////////////////////////////////////////				      
$cid_t=$rs0["cid"];
					   
$rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where   id=" . $cid_t ));

while(  $rs_1["pid"] <>0)
{
 $cid_t=$rs_1["pid"];
 $rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=" . $cid_t ));
}

$cid_plat=$rs_1["id"];		
///////////////////////////////////////////////////////						


$rs_query_1=mysql_query("select count(*) from sbwmd_platforms where cid=" . $cid_plat );   	
$rs_1=mysql_fetch_array($rs_query_1);

if ($rs_1[0]>0)
{   

?>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Operating 
              system:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php
					   $cnt=1;
			
				
					   $rs_query_t=mysql_query("select * from sbwmd_platforms where cid=" . $cid_plat );
					   while($rs_t=mysql_fetch_array($rs_query_t))
					   {
					   ?>
                <?php if ($cnt%2==1) { ?>
                <tr> 
                  <?php } ?>
                  <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <input  type="checkbox" value="yes" name="plat_name<?php echo $rs_t["id"];?>" 
						  
						  <?
						  
						 $a=split(",",$rs0["platforms"]);
						 $checked="no";
						 for ($i=0;$i< count($a) ; $i++)
						 {
						  if ($a[$i]==$rs_t["id"])
						  {
						   $checked="yes";
						  }
						   
						 }
						 
						 if ($checked=="yes")
						 {
						 echo " checked ";
						 }
						 
						 						  
						  ?>
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
          <?
  }
 ?>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Release 
              date:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <table border="0" cellpadding="0" cellspacing="0">
                <td width="20%" valign="top"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_month">
                    <option value="">Select Month 
                    <option   value="01" <? if($date_arr['mon']==01) echo " selected";?>>January 
                    <option   value="02" <? if($date_arr['mon']==02) echo " selected";?>>February 
                    <option   value="03" <? if($date_arr['mon']==03) echo " selected";?>>March 
                    <option   value="04" <? if($date_arr['mon']==04) echo " selected";?>>April 
                    <option   value="05" <? if($date_arr['mon']==05) echo " selected";?>>May 
                    <option   value="06" <? if($date_arr['mon']==06) echo " selected";?>>June 
                    <option   value="07" <? if($date_arr['mon']==07) echo " selected";?>>July 
                    <option   value="08" <? if($date_arr['mon']==08) echo " selected";?>>August 
                    <option   value="09" <? if($date_arr['mon']==09) echo " selected";?>>September 
                    <option   value="10" <? if($date_arr['mon']==10) echo " selected";?>>October 
                    <option   value="11" <? if($date_arr['mon']==11) echo " selected";?>>November 
                    <option   value="12" <? if($date_arr['mon']==12) echo " selected";?>>December 
                  </select>
                  </font></td>
                <td width="20%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_day">
                    <option value="">Select Day 
                    <option  value="01" <? if($date_arr['mday']==01) echo " selected";?>>1st 
                    <option  value="02" <? if($date_arr['mday']==02) echo " selected";?>>2nd 
                    <option  value="03" <? if($date_arr['mday']==03) echo " selected";?>>3rd 
                    <option  value="04" <? if($date_arr['mday']==04) echo " selected";?>>4th 
                    <option  value="05" <? if($date_arr['mday']==05) echo " selected";?>>5th 
                    <option  value="06" <? if($date_arr['mday']==06) echo " selected";?>>6th 
                    <option  value="07" <? if($date_arr['mday']==07) echo " selected";?>>7th 
                    <option  value="08" <? if($date_arr['mday']==08) echo " selected";?>>8th 
                    <option  value="09" <? if($date_arr['mday']==09) echo " selected";?>>9th 
                    <option  value="10" <? if($date_arr['mday']==10) echo " selected";?>>10th 
                    <option  value="11" <? if($date_arr['mday']==11) echo " selected";?>>11th 
                    <option  value="12" <? if($date_arr['mday']==12) echo " selected";?>>12th 
                    <option  value="13" <? if($date_arr['mday']==13) echo " selected";?>>13th 
                    <option  value="14"<? if($date_arr['mday']==14) echo " selected";?>>14th 
                    <option  value="15"<? if($date_arr['mday']==15) echo " selected";?>>15th 
                    <option  value="16"<? if($date_arr['mday']==16) echo " selected";?>>16th 
                    <option  value="17"<? if($date_arr['mday']==17) echo " selected";?>>17th 
                    <option  value="18"<? if($date_arr['mday']==18) echo " selected";?>>18th 
                    <option  value="19"<? if($date_arr['mday']==19) echo " selected";?>>19th 
                    <option  value="20"<? if($date_arr['mday']==20) echo " selected";?>>20th 
                    <option  value="21"<? if($date_arr['mday']==21) echo " selected";?>>21st 
                    <option  value="22"<? if($date_arr['mday']==22) echo " selected";?>>22nd 
                    <option  value="23"<? if($date_arr['mday']==23) echo " selected";?>>23rd 
                    <option  value="24"<? if($date_arr['mday']==24) echo " selected";?>>24th 
                    <option  value="25"<? if($date_arr['mday']==25) echo " selected";?>>25th 
                    <option  value="26"<? if($date_arr['mday']==26) echo " selected";?>>26th 
                    <option  value="27"<? if($date_arr['mday']==27) echo " selected";?>>27th 
                    <option  value="28"<? if($date_arr['mday']==28) echo " selected";?>>28th 
                    <option  value="29"<? if($date_arr['mday']==29) echo " selected";?>>29th 
                    <option  value="30"<? if($date_arr['mday']==30) echo " selected";?>>30th 
                    <option  value="31"<? if($date_arr['mday']==31) echo " selected";?>>31st 
                  </select>
                  </font></td>
                <td width="20%" valign="top"> <font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="rev_year">
                    <option value="">Select Year 
                    <option  value="1998" <? if($date_arr['year']==1998) echo " selected";?>>1998 
                    <option  value="1999" <? if($date_arr['year']==1998) echo " selected";?>>1999 
                    <option  value="2000" <? if($date_arr['year']==2000) echo " selected";?>>2000 
                    <option  value="2001" <? if($date_arr['year']==2001) echo " selected";?>>2001 
                    <option  value="2002" <? if($date_arr['year']==2002) echo " selected";?>>2002 
                    <option  value="2003" <? if($date_arr['year']==2003) echo " selected";?>>2003 
                    <option  value="2004" <? if($date_arr['year']==2004) echo " selected";?>>2004 
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
              <input type="text" name="size" size="10" value="<? echo $rs0["size"];?>" style="font-family: courier,monospace; width: 80;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Version 
              number:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="version" size="10" value="<? echo $rs0["version"];?>" style="font-family: courier,monospace; width: 80;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Digital 
              River ID:</b></font></td>
            <td align="right"><font color="red" size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="digital_river_id" MAXLENGTH="30" SIZE="10" value="<? echo $rs0["digital_riverid"];?>"  style="font-family: courier,monospace; width: 100;">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<b>Software 
              URL:</b></font></td>
            <TD align=right><FONT color=red 
                        size=2 face="Arial, Helvetica, sans-serif">*&nbsp;</FONT></TD>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <input type="text" name="location" MAXLENGTH="255" SIZE="40" value="<? echo $rs0["soft_url"];?>" style="font-family: courier,monospace; width: 360;">
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="next" type="submit" class="submit" value="Update"></td>
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

