#!/usr/bin/perl

require "/full/path/to/config.pl";

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

    open (MAIL, "|$mailprog -t")
	            || print "Can't start mail program"; 
    
    print MAIL "To: $edit_array[2]\n";
    print MAIL "From: $orgmail ($orgname Support)\n";
    print MAIL "Subject: $orgname Account Renewal Notice\n";
    #Date
    print MAIL "$date\n";
    
    # Check for Message Subject
    
    print MAIL "-" x 75 . "\n\n";

    print MAIL "This is a courtesy note, sent to remind you that your\n";
    print MAIL "$orgname account will expire in $renewal days.\n\n";

    print MAIL "Contact $orgname at $orgmail, or visit our website at\n";
    print MAIL "$website to renew your account.\n\n";

    print MAIL "Your $orgname User ID is: $edit_array[0]\n";
    print MAIL "Your $orgname password is: $edit_array[1]\n\n";

    print MAIL "please contact $orgname support at: $orgmail\n";
    print MAIL "if you have any questions.\n\n";

    print MAIL "$orgname Support Team\n";    

    close (MAIL);
 
       
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



exit;


