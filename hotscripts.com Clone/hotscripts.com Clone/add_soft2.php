<?
include_once "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{

?>
      <script language="javascript">
      //<!--
      function Validate(form) {
         if(form.license_id[form.license_id.selectedIndex].value == "") {
            alert('Please select a License.');
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

		 if(form.version.value == "" ) {
            alert('Please enter Software Version.');
            return false;
         }
		 if(form.location.value == "" ) {
            alert('Please enter Software Url.');
            return false;
         }

         return true;
      }
      //-->
   </script>
 
</head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25"><a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; ADD SOFTWARE</font></strong>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="80%" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td height="25" bgcolor="#003366"> <div align="center"><FONT color=#000000><strong><font color="#FFFFFF" size="2" >Post 
              New Software - Step 2 of 2</font></strong></FONT></div></td>
        </tr>
        <tr> 
          <td valign="top" bgcolor="#FFFFFF"> <form name="add_software" onSubmit="return Validate(this);" action="insert_soft.php" method="post">
              <?
		  foreach($_REQUEST as $key => $value)
			{
		echo "<input type='hidden' name='$key' value='$value'>" ;
			}
		?>
              <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr> 
                  <td height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>License:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td>  
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
                <?
			   
					  $cnt=1;
                      $cid_t=$_REQUEST["cat1"];
					  
					   
$rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where   id=" . $cid_t ));

while(  $rs_1["pid"] <>0)
{
 $cid_t=$rs_1["pid"];
 $rs_1=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=" . $cid_t ));
}

$cid_plat=$rs_1["id"];



	$rs_query_1=mysql_query("select count(*) from sbwmd_platforms where cid=" . $cid_plat );
   	$rs_1=mysql_fetch_array($rs_query_1);

		if ($rs_1[0]>0)
		{			   
                ?>
                <tr> 
                  <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Operating 
                    system:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <?php

/////////////////////////

 $rs_query_t=mysql_query("select * from sbwmd_platforms where cid=" . $cid_plat );
					   
					   
					   
					   while($rs_t=mysql_fetch_array($rs_query_t))
					   {
					   ?>
                      <?php if ($cnt%2==1) { ?>
                      <tr> 
                        <?php } ?>
                        <td>

						<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
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
                <?
		 }
		 ?>
                <tr> 
                  <td height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>Release 
                    date:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >&nbsp;</FONT></TD>
                  <td> <table border="0" cellpadding="0" cellspacing="0">
                      <td width="20%" valign="top">  
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
                      <td width="20%" valign="top"> 
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
                      <td width="20%" valign="top">  
                        <select name="rev_year">
                            <option value="">Select Year </option>
                            <option value="1998">1998 </option>
                            <option value="1999">1999 </option>
                            <option value="2000">2000 </option>
                            <option value="2001">2001 </option>
                            <option value="2002">2002 </option>
                            <option value="2003">2003 </option>
                            <option value="2004">2004 </option>
                            <option value="2005">2005</option>
                            <option value="2006">2006</option>
                          </select>
                        </font></td>
                    </table></td>
                </tr>
                <tr> 
                  <td height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>Size 
                    </b><font size="1">(in bytes) </font><b>:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td>  
                    <input type="text" name="size" size="10" value="" style="font-family: courier,monospace; width: 80;">
                    </font></td>
                </tr>
                <tr> 
                  <td height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>Version 
                    number:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td>  
                    <input type="text" name="version" size="10" value="" style="font-family: courier,monospace; width: 80;">
                    </font></td>
                </tr>
                <tr> 
                  <td width="50%" height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>Digital 
                    River ID:</b></font></td>
                  <td align="right"><font color="red" size="2" >&nbsp;</font></td>
                  <td>  
                    <input type="text" name="digital_river_id" MAXLENGTH="30" SIZE="10" value=""  style="font-family: courier,monospace; width: 100;">
                    </font></td>
                </tr>
                <tr> 
                  <td height="25" align="left" bgcolor="#f4f4f4">&nbsp;<b>Software 
                    URL:</b></font></td>
                  <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                  <td>  
                    <input type="text" name="location" MAXLENGTH="255" SIZE="40" value="http://" style="font-family: courier,monospace; width: 360;">
                    </font></td>
                </tr>
                <tr> 
                  <td rowspan="2" align="left" bgcolor="#f4f4f4">&nbsp;</font></td>
                  <td height="25">&nbsp;</font></td>
                  <td><font color="#333333" size="2" ><strong>Note:</strong> 
                    You must specify a URL that points directly to your file, 
                    not just your home page.</font></td>
                </tr>
                <tr> 
                  <td height="25">&nbsp;</td>
                  <td><input name="next" type="submit" class="input" value="Finish"></td>
                </tr>
                <tr> 
                  <td width="50%">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?
}// end main
include "template1.php";
?>
