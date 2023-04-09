#!/usr/bin/perl

# If you are running this script under mod_perl or windows NT, please fill in the following variable.
# This variable should contain the data path to this directory.
# Example:
# $path = "/www/root/website/cgi-bin/bidsearch/"; # With a slash at the end as shown
my $path = ""; # With a slash at the end

#### Nothing else needs to be edited ####

# Bid Search Engine by Done-Right Scripts
# Admin Script
# Version 2.0
# WebSite:  http://www.done-right.net
# Email:    support@done-right.net
# 
# Please edit the variables below.
# Please refer to the README file for instructions.
# Any attempt to redistribute this code is strictly forbidden and may result in severe legal action.
# Copyright © 2002 Done-Right. All rights reserved.
###############################################


###############################################
use vars qw(%config %FORM $inbuffer $qsbuffer $buffer @pairs $pair $name $value %semod);
use CGI::Carp qw(fatalsToBrowser);
undef %config;
local %config = ();
do "${path}config/config.cgi";
if ($config{'modperl'} == 1) {
	eval("use Apache"); if ($@) { die "The Apache module used for mod_perl appears to not be installed"; }
}
my $file_ext = "$config{'extension'}";
if ($config{'data'} eq "mysql") { do "${path}functions_mysql.$file_ext"; }
else { do "${path}functions_text.$file_ext"; }
do "${path}functions.$file_ext";
&main_functions::checkpath('customize', $path);
###############################################


###############################################
local (%FORM, $inbuffer, $qsbuffer, $buffer, @pairs, $pair, $name, $value);
read(STDIN, $inbuffer, $ENV{'CONTENT_LENGTH'});
$qsbuffer = $ENV{'QUERY_STRING'};
foreach $buffer ($inbuffer,$qsbuffer) {
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		#$value =~ s/<!--(.|\n)*-->//g;
		$value =~ s/~!/ ~!/g; 
		#$value =~ s/<([^>]|\n)*>//g;
		$FORM{$name} = $value;
	}
}

#logics
if ($FORM{'tab'} eq "custpage") { &custpage(); }
elsif ($FORM{'tab'} eq "selecthtml") { &selecthtml(); }
elsif ($FORM{'tab'} eq "htmlpage") { &htmlpage(); }
elsif ($FORM{'tab'} eq "selectemail") { &selectemail(); }
elsif ($FORM{'tab'} eq "startpage") { &startpage(); }
elsif ($FORM{'tab'} eq "resultspage") { &resultspage(); }
elsif ($FORM{'tab'} eq "searchbox") { &searchbox(); }
elsif ($FORM{'tab'} eq "frames") { &frames(); }
elsif ($FORM{'tab'} eq "writeframes") { &writeframes(); }
else { &customize(); }
###############################################


