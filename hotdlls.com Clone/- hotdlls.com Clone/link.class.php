<?php

class linker extends config {

  function linkform($act, $err="", $ll="") {
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\"><form action=\"$act\" method=\"POST\">
<tr><td class=\"form2\"><b>Username:</b></td><td><input type=\"text\" class=\"form\" size=\"30\" name=\"ll[user]\" value=\"$ll[user]\">$err[user]</td></tr>
<tr><td class=\"form2\"><b>Password:</b></td><td><input type=\"password\" class=\"form\" size=\"30\" name=\"ll[pass]\" value=\"$ll[pass]\">$err[pass]</td></tr>
<tr><td class=\"form2\"><b>Site Name:</b></td><td><input type=\"text\" class=\"form\" size=\"30\" name=\"ll[title]\" value=\"$ll[title]\">$err[title]</td></tr>
<tr><td class=\"form2\"><b>Url:</b></td><td><input type=\"text\" class=\"form\" size=\"30\" name=\"ll[url]\" value=\"$ll[url]\">$err[url]<td></tr>
<tr><td class=\"form2\"><b>E-mail:</b></td><td><input type=\"text\" class=\"form\" size=\"30\" name=\"ll[email]\" value=\"$ll[email]\">$err[email]</td></tr>
<tr><td></td><td><input type=\"Submit\" class=\"form\" value=\"Join Link-Exchange\"></td></tr></table>";
  }

  function stats() {
    echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#212C3B\"><tr style=\"color:#FFFFFF;\" align=\"center\">
<td>Edit</td><td>Name</td><td>Url</td><td>In</td><td>Out</td><td>Ratio</td></tr>\n";
    $get = mysql_query("SELECT * FROM $this->mysql_tb_le ORDER BY inn DESC");
    while ($row = mysql_fetch_array($get)) {
    echo "<tr bgcolor=\"#FFFFFF\"><td><a href=\"admin.php?go=link&s=stats&id=$row[id]\">Edit</a></td><td>$row[title]</td>
<td><a href=\"$row[url]\" target=\"_blank\">$row[url]<a></td><td>$row[inn]</td><td>$row[ut]</td><td>".@round($row[inn]/$row[ut], 2)."</td></tr>\n";
    }
    echo "</table><br><br><b>Linkstats resets every 24 hours!</b>";
  }

  function add() {
    global $ll;
    $loc = "admin.php?go=link&s=add";
    $err = array();
    $stand  = "<font size=1 color=#FF0000>&nbsp; <b>";

    if (!$ll)
      $this->linkform($loc);
    elseif ($ll && (!$ll[user] || !$ll[pass] || !$ll[url] || !$ll[email])) {
      if (!$ll[user])
        $err[user] = $stand."you must enter a username!";
      if (!$ll[pass])
        $err[pass] = $stand."you must enter a password!";
      if (!$ll[url])
        $err[url] = $stand."what is your url?";
      if (!$ll[title])
        $err[title] = $stand."what is your site called?";
      if (!$ll[email] || !$this->checkmail($ll[email]))
        $err[email] = $stand."what is your email?";

      $this->linkform($loc, $err, $ll);
    } elseif (@mysql_query("INSERT INTO $this->mysql_tb_le (id,pass,title,url,email) VALUES ('$ll[user]',password('$ll[pass]'),'$ll[title]','$ll[url]','$ll[email]')")) {

      echo "<b>Welcome to our link-exchange</b><br><br>To start sending hits and get huge traffic back link to:<br>
http://localhost/in.php?id=$ll[user]<br><br><b>This Information has been emailed you!</b><br><br>
      <b>Username:</b> $ll[user]<br>
      <b>Password:</b> $ll[pass]<br>
      <b>Site Name:</b> $ll[title]<br>
      <b>Url:</b> $ll[url]<br>
      <b>E-mail:</b> $ll[email]<br>";
    } else {
      $err[user] = $stand."username allready taken!";
      $this->linkform($loc, $err, $ll);
    }
  }

  function checkmail($email) {
    $exp = explode("@", $email);
    if ($exp[1] && !$exp[2]) {
      $ext = explode(".", $exp[1]);
      if ($ext[1])
        return true;
      else
        return false;
    } else
      return false;
  }

