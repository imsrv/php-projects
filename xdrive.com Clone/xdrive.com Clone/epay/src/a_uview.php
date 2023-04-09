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
<script>
function popUp(URL) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,location=0,status=1,menubar=0,scrollbars=1,resizable=1,width=600,height=470');");
}
</script>
<?
if ($_GET['ed'] && $user == 3)
{
  $_fpr_add = 0;
  $_GET['id'] = $_GET['ed'];
  require("admin/g_uedit.php");
  if (!$_fpr_err)
  {
    unset($x);
    while (list($k,$v) = each($_GET))
      if ($k != "ed")
        $x[] = urlencode($k)."=".urlencode($v);
    header("Location: index.php?".implode("&", $x));
    exit;
  }
}
else 
{
$r = mysql_fetch_object(mysql_query("SELECT * FROM epay_users WHERE id=".(int)$_GET['user']));
if ($r)
{
  if ($r->type == 'pr')
  {
    list($pr_subcat) = mysql_fetch_row(mysql_query("SELECT title FROM epay_users,epay_pr_subcats WHERE epay_users.id=$r->id AND pr_subcat=epay_pr_subcats.id"));
    $subtype = " ($pr_subcat)";
$folio = 0;
$sql = "SELECT * FROM epay_users_folio WHERE user=".(int)$_GET['user'];
$qry1 = mysql_query($sql);
$itms = 0;
if ($qry1){
	$row = mysql_fetch_object($qry1);
	if($row->user == (int)$_GET['user'] ){
		$folio = 1;
	}
}
  }
 
  $r->view_counter++;
  mysql_query("UPDATE epay_users SET view_counter={$r->view_counter} WHERE id={$r->id}");
  
  $info = userinfo($r->id);
  $x = preg_replace(
    "/((http(s?):\\/\\/)|(www\\.))([\\w\\.]+)(.*?)(?=\\s)/i", 
    "<a href=\"http$3://$4$5$6&brand=$brand\" target=\"_blank\">$4$5</a>", 
    htmlspecialchars($r->profile." "));
    
if ( ($r->country) || ($r->state) ){
	$country = strtolower($r->country);
	if (file_exists("img/flags/{$r->state}.gif") ){
		$sname = statename($r->state,$r->country);
		$flag = "<img src=epay/img/flags/{$r->state}.gif height=15 width=22 border=0 alt='$sname'>";
	}else if (file_exists("img/flags/{$country}.gif") ){
		$sname = statename($r->state,$r->country);
		$flag = "<img src=epay/img/flags/{$country}.gif height=15 width=22 border=0 alt='$sname'>";
	}
}
  echo "<TABLE class=design cellspacing=0 width=100%>\n",
       "<FORM method=post action=wm.php><input type=hidden name=a value=invite><INPUT type=hidden name=suid value=$suid>",
       "<TR><TH colspan=2>{$GLOBALS[$r->type]} Info\n", $subtype,
       "<TR><TD class=row1 width=25%>Username:\n",
       "<TD class=row1>$flag $r->username\n",
       ($r->special ? getuserstatus($r->id) : ""),
       ($user == 3 ? " <a href=index.php?a=uview&user=$r->id&$id&ed=$r->id&brand=$brand>Edit</a>" : ""),
       "<TR><TD class=row2>Name/Company:\n",
       "<TD class=row2>",($r->name ? htmlspecialchars($r->name) : '&nbsp;'),
       "<TR><TD class=row1>Profile:\n",
       "<TD class=row1>",($r->profile ? nl2br($x) : '&nbsp;'),"\n";
  echo "</FORM></TABLE>",
       "<br>Profile Viewed <b>{$r->view_counter}</b> times.<br>";
}
else
  $action = '';
}
?>