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

# Determine what part of the script we need
if ($FORM{'action'} eq "regterms") {
	&regterms;
} elsif ($FORM{'action'} eq "register") {
	&register;
} elsif ($FORM{'action'} eq "addmember") {
	&addmember;
} elsif ($FORM{'action'} eq "login") {
	&login;
} elsif ($FORM{'action'} eq "saveprofile") {
	&saveprofile;
} elsif ($FORM{'action'} eq "showsmut") {
	&showsmut;
} elsif ($FORM{'action'} eq "logout") {
	print "Set-Cookie: rmid=\n";
	print "Set-Cookie: rmpass=\n";
	print "Location:$scripturl/index.cgi\n\n";
	exit;
}

# Read member cookies
&checkcookie;

# Skip login if cookie is set
if ($cookie{'rmid'} and $cookie{'rmpass'}) {
	$FORM{'id'} = $cookie{'rmid'};
	$FORM{'pass'} = $cookie{'rmpass'};
	&login;
} else {

	# Load common vocabulary
	require "$tmplpath/common.txt";

	# Load Member Login Form template
	require "$tmplpath/memblogin.tmpl";

	# Login Form
	$FORM_SUB = qq(<SCRIPT LANGUAGE="JavaScript">
<!-- Hide from non-JavaScript browsers
function Check_Data() {
	if (!document.adform.id.value || !document.adform.pass.value) {
		alert("$commonvoc[30]");
		return false;
	} else {
		return true;
	}
}
// Stop hiding --->
</SCRIPT>
<div align="center">
  <h3><font face="$fontname" size="$fontsize"><b>$tempvoc[0]</b></font> </h3>
  <form method="post" action="$scripturl/members.cgi" name="adform" onSubmit="return Check_Data();">
    <input type="hidden" name="action" value="login">
	<input type="hidden" name="redirect" value="$FORM{'redirect'}">
    <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
      <tr> 
        <td bgcolor="$headcolor" colspan="2"><font face="$sfontname" size="$sfontsize">$tempvoc[1]</font></td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[12]*</b></font></td>
        <td> 
          <input type="text" name="id" maxlength="12" size="30">
          <font face="$sfontname" size="$sfontsize"><a href="$scripturl/members.cgi?action=regterms">$commonvoc[29]</a></font></td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[19]*</b></font></td>
        <td> 
          <input type="password" name="pass" maxlength="12" size="30">
        </td>
      </tr>
      <tr> 
        <td bgcolor="$headcolor" colspan="2"><font face="$sfontname" size="$sfontsize">$commonvoc[21]</font></td>
      </tr>
    </table>
    <br>
    <input type="submit" name="submit" value="$commonvoc[24]">
    <input type="button" name="cancel" value="$commonvoc[26]" onClick="history.back()">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>);

	# Perform template substitutions
	$temphtml =~ s/\{FORM\}/$FORM_SUB/g;

	# Display the screen
	&showscreen;
}


########################### SUBROUTINES ###########################


# Display the Terms of Use
sub regterms {

	# Load the Terms of Use template
	require "$tmplpath/regterms.tmpl";

	# Terms of Use form
	$FORM_SUB = qq(<div align="center"><h3><font size="$fontsize" face="$fontname"><b>$tempvoc[0]</b></font></h3> 
  <form method="post" action="$scripturl/members.cgi" name="adform">
    <input type="hidden" name="action" value="register">
    <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <td bgcolor="$headcolor"><font face="$sfontname" size="$sfontsize">$tempvoc[1]</font></td>
      </tr>
      <tr>
        <td bgcolor="$primcolor"><font face="$fontname" size="$fontsize">$tempvoc[2]</font>
        </td>
      </tr>
      <tr>
        <td bgcolor="$headcolor"><font face="$sfontname" size="$sfontsize">$tempvoc[3]</font></td>
      </tr>
    </table>
    <br>
    <input type="submit" name="agree" value="$tempvoc[4]">
    <input type="button" name="cancel" value="$tempvoc[5]" onClick="history.back()">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>);

	# Perform template substitutions
	$temphtml =~ s/\{FORM\}/$FORM_SUB/g;

	# Display the screen
	&showscreen;
}


