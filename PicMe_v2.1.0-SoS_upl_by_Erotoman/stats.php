<?php
/*
#
#	$Id: STATS.PHP
#	Version 2.0.0
#
*/
?>
			<b>Total Photos:</b> <? echo gettotpics() ?>
    			<br><b>Total Members:</b> <? echo numusers() ?>
    			<br><b>Votes Remaining:</b> <? echo $votesleft; ?>
    			<br><b>Total PM's:</b> <? echo messages() ?>
    			<br><b>Total Comments:</b> <? echo comments() ?>
    			<br><b>Total Votes:</b> <? gettotvotes() ?>
    			<br><b>Total Points:</b> <? gettotpoints() ?>
