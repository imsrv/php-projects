#!/usr/bin/perl

$myouturl="http://mydomain.com/out.php";

$cooki = $ENV{'HTTP_COOKIE'};
$b =  $ENV{"QUERY_STRING"};


$outurl=$myouturl . "?" . $b;



if ($cooki=~m/drocher/) {
	# ok this drocher with cookie on
print "Location: $outurl\n\n";
exit;
}
else {
	# fuck off 

print "Location: http://www.ruspussies.net/archive\n\n";
exit;
}
1;