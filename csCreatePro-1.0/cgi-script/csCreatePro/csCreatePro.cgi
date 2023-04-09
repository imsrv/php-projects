#!/usr/bin/perl
#
# csCreatePro - 020202
# 
#####################################################################
#                                                                   #
#    Copyright © 1999-2002 CGISCRIPT.NET - All Rights Reserved     #
#                                                                   #
#####################################################################
#                                                                   #
#          THIS COPYRIGHT INFORMATION MUST REMAIN INTACT            #
#                AND MAY NOT BE MODIFIED IN ANY WAY                 #
#                                                                   #
#####################################################################
#
# When you downloaded this script you agreed to accept the terms
# of this Agreement. This Agreement is a legal contract, which
# specifies the terms of the license and warranty limitation between
# you and CGISCRIPT.NET. You should carefully read the following
# terms and conditions before installing or using this software.
# Unless you have a different license agreement obtained from
# CGISCRIPT.NET, installation or use of this software indicates
# your acceptance of the license and warranty limitation terms
# contained in this Agreement. If you do not agree to the terms of this
# Agreement, promptly delete and destroy all copies of the Software.
#
# Versions of the Software
# Only one copy of the registered version of CGISCRIPT.NET
# may used on one web site.
#
# License to Redistribute
# Distributing the software and/or documentation with other products
# (commercial or otherwise) or by other than electronic means without
# CGISCRIPT.NET's prior written permission is forbidden.
# All rights to the CGISCRIPT.NET software and documentation not expressly
# granted under this Agreement are reserved to CGISCRIPT.NET.
#
# Disclaimer of Warranty
# THIS SOFTWARE AND ACCOMPANYING DOCUMENTATION ARE PROVIDED "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY OTHER
# WARRANTIES WHETHER EXPRESSED OR IMPLIED.   BECAUSE OF THE VARIOUS HARDWARE
# AND SOFTWARE ENVIRONMENTS INTO WHICH CGISCRIPT.NET MAY BE USED, NO WARRANTY
# OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.  THE USER MUST ASSUME THE
# ENTIRE RISK OF USING THIS PROGRAM.  ANY LIABILITY OF CGISCRIPT.NET WILL BE
# LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR REFUND OF PURCHASE PRICE.
# IN NO CASE SHALL CGISCRIPT.NET BE LIABLE FOR ANY INCIDENTAL, SPECIAL OR
# CONSEQUENTIAL DAMAGES OR LOSS, INCLUDING, WITHOUT LIMITATION, LOST PROFITS
# OR THE INABILITY TO USE EQUIPMENT OR ACCESS DATA, WHETHER SUCH DAMAGES ARE
# BASED UPON A BREACH OF EXPRESS OR IMPLIED WARRANTIES, BREACH OF CONTRACT,
# NEGLIGENCE, STRICT TORT, OR ANY OTHER LEGAL THEORY. THIS IS TRUE EVEN IF
# CGISCRIPT.NET IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IN NO CASE WILL
# CGISCRIPT.NET' LIABILITY EXCEED THE AMOUNT OF THE LICENSE FEE ACTUALLY PAID
# BY LICENSEE TO CGISCRIPT.NET.
#
# Credits:
# Andy Angrick - Programmer - angrick@cgiscript.net
# Mike Barone - Design - mbarone@cgiscript.net
#
# For information about this script or other scripts see
# http://www.cgiscript.net
#
# Thank you for trying out our script.
# If you have any suggestions or ideas for a new innovative script
# please direct them to suggest@cgiscript.net.  Thanks.
#
#####################################################################
#                                                                   #
#    Configuration variables                                        #
#                                                                   #
#####################################################################
(! -e "setup.cgi")?(&Setup):(require("setup.cgi"));

#####################################################################
#                                                                   #
#    End Configuration Variables.                                   #
#                                                                   #
#####################################################################
require("libs.cgi");
$in{'cgiurl'} = $cgiurl;
$in{'htmlurl'} = $htmlurl;
$in{'dd'} = $rootpath;

$in{'cinfo'} = qq|
<font size=1 face=tahoma><b><a href="http://www.cgiscript.net">Powered by csCreatePro - © 1999-2002 WWW.CGISCRIPT.NET, LLC</font></a></b></font>
|;

$| = 1;										

eval { &main; };							
if ($@) {
  &cgierr("fatal error: $@"); 
  }		
exit; 

