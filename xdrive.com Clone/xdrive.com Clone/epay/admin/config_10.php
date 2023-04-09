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
<?	prareas(0);
	if ($_POST['change9']){
		$qr1 = mysql_query("SELECT * FROM epay_faq_list");
		$max = 0;
		while ($a = mysql_fetch_object($qr1)){
			$x[$a->id] = 1;
			if ($a->id > $max) $max = $a->id;
			if (preg_match("/update/i", $_POST['change9'])){
				mysql_query("UPDATE epay_faq_list SET question='".addslashes($_POST["question$a->id"])."',answer='".addslashes($_POST["answer$a->id"])."',cat='".addslashes($_POST["cat$a->id"])."' WHERE id=$a->id");
			}
		}
		for ($i = 0; $i <= $max; $i++){
			if (!$x[$i]) break;
			$sel_id = $i;
		}
		if (preg_match("/delete/i", $_POST['change9']) && $_POST['delete']){
			$id = (int)$_POST['delete'];
			mysql_query("DELETE FROM epay_faq_list WHERE id=$id");
		}
		if (preg_match("/add/i", $_POST['change9']) && $_POST['questionnew'] != ''){
			mysql_query("INSERT INTO epay_faq_list SET question='".addslashes($_POST['questionnew'])."',answer='".addslashes($_POST["answernew"])."',cat='".$_POST['catnew']."'") or die( mysql_error() );
		}
	}
?>
	<CENTER>
	<BR>
	<TABLE class=design cellspacing=0>
	<TR>
		<th>&nbsp;</TH>
		<th>ID</TH>
		<th>Question / Answer</TH>
		<th>Section</TH>
<?
		$qr1 = mysql_query("SELECT * FROM epay_faq_list ORDER BY cat");
		while ($a = mysql_fetch_object($qr1)){
?>
	<TR>
		<TD valign=top><?=($a->id ? "<input type=radio name=delete value=$a->id>" : "&nbsp;")?></TD>
		<TD valign=top><?=$a->id?></TD>
		<TD valign=top>
			<TABLE class=design cellspacing=0>
			<TR>
				<TD valign=top><b>Q: </TD>
				<TD valign=top>
					<input type=text name=question<?=$a->id?> size=60 value="<?=htmlspecialchars($a->question)?>">
				</TD>
			</TR>
			<TR>
				<TD valign=top><b>A: </TD>
				<TD valign=top>
					<textarea name="answer<?=$a->id?>" cols=60 rows=5><?=htmlspecialchars($a->answer)?></textarea>
				</TD>
			</TR>
			</table>
		</TD>
		<TD valign=top>
			<select name="cat<?=$a->id?>">
<?
		// Selection Header
		$qr2 = mysql_query("SELECT * FROM epay_faq_cat_list ORDER BY id");
		while ($n = mysql_fetch_object($qr2)){
			echo "<option value=".$n->id." ".($a->cat == $n->id ? ' selected' : '')."> ". $n->title;
		}
?>
			</select>
		</TD>

<?
			$i++;
		}
?>
	<TR>
		<TH colspan=4>
			<input type=submit name=change9 value="Update FAQs">
			<input type=submit name=change9 value="Delete selected" <?=$del_confirm?>>
		</TH>
	</TR>
	<TR>
		<TD colspan=2>&nbsp;</TD>
		<TD valign=top>
			<TABLE class=design cellspacing=0>
			<TR>
				<TD valign=top><b>Q:</TD>
				<TD valign=top>
					<input type=text name=questionnew size=60>
				</TD>
			</TR>
			<TR>
				<TD valign=top><b>A:</TD>
				<TD valign=top>
					<textarea name="answernew" cols=60 rows=5></textarea>
				</TD>
			</TR>
			</TABLE>
		</TD>
		<TD valign=top>
			<select name="catnew">
<?
		// Selection Header
		$qr3 = mysql_query("SELECT * FROM epay_faq_cat_list ORDER BY id");
		while ($a = mysql_fetch_object($qr3)){
			echo "<option value=".$a->id."> ". $a->title;
		}
?>
			</select>
		</TD>

	</TR>
	<TR>
		<TH colspan=4><input type=submit name=change9 value="Add new record"></TH>
	</TABLE>
	</CENTER>