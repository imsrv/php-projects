<?
	header("Pragma: no-cache");
	header("Cache-Control: no-cache, must-revalidate");
	session_start();

	//********************************************//
	//*** CONFIGURE YOUR SERVER HERE *** START ***//
	$DBH="db_host";
	$DBU="db_user";
	$DBP="db_pass";
	//*** CONFIGURE YOUR SERVER HERE *** STOP ***//
	//*******************************************//

	$VER=array(
		 "NAME"=>"WizMySQLAdmin",
		 "WEB"=>"Wiz's Shelf",
		 "URL"=>"http://wiz.homelinux.net/",
		 "MAJOR"=>"0.8",
		 "MINOR"=>"6",
		 "BUILD"=>"64"
	);

	$WIZ=$_SERVER[SCRIPT_NAME];
	if(!$_SESSION[RPP]) $_SESSION[RPP]=20;

	$dbl=@mysql_connect($DBH,$DBU,$DBP) or die("Access denied. Check configuration.");

	switch($_REQUEST[hop]) {
		//SET DATABASE
		case "1":
			$_SESSION[DBN]=$_GET[dbn];
			$_SESSION[msg]="Database <b>$_SESSION[DBN]</b> selected";
			break;
		//UNSET DATABASE AND TABLE
		case "2":
			unset($_SESSION[DBN]);
			unset($_SESSION[TBN]);
			$_SESSION[msg]="Databases on server";
			break;
		//CREATE NEW DATABASE
		case "3":
			if(mysql_query("CREATE DATABASE $_POST[dbnew]",$dbl)) {
				$_SESSION[DBN]=$_POST[dbnew];
				$_SESSION[msg]="Database <b>$_SESSION[DBN]</b> created!";
			} else {
				unset($_SESSION[DBN]);
				$_SESSION[msg]="Error creating database <b>$_SESSION[TBN].$_POST[dbnew]</b>";
			}
			break;
		//DROP DATABASE
		case "4":
			if(mysql_query("DROP DATABASE $_SESSION[DBN]",$dbl)) {
				$_SESSION[msg]="Database <b>$_SESSION[DBN]</b> removed!";
				unset($_SESSION[DBN]);
			} else {
				$_REQUEST[op]=1;
				$_SESSION[msg]="Error removing database <b>$_SESSION[DBN]</b>";
			}
			break;
		//SET TABLE
		case "5":
			$_SESSION[TBN]=$_REQUEST[tbn];
			$_SESSION[PG]=0;
			$_SESSION[WHERE]="";
			$_SESSION[msg]="Table <b>$_SESSION[DBN].$_SESSION[TBN]</b> selected";
			break;
		//UNSET TABLE
		case "6":
			unset($_SESSION[TBN]);
			$_SESSION[msg]="Tables of <b>$_SESSION[DBN]</b>";
			break;
		//SET RPP VALUE
		case "7":
			$_SESSION[RPP]=$_POST[rpp];
			$_SESSION[PG]=0;
			break;
		//SET PG VALUE
		case "8":
			$_SESSION[PG]=$_REQUEST[pg];
			break;
		//SET WHERE FOR QUERY
		case "9":
			$_SESSION[TBN]=$_REQUEST[tbn];
			$_SESSION[PG]=0;
			$_SESSION[WHERE]=stripslashes($_POST[where]);
			$_SESSION[msg]="Table <b>$_SESSION[DBN].$_SESSION[TBN]</b> selected";
			break;
		//10:ESPORTA CSV
		case "10":
			$campi=mysql_list_fields($_SESSION[DBN],$_SESSION[TBN],$dbl);
			$cols=mysql_num_fields($campi);
			for($i=0;$i<$cols;$i++) $dump.="\"".mysql_field_name($campi,$i)."\",";
			$dump=substr($dump,0,-1)."\n";
			$rs=mysql_query("SELECT * FROM $_SESSION[TBN]",$dbl);
			while($rc=mysql_fetch_row($rs)) {
				for($i=0;$i<$cols;$i++) $dump.="\"".addslashes($rc[$i])."\",";
				$dump=substr($dump,0,-1)."\n";
			}
			header("Content-type: text/plain");
			header("Content-Disposition: filename=$_SESSION[DBN].$_SESSION[TBN].sql");
			die($dump);
			break;
	}

	if($_SESSION[DBN]) {
		mysql_select_db($_SESSION[DBN],$dbl);
		$rs=mysql_list_tables($_SESSION[DBN],$dbl);
		for($i=0;$i<mysql_num_rows($rs);$i++) {
			$tbn=mysql_tablename($rs,$i);
			$TABLES.="<option value='$tbn' ".(($tbn==$_SESSION[TBN])?"selected":"").">$tbn</option>";
		}
	} else {
		unset($_REQUEST[op]);
	}
