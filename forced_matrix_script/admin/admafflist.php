<?php
/* nulled by [GTT] :) */    


@session_start();
include("functions.php");
include("header.php");
db_connect();
if (session_is_registered("admin"))
{
$show=15;
if (!@$page) {$begin=0;$page=1;}
else $begin=($page-1)*$show;
if (@$sortby) {$orderby="order by"; $sort=$sortby;} else {$orderby=""; $sort="";}
if (@$sortby=="amt") $sortby="saleam+lev1saleam+lev2saleam+lev3saleam+lev4saleam+lev5saleam+lev6saleam+lev7saleam DESC";
if (@$sortby=="clicks") $sortby="banclicks+textclicks DESC";
if (@$sortby=="name") $sortby="frstname, lstname";
if (@$sortby=="lstpaidtime") $sortby="lastpaidtime DESC";
if (@$sortby=="lastpaidamt") $sortby="lastpaidamt DESC";
if (@$sortby=="totalpaidamt") $sortby="totalpaidamt DESC";
$affs=db_result_to_array("select id, frstname, lstname, banclicks, textclicks, lastpaidtime,lastpaidamt, totalpaidamt from users $orderby ".@$sortby." limit $begin, $show");

?>
<?admin_menu();?><CENTER>
<h3 align="center">Affiliates Details</h3><table width="700" border="0">
<tr>
  <td width="59" align="center"><div align="center"><b><a href="admafflist.php?sortby=id">Affiliate
      ID</a></b></div></td>
  <td width="283"><div align="center"><b><a href="admafflist.php?sortby=name">Affiliate
      Name</a></b></div></td>
  <td width="82" align="center"><div align="center"><b><a href="admafflist.php?sortby=amt">Amount
      Due ($)</a></b></div></td>
  <td width="*" align="center"><div align="center"><b><a href="admafflist.php?sortby=clicks">Total
      Clickthroughs</a></b></div></td>
  <td width="100" align="center"><div align="center"><b><a href="admafflist.php?sortby=lstpaidtime">Last
      Paid</a></b></div></td>
  <td width="120" align="center"><div align="center"><b><a href="admafflist.php?sortby=lastpaidamt">Last
      Paid<br>
      Amt ($)</a></b></div></td>
  <td width="100" align="center"><div align="center"><b><a href="admafflist.php?sortby=totalpaidamt">Total
      Paid</b></a></div></td>
</tr>
<tr>
  <TD colspan=7><hr align="center" size=1></TD>
</tr>
<?
for ($i=0; $i<count($affs); $i++)
{
?>
<tr>
  <td width="59" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>"><?echo $affs[$i][0];?></a></div></td>
  <td width="283"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>"><?echo $affs[$i][1]; echo " "; echo $affs[$i][2];?></a></div></td>
  <td width="82" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>">
      <?$balance=calc_balance($affs[$i][0]); echo $balance;?>
      </a></div></td>
  <td width="*" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>">
      <?$totalclicks=$affs[$i][3]+$affs[$i][4]; echo $totalclicks;?>
      </a></div></td>
  <td width="100" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>">
      <?if (!$affs[$i][5]) echo "NEVER"; else echo date('Y-m-d', $affs[$i][5]);?>
      </a></div></td>
  <td width="120" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>"><?echo $affs[$i][6];?></a></div></td>
  <td width="100" align="center"><div align="center"><a href="admaffedit.php?affid=<?echo $affs[$i][0];?>"><?echo $affs[$i][7];?></a></div></td>
</tr>
<div align="center">
  <?}
echo "</table><br>";
$pageamt=db_result_to_array("select count(id) from users");
if ($pageamt[0][0]%$show) $pageamt=($pageamt[0][0]-$pageamt[0][0]%$show)/$show+1; else $pageamt=$pageamt[0][0]/$show;
$currpage=$begin/$show+1;
if ($page!=1) echo "<a href=admafflist.php?sortby=$sort&page=".($page-1)."><<</a> "; else echo "<< ";
for ($i=1; $i<=$pageamt; $i++)
 {
  if ($page!=$i) echo "<a href=admafflist.php?sortby=$sort&page=$i>$i</a> "; else echo "$i ";
 }
if ($page!=$pageamt) echo "<a href=admafflist.php?sortby=$sort&page=".($page+1).">>></a></a>"; else echo ">>";
?>
  <br>
</div>
<form method="post" action="adminlogin.php">
  <div align="center">
    <input type="submit" name="Submit" value="Click here to return to Main Menu">
  </div>
</form>
<div align="center"></CENTER></div>
<div align="center">
  <?
}
else echo "You are not logged in";
?>
</div>
