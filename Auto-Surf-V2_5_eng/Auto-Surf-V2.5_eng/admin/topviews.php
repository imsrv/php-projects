<?php

include('../prepend.inc.php');

$data=gettopviews();
?>
<?
include("../templates/admin-header.txt");
?>
<center>
<TABLE bgcolor="#FFFFFF" bordercolor="#000000" border="1" width="99%" align="center">
  <tr>
    <td>Rank</td>
    <td>First name</td>
    <td>Name</td>
    <td>E-mail</td>
    <td>URL</td>
    <td>Views</td>
  </tr>
<?php

        for($i=0; $i<count($data); $i++)
        {
                echo "
  <tr>
    <td><b>".($i+1)."</b></td>
    <td>".$data[$i][prename]."</td>
    <td>".$data[$i][name]."</td>
    <td>".$data[$i][email]."</td>
    <td><a href=\"".$data[$i][url]."\" target=\"_blank\">".$data[$i][url]."</a></td>
    <td>".$data[$i][views]."</td>
  </tr>
";
        }

?>
</TD>
</TR>
</TABLE>
<?
include("../templates/admin-footer.txt");
?>