#!/usr/bin/perl

#######################################################################################
#
#	PSUpload Helper (PSUpload) V3.0    [NT Version]
#	©2000, Perl Services
#
#	Requirements:		NT Server, Perl5+, CGI.pm
#	Created:		September 22nd, 2000
#	Author: 		Jim Melanson
#	Contact:		www.perlservices.net
#				Phone:		1-877751-5900, ext. 908
#				Fax:		1-208-694-1613
#				E-Mail:		info@perlservices.com
#						info@charityware.ws
#
#
#	http://www.perlservices.net/en/programs/psupload/users_guide.shtml
#
#######################################################################################
#
#
#	This utility is distributed under the same terms as Perl itself. It may be
#	modified and utilized as you will so long as the original copyright notice
#	remains in the header and that any modifications you make are state in the
#	header along with the date of the modification and the name and email addy
#	of the person who made the modification.
#
#	Additionally, this program has been designated as Charity Ware. That means
#	that if you use the program or modify the program to use it in/with another
#	program then you are required to make a charitable donation to a charity
#	of YOUR choice in the amount of YOUR choice. We'd appreciate your dropping
#	by Charity Ware (www.charityware.ws) to register your donation so others can
#	see who is benefiting from our work. If your too busy, drop us a line telling
#	us who benefited and how much you gave them and we'll post the registration
#	for you.
#
#	This program requires installation on a UNIX server running Perl4 or higher.
#
#	This program require the use of the CGI.pm module. If it is not installed
#	on your server, you can have your sysadmin obtain the latest version of CGI.pm
#	form the CPAN site at www.cpan.org
#
#	Please see the accompanying HTML demonstration file for instructions on
#	creating the upload form you will put on your HTML page.
#
#	History:
#	This program was originally written in a basic form by Mark Knickelbain. After
#	Perl Services was taken over by Jim Melanson, this utility was re-written. This
#	re-write has been based on the feedback of hundreds of users. The features
#	incorporated in the re-write were the most common requests of PSUpload Helper
#	users. Version 2.0 of this program was released on February 22nd, 2001.
#
#	It was the authors choice that PSUpload Helper 2.0 should be distributed from
#	the Charity Ware site at www.charityware.ws so that others less fortunate may
#	benefit from his efforts.
#
#######################################################################################
#
#	FINAL WORD:	Do you have comments or criticisms (constructive ones) please
#			send them to jim@perlservices.com or info@charityware.ws. This
#			library and the V2 of PSUpload Helper are the results of input
#			from end users and incorporate the most common requests.
#
#######################################################################################
#
#	CONFIGURE VARIABLES

$Data = "E:\path\to\storeage\directory";
    #	On your server, create a directory where this program will write the files
    #	to. If you do NOT specify a $Data
    #	directory, the program will attempt to write to the web root directory.
    #	NOTE: YOU SHOULD ALWAYS SPECIFY A DIRECTORY TO STORE THE UPLOAD

@good_extensions = ();
    #	If you want to limit the types of extension that can be uploaded, specify them
    #	here by adding them to the array. For example, if you wanted to permit only
    #	the upload of gif's, jpg's and png's, then you would set the above array to
    #	look like this:
    #	@good_extensions = ('gif', 'jpg', 'jpeg', 'png');
    #

@bad_extensions = ();
    #	If you want to permit the upload of all file types with only certain exceptions,
    # 	then specify those extensins in the bad_extensions array. This means that if set
    #   this array to contain .exe, .pl, .cgi files, then the program will only store a
    #	file if the extension of that file is NOT found in this array.
    #	To set the array to exclude these sample extensions, you would set it like this:
    #	@bad_extensions = ('exe', 'cgi', 'pl');
    #

	#	NOTE: If you specify both @good_extensions and @bad_extensions, then
	#	the settings in @bad_extensions will be ignored and the program will
	#	use @good_extensions as it's refrence.

$redirect = "http://www.charityware.ws";
    #	When the upload of files is complete, the program must print someting out on the
    #	browser screen. Set the $redirect variable to the full URL (don't forget the http://)
    #	that you want the person taken to once the program is finished. If you don't specify
    #	a URL here, the program will print out a simple upload summary page.

$max_size = 50;
    #	Set the maximum size of each file that is permitted. For example, if you only want
    #	files to be uploaded that are under 50Kb in size, set the value to:
    #	$max_size = 50;
    #	If you set the value to zero, remove it or comment it out, then the size of the
    #	uploaded file will NOT be checked.