sub main{
print "Content-type: text/html\n\n";
($ENV{'CONTENT_TYPE'} =~ /multipart\/form-data/i)?(&getdata(1)):(&getdata());
($in{'command'} eq 'login')&&(&Login);
($in{'command'} eq '')&&(&Login);
($in{'command'} eq 'savesetup')&&(&SaveSetup);
#all require password below
&GetLogin;
($in{'command'} eq 'a')&&(&Add);
($in{'command'} eq 'sua')&&(&ShowUserAdd);
($in{'command'} eq 'i')&&(&Import);
($in{'command'} eq 'sa')&&(&ShowAdd);
($in{'command'} eq 'si')&&(&ShowImport);
($in{'command'} eq 'manage')&&(&Manage);
($in{'command'} eq 'edit')&&(&Edit);
($in{'command'} eq 'delete')&&(&Delete);
($in{'command'} eq 'remove')&&(&Remove);
($in{'command'} eq 'savechanges')&&(&SaveChanges);
($in{'command'} eq 'createdir')&&(&CreateDir);
($in{'command'} eq 'cd')&&(&ShowCD);
($in{'command'} eq 'browse')&&(&Browse);
($in{'command'} eq 'showeditor')&&(&ShowEditor);
($in{'command'} eq 'showupload')&&(&ShowUpload);
($in{'command'} eq 'upload')&&(&Upload);
($in{'command'} eq 'setusers')&&(&SetUsers);
($in{'command'} eq 'sau')&&(&ShowAddUser);
($in{'command'} eq 'au')&&(&AddUser);
($in{'command'} eq 'du')&&(&DeleteUser);
($in{'command'} eq 'savu')&&(&SaveUser);
exit;
}

sub SaveUser{
(!$in{'user'})&&(&PError("Error. no user selected."));
($in{'user'} eq 'ALL')&&(&PError("Error. please select a user."));

(!$in{'uusername'})&&(&PError("Please enter a username"));
($in{'uusername'} =~ /\W/)&&(&PError("Username can only contain alpha-numeric characters."));
(!$in{'upassword'})&&(&PError("Please enter a password"));
(!$in{'ufirstname'})&&(&PError("Please enter a first name"));
(!$in{'ulastname'})&&(&PError("Please enter a lastname"));

open(USER,"+<$cgipath/user.dat.cgi");
while(<USER>){
  ($u,$p,$f,$l) = split(":",$_);
  ($u ne $in{'user'})?(push(@l,$_)):(push(@l,"$u:$in{'upassword'}:$in{'ufirstname'}:$in{'ulastname'}\n"));
  }

if(@l){
seek(USER,0,0);
foreach $i (@l){
  print USER $i;
  }
truncate(USER,tell(USER));
}

close USER;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
window.location = "$cgiurl?command=manage&user=$u&rnd="+rndURL;
</script>
EOF
}

sub DeleteUser{
(!$in{'user'})&&(&PError("Error. no user selected to delete."));
($in{'user'} eq 'ALL')&&(&PError("Error. please select a user to delete."));

open(USER,"+<$cgipath/user.dat.cgi");
while(<USER>){
  ($u,$p,$f,$l) = split(":",$_);
  ($u ne $in{'user'})&&(push(@l,$_));
  }

seek(USER,0,0);
foreach $i (@l){
  print USER $i;
  }
truncate(USER,tell(USER));

close USER;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
window.location = "$cgiurl?command=manage&rnd="+rndURL;
</script>
EOF
}

sub AddUser{
(!$in{'uusername'})&&(&PError("Please enter a username"));
($in{'uusername'} =~ /\W/)&&(&PError("Username can only contain alpha-numeric characters."));
(!$in{'upassword'})&&(&PError("Please enter a password"));
(!$in{'ufirstname'})&&(&PError("Please enter a first name"));
(!$in{'ulastname'})&&(&PError("Please enter a lastname"));

if(! -e "$cgipath/user.dat.cgi"){
  open(USER,">$cgipath/user.dat.cgi");
}
else{
  open(USER,"+<$cgipath/user.dat.cgi");
  while(<USER>){
    ($u,$p,$f,$l) = split(":",$_);
    ($u eq $in{'uusername'})&&(&PError("User already exists. Select another username."));
    }
  }
print USER "$in{'uusername'}:$in{'upassword'}:$in{'ufirstname'}:$in{'ulastname'}\n";
close USER;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("User Added");
window.opener.location = "$cgiurl?command=manage&user=$in{'uusername'}&rnd="+rndURL;
window.close();
</script>
EOF
exit;
}

sub ShowAddUser{
&PageOut("$cgipath/t_add_user.htm");
exit;
}

