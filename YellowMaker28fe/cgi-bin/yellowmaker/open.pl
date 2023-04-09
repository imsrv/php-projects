#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# open.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
do "cookie.lib";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&checkpermission;

&parse_form;

$file=$database;
$user="$emailaddress";
$file =~ /(.+)/;
$safefile=$1;
$returnval=&datadefined($user, $safefile);

&header;
&top;

$category2="";
$category2=$category;
$category2 =~ s/&/%26/gi;

if (!$category) {
$category="<Strong>Category:</strong> Please select a category from listings below.";
} else {
$category="<Strong>Category:</strong> <a href=\"$homecgi/open2.pl?category=$category2\">$category</a>";
}

print qq~
<div align="center"><center>

<table border="0" cellpadding="0" width="90%" cellspacing="0">
  <tr>
    <td width="100%" colspan="3"><p align="center"><font face="$font" size="$size"><big><img
    src="$home/pics/open.gif" alt="Add/Modify Profile" border="0"></big><br>
    <big><br>
    </big><b>Step 1:</b> Specify Your Organization Type</font></td>
  </tr>
  <tr>
    <td width="100%" align="center" height="15" valign="top" colspan="3"></td>
  </tr>
  <tr>
    <td width="100%" align="center" height="20" valign="top" colspan="3"><font face="$font" size="$size">$category</font></a></td>
  </tr>
  <tr>
    <td width="100%" align="center" height="15" valign="top" colspan="3"></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><hr noshade color="#FF9933" size="1" width="90%">
    </td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><font face="$font" size="$size"><a
    href="$homecgi/open.pl?category=a">A</a> <a href="$homecgi/open.pl?category=b">B</a> <a
    href="$homecgi/open.pl?category=c">C</a> <a href="$homecgi/open.pl?category=d">D</a> <a
    href="$homecgi/open.pl?category=e">E</a> <a href="$homecgi/open.pl?category=f">F</a> <a
    href="$homecgi/open.pl?category=g">G</a> <a href="$homecgi/open.pl?category=h">H</a> <a
    href="$homecgi/open.pl?category=i">I</a> <a href="$homecgi/open.pl?category=j">J</a> <a
    href="$homecgi/open.pl?category=k">K</a> <a href="$homecgi/open.pl?category=l">L</a> <a
    href="$homecgi/open.pl?category=m">M</a> <a href="$homecgi/open.pl?category=n">N</a> <a
    href="$homecgi/open.pl?category=o">O</a> <a href="$homecgi/open.pl?category=p">P</a> <a
    href="$homecgi/open.pl?category=q">Q</a> <a href="$homecgi/open.pl?category=r">R</a> <a
    href="$homecgi/open.pl?category=s">S</a> <a href="$homecgi/open.pl?category=t">T</a> <a
    href="$homecgi/open.pl?category=u">U</a> <a href="$homecgi/open.pl?category=v">V</a> <a
    href="$homecgi/open.pl?category=w">W</a> <a href="$homecgi/open.pl?category=x">X</a> <a
    href="$homecgi/open.pl?category=y">Y</a> <a href="$homecgi/open.pl?category=z">Z</a></font></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><hr noshade color="#FF9933" size="1" width="90%">
    </td>
  </tr>
  <tr>
    <td width="100%" align="center" height="20" valign="top" colspan="3"></td>
  </tr>
  <tr>
    <td width="33%" align="center" valign="top"></td>
    <td width="67%" align="left" valign="top"><font face="$font" size="$size"><p align="left">
~;

if (!$form{'category'}) {
$form{'category'}="a";
}

open (CATEGORIES, "<$sub8/$form{'category'}.txt");
foreach $line (<CATEGORIES>) {
$line =~ s/^\s+//;
$line =~ s/\s+$//;
$line2="";
$line2=$line;
$line2 =~ s/&/%26/gi;
print "<a href=\"$homecgi/open2.pl?category=$line2\">$line</a><br>\n";
}
close CATEGORIES;

print qq~
</font></td>
    <td width="10%" align="center" valign="top"></td>
  </tr>
  <tr>
    <td width="100%" align="center" height="20" valign="top" colspan="3"></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><hr noshade color="#FF9933" size="1" width="90%">
    </td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><font face="$font" size="$size"><a
    href="$homecgi/open.pl?category=a">A</a> <a href="$homecgi/open.pl?category=b">B</a> <a
    href="$homecgi/open.pl?category=c">C</a> <a href="$homecgi/open.pl?category=d">D</a> <a
    href="$homecgi/open.pl?category=e">E</a> <a href="$homecgi/open.pl?category=f">F</a> <a
    href="$homecgi/open.pl?category=g">G</a> <a href="$homecgi/open.pl?category=h">H</a> <a
    href="$homecgi/open.pl?category=i">I</a> <a href="$homecgi/open.pl?category=j">J</a> <a
    href="$homecgi/open.pl?category=k">K</a> <a href="$homecgi/open.pl?category=l">L</a> <a
    href="$homecgi/open.pl?category=m">M</a> <a href="$homecgi/open.pl?category=n">N</a> <a
    href="$homecgi/open.pl?category=o">O</a> <a href="$homecgi/open.pl?category=p">P</a> <a
    href="$homecgi/open.pl?category=q">Q</a> <a href="$homecgi/open.pl?category=r">R</a> <a
    href="$homecgi/open.pl?category=s">S</a> <a href="$homecgi/open.pl?category=t">T</a> <a
    href="$homecgi/open.pl?category=u">U</a> <a href="$homecgi/open.pl?category=v">V</a> <a
    href="$homecgi/open.pl?category=w">W</a> <a href="$homecgi/open.pl?category=x">X</a> <a
    href="$homecgi/open.pl?category=y">Y</a> <a href="$homecgi/open.pl?category=z">Z</a></font></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><hr noshade color="#FF9933" size="1" width="90%">
    </td>
  </tr>
</table>
</center></div>
~;

&bottom;
exit;
