#!/usr/bin/perl
$basepath = './';
#
# csNews - v2.26 - 052102
#####################################################################
#                                                                   #
#    Copyright © 1999-2001 localhost - All Rights Reserved     #
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
# you and localhost. You should carefully read the following
# terms and conditions before installing or using this software.
# Unless you have a different license agreement obtained from
# localhost, installation or use of this software indicates
# your acceptance of the license and warranty limitation terms
# contained in this Agreement. If you do not agree to the terms of this
# Agreement, promptly delete and destroy all copies of the Software.
#
# Versions of the Software
# Only one copy of the registered version of localhost
# may used on one web site.
#
# License to Redistribute
# Distributing the software and/or documentation with other products
# (commercial or otherwise) or by other than electronic means without
# localhost's prior written permission is forbidden.
# All rights to the localhost software and documentation not expressly
# granted under this Agreement are reserved to localhost.
#
# Disclaimer of Warranty
# THIS SOFTWARE AND ACCOMPANYING DOCUMENTATION ARE PROVIDED "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY OTHER
# WARRANTIES WHETHER EXPRESSED OR IMPLIED.   BECAUSE OF THE VARIOUS HARDWARE
# AND SOFTWARE ENVIRONMENTS INTO WHICH localhost MAY BE USED, NO WARRANTY
# OF FITNESS FOR A PARTICULAR PURPOSE IS OFFERED.  THE USER MUST ASSUME THE
# ENTIRE RISK OF USING THIS PROGRAM.  ANY LIABILITY OF localhost WILL BE
# LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR REFUND OF PURCHASE PRICE.
# IN NO CASE SHALL localhost BE LIABLE FOR ANY INCIDENTAL, SPECIAL OR
# CONSEQUENTIAL DAMAGES OR LOSS, INCLUDING, WITHOUT LIMITATION, LOST PROFITS
# OR THE INABILITY TO USE EQUIPMENT OR ACCESS DATA, WHETHER SUCH DAMAGES ARE
# BASED UPON A BREACH OF EXPRESS OR IMPLIED WARRANTIES, BREACH OF CONTRACT,
# NEGLIGENCE, STRICT TORT, OR ANY OTHER LEGAL THEORY. THIS IS TRUE EVEN IF
# localhost IS ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. IN NO CASE WILL
# localhost' LIABILITY EXCEED THE AMOUNT OF THE LICENSE FEE ACTUALLY PAID
# BY LICENSEE TO localhost.
#
# Credits:
# Andy Angrick - Programmer - angrick@localhost
# Mike Barone - Design - mbarone@localhost
#
# For information about this script or other scripts see
# http://localhost
#
# Thank you for trying out our script.
# If you have any suggestions or ideas for a new innovative script
# please direct them to suggest@localhost.  Thanks.
#
########################################################################
#                       Config Variables                               #
########################################################################

(! -e "$basepath/setup.cgi")?($nosetup=1):(require("$basepath/setup.cgi"));
(!$htmlpath)&&($htmlpath=$cgipath);
(!$htmlurl)&&($htmlurl=$cgiurl);
$in{'htmlurl'} = $htmlurl;
$in{'cgiurl'} = $cgiurl."/csNews.cgi";
$sendmail = '/usr/sbin/sendmail';
$df = 'US';
$flock = 1;

########################################################################
#                       End Config Variables                           #
########################################################################
require("$basepath/libs.cgi");

$edd = "default%2edb";
$dd="default";
$in{'cinfo'} = qq|
<p align="center"><b><font color="#3366FF" face="verdana" size="1">Powered
        by CSNews - © 2000,2001 localhost Nullified by AndyAN</font></b>
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
$in{'database'} =~ s/%(..)/pack("c",hex($1))/ge;
$in{'database'} =~ s/([^\w&=])/'%'.sprintf("%.2x",ord($1))/ge;
$in{'database'} =~ s/%2earchive/\.archive/g;
($in{'command'} eq '')&&($nosetup)&&(&Setup);
($in{'command'} eq '')&&(!$nosetup)&&(&ShowIndex);
($in{'command'} eq "viewnews")&&(&ShowListPub);
($in{'command'} eq "viewone")&&(&ViewOne);
($in{'command'} eq "login")&&(&Login);
($in{'command'} eq 'savesetup')&&(($nosetup)?(&SaveSetup):(&PError("Error. Permission denied.")));
($in{'command'} eq 'emailarticle')&&(&EmailArticle);
($in{'command'} eq 'dosearch')&&(&DoSearch);
($in{'command'} eq 'showsearchform')&&(&ShowSearchForm);
&SaveVars;
&GetLogin;
&GetVars;
($in{'command'} eq "setstyles")&&(&SetStyles);
($in{'command'} eq "showadd")&&(&ShowAdd);
($in{'command'} eq "reorder")&&(&Reorder);
($in{'command'} eq "moveto")&&(&Moveto);
($in{'command'} eq "add")&&(&Add);
($in{'command'} eq "showedit")&&(&ShowEdit);
($in{'command'} eq "savechanges")&&(&SaveChanges);
($in{'command'} eq "deleteitems")&&(&DeleteItems);
($in{'command'} eq "copyitem")&&(&CopyItem);
($in{'command'} eq "manage")&&(&ShowList);
($in{'command'} eq "view")&&(&ViewOne);
($in{'command'} eq "showadv")&&(&ShowAdv);
($in{'command'} eq "deletedb")&&(&DeleteDB);
($in{'command'} eq "showadddb")&&(&ShowAddDB);
($in{'command'} eq "addnewsdb")&&(&AddNewsDB);
($in{'command'} eq "showlinks")&&(&ShowLinks);
($in{'command'} eq "showupload")&&(&ShowUpload);
($in{'command'} eq "upload")&&(&Upload);
($in{'command'} eq "refresh")&&(&Refresh);
($in{'command'} eq 'showeditor')&&(&ShowEditor);
($in{'command'} eq 'uploadEditor')&&(&UploadEditor);
($in{'command'} eq 'showuploadEditor')&&(&ShowUploadEditor);
($in{'command'} eq 'rendb')&&(&CopyDB(1));
($in{'command'} eq 'copydb')&&(&CopyDB(2));
($in{'command'} eq 'viewsaved')&&(&ViewSaved);
}

sub ShowSearchForm{

if($in{'js'} ne 'Y'){
&PageOut("$htmlpath/t_searchform.htm");
}
else{
&PageOutJS("$htmlpath/t_searchform.htm");
}
exit;
}

sub DoSearch{
(!$in{'database'})&&($in{'database'} = 'all');
(!$in{'query'})&&(&PError("Error. Please enter something to search for."));

(-e "$htmlpath/$in{'database'}.style")?(require "$htmlpath/$in{'database'}.style"):(require "$cgipath/styles.cgi");

if($in{'database'} eq 'all'){
  opendir(IMG,"$htmlpath/");
  @dbfiles = grep(/db$/,readdir(IMG));
  closedir(IMG);
  foreach $i (sort @dbfiles){
    push(@sd,$i);
    }
  $in{'ilink'} = qq|<a href="$in{'cgiurl'}">[Back to Index]</a></font>|;
  }
  else{
    push(@sd,$in{'database'});
 $in{'ilink'} = qq|<a href="$in{'cgiurl'}?command=viewnews&database=$in{'database'}">[Back to Index]</a></font>|;
}

#loop through for search
foreach $i (@sd){
  open(DB,"$htmlpath/$i")||print "$htmlpath/$i<br>";
  while($line=<DB>){
    chop $line;
    (@fields) = split(/\~/,$line);
    next if ($fields[21] eq 'N');
    ##get news html file
    $in{'database'} = $i;
    open(HTML,"$htmlpath/newsdir/$in{'database'}$fields[0].htm")||print "$!: $htmlpath/newsdir/$in{'database'}$fields[0].htm<br>";
    $body='';
    while(<HTML>){
      $body .= $_;
    }
    close HTML;
    $line = $line .' '. $body;
    if($line =~ /$in{'query'}/i){
    $fields[3] =~ s/&#(\d+);/pack("c",$1)/ge;
    $fields[1] =~ s/&#(\d+);/pack("c",$1)/ge;
    $fields[3] =~ s/\\n/\n/g;
    $cat=$i;
    $cat =~ s/%(..)/pack("c",hex($1))/ge;
    $cat =~ s/\.db//g;
    $cat = "$cat » ";
      $in{'searchresults'} .= "<br clear=\"all\"><ul><li><a href=\"$in{'cgiurl'}?command=viewone&id=$fields[0]&database=$i\" target=\"_blank\">$cat$fields[1]</a><br>$fields[3]</li></ul><br clear=\"all\">\n";
    }
  }
close DB;
}

(!$in{'searchresults'})&&($in{'searchresults'} = '<font face=verdana size=2>No results found.</font>');
&PageOut("$htmlpath/t_search_results.htm");
exit;
}


