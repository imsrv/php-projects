#!/usr/bin/perl

# Version 1.030
#################################################################
# EDIT BELOW
#################################################################
## This is the only line in this script that requires editing.
## Enter the full directory path to your config.pl file between
## The quotation marks.
## Example: require "/full/directory/path/to/config.pl";

require "/full/directory/path/to/config.pl";

# Save the file and do the same for the other files.
#################################################################
# DO NOT EDIT BELOW THIS LINE
#################################################################
# Define arrays for the day of the week and month of the year.           #
    @days   = ('Sunday','Monday','Tuesday','Wednesday',
	       'Thursday','Friday','Saturday');
    @months = ('January','February','March','April','May','June','July',
		 'August','September','October','November','December');

    # Get the current time and format the hour, minutes and seconds.  Add    #
    # 1900 to the year to get the full 4 digit year.                         #
    ($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
    $time = sprintf("%02d:%02d:%02d",$hour,$min,$sec);
    $year += 1900;

    # Format the date.                                                       #
    $date = "$days[$wday], $months[$mon] $mday, $year at $time";
######################################################

&login;
&verify;
exit;

sub login {

open (DAT,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
 @database_array = <DAT>;
close (DAT);


foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
          
if ($edit_array[0] eq $ENV{'REMOTE_USER'}) {last; }

}

if ($edit_array[0] eq $ENV{'REMOTE_USER'}) {

print "Content-type: text/html\n\n";
print "Welcome $edit_array[3] $edit_array[4]<BR>";


}
}

sub verify {

unless (-e "$memberinfo/$ENV{'REMOTE_USER'}.$mday") {


$difip = "1";

$newline2 = join
("\:",$ENV{'REMOTE_USER'},$ENV{'REMOTE_HOST'},$ENV{'REMOTE_ADDR'},$difip,0);
$newline2 .= "\n";

open(TEMP2, ">$memberinfo/$ENV{'REMOTE_USER'}.$mday") or print "unable to create user userlog file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(TEMP2, $LOCK_EX); #Locks the file
	}
print TEMP2 $newline2;
close (TEMP2);
exit;
}

open (USERLOG, "<$memberinfo/$ENV{'REMOTE_USER'}.$mday") or print "unable to open userlog.  Check your directory permission settings.";

if ($LOCK_EX){ 
      flock(USERLOG, $LOCK_EX); #Locks the file
	}
 @database_array = <USERLOG>;
close (USERLOG);



foreach $lines(@database_array) {
          @edit_array = split(/\:/,$lines);
}

if ($ENV{'REMOTE_ADDR'} != $edit_array[2]) {
$edit_array[3]++;
}



  if ($edit_array[3] > $userips) {
#print "Content-type: text/html\n\n";

  
open (FILE,"<$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	}
 @database_file = <FILE>;
close (FILE);
open (FILE2, ">$memberinfo/amdata.db");
if ($LOCK_EX){ 
      flock(FILE2, $LOCK_EX); #Locks the file
	}

foreach $lines(@database_file) {
          @edit_file = split(/\:/,$lines);
            if ($ENV{'REMOTE_USER'} =~ /$edit_file[0]\b/) {
            
$edit_file[1] = "Deleted $mon/$mday/$year";

}

$newline = join
("\:",@edit_file);

chomp($newline);
print FILE2 "$newline\n";
}


close (FILE2);




     
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

if ($ENV{'REMOTE_USER'} !~ /$edit_array[0]\b/) {
chomp $lines;
print DAT2 "$lines\n";

}

}
close(DAT2);
print "You've been deleted.";
exit;
}

open (USERLOG, ">>$memberinfo/$ENV{'REMOTE_USER'}.$mday") or print "unable to open userlog.  Check your directory permission settings.";


$newline2 = join
("\:",$ENV{'REMOTE_USER'},$ENV{'REMOTE_HOST'},$ENV{'REMOTE_ADDR'},$edit_array[3],0);
#$newline2 .= "\n";

print USERLOG "$newline2\n";
close (USERLOG);
exit;
}