# Display new member registration form
sub register {

	# Load common vocabulary
	require "$tmplpath/common.txt";

	# Load Registration Form template
	require "$tmplpath/regform.tmpl";

	# Smut filter indicator
	$showsmutswitch = "<a href=\"javascript:popup('$scripturl/members.cgi?action=showsmut')\">$commonvoc[35]</a>$commonvoc[36]" if $badwords;

	# Build countries list
	&buildcountries;

	# Registration Form
	$FORM_SUB = qq(<SCRIPT LANGUAGE="JavaScript">
<!-- Hide from non-JavaScript browsers
function Check_Data() {
	if (!document.adform.name.value || !document.adform.email.value ||
			!document.adform.url.value || !document.adform.title.value ||
			!document.adform.description.value || !document.adform.country.value ||
			!document.adform.pass.value || !document.adform.pass2.value) {
		alert("$commonvoc[30]");
		return false;
	} else {
		return true;
	}
}
function popup(url)
{
	newwindow=window.open(url,'name','height=200,width=300,scrollbars');
	if (window.focus) {newwindow.focus()}
}
// Stop hiding --->
</SCRIPT>
<div align="center"> 
  <h3><font face="$fontname" size="$fontsize"><b>$tempvoc[0]</b></font></h3>
  <form method="post" action="$scripturl/members.cgi" name="adform" onSubmit="return Check_Data();">
    <input type="hidden" name="action" value="addmember">
    <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
      <tr> 
        <td bgcolor="$headcolor" colspan="2"><font face="$sfontname" size="$sfontsize">$tempvoc[1]</font></td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[13]*</b></font></td>
        <td> 
          <input type="text" name="name" maxlength="35" size="30">
        </td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[14]*</b></font></td>
        <td> 
          <input type="text" name="email" maxlength="50" size="30">
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td bgcolor="$primcolor"><font face="$fontname" size="$fontsize"><b>$commonvoc[15]*</b></font></td>
        <td> 
          <input type="text" name="url" maxlength="200" value="http://" size="30">
        </td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[16]*</b></font></td>
        <td bgcolor="$seconcolor"> 
          <input type="text" name="title" maxlength="100" size="30">
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[17]*</b></font></td>
        <td> 
          <input type="text" name="description" maxlength="200" size="30">
        </td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[18]*</b></font></td>
        <td> 
$countrieslist
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[19]*<br>
          </b><font face="$sfontname" size="$sfontsize">($tempvoc[2])</font></font></td>
        <td bgcolor="$primcolor"> 
          <input type="password" name="pass" maxlength="12" size="30">
        </td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$tempvoc[3]*<br>
          </b><font face="$sfontname" size="$sfontsize">($tempvoc[4])</font></font></td>
        <td> 
          <input type="password" name="pass2" maxlength="12" size="30">
        </td>
      </tr>
      <tr> 
        <td bgcolor="$headcolor" colspan="2"><font face="$sfontname" size="$sfontsize">$commonvoc[21] $showsmutswitch</font></td>
      </tr>
    </table>
    <br>
    <input type="submit" name="submit" value="$commonvoc[24]">
    <input type="button" name="cancel" value="$commonvoc[26]" onClick="history.back()">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>);

	# Perform template substitutions
	$temphtml =~ s/\{FORM\}/$FORM_SUB/g;

	# Display the screen
	&showscreen;
}


