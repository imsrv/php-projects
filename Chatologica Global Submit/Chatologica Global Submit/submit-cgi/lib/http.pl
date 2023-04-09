#########################################################################################
# Chatologica http.pl - http connection library
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
#
#  PURPOSE: downloading an html page from an URL.
#	    Versions with 2 as suffix honour redirection.
#
#  USAGE:
#
#  in list context:
#  ($page,$error,$header,$bytes) = &HTTP($remote_path, $host, $port, $method, $timeout,
#					 $vars, $cookie, $submit);
#  # HTTP version that honour redirection:
#  ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) =
#  &HTTP2($remote_path, $host, $port, $method, $timeout, $vars, $cookie, $submit);
#
#  ($page,$error,$header,$bytes) = &get_URL($url, $timeout, $cookie, $submit);
#  ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) =
#  &get_URL2($url, $timeout, $cookie, $submit);		# honour redirection
#  # $URL is the redirected URL
#  # $bytes is the number of bytes received
#  # $content or $page is the downloaded content without header lines
#  # $content1 is content of the redirected target
#
#  in scalar context:
#  $page = &HTTP($remote_path, $host, $port, $method, $timeout, $vars, $cookie, $submit);
#  $page = &get_URL($url, $timeout, $cookie, $submit);
#
#  If $submit is not empty we just get the header and do not download the rest of response,
#  thus saving network resources.
#
#
#  EXAMPLES:
#
#  $page = &HTTP('/index.cgi', 'www.yahoo.com', 80, 'GET', 60, 'test=on&all=1',1);
#  $page = &HTTP('/blue.cgi', 'ink.yahoo.com', 80, 'POST', 3, 'set=on&r=1',
#		'cook1=mmm; cook2=nnn');
#  $page = &get_URL('http://www.yahoo.com/cgi-bin/text.cgi?haha=hello',10);
#  ($page,$error,$header,$bytes) = &HTTP('/', 'www.yahoo.com', 80, 'GET', 60);
#  ($page,$error,$header,$bytes) = &get_URL('http://www.yahoo.com/',10,'');
#  ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) =
#  &HTTP2('/', 'www.infoseek.com', 80, 'GET', 60);
#  
#########################################################################################

use strict;			# load the strict pragma
use Socket;			# load the Socket library
my $PROTOCOL = getprotobyname('tcp');		# set the protocol number outside any procedures
$PROTOCOL = 6 unless ($PROTOCOL =~ /^\d+$/);    # because getprotobyname leaks memory (bug!!)
                                                # meanwhile inet_aton and gethostbyname leaks memory
						# too (virtual domains in off-line mode at least)


sub get_URL		# a simplier variant of the HTTP procedure
{			# we provide only URL, timeout threshold and the cookies(if any)
    my($url, $timeout, $cookie, $submit) = @_;
    my($page, $err, $header, $bytes) = ();
    if(!$url) { return '';};				# if no URL - return empty value
    my($remote_path, $host, $port, $vars) = &parse_URL($url);
    ($page, $err, $header, $bytes) = &HTTP($remote_path, $host, $port, 'GET', $timeout, $vars, $cookie, $submit);
    if(wantarray) {
     	return ($page, $err, $header, $bytes);
    } else {
     	return $page;
    };
};



sub get_URL2		# like &get_URL but checks if there is redirection request
{			# and if yes gets the content of redirected page
    my($url, $timeout, $cookie, $submit) = @_;
    if(!$url) { return '';};				# if no URL - return empty value
    my($remote_path, $host, $port, $vars) = &parse_URL($url);
    my ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) = 
	&HTTP2($remote_path, $host, $port, 'GET', $timeout, $vars, $cookie, $submit);
    if(wantarray) {
     	return ($URL, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1);
    } else {
     	if($content1) {
	    return $content1;
	};
	return $content;	# the context expects scalar returned
    };
};



sub HTTP2		# like &HTTP but checks if there is a redirection request
{ 			# and if yes gets the content of redirected page
    my($remote_path, $host, $port, $method, $timeout, $vars, $cookie, $submit) = @_;
    my ($content, $err, $header, $bytes) = 
   	&HTTP($remote_path, $host, $port, $method, $timeout, $vars, $cookie, $submit);
    my ($content1, $err1, $header1, $bytes1, $url) = ();
    if($header =~ m/(Object moved|Moved tempo|302 Found).*Location: /is ) {
	$url = 'redirection';
    };
    if(wantarray) {				# the context expects list returned
	return ($url, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1);
    } else {
	if($content1) {
	    return $content1;
	};
	return $content;	# the context expects scalar returned
    };
};