###############################################
#Main Sub
sub customize {
my $text = $_[0];
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Templates</U></B></font><P>
<center>$text
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=selecthtml&user=$FORM{'user'}&file=bidsearchengine">Customize HTML Pages</a></td>
<td width="65%"><font face="verdana" size="-1">Customize the html code for various pages.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=selectemail&user=$FORM{'user'}&file=bidsearchengine">Customize Email Pages</a></td>
<td width="65%"><font face="verdana" size="-1">Customize various email message text.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=searchbox&user=$FORM{'user'}&file=bidsearchengine">Search Box</a></td>
<td width="65%"><font face="verdana" size="-1">Create a small search box that can be put anywhere on your site or your visitors sites.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=frames&user=$FORM{'user'}&file=bidsearchengine">Framed Results</a></td>
<td width="65%"><font face="verdana" size="-1">Display the search results in a frame so that the user never leaves your site.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub selecthtml {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize HTML Pages</U></B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Search Pages</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=startpage&user=$FORM{'user'}&file=bidsearchengine&page=Search+Start+Page&htmlfile=searchstart">Start Page</a></td>
<td width="65%"><font face="verdana" size="-1">Initial page at when you goto search.$file_ext.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=resultspage&user=$FORM{'user'}&file=bidsearchengine&page=Search+Results+Page&htmlfile=searchresults">Results Page</a></td>
<td width="65%"><font face="verdana" size="-1">Search results page.</font></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Signup Pages</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Signup+Page+1&htmlfile=signup">First Page</a></td>
<td width="65%"><font face="verdana" size="-1">Enter search listings page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Signup+Page+2&htmlfile=signup2">Second Page</a></td>
<td width="65%"><font face="verdana" size="-1">Enter contact information page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Signup+Page+3&htmlfile=signup3">Third Page</a></td>
<td width="65%"><font face="verdana" size="-1">Enter credit information page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Signup+Confirmation&htmlfile=signup4">Confirmation Page</a></td>
<td width="65%"><font face="verdana" size="-1">Confirms order.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Check+Bids&htmlfile=checkbid">Check Bids</a></td>
<td width="65%"><font face="verdana" size="-1">Allows a user to easily check the amount of bids for a given term.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Search+Term+Suggestion&htmlfile=suggestion">Search Term Suggestion</a></td>
<td width="65%"><font face="verdana" size="-1">If you have the option enabled to log keywords, members can type in a keyword to get search term suggestions for their listings.</font></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Members Pages</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Login+Page&htmlfile=login">Login Page</a></td>
<td width="65%"><font face="verdana" size="-1">Member login Page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Main+Page&htmlfile=members">Main Page</a></td>
<td width="65%"><font face="verdana" size="-1">Members main page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Forgot+Password+Page&htmlfile=forgot">Forgot Password Page</a></td>
<td width="65%"><font face="verdana" size="-1">Forgot password message page.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Message+Page&htmlfile=message">Message Page</a></td>
<td width="65%"><font face="verdana" size="-1">Displays message.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Statistics+Page&htmlfile=statistics">Statistics Page</a></td>
<td width="65%"><font face="verdana" size="-1">Members statistics.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Modify+Profile+Page&htmlfile=profile">Profile Page</a></td>
<td width="65%"><font face="verdana" size="-1">Modify profile information.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Update+Balance+Page&htmlfile=balance">Update Balance Page</a></td>
<td width="65%"><font face="verdana" size="-1">Add money to balance.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Update+Bids+Page&htmlfile=bids">Update Bids Page</a></td>
<td width="65%"><font face="verdana" size="-1">Add or subtract from current bid listings.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Manage+Listings+Page&htmlfile=manage">Manage Listings Page</a></td>
<td width="65%"><font face="verdana" size="-1">Links to add, edit and delete listings.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Add+Listings+Page&htmlfile=add">Add Listings Page</a></td>
<td width="65%"><font face="verdana" size="-1">Add new search listings.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Edit+Listings+Page&htmlfile=edit">Edit Listings Page</a></td>
<td width="65%"><font face="verdana" size="-1">Edit existing search listings.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Delete+Listings+Page&htmlfile=delete">Delete Listings Page</a></td>
<td width="65%"><font face="verdana" size="-1">Delete existing search listings.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Non-Targeted+Listings+Page&htmlfile=nontargeted">Non-Targeted Listings Page</a></td>
<td width="65%"><font face="verdana" size="-1">Add/Edit non-targeted bid listings.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub selectemail {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Email Messages</U></B></font><P>
<center>
<table width=70% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Signup Emails</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Signup+Email&htmlfile=emailsignup">Signup Message</a></td>
<td width="65%"><font face="verdana" size="-1">Message to let user know you received their order.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Member+Approved+Email&htmlfile=emailapprove">Member Approved</a></td>
<td width="65%"><font face="verdana" size="-1">Order processed and member online notification.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Member+Denied+Email&htmlfile=emaildenied">Member Denied</a></td>
<td width="65%"><font face="verdana" size="-1">Order not processed email.</font></td>
</tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr>
<td colspan=2><font face="verdana" size="-1"><B>Members Emails</B></font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Updated+Balance+Email&htmlfile=emailaddonbalance">Updated Balance Message</a></td>
<td width="65%"><font face="verdana" size="-1">Confirms to the member that you have received their order to addon to their balance.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Listing+OutBidded+Email&htmlfile=emailoutbid">Listing OutBidded</a></td>
<td width="65%"><font face="verdana" size="-1">Message to let member know that another member has outbidded their current listing & taken their position.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Removed+Listings+Email&htmlfile=emailremove">Removed Listings</a></td>
<td width="65%"><font face="verdana" size="-1">Message to let member know their balance has depleted and their listings are offline.</font></td>
</tr>
<tr>
<td width="35%"><font face="verdana" size="-1"><a href="customize.$file_ext?tab=htmlpage&user=$FORM{'user'}&file=bidsearchengine&page=Balance+Low+Warning+Email&htmlfile=emailwarning">Balance Low Warning</a></td>
<td width="65%"><font face="verdana" size="-1">Warns member that their balance is nearly depleted.</font></td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
sub htmlpage {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}template/$FORM{'htmlfile'}.txt");
my @data = <FILE>;
close (FILE);
open (FILE, "${path}config/defaults.txt");
my @defs = <FILE>;
close (FILE);
my @disopt = split(/\|/, $defs[2]);
my $page = $FORM{'page'};
$page =~ tr/+/ /;
my @tag;
if ($FORM{'htmlfile'} eq "login") {
	$tag [0] = "&lt;!-- [error] --&gt;|Display any login error";
	$tag [1] = "&lt;!-- [error2] --&gt;|Display any forgot password error";
} elsif ($FORM{'htmlfile'} eq "members") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [created] --&gt;|Date of when account was created";
	$tag [3] = "&lt;!-- [depletion] --&gt;|Estimated amount of days of account depletion";
	$tag [4] = "&lt;!-- [costperday] --&gt;|Estimated average cost per day";
	$tag [5] = "&lt;!-- [balance] --&gt;|Current account balance";
} elsif ($FORM{'htmlfile'} eq "forgot") {
	$tag [0] = "&lt;!-- [email] --&gt;|Displays the email address that the password was sent to";
} elsif ($FORM{'htmlfile'} eq "message") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [message] --&gt;|Displays action success message";
} elsif ($FORM{'htmlfile'} eq "statistics") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [viewing] --&gt;|The date selected to view";
	$tag [3] = "&lt;!-- [options] --&gt;|Other dates that can be viewed";
	$tag [4] = "&lt;!-- [created] --&gt;|Date of when account was created";
	$tag [5] = "&lt;!-- [depletion] --&gt;|Estimated amount of days of account depletion";
	$tag [6] = "&lt;!-- [costperday] --&gt;|Estimated average cost per day";
	$tag [7] = "&lt;!-- [balance] --&gt;|Current account balance";
	$tag [8] = "&lt;!-- [viewing2] --&gt;|The date selected to view";
	$tag [9] = "&lt;!-- [listing] --&gt;|Used to display each statistic";
	$tag [10] = "&lt;!-- [keyword] --&gt;|Displays search term";
	$tag [11] = "&lt;!-- [clicks] --&gt;|Amount of click throughs for this search term";
	$tag [12] = "&lt;!-- [cost] --&gt;|Cost of this search term based on the bid and amount of clicks";
	$tag [13] = "&lt;!-- [totalclicks] --&gt;|Total click throughs for all search terms";
	$tag [14] = "&lt;!-- [totalcost] --&gt;|Total cost for all search terms";
} elsif ($FORM{'htmlfile'} eq "profile") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "[name]|Displays users name";
	$tag [3] = "[email]|Displays users email";
	$tag [4] = "[address1]|Displays users street address";
	$tag [5] = "[address2]|Displays users second address if they have one";
	$tag [6] = "[city]|Displays users city";
	$tag [7] = "[state]|Displays state or province";
	$tag [8] = "[zip]|Displays users zip code";
	$tag [9] = "[country]|Displays users country";
	$tag [10] = "[phone]|Displays users telephone number";
	$tag [11] = "&lt;!-- [error] --&gt;|Displays error message";
} elsif ($FORM{'htmlfile'} eq "balance") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "[chname]|Card holders name";
	$tag [3] = "[cctype]|Credit card type";
	$tag [4] = "[expire]|Credit card expiration date";
	$tag [5] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [6] = "&lt;!-- [currentbalance] --&gt;|Current balance";
} elsif ($FORM{'htmlfile'} eq "bids") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [3] = "&lt;!-- [listing] --&gt;|Used to display each listing";
	$tag [4] = "&lt;!-- [keyword] --&gt;|Displays search term";
	$tag [5] = "&lt;!-- [position] --&gt;|Current position of search term";
	$tag [6] = "&lt;!-- [bidtobe1] --&gt;|Amount required to be the #1 position";
	$tag [7] = "&lt;!-- [listing] --&gt;|Used to display each listing";
	$tag [8] = "[newbid]|Current bid for search term";
	$tag [9] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "manage") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
} elsif ($FORM{'htmlfile'} eq "add") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [3] = "&lt;!-- [displaylistings] --&gt;|Used to display the amount of site listings";
	$tag [4] = "&lt;!-- [numb] --&gt;|Displays listing number";
	$tag [5] = "&lt;!-- [listerror] --&gt;|Displays listing error message";
	$tag [6] = "&lt;!-- [copy] --&gt;|Used to display Copy Previous Information Checkbox";
	$tag [7] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "nontargeted") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [3] = "&lt;!-- [listerror] --&gt;|Displays listing error message";
	$tag [4] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "edit") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [3] = "&lt;!-- [displaylistings] --&gt;|Used to display the amount of site listings";
	$tag [4] = "&lt;!-- [numb] --&gt;|Displays listing number";
	$tag [5] = "&lt;!-- [listerror] --&gt;|Displays listing error message";
	$tag [6] = "[keyword]|Displays search term";
	$tag [7] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "delete") {
	$tag [0] = "[user]|Displays username";
	$tag [1] = "[pass]|Displays crypted password";
	$tag [2] = "&lt;!-- [displaylistings] --&gt;|Used to display the amount of site listings";
	$tag [3] = "&lt;!-- [numb] --&gt;|Displays listing number";
	$tag [4] = "&lt;!-- [keyword] --&gt;|Displays search term";
	$tag [5] = "&lt;!-- [title] --&gt;|Displays title";
	$tag [6] = "&lt;!-- [description] --&gt;|Displays description";
	$tag [7] = "&lt;!-- [url] --&gt;|Displays url";
	$tag [8] = "&lt;!-- [bid] --&gt;|Displays bid amount";
	$tag [9] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "signup") {
	$tag [0] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [1] = "&lt;!-- [displaylistings] --&gt;|Used to display the amount of site listings";
	$tag [2] = "&lt;!-- [numb] --&gt;|Displays listing number";
	$tag [3] = "&lt;!-- [listerror] --&gt;|Displays listing error message";
	$tag [4] = "&lt;!-- [copy] --&gt;|Used to display Copy Previous Information Checkbox";
	$tag [5] = "&lt;!-- [currency] --&gt;|Displays default currency (obtained from default options)";
} elsif ($FORM{'htmlfile'} eq "signup2") {
	$tag [0] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [1] = "&lt;!-- [signup1] --&gt;|Carries variables from the first signup page";
} elsif ($FORM{'htmlfile'} eq "signup3") {
	$tag [0] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [1] = "&lt;!-- [signup1] --&gt;|Carries variables from the first signup page";
	$tag [2] = "&lt;!-- [signup2] --&gt;|Carries variables from the second signup page";
	$tag [3] = "&lt;!-- [balance] --&gt;|Displays minimum balance allowed to order";
} elsif ($FORM{'htmlfile'} eq "checkbid") {
	$tag [0] = "[searchterm]|Search term checked";
	$tag [1] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [2] = "&lt;!-- [list] --&gt;|Used to list the table to display the bids";
	$tag [3] = "&lt;!-- [displaylistings] --&gt;|Used to display each listing found";
	$tag [4] = "&lt;!-- [position] --&gt;|Current position of listing";
	$tag [5] = "&lt;!-- [url] --&gt;|URL of listing";
	$tag [6] = "&lt;!-- [title] --&gt;|Title of listing";
	$tag [7] = "&lt;!-- [bid] --&gt;|Bid amount for listing";
} elsif ($FORM{'htmlfile'} eq "suggestion") {
	$tag [0] = "[searchterm]|Search term checked";
	$tag [1] = "&lt;!-- [error] --&gt;|Displays error message";
	$tag [2] = "&lt;!-- [list] --&gt;|Used to list the table to display the bids";
	$tag [3] = "&lt;!-- [displaylistings] --&gt;|Used to display each listing found";
	$tag [4] = "&lt;!-- [count] --&gt;|Number of searches performed for keyword";
	$tag [5] = "&lt;!-- [term] --&gt;|Search term suggested";
} elsif ($FORM{'htmlfile'} eq "emailaddonbalance") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[balance]|Current balance";
	$tag [2] = "[totalbalance]|Displays members total balance as a result of their addon amount";
	$tag [3] = "[username]|Members username";
	$tag [4] = "[password]|Members password";
	$tag [5] = "[loginurl]|Member login url";
	$tag [6] = "[company]|Company name taken from the variable configuration section";
	$tag [7] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailapprove") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[username]|Members username";
	$tag [2] = "[password]|Members password";
	$tag [3] = "[loginurl]|Member login url";
	$tag [4] = "[company]|Company name taken from the variable configuration section";
	$tag [5] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emaildenied") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[company]|Company name taken from the variable configuration section";
	$tag [2] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailoutbid") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[searchterm]|Search term that was out bidded";
	$tag [2] = "[oldposition]|Listings old position before out bidded";
	$tag [3] = "[newposition]|Listings new position as a result of being out bidded";
	$tag [4] = "[members]|Member login url";
	$tag [5] = "[company]|Company name taken from the variable configuration section";
	$tag [6] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailremove") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[members]|Member login url";
	$tag [2] = "[company]|Company name taken from the variable configuration section";
	$tag [3] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailsignup") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[username]|Members username";
	$tag [2] = "[address]|Members address";
	$tag [3] = "[city]|Members city";
	$tag [4] = "[state]|Members state or province";
	$tag [5] = "[country]|Members country";
	$tag [6] = "[zip]|Members zip code";
	$tag [7] = "[phone]|Members phone number";
	$tag [8] = "[amount]|Amount ordered";
	$tag [9] = "[company]|Company name taken from the variable configuration section";
	$tag [10] = "[url]|WebSite URL taken from the variable configuration section";
} elsif ($FORM{'htmlfile'} eq "emailwarning") {
	$tag [0] = "[name]|Members name";
	$tag [1] = "[date]|Current date";
	$tag [2] = "[balance]|Current balance";
	$tag [3] = "[avg]|Average cost per day";
	$tag [4] = "[days]|Estimated days of depletion";
	$tag [5] = "[members]|Member login url";
	$tag [6] = "[company]|Company name taken from the variable configuration section";
	$tag [7] = "[url]|WebSite URL taken from the variable configuration section";
}
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize</U> - <font color=red>$page</font></B></font>
<center><P>