  function edit($id) {
    global $le;
    $get = mysql_query("SELECT * FROM $this->mysql_tb_le WHERE id = '$id'");
    $row = mysql_fetch_array($get);
    $s[$row[support]] = " selected";
    if (!$le) {
    echo "<table border=\"0\" cellspacing=\"2\" cellpadding=\"1\"><form name=\"link\" action=\"admin.php?go=link&s=stats&id=$id\" method=\"POST\">
<tr><td class=\"form2\">Id: </td><td class=\"form\">$row[id]</td></tr>
<tr><td class=\"form2\">Name: </td><td><input type=\"text\" name=\"le[title]\" value=\"$row[title]\" class=\"form\" size=\"30\"></td></tr>
<tr><td class=\"form2\">Url: </td><td><input type=\"text\" name=\"le[url]\" value=\"$row[url]\" class=\"form\" size=\"30\"></td></tr>
<tr><td class=\"form2\">E-mail: </td><td><input type=\"text\" name=\"le[email]\" value=\"$row[email]\" class=\"form\" size=\"30\"></td></tr>
<tr><td class=\"form2\">In: </td><td><input type=\"text\" name=\"le[inn]\" value=\"$row[inn]\" size=\"3\" class=\"form\"></td></tr>
<tr><td class=\"form2\">Out: </td><td><input type=\"text\" name=\"le[ut]\" value=\"$row[ut]\" size=\"3\" class=\"form\"></td></tr>
<tr><td class=\"form2\">Support: </td><td><select name=\"le[sup]\" class=\"form\" size=\"1\">
<option value=\"0\"$s[0]>0</option><option value=\"1\"$s[1]>1</option><option value=\"2\"$s[2]>2</option>
<option value=\"3\"$s[3]>3</option><option value=\"4\"$s[4]>4</option><option value=\"5\">$s[5]5</option>
<option value=\"6\"$s[6]>6</option><option value=\"7\"$s[7]>7</option><option value=\"8\"$s[8]>8</option>
<option value=\"9\"$s[9]>9</option><option value=\"10\"$s[10]>10</option></select></td></tr>
<tr><td class=\"form2\">Delete? </td><td class=\"form\"><input type=\"checkbox\" name=\"le[del]\" value=\"ja\"> check to delete</td></tr>
<tr><td></td><td><input type=\"Submit\" value=\"Update!\" class=\"form\"></td></tr></form></table>";
    } elseif (!$le[del]) {
      mysql_query("UPDATE $this->mysql_tb_le SET title='$le[title]',url='$le[url]',inn='$le[inn]',ut='$le[ut]',support='$le[sup]',email='$le[email]' WHERE id = '$id'");
      echo "<b>Updated!</b><br><br><a href=\"admin.php?go=link&s=stats&id=$id\">back to edit</a><br>
      <a href=\"admin.php?go=link&s=stats\">back to link list</a>";
    } else {
      mysql_query("DELETE FROM $this->mysql_tb_le WHERE id = '$id'");
      echo "<b>Updated!</b><br><br><a href=\"admin.php?go=link&s=stats\">back to link list</a>";
    }
  }

  function get($number="5", $max="20", $start="0") {
    $file = @file("dato.txt");
    $datoen = $this->dato();
    if ($file[0] != $datoen) {
      $fp = @fopen("dato.txt", "w");
      @fputs($fp, $datoen);
      @fclose($fp);
      mysql_query("UPDATE $this->mysql_tb_le SET inn=0, ut=0, supports=0");
    }
    #$number++;
    $get = mysql_query("SELECT * FROM $this->mysql_tb_le WHERE inn > 0 ORDER BY inn DESC LIMIT $start,$max");
    $i = 1;
    $ii = 0;
    echo "
<table>
  <td>";

    /*while ($row = mysql_fetch_array($get)) {
      if ($ii == $number)
        echo "</td>";
      if ($i != $max-$number && $ii == ($max/$number)-1)*/

    while($row = mysql_fetch_array($get)) {
      if ($ii == $number) {
        echo "</td>";
        $ii = 1;
      } else
        $ii++;
      if ($ii == 1 && $ii != $max && $i>1)
        echo "<td>";

      echo "<font color=\"blue\"><B>$i.&nbsp;</font><a href=\"ut.php?id=$row[id]\" target=\"_blank\" onMouseOver=\"window.status='Visit $row[title]'; return true\" onMouseOut=\"window.status='HotDDLs.com'\">$row[title]</a></b><br>\n";
      $i++;
    }

    while ($max >= $i) {
      if ($ii == $number) {
        echo "</td>";
        $ii = 1;
      } else
        $ii++;
      if ($ii == 1 && $ii != $max)
        echo "<td>";

      echo "<font color=\"blue\"><i>$i.</font> <a href=\"join.php\" target=\"_blank\">Your Site Here?</a></i><br>\n";
      $i++;
    }
  }
}
?>