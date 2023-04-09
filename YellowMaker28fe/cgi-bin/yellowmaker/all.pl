#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# all.pl
########################################################################

eval {
  ($0 =~ m,(.*)/[^/]+,)   && unshift (@INC, "$1"); # Get the script location: UNIX / or Windows /
  ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Get the script location: Windows \

do "config.pl";
do "config2.pl";
do "variable.pl";
do "sub.pl";
};

if ($@) {
print ("Content-type: text/html\n\n");
print "Error including required files: $@\n";
print "Make sure these files exist, permissions are set properly, and paths are set correctly.";
exit;
}

&parse_form;

&header;
&top;

print qq~
<div align="center"><center>

<table border="0" cellpadding="0" width="90%" cellspacing="0">
  <tr>
    <td width="100%" colspan="3"><p align="center"><font face="$font" size="$size"><big><img
    src="$home/pics/categories.gif" alt="All Categories" border="0"></big><br>
<br>Please select a category you want to search.</font></td>
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
    href="$homecgi/all.pl?category=a&goto=$form{'goto'}">A</a> <a href="$homecgi/all.pl?category=b&goto=$form{'goto'}">B</a> <a
    href="$homecgi/all.pl?category=c&goto=$form{'goto'}">C</a> <a href="$homecgi/all.pl?category=d&goto=$form{'goto'}">D</a> <a
    href="$homecgi/all.pl?category=e&goto=$form{'goto'}">E</a> <a href="$homecgi/all.pl?category=f&goto=$form{'goto'}">F</a> <a
    href="$homecgi/all.pl?category=g&goto=$form{'goto'}">G</a> <a href="$homecgi/all.pl?category=h&goto=$form{'goto'}">H</a> <a
    href="$homecgi/all.pl?category=i&goto=$form{'goto'}">I</a> <a href="$homecgi/all.pl?category=j&goto=$form{'goto'}">J</a> <a
    href="$homecgi/all.pl?category=k&goto=$form{'goto'}">K</a> <a href="$homecgi/all.pl?category=l&goto=$form{'goto'}">L</a> <a
    href="$homecgi/all.pl?category=m&goto=$form{'goto'}">M</a> <a href="$homecgi/all.pl?category=n&goto=$form{'goto'}">N</a> <a
    href="$homecgi/all.pl?category=o&goto=$form{'goto'}">O</a> <a href="$homecgi/all.pl?category=p&goto=$form{'goto'}">P</a> <a
    href="$homecgi/all.pl?category=q&goto=$form{'goto'}">Q</a> <a href="$homecgi/all.pl?category=r&goto=$form{'goto'}">R</a> <a
    href="$homecgi/all.pl?category=s&goto=$form{'goto'}">S</a> <a href="$homecgi/all.pl?category=t&goto=$form{'goto'}">T</a> <a
    href="$homecgi/all.pl?category=u&goto=$form{'goto'}">U</a> <a href="$homecgi/all.pl?category=v&goto=$form{'goto'}">V</a> <a
    href="$homecgi/all.pl?category=w&goto=$form{'goto'}">W</a> <a href="$homecgi/all.pl?category=x&goto=$form{'goto'}">X</a> <a
    href="$homecgi/all.pl?category=y&goto=$form{'goto'}">Y</a> <a href="$homecgi/all.pl?category=z&goto=$form{'goto'}">Z</a></font></td>
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
$line2 =~ s/&/%26/g;

print "<a href=\"$homecgi/advanced2.pl?host=Doesn't%20Matter&id=Doesn't%20Matter&ip=Doesn't%20Matter&emailaddr=Doesn't%20Matter&dateadd=Doesn't%20Matter&datemod=Doesn't%20Matter&category=$line2&goto=$form{'goto'}\">$line<br></a>\n";
}

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
    href="$homecgi/all.pl?category=a&goto=$form{'goto'}">A</a> <a href="$homecgi/all.pl?category=b&goto=$form{'goto'}">B</a> <a
    href="$homecgi/all.pl?category=c&goto=$form{'goto'}">C</a> <a href="$homecgi/all.pl?category=d&goto=$form{'goto'}">D</a> <a
    href="$homecgi/all.pl?category=e&goto=$form{'goto'}">E</a> <a href="$homecgi/all.pl?category=f&goto=$form{'goto'}">F</a> <a
    href="$homecgi/all.pl?category=g&goto=$form{'goto'}">G</a> <a href="$homecgi/all.pl?category=h&goto=$form{'goto'}">H</a> <a
    href="$homecgi/all.pl?category=i&goto=$form{'goto'}">I</a> <a href="$homecgi/all.pl?category=j&goto=$form{'goto'}">J</a> <a
    href="$homecgi/all.pl?category=k&goto=$form{'goto'}">K</a> <a href="$homecgi/all.pl?category=l&goto=$form{'goto'}">L</a> <a
    href="$homecgi/all.pl?category=m&goto=$form{'goto'}">M</a> <a href="$homecgi/all.pl?category=n&goto=$form{'goto'}">N</a> <a
    href="$homecgi/all.pl?category=o&goto=$form{'goto'}">O</a> <a href="$homecgi/all.pl?category=p&goto=$form{'goto'}">P</a> <a
    href="$homecgi/all.pl?category=q&goto=$form{'goto'}">Q</a> <a href="$homecgi/all.pl?category=r&goto=$form{'goto'}">R</a> <a
    href="$homecgi/all.pl?category=s&goto=$form{'goto'}">S</a> <a href="$homecgi/all.pl?category=t&goto=$form{'goto'}">T</a> <a
    href="$homecgi/all.pl?category=u&goto=$form{'goto'}">U</a> <a href="$homecgi/all.pl?category=v&goto=$form{'goto'}">V</a> <a
    href="$homecgi/all.pl?category=w&goto=$form{'goto'}">W</a> <a href="$homecgi/all.pl?category=x&goto=$form{'goto'}">X</a> <a
    href="$homecgi/all.pl?category=y&goto=$form{'goto'}">Y</a> <a href="$homecgi/all.pl?category=z&goto=$form{'goto'}">Z</a></font></td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3"><hr noshade color="#FF9933" size="1" width="90%">
    </td>
  </tr>
  <tr>
    <td width="100%" align="center" valign="top" colspan="3" height="25"></td>
  </tr>
</table>
</center></div>
~;

&print_search;

&bottom;
exit;
