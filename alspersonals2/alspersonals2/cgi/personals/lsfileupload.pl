#!/usr/bin/perl 

use CGI::Carp qw(fatalsToBrowser);
require "configdat.lib";
require "defaulttext.lib";


# No additional changes necessary
# Leave what lies below this line in tact
###########################################

	
	$| = 1;
	chop $userimagesdir if ($userimagesdir =~ /\/$/);
	use CGI qw(:standard);
	$query = new CGI;

	if ( (!(-e $userimagesdir)) ||
		 (!(-W $userimagesdir)) ||
		 (!(-d $userimagesdir)) ) {
		print header;
		print <<ENDOFHTML;;
		
		$mainheader<br><br>
		<BLOCKQUOTE>Either the specified directory, $userimagesdir, does 
		not exist, is not writable (chmod 777), or
		it is not a directory. 
		</BLOCKQUOTE>
		<br>$botcode
		
ENDOFHTML
		exit;
	}
	
#############################################################################

	foreach $key (sort {$a <=> $b} $query->param()) {
		next if ($key =~ /^\s*$/);
		next if ($query->param($key) =~ /^\s*$/);
		next if ($key !~ /^file-to-upload-(\d+)$/);
		
		$Number = $1;
		
		if ($query->param($key) =~ /([^\/\\]+)$/) {
			$Filename = $1;
			$Filename =~ s/^\.+//;
			$File_Handle = $query->param($key);

		


unless($Filename =~/\.gif$|\.GIF$|\.jpg$|\.JPG$|\.jpeg$/){
print header;
print "$mainheader$menu1$menu2<br><br>\n";
print "$fupl2\n";
print "<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center> <br><br>$botcode\n";
exit;
}

		if(-e "$userimagesdir/$Filename"){

		print header;
		print "$mainheader$menu1$menu2<br><br>\n";
		print "$fupl3 <br>
		<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
		<br><br>$botcode\n";
		exit;
		}

		if($Filename =~ / /){
		print "Content-type:text/html\n\n";
		print "$mainheader$menu1$menu2<br><br>\n";
		print "$fupl5 <br>
		<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
		<br><br>$botcode\n";
		exit;
		}

		if(($Filename =~ /\$./)||($Filename =~ /\@/)||($Filename =~ /\*/)||
		($Filename =~ /\%/)||($Filename =~ /\^/)||($Filename =~ /\#/)||
		($Filename =~ /\!/)||($Filename =~ /\~/)||($Filename =~ /\`/)||
		($Filename =~ /\;/)||($Filename =~ /\:/)||($Filename =~ /\[/)||
		($Filename =~ /\]/)||($Filename =~ /\(/)||($Filename =~ /\)/)||
		($Filename =~ /\&/)||($Filename =~ /\"/)||($Filename =~ /\'/)||
		($Filename =~ /\+/)||($Filename =~ /\=/)||($Filename =~ /\|/)||
		($Filename =~ /\{/)||($Filename =~ /\}/)||($Filename =~ /\//)||
		($Filename =~ /\\/)||($Filename =~ /\?/)||($Filename =~ /\,/)||
		($Filename =~ /\>/)||($Filename =~ /\</)||
		($Filename =~ /\$/)){

		print "Content-type:text/html\n\n";
		print "$mainheader$menu1$menu2<br><br>\n";
		print "$fupl5 <br>
		<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
		<br><br>$botcode\n";
		exit;
		}


		if (!$files_named_index && $Filename =~ /^index/i) {

				print "Content-type:text/html\n\n";
				print "
				$mainheader	$menu1 $menu2
				<br><br>
				$fupl4	
				<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
				$botcode	
				\n";
				exit;
				}

		} else {

			$invalid_filename = $query->param($key);

			

			print "Content-type:text/html\n\n";
			print "
			$mainheader$menu1 $menu2 <br><br>
			
			$fupl5
			
			<center><FORM> <INPUT type=\"button\" value=\"$chtgb\" onClick=\"history.go(-1)\" class=\"button\"> </FORM></center>
			$botcode
			\n";
			exit;
			}

##############################################################################



            if (!open(OUTFILE, ">$userimagesdir\/$Filename")) {
            print "Content-type: text/plain\n\n";
            print "$fupl1\n\n";
	    exit;

        	}



		undef $BytesRead;
		undef $Buffer;
        	while ($Bytes = read($File_Handle,$Buffer,1024)) {
		$BytesRead += $Bytes;
            	print OUTFILE $Buffer;
        	}
		
		push(@Files_Written, "$userimagesdir\/$Filename");
		$TOTAL_BYTES += $BytesRead;
		$Confirmation{$File_Handle} = $BytesRead;

        close($File_Handle);
		close(OUTFILE);

        chmod (0666, "$userimagesdir\/$Filename");
    }

	$FILES_UPLOADED = scalar(keys(%Confirmation));

	
	if ($TOTAL_BYTES > $maxfilesize && $maxfilesize > 0) {
		foreach $File (@Files_Written) {
			unlink $File;
		}
		
		print header;
		print <<ENDOFHTML;
		
		<HTML>
		<HEAD>
			<TITLE>Error</TITLE>
		</HEAD>
		<BODY BGCOLOR="#FFFFFF">
		<br><br>
		$mainheader
		<blockquote>The file you are uploading exceeds the maximum allowed.
		Your file is <B>$TOTAL_BYTES</B> in size. The maximum allowed
		is <B>$maxfilesize</B> bytes.  <B>Your file was not successfully saved.
		Please reduce the file size and try again.</blockquote>
		<br>
		$botcode
		</BODY></HTML>
				
ENDOFHTML
		exit;
	}
	
#################################################################################

if ($return_page !~ /^\s*$/) {
		print $query->redirect($return_page);
	} else {
	

		print header;
		print <<ENDOFHTML;
		
		$mainheader
	<center><table border=1 cellpadding=2 cellspacing=2><tr>
		<td><center><img src="$userimagesurl/$Filename" alt="$Filename" border=0></td>
<td><blockquote><font size=2 face=arial>Your file was successfully uploaded. The filename is highlighted below:<br>
<center><table bgcolor=ffff00><tr><td><center>
<font size=3>$Filename</font></center>
</td></tr></table></center>

You need to copy this filename and click the button below to go back to the form. Enter
the filename into the appropriate box. <b>**IMPORTANT</b>: You <b>MUST</b> enter the correct extention after the
filename. If the filename ends in ".jpg", but you put ".gif", the image will not show up. You will see a little 
box representing a broken image instead. The same will happen if you forget the extension altogether. 
</blockquote></font>
<input type="hidden" name="filename" value="$Filename">	
<center><form><input type="button" value="Click Here To Go Back" onClick="history.go(-2)"></form></center><br>
</td></tr></table></center>
$botcode
ENDOFHTML
		exit;	
	}
	






