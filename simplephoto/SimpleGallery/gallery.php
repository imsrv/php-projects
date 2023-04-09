<?
#########################################################
# Simple Gallery                                        #
#########################################################
#                                                       #
# Created by: Doni Ronquillo                            #
#                                                       #
# This script and all included functions, images,       #
# and documentation are copyright 2003                  #
# free-php.net (http://free-php.net) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
#########################################################

    session_start();

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    
		include("inc/config.php");
		include("inc/header.php");

        $cid = $_REQUEST['cid'];
        $thisOffset = $_REQUEST['thisOffset'];
        $lineIndex  = $_REQUEST['lineIndex'];

        $sql3="select * from freephp_gallery_category where id='$cid'";
        $query3 = mysql_query($sql3);
		$result3=mysql_fetch_assoc($query3);

		echo "<B>$result3[title]</B><br>";


		echo "<BR>";

    	$sql2="select * from freephp_gallery_category where parent='$cid' ORDER BY title";
    	$query2 = mysql_query($sql2);

		while ($result2=mysql_fetch_assoc($query2)) {

   		$catsres = mysql_query("select * from freephp_gallery where category = '$result2[id]'");
		$count=mysql_num_rows($catsres);

		echo "&nbsp;&nbsp;<img src='images/folder.gif' alt='' border=0> <a href='gallery.php?cid=$result2[id]'>$result2[title] [$count]</a><br>";

		}

echo "<BR>";

$recordLimit= 12;
$prevLink         = "<< Previous";
$nextLink         = "Next >>";

function pageStatus($i){ echo " Click to View Page $i"; }

if (!isset($thisOffset) || $thisOffset < 0) $thisOffset=0;
if ($action==search) $thisOffset = $thisOffset - 1;
if (!isset($lineIndex) || $lineIndex < 0) $lineIndex=0;
if ($action==search) $lineIndex = $lineIndex - 1;

        $sql="select * from freephp_gallery where category='$cid' ORDER BY id DESC";
        $getTotalRows = mysql_query($sql);
        $totalRowsNum = mysql_num_rows($getTotalRows);
        $sql.=" Limit $thisOffset,$recordLimit";
        $query = mysql_query($sql);

        // set the counter for the table split...
        $count = 1;

	while ($result=mysql_fetch_assoc($query)){


        $lineIndex++;




if ($count == 1) {

// the beginning cell
$table_print .= <<<TABLE_PRINT

<TR><TD Valign=top>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100 align=center>
<TR><TD valign=top width=100><div align=center><A HREF="preview.php?id=$result[id]"><IMG SRC="images/thumbs/$result[id].jpg"></a></DIV></TD></TR>
</TABLE>

</TD>

TABLE_PRINT;

} elseif ($count == 2) {

// echo code for middle cell
$table_print .= <<<TABLE_PRINT

<TD Valign=top>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100 align=center>
<TR><TD valign=top width=100><div align=center><A HREF="preview.php?id=$result[id]"><IMG SRC="images/thumbs/$result[id].jpg"></a></DIV></TD></TR>
</TABLE>

</TD>

TABLE_PRINT;

} elseif ($count  == 3) {

//ech code for end cell, in </TR>
$table_print .= <<<TABLE_PRINT

<TD Valign=top>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100 align=center>
<TR><TD valign=top width=100><div align=center><A HREF="preview.php?id=$result[id]"><IMG SRC="images/thumbs/$result[id].jpg"></a></DIV></TD></TR>
</TABLE>


</TD></TR>

TABLE_PRINT;

$count = 0;

}



$count++;

}

echo <<<TABLE_BEGIN

<TABLE BORDER=0 width=95% align=center>

TABLE_BEGIN;

echo $table_print;

echo <<<TABLE_END

</TABLE><BR>

TABLE_END;



if ($totalRowsNum <= $recordLimit) {
// less than recordLimit returned.
} else {

if ($thisOffset!=0) { $prevOffset = intval($thisOffset-$recordLimit);
echo "<a href=\"$PHP_SELF?cid=$cid&thisOffset=$prevOffset&lineIndex=$prevOffset\">$prevLink</a>&nbsp;";
}
else { echo "$prevLink&nbsp;";
}

$totalPages = intval($totalRowsNum/$recordLimit);

if ($totalRowsNum%$recordLimit) $totalPages++;
for ($i=1;$i<=$totalPages;$i++) {
if ((intval($thisOffset/$recordLimit)) == (intval($i-1))) {

echo "&nbsp;$i&nbsp;";

} else {

$nextOffset= intval($recordLimit*($i-1));

echo "&nbsp;<a";
                   pageStatus($i);
echo " href=\"$PHP_SELF?cid=$cid&thisOffset=$nextOffset&lineIndex=$nextOffset\">$i</a>&nbsp;";
}
}

if (!(intval(((intval($thisOffset/$recordLimit))+1))==$totalPages) && $totalPages!=1) {
$nextOffset = intval($thisOffset+$recordLimit);

echo "&nbsp;<a href=\"$PHP_SELF?cid=$cid&thisOffset=$nextOffset&lineIndex=$nextOffset\">$nextLink</a><p>\n";
}
else echo "&nbsp;$nextLink<p>";
}



 	include("inc/footer.php");

?>