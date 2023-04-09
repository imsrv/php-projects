#########################################################################################
# Chatologica cgi-handler.pl - standard cgi input parsing tool
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
#	
#    USAGE:
#
#	&Parse_CGI_Input(\%in);
#	we pass a reference to the hash %in where will put the parsed data
#
#########################################################################################

use strict;



sub Parse_CGI_Input
{
    my($in) = @_;
    my $cgi_max_data = 131072;		# maximum bytes to accept via POST - 2^17
    my $type = $ENV{'CONTENT_TYPE'};		# Getting several useful ENV variables
    my $length  = $ENV{'CONTENT_LENGTH'};
    my $method = $ENV{'REQUEST_METHOD'};  
    if($length > $cgi_max_data) { 
	&CgiDie("cgi.pl: Request to receive too much data: $length bytes\n");
    };  
    if(!(!$method || $method =~ /GET|POST/i || $type eq 'application/x-www-form-urlencoded')) {
	&CgiDie("cgi.pl: Usupported request method: $method");
    };
    if($type =~ m{multipart/form-data}i) {
	&CgiDie("cgi.pl: Usupported content type: $type");
    };
    my $input = $ENV{'QUERY_STRING'};
    if($method =~ /POST/i) {
	read(STDIN, $input, $length);
    };
    my @params = split(/[&;]/, $input); 
    push(@params, @ARGV); 			# add command-line parameters
    my($i, $key, $val) = ();
    foreach $i (0..$#params) {	   
	$params[$i] =~ s/\+/ /g;     				# Convert plus to space      
	($key, $val) = split(/=/, $params[$i], 2);  		# Split into key and value      	   
	$key =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;	# Convert %XX from hex 
	$val =~ s/%([A-Fa-f0-9]{2})/pack("c",hex($1))/ge;	# numbers to alphanumeric
	$$in{$key} .= "\0" if (defined($$in{$key})); 		# \0 is the multiple separator
	$$in{$key} .= $val;	   				# Associate key and value
    };    
};



sub CgiDie
{
    my($err) = @_;
    print "Content-type: text/html\n\n$err";
    exit;
};



1; # this library must return true

