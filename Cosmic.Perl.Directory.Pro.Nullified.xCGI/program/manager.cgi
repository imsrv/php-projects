#!/usr/local/bin/perl
##-----------------------------------------------------------------##
##                                                                 ##
##                                                                 ##
## © Copyright Mr Lyle R Hopkins 2000. All rights reserved. No part##
## of this or any of the attached documents shall be               ##
## reproduced/stored in any way whatsoever without written         ##
## permission from the Copyright holder.                           ##
##   The Copyright holder holds no responsibility for errors or    ##
## omissions. No liability is assumed in any way for damages       ##
## resulting from the use of this document/program.                ##
##                                                                 ##
## Have a nice day.                                                ##
##                                                                 ##
##                                                                 ##
##-----------------------------------------------------------------##

## By Lyle Hopkins ##

require 'dirpro.lib';
require 'dirprovar.lib';

##################################################
######################## Other variables
##################################################

print "Content-type: text/html\n\n";

&get_post_data;
&get_get_data;

($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time); ## Get date
$year += 1900;

if ($WHATWANT{'want'} eq "admin") {
  &admin();
}
if ($WHATWANT{'want'} eq "enteradmin") {
  $WHATWANT{'username'} = $FORM{'username'};
  $WHATWANT{'password'} = $FORM{'password'};
  &passcheck();
  &enteradmin();
}
if ($WHATWANT{'want'} eq "viewsub") {
  &passcheck();
  &viewsub();
}
if ($WHATWANT{'want'} eq "addsub") {
  &passcheck();
  &addsub();
}
if ($WHATWANT{'want'} eq "removesub") {
  &passcheck();
  &removesub();
}
if ($WHATWANT{'want'} eq "viewmodify") {
  &passcheck();
  &viewmodify();
}
if ($WHATWANT{'want'} eq "addmodify") {
  &passcheck();
  &addmodify();
}
if ($WHATWANT{'want'} eq "removemodify") {
  &passcheck();
  &removemodify();
}
if ($WHATWANT{'want'} eq "viewcat") {
  &passcheck();
  &viewcat();
}
if ($WHATWANT{'want'} eq "viewsubcat") {
  &passcheck();
  &viewsubcat();
}
if ($WHATWANT{'want'} eq "createcat") {
  &passcheck();
  &createcat();
}
if ($WHATWANT{'want'} eq "modifycat") {
  &passcheck();
  &modifycat();
}
if ($WHATWANT{'want'} eq "modifycat2") {
  &passcheck();
  &modifycat2();
}
if ($WHATWANT{'want'} eq "removecat") {
  &passcheck();
  &removecat();
}
if ($WHATWANT{'want'} eq "gensd") {
  &passcheck();
  &gensd();
}
if ($WHATWANT{'want'} eq "viewsite") {
  &passcheck();
  &viewsite();
}
if ($WHATWANT{'want'} eq "removesite") {
  &passcheck();
  &removesite();
}
if ($WHATWANT{'want'} eq "modifysite") {
  &passcheck();
  &modifysite();
}
if ($WHATWANT{'want'} eq "viewtopsite") {
  &passcheck();
  &viewtopsite();
}
if ($WHATWANT{'want'} eq "removetopsite") {
  &passcheck();
  &removetopsite();
}
if ($WHATWANT{'want'} eq "modifytopsite") {
  &passcheck();
  &modifytopsite();
}
if ($WHATWANT{'want'} eq "addtopsite") {
  &passcheck();
  &addtopsite();
}
if ($WHATWANT{'want'} eq "viewcads") {
  &passcheck();
  &viewcads();
}
if ($WHATWANT{'want'} eq "modifycads") {
  &passcheck();
  &modifycads();
}
if ($WHATWANT{'want'} eq "removecads") {
  &passcheck();
  &removecads();
}
if ($WHATWANT{'want'} eq "viewads") {
  &passcheck();
  &viewads();
}
if ($WHATWANT{'want'} eq "addads") {
  &passcheck();
  &addads();
}
if ($WHATWANT{'want'} eq "removeads") {
  &passcheck();
  &removeads();
}
if ($WHATWANT{'want'} eq "modifyads") {
  &passcheck();
  &modifyads();
}
if ($WHATWANT{'want'} eq "displayvariables") {
  &passcheck();
  &displayvariables();
}
if ($WHATWANT{'want'} eq "savevariables") {
  &passcheck();
  &savevariables();
}
if ($WHATWANT{'want'} eq "changepasswordform") {
  &passcheck();
  &changepasswordform();
}
if ($WHATWANT{'want'} eq "changepassword") {
  &passcheck();
  &changepassword();
}
if ($WHATWANT{'want'} eq "regeneratecats") {
  &passcheck();
  &regeneratecats();
}


##################################################
######################## Enter Admin
##################################################

sub admin {

print <<EndHTML;

<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF">
<div align="center"> 
  <p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Password required 
    for Management Area</font></p>
  <form action="manager.cgi?want=enteradmin" method="POST">
    <table width="250" border="1" cellspacing="1" cellpadding="1">
      <tr> 
        <td><font face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
        <td> 
          <input type="text" size="20"
    name="username">
        </td>
      </tr>
      <tr> 
        <td><font face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
        <td> 
          <input type="password" size="20"
    name="password">
        </td>
      </tr>
    </table>
    <p align="center"> 
      <input type="submit" value="Enter">
    </p>
    </form>
</div>
</body>
</html>


EndHTML
;

} ## End sub


##################################################
######################## Admin area
##################################################

sub enteradmin {

print <<EndHTML;

<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p align="center"><font size="5" face="Verdana, Arial, Helvetica, sans-serif">Manager 
  area</font></p>
<p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewsub&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
  submissions</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewads&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
  advertising</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewcat&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Edit 
  categories</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewmodify&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
  modifications</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=gensd&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Generate 
  search data</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=regeneratecats&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Re-Generate 
  all categories</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=displayvariables&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Display 
  Variables</a><br>
  </font><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=changepasswordform&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Change 
  Password</a></font></p>
</body>
</html>

EndHTML
;

} ## End sub


##################################################
######################## Password check
##################################################

sub passcheck {

open(INF,"adminpass.txt") || &errormessage("Could not open password file adminpass.txt");
  $userpass = <INF>; ## Put into an array
close(INF); ## Close file
chomp($userpass);
($username, $password) = split(/:/, $userpass);
$enterpasscrypt = crypt($WHATWANT{'password'}, substr($password, 0, 2));
unless ($WHATWANT{'username'} eq $username && $enterpasscrypt eq $password) {
  &message_end("Invalid username & password","You have entered and invalid username and password to enter this admin area.");
}

} ## End sub


##################################################
######################## View submissions
##################################################

