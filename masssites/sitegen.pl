#!/usr/bin/perl

#########################################################
#                   MassSites 1.0b                      #
#########################################################
#                                                       #
# These scripts are copywrite by Adult Designz PTY.     #
# any attempt to modify or use this code without proper #
# authorization as well as distributing it in any way   #
# will be considered an infringement of our copywrite   #
# and legal action will be pursued to the fullest       #
# extent possible.                                      #
#                                                       #
# This script was created by:                           #
#                                                       #
# Adult Designz Web Specialties PTY.                    #
# http://www.adultdesignz.com                           #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the author at        #
# apex@zyx.net or lisaryan@logicworld.com.au            #
#                                                       #
# Please Read the install.txt that came with this       #
# package for proper installation instructions.         #
#                                                       #
#                                                       #
# This script set may utilize cgi-lib.pl written by     #
# Steven E. Brenner and several perl modules created    #
# by one of our coders Bernhard van Staveren.           #
#########################################################
use Socket;
use Conf;


# add your email here. do not forget the \ in front of the @.
$email = "nuclei\@eisa.net.au";

# URL to the directory this script is running from.
$urltodir = "http://adultstorage.com/test";

# Auto submit to Search Engines? (1 for yes - 2 for no)
$submit= "1";

# Path to your sendmail program.
$mailprogram = "/usr/sbin/sendmail -t";


##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################





($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
if ($sec < 10) { $sec = "0$sec"; }
if ($min < 10) { $min = "0$min"; }
if ($hour < 10) { $hour = "0$hour"; }
if ($mday < 10) { $mday = "0$mday"; }
$date = "$mon/$mday/$year";
$time = "$hour:$min:$sec";

$site=shift || die "Usage:  $0 <directory> \"site name\"\n";
$sitename=shift || die "Usage:  $0 <directory> \"site name\"\n";
$scheme=&rand_line('grfx.txt');

sub get_rand {
  opendir(DIR, shift) or die "Failed to read directory listing.\n";
  @ents=grep { ! /^\./ } readdir(DIR);
  if($pre=shift) {  @ents = grep { /^$pre/ } @ents }
  closedir(DIR);
  return $ents[rand(@ents)];
}
sub rand_line {
  open(IN, shift);
  chomp(@a=<IN>);
  close(IN);
  return $a[rand(@a)];
}
sub rand_banner {
  $line=rand_line('banners.txt');
  my($bansrc,$banurl)=split '#', $line;
  push(@files, "banners/$bansrc");
  return "<a href=$banurl><img border=0 src=$bansrc></a>";
}


$bg=get_rand('backgrounds',$scheme);
$logo=get_rand('logos',$scheme);
$entbut=get_rand('enterbut',$scheme);
$extbut=get_rand('exitbut',$scheme);
$template=get_rand('templates');
push(@files, "logos/$logo","enterbut/$entbut","exitbut/$extbut","backgrounds/$bg");

{
  local $/=undef;
  open(IN, "templates/$template") or warn "Unable to open templates/$template: $!\n";
  $tmpl=<IN>;
  close(IN);
}

$tmpl=~s/%bg%/$bg/g;
$tmpl=~s/%logo%/$logo/g;
$tmpl=~s/%banner%/&rand_banner()/eg;
$tmpl=~s/%sitename%/$sitename/g;
$tmpl=~s/%entbut%/$entbut/g;
$tmpl=~s/%extbut%/$extbut/g;
system("mkdir sites");
system("chmod 0777 sites");
system("mkdir sites/$site");
system("chmod 0777 sites/$site");
system("cp @files sites/$site/");
open(OUT, ">sites/$site/index.html") or die "unable to open sites/$site for writing: $!\n";
print OUT $tmpl;
close(OUT);
system("chmod 0777 -R sites/$site");
system("cp content/* sites/$site");
system("chmod 0777 -R sites/$site");

$url = "$urltodir/sites/$site";

        open (MAIL,"|$mailprogram");
        print MAIL "To: $email\n";
        print MAIL "From: SiteGen\n";
        print MAIL "Subject:New site created!!\n";
        print MAIL " \n";
        print MAIL "On $date at $time, SiteGen created  \n";
        print MAIL " \n";
        print MAIL "Sitename: $sitename \n";
        print MAIL "URL: $urltodir/sites/$site \n";
        print MAIL " \n";
        print MAIL " \n";
        print MAIL "Now that you have one or more sites created \n";
        print MAIL "I suggest you go to their directories and get the \n";
        print MAIL "logo graphic for each site and customize it with the  \n";
        print MAIL "sites name. \n";
        print MAIL " \n";
        print MAIL " \n";

  if($submit == "1") {
$url = "$urltodir/sites/$site";
        print MAIL "I was also told to submit this site \n";
        print MAIL "to the major Search Engines. That has \n";
        print MAIL "been completed as requested! \n";
        print MAIL " \n";
	&altavista;
}
sub altavista {
        $port = 80;
        $remote = "add-url.altavista.digital.com";
        $add="/cgi-bin/newurl?ad=1&q=$url";
        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);
        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /will be indexed/)
        }
	if($success==1) {
          print MAIL "$url was submitted to altavista<br><br>\n"; 
        } else {
          print MAIL "Addition to Altavista failed. (Perhaps it allready exists?)\n";      
	}
	&webcrawler;
}

