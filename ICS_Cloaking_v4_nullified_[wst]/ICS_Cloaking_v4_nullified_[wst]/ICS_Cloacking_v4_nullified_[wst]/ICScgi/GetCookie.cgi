sub GetCookie {
#
#  PROGRAM:	GetCookie.cgi


################################
#  Create a new CGI object     #
################################

use CGI;
$query = new CGI;
$RetrievedCookie = $query->cookie('ICS');

if($RetrievedCookie =~ /1a3c579bbx2794xc5514d7f5f5c9/){ 
   $Auth = "OK"
   }
}
1;