# Add new member to the database
sub addmember {

	# Check referring URL
	&urlcheck;

	# Check form fields
	if ($FORM{'name'} eq "" or $FORM{'name'} !~ /\S/) {
		push(@badfields, 3);
	}

	if ($FORM{'email'} !~ /[\w\-]+\@[\w\-]+\.[\w\-]+/) {
		push(@badfields, 4);
	}

	if ($FORM{'url'} !~ /^(f|ht)tp:\/\/[\w\-]+\.[\w\-]+/ or $FORM{'url'} eq "http://") {
		push(@badfields, 5);
	}

	if ($FORM{'title'} eq "" or $FORM{'title'} !~ /\S/) {
		push(@badfields, 6);
	}

	if ($FORM{'description'} eq "" or $FORM{'description'} !~ /\S/) {
		push(@badfields, 7);
	}

	push(@badfields, 8) unless $FORM{'country'};

	if ($FORM{'pass'} eq "" or $FORM{'pass'} =~ /\W/) {
		push(@badfields, 9);
	}

	unless ($FORM{'pass'} eq $FORM{'pass2'}) {
		push(@badfields, 10);
	}

	# Display errors, if any
	&formerror;

	# Check for bad/rude words
	&smut_detect($FORM{'name'},$FORM{'email'},$FORM{'url'},$FORM{'title'},$FORM{'description'});

	# Load Members List
	&readmembers;

	# Check for duplicate e-mail addresses
	if ($emailcheck and grep(/\t$FORM{'email'}\t/i, @members)) {
		push(@badfields, 11);
		&formerror;
	}

	# Check for duplicate URL
	if (grep(/\t$FORM{'url'}\t/i, @members)) {
		push(@badfields, 12);
		&formerror;
	}

	# Strip html tags
	&htmlstrip($FORM{'name'},$FORM{'email'},$FORM{'url'},$FORM{'title'},$FORM{'description'});

	# Get current time
	$curtime = time();

	# Get new member ID
	open(IDFILE,"+<$membpath/count.log") || err("Could not open $membpath/count.log: $!");
	flock(IDFILE,2);
	$idcount = <IDFILE>;
	$idcount++;
	seek(IDFILE,0,0);
	truncate(IDFILE,0);
	print IDFILE $idcount;
	close(IDFILE);

	# Create new member file
	open(MEMB,">$membpath/$idcount.cgi") || err("Could not create $membpath/$idcount.cgi: $!");
	flock(MEMB,2);
	seek(MEMB,0,0);
	print MEMB "$idcount\n$curtime\n$FORM{'name'}\n$FORM{'email'}\n$FORM{'url'}\n$FORM{'title'}\n$FORM{'description'}\n$FORM{'country'}\n$FORM{'pass'}\n0\n$curtime\n0\n0\n$curtime\n0\n$curtime\n";
	close(MEMB);

	# Add member to Members List File
	open(MLIST,">>$membpath/memblist.cgi") || err("Could not update $membpath/memblist.cgi: $!");
	flock(MLIST,2);
	seek(MLIST,0,2);
	print MLIST "$idcount\t$FORM{'name'}\t$FORM{'email'}\t$FORM{'url'}\t$FORM{'title'}\t$FORM{'description'}\n";
	close(MLIST);

	# Save member login/password in cookie
	print "Set-Cookie: rmid=$idcount\n";
	print "Set-Cookie: rmpass=$FORM{'pass'}\n";

	# Notify the admin of the new member registration
	if ($regadmin) {
		$msgtext = "$FORM{'name'} has just registered with your RankMaster script!\n".
		           "-------------------------------------------------------------------\n\n".
		           "Note: this message was generated by RankMaster script.\n".
			   "You can turn this notification off by adjusting the script options.\n";
		&sendmail($adminemail, $adminemail, "New RankMaster member registration!", $msgtext);
	}

	# Send Welcome Message
	if ($newuseremail) {
			require "$tmplpath/common.txt";
			$boxlink = &getlink($idcount, "box");
			$imglink = &getlink($idcount, "image");
			$txtlink = &getlink($idcount, "text");
			$newusertext =~ s/\[name\]/$FORM{'name'}/g;
			$newusertext =~ s/\[email\]/$FORM{'email'}/g;
			$newusertext =~ s/\[url\]/$FORM{'url'}/g;
			$newusertext =~ s/\[title\]/$FORM{'title'}/g;
			$newusertext =~ s/\[id\]/$idcount/g;
			$newusertext =~ s/\[pass\]/$FORM{'pass'}/g;
			$newusertext =~ s/\[boxcode\]/$boxlink/g;
			$newusertext =~ s/\[imgcode\]/$imglink/g;
			$newusertext =~ s/\[textcode\]/$txtlink/g;
			&sendmail($adminemail, $FORM{'email'}, $newusersubject, $newusertext);
	}

	# Show Success Screen
	&confirm(3,4,"$scripturl/members.cgi");
}


