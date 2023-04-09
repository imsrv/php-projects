#!/usr/bin/perl
# --------------------------------------------------------------------
#
#                         MailChek Version 2.00
#                          Attachment processor
#                          Supplied by  Virus
#                          Nullified by CyKuH
#
# Copyright  ©2001-2002 Chez Surette Art, All Rights Reserved
#
# Installation or use of this software constitutes acceptance of the
# terms of the Licence agreement contained in the accompanying file
# 'Licence.txt'. This agreement is a legal contract, which specifies
# the terms of the license and warranty limitation between you and
# Chez Surette Art. Please read carefully the terms and conditions
# contained in the Licence before installing or using this software.
# Unless you have a different License agreement with Chez Surette Art,
# installation or use of this software signifies your acceptance of
# the License agreement and warranty limitation terms contained therein.
# If you do not agree to the terms of the agreement, promptly delete
# and destroy all copies of this software.
#
#    Filename : attach.cgi (standard version)
# --------------------------------------------------------------------

###############################  attach.cgi  #########################
#
#  This script processes email attachmants such as: text and html files;
#  images, audio and video files and any other files tramsmitted with
#  Base64 encoding; and others. The output is printed directly into the
#  email message display and may consist of a link to the attachment.
#
######################################################################

use MIME::Base64;
require 'mailchek.cfg';
require 'cookie.lib';
require 'mailchek.lib';

print "Content-type: text/html\n\n";

@pairs = split(/\&/, $ENV{'QUERY_STRING'});

foreach $pair (@pairs)   {
($name, $value) = split(/=/,$pair);
push (@data,$name);
push (@data, $value);
}
%form=@data;

# ****** VARIABLES *********
my $MID = $form{'MID'};
my $start_attach_line =  $form{'sal'};  # This is the line number the attachment starts at
my $end_attach_line =  $form{'eal'};  # This is the line number the attachment ends at
my $user = &get_User;

unless ($start_attach_line and $end_attach_line and $MID) {
    exit;
}

my $user_path="$tempdir/$user";
unless (open (MESSAGE,"<$user_path/$MID"))  {
   print "Could not open $user_path/$MID. $!";
   exit;
}

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