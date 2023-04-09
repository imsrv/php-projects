#!/usr/bin/perl
# -----------------------------------------------------------------
#                     GroupMail Secure Version 2.00
#
#                       Process MIME attachments
#                          Supplied by  Virus
#                          Nullified by CyKuH
#    Filename : attach.cgi
# -------------------------------------------------------------------

use MIME::Base64;
require 'groupmail.lib';
require 'groupmail.cfg';

print "Content-type: text/html\n\n";
@pairs = split(/\&/, $ENV{'QUERY_STRING'});

foreach $pair (@pairs)   {
($name, $value) = split(/=/,$pair);
push (@data,$name);
push (@data, $value);
}
%form=@data;

# ****** VARIABLES *********
my $member = $form{'member'};
my $MID = $form{'MID'};
my $start_attach_line =  $form{'sal'};  # This is the line number the attachment starts at
my $end_attach_line =  $form{'eal'};  # This is the line number the attachment ends at

# ****** SET THESE VARIABLES *******
my ($dir_URL, $mailpath) = &Set_location;

unless ($start_attach_line and $end_attach_line and $MID) {
    exit;
}

my $user_path="$mailpath/$member";
&oops ("Could not open $user_path/$MID. $!") unless (open (MESSAGE,"<$user_path/$MID"));
my @message=<MESSAGE>;
close MESSAGE;
@message = splice(@message,$start_attach_line,$end_attach_line);   # Remove everything up to the attachment
my @attach_header;
while ($_ = shift @message) {
    if ($_ eq "\n") {
	last;
    }
    chop;
    push @attach_header,$_;
}
my %header = &Parse_header(\@attach_header);

if ($header{'content-transfer-encoding'} =~ /^base64/i) {
    foreach (@message) {
	print decode_base64($_);
    }
}
elsif ($header{'content-transfer-encoding'} =~ /^quoted_printable/i) {
    foreach (@message) {
	s/[ \t]+?(\r?\n)/$1/g;
	s/=\r?\n//g;
	s/=([\da-fA-F]{2})/pack("C",hex($1))/ge;
	print;
    }
}
else {
    foreach (@message) {
	print;
    }
}
1;