<?
  session_start();

  // check session variable

  if (session_is_registered("valid_admin"))
  {
	  include "../../config.php"; 
	  include "../header.290";     
      echo "<p><font face=arial>
    
    	<a href=payout.php>Change Your Payout Amount</a><br>
    	View Click Throughs<br>
    	<a href=sales.php>View Sales</a><br>
    	<a href=banners.php>Add/Edit/Delete A Banner</a><br>
    	<a href=remove.php>Delete An Affiliate</a><br>
    	<a href=reward.php>Reward Affiliates</a><br>
    	<a href=contact.php>Contact Affiliates</a><br>";
    	
	echo "<form method=post action=changeclick.php>
  <table border=0 cellspacing=0 cellpadding=0>
    <tr align=center valign=middle> 
      <td width=200><font face=Arial, Helvetica, sans-serif>Show The Clickthrouhs 
        For:</font></td>
      <td width=70> 
        <select name=change>";
          
        mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error (line 28)"); 
  		$result = mysql_db_query($database, "select * from affiliates") or die ("Database INSERT Error"); 
		if (mysql_num_rows($result)) {
    	while ($qry = mysql_fetch_array($result)) {
      print "<option value=";
      print $qry[refid];
      print ">";
      print $qry[refid];
      print "</option>";
    }
    print "</select>";
  }

	echo "</td>
      <td width=50> 
        <p> 
          <input type=submit value=Show>
        </p>
        </td>
    </tr>
  </table>
</form>";
    	
  mysql_connect($server, $db_user, $db_pass) or die ("Database CONNECT Error (line 51)"); 
  $result = mysql_db_query($database, "select * from clickthroughs where refid = '$change' ORDER BY date and time") or die ("Database INSERT Error"); 
		
  print "<br><br><font face=arial>Clickthroughs From ";
  print $change;
  print " To Your Site: ";
  print mysql_num_rows($result);
  print "<br><br>";
  
  if (mysql_num_rows($result)) {
    print "<font face=arial><TABLE>";
    print "<TR><TH>Date</TH><TH>Time</TH>";
    print "<TH>Referrer URL</TH></TR>";
    while ($qry = mysql_fetch_array($result)) {
      print "<TR>";
      print "<TD><font size=2>";
      print $qry[date];
      print "</TD>";
      print "<TD><font size=2>";
      print $qry[time];
      print "</TD>";
      print "<TD><font size=2>";
      print $qry[refferalurl];
      print "</TD>";
      print "</TR>";
    }
    print "</TABLE>";
  }

  }

   else
  {
       include "../header.290"; 
    echo "<p>Only the administrator may see this page.</p>";
  }

     include "../footer.290"; 
?>
