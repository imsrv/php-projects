<?php
include("functions.php");
include ('header.php');
?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF">
<?php
/* nulled by [GTT] :) */ 
$result=db_result_to_array("select contactus from admininfo");
echo "<center>".$result[0][0]."</center>";
?>
<?php
include ('footer.php');
?>
        </td>
  </tr>
</table>
