#!/usr/bin/perl

###############################################################
#                                                             #
# Any use of this program is entirely at the risk of the      #
# user. No liability will be accepted by the author.          #
#                                                             #
# This code must not be distributed or sold, even in modified #
# form, without the written permission of the author.         #
#                                                             #
###############################################################

###############################################################
#                                                             #
# Nothing below needs to be modified. You can apply           #
# modifications if you know what you are doing. Remember that #
# all credits must remain intact.                             #
#                                                             #
###############################################################

# Locate and load required files
eval {
	# Get the script location (for UNIX and Windows)
	($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");

	# Get the script location (for Windows)
	($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");

	# Load files
	require "settings.cgi";
	require "common.sub";
};

# Read the form
&readform;

# Get update, reset, clearance times
require "$membpath/timer.log";

# Get current time
$curtime = time();

# Set internal script reference
$fromscript = 1;

# Reset IP Log
require "$path/ipreset.cgi" if (!$usecrontab && $iptime && $curtime - $iplog >= $iptime);

# Check if member file exists
unless (-e "$membpath/$FORM{'id'}.cgi") {
	push(@badfields, 14);
	&formerror;
}

# Read IP Log
&readiplog;

# Check for duplicate incoming hits
unless (grep(/^$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tin/, @iploginfo) || !$ENV{'HTTP_REFERER'} || $ENV{'HTTP_REFERER'} =~ /$scripturl/i) {

	# Update IP Log
	open(IPS,">>$membpath/ip.log") || err("Could not update $membpath/ip.log: $!");
	flock(IPS,2);
	seek(IPS,0,2);
	print IPS "$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tin\n";
	close(IPS);

	# Update member file
	open(PROFILE,"+<$membpath/$FORM{'id'}.cgi") || err("Could not update $FORM{'id'}.cgi: $!");
	flock(PROFILE,2);
	@mprofile = <PROFILE>;
	chomp(@mprofile);
	$mprofile[12]++;
	$mprofile[13] = $curtime;
	seek(PROFILE,0,0);
	truncate(PROFILE,0);
	foreach $line(@mprofile) {
		print PROFILE "$line\n";
	}
	close(PROFILE);
}

# Process rating
if ($FORM{'action'} eq "applyrating") {
	&applyrating;
}

# Open member profile
open(PROFILE,"$membpath/$FORM{'id'}.cgi") || err("Could not open $FORM{'id'}.cgi: $!");
@mprofile = <PROFILE>;
close(PROFILE);
chomp(@mprofile);

# Load common vocabulary
require "$tmplpath/common.txt";

# Load Rating Form template
require "$tmplpath/rateform.tmpl";

# Rating Form
$FORM_SUB = qq(<div align="center">
  <h3><font face="$fontname" size="$fontsize"><b>$tempvoc[0]</b></font></h3>
  <form method="post" action="$scripturl/rate.cgi" name="adform">
    <input type="hidden" name="action" value="applyrating">
    <input type="hidden" name="id" value="$FORM{'id'}">
    <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
      <tr> 
        <td colspan="2" bgcolor="$headcolor"><font face="$sfontname" size="$sfontsize">$tempvoc[1]</font></td>
      </tr>
      <tr bgcolor="$primcolor" valign="top"> 
        <td nowrap><b><font face="$fontname" size="$fontsize">$tempvoc[2]</font></b></td>
        <td bgcolor="$primcolor"><font face="$fontname" size="$fontsize"><a href="$mprofile[4]" target="_blank"><b>$mprofile[5]</b></a><br>
          $mprofile[6]</font></td>
      </tr>
      <tr bgcolor="$seconcolor" valign="top"> 
        <td nowrap><b><font face="$fontname" size="$fontsize">$tempvoc[3]</font></b></td>
        <td> 
          <select name="rating" size="1">
            <option value="1">1 - $commonvoc[43]</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10 - $commonvoc[42]</option>
          </select>
        </td>
      </tr>
      <tr> 
        <td colspan="2" bgcolor="$headcolor"><font face="$sfontname" size="$sfontsize">$tempvoc[4]</font></td>
      </tr>
    </table>
    <br>
    <input type="submit" name="rate" value="$tempvoc[5]">
    <input type="submit" name="skip" value="$tempvoc[6]">
  </form>
</div>);

# Show selected rating
$FORM_SUB =~ s/<option value=\"$FORM{'rating'}\">/<option value=\"$FORM{'rating'}\" selected>/;

# Perform template substitutions
$temphtml =~ s/\{FORM\}/$FORM_SUB/g;

# Display the screen
&showscreen;


########################### SUBROUTINES ###########################


# Process Rating
sub applyrating {

	# Check referring URL
	&urlcheck;

	# Process vote
	if ($FORM{'rate'}) {

		# Check if the rating is valid
		unless ($FORM{'rating'} >= 1 && $FORM{'rating'} <= 10) {
			push(@badfields, 18);
			&formerror;
		}

		# Read IP Log
		&readiplog;

		# Check for duplicate votes
		if (grep(/^$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tvote/, @iploginfo)) {
			push(@badfields, 17);
			&formerror;

		# Record vote
		} else {

			# Update IP Log
			open(IPS,">>$membpath/ip.log") || err("Could not update $membpath/ip.log: $!");
			flock(IPS,2);
			seek(IPS,0,2);
			print IPS "$ENV{'REMOTE_ADDR'}\t$FORM{'id'}\tvote\n";
			close(IPS);

			# Update member file
			open(PROFILE,"+<$membpath/$FORM{'id'}.cgi") || err("Could not update $FORM{'id'}.cgi: $!");
			flock(PROFILE,2);
			@mprofile = <PROFILE>;
			chomp(@mprofile);
			$mprofile[9]++;
			$mprofile[10] = $curtime;
			$mprofile[11] += $FORM{'rating'};
			seek(PROFILE,0,0);
			truncate(PROFILE,0);
			foreach $line(@mprofile) {
				print PROFILE "$line\n";
			}
			close(PROFILE);

			# Show success screen
			&confirm(7, 8, "$scripturl/index.cgi");
		}

	# Redirect to Top List
	} else {
		print "Location:$scripturl/index.cgi\n\n";
	}
}


# Read IP Log
sub readiplog {
	open(IPS,"$membpath/ip.log") || err("Could not open $membpath/ip.log: $!");
	@iploginfo = <IPS>;
	close(IPS);
}