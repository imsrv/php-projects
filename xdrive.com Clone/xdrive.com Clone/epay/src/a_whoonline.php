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

$type = $_GET['type'];
$name = $$type;
if (!$type) $name = "User";

echo "<div align=center><table class=design cellspacing=0>",
     "<form method=post action=wm.php><input type=hidden name=a value=invite><input type=hidden name=suid value=$suid>",
     "<tr><th>$name<th>Signed on";
if ($type == 'pr')
{
  echo "<th>Invite";
  $cols = 3;
}
else
  $cols = 2;

if ($type) $wh = "type='$type' AND";
$r = mysql_query("SELECT a.* FROM epay_users a,epay_visitors b WHERE $wh a.username=b.username ORDER BY username");
$i = 1;
$cnt = 1;
while ($a = mysql_fetch_object($r))
{
  $info = userinfo($a->id);
  if ($a->type == 'pr')
    list($pr_subcat) = mysql_fetch_row(mysql_query("SELECT title FROM epay_users,epay_pr_subcats WHERE epay_users.id=$a->id AND pr_subcat=epay_pr_subcats.id"));
  elseif (!$type)
    $pr_subcat = $wm;
  echo "\n<tr>",
       "<td class=row$i>",pruser($a->id, $a->username, $a->special)," (",htmlspecialchars($pr_subcat),")",
       "<td class=row$i align=right>",date("d M Y", strtotime($a->signed_on));
  if ($type == 'pr')
    echo "<td class=row$i align=center><input type=checkbox class=checkbox name=_inv$cnt value=$a->id>";
  $cnt++;
  $i = 3 - $i;
}
  
if (!mysql_num_rows($r)) echo "<tr><td colspan=$cols>No online users.";
if ($type == 'pr')
  echo "<tr><th colspan=3 class=submit><input type=submit class=button value='Invite'></th></form>";
echo "</table></div>";


?>
