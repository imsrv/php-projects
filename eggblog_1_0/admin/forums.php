<?php
require_once("header.php");
echo "		<h2>Forum topics ...</h2>\n";
if (isset($_SESSION[eggblog])) {
  if ($_SESSION[eggblog] == $eggblog_forum_mods) {
    if (!isset($_GET[i])) {
      $i=0;
    }
    else {
      $i = $_GET[i];
    }
    $count=mysql_result(mysql_query("SELECT count(*) FROM eggblog_forum_topics"),0);
    $from=$i+1;
    $to=$i+10;
    if ($to > $count) {
      $to=$count;
    }
    if ($count == 0) {
      echo "		<p>There are currently <b>no topics</b> in the forum.</p>\n";
    }
    else {
      echo "		<p>Showing topics <b>$from</b> to <b>$to</b> with the most recently active topic listed first:</p>\n";
      $sql="SELECT id, name FROM eggblog_forum_topics ORDER BY name LIMIT $i,$eggblog_forum_index";
      $result=mysql_query($sql);
      $previous=$i-$eggblog_forum_index;
      $next=$i+$eggblog_forum_index;
      while ($row=mysql_fetch_array($result)) {
        echo "		<p><a href=\"posts.php?id=$row[id]\" style=\"font-size:125%; font-weight:bold;\">$row[name]</a><br /><a href=\"topics.php?edit=$row[id]\">edit</a> | <a href=\"topics.php?delete=$row[id]\">delete</a></p>\n";
      }
    }
    echo "		<table width=\"100%\" summary=\"Forum navigation\">\n			<tr><td width=\"20%\" align=\"left\">";
    if ($i >= $eggblog_forum_index) {
      echo "<a href=\"forums.php?i=$previous\">previous page</a>";
    }
    echo "</td><td width=\"60%\" align=\"center\"> pages: ";
    $ii=0;
    $iii=$count/$eggblog_forum_index;
    while ($ii < $iii) {
      $page=$ii*$eggblog_forum_index;
      if ($page < $count) {
        $ii++;
        echo "<a href=\"forums.php?i=$page\">$ii</a>&nbsp; ";
      }
      else {
        $ii=$eggblog_forum_index;
      }
    }
    echo "</td><td width=\"20%\" align=\"right\">";
    if ($next < $count) {
      echo "<a href=\"forums.php?i=$next\">next</a>";
    }
    echo "</td></tr>\n		</table>\n";
  }
  else {
    echo "		<p><b>You are not authorised to view the administration area of the blog.</b></p>\n";
  }
}
else {
  require_once("../_etc/login_form.php");
}
require_once("footer.php");
?>