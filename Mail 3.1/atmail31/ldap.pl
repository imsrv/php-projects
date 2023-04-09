#!/usr/bin/perl
# Script to interface with LPAD servers
# Developed by Ben Duncan (ben@cgisupport.com)
# http://CGIsupport.com

# Find current working directory and load library modules
use FindBin qw($Bin);
use lib "$Bin/libs";

use Net::LDAP;
use IO::Select;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

require 'Common.pm';

&config;
&htmlheader("Email Search");

# Custom design link colours and layout here

# LDAP Server list
# ldap.switchboard.com
# ldap.whowhere.com
# ldap.infospace.com
# ldap.four11.com
# ldap.bigfoot.com

# Make a new connection to LDAP server (port 389)
#$servername = "ldap.four11.com" if(!$servername);

if(!$servername) {
&printstart;
exit;
                }

$ldap = Net::LDAP->new($servername,
		DN => "",
		Password => "",
		Port => 389,
		Debug => 3,
	) or print "$@";


$query = "(!(cn=$FirstName $LastName))" if(!$advanced);
$query = "(!(mail=$mail))" if($advanced);

# Now we make our query to the LDAP server according to the users
# input via the form

for $filter     (
$query, '(&(objectClass=Person))',
	        ) {

    $mesg = $ldap->search(
		filter => $filter
    ) or print $@;

# print $query;

# Modify the HTML below to change the design of the output from the
# LDAP server

# Prefer either a simple or advanced search
&advanced if($advanced);
&simple if(!$advanced);

sub simple      {

for($index = 0 ; $entry = $mesg->entry($index) ; $index++ ) { }

$content = <<_EOF;
   <table width="600" border="0" height="149">
      <tr> 
        <td> 
          <table cellpadding=3 cellspacing=0 border=0 width="600">
            <tr bgcolor="$primarycolor">
              <td width="478">$index matches</td>
              <td width="110">
                <div align="right"><font face=Arial size="-1">
<a href="ldap.pl"><b>Search 
                  Again</b></a></font></div>
              </td>
            </tr>
          </table>
          <table cellpadding=2 cellspacing=1 border=1 width="600">
            <tr bgcolor="$secondarycolor"> 
              <td>&nbsp;<font size="-1" face=Arial><b>Country</b></font>
</td>
              <td>&nbsp;<font size="-1" face=Arial><b>Email</b></font></td>
              <td>&nbsp;<font size="-1" face=Arial><b>Full Name</b></font></td>
              <td>&nbsp;<font size="-1" face=Arial><b>Tools</b></font></td>
            </tr>
_EOF

for($index = 0 ; $entry = $mesg->entry($index) ; $index++ ) {
      my $attr;

      $content .= "<TR>";

      foreach $attr ($entry->attributes) {
        my $vals = $entry->get($attr);
        my $val;
        my $j = 0;

 #       print "$attr = @$vals<BR>";        

        if($attr eq "cn" || $attr eq "c" || $attr eq "mail")
        {
      
        foreach $val (@$vals) {
        $mail = $val if($attr eq "mail");
        $fullname = $val if($attr eq "cn");

          $val = qq!<a href="$val">$val</a>! if $val =~ /^https?:/;
         $val = qq!<a href="compose.pl?username=$username&pop3host=$pop3host&emailfrom=$val">$val</a>! if $val =~ /^(.*)\@(.*)+$/;
#         $val = qq!<a href="mailto:$val">$val</a>! if $val =~ /^[-\w]+\@[-.\w]+$/;
#          $val = qq!<a href="mailto:$val">$val</a>! if $val =~ /^(.*)+\@[-.\w]+$/;
#         $content .= "<TR>" if $j++;
          $content .= "<TD>" . $val . "</TD>\n";

                                }
        }
      
                                        }

$content .= "<TD><a 
href=\"ldap.pl?advanced=1&mail=$mail&fullname=$fullname&servername=$servername\">Advanced</a></TD></TR>\n";
    }

$content .= <<_EOF;
</table></td></tr></table><hr>
_EOF

# Count how many matches
$content .= "</BODY></TABLE>\n";

# Print result to browser
print $content;

exit;

        }
}

