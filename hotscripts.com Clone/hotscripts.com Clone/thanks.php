<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";

function main()
{

$custom=$_REQUEST["custom"];
$sql1="update  sbwmd_ads  set paid='yes' where id=$custom";
mysql_query($sql1 );


?> 
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; ADVERTISE</font></strong>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td> 
      <?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
      <br> <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
        <tr> 
          <td><b><font face="verdana, arial" size="1" color="#666666"> 
            <?
print($_REQUEST['msg']); 

?>
            </font></b></td>
        </tr>
      </table>
      <?
}//end if
?>
      <font color="#000000" size="2" ><strong><br>
      <font color="#003366"> Thanks for choosing us for your website promotion. 
      <br>
      We have included you banner for rotation on our website.</font></strong></font> 
    </td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>