sub SetUsers{
open(DB,"+<$cgipath/create.dat.cgi");

$in{'uwa'} =~ s/~$//g;
$in{'uwa'} =~ s/^~//g;

while(<DB>){
chomp;
(@f) = split("\t",$_);
($f[0] ne $in{'id'})&&(push (@l,"$_\n"));
if($f[0] eq $in{'id'}){
  push(@l,"$f[0]\t$f[1]\t$f[2]\t$f[3]\t$in{'uwa'}\n");
  }
}


seek(DB,0,0);
foreach $i (@l){
  print DB $i;
  }

truncate(DB,tell(DB));
close DB;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
window.opener.location = "$cgiurl?command=manage&rnd="+rndURL;
window.close();
</script>
EOF
}

sub ShowUserAdd{


#get all users
open(USERS,"$cgipath/user.dat.cgi");
while(<USERS>){
  chomp;
  ($u,$p,$f,$l) = split(":",$_);
  push(@au,$u);
  }
close USERS;

open(DB,"$cgipath/create.dat.cgi");
while(<DB>){
chomp;
(@f) = split("\t",$_);
($f[0] eq $in{'id'})&&($found=1)&&(last);
}

(@uwa) = split("~",$f[4]);

foreach $i (@uwa){
  $in{'userswithaccess'} .= "<option value=\"$i\">$i</option>\n";
  $f{$i} = 1;
  }

foreach $i (@au){
  $in{'allusers'} .= "<option value=\"$i\">$i</option>\n" unless ($f{$i});
  }

&PageOut("$cgipath/t_select_users.htm");
exit;
}

sub ShowUpload{
&PageOut("$cgipath/t_upload_image.htm");
exit;
}

sub Upload{
$rn = &GetRealName($in{'file'});
&CheckExt($rn);
$trn = $in{'id'};
&SaveFile($in{'file'},"$htmlpath/image_upload/$trn.$rn");
(!$in{'align'})&&($in{'align'}='left');
(!$in{'border'})&&($in{'border'}='0');
(!$in{'hspace'})&&($in{'hspace'}='0');
(!$in{'vspace'})&&($in{'vspace'}='0');
$htmlurl =~ s/\/$//;
print <<"EOF";
<script language=javascript>
var sel=window.opener.editArea.document.selection.createRange();
sel.pasteHTML("<img src=\\"$htmlurl/image_upload/$trn.$rn\\" align=\\"$in{'align'}\\" alt=\\"$in{'description'}\\" border=\\"$in{'border'}\\" hspace=\\"$in{'hspace'}\\" vspace=\\"$in{'vspace'}\\">");
sel.select();
window.close();
</script>
EOF
exit;
}


sub ShowEditor{
&PageOut("$cgipath/editor.cgi");
exit;
}

sub Login{
&PageOut("$cgipath/t_login.htm");
exit;
}

sub GetLogin{
&GetCookies;
$in{'UserName'} = $cookie{'UserName'};
$in{'PassWord'} = $cookie{'PassWord'};
if(!$in{'UserName'}){
&PageOut("$cgipath/t_login.htm");
exit;
}
else{
return if (&FoundValidLogin);
(($in{'UserName'} ne $username)||(($in{'PassWord'} ne $password)))&&(&PError("Error. Invalid username or password"));
}
}

sub FoundValidLogin{

open(USERS,"$cgipath/user.dat.cgi");
while(<USERS>){
chomp;
($u,$p,$f,$l) = split(":",$_);
($u eq $in{'UserName'})&&(last);
}
close USERS;

(!$p)&&(return 0);
if(($p eq $in{'PassWord'})&&($u eq $in{'UserName'})){
  $userentry = 1;
  return 1;
  }
else{
  return 0;
  }
}

sub Import{
$nf = "$in{'dir'}/$in{'file'}";
$nf =~ s/\/\//\//g;

(!$nf)&&(&PError("Invalid URL"));
(-d "$nf")&&(&PError("Error. Can't import directories."));
(-B "$nf")&&(&PError("Error. Can't import binary files."));
(! -e $nf)&&(&PError("Error. File doesn't exist"));

open(HTML,"$nf");
while(<HTML>){
  $body .= $_;
  }
close HTML;

($in{'title'}) = $body =~ /<title>(.*?)<\/title>/si;
$in{'title'} =~ s/\r*\n//g;
(!$in{'title'})&&($in{'title'} = 'untitled');

#get uniqueid;
if(! -e "$cgipath/create.dat.cgi"){
  open(DB,">$cgipath/create.dat.cgi");
}
else{
  open(DB,"+<$cgipath/create.dat.cgi");
  while(<DB>){
    (@f) = split("\t",$_);
    $exist{$f[1]}=1;
    ($f[0] > $id)&&($id = $f[0]);
    }
  }

(!$id)&&($id=1);
$id++;
$nf =~ s/^$rootpath//;
($exist{$nf})&&(&PError("Error. file already imported."));
print DB "$id\t$nf\t$in{'title'}\t\n";

close DB;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Page Imported.");
window.opener.location = "$cgiurl?command=manage&rnd="+rndURL;
window.close();
</script>
EOF
exit;
}


