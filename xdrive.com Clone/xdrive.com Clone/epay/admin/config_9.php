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
	prareas(0);
	if ($_POST['change10']){
		$qr1 = mysql_query("SELECT * FROM epay_faq_cat_list");
		$max = 0;
		while ($a = mysql_fetch_object($qr1)){
			$x[$a->id] = 1;
			if ($a->id > $max) $max = $a->id;
			if (preg_match("/update/i", $_POST['change10'])){
				mysql_query("UPDATE epay_faq_cat_list SET title='".addslashes($_POST["title$a->id"])."' WHERE id=$a->id");
			}
		}
		for ($i = 0; $i <= $max; $i++){
			if (!$x[$i]) break;
			$sel_id = $i;
		}
		if (preg_match("/delete/i", $_POST['change10']) && $_POST['delete']){
			$id = (int)$_POST['delete'];
			mysql_query("DELETE FROM epay_faq_cat_list WHERE id=$id");
			mysql_query("UPDATE epay_area_list SET parent='0' WHERE parent=$id");
		}
		if (preg_match("/add/i", $_POST['change10']) && $_POST['title_new'] != ''){
			mysql_query("INSERT INTO epay_faq_cat_list SET title='".addslashes($_POST['title_new'])."'") or die( mysql_error() );
		}
	}
?>
	<CENTER>
	<SMALL>
	<SPAN style="color: red;">Warning:</SPAN>Deleting a group will place that group's areas into no group at all</SMALL>
	<BR>
	<TABLE class=design cellspacing=0>
	<TR>
		<th>&nbsp;</TH>
		<th>ID</TH>
		<th>Title</TH>
<?
		$qr1 = mysql_query("SELECT * FROM epay_faq_cat_list ORDER BY id");
		while ($a = mysql_fetch_object($qr1)){
?>
	<TR>
		<TD><?=($a->id ? "<input type=radio name=delete value=$a->id>" : "&nbsp;")?></TD>
		<TD><?=$a->id?></TD>
		<TD><input type=text name=title<?=$a->id?> size=60 value="<?=htmlspecialchars($a->title)?>"></TD>
<?
			$i++;
		}
?>
	<TR>
		<TH colspan=4>
			<input type=submit name=change10 value="Update header list">
			<input type=submit name=change10 value="Delete selected" <?=$del_confirm?>>
		</TH>
	</TR>
	<TR>
		<TD colspan=2>&nbsp;</TD>
		<TD><input type=text name=title_new size=60></TD>
	</TR>
	<TR>
		<TH colspan=4><input type=submit name=change10 value="Add new record"></TH>
	</TABLE>
	</CENTER>