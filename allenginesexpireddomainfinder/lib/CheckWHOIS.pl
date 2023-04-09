#!/usr/bin/perl
#############################################################
#############################################################
##        Aaron's All Engine Expired Domain Finder         ##
##                This is a Commercial Script              ##
##        Modification, Distribution or Resale without     ##
##        Prior written permission is in Violation of      ##
##        the copyrights and International Intellectual    ##
##        Property Laws.  Violators will be prosecuted!    ##
##        http://www.aaronscgi.com - aaron@aaronscgi.com   ##
#############################################################
#############################################################
#                                                           #
#             THE ONLY CHANGE THAT NEED BE MADE IS          #
#             THE PATH TO PERL AT THE TOP OF THIS           #
#             PAGE IF NEEDED.                               #
#                                                           #
#############################################################
#                                                           #
#            DO NOT EDIT ANYTHING BELOW THIS LINE           #
#                                                           #
#############################################################
use Socket;

sub CheckWHOIS {
    my @D = @_; my @expired;
    local $iaddr =  gethostbyname('whois.crsnic.net');
    for (@D) {push @expired, $_ if isExpired($_, $iaddr)};
    return @expired;
}

sub isExpired {
$DB::single=2;
    my $dom=$_[0];
    close(S);socket(S, AF_INET, SOCK_STREAM, getprotobyname('tcp'));
    connect(S, sockaddr_in("43",$_[1])) or die $!;
    syswrite(S, "$dom\n");
    my $res = join "", <S>;
    return $res =~/No match for/;
}

1;

