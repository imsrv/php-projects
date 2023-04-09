<?php
require "../_etc/header.php";

if (isset($_POST[q])){
  echo "		<h2>search results</h2>\n";
  $q = str_replace("\\","",$_POST[q]);
  $q_backup = $q;
  $q_html = str_replace("\"", "&quot;", $q);
  preg_match_all("/\"(.+?)\"/i", $q, $phrase);
  $count_phrase = count($phrase[1]);
  $p=0;
  while ($p < $count_phrase) {
    $keyword = str_replace($phrase[1][$p]. " ", "", $q);
    $keyword = str_replace($phrase[1][$p], "", $q);
    $p++;
  }
  $q = str_replace("\"", "", $q);
  $q = str_replace("  ", " ", $q);
  $qarray = explode(" ", $q);
  $wordarray = array_merge($phrase[1], $qarray);
  $numterms = count($wordarray);
  $banlist = array("a", "the", "for", "of", "an", "and", "or", "in");
  $structure = "AND";
  $looped = false;
  for ($z = 0; $z < $numterms; $z++) {
    if (!in_array($wordarray[$z], $banlist)) {
      if ($looped) {
        $filter .= " $structure (title LIKE '%".$wordarray[$z]."%' OR intro LIKE '%".$wordarray[$z]."%' OR details LIKE '%".$wordarray[$z]."%')";
      }
      else  {
        $filter = " WHERE (title LIKE '%".$wordarray[$z]."%' OR intro LIKE '%".$wordarray[$z]."%' OR details LIKE '%".$wordarray[$z]."%')";
        $looped = true;
      }
    }
  }
  $sql = "SELECT id, date, title FROM eggblog_articles" .$filter. " ORDER BY date DESC";
  $result=mysql_query($sql);
  $total=mysql_num_rows($result);
  echo "		<p><b>$total matches were found for</b> $q_html</p>\n";

  if ($total != 0) {
    echo "		<table>\n";
    while($row=mysql_fetch_array($result))  {
      $date=date("d M Y",$row[date]);
      $title=$row[title];
      echo "			<tr>
				<td>$date</td>
				<td><a href=\"blog.php?id=$row[id]\">$title</a></td>
			</tr>\n";
    }
    echo "		</table>\n";
  }
}
else {
  echo "		<p><b>Search all the articles using the keyword search below</b>.</p>
		<p>Enhance the results by using exact matching using quote marks &quot;s.</p>\n\n";
}
echo "		<form action=\"search.php\" method=\"post\">
			<p>Keyword: <input type=\"text\" name=\"q\" size=\"30\" value=\"$q_html\" /> <input type=\"submit\" name=\"submit\" value=\"Submit\" /></p>
		</form>\n";
require "../_etc/footer.php";
?>