sub ViewSaved{
print "<pre>";
open(DB,"$htmlpath/$in{'database'}.savedemail.cgi");
while(<DB>){
  $found=1;
  print;
  }
if(!$found){
  print "No email addresses saved<br>";
  }
exit;
}

sub EmailArticle{
(!$in{'te'})&&(&PError("Error. Please enter an email address to send the article to."));
(!$in{'ye'})&&(&PError("Error. Please enter your email address"));
open(MAIL,"|$sendmail -t");
print MAIL <<"EOF";
To: $in{'te'}
From: $in{'ye'}
Subject: $in{'title'}

$in{'comments'}

$in{'url'}

EOF
close MAIL;

open(DB,">>$htmlpath/$in{'database'}.savedemail.cgi");
($flock)&&(flock(DB,2));
print DB "$in{'te'}\n$in{'ye'}\n";
close DB;
($flock)&&(flock(DB,8));
print <<"EOF";
<script language=javascript>
alert("Your email has been sent!");
history.back();
</script>
EOF
exit;
}

sub CopyDB{
local($type) = @_;
$in{'nm'} = $in{'nm'} . ".db";
$in{'nm'} =~ s/([^\w&=])/'%'.sprintf("%.2x",ord($1))/ge;
(-e "$in{'nm'}")&&(&PError("Error. Category already exists"));
if($type == 1){
  rename("$htmlpath/$in{'database'}","$htmlpath/$in{'nm'}");
  rename("$htmlpath/$in{'database'}.style","$htmlpath/$in{'nm'}.style");
  rename("$htmlpath/$in{'database'}.evenrow","$htmlpath/$in{'nm'}.evenrow");
  rename("$htmlpath/$in{'database'}.oddrow","$htmlpath/$in{'nm'}.oddrow");
  rename("$htmlpath/$in{'database'}.list","$htmlpath/$in{'nm'}.list");
  rename("$htmlpath/$in{'database'}.full","$htmlpath/$in{'nm'}.full");
  }
else{
  &CopyFile("$htmlpath/$in{'database'}","$htmlpath/$in{'nm'}");
  &CopyFile("$htmlpath/$in{'database'}.style","$htmlpath/$in{'nm'}.style");
  &CopyFile("$htmlpath/$in{'database'}.evenrow","$htmlpath/$in{'nm'}.evenrow");
  &CopyFile("$htmlpath/$in{'database'}.oddrow","$htmlpath/$in{'nm'}.oddrow");
  &CopyFile("$htmlpath/$in{'database'}.list","$htmlpath/$in{'nm'}.list");
  &CopyFile("$htmlpath/$in{'database'}.full","$htmlpath/$in{'nm'}.full");
}
opendir(TDIR,"$htmlpath/newsdir");
@allfiles = readdir(TDIR);
closedir TDIR;
$db = $in{'database'};
foreach $i (@allfiles){
  if($i =~ /$db(\d+)\.htm/){
    &CopyFile("$htmlpath/newsdir/$i","$htmlpath/newsdir/$in{'nm'}$1.htm");
    ($type == 1)&&(unlink("$htmlpath/newsdir/$i"));
    }
  }
($type==1)?($m = 'category rename'):($m = 'category copied');
($type==1)&&($in{'database'} = $in{'nm'});
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("$m");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF
exit;
}

sub Moveto{
(!$in{'moveto'})&&(&PError("Error. Please select an item to move."));
($in{'movedatabase'} eq $in{'database'})&&(&PError("Error. The item already exists in this category"));
@moves = split(/\\0/,$in{'moveto'});
foreach $i (@moves){
$m{$i} = 1;
}
##get highest ID in DB for unique ID.
open(DB,"$htmlpath/$in{'movedatabase'}");
$id = 0;
while(<DB>){
($idt,@rest) = split("~",$_);
($idt > $id)&&($id = $idt);
}
close DB;
$id++;
open(ODB,"$htmlpath/$in{'database'}");
($flock)&&(flock(ODB,2));
open(ODBT,">$htmlpath/$in{'database'}.tmp");
($flock)&&(flock(ODBT,2));
open(MDB,">>$htmlpath/$in{'movedatabase'}");
($flock)&&(flock(MDB,2));
while($line = <ODB>){
$count++;
($mid,@fields) = split(/\~/,$line);
  if($m{$mid}){
  $all = join("~",@fields);
  print MDB "$id~$all";
  rename("$htmlpath/newsdir/$in{'database'}${mid}.htm","$htmlpath/newsdir/$in{'movedatabase'}${id}.htm");
  $id++;
  }
  else{
  print ODBT $line;
  }
}
close ODB;
close ODBT;
close MDB;
rename("$htmlpath/$in{'database'}.tmp","$htmlpath/$in{'database'}");
($flock)&&(flock(ODB,8));
($flock)&&(flock(ODBT,8));
($flock)&&(flock(MDB,8));
##rename bodies
foreach $i (@moves){
  rename("$htmlpath/newsdir/$in{'database'}${i}.htm","$htmlpath/newsdir/$in{'movedatabase'}${i}.htm");
  }

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("The news items have been moved.");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF
exit;
}

sub GetLogin{
&GetCookies;
$in{'UserName'} = $cookie{'UserName'};
$in{'PassWord'} = $cookie{'PassWord'};
if(!$in{'UserName'}){
&PageOut("$htmlpath/t_login.htm");
exit;
}
else{
  ##if master...let it go
  if(($in{'UserName'} eq $username)&&($in{'PassWord'} eq $password)){
    #good to go.
    $in{'mpage'} = 'manager';
    return;
    }
  else{
  (-e "$htmlpath/$in{'database'}.style")?($dbs =  "$htmlpath/$in{'database'}.style"):($dbs = "${cgipath}/styles.cgi");
  require($dbs);
  $in{'mpage'} = '';
    ##anonymous access
    ($in{'security'} eq "anon")&&(return);
    ##password access
    ($in{'security'} ne 'password')&&(&PError("Error. Invalid username or password"));
    ##find out what database we are in and match up user.
    ##get users
    @users = split(/\r?\n/,$in{'userpass'});
    foreach $i (@users){
      ($username,$password)=split(":",$i);
      ##good to go
      ($in{'UserName'} eq $username)&&($in{'PassWord'} eq $password)&&(return);
      }
   }
}
 &PError("Error. Invalid username or password");
}

sub Login{
&GetDatabases;
&PageOut("$htmlpath/t_login.htm");
exit;
}

