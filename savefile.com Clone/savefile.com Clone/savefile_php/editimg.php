<?
	include("include/common.php");

	if(!$loggedin){
		ob_start();
		header("Location: login.php");
	}
	include("include/header.php");
	include("include/accmenu.php");
	if($del){
		$sql = "SELECT * FROM images25 WHERE id='$del'";
		$qr1 = mysql_query($sql);
		$row = mysql_fetch_object($qr1);
		if( file_exists($att_path."/".$row->filename)	){
			unlink($att_path."/".$row->filename);
		}
		mysql_query("DELETE FROM images25 WHERE id='$del'");
	}

	$limit = 10;
?>
	<script>
		function gotocluster(s){
			var d = s.options[s.selectedIndex].value
			self.location.href=d;
		}
	</script>
<?
	if (!$start_m){
		$starttime = time();
		$start_y = date("Y",$starttime);
		$start_d = date("d",$starttime);
		$start_m = date("m",$starttime);
	}
	if (!$end_m){
		$endtime = time();
		$end_y = date("Y",$endtime);
		$end_d = date("d",$endtime);
		$end_m = date("m",$endtime);
	}
?>
	<h3>Manage Your Uploads</h3>
	<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<form method="POST">
<?
			$sql = "SELECT * FROM images25 WHERE user='$myuid'";
			$qr1 = mysql_query($sql);
			$rowcount = mysql_num_rows($qr1);
			$pagecount = ceil($rowcount / $limit);
			print "<table width=100%><td>Page No: " . ($pageno+1) ."</td><td align=right>
						<select onChange=\"gotocluster(this)\">\n
						<option>Select A Page</option>";
			for($x=0; $x<$pagecount; $x++){
				$p = $x + 1;
				$l = $x * $limit + 1;
				$u = $l + $limit - 1;
				if($u>$rowcount) $u=$rowcount;
				print "<option value='editimg.php?pageno=".$x."'>Page $p ($l - $u)</option>\n";
			}
			print "</select></td></table>";
			$l = $pageno * $limit;
			$u = $l + $limit-1;
			$count = -1;
			$i = 1;
			$domCount = 0;
			while( $a = mysql_fetch_object($qr1) ){
				$count++;
				$row = ($count % 2)+1;
				if ($limit && $count < $l ) continue;
				if($limit && $count > $u) continue;
				$filen = $siteurl."/".str_replace('./', '', $att_path)."/".$a->filename;
				$filen = str_replace('http://','%%',$filen);
				$filen = str_replace('//','/',$filen);
				$filen = str_replace('%%','http://',$filen);
				if( file_exists($att_path."/".$a->filename)	){
					echo "<a href='$filen' target='_new'><img src='$filen' width=100 height=100 border=0></a><br>";
				}else{
					echo "no image found<br>";
				}
				echo "<a href='getcode.php?img=".$a->id."'>get code</a> | ";
				echo "<a href='editimg.php?pageno=".$pageno."&del=".$a->id."'>delete</a><br>";
			}
			print "<table width=100%><td>Page No: " . ($pageno+1) ."</td><td align=right>
						<select onChange=\"gotocluster(this)\">\n
						<option>Select A Page</option>";
			for($x=0; $x<$pagecount; $x++){
				$p = $x + 1;
				$l = $x * $limit + 1;
				$u = $l + $limit - 1;
				if($u>$rowcount) $u=$rowcount;
				print "<option value='editimg.php?pageno=".$x."'>Page $p ($l - $u)</option>\n";
			}
			print "</select></td></table>";
?>
			</form>
		</td>
	</tr>
	</table>
<?	include("include/footer.php");	?>