<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.$file_ext?tab=custpage&user=$FORM{'user'}&file=bidsearchengine"><BR>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=100 WRAP="OFF">
EOF

foreach my $line(@data) {
	chomp($line);
	$line =~ s/<\/TEXTAREA>/&lt;\/TEXTAREA>/ig;
	print "$line\n";
}

print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="$FORM{'htmlfile'}">
<input type=submit value="Save">
</form>
<BR>
<table width=90% border="0" cellspacing="2" cellpadding="0">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag] and most of them are self explanatory.
</center></td></tr>
EOF
foreach my $line(@tag) {
	my @inner = split(/\|/, $line);
print <<EOF;
<tr>
<td width="35%"><font face="verdana" size="-1">$inner[0]</td>
<td width="55%"><font face="verdana" size="-1">$inner[1]</td>
</tr>
EOF
}

print <<EOF;
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Customize Start Page
sub startpage {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}template/searchstart.txt");
my @data = <FILE>;
close (FILE);
open (FILE, "${path}config/defaults.txt");
my @defs = <FILE>;
close (FILE);
my @disopt = split(/\|/, $defs[2]);
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Start Page</U></B></font>
<center><P>
<form METHOD="POST" ACTION="customize.$file_ext?tab=custpage&user=$FORM{'user'}&file=bidsearchengine">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><center>
<table width="30%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><center><font face="verdana" size="-1" color="#000066"><B>Display Options</td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Advanced Options:
<td width=5% align=right><input TYPE="checkbox" NAME="Advanced" $disopt[0]></td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Selectable Engines:</td>
<td width=5% align=right><input TYPE="checkbox" NAME="Engines" $disopt[1]></td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Popular Searches:</td>
<td width=5% align=right><input TYPE="checkbox" NAME="Popular" $disopt[2]></td></tr>