sub ShowIndex{
opendir(IMG,"$htmlpath/");
@dbfiles = grep(/db$/,readdir(IMG));
closedir(IMG);
$dfound=0;
foreach $i (sort @dbfiles){
$dfound=1;
$seldb='';
$dbo = $i;
$dbo =~ s/%(..)/pack("c",hex($1))/ge;
$dbo =~ s/\.db//g;
$in{'newsitems'} .= "<li><a href=\"$in{'cgiurl'}?command=viewnews&database=$i\" target=\"_blank\">$dbo</a></li>";
}
(!$dfound)&&($in{'newsitems'} = "No news categories configured.");
&PageOut("$htmlpath/t_index.htm");
exit;
}

sub Refresh{
&SetStyle;
&ShowAdv;
exit;
}

sub AddNewsDB{
(!$in{'newsdb'})&&(&PError("Error. Please Enter a Database Name."));
$in{'newsdb'} .= '.db';
$in{'newsdb'} =~ s/([^\w&=])/'%'.sprintf("%.2x",ord($1))/ge;
(-e "$htmlpath/$in{'newsdb'}")&&(&PError("Error. Database already exists. Please use another name."));
open(NEWS,">${htmlpath}/$in{'newsdb'}");
close NEWS;
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("News Database $in{'database'} has been created");
window.opener.location = "$in{'cgiurl'}?command=manage&database=$in{'newsdb'}&rnd="+rndURL;
window.close();
</script>
EOF
}

sub ShowAddDB{
&PageOut("${htmlpath}/t_adddb.htm");
exit;
}


sub DeleteDB{
unlink("$htmlpath/$in{'database'}");
unlink("$htmlpath/$in{'database'}.style");
unlink("$htmlpath/$in{'database'}.evenrow");
unlink("$htmlpath/$in{'database'}.oddrow");
unlink("$htmlpath/$in{'database'}.list");
unlink("$htmlpath/$in{'database'}.full");
#delete the bodies
opendir(DIR,"$htmlpath/newsdir");
@files = readdir(DIR);
close DIR;
foreach $i (@files){
if($i =~ /$in{'database'}\d+\.htm/){
  unlink("$htmlpath/newsdir/$i");
  }
}
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("The category has been removed");
window.location = "$in{'cgiurl'}?command=manage&rnd="+rndURL;
</script>
EOF
}

sub ViewOne{
(-e "$htmlpath/$in{'database'}.style")?(require "$htmlpath/$in{'database'}.style"):(require "$cgipath/styles.cgi");
(-e "$htmlpath/$in{'database'}.full")?($po = "$htmlpath/$in{'database'}.full"):($po = "$htmlpath/t_view.htm");

open(DB,"$htmlpath/$in{'database'}");
$found = 0;
while(<DB>){
chop;
(@fields) = split(/\~/,$_);
($fields[0] eq $in{'id'})&&($found = 1)&&(last);
}
if($found){
$in{'id'} = $fields[0];
$in{'title'} = $fields[1];
$in{'ptitle'} = $in{'title'};
$in{'date'} = $fields[2];
if($df ne 'US'){
my($m,$d,$y) = $in{'date'} =~ /(\d\d)-(\d\d)-(\d\d\d\d)/;
$in{'date'} = "$d-$m-$y";
}
$in{'description'} = $fields[3];
$in{'location'} = $fields[4];

foreach $i (keys %in){
$in{$i} =~ s/&#(\d+);/pack("c",$1)/ge;
}

$in{'description'} =~ s/\\n/<br>/g;
$display = $fields[19];
$authorization = $fields[21];
$bodyname = "$in{'database'}$fields[0].htm";
##get news html file
open(HTML,"$htmlpath/newsdir/$bodyname");
while(<HTML>){
$in{'body'} .= $_;
}
close HTML;

if($fields[22] eq 'checked'){
$in{'body'} =~ s/([\<\>])/'&#'.ord($1).';'/ge;
$in{'body'} =~ s/\n/<br>/g;
$in{'title'} =~ s/([\<\>])/'&#'.ord($1).';'/ge;
$in{'date'} =~ s/([\<\>])/'&#'.ord($1).';'/ge;
$in{'location'} =~ s/([\<\>])/'&#'.ord($1).';'/ge;
}

if($in{'displaysendemail'}){
open(HTML,"$htmlpath/t_email.htm");
while(<HTML>){
$_ =~ s/in\((\w+)\)/$in{$1}/g;
$in{'body'} .= $_;
}
close HTML;
}

($fields[6] eq 'checked')&&($in{'date'}='');
($fields[7] eq 'checked')&&($in{'location'}='');
($in{'date'})&&($in{'location'})&&($in{'location'}=" -- $in{'location'}");
(!$in{'op'})&&($in{'op'} = 't');
(!$in{'ct'})&&($in{'ct'} = 'd');
if(($in{'ct'} ne 'j')&&($in{'op'} eq 't')){
  &PageOut("$po");
  }
elsif(($in{'ct'} eq 'j')&&($in{'op'} eq 't')){
  &PageOutJS("$po");
  }
elsif(($in{'ct'} ne 'j')&&($in{'op'} ne 't')){
  &PageOut("$htmlpath/newsdir/$bodyname");
  }
else{
  &PageOutJS("$htmlpath/newsdir/$bodyname");
  }

}
else{
print "Error. No Record Found!<br>";
}
close DB;
exit;
}


sub SetStyle{
#save templates

if($in{'EvenRowTemplate'}){
  $in{'EvenRowTemplate'} =~ s/&#(\d+);/pack("c",$1)/ge;
  open(TMP,">$htmlpath/$in{'database'}.evenrow");
  print TMP $in{'EvenRowTemplate'};
  close TMP;
  delete($in{'EvenRowTemplate'});
  }

if($in{'OddRowTemplate'}){
  $in{'OddRowTemplate'} =~ s/&#(\d+);/pack("c",$1)/ge;
  open(TMP,">$htmlpath/$in{'database'}.oddrow");
  print TMP $in{'OddRowTemplate'};
  close TMP;
  delete($in{'OddRowTemplate'});
  }

if($in{'MainListingTemplate'}){
  $in{'MainListingTemplate'} =~ s/&#(\d+);/pack("c",$1)/ge;
  open(TMP,">$htmlpath/$in{'database'}.list");
  print TMP $in{'MainListingTemplate'};
  close TMP;
  delete($in{'MainListingTemplate'});
  }

if($in{'FullViewTemplate'}){
  $in{'FullViewTemplate'} =~ s/&#(\d+);/pack("c",$1)/ge;
  open(TMP,">$htmlpath/$in{'database'}.full");
  print TMP $in{'FullViewTemplate'};
  close TMP;
  delete($in{'FullViewTemplate'});
  }

open(STYLE,">$htmlpath/$in{'database'}.style");
foreach $i (sort keys(%in)){
$in{$i} =~ s/&#(\d+);/pack("c",$1)/ge;
next if (($i eq 'command')||($i eq 'cgiurl'));
next if (($i eq 'basemanageurl')||($i eq 'cinfo'));
next if (($i eq 'database')||($i eq 'imagedir'));
next if (($i eq 'imagerealdir')||($i eq 'images2'));
next if (($i eq 'format')||($i eq 'managementname'));
next if (($i eq 'managementuser')||($i eq 'managementemail'));
next if (($i eq 'UserName')||($i eq 'PassWord'));
$in{$i} =~ s/\\//g;
$in{$i} =~ s/@/\\@/g;
$in{$i} =~ s/"/\\"/g;
print STYLE "\$in{'$i'}=\"$in{$i}\";\n";
}
print STYLE "1;\n";
close STYLE;

}

sub SetStyles{
&SetStyle;
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Style has been successfully changes.");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF
exit;
}