sub Edit{
open(DB,"$cgipath/create.dat.cgi");
while(<DB>){
chomp;
(@f) = split("\t",$_);
($f[0] eq $in{'id'})&&($found=1)&&(last);
}

if($found){
($in{'id'},$in{'url'},$in{'title'},$in{'line'}) = split("\t",$_);
$in{'url'} =~ s/&#(\d+);/pack("c",$1)/ge;
$in{'title'} =~ s/&#(\d+);/pack("c",$1)/ge;

$nf = "$rootpath/$in{'url'}";
open(HTML,"$nf")||print "$!:$nf<br>";
while(<HTML>){
$in{'explode'} .= $_;
}
close HTML;

$in{'explode'} =~ s/([^\w\s])/'&#'.ord($1).';'/ge;

&PageOut("$cgipath/t_edit.htm");
}
else{
&PError("Error. No record found with that identifier");
}
exit;
}

sub GetUsers{
open(USER,"$cgipath/user.dat.cgi");
while(<USER>){
  chomp;
  ($u,$p,$f,$l) = split(":",$_);
  ($in{'user'} eq $u)?($sel='selected'):($sel='');
  $ut = $u;
  $ut =~ tr/a-z/A-Z/;
  $users{$ut} = qq|<option $sel>$u</option>|;
  if($in{'user'} eq $u){
    $in{'ufirstname'} = $f;
    $in{'ulastname'} = $l;
    $in{'uusername'} = $u;
    $in{'upassword'} = $p;
    }
  }
close USER;

foreach $i (sort keys %users){
  $in{'useroptions'} .= $users{$i};
  }
if($in{'user'} eq 'ALL'){
    $in{'ufirstname'} = '';
    $in{'ulastname'} = '';
    $in{'uusername'} = '';
    $in{'upassword'} = '';
    }
}

sub Manage{
(!$in{'user'})&&(!$userentry)&&($in{'user'} = 'ALL');
&GetUsers;
srand(time|$$);
open(DB,"$cgipath/create.dat.cgi");
$rooturl =~ s/\/$//;
while(<DB>){
chomp;
(@f) = split("\t",$_);
$f[1] =~ s/&#(\d+);/pack("c",$1)/ge;
$f[2] =~ s/&#(\d+);/pack("c",$1)/ge;
$rnd=int(rand(1000));

if((!$userentry)&&($in{'user'} ne 'ALL')){
  ($f[4] !~ /$in{'user'}/)&&(next);
  }

$in{'row'} .="
<TR>
<TD nowrap valign=\"middle\" align=\"center\">
<TABLE border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"5\">
<TR>
<TD nowrap width=\"25%\" valign=\"middle\" align=\"center\"><a href=\"javascript:TextEdit('$f[0]');\"><font size=\"1\" face=\"Tahoma\">Text Edit</font></a>
</TD>
<TD nowrap width=\"25%\" valign=\"middle\" align=\"center\"><a href=\"javascript:Edit('$f[0]');\"><font size=\"1\" face=\"Tahoma\">HTML Edit</font></a>
</TD>
<TD nowrap width=\"25%\" valign=\"middle\" align=\"center\"><a href=\"javascript:Delete('$f[0]');\"><font size=\"1\" face=\"Tahoma\">Delete</font></a>
</TD>
<TD nowrap width=\"25%\" valign=\"middle\" align=\"center\"><a href=\"javascript:Remove('$f[0]');\"><font size=\"1\" face=\"Tahoma\">Remove</font></a>
</TD>
</TR>
</TABLE>
</TD>
<TD nowrap valign=\"middle\" align=\"left\"><font size=\"1\" face=\"Tahoma\">$f[2]</FONT>
</TD>
<TD nowrap valign=\"middle\" align=\"left\"><FONT face=\"verdana,arial,helvetica\" size=\"2\"><input class=button type=button value=\"Show Users\" onClick=\"ShowUsers('$f[0]');\"></FONT>
</TD>
<TD nowrap valign=\"middle\" align=\"left\"><font size=\"1\" face=\"Tahoma\"><a href=\"$rooturl$f[1]?nocache=$rnd\" target=\"_blank\">$f[1]</a></FONT>
</TD>
</TR>
";

#do users.
$hasaccess=0;
foreach $i (split("~",$f[4])){
($i eq $in{'UserName'})&&($hasaccess=1);
}

$in{'rowuser'} .="
<TR>
<TD valign=\"middle\" align=\"center\">
<TABLE border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"5\">
<TR>
<TD valign=\"middle\" align=\"center\" nowrap><a href=\"javascript:TextEdit('$f[0]');\"><font size=\"1\" face=\"Tahoma\">Text Edit</font></a>
</TD>
<TD valign=\"middle\" align=\"center\"><a href=\"javascript:Edit('$f[0]');\"><font size=\"1\" face=\"Tahoma\">HTML Edit</font></a>
</TD>
</TR>
</TABLE>
</TD>
<TD valign=\"middle\" align=\"left\"><font size=\"1\" face=\"Tahoma\">$f[2]</FONT>
</TD>
<TD valign=\"middle\" align=\"left\"><font size=\"1\" face=\"Tahoma\"><a href=\"$rooturl$f[1]?nocache=$rnd\" target=\"_blank\">$f[1]</a></FONT>
</TD>
</TR>
" if ($hasaccess);


}
(!$in{'row'})&&($in{'row'} = "<td colspan=4><font size=2 face=verdana>No pages in database</font></td>");
(!$in{'rowuser'})&&($in{'rowuser'} = "<td colspan=3><font size=2 face=verdana>No pages to edit</font></td>");

$in{'rooturl'} = $rooturl;
($userentry)?(&PageOut("$cgipath/t_user_manage.htm")):(&PageOut("$cgipath/t_manage.htm"));
}

