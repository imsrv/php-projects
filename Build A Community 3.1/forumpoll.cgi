#!/usr/bin/perl
##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################

require "./common.pm";

if ($yh_domains ne "") { if( &Invalid_IP($yh_domains) ) { $BODY .= "Location: $CONFIG{'COMMUNITY_noip'}\n\n"; } }

&parse_FORM;

if ($FORM{'action'} eq "") {
	&Error ("No Option Specified");
}

if ($FORM{'poll'} eq "") {
	&Error ("No Topic Specified");
}

if ($FORM{'action'} eq "View Results!") {
	&DisplayResults;
}

else {
	&CheckVoter;
	&RecordVote;
}

	&print_output('forum_poll');


sub CheckVoter {
	$fn = $CONFIG{'data_dir'} . "/cforums/polls/" . $FORM{'poll'} . ".vot";
	open (VF, "$fn");
	$voter = <VF>;
	close VF;
	chop ($voter);
	
	if ($voter eq $ENV{'REMOTE_ADDR'}) {
		&Error ("No Duplicate Voting");
	}
	else {
		open (VF, ">$fn");
		print VF "$ENV{'REMOTE_ADDR'}\n";
		close VF;
	}
	chmod 0777, "$fn";
}


sub RecordVote {
	$fn = $CONFIG{'data_dir'} . "/cforums/polls/" . $FORM{'poll'} . ".txt";

	&lock("$FORM{'poll'}");
	open (VF,"$fn");
	@lines = <VF>;
	chop @lines;
	close VF;

	$Count = 1;

	foreach $nline (@lines) {
		(@t) = split(/::/, $nline);
		$votes{$t[0]} = $t[1];
		$tvotes = $tvotes + $votes{$t[0]};
		$Count++;
	}
	$votes{$FORM{'item'}}++;

	open (VF, ">$fn");
	$Counter = 0;
	foreach $l (keys %votes) {
		print VF "$l\:\:$votes{$l}\n";
	}
	close VF;
	&unlock("$FORM{'poll'}");
	$tvotes++;


	chmod 0777, "$fn";

	$Flag = 1;
	
	&DisplayResults;
}

sub DisplayResults {
	$fn = $CONFIG{'data_dir'} . "/cforums/polls/" . $FORM{'poll'} . ".txt";

	if ($Flag != 1) {
		open (VF,"$fn");
		@lines = <VF>;
		chop @lines;
		close VF;

		$Count = 1;

		foreach $nline (@lines) {
			(@t) = split(/::/, $nline);
			$votes{$t[0]} = $t[1];
			$tvotes = $Votes + $votes{$t[0]};
			$Count++;
		}
	}
	
	
	if ($tvotes != 0) {
		foreach $l (sort keys %votes) {
			$Percentage{$l} = (int(($votes{$l} / $tvotes) * 100));
			$length = ($Percentage{$l} * 2) + 1;
			$VOTELINES .= "<tr><td>$l</td><td align=center>$votes{$l}</td><td align=center>$Percentage{$l}\%</td><TD><IMG SRC=\"$CONFIG{'button_dir'}/bar.gif\" height=10 width=$length></tr>\n";
		}
	}
	
	
	$BODY .= "<table border=2>\n";
	$BODY .= "<tr><td><b>Selection</b></td><td align=center><b>No. Votes</b></td><td align=center><b>Percentage</b></td><TD><BR></TD></tr>\n";
	
	$BODY .= "$VOTELINES\n";

	$BODY .= "<TR><TD COLSPAN=4><CENTER><b>Total Votes Cast So Far: $tvotes</b></CENTER></TD></TR>\n";
	$BODY .= "</table>\n";

	$BODY .= "</body>\n";
	$BODY .= "</html>\n";
}

sub Error {
	local ($Error) = @_;

	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Error!</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$FORM{'text'}_color\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";

	if ($Error eq "No Duplicate Voting") {
		$BODY .= "<center><h3>Error: No Duplicate Voting!</h3></center>\n";
		$BODY .= "Sorry, you can only vote once on a particular topic.<p>\n";
	}
	if ($Error eq "No Option Specified") {
		$BODY .= "<center><h3>Error: No Option Specified!</h3></center>\n";
		$BODY .= "No option was specified, there was an error with the form you used to vote.<p>\n";
	}
	if ($Error eq "No Topic Specified") {
		$BODY .= "<center><h3>Error: No Topic Specified!</h3></center>\n";
		$BODY .= "No topic was specified, there was an error with the form you used to vote.<p>\n";
	}

	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');
}