# Member Area
sub login {

	# Check referring URL
	&urlcheck;

	# Check login name and password
	&memblogin;

	# Load common vocabulary
	require "$tmplpath/common.txt";

	# Load Member Area template
	require "$tmplpath/membarea.tmpl";

	# Show HTML GENERATOR panel
	if ($FORM{'redirect'} eq "htmlgenerator") {

		# Initialize link codes
		$tmplinkcodes = "";

		# Build link codes
		if ($showboxlink) {
			$tmplinkcodes .= &buildlink($mprofile[0], "box", $tempvoc[4]);
		}
		if ($showimglink) {
			$tmplinkcodes .= &buildlink($mprofile[0], "image", $tempvoc[5]);
		}
		if ($showtxtlink) {
			$tmplinkcodes .= &buildlink($mprofile[0], "text", $tempvoc[6]);
		}

		# HTML GENERATOR panel
		$PANEL_SUB = qq(<div align="center">
  <h3><font face="$fontname" size="$fontsize"><b>$tempvoc[0]</b></font></h3>
  <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
    <tr> 
      <td bgcolor="$headcolor"> 
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td> 
              <div align="center"><font face="$fontname" size="$fontsize"><b><a href="$scripturl/members.cgi?redirect=profile">$tempvoc[1]</a></b></font></div>
            </td>
            <td bgcolor="$primcolor"> 
              <div align="center"><font face="$fontname" size="$fontsize"><b>$tempvoc[2]</b></font></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr bgcolor="$primcolor"> 
      <td>
        <table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="$seconcolor">
$tmplinkcodes
        </table>
      </td>
    </tr>
    <tr bgcolor="$headcolor"> 
      <td><font face="$sfontname" size="$sfontsize">$tempvoc[9]</font></td>
    </tr>
  </table>
    <br>
  <form name="adform">
    <input type="button" name="back" value="$tempvoc[3]" onClick="window.location='$scripturl/index.cgi';return true">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>);

	# Show MY PROFILE panel
	} else {

		# Smut filter indicator
		$showsmutswitch = "<a href=\"javascript:popup('$scripturl/members.cgi?action=showsmut')\">$commonvoc[35]</a>$commonvoc[36]" if $badwords;

		# Build countries list
		&buildcountries;

		# MY PROFILE panel
		$PANEL_SUB = qq(<script language="JavaScript">
<!-- Hide from non-JavaScript browsers
function Check_Data() {
	if (!document.adform.name.value || !document.adform.email.value ||
			!document.adform.url.value || !document.adform.title.value ||
			!document.adform.description.value || !document.adform.country.value ||
			!document.adform.pass.value) {
		alert("$commonvoc[30]");
		return false;
	} else {
		return true;
	}
}
function popup(url)
{
	newwindow=window.open(url,'name','height=200,width=300,scrollbars');
	if (window.focus) {newwindow.focus()}
}
// Stop hiding --->
</script>
<div align="center">
  <h3><font face="$fontname" size="$fontsize"><b>$tempvoc[0]</b></font></h3>
  <form method="post" action="$scripturl/members.cgi" name="adform" onSubmit="return Check_Data();">
    <input type="hidden" name="action" value="saveprofile">
    <input type="hidden" name="redirect" value="profile">
    <input type="hidden" name="id" value="$mprofile[0]">
    <table width="$tablewidth" border="0" cellspacing="1" cellpadding="3">
      <tr> 
        <td bgcolor="$headcolor" colspan="2"> 
          <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tr> 
              <td bgcolor="$primcolor"> 
                <div align="center"><font face="$fontname" size="$fontsize"><b>$tempvoc[1]</b></font></div>
              </td>
              <td> 
                <div align="center"><font face="$fontname" size="$fontsize"><b><a href="$scripturl/members.cgi?redirect=htmlgenerator">$tempvoc[2]</a></b></font></div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[12]*</b></font></td>
        <td><font face="$fontname" size="$fontsize"><b>$mprofile[0]</b></font></td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[19]*</b></font></td>
        <td> 
          <input type="text" name="pass" maxlength="12" size="30" value="$mprofile[8]">
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[13]*</b></font></td>
        <td><font face="$fontname" size="$fontsize"> 
          <input type="text" name="name" maxlength="35" size="30" value="$mprofile[2]">
          </font></td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[14]*</b></font></td>
        <td> 
          <input type="text" name="email" maxlength="50" size="30" value="$mprofile[3]">
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[15]*</b></font></td>
        <td> <font face="$fontname" size="$fontsize"><b> 
          <input type="text" name="url" maxlength="200" value="$mprofile[4]" size="30">
          </b></font></td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[16]*</b></font></td>
        <td> 
          <input type="text" name="title" maxlength="100" size="30" value="$mprofile[5]">
        </td>
      </tr>
      <tr bgcolor="$primcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[17]*</b></font></td>
        <td> 
          <input type="text" name="description" maxlength="200" size="30" value="$mprofile[6]">
        </td>
      </tr>
      <tr bgcolor="$seconcolor"> 
        <td><font face="$fontname" size="$fontsize"><b>$commonvoc[18]*</b></font></td>
        <td> 
$countrieslist
        </td>
      </tr>
      <tr bgcolor="$headcolor"> 
        <td colspan="2"><font face="$sfontname" size="$sfontsize">$commonvoc[22] $showsmutswitch</font></td>
      </tr>
    </table>
    <br>
    <input type="submit" name="submit" value="$commonvoc[25]">
    <input type="button" name="back" value="$tempvoc[3]" onClick="window.location='$scripturl/index.cgi';return true">
    <br>
  </form>
  <font face="Arial, Helvetica, sans-serif" size="-2"><a href="http://scripts.21stcenturyhost.net" target="_blank">Powered 
  by 21stCenturyScripts</a></font></div>);

		# Show selected country
		$PANEL_SUB =~ s/<option value=\"$mprofile[7]\">/<option value=\"$mprofile[7]\" selected>/;
	}

	# Perform template substitutions
	$temphtml =~ s/\{PANEL\}/$PANEL_SUB/g;
	&logstatus;

	# Display the screen
	&showscreen;
}


