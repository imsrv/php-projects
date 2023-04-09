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
	prheaders(0);
	$n1 = $n2 = 0;
	if ($_POST['change3']){
		for ($i = 0; $i < $_POST["itotal"]; $i++){
			$query = "UPDATE epay_area_list SET title='".addslashes($_POST["title$i"])."',parent='".addslashes($_POST["parent$i"])."' WHERE id=$i";
			mysql_query($query) or die( mysql_error()."<br>$query<br>" );
		}
	}elseif ($_POST['up']){
		$n2 = (int)$_POST['up'];
		$n1 = $n2 - 1;
	}elseif ($_POST['down']){
		$n1 = (int)$_POST['down'];
		$n2 = $n1 + 1;
	}
	if ($n1 && $n2){
		$n1--;
		$n2--;
		$b1 = 1 << $n1;
		$b2 = 1 << $n2;
		mysql_query("UPDATE epay_area_list SET title='".addslashes($_POST["title$n1"])."',parent='".addslashes($_POST["parent$n1"])."'  WHERE id=$n2");
		mysql_query("UPDATE epay_area_list SET title='".addslashes($_POST["title$n2"])."',parent='".addslashes($_POST["parent$n2"])."'  WHERE id=$n1");
		mysql_query("UPDATE epay_subarea_list SET parent='".$n1."' WHERE parent=$n2");
		mysql_query("UPDATE epay_subarea_list SET parent='".$n2."' WHERE parent=$n1");
		$qr1 = mysql_query("SELECT id,area FROM epay_projects");
		while ($r = mysql_fetch_row($qr1)){
			$area = $r[1];
			$x1 = ($area & $b1);
			$x2 = ($area & $b2);
			$area = ($area ^ ($x1 | $x2));
			if ($x1) $area |= $b2;
			if ($x2) $area |= $b1;
			mysql_query("UPDATE epay_projects SET area=$area WHERE id=$r[0]");
		}
		$qr1 = mysql_query("SELECT id,area FROM epay_users WHERE area>0");
		while ($r = mysql_fetch_row($qr1)){
			$area = $r[1];
			$x1 = ($area & $b1);
			$x2 = ($area & $b2);
			$area = ($area ^ ($x1 | $x2));
			if ($x1) $area |= $b2;
			if ($x2) $area |= $b1;
			mysql_query("UPDATE epay_users SET area=$area WHERE id=$r[0]");
		}
	}
?>
	<CENTER>
	<SMALL>
		The changes in this table will not affect any projects already created or users' profiles.<br>
		P.S. To delete an area, just remove it's title.
	</SMALL>
	<BR>
	<TABLE class=design cellspacing=0>
	<FORM name=form1 method=post>
	<TR>
		<TH>&nbsp;</TH>
		<TH>Area Name</TH>
<? 	if ($catgroups){	?>
		<TH>Selected Parent Name</TH>
<? 	}	?>
		<TH>&nbsp;</TH>
	</tr>
<?
//		mysql_query("DELETE FROM epay_area_list WHERE title='';");
		$qr1 = mysql_query("SELECT * FROM epay_area_list ORDER BY parent DESC");
		$qr2 = mysql_query("SELECT * FROM epay_area_list ORDER BY parent DESC");
		$itotal = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
//			if (mysql_result($qr2, $i, 'title')){
				$itotal++;
//			}
		}
		$i = 1;
		while ($a = mysql_fetch_object($qr1)){
?>
		<TR>
			<TD><?=$i?></td>
			<TD><input type=text name=title<?=$a->id?> size=50 value="<?=htmlspecialchars($a->title)?>"></td>
<? 	if ($catgroups){	?>
			<TD>
				<select name="parent<?=$a->id?>">
					<option value="">-- please select one --</option>
<?
			// Selection Header
			reset($enum_headers);
			while ($b = each($enum_headers)){
				echo "<option value=$b[0]",($a->parent == $b[0] ? ' selected' : ''),"> $b[1]";
				if ($b[0] < sizeof($enum_headers) - 1) echo "\n";
			}
?>
				</select>
			</TD>
<?	}else{	?>
			<input type="hidden" name="parent<?=$a->id?>" value="<?=$a->parent?>">
<?	}	?>
			<TD>
				<? if ($i != 1) { ?>
					<A href=# onClick="if (confirm('Move group ?')) { form1.up.value='<?=$i?>'; form1.submit(); return false; } else { return false; }">Up</a> 
				<? } ?>
				<? if ($i != $itotal) { ?>
					<A href=# onClick="if (confirm('Move group ?')) { form1.down.value='<?=$i?>'; form1.submit(); return false; } else { return false; }">Down</a> 
				<? } ?>
			</TD>
<?
//			$itotal = $i;
			$i++;
		}
	?>
	<input type="hidden" name="itotal" value="<?=$itotal?>">
	<TR>
		<th colspan=3><P align=center><input type=submit name=change3 value="Update"></th>
	</tr>
	<INPUT type=hidden name=up>
	<INPUT type=hidden name=down>
	</FORM>
	<FORM name=form2 method=post action="addcat.php">
	<input type="hidden" name="nextid" value="<?if(!$itotal){$nextid=0;}else{$nextid=$itotal;}echo $nextid;?>">
	<input type="hidden" name="suid" value="<?=$suid;?>">
	<TR>
		<td><?=$i?></TD>
		<TD><input type=text name=title_new size=30></TD>
<? 	if ($catgroups){	?>
		<TD>
			<select name="parent_new">
				<option value="">-- please select one --</option>
<?
		// Selection Header
		reset($enum_headers);
		while ($b = each($enum_headers)){
			echo "<option value=$b[0]> $b[1]";
			if ($b[0] < sizeof($enum_headers) - 1) echo "\n";
		}
?>
			</select>
		</TD>
<?	}	?>
	</TR>
	<TR>
		<TH colspan=3><input type=submit name=change8 value="Add new record"></TH>
	</TR>
	</form>
	</TABLE>
	</CENTER>
