<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache"); 
header("Content-type: text/html");

# get rid of those damns slashes after urlencoding
$add = stripslashes($add);
$addnow = stripslashes($addnow);
$remove = stripslashes($remove);
?>

<?
function currentTrack()
	{
	$fp = popen( "./playlist.pl current", "r" );
	$data = fgets($fp, 1024);
	pclose($fp);
	$data = chop($data);
	return $data;
	}	

function showInfo()
	{
	$fd = popen( "./playlist.pl info", "r" );
	$title = fgets($fd, 4096);
	$album = fgets($fd, 4096);
	$artist = fgets($fd, 4096);
	$year = fgets($fd, 4096);
	pclose($fd);

	if ($title=="\n" && $album=="\n" && $artist=="\n" && $year=="\n")
		{
		return;
		}
	echo '<center>';
	echo '<table bgcolor=#96aebc>';
        echo '<tr><td>';
        echo '<table bgcolor=#cee2ef>';

	if ($title!="")
		{
		echo '<tr><td>Title</td><td>' . $title . '</td></tr>';
		}
	if ($album!="")
		{
		echo '<tr><td>Album</td><td>' . $album . '</td></tr>';
		}
	if ($artist!="")
		{
		echo '<tr><td>Artist</td><td>' . $artist . '</td></tr>';
		}
	if ($year!="")
		{
		echo '<tr><td>Year</td><td>' . $year . '</td></tr>';
		}
	echo '</table>';
	echo '</td></td></table>';
	echo '</center>';
	}
?>

<html>
<body bgcolor=#ffffff>

<?
if (empty($information) && empty($tracks) && empty($remove) && empty($skip) && empty($randomise) && empty($playlist) && empty($nowlist))
	{
	echo '<center>';
	echo '<a href="index.php3?skip=1" target=main><img src="images/skip.png" border=0 alt="[Skip Track]"></a>';
	echo '<a href="index.php3?tracks=1" target=main><img src="images/add.png" border=0 alt="[Add Tracks]"></a>';
	echo '<a href="index.php3?playlist=1" target=main><img src="images/playlist.png" border=0  alt="[View Playlist]"></a>';
	echo '<a href="index.php3?nowlist=1" target=main><img src="images/reqlist.png" border=0 alt="[View Request List]"></a>';
	echo '<a href="index.php3?randomise=1" target=main><img src="images/random.png" border=0 alt="[Randomise Tracks]"></a>';
	echo '<a href="index.php3?information=1" target=main><img src="images/info.png" border=0 alt="[Information Summary]"></a>';
	echo '<a href="http://epic.world:8000"><img src="images/listen.png" border=0 alt="[Listen]"></a>';
	echo '</center>';
	}
else
	{
	echo '<center>';
	echo '<h1>';
	echo "Now Playing: " . ($current = currentTrack());
	echo '</h1>';
	echo '</center>';
	showInfo($current);
	}
?>

<?
function addTracks()
	{
	echo '<table bgcolor=#96aebc>';
	echo '<tr><td>';
	echo '<center><h2>Master List</h2></center>';
	echo '</td></tr>';
	echo '<tr><td>';
	echo '<table bgcolor=#cee2ef>';
	$fd = popen( "./playlist.pl listmaster", "r" );
	while ($data = fgets($fd, 4096))
		{
		$data = chop($data);
		echo '<tr>';

		echo '<td>';
		echo $data;
		echo '</td>';
	
		echo '<td>';
		echo '<a href=index.php3?addnow=' . urlencode($data) . ' target=menu>';
		echo 'Add to now list';
		echo '</a>';
		echo '</td>';

		echo '<td>';
		echo '<a href=index.php3?add=' . urlencode($data) . ' target=menu>';
		echo 'Add to playlist';
		echo '</a>';
		echo '</td>';

		echo '</tr>';
		}
	echo '</table>';
	echo '</td></td></table>';
	pclose($fd);
	}

function showPlaylist()
	{
	echo '<table bgcolor=#96aebc>';
        echo '<tr><td>';
        echo '<center><h2>Play List</h2></center>';
        echo '</td></tr>';
        echo '<tr><td>';
        echo '<table bgcolor=#cee2ef>';
	$fd = popen( "./playlist.pl list", "r" );
	while ($data = fgets($fd, 4096))
		{
		$data = chop($data);
		echo '<tr>';

		echo '<td>';
		echo $data;
		echo '</td>';
	
		echo '<td>';
		echo '<a href=index.php3?remove=' . urlencode($data) . '>';
		echo 'Remove from playlist';
		echo '</a>';
		echo '</td>';

		echo '</tr>';
		}
	echo '</table>';
	echo '</td></td></table>';
	pclose($fd);
	}

function showNowlist()
	{
	echo '<table bgcolor=#96aebc>';
        echo '<tr><td>';
        echo '<center><h2>Now List</h2></center>';
        echo '</td></tr>';
        echo '<tr><td>';
        echo '<table bgcolor=#cee2ef>';
	$fd = popen( "./playlist.pl listnow", "r" );
	while ($data = fgets($fd, 4096))
		{
		$data = chop($data);
		echo '<tr>';

		echo '<td>';
		echo $data;
		echo '</td>';
	
		echo '</tr>';
		}
	echo '</table>';
	echo '</td></td></table>';
	pclose($fd);
	}

?>



<?
if ($add != "")
	{
	$fp = popen( "./playlist.pl add", "w" );
	fputs($fp, $add."\n");
	pclose($fp);
#	addTracks();
	}
elseif ($addnow != "")
	{
	$fp = popen( "./playlist.pl addnow", "w" );
	fputs($fp, $addnow."\n");
	pclose($fp);
#	addTracks();
	}
elseif ($remove != "")
	{
	$fp = popen( "./playlist.pl remove", "w" );
	fputs($fp, $remove);
	pclose($fp);
	showNowlist();
	showPlaylist();
	}
elseif ($skip != "")
	{
	system('./playlist.pl skip');
	showPlaylist();
	}
elseif ($tracks != "")
	{
	addTracks();
	}
elseif ($playlist != "")
	{
	showPlaylist();
	}
elseif ($nowlist != "")
	{
	showNowlist();
	}
elseif ($randomise != "")
	{
	system('./playlist.pl randomise');
	showPlaylist();
	}
elseif ($information != "")
	{
	showNowlist();
	showPlaylist();
	}
?>

</body>
</html>

