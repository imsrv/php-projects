#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\n\n"; 
#Anyone happen to know what today is?
		@numdays = (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		($sec, $min, $hr, $day, $mon, $year) = localtime;
		$year += 1900;	
		$min = "0$min" if $min < 10;
		$sec = "0$sec" if $sec < 10;
		$rday = $day;
		$day = "0$day" if $day < 10;
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

		$when = "$mon/$day/$year at $hr:$min$xm $zone";
		$whenlocal = "$hr:$min$xm $zone";
		$whenserver = "$sse:$min:$sec";
		$date_today = "$mon/$day/$year";
		$datecode = "$year$moncode$day";

#Okay, thanks!

open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10,$pont11,$pont12,$pont13,$pont14)=split(/::/, $poi);

$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");


my $sth = $dbh->prepare("SELECT COUNT(approval) FROM DMtgpgalleries WHERE approval = '1' AND vermail = '1' ") or die "Unable to prepare query: ".$dbh->errstr;
$sth->execute() or die "Unable to execute query: ".$sth->errstr;
my $num_rows = $sth->fetchrow;

          open(TGPMAIN,">$main_html") || print "Can't open $main_html REASON: ($!)\n";
        open(HTML, "$header_txt") || print "Can't open $header_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $later (@html_text) {
        chomp $later;
        $later =~ s/#LINKCOUNT#/$num_rows/g;
        print TGPMAIN "$later\n";
}




        open(HTML, "$maintemp") || print "Can't open $maintemp\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $laters (@html_text) {
        chomp $laters;
        ##

        while ($laters =~ /(%(.+?)%)/) {
        $hoho = $2;
        my($query) = "SELECT * FROM DMtgpblind WHERE linkname = '$hoho' ORDER BY rand()";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
                while(@rowze = $sth->fetchrow)  {
                $linkname = $rowze[0];
                $linkurl = $rowze[1];
                $linkdesc = $rowze[2];
                $numpics = $rowze[3];
                }


        open(LINE, "$blind") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
foreach $laters (@linetemp){
        chomp $laters;
	 $linkdesc =~ s/_//;
	if ($pont14 eq "yes") {
	$linkdesc =~ s/\b(\w)/uc($1)/eg;
	} 
        $laters =~ s/#LINKDESC#/$linkdesc/g;
        $laters =~ s/#LINKURL#/$linkurl/g;
        if ($numpics < 10) {
        $laters =~ s/#NUMPICS#/0$numpics/g;
        } else {
        $laters =~ s/#NUMPICS#/$numpics/g;
        }
        $laters =~ s/#MON#/$mon/g;
        $laters =~ s/#DAY#/$bday/g;
        print TGPMAIN "$laters\n";
        }
        last;
        }
##

##
        while ($laters =~ /(##(.+?)##)/) {
        $hehe = $2;
        my($query) = "SELECT * FROM DMtgptemps WHERE tagname = '$hehe'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
                while(@rowz = $sth->fetchrow)  {
                $tagname = $rowz[0];
                $categ = $rowz[1];
                $startat = $rowz[2];
                $endat = $rowz[3];

        }

         my ( $webname, $webemail, $weburl, $webcate, $webpics, $webdesc, $webdate, $datecode, $approval, $idnum, $webip, $uniqueid, $vermail, $stamp, $rate, $aff );
        my($query) = "SELECT * FROM DMtgpgalleries WHERE webcate = '$categ' and approval = '1' ORDER BY datecode DESC, rate DESC, idnum DESC LIMIT $startat, $endat";

        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Could not execute!");
        $sth->bind_columns( undef, \$webname, \$webemail, \$weburl, \$webcate, \$webpics, \$webdesc, \$webdate, \$datecode, \$approval, \$idnum, \$webip, \$uniqueid, \$vermail, \$stamp, \$rate, \$aff );

        while ( $sth->fetch ) {

        open(LINE, "$linetemp") || print "Can't open $linetemp\n";
        @linetemp = <LINE>;
        close(LINE);
$dc = $webdate;
($rday,$rmon,$ryear)=split(/\//, $dc);
foreach $laters (@linetemp){
        chomp $laters;
        $webdesc =~ s/_//;
        $laters =~ s/#LINKDESC#/$webdesc/g;
        $laters =~ s/#LINKURL#/$weburl/g;
	  if ($webpics < 10) {
        $laters =~ s/#NUMPICS#/0$webpics/g;
        } else {
        $laters =~ s/#NUMPICS#/$webpics/g;
        }
        $laters =~ s/#NUMPICS#/$webpics/g;
        $webcate =~ s/ /%20/g;
        $laters =~ s/#CATEG#/$webcate/g;
        $laters =~ s/#IDNUM#/$idnum/g;
        $laters =~ s/#MON#/$rmon/g;
        $laters =~ s/#DAY#/$rday/g;
        print TGPMAIN "$laters\n";
        }
}
last;
}
    $laters =~ s/%(.+?)%//g;
    $laters =~ s/##(.+?)##//g;
        print TGPMAIN "$laters\n";
}
        open(HTML, "$footer_txt") || print "Can't open $footer_txt\n";
        @html_text = <HTML>;
        close(HTML);
        foreach $laters (@html_text) {
        chomp $laters;
        $laters =~ s/#UPDATED#/$when/g;
        print TGPMAIN "$laters\n";
}
        close(TGPMAIN);

#Yay! The smut LIVES!

#Print them out a nice message

print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">\n";
print "<title>Thank You!</title>\n";
print "</head>\n";
print "\n";
print "<body>\n";
print "\n";
print "<p align=\"center\"><font face=\"Verdana\">Page generated<!--CyKuH--></font></p>\n";
print "\n";
print "</body>\n";
print "\n";
print "</html>\n";
exit;

#Now get the hell outta here!