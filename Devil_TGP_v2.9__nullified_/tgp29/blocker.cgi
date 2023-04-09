#!/usr/bin/perl -w
###############################################################################
#                                                                             #
# Program Name         : TGPDevil TGP System                                  #
# Program Version      : 2.9                                                  #
# Program Author       : Dot Matrix Web Services                              #
# Home Page            : http://www.tgpdevil.com                              #
# Supplied by          : CyKuH                                                #
# Nullified By         : CyKuH                                                #
#                                                                             #
#                   Copyright (c) WTN Team `2002                              #
###############################################################################
require "config.pl";
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\n\n";

#Anyone happen to know what today is?
		@numdays = (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		($sec, $min, $hr, $day, $mon, $year) = localtime;
		$year += 1900;	
		$min = "0$min" if $min < 10;
		$sec = "0$sec" if $sec < 10;
		$realday = "$day";
		$sse = $hr;

		$hr += $timefix;
		if($hr >= 24) {
			$hr -= 24;
			$day++;
			if($day > $numdays[$mon]) {
				$mon++;
				$day = 1;
			}
		}
		if ($hr < 0) {
			$hr += 24;
			$day--;
			if(!$day) {
				$mon--;
				$day = $numdays[$mon];
			}
		}
		$mon++;
		$moncode = "$mon";
		$moncode = "0$mon" if $mon < 10;
		$xm = ($hr > 11) ? 'pm' : 'am';
		$hr = 12 if ($hr == 0);
		$hr -= 12 if ($hr > 12);
		$day = "0$day" if $day < 10;

		$when = "$mon/$realday/$year at $hr:$min$xm $zone";
		$whenlocal = "$hr:$min$xm $zone";
		$whenserver = "$sse:$min:$sec";
		$date_today = "$mon/$realday/$year";
		$datecode = "$year$moncode$day";
		
open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10,$pont11,$pont12,$pont13,$pont14)=split(/::/, $poi);

if ($pont9 eq "yes"){
print "<meta http-equiv=\"Set-Cookie\" content=\"TGP_SUBMIT_COOKIE=Dot_Matrix_TGP_System;Path=/;\">\n";
}

