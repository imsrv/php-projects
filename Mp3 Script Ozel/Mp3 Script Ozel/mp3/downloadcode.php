<?php 

												$id = $_GET['id'];
												include("config.php");
												mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
												mysql_select_db($db_name) or die(mysql_error());
												$result = mysql_query("SELECT * FROM mp3 WHERE id LIKE '$id'");
												while($r=mysql_fetch_array($result))
												{
												$album=$r["album"];
												$date=$r["date"];
												$artist=$r["artist"];
												$id=$r["id"];
												$img=$r["img"];
												$text1=$r["text1"];
												$link1=$r["link1"];	
												$text2=$r["text2"];	
												$link2=$r["link2"];				
												$text3=$r["text3"];
												$link3=$r["link3"];
												$text4=$r["text4"];
												$link4=$r["link4"];
												$text5=$r["text5"];
												$link5=$r["link5"];
												$text6=$r["text6"];
												$link6=$r["link6"];
												$text7=$r["text7"];
												$link7=$r["link7"];
												$text8=$r["text8"];
												$link8=$r["link8"];
												$text9=$r["text9"];
												$link9=$r["link9"];
												$text10=$r["text10"];
												$link10=$r["link10"];
												$link11=$r["link11"];
												$text11=$r["text11"];
												$link12=$r["link12"];
												$text12=$r["text12"];
												$link13=$r["link13"];
												$text13=$r["text13"];
												$link14=$r["link14"];
												$text14=$r["text14"];
												$link15=$r["link15"];
												$text15=$r["text15"];


echo '<table width="391" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>';
    echo '<td width="391" height="203" valign="top"><div align="center">';
      echo "<p><img border='0' src='"; if ($img=="") { echo "images/score_70.gif"; } else { echo "$img"; } echo"' width='70' height='60'></p>";
      echo '<p>$artist;</p>';
      echo '<div align="left"> Album: $album<br>';
        echo 'Added Date: $date<br>';
       echo 'Songs:<br>
        1.  <a href="$link1">$text1</a> <br>
        2. <a href="$link2">$text2</a><br>
        3. <a href="$link3">$text3</a><br>
        4. <a href="$link4">$text4</a><br>
        5. <a href="$link5">$text5</a><br>
        6. <a href="$link6">$text6</a><br>
        7. <a href="$link7">$text7</a><br>
        8. <a href="$link8">$text8</a><br>
        9. <a href="$link9">$text9</a><br>
        10. <a href="$link10">$text10</a><br>
        11. <a href="$link11">$text11</a><br>
        12. <a href="$link12">$text12</a><br>
        13. <a href="$link13">$text13</a><br>
        14. <a href="$link14">$text14</a><br>
        15. <a href="$link15">$text15</a><br>';
      echo '</div></div></td>';
  echo '</tr>';
echo '</table>';
}
?>
<?php mysql_close(); ?>