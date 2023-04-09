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

# Initialize start position
$FORM{'startat'} = 0;

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

# Reset member stats
require "$path/reset.cgi" if (!$usecrontab && $restime && $curtime - $reset >= $restime);

# Update Top List
require "$path/update.cgi" if (!$usecrontab && $updtime && $curtime - $update >= $updtime);

# Read the rankings
open(RANKINGS,"$membpath/lastupdate.log") || err("Could not update $membpath/lastupdate.log: $!");
@ranklist = <RANKINGS>;
close(RANKINGS);
chomp(@ranklist);

# Get the total number of sites
$totsites = scalar(@ranklist);

# Check if start position is valid
$FORM{'startat'} = 0 if $FORM{'startat'} < 0 || $FORM{'startat'} >= $totsites;

# Format dates
$last_update = &getdate($update, 1);
$next_reset  = &getdate($reset + $restime, 1) if $restime;

# Load common vocabulary
require "$tmplpath/common.txt";

# Load Top List template
require "$tmplpath/index.tmpl";

# Total number of sites
$TOT_SITES_SUB = qq(<font face="$fontname" size="$fontsize">$tempvoc[0] $totsites</font>);

# Date of last update
$UPD_DATE_SUB = qq(<font face="$fontname" size="$fontsize">$tempvoc[1] $last_update</font>);

# Date of next reset
$RES_DATE_SUB = qq(<font face="$fontname" size="$fontsize">$tempvoc[2] $next_reset</font>) if $restime;

# Member Area link
$MEMB_LINK_SUB = qq(<font face="$fontname" size="$fontsize"><a href="$scripturl/members.cgi">$tempvoc[3]</a></font>);

# Registration link
$REG_LINK_SUB = qq(<font face="$fontname" size="$fontsize"><a href="$scripturl/members.cgi?action=regterms">$tempvoc[4]</a></font>);

# Column span of Rank
$rank_span = 1 + $showimgindicator + $showtxtindicator;

