<?
/*
 * gCards - a web-based eCard application
 * Copyright (C) 2003 Greg Neustaetter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
session_start();
session_unregister('imageid');
session_unregister('to_name');
session_unregister('to_email');
session_unregister('cardtext');

include_once('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
include_once('config.php');
include_once('inc/UIfunctions.php');

showHeader($siteName);

if (!$row) $row = 0;  // start on first row if a row is not selected
$limit = ($rowsPerPage * $cardsPerRow);  // set the number of cards per page

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$conn = &ADONewConnection('mysql');	# create a connection
$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);



// Get the total number of cards, or the number of cards in a category if a category is selected
$rowsInTableSQL = "SELECT COUNT(*) from cardinfo";
if ($catSearch) $numrows = $conn->GetOne("$rowsInTableSQL where catid = '$catSearch'");
else $numrows = $conn->GetOne($rowsInTableSQL);
// calculate the number of pages needed to show the cards
if (($numrows % $limit) == 0) 
	$pages = ($numrows/$limit);
else 
	$pages = intval($numrows/$limit) + 1;
$current = ($row/$limit) + 1;  // Current Page

$sqlstmt = 'select * from cardinfo';
if ($catSearch) $recordSet = &$conn->SelectLimit("$sqlstmt where catid = '$catSearch' order by imageid $order",$limit,$row );
	else $recordSet = &$conn->SelectLimit("$sqlstmt order by imageid $order",$limit,$row);
if (!$recordSet) print $conn->ErrorMsg();
?>


<table width="100%">
	<tr>
		<td align="left" valign="top" width="200">
			<? include('inc/getcategories.php');  // show the eCard Categories ?>
		</td>
		<td>
			<table cellpadding="5">
				<tr>
					<td class="subtitle">
						<? 
						if ($selectedCategory) echo $selectedCategory;
						else echo "All Categories";
						?>
					</td>
				</tr>
				<tr>
					<td>
						Choose a card below to start!<br><br>
					</td>
				</tr>
			</table>
<?
if ($recordSet)
	{
		$numCards = $recordSet->RecordCount();
		$cardCount = 0;
		echo "<table cellpadding=\"5\" cellspacing=\"5\">\n\t<tr>";
		while (!$recordSet->EOF) 
			{
				$imageid = $recordSet->fields[imageid];
				$cardname = $recordSet->fields[cardname];
				$thumbpath = rawurlencode($recordSet->fields[thumbpath]);
				if ((($cardCount % $cardsPerRow) == 0) && (!($cardCount == 0))) echo "\n\t</tr>\n\t<tr>";
				echo "\n\t\t<td align=\"center\" bgcolor=\"white\">\n\t\t\t<a href=\"compose.php?imageid=$imageid\"><img src=\"images/$thumbpath\" border=\"0\"></a><br>\n\t\t\t$cardname\n\t\t</td>";
				$recordSet->MoveNext();
				$cardCount++;
			}
		$emptyCells = ($cardsPerRow - ($numCards % $cardsPerRow));
		for ($i=0; $i < $emptyCells; $i++) echo "\n\t\t<td>&nbsp;</td>";
		echo "\n\t</tr>\n</table>";
	}
	
$recordSet->Close(); # optional
echo "<tr><td>&nbsp;</td><td><br>";

echo "</td></tr>";
if (!($pages == 1))
{
echo "<tr><td>&nbsp;</td><td>";
if ($row != 0) {  // if not the first page create back link with record set 1 page back (record - limit)
	$backPage = $row - $limit;  
	echo "<a href='$PHP_SELF?row=$backPage&catSearch=$catSearch'>Back</a>&nbsp;&nbsp; \n";}
for ($i=1; $i <= $pages; $i++) {  
	$ppage = $limit*($i - 1);  // ppage is record at a certain page
	if ($ppage == $row){
		echo "<b>$i</b>&nbsp;&nbsp; \n";}  // if current page just show page number
	else {
		echo "<a href='$PHP_SELF?row=$ppage&catSearch=$catSearch'>$i</a>&nbsp;&nbsp; \n";}}  // else show link to page number
if ($current < $pages) { // Give next link if not last page
	$nextPage = $row + $limit;
	echo("<a href='$PHP_SELF?row=$nextPage&catSearch=$catSearch'>Next</a>");}
echo "</td></tr>";
}

?>
		</td>
	</tr>
</table>
<?



$currentTime = time();
$timeToSeconds = ($deleteDays * 24 * 60 * 60);
$deletePriorTime = $currentTime - $timeToSeconds;
$deleteCardsSQL = "DELETE FROM sentcards WHERE cardid < $deletePriorTime";
$conn->Execute($deleteCardsSQL);
	
$conn->Close(); # optional
showFooter();


?>                    