<tr><td width=25%><font face="verdana" size="-1">Display Categories:</td>
<td width=5% align=right><input TYPE="checkbox" NAME="Categories" $disopt[3]></td></tr>

<tr><td colspan=2><center><input TYPE="submit" VALUE="Save"></td></tr>

</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<input type=hidden name=type value="display">
<input type=hidden name=file2 value="searchstart">
<input type=hidden name=filename value="Start">
</form>
</font></B><P>
<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.$file_ext?tab=custpage&user=$FORM{'user'}&file=bidsearchengine"><BR>
<center><font face="verdana" size="-1"><TEXTAREA NAME="code" ROWS=40 COLS=100 WRAP="Off">
EOF

foreach my $line(@data) {
	chomp($line);
	print "$line\n";
}

print <<EOF;
</TEXTAREA><BR><BR>
<input type=hidden name=file2 value="searchstart">
<input type=hidden name=filename value="Start">
<input type=submit value="Save">
</form>
<BR>
<table width=90% border="0" cellspacing="2" cellpadding="0">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag].
<BR><font color="#000066"></center>It is not recommended you delete these tags.  You can choose not to display a certain item by using the display options that are above.</b></td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [timeout] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays the Default Timeout Value</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [perpage] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays the Default Results per Page Value</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Engines] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Selectable Engines in between the &lt;!-- [Engines] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [display engines] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays Selectable Engines</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Popular] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Popular Searches in between the &lt;!-- [Popular] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Advanced] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Advanced Options in between the &lt;!-- [Advanced] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Categories] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Contains Search Categories in between the &lt;!-- [Categories] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [Popular Searches] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays Popular Searches</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Customize Results Page
sub resultspage {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
open (FILE, "${path}template/searchresults.txt");
my @data = <FILE>;
close (FILE);
my $break = "@data";
my @break = split(/<\!-- \[break\] -->/, $break);
open (FILE, "${path}config/defaults.txt");
my @defs = <FILE>;
close (FILE);
my @disopt = split(/\|/, $defs[3]);
print <<EOF;
<font face="verdana" size="-1"><B><U>Customize Results Page</U></B></font>
<center><P>
<form METHOD="POST" ACTION="customize.$file_ext?tab=custpage&user=$FORM{'user'}&file=bidsearchengine">
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td><center>
<table width="40%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr><td colspan=2><center><font face="verdana" size="-1" color="#000066"><B>Display Options</td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Selectable Engines (top of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="EnginesTop" $disopt[0]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Search Box (top of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="BoxTop" $disopt[1]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Selectable Engines (bottom of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="EnginesBottom" $disopt[2]></td></tr>

<tr><td width=35%><font face="verdana" size="-1">Display Search Box (bottom of page):</td>
<td width=5% align=right><input TYPE="checkbox" NAME="BoxBottom" $disopt[3]></td></tr>

<tr><td colspan=2><center><input TYPE="submit" VALUE="Save"></td></tr>

</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
<input type=hidden name=page value="results">
<input type=hidden name=type value="display">
<input type=hidden name=file2 value="searchresults">
<input type=hidden name=filename value="Results">
</form>
</font></B><P>
<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face="verdana" size="-1" color="#000066"><B>Customize Code</B></font></center>
<form METHOD="POST" ACTION="customize.$file_ext?tab=custpage&user=$FORM{'user'}&file=bidsearchengine"><BR>
<center><font face="verdana" size="-1" color="#000066"><B>Top Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="topcode" ROWS=30 COLS=100 WRAP="off">
EOF
my @newbreak = split(/\n/, $break[0]);
foreach my $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
my $infotitle = "Result Information & Related Search";
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>$infotitle Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="infocode" ROWS=10 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[1]);
foreach my $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>Search Results Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="resultscode" ROWS=10 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[2]);
foreach my $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<center><font face="verdana" size="-1" color="#000066"><B>Bottom Code</B></font></center>
<center><font face="verdana" size="-1"><TEXTAREA NAME="bottomcode" ROWS=30 COLS=100 WRAP="off">
EOF
@newbreak = split(/\n/, $break[3]);
foreach my $line(@newbreak) {
	chomp($line);
	print "$line\n";
}
print <<EOF;
</TEXTAREA><P>
<input type=hidden name=file2 value="searchresults">
<input type=hidden name=filename value="Results">
<input type=submit value="Save">
</form>
<table width=90% border="0" cellspacing="0" cellpadding="1">
<tr><td colspan=2><b><font face="verdana" size="-1"><center>The following html tags are used to display a specific item.  Usually the tags look like this &lt;!-- [tag] --&gt; or [tag].
<BR>You can choose to delete any tag in order to not display the item.</b></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">$infotitle Tags:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [first] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Start of your Search</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [last] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the End of your Search</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [found] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the number of results found</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [view] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays sorting links</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [wordfilter] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the amount of Family Filtered results there were</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [description] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Hide/Show Results Link</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [target] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Display Target Result(s)</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [relatedtitle] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">If Related words are found, it displays "Related:"</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [relatedrow] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the related keywords in between the <font color=red>&lt;!-- [relatedbreak] --&gt;</font> tags</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">Search Results Tags:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [number] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Number</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [url] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results URL</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [title] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Title</td></tr>
EOF
undef %semod;
local %semod = ();
do "${path}template/Web.cgi";
my $desvals = "$semod{'descripvars'}";
my @des = split(/\|/, $desvals);
unless ($des[0] eq "") {
	foreach my $line2(@des) {
print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [$line2] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results $line2</td></tr>
EOF
	}
} else {
print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [description] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results description</td></tr>
EOF
}

