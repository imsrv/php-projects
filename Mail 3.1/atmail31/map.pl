#!/usr/bin/perl
use LWP::Simple;

# Find current working directory and load library modules
use FindBin qw($Bin);
use lib "$Bin/libs";

use Net::LDAP;
use IO::Select;
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

require 'Common.pm';

&config;
&htmlheader("Map Search");

&getmap;
exit;

sub getmap
        {

$mapurl = "http://maps.yahoo.com/py/maps.py?city=$City&state=$State";

#my $mapurl = "http://maps.yahoo.com/py/maps.py?city=$city&state=$state";

$content = get($mapurl);

$content =~ /<input type="image" value="map" name="map" (.*)ismap>/sm;
$map = $1;
$map =~ /src="(.*)" WIDTH="400"/sm;
$mapurl = $1;

#print $mapurl;

$City =~ s/ //g;
$State =~ s/ //g;

if(!-e "$Bin/imgs/$City$State.gif") {
getstore($mapurl,"$Bin/imgs/$City$State.gif");
$newmap=1;
}

print<<_EOF;
<body bgcolor=white>
<Font size=+2>Map results for $City, $State - $Country</font><BR>
<img src="imgs/$City$State.gif">
<HR>
_EOF

#print "<BR><B>New Map from network</B>" if($newmap);
#print "<BR><B>Cached Map from network</B>" if(!$newmap);

        }

sub formvars {                                                                 
    
    my($self, $type) = @_;
                                                                     
    my($param,$value,@result);                                         
    return 0 unless $self->param;
    foreach $param ($self->param) {                            
        $name=$self->escapeHTML($param);
        foreach $value ($self->param($param)) {     
        $$name = $value; 
    }                                
 }                                               
}