sub ShowAdd{
$in{'url'} = $rooturl;
&PageOut("$cgipath/t_add.htm");
exit;
}

sub ShowCD{
$in{'url'} = $rooturl;
&PageOut("$cgipath/t_cd.htm");
exit;
}

sub ShowImport{
$in{'url'} = $rooturl;
&PageOut("$cgipath/t_import.htm");
exit;
}

sub Delete{
open(DB,"+<$cgipath/create.dat.cgi");

while(<DB>){
(@f) = split("\t",$_);
($f[0] ne $in{'id'})&&(push(@l,$_));
($f[0] eq $in{'id'})&&($ftd = $f[1]);
}

seek(DB,0,0);
foreach $i (@l){
  print DB $i;
  }
truncate(DB, tell(DB));
close DB;

$f[1] =~ s/&#(\d+);/pack("c",$1)/ge;
##delete the html file
#strip off URL
$ftd = "$rootpath/$ftd";

if($makebackups){
  ($ftd)&&(rename($ftd,"$ftd.backup"));
  }

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Page Deleted.");
window.location = "$cgiurl?command=manage&rnd="+rndURL;
</script>
EOF
exit;
}

sub Remove{
open(DB,"+<$cgipath/create.dat.cgi");
while(<DB>){
(@f) = split("\t",$_);
($f[0] ne $in{'id'})&&(push(@l,$_));
}

seek(DB,0,0);
foreach $i (@l){
  print DB $i;
  }

truncate(DB, tell(DB));
close DB;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Page Removed from list (original copy retained).");
window.location = "$cgiurl?command=manage&rnd="+rndURL;
</script>
EOF
exit;
}

sub SaveChanges{
$in{'explode'}=~ s/&#(\d+);/pack("c",$1)/ge;
$in{'explode'}=~ s/\r*\n/\n/g;

open(DB,"$cgipath/create.dat.cgi");
while(<DB>){
  (@f) = split("\t",$_);
  ($f[0] eq $in{'id'})&&($url = $f[1]);
  }
close DB;

$nf = "$rootpath/$url";
open(HTML,"$nf");
while(<HTML>){
  $ob .= $_;  
  }
close HTML;

if($makebackups){
open(HTML,">$nf.backup");
print HTML $ob;
close HTML;
}

open(HTML,">$nf");
if($in{'em'} eq 'html'){
  ($in{'title'}) = $ob =~ /<title>(.*?)<\/title>/si;
  $in{'title'} =~ s/\r*\n//g;
  (!$in{'title'})&&($in{'title'} = 'untitled');
  $ob =~ s/(.*?)<body.*body>(.*?)//si;
  print HTML "$1$in{'explode'}$2";
  }
else{
  ($in{'title'}) = $in{'explode'} =~ /<title>(.*?)<\/title>/si;
  $in{'title'} =~ s/\r*\n//g;
  (!$in{'title'})&&($in{'title'} = 'untitled');
  print HTML $in{'explode'};
  }
close HTML;


open(DB,"+<$cgipath/create.dat.cgi");
while(<DB>){
chomp;
(@f) = split("\t",$_);
($f[0] ne $in{'id'})&&(push(@l,"$_\n"));
if($f[0] eq $in{'id'}){
  $url = $f[1];
  push(@l,"$f[0]\t$f[1]\t$in{'title'}\t$f[3]\t$f[4]\n");
  }
}
seek(DB,0,0);
foreach $i (@l){
  print DB $i;
  }
truncate(DB, tell(DB));
close DB;


print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Page Saved.");
window.opener.location = "$cgiurl?command=manage&rnd="+rndURL;
window.close();
</script>
EOF
exit;
}

