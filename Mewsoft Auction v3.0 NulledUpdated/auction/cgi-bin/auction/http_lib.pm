#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
=help CONSTANTS

The following constant functions can be used as mnemonic status code
names:

   RC_CONTINUE				(100)
   RC_SWITCHING_PROTOCOLS		(101)

   RC_OK				(200)
   RC_CREATED				(201)
   RC_ACCEPTED				(202)
   RC_NON_AUTHORITATIVE_INFORMATION	(203)
   RC_NO_CONTENT			(204)
   RC_RESET_CONTENT			(205)
   RC_PARTIAL_CONTENT			(206)

   RC_MULTIPLE_CHOICES			(300)
   RC_MOVED_PERMANENTLY			(301)
   RC_FOUND				(302)
   RC_SEE_OTHER				(303)
   RC_NOT_MODIFIED			(304)
   RC_USE_PROXY				(305)
   RC_TEMPORARY_REDIRECT		(307)

   RC_BAD_REQUEST			(400)
   RC_UNAUTHORIZED			(401)
   RC_PAYMENT_REQUIRED			(402)
   RC_FORBIDDEN				(403)
   RC_NOT_FOUND				(404)
   RC_METHOD_NOT_ALLOWED		(405)
   RC_NOT_ACCEPTABLE			(406)
   RC_PROXY_AUTHENTICATION_REQUIRED	(407)
   RC_REQUEST_TIMEOUT			(408)
   RC_CONFLICT				(409)
   RC_GONE				(410)
   RC_LENGTH_REQUIRED			(411)
   RC_PRECONDITION_FAILED		(412)
   RC_REQUEST_ENTITY_TOO_LARGE		(413)
   RC_REQUEST_URI_TOO_LARGE		(414)
   RC_UNSUPPORTED_MEDIA_TYPE		(415)
   RC_REQUEST_RANGE_NOT_SATISFIABLE     (416)
   RC_EXPECTATION_FAILED		(417)

   RC_INTERNAL_SERVER_ERROR		(500)
   RC_NOT_IMPLEMENTED			(501)
   RC_BAD_GATEWAY			(502)
   RC_SERVICE_UNAVAILABLE		(503)
   RC_GATEWAY_TIMEOUT			(504)
   RC_HTTP_VERSION_NOT_SUPPORTED	(505)

=cut
#==========================================================
my %StatusCode = (
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Large',
    415 => 'Unsupported Media Type',
    416 => 'Request Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
);

my $mnemonicCode = '';
my ($code, $message);
while (($code, $message) = each %StatusCode) {
    # create mnemonic subroutines
    $message =~ tr/a-z \-/A-Z__/;
    $mnemonicCode .= "sub RC_$message () { $code }\t";
    # make them exportable
    $mnemonicCode .= "push(\@EXPORT, 'RC_$message');\n";
}
# warn $mnemonicCode; # for development
eval $mnemonicCode; # only one eval for speed
die if $@;

