# Version: 1.1 - 042902
#
#####################################################################
#                                                                   #
#    Copyright © 1999-2001 CGISCRIPT.NET - All Rights Reserved     #
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
###standard subs
###############standard subroutines#############


sub GetCookies{
$cookies = $ENV{'HTTP_COOKIE'};
@allcookies = split(/;\s*/,$cookies);
foreach $i (@allcookies){
  ($name,$value) = split(/\s*=\s*/,$i);
  $cookie{$name}=$value;
  }
}
1;

sub Escape{
foreach $i (keys %in){
  $in{$i} =~ s/'/''/g;
  }
}

sub UnEscape{
foreach $i (keys %in){
  $in{$i} =~ s/''/'/g;
  }
}
1;

sub cgierr {
# --------------------------------------------------------
# Displays any errors and prints out FORM and ENVIRONMENT
# information. Useful for debugging.

        if (!$html_headers_printed) {
                print "Content-type: text/plain\n\n";
                $html_headers_printed = 1;
        }
        print "<PRE>\nCGI Error: $!\n";
        print "Message: $_[0]\n\n";
        print "\n</PRE>";
        exit;
}
1;

sub PageOut{
local($file) = @_;
open(OUT,"$file")||print "$!: $file<br>";
while(<OUT>){
$_ =~ s/in\((\w+)\)/$in{$1}/g;
print;
}
close OUT;
}
1;

sub getdata{
local($usecgi)=@_;
if($usecgi){
use CGI;
$query = new CGI;
@names = $query->param;
foreach $i (@names){
  $in{$i} = $query->param("$i");
  }
}
else{
# Read in text
  if ($ENV{'REQUEST_METHOD'} eq "GET") {
    $in = $ENV{'QUERY_STRING'};
  } elsif ($ENV{'REQUEST_METHOD'} eq "POST") {
    for ($i = 0; $i < $ENV{'CONTENT_LENGTH'}; $i++) {
      $in .= getc;
    }
  }

  @in = split(/&/,$in);

  foreach $i (0 .. $#in) {
    # Convert plus's to spaces
    $in[$i] =~ s/\+/ /g;

    # Convert %XX from hex numbers to alphanumeric
    $in[$i] =~ s/%(..)/pack("c",hex($1))/ge;

    # Split into key and value.
    $loc = index($in[$i],"=");
    $key = substr($in[$i],0,$loc);
    $val = substr($in[$i],$loc+1);
    $in{$key} .= '\0' if (defined($in{$key})); # \0 is the multiple separator
    $in{$key} .= $val;
    }
}
($in{'database'} =~ /\|/)&&(&PError("Error. Invalid name"));
($in{'database'} =~ /\.\./)&&(&PError("Error. Invalid name"));
($in{'movedatabase'} =~ /\|/)&&(&PError("Error. Invalid name"));
($in{'movedatabase'} =~ /\.\./)&&(&PError("Error. Invalid name"));
($in{'newsdb'} =~ /\|/)&&(&PError("Error. Invalid name"));
($in{'newsdb'} =~ /\.\./)&&(&PError("Error. Invalid name"));
($in{'id'} =~ /\|/)&&(&PError("Error. Invalid name"));
($in{'id'} =~ /\.\./)&&(&PError("Error. Invalid name"));
($in{'file'} =~ /\|/)&&(&PError("Error. Invalid name"));
($in{'file'} =~ /\.\./)&&(&PError("Error. Invalid name"));
}

sub PError{
local($message,$c) = @_;
if($c){
print<<"EOF";
<body bgcolor=#C0C0C0>
<script language=javascript>
alert("$message");
window.close();
</script>
EOF

}
else{
print<<"EOF";
<body bgcolor=#C0C0C0>
<script language=javascript>
alert("$message");
history.back();
</script>
EOF

}
exit;
}
1;

sub escape{
local(*var) = @_;
$var =~ s/([^\w\s\n])/'&#'.ord($1).';'/ge;
}
1;

sub unescape{
local(*var) = @_;
$var =~ s/&#(\d+);/pack("c",$1)/ge;
}
1;

sub ctime {
    @DoW = ('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    @MoY = ('January','February','March','April','May','June',
            'July','August','September','October','November','December');

    local($time) = @_;
    local($[) = 0;
    local($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst);

    # Determine what time zone is in effect.
    # Use GMT if TZ is defined as null, local time if TZ undefined.
    # There's no portable way to find the system default timezone.

    $TZ = defined($ENV{'TZ'}) ? ( $ENV{'TZ'} ? $ENV{'TZ'} : 'GMT' ) : '';
    ($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $isdst) =
        ($TZ eq 'GMT') ? gmtime($time) : localtime($time);

    # Hack to deal with 'PST8PDT' format of TZ
    # Note that this can't deal with all the esoteric forms, but it
    # does recognize the most common: [:]STDoff[DST[off][,rule]]

    if($TZ=~/^([^:\d+\-,]{3,})([+-]?\d{1,2}(:\d{1,2}){0,2})([^\d+\-,]{3,})?/){
        $TZ = $isdst ? $4 : $1;
    }
    $TZ .= ' ' unless $TZ eq '';

    $year += 1900;
    #sprintf("%s %s %2d, %4d\n", $DoW[$wday], $MoY[$mon], $mday, $year);
    $mon++;
    return sprintf("%.2d-%.2d-%.4d",$mon,$mday,$year);
}
1;