# Save changes to Member Profile
sub saveprofile {

	# Check referring URL
	&urlcheck;

	# Check form fields
	if ($FORM{'name'} eq "" or $FORM{'name'} !~ /\S/) {
		push(@badfields, 3);
	}

	if ($FORM{'email'} !~ /[\w\-]+\@[\w\-]+\.[\w\-]+/) {
		push(@badfields, 4);
	}

	if ($FORM{'url'} !~ /^(f|ht)tp:\/\/[\w\-]+\.[\w\-]+/ or $FORM{'url'} eq "http://") {
		push(@badfields, 5);
	}

	if ($FORM{'title'} eq "" or $FORM{'title'} !~ /\S/) {
		push(@badfields, 6);
	}

	if ($FORM{'description'} eq "" or $FORM{'description'} !~ /\S/) {
		push(@badfields, 7);
	}

	push(@badfields, 8) unless $FORM{'country'};

	if ($FORM{'pass'} eq "" or $FORM{'pass'} =~ /\W/) {
		push(@badfields, 9);
	}

	# Display errors, if any
	&formerror;

	# Check for bad/rude words
	&smut_detect($FORM{'name'},$FORM{'email'},$FORM{'url'},$FORM{'title'},$FORM{'description'});

	# Load Members List
	&readmembers;

	# Strip html tags
	&htmlstrip($FORM{'name'},$FORM{'email'},$FORM{'url'},$FORM{'title'},$FORM{'description'});

	# Update member file
	open(MEMB,"+<$membpath/$FORM{'id'}.cgi") || err("Could not update $membpath/$FORM{'name'}.cgi: $!");
	flock(MEMB,2);
	@mprofile = <MEMB>;
	chomp(@mprofile);
	# Check for duplicate e-mail addresses
	if ($emailcheck and $FORM{'email'} ne $mprofile[3] and grep(/\t$FORM{'email'}\t/i, @members)) {
		close(MEMB);
		push(@badfields, 11);
		&formerror;
	# Check for duplicate URLs
	} elsif ($FORM{'url'} ne $mprofile[4] and grep(/\t$FORM{'url'}\t/i, @members)) {
		close(MEMB);
		push(@badfields, 12);
		&formerror;
	}
	seek(MEMB,0,0);
	truncate(MEMB,0);
	print MEMB "$FORM{'id'}\n$mprofile[1]\n$FORM{'name'}\n$FORM{'email'}\n$FORM{'url'}\n$FORM{'title'}\n$FORM{'description'}\n$FORM{'country'}\n$FORM{'pass'}\n$mprofile[9]\n$mprofile[10]\n$mprofile[11]\n$mprofile[12]\n$mprofile[13]\n$mprofile[14]\n$mprofile[15]\n";
	close(MEMB);

	# Update Member List
	open(MLIST,"+<$membpath/memblist.cgi") || err("Could not update $membpath/memblist.cgi: $!");
	flock(MLIST,2);
	@members = <MLIST>;
	seek(MLIST,0,0);
	truncate(MLIST,0);
	foreach $line(@members) {
		$line = "$FORM{'id'}\t$FORM{'name'}\t$FORM{'email'}\t$FORM{'url'}\t$FORM{'title'}\t$FORM{'description'}\n" if $line =~ /^$FORM{'id'}\t/;
		print MLIST $line;
	}
	close(MLIST);

	# Save member password in cookie
	print "Set-Cookie: rmpass=$FORM{'pass'}\n";

	# Show Success Screen
	&confirm(5,6,"$scripturl/members.cgi?redirect=profile");
}


# Member Login Check
sub memblogin {

	# Check form fields
	if ($FORM{'id'} !~ /^\d+$/) {
		push(@badfields, 2);
	}

	if ($FORM{'pass'} eq "" or $FORM{'pass'} =~ /\W/) {
		push(@badfields, 9);
	}

	# Display errors, if any
	&formerror;

	# Check if member file exists
	unless (-e "$membpath/$FORM{'id'}.cgi") {
		print "Set-Cookie: rmid=\n";
		push(@badfields, 14);
		&formerror;
	}

	# Open member profile
	open(PROFILE,"$membpath/$FORM{'id'}.cgi") || err("Could not open $FORM{'id'}.cgi: $!");
	@mprofile = <PROFILE>;
	close(PROFILE);
	chomp(@mprofile);

	# Check password
	unless ($FORM{'pass'} eq $mprofile[8]) {
		print "Set-Cookie: rmpass=\n";
		push(@badfields, 15);
		&formerror;
	}

	# Save member login/password as cookie
	print "Set-Cookie: rmid=$FORM{'id'}\n";
	print "Set-Cookie: rmpass=$FORM{'pass'}\n";
}