sub viewsub {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Sites submitted 
  to be listed</font></p>
  <table BORDER=1 COLS=21>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Category</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Site name</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Certificate</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Affiliate program</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Traded</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Cool?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Rank high?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove submission</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Add submission</font></TD>
    </TR>
EndHTML
$linenum = 0;
open(INF,"$data/submissions.dta"); ## || &errormessage("Could not open submissions file, file may be empty"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($catname, $sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$affil,$trade,$email,$password) = split(/¦/, $line);
  print <<EndHTML
    <form action="$programurl/manager.cgi?want=addsub&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=password value="$password">
        <input name=category type=text value="$catname">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=name type=text value="$sitename">
        <a href="$siteurl" target="_default">link</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=description type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=url type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 type=text value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 type=text value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 type=text value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 type=text value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 type=text value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 type=text value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 type=text value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 type=text value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 type=text value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 type=text value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cert type=text value="$cert">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Runs an affiliate 
        program:- $affil</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Trading:- $trade 
        <input type=hidden name=trade value=$trade></font></TD>
EndHTML
;

  if ($trade || $affil eq "Yes") {
    print <<EndHTML
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Link as affiliatetrade? 
        <select name="trade">
          <option value="1" selected>Yes</option>
          <option value="2">No</option>
        </select>
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool type=checkbox value="yes">
        Cool site?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email:- <a href="mailto:$email">$email</a> 
        <input type=hidden name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removesub&remove=$linenum&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this Submission</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=want value=addsub>
        <input type=hidden name=addsub value=$linenum>
        <input type=submit value=Add>
        </font></TD>
    </TR>
    </form>
EndHTML
;
  }
  else {
    print <<EndHTML
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Link as affiliatetrade? 
        <select name="trade">
          <option value="1">Yes</option>
          <option value="2" selected>No</option>
        </select>
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool type=checkbox value="yes">
        Cool site?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email:- <a href="mailto:$email">$email</a> 
        <input type=hidden name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removesub&remove=$linenum&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this Submission</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=want value=addsub>
        <input type=hidden name=addsub value=$linenum>
        <input type=submit value=Add>
        </font></TD>
    </TR>
    </form>
EndHTML
;
  }

  $linenum++;
} ## End loop

print <<EndHTML
  </table>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove submissions
##################################################

