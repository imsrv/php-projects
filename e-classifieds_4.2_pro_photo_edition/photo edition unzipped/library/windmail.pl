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

##############################################################################
# This mail subroutine is designed to work with the Windmail 3.0 program
# created by GeoCel, International.  You can download an evaluation copy of
# WindMail 3.0 at the following URL:
# 
#       http://www.geocel.com/download/wmail301e.exe 
##############################################################################

sub send_message {

# Define Variables  
#        Detailed Information Found In README File.
# 
# $mailprog defines the location of your WindMail program on your Windows NT
# system.  Make sure you have permissions to execute WindMail in the
# specified directory.  Be sure to escape (\) any \ characters
# (ie. $mailprog = 'c:\\cgi-bin\\windmail.exe') 

# $location_of_mail_program = 'E:\\windmail\\windmail.exe';

# $tempdir defines the location of the temporary directory to which the 
# Web Server user must have read and write access.  If you are running on
# NTFS, this is especially important.
# Note that this is a directory used to store the mailing information for
# each message and is not related to the 
# temporary directory used by WindMail.
# Do NOT add the trailing slash at the end of this directory name.

$windmail_temp_dir = "$path/temp";

# If $kill_windmail_tempfile is 1, the temporary file created by the program will 
# be automatically deleted.  You should leave this set to 1 unless you are      #
# debugging and need to see the contents of the temporary file.  In this     #
# case, set the value to 0.						     #

$kill_windmail_tempfile = 1;

# If you are running under Microsoft IIS, or any other server which uses     #
# NPH-CGI for Perl CGIs, uncomment the next line.                            #

# $IIS_MODE = 1;

    local($from, $to, $subject, $messagebody) = @_;

    # Output a temporary file

    $windmail_tempfile = GetWindmailTempFileName($windmail_temp_dir, "WM");

    open(MAIL,">$windmail_tempfile") || &web_error("$windmail_tempfile_error_message"); 

    print MAIL "To: $to\n";
    print MAIL "From: $from\n";
    print MAIL "Subject: $subject\n\n";
    print MAIL "$messagebody\n";

    close (MAIL);
 
	# Note that -t is repeated;  this is necessary for some implementations of
	# Perl that do not correctly send the program name as the first argument.
	# Other implementations of Perl which send the arguments correctly are not
	# affected and this should therefore not be modified.

#	system("\"$location_of_mail_program\" -t -t -n $windmail_tempfile") || &web_error("$windmail_program_error_message"); 

	system("\"$location_of_mail_program\" -t -t -n $windmail_tempfile"); 

	if ($kill_windmail_tempfile)
	{
		unlink($windmail_tempfile);
	}

sub GetWindmailTempFileName {

	$windmail_path = $_[0];
	$windmail_prefix = $_[1];

	# Get a random number
	
	# First, seed the random number generator
	srand;

	# Then get a random # for which a file name can be created
	$done = 0;
	$windmail_tempfile = "";
	while (!$done)
	{
		$randNum = int(rand(999999));
		$windmail_tempfile = "$windmail_path/$windmail_prefix$randNum.tmp";
		open(TEMP, "<$windmail_tempfile") or $done = 1;
		close(TEMP);
	}
	
	return $windmail_tempfile;
}

} #end of windmail

sub web_error {
    local ($error) = @_;
    print "$error<p>\n";
    die $error;
}

1;