sub CreateDir{

($in{'file'} =~ /\.\./)&&(&PError("Error. Invalid directory name."));
$nf = "$in{'dir'}/$in{'file'}";

mkdir($nf,0755) || print "$!: $newdir<br>";
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Directory Created.");
window.location = "$cgiurl?command=browse&dir=$in{'dir'}&rnd="+rndURL;
</script>
EOF

exit;
}

sub Add{
($in{'file'} =~ /\.\./)&&(&PError("Error. Invalid filename."));
#check to see if file already exists.
#strip off URL
$nf = "$in{'dir'}/$in{'file'}";
$nf =~ s/\/\//\//g;

(!$nf)&&(&PError("Invalid URL"));
(-e $nf)&&(&PError("Error. File already exists"));
$nf =~ s/^$rootpath//;

#get uniqueid;
open(DB,"$cgipath/create.dat.cgi");
while(<DB>){
(@f) = split("\t",$_);
$exist{$f[1]}=1;
($f[0] > $id)&&($id = $f[0]);
}
close DB;

(!$id)&&($id=1);
$id++;

($exist{$nf})&&(&PError("Error. URL already exists."));

open(DB,">>$cgipath/create.dat.cgi");
print DB "$id\t$nf\t$in{'title'}\t\n";
close DB;

##create base page
open(HTML,">$rootpath/$nf");
print HTML<<"EOF";
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<meta http-equiv="content-language" content="en">
<meta name="generator" content="csCreatePro by WWW.CGISCRIPT.NET, LLC">
<meta name="author" content="">
<meta name="keywords" content="">
<meta name="description" content="">
<title>$in{'title'} - csCreatePro by WWW.CGISCRIPT.NET, LLC</title>
</head>
<body>

</body>
</html>
EOF
close HTML;

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Page Added.");
window.opener.location = "$cgiurl?command=manage&rnd="+rndURL;
window.close();
</script>
EOF
exit;
}

sub CheckVars{
(!$in{'url'})&&(&PError("Error. Please enter a URL"));
(!$in{'title'})&&(&PError("Error. Please enter a title"));
#unescape;
$in{'url'} =~ s/&#(\d+);/pack("c",$1)/ge;
$in{'title'} =~ s/&#(\d+);/pack("c",$1)/ge;
#escape;
$in{'url'} =~ s/([^\w\s])/'&#'.ord($1).';'/ge;
$in{'title'} =~ s/([^\w\s])/'&#'.ord($1).';'/ge;
}

