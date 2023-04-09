#####################################################################
# e-Classifieds(TM)
# Copyright © Hagen Software Inc. All rights reserved.
#
# By purchasing, installing, copying, downloading, accessing or otherwise
# using the SOFTWARE PRODUCT, or by viewing, copying, creating derivative
# works from, appropriating, or otherwise altering all or any part of its
# source code (including this notice), you agree to be bound by the terms
# of the EULA that accompanied this product, as amended from time to time
# by Hagen Software Inc.  The EULA can also be viewed online at
# "http://www.e-classifieds.net/support/license.html"
#####################################################################

sub send_message {

use Socket;

&smtp_send_mail;

sub smtp_real_send_mail {
    local($fromuser, $fromsmtp, $touser, $tosmtp, 
	  $subject, $messagebody) = @_;
    local($ipaddress, $fullipaddress, $packconnectip);
    local($packthishostip);
    local($AF_INET, $SOCK_STREAM, $SOCK_ADDR);
    local($PROTOCOL, $SMTP_PORT);
    local($buf);
    $messagebody = "Subject: $subject\n\n" . $messagebody;

    $AF_INET = AF_INET;
    $SOCK_STREAM = SOCK_STREAM;

    $SOCK_ADDR = "S n a4 x8";

    $PROTOCOL = (getprotobyname('tcp'))[2];
    $SMTP_PORT = (getservbyname('smtp','tcp'))[2];

    $SMTP_PORT = 25 unless ($SMTP_PORT =~ /^\d+$/);
    $PROTOCOL = 6 unless ($PROTOCOL =~ /^\d+$/);

    $ipaddress = (gethostbyname($location_of_mail_program))[4];

    $fullipaddress = join (".", unpack("C4", $ipaddress));

    $packconnectip = pack($SOCK_ADDR, $AF_INET, 
		   $SMTP_PORT, $ipaddress);
    $packthishostip = pack($SOCK_ADDR, 
			 $AF_INET, 0, "\0\0\0\0");

    socket (S, $AF_INET, $SOCK_STREAM, $PROTOCOL) || 
	&web_error( "Can't make socket:$!\n");

    bind (S,$packthishostip) || 
	&web_error( "Can't bind:$!\n");
    connect(S, $packconnectip) || 
	&web_error( "Can't connect socket:$!\n");

    select(S);
    $| = 1;
    select (STDOUT);

    $buf = read_sock(S, 60);

    print S "HELO $fromsmtp\n";

    $buf = read_sock(S, 60);

    print S "MAIL From:<$fromuser>\n";
    $buf = read_sock(S, 60);

    print S "RCPT To:<$touser>\n";
    $buf = read_sock(S, 60);

    print S "DATA\n";
    $buf = read_sock(S, 60);

    print S $messagebody . "\n";

    print S ".\n";
    $buf = read_sock(S, 60);

    print S "QUIT\n";

    close S;

} 

sub smtp_send_mail
{
local($from, $to, $subject, $messagebody) = @_;

local($fromuser, $fromsmtp, $touser, $tosmtp);

$fromuser = $from;
$touser = $to;

$fromsmtp = (split(/\@/,$from))[1];
$tosmtp = (split(/\@/,$to))[1];

&smtp_real_send_mail($fromuser, $fromsmtp, $touser, 
           $tosmtp, $subject, $messagebody);

} 

sub read_sock {
    local($handle, $endtime) = @_;
    local($localbuf,$buf);
    local($rin,$rout,$nfound);

    $endtime += time;

    $buf = "";

    $rin = '';
    vec($rin, fileno($handle), 1) = 1;

    $nfound = 0;

read_socket: 
while (($endtime > time) && ($nfound <= 0)) {
    $length = 1024;
    $localbuf = " " x 1025;
    $nfound = 1;
    if ($os ne "nt") {
	$nfound = select($rout=$rin, undef, undef,.2);
	    }
}
	
    if ($nfound > 0) {
	$length = sysread($handle, $localbuf, 1024);
	if ($length > 0) {
	    $buf .= $localbuf;
	    }
    }

$buf;
}

} 

sub web_error {
    local ($error) = @_;
    print "$error<p>\n";
    die $error;
}

1;