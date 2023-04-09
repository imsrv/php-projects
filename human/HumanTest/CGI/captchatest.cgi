#!/usr/bin/perl

##############
# FirstProductions Human Test
# Copyright © 2003, First Productions, Inc.
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
# You can visit us on the web at:
# http://www.firstproductions.com/cgi/
#
# You can contact us at:
# cgi@firstproductions.com
##############
# Be sure to edit the settings in CAPTCHA.PL before running this script!
##############

use CGI;
require "captcha.pl";

$q = new CGI;
$code = $q->param('code');
$crypt = $q->param('crypt');

print "Content-type: text/html\n\n";

print '<html><h2 align="center">FirstProductions Human Test Example</h2>';

if ($code && $crypt){
	print '<p align="center">';

	# check code
	$result = &checkCode($code,$crypt);

	if ($result == 1){
		print "<b>Passed!</b> Congratulations, you are a human! Try the new code below.";
	}
	elsif ($result == -1){
		print "<b>Failed!</b> Reason: code expired. Possible cause: code was issued too long ago. Try the new code below.";
	}
	elsif ($result == -2){
		print "<b>Failed!</b> Reason: invalid code (not in database). Possible causes: code already used or expired. Try the new code below.";
	}
	elsif ($result == -3){
		print "<b>Failed!</b> Reason: invalid code (code does not match crypt). Possible cause: characters not entered correctly. Try the new code below.";
		# note - once a solution is tried it is expired, even if it failed
	}
	else {
		print "Code not checked (file error)! Check to be sure that the script is properly configured.";
	}

	print '</p>';
}

	# generate crypt
	$crypt = &generateCode(8);

	if ($crypt){
		# output page
		print '<p align="center"><img src="'.$captcha_webfolder.'/'.$crypt.'.png" width='.($captcha_length*$captcha_width).' height='.$captcha_height.' border=0></p><form action="captchatest.cgi" method="POST"><div align="center"><center><input type="hidden" name="crypt" value="'.$crypt.'">Enter the characters you see in the image: <input type="text" name="code" value=""><input type="submit" value="Check"><br>Note: the numbers zero (0) and one (1) do not appear in the image. Refresh/reload this page for a new image. If you are uncertain of a character, take your best guess.</center></div></form><p align="center"><A HREF="http://www.firstproductions.com/cgi/human/">More Information</A> · <A HREF="http://www.firstproductions.com/cgi/human/download.html">Download Now!</A></p><p align="center">FirstProductions Human Test, Copyright &copy; 2003, First Productions, Inc.</p></html>';
		# notes: $captcha_length is the number of characters
		#        $captcha_width is the width of each character
		#        $captcha_height is the height of each characters and of the output image
		#        multiply $captcha_length by $captcha_width to get the width of the output image
		#        
		#        $crypt is the md5-encrypted version of the code that needs to be entered
		#        it should be passed back as a hidden input.
		#        it is also the filename of the output image without the .png suffix
	}
	else{
		print "Code not generated (file error)! Check to be sure that the script is properly configured.";
	}

exit;

