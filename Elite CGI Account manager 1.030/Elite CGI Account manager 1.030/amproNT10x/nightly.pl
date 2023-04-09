#!/usr/bin/perl

require "c:/full/path/to/config.pl";


##  (http://support.cgiscriptcenter.com)  ##

# Version 1.030
#################################################
# Define arrays for the day of the week and month of the year.           #
    @days   = ('Sunday','Monday','Tuesday','Wednesday',
	       'Thursday','Friday','Saturday');
    @months = ('01','02','03','04','05','06','07',
		 '08','09','10','11','12');

    # Get the current time and format the hour, minutes and seconds.  Add    #
    # 00 to the year to get the full 2 digit year.                         #
    ($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
    $time = sprintf("%02d:%02d:%02d",$hour,$min,$sec);
    $year += 1900;

    # Format the date.                                                       #
    $date = "$months[$mon].$mday.$year";



&backup;


sub backup {
open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

open (DAT2,">$backup/amdata.$date");
if ($LOCK_EX){ 
flock(DAT2, $LOCK_EX); #Locks the file
	}
          
print DAT2 @database_array;
close (DAT2);


if ($htaccess == "1") {

open (DAT3, "<$memaccess");
if ($LOCK_EX){ 
 flock(DAT3, $LOCK_EX); #Locks the file
	}
@database_array2 = <DAT3>;
             close (DAT3);

open (DAT4, ">$backup/htpasswd.$date");
if ($LOCK_EX){ 
 flock(DAT4, $LOCK_EX); #Locks the file
	}

print DAT4 @database_array2;
close (DAT4);

 }
}


sub htaccess {
if ($htaccess == "1") {
       open (DAT2, "<$memaccess"); 
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
             @database_array = <DAT2>;
             close (DAT2);

open (DAT2, ">$memaccess");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	} 

          foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);


if ($edit_array[0] !~ /$edit_array2[0]\b/) {
chomp($lines);
print DAT2 "$lines\n";
}

}
close (DAT2);
}
}



if ($acctlength) {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);

open (DAT, ">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);

$edit_array[29]--;

&renewal;

$newline = join
("\:",@edit_array);

chomp($newline);
print DAT "$newline\n";
}

}

close (DAT);

if ($acctlength) {
&dexpired;
}

sub renewal {

  if ($edit_array[29] == $renewal) {
# Output a temporary file

$body = ""; 
    
#    $body .= "To: $edit_array[2]\n";
#    $body .= "From: $orgmail ($orgname Support)\n";
#    $body .= "Subject: $orgname Account Renewal Notice\n";
    #Date
    $body .= "$date\n";
    
    # Check for Message Subject
    
    $body .= "-" x 75 . "\n\n";

    $body .= "This is a courtesy note, sent to remind you that your\n";
    $body .= "$orgname account will expire in $renewal days.\n\n";

    $body .= "Contact $orgname at $orgmail, or visit our website at\n";
    $body .= "$website to renew your account.\n\n";

    $body .= "Your $orgname User ID is: $edit_array[0]\n";
    $body .= "Your $orgname password is: $edit_array[1]\n\n";

    $body .= "please contact $orgname support at: $orgmail\n";
    $body .= "if you have any questions.\n\n";

    $body .= "$orgname Support Team\n";    
&sendmail("$edit_array[2]","$orgmail","$orgname Account Renewal Notice","$body");
       
  }
}


sub dexpired {

open (DAT2,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
 @database_array2 = <DAT2>;
close (DAT2);

foreach $lines2(@database_array2) {
          @edit_array2 = split(/\:/,$lines2);

if ($edit_array2[29] == 0) {


$username = $edit_array2[0];

open (DAT2, ">>$memberinfo/expired.db");
if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
     chomp $lines2;

print DAT2 "$lines2\n";
close (DAT2);

&htaccess;


  }
 }

open (DAT3,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT3, $LOCK_EX); #Locks the file
	}
 @database_array3 = <DAT3>;
close (DAT3);

open (DAT3, ">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT3, $LOCK_EX); #Locks the file
	}
foreach $lines3(@database_array3) {
          @edit_array3 = split(/\:/,$lines3);
          chomp $lines3;
if ($edit_array3[29] != 0) {

print DAT3 "$lines3\n";


  }

 }
close (DAT3);

}


sub  sendmail {


	my($to, $from, $subject, $body, $tempfile) = @_;

	if (lc $mailusing eq 'sendmail')   
		{
		open (MAIL, "|$mailprog -t") || print ("Can't open $mailprog!\n");
                if ($in{'html'}) {
                print MAIL "Content-type: text/html\n";
                }
		print MAIL "To: $to\r\n";
		print MAIL "From: $from\r\n";
		print MAIL "Subject: $subject\r\n";
                print MAIL "$body";

                print MAIL "\r\n\r\n";
		close MAIL;
		}
	else
			{
			$err = &sockets_mail($to, $from, $subject, $body); 
			if ($err < 1)
				{print "<br>\nSendmail error # $err<br>\n";}			
			}
		#}	
}


sub sockets_mail {

    my ($to, $from, $subject, $message) = @_;

    my ($replyaddr) = $from;
   
    if (!$to) { return -8; }

    my ($proto, $port, $smptaddr);

    my ($AF_INET)     =  2;
    my ($SOCK_STREAM) =  1;

    $proto = (getprotobyname('tcp'))[2];
    $port  = 25;

    $smtpaddr = ($smtp_addr =~ /^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/)
                    ? pack('C4',$1,$2,$3,$4)
                    : (gethostbyname($smtp_addr))[4];

    if (!defined($smtpaddr)) { return -1; }

    if (!socket(S, $AF_INET, $SOCK_STREAM, $proto))             { return -2; }
    if (!connect(S, pack('Sna4x8', $AF_INET, $port, $smtpaddr))) { return -3; }

    # my($oldfh) = select(S); $| = 1; select($oldfh);

    select(S);
    $| = 1;
    select(STDOUT);

    $_ = <S>; if (/^[45]/) { close S; return -4; }

    print S "helo localhost\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }

    print S "mail from: $from\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }
   
    print S "rcpt to: $to\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -6; }
    

    print S "data\r\n";
    $_ = <S>; if (/^[45]/) { close S; return -5; }

    if ($in{'html'}) {
    print S "Content-type: text/html\r\n";
    } else {
    print S "Content-Type: text/plain; charset=us-ascii\r\n";
    }
    print S "To: $to\r\n";
    print S "From: $from\r\n";
    print S "Reply-to: $replyaddr\r\n" if $replyaddr;
    print S "Subject: $subject\r\n\r\n";
    print S "$message";
    print S "\r\n.\r\n";

    $_ = <S>; if (/^[45]/) { close S; return -7; }

    print S "quit\r\n";
    $_ = <S>;

    close S;
    return 1;
}






exit;