sub removesub {

open(INF,"$data/submissions.dta") || &errormessage("Could not open submissions file"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/submissions.dta") || &errormessage("Could not open submissions file, file may not be writeable");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&message("Operation complete","Submission has been removed, please refresh the previous page before removing another submission");

} ## End sub


##################################################
######################## Add submission
##################################################

sub addsub {

open(OUTF,">>$data/$FORM{'category'}/category.dta") || &errormessage("Could not open output file \"$FORM{'category'}/category.dta\"");
flock(OUTF,2);
  print OUTF
  "$FORM{'name'}¦$FORM{'description'}¦$FORM{'url'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    print OUTF
    "$FORM{\"u$usernum\"}¦";
  } ## end loop
  print OUTF
  "$FORM{'cert'}¦$FORM{'cool'}¦$FORM{'trade'}¦$yday¦$year¦$FORM{'email'}¦$FORM{'password'}\n";
flock(OUTF,8);
close(OUTF); ## Close file

open(INF,"$data/submissions.dta") || &errormessage("Could not open submissions file"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/submissions.dta") || &errormessage("Could not open output file submissions.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $FORM{'addsub'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml($FORM{'category'});

&message("Operation complete","The site has been added to the database, please refresh the previous page before adding/removing another site");

} ## End sub


##################################################
######################## View modifications
##################################################

sub viewmodify {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Sites submitted 
  to be modified</font></p>
  <table BORDER=1 COLS=21>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Category</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Site name</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Certificate</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Affiliate program</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Traded</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Rank high?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Cool?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove modification</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Add modification</font></TD>
    </TR>
EndHTML
$linenum = 0;
open(INF,"$data/modify.dta"); ## || &errormessage("Could not open modify file, file may be empty"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($sitenameold, $catname, $sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$affil,$trade,$email,$password) = split(/¦/, $line);
  print <<EndHTML
    <form action="$programurl/manager.cgi?want=addmodify&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=sitenameold value="$sitenameold">
        <input type=hidden name=password value="$password">
        <input name=category type=text value="$catname">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=name type=text value="$sitename">
        <a href="$siteurl" target="_default">link</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=description type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=url type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 type=text value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 type=text value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 type=text value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 type=text value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 type=text value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 type=text value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 type=text value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 type=text value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 type=text value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 type=text value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cert type=text value="$cert">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Runs an affiliate 
        program:- $affil</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Trading:- $trade 
        <input type=hidden name=trade value=$trade>
        </font></TD>
EndHTML
;

  if ($trade || $affil eq "Yes") {
    print <<EndHTML
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Link as affiliatetrade? 
        <select name="trade">
          <option value="1" selected>Yes</option>
          <option value="0">No</option>
        </select>
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool type=checkbox value="yes">
        Cool site?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email:- <a href="mailto:$email">$email</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removemodify&remove=$linenum&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this Submission</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=addsub value=$linenum>
        <input type=hidden name=email value=$email>
        <input type=submit value=Add>
        </font></TD>
    </TR>
    </form>
EndHTML
;
  }
  else {
    print <<EndHTML
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Link as affiliatetrade? 
        <select name="trade">
          <option value="1">Yes</option>
          <option value="0" selected>No</option>
        </select>
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool type=checkbox value="yes">
        Cool site?</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email:- <a href="mailto:$email">$email</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removemodify&remove=$linenum&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this Submission</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=addsub value=$linenum>
        <input type=hidden name=email value=$email>
        <input type=submit value=Add>
        </font></TD>
    </TR>
    </form>
EndHTML
;
  }

  $linenum++;
} ## End loop

print <<EndHTML
  </table>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove modifications
##################################################

sub removemodify {

open(INF,"$data/modify.dta") || &errormessage("Could not open modify file"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/modify.dta") || &errormessage("Could not open modify file, file may not be writeable");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&message("Operation complete","Modification has been removed, please refresh the previous page before removing another modification");

} ## End sub


##################################################
######################## Add modification
##################################################

sub addmodify {

open(INF,"$data/$FORM{'category'}/category.dta") || &errormessage("Could not open category file"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/$FORM{'category'}/category.dta") || &errormessage("Could not open output file \"$FORM{'category'}/category.dta\"");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    if ($sitename eq $FORM{'sitenameold'}) {
      print OUTF
      "$FORM{'name'}¦$FORM{'description'}¦$FORM{'url'}¦";
      for ($usernum = 1; $usernum < 11; $usernum++) {
        $tempvar = "u$usernum";
        print OUTF
        "$FORM{$tempvar}¦";
      } ## end loop
      print OUTF
      "$FORM{'cert'}¦$FORM{'cool'}¦$FORM{'trade'}¦$yday¦$year¦$FORM{'email'}¦$FORM{'password'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End if
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

open(INF,"$data/modify.dta") || &errormessage("Could not open modification submissions file");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/modify.dta") || &errormessage("Could not open output file modify.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $FORM{'addsub'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml($FORM{'category'});

&message("Operation complete","The site has been added to the database, please refresh the previous page before adding/removing another site");

} ## End sub


##################################################
######################## View category
##################################################

sub viewcat {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Sites submitted 
  to be modified</font></p>
  <table BORDER=1 COLS=8>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Category</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View sub categories</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View sites</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View topsites</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View advertising</font></TD>
    </TR>
EndHTML

open(INF,"$data/categories.dta"); ## || &errornote("Could not open file categories.dta, file may not exist yet"); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($catname, $catdescription) = split(/¦/, $line);
  print <<EndHTML;
    <form action="$programurl/manager.cgi?want=modifycat&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        $catname
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=catdescription type=text value="$catdescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=catname value="$catname">
        <input type=hidden name=username value="$WHATWANT{'username'}">
        <input type=hidden name=password value="$WHATWANT{'password'}">
        <input type=submit value="Modify">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removecat&remove=$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}&catname=$catname">Remove 
        this Catagory</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewsubcat&catname=$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
        sub Catagories</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewsite&catname=$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
        sites</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewtopsite&catname=$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
        topsites</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewcads&catname=$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
        advertising</a></font></TD>
    </TR>
    </form>
EndHTML
;
} ## End loop

print <<EndHTML;
  </table>
  <form action="$programurl/manager.cgi?want=createcat&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}" method=post>
  <p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Add new category</font></p>
  <table width="350" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Category name:</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input type=text name=catname size=30>
        </font></td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Description:</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input type=text name=catdescription size=30>
        </font></td>
    </tr>
  </table>
  <p>
    <input type=submit value="Create">
  </p>
  </form>
</body>
</html>
EndHTML

} ## End sub

##################################################
######################## Create category
##################################################

sub createcat {

if (exists $FORM{'catplus'}) {
  open(OUTF,">>$data/$FORM{'catplus'}/category.sub")  || &errormessage("Could not open output file $FORM{'catplus'}/category.sub, make sure folder is writeable");
  flock(OUTF,2);
    print OUTF
    "$FORM{'catname'}¦$FORM{'catdescription'}\n"; ## Write user fields
  flock(OUTF,8);
  close(OUTF); ## Close file
  $FORM{'catname'} = "$FORM{'catplus'}/$FORM{'catname'}";
}
else {
  open(OUTF,">>$data/categories.dta") || &errormessage("Could not open output file categories.dta");
  flock(OUTF,2);
    print OUTF
    "$FORM{'catname'}¦$FORM{'catdescription'}\n"; ## Write user fields
  flock(OUTF,8);
  close(OUTF); ## Close file
}

mkdir("$data/$FORM{'catname'}", 0777) || &errormessage("Could not create directory $FORM{'catname'}");
open(OUTF,">>$data/catsearchdata.dta")  || &errormessage("Could not open output file catsearchdata.dta");
flock(OUTF,2);
  print OUTF
  "$FORM{'catname'}¦$FORM{'catdescription'}\n"; ## Write user fields
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catplus'}");
&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The new category has been created");

} ## End sub


##################################################
######################## Modify category
##################################################

sub modifycat {

open(INF,"$data/categories.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/categories.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    if ($catname eq $FORM{'catname'}) {
      print OUTF
      "$catname¦$FORM{'catdescription'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End else
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

open(INF,"$data/catsearchdata.dta");
  @userdata2 = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/catsearchdata.dta");
flock(OUTF,2);
  foreach $line (@userdata2) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    if ($catname eq $FORM{'catname'}) {
      print OUTF
      "$catname¦$FORM{'catdescription'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End else
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The category description has been changed");

} ## End sub


##################################################
######################## Re-generate categories
##################################################

sub regeneratecats {

open(INF,"$data/catsearchdata.dta");
  @userdata2 = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata2) {
  chomp($line);
  ($catname, $catdescription) = split(/¦/, $line);
  &generatecathtml("$catname");
} ## End loop

&message("Operation complete","The categories have been re-generated");

} ## End sub


##################################################
######################## Remove category
##################################################

sub removecat {

if (-e "$data/$WHATWANT{'catname'}/category.sub") {
  open(INF,"$data/$WHATWANT{'catname'}/category.sub") || &errornote("Could not open file $WHATWANT{'catname'}/category.sub");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  if ($userdata[0] ne "") { &errormessage("Category still contains sub categories, you must remove these first."); }
} ## End if

if (exists $WHATWANT{'maincat'}) {
  open(INF,"$data/$WHATWANT{'maincat'}/category.sub") || &errornote("Could not open file $WHATWANT{'maincat'}/category.sub");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  open(OUTF,">$data/$WHATWANT{'maincat'}/category.sub") || &errormessage("Could not open output file $WHATWANT{'maincat'}/category.sub");
  flock(OUTF,2);
    foreach $line (@userdata) {
      chomp($line);
      ($catname, $catdescription) = split(/¦/, $line);
      if ($catname ne $WHATWANT{'remove'}) {
        print OUTF
        "$line\n"; ## Write user fields
      } ## End if
    } ## End loop
  flock(OUTF,8);
  close(OUTF); ## Close file
}
else {
  open(INF,"$data/categories.dta") || &errornote("Could not open file categories.dta");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  open(OUTF,">$data/categories.dta") || &errormessage("Could not open output file categories.dta");
  flock(OUTF,2);
    foreach $line (@userdata) {
      chomp($line);
      ($catname, $catdescription) = split(/¦/, $line);
      if ($catname ne $WHATWANT{'remove'}) {
        print OUTF
        "$line\n"; ## Write user fields
      } ## End if
    } ## End loop
  flock(OUTF,8);
  close(OUTF); ## Close file
}

if (exists $WHATWANT{'maincat'}) {
  $WHATWANT{'remove'} = "$WHATWANT{'maincat'}/$WHATWANT{'remove'}";
} ## End if

open(INF,"$data/catsearchdata.dta") || &errornote("Could not open file catsearchdata.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/catsearchdata.dta") || &errormessage("Could not open output file catsearchdata.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    if ($catname ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file


unlink("$data/$WHATWANT{'catname'}/category.dta");
unlink("$data/$WHATWANT{'catname'}/category.top");
unlink("$data/$WHATWANT{'catname'}/category.sub");
unlink("$data/$WHATWANT{'catname'}/category.ads");
$tempfilename = "$data/$WHATWANT{'catname'}/index.html";
unlink($tempfilename);
rmdir("$data/$WHATWANT{'catname'}") || &errornote("Could not remove folder $WHATWANT{'catname'}. It probably still contains data files, you may now remove this folder via FTP");

&generatecathtml("$WHATWANT{'maincat'}");

&message("Operation complete","The selected category has been removed");

} ## End sub


##################################################
######################## View sub categories
##################################################

sub viewsubcat {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">You are in the $WHATWANT{'catname'} category</font></p>
  
<table BORDER=1 COLS=8>
  <TR> 
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Category</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View sub categories</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View sites</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View topsites</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View advertising</font></TD>
  </TR>
EndHTML

open(INF,"$data/$WHATWANT{'catname'}/category.sub"); ## || &errornote("Could not open file $WHATWANT{'catname'}/category.sub, file may not exist yet."); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($catname, $catdescription) = split(/¦/, $line);
  print <<EndHTML;
  <form action="$programurl/manager.cgi?want=modifycat2&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
  <TR> 
    <TD> 
        <font face="Verdana, Arial, Helvetica, sans-serif">$catname 
        <input type=hidden name=catname value="$catname">
        </font> 
    </TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
      <input name=catdescription type=text value="$catdescription">
      </font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
      <input type=hidden name=catnamelong value="$WHATWANT{'catname'}/$catname">
      <input type=hidden name=catnamemain value="$WHATWANT{'catname'}">
      <input type=hidden name=username value="$WHATWANT{'username'}">
      <input type=hidden name=password value="$WHATWANT{'password'}">
      <input type=submit value="Modify">
      </font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removecat&maincat=$WHATWANT{'catname'}&remove=$catname&catname=$WHATWANT{'catname'}/$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
      this Catagory</a></font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewsubcat&catname=$WHATWANT{'catname'}/$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
      sub categories</a></font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewsite&catname=$WHATWANT{'catname'}/$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
      sites</a></font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewtopsite&catname=$WHATWANT{'catname'}/$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
      topsites</a></font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=viewcads&catname=$WHATWANT{'catname'}/$catname&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">View 
      advertising</a></font></TD>
  </TR>
  </form>
EndHTML
;
} ## End loop

print <<EndHTML;
</table>
  <form action="$programurl/manager.cgi?want=createcat&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}" method=post>
  <p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Add new category</font></p>
  <table width="350" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Category name:</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input type=text name=catname size=30>
        </font></td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Description:</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">
        <input type=text name=catdescription size=30>
        </font></td>
    </tr>
  </table>
  <p><font face="Verdana, Arial, Helvetica, sans-serif"> 
    <input type=hidden name=catplus value="$WHATWANT{'catname'}">
    </font><font face="Verdana, Arial, Helvetica, sans-serif"> 
    <input type=submit value="Create">
    </font></p>
  </form></body>
</html>
EndHTML

} ## End sub


##################################################
######################## Modify category
##################################################

sub modifycat2 {

open(INF,"$data/$FORM{'catnamemain'}/category.sub");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/$FORM{'catnamemain'}/category.sub");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    if ($catname eq $FORM{'catname'}) {
      print OUTF
      "$catname¦$FORM{'catdescription'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End else
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

open(INF,"$data/catsearchdata.dta");
  @userdata2 = <INF>; ## Put into an array
close(INF); ## Close file
open(OUTF,">$data/catsearchdata.dta");
flock(OUTF,2);
  foreach $line (@userdata2) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    if ($catname eq $FORM{'catnamelong'}) {
      print OUTF
      "$catname¦$FORM{'catdescription'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n";
    } ## End else
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catnamelong'}");
&generatecathtml("$FORM{'catnamemain'}");

&message("Operation complete","The category description has been changed");

} ## End sub


##################################################
######################## Generate category HTML
##################################################

sub generatecathtml {

$categoryname = $_[0];
($categorynameshort2, $categorynameshort) = $categoryname =~ m!^(.+/)(.+)?$!;

unless ($categoryname =~ /\//) { $categorynameshort = $categoryname; } ## End unless

if (-e "$data/$categoryname/category.ads") {
  open(INF,"$data/$categoryname/category.ads");
    $adsdata = <INF>; ## Put into an array
  close(INF); ## Close file
  chomp($adsdata);
  ($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$email) = split(/¦/, $adsdata);
  open(FILE, "$categoryb");
    @categoryba = <FILE>;
  close(FILE);
  $categorybanner = join('',@categoryba);
  $categorybanner =~ s/::bannerurl::/$bannerurl/gis;
  $categorybanner =~ s/::siteurl::/$siteurl/gis;
  $categorybanner =~ s/::sitedescription::/$sitedescription/gis;
  $categorybanner =~ s/::u1::/$u1/gis;
  $categorybanner =~ s/::u2::/$u2/gis;
  $categorybanner =~ s/::u3::/$u3/gis;
  $categorybanner =~ s/::u4::/$u4/gis;
  $categorybanner =~ s/::u5::/$u5/gis;
  $categorybanner =~ s/::u6::/$u6/gis;
  $categorybanner =~ s/::u7::/$u7/gis;
  $categorybanner =~ s/::u8::/$u8/gis;
  $categorybanner =~ s/::u9::/$u9/gis;
  $categorybanner =~ s/::u10::/$u10/gis;

} ## End if

$addsitelink = "$programurl/submit.cgi?want=addsitemaker&category=$categoryname";
$modifysitelink = "$programurl/submit.cgi?want=modcatdisplay&category=$categoryname";

open(FILE, "$categoryp");
  @categorypa = <FILE>;
close(FILE);
$categorypage = join('',@categorypa);
$content = $categorypage;
$content =~ s/::addsitelink::/$addsitelink/gis;
$content =~ s/::modifysitelink::/$modifysitelink/gis;
$content =~ s/::catname::/$categoryname/gis;
$content =~ s/::catnameshort::/$categorynameshort/gis;
$content =~ s/::catnameshort2::/$categorynameshort2/gis;
$content =~ s/::banner::/$categorybanner/gis;
($pagetop, $pagemiddle1, $pagemiddle2, $pagebottom) = split(/::resultshere::/, $content);

open(OUTF,">$data/$categoryname/index.html") || &errormessage("Could not open output file index.html");
flock(OUTF,2);

  print OUTF
  "$pagetop\n";

if (-e "$data/$categoryname/category.sub") {
  open(INF,"$data/$categoryname/category.sub");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file

  $cat_matches = @userdata;

  if ($cat_matches < 1) {
    print OUTF "$nocatincattext\n";
  } ## End if

  open(FILE, "$categoryc");
    @categoryca = <FILE>;
  close(FILE);
  $categorycat = join('',@categoryca);
  foreach $line (@userdata) {
    chomp($line);
    ($catname, $catdescription) = split(/¦/, $line);
    $content = $categorycat;
    $caturl = "$data_url/$categoryname/$catname";
    $content =~ s/::catname::/$catname/gis;
    $content =~ s/::caturl::/$caturl/gis;
    $content =~ s/::catdescription::/$catdescription/gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  print OUTF "$nocatincattext\n";
} ## End else

  print OUTF
  "$pagemiddle1\n";

if (-e "$data/$categoryname/category.top") {
  open(INF,"$data/$categoryname/category.top");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  $site_matches = @userdata;

  open(FILE, "$categoryt");
    @categoryto = <FILE>;
  close(FILE);
  $categorytopsite = join('',@categoryto);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$ig1,$ig2,$email) = split(/¦/, $line);
    $content = $categorytopsite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  $site_matches = 0;
} ## End else

  print OUTF
  "$pagemiddle2\n";

if (-e "$data/$categoryname/category.dta") {
  open(INF,"$data/$categoryname/category.dta");
    @userdata = <INF>; ## Put into an array
  close(INF); ## Close file
  @userdata = sort(@userdata);
  $site_matches_tmp = @userdata;
  $site_matches += $site_matches_tmp;

  if ($site_matches < 1) {
    print OUTF "$nositesincattext";
  } ## End if

  for ( $loopnum = $#tradesites ; $loopnum>=0 ; $loopnum-- ) {
    shift(@tradesites);
  } ## End loop
  for ( $loopnum = $#nontradesites ; $loopnum>=0 ; $loopnum-- ) {
    shift(@nontradesites);
  } ## End loop

  open(FILE, "$categorys");
    @categorysi = <FILE>;
  close(FILE);
  $categorysite = join('',@categorysi);
  foreach $line (@userdata) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    if ($affiltrade) {
      push(@tradesites,$line);
    } ## End if
    else {
      push(@nontradesites,$line);
    } ## End else
  } ## End loop
  foreach $line (@tradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $content =~ s/::modify:://gis;
    print OUTF
    "$content\n";
  } ## End loop
  foreach $line (@nontradesites) {
    chomp($line);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
    $content = $categorysite;
    $content =~ s/::siteurl::/$siteurl/gis;
    $content =~ s/::sitename::/$sitename/gis;
    $content =~ s/::sitedescription::/$sitedescription/gis;
    $content =~ s/::u1::/$u1/gis;
    $content =~ s/::u2::/$u2/gis;
    $content =~ s/::u3::/$u3/gis;
    $content =~ s/::u4::/$u4/gis;
    $content =~ s/::u5::/$u5/gis;
    $content =~ s/::u6::/$u6/gis;
    $content =~ s/::u7::/$u7/gis;
    $content =~ s/::u8::/$u8/gis;
    $content =~ s/::u9::/$u9/gis;
    $content =~ s/::u10::/$u10/gis;
    if ($cool) {
      $content =~ s/::coolsite::/$coolsitelogo/gis;
    } ## End if
    $content =~ s/::coolsite:://gis;
    $content =~ s/::modify:://gis;
    print OUTF
    "$content\n";
  } ## End loop
} ## End if
else {
  if ($site_matches < 1) { 
    print OUTF "$nositesincattext";
  } ## End if
} ## End else

  print OUTF
  "$pagebottom\n";

flock(OUTF,8);
close(OUTF); ## Close file

} ## End sub


##################################################
######################## Generate searchdata
##################################################

sub gensd {

open(INF,"$data/catsearchdata.dta") || &errormessage("Could not open file catsearchdata.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($catname, $catdescription) = split(/¦/, $line);
  open(INF2,"$data/$catname/category.dta"); ## || &errornote("Could not open file $catname/category.dta, category may be empty");
    @categorydata = <INF2>; ## Put into an array
  close(INF2); ## Close file
  foreach $siteinfo (@categorydata) {
    chomp($siteinfo);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $siteinfo);
    push(@sitesearchdata, "$catname¦$sitename¦$sitedescription¦$siteurl¦$u1¦$u2¦$u3¦$u4¦$u5¦$u6¦$u7¦$u8¦$u9¦$u10¦$cert¦$affiltrade¦$cool");
  } ## End loop
  open(INF2,"$data/$catname/category.top");
    @categorytopdata = <INF2>; ## Put into an array
  close(INF2); ## Close file
  foreach $topsiteinfo (@categorytopdata) {
    chomp($topsiteinfo);
    ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$email) = split(/¦/, $topsiteinfo);
    push(@topsitesearchdata, "$catname¦$sitename¦$sitedescription¦$siteurl¦$u1¦$u2¦$u3¦$u4¦$u5¦$u6¦$u7¦$u8¦$u9¦$u10¦$cert¦$cool");
  } ## End loop
} ## End loop

open(OUTF,">$data/topsites2.dta") || &errormessage("Could not open output file topsites2.dta");
flock(OUTF,2);
  foreach $line (@topsitesearchdata) {
    chomp($line);
    print OUTF
    "$line\n"; ## Write user fields
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

open(OUTF,">$data/searchdata2.dta") || &errormessage("Could not open output file searchdata2.dta");
flock(OUTF,2);
  foreach $line (@sitesearchdata) {
    chomp($line);
    print OUTF
    "$line\n"; ## Write user fields
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

unlink("$data/searchdata.old");
rename("$data/searchdata.dta","$data/searchdata.old");
rename("$data/searchdata2.dta","$data/searchdata.dta");

unlink("$data/topsites.old");
rename("$data/topsites.dta","$data/topsites.old");
rename("$data/topsites2.dta","$data/topsites.dta");

&message("Operation complete","Search database generated");

} ## End sub


##################################################
######################## View category sites
##################################################

sub viewsite {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">You are in the $WHATWANT{'catname'} category viewing sites</font></p>
  <table BORDER=1 COLS=20>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Sitename</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Certificate</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Coolsite</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Affiliatetrade</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">email</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View page</font></TD>
    </TR>
EndHTML

$linenum = 0;
open(INF,"$data/$WHATWANT{'catname'}/category.dta"); ## || &errornote("Could not open file $WHATWANT{'catname'}/category.dta, file may not exist yet."); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$affiltrade,$ig1,$ig2,$email,$password) = split(/¦/, $line);
  print <<EndHTML;
    <form action="$programurl/manager.cgi?want=modifysite&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=password type=hidden value="$password">
        <input type=text name=sitename value="$sitename">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cert value="$cert">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool value="$cool">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=trade value="$affiltrade">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=catname value="$WHATWANT{'catname'}">
        <input type=hidden name=sitenum value="$linenum">
        <input type=submit value="Modify">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removesite&catname=$WHATWANT{'catname'}&remove=$linenum&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this site</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$siteurl" target="_default">View 
        site</a></font></TD>
    </TR>
    </form>
EndHTML
;
  $linenum++;
} ## End loop

print <<EndHTML
  </table>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove site
##################################################

sub removesite {

open(INF,"$data/$WHATWANT{'catname'}/category.dta") || &errormessage("Could not open file $WHATWANT{'catname'}/category.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/$WHATWANT{'catname'}/category.dta") || &errormessage("Could not open output file $WHATWANT{'catname'}/category.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$WHATWANT{'catname'}");

&message("Operation complete","The selected site has been removed, please refresh previos page before editing more sites");

} ## End sub


##################################################
######################## Modify site
##################################################

sub modifysite {

open(INF,"$data/$FORM{'catname'}/category.dta") || &errornote("Could not open file $FORM{'catname'}/category.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/$FORM{'catname'}/category.dta") || &errormessage("Could not open output file $FORM{'catname'}/category.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum eq $FORM{'sitenum'}) {
      print OUTF
      "$FORM{'sitename'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
      for ($usernum = 1; $usernum < 11; $usernum++) {
        $tempvar = "u$usernum";
        print OUTF
        "$FORM{$tempvar}¦";
      } ## end loop
      print OUTF
      "$FORM{'cert'}¦$FORM{'cool'}¦$FORM{'trade'}¦$yday¦$year¦$FORM{'email'}¦$FORM{'password'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End else
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The selected site has been modified, please refresh previous page before editing more sites");

} ## End sub


##################################################
######################## View category topsites
##################################################

sub viewtopsite {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">You are in the $WHATWANT{'catname'} category Viewing top listing sites</font></p>
  <table BORDER=1 COLS=20>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Sitename</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Certificate</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Coolsite</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">email</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">View page</font></TD>
    </TR>
EndHTML

$linenum = 0;
open(INF,"$data/$WHATWANT{'catname'}/category.top"); ## || &errornote("Could not open file $WHATWANT{'catname'}/category.top, file may not exist yet."); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($sitename, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$cert,$cool,$ig1,$ig2,$email) = split(/¦/, $line);
  print <<EndHTML;
    <form action="$programurl/manager.cgi?want=modifytopsite&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=text name=sitename value="$sitename">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cert value="$cert">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool value="$cool">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=catname value="$WHATWANT{'catname'}">
        <input type=hidden name=sitenum value="$linenum">
        <input type=submit value="Modify">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removetopsite&catname="$WHATWANT{'catname'}"&remove="$linenum"&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this site</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$siteurl" target="_default">View 
        site</a></font></TD>
    </TR>
    </form>
EndHTML
;
  $linenum++;
} ## End loop

print <<EndHTML;
  </table>
<p><br>
  <font face="Verdana, Arial, Helvetica, sans-serif" size="4">Add new Top listing 
  site</font></p>
<form action="$programurl/manager.cgi?want=addtopsite&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
  <table border=1 cols=18>
    <TR>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Sitename</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Certificate</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Coolsite</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">email</font></td>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Add Site</font></TD>
    </TR>
    <TR> 
      <TD> <font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=text name=sitename value="">
        </font> </TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="http://">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cert value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=cool value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=catname value="$WHATWANT{'catname'}">
        <input type=hidden name=username value=$WHATWANT{'username'}>
        <input type=hidden name=password value=$WHATWANT{'password'}">
        <input type=submit value="ADD">
        </font></TD>
    </TR>
  </table>
</form>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove topsite
##################################################

sub removetopsite {

open(INF,"$data/$WHATWANT{'catname'}/category.top") || &errormessage("Could not open file $WHATWANT{'catname'}/category.top");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/$WHATWANT{'catname'}/category.top") || &errormessage("Could not open output file $WHATWANT{'catname'}/category.top");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$WHATWANT{'catname'}");

&message("Operation complete","The selected site has been removed, please refresh previos page before editing more sites");

} ## End sub


##################################################
######################## Modify topsite
##################################################

sub modifytopsite {

open(INF,"$data/$FORM{'catname'}/category.top") || &errornote("Could not open file $FORM{'catname'}/category.top");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/$FORM{'catname'}/category.top") || &errormessage("Could not open output file $FORM{'catname'}/category.top");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum eq $FORM{'sitenum'}) {
      print OUTF
      "$FORM{'sitename'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
      for ($usernum = 1; $usernum < 11; $usernum++) {
        print OUTF
        "$FORM{\"u$usernum\"}¦";
      } ## end loop
      print OUTF
      "$FORM{'cert'}¦$FORM{'cool'}¦$yday¦$year¦$FORM{'email'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End else
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The selected top site has been modified, please refresh previous page before editing more sites");

} ## End sub


##################################################
######################## Add topsite
##################################################

sub addtopsite {

open(OUTF,">>$data/$FORM{'catname'}/category.top") || &errormessage("Could not open output file \"$FROM{'catname'}/category.top\"");
flock(OUTF,2);
  print OUTF
  "$FORM{'sitename'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    print OUTF
    "$FORM{\"u$usernum\"}¦";
  } ## end loop
  print OUTF
  "$FORM{'cert'}¦$FORM{'cool'}¦$yday¦$year¦$FORM{'email'}\n";
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The top site has been added to the database, please refresh the previous page before adding/removing another site");

} ## End sub


##################################################
######################## View category advertising
##################################################

sub viewcads {

open(INF,"$data/$WHATWANT{'catname'}/category.ads"); ## || &errornote("Could not open file $WHATWANT{'catname'}/category.ads, file may not exist yet."); ## Open read file
  $line = <INF>; ## Put into an array
close(INF); ## Close file
chomp($line);
($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$email) = split(/¦/, $line);
print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">You are in the $WHATWANT{'catname'} category Viewing advertising</font></p>
  
<table BORDER=1 COLS=17>
  <TR> 
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">SiteBanner</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">email</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View page</font></TD>
  </TR>
  <form action="$programurl/manager.cgi?want=modifycads&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=text name=bannerurl value="$bannerurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=catname value="$WHATWANT{'catname'}">
        <input type=hidden name=sitenum value="$linenum">
        <input type=hidden name=username value=$WHATWANT{'username'}>
        <input type=hidden name=password value=$WHATWANT{'password'}">
        <input type=submit value="Modify/Add">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removecads&catname="$WHATWANT{'catname'}"&remove="$linenum"&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this Ad</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$siteurl" target="_default">View 
        site</a></font></TD>
    </TR>
  </form>
</table>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove category advertising
##################################################

sub removecads {

unlink("$data/$WHATWANT{'catname'}/category.ads");
&message("Operation complete","The advertising file has been removed, please refresh the previous page before adding another advert");

&generatecathtml("$WHATWANT{'catname'}");

} ## End sub


##################################################
######################## Modify category advertising
##################################################

sub modifycads {

open(OUTF,">$data/$FORM{'catname'}/category.ads") || &errormessage("Could not open output file \"$FROM{'catname'}/category.ads\"");
flock(OUTF,2);
  print OUTF
  "$FORM{'bannerurl'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    print OUTF
    "$FORM{\"u$usernum\"}¦";
  } ## end loop
  print OUTF
  "$FORM{'email'}";
flock(OUTF,8);
close(OUTF); ## Close file

&generatecathtml("$FORM{'catname'}");

&message("Operation complete","The category advert has been added, please refresh the previous page before modifying/removing another advert");

} ## End sub


##################################################
######################## View keyword advertising
##################################################

sub viewads {

print <<EndHTML;
<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF" text="#000000" link="#000000" vlink="#000000" alink="#000000">
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">You are viewing keyword advertising</font></p>
  
<table BORDER=1 COLS=20>
  <TR> 
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">BannerURL</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Keywords (separated 
      by ',')</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Email</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Modify</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">Remove</font></TD>
    <TD><font face="Verdana, Arial, Helvetica, sans-serif">View page</font></TD>
  </TR>
EndHTML

$linenum = 0;
open(INF,"$data/advertise.dta"); ## || &errornote("Could not open file advertise.dta, file may not exist yet."); ## Open read file
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
foreach $line (@userdata) {
  chomp($line);
  ($bannerurl, $sitedescription, $siteurl,$u1,$u2,$u3,$u4,$u5,$u6,$u7,$u8,$u9,$u10,$keywords,$email) = split(/¦/, $line);
  print <<EndHTML;
  <form action="$programurl/manager.cgi?want=modifyads&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
    <TR> 
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=text name=bannerurl value="$bannerurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="$sitedescription">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="$siteurl">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="$u1">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="$u2">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="$u3">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="$u4">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="$u5">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="$u6">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="$u7">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="$u8">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="$u9">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="$u10">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=keywords value="$keywords">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="$email">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=adnum value="$linenum">
        <input type=hidden name=username value=$WHATWANT{'username'}>
        <input type=hidden name=password value=$WHATWANT{'password'}">
        <input type=submit value="Modify">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$programurl/manager.cgi?want=removeads&remove="$linenum"&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}">Remove 
        this site</a></font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"><a href="$siteurl" target="_default">View 
        site</a></font></TD>
    </TR>
  </form>
EndHTML
;
  $linenum++;
} ## End loop
print "</table>";

print <<EndHTML;
</table>
<p> <font face="Verdana, Arial, Helvetica, sans-serif" size="4">Add new keyword 
  advert</font></p>
<form action="$programurl/manager.cgi?want=addads&password=$WHATWANT{'password'}&username=$WHATWANT{'username'}" method=post>
  <table border=1 cols=16>
    <TR>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">BannerURL</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Description</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">URL</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User1</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User2</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User3</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User4</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User5</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User6</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User7</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User8</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User9</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">User10</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Keywords (separated 
        by ',')</font></td>
      <td><font face="Verdana, Arial, Helvetica, sans-serif">Email</font></td>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif">Add new advert</font></TD>
    </TR>
    <TR> 
      <TD> <font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=text name=bannerurl value="">
        </font> </TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=sitedescription type=text value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=siteurl type=text value="http://">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u1 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u2 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u3 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u4 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u5 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u6 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u7 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u8 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u9 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=u10 value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=keywords value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name=email value="">
        </font></TD>
      <TD><font face="Verdana, Arial, Helvetica, sans-serif"> 
        <input type=hidden name=username value=$WHATWANT{'username'}>
        <input type=hidden name=password value=$WHATWANT{'password'}">
        <input type=submit value="ADD">
        </font></TD>
    </TR>
  </table>
</form>
</body>
</html>
EndHTML

} ## End sub