print <<EOF;
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [Source] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Search Results Source or the Bid Amount</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [biduser] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the the bid members username</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">More Results Links & Timeout:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [nextform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Next Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [prevform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Previous Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [numberform] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Link Code for Numbered Results</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EngTimedout] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Engines that Timedout</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">These tags can be placed anywhere but it is not recommended you delete these tags.  You can choose not to display a certain item by using the display options that are above.</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [timeout] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Default Timeout Value</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [perpage] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Used to display the page</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [BoxTop] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the top Search Box between the &lt;!-- [BoxTop] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [BoxBottom] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the bottom Search Box between the &lt;!-- [BoxBottom] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EnginesTop] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the top Selectable Engines between the &lt;!-- [EnginesTop] --&gt; tags</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [EnginesBottom] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Contains the bottom Selectable Engines between the &lt;!-- [EnginesBottom] --&gt; tags</td></tr>
<tr><td width="35%"><font face="verdana" size="-1">&lt;!-- [display engines] --&gt;</td>
<td width="55%"><font face="verdana" size="-1">Displays Selectable Engines</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2><b><font face="verdana" size="-1" color="#000066">The following tags can be placed anywhere:</font></b></td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [keys] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays the Keywords Used</td></tr>
<tr><td width="35%" valign=top><font face="verdana" size="-1">&lt;!-- [banner] --&gt;</td>
<td width="55%" valign=top><font face="verdana" size="-1">Displays a Targeted Banner</td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write to Customized Page
sub custpage {
$FORM{'user'} = &main_functions::checklogin($FORM{user});

if ($FORM{'type'} eq "display") {
	open (FILE, "${path}config/defaults.txt");
	my @data2 = <FILE>;
	close (FILE);
	my (@defaults, $array, $distype, $p, $newdef);
	if ($FORM{'filename'} eq "Start") {
		@defaults = split(/\|/, $data2[2]);
		$array = "Advanced|Engines|Popular|Categories";
	} else {
		@defaults = split(/\|/, $data2[3]);
		$array = "EnginesTop|BoxTop|EnginesBottom|BoxBottom";
	}
	chomp(@defaults);
	my @array2 = split(/\|/, $array);
	foreach (@array2) {
		$distype = "$array2[$p]";
		my $distype2 = $$distype;
		if ($FORM{$distype} eq "on") {
			$distype2 = "CHECKED";
		} else {
			$distype2 = "";
		}
	
		unless ($defaults[$p] eq $distype2) {
			$defaults[$p] = "$distype2";
			my $page="";
			open (FILE, "${path}template/$FORM{'file2'}.txt");
			my @data = <FILE>;
			close (FILE);
			foreach my $line(@data) {
				chomp($line);
				$page .= $line;
			}
			my @split = split(/<\!-- \[$distype\] -->/, $page);
			&$distype($distype2, @split);
		}
		if ($p == 0) { $newdef .= "$defaults[$p]"; }
		else { $newdef .= "|$defaults[$p]"; }
		$p++;
	}
	chomp (@data2);
	open (FILE, ">${path}config/defaults.txt");
	print FILE "$data2[0]\n";
	print FILE "$data2[1]\n";
	if ($FORM{'filename'} eq "Start") {
		print FILE "$newdef\n";
		print FILE "$data2[3]\n";
	} else {
		print FILE "$data2[2]\n";
		print FILE "$newdef\n";
	}
	print FILE "$data2[4]";
	close (FILE);

	sub EnginesTop {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesTop] -->
                  <!-- [display engines] -->
                  <!-- [EnginesTop] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesTop] -->

                  <!-- [EnginesTop] -->
$split[2]
EOF
		}
		close (FILE2);
	}

	sub EnginesBottom {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesBottom] -->
                  <!-- [display engines] -->
                  <!-- [EnginesBottom] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [EnginesBottom] -->

                  <!-- [EnginesBottom] -->