# Show a list of blocked words
sub showsmut {

	# Load common vocabulary
	require "$tmplpath/common.txt";

	# Initialize blocked words list
	$tmpwordlist = "";

	# Build blocked words list
	@badlist = split(/,/, $badwords);
	foreach $smutword(@badlist) {

		# Exact match
		if ($smutword =~ /\[(.*)\]/) {
			$smutword = $1;
			$lblmatch = $commonvoc[39];

		# Pattern match
		} else {
			$lblmatch = $commonvoc[38];
		}

		$tmpwordlist .= qq(        <li><b><font face="$fontname" size="$fontsize">$smutword</font></b><font face="$fontname" size="$fontsize"> 
          ($lblmatch)</font></li>);
	}

	# Display blocked words list
	print "Content-type: text/html\n\n";
	print <<EOH;
<html>
<head>
<title>$commonvoc[35]</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<SCRIPT LANGUAGE="JavaScript">
<!-- Hide from non-JavaScript browsers
document.bgColor = window.opener.document.bgColor;
document.fgColor = window.opener.document.fgColor;
// Stop hiding --->
</SCRIPT>
<body>
<div align="center">
  <h3><b><font face="$fontname" size="$fontsize">$commonvoc[40]</font></b></h3>
</div>
<form>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr> 
    <td> 
      <ul>
$tmpwordlist
      </ul>
    </td>
  </tr>
</table>
</form>
<div align="center">
  <input type="button" name="close" value="$commonvoc[41]" onClick="javascript:window.close()">
</div>
</body>
</html>
EOH
	exit;
}


