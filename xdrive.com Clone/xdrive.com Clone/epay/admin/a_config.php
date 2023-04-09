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
if(!$_POST['what'])$_POST['what'] = $_GET['what'];
?>

<TABLE class=design width=100% cellspacing=0>
<FORM name=form1 method=post>
	<?=$id_post?>
	<input type=hidden name=what value="<?=(int)$_POST['what']?>">
<TR><TD style="padding: 10px;">

	<? include("admin/config_".(int)$_POST['what'].".php"); ?>

</TD></TR>
</FORM>
</TABLE>
