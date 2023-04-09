#!/usr/bin/perl

##############
# CAPTCHA.PL #
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
# FUNCTIONS  #
##############
# Function: generateCode($length)
# Returns: md5 crypt (also image filename minus .png)
#
# Function: checkCode($code,$crypt)
# Returns: 1 : Passed
#          0 : Code not checked (file error)
#         -1 : Failed: code expired
#         -2 : Failed: invalid code (not in database)
#         -3 : Failed: invalid code (code does not match crypt)
##############

use GD;
use Digest::MD5 qw(md5_hex);

##### SETTINGS #####
$captcha_datafolder = "/home/firstpro/captcha"; # not web accessible to store database (no trailing slash)
$captcha_database = "$captcha_datafolder/codes.txt"; # path to database file
$captcha_imagesfolder = "$captcha_datafolder/images"; # not web accessible to store png image files (no trailing slash)
$captcha_outputfolder = "/home/firstpro/firstproductions-www/abc"; # path to store output (no trailing slash)
$captcha_webfolder = "http://www.firstproductions.com/abc"; # url to outputfolder (no trailing slash)

$captcha_expire = 300; # expire time in seconds (default five minutes: 300)
                       # note: once a test is submitted, the code is also expired,
                       #       regardless if the test was passed or failed

$captcha_width = 25; # width of character graphics
$captcha_height = 35; # height of character graphics
####################

sub checkCode {
	$captcha_code = lc($_[0]);
	$captcha_crypt = $_[1];
	
	# set a variable with the current time
	$captcha_currenttime = time;

	$captcha_returnvalue = 0;

	# zeros (0) and ones (1) are not part of the code
	$captcha_code =~ tr/01/ol/;

	$captcha_md5 = md5_hex($captcha_code);

	open (DATA, "<$captcha_database") || return 0;
	flock DATA, 2; 
	@data=<DATA>;
	close(DATA);

	$captcha_passed=0;
	$captcha_newdata = "";
	foreach $captcha_fileline (@data) {
		$captcha_fileline =~ s/\n//;
		($captcha_datatime,$captcha_datacode) = split(/::/,$captcha_fileline);
		if ($captcha_datacode eq $captcha_crypt){
			# the crypt was found in the database
			if ($captcha_currenttime - $captcha_datatime > $captcha_expire){ 
				# the crypt was found but has expired
				$captcha_returnvalue = -1;
			}
			else{
				$captcha_found = 1;
			}
			# remove the found crypt so it can't be used again
			unlink("$captcha_outputfolder/$captcha_datacode.png");
		}
		elsif ($captcha_currenttime - $captcha_datatime > $captcha_expire){
			# removed expired crypt
			unlink("$captcha_outputfolder/$captcha_datacode.png");
		}
		else{
			# crypt not found or expired, keep it
			$captcha_newdata .= $captcha_fileline."\n";
		}
	}

	if ($captcha_md5 eq $captcha_crypt){
		# solution was correct
		if ($captcha_found){
			# solution was correct and was found in database - passed
			$captcha_returnvalue = 1;
		}
		elsif (!$captcha_returnvalue){
			# solution was not found in database
			$captcha_returnvalue = -2;
		}
	}
	else {
		# incorrect solution
		$captcha_returnvalue = -3;
	}

	# update database
	open(DATA,">$captcha_database") || return 0;
		print DATA $captcha_newdata;
	close(DATA);
	
	return $captcha_returnvalue;
}