$split[2]
EOF
		}
		close (FILE2);
	}

	sub BoxTop {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxTop] -->
                  <form METHOD="POST" ACTION="search.[ext]?results&page=1">
                  <input type=text name=keywords size=25 value="<!-- [keys] -->">
                  &nbsp;&nbsp;&nbsp;<input type=submit value=" Search "><BR>
                  <font face="verdana, helvetica" size="-1">
                  <input type="radio" name="method" value="1"> any 
                  <input type="radio" name="method" value="0" checked> all 
                  <input type="radio" name="method" value="2"> phrase 
                  </font><BR><BR>
                  <!-- [BoxTop] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxTop] -->

                  <!-- [BoxTop] -->
$split[2]
EOF
		}
		close (FILE2);
	}

	sub BoxBottom {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxBottom] -->
                  <form METHOD="POST" ACTION="search.[ext]?results&page=1">
                  <input type=text name=keywords size=25 value="<!-- [keys] -->">
                  &nbsp;&nbsp;&nbsp;<input type=submit value=" Search "><BR>
                  <font face="verdana, helvetica" size="-1">
                  <input type="radio" name="method" value="1"> any 
                  <input type="radio" name="method" value="0" checked> all 
                  <input type="radio" name="method" value="2"> phrase 
                  </font><BR><BR>
                  <!-- [BoxBottom] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                  <!-- [BoxBottom] -->

                  <!-- [BoxBottom] -->
