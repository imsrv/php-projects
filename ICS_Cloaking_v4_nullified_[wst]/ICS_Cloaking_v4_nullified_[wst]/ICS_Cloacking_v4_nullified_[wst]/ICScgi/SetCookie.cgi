sub SetCookie {
################################
#  Create a new CGI object     #
################################
use CGI;
$query = new CGI;

$cookie = $query->cookie(-name=>'ICS',
-value=>'1a3c579bbx2794xc5514d7f5f5c9',
-expires=>'+4h',
-path=>'/');


print $query->header(-cookie=>$cookie);

}
1;