sub HTTP			# send an HTTP request over network and wait for result
{ 
    my($remote_path, $host, $port, $method, $timeout, $vars, $cookie, $submit) = @_;
    my(	$content, 		# content of the downloaded stuff
	$content_length,	# the Content-length: value
	$header,		# HTTP header of the downloaded stuff		
	$err,			# error message
	$url,			# full URL of the item   http://.....
	$uri,			# requested URI - the path after the domain name
	$cookie_tag,		# "Cookie: cookie_name=cookie_value" cookie header line
	$request,		# the http request header text
	$x, 			# index where the header delimiters starts
	$split_length,		# length of the delimiters (new lines/carriage returns)
	$ipaddress, 		# remote IP address
	$packconnectip,		# packed address to connect
	$packthishostip,	# packed address of this host	
	$local_buffer,		# local buffer where we read the socket in
	$length,		# how many bytes were read from the socket in one pass
	$rin, 			# Read Input variable
	$rout, 			# Read Output variable
	$nfound, 		# is there something for read
	$read_finished,		# the download process has finished successfully
	$bytes,			# total bytes read successfully	
	$start_time,		# the time when this subroutine starts
	$end_time		# when to timeout this subroutine
    ) = ();
    $start_time = time;			# the time now
    $end_time = $start_time + $timeout;	# the time when we'll timeout this task
    if($port !~ /^\d+$/) {
	$port = 80;			# set default port 80 if not entered
    };
    if($method !~ /get|post/i) {
	$method = 'GET';		# set default http method GET if not entered
    };
    $bytes = 0; 			# so far nothing was read
    $content = '';
    $err = '';
    eval {
    	local $SIG{ALRM} = sub { die "alarm timeout" };	# alarm handler definition	
    	eval{alarm $timeout;};  				# start the alarm clock for $timeout seconds
    	$ipaddress = undef;
    	if ($host) {
    	    $ipaddress = inet_aton($host);			# trying to get the host IP address and pack
    	} else {
	    $err = "Invalid host name: empty value";
	    eval{alarm 0;}; return;
    	};		
    	if(!(defined $ipaddress)) {				# couldn't resolve the host name
	    $err = "Couldn't resolve IP address for host: $host";
	    eval{alarm 0;}; return;
    	};
        $packconnectip = sockaddr_in($port, $ipaddress);	# pack the remote address
        $packthishostip = sockaddr_in(0, INADDR_ANY);	# pack the local address
        if(!(socket(S, AF_INET, SOCK_STREAM, $PROTOCOL))) {  	# Can't make socket							
            $err = "Can't make socket: $!";
	    eval{alarm 0;}; return;
    	};
    	if(!(bind(S,$packthishostip))) {		# Can't bind the socket to the local host.
	    $err = "Can't bind: $!";
	    eval{alarm 0;}; return;
    	};
        if(!(connect(S, $packconnectip))){		# Can't connect the socket to the remote host.
    	    $err = "Can't connect socket: $!";	
	    eval{alarm 0;}; return;
    	};
    	select(S);				# select the socket
    	$| = 1; 				# turn off the output buffering for this socket
    	select (STDOUT);			# return to the standard output
    	$cookie_tag = '';
    	if($cookie) {					# cookies will be sent
	    $cookie_tag = "\nCookie: $cookie";		# what we add to the header
    	};
    	if($method =~ m/GET/i) { 			# if GET http method
    	    if($vars) {
	        $uri = "$remote_path" . "?$vars";
    	    } else {
	    	$uri = $remote_path;
    	    };
    	    $request = <<"__END_OF_SOCKET__";		# make GET request header
GET $uri HTTP/1.0
Host: $host\:$port
User-Agent: Mozilla/1.0$cookie_tag

__END_OF_SOCKET__
    } else {						# if POST http method
	$content_length = length($vars);		# content length
	$request = <<"__END_OF_SOCKET__";		# make POST request header
POST $remote_path HTTP/1.0
Host: $host\:$port
User-Agent: Mozilla/1.0
Content-type: application/x-www-form-urlencoded
Content-length: $content_length$cookie_tag

$vars
__END_OF_SOCKET__
    	};
    	$request =~ s/\r\n/\0/g;		# Translate all \r\n and \n to 		
    	$request =~ s/\n/\0/g;			# the standard internet terminator:\015\012
    	$request =~ s/\0/\015\012/g;		# \r\n is not always \015\012 (as on Mac platform)
    	print S $request;			# send the request through network
	$rin = '';                              # Read Input Variable
    	vec($rin, fileno(S), 1) = 1;		# Set $rin to be a vector of the socket file handle
	my $buffer_size = 2048;			# 2KB is the standard buffer size
	if($submit) {
	   $buffer_size = 600;			# reduced buffer size if we get the headers only
	};
    	while (($end_time > time) && (!$read_finished)) {	# Loop until we time out    	
            $nfound = select($rout=$rin,undef,undef,0.01);	# The following polls to see
						# if there is anything in the input
						# buffer to read. If there is, we will 
						# later call the sysread routine.
            if ($nfound > 0) {	# If we found something in the read socket, we should
				# get it using sysread.
	     	$local_buffer = '';				# clean up the local buffer
             	$length = sysread(S, $local_buffer, $buffer_size);	# read buffer				
       	     	if ($length > 0) {				# there is something read
            	    $content .= $local_buffer;		# add buffer to content
		    $bytes += $length;			# how many bytes read so far
		    if($submit) {			# if have to submit - get headers only
		    	if($content =~ m/(\015\012\015\012|\r\n\r\n|\n\n)/) {
			    $read_finished = 1;
			};
		    };
             	} else {
		    $read_finished = 1;			# we have read everything
  	     	};
            };
    	};    						
    	if(($end_time <= time) && !$read_finished) {    # set timeout error
	    $err = "timeout";
    	};
    	eval{alarm 0;};					# cancel the alarm clock
    };
    close S;						# close connection
    if ($@ =~ /alarm timeout/) { 			# alarm() has triggered timeout
	$err = "timeout";
    };
    # Splitting the read content on header and actual content body.
    # Different Web Servers use different delimiters sometimes (like \r\n\r\n or \n\n).
    # The legal HTTP delimiter is \015\012\015\012
    $x = index($content, "\015\012\015\012");	# find the standard HTTP delimiter
    $split_length = 4;
    if ($x == -1) {
	$x = index($content, "\r\n\r\n");	# check if new lines with carriage returns
    }
    if ($x == -1) {				
	$x = index($content, "\n\n");		# check if plain new lines
	$split_length = 2;
    };
    if ($x > -1) {				# spliting the header and content
 	$header = substr($content,0,$x+1);
        $content = substr($content,$x + $split_length);	
    };
    # if standard delimiter is not found we do not return header but only the content.
    if(wantarray) {				# the context expects list returned
     	return ($content, $err, $header, $bytes);
    } else {					# the context expects scalar returned
     	return $content;
    };
};



