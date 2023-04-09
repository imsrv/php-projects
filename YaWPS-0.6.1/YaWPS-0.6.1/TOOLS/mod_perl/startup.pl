# Startup script for mod_perl.

use strict;

# Compile CGI.pm.
use CGI qw(-compile :all);

# Test if mod_perl is up and running.
$ENV{MOD_PERL} or die "Cannot preload YaWPS! $!";

# Include path to YaWPS (needs to be changed to the path of your YaWPS installation!).
use lib qw(/var/www/perl/yawps);

# Preload the YaWPS module.
use yawps;

1;