sub Browse{
(!$in{'dir'})&&($in{'dir'} = $rootpath);

##find previous dir
($pdir,$tdir) = $in{'dir'} =~ /(.*)\/(.*)$/;

##find root and give prev dir
if($in{'dir'} ne $rootpath){
$in{'line'} .= "
          <tr>
            <td align=\"center\" valign=\"middle\">&nbsp;</td>
            <td align=\"left\"><a href=\"$in{'cgiurl'}?command=browse&dir=$pdir\"><img border=\"0\" src=\"$htmlurl/images/up.gif\" width=\"18\" height=\"16\"></a></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\" color=\"#0000FF\"><a href=\"$in{'cgiurl'}?command=browse&dir=$pdir\">Previous Directory</a></font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">&nbsp;</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">&nbsp;</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">&nbsp;</font></td>
          </tr>
          ";
}#end find root

###get the dirs
opendir(DIR,"$in{'dir'}");
@files = grep(!/^\.\.?$/,readdir(DIR));
closedir(DIR);

foreach $i (sort (@files)){

@info = stat("$in{'dir'}/$i");
$mode = substr(sprintf("%lo",$info[2]),2);
$mode =~ s/^0//;
$created = &ctime($info[10]);
$size = $info[7];
$ei=$i;
$ei =~ s/([^\w&=])/'%'.sprintf("%.2x",ord($1))/ge;
$edir = $in{'dir'};
$edir =~ s/([^\w&=])/'%'.sprintf("%.2x",ord($1))/ge;
$dirs .= "
          <tr>
            <td align=\"center\" valign=\"middle\"><font face=\"Verdana\" size=\"2\">&nbsp;</font></td>
            <td align=\"left\"><a href=\"$in{'cgiurl'}?command=browse&dir=$edir/$ei\"><img border=\"0\" src=\"$htmlurl/images/folder.gif\" width=\"18\" height=\"16\"></a></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\" color=\"#0000FF\"><a href=\"$in{'cgiurl'}?command=browse&dir=$edir/$ei\">$i</a></font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$size bytes</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$created</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$mode</font></td>
          </tr>
          " if (-d "$in{'dir'}/$i");
          
$fileurl = "$in{'dir'}/$i";
$fileurl =~ s/^$rootpath/$rooturl/i;

$ri = $i;
$ri =~ s/'/\\'/g;

$files .= "
          <tr>
            <td align=\"center\" valign=\"middle\"><font face=\"Verdana\" size=\"2\"><input name=\"item\" onClick=\"SetRad('$ri');\" type=\"radio\" value=\"$i\"></font></td>
            <td align=\"left\"><img border=\"0\" src=\"$htmlurl/images/document.gif\" width=\"18\" height=\"16\"></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\" color=\"#0000FF\"><a href=\"$fileurl\" target=\"_blank\">$i</a></font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$size bytes</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$created</font></td>
            <td align=\"left\"><font face=\"Tahoma\" size=\"1\">$mode</font></td>
          </tr>
          "if (! -d "$in{'dir'}/$i");
}

$in{'line'} .= $dirs.$files;

$in{'disdir'} = $in{'dir'};
$in{'disdir'} =~ s/^$rootpath/\//g;
$in{'disdir'} =~ s/\/\//\//g;
$rootpath =~ s/\/$//;

$siteurl = qq|<a href="$in{'cgiurl'}?command=browse">$rootpath</a>|;
(@e) = split("/",$in{'disdir'});

foreach $i (@e){
next if (!$i);
$mdd .= "/$i";
$lnkd = qq|/<a href="$cgiurl?command=browse&dir=$rootpath$mdd">$i</a>|;
$in{'dirdir'} .= $lnkd;
}

$in{'disdir'} = $siteurl.$in{'dirdir'};
&PageOut("$cgipath/t_select.htm");
}


