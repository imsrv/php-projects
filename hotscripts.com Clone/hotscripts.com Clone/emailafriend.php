<?php
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";

function main()
{
/////////////getting no. of friends 
$no_of_friends=mysql_fetch_array(mysql_query("select no_of_friends from sbwmd_config"));
	if ( isset($_REQUEST["sid"] ) && $_REQUEST["sid"]!="")
	{
    
	$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["sid"] ));
    if ($rst)
	{
	$cid=$rst["cid"];
	}
	else
	{
	//header("Location:"."index.php");
	echo "NOT FOUND";
	}
	
	}
    else
	{
	//header("Location:"."index.php");
	echo "NOT SUPPLIES";
	}

?>
<script language="javascript">
      //<!--
      function Validate(form) {
         
		 if(form.fname.value=='') {
           alert('Enter First Name');
           return false;
           }
		   if(form.lname.value=='') {
           alert('Enter Last Name');
           return false;
           }
		   if(!form.useremail.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Invalid e-mail address.');
           return false;
           }
         return true;
      }
      //-->
   </script>
<table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="2"> 
      <table width="391" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="76" height="22"> &nbsp;<strong> <a href="index.php"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Home</font></a> 
            </strong></td>
          <td width="189" height="22"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>></strong></font> 
            <strong><font color="#000000"><a href="software-description.php"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Software 
            Description</font></a> </font></strong></td>
          <td width="124" height="22"><strong><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">>Email 
            A Friend</font> </strong></td>
        </tr>
      </table>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="78%" colspan="2" valign="top"> <table width="420" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr bgcolor="#000000"> 
                <td height="25" colspan="2" bgcolor="#003366">
<div align="center"><strong><font color="#FFFFFF" size="2" >Enter 
                    the following fields</font></strong></div></td>
              </tr>
              <tr> 
                <td valign="top"> <form name="form" onSubmit="return Validate(this);" action="insertemails.php" method="post">
                    <input type='hidden' name='sid' value='<? echo $_REQUEST["sid"];?>'>
                    <input type='hidden' name='no_of_friends' value='<? echo $no_of_friends[0];?>'>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
                      <tr> 
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>First 
                          Name:</b></font></td>
                        <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                        <td>  
                          <input type="text" name="fname" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="25" value="">
                          </font></td>
                      </tr>
                      <tr> 
                        <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Last 
                          Name:</b></font></td>
                        <TD align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                        <td>  
                          <input type="text" name="lname" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="25" value="">
                          </font></td>
                      </tr>
                      <tr> 
                        <td width="45%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Email:</b></font></td>
                        <TD width="5%" align=right><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
                        <td width="50%">  
                          <input type="text" name="useremail" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="25" value="">
                          </font></td>
                      </tr>
                      <?
					  $cnt=0;
					  while($no_of_friends[0]>$cnt)
					  {
					  $cnt++;
					  ?>
                      <tr> 
                        <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Friend 
                          <? echo $cnt;?>:</b></font></td>
                        <TD align=right><FONT color=red 
                        size=2 >&nbsp;</FONT></TD>
                        <td>  
                          <input type="text" name="friend_email<? echo $cnt;?>" style="font-family: courier,monospace;" MAXLENGTH="30" SIZE="25" value="">
                          </font></td>
                      </tr>
                      <?
					  }//end while
					  ?>
                      <tr> 
                        <td height="25" bgcolor="#f4f4f4">&nbsp;</font></td>
                        <td>&nbsp;</font></td>
                        <td> 
                          <INPUT type=submit value=Submit name=submit>
                          </font></td>
                      </tr>
                    </table>
                  </form></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>