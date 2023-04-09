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
	prareas3(0);
	$n1 = $n2 = 0;
	if ( preg_match("/delete/i", $_POST['change3']) ){
		$qr1 = mysql_query("SELECT * FROM epay_area_list");
		$max = 0;
		while ($d = mysql_fetch_object($qr1)){
			$key = $_POST["delete{$d->id}"];
			if($key){
				if($d->title == $key){
					$id=$d->id;
					@mysql_query("DELETE FROM epay_area_list WHERE id=$id");
					echo "{$d->title} was deleted<bR>";
					$uC++;
				}
			}
		}
	}
	if ($_POST['change3']){
		$qr1 = mysql_query("SELECT * FROM epay_area_list");
		$max = 0;
		while ($a = mysql_fetch_object($qr1)){
			$x[$a->id] = 1;
			if ($a->id > $max) $max = $a->id;
			if (preg_match("/update/i", $_POST['change3'])){
				$query = "UPDATE epay_area_list SET title='".addslashes($_POST["title$a->id"])."',parent='".addslashes($_POST["parent$a->id"])."' WHERE id=$a->id";
				mysql_query($query) or die( mysql_error()."<br>$query<br>" );
			}
		}
		for ($i = 0; $i <= $max; $i++){
			if (!$x[$i]) break;
			$sel_id = $i;
		}
	}
	if (preg_match("/add/i", $_POST['change8']) && $_POST['title_new'] != ''){
		$query = "INSERT INTO epay_area_list SET title='".addslashes($_POST["title_new"])."',parent='".addslashes($_POST["parent_new"])."'";
		mysql_query($query) or die( mysql_error()."<BR>$query<br>");
	}
?>
<TABLE class=design width=90% cellspacing=0>
<FORM name=form1 method=post>
<TR><TH colspan=3>Categories</TH>
<? 	if ($catgroups){	?>
	<TH>Selected Parent Name</TH>
<? 	}	?>
<?
//		mysql_query("DELETE FROM epay_area_list WHERE title='';");
	if ($catgroups){
		$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE parent=0 ORDER BY parent ASC");
		$qr2 = mysql_query("SELECT * FROM epay_area_list WHERE parent=0 ORDER BY parent ASC");
	}else{
		$qr1 = mysql_query("SELECT * FROM epay_area_list ORDER BY parent ASC");
		$qr2 = mysql_query("SELECT * FROM epay_area_list ORDER BY parent ASC");
	}
		$itotal = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
//			if (mysql_result($qr2, $i, 'title')){
				$itotal++;
//			}
		}
		$i = 1;
		while ($a = mysql_fetch_object($qr1)){
			if ( $a->parent ){
				$hdr = getheader($a->parent);
			}
			if ($hdr){
				$title = $hdr." - ".$a->title;
			}else{
				$title = $a->title;
			}
			$kname = $a->title;
?>
<TR>
	<TD width=15><input type=checkbox name="delete<?=$a->id?>" value="<?=$kname?>">
	<TD width=15><?=$i?></TD> 
	<TD><input type=text name=title<?=$a->id?> size=50 value="<?=htmlspecialchars($a->title)?>"></TD>
<? 			if ($catgroups){	?>
				<TD><select name="parent<?=$a->id?>">
					<option value="">-- please select one --</option>
<?
// Selection Header
			$aqr1 = mysql_query("SELECT id,title FROM epay_area_list WHERE parent='0'");
				while ($cb = mysql_fetch_object($aqr1)){
					if ($cb->id){
				echo "<option value={$cb->id}",($a->parent == $cb->id ? ' selected' : ''),"> $cb->title";
				}
			}
?>
	</select></TD>
<?			}else{	?>
				<input type="hidden" name="parent<?=$a->id?>" value="<?=$a->parent?>">
<?			}	?>
		<input type="hidden" name="akey<?=$a->id?>" value="<?=$a->akey?>">
<?
//			$itotal = $i;
			$i++;
			if ($catgroups){
				$child = buildTree($a->id);
				if($child){
					echo $child;
				}
			}
		}
?>
	<input type="hidden" name="itotal" value="<?=$itotal?>">
<TR><TH colspan=4><P align=center><input type=submit name=change3 value="Update">
	<input type=submit name=change3 value="Delete selected" <?=$del_confirm?>></TH></TR>
	<INPUT type=hidden name=up>
	<INPUT type=hidden name=down>
	<input type="hidden" name="nextid" value="<?if(!$itotal){$nextid=0;}else{$nextid=$itotal;}echo $nextid;?>">
	<input type="hidden" name="suid" value="<?=$suid;?>">
<TR>
	<TD width=15>&nbsp;</TD>
	<TD><?=$i?></TD>
	<TD><input type=text name=title_new size=30></TD>
<? 	if ($catgroups){	?>
	<TD colspan=2><select name="parent_new">
		<option value="">-- please select one --</option>
<?
// Selection Header
		$qr1 = mysql_query("SELECT id,title FROM epay_area_list WHERE parent='0'");
		while ($a = mysql_fetch_object($qr1)){
			if ($a->id){
				echo "<option value=".$a->id.">".$a->title;
			}
		}
?>
</select></TD>
<? 	}	?>
	</TD></TR>
<TR><TH colspan=4><input type=submit name=change8 value="Add new record"></TH></TR>
</FORM>
</TABLE>
</CENTER>
<?
	function buildTree($parent){
		global $catgroups;
		ob_start();
		$qr1 = mysql_query("SELECT * FROM epay_area_list WHERE parent=$parent ORDER BY id");
		$qr2 = mysql_query("SELECT * FROM epay_area_list WHERE parent=$parent ORDER BY id");
		$itotal = 0;
		for ($i = mysql_num_rows($qr2) - 1; $i >= 0; $i--){
				$itotal++;
	}
	if(!$itotal++){
			return "";
	}
		$i = 1;
	while ($a = mysql_fetch_object($qr1)){
	if ( $a->parent ){
		$hdr = getheader($a->parent);
	}
	if ($hdr){
		$title = $hdr." - ".$a->title;
	}else{
		$title = $a->title;
	}
		$kname = $a->title;
		
?>
<TR>
	<TD width=15>&nbsp;</TD>
	<TD width=15><input type=checkbox name="delete<?=$a->id?>" value="<?=$kname?>">
	<TD><input type=text name=title<?=$a->id?> size=50 value="<?=htmlspecialchars($a->title)?>"></TD>
<? 			if ($catgroups){	?>
	<TD><select name="parent<?=$a->id?>">
		<option value="">-- please select one --</option>
<?
// Selection Header
		$aqr1 = mysql_query("SELECT id,title FROM epay_area_list WHERE parent='0'");
			while ($cb = mysql_fetch_object($aqr1)){
		if ($cb->id){
			echo "<option value={$cb->id}",($a->parent == $cb->id ? ' selected' : ''),"> $cb->title";
		}
	}
?>
	</select></TD>
<?	}else{	?>
		<input type="hidden" name="parent<?=$a->id?>" value="<?=$a->parent?>">
<?	}	?>
		<input type="hidden" name="akey<?=$a->id?>" value="<?=$a->akey?>">
<?
//			$itotal = $i;
			$i++;
		}
		$child = ob_get_contents();
		ob_end_clean();
		return $child;
	}
?>