sub GetRealName{
local($filename) = @_;
    if ($filename =~ /\//) {
	@array = split(/\//, $filename);
	$real_name = pop(@array);
    } elsif ($filename =~ /\\/) {
	@array = split(/\\/, $filename);
	$real_name = pop(@array);
    } else {
	$real_name = "$filename";
    }
return $real_name;
}


sub SaveFile {
local($filename,$outfile)=@_;
    if (!open(OUTFILE, ">$outfile")) {
    &PError("Error. There was an error saving your attachment.");
    }
    binmode(OUTFILE);
    while ($bytesread = read($filename,$buffer,1024)) {
        $totalbytes += $bytesread;
        print OUTFILE $buffer;               
    }
    close($filename);
    close(OUTFILE);
}

sub CheckExt{
local($rn) = @_;
#check file extension.
$in{'fta'} = "gif,jpg";
if($in{'fta'}){
  ($ext) = $rn =~ /.*\.(\w*)$/;
  (@fx) = split(",",$in{'fta'});
    foreach $i (@fx){
      ($i =~ /$ext/i)&&($found=1);
      }
  (!$found)&&(&PError("Error. Only $in{'fta'} types are permitted"));
  }
if($in{'ftr'}){
  ($ext) = $rn =~ /.*\.(\w*)$/;
  (@fx) = split(",",$in{'ftr'});
    foreach $i (@fx){
      ($i !~ /$ext/i)&&($found=1);
      }
  (!$found)&&(&PError("Error. $in{'ftr'} types are NOT permitted"));
  }
  
}


sub Setup{
print "Content-type: text/html\n\n";
$cgipath = `pwd`;chomp $cgipath;
$cgiurl = "$ENV{'HTTP_HOST'}/$ENV{'SCRIPT_NAME'}";
$cgiurl =~ s/\/csCreatePro.cgi//i;
$cgiurl =~ s/\/\//\//g;
$cgiurl = "http://".$cgiurl;
$rooturl = "http://$ENV{'HTTP_HOST'}";
$rootpath = $ENV{'DOCUMENT_ROOT'};

open(SETUP,">./setup.cgi");
print SETUP <<"EOF";
\$cgiurl = '$cgiurl';
\$cgipath = '$cgipath';
\$htmlurl = '$cgiurl';
\$htmlpath = '$cgipath';
\$rooturl = '$rooturl';
\$rootpath = '$rootpath';
\$makebackups=1;
\$username = 'demo';
\$password = 'demo';
1;
EOF

close SETUP;

$setup = "\$cgiurl = '$cgiurl/csCreatePro.cgi';
\$cgipath = '$cgipath';
\$htmlurl = '$cgiurl';
\$htmlpath = '$cgipath';
\$rooturl = '$rooturl';
\$rootpath = '$rootpath';
\$makebackups=1;
\$username = 'demo';
\$password = 'demo';
1;
";

print <<"EOF";
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>csCreatePro</title>
</head>

<body>
<font size=4 face=tahoma><b>csCreatePro Setup</b></font><hr>

<font size=2 face=tahoma><b>Current contents of your setup.cgi file</b><br>Please verify the information and modify if needed:
<form method=post action="$in{'cgiurl'}">
<input type=hidden name=command value=savesetup>
<textarea rows=10 cols=80 name=setup wrap=off>$setup
</textarea>
<hr>
<input type=submit value="-=Save Changes=-"> <input type=button value="-=Enter Management=-" onClick="window.location='$in{'cgiurl'}?command=manage';">
</form>
<p><font face="Tahoma" size="2"><b>Definitions:</b></font></p>
<p><font face="Tahoma" size="2"><b>\$cgiurl </b> = Full URL to cs</font></font><font face="Tahoma" size="2">CreatePro.cgi<font size=2 face=tahoma><br>
<b>
\$cgipath</b> = Full PATH to the cs</font></font><font size="2" face="tahoma">CreatePro<font face="Tahoma" size="2"> DIRECTORY<br>
<b>\$</b></font></font><font face="Tahoma" size="2"><b>html</b><font size="2" face="tahoma"><b>url</b> = Full URL to
</font></font><font size="2" face="tahoma">directory where the image_upload,
images, and icons are stored. If you are installing this outside your cgi-bin
directory, then this variable can be the same as the \$cgiurl variable.<font face="Tahoma" size="2"><br>
<b>\$</b></font><b>html</b><font face="Tahoma" size="2"><b>path</b> = </font> Full
PATH to directory where the image_upload, images, and icons are stored. If you
are installing this outside your cgi-bin directory, then this variable can be
the same as the \$cgipath variable.<br>
<b>\$rooturl</b> = Full URL to your home directory<br>
<b>\$rootpath</b> = Full PATH to your home directory.</font><font face="Tahoma" size="2"><br>
<b>
\$username</b> = username to enter management screens<br>
<b>
\$password</b> = password to enter management screens<br>
</font>
</p>
<p><font face="Tahoma" size="2"><i>(note: the '1' at the end is to prevent
errors from perl if \$password was left empty)</i>
</p>
<p><font face="Tahoma" size="2"><b>Normal Installation Instructions:</b></font></p>
<p><font face="Tahoma" size="2">In most cases, the script is already configured.
Change the \$username and \$password variables to your liking and click 'Save'.
If the setup portion of the script cannot find your sites variables
automatically, you will might have to enter those in the above text area.</font></p>
<p><b>NOTE:</b> If you click 'save' and keep coming back to this screen, then
most likely your webserver doesn't have write access to this directory. You will
need to chmod the cgipath directory and htmlpath directories and subdirectories
to '777'.</p>
<p><font face="Tahoma" size="2"><b>CGI-BIN Installation Instructions:</b></font></p>
<p><font face="Tahoma" size="2">If your hosting service <b>will not</b> let you
run scripts outside your <b>cgi-bin</b> directory, then follow these procedures:</font></p>
<p>Create a directory outside your cgi-bin directory that is accessible from a
web browser. Usually this means creating a directory in the same place as where
your index.htm page is located. Inside this directory place the images,
image_upload, and icons directory and their contents to this folder. For
example, if the directory you created was called csCreatePro, then the result
would be:<br>
<br>
csCreatePro/images<br>
csCreatePro/image_upload<br>
csCreatePro/icons</p>
<p>Then point the htmlurl and htmlpath variables to this directory.</p>
</font>
</body>

</html>
EOF

exit;
}

sub SaveSetup{
($username ne 'demo')&&(&PError("Error. Access denied"));
($password ne 'demo')&&(&PError("Error. Access denied"));
$in{'setup'} =~ s/\r*\n/\n/g;
open(SETUP,">setup.cgi");
print SETUP $in{'setup'};
print SETUP "\n";
close SETUP;
print <<"EOF";
<script language=javascript>
alert("Setup.cgi reconfigured");
window.location = "csCreatePro.cgi?command=login";
</script>
EOF
exit;
}