$split[2]
EOF
		}
		close (FILE2);
	}

	sub Popular {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                <!-- [Popular] -->
                <table BORDER=0 CELLSPACING=0 CELLPADDING=0>
                  <tr>
                    <td width="150">
                      <b><font face="verdana, helvetica" size=-1 color="#000099">
                      Popular Searches</font></b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <font face="verdana, helvetica" size="-1">
                      <!-- [Popular Searches] -->
                    </td>
                  </tr>
                </table>
                <!-- [Popular] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                <!-- [Popular] -->

                <!-- [Popular] -->
$split[2]
EOF
		}
		close (FILE2);
	}
	sub Advanced {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                <!-- [Advanced] -->
                <table BORDER=0 CELLSPACING=0 CELLPADDING=0 >
                  <tr>
                    <td>
                      <b><font face="verdana, helvetica" color="#000099" size=-1>
                      Advanced</font></b>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <font face="verdana, helvetica" size=-1>Show Summaries
                      <input TYPE="radio" NAME="descrip" VALUE="0" CHECKED>
                      <br><font face="verdana, helvetica" size=-1>
                      Hide Summaries<input TYPE="radio" NAME="descrip" VALUE="1"><BR>
                      <br><font face="verdana, helvetica" size=-1>
                      Timeout&nbsp;<select NAME="timeout" SIZE="1">
                      <option SELECTED><!-- [timeout] --><option>---<option>2<option>5<option>7<option>15
                      </select><BR>
                      <font face="verdana, helvetica" size=-1>
                      Results Per Page&nbsp;<select NAME="perpage" SIZE="1">
                      <option SELECTED><!-- [perpage] --><option>---<option>10<option>20<option>30<option>40<option>50
                      </select>
                      Family Filter: <input TYPE="checkbox" NAME="wordfilter">
                    </td>
                  </tr>
                </table>
                <!-- [Advanced] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                <!-- [Advanced] -->
                <input TYPE="hidden" NAME="descrip" VALUE="0">
                <input TYPE="hidden" NAME="timeout" VALUE="<!-- [timeout] -->">
                <input TYPE="hidden" NAME="perpage" VALUE="<!-- [perpage] -->">
                <!-- [Advanced] -->
$split[2]
EOF
		}
		close (FILE2);
	}
	sub Engines {
		my ($distype, @split) = @_;
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
print FILE2 <<EOF;
$split[0]
                <!-- [Engines] -->
                <!-- [display engines] -->
                <!-- [Engines] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
                <!-- [Engines] -->

                <!-- [Engines] -->
$split[2]
EOF
		}
		close (FILE2);
	}
	sub Categories {
		my ($distype, @split) = @_;
		open (FILE4, "${path}template/categories.txt");
		my @data3 = <FILE4>;
		close(FILE4);
		open (FILE2, ">${path}template/$FORM{'file2'}.txt");
		if ($distype eq "CHECKED") {
			my ($f, $c, $printhtml);
			foreach (@data3) {
				if ($f == 3) {
					$f=0;
					$printhtml .= "</tr><tr>";	
				}
				my @htmldata = split(/\|/, $data3[$c]);
				my $linkurl = $htmldata[0];
				$linkurl =~ tr/ /+/;
				$printhtml .= "<td><b><font face=verdana size=-1><a href=\"search.[ext]?keywords=$linkurl\">$htmldata[0]</a></b><BR><font size=-2>\n";
				my $d=0;
				foreach (@htmldata) {
					unless ($d == 0) {
						$linkurl = $htmldata[$d];
						$linkurl =~ tr/ /+/;
						$printhtml .= "<a href=\"search.[ext]?keywords=$linkurl\">$htmldata[$d]</a>\n";
					}
					$d++;
				}
				$printhtml .= "<BR>&nbsp;</td>\n";
				$c++;
				$f++;
			}
print FILE2 <<EOF;
$split[0]
<!-- [Categories] -->
<table BORDER=0 CELLSPACING=0 CELLPADDING=0 COLS=3 WIDTH=90%><tr>
$printhtml
</table>
<!-- [Categories] -->
$split[2]
EOF
		} else {
print FILE2 <<EOF;
$split[0]
<!-- [Categories] -->

<!-- [Categories] -->
$split[2]
EOF
		}
		close (FILE2);
	}

	my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>$FORM{'filename'} Page Customized</B></font></font>";
	&customize($text);
} else {
	open (FILE2, ">${path}template/$FORM{'file2'}.txt");
	if ($FORM{'file2'} eq "searchresults") {
		$FORM{'topcode'} =~ s/\r//g;
		$FORM{'infocode'} =~ s/\r//g;
		$FORM{'resultscode'} =~ s/\r//g;
		$FORM{'bottomcode'} =~ s/\r//g;
print FILE2 <<EOF;
$FORM{'topcode'}
<!-- [break] -->
$FORM{'infocode'}
<!-- [break] -->
$FORM{'resultscode'}
<!-- [break] -->
$FORM{'bottomcode'}
EOF
	} else {
		$FORM{'code'} =~ s/\r//g;
		$FORM{'code'} =~ s/&lt;\/TEXTAREA>/<\/TEXTAREA>/ig;
print FILE2 <<EOF;
$FORM{'code'}
EOF
	}
	close (FILE2);
	open (FILE, "${path}template/$FORM{'file2'}.txt");
	my @data = <FILE>;
	close (FILE);
	open (FILE, ">${path}template/$FORM{'file2'}.txt");
	foreach my $line(@data) {
		chomp($line);
		print FILE "$line\n";	
	}
	close (FILE);
	my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Page Customized</B></font></font>";
	&customize($text);
}
}
###############################################


