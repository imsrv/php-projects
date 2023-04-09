<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
($fn = $_POST['filename'] or $fn = $_GET['filename']);
if (substr($fn, -4) != ".htm" && substr($fn, -5) != ".html" && substr($fn, -4) != ".php") exit;

if ($_POST['update'])
{
  $f = fopen($fn, 'w');
  if ($f)
  {
    fwrite($f, $_POST['content']);
    fclose($f);
    echo "Edit page successful<br>";
  }
  else
    echo "<div class=error>Check permissions for file <b>$fn</b></div>";
}

$fc = join("", file($fn));
?>
<table class=design cellspacing=0 width=100%>
<form method=post>
<input type=hidden name=filename value="<?=$fn?>">
<?=$id_post?>
  <tr><th>Edit page <?=$fn?>
  <tr><td>
     <textarea name=content rows=30 style="width:100%;"><?=htmlspecialchars($fc);?></textarea>
  <tr><th class=submit>
     <input type=submit class=button name=update value="Update >>">
  </th>
</form>
</table>