$max_num_files = 5;
    #	You must specify the maximum number of files that can be uploaded at one time. You
    #	can set this to any number you want but be realistic. The limit before the server
    #	times out will depend on the maximum size of the upload. I have tested this program
    #	with ASCII files up to 8MB in size successfully but that was on a particularly
    #	robust server. I recommend that you set this no higher than 5 if you are going to
    #	be using this for larger binary files such as images or executables or word docs, etc.
    #	If you remove, comment out or set this value to zero, the program will default the
    #	value to 1 file.

$auto_rename = 1;
    #   This variable tells the program whether or not to over-write or reject like
    #   named files. Therefore, if you upload a file with a name that already exists
    #   on the server, set this value for the appropriate following results:
    #           0 => Overwrite the existing file
    #           1 => Leave existing file in place, serialize the name of the new
    #                new file (i.e. some_book.doc, some_book1.doc, some_book2.doc, etc)
    #           2 => Reject the new file. Leaves the original file in place and rejects
    #                the new file so that it is not saved.
    #   The default setting of this var is 0.

#
#######################################################################################
#
#			DO NOT EDIT ANYTHING BELOW THIS LINE
#			 UNLESS YOU KNOW WHAT YOU ARE DOING
#

if(($ENV{'QUERY_STRING'} =~ /^debug/) && !$no_debug) {
    print "Pragma: no-cache\nContent-type: text/html\n\n";
    print "<TITLE>PSUpload Demonstration Upload Program - Debug Mode</TITLE></HEAD><BODY BGCOLOR=\"#ffffff\" TEXT=\"#330066\" LINK=\"#336666\" ALINK=\"#336666\" VLINK=\"#336666\" BGCOLOR=\"#FFFFFF\"><FONT SIZE=\"2\" FACE=\"verdana, arial, helvetica\">\n";
    print "<CENTER><B><H2>Charity Ware's PSUpload Program</H2></B><BR><BR><TABLE BORDER=0><TR><TD COLSPAN=2><FONT SIZE=\"2\" FACE=\"verdana, arial, helvetica\">\n";
    print "<DL><DT><B>Your web root directory appears to be located at:</B><DD>$ENV{'DOCUMENT_ROOT'}<BR><BR><DT><B>You specified directory for storing the uploads is:</B><DD>$Data<BR><BR><DT><B>Your specified directory...</B><DD>\n";
    if(-d $Data) {
	print "...appears to be a valid directory.<BR><BR>Make sure this \$Data directory is CHMOD 777.\n";
    } else {
	print "...does not appear to be a valid directory.<BR><BR>\n";
	unless($Data =~ /^$ENV{'DOCUMENT_ROOT'}/) {
	    print "The value you specified in the \$Data variable is incorrect. Please<BR>correct your \$Data variable and run debug again.<BR><BR>\n";
	}
    }
    if($Data =~ /\/$/) {
	print "<FONT COLOR=\"#FF0000\">NOTE: Your variable \$Data ends with a trailing slash. Please<BR>remove this trailing slash, upload the program again<BR>and run debug once more to see if you have a valid directory.</FONT><BR><BR>\n";
    }
    print "</DL><BR><BR></FONT></TD></TR><TR><TD WIDTH=\"50%\" VALIGN=\"TOP\"><FONT SIZE=\"2\" FACE=\"verdana, arial, helvetica\"><B>OS:</B><BR>$^O<BR><BR><B>Perl:</B><BR>$]</FONT></TD><TD VALIGN=\"TOP\"><FONT SIZE=\"2\" FACE=\"verdana, arial, helvetica\"><B>Installed:</B><BR>"; my @inst = split(/\//, $ENV{'SERVER_SOFTWARE'}); print join("<BR>", @inst); print"</FONT></TD></TR></TABLE><BR><BR><BR><BR><A HREF=\"http://www.charityware.ws/\">&copy; 2001, Jim Melanson</A></CENTER><BR><BR></FONT></BODY></HTML>\n";
} else {
    use CGI; 
    $max_num_files  ||= 1;
    $Data 		||= $ENV{'DOCUMENT_ROOT'};
    undef @bad_extensions if @good_extensions;
    for(my $a = 1; $a <= $max_num_files; $a++) {
	my $req = new CGI; 
	if($req->param("FILE$a")) {
	    my $file = $req->param("FILE$a");
	    my $filename = $file; 
	    $filename =~ s/^.*(\\|\/)//;
            $filename =~ s/ +/\_/g;
	    my $proceed_type = 0;
	    if(@good_extensions) {
		foreach(@good_extensions) {
		    my $ext = $_;
		    $ext =~ s/\.//g;
		    if($filename =~ /\.$ext$/) {
			$proceed_type = 1;
			last;
		    }
		}
		unless($proceed_type) {
		    push(@was_not_good_type, $filename);
		}
	    }
	    elsif(@bad_extensions) {
		$proceed_type = 1;
		foreach(@bad_extensions) {
		    my $ext = $_;
		    $ext =~ s/\.//g;
		    if($filename =~ /\.$ext$/) {
			$proceed_type = 0;
			last;
		    }
		}
		unless($proceed_type) {
		    push(@was_a_bad_type, $filename);
		}
	    } else {
		$proceed_type = 1;
	    }
            if(($auto_rename == 2) && (-e "$Data/$filename")) {
                $proceed_type = 0;
                push(@rejected, $filename);
            }

	    if($proceed_type) {
                if((-e "$Data/$filename") && ($auto_rename == 1)) {
                    my $pick_new_name = 1;
                    my $fore_num = 1;
                    $filename =~ /^(.+)\.([^\.]+)$/;
                    my $front = $1;
                    my $ext = $2;
                    while($pick_new_name) {
                        my $test_name = $front . $fore_num . '.' . $ext;
                        unless(-e "$Data/$test_name") {
                            $pick_new_name = 0;
                            $filename = $test_name;
                        }
                        $fore_num++;
                    }
                }
		if(open(OUTFILE, ">$Data/$filename")) {
		    binmode(OUTFILE);
		    while (my $bytesread = read($file, my $buffer, 1024)) { 
			print OUTFILE $buffer; 
		    } 
		    close (OUTFILE);
	            if($max_size) {
		        if((-s "$Data/$filename") > ($max_size * 1024)) {
		            push(@was_too_big, $filename);
		            unlink("$Data/$filename");
		        } else {
		            push(@file_did_save, $filename);
                        }
	            } else {
		        push(@file_did_save, $filename);
                    }
		} else {
		    push(@did_not_save, $filename);
		}
	    }
	}
    }
    print "Pragma: no-cache\n";
    if($redirect && ($redirect =~ /^http\:\/\//)) {
	print "Location: $redirect\n\n";
    } else {
	print "Content-type: text/html\n\n";
	print "<HEAD><TITLE>PSUpload Results</TITLE></HEAD><BODY><FONT FACE=\"verdana,helvetica,arial\" SIZE=2><BR><BR><CENTER><B><H2>Upload Results</H2></B><HR WIDTH=\"65%\"><BR><BR>\n";
	if(@rejected) {print "<B>The following file(s) were not stored as they<BR>were already on the server:<BR><BR>\n"; print join("<BR>", @rejected); print "<BR><BR>\n"}
	if(@file_did_save) {print "<B>The following file(s) were saved:<BR><BR>\n"; print join("<BR>", @file_did_save); print "<BR><BR>\n"}
	if(@was_not_good_type) {print "<B>The following file(s) were not stored as their file extension<BR>did not match any of the valid extensions specified in the program:<BR><BR>\n"; print join("<BR>", @was_not_good_type); print "<BR><BR>\n"}
	if(@was_a_bad_type) {print "<B>The following files were not stored as their file extension<BR>are on the list of extensions not permitted for upload:<BR><BR>\n"; print join("<BR>", @was_a_bad_type); print "<BR><BR>\n"}
	if(@was_too_big) {print "<B>The following files were not stored as their file size<BR>exceeded the maximum file size of $max_size Kb.:<BR><BR>\n"; print join("<BR>", @was_too_big); print "<BR><BR>\n"}
	if(@did_not_save) {print "<B>The following files were not stored because the<BR>program could not open their destination file:<BR><BR>\n"; print join("<BR>", @did_not_save);print "<BR><BR>\n";
            if(!@file_did_save) {print "<FONT COLOR=\"RED\"><B>NOTE: Check to ensure that the \$Data variable reflects the correct<BR>absolute path to the directory these files should be store in.</B></FONT><BR><BR>"}
	}
	print "<BR><BR><HR WIDTH=\"65%\"><BR><A HREF=\"http://www.charityware.ws/psupload/psupload.shtml/\"><FONT COLOR=\"#C0C0C0\">&copy; 2001, Jim Melanson</FONT></A><BR></BODY></HTML>\n";
    }
}