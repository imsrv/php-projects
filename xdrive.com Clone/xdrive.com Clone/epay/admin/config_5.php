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
if ($_POST['change5'])
{
  $qr1 = mysql_query("SELECT * FROM epay_os_list");
  $max = 0;
  while ($a = mysql_fetch_object($qr1))
  {
    $x[$a->id] = 1;
    if ($a->id > $max) $max = $a->id;
    if (preg_match("/update/i", $_POST['change5']))
      mysql_query("UPDATE epay_os_list SET title='".addslashes($_POST["title$a->id"])."' WHERE id=$a->id");
  }
  for ($i = 0; $i <= $max; $i++)
    if (!$x[$i]) break;
  $sel_id = $i;
  
  if (preg_match("/delete/i", $_POST['change5']) && $_POST['delete'])
  {
    $id = (int)$_POST['delete'];
    mysql_query("DELETE FROM epay_os_list WHERE id=$id");
    mysql_query("UPDATE epay_projects SET os=0 WHERE os=$id");
  }
  if (preg_match("/add/i", $_POST['change5']) && $_POST['title_new'] != '')
    mysql_query("INSERT INTO epay_os_list VALUES($sel_id,'".addslashes($_POST['title_new'])."')");
}
?>

<CENTER>
<SMALL><SPAN STYLE="color: red;">Warning:</SPAN> If you will delete an item from this list, then the specified OS will be removed from all projects containing it.</SMALL>
<BR>
<TABLE class=design cellspacing=0>
<TR><TH>&nbsp;
	<TH>ID
	<TH>Title
    
<?
$qr1 = mysql_query("SELECT * FROM epay_os_list ORDER BY id");
while ($a = mysql_fetch_object($qr1))
{
?>
<TR><TD><?=($a->id ? "<input type=radio name=delete value=$a->id>" : "&nbsp;")?>
	<TD><?=$a->id?>
	<TD><input type=text name=title<?=$a->id?> size=30 value="<?=htmlspecialchars($a->title)?>">
<?
  $i++;
}
?>

<TR><TH colspan=3>
	<input type=submit name=change5 value="Update OS list">
	<input type=submit name=change5 value="Delete selected" <?=$del_confirm?>>

<TR><TD colspan=2>&nbsp;
	<TD><input type=text name=title_new size=30>
<TR><TH colspan=3><input type=submit name=change5 value="Add new record">
    

</TABLE>
</CENTER>


