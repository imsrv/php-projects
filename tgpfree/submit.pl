#!/usr/bin/perl
#Version 2.0
use DBI;
use CGI::Carp qw(fatalsToBrowser);
use CGI;
use LWP::UserAgent;
use LWP::Simple; 
use HTML::LinkExtor;
use URI::URL;
my $cgi = new CGI;
my $query = new CGI;
require "config.pl";
$dbh = DBI->connect("dbi:mysql:$database:$dbhost:dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
print "Content-type: text/html\n\n";

# Lets declare some variables.
my $webname = $cgi->param('webname');
my $webemail = $cgi->param('webemail');
my $weburl = $cgi->param('weburl');
my $webcate = $cgi->param('webcate');
my $webpics = $cgi->param('webpics');
my $webdesc = $cgi->param('webdesc');
#Let's be done with the variables.


$isnow = time;
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
#Okay, thanks!

open(P, "$options_db") || print "Cant open $options_db REASON ($!)";
$poi = <P>;
close(P);
($pont1,$pont2,$pont3,$pont5,$pont6,$pont7,$pont8,$pont9,$pont10)=split(/::/, $poi);

#Puke out some errors if the user does something retarded
if($webname eq "") { print "Content-type: text/html\n\n"; &error; print "You did not enter your name."; &error2; exit; }
if($webemail eq "") { print "Content-type: text/html\n\n"; &error; print "You did not enter your email address."; &error2; exit; }
if($weburl eq "") { print "Content-type: text/html\n\n"; &error; print "You did not enter the URL to your gallery."; &error2; exit; }
if($webpics eq "") { print "Content-type: text/html\n\n"; &error; print "You did not enter the number of pics in your gallery."; &error2; exit; }
if($webdesc eq "") { print "Content-type: text/html\n\n"; &error; print "You did not enter a description for your gallery."; &error2; exit; }
#User made it past this point, they must not be retarded.

#Check for reciprocal link
if ($pont3 eq "yes"){
my ($url,$agent,$page,$results,$bs,@ahref);
$url = $weburl;
$agent = new LWP::UserAgent;
my @links = ();
$page = HTML::LinkExtor->new(\&scan);
$results = $agent->request(HTTP::Request->new(GET => $url), sub {$page->parse($_[0])});
if ($results->is_success) {
my $bs = $results->base;
@links = map { $_ = url($_, $bs)->abs; } @links;
sub scan {
    my($html, %tag) = @_;
    return if $html ne 'a';
    push(@links, values %tag);
}
if (grep { /$reciplink/gi } @links) {
 $arelinking = 1;
    } else {
    open(HTML, "$noreciptemp") || print "Can't open $noreciptemp\n";
        @html_text = <HTML>;
        close(HTML);
        print @html_text;
    exit;
}

    } else { &error; print "The URL you submitted ($url) does not appear to exist."; &error2; exit; }

} else { &verifylive; }



        my($query) = "SELECT * FROM DMtgpgalleries WHERE weburl = '$weburl'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@oops = $sth->fetchrow)  {
        if ($oops[2]){
        open(OOPSIE, "$duplicateerror") || print "Can't open $duplicateerror\n";
        @error_text1 = <OOPSIE>;
        close(OOPSIE);
        print @error_text1;
        $sth->finish;
    exit;
    }
    }
$sth->finish;

        my($query) = "SELECT * FROM DMtgpgalleries WHERE datecode = '$datecode' AND webip = '$ENV{'REMOTE_ADDR'}'";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        $searchlist = 0;
        while(@row = $sth->fetchrow)  {
        ++$searchlist;
        }
        $sth->finish;

        if ($searchlist >= $pont2){
            open(OOPS, "$excessiveposts") || print "Can't open $excessiveposts\n";
        @error_text = <OOPS>;
        close(OOPS);
        print @error_text;
    exit;
    }

#Get unique post ID number
$passwd = random_password();
&getpid;


        if ($pont5 eq "yes"){
                $vermail = 0;
                &checkemail;
        }
        else {
                $vermail = 1;

                if ($pont6 eq "yes"){
                        &submail;
                }
        }

#Write the users info to the database
if ($requireapproval eq "yes"){
        $approval = 0;
}
else {
$approval=1;
}
my($add) = "INSERT INTO DMtgpgalleries VALUES('$webname','$webemail','$weburl','$webcate','$webpics','$webdesc','$date_today','$datecode','$approval','$newpid','$ip','$passwd','$vermail','$isnow')";
       my($sth) = $dbh->prepare($add);
       $sth->execute || die("Couldn't exec sth!");
       $sth->finish;
        $dbh->disconnect;
#Okay, done with that.

#Print them out a nice message
    open(HTML, "$successpage") || print "Can't open $successpage\n";
        @html_text = <HTML>;
        close(HTML);
        print @html_text;
        
    exit;
#Now get the hell outta here!


sub verifylive {
use LWP::Simple; 
my $url = $weburl; 
if (head($url)) { 

} else { &error; print "The URL you submitted ($url) does not appear to exist."; &error2; exit; }
}

sub random_password {
($length) = @_;
if ($length eq "" or $length < 3) {
$length = 8;
}
$vowels = "aeiouyAEUY";
$consonants = "bdghjmnpqrstvwxzBDGHJLMNPQRSTVWXZ12345678";
srand(time() ^ ($$ + ($$ << 15)) );
$alt = int(rand(2)) - 1;
$s = "";
$newchar = "";
foreach $i (0..$length-1) {
if ($alt == 1) {
$newchar =
substr($vowels,rand(length($vowels)),1);
} else {
$newchar = substr($consonants,
rand(length($consonants)),1);
}
$s .= $newchar;
$alt = !$alt;
}
return $s;
}
	sub getpid {
		my($query) = "SELECT idnum FROM `DMtgpgalleries` ORDER BY `idnum` DESC LIMIT 1";
        my($sth) = $dbh->prepare($query);
        $sth->execute || die("Couldn't exec sth!");
        while(@PID = $sth->fetchrow)  {
        $CURPID = $PID[0];
        }
$newpid = $CURPID+1;
        }

        	