sub generateCode {
	$captcha_length = $_[0];

	# create a random seed
	srand (time ^ $$ ^ unpack "%L*", `ps axww | gzip`);
	
	# set a variable with the current time
	$captcha_currenttime = time;

	# create a new image and color
	$captcha_im = new GD::Image($captcha_width*$captcha_length,$captcha_height);
	$captcha_black = $captcha_im->colorAllocate(0,0,0);
	
	# generate a new code
	$captcha_code = "";
	for($captcha_i=0; $captcha_i<$captcha_length; $captcha_i++){ 
		$captcha_list =int(rand 4) +1;
		if ($captcha_list==1){ # choose a number 1/4 of the time
			$captcha_char =int(rand 7)+50;
		}
		else{ # choose a letter 3/4 of the time
			$captcha_char =int(rand 25)+97;
		}
		$captcha_char =chr($captcha_char);
		$captcha_code .= $captcha_char;
	}
	$captcha_md5 = md5_hex($captcha_code);
	
	# copy the character images into the code graphic
	for($captcha_i=0; $captcha_i<$captcha_length; $captcha_i++){
		$captcha_letter = substr($captcha_code,$captcha_i,1);
		$captcha_source = new GD::Image("$captcha_imagesfolder/$captcha_letter.png");
		$captcha_im->copy($captcha_source,$captcha_i*$captcha_width,0,0,0,$captcha_width,$captcha_height);
		$captcha_a =int(rand (int($captcha_width/14)))+0;
		$captcha_b =int(rand (int($captcha_height/12)))+0;
		$captcha_c =int(rand (int($captcha_width/3)))-(int($captcha_width/5));
		$captcha_d =int(rand (int($captcha_height/3)))-(int($captcha_height/5));
		$captcha_im->copyResized($captcha_source,($captcha_i*$captcha_width)+$captcha_a,$captcha_b,0,0,$captcha_width+$captcha_c,$captcha_height+$captcha_d,$captcha_width,$captcha_height);
	}
	
	# distort the code graphic
	for($captcha_i=0; $captcha_i<($captcha_length*$captcha_width*$captcha_height/14+200); $captcha_i++){
		$captcha_a =int(rand ($captcha_length*$captcha_width))+0;
		$captcha_b =int(rand $captcha_height)+0;
		$captcha_c =int(rand ($captcha_length*$captcha_width))+0;
		$captcha_d =int(rand $captcha_height)+0;
		$captcha_index = $captcha_im->getPixel($captcha_a,$captcha_b);
		if ($captcha_i < (($captcha_length*$captcha_width*$captcha_height/14+200)/100)){
			$captcha_im->line($captcha_a,$captcha_b,$captcha_c,$captcha_d,$captcha_index);
		}
		elsif ($captcha_i < (($captcha_length*$captcha_width*$captcha_height/14+200)/2)){
			$captcha_im->setPixel($captcha_c,$captcha_d,$captcha_index);
		}
		else{
			$captcha_im->setPixel($captcha_c,$captcha_d,$captcha_black);
		}
	}
	
	# generate a background
	$captcha_a =int(rand 5)+1;
	$captcha_source = new GD::Image("$captcha_imagesfolder/background$captcha_a.png");
	($captcha_backgroundwidth,$captcha_backgroundheight) = $captcha_source->getBounds();
	$captcha_b =int(rand (int($captcha_backgroundwidth/13)))+0;
	$captcha_c =int(rand (int($captcha_backgroundheight/7)))+0;
	$captcha_d =int(rand (int($captcha_backgroundwidth/13)))+0;
	$captcha_e =int(rand (int($captcha_backgroundheight/7)))+0;
	$captcha_source2 = new GD::Image(($captcha_length*$captcha_width),$captcha_height);
	$captcha_source2->copyResized($captcha_source,0,0,$captcha_b,$captcha_c,($captcha_length*$captcha_width),$captcha_height,$captcha_backgroundwidth-$captcha_b-$captcha_d,$captcha_backgroundheight-$captcha_c-$captcha_e);
	
	# merge the background onto the image
	$captcha_im->copyMerge($captcha_source2,0,0,0,0,($captcha_length*$captcha_width),$captcha_height,40);
	
	# add a border
	$captcha_im->rectangle(0,0,($captcha_length*$captcha_width-1),($captcha_height-1),$captcha_black);

	# destroy code for security
	$captcha_code = "";

	# clean expired codes and images
	open (DATA, "<$captcha_database") || return;
	flock DATA, 2; 
	@data=<DATA>;
	close(DATA);
	
	$captcha_newdata = "";
	foreach $captcha_fileline (@data) {
		$captcha_fileline =~ s/\n//;
		($captcha_datatime,$captcha_datacode) = split(/::/,$captcha_fileline);
		if ($captcha_currenttime - $captcha_datatime > $captcha_expire || $captcha_datacode  eq $captcha_md5){
			unlink("$captcha_outputfolder/$captcha_datacode.png");
		}
		else{
			$captcha_newdata .= $captcha_fileline."\n";
		}
	}
	
	# save the code to database
	open(DATA,">$captcha_database") || return;
		print DATA $captcha_newdata;
		print DATA $captcha_currenttime."::".$captcha_md5."\n";
	close(DATA);
	
	# save the image to file
	$captcha_outputfile = "$captcha_outputfolder/$captcha_md5.png";
	$captcha_png_data = $captcha_im->png;
	open (FILE,">$captcha_outputfile") || return;
	binmode FILE;
	print FILE $captcha_png_data;
	close FILE;
	
	# return crypt (md5)
	return $captcha_md5;
}

1;