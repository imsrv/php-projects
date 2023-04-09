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
require("admin/backup_info.php");

$filename = $bkp_path.$_POST['restore'];
if ($_POST['restore'] && @file_exists($filename))
{
  $f = gzopen($filename, "r");
  $max = 65536;
  while (list($k,$table) = each($tables))
  {
    $line = gzgets($f, $max);
    $keys = explode(chr(1), $line);

    $fields = sizeof($keys) - 1;
    unset($wh);
    for ($i = 0; $i < $fields; $i++)
      $wh[] = $keys[$i];
    $sql = "INSERT INTO $table(".implode(",", $wh).") VALUES";
    mysql_query("DELETE FROM $table");
    
    $line = gzgets($f, $max);
    $num = (int)$line;
    $c = $ce = 0;
    for ($i = 0; $i < $num; $i++)
    {
      $line = rtrim(gzgets($f, $max));
      $line = str_replace(array(chr(2),chr(3)), array("\r","\n"), $line);
      $v = explode(chr(1), addslashes($line));
      mysql_query($sql."('".implode("','", $v)."')");
      if (mysql_errno())
        $ce++;
      else
        $c++;
    }
    echo "Restoring table <b>$table</b>: $c of ",($c+$ce)," records successful...<br>";
    flush();
    
    set_time_limit(30);
  }
  
  $config = "";
  while ( !gzeof($f) ){
	$config .= gzgets($f, $max);
  }
  $configa = explode("@!%!@",$config);
  $config1 = $configa[0];
  $config2 = $configa[1];
  echo "Restoring config.php file...<br>";
  $f2 = fopen("config.php", "w");
  if ($f)
  {
    fwrite($f2, $config1);
    fclose($f2);
  }
  else
    echo "<div class=error>Check write permissions for file <b>config.php</b></div><br>";
  echo "Restoring config2.php file...<br>";
  $f2a = fopen("config2.php", "w");
  if ($f)
  {
    fwrite($f2a, $config2);
    fclose($f2a);
  }
  else
    echo "<div class=error>Check write permissions for file <b>config.php</b></div><br>";
  
  gzclose($f);
  echo "The database was restored.";
  exit;
}

while (list($k,$table) = each($tables))
{
  list($num) = mysql_fetch_row(mysql_query("SELECT COUNT(*) FROM $table"));
  echo "Table <b>$table</b> has <b>$num</b> records<br>";
}
?>
<br>!!! Restoring will delete all current data !!!<br>
<form method=post>
<select name=restore>
  <option value="">Select a file to restore data from
  <?
    if ($dir = @opendir($bkp_path)) 
    {
      while (($file = readdir($dir)) !== false)
        if (substr($file, -3) == ".gz")
          echo "<option>$file</option>";
      closedir($dir);
    }
  ?>
</select>
<input type=submit class=button value="Restore Database >>">

<?=$id_post?>
</form>