sub ShowAd{
(-e "$htmlpath/$in{'database'}.style")?(require "$htmlpath/$in{'database'}.style"):(require "$cgipath/styles.cgi");
(-e "$htmlpath/$in{'database'}.evenrow")?($evenrow =  "$htmlpath/$in{'database'}.evenrow"):($evenrow =  "$htmlpath/t_news_line_even.htm");
(-e "$htmlpath/$in{'database'}.oddrow")?($oddrow =  "$htmlpath/$in{'database'}.oddrow"):($oddrow =  "$htmlpath/t_news_line_odd.htm");
(-e "$htmlpath/$in{'database'}.list")?($list =  "$htmlpath/$in{'database'}.list"):($list =  "$htmlpath/t_news_body.htm");
(-e "$htmlpath/$in{'database'}.full")?($full =  "$htmlpath/$in{'database'}.full"):($full =  "$htmlpath/t_view.htm");

(!$in{'security'})&&($in{'securitynone'} = 'checked');
$in{"security$in{'security'}"}='checked';
($in{'security'} ne 'password')&&($in{'securepass'} = '');
(!$in{'position'})&&($in{'positioncenter'} = 'checked');
$in{'position'.$in{'position'}} = 'checked';

foreach $i (keys %in){
 $in{$i} =~ s/([<>"])/'&#'.ord($1).';'/ge;
 }

##get even row
open(TMP,"$evenrow");
while(<TMP>){
$in{'EvenRowTemplate'} .= $_;
}
close TMP;
##get odd row
open(TMP,"$oddrow");
while(<TMP>){
$in{'OddRowTemplate'} .= $_;
}
close TMP;
##get list body
open(TMP,"$list");
while(<TMP>){
$in{'MainListingTemplate'} .= $_;
}
close TMP;

##get full listing
open(TMP,"$full");
while(<TMP>){
$in{'FullViewTemplate'} .= $_;
}
close TMP;


}

sub ShowAdv{
($in{'mpage'} ne 'manager')&&(&PError("Error. Access denied for advanced settings"));
&ShowAd;
&PageOut("$htmlpath/t_news_advanced_settings.htm");
exit;
}

sub ShowList{
$flip=1;
&GetDatabases;
$dbo = $in{'database'};
$dbo =~ s/%(..)/pack("c",hex($1))/ge;
$dbo =~ s/\.db//g;
if($dbo =~ /\.archive$/){
$dbo =~ s/\.archive$//;
$dbo = "$dbo Archive";
}
$in{'alabel'} = "Current Category: <font color=red>$dbo</font>";

##get total count
open(DB,"$htmlpath/$in{'database'}");
while($line=<DB>){
$tc++;
}
close DB;
open(DB,"$htmlpath/$in{'database'}");
while($line=<DB>){
chomp $line;
$count ++;
(@fields) = split(/\~/,$line);

foreach $i (0..$#fields){
  $fields[$i] =~ s/&#(\d+);/pack("c",$1)/ge;
  ($fields[22] eq 'checked')&&($fields[$i] =~ s/([<>"])/'&#'.ord($1).';'/ge);
  $fields[$i] =~ s/\\n/\n/g;
  }
($fields[2])&&($fields[2] .= ' -- ');

if($df ne 'US'){
my($m,$d,$y) = $fields[2] =~ /(\d\d)-(\d\d)-(\d\d\d\d)/;
$fields[2] = "$d-$m-$y";
}

$in{'viewlink'}='';
##create the link
($fields[19] eq "S")&&($in{'viewlink'} = "<a href=\"$in{'cgiurl'}?database=$in{'database'}&command=viewone&id=$fields[0]\">");
($fields[19] eq "P")&&($in{'viewlink'} = "<a href=\"javascript:View('$fields[0]');\">");
($fields[19] eq "I")&&($in{'viewlink'} = "<a href=\"$in{'htmlurl'}/news_upload/$fields[10]\" target=\"_blank\">");
if($fields[19] eq "U"){
  open(HTML,"$htmlpath/newsdir/$in{'database'}$fields[0].htm");
  $url = <HTML>;
  close HTML;
  $in{'viewlink'} = "<a href=\"$url\">";
}

##make select
for $i (1..$tc){
($i == $count)?($sel = 'selected'):($sel='');
$in{'rowsel'} .= "<option $sel>$i</option>";
}

($flip==1)?($bgc='#CCCCCC'):($bgc='#FFFFFF');
$flip=$flip * -1;


$in{'line'} .= "
  <tr bgcolor=\"$bgc\">
  <td valign=top align=\"center\">
  <input type=checkbox name=\"moveto\" value=\"$fields[0]\"></td><td valign=top align=\"center\"><select size=1 name=\"order_$count\" onChange=\"document.lowform.submit()\">
  $in{'rowsel'}
  </select>
  </td>
    <td align=\"left\" vAlign=\"top\"><input class=\"button\" type=\"button\" value=\"Edit\" onClick=\"javascript:Edit('$fields[0]');\">  <input class=\"button\" type=\"button\" value=\"Copy\" onClick=\"javascript:CopyItem('$fields[0]');\">
    </td>
    <td>
      <font face=\"ARIAL,HELVETICA\" size=\"2\"><b>$in{'viewlink'}$fields[1]</a></b></font><br>
      <font face=\"ARIAL,HELVETICA\" size=\"-2\">$fields[2]$fields[4]<br>
      $fields[3]</font></td>
  </td>
  </tr>
";

$in{'rowsel'}='';
}

close DB;
(!$in{'line'})&&($in{'line'}="<tr><td colspan=4><font size=2 face=verdana><b>No news items configured</b></td></tr>");
($in{'mpage'} eq 'manager')?(&PageOut("$htmlpath/t_show_list.htm")):(&PageOut("$htmlpath/t_show_list_pub.htm"));
exit;
}

sub GetDatabases{
opendir(IMG,"$htmlpath/");
@dbfiles = grep(/db$/,readdir(IMG));
closedir(IMG);
$dfound=0;
foreach $i (sort @dbfiles){
$seldb='';
$dbo = $i;
$dbo =~ s/%(..)/pack("c",hex($1))/ge;
$dbo =~ s/\.db//g;
(!$in{'database'})&&($seldb='selected')&&($in{'database'} = $i)&&($dfound=1);
($i eq $in{'database'})?($seldb = 'selected'):($seldb = '');
("$i.archive" eq $in{'database'})?($sela = 'selected'):($sela = '');
  $in{'databases'} .= "<option value=\"$i\" $seldb>$dbo</option>\n";
  $in{'databasesa'} .= "<option value=\"$i.archive\" $sela>$dbo Archive</option>\n";
  }

###get saved archives
opendir(IMG,"$htmlpath/");
@dbfiles = grep(/archive$/,readdir(IMG));
closedir(IMG);
$dfound=0;
foreach $i (sort @dbfiles){
$seldb='';
$dbo = $i;
$dbo =~ s/%(..)/pack("c",hex($1))/ge;
$dbo =~ s/\.db.archive//g;
$dfound=1;
($i eq $in{'database'})?($sela = 'selected'):($sela = '');
  $in{'databasesb'} .= "<option value=\"$i\" $sela>$dbo Archive</option>\n";
  }

(!$dfound)&&(!$in{'databases'})&&($in{'database'} = $edd)&&($in{'databases'} = "<option value=\"$edd\">$dd</option>");


}

sub CopyItem{
##get highest ID in DB for unique ID.
open(DB,"$htmlpath/$in{'database'}");
$id = 0;
while(<DB>){
($idt,@rest) = split("~",$_);
($idt > $id)&&($id = $idt);
}
close DB;
$id++;

open(DB,"$htmlpath/$in{'database'}");
open(TMP,">$htmlpath/$in{'database'}.tmp");
($flock)&&(flock(TMP,2));
while($line = <DB>){
$count++;
($mid,@fields) = split(/\~/,$line);
print TMP $line;
if($mid eq $in{'id'}){
  $tmp = join("~",$id,@fields);
  print TMP $tmp;
  }
}
close DB;
close TMP;
($flock)&&(flock(TMP,8));
@fi = stat("$htmlpath/$in{'database'}.tmp");
##only write over the file if greater than 1 byte in size.
rename("$htmlpath/$in{'database'}.tmp","$htmlpath/$in{'database'}") unless (($fi[7] < 1)&&($count > 1));
#copy body
open(BODY,"$htmlpath/newsdir/$in{'database'}$in{'id'}.htm");
open(BODYNEW,">$htmlpath/newsdir/$in{'database'}$id.htm");
($flock)&&(flock(BODYNEW,2));
while(<BODY>){
  print BODYNEW;
  }
close BODY;
close BODYNEW;
($flock)&&(flock(BODYNEW,8));
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("The selected item has been copied.");

window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF

exit;
}

sub DeleteItems{
@moves = split(/\\0/,$in{'moveto'});
foreach $i (@moves){
$m{$i} = 1;
}

open(DB,"$htmlpath/$in{'database'}");
($flock)&&(flock(DB,2));
open(TMP,">$htmlpath/$in{'database'}.tmp");
($flock)&&(flock(TMP,2));
while($line = <DB>){
$count++;
(@fields) = split(/\~/,$line);
print TMP $line unless ($m{$fields[0]});
}
close DB;
close TMP;
rename("$htmlpath/$in{'database'}.tmp","$htmlpath/$in{'database'}");
($flock)&&(flock(TMP,8));
($flock)&&(flock(DB,8));
#delete bodies
foreach $i (@moves){
unlink("$htmlpath/newsdir/$in{'database'}$i.htm");
}

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("The news items has been deleted.");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF

exit;
}

sub SaveChanges{
if($in{'file'}){
  $rn = &GetRealName($in{'file'});
  $trn = $in{'database'};
  $trn =~ s/\%/\_/g;
  &SaveFile($in{'file'},"$htmlpath/news_upload/$trn.$rn");
  $in{'uploaded'} = "$trn.$rn";
  }
$id = $in{'id'};
foreach $i (keys(%in)){
$in{$i} =~ s/&#60;/</g;
$in{$i} =~ s/&#62;/>/g;
}
$in{'datemodified'} = time;
&GetOutVars;
open(DB,"$htmlpath/$in{'database'}");
open(TMP,">$htmlpath/$in{'database'}.tmp");
($flock)&&(flock(TMP,2));
while($line = <DB>){
$count++;
(@fields) = split(/\~/,$line);
($fields[0] eq $id)?(print TMP "$newentry\n"):(print TMP $line);
}
close DB;
close TMP;
($flock)&&(flock(TMP,8));
@fi = stat("$htmlpath/$in{'database'}.tmp");
##only write over the file if greater than 1 byte in size.
rename("$htmlpath/$in{'database'}.tmp","$htmlpath/$in{'database'}") unless (($fi[7] < 1)&&($count > 1));
print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("Changes have been saved.");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF

exit;
}

sub ShowEdit{
open(DB,"$htmlpath/$in{'database'}");
$found = 0;
while(<DB>){
chop;
(@fields) = split(/\~/,$_);
($fields[0] eq $in{'id'})&&($found = 1)&&(last);
}

if($found){
foreach $i (0..$#fields){
$fields[$i] =~ s/&#(\d+);/pack("c",$1)/ge;
$fields[$i] =~ s/\\n/\n/g;
}

foreach $i (0..$#fields){
$fields[$i] =~ s/([<>"])/'&#'.ord($1).';'/ge;
}

$in{'id'} = $fields[0];
$in{'title'} = $fields[1];
($in{'month'},$in{'day'},$in{'year'}) = split(/[\.\-\/]/,$fields[2]);
$in{'description'} = $fields[3];
$in{'description'} =~ s/<(\/*textarea)>/&#60;$1&#62;/gi;
$in{'location'} = $fields[4];
$in{'hidedate'} = $fields[6];
$in{'hidelocation'} = $fields[7];
$in{'dateentered'} = $fields[8];
$in{'datemodified'} = $fields[9];
$in{'uploaded'} = $fields[10];
$display = $fields[19];
if($display eq 'I'){
  $in{'cf'} = "<br>Current File: <a href=\"$in{'htmlurl'}/news_upload/$fields[10]\" target=\"_blank\">$in{'uploaded'}</a>";
  }
$in{"d$display"} = 'checked';
$in{'noparsehtml'} = $fields[22];
$authorization = $fields[21];
$in{"a$authorization"} = 'checked';
$bodyname = "$in{'database'}$fields[0].htm";
$in{'title1'} = "Edit News Item";
$in{'sbutton'} = '    Save Changes    ';
$in{'command'} = 'savechanges';


(!$display)&&($in{'dS'} = 'checked');
(!$authorization)&&($in{'aY'} = 'checked');

##get news html file
open(HTML,"$htmlpath/newsdir/$bodyname");
while(<HTML>){
$in{'body'} .= $_;
}

$in{'body'} =~ s/<(\/*textarea)>/&#60;$1&#62;/gi;

($display eq "U")&&($in{'url'} = $in{'body'})&&($in{'body'} = '');
(!$in{'url'})&&($in{'url'} = 'http://');
close HTML;
&PageOut("$htmlpath/t_add_news.htm");
}
else{
print "Error. No record found.";
}
exit;
}

sub Add{
if($in{'file'}){
  $rn = &GetRealName($in{'file'});
  $trn = $in{'database'};
  $trn =~ s/\%/\_/g;
  &SaveFile($in{'file'},"$htmlpath/news_upload/$trn.$rn");
  $in{'uploaded'} = "$trn.$rn";
  }
(-e "$htmlpath/$in{'database'}.style")?(require "$htmlpath/$in{'database'}.style"):(require "$cgipath/styles.cgi");
##get highest ID in DB for unique ID.
open(DB,"$htmlpath/$in{'database'}");
$id = 0;
while(<DB>){
($idt,@rest) = split("~",$_);
($idt > $id)&&($id = $idt);
}
close DB;
$id++;
&GetOutVars;

open(DB,"$htmlpath/$in{'database'}");
open(DBT,">$htmlpath/$in{'database'}.tmp");
($flock)&&(flock(DBT,2));
print DBT "$newentry\n";
while(<DB>){
print DBT $_;
}
close DB;
close DBT;
($flock)&&(flock(DBT,8));
@s = stat("$htmlpath/$in{'database'}.tmp");
($s[7]>0)&&(rename("$htmlpath/$in{'database'}.tmp","$htmlpath/$in{'database'}"));

print <<"EOF";
<script language=javascript>
var rndURL = (1000*Math.random());
alert("News item successfully added.");
window.location = "$in{'cgiurl'}?command=manage&database=$in{'database'}&rnd="+rndURL;
</script>
EOF

exit;
}

sub GetOutVars{
$display = $in{'display'};
$url = $in{'url'};
if($display eq "U"){
$body = $url;
}
else{
$body = $in{'body'};
}
&GetBodyName;
$body =~ s/\r\n/\n/g;
open(HTML,">$htmlpath/newsdir/$bodyname");
($flock)&&(flock(HTML,2));
print HTML $body;
close HTML;
($flock)&&(flock(HTML,8));
#escape all variables
foreach $i (keys (%in)){
  $in{$i} =~ s/([^\w\s])/'&#'.ord($1).';'/ge;
  }
$title = $in{'title'};
$date = "$in{'month'}-$in{'day'}-$in{'year'}";
$description = $in{'description'};
$location = $in{'location'};
$hidedate = $in{'hidedate'};
$hidelocation = $in{'hidelocation'};
($in{'dateentered'})?($dateentered = $in{'dateentered'}):($dateentered = time);
($in{'datemodified'})?($datemodified = $in{'datemodified'}):($datemodified = time);
$uploaded = $in{'uploaded'};
$authorization = $in{'authorization'};
#unescape all variables
foreach $i (keys (%in)){
  $in{$i} =~ s/&#(\d+);/pack("c",$1)/ge;
  }
$newentry = "$id~$title~$date~$description~$location~$bodyname~$hidedate~$hidelocation~$dateentered~$datemodified~$uploaded~$t3~$p1~$p2~$p3~$e1~$e2~$e3~$header~$display~$MsgIcon~$authorization~$in{'noparsehtml'}";
$newentry =~ s/\r\n/\\n/g;
$newentry =~ s/\n/\\n/g;
}


sub GetBodyName{
$bodyname = "$in{'database'}$id.htm";
}

sub ShowAdd{
$in{'title1'} = "Add News Item";
$date = &ctime(time);
($in{'month'},$in{'day'},$in{'year'}) = split(/[\.\-\/]/,$date);
$in{'sbutton'} = '    Add News    ';
$in{'command'} = 'add';
$in{'dP'} = 'checked';
$in{'aY'} = 'checked';
$in{'url'} = 'http://';
$in{'htmlNO'} = 'checked';
&PageOut("$htmlpath/t_add_news.htm");
exit;
}

sub Reorder{
##get total count
open(DB,"$htmlpath/$in{'database'}");
while($line=<DB>){
$tc++;
@f=split("~",$line);
($in{'order_'.$tc} > $tc)&&($pre='2');
($in{'order_'.$tc} < $tc)&&($pre='0');
($in{'order_'.$tc} == $tc)&&($pre='1');

$o = sprintf("%.3d",$in{'order_'.$tc});
$l{$o.$pre.'-'.$f[0]} = $line;
}
close DB;

open(OUT,">$htmlpath/~$in{'database'}");
($flock)&&(flock(OUT,2));
for $i (sort keys %l){
print OUT $l{$i};
}
close OUT;
($flock)&&(flock(OUT,8));
$tc=0;
$in{'w'} = 'lowform';
@s = stat("$htmlpath/~$in{'database'}");
($s[7]>0)&&(rename("$htmlpath/~$in{'database'}","$htmlpath/$in{'database'}"));
&ShowList;
}


sub ShowLinks{
open(DB,"$htmlpath/$in{'database'}")||die print "$htmlpath/$in{'database'}<br>";
while($line=<DB>){
  chop $line;
  (@fields) = split(/\~/,$line);
  $in{'titles'} .= qq|<option value="$fields[0]">$fields[1]</option>|;
}
&GetDatabases;
$in{'ssiurl'} = $in{'cgiurl'};
$in{'ssiurl'} =~ s/http:\/\/.*?\//\//i;
&PageOut("$htmlpath/link_wizard.htm");
exit;
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

sub SaveVars{
foreach $i (keys %in){
  $tmp{$i} = $in{$i};
  }
}

sub GetVars{
foreach $i (keys %tmp){
  $in{$i} = $tmp{$i};
  }
}

sub Setup{
$cgipath = `pwd`;chomp $cgipath;
$cgiurl = "$ENV{'HTTP_HOST'}/$ENV{'SCRIPT_NAME'}";
$cgiurl =~ s/\/csNews\.cgi//i;
$cgiurl =~ s/\/\//\//g;
$cgiurl = "http://".$cgiurl;

$setup = "\$cgiurl = '$cgiurl';
\$cgipath = '$cgipath';
\$username='demo';
\$password='demo';
1;
";

print <<"EOF";


<head>
<title>csNews Setup Nullified by AndyAN</title>
</head>

<body>
<b><font face="tahoma">csNews Setup <font COLOR="#000000">Nullified by AndyAN</font></font></b><hr>
<font size=2 face=tahoma><b>Current contents of your setup.cgi file</b><br>Please verify the information and modify if needed:
<form method=post action="csNews.cgi">
<input type=hidden name=command value=savesetup>
<textarea rows=10 cols=80 name=setup wrap=off>
$setup
</textarea>
<hr>
<input type=submit value="-=Save Changes=-">
</form>
<p><font face="Tahoma" size="2"><b>Definitions:</b></font></p>
<p><font face="Tahoma" size="2">\$cgiurl = Full URL to </font></font><font face="Tahoma" size="2">the
csNews directory<font size=2 face=tahoma><br>
\$cgipath = Full PATH to the csNews directory.<br>
\$username = username to enter management screens<br>
\$password = password to enter management screens</font></font>

<p><font face="Tahoma" size="2"><b>Normal Installation Instructions:</b></font></p>
<p><font face="Tahoma" size="2">In most cases, the script is already configured.
Change the \$username and \$password variables to your liking and click 'Save'.
If the setup portion of the script cannot find your site variables
automatically, you </font></font>will<font face="Tahoma" size="2"><font size=2 face=tahoma>
have to enter those in the above text area.</font></font> If you click 'save'
and you come back to this setup page, then your server doesn't have write access
to your directories. You can solve this problem by chmod'ing the csNews
directory to 777.</p>
<p><b>WinNT installations:</b><br>
The script has been tested and works on an NT IIS webserver. You will, however,
have to manually enter the cgipath and rootpath variables. For example, your
rootpath might look something like 'c:/inetpub/wwwroot' (Note: the back-slashes
'\' normally associated with Window's file paths has been changed to a
forward-slash '/')</p>
<font size=2 face=tahoma>
<p><font face="Tahoma" size="2"><b>CGI-BIN Installation Instructions:</b></font></p>
</font><p>The preferred method is to install csNews in a directory outside
your cgi-bin directory, however, i<font size=2 face=tahoma><font face="Tahoma" size="2">f your hosting service <b>will not</b> let
you
run scripts outside your <b>cgi-bin</b> directory, then follow these procedures:</font></p>
<p><font face="Tahoma" size="2">Copy all the *.cgi files to a directory in your
cgi-bin directory, making sure they are chmod'd to 755. For example, you could
create a /cgi-bin/csNews/ directory and place csNews.cgi, libs.cgi, styles.cgi
and setup.cgi </font></font>(<font face="Tahoma" size="2"><font size=2 face=tahoma>if this file
exists</font></font>) in this direcory<font size=2 face=tahoma><font face="Tahoma" size="2">.</font></p>
<p><font face="Tahoma" size="2">Create a directory outside your cgi-bin
directory and copy all the remaining files and subdirectories there. For
example, you could create a /cgi-script/csNews and place the files there.</font></p>
<p><font face="Tahoma" size="2">Edit the above variables (or manually edit
setup.cgi) to the following:<br>
\$cgiurl = URL to the csNews directory INSIDE your cgi-bin directory (where
the script is installed).<br>
\$cgipath = FULL PATH to the csNews directory INSIDE your cgi-bin directory
(where the script is installed).<br>
<i><b>ADD THE FOLLOWING VARIABLES TO THE ABOVE CONFIGURATION OR MANUALLY EDIT
setup.cgi:<br>
</b></i>\$htmlurl =&nbsp; FULL URL to the csNews directory OUTSIDE your cgi-bin
directory (where the rem</font></font>ainin<font size=2 face=tahoma><font face="Tahoma" size="2">g files where installed) <br>
\$htmlpath = FULL PATH to the csNews directory OUTSIDE your cgi-bin
directory (where the</font></font><font face="Tahoma" size="2"> remaining</font><font size=2 face=tahoma><font face="Tahoma" size="2"> files where installed) <br>
For Example, your new setup.cgi file might look something like this:<br>
\$cgiurl='http://localhost/cgi-bin/csNews';<br>
\$cgipath='/www/vhosts/localhost/cgi-bin/csNews';<br>
\$htmlurl='http://localhost/cgi-script/csNews';<br>
\$htmlpath='/www/vhosts/localhost/cgi-script/csNews';<br>
\$username='myusername';<br>
\$password=',mypassword';<br>
1;</font></p>
<p><font face="Tahoma" size="2"><i>(note: the '1' at the end is to prevent
errors from perl if \$password was left empty)</i></font></p>
</font>
</body>
EOF

exit;
}

sub SaveSetup{
(-e "$basepath/setup.cgi")&&(&PError("Error. Access Denied"));
$in{'setup'} =~ s/\r*\n/\n/g;
open(SETUP,">./setup.cgi");
($flock)&&(flock(SETUP,2));
print SETUP $in{'setup'};
print SETUP "\n";
close SETUP;
($flock)&&(flock(SETUP,8));
print <<"EOF";
<script language=javascript>
alert("Setup.cgi reconfigured");
window.location = "csNews.cgi?command=login";
</script>
EOF
exit;
}


sub ShowListPub{
&GetRange;
(!$in{'o'})&&($in{'o'} = 'n');
(!$in{'od'})&&($in{'od'} = 'a');

##override to create all encompassing db
if($in{'database'} eq 'all'){
  &CreateFullDB;
  }
elsif($in{'database'} =~ /\%5c0/){
  &CreateFullDB;
  }
else{
  open(DB,"$htmlpath/$in{'database'}");
  while(<DB>){
    chomp;
    push(@tmp,$_);
    }
  close DB;
}

foreach $line (@tmp){
  #chop $line;
  $count ++;
  (@fields) = split(/\~/,$line);
  next if ($fields[21] eq 'N');
  #order number
  $count = sprintf("%.3d",$count);
  ($in{'o'} eq 'n')&&($sort{$count} = $line);
  #order date
  if($in{'o'} eq 'd'){
  $fields[2] =~ s/&#(\d+);/pack("c",$1)/ge;
  ($m,$d,$y) = split(/[\-\/\.]/,$fields[2]);
  $m = sprintf("%.2d",$m);
  $d = sprintf("%.2d",$d);
  $y = sprintf("%.4d",$y);
  $myd = "$y$m$d-$fields[0]-$fields[23]";
  $sort{$myd} = $line;
  }
  #order description
  if($in{'o'} eq 'a'){
  $fields[1] =~ s/&#(\d+);/pack("c",$1)/ge;
  $myt = "$fields[1]-$fields[0]-$fields[23]";
  $myt =~ tr/A-Z/a-z/;
  $sort{$myt} = $line;
  }

}

if($in{'od'} eq 'a'){
foreach $line (sort {$a cmp $b} keys(%sort)){
  (&CheckRange)&&(next);
  push(@vals,$sort{$line});
  }
}
else{
foreach $line (sort {$b cmp $a} keys(%sort)){
  (&CheckRange)&&(next);
  push(@vals,$sort{$line});
  }
}

&ShowListPub2;
}

sub GetRange{
if(($in{'range'} eq 's')&&($in{'o'} eq 'd')){
  ($m,$d,$y) = split(/[\-\/\.]/,$in{'rangestart'});
  $m = sprintf("%.2d",$m);
  $d = sprintf("%.2d",$d);
  $y = sprintf("%.4d",$y);
  $in{'rangestart'} = "$y$m$d";
  ($m,$d,$y) = split(/[\-\/\.]/,$in{'rangeend'});
  $m = sprintf("%.2d",$m);
  $d = sprintf("%.2d",$d);
  $y = sprintf("%.4d",$y);
  $in{'rangeend'} = "$y$m$d";
  }
}

sub CheckRange{
(($in{'range'} eq '')||($in{'range'} eq 'a'))&&(return 0);

if(($in{'range'} eq 's')&&($in{'o'} eq 'n')){
  if($in{'pt'} ne 'c'){
    $mycount++;
    (($mycount >= $in{'rangestart'})&&($mycount <= $in{'rangeend'}))?(return 0):(return 1);
    }
  else{
    @f = split("~",$sort{$line});
    $mycount{$f[23]}++;
    (($mycount{$f[23]} >= $in{'rangestart'})&&($mycount{$f[23]} <= $in{'rangeend'}))?(return 0):(return 1);
    }
  }

if(($in{'range'} eq 's')&&($in{'o'} eq 'a')){
  $x = substr($line,0,length($in{'rangestart'}));
  $y = substr($line,0,length($in{'rangeend'}));
  (($x ge $in{'rangestart'})&&($y le $in{'rangeend'}))?(return 0):(return 1);
  }

if(($in{'range'} eq 's')&&($in{'o'} eq 'd')){
  ($x,$i) = split(/[\-\/\.]/,$line);
  (($x ge $in{'rangestart'})&&($x le $in{'rangeend'}))?(return 0):(return 1);
  }

}

sub ShowListPub2{
srand(time|$$);
$rand = int(rand(1000));
$tid=$in{'id'};
#&GetDatabases;

(-e "$htmlpath/$in{'database'}.style")?(require "$htmlpath/$in{'database'}.style"):(require "$cgipath/styles.cgi");
(-e "$htmlpath/$in{'database'}.evenrow")?($evenrow =  "$htmlpath/$in{'database'}.evenrow"):($evenrow =  "$htmlpath/t_news_line_even.htm");
(-e "$htmlpath/$in{'database'}.oddrow")?($oddrow =  "$htmlpath/$in{'database'}.oddrow"):($oddrow =  "$htmlpath/t_news_line_odd.htm");
(-e "$htmlpath/$in{'database'}.list")?($list =  "$htmlpath/$in{'database'}.list"):($list =  "$htmlpath/t_news_body.htm");

$jsfn = $in{'database'};
$jsfn =~ s/\W//g;
$jsfn .= $rand;
$flip=1;

#get even row
open(NEWS,"$evenrow");
while(<NEWS>){
  $tmpeven .= $_
  }
close NEWS;

#get odd row
open(NEWS,"$oddrow");
while(<NEWS>){
  $tmpodd .= $_
  }
close NEWS;

foreach $line (@vals){
$count ++;
(@fields) = split(/\~/,$line);

## if other type of database... give it to them
if($fields[23]){
  $in{'database'} = $fields[23];
  }

next if ($fields[21] eq 'N');

foreach $i (0..$#fields){
$fields[$i] =~ s/&#(\d+);/pack("c",$1)/ge;
($fields[22] eq 'checked')&&($fields[$i] =~ s/([<>"])/'&#'.ord($1).';'/ge);
$fields[$i] =~ s/\\n/\n/g;
}


$in{'viewlink'}='';
##create the link

($in{'link'})&&($fields[19] = $in{'link'});

($fields[19] eq "S")&&($viewlink = "<a href=\"$in{'cgiurl'}?database=$in{'database'}&command=viewone&id=$fields[0]&op=$in{'ob'}\">");
if($fields[19] eq "P"){
  $in{'database'} =~ s/\%27/\\'/g;
  $viewlink = "<a href=\"javascript:View${jsfn}('$fields[0]','$in{'database'}');\">";
  $in{'database'} =~ s/\\'/\%27/g;
  }
($fields[19] eq "I")&&($viewlink = "<a href=\"$in{'htmlurl'}/news_upload/$fields[10]\" target=\"_blank\">");
(!$viewlink)&&($viewlink = "<a href=\"$in{'cgiurl'}?database=$in{'database'}&command=viewone&id=$fields[0]&op=$in{'ob'}\">");
($fields[19] eq "N")&&($viewlink = "");

if($fields[19] eq "U"){
  open(HTML,"$htmlpath/newsdir/$in{'database'}$fields[0].htm");
  $url = <HTML>;
  close HTML;
  $viewlink = "<a href=\"$url\" target=_blank>";
}

$flip = $flip * -1;
if($in{'sc'} eq 'y'){
  $cat = $in{'database'};
  $cat =~ s/%(..)/pack("c",hex($1))/ge;
  $cat =~ s/\.db//g;
  $cat = "$cat » ";
  $in{'title'} = "$viewlink$cat$fields[1]</a>";
  }
else{
  $in{'title'} = "$viewlink$fields[1]</a>";
}

($fields[6] ne 'checked')?($in{'date'} = $fields[2]):($in{'date'} = '');
($fields[7] ne 'checked')?($in{'location'} = $fields[4]):($in{'location'}='');
$in{'description'} = $fields[3];

if($df ne 'US'){
my($m,$d,$y) = $in{'date'} =~ /(\d\d)-(\d\d)-(\d\d\d\d)/;
$in{'date'} = "$d-$m-$y";
}

($in{'sd'} eq 'n')&&($in{'description'} = '');
($in{'st'} eq 'n')&&($in{'date'} = '');
($in{'st'} eq 'n')&&($in{'location'} = '');
#limit description
($in{'dlimit'})&&($in{'description'} = substr($in{'description'},0,$in{'dlimit'}).'...');
#add bodies to description
if($in{'nb'} eq 'y'){
  $body='';
  $in{'title'} = "$cat$fields[1]";
  open(HTML,"$htmlpath/newsdir/$in{'database'}$fields[0].htm");
  while(<HTML>){
  $body .= $_;
  }
  close HTML;
  $in{'description'} = "$in{'description'}<p>$body</p>";
}

($flip == -1)?($newsline = $tmpeven):($newsline = $tmpodd);
($in{'op'} eq 'r')&&($br='<br>');
($in{'date'})&&($in{'date'} = "$br$in{'date'}");
($in{'description'})&&($in{'description'} = "$br$in{'description'}");
($in{'date'})&&($in{'location'})&&($in{'location'} = " - $in{'location'}");
(!$in{'date'})&&($in{'location'})&&($in{'location'} = "$br$in{'location'}");
$newsline =~ s/in\((\w+)\)/$in{$1}/g;
$in{'newslines'} .= $newsline;
($in{'op'} eq 'r')&&($raw .= "<p>$in{'title'}$in{'date'}$in{'location'}$in{'description'}</p>");
}

($in{'locationbar'} eq 'checked')?($in{'locationbar'} = 'yes'):($in{'locationbar'} = 'no');
($in{'directories'} eq 'checked')?($in{'directories'} = 'yes'):($in{'directories'} = 'no');
($in{'statusbar'} eq 'checked')?($in{'status'} = 'yes'):($in{'status'} = 'no');
($in{'menubar'} eq 'checked')?($in{'menubar'} = 'yes'):($in{'menubar'} = 'no');
($in{'toolbar'} eq 'checked')?($in{'toolbar'} = 'yes'):($in{'toolbar'} = 'no');
($in{'resizable'} eq 'checked')?($in{'resizable'} = 'yes'):($in{'resizable'} = 'no');
($in{'scrollbar'} eq 'checked')?($in{'scrollbar'} = 'yes'):($in{'scrollbar'} = 'no');
(!$in{'ptop'})&&($in{'ptop'} = '0');
(!$in{'pleft'})&&($in{'pleft'} = '0');
$newsjs = qq~
<script language=javascript>
var win=null;
function View${jsfn}(id,db){
var rndURL = (1000*Math.random());
var myname="$in{'rand'}";
var w = "$in{'Width'}";
var h = "$in{'Height'}";
var pos = "$in{'position'}";
if("$in{'position'}" == "absolute"){
var TopPosition = $in{'ptop'};
var LeftPosition = $in{'pleft'};
}

var mypage = "$in{'cgiurl'}?database="+db+"&command=viewone&op=$in{'ob'}&id="+id+"&rnd="+rndURL;
if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
else if((pos!="center" && pos!="random" && pos!= "absolute") || pos==null){LeftPosition=0;TopPosition=20}
settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars=$in{'scrollbar'},location=$in{'locationbar'},directories=$in{'directories'},status=$in{'status'},menubar=$in{'menubar'},toolbar=$in{'toolbar'},resizable=$in{'resizable'}';
win=window.open(mypage,myname,settings);
if(win.focus){win.focus();}}
</script>
~;
if($in{'op'} eq 'r'){
  $raw .= $newsjs;
  if($in{'ct'} eq 'j'){
    $raw =~ s/\"/\\"/g;
    $raw =~ s/script/scr\"\+\"ipt/gsi;
    @mylines = split(/\r*\n/,$raw);

    foreach $q (@mylines){
      print qq|
      document.write("$q");
      |;
  }
  }
  else{
    print $raw;
    }
  }
else{
  $in{'newslines'} .= $newsjs;
  ($in{'ct'} eq 'j')?(&PageOutJS("$list")):(&PageOut("$list"));
  }
exit;
}

sub ShowUploadEditor{
&PageOut("$htmlpath/t_upload_imageEditor.htm");
exit;
}

sub UploadEditor{
$rn = &GetRealName($in{'file'});
&CheckExt($rn);
$trn = $in{'database'};
$trn =~ s/\%/\_/g;
&SaveFile($in{'file'},"$htmlpath/image_upload/$trn.$rn");
(!$in{'align'})&&($in{'align'}='left');
(!$in{'border'})&&($in{'border'}='0');
(!$in{'hspace'})&&($in{'hspace'}='0');
(!$in{'vspace'})&&($in{'vspace'}='0');
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
&PageOut("$htmlpath/editor.cgi");
exit;
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

sub CopyFile{
local($old,$new)=@_;
return if ((! -e "$old")||(-d "$old"));
open(DB,"$old");
open(DBT,">$new");
($flock)&&(flock(DBT,2));
while(<DB>){
  print DBT;
  }
close DB;
close DBT;
($flock)&&(flock(DBT,8));
}

sub PageOutJS{
local($file) = @_;
open(OUT,"$file")||print "$!: $file<br>";
while(<OUT>){
$o = $_;
$o =~ s/in\((\w+)\)/$in{$1}/g;
$o =~ s/\"/\\"/g;
$o =~ s/\\n/\\\\n/g;
#$o =~ s/script/scr\"\+\"ipt/gsi;
$o =~ s/(scr)(ipt)/$1\"\+\"$2/gsi;
@mylines = split(/\r*\n/,$o);

    foreach $q (@mylines){
      print qq|document.write("$q\\n");\n|;
      }

}
close OUT;
}
1;

sub CreateFullDB{

if($in{'database'} eq 'all'){
opendir(IMG,"$htmlpath/");
@dbfiles = grep(/db$/,readdir(IMG));
closedir(IMG);
opendir(IMG,"$htmlpath/");
@dbfilesb = grep(/archive$/,readdir(IMG));
closedir(IMG);
push(@dbfiles,@dbfilesb);
}
else{
@dbfiles = split(/\%5c0/,$in{'database'});
$in{'database'} = $dbfiles[0];
}

foreach $x (@dbfiles){
  open(DB,"$htmlpath/$x");
  while(<DB>){
    chomp;
    @f = split("~",$_);
    $f[9] = sprintf("%.20d",$f[9]);
    if($in{'gc'} eq 'y'){
      $tmp = $x;
      $tmp =~ s/\W//g;
      $tmp =~ tr/a-z/A-Z/;
      $mydb{"$tmp$f[9]\t$f[0]\t$x"} = $_;
      }
    else{
      $mydb{"$f[9]\t$f[0]\t$x"} = $_;
      }
    }
  close DB;
  }

foreach $x (sort {$b cmp $a} keys(%mydb)){
  if($in{'gc'} eq 'y'){
    ($dm,$id,$db) = split("\t",$x);
    }
  else{
    ($dm,$id,$db) = split("\t",$x);
    }
  push(@tmp,"$mydb{$x}~$db");
  }
close TMP;

}