##################################################
######################## Remove advert
##################################################

sub removeads {

open(INF,"$data/advertise.dta") || &errormessage("Could not open file advertise.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/advertise.dta") || &errormessage("Could not open output file advertise.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum ne $WHATWANT{'remove'}) {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End if
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&message("Operation complete","The advert site has been removed, please refresh previos page before editing more adverts");

} ## End sub


##################################################
######################## Modify advert
##################################################

sub modifyads {

open(INF,"$data/advertise.dta") || &errornote("Could not open file advertise.dta");
  @userdata = <INF>; ## Put into an array
close(INF); ## Close file
$linenum = 0;
open(OUTF,">$data/advertise.dta") || &errormessage("Could not open output file advertise.dta");
flock(OUTF,2);
  foreach $line (@userdata) {
    chomp($line);
    if ($linenum eq $FORM{'adnum'}) {
      print OUTF
      "$FORM{'bannerurl'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
      for ($usernum = 1; $usernum < 11; $usernum++) {
        print OUTF
        "$FORM{\"u$usernum\"}¦";
      } ## end loop
      print OUTF
      "$FORM{'keywords'}¦$FORM{'email'}\n";
    } ## End if
    else {
      print OUTF
      "$line\n"; ## Write user fields
    } ## End else
    $linenum++;
  } ## End loop
flock(OUTF,8);
close(OUTF); ## Close file

&message("Operation complete","The selected advert has been modified, please refresh previous page before editing more adverts");

} ## End sub


##################################################
######################## Add advert
##################################################

sub addads {

open(OUTF,">>$data/advertise.dta") || &errormessage("Could not open output file advertise.dta");
flock(OUTF,2);
  print OUTF
  "$FORM{'bannerurl'}¦$FORM{'sitedescription'}¦$FORM{'siteurl'}¦";
  for ($usernum = 1; $usernum < 11; $usernum++) {
    print OUTF
    "$FORM{\"u$usernum\"}¦";
  } ## end loop
  print OUTF
  "$FORM{'keywords'}¦$FORM{'email'}\n";
flock(OUTF,8);
close(OUTF); ## Close file

&message("Operation complete","The advert has been added to the database, please refresh the previous page before adding/removing another advert");

} ## End sub


##################################################
######################## Display Variables
##################################################

sub displayvariables {

$coolsitelogo =~ s/"/&quot;/gis;
$nextresultslink =~ s/"/&quot;/gis;
$modifyhtml =~ s/"/&quot;/gis;
$nositeresultstext =~ s/"/&quot;/gis;
$nocatresultstext =~ s/"/&quot;/gis;
$nositesincattext =~ s/"/&quot;/gis;
$nocatincattext =~ s/"/&quot;/gis;

print <<HTMLBLOCK
<html>
<head>
<title>Variable Setup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF">
<div align="center">
  <p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Variable Configuration</font></p>
  <form action="manager.cgi?want=savevariables&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}" method=post>
    <table width="70%" border="1" cellspacing="1" cellpadding="1">
      <tr> 
        <td>Search Data Folder system path</td>
        <td> 
          <input type="text" name="data" size="36" value="$data">
        </td>
      </tr>
      <tr> 
        <td>Search Data Folder URL</td>
        <td> 
          <input type="text" name="data_url" size="36" value="$data_url">
        </td>
      </tr>
      <tr> 
        <td>Program URL</td>
        <td> 
          <input type="text" name="programurl" size="36" value="$programurl">
        </td>
      </tr>
      <tr> 
        <td>Return link needed page</td>
        <td> 
          <input type="text" name="needlinkpage" size="36" value="$needlinkpage">
        </td>
      </tr>
      <tr> 
        <td>Site submission complete page</td>
        <td> 
          <input type="text" name="subcompletepage" size="36" value="$subcompletepage">
        </td>
      </tr>
      <tr> 
        <td>Maximum categories to be displayed in search results</td>
        <td> 
          <input type="text" name="maxcatshow" size="36" value="$maxcatshow">
        </td>
      </tr>
      <tr> 
        <td>Maximum sites to be displayed in search results</td>
        <td> 
          <input type="text" name="maxsiteshow" size="36" value="$maxsiteshow">
        </td>
      </tr>
      <tr> 
        <td>HTML for coolsite logo</td>
        <td> 
          <input type="text" name="coolsitelogo" size="36" value="$coolsitelogo">
        </td>
      </tr>
      <tr> 
        <td>HTML for next page of search results link<br>::url:: must be used for link url</td>
        <td> 
          <input type="text" name="nextresultslink" size="36" value="$nextresultslink">
        </td>
      </tr>
      <tr> 
        <td>HTML for modification link</td>
        <td> 
          <input type="text" name="modifyhtml" size="36" value="$modifyhtml">
        </td>
      </tr>
      <tr> 
        <td>Site submissions must link back</td>
        <td>
          <select name="tradeonly">
HTMLBLOCK
;
if ($tradeonly == 0) {
  print <<HTMLBLOCK
            <option value="0" selected>Off</option>
            <option value="1">On</option>
HTMLBLOCK
} ## End if
else {
  print <<HTMLBLOCK
            <option value="0">Off</option>
            <option value="1" selected>On</option>
HTMLBLOCK
} ## End if
print <<HTMLBLOCK
          </select>
        </td>
      </tr>
      <tr> 
        <td>Site modification submissions</td>
        <td>
          <select name="automodify">
HTMLBLOCK
;
if ($automodify == 0) {
  print <<HTMLBLOCK
            <option value="1">Instant updates</option>
            <option value="0" selected>Updates pending review</option>
HTMLBLOCK
} ## End if
else {
  print <<HTMLBLOCK
            <option value="1" selected>Instant updates</option>
            <option value="0">Updates pending review</option>
HTMLBLOCK
} ## End else

$certificate = join(',',@certificate);

print <<HTMLBLOCK
          </select>
        </td>
      </tr>
      <tr> 
        <td>Certificate Adult word list<br>Separate words with ',' have no spaces</td>
        <td>
          <input type="text" name="certificate" size="36" value="$certificate">
        </td>
      </tr>
      <tr> 
        <td>HTML for no site search results text</td>
        <td> 
          <input type="text" name="nositeresultstext" size="36" value="$nositeresultstext">
        </td>
      </tr>
      <tr> 
        <td>HTML for no category search results text</td>
        <td> 
          <input type="text" name="nocatresultstext" size="36" value="$nocatresultstext">
        </td>
      </tr>
      <tr> 
        <td>HTML for no sites in category text</td>
        <td> 
          <input type="text" name="nositesincattext" size="36" value="$nositesincattext">
        </td>
      </tr>
      <tr> 
        <td>HTML for no sub-categories in category text</td>
        <td> 
          <input type="text" name="nocatincattext" size="36" value="$nocatincattext">
        </td>
      </tr>
    </table>
    <input type="submit" value="Save New Configuration">
  </form>
</div>
</body>
</html>

HTMLBLOCK
;

} ## End sub


##################################################
######################## Save Variables
##################################################

sub savevariables {

&get_post_data;

@certificate = split(/,/, $FORM{'certificate'});

open(OUTF,">dirprovar.lib");
  print OUTF
"##################################################
######################## Define variables
##################################################

\$data = \"$FORM{'data'}\";
\$programurl = \"$FORM{'programurl'}\";
\$data_url = \"$FORM{'data_url'}\";
\$needlinkpage = \"$FORM{'needlinkpage'}\";
\$subcompletepage = \"$FORM{'subcompletepage'}\";
\$tradeonly = $FORM{'tradeonly'};
";

print OUTF "\@certificate = (";

foreach $line (@certificate) {
  chomp($line);
  print OUTF "\"$line\"";
  unless ($certificate[$#certificate] eq $line) { print OUTF ","; } ## End if
} ## End loop

print OUTF ");
\$categoryp = \"categoryp.tpl\"; ## Category page template
\$categorys = \"categorys.tpl\"; ## Category sites template
\$categoryt = \"categoryt.tpl\"; ## Category topsites template
\$categoryc = \"categoryc.tpl\"; ## Category subcat template
\$categoryb = \"categoryb.tpl\"; ## Category banner template
\$searchresultsp = \"searchresultsp.tpl\"; ## Search results page template
\$searchresultsb = \"searchresultsb.tpl\"; ## Search results banner template
\$searchresultss = \"searchresultss.tpl\"; ## Search results sites template
\$searchresultst = \"searchresultst.tpl\"; ## Search results topsites template
\$searchresultsc = \"searchresultsc.tpl\"; ## Search results categories template
\$maxcatshow = $FORM{'maxcatshow'}; ## Maximum number of categories to show per page
\$maxsiteshow = $FORM{'maxsiteshow'}; ## Maximum number of sites to show per page
\$coolsitelogo = \"$FORM{'coolsitelogo'}\";
\$nextresultslink = '$FORM{'nextresultslink'}';
\$addsitepage = \"addsite.tpl\";
\$modifyhtml = '$FORM{'modifyhtml'}';
\$modifypass = \"modifypass.tpl\"; ## Template for modify password page
\$modifypage = \"modifypage.tpl\"; ## Template for modify page
\$automodify = $FORM{'automodify'}; ## 1 for auto modify, 0 for submission
\$nositeresultstext = \"$FORM{'nositeresultstext'}\"; ## HTML for no site search results
\$nocatresultstext = \"$FORM{'nocatresultstext'}\"; ## HTML for no category search results
\$nositesincattext = \"$FORM{'nositesincattext'}\"; ## HTML for no sites in category
\$nocatincattext = \"$FORM{'nocatincattext'}\"; ## HTML for no sub-categories in category


1;";
close(OUTF); ## Close file

&message("Operation Complete","The variable changes have been saved");

} ## End sub


##################################################
######################## Change Password Form
##################################################

sub changepasswordform {

print <<HTMLBLOCK

<html>
<head>
<title>Management Area</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#6699FF">
<div align="center"> 
  <p><font face="Verdana, Arial, Helvetica, sans-serif" size="4">Please enter 
    your new Username/Password</font></p>
  <form action="manager.cgi?want=changepassword&username=$WHATWANT{'username'}&password=$WHATWANT{'password'}" method="POST">
    <table width="250" border="1" cellspacing="1" cellpadding="1">
      <tr> 
        <td><font face="Verdana, Arial, Helvetica, sans-serif">Username</font></td>
        <td> 
          <input type="text" size="20"
    name="username">
        </td>
      </tr>
      <tr> 
        <td><font face="Verdana, Arial, Helvetica, sans-serif">Password</font></td>
        <td> 
          <input type="text" size="20"
    name="password">
        </td>
      </tr>
    </table>
    <p align="center"> 
      <input type="submit" value="Enter">
    </p>
    </form>
</div>
</body>
</html>

HTMLBLOCK

} ## End sub


##################################################
######################## Change Password
##################################################

sub changepassword {

open(INF,"adminpass.txt");
  $userpass = <INF>; ## Put into an array
close(INF); ## Close file
chomp($userpass);
($username, $password) = split(/:/, $userpass);
$newpasscrypt = crypt($FORM{'password'}, substr($password, 0, 2));
open(OUTF,">adminpass.txt") || print "Cant open outf";
  print OUTF
  "$FORM{'username'}:$newpasscrypt";
close(OUTF);

&message("Operation Complete","Your new username/password combination has been saved");

} ## End sub