sub advanced    {

$content = <<_EOF;
   <table width="600" border="0" height="149">
      <tr>
        <td>
          <table cellpadding=3 cellspacing=0 border=0 width="600">
            <tr bgcolor="$primarycolor">
              <td width="478">Advanced Search</td>
              <td width="110">
                <div align="right"><font face=Arial size="-1">
<a href="ldap.pl"><b>Search Again</b></a></font></div>
              </td>
            </tr>
          </table>
          <table cellpadding=2 cellspacing=1 border=1 width="600">
_EOF

my $entry;
    my $index;

    for($index = 0 ; $entry = $mesg->entry($index) ; $index++ ) {
      my $attr;

#$content .= "<TR><TH COLSPAN=2><hr>&nbsp</TR>\n";

#      $content .= $index ? "<TR><TH COLSPAN=2><hr>&nbsp</TR>\n";
#                         : "<TABLE>";

      foreach $attr ($entry->attributes) {
        my $vals = $entry->get($attr);
        my $val;

        $content .= "<TR><TD align=right valign=top";
        $content .= " ROWSPAN=" . scalar(@$vals)
          if (@$vals > 1);
        $content .= ">" . $attr  . "&nbsp</TD>\n";

        my $j = 0;
        foreach $val (@$vals) {

          $$attr = $val;
          $val = qq!<a href="$val">$val</a>! if $val =~ /^https?:/;
          $val = qq!<a href="mailto:$val">$val</a>! if $val =~ /^[-\w]+\@[-.\w]+$/;
          $content .= "<TR>" if $j++;
          $content .= "<TD>" . $val . "</TD></TR>\n";
        }
      }
    }

    $content .= "</TABLE>" if $index;

$content .= <<_EOF;
<table cellpadding=3 cellspacing=0 border=0 width="600">
<tr bgcolor="$secondarycolor">
_EOF

$content .= "<td width=\"478\"><a href=\"map.pl?City=$l&State=$st\">Show Map</a></td>" if($l && $st);

$content .= <<_EOF;

              <td width="110">
                <div align="right"><font face=Arial size="-1">
<a href="lpad.pl"><b>Search
                  Again</b></a></font></div>
              </td>
            </tr>
          </table>
_EOF

    $content .= "<hr>";
    $content .= $index ? sprintf("%s Match%s found",$index, $index>1 ? "es" : "")
                       : "<B>No Matches found</B>";
    $content .= "</BODY>\n";
print $content;
exit;
               
 }

# Raw dump LPAD results
#foreach (sort keys $mesg) { print "$_ \n"; }
#foreach $v ($mesg->all_entries) { print $v, "\n<BR>"; }

# Get form vars user posted

sub formvars {

    my($self, $type) = @_;

    my($param,$value,@result);
    return 0 unless $self->param;
    foreach $param ($self->param) {
        $name=$self->escapeHTML($param);
        foreach $value ($self->param($param)) {
        $$name = $value;
        push(@$name, "$value") if($name eq "msgdelete");
        $myenv{$name} = $value;
    }
 }

}

sub blacklist   {

print "Sorry! Your query is incorrect. <a href=ldap.pl>Try again</a><BR>";
exit;
                }

sub printstart
{

print<<_EOF;
<center>
  <form method="post" action="ldap.pl">
<input type="hidden" name="newlogin" value="1">
    <table border=0 cellpadding=2 cellspacing=0 width="94%">
<TR><TD valign=top width="1%">

<table border=0 cellpadding=4 cellspacing=0>
<tr>
<td nowrap bgcolor ="$primarycolor"> <font face=arial><b>
Search for People</b></font></td></tr><tr><td align=right>
<table border=0 cellpadding=2 cellspacing=0>
<tr>

<b>First Name</b>
<input type=text name=FirstName size=22 value="">
</tr><tr>
<b>Last Name</b><br>
<INPUT TYPE=text NAME=LastName size=22 value="">
</tr>

<TR>
<b>Domain</b>
<font size="-1">(e.g. <i><b>yahoo</b>.com</i>)</font><br>
<input type=text name=Domain size=22 value="">
<B>LDAP Server</B><BR>
<select name="servername">
<option value="ldap.four11.com">lpad.four11.com
<option value="ldap.whowhere.com">lpad.whowhere.com
<option value="ldap.infospace.com">ldap.infospace.com
<option value="ldap.bigfoot.com">ldap.bigfoot.com
<option value="ldap.switchboard.com">ldap.switchboard.com
</select>
<input type="submit" value="Find!">
</td></tr>
</table>
<br></td></tr>
</table>
</TD>
<TD>&nbsp;</TD>
<TD valign=top width="100%">

<table border=0 cellpadding=4 cellspacing=0 width="100%">
<tr>
<td bgcolor="$secondarycolor"><font face="Arial">
<b>The most powerful LDAP client application!</b></font> </td>
            </tr>
            <tr> 
              <td valign=top>
<font face="arial">

<li>Search for people via any LDAP server
<li>Find peoples email, telephone and mailing addresses
<li>Simple and <b>advanced</b> search options
<li>Find driving instructions and full colour maps of addresses
<li>Support to block blacklisted search querys
<li>Fast and slick code with HTML templates
                </ul>
                </font></td>
            </tr></table>
</td></tr></table>
</form>
</center>
</body>
</html>
_EOF
}