?>
	<html>
	<head>
		<title><?="$VER[NAME] $VER[MAJOR].$VER[MINOR]"?></title>
		<style type="text/css"><!--
			BODY,TABLE,TR,TD,INPUT,TEXTAREA,OPTION,SELECT { font-family:sans-serif;font-size:10pt;color:#404040;text-decoration:none; }
			A:LINK,A:VISITED { font-family:sans-serif;font-size:10pt;color:#3366AA;text-decoration:none; }
			A:HOVER { text-decoration:underline; }
		--></style>
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
	<tr valign="middle" height="20" bgcolor="#CCCCCC">
		<td width="75%">&nbsp; <b><?="$VER[NAME] $VER[MAJOR].$VER[MINOR]"?></b></td>
		<td width="25%" align="right"><a href="<?=$VER[URL]?>" target='_blank'><b>P</b>owered by <b><?=$VER[WEB]?></b></a> &nbsp;</td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
	<tr valign="middle" height="20" bgcolor="#DDDDDD">
		<td width="75%">
			&nbsp; <b>Menu:</b> |
			<a href="<?=$WIZ?>?hop=2"><b>S</b>how databases</a>
<?
	switch($_REQUEST[op]) {
		//SHOW TABLES
		case "1":
			echo(" | <a href='javascript:if(confirm(\"Sure to drop database $_SESSION[DBN]?\")) window.open(\"$WIZ?hop=4&op=1\",\"_self\")'><b>D</b>rop current database ($_SESSION[DBN])</a>");
			break;
		//TABLE FUNCTIONS
		case "2":
		case "3":
		case "4":
		case "5":
		case "6":
		case "7":
		case "8":
		case "9":
		case "10":
		case "11":
		case "12":
		case "13":
			echo("
			| <a href='$WIZ?op=1&hop=6'><b>B</b>ack to tables</a> | |
			| <a href='$WIZ?op=2'><b>P</b>roperties</a>
			| <a href='$WIZ?op=3'><b>B</b>rowse</a>
			| <a href='$WIZ?op=8'><b>I</b>nsert</a>
			| <a href='javascript:if(confirm(\"Sure to EMPTY table $_SESSION[TBN]?\")) window.location=\"$WIZ?op=6\"'><b>E</b>mpty</a>
			| <a href='javascript:if(confirm(\"Sure to DROP table $_SESSION[TBN]?\")) window.location=\"$WIZ?op=7\"'><b>D</b>rop</a>
			| <a href='$WIZ?op=10'><b>I</b>mport</a>
			| <a href='$WIZ?hop=10' target='_blank'><b>E</b>xport</a>
			");
			break;
	}
?>
	  		| | | <a href="<?=$WIZ?>?op=999"><b>C</b>redits</a>|
		</td>
		<td width="25%" align="right"><b>C</b>urrent database: <font color="#3366AA"><b>
<?
			if($_SESSION[DBN]) {
				echo($_SESSION[DBN]);
				if($_SESSION[TBN]) echo(".$_SESSION[TBN]");
			} else {
				echo("<i>none</i>");
			}
?> 
			</b></font> &nbsp;
		</td>
 	</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
	<tr valign="top">
<? 	if($_REQUEST[op]<100) { 	?>
		<td width="160" align="center" bgcolor="#EEEEEE" style="padding: 10pt 10pt 10pt 10pt">
			<form name='qry' action="<?="$WIZ?op=4"?>" method="post">
			<b>.: QUERY :.</b><br>
			<textarea name="qr" style="width:150pt;height:75pt;"></textarea><br>
			<input type="submit" style="width:150pt;" value="Execute">
			<input type="button" style="width:150pt;" value="Reset query" onClick="javascript:qry.qr.value='';">
			</form>
<? 			if($_SESSION[DBN]) { 	?>
				<form name='sel' action="<?="$WIZ?op=3&hop=9"?>" method="post">
				<b>.: SELECT :.</b><br>
				SELECT * FROM<br>
				<select name="tbn"><?=$TABLES?></select><br>
				WHERE<br>
				<textarea name="where" style="width:150pt;height:75pt;"><?=$_SESSION[WHERE]?></textarea><br>
				<input type="submit" style="width:150pt;" value="Execute"><br>
				<input type="button" style="width:150pt;" value="Reset query" onClick="javascript:sel.where.value='';">
				</form>
				<form action="<?="$WIZ?op=12"?>" method="post">
				<b>.: CREATE TABLE :.</b><br>
				Table name:<br>
				<input type="text" name="tablenew" style="width:150pt;"><br>
				Number of fields: <input type="text" name="tablefields" style="width:50pt;"><br>
				<input type="submit" style="width:150pt;" value="Execute">
				</form>
<? 			} 	?>
			<form action="<?="$WIZ?op=1&hop=3"?>" method="post">
			<b>.: CREATE DATABASE :.</b><br>
			Database name:<br>
			<input type="text" name="dbnew" style="width:150pt;"><br>
			<input type="submit" style="width:150pt;" value="Execute">
			</form>
		</td>
<? 	} 	?>
		<td bgcolor="#FFFFFF" style="padding: 15pt 15pt 15pt 15pt">
<?
	switch($_REQUEST[op]) {
		//1: SHOW TABLES
		case "1":
			echo("<table cellspacing='0' cellpadding='2' border='0' style='border:1pt solid #666666;border-collapse:collapse;'>
					<tr style='background-color:#DDDDDD;'>
					<th width='100'>TABLE</th>
					<th width='60'>Records</th>
					</tr>\n");
			$rs=mysql_list_tables($_SESSION[DBN],$dbl);
			for($i=0;$i<mysql_num_rows($rs);$i++) {
				$bgcolor=($bgcolor=="#EEEEEE")?"#FFFFFF":"#EEEEEE";
				$tbn=mysql_tablename($rs,$i);
				echo("<tr align='center' style='background-color:$bgcolor' onMouseOver='javascript:this.style.backgroundColor=\"#CCFF00\"' onMouseOut='javascript:this.style.backgroundColor=\"$bgcolor\"'>
						<th><a href='$WIZ?op=2&hop=5&tbn=$tbn'>$tbn</a></th>
						<td>".mysql_num_rows(mysql_query("SELECT * FROM $tbn",$dbl))."</td>");
			}
			echo("</tr></table>");
			break;
		//2:TABLE PROPERTIES
		case "2":
			echo("<table cellspacing='0' cellpadding='2' border='0' style='border:1pt solid #666666;border-collapse:collapse;'>
					<tr style='background-color:#DDDDDD;'>
					<th width='70'>FIELD</th>
					<th width='90'>TYPE</th>
					<th>PROPERTIES</th>
					</tr>\n");
			$campi=mysql_list_fields("$_SESSION[DBN]","$_SESSION[TBN]",$dbl);
			$cols=mysql_num_fields($campi);
			for($i=0;$i<$cols;$i++) {
				$bgcolor=($bgcolor=="#EEEEEE")?"#FFFFFF":"#EEEEEE";
				echo("<tr style='background-color:$bgcolor' onMouseOver='javascript:this.style.backgroundColor=\"#CCFF00\"' onMouseOut='javascript:this.style.backgroundColor=\"$bgcolor\"'>
						<td><b>".mysql_field_name($campi,$i)."</b></td>
						<td>".mysql_field_type($campi,$i)."(".mysql_field_len($campi,$i).")</td>
						<td>".str_replace(" ",", ",mysql_field_flags($campi,$i))."</td>
						</tr>");
			}
			echo("</table>");
			break;
		//3:BROWSE
		case "3":
			echo("<table cellspacing='0' cellpadding='2' border='0' style='border:1pt solid #666666;border-collapse:collapse;'>
					<tr style='background-color:#DDDDDD;'>");
			$campi=mysql_list_fields($_SESSION[DBN],$_SESSION[TBN],$dbl);
			$cols=mysql_num_fields($campi);
			for($i=0;$i<$cols;$i++) echo("<th>".mysql_field_name($campi,$i)."</th>");
			echo("<td colspan='2'>&nbsp;</td></tr>");
			if($rs=mysql_query("SELECT * FROM $_SESSION[TBN] WHERE ".(($_SESSION[WHERE])?$_SESSION[WHERE]:"1"),$dbl)) {
				for($i=0;($i*$_SESSION[RPP])<mysql_num_rows($rs);$i++) $pages.="<option value='$i' ".(($_SESSION[PG]==$i)?"selected":"").">".($i+1)."</option>\n";
				$disablenext=(mysql_num_rows($rs)<($_SESSION[RPP]*($_SESSION[PG]+1)))?"disabled":"";
				$rs=mysql_query("SELECT * FROM $_SESSION[TBN] WHERE ".(($_SESSION[WHERE])?$_SESSION[WHERE]:"1")." LIMIT ".($_SESSION[PG]*$_SESSION[RPP]).",$_SESSION[RPP]",$dbl);
				while($rc=mysql_fetch_row($rs)) {
					$bgcolor=($bgcolor=="#EEEEEE")?"#FFFFFF":"#EEEEEE";
					echo("<tr style='background-color:$bgcolor' onMouseOver='javascript:this.style.backgroundColor=\"#CCFF00\"' onMouseOut='javascript:this.style.backgroundColor=\"$bgcolor\"'>");
					$where="";
					for($i=0;$i<$cols;$i++) {
						echo("<td>".nl2br($rc[$i])."</td>");
						if($rc[$i]) $where.=mysql_field_name($campi,$i)."='".addslashes($rc[$i])."' AND ";
					}
					echo("
							<td><form method='post' action='$WIZ?op=8'>
							<input type='hidden' name='edit' value='".base64_encode($where)."'>
							<input type='submit' value='Edit'>
							</form></td>
							<td><form method='post' action='$WIZ?op=5'>
							<input type='hidden' name='del' value='".base64_encode($where)."'>
							<input type='button' value='Delete' onClick='javascript:if(confirm(\"Delete record?\")) submit();'>
							</form></td>
							</tr>");
				}
			}
			echo("</table>
					<p>
					<input type='button' value='&lt;&lt; Previous page' style='width:150pt;' ".((($_SESSION[PG]-1)<0)?"disabled":"")." onClick='javascript:window.location=\"$WIZ?op=3&hop=8&pg=".($_SESSION[PG]-1)."\"'>
					&nbsp;
					<input type='button' value='Next page &gt;&gt;' style='width:150pt;' $disablenext onClick='javascript:window.location=\"$WIZ?op=3&hop=8&pg=".($_SESSION[PG]+1)."\"'>
					</p>
					<form method='post' action='$WIZ?op=3&hop=7'>
					<input type='submit' value='Show'> <input type='text' name='rpp' value='$_SESSION[RPP]' size='4'> records for each page
					</form>
					<form method='post' action='$WIZ?op=3&hop=8'>
					<input type='submit' value='Go'> to page <select name='pg' onChange='javascript:submit()'>$pages</select>
					</form>
			");
			break;
		//4:EXECUTE QUERY
		case "4":
			echo("<p><b>Q</b>uery results:</p>\n<p>");
			$qr=split(";",stripslashes($_POST[qr]));
			foreach($qr as $qry) {
				if(trim($qry)) echo("<p>".((mysql_query(trim($qry),$dbl))?"<b>OK!</b> - $qry<br>":"<b>FAILED!</b> - $qry")."</p>\n");
			}
			echo("<p><a href='$WIZ?op=2'><b>&gt;&gt; Table properties</b></a></p>");
			break;
		//5:DELETE RECORD
		case "5":
			echo("<p>".((mysql_query("DELETE FROM $_SESSION[TBN] WHERE ".base64_decode($_POST[del])." 1 LIMIT 1",$dbl))?"Record deleted":"Unable to delete record")."</p>");
			echo("<p><a href='$WIZ?op=3'><b>&gt;&gt; Browse table</b></a></p>");
			break;
		//6:EMPTY TABLE
		case "6":
			mysql_query("DELETE FROM $_SESSION[TBN]");
			echo("<b>Table $_SESSION[TBN] is now empty.</b></p>");
			echo("<p><a href='$WIZ?op=2'><b>&gt;&gt; Table properties</b></a></p>");
			break;
		//7:DROP TABLE
		case "7":
			mysql_query("DROP TABLE $_SESSION[TBN]");
			echo("<b>Table $_SESSION[TBN] dropped.</b></p>");
			echo("<p><a href='$WIZ?op=1'><b>&gt;&gt; List tables</b></a></p>");
			unset($_SESSION[TBN]);
			break;
		//8:INSERT/EDIT RECORD
		case "8":
			echo("<form method='post' action='$WIZ?op=9'><input type='hidden' name='edit' value='$_POST[edit]'>");
			if($_POST[edit]) $rc=mysql_fetch_row(mysql_query("SELECT * FROM $_SESSION[TBN] WHERE ".base64_decode($_POST[edit])." 1 LIMIT 1",$dbl));
			$campi=mysql_list_fields($_SESSION[DBN],$_SESSION[TBN],$dbl);
			$cols=mysql_num_fields($campi);
			for($i=0;$i<$cols;$i++) echo("<p><b>".mysql_field_name($campi,$i)."</b>: ".((mysql_field_type($campi,$i)=="blob")?"<textarea cols='40' rows='4' name='".mysql_field_name($campi,$i)."'>$rc[$i]</textarea>":"<input type='text' name='".mysql_field_name($campi,$i)."' value='$rc[$i]' size='50'>")."</p>\n");
			echo("<input type='submit' value='Save'> <input type='reset' value='Reset'> <input type='button' value='Back to table content' onClick='javascript:window.location=\"$WIZ?op=3\"'></form>");
			break;
		//9:SAVE RECORD
		case "9":
			$campi=mysql_list_fields($_SESSION[DBN],$_SESSION[TBN],$dbl);
			$cols=mysql_num_fields($campi);
			for($i=0;$i<$cols;$i++) $fields.=mysql_field_name($campi,$i)."='$"."_POST[".mysql_field_name($campi,$i)."]', ";
			eval("\$fields=\"$fields\";");
			$fields=substr($fields,0,-2);
			$qry=($_POST[edit])?"UPDATE $_SESSION[TBN] SET $fields WHERE ".base64_decode($_POST[edit])." 1 LIMIT 1":"INSERT INTO $_SESSION[TBN] SET $fields";
			echo((mysql_query($qry,$dbl))?"Query executed":"Error executing query");
			echo("<p><a href='$WIZ?op=3'><b>&gt;&gt; Browse table</b></a></p>");
			break;
		//10:SET CSV IMPORT
		case "10":
			echo("<p><b>S</b>elect <b>CSV</b> file to import into <b>$_SESSION[DBN].$_SESSION[TBN]</b>:</p>
					<form action='$WIZ?op=11' method='post' enctype='multipart/form-data'>
					<p>CSV file: <input name='csv' type='file'></p>
					<p><input type='submit' value='Import CSV'></p>
					</form>");
			break;
		//11:IMPORT CSV
		case "11":
			if(!mysql_query("LOAD DATA LOCAL INFILE '".$_FILES['csv']['tmp_name']."' REPLACE INTO TABLE $_SESSION[TBN] FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ESCAPED BY '\\\' LINES TERMINATED BY '\n'",$dbl)) $no="NOT";
			echo("<p><b>CSV $no imported into $_SESSION[DBN].$_SESSION[TBN]</b></p>");
			echo("<p><a href='$WIZ?op=2'><b>&gt;&gt; Table properties</b></a></p>");
			break;
		//12:CREATE TABLE
		case "12":
			echo("<p>Define <b>$_POST[tablefields]</b> fields for new table <b>$_POST[tablenew]</b>:</p>");
			echo("<form method='post' action='$WIZ?op=13&tablefields=$_POST[tablefields]&tablenew=$_POST[tablenew]'>
					<table cellspacing='0' cellpadding='2' border='0' style='border:1pt solid #666666;border-collapse:collapse;'>
					<tr style='background-color:#DDDDDD;'>
					<th>FIELD</th>
					<th>TYPE</th>
					<th>LENGTH/VALUES</th>
					<th>ATTRIBUTES</th>
					<th>NULL</th>
					<th>DEFAULT</th>
					<th>EXTRA</th>
					<th>INDEX</th>
					</tr>\n");
			for($i=0;$i<$_POST[tablefields];$i++) {
				$bgcolor=($bgcolor=="#EEEEEE")?"#FFFFFF":"#EEEEEE";
				echo("<tr align='center' style='background-color:$bgcolor' onMouseOver='javascript:this.style.backgroundColor=\"#CCFF00\"' onMouseOut='javascript:this.style.backgroundColor=\"$bgcolor\"'>
						<td><input type='text' name='field[$i]' style='width:70pt;'></td>
						<td>
						<select name='type[$i]'>");
				$types=array("","TINYINT","SMALLINT","MEDIUMINT","INT","BIGINT","DOUBLE","DECIMAL","FLOAT","DATE","TIME","TIMESTAMP","DATETIME","YEAR","VARCHAR","TINYTEXT","TEXT","MEDIUMTEXT","LONGTEXT","TINYBLOB","BLOB","MEDIUMBLOB","LONGBLOB");
				foreach($types as $type) echo("<option value='$type'>$type</option>\n");
				echo("</select>
						</td>
						<td><input type='text' name='len[$i]' style='width:50pt;'></td>
						<td>
						<select name='attr[$i]'>");
				$attrs=array("","BINARY","UNSIGNED","UNSIGNED ZEROFILL");
				foreach($attrs as $attr) echo("<option value='$attr'>$attr</option>\n");
				echo("</select>
						</td>
						<td>
						<select name='null[$i]'>");
				$nulls=array("NOT NULL","NULL");
				foreach($nulls as $null) echo("<option value='$null'>$null</option>\n");
				echo("</select>
						</td>
						<td><input type='text' name='def[$i]' style='width:50pt;'></td>
						<td>
						<select name='extra[$i]'>");
				$extras=array("","AUTO_INCREMENT");
				foreach($extras as $extra) echo("<option value='$extra'>$extra</option>\n");
				echo("</select>
						</td>
						<td>
						<select name='index[$i]'>");
				$indexs=array("","PRIMARY KEY","INDEX","UNIQUE KEY");
				foreach($indexs as $index) echo("<option value='$index'>$index</option>\n");
				echo("</select>
						</td>
						</tr>");
			}
			echo("</table>
					<p><input type='submit' value='Create table'></p>
					</form>");
			break;
		//13:CREATE TABLE EXECUTE
		case "13":
			$queryindex=array();
			echo("<p>Creating table <b>$_GET[tablenew]</b>:</p>");
			$query="CREATE TABLE $_GET[tablenew] (";
			for($i=0;$i<$_GET[tablefields];$i++) {
				$query.=$_POST[field][$i]." ";
				$query.=$_POST[type][$i]." ";
				if($_POST[len][$i]) $query.="(".$_POST[len][$i].") ";
				$query.=$_POST[attr][$i]." ";
				$query.=$_POST[null][$i]." ";
				if($_POST[def][$i]) $query.=" DEFAULT '".$_POST[def][$i]."' ";
				$query.=$_POST[extra][$i]." ";
				if($_POST[index][$i]) {
					if($_POST[index][$i]=="INDEX"){
						$queryindex[]="ALTER TABLE $_GET[tablenew] ADD INDEX (".$_POST[field][$i]."); ";
					}else {
						$query.=$_POST[index][$i];
					}
				}
				$query.=", ";
			}
			$query=substr($query,0,-2).");";
			echo("<p>");
			if(@mysql_query($query,$dbl)) {
				foreach($queryindex as $qi) @mysql_query($qi,$dbl);
				echo("Table <b>$_GET[tablenew]</b> created");
				$_SESSION[TBN]=$_GET[tablenew];
				$_SESSION[PG]=0;
				$_SESSION[WHERE]="";
				$_SESSION[msg]="Table <b>$_SESSION[DBN].$_GET[tablenew]</b> created";
			} else {
				echo("Error creating table <b>$_GET[tablenew]</b>");
			}
			echo("</p>");
			echo("<p><a href='$WIZ?op=2'><b>&gt;&gt; Table properties</b></a></p>");
			break;
		//999:CREDITS
		case "999":
			echo("
					<p><b>Maintainer</b>:<br>
					&nbsp; <font color='#3366AA'><b>Marco Avidano</b></font>
					</p>
					<p><b>Thanks to</b>:<br>
					&nbsp; <font color='#3366AA'><b>Chris St. Pierre</b></font> (creation table wizard)
					</p>
					<p><b>Some information about this program</b>:<br>
					&nbsp; Project name: <font color='#3366AA'><b>$VER[NAME]</b></font><br>
					&nbsp; Major version: <font color='#3366AA'><b>$VER[MAJOR]</b></font><br>
					&nbsp; Minor version: <font color='#3366AA'><b>$VER[MINOR]</b></font><br>
					&nbsp; Build: <font color='#3366AA'><b>$VER[BUILD]</b></font><br>
					&nbsp; Shortly: <font color='#3366AA'><b>$VER[MAJOR].$VER[MINOR]</b></font><br>
					&nbsp; Web site: <font color='#3366AA'><b>$VER[WEB]</b></font><br>
					&nbsp; URL: <a href='$VER[URL]' target='_blank'><b>$VER[URL]</b></a>
					</p>
					<p><b>Something else</b>:<br>
					&nbsp; &quot;I don't know half of you half as well as I should like;<br>
					&nbsp; and I like less than half of you half as well as you deserve.&quot;<br>
					&nbsp; - Bilbo Baggins
					</p>
					<p>&nbsp;</p>
			");
			$_SESSION[msg]="Take it easy!";
			break;
		//DEFAULT: SHOW DATABASES
		default:
			echo("<table cellspacing='0' cellpadding='2' border='0' style='border:1pt solid #666666;border-collapse:collapse;'>
					<tr style='background-color:#DDDDDD;'>
					<th width='100'>DATABASE LIST</th>
					</tr>");
			$rs=mysql_list_dbs($dbl);
			while($rc=mysql_fetch_object($rs)) {
				$bgcolor=($bgcolor=="#EEEEEE")?"#FFFFFF":"#EEEEEE";
				echo("<tr style='background-color:$bgcolor' onMouseOver='javascript:this.style.backgroundColor=\"#CCFF00\"' onMouseOut='javascript:this.style.backgroundColor=\"$bgcolor\"'><td><a href='$WIZ?op=1&hop=1&dbn=$rc->Database'>$rc->Database</a></td></tr>\n");
			}
			echo("</table>");
			break;
	}
?>
		</td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
	<tr valign="middle" height="20" bgcolor="#DDDDDD">
		<td width="100%">&nbsp; <b>Log:</b> <?=$_SESSION[msg]?></td>
	</tr>
	</table>
	<table cellspacing="0" cellpadding="0" width="100%" border="0" valign="middle">
	<tr height="20">
		<th bgcolor="#CCCCCC">Copyright &copy; 2004 Marco Avidano -:- Powered by <a href="<?=$VER[URL]?>" target='_blank'><?=$VER[WEB]?></a></td>
	</tr>
	</table>
	</body>
	</html>
<?
	mysql_close($dbl);
?>
