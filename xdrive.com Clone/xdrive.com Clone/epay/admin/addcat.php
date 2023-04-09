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
	chdir('..');
	require('src/common.php');
	($suid = $_POST['suid']) or ($suid = $_GET['suid']);
	$id = "suid=$suid";
	$query = "INSERT INTO epay_area_list SET id='".$_POST["nextid"]."',title='".addslashes($_POST["title_new"])."',parent='".addslashes($_POST["parent_new"])."'";
	mysql_query($query) or die( mysql_error()."<BR>$query<br>");
?>
<form name="form1" action="right.php" method="POST">
	<input type="hidden" name="a" value="config">
	<input type="hidden" name="what" value="3">
	<input type="hidden" name="suid" value="<?=$suid?>">
</form>
<script>
	form1.submit();
</script>