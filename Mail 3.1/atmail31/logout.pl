#!/usr/bin/perl
# Logout

# @Mail library configuration
use CGI qw(:standard);
use CGI::Carp qw(fatalsToBrowser carpout);

# Find cwd and set to library path
use FindBin qw($Bin);
use lib "$Bin/libs";

do "$Bin/atmail.conf";
do "$Bin/html/header.phtml";
do "$Bin/html/footer.phtml";
do "$Bin/html/javascript.js";

require 'Common.pm';

&config;
&javascript;
&htmlheader("Logged out");
&logout;
&htmlend;
exit;

sub logout      {
print<<_EOF;
<b>Successfully logged off!</b><HR>
<a href="index.html">Click here</a> to login as a new user.
_EOF
                }

