#!/usr/bin/perl

$fname="drocher";
$action="drocher";
$cotarget="cgi-bin/pt2.cgi";
&cookii;
print "Content-type: text/html\n\n";

print <<EOF;

some shit

EOF





sub cookii {

$timenow = time();
$cookieexpire = $timenow+86400;
&setcookie($fname, $action, $cookieexpire);
sub setcookie {
  local($name,$value,$expires) = @_;
    local(@days) = ("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
    local(@months) = ("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
  local($seconds,$min,$hour,$mday,$mon,$year,$wday) = gmtime($expires) if ($expires > 0); #get date info if expiration set.
  $seconds = "0" . $seconds if $seconds < 10; # formatting of date variables
  $min = "0" . $min if $min < 10; 
  $hour = "0" . $hour if $hour < 10; 
  if (! defined $expires) { $expires = " expires\=Fri, 31-Dec-1999 00:00:00 GMT;"; } # if expiration not set, expire at 12/31/1999
  elsif ($expires == -1) { $expires = "" } # if expiration set to -1, then eliminate expiration of cookie.
  else { 
    $year += 2000; 
    $expires = "expires\=$days[$wday], $mday-$months[$mon]-$year $hour:$min:$seconds GMT; "; #form expiration from value passed to function.
  }
print "Set-Cookie: ";
print ($name, "=", $value, "; $expires path =", "/$cotarget","\n");
}
}

1;

