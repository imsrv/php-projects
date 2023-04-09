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

sub real_send_mail {
    local($fromuser, $fromsmtp, $touser, $tosmtp, 
      $subject, $messagebody) = @_;

    open (MAIL, "|$send_mail_program") || 
	&web_error("$unix_mail_error_message");

    print MAIL <<__END_OF_MAIL__;
To: $touser
From: $fromuser
Subject: $subject

$messagebody

__END_OF_MAIL__

    close (MAIL);

} 

sub send_message {

    local($from, $to, $subject, $messagebody) = @_;

    local($fromuser, $fromsmtp, $touser, $tosmtp);

if ($block_sendmail_aliasing eq "on") {
$mail_aliasing_tag = "-n";
}

$send_mail_program = "$location_of_mail_program -t $mail_aliasing_tag";

    $fromuser = $from;
    $touser = $to;

    $fromsmtp = (split(/\@/,$from))[1];
    $tosmtp = (split(/\@/,$to))[1];

    &real_send_mail($fromuser, $fromsmtp, $touser, 
           $tosmtp, $subject, $messagebody);

} 

sub web_error {
    local ($error) = @_;
    print "$error<p>\n";
    die $error;
}

1;