sub make_URL			# make an URL from its components: remote_path, 
{				# host, port, ...
    my($remote_path, $host, $port, $vars) = @_; # $vars and $port are optional
    if($vars) {
      	$vars = "?$vars"; 		# if we pass parameters we will need ? sign
    };
    if(($port == 80) || (!$port)) {
      	return "http://$host$remote_path$vars";
    } else {
      	return "http://$host:$port$remote_path$vars";
    };
};



sub parse_URL		# extracts a remote_path, host, port and the variables from an URL
{
    my($url) = @_;
    my($remote_path, $host, $port, $vars) = ('/','',80,'');
    $url =~ s/\s//g;			# remove white spaces
    if($url !~ m{^http://}i) {		# each http url must start with http://
	$url = 'http://' . $url;
    };
    if($url =~ m{http://([^/]+)$}i) {
	$host = $1;
    };
    if($url =~ m{http://([^/]+)(/.*)$}i) {
	$host = $1; $remote_path = $2;
	if($remote_path =~ m{^(.+)\?(.*)$}) {
 	    $remote_path = $1; $vars = $2;
	};
    };
    if($host =~ m{^(.+):(\d+)$}) {
	$host = $1; $port = $2;
    };
    return ($remote_path, $host, $port, $vars);
}



sub variables_encode		# URL-encode the variables/values being passed to net
{
    my($variables) = @_;		# hash of variable/value pairs
    my($var, @pairs) = ();
    foreach $var (keys %$variables) {
       push @pairs, (&URLencode($var) . "=" . &URLencode($$variables{$var}));
    };
    return join('&',@pairs);
};



1; # this library must return TRUE