# Build countries list
sub buildcountries {
	$countrieslist = qq(          <select name="country" size="1">
            <option value="">$commonvoc[20]</option>
            <option value="AF">Afghanistan </option>
            <option value="AL">Albania </option>
            <option value="DZ">Algeria </option>
            <option value="AS">American Samoa </option>
            <option value="AD">Andorra </option>
            <option value="AO">Angola </option>
            <option value="AI">Anguilla </option>
            <option value="AQ">Antarctica </option>
            <option value="AG">Antigua and Barbuda </option>
            <option value="AR">Argentina </option>
            <option value="AM">Armenia </option>
            <option value="AW">Aruba </option>
            <option value="AU">Australia </option>
            <option value="AT">Austria </option>
            <option value="AZ">Azerbaijan </option>
            <option value="BS">Bahamas </option>
            <option value="BH">Bahrain </option>
            <option value="BD">Bangladesh </option>
            <option value="BB">Barbados </option>
            <option value="BY">Belarus </option>
            <option value="BE">Belgium </option>
            <option value="BZ">Belize </option>
            <option value="BJ">Benin </option>
            <option value="BM">Bermuda </option>
            <option value="BT">Bhutan </option>
            <option value="BO">Bolivia </option>
            <option value="BA">Bosnia and Herzegowina </option>
            <option value="BW">Botswana </option>
            <option value="BV">Bouvet Island </option>
            <option value="BR">Brazil </option>
            <option value="IO">British Indian Ocean Territory </option>
            <option value="BN">Brunei Darussalam </option>
            <option value="BG">Bulgaria </option>
            <option value="BF">Burkina Faso </option>
            <option value="BI">Burundi </option>
            <option value="KH">Cambodia </option>
            <option value="CM">Cameroon </option>
            <option value="CA">Canada </option>
            <option value="CV">Cape Verde </option>
            <option value="KY">Cayman Islands </option>
            <option value="CF">Central African Republic </option>
            <option value="TD">Chad </option>
            <option value="CL">Chile </option>
            <option value="CN">China </option>
            <option value="CX">Christmas Island </option>
            <option value="CC">Cocos (Keeling) Islands </option>
            <option value="CO">Colombia </option>
            <option value="KM">Comoros </option>
            <option value="CG">Congo </option>
            <option value="CK">Cook Islands </option>
            <option value="CR">Costa Rica </option>
            <option value="CI">Cote D'Ivoire </option>
            <option value="HR">Croatia (local name: Hrvatska) </option>
            <option value="CU">Cuba </option>
            <option value="CY">Cyprus </option>
            <option value="CZ">Czech Republic </option>
            <option value="DK">Denmark </option>
            <option value="DJ">Djibouti </option>
            <option value="DM">Dominica </option>
            <option value="DO">Dominican Republic </option>
            <option value="TP">East Timor </option>
            <option value="EC">Ecuador </option>
            <option value="EG">Egypt </option>
            <option value="SV">El Salvador </option>
            <option value="GQ">Equatorial Guinea </option>
            <option value="ER">Eritrea </option>
            <option value="EE">Estonia </option>
            <option value="ET">Ethiopia </option>
            <option value="FK">Falkland Islands (Malvinas) </option>
            <option value="FO">Faroe Islands </option>
            <option value="FJ">Fiji </option>
            <option value="FI">Finland </option>
            <option value="FR">France </option>
            <option value="FX">France, Metropolitan </option>
            <option value="GF">French Guiana </option>
            <option value="PF">French Polynesia </option>
            <option value="TF">French Southern Territories </option>
            <option value="GA">Gabon </option>
            <option value="GM">Gambia </option>
            <option value="GE">Georgia </option>
            <option value="DE">Germany </option>
            <option value="GH">Ghana </option>
            <option value="GI">Gibraltar </option>
            <option value="GR">Greece </option>
            <option value="GL">Greenland </option>
            <option value="GD">Grenada </option>
            <option value="GP">Guadeloupe </option>
            <option value="GU">Guam </option>
            <option value="GT">Guatemala </option>
            <option value="GN">Guinea </option>
            <option value="GW">Guinea-Bissau </option>
            <option value="GY">Guyana </option>
            <option value="HT">Haiti </option>
            <option value="HM">Heard and Mc Donald Islands </option>
            <option value="HN">Honduras </option>
            <option value="HK">Hong Kong </option>
            <option value="HU">Hungary </option>
            <option value="IS">Iceland </option>
            <option value="IN">India </option>
            <option value="ID">Indonesia </option>
            <option value="IR">Iran (Islamic Republic of) </option>
            <option value="IQ">Iraq </option>
            <option value="IE">Ireland </option>
            <option value="IL">Israel </option>
            <option value="IT">Italy </option>
            <option value="JM">Jamaica </option>
            <option value="JP">Japan </option>
            <option value="JO">Jordan </option>
            <option value="KZ">Kazakhstan </option>
            <option value="KE">Kenya </option>
            <option value="KI">Kiribati </option>
            <option value="KP">Korea, People's Republic of </option>
            <option value="KR">Korea, Republic of </option>
            <option value="KW">Kuwait </option>
            <option value="KG">Kyrgyzstan </option>
            <option value="LA">Lao People's Republic </option>
            <option value="LV">Latvia </option>
            <option value="LB">Lebanon </option>
            <option value="LS">Lesotho </option>
            <option value="LR">Liberia </option>
            <option value="LY">Libyan Arab Jamahiriya </option>
            <option value="LI">Liechtenstein </option>
            <option value="LT">Lithuania </option>
            <option value="LU">Luxembourg </option>
            <option value="MO">Macau </option>
            <option value="MK">Macedonia, </option>
            <option value="MG">Madagascar </option>
            <option value="MW">Malawi </option>
            <option value="MY">Malaysia </option>
            <option value="MV">Maldives </option>
            <option value="ML">Mali </option>
            <option value="MT">Malta </option>
            <option value="MH">Marshall Islands </option>
            <option value="MQ">Martinique </option>
            <option value="MR">Mauritania </option>
            <option value="MU">Mauritius </option>
            <option value="YT">Mayotte </option>
            <option value="MX">Mexico </option>
            <option value="FM">Micronesia, Federated States of </option>
            <option value="MD">Moldova, Republic of </option>
            <option value="MC">Monaco </option>
            <option value="MN">Mongolia </option>
            <option value="MS">Montserrat </option>
            <option value="MA">Morocco </option>
            <option value="MZ">Mozambique </option>
            <option value="MM">Myanmar </option>
            <option value="NA">Namibia </option>
            <option value="NR">Nauru </option>
            <option value="NP">Nepal </option>
            <option value="NL">Netherlands </option>
            <option value="AN">Netherlands Antilles </option>
            <option value="NC">New Caledonia </option>
            <option value="NZ">New Zealand </option>
            <option value="NI">Nicaragua </option>
            <option value="NE">Niger </option>
            <option value="NG">Nigeria </option>
            <option value="NU">Niue </option>
            <option value="NF">Norfolk Island </option>
            <option value="MP">Northern Mariana Islands </option>
            <option value="NO">Norway </option>
            <option value="OM">Oman </option>
            <option value="PK">Pakistan </option>
            <option value="PW">Palau </option>
            <option value="PA">Panama </option>
            <option value="PG">Papua New Guinea </option>
            <option value="PY">Paraguay </option>
            <option value="PE">Peru </option>
            <option value="PH">Philippines </option>
            <option value="PN">Pitcairn </option>
            <option value="PL">Poland </option>
            <option value="PT">Portugal </option>
            <option value="PR">Puerto Rico </option>
            <option value="QA">Qatar </option>
            <option value="RE">Reunion </option>
            <option value="RO">Romania </option>
            <option value="RU">Russian Federation </option>
            <option value="RW">Rwanda </option>
            <option value="KN">Saint Kitts and Nevis </option>
            <option value="LC">Saint Lucia </option>
            <option value="VC">Saint Vincent and the Grenadines </option>
            <option value="WS">Samoa </option>
            <option value="SM">San Marino </option>
            <option value="ST">Sao Tome and Principe </option>
            <option value="SA">Saudi Arabia </option>
            <option value="SN">Senegal </option>
            <option value="SC">Seychelles </option>
            <option value="SL">Sierra Leone </option>
            <option value="SG">Singapore </option>
            <option value="SK">Slovakia (Slovak Republic) </option>
            <option value="SI">Slovenia </option>
            <option value="SB">Solomon Islands </option>
            <option value="SO">Somalia </option>
            <option value="ZA">South Africa </option>
            <option value="ES">Spain </option>
            <option value="LK">Sri Lanka </option>
            <option value="SH">St. Helena </option>
            <option value="PM">St. Pierre and Miquelon </option>
            <option value="SD">Sudan </option>
            <option value="SR">Suriname </option>
            <option value="SJ">Svalbard and Jan Mayen Islands </option>
            <option value="SZ">Swaziland </option>
            <option value="SE">Sweden </option>
            <option value="CH">Switzerland </option>
            <option value="SY">Syrian Arab Republic </option>
            <option value="TW">Taiwan </option>
            <option value="TJ">Tajikistan </option>
            <option value="TZ">Tanzania, United Republic of </option>
            <option value="TH">Thailand </option>
            <option value="TG">Togo </option>
            <option value="TK">Tokelau </option>
            <option value="TO">Tonga </option>
            <option value="TT">Trinidad and Tobago </option>
            <option value="TN">Tunisia </option>
            <option value="TR">Turkey </option>
            <option value="TM">Turkmenistan </option>
            <option value="TC">Turks and Caicos Islands </option>
            <option value="TV">Tuvalu </option>
            <option value="UG">Uganda </option>
            <option value="UA">Ukraine </option>
            <option value="AE">United Arab Emirates </option>
            <option value="GB">United Kingdom </option>
            <option value="US">United States </option>
            <option value="UM">United States Minor Outlying Isles </option>
            <option value="UY">Uruguay </option>
            <option value="UZ">Uzbekistan </option>
            <option value="VU">Vanuatu </option>
            <option value="VA">Vatican City State (Holy See) </option>
            <option value="VE">Venezuela </option>
            <option value="VN">Vietnam </option>
            <option value="VG">Virgin Islands (British) </option>
            <option value="VI">Virgin Islands (U.S.) </option>
            <option value="WF">Wallis And Futuna Islands </option>
            <option value="EH">Western Sahara </option>
            <option value="YE">Yemen </option>
            <option value="YU">Yugoslavia </option>
            <option value="ZR">Zaire </option>
            <option value="ZM">Zambia </option>
            <option value="ZW">Zimbabwe </option>
          </select>);
}


# Build HTML GENERATOR codes
sub buildlink {

	# Localize incoming variables
	my($membid, $linklabel, $linktitle) = @_;

		# Get link code
		$linkcode = &getlink($membid, $linklabel);

		# Create HTML GENERATOR code
		$builtlink = qq(
          <tr> 
            <td colspan="2" bgcolor="$seconcolor"><font face="$fontname" size="$fontsize"><b>$linktitle</b></font></td>
          </tr>
          <tr valign="top"> 
            <td><font face="$sfontname" size="$sfontsize">$tempvoc[7]</font><br>
              <center>$linkcode</center>
            </td>
            <td><font face="$sfontname" size="$sfontsize">$tempvoc[8]</font>
              <form name="$linklabel">
                <center><textarea name="$linklabel" cols="30" rows="4" wrap="VIRTUAL">$linkcode</textarea></center>
              </form>
            </td>
          </tr>);

          return $builtlink;
}