###############################################
#Search Box
sub searchbox {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
print <<EOF;
<font face="verdana" size="-1"><B><U>Search Box</U></B></font><BR>
<center><P>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<form><BR><center>
<table width="90%"><tr><td>
<font face="verdana" size="-1"><center>Copy & paste the following to display a search box.  This search box can also 
be used for your visitors to put on their site.<BR>
</td></tr></table><font face="verdana" size="-1"><center><TEXTAREA NAME="code" ROWS=11 COLS=100>
<!-- Search Box -->
<form METHOD="POST" ACTION="$config{'adminurl'}search.$file_ext">
<input type=text name=keywords size=25><input type=submit value=" Search ">
</form>
<!-- Search Box -->
</TEXTAREA><BR><BR>
</form>
<BR>
</td>
</tr>
</table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Frame Redirection
sub frames {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
print "Content-type: text/html\n\n";
&main_functions::header(undef, $FORM{user});
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
print <<EOF;
<font face="verdana" size="-1"><B><U>Frame Redirection</U></B></font><BR>
<center><P>
<form METHOD="POST" ACTION="customize.$file_ext?tab=writeframes&user=$FORM{'user'}&file=bidsearchengine">
<center>
<table width=95% border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<table width="100%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000">
<tr>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="3" bgcolor="#CCCCCC">
<tr>
<td>
<center><font face=verdana size=-1 color="#000066"><B>Enable Frame Redirection: <input TYPE="checkbox" NAME="frame" $opt[3]></B><P>
<font face=verdana size=-1 color="#000066"><B>Customize Code for Frames</B><BR>
<TEXTAREA NAME="mainframe" ROWS=11 COLS=100 WRAP="off">
EOF
if (-e "${path}template/frame.txt") {
	open (FILE, "${path}template/frame.txt");
	my @DATA = <FILE>;
	close (FILE);
	foreach my $line(@DATA) {
		chomp($line);
		print "$line\n";
	}
} else {
print <<EOF;
<HTML>
<HEAD>
  <TITLE>Search</TITLE>
</HEAD>
<frameset rows="10%,*" frameborder=0 border=0 framespacing=0>
  <frame src="[topframe]" noresize name=top scrolling=no marginwidth=0 marginheight=0 frameborder=0>
  <frame src="[frameurl]" name="bottom" noresize marginwidth=0 marginheight=0 frameborder=0>
</frameset>
<noframes>
  <body bgcolor="#FFFFFF">
    <font face=verdana size="-1">If the page did not open, please <a href="[frameurl]"><b>Click Here</b></a>.
  </body>
</noframes>
</HTML>
EOF
}
print <<EOF;
</TEXTAREA><P>
<font face=verdana size=-1 color="#000066"><B>Customize Code for Top Frame</B><BR>
<TEXTAREA NAME="topframe" ROWS=11 COLS=100 WRAP="off">
EOF
if (-e "${path}template/topframe.txt") {
	open (FILE, "${path}template/topframe.txt");
	my @DATA = <FILE>;
	close (FILE);
	foreach my $line(@DATA) {
		chomp($line);
		print "$line\n";
	}
} else {
print <<EOF;
<HTML>
<HEAD>
  <TITLE>Search</TITLE>
</HEAD>
<BODY bgcolor="#000066" link=#999999 vlink=#999999>
<TABLE width="100%" bgcolor="#000066">
<TR><TD width="20%" valign=top><img src="images/framelogo.gif" border=0></TD>
<TD width="60%" valign=top>
<center><!-- [banner] -->
</TD>
<TD width="20%" align=right valign=top><font face=verdana size=-1 color=#999999><B>
<a href="[frameurl]" target="_top"><B>CLOSE FRAME</A>&nbsp;<BR>
<a href="[topframe]" target="_top"><B>BACK</A>&nbsp;
</font></B></TD></TR></TABLE>
</BODY>
</HTML>
EOF
}
print <<EOF;
</TEXTAREA><P>
<input type=submit value="Save">
</td></tr></table>
</td></tr></table>
</td></tr></table><BR><BR>
EOF
&main_functions::footer;
&main_functions::exit;
}
###############################################


###############################################
#Write Frame Redirection
sub writeframes {
$FORM{'user'} = &main_functions::checklogin($FORM{user});
my (@eng, @adv, @opt);
&main_functions::getdefaults(\@eng, \@adv, \@opt);
if ($FORM{'frame'} eq "on") { $FORM{'frame'} = "CHECKED"; }
else { $FORM{'frame'} = ""; }
my @newarray = splice(@opt,3,1,$FORM{'frame'});
my ($a, $opt);
foreach my $new(@opt) {
	chomp($new);
	if ($a == 0) { $opt = "$new"; }
	else { $opt .= "|$new"; }
	$a++;
}
open (FILE, "${path}config/defaults.txt");
my @data = <FILE>;
close (FILE);
chomp(@data);
open (FILE, ">${path}config/defaults.txt");
print FILE <<EOF;
$data[0]
$data[1]
$data[2]
$data[3]
$opt
EOF
close (FILE);

open (FILE, ">${path}template/frame.txt");
print FILE <<EOF;
$FORM{'mainframe'}
EOF
close (FILE);

open (FILE, ">${path}template/topframe.txt");
print FILE <<EOF;
$FORM{'topframe'}
EOF
close (FILE);

my $text = "<font face=verdana size=-1><B>Message:</B> <font color=red>Frame Redirection Customized</B></font></font>";
&customize($text);
}
###############################################