# backwards compatibility
*RC_MOVED_TEMPORARILY = \&RC_FOUND;  # 302 was renamed in the standard
push(@EXPORT, "RC_MOVED_TEMPORARILY");
#==========================================================
sub Status_Message ($){$StatusCode{$_[0]};}
#==========================================================
#$Out=&LWP_Simple("https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/auction/auction.cgi?action=Sign_in&Lang=English");
#$Out=&LWP_UserAgent("https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/auction/auction.cgi?action=Sign_in&Lang=English");
#$Out=&Net_SSLeay("https://www.safeweb.com/o/_i:http://www.mewsoft.com", "/cgi-bin/auction/auction.cgi?action=Sign_in&Lang=English");
#$Out=&HTTP_Post("https://www.safeweb.com/o/_i:mewsoft.com", "/cgi-bin/auction/auction.cgi","action=Sign_in&Lang=English");
#$Out=&HTTP_Get("https://www.safeweb.com/o/_i:mewsoft.com", "/cgi-bin/auction/auction.cgi","action=Sign_in&Lang=English");
#$Global{'Web_Server_Connection'} = "LWP_Simple";
#$Global{'Web_Server_Connection'} = "LWP_UserAgent";
#$Global{'Web_Server_Connection'} = "Net_SSLeay";
#$Global{'Web_Server_Connection'} = "Socket";
#$Out=&Web_Server("https://www.safeweb.com/o/_i:http://mewsoft.com", "/cgi-bin/auction/auction.cgi","action=Sign_in&Lang=English");
#print $Out;
#exit 0;
#==========================================================
sub Web_Server{
my($Domain, $URL, $Form_Param) = @_;
my($Full_URL, $Response, $Code, $Status, $Header);

	if (!$Form_Param) {
		$Full_URL=$Domain . $URL;
	}
	else{
		$Full_URL=$Domain . $URL . "?". $Form_Param;
	}

	if ($Global{'Web_Server_Connection'} eq "LWP_Simple") {
				eval "use LWP::Simple";
				if ($@) { die ("Couldn't Load LWP::Simple: $@");}
				$Response=&LWP_Simple($Full_URL);
	}
	elsif ($Global{'Web_Server_Connection'} eq "LWP_UserAgent") {
				eval "use LWP::UserAgent";
				if ($@) { die ("Couldn't Load LWP::UserAgent: $@");}
				$Response = &LWP_UserAgent($Domain . $URL, $Form_Param, $Method);
	}
	elsif ($Global{'Web_Server_Connection'} eq "LWP_UserAgent_With_Header") {
				eval "use LWP::UserAgent";
				if ($@) { die ("Couldn't Load LWP::UserAgent: $@");}
				$Response = &LWP_UserAgent_With_Header($Domain . $URL, $Form_Param, $Method);
	}
	elsif ($Global{'Web_Server_Connection'} eq "Net_SSLeay") {
				eval "use Net::SSLeay";
				if ($@) { die ("Couldn't Load Net::SSLeay: $@"); }
				$Response=&Net_SSLeay($Domain, $URL, $Form_Param);
	}
	elsif ($Global{'Web_Server_Connection'} eq "Socket") {
				use Socket;
				#$Domain="https://www.safeweb.com/o/_i:http://mewsoft.com";$URL='/cgi-bin/auction/auction.cgi'; $Form_Param='';
				($Code, $Status, $Response)=&HTTP_Post($Domain.$URL, $Form_Param, "POST");
				#Code =302 for redirect url where Status=Moved and the Location: contains the new url
				if ($Code ne "200") {$Response = "";}
				($Header, $Response) = split("\r\n\r\n", $Response);
	}
	else{
				$Response="";
	}
	
	return $Response;
}
#==========================================================
sub LWP_Simple{
my($URL)=shift;
my($Content);

	$Content = get($URL);
	return $Content;
	
}
#==========================================================
sub Net_SSLeay {
my($Domain, $URL, $Form_Param) = @_;
my($Buffer);

	if ($Form_Param) {$URL .= "?" . $Form_Param;}

	$Buffer=Net::SSLeay::get_https("$Domain", 443, "$URL");

	return $Buffer;

}
#==========================================================
sub LWP_UserAgent_With_Header{ 
my($Target_URL, $Form_Param, $Method)=@_;
my($Request, $Response);
my($User_Agent, $Buffer);
		
		$Buffer="";
		$User_Agent = new LWP::UserAgent;
		$User_Agent->agent('Mozilla/4.0');
		$User_Agent->timeout(10);

		if (!$Method){$Method = "GET";}

		if($Method eq 'GET') {
				$Request = new HTTP::Request  GET=> "$Target_URL?$Form_Param";
		} else { 
				$Request = new HTTP::Request POST => "$Target_URL";
				$Request->content_type('application/x-www-form-urlencoded');
				$Request->content($Form_Param);
		}

		$Response = $User_Agent->request($Request);
		$Buffer=$Response->as_string; 

	return $Buffer; 
}
#==========================================================
sub LWP_UserAgent{ 
my($Target_URL, $Form_Param, $Method)=@_;
my($Request, $Response);
my($User_Agent, $Buffer);
		
		$Buffer="";
		$User_Agent = new LWP::UserAgent;
		$User_Agent->agent('Mozilla/4.0');
		$User_Agent->timeout(10);
		
		if (!$Method){$Method = "GET";}

		if ($Method eq 'GET') {
				$Request = new HTTP::Request  GET=> "$Target_URL?$Form_Param";
		} else { 
				$Request = new HTTP::Request POST => "$Target_URL";
				$Request->content_type('application/x-www-form-urlencoded');
				$Request->content($Form_Param);
		}

		$Response = $User_Agent->request($Request);
		if ($Response->is_success) {
			  $Buffer = $Response->content();
		} else {
			  $Buffer="";
		}

		return $Buffer; 
}
#==========================================================
sub SSL_Post {
my($remote, $script, $buffer)=@_;
my($Out);

#	$remote = "secure.authorize.net";
#	$script = "/gateway/transact.dll";

	use Socket;	

	$port = "80";
	$buffer =~ s/ /%20/g;

	$add = $buffer;
	$postlen = length($add);
	$msg = "POST $script HTTP/1.0\r\nContent-type: application/x-www-form-urlencoded\r\nContent-length: $postlen\r\n\r\n$add\r\n";
	$submit = "$msg";

	if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
	die "No port specified." unless $port;

	$iaddr   = inet_aton($remote)               || die "Could not find host: $remote"."<BR>Line ". __LINE__ . ", File ". __FILE__;
	$paddr   = sockaddr_in($port, $iaddr);
	$proto   = getprotobyname('tcp');

	socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__;
	connect(SOCK, $paddr)    || die "connect error: $!";

	send(SOCK,$submit,0);

	$Out="";
	while(<SOCK>) {
				while(<SOCK>) {         
						if ( /^[\r]??$/ )	{	    
								while (<SOCK>) {
											$Out.=$_;
								}
						}
				}
	}
	
	return $Out;
}
#==========================================================
sub HTTP_Post{
my ($URL, $Form_Params, $Method) = @_;
my($Time_out, $Start_Time, $Length, $Domain, $Sub_Domain);
my($Internet_Addr, $Paddr, $Port, $Proto, $Line, $Time_Now, $CRLF);
my($Temp, $Temp1, $Response, $Status_Code, $Status_Msg, $Size);

	$CRLF = "\015\012"; # how lines should be terminated; "\r\n" is not correct on all systems, for instance MacPerl defines it to "\012\015"

	if (!$Method) {$Method = "POST";}
    $Time_out = 10;
    $Start_Time=time;
    $Length = length($Form_Params);

    ($Domain, $Sub_Domain) = $URL =~ m|^https?://([^/]+)(.*)|;
    $Sub_Domain ||= '/';

	$Port = "80";
	if ($Port =~ /\D/) { $Port = getservbyname($Port, 'tcp');}
	$Proto = getprotobyname('tcp');
    socket(SOCK, PF_INET, SOCK_STREAM, $Proto);

    $Internet_Addr   = inet_aton($Domain) || return(700,"Invalid Domain: $Domain"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    $Paddr = sockaddr_in($Port, $Internet_Addr) || return(700,"Invalid Domain Address: $Domain"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    
	socket(SOCK, PF_INET, SOCK_STREAM, $Proto) || return (700,"Socket Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    connect(SOCK, $Paddr) || return (400,"Connect Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    
	select(SOCK);
	
	$|=1;

    select(STDOUT);
    
    print SOCK "$Method $Sub_Domain HTTP/1.0\n",'Host: ',$Domain,"\n";
    print SOCK "Content-Type: application/x-www-form-urlencoded\n"; 
    print SOCK "Content-Length: $Length\n\n";
    print SOCK "$Form_Params\n\n";

	$Response = ""; $Line="";
	while (defined($Line = <SOCK>)) { 
			   $Time_Now = time;
			   if (($Time_Now - $Start_Time) >= $Time_out ) { return(600,"Socket Read Timeout"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
			   $Response .= $Line; 
    }

	if (!$Response){return(500,"Connection Refused"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

    close (SOCK)  || return( 700,"Close Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

    ($Temp, $Temp1) = split(/\n/, $Response);

    ($Status_Code, $Status_Msg) = $Temp =~ m|http/1\.\d+\s+(\d+)\s+(.*)$|i; # $Status_Code=200 is = OK

    if ($Response =~ m|(content-length:)(\s+)(\d+)(\s+)(\n)|i) {$Size = $3;}

    if (!$Status_Code) {return (400,"Malformed Header"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
    #print "<br>Status_Code=$Status_Code<br>Status_Msg=$Status_Msg<br>$Response<br>";
	return ($Status_Code, $Status_Msg, $Response, $Size);
}
#==========================================================
sub HTTP_Get{
my ($URL, $Form_Params, $Method) = @_;
my($Time_out, $Start_Time, $Length, $Domain, $Sub_Domain);
my($Internet_Addr, $Paddr, $Port, $Proto, $Line, $Time_Now, $CRLF);
my($Temp, $Temp1, $Response, $Status_Code, $Status_Msg, $Size);

	$CRLF = "\015\012"; # how lines should be terminated; "\r\n" is not correct on all systems, for instance MacPerl defines it to "\012\015"

	if (!$Method) {$Method = "GET";}
    $Time_out = 10;
    $Start_Time=time;
    $Length = length($Form_Params);

    ($Domain, $Sub_Domain) = $URL =~ m|^https?://([^/]+)(.*)|;
    $Sub_Domain ||= '/';

	$Port = "80";
	if ($Port =~ /\D/) { $Port = getservbyname($Port, 'tcp');}
	$Proto = getprotobyname('tcp');
    socket(SOCK, PF_INET, SOCK_STREAM, $Proto);

    $Internet_Addr   = inet_aton($Domain) || return(700,"Invalid Domain : $Domain"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    $Paddr = sockaddr_in($Port, $Internet_Addr) || return(700,"Invalid Domain Address: $Domain"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    
	socket(SOCK, PF_INET, SOCK_STREAM, $Proto) || return (700,"Socket Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    connect(SOCK, $Paddr) || return (400,"Connect Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
    
	select(SOCK);
	
	$|=1;

    select(STDOUT);

	print SOCK "$Method $Sub_Domain HTTP/1.0\n",'Host: ',$Domain,"\n";
	 if ($ENV{'HTTP_USER_AGENT'}){ 
			print SOCK "User-Agent: $ENV{HTTP_USER_AGENT}\n";
	}
    print SOCK "\n";

	$Response = ""; $Line="";
	while (defined($Line = <SOCK>)) { 
			   $Time_Now = time;
			   if (($Time_Now - $Start_Time) >= $Time_out ) { return(600,"Socket Read Timeout"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
			   $Response .= $Line; 
    }

	if (!$Response){return(500,"Connection Refused!"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

    close (SOCK)  || return( 700,"Close Error: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

    ($Temp, $Temp1) = split(/\n/, $Response);

    ($Status_Code, $Status_Msg) = $Temp =~ m|http/1\.\d+\s+(\d+)\s+(.*)$|i; # $Status_Code=200 is = OK

    if ($Response =~ m|(content-length:)(\s+)(\d+)(\s+)(\n)|i) {$Size = $3;}

    if (!$Status_Code) {return (400,"Malformed Header"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
    #print "<br>Status_Code=$Status_Code<br>Status_Msg=$Status_Msg<br>$Response<br>";
	return ($Status_Code, $Status_Msg, $Response, $Size);
}
#==========================================================
sub X_get{
    my $url = shift;
    my $ret;
    if (!$FULL_LWP && $url =~ m,^http://([^/:]+)(?::(\d+))?(/\S*)?$,) {
	my $host = $1;
	my $port = $2 || 80;
	my $path = $3;
	$path = "/" unless defined($path);
	return _trivial_http_get($host, $port, $path);
    } else {
        _init_ua() unless $ua;
	my $request = HTTP::Request->new(GET => $url);
	my $response = $ua->request($request);
	return $response->is_success ? $response->content : undef;
    }
}
#==========================================================
sub X_trivial_http_get{
   my($host, $port, $path) = @_;
   #print "HOST=$host, PORT=$port, PATH=$path\n";

   require IO::Socket;
   local($^W) = 0;
   my $sock = IO::Socket::INET->new(PeerAddr => $host,
                                    PeerPort => $port,
                                    Proto    => 'tcp',
                                    Timeout  => 60) || return;
   $sock->autoflush;
   my $netloc = $host;
   $netloc .= ":$port" if $port != 80;
   print $sock join("\015\012" =>
                    "GET $path HTTP/1.0",
                    "Host: $netloc",
                    "User-Agent: lwp-trivial/$VERSION",
                    "", "");

   my $buf = "";
   my $n;
   1 while $n = sysread($sock, $buf, 8*1024, length($buf));
   return undef unless defined($n);

   if ($buf =~ m,^HTTP/\d+\.\d+\s+(\d+)[^\012]*\012,) {
       my $code = $1;
       #print "CODE=$code\n$buf\n";
       if ($code =~ /^30[1237]/ && $buf =~ /\012Location:\s*(\S+)/) {
           # redirect
           my $url = $1;
           return undef if $loop_check{$url}++;
           return _get($url);
       }
       return undef unless $code =~ /^2/;
       $buf =~ s/.+?\015?\012\015?\012//s;  # zap header
   }

   return $buf;
}
#==========================================================
1;
