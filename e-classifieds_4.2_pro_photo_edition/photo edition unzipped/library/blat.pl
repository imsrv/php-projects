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

########################################################
# This mail libary was created for use with 
# blat version 1.4 for Windows NT. 
# Blat can be found at : http://gepasi.dbs.aber.ac.uk/softw/Blat.html
########################################################

sub send_message {
    local($from, $to, $subject, $messagebody) = @_;

   BEGIN{ srand $$.time }
   do {$temp_file  = "$temp_dir/".
  int (rand(1000000)).".file"} until (!-e $temp_file);

   open (TEMP, ">$temp_file") ||
     &web_error("Could not write temp-file");
   print TEMP "$messagebody";
   close TEMP;

 system("$location_of_mail_program $temp_file -s \"$subject\" -t $to -f $from");

 unlink $temp_file;

## This is an alternative way of calling Blat just in case the code
## above doesn't work for some reason.

## Open blat and send the pertinent information 
## to the command line. Other commands that are available :
##
## -s - - the subject
## -t - - e-mail address that the message should be sent to
## -f - - overrides default sender address, must be known to smtp server.
## -i - - a "from" address, not neccessarily known to smtp server.
## -c - - carbon copy recipient list (comma separated)
## -b - - blind carbon copy recipient list (comma separated)
## -server - - overrides the default SMTP server to be used. 
##
## The first '-' tells blat that we will be sending the contents of STDIN
## This is the $messagebody.

## Uncomment the lines below to use this alternative routine.

# $blat_mail_program = "$location_of_mail_program - -t $to -i $from -s $subject";

# open (MAIL, "|$blat_mail_program") || 
# &web_error("$blat_mail_error_message");

# print MAIL "$messagebody";

# close (MAIL);

} #end of blat_mail

sub web_error {
    local ($error) = @_;
    print "$error<p>\n";
    die $error;
}

1;