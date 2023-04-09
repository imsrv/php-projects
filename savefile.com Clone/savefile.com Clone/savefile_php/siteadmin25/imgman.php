<?
	chdir("..");
	include("include/common.php");
	include("siteadmin25/accesscontrol.php");
	include("siteadmin25/header.php");
?>
<?
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
	<form method="POST">
	<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td><p>date :</p></td>
		<td nowrap>
		<!-- add writecombo date here -->
			<? WriteCombo($month_values, "start_m",$start_m);?>
			/
			<? WriteCombo($day_values, "start_d",$start_d);?>
			/
			<input name="start_y" type="text" size="4" maxlength="4" value="<?=$start_y?>">
			 -to- <? WriteCombo($month_values, "end_m",$end_m);?>
			/
			<? WriteCombo($day_values, "end_d",$end_d);?>
			/
			<input name="end_y" type="text" size="4" maxlength="4" value="<?=$end_y?>">
		</td>
		<td align="right"><input type="submit" name="report" value="  view report  "></td>
	</tr>
	</table>
	</form>
	<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<form method="POST">
			<input type='hidden' name='start_m' value='<?=$start_m?>'>
			<input type='hidden' name='start_d' value='<?=$start_d?>'>
			<input type='hidden' name='start_y' value='<?=$start_y?>'>
			<input type='hidden' name='end_m' value='<?=$end_m?>'>
			<input type='hidden' name='end_d' value='<?=$end_d?>'>
			<input type='hidden' name='end_y' value='<?=$end_y?>'>
<?
		if($report){
			$stime = mktime(0,0,0,$start_m,$start_d,$start_y);
			$etime = mktime(23,59,59,$end_m,$end_d,$end_y);
			if($byip){
				$sql = "SELECT * FROM images25 WHERE ipaddress='$byip'";
			}else if($byuid){
				$sql = "SELECT * FROM images25 WHERE user='$byuid'";
			}else{
				$sql = "SELECT * FROM images25 WHERE date >= $stime AND date <= $etime";
			}
			$qr1 = mysql_query($sql);
			echo "Number of searches found: ".mysql_num_rows($qr1)."<br>";
			if($byip){
				$purl = "imgman.php?report=1&byip=".$byip;
			}else{
				$purl = "imgman.php?report=1&start_m=".$start_m."&start_d=".$start_d."&start_y=".$start_y."&end_m=".$end_m."&end_d=".$end_d."&end_y=".$end_y;
			}
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
				print "<option value='".$purl."&pageno=".$x."'>Page $p ($l - $u)</option>\n";
			}
			print "</select></td></table>";
			echo "<table width=100%>";
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
				echo "<tr>";
				echo "	<td>";
				if( file_exists($att_path."/".$a->filename)	){
					$x = strtolower( substr($a->filename, -3)); 
					if($x=="jpg" or $x=="jpeg" or $x=="gif" or $x=="png" or $x=="jif" or $x=="jfif")
					{
						$filenx=$filen;
						$alter="no";
					}
					else
					{
						include("const.inc.php");
						$filenx = $siteurl."/icons/".$Icons[$x];
						$alter="yes";
					}

					if($alter=="yes")
					echo "<a href='$filen' target='_new'><img src='$filenx' width=20 height=20 border=0></a><br>";
					else
					echo "<a href='$filen' target='_new'><img src='$filenx' width=100 height=100 border=0></a><br>";

				}else{
					echo "	no image found<br>";
				}
				echo "		<a href='$purl&pageno=".$pageno."&del=".$a->id."'>delete</a>";
				echo "	</td>";
				echo "	<td valign=top>";
				echo "		<b>URL:</B> $filen<br>";
				if($a->user){
					list($username) = mysql_fetch_array( mysql_query("SELECT username FROM users25 WHERE uid='".$a->user."'") );
					echo "		<b>Owner:</b> <a href='imgman.php?byuid=".$a->user."&report=1'>".$username."</a><br>";
				}
				echo "		<b>IP Address:</b> <a href='imgman.php?byip=".$a->ipaddress."&report=1'>".$a->ipaddress."</a><br>";
				echo "	</td>";	
				echo "</tr>";
				echo "<tr>";
				echo "	<td colspan=2><hr></td>";
				echo "</tr>";
			}
			echo "</table>";
			print "<table width=100%><td>Page No: " . ($pageno+1) ."</td><td align=right>
						<select onChange=\"gotocluster(this)\">\n
						<option>Select A Page</option>";
			for($x=0; $x<$pagecount; $x++){
				$p = $x + 1;
				$l = $x * $limit + 1;
				$u = $l + $limit - 1;
				if($u>$rowcount) $u=$rowcount;
				print "<option value='".$purl."&pageno=".$x."'>Page $p ($l - $u)</option>\n";
			}
			print "</select></td></table>";
		}
?>
			</form>
		</td>
	</tr>
	</table>
<?
	include("siteadmin25/footer.php");
?>