<?
/* nulled by [GTT] :) */ 

include("functions.php");
db_connect();
@session_start();
include ('header.php');
if(session_is_registered("usid"))
{
 $matrix_deep=db_result_to_array("select matrix_deep, matrix_width  from admininfo");
 $matrix_width=$matrix_deep[0][1];
 if (@$reset) mysql_query("update users set banclicks='0', textclicks='0', lastresettime='".time()."' where id='$usid'");
 $lastresettime=db_result_to_array("select lastresettime from users where id='$usid'");
 $levelsaleam=db_result_to_array("select saleam from users where id='$usid'");
 $levelsaleqt=db_result_to_array("select saleqt from users where id='$usid'");
 $usclicks=db_result_to_array("select banclicks, textclicks from users where id='$usid'");
 $paid=db_result_to_array("select totalpaidamt, lastpaidamt, lastpaidtime from users where id='$usid'");

  $affs[0]=db_result_to_array("select id from users where referer='$usid'");
 for ($k=0; $k<6; $k++)
 {
  @$c=count($affs[$k]);
  $afflevel[$k]=$c;
  for ($i=0; $i<$c; $i++)
  {
   if (@$affs[$k+1])$t=count($affs[$k+1]); else $t=0;
   $affss=db_result_to_array("select id from users where referer='".$affs[$k][$i][0]."'");
   for ($j=0; $j<count($affss); $j++, $t++)
    $affs[$k+1][$t][0]=$affss[$j][0];
  }
 }
 @$c=count($affs[$k]);
 $afflevel[$k]=$c;

?>
<CENTER>
  <table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
      <td bgcolor="#FFFFFF"><h3 align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Current
          Overall Affiliate Statistics</font></h3>
        <P align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><A HREF="adtrack.php">Please
          view your ad tracking stats here</A></font></P>
        <div align="center">
          <table width="450" border="0">
            <tr>
              <td width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Total
                Banner Clicks:</font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                <?echo $usclicks[0][0];?> </b></font></td>
            </tr>
            <tr>
              <td width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Total
                Text Clicks:</font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                <?echo $usclicks[0][1];?> </b></font></td>
            </tr>
            <tr>
              <td colspan="2" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr>
              <td bgcolor="#EDF0F5"> <form method="post" action="affstats.php">
                  <font size="2" face="Arial, Helvetica, sans-serif">
                  <input type="hidden" name="reset" value=TRUE>
                  <input name="submit" type="submit" value="Reset Statistics" >
                  <br>
                  Note: This cannot be undone </font></form></td>
              <td valign="top" bgcolor="#DFE3E9"> <font size="2" face="Arial, Helvetica, sans-serif"><b>Stats
                Last Reset:
                <?if ($lastresettime[0][0]) echo date('Y-m-d', $lastresettime[0][0]); else echo "NEVER";?>
                </b></font></td>
            </tr>
            <tr>
              <td colspan="2" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr>
              <td width="180" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Your
                Sales :<br>
                </font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                <?echo $levelsaleqt[0][0];?> | $<?echo number_format($levelsaleam[0][0],2);?></b><br>
                (Number of sales|Amount Earned)</font></td>
            </tr>
            <tr>
              <td colspan="2" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
<?for ($l=1; $l<=$matrix_deep[0][0]; $l++){
          $current_level=db_result_to_array("select salesquant, salesamt from levels_sales where user_id=".$usid." and level_num=$l");
?>
            <tr>
              <td width="180" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Level
                <?echo $l?> Sales:<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--(currently <?echo $afflevel[0];?>
                affiliates)--></font> </td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><?if ($current_level[0]['salesquant']) echo $current_level[0]['salesquant']; else echo "0";?>
                | $<?echo number_format($current_level[0]['salesamt'],2);?></font></td>
            </tr>
<?}?>
            <tr>
              <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr>
              <td width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Total
                Balance Available:</font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif">
                          $<? echo number_format(calc_balance($usid), 2);?>
                </font></td>
            </tr>
            <tr>
              <td width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif">Total
                Amount Paid:</font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif">$<?echo number_format($paid[0][0],2);?></font></td>
            </tr>
            <tr>
              <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr>
              <td  width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif"><b>Last
                payment amount:</b></font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><b>$<?echo number_format($paid[0][1],2);?></b></font></td>
            </tr>
            <tr>
              <td  width="150" bgcolor="#EDF0F5"><font size="2" face="Arial, Helvetica, sans-serif"><b>Last
                payment date:</b></font></td>
              <td width="290" bgcolor="#DFE3E9"><font size="2" face="Arial, Helvetica, sans-serif"><b>
                <?if ($paid[0][2]) echo date('Y-m-d', $paid[0][2]); else echo "NEVER";?>
                </b></font></td>
            </tr>
            <tr>
              <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            </tr>
            <tr bgcolor="#EDF0F5">
              <td colspan="2"> <p><font size="2" face="Arial, Helvetica, sans-serif">Please
                  note that funds can only be sent out when your balance reaches
                  a minimum of $
                  <?$minbal=db_result_to_array("select minbal from admininfo"); echo $minbal[0][0];?>
                  </font></p></td>
            </tr>
          </table>
        </div>
        <form method="post" action="login.php">
          <div align="center">
            <input type="submit" name="Submit" value="Click here to return to Main Menu">
          </div>
        </form></td>
    </tr>
  </table>
  </CENTER>
<?
}

else
echo "Access denied";

include ('footer.php');

function find_matrix_users_on_level($id, $matrix_width, $level_num)//need to finish
{
 global $current_level_users;
 global $current_level;

 $childs=db_result_to_array("select user_id from matrix where parent_id=$id");
 $current_level_users+=count($childs);
 for ($i=0; $i<count($childs); $i++)
  find_matrix_users_on_level($childs[$i][0], $matrix_width, $level_num);
}
?>