# Build Top List rows
if (@ranklist) {

	# Initialize background row color
	$tmprowbg = $topprimcolor;

	# Loop through rankings list
	$endpos = $FORM{'startat'} + $sitesperpage - 1;
	$endpos = $totsites - 1 if $endpos >= $totsites;
	for ($i = $FORM{'startat'}; $i <= $endpos; $i++) {

		# Get member info
		@tmprankinfo = split(/\t/, $ranklist[$i]);

		# Position change graphic indicator
		if ($showimgindicator) {
			$poschange = $tmprankinfo[2] - $tmprankinfo[1];
			if ($tmprankinfo[2] && $poschange > 0) {
				$tmpgraphic = $gainimg;
			} elsif ($tmprankinfo[2] && $poschange < 0){
				$tmpgraphic = $lostimg;
			} else {
				$tmpgraphic = $nochangeimg;
			}
			$tmpimgindicator = qq(      <td> 
        <div align="center"><img src="$tmpgraphic"></div>
      </td>);
		}

		# Position change text indicator
		if ($showtxtindicator) {
			$poschange = $tmprankinfo[2] - $tmprankinfo[1];
			if ($tmprankinfo[2] && $poschange > 0) {
				$tmpcolor = $gaincolor;
				$poschange = "+" . $poschange;
			} elsif ($tmprankinfo[2] && $poschange < 0){
				$tmpcolor = $lostcolor;
			} else {
				$tmpcolor = $nochangecolor;
				$poschange = "-";
			}
			$tmptxtindicator = qq(      <td nowrap> 
        <div align="center"><font color="$tmpcolor" face="$fontname" size="$fontsize">$poschange</font></div>
      </td>);
		}

		# Flag
		$tmpflag = qq(<img src="$flagsurl/$tmprankinfo[3].gif" alt="$tmprankinfo[3]"> ) if $showflag;

		# Rate It! link
		$tmprateit = qq(<a href="$scripturl/rate.cgi?id=$tmprankinfo[0]"><font face="$fontname" size="$fontsize">$commonvoc[51]</font></a>) if $showrateit;

		# In
		$tmpin = qq(      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize">$tmprankinfo[6]</font></div>
      </td>) if $showin;

		# Out
		$tmpout = qq(      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize">$tmprankinfo[7]</font></div>
      </td>) if $showout;

		# Total hits
		$tmphitscalc = $tmprankinfo[6] + $tmprankinfo[7];
		$tmphits = qq(      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize">$tmphitscalc</font></div>
      </td>) if $showhits;

		# Votes
		$tmpvotes = qq(      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize">$tmprankinfo[8]</font></div>
      </td>) if $showvotes;

		# Rating
		$tmprating = sprintf("      <td nowrap> 
        <div align=\"center\"><font face=\"$fontname\" size=\"$fontsize\">%.2f</font></div>
      </td>", $tmprankinfo[9]) if $showrating;

		# Score
		$tmpscore = qq(      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize">$tmprankinfo[10]</font></div>
      </td>) if $showscore;

		# Complete row
		$tmprows .= qq(    <tr bgcolor="$tmprowbg" valign="top"> 
      <td nowrap> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$tmprankinfo[1]</b></font></div>
      </td>
$tmpimgindicator
$tmptxtindicator
      <td> 
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
          <tr> 
            <td>$tmpflag<font face="$fontname" size="$fontsize"><b><a href="$scripturl/redirect.cgi?id=$tmprankinfo[0]" target="_blank">$tmprankinfo[4]</a></b><br>
              $tmprankinfo[5]</font></td>
            <td valign="bottom" nowrap> 
              <div align="right">$tmprateit</div>
            </td>
          </tr>
        </table>
      </td>
$tmpin
$tmpout
$tmphits
$tmpvotes
$tmprating
$tmpscore
    </tr>);

		# Switch background row color
		if ($tmprowbg eq $topprimcolor) {
			$tmprowbg = $topseconcolor;
		} else {
			$tmprowbg = $topprimcolor;
		}
	}
} else {

	# Total column span
	$totspan = 2 + $showimgindicator + $showtxtindicator + $showin + $showout + $showhits + $showvotes + $showrating + $showscore;

	# Nothing to display
	$tmprows = qq(    <tr bgcolor="$topprimcolor" valign="top"> 
      <td nowrap colspan="$totspan"> 
        <div align="center"><font face="$fontname" size="$fontsize">$tempvoc[6]</font></div>
      </td>
    </tr>);
}

# Top List table
$TOP_LIST_SUB = qq(  <table width="$topwidth" border="$topborder" cellspacing="$topspacing" cellpadding="$toppadding" bordercolor="$topbordercolor">
    <tr bgcolor="$topheadcolor" valign="top"> 
      <td colspan="$rank_span"> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[44]</b></font></div>
      </td>
      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$tempvoc[5]</b></font></div>
      </td>
);
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[45]</b></font></div>
      </td>
) if $showin;
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[46]</b></font></div>
      </td>
) if $showout;
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[47]</b></font></div>
      </td>
) if $showhits;
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[48]</b></font></div>
      </td>
) if $showvotes;
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[49]</b></font></div>
      </td>
) if $showrating;
$TOP_LIST_SUB .= qq(      <td> 
        <div align="center"><font face="$fontname" size="$fontsize"><b>$commonvoc[50]</b></font></div>
      </td>
) if $showscore;
$TOP_LIST_SUB .= qq(    </tr>
$tmprows
  </table>);

if ($totsites) {

	# Viewing position indicator
	$POS_IND_SUB = sprintf("<font face=\"$fontname\" size=\"$fontsize\">$commonvoc[52] %d - %d $commonvoc[53] %d.</font>", $FORM{'startat'} + 1, $endpos + 1, $totsites);

	# Page breakdown links
	$PAGE_LINKS_SUB = qq(<font face="$fontname" size="$fontsize">$commonvoc[54]);
	$startpos = 0;
	$pagenum = 1;
	while ($startpos < $totsites) {
		if ($startpos eq $FORM{'startat'}) {
			$PAGE_LINKS_SUB .= qq( [$pagenum]);
		} else {
			$PAGE_LINKS_SUB .= qq( [<a href="$scripturl/index.cgi?startat=$startpos">$pagenum</a>]);
		}
		$startpos += $sitesperpage;
		$pagenum++;
	}
	$PAGE_LINKS_SUB .= "</font>";
}

# Perform template substitutions
$temphtml =~ s/\{TOT_SITES\}/$TOT_SITES_SUB/g;
$temphtml =~ s/\{UPD_DATE\}/$UPD_DATE_SUB/g;
$temphtml =~ s/\{RES_DATE\}/$RES_DATE_SUB/g;
$temphtml =~ s/\{MEMB_LINK\}/$MEMB_LINK_SUB/g;
$temphtml =~ s/\{REG_LINK\}/$REG_LINK_SUB/g;
$temphtml =~ s/\{TOP_LIST\}/$TOP_LIST_SUB/g;
$temphtml =~ s/\{POS_IND\}/$POS_IND_SUB/g;
$temphtml =~ s/\{PAGE_LINKS\}/$PAGE_LINKS_SUB/g;
&logstatus;

# Display the screen
&showscreen;