sub webcrawler {
        $port = 80;
        $remote = "info.webcrawler.com";
        $add="/cgi-bin/addURL.cgi?URLS=$url&action=add";
        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /was added to/)
        }
        close(SOCK);
	if($success==1) {
          print MAIL "$url was submitted to webcrawler<br><br>\n"; 
        } else {
          print MAIL "Addition to webcrawler failed. (Perhaps it allready exists?)\n";      
	}
	&lycos;
}


sub lycos {

        $port = 80;
        $remote = "www.lycos.com";
        $add="/cgi-bin/spider_now.pl?query=$url&email=$email&opt-in=on";
        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {

                $success = 1 if ($_ =~ /will be indexed/)
        }
	if($success==1) {
          print MAIL "$url was submitted to lycos<br><br>\n"; 
        } else {
          print MAIL "Addition to lycos failed. (Perhaps it allready exists?)\n";      
	}
	&aolnetfind;
}


sub aolnetfind {

        $port = 80;
        $remote = "netfind.aol.com";

        $add="/cgi/nfadd_url.cgi?look=netfind&url=$url&email=$email";

        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {

                $success = 1 if ($_ =~ /thanks/)
        }
	if($success==1) {
          print MAIL "$url was submitted to AOL Netfind<br><br>\n"; 
        } else {
          print MAIL "Addition to AOL Netfind failed. (Perhaps it allready exists?)\n";      
	}

	&worm;
}



sub worm {
        $port = 80;
        $remote = "www.goto.com";
        $add="/p/addsite.mp?URL=$url&EMAIL=$email";
        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /URL Submitted/)
                        
        }
	if($success==1) {
          print MAIL "$url was submitted to Goto<br><br>\n"; 
        } else {
          print MAIL "Addition to Goto failed. (Perhaps it allready exists?)\n";      
	}
	&excite;
}

sub excite {

        $port = 80;
        $remote = "www.excite.com";

        $add="/cgi/info.cgi?url=$url&email=$email&look=excite";


        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /Thank you/)
        }
	if($success==1) {
          print MAIL "$url was submitted to excite<br><br>\n"; 
        } else {
          print MAIL "Addition to excite failed. (Perhaps it allready exists?)\n";      
	}

	&seek;
}

sub seek {
        $port = 80;
        $remote = "www.whatuseek.com";

        $add="/cgi-bin/addurl?url=$url&email=$email&submit=Add+This+URL";

        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /Thank you/)
                        
        }
	if($success==1) {
          print MAIL "$url was submitted to WhatUseek<br><br>\n"; 
        } else {
          print MAIL "Addition to whatuseek failed. (Perhaps it allready exists?)\n";      
	}

	&hotbot;
}

sub hotbot {
        $port = 80;
        $remote = "main.hotbot.com";

        $add="/addurl2.html?newurl=$url&email=$email";

        $submit = "GET $add HTTP/1.0\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') }
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) {
                $success = 1 if ($_ =~ /Got it/)
        }
	if($success==1) {
          print MAIL "$url was submitted to hotbot<br><br>\n"; 
        } else {
          print MAIL "Addition to hotbot failed. (Perhaps it allready exists?)\n";      
	}
	&infoseek;
}


sub infoseek  {

        $port = 80;
        $remote = "www.infoseek.com";

        $add="/AddURL/addurl?pg=URLAddurl.html&sv=IS&lk=noframes&nh=10&url=$url";
       
                
        $submit = "GET $add HTTP/1.0\n\n\n";
        if ($port =~ /\D/) { $port = getservbyname($port, 'tcp') } 
        die "No port specified." unless $port;
        $iaddr   = inet_aton($remote)               || die "Could not find host: $remote";
        $paddr   = sockaddr_in($port, $iaddr);

        $proto   = getprotobyname('tcp');
        socket(SOCK, PF_INET, SOCK_STREAM, $proto)  || die "socket: $!";
        connect(SOCK, $paddr)    || die "connect: $!";
        send(SOCK,$submit,0);
        while(<SOCK>) { 
                $success = 1 if ($_ =~ /has been submitted/)
        }
        close(SOCK);
	if($success==1) {
          print MAIL "$url was submitted to infoseek<br><br>\n"; 
        } else {
          print MAIL "Addition to infoseek failed. (Perhaps it allready exists?)\n";      
	}

}


        print MAIL " \n";
        close (MAIL);

