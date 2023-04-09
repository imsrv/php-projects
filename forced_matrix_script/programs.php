<?
/* nulled by [GTT] :) */    

include("functions.php");

db_connect();

$query_progs = "SELECT * FROM programs, aff_payments where aff_payments.programid=programs.id";

$progs = mysql_query($query_progs) or die(mysql_error());

$row_progs = mysql_fetch_assoc($progs);

$totalRows_progs = mysql_num_rows($progs);

?>

<? include ('header.php'); ?>
<table width="788" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="9%" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td width="81%" nowrap bgcolor="#CED3E3"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Programs
            avialiable for purchase&nbsp; </font><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></td>
          <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            <?php do { ?>
            <strong><?php echo $row_progs['title']; ?></strong> <br>
            <em><?php echo $row_progs['description']; ?></em><br>
            <font color="#0D004C">Price: $<?php echo number_format($row_progs['price'],2); ?></font><br>
            <br>
            <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
            </font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td bgcolor="#CED3E3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
      </table>
      <br>
      <br>
      <?

$query_progs = "SELECT * FROM aff_payments where programid=0 and subscrid=0";

$progs = mysql_query($query_progs) or die(mysql_error());

$row_progs = mysql_fetch_assoc($progs);

$totalRows_progs = mysql_num_rows($progs);

?>
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="9%" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td width="81%" nowrap bgcolor="#CED3E3"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Single
            Items avialiable for purchase&nbsp; </font><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></td>
          <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            <?php do { ?>
            <strong><?php echo $row_progs['name']; ?></strong> <br>
            <em><?php echo $row_progs['description']; ?></em><br>
            <font color="#0D004C">Price: $<?php echo number_format($row_progs['price'],2); ?></font><br>
            <br>
            <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
            </font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td bgcolor="#CED3E3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
      </table>
      <br>
      <br>
      <?

$query_progs = "SELECT * FROM subscribtions, aff_payments where aff_payments.subscrid=subscribtions.id";

$progs = mysql_query($query_progs) or die(mysql_error());

$row_progs = mysql_fetch_assoc($progs);

$totalRows_progs = mysql_num_rows($progs);

?>
      <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td width="9%" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td width="81%" nowrap bgcolor="#CED3E3"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;Single
            Items avialiable for purchase&nbsp; </font><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            </font></td>
          <td width="10%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
            <?php do { ?>
            <strong><?php echo $row_progs['name']; ?></strong> <br>
            <em><?php echo $row_progs['description']; ?></em><br>
            <font color="#0D004C">Sign up free: $<?php echo number_format($row_progs['signupfee'],2); ?></font><br>
            <font color="#0D004C">Duration: <?php echo $row_progs['duration']; ?>
            days</font><br>
            <font color="#0D004C">Re-occuringfee: $<?php echo number_format($row_progs['reoccuringfee'],2); ?></font><br>
            <br>
            <?php } while ($row_progs = mysql_fetch_assoc($progs)); ?>
            </font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
        <tr>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td bgcolor="#CED3E3"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
        </tr>
      </table></td>
  </tr>
</table>
<? include ('footer.php'); ?>
</body>

</html>

<?php

mysql_free_result($progs);

?>
