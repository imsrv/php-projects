<?
if (!ini_get('register_globals')) 
   {
       $types_to_register = array('GET','POST','COOKIE','SESSION','SERVER');
       foreach ($types_to_register as $type)
       {
           if (@count(${'HTTP_' . $type . '_VARS'}) > 0)
           {
               extract(${'HTTP_' . $type . '_VARS'}, EXTR_OVERWRITE);
           }
       }
   }

session_start();
if(!session_is_registered("auth"))
	header ("Location: index.php");

include ("include/header.php");
?>
<table border="0" cellpadding="15" cellspacing="0" align="center" height="100%">
<tr>
	<td><a href="changepass.php"><img src="images/changepass.jpg"  width="128" height="141" border="0"></a></td>
	<td><a href="changeemail.php"><img src="images/adminemail.jpg"  width="128" height="141" border="0"></a></td>
</tr>
</table>
<?
include ("include/bottom.php");
?>