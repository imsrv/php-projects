#!/usr/bin/perl
#########################################################
#     SafeList - A full pay to join Opt in mail site    #
#########################################################
#                                                       #
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Development Division.                  #
# http://www.perlcoders.com/                            #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright 2001              #
# PerlCoders (http://perlcoders.com) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on any site they own. There is no individual site     #
# license needed per site.                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################

use CGI ':cgi';
use Configs;
use Locking;

$action=param('a');
$pass=param('p');
$ref=param('ref');
$scripturl=$scriptdirurl."admin.cgi";

	if($pass ne $admin_pass) { &login; }
	# see what we do now
	if($action eq "main") { &main; }
	elsif($action eq "view") { &view; }
	elsif($action eq "add") { &add; }
	elsif($action eq "add_process") { &add_process; }
	elsif($action eq "mod") { &mod; }
	elsif($action eq "mod_process") { &mod_process; }
	elsif($action eq "del") { &del; }
	elsif($action eq "val") { &validate; }
	else { &login; }

sub main {
	$howmany=0;
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) { $howmany++; }
	open(PAGE, "templates/admin/main.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	$page_html =~ s/%howmany%/$howmany/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub view {
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	$output="<table cellpadding=2 cellspacing=2>\n";
	$output.="<tr>\n";
	$output.="<td><font size=-1><b>User</b></font></td>\n";
	$output.="<td><font size=-1><b>Name</b></font></td>\n";
	$output.="<td><font size=-1><b>Status</b></font></td>\n";
	$output.="<td><font size=-1><b>Actions</b></font></td>\n";
	$output.="</tr>\n";
	foreach $line (@in) {
		$realstatus="";
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($status eq "1") { $realstatus="Active"; } else { $realstatus="InActive"; }
		$output.="<tr>\n";
		$output.="<td><font size=-1>$ilogin</font></td>\n";
		$output.="<td><font size=-1>$iname</font></td>\n";
		$output.="<td><font size=-1>$realstatus</font></td>\n";
		$output.="<td><a href=\"mailto:$iemail\"><font size=-1>mail</font></a> 	<a href=$scripturl?p=$pass&action=mod&who=$ilogin><font size=-1>modify</font></a>  <a href=$scripturl?p=$pass&action=del&who=$ilogin><font size=-1>delete</font></a></td>\n";
		$output.="</tr>\n";
	}
	$output.="</table>\n";
	open(PAGE, "templates/admin/view.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	$page_html =~ s/%output%/$output/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub add {
	open(PAGE, "templates/admin/adduser.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	$page_html =~ s/%pass%/$pass/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub add_process {
	$zname=param('iname');
	$zemail=param('iemail');
	$zlogin=param('ilogin');
	$zpass=param('ipass');
	$zstatus=param('status');
	$zdayjoined=param('dayjoined');
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($iemail eq $zemail) {
			$response .= "That Email is already in our databases.<br>\n";
		}	
		if($ilogin eq $zlogin) {
			$response .= "The username $login is already taken.<br>\n";
		}	
	}
	open(IN2, "$scriptdir/dbase/holding.txt");
	chomp(@in2=<IN2>);
	close(IN2);
	foreach $line2 (@in2) {
		($id, $iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line2);
		if($iemail eq $zemail) {
			$response .= "That Email is already in our databases.<br>\n";
		}
		if($ilogin eq $zlogin) {
			$response .= "The username $login is already taken.<br>\n";
		}
	}
	if($response ne "") {
		open(PAGE, "templates/admin/error.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%scripturl%/$scripturl/gi;
		$page_html =~ s/%pass%/$pass/gi;
		$page_html =~ s/%reason%/$response/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		$dyj=time();
		open(OUT, ">>$scriptdir/dbase/users.txt");
		&LockDB(OUT);
		print OUT "$zname|$zemail|$zlogin|$zpass|$zstatus|$dyj\n";
		&UnlockDB(OUT);
		close(OUT);
		print "Location: $scripturl?action=view&p=$pass\n\n";
		exit;
	}
}
sub mod {
	$who=param('who');
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		$rstatus="";
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($who eq $ilogin) {
			if($status eq "1") { $rstatus="Active"; } else { $rstatus="Inactive"; }
			$output.="<form action=$scripturl method=POST>\n";
			$output.="<input type=hidden name=action value=mod_process>\n";
			$output.="<input type=hidden name=p value=$pass>\n";
			$output.="<input type=hidden name=who value=$who>\n";
			$output.="<table>\n";
			$output.="<tr><td>Real Name</td><td><input type=text name=iname value=\"$iname\"></td></tr>\n";
			$output.="<tr><td>Email Address</td><td><input type=text name=iemail value=\"$iemail\"></td></tr>\n";
			$output.="<tr><td>Username</td><td>$ilogin</td></tr>\n";
			$output.="<tr><td>Password</td><td><input type=text name=ipass value=\"$ipass\"></td></tr>\n";
			$output.="<tr><td>Status</td><td><select name=status><option value=\"$status\"> $rstatus </option><option value=\"0\"> Inactive </option><option value=\"1\"> Active </option></select></td></tr>\n";
			$output.="</table><br><br>\n";
			$output.="<input type=submit value=\"Modify Info\">\n";
			$output.="</form>\n";
			open(PAGE, "templates/admin/modify.html");
			chomp(@page=<PAGE>);
			close(PAGE);
			$page_html=join("\n", @page);
			$page_html =~ s/%scripturl%/$scripturl/gi;
			$page_html =~ s/%pass%/$pass/gi;
			$page_html =~ s/%output%/$output/gi;
			print "Content-type: text/html\n\n";
			print "$page_html\n";
			exit;
		}
	}
}
sub mod_process {
	$who=param('who');
	$zname=param('iname');
	$zemail=param('iemail');
	$zpass=param('ipass');
	$zstatus=param('status');
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($who eq $ilogin) {
			$newline="$zname|$zemail|$ilogin|$zpass|$zstatus|$dayjoined";
			$setfound="1";
			push(@new, $newline);
		} else {
			$line =~ s/\n//gi;
			push(@new, $line);
		}
	}
	if($setfound eq "1") {
		open(OUT, ">scriptdir/dbase/users.txt");
		&LockDB(OUT);
		foreach $thing (@new) {
			print OUT "$thing\n";
		}
		&UnlockDB(OUT);
		close(OUT);
	}
	print "Location: $scripturl?action=view&p=$pass\n\n";
	exit;
}
sub del {
	$who=param('who');
	open(IN, "$scriptdir/dbase/users.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($who eq $ilogin) {
			$setfound="1";
		} else {
			$line =~ s/\n//gi;
			push(@new, $line);
		}
	}
	if($setfound eq "1") {
		open(OUT, ">scriptdir/dbase/users.txt");
		&LockDB(OUT);
		foreach $thing (@new) {
			print OUT "$thing\n";
		}
		&UnlockDB(OUT);
		close(OUT);
	}
	print "Location: $scripturl?action=view&p=$pass\n\n";
	exit;
}
sub login {
	open(PAGE, "templates/admin/login.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%scripturl%/$scripturl/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}
sub validate {
	open(IN, "$scriptdir/dbase/holding.txt");
	chomp(@in=<IN>);
	close(IN);
	foreach $line (@in) {
		($id, $iname, $iemail, $ilogin, $ipass, $status, $dayjoined)=split(/\|/, $line);
		if($ref eq $id) {
			$set_found=1;
			open(OUT, ">>$scriptdir/dbase/users.txt") or die("$!");
			&LockDB(OUT);
			print OUT "$iname|$iemail|$ilogin|$ipass|1|$dayjoined\n";
			&UnlockDB(OUT);
			close(OUT);
			open(OUT5, ">>$scriptdir/all_mails.txt");
			&LockDB(OUT5);
			print OUT5 "$iemail\n";
			&UnlockDB(OUT5);
			close(OUT5);
			#mail user
			$ua_url="$scripturl/user.cgi";
			open(IN2, "templates/mail/user_validated.txt");
			chomp(@in2=<IN2>);
			close(IN2);
			$mail_body=join("\n", @in2);
			$mail_body =~ s/%name%/$iname/gi;
			$mail_body =~ s/%email%/$iemail/gi;
			$mail_body =~ s/%username%/$ilogin/gi;
			$mail_body =~ s/%password%/$ipass/gi;
			$mail_body =~ s/%userpage%/$ua_url/gi;

			open(MAIL, "|$sendmail -t");
			print MAIL<<"EOT";
From: $mail_from
To: $iemail
Subject: Congratulations!


$mail_body

EOT
			close(MAIL);
		}
		if($ref ne $id) {
			push(@new, $line);
		}
	}
	# remove this entry from holding dbase
	open(OUT2, ">$scriptdir/dbase/holding.txt");
	&LockDB(OUT2);
	foreach $thing (@new) {
		print OUT2 $thing;
	}
	&UnlockDB(OUT2);
	close(OUT2);
	if($set_found eq "1") {
		open(PAGE, "templates/admin/aval_success.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%name%/$iname/gi;
		$page_html =~ s/%email%/$iemail/gi;
		$page_html =~ s/%username%/$ilogin/gi;
		$page_html =~ s/%password%/$ipass/gi;
		$page_html =~ s/%useradmin%/$ua_url/gi;
		$page_html =~ s/%userpage%/$up_url/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	} else {
		open(PAGE, "templates/admin/aval_failure.html");
		chomp(@page=<PAGE>);
		close(PAGE);
		$page_html=join("\n", @page);
		$page_html =~ s/%ref%/$ref/gi;
		print "Content-type: text/html\n\n";
		print "$page_html\n";
		exit;
	}
	exit;
}
sub badpass {
	open(PAGE, "templates/admin/admin_badpass.html");
	chomp(@page=<PAGE>);
	close(PAGE);
	$page_html=join("\n", @page);
	$page_html =~ s/%ref%/$ref/gi;
	print "Content-type: text/html\n\n";
	print "$page_html\n";
	exit;
}