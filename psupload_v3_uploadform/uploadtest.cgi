#!/usr/bin/perl

#######################################################################################
#
#	PSUpload Library Test Script V3.0
#	©2000, Perl Services
#
#	Requirements:		UNIX Server, Perl5+, CGI.pm
#	Created:		September 22nd, 2000
#	Author: 		Jim Melanson
#	Contact:		www.perlservices.net
#				Phone:		1-877-751-5900, ext. 908
#				Fax:		1-208-694-1613
#				E-Mail:		info@perlservices.net
#
#
#	http://www.perlservices.net/en/programs/psupload/users_guide.shtml
#
#######################################################################################
#
#	To use this demonstration script, you must set the $Data variable as described
#	below. Once that is done, FTP this script and the upload.lib file to your
#	sites cgi-bin. Make sure you transfer these in ASCII format and not in Binary
#	format. Once uploaded, CHMOD the scripts to 755.
#

$Data = "/usr/home/name/hosts/path/to/directory";
    # On your server and in your web space, create a directory that this test script
    # can store the uploaded files in. CHMOD the directory to 777. Set the $Data variable
    # to the absolute path to this directory. Note that this does not mean the URL to the
    # directory, it means the full UNIX path from root to the directory. If you do not know
    # what the absolute path is to your web space, upload the "upload.cgi" file to your
    # cgi-bin and CHMOD 755. Next call the URL to the script in your browser and add
    # "?debug" to the end of it. i.e.:
    #
    #			http://www.yourdomain.com/cgi-bin/upload.cgi?debug
    #
    # This will print out the absolute path to the directory you put the script in.

#
#	You do not need to edit anything else in this program. However, please read it
#	carefully to see exactly how to implement the library.
#
#######################################################################################

use CGI;

require 'upload.lib';

$ScriptURL = "http://$ENV{'SERVER_NAME'}$ENV{'SCRIPT_NAME'}";

if($ENV{'QUERY_STRING'} =~ /^upload/) {

    #####################################
    # Because I have three upload fields
    # on the page, I need three separate
    # calls to the sub-routine. See that
    # I have passed the name of each of
    # the upload fields to the subroutine
    # calls
    #####################################

    &psupload($Data, 'myfield');
    &psupload($Data, 'anotherfile');
    &psupload($Data, 'FILE1');

    #####################################
    # Now just printing out a page that
    # indicates the test is done. You have
    # to print something out or else your
    # user will get 500 errors.
    #####################################
   
    print "Content-type: text/html\n\n";
    print qq~
    <HEAD><TITLE>PSUpload Demonstration Upload Form</TITLE></HEAD>
    <BODY BGCOLOR="#ffffff" TEXT="#330066" LINK="#336666" ALINK="#336666" VLINK="#336666" BGCOLOR="#FFFFFF">
    <FONT SIZE="2" FACE="verdana, arial, helvetica">
    <CENTER><BR><BR><BR><B>Upload Complete!</B>
    <BR><BR><BR><BR><BR>
    &copy; 2001, <A HREF="http://www.charityware.ws/">Jim Melanson</A><BR><BR>
    </FONT></BODY></HTML>
    ~;
} else {
    ####################################
    # Print out the upload form
    ####################################
    print "Content-type: text/html\n\n";
    print qq~ 
    <HEAD><TITLE>PSUpload Demonstration Upload Form</TITLE></HEAD>
    <BODY BGCOLOR="#ffffff" TEXT="#330066" LINK="#336666" ALINK="#336666" VLINK="#336666" BGCOLOR="#FFFFFF">
    <FONT SIZE="2" FACE="verdana, arial, helvetica">
    <CENTER><BR><BR><BR><B>PSUpload Demonstration Upload Form</B><BR><BR><BR>
    <TABLE BORDER=0><TR><TD><FONT SIZE="2" FACE="verdana, arial, helvetica">
    ~;
    ####################################
    # This is the actual upload form.
    # Note that you can name the upload
    # fields anything you want so long
    # as you pass that field name to the
    # psupload() subroutine. (see above)
    ####################################
    print qq~
    <FORM METHOD="POST" ACTION="$ScriptURL?upload" ENCTYPE="multipart/form-data">

    File 1: <INPUT TYPE="FILE" NAME="myfield"><br>

    File 2: <INPUT TYPE="FILE" NAME="anotherfile"><br>

    File 2: <INPUT TYPE="FILE" NAME="FILE1"><br>

    <CENTER><INPUT TYPE="SUBMIT" VALUE="Upload!"></CENTER>
    </FORM>

    ####################################
    # End of the upload form
    ####################################

    </FONT></TD></TR></TABLE><BR><BR><BR><BR>
    &copy; 2001, <A HREF="http://www.charityware.ws/">Jim Melanson</A><BR><BR>
    </FONT></BODY></HTML>

    ~;
};


