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
if ($_POST['change7'])
{
  $qr1 = mysql_query("SELECT * FROM epay_quotes");
  $max = 0;
  while ($a = mysql_fetch_object($qr1))
  {
    $x[$a->id] = 1;
    if ($a->id > $max) $max = $a->id;
    if (preg_match("/update/i", $_POST['change7']))
      mysql_query("UPDATE epay_quotes SET comment='".addslashes($_POST["comment$a->id"])."' WHERE id=$a->id");
  }
  for ($i = 0; $i <= $max; $i++)
    if (!$x[$i]) break;
  $sel_id = $i;
  
  if (preg_match("/delete/i", $_POST['change7']) && $_POST['delete'])
  {
    $id = (int)$_POST['delete'];
    mysql_query("DELETE FROM epay_quotes WHERE id=$id");
  }
}
?>

<CENTER>
<BR>
<TABLE class=design cellspacing=0>
<form method=post>
<TR><TH>&nbsp;
	<TH>Date
	<TH>Submitted by
	<TH>Quote
    
<?
$qr1 = mysql_query("SELECT * FROM epay_quotes ORDER BY submit_date DESC");
while ($a = mysql_fetch_object($qr1))
{
?>
<TR><TD><?="<input type=radio name=delete value=$a->id>"?>
	<TD><?=date("d M Y", strtotime($a->submit_date))?>
	<? $x = mysql_fetch_object(mysql_query("SELECT username,type FROM epay_users WHERE id={$a->submit_by}")); ?>
	<TD><?="$x->username ({$GLOBALS[$x->type]})"?>
	<TD>
	  <TEXTAREA name=comment<?=$a->id?> cols=30 rows=2><?=htmlspecialchars($a->comment)?></TEXTAREA>
<?
  $i++;
}
?>

<TR><TH colspan=4>
	<input type=submit name=change7 value="Update Quotes list">
	<input type=submit name=change7 value="Delete selected" <?=$del_confirm?>>

</th>
<?=$id_post?>
</form>
</TABLE>
</CENTER>


