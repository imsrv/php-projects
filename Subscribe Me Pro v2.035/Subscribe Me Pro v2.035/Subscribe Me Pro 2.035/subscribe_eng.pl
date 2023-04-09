




# Copyright 1999 - 2000 Diran Alemshah.  All Rights Reserved.
#
# LICENSOR'S PROGRAM IS COPYRIGHTED AND LICENSED (NOT SOLE).
# LICENSOR DOES NOT SELL OR TRANSFER TITLE TO THE LICENSED
# PROGRAM TO YOU. YOUR LICENSE OF THE LICENSED PROGRAM WILL
# NOT COMMENCE UNTIL YOU HAVE EXECUTED THIS AGREEMENT AND AN
# AUTHORIZED REPRESENTATIVE OF LICENSOR HAS RECEIVED, APPROVED,
# AND EXECUTED A COPY OF IT AS EXECUTED BY YOU.
# 1. License Grant.</B> Licensor hereby grants to you, and you
# accept, a nonexclusive license to use the downloaded computer
# programs, object code form only (collectively referred to as
# the &quot;Software&quot;), and any accompanying User Documentation,
# only as authorized in this License Agreement. The Software may be
# used on any website owned by Licensee, or if Licensee is a company
# or corporation, any website owned by Licensee company or corporation.
# You agree that you will not assign, sublicense, transfer, pledge,
# lease, rent, or share your rights under this License Agreement.
# You agree that you may not reverse assemble, reverse compile, or
# otherwise translate the Software<BR> <BR> Upon loading the Software
# into your computer, you may make a copy of the Software for
# backup purposes. You may make one copy of any User's Manual
# provided for backup purposes. Any such copies of the Software
# or the User's Manual shall include Licensor's copyright and other
# proprietary notices. Except as authorized under this paragraph,
# no copies of the Program or any portions thereof may be made by
# you or any person under your authority or control.
# 2. License Fees.  The license fees paid by you are paid
# in consideration of the licenses granted under this License
# Agreement. You are solely responsible for payment of any taxes
# (including sales or use taxes, intangible taxes, and property taxes)
# resulting from your acceptance of this license and your possession
# and use of the Licensed Program, exclusive of taxes based on
# Licensor's income. Licensor reserves the right to have you
# pay any such taxes as they fall due to Licensor for remittance to
# the appropriate authority. You agree to hold harmless Licensor
# from all claims and liability arising from your failure to report
# or pay such taxes.
# 3. This License Agreement is effective upon your submission of this form.
# 4. Limited Warranty. Licensor warrants, for your benefit alone,
# that the Licensed Program conforms in all material respects to
# the specifications for the current version of the Licensed Program.
# This warranty is expressly conditioned on your observance of the
# operating, security, and data-control procedures set forth in the
# User's Manual included with the Licensed Program.
# 
# EXCEPT AS EXPRESSLY SET FORTH IN THIS AGREEMENT, LICENSOR
# DISCLAIMS ANY AND ALL PROMISES, REPRESENTATIONS, AND WARRANTIES
# WITH RESPECT TO THE LICENSED PROGRAM, INCLUDING ITS CONDITION,
# ITS CONFORMITY TO ANY REPRESENTATION OR DESCRIPTION, THE EXISTENCE
# OF ANY LATENT OR PATENT DEFECTS, ANY NEGLIGENCE, AND ITS
# MERCHANTABILITY OR FITNESS FOR A PARTICULAR USE.
# 5. Limitation of Liability.</B> Licensor's cumulative liability
# to you or any other party for any loss or damages resulting
# from any claims, demands, or actions arising out of or relating
# to this Agreement shall not exceed the license fee paid to Licensor
# for the use of the Program. In no event shall Licensor be liable
# for any indirect, incidental, consequential, special, or exemplary
# damages or lost profits, even if Licensor has been advised of the
# possibility of such damages.
# 6. Proprietary Protection. Licensor shall have sole and exclusive
# ownership of all right, title, and interest in and to the Licensed
# Program and all modifications and enhancements thereof (including
# ownership of all trade secrets and copyrights pertaining thereto),
# subject only to the rights and privileges expressly granted to you
# herein by Licensor. This Agreement does not provide you with title
# or ownership of the Licensed Program, but only a right of limited
# use. You must keep the Licensed Program free and clear of all claims,
# liens, and encumbrances.
# 7. Restrictions. You may not use, copy, modify, or distribute the
# Licensed Program (electronically or otherwise), or any copy,
# adaptation, transcription, or merged portion thereof, except as
# expressly authorized by Licensor. You may not reverse assemble,
# reverse compile, or otherwise translate the Licensed Program.
# Your rights may not be transferred, leased, assigned, or sublicensed
# except for a transfer of the Licensed Program in its entirety to
# (1) a successor in interest of your entire business who assumes
# the obligations of this Agreement or (2) any other party who is
# reasonably acceptable to Licensor, enters into a substitute
# version of this Agreement, and pays an administrative fee intended
# to cover attendant costs. No service bureau work, multiple-user
# license, or time-sharing arrangement is permitted, except as
# expressly authorized by Licensor. If you use, copy, or modify
# the Licensed Program or if you transfer possession of any copy,
# adaptation, transcription, or merged portion of the Licensed
# Program to any other party in any way not expressly authorized
# by Licensor, your license is automatically terminated.
# 8. Licensor's Right Of Entry.</B> You hereby authorize Licensor
# to enter your premises in order to inspect the Licensed Program
# in any reasonable manner during regular business hours to verify
# your compliance with the terms hereof.
# 9. Injunctive Relief.</B> You acknowledge that, in the event
# of your breach of any of the foregoing provisions, Licensor
# will not have an adequate remedy in money or damages. Licensor
# shall therefore be entitled to obtain an injunction against such
# breach from any court of competent jurisdiction immediately upon
# request. Licensor's right to obtain injunctive relief shall not
# limit its right to seek further remedies.
# 10. Trademark. COMMISSION CART(TM), ACCOUNT MANAGER(TM), PICLINK
# ADVERTISER(TM), BANDWIDTH PROTECTOR(TM), PC CONFIGURATOR(TM),
# Subscribe Me(TM) Professional
# are all trademarks of Licensor. No right, license, or interest
# to such trademark is granted hereunder, and you agree that no
# such right, license, or interest shall be asserted by you with
# respect to such trademark.
# 11. Governing Law.  This License Agreement shall be construed
# and governed in accordance with the laws of the State of California,
# USA.
# 12. Costs of Litigation. If any action is brought by either party
# to this License Agreement against the other party regarding the
# subject matter hereof, the prevailing party shall be entitled
# to recover, in addition to any other relief granted, reasonable
# attorney fees and expenses of litigation.
# 13. Severability. Should any term of this License Agreement be
# declared void or unenforceable by any court of competent
# jurisdiction, such declaration shall have no effect on the
# remaining terms hereof.
# 14. No Waiver. The failure of either party to enforce any
# rights granted hereunder or to take action against the other
# party in the event of any breach hereunder shall not be deemed
# a waiver by that party as to subsequent enforcement of rights
# or subsequent actions in the event of future breaches.
# 15. Integration.  THIS AGREEMENT IS THE COMPLETE AND EXCLUSIVE
# STATEMENT OF LICENSOR'S OBLIGATIONS AND RESPONSIBILITIES TO YOU
# AND SUPERSEDES ANY OTHER PROPOSAL, REPRESENTATION, OR OTHER
# COMMUNICATION BY OR ON BEHALF OF LICENSOR RELATING TO THE
# SUBJECT MATTER HEREOF
################################################################

&MethGet;
&MethPost;
&ReadParse;


sub ReadParse {
  local (*in) = @_ if @_;
  local ($i, $key, $val);

  # Read in text
  if (&MethGet) {
    $in = $ENV{'QUERY_STRING'};
  } elsif (&MethPost) {
    read(STDIN,$in,$ENV{'CONTENT_LENGTH'});
  }

  @in = split(/[&;]/,$in); 

  foreach $i (0 .. $#in) {
    # Convert plus's to spaces
    $in[$i] =~ s/\+/ /g;

    # Split into key and value.  
    ($key, $val) = split(/=/,$in[$i],2); # splits on the first =.

    # Convert %XX from hex numbers to alphanumeric
    $key =~ s/%(..)/pack("c",hex($1))/ge;
    $val =~ s/%(..)/pack("c",hex($1))/ge;

    # Associate key and value
    $in{$key} .= "\0" if (defined($in{$key})); # \0 is the multiple separator
    $in{$key} .= $val;

  }

  return scalar(@in); 
}
# MethGet
# Return true if this cgi call was using the GET request, false otherwise

sub MethGet {
  return ($ENV{'REQUEST_METHOD'} eq "GET");
}


# MethPost
# Return true if this cgi call was using the POST request, false otherwise

sub MethPost {
  return ($ENV{'REQUEST_METHOD'} eq "POST");
}

$val =~ s/<!--(.|\n)*-->//g;


# Define arrays for the day of the week and month of the year.           #
    @days   = ('Sunday','Monday','Tuesday','Wednesday',
	       'Thursday','Friday','Saturday');
    @months = ('01','02','03','04','05','06','07',
		 '08','09','10','11','12');

    # Get the current time and format the hour, minutes and seconds.  Add    #
    # 1900 to the year to get the full 4 digit year.                         #
    ($sec,$min,$hour,$mday,$mon,$year,$wday) = (localtime(time))[0,1,2,3,4,5,6];
    $time = sprintf("%02d:%02d:%02d",$hour,$min,$sec);
    $year += 1900;

    # Format the date.                                                       #
    $datename = "$months[$mon]-$mday-$year";
    $date2 = "$months[$mon]/$mday/$year";




$thetime = time();

$cgiurl = $ENV{'SCRIPT_NAME'};
$servername = $ENV{'SERVER_NAME'};

################################################################
# DO NOT EDIT ABOVE PARAGRAPH
################################################################


###############################################################
# DO NOT EDIT BELOW THIS LINE
###############################################################

$version = "2.035";



$sminstaller = $ENV{'SCRIPT_NAME'};
$sminstaller =~ s/s\.cgi$/setup\.cgi/;
$sminstaller =~ s/s\.pl$/setup\.pl/;



if ($in{'subscribe'} eq "subscribe") { &subscribe; }
elsif ($in{'subscribe'} eq "unsubscribe")  {&unsubscribe; }
elsif ($in{'r'}) {&unsubscribe;}
elsif ($in{'a'}) {&subscribe;}
elsif ($in{'page'}) {&track;}
elsif ($in{'mailing'}) {&mailing; }
elsif ($in{'create_list'}) {&create_list; }
elsif ($in{'setpwd'}) {&setpwd; }
elsif ($in{'edit_manually'}) {&edit_manually; }
elsif ($in{'edit_manually2'}) {&edit_manually2; }
elsif ($in{'manual_update'}) {&manual_update; }
elsif ($in{'manual_update2'}) {&manual_update2; }
elsif ($in{'view_list'}) {&viewaddresses; }
elsif ($in{'viewtracking'}) {&viewtracking; }
elsif ($in{'list_backup'}) {&list_backup; }
elsif ($in{'track_results'}) {&track_results; }
elsif ($in{'adminreturn'}) {&adminpanel; }
elsif ($in{'form2'}) {&form2; }
elsif ($in{'passcheck'}) {&passcheck; }
elsif ($in{'add_list'}) {&add_list; }
elsif ($in{'delete_list'}) {&delete_list; }
elsif ($in{'list_details'}) {&list_details; }
elsif ($in{'delete2'}) {&delete2; }
elsif ($in{'edit_list'}) {&edit_list; }
elsif ($in{'update_list'}) {&update_list; }
elsif ($in{'graphic'}) {&display_graphic; }
elsif ($in{'enterpass'}) {&passcheck; }
elsif ($in{'log_off'}) {&log_off; }
else {&adminpass; }
exit;



#$cgiurl = $ENV{'SCRIPT_NAME'};

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




########################################################
# Subroutine FIND - Will find member info and email it
########################################################




sub subscribe {


unless (($in{'l'}) && (-e "$lists/$in{'l'}.list")) {
print "Content-type: text/html\n\n";
print "That list does not exists.<BR>";
exit;
}

undef($optin);

# unless ($in{'list_name'}) {

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);
chomp($lines);

# print "$edit_db[0],$in{'list_name'}<BR>";

if ($edit_db[0] == $in{'l'}) { 


$in{'list_name'} = $edit_db[1];
$in{'admin_email'} = $edit_db[2];
if (lc $edit_db[4] eq 'optin') {
$optin = 1;
}
last;
  }
 }
# }

&checkaddress;

open (DAT,"$lists/$in{'l'}.list");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
@database_array = <DAT>;
close(DAT);

        foreach $lines(@database_array) {
         chomp($lines);            


&parseemail;

if ($existing eq $email) {
         
open (ALRESPONSE,"<$lists/$in{'l'}.alsignup");
 if ($LOCK_EX){ 
      flock(ALRESPONSE, $LOCK_EX); #Locks the file
	}
 @al_data = <ALRESPONSE>;
 close (ALRESPONSE);

## Already Listed HTML Response

print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesal(@al_data) {
    $linesal =~ s/<E-MAIL>/$in{'e'}/g;
    $linesal =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesal =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesal =~ s/<SERVER_NAME>/$servername/g;
    $linesal =~ s/<CGI_URL>/$cgiurl/g;
    $linesal =~ s/<LIST>/$in{'l'}/g;
    $linesal =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$linesal";

}
&footer;
exit;

 } 
 }


if (($optin) && (!$in{'p'}) && (!$in{'session_id'})) {

    # First, seed the random number generator
	srand;

	# Then get a random # for which a file name can be created
	$randOptin = int(rand(999999));

      open (DAT,">$tempdir/$in{'l'}-$in{'e'}.optin");
       if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
      print DAT "$randOptin";
      close(DAT);

    print "Content-type: text/html\n\n";

open (OPTINHTMLRESPONSE,"<$lists/$in{'l'}.optinresponse");
 if ($LOCK_EX){ 
      flock(OPTINHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
 @optinhtml_data = <OPTINHTMLRESPONSE>;
 close (OPTINHTMLRESPONSE);

## Already Listed HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesoph(@optinhtml_data) {
    $linesoph =~ s/<E-MAIL>/$in{'e'}/g;
    $linesoph =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesoph =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesoph =~ s/<SERVER_NAME>/$servername/g;
    $linesoph =~ s/<CGI_URL>/$cgiurl/g;
    $linesoph =~ s/<LIST>/$in{'l'}/g;
    $linesoph =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$linesoph";

}


&footer;


$servername = $ENV{'SERVER_NAME'};
$from = $in{'admin_email'};

$body = "";
				
open (OPTRESPONSE,"<$lists/$in{'l'}.optinsignup");
 if ($LOCK_EX){ 
      flock(OPTRESPONSE, $LOCK_EX); #Locks the file
	}
 @opt_data = <OPTRESPONSE>;
 close (OPTRESPONSE);


foreach $linesd(@opt_data) {
# $linesd =~ s/\r//g;

    $linesd =~ s/<E-MAIL>/$in{'e'}/g;
    $linesd =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesd =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesd =~ s/<SERVER_NAME>/$servername/g;
    $linesd =~ s/<CGI_URL>/$cgiurl/g;
    $linesd =~ s/<LIST>/$in{'l'}/g;
    $linesd =~ s/<SECURE_CODE>/$randOptin/g;

$body .= "$linesd";
}
&sendmail("$in{'e'}","$in{'admin_email'}","Your Confirmation Required","$body");
exit;
} else {

      if (($optin) && !$in{'session_id'}) {
      undef $/;
      open (DAT2,"<$tempdir/$in{'l'}-$in{'e'}.optin");
       if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
      $input_array = <DAT2>;
      close(DAT2);
      $/ = "\n";

      unless ($in{'p'} eq $input_array) {
      print "Content-type: text/html\n\n";

open (NMRESPONSE,"<$lists/$in{'l'}.nmresponse");
 if ($LOCK_EX){ 
      flock(NMRESPONSE, $LOCK_EX); #Locks the file
	}
 @nm_data = <NMRESPONSE>;
 close (NMRESPONSE);

## No Match HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesnm(@nm_data) {
    $linesnm =~ s/<E-MAIL>/$in{'e'}/g;
    $linesnm =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesnm =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesnm =~ s/<SERVER_NAME>/$servername/g;
    $linesnm =~ s/<CGI_URL>/$cgiurl/g;
    $linesnm =~ s/<LIST>/$in{'l'}/g;
    $linesnm =~ s/<ADMIN_MAIL>/$edit_db[2]/g;
    $linesnm =~ s/<SECURE_CODE>/$in{'p'}/g;

print "$linesnm";

}

&footer;
      exit;
       }
      unlink("$tempdir/$in{'l'}-$in{'e'}.optin");
      } elsif ($in{'session_id'})  {
      &sessioncheck;
      }

      print "Content-type: text/html\n\n";
      open (DAT,">>$lists/$in{'l'}.list") || die print"Permissions Error - Can't open $in{'l'}.list file.";
      if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
         print DAT "$in{'e'}\n" || die print"Permissions Error - can't write to $in{'l'}.list file.";
              close (DAT);

              
open (SRESPONSE,"<$lists/$in{'l'}.ssignup");
 if ($LOCK_EX){ 
      flock(SRESPONSE, $LOCK_EX); #Locks the file
	}
 @s_data = <SRESPONSE>;
 close (SRESPONSE);

## Success HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $liness(@s_data) {
    $liness =~ s/<E-MAIL>/$in{'e'}/g;
    $liness =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $liness =~ s/<WEBSITEURL>/$websiteurl/g;
    $liness =~ s/<SERVER_NAME>/$servername/g;
    $liness =~ s/<CGI_URL>/$cgiurl/g;
    $liness =~ s/<LIST>/$in{'l'}/g;
    $liness =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$liness";

}

&footer;

unless ($in{'usernotify'}) {

$servername = $ENV{'SERVER_NAME'};
$from = $in{'admin_email'};

$body = "";

open (RESPONSE,"<$lists/$in{'l'}.signup");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
 @data = <RESPONSE>;
 close (RESPONSE);


foreach $linesd(@data) {
# $linesd =~ s/\r//g;

    $linesd =~ s/<E-MAIL>/$in{'e'}/g;
    $linesd =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesd =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesd =~ s/<SERVER_NAME>/$servername/g;
    $linesd =~ s/<CGI_URL>/$cgiurl/g;
    $linesd =~ s/<LIST>/$in{'l'}/g;

$body .= "$linesd";
}


				  
&sendmail("$in{'e'}","$in{'admin_email'}","You've Been Added!","$body");
}

if ($notification eq "ON") {
&notifyadminadded;
 }
}
exit;
}

sub unsubscribe {



undef($optout);

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);

if ($edit_db[0] == $in{'l'}) { 


$in{'list_name'} = $edit_db[1];
$in{'admin_email'} = $edit_db[2];
if (lc $edit_db[5] eq 'optout') {
$optout = 1;
}
last; 
  }
 }

&checkaddress;


undef($found);

open (DAT,"<$lists/$in{'l'}.list");
       if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}

@database_array = <DAT>;
close(DAT);

         foreach $lines(@database_array) {
         chomp($lines);
         $lines =~ s/\r//;


&parseemail;



if ($existing eq $email) {
$found = "1";
}
}

unless ($found) {
open (NFRESPONSE,"<$lists/$in{'l'}.nfresponse");
 if ($LOCK_EX){ 
      flock(NFRESPONSE, $LOCK_EX); #Locks the file
	}
 @nf_data = <NFRESPONSE>;
 close (NFRESPONSE);



## Not Found HTML Response

print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesnf(@nf_data) {
    $linesnf =~ s/<E-MAIL>/$in{'e'}/g;
    $linesnf =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesnf =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesnf =~ s/<SERVER_NAME>/$servername/g;
    $linesnf =~ s/<CGI_URL>/$cgiurl/g;
    $linesnf =~ s/<LIST>/$in{'l'}/g;
    $linesnf =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$linesnf";

}
    
&footer;
close (DAT);
exit;
}    










if (($optout) && (!$in{'p'}) && (!$in{'session_id'})) {

# First, seed the random number generator
	srand;

	# Then get a random # for which a file name can be created
	$randOptout = int(rand(999999));

      open (DAT,">$tempdir/$in{'l'}-$in{'e'}.optout");
       if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
      print DAT "$randOptout";
      close(DAT);

    print "Content-type: text/html\n\n";

open (OPTOUTHTMLRESPONSE,"<$lists/$in{'l'}.optoutsignup");
 if ($LOCK_EX){ 
      flock(OPTOUTHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
 @optouthtml_data = <OPTOUTHTMLRESPONSE>;
 close (OPTOUTHTMLRESPONSE);

## Opt Out HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesopouth(@optouthtml_data) {
    $linesopouth =~ s/<E-MAIL>/$in{'e'}/g;
    $linesopouth =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesopouth =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesopouth =~ s/<SERVER_NAME>/$servername/g;
    $linesopouth =~ s/<CGI_URL>/$cgiurl/g;
    $linesopouth =~ s/<LIST>/$in{'l'}/g;
    $linesopouth =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$linesopouth";

}


&footer;


$servername = $ENV{'SERVER_NAME'};
$from = $in{'admin_email'};

$body = "";
				
open (OPTOUTRESPONSE,"<$lists/$in{'l'}.optoutresponse");
 if ($LOCK_EX){ 
      flock(OPTOUTRESPONSE, $LOCK_EX); #Locks the file
	}
 @optout_data = <OPTOUTRESPONSE>;
 close (OPTOUTRESPONSE);


foreach $linesopout(@optout_data) {
# $linesd =~ s/\r//g;

    $linesopout =~ s/<E-MAIL>/$in{'e'}/g;
    $linesopout =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesopout =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesopout =~ s/<SERVER_NAME>/$servername/g;
    $linesopout =~ s/<CGI_URL>/$cgiurl/g;
    $linesopout =~ s/<LIST>/$in{'l'}/g;
    $linesopout =~ s/<SECURE_CODE>/$randOptout/g;

$body .= "$linesopout";
}
&sendmail("$in{'e'}","$in{'admin_email'}","Your Confirmation Required","$body");
exit;

 
} else {


if (($optout) && !$in{'session_id'}) {
      undef $/;
      open (DAT2,"<$tempdir/$in{'l'}-$in{'e'}.optout");
       if ($LOCK_EX){ 
      flock(DAT2, $LOCK_EX); #Locks the file
	}
      $input_array = <DAT2>;
      close(DAT2);
      $/ = "\n";

      unless ($in{'p'} eq $input_array) {
      print "Content-type: text/html\n\n";

open (NMRESPONSE,"<$lists/$in{'l'}.nmresponse");
 if ($LOCK_EX){ 
      flock(NMRESPONSE, $LOCK_EX); #Locks the file
	}
 @nm_data = <NMRESPONSE>;
 close (NMRESPONSE);

## No Match HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesnm(@nm_data) {
    $linesnm =~ s/<E-MAIL>/$in{'e'}/g;
    $linesnm =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesnm =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesnm =~ s/<SERVER_NAME>/$servername/g;
    $linesnm =~ s/<CGI_URL>/$cgiurl/g;
    $linesnm =~ s/<LIST>/$in{'l'}/g;
    $linesnm =~ s/<ADMIN_MAIL>/$edit_db[2]/g;
    $linesnm =~ s/<SECURE_CODE>/$in{'p'}/g;

print "$linesnm";

}

&footer;
      exit;
       }
      unlink("$tempdir/$in{'l'}-$in{'e'}.optout");
      } elsif ($in{'session_id'})  {
      &sessioncheck;
      }


open (DAT,"$lists/$in{'l'}.list");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
@database_array = <DAT>;
close(DAT);

print "Content-type: text/html\n\n";

open (DAT,"<$lists/$in{'l'}.list");
      if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
         foreach $lines(@database_array) {
         chomp($lines);
         $lines =~ s/\r//;
         
&parseemail;


if ($existing eq $email) {

open (RRESPONSE,"<$lists/$in{'l'}.rremoval");
 if ($LOCK_EX){ 
      flock(RRESPONSE, $LOCK_EX); #Locks the file
	}
 @r_data = <RRESPONSE>;
 close (RRESPONSE);

## Removal HTML Response

#print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesr(@r_data) {
    $linesr =~ s/<E-MAIL>/$in{'e'}/g;
    $linesr =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesr =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesr =~ s/<SERVER_NAME>/$servername/g;
    $linesr =~ s/<CGI_URL>/$cgiurl/g;
    $linesr =~ s/<LIST>/$in{'l'}/g;
    $linesr =~ s/<ADMIN_MAIL>/$edit_db[2]/g;

print "$linesr";

}
&footer;
close (DAT);
  
        
   open (DAT,">$lists/$in{'l'}.list");
       if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
         foreach $lines(@database_array) {
         chomp($lines);

&parseemail;


if ($existing ne $email) {


#   if ($lines !~ /$in{'e'}/i) {
       
              print DAT "$lines\n";
              
              }
}
              close (DAT);

unless ($in{'usernotify'}) {

$servername = $ENV{'SERVER_NAME'};


$body = "";

open (RESPONSE,"<$lists/$in{'l'}.removal");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
 @data = <RESPONSE>;
 close (RESPONSE);


foreach $linesd(@data) {
# $linesd =~ s/\r//g;

    $linesd =~ s/<E-MAIL>/$in{'e'}/g;
    $linesd =~s/<LIST_NAME>/$in{'list_name'}/g;
    $linesd =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesd =~ s/<SERVER_NAME>/$servername/g;
    $linesd =~ s/<CGI_URL>/$cgiurl/g;
    $linesd =~ s/<LIST>/$in{'l'}/g;

$body .= "$linesd";
}				


				
&sendmail("$in{'e'}","$in{'admin_email'}","You've Been Removed!","$body");

}

if ($notification eq "ON") {
&notifyadmindeleted;
}

exit;
  }
 } # NEW - Double Opt Out
} 


}

sub form2 {
# &blindcheck;

&sessioncheck;

print "Content-type: text/html\n\n";
&header;
$section_title = "Mass Mailing Form";
&header2;
print<<EOF;

    <FORM ACTION="$cgiurl" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD ALIGN="CENTER">
        <TABLE BORDER="0">
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/mailsubject.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Subject:</B></FONT></TD>
            <TD COLSPAN="2"><INPUT TYPE="TEXT" SIZE="30" NAME="mail_subject"></TD>
          </TR>
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/tolists.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>To
            List(s):</B></FONT></TD>
            <TD COLSPAN="2"><SELECT NAME="to_lists" SIZE="1">
            <OPTION VALUE="choose" SELECTED="SELECTED">Choose list to send to</OPTION>
EOF

open (LISTS, "<$lists/lists.db");
 if ($LOCK_EX){ 
      flock(LISTS, $LOCK_EX); #Locks the file
	}
@list_array = <LISTS>;
close(LISTS);

foreach $lines(@list_array) {
@edit_array = split(/\|/,$lines);

print "<OPTION VALUE=\"$edit_array[0]\">$edit_array[1]</OPTION>\n";

}

print<<EOF;

</SELECT></TD>
          </TR>

          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/sendhtml.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Send as HTML:</B></FONT></TD>
            <TD><INPUT TYPE="CHECKBOX" NAME="html" ALIGN="BOTTOM"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>(Sendmail and Sockets mail only)</B></FONT></TD>
          </TR>
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/removelink.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Remove Link:</B></FONT></TD>
            <TD><INPUT TYPE="CHECKBOX" NAME="no_credit" ALIGN="BOTTOM"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>(Removes "Powered by Subscribe Me" link) from mailings.</B></FONT></TD>
          </TR>
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/unsubscribelink.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Include
            Unsubscribe Address Link:</B></FONT></TD>
            <TD><INPUT TYPE="CHECKBOX" NAME="unsubscribe_address" ALIGN="BOTTOM"></TD>
            <TD></TD>
          </TR>
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/trackmailings.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A></TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Track All
            Clicks from Mailings:</B></FONT></TD>
            <TD><INPUT TYPE="CHECKBOX" NAME="tracking" ALIGN="BOTTOM"> </TD>
            <TD><INPUT TYPE="TEXT" NAME="useurl" VALUE="$websiteurl"></TD>
          </TR>
          <TR>
            <TD><A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/adminpass.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
</TD>
            <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Administration
            Password:</B></FONT></TD>
            <TD COLSPAN="2"><INPUT TYPE="PASSWORD" NAME="password" SIZE="30"></TD>
          </TR>
        </TABLE><TEXTAREA NAME="message" ROWS="12" COLS="50" WRAP="OFF"></TEXTAREA><BR>
        <INPUT TYPE="SUBMIT" VALUE="    Send    " NAME="mailing"><INPUT TYPE="RESET" NAME="">
        </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF

&footer2;
&footer;
exit;
}




sub checkaddress {

$in{'e'} =~ s/\s//g;

unless ($in{'e'} =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $in{'e'} !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
        } else {
         $legalemail = 0;
        }


if ($legalemail !~ 1) {

open (IMPROPERRESPONSE,"<$lists/$in{'l'}.impropersignup");
 if ($LOCK_EX){ 
      flock(IMPROPERRESPONSE, $LOCK_EX); #Locks the file
	}
 @ia_data = <IMPROPERRESPONSE>;
 close (IMPROPERRESPONSE);

## No Match HTML Response

print "Content-type: text/html\n\n";

&no_javascriptheader;

foreach $linesia(@ia_data) {
    $linesia =~ s/<E-MAIL>/$in{'e'}/g;
    $linesia =~ s/<LIST_NAME>/$in{'list_name'}/g;
    $linesia =~ s/<WEBSITEURL>/$websiteurl/g;
    $linesia =~ s/<SERVER_NAME>/$servername/g;
    $linesia =~ s/<CGI_URL>/$cgiurl/g;
    $linesia =~ s/<LIST>/$in{'l'}/g;
    $linesia =~ s/<ADMIN_MAIL>/$edit_db[2]/g;
    $linesia =~ s/<SECURE_CODE>/$in{'p'}/g;

print "$linesia";
}

&footer;
exit;
}
}

sub adminpass {


if (-e "$passfile/password.txt") {

print "Content-type: text/html\n\n";
&header;
&header3;
print<<EOF;

    
    <FORM ACTION="$cgiurl" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="enterpass" VALUE="1">
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P ALIGN="CENTER"><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
           Administration Password</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">The Administration
          section is restricted to authorized individuals only. Please enter the
          Administration password below.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Password</B></FONT><BR>
            <INPUT TYPE="PASSWORD" NAME="pwd"></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="passcheck" VALUE="  Enter Password  " CHECKED="CHECKED"><INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR>
      <TR>
        <TD><BR>
        <FONT SIZE="-2" FACE="arial, helvetica"><B>Enable Javascript
        on your web browser to see script update information below.</B></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica"><B>Version Information</B></FONT></TD>
      </TR>
        <TR>
        <TD BGCOLOR="#000000">
        <TABLE BORDER="0" WIDTH="400" BGCOLOR="#FFFFFF" CELLPADDING="0" CELLSPACING="0">
       <TR>
        <TD ALIGN="CENTER" WIDTH="50%"><FONT SIZE="-2" FACE="arial, helvetica">Your
        Version:</FONT></TD>
        <TD ALIGN="CENTER" WIDTH="50%"><FONT SIZE="-2" FACE="arial, helvetica">$version</FONT></TD>
      </TR>

<SCRIPT LANGUAGE="javascript1.1" SRC="http://www.cgiscriptcenter.com/subscribe/install/js.js">
</SCRIPT>
          
        </TABLE></TD>
      </TR>
    </TABLE></CENTER>

<CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica"><B>News Updates</B></FONT></TD>
      </TR>
        <TR>
        <TD BGCOLOR="#000000">
        <TABLE BORDER="0" WIDTH="400" BGCOLOR="#FFFFFF" CELLPADDING="4" CELLSPACING="0">
<SCRIPT LANGUAGE="javascript1.1" SRC="http://www.cgiscriptcenter.com/subscribe/install/jsnews.js">
</SCRIPT>
          
        </TABLE></TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer3;
&footer;
exit;

} else {

print "Content-type: text/html\n\n";
&header;
&header3;
print<<EOF;

    <FORM ACTION="$sminstaller" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="setpwd" VALUE="1">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Set Password!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You have not yet
          set your administration password! Please enter your password below,
          once to set the password and the second time to confirm it.</FONT></P>
        <CENTER>
        <TABLE BORDER="0">
          <TBODY>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">password</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="RIGHT"><INPUT TYPE="PASSWORD" NAME="pwd2"></TD>
            <TD><FONT SIZE="-2" FACE="verdana, arial, helvetica">confirmation</FONT></TD>
          </TR>
          <TR>
            <TD ALIGN="CENTER"><BR>
            <INPUT TYPE="SUBMIT" NAME="setpwd" VALUE="  Set Password  "></TD>
            <TD><BR>
            <INPUT TYPE="RESET" NAME=""></TD>
          </TR></TBODY>
        </TABLE></CENTER> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer3;
&footer;
exit;
 }
}


sub blindcheck {
open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);

		if ($in{'pwd'}) {
			$newpassword = crypt($in{'pwd'}, 'aa');
		}
		else {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
    <FORM ACTION="$cgiurl" METHOD="POST">
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe Me
         </FONT> Status: Password Error!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Please enter your
          password!</FONT></P> </TD>
      </TR></TBODY>
    </TABLE></CENTER></FORM>
EOF
&footer;
exit;
		}
		unless ($newpassword eq $password) {
print "Content-type: text/html\n\n";
&header;
print<<EOF;
<FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\" TARGET=\"_blank\"><B>Subscribe Me $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM>
EOF
exit;

}
}






sub passcheck {

open (PASSWORD, "$passfile/password.txt");
           if ($LOCK_EX){ 
      flock(PASSWORD, $LOCK_EX); #Locks the file
	}
		$password = <PASSWORD>;
		close (PASSWORD);
		chop ($password) if ($password =~ /\n$/);


		if ($in{'pwd'}) {
			$newpassword = crypt($in{'pwd'}, 'aa');
		}
		else {
                  print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Subscribe Me: Password Error!</TITLE></HEAD><BODY
BGCOLOR=\"#FFFFFF\"><FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Please enter your password!</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\" TARGET=\"_blank\"><B>Subscribe
Me $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM></BODY></HTML>";
exit;
		}
		unless ($newpassword eq $password) {
                  print "Content-type: text/html\n\n";
print "<HTML><HEAD><TITLE>Subscribe Me: Password Error!</TITLE></HEAD><BODY
BGCOLOR=\"#FFFFFF\"><FORM ACTION=\"$cgiurl\" METHOD=\"POST\"><CENTER><BR>
<TABLE BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><P><B><FONT FACE=\"verdana, arial, helvetica\"><FONT
COLOR=\"#FF0000\">Subscribe Me</FONT> Status:  Password Error!</FONT></B></P>
<P><FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">Incorrect password!  Please enter the correct password.</FONT></P>
<CENTER><TABLE
BORDER=\"0\" WIDTH=\"400\"><TBODY><COLDEFS><COLDEF></COLDEFS><ROWS><TR><TD
COLSTART=\"1\"><HR SIZE=\"1\"></TD></TR><TR><TD ALIGN=\"CENTER\" COLSTART=\"1\"><FONT
SIZE=\"-2\" FACE=\"verdana, arial, helvetica\">
Maintained with  <A HREF=\"http://www.cgiscriptcenter.com/subpro/index2.html\" TARGET=\"_blank\"><B>Subscribe
Me $version</B></A></FONT></TD></TR></ROWS></TBODY></TABLE></CENTER></TD></TR></ROWS></TBODY></TABLE></CENTER></FORM></BODY></HTML>";
exit;
		}
#&form2;
&sessionid;
&adminpanel;
}

sub sessionid {
&blindcheck;


	srand($thetime);
	$session ="";
	@passset = ('a'..'z', 'A'..'Z', '1'..'9');
	for ($i = 0; $i < 15; $i++) {
		$randum_num = int(rand($#passset + 1));
		$session .= @passset[$randum_num];
	}



open(SESSIONID, ">$memberinfo/session.id");
           if ($LOCK_EX){ 
      flock(SESSIONID, $LOCK_EX); #Locks the file
	}


print SESSIONID "$session";
close(SESSIONID);

$in{'session_id'} = "$session";

open(SESSIONTIME, ">$memberinfo/session.time");
           if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}


print SESSIONTIME "$thetime";
close(SESSIONTIME);

}


sub parseemail {

$email = $in{'e'};
$existing = $lines;
$existing =~ tr/A-Z/a-z/;
$email =~ tr/A-Z/a-z/;

}

sub header {
open (FILE,"<$memberinfo/default.header"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @headerfile = <FILE>;
 close(FILE);
print "<HTML><HEAD><TITLE></TITLE>
<SCRIPT LANGUAGE=\"JavaScript\">
<!-- Begin
function Start(page) {
OpenWin = this.open(page, \"CtrlWindow\", [\"toolbar=no,menubar=no,location=no,scrollbars=yes,resize=yes,height=350,width=520\"]);
}
// End -->

</SCRIPT>
</HEAD><BODY TEXT=\"#000040\" LINK=\"#0000FF\" VLINK=\"#0000FF\" ALINK=\"#FF0000\">\n";
foreach $line(@headerfile) {
print "$line";
  }
}



sub no_javascriptheader {
open (FILE,"<$memberinfo/default.header"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @headerfile = <FILE>;
 close(FILE);
print "<HTML><HEAD><TITLE></TITLE>
</HEAD><BODY TEXT=\"#000040\" LINK=\"#0000FF\" VLINK=\"#0000FF\" ALINK=\"#FF0000\">\n";
foreach $line(@headerfile) {
print "$line";
  }
}



sub footer {
open (FILE,"<$memberinfo/default.footer"); #### Full path name from root.
if ($LOCK_EX){ 
      flock(FILE, $LOCK_EX); #Locks the file
	} 
 @footerfile = <FILE>;
 close(FILE);
foreach $line(@footerfile) {
print "$line";

}
if (lc $link eq "partial_credit") {
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD><HR SIZE="1"></TD>
      </TR>
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-2" FACE="verdana, arial, helvetica">
        <FONT COLOR="#C0C0C0">Maintained with <B>Subscribe Me $version</B></FONT></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</BODY></HTML>
EOF
} elsif (lc $link eq "no_credit") {
print<<EOF;
</BODY></HTML>
EOF
} else {
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD><HR SIZE="1"></TD>
      </TR>
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-2" FACE="verdana, arial, helvetica">
        Maintained with <A HREF="http://www.subscribemepro.com/" TARGET="_blank"><B>Subscribe
          Me $version</B></A></FONT></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</BODY></HTML>
EOF
}
}


sub sessioncheck {

open(SESSIONTIME, "<$memberinfo/session.time");
if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}
 $session_time = <SESSIONTIME>;
 close(SESSIONTIME);

$user_session = $thetime - $session_time;

open(SESSIONID, "<$memberinfo/session.id");
if ($LOCK_EX){ 
      flock(SESSIONID, $LOCK_EX); #Locks the file
	}
 $session_variable = <SESSIONID>;
 close(SESSIONID);

unless (($in{'session_id'} eq "$session_variable") && ("$user_session" < "$config_session") && ($session_variable)) {
# print "Content-type: text/html\n\n";
# print "No match: Input Session ID = $in{'session_id'} - Session Variable = # $session_variable<BR>User Session = $user_session";
&adminpass;
exit;
 }

#print "Content-type: text/html\n\n";
#print "Match: Input Session ID = $in{'session_id'} - Session Variable = #$session_variable<BR>User Session = $user_session<BR>Config Session = $config_session";

open(SESSIONTIME, ">$memberinfo/session.time");
           if ($LOCK_EX){ 
      flock(SESSIONTIME, $LOCK_EX); #Locks the file
	}

print SESSIONTIME "$thetime";
close(SESSIONTIME);

} 




sub add_list {
&sessioncheck;
#&totalsubscribers;

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    
    <FORM ACTION="$cgiurl" METHOD="POST"><INPUT TYPE="HIDDEN" 
    NAME="session_id" VALUE="$in{'session_id'}">
    <TABLE BORDER="0" WIDTH="91%" CELLPADDING="0" CELLSPACING="0">
      <TR>
        <TD>
        <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
           <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/listname.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
           <B>List Name</B> </FONT></TD>
            <TD WIDTH="65%" ALIGN="RIGHT"><INPUT TYPE="TEXT" NAME="list_name" SIZE="36"></TD>
          </TR>
          <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/importaddresses.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>Import Addresses</B></FONT> <INPUT TYPE="CHECKBOX" NAME="import"></TD>
            <TD WIDTH="65%" ALIGN="RIGHT"> <INPUT TYPE="TEXT" NAME="address_import" SIZE="36" VALUE="$lists/address_file.txt"></TD>
          </TR>
          <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/adminemail.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>List Admin E-mail</B></FONT></TD>
            <TD ALIGN="RIGHT" WIDTH="65%"><INPUT TYPE="TEXT" NAME="admin_email" SIZE="36" VALUE="youremailaddress\@yourserver.com"></TD>
          </TR>
          <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optin.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>Double Opt IN</B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>To ensure valid address
            </I></FONT></TD>
            <TD ALIGN="LEFT" WIDTH="65%"><SELECT NAME="optin_setting" SIZE="1">
            <OPTION VALUE="off" SELECTED="SELECTED">OFF</OPTION>
            <OPTION VALUE="optin">ON</OPTION></SELECT></TD>
          </TR>
          <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optout.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>Double Opt OUT</B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>To ensure authentic removal requests
            </I></FONT></TD>
            <TD ALIGN="LEFT" WIDTH="65%"><SELECT NAME="optout_setting" SIZE="1">
            <OPTION VALUE="optout" SELECTED="SELECTED">ON</OPTION>
            <OPTION VALUE="off">OFF</OPTION></SELECT></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/listdescription.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Description</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>Describe the list
            purpose</I></FONT></B></TD>
            <TD ALIGN="RIGHT" WIDTH="65%"><TEXTAREA NAME="description" ROWS="4" COLS="34" WRAP="Off"></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optinhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Optin Sign-up HTML Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            Optin signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="optin_signup" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        <CENTER>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
          We Need Your Confirmation!</FONT></B></P></CENTER>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">In order to ensure
          that you are the owner of the e-mail address: <E-MAIL>, for your
          protection we have just e-mailed you at that address with the
          instructions to complete your addition to our list.<BR>
           <BR>
          <B>Unless you repond to the automated e-mail just sent, your address
          will not be added to our list!</B></FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you experience
          any difficulties, please contact us at
          <A HREF="mailto:<ADMIN_EMAIL>"><ADMIN_EMAIL></A> for
          assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>

</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optouthresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Optout Removal HTML Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            Optout signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="optout_signup" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        <CENTER>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status:<BR>
          We Need Your Confirmation!</FONT></B></P></CENTER>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">In order to ensure
          that you are the owner of the e-mail address: <E-MAIL>, for your
          protection we have just e-mailed you at that address with the
          instructions to complete your removal from our list.<BR>
           <BR>
          <B>Unless you repond to the automated e-mail just sent, your address
          will not be removed from our list!</B></FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you experience
          any difficulties, please contact us at
          <A HREF="mailto:<ADMIN_EMAIL>"><ADMIN_EMAIL></A> for
          assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>

</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optnomatch.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">"No Match" Optin Sign-up HTML Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            "No Match " Optin signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="no_match" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Does Not Match!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">In order to ensure
          that you are the owner of the e-mail address: <E-MAIL>, our
          Subscribe Me program checks to make sure that the link you clicked on
          has the proper authorization code. The code that was submitted with
          your signup: <B><SECURE_CODE></B> doesn't match that on file for this
          e-mail address.<BR>
           <BR>
          </FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you feel you've
          received this notice in error, please contact us at
          <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A> for
          assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optinresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Optin Sign-up E-Mail Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to
            Optin signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="optin_response" ROWS="4" COLS="34" WRAP="Off">This message is to verify that you wish to have your
email address: <E-MAIL> added to the
<LIST_NAME>
Subscribe Me mailing list.

You MUST click on the link below to have your address added
to our list.  This is to ensure that someone doesn't add your
address to our list without your knowledge or consent.

Thank you,

http://<SERVER_NAME><CGI_URL>?a=1&amp;l=<LIST>&amp;e=<E-MAIL>&p=<SECURE_CODE>

America Online users, please click: <A HREF="http://<SERVER_NAME><CGI_URL>?a=1&l=<LIST>&e=<E-MAIL>&p=<SECURE_CODE>"><B>Here</B></A>

<LIST_NAME></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optoutresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Optout Removal E-Mail Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to
            Optout Removal Requests</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="optout_response" ROWS="4" COLS="34" WRAP="Off">This message is to verify that you wish to have your
email address: <E-MAIL> removed from the
<LIST_NAME>
Subscribe Me mailing list.

You MUST click on the link below to have your address removed
from our list.  This is to ensure that someone doesn't remove your
address from our list without your knowledge or consent.

Thank you,

http://<SERVER_NAME><CGI_URL>?r=1&amp;l=<LIST>&amp;e=<E-MAIL>&p=<SECURE_CODE>

America Online users, please click: <A HREF="http://<SERVER_NAME><CGI_URL>?r=1&l=<LIST>&e=<E-MAIL>&p=<SECURE_CODE>"><B>Here</B></A>

<LIST_NAME></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/hnormal.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-up HTML Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            normal successful signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="shtmlresponse" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Success!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your email
          address: <E-MAIL> has been added to the <LIST_NAME> mailing
          list.</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If at any time you
          desire to be removed from our list, you may do so
          <A HREF="$websiteurl">at our website</A>. Please contact
          <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A> if you
          need any further assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>

          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/iahresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-up "Address Improperly Formatted!</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            "improper address format" signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="improper_address" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Address Improperly Formatted!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">You have entered an improper email address.
        Please make sure your email address appears in this manner:<BR><BR>
        username\@domain.com, or username\@domain.net, etc. !</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you need
          further assistance, please contact <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A>.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>

          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/nfhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-up "Not Found" HTML Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            "address not found" signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="not_found" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Not Found!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your email
          address: <E-MAIL> was not found in our database. Please make sure
          you spelled the address properly and that you used the same email
          address that you created your account with.</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you need
          further assistance, please contact <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A>.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/alhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-up HTML "Already Listed" Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response when
            "address already listed"</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="alhtmlresponse" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Already Listed!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your email
          address: <E-MAIL> is already in our database!</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If you believe you
          are not receiving our intended mailings, please contact us at
          <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A> for
          assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/signupresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-Up E-Mail Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to
            normal successful signups</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="signup" ROWS="4" COLS="34" WRAP="Off">This message is to confirm the addition of your
email address: <E-MAIL> to the 
<LIST_NAME>
Subscribe Me mailing list.

If you feel you have received this notice in error,
please visit the <LIST_NAME>
Subscribe Me mailing list
at our website: 

<WEBSITEURL>
to remove yourself automatically, or click the link below:

http://<SERVER_NAME><CGI_URL>?r=1&amp;l=<LIST>&amp;e=<E-MAIL>

Thank you,

<LIST_NAME></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/rhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">HTML Removal Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
            successful removals</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="rhtmlresponse" ROWS="4" COLS="34" WRAP="Off"><CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Removed!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your email
          address: <E-MAIL> has been removed from the <LIST_NAME>
          database. We are sorry to see you go!</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">If ever you desire
          to be re-added to our mailing list, you may do so
          <A HREF="$websiteurl">at our website</A>. Please contact
          <A HREF="mailto:<ADMIN_MAIL>"><ADMIN_MAIL></A> for
          assistance.</FONT></P></TD>
      </TR></TBODY>
    </TABLE></CENTER>
</TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/removalresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Removal
            Response</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to
            successful removals</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="removal" ROWS="4" COLS="34" WRAP="Off">This message is to confirm the removal of your
email address: <E-MAIL> from the 
<LIST_NAME>
Subscribe Me mailing list.

We're sorry to see you go!

If you feel you have received this notice in error,
please visit the <LIST_NAME>
Subscribe Me mailing list
at our website: 

<WEBSITEURL>
to add yourself automatically, or click on the link
below to automatically re-subscribe yourself:

http://<SERVER_NAME><CGI_URL>?a=1&amp;l=<LIST>&amp;e=<E-MAIL>

Thank you,

<LIST_NAME></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/signaturemessage.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B><FONT SIZE="-1" FACE="arial, helvetica">Signature
            Message</FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>Added to end of mailing</I></FONT></B></TD>
            <TD WIDTH="65%"><TEXTAREA NAME="signature" ROWS="4" COLS="34" WRAP="Off"></TEXTAREA></TD>
          </TR>
          <TR>
            <TD WIDTH="35%"></TD>
            <TD WIDTH="65%">
            
            <P><BR>
              <INPUT TYPE="SUBMIT" NAME="create_list" VALUE="Create List"><INPUT TYPE="RESET" NAME="Reset1"></P></TD>
          </TR>
        </TABLE></TD>
      </TR>
    </TABLE></FORM>
        
EOF
&footer2;
&footer;
exit;

}

sub newid {
open (ID,"<$lists/new.id"); ## Creating an invoice number.
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}
$new_id = <ID> ;
close (ID);
$new_id++;
open (NEWID,">$lists/new.id");
if ($LOCK_EX){ 
      flock(NEWID, $LOCK_EX); #Locks the file
	}
print NEWID "$new_id";
close (NEWID);
}


sub create_list {
&sessioncheck;
unless (($in{'address_import'} =~ /address_file.txt/) || (!($in{'address_import'}))) {
 unless ($in{'import'}) {
print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="300">
      <TR>
        <TD>
        <CENTER><BR><FONT SIZE="-1" FACE="Verdana, Arial, Helvetica"><B>UNSUCCESSFUL!</B></FONT><BR>
        </CENTER>
        
        <P><FONT SIZE="-1" FACE="Arial, Helvetica">It appears you may be
          trying to import an address list, as the original information in the
          import section is removed. If you are attempting to import a list, be
          sure to check the IMPORT LIST checkbox first, next to the path to the
          file.<BR>
          <BR>
          If you are NOT attempting to import a list, either do NOT remove any of the
          existing information in the path to demonstation file, or remove ALL of the
          file path information from the box.</FONT></P><BR>
        <CENTER>
        <FORM><INPUT TYPE="BUTTON" VALUE="BACK TO LIST CREATOR/IMPORTER FORM" 
        ONCLICK="history.go(-1)"></FORM></CENTER></TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer2;
&footer;
exit;
 }
}

if ($in{'import'}) {

if (($in{'address_import'} =~ /\.pl/) || ($in{'address_import'} =~ /\.cgi/)) {
print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="300">
      <TR>
        <TD>
        <CENTER><BR><FONT SIZE="-1" FACE="Verdana, Arial, Helvetica"><B>UNSUCCESSFUL!</B></FONT><BR>
        </CENTER>
        
        <P><FONT SIZE="-1" FACE="Arial, Helvetica">It appears you are
          attempting to import a CGI file. For security purposes, Subscribe Me
          Professional can not import CGI files.</FONT></P>
        </TD>
      </TR>
    </TABLE></CENTER><CENTER>
        <FORM><INPUT TYPE="BUTTON" VALUE="BACK TO LIST CREATOR/IMPORTER FORM" 
        ONCLICK="history.go(-1)"></FORM></CENTER>
EOF
&footer2;
&footer;
exit;
 }
}

if ($in{'import'}) {

 unless (-e "$in{'address_import'}") {
 print "Content-type: text/html\n\n";
 print "Subscribe Me Pro didn't find the file:<BR>$in{'address_import'}<BR>";
 print "Please make sure you uploaded the file to the directory you inputed.<BR>";
 exit;
 }

}

open (IMPORT, "<$in{'address_import'}");
 if ($LOCK_EX){ 
      flock(IMPORT, $LOCK_EX); #Locks the file
	}
@import_list = <IMPORT>;
close(IMPORT);

#}

&newid;

$in{'description'} =~ s/\r//gm;
$in{'description'} =~ s/\n/\\n/gm;

open (NEWLIST, ">>$lists/lists.db");
if ($LOCK_EX){ 
      flock(NEWLIST, $LOCK_EX); #Locks the file
	}
$newline2 = join
("\|",$new_id,$in{'list_name'},$in{'admin_email'},$in{'description'},$in{'optin_setting'},$in{'optout_setting'},0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
$newline2 .= "\n";

print NEWLIST "$newline2";
close(NEWLIST);

print "Content-type: text/html\n\n";
&header;
&header2;


unless (-e "$lists/$new_id.list") {
open (NEWLIST2, ">$lists/$new_id.list");

if ($in{'import'}) {

print<<EOF;
<P><FONT SIZE="-1" FACE="Verdana, Arial, Helvetica"><B>If any illegal
addresses were found, they will appear below.<BR>Illegal addresses are NOT
added to your list!:</B></FONT></P>
EOF

foreach $iline(@import_list) {

chomp($iline);
$iline =~ s/\r//;

$iline =~ s/\s//g;


unless ($iline =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $iline !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
         #print NEWLIST2 "$iline\n";
         $ilinen = "$iline\n";
         push(@single_addresses,$ilinen);
         } else {
         $legalemail = 0;
         unless($iline){
         $iline = "Possibe extra carriage return";
         }
         print "<DIV ALIGN=\"LEFT\"><FONT SIZE=\"-1\" FACE=\"Arial, Helvetica\">Illegal address or character - <B>$iline</B></FONT><BR></DIV>";
        }
 }


foreach $iaddress(@single_addresses) {
   $single_addresses{$iaddress} = 1;
}

while ( ($key, $value ) = each( %single_addresses) ) {
print NEWLIST2 "$key";
}

}
close(NEWLIST2);



open (RESPONSE1,">$lists/$new_id.optinresponse");
 if ($LOCK_EX){ 
      flock(RESPONSE1, $LOCK_EX); #Locks the file
	}
print RESPONSE1 "$in{'optin_signup'}";
 close (RESPONSE1);

open (OPTOUT,">$lists/$new_id.optoutsignup");
 if ($LOCK_EX){ 
      flock(OPTOUT, $LOCK_EX); #Locks the file
	}
print OPTOUT "$in{'optout_signup'}";
 close (OPTOUT);



open (OPTINR,">$lists/$new_id.optinsignup");
 if ($LOCK_EX){ 
      flock(OPTINR, $LOCK_EX); #Locks the file
	}
print OPTINR "$in{'optin_response'}";
 close (OPTINR);


open (OPTOUTR,">$lists/$new_id.optoutresponse");
 if ($LOCK_EX){ 
      flock(OPTOUTR, $LOCK_EX); #Locks the file
	}
print OPTOUTR "$in{'optout_response'}";
 close (OPTOUTR);


open (RESPONSE2,">$lists/$new_id.signup");
 if ($LOCK_EX){ 
      flock(RESPONSE2, $LOCK_EX); #Locks the file
	}
print RESPONSE2 "$in{'signup'}";
 close (RESPONSE2);


open (RESPONSE3,">$lists/$new_id.removal");
 if ($LOCK_EX){ 
      flock(RESPONSE3, $LOCK_EX); #Locks the file
	}
print RESPONSE3 "$in{'removal'}";
 close (RESPONSE3);



open (RESPONSE4,">$lists/$new_id.signature");
 if ($LOCK_EX){ 
      flock(RESPONSE4, $LOCK_EX); #Locks the file
	}
print RESPONSE4 "$in{'signature'}";
 close (RESPONSE4);


open (IMPROPERHTMLRESPONSE,">$lists/$new_id.impropersignup");
 if ($LOCK_EX){ 
      flock(IMPROPERHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print IMPROPERHTMLRESPONSE "$in{'improper_address'}";
 close (IMPROPERHTMLRESPONSE);


open (ALHTMLRESPONSE,">$lists/$new_id.alsignup");
 if ($LOCK_EX){ 
      flock(ALHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print ALHTMLRESPONSE "$in{'alhtmlresponse'}";
 close (ALHTMLRESPONSE);

open (SHTMLRESPONSE,">$lists/$new_id.ssignup");
 if ($LOCK_EX){ 
      flock(SHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print SHTMLRESPONSE "$in{'shtmlresponse'}";
 close (SHTMLRESPONSE);


open (RHTMLRESPONSE,">$lists/$new_id.rremoval");
 if ($LOCK_EX){ 
      flock(RHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print RHTMLRESPONSE "$in{'rhtmlresponse'}";
 close (RHTMLRESPONSE);


open (NFHTMLRESPONSE,">$lists/$new_id.nfresponse");
 if ($LOCK_EX){ 
      flock(NFHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print NFHTMLRESPONSE "$in{'not_found'}";
 close (NFHTMLRESPONSE);

open (NMHTMLRESPONSE,">$lists/$new_id.nmresponse");
 if ($LOCK_EX){ 
      flock(NMHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print NMHTMLRESPONSE "$in{'no_match'}";
 close (NMHTMLRESPONSE);


}



print<<EOF;

    <CENTER>
    <FORM METHOD="POST" ACTION="$cgiurl">
    
    <P><INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}"></P>
    <TABLE BORDER="0" WIDTH="350">
      <TR>
        <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>List:
        $in{'list_name'}<BR>
        <BR>
        was created successfully.</B></FONT></TD>
      </TR>
    </TABLE></FORM></CENTER>

EOF
&footer2;
&footer;
exit;

}


sub update_list {
&sessioncheck;


$in{'description'} =~ s/\r//gm;
$in{'description'} =~ s/\n/\\n/gm;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);



open (DB2, ">$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB2, $LOCK_EX); #Locks the file
	}

foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);

if ($edit_db[0] == $in{'list_id'}) {

$edit_db[1] = $in{'list_name'} if $in{'list_name'};
$edit_db[2] = $in{'admin_email'} if $in{'admin_email'};
$edit_db[3] = $in{'description'} if $in{'description'};
$edit_db[4] = $in{'optin_setting'} if $in{'optin_setting'};
$edit_db[5] = $in{'optout_setting'} if $in{'optout_setting'};
}

$newline = join
("\|",@edit_db);

# chomp($newline);
print DB2 "$newline";
}

close(DB2);


open (RESPONSE1,">$lists/$in{'list_id'}.optinresponse");
 if ($LOCK_EX){ 
      flock(RESPONSE1, $LOCK_EX); #Locks the file
	}
print RESPONSE1 "$in{'optin_response'}";
 close (RESPONSE1);

open (OPTADDITION,">$lists/$in{'list_id'}.optinsignup");
 if ($LOCK_EX){ 
      flock(OPTADDITION, $LOCK_EX); #Locks the file
	}
print OPTADDITION "$in{'optinsignup'}";
 close (OPTADDITION);

open (OPTREMOVAL,">$lists/$in{'list_id'}.optoutsignup");
 if ($LOCK_EX){ 
      flock(OPTREMOVAL, $LOCK_EX); #Locks the file
	}
print OPTREMOVAL "$in{'optout_signup'}";
 close (OPTREMOVAL);

open (OPTREMOVALR,">$lists/$in{'list_id'}.optoutresponse");
 if ($LOCK_EX){ 
      flock(OPTREMOVALR, $LOCK_EX); #Locks the file
	}
print OPTREMOVALR "$in{'optout_response'}";
 close (OPTREMOVALR);

open (ADDITION,">$lists/$in{'list_id'}.signup");
 if ($LOCK_EX){ 
      flock(ADDITION, $LOCK_EX); #Locks the file
	}
print ADDITION "$in{'signup'}";
 close (ADDITION);



open (REMOVAL,">$lists/$in{'list_id'}.removal");
 if ($LOCK_EX){ 
      flock(REMOVAL, $LOCK_EX); #Locks the file
	}
print REMOVAL "$in{'removal'}";
 close (REMOVAL);



open (SIGNATURE,">$lists/$in{'list_id'}.signature");
 if ($LOCK_EX){ 
      flock(SIGNATURE, $LOCK_EX); #Locks the file
	}
print SIGNATURE "$in{'signature'}";
 close (SIGNATURE);


open (IMPROPERHTMLRESPONSE,">$lists/$in{'list_id'}.impropersignup");
 if ($LOCK_EX){ 
      flock(IMPROPERHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print IMPROPERHTMLRESPONSE "$in{'improper_address'}";
 close (IMPROPERHTMLRESPONSE);


open (ALHTMLRESPONSE,">$lists/$in{'list_id'}.alsignup");
 if ($LOCK_EX){ 
      flock(ALHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print ALHTMLRESPONSE "$in{'alhtmlresponse'}";
 close (ALHTMLRESPONSE);


open (SHTMLRESPONSE,">$lists/$in{'list_id'}.ssignup");
 if ($LOCK_EX){ 
      flock(SHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print SHTMLRESPONSE "$in{'shtmlresponse'}";
 close (SHTMLRESPONSE);


open (RHTMLRESPONSE,">$lists/$in{'list_id'}.rremoval");
 if ($LOCK_EX){ 
      flock(RHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print RHTMLRESPONSE "$in{'rhtmlresponse'}";
 close (RHTMLRESPONSE);


open (NFHTMLRESPONSE,">$lists/$in{'list_id'}.nfresponse");
 if ($LOCK_EX){ 
      flock(NFHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print NFHTMLRESPONSE "$in{'not_found'}";
 close (NFHTMLRESPONSE);

open (NMHTMLRESPONSE,">$lists/$in{'list_id'}.nmresponse");
 if ($LOCK_EX){ 
      flock(NMHTMLRESPONSE, $LOCK_EX); #Locks the file
	}
print NMHTMLRESPONSE "$in{'no_match'}";
 close (NMHTMLRESPONSE);



print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;

    <CENTER>
    <FORM METHOD="POST" ACTION="$cgiurl">
    
    <P><INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}"></P>
    <TABLE BORDER="0" WIDTH="350">
      <TR>
        <TD><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>List:
        $in{'list_name'}<BR>
        <BR>
        was updated successfully.</B></FONT></TD>
      </TR>
    </TABLE></FORM></CENTER>

EOF
&footer2;
&footer;
exit;

}



sub track_results {

&sessioncheck;

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <FORM METHOD="POST" ACTION="$cgiurl"><INPUT TYPE="HIDDEN" 
    NAME="session_id" VALUE="$in{'session_id'}">
    <TABLE BORDER="0" WIDTH="90%" CELLPADDING="0" CELLSPACING="0">
      <TR>
        <TD ALIGN="CENTER">
        <TABLE BORDER="0" WIDTH="100%">
        </TABLE><BR>
        </TD>
      </TR>
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Subscribe
        Me Professional - <FONT COLOR="#0000FF">Mailing Effectiveness Tracking</FONT></B></FONT></TD>
      </TR>
    </TABLE>
    
    <P><BR>
       </P>
    <TABLE BORDER="0" WIDTH="100%">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, hetvetica"><B>Choose
        Mailing:</B></FONT>
        <SELECT NAME="whichmailing" SIZE="1">
        <OPTION VALUE="choose" SELECTED="SELECTED">Choose One</OPTION>
EOF

opendir (DIR, "$trackdir");
@file = grep { /.txt/} readdir(DIR);
close (DIR);

foreach $trackinglines(@file) {
print "<OPTION VALUE=\"$trackinglines\">$trackinglines</OPTION>\n";
}

print<<EOF;
</SELECT><INPUT TYPE="SUBMIT" NAME="viewtracking" VALUE="Go!"></TD>
      </TR>
    </TABLE></FORM>


EOF
&footer2;
&footer;
exit;
}








sub delete_list {

&sessioncheck;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);


# print "$edit_db[0],$in{'list_name'}<BR>";

if ($edit_db[0] == $in{'list_name'}) { 

# print "Found it<BR>";
last;


 }

}


unless ($edit_db[1]) {
$edit_db[1] = "List name not entered";
}


print "Content-type: text/html\n\n";
&header;
&header2;

print<<EOF;

    <FORM METHOD="POST" ACTION="$cgiurl">
    <CENTER>
    <TABLE BORDER="0" WIDTH="350">
      <TR>
        <TD>
        
        <P><INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
           <INPUT TYPE="HIDDEN" NAME="list_name" VALUE="$edit_db[0]"></P>
        
        <P><FONT SIZE="+1" FACE="verdana, arial, helvetica"><I>WARNING:</I></FONT><BR>
          <BR>
          <FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>You are about to
          permanently delete your<BR>
           <BR>
          $edit_db[1]<BR>
          <BR>
           Are you sure you want to?</B></FONT></P>
        
        <P><INPUT TYPE="SUBMIT" NAME="delete2" VALUE="  Delete  "><INPUT TYPE="SUBMIT" NAME="adminreturn" VALUE="Do not delete"></P></TD>
      </TR>
    </TABLE></CENTER></FORM>
EOF

&footer2;
&footer;
exit;
}


sub list_details {
&sessioncheck;

$session_id = $in{'session_id'};

## Count Users ##

$lines_users = 0;

open (LIST, "<$lists/$in{'list_name'}.list");
if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
@database_array = <LIST>;
close (LIST);


$lines_users = push(@database_array);

## Count Users ##


## List Details ## 

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_list = split(/\|/,$lines);

if ($in{'list_name'} == $edit_list[0]) {

&read_messages;

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;

    <FORM ACTION="$cgiurl" METHOD="POST">
    <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
    <INPUT TYPE="HIDDEN" NAME="l" VALUE="$in{'list_name'}">
    <INPUT TYPE="HIDDEN" NAME="list_id" VALUE="$in{'list_name'}">
    <INPUT TYPE="HIDDEN" NAME="list_name" VALUE="$edit_list[1]">

    <TABLE BORDER="1" WIDTH="90%" CELLPADDING="0" CELLSPACING="0">
      <TR>
        <TD BGCOLOR="#FFFFFF">
        <CENTER>
        <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD ALIGN="LEFT" WIDTH="50%"><B><FONT SIZE="-1" FACE="arial, helvetica">List
            Name: <FONT COLOR="#FF0000">$edit_list[1]</FONT></FONT></B></TD>
            <TD ALIGN="LEFT" WIDTH="50%"><B><FONT SIZE="-1" FACE="arial, helvetica">Subscribers:
            <FONT COLOR="#FF0000">$lines_users</FONT></FONT></B></TD>
          </TR>
        </TABLE><BR>
        </CENTER>
        <TABLE BORDER="1" WIDTH="100%">
          <TBODY>
          <TR>
            <TD VALIGN="TOP" WIDTH="50%"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>Add
            / Remove Subscribers:</B></FONT></TD>
            <TD WIDTH="50%">
            
            <P> <FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Subscribe
              or Unsubscribe<BR>
               any addresses here</B></FONT> </P></TD>
          </TR>
          <TR>
            <TD></TD>
            <TD><INPUT TYPE="TEXT" SIZE="15" NAME="e"></TD>
          </TR>
          <TR>
            <TD></TD>
            <TD WIDTH="50%"><INPUT TYPE="RADIO" NAME="subscribe" VALUE="subscribe" CHECKED="CHECKED" ALIGN="TOP"><FONT SIZE="-2" COLOR="#000000" FACE="verdana, arial, helvetica"><B>subscribe</B></FONT><BR>
            <INPUT TYPE="RADIO" NAME="subscribe" VALUE="unsubscribe" ALIGN="TOP">
            <FONT SIZE="-2" COLOR="#000000" FACE="verdana, arial, helvetica"><B>unsubscribe</B></FONT><BR>
            <INPUT TYPE="CHECKBOX" NAME="usernotify" CHECKED="CHECKED">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>DO NOT Notify
            Subscriber</B></FONT></TD>
          </TR>
          <TR>
            <TD></TD>
            <TD WIDTH="50%">
            
            <P><INPUT TYPE="SUBMIT" VALUE="  Submit  "><INPUT TYPE="RESET" NAME="Reset1"></P></TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>Double Opt In: <FONT COLOR="#FF0000">$edit_list[4]</FONT></B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
            </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>Double Opt Out: <FONT COLOR="#FF0000">$edit_list[5]</FONT></B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
            </TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>List
            E-mail: <FONT COLOR="#FF0000">$edit_list[2]</FONT></B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
          </TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>See
            Entire List:</B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?view_list=1&list_name=$edit_list[0]&session_id=$session_id">View
              List</A></B></FONT></TD>
          </TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>Batch Address Addition:</B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_manually=1&list_name=$edit_list[0]&session_id=$session_id">Add Addresses</A></B></FONT></TD>
          </TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>Manual List Edit:</B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_manually2=1&list_name=$edit_list[0]&session_id=$session_id">Edit List Manually</A></B></FONT></TD>
          </TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>List Backup:</B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?list_backup=1&list_name=$edit_list[0]&session_id=$session_id">Backup $edit_list[1]</A></B></FONT></TD>
          </TR>
          <TR>
          <TR>
            <TD VALIGN="TOP"><FONT SIZE="-1" FACE="arial, helvetica"><B>Subscriber
            Count: <FONT COLOR="#FF0000">$lines_users</FONT></B></FONT></TD>
            <TD><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?list_details=1&list_name=$edit_list[0]&session_id=$session_id">Refresh
              Count</A></B></FONT></TD>
          </TR>
        </TBODY>
        </TABLE>
        <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD><BR>
            </TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>List Description:</B></FONT>
            <FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica">$edit_list[3]</FONT><BR>
             <BR>
            </TD>
          </TR>
        </TABLE>
        <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>Opt List Signup Email Response - Only sent when "Optin" chosen
            Mailing:</B></FONT> <FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica">$optinsignup_message</FONT><BR>
             <BR>
            </TD>
          </TR>
        </TABLE>

         <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>List Signup
            Mailing:</B></FONT> <FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica">$signup_message</FONT><BR>
             <BR>
            </TD>
          </TR>
        </TABLE>
        <TABLE BORDER="0" WIDTH="100%">
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica"><B>List Removal
            Mailing:</B></FONT> <FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?edit_list=1&list_name=$edit_list[0]&session_id=$session_id">Edit</A></B></FONT></TD>
          </TR>
          <TR>
            <TD><FONT SIZE="-1" FACE="arial, helvetica">$removal_message</FONT><BR>
             <BR>
            </TD>
          </TR>
        </TABLE></TD>
      </TR>
    </TABLE></FORM>

EOF

&copypaste;

&footer2;
&footer;

last;

exit;
 }
}

}



sub read_messages {


undef $/;
open (OPTADDITION,"<$lists/$edit_list[0].optinsignup");
 if ($LOCK_EX){ 
      flock(OPTADDITION, $LOCK_EX); #Locks the file
	}
$optinsignup_message = <OPTADDITION>;


if ($in{'list_details'}) {
$optinsignup_message =~ s/\</\&lt\;/g;
$optinsignup_message =~ s/\>/\&gt\;/g;
$optinsignup_message =~ s/\r/<BR>/g;
} else {
$optinsignup_message =~ s/\r//g;
}

 close (OPTADDITION);
$/ = "\n";



undef $/;
open (OPTRADDITION,"<$lists/$edit_list[0].optinresponse");
 if ($LOCK_EX){ 
      flock(OPTRADDITION, $LOCK_EX); #Locks the file
	}
$optinresponse_message = <OPTRADDITION>;


if ($in{'list_details'}) {
$optinresponse_message =~ s/\</\&lt\;/g;
$optinresponse_message =~ s/\>/\&gt\;/g;
$optinresponse_message =~ s/\r/<BR>/g;
} else {
$optinresponse_message =~ s/\r//g;
}

 close (OPTRADDITION);
$/ = "\n";




undef $/;
open (OPTRREM,"<$lists/$edit_list[0].optoutsignup");
 if ($LOCK_EX){ 
      flock(OPTRREM, $LOCK_EX); #Locks the file
	}
$optoutsignup_message = <OPTRREM>;


if ($in{'list_details'}) {
$optoutsignup_message =~ s/\</\&lt\;/g;
$optoutsignup_message =~ s/\>/\&gt\;/g;
$optoutsignup_message =~ s/\r/<BR>/g;
} else {
$optoutsignup_message =~ s/\r//g;
}

 close (OPTRREM);
$/ = "\n";


undef $/;
open (OPTRREMR,"<$lists/$edit_list[0].optoutresponse");
 if ($LOCK_EX){ 
      flock(OPTRREMR, $LOCK_EX); #Locks the file
	}
$optoutresponse_message = <OPTRREMR>;


if ($in{'list_details'}) {
$optoutresponse_message =~ s/\</\&lt\;/g;
$optoutresponse_message =~ s/\>/\&gt\;/g;
$optoutresponse_message =~ s/\r/<BR>/g;
} else {
$optoutresponse_message =~ s/\r//g;
}

 close (OPTRREMR);
$/ = "\n";



undef $/;
open (IMPROPERADDRESS,"<$lists/$edit_list[0].impropersignup");
 if ($LOCK_EX){ 
      flock(IMPROPERADDRESS, $LOCK_EX); #Locks the file
	}
$ia_message = <IMPROPERADDRESS>;


if ($in{'list_details'}) {
$ia_message =~ s/\</\&lt\;/g;
$ia_message =~ s/\>/\&gt\;/g;
$ia_message =~ s/\r/<BR>/g;
} else {
$ia_message =~ s/\r//g;
}

 close (IMPROPERADDRESS);
$/ = "\n";




undef $/;
open (NMRESPONSE,"<$lists/$edit_list[0].nmresponse");
 if ($LOCK_EX){ 
      flock(NMRESPONSE, $LOCK_EX); #Locks the file
	}
$nm_message = <NMRESPONSE>;


if ($in{'list_details'}) {
$nm_message =~ s/\</\&lt\;/g;
$nm_message =~ s/\>/\&gt\;/g;
$nm_message =~ s/\r/<BR>/g;
} else {
$nm_message =~ s/\r//g;
}

 close (NMRESPONSE);
$/ = "\n";


undef $/;
open (NFRESPONSE,"<$lists/$edit_list[0].nfresponse");
 if ($LOCK_EX){ 
      flock(NFRESPONSE, $LOCK_EX); #Locks the file
	}
$nf_message = <NFRESPONSE>;


if ($in{'list_details'}) {
$nf_message =~ s/\</\&lt\;/g;
$nf_message =~ s/\>/\&gt\;/g;
$nf_message =~ s/\r/<BR>/g;
} else {
$nf_message =~ s/\r//g;
}

 close (NFRESPONSE);
$/ = "\n";



undef $/;
open (ALRESPONSE,"<$lists/$edit_list[0].alsignup");
 if ($LOCK_EX){ 
      flock(ALRESPONSE, $LOCK_EX); #Locks the file
	}
$al_message = <ALRESPONSE>;


if ($in{'list_details'}) {
$al_message =~ s/\</\&lt\;/g;
$al_message =~ s/\>/\&gt\;/g;
$al_message =~ s/\r/<BR>/g;
} else {
$al_message =~ s/\r//g;
}

 close (ALRESPONSE);
$/ = "\n";




undef $/;
open (ADDITION,"<$lists/$edit_list[0].signup");
 if ($LOCK_EX){ 
      flock(ADDITION, $LOCK_EX); #Locks the file
	}
$signup_message = <ADDITION>;


if ($in{'list_details'}) {
$signup_message =~ s/\</\&lt\;/g;
$signup_message =~ s/\>/\&gt\;/g;
$signup_message =~ s/\r/<BR>/g;
} else {
$signup_message =~ s/\r//g;
}

 close (ADDITION);
$/ = "\n";


undef $/;
open (SADDITION,"<$lists/$edit_list[0].ssignup");
 if ($LOCK_EX){ 
      flock(SADDITION, $LOCK_EX); #Locks the file
	}
$ssignup_message = <SADDITION>;


if ($in{'list_details'}) {
$ssignup_message =~ s/\</\&lt\;/g;
$ssignup_message =~ s/\>/\&gt\;/g;
$ssignup_message =~ s/\r/<BR>/g;
} else {
$ssignup_message =~ s/\r//g;
}

 close (SADDITION);
$/ = "\n";



undef $/;
open (REMOVAL,"<$lists/$edit_list[0].removal");
 if ($LOCK_EX){ 
      flock(REMOVAL, $LOCK_EX); #Locks the file
	}
$removal_message = <REMOVAL>;

if ($in{'list_details'}) {
$removal_message =~ s/\</\&lt\;/g;
$removal_message =~ s/\>/\&gt\;/g;
$removal_message =~ s/\r/<BR>/g;
} else {
$removal_message =~ s/\r//g;
}


 close (REMOVAL);
$/ = "\n";



undef $/;
open (RREMOVAL,"<$lists/$edit_list[0].rremoval");
 if ($LOCK_EX){ 
      flock(RREMOVAL, $LOCK_EX); #Locks the file
	}
$rremoval_message = <RREMOVAL>;

if ($in{'list_details'}) {
$rremoval_message =~ s/\</\&lt\;/g;
$rremoval_message =~ s/\>/\&gt\;/g;
$rremoval_message =~ s/\r/<BR>/g;
} else {
$rremoval_message =~ s/\r//g;
}


 close (RREMOVAL);
$/ = "\n";




undef $/;
open (SIGNATURE,"<$lists/$edit_list[0].signature");
 if ($LOCK_EX){ 
      flock(SIGNATURE, $LOCK_EX); #Locks the file
	}
$signature_message = <SIGNATURE>;



if ($in{'list_details'}) {
$signature_message =~ s/\</\&lt\;/g;
$signature_message =~ s/\>/\&gt\;/g;
$signature_message =~ s/\r/<BR>/g;
} else {
$signature_message =~ s/\r//g;
}


 close (SIGNATURE);
$/ = "\n";



}



sub edit_list {
&sessioncheck;

open (DB, "$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_list = split(/\|/,$lines);


# print "$edit_db[0],$in{'list_name'}<BR>";

if ($edit_list[0] == $in{'list_name'}) {


&read_messages;
 

print "Content-type: text/html\n\n";
&header;
&header2;

print<<EOF;

        <FORM ACTION="$cgiurl" METHOD="POST">
        <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
        <INPUT TYPE="HIDDEN" NAME="list_id" VALUE="$in{'list_name'}">
        <TABLE BORDER="0" WIDTH="90%" CELLPADDING="0" CELLSPACING="0">
          <TR>
            <TD>
            <TABLE BORDER="0" WIDTH="100%">
              <TR>
                <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/listname.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B>List Name</B> </FONT></TD>
                <TD WIDTH="65%" ALIGN="RIGHT"><INPUT TYPE="TEXT" NAME="list_name" VALUE="$edit_list[1]" SIZE="36"></TD>
              </TR>
              <TR>
                <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/adminemail.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B>List Admin E-mail</B></FONT></TD>
                <TD ALIGN="RIGHT" WIDTH="65%"><INPUT TYPE="TEXT" NAME="admin_email" SIZE="36" VALUE="$edit_list[2]"></TD>
              </TR>
              <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optin.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>Double Opt IN</B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>To ensure valid address
            </I></FONT></TD>
            <TD ALIGN="LEFT" WIDTH="65%"><SELECT NAME="optin_setting" SIZE="1">
EOF

if ($edit_list[4] eq 'optin') {
print<<EOF;
            <OPTION VALUE="optin" SELECTED="SELECTED">ON</OPTION>
            <OPTION VALUE="off">OFF</OPTION>
EOF
} else {
print<<EOF;
           <OPTION VALUE="off" SELECTED="SELECTED">OFF</OPTION>
           <OPTION VALUE="optin">ON</OPTION>
EOF
}

print<<EOF;     
    </SELECT></TD>
          </TR>
              <TR>
            <TD WIDTH="35%"><FONT SIZE="-1" FACE="arial, helvetica">
            <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optout.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
            <B>Double Opt OUT</B></FONT><BR>
            <FONT SIZE="-2" FACE="arial, helvetica"><I>To help prevent malicious behavior
            </I></FONT></TD>
            <TD ALIGN="LEFT" WIDTH="65%"><SELECT NAME="optout_setting" SIZE="1">
EOF

if ($edit_list[5] eq 'optout') {
print<<EOF;
            <OPTION VALUE="optout" SELECTED="SELECTED">ON</OPTION>
            <OPTION VALUE="off">OFF</OPTION>
EOF
} else {
print<<EOF;
           <OPTION VALUE="off" SELECTED="SELECTED">OFF</OPTION>
           <OPTION VALUE="optout">ON</OPTION>
EOF
}

print<<EOF;     
    </SELECT></TD>
          </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/listdescription.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Description</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>Describe the list
                purpose</I></FONT></B></TD>
                <TD ALIGN="RIGHT" WIDTH="65%"><TEXTAREA NAME="description" ROWS="4" COLS="34" WRAP="Off">$edit_list[3]</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optinhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Optin Sign-Up HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
                Optin signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="optin_response" ROWS="4" COLS="34" WRAP="Off">$optinresponse_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optouthresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Optout Removal HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
                Optout Removal Requests</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="optout_signup" ROWS="4" COLS="34" WRAP="Off">$optoutsignup_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optnomatch.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">"No Match" Optin Sign-Up HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to
                "No Match" Optin signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="no_match" ROWS="4" COLS="34" WRAP="Off">$nm_message</TEXTAREA></TD>
              </TR>
              <TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optinresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Optin Sign-Up E-Mail Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to Optin
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="optinsignup" ROWS="4" COLS="34" WRAP="Off">$optinsignup_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/optoutresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Optout Removal E-Mail Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to Optout
                removals</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="optout_response" ROWS="4" COLS="34" WRAP="Off">$optoutresponse_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/hnormal.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Signup HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to normal successful
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="shtmlresponse" ROWS="4" COLS="34" WRAP="Off">$ssignup_message</TEXTAREA></TD>
              </TR>

              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/iahresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-Up "Improperly Formatted Address" HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to "Improperly Formatted Address" 
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="improper_address" ROWS="4" COLS="34" WRAP="Off">$ia_message</TEXTAREA></TD>
              </TR>

              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/nfhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-Up "Not Found" HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to "address not found" 
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="not_found" ROWS="4" COLS="34" WRAP="Off">$nf_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/alhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-Up "Already Listed" HTML Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response when "address already listed" 
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="alhtmlresponse" ROWS="4" COLS="34" WRAP="Off">$al_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/signupresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Sign-Up E-Mail Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to normal successful
                signups</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="signup" ROWS="4" COLS="34" WRAP="Off">$signup_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/rhresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">HTML Removal Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>HTML response to successful
                removals</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="rhtmlresponse" ROWS="4" COLS="34" WRAP="Off">$rremoval_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/removalresponse.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Removal Response</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>E-mail response to successful
                removals</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="removal" ROWS="4" COLS="34" WRAP="Off">$removal_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%">
                <A HREF="javascript:Start('http://www.cgiscriptcenter.com/subscribe/install/signaturemessage.shtm')"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>?</B></FONT></A>
                <B><FONT SIZE="-1" FACE="arial, helvetica">Signature Message</FONT><BR>
                <FONT SIZE="-2" FACE="arial, helvetica"><I>Added to end of
                mailing</I></FONT></B></TD>
                <TD WIDTH="65%"><TEXTAREA NAME="signature" ROWS="4" COLS="34" WRAP="Off">$signature_message</TEXTAREA></TD>
              </TR>
              <TR>
                <TD WIDTH="35%"></TD>
                <TD WIDTH="65%">
                
                <P><BR>
                  <INPUT TYPE="SUBMIT" NAME="update_list" VALUE="Update List"><INPUT TYPE="RESET" NAME="Reset1"></P></TD>
              </TR>
            </TABLE></TD>
          </TR>
        </TABLE></FORM>
        
        
EOF

&footer2;
&footer;

last;
exit;

 }

}
}


sub delete2 {

&sessioncheck;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

open (DB, ">$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}


foreach $lines(@db_array) {
@edit_db = split(/\|/,$lines);

if ($in{'list_name'} != $edit_db[0]) {

print DB "$lines";


}

}
close(DB);

unlink("$lists/$in{'list_name'}.list");
unlink("$lists/$in{'list_name'}.signup");
unlink("$lists/$in{'list_name'}.removal");
unlink("$lists/$in{'list_name'}.rremoval");
unlink("$lists/$in{'list_name'}.signature");
unlink("$lists/$in{'list_name'}.alsignup");
unlink("$lists/$in{'list_name'}.nfresponse");
unlink("$lists/$in{'list_name'}.nmresponse");
unlink("$lists/$in{'list_name'}.optinresponse");
unlink("$lists/$in{'list_name'}.optinsignup");
unlink("$lists/$in{'list_name'}.ssignup");
unlink("$lists/$in{'list_name'}.optoutresponse");
unlink("$lists/$in{'list_name'}.optoutsignup");
unlink("$lists/$in{'list_name'}.impropersignup");

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER><BR>
    <TABLE BORDER="0" WIDTH="350">
      <TR>
        <TD><FONT SIZE="-1" FACE="arial, helvetica">The list $in{'list_name'} has
        been deleted from the database.</FONT> </TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer2;
$footer;

}




sub totalsubscribers {

$total_subscribers = 0;

opendir (DIR, "$lists"); 
@file = grep { /.list/} readdir(DIR);

$list_number = push(@file);

 foreach $lines_lists(@file) {

open (LIST, "<$lists/$lines_lists");
if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
 @database_array = <LIST>;
 close (LIST);


my $lines_users = push(@database_array);
$total_subscribers = $total_subscribers + $lines_users;


}

}



sub ind_users {

$lines_users = 0;

open (LIST, "<$lists/$edit_array2[0].list");
if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
@database_array = <LIST>;
close (LIST);


$lines_users = push(@database_array);

}



sub display_graphic {

if ($in{'graphic'}) {

print "Content-type: image/$imagetype\n";
print "\n";
$file = "$graphics/$in{'graphic'}";
open (IMAGE, "<$file") || die "Can't open $file: $!";
if ($os eq 'nt') {
binmode(IMAGE); ## If used on an NT server, remove the "#" at front.
binmode(STDOUT); ## If used on an NT server, remove the "#" at front.
}
while (<IMAGE>)
{
        print $_;
}
close(IMAGE);
# exit;
}
}



sub adminpanel {

$session_id = $in{'session_id'};

&sessioncheck;
&totalsubscribers;


print "Content-type: text/html\n\n";

&header;
&header2;
print<<EOF;

        <FORM ACTION="$cgiurl">
        <TABLE BORDER="0" WIDTH="90%" CELLPADDING="0" CELLSPACING="0">
          <TR>
            <TD BGCOLOR="#000000" ALIGN="CENTER" WIDTH="100%">
            <TABLE BORDER="0" WIDTH="100%" CELLSPACING="1" CELLPADDING="0" BGCOLOR="#FFB500">
              <TR>
                <TD WIDTH="55%" ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica">List
                Names</FONT></TD>
                <TD ALIGN="CENTER" WIDTH="15%"><FONT SIZE="-1" FACE="arial, helvetica">Subscribers</FONT></TD>
                <TD ALIGN="CENTER" WIDTH="30%"><FONT SIZE="-1" FACE="arial, helvetica">Edit/Delete
                List</FONT></TD>
              </TR>
            </TABLE></TD>
          </TR>
EOF




open (DESCRIPTION, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DESCRIPTION, $LOCK_EX); #Locks the file
	}
 @database_array2 = <DESCRIPTION>;
 close (DESCRIPTION);

$count=0;

foreach $line(@database_array2) {
@edit_array2 = split(/\|/,$line);

$edit_array2[3] =~ s/\r//gm;
$edit_array2[3] =~ s/\\n/<BR>/gm;

&ind_users;

print<<EOF;
            <TR>
            <TD BGCOLOR="#000000">
    <TABLE BORDER="0" CELLPADDING="5" WIDTH="100%" CELLSPACING="1">
      <TR>
        <TD ALIGN="LEFT" WIDTH="55%" BGCOLOR="#FFFFFF"><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>$edit_array2[1]</B>
        </FONT><BR>
        <FONT SIZE="-2" FACE="arial, helvetica">$edit_array2[3]</FONT></TD>
        <TD ALIGN="LEFT" WIDTH="15%" BGCOLOR="#FFFFFF"><B><FONT COLOR="#FF0000" SIZE="-2" FACE="arial, helvetica">$lines_users</FONT></B></TD>
        <TD ALIGN="CENTER" WIDTH="30%" BGCOLOR="#FFFFFF"><B><FONT COLOR="#FF0000" SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?list_details=1&list_name=$edit_array2[0]&session_id=$session_id">Details</A></B>
        |
        <A HREF="$cgiurl?edit_list=1&list_name=$edit_array2[0]&session_id=$session_id">Edit</A>
        |
        <A HREF="$cgiurl?delete_list=1&list_name=$edit_array2[0]&session_id=$session_id">Delete        </A></FONT></B></TD>
      </TR>
    </TABLE></TD>
                </TR>

EOF
$count++;

}

print<<EOF;
              


        </TABLE>
        
        <P></P>
EOF

&menu;

print<<EOF;
      </CENTER></FORM></TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer;
exit;
}


sub menu {
print<<EOF;
    <TABLE BORDER="0" WIDTH="90%">
      <TR>
        <TD ALIGN="CENTER"><FONT SIZE="-2" FACE="arial, helvetica"><B><A HREF="$cgiurl?adminreturn=1&session_id=$in{'session_id'}">Main
          Menu</A> | <A HREF="$cgiurl?add_list=1&session_id=$in{'session_id'}">Add/Import
          List</A> |
        <A HREF="$sminstaller?reinstall=1&session_id=$in{'session_id'}">Edit/Upgrade
          Configs</A> | <A HREF="$cgiurl?form2=1&session_id=$in{'session_id'}">Send
          Mail</A> |
        <A HREF="$cgiurl?track_results=1&session_id=$in{'session_id'}">Track
          Results</A> | <A HREF="$cgiurl?log_off=1&session_id=$in{'session_id'}">Log
          Off</A></B></FONT></TD>
      </TR>
    </TABLE>
EOF
}




sub log_off {
&sessioncheck;

unlink("$memberinfo/session.id");
unlink("$memberinfo/session.time");

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="350">
      <TR>
        <TD><BR><FONT SIZE="-1" FACE="verdana, arial, helvetica"><B>You have
        successfully logged off. Your Session Management password has been
        deleted for security purposes.<BR>
         <BR>
         A new one will be created the next time you log into your Subscribe Me
        Professional program.<BR>
         <BR>
         <BR>
         Thank you for using Subscribe Me Professional.</B></FONT></TD>
      </TR>
    </TABLE></CENTER>
EOF
&footer2;
&footer;
exit;
}






# sub mailing {
# if ($mailusing eq 'sendmail') {
# &mailingu;
# } elsif ($mailusing eq 'blat') {
# &mailingnt;
# } elsif ($mailusing eq 'sockets') {
# &mailings;
# }
# }







sub header2 {

&totalsubscribers;

if (-e "$graphics/sub3.gif") {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER"><IMG SRC="$cgiurl?graphic=sub3.gif" 
    ALT="Subscribe Me Professional logo" WIDTH="129" HEIGHT="77"></TD>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE> <BR>
        <TABLE BORDER="0" WIDTH="75%">
          <TR>
            <TD WIDTH="50%" ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica">Number
            of Lists: <FONT COLOR="#0000FF">$list_number</FONT></FONT></TD>
            <TD WIDTH="50%" ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica">Total
            Subscribers: <FONT COLOR="#0000FF">$total_subscribers</FONT></FONT></TD>
          </TR>
        </TABLE>
EOF
} else {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE> <BR>
        <TABLE BORDER="0" WIDTH="75%">
          <TR>
            <TD WIDTH="50%" ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica">Number
            of Lists: <FONT COLOR="#0000FF">$list_number</FONT></FONT></TD>
            <TD WIDTH="50%" ALIGN="CENTER"><FONT SIZE="-1" FACE="arial, helvetica">Total
            Subscribers: <FONT COLOR="#0000FF">$total_subscribers</FONT></FONT></TD>
          </TR>
        </TABLE>
EOF
}
}


sub header3 {

&totalsubscribers;

if (-e "$graphics/sub3.gif") {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER"><IMG SRC="$cgiurl?graphic=sub3.gif" 
    ALT="Subscribe Me Professional logo" WIDTH="129" HEIGHT="77"></TD>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE>
EOF
} else {
print<<EOF;
<CENTER>
    <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" BGCOLOR="#FFFF80" WIDTH="500">
      <TR>
        <TD BGCOLOR="#FFB500" ALIGN="CENTER" WIDTH="100%">
        <TABLE BORDER="0" BGCOLOR="#FFFFFF" CELLSPACING="0" CELLPADDING="5" WIDTH="100%">
          <TR>
            <TD ALIGN="CENTER" VALIGN="MIDDLE"><FONT FACE="verdana, arial, helvetica" SIZE="-1"><B>Subscribe
            Me Professional $version<BR>
             Administration Panel</B></FONT><HR SIZE="1" WIDTH="150">
            <FONT SIZE="-2" FACE="verdana, arial, helvetica"><A HREF="http://www.cgiscriptcenter.com/subscribe/pro/support/" TARGET="_blank">Users
              Manual and Support</A></FONT></TD>
          </TR>
        </TABLE>
EOF
}
}




sub footer2 {

print "<P>";

&menu;

print "<BR>
           </P></TD>
      </TR>
    </TABLE></CENTER>";

}


sub footer3 {

print "<P>";
print "<BR>
           </P></TD>
      </TR>
    </TABLE></CENTER>";

}



sub notifyadminadded {


$body = "";

#			$body .= "To: $list_mail\n";
#		      $body .=  "From: $list_mail\n";
#			$body .=  "Subject: Subscribe Me New Addition!\n\n";
				

    $body .= "The email address $in{'e'} has been\n";
    $body .= "successfully added to the $in{'list_name'}\n";
    $body .= "Subscribe Me mailing list!\n\n";

    $body .= "Automated Subscribe Me Responder\n\n";
				  
&sendmail("$in{'admin_email'}","$in{'admin_email'}","Subscribe Me New Addition!","$body");
}

sub notifyadmindeleted {


$body = "";
#			$body .= "To: $list_mail\n";
#		      $body .=  "From: $list_mail\n";
#			$body .=  "Subject: Subscribe Me User Deleted!\n\n";
				

    $body .= "The email address $in{'e'} has been\n";
    $body .= "successfully removed from the $in{'list_name'}\n";
    $body .= "Subscribe Me mailing list!\n\n";

    $body .= "Automated Subscribe Me Responder\n\n";

				  
&sendmail("$in{'admin_email'}","$in{'admin_email'}","Subscribe Me Removal!","$body");
}


sub done {

$body = "";

    $body .= "Your Subscribe Me Mass Mailing was successfully\n";
    $body .= "sent to $user_count e-mail addresses.\n\n";

    $body .= "Automated Subscribe Me Responder\n\n";

&sendmail("$list_mail","$list_mail","Subscribe Me Mass Mailing Status!","$body");
}

sub countusers {

open (LIST,"<$lists/$in{'l'}.list");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
 @database_array = <LIST>;
 close (LIST);

$users = push(@database_array);
}

sub viewaddresses {
&sessioncheck;
# &blindcheck;

open (LIST,"<$lists/$in{'list_name'}.list");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
 @database_array = <LIST>;
 close (LIST);
print "Content-type: text/html\n\n";
&header;
print "<P>";

foreach $lines(@database_array) {
chomp($lines);

print "<FONT SIZE=\"-1\" FACE=\"verdana, arial, helvetica\">$lines</FONT><BR>";

}
print "</P>";
&footer;
exit;

}



sub track {

$found = "0";

open (TRACK,"<$trackdir/$in{'which'}.urlfile") || die("Can't find $trackdir/$in{'which'}.urlfile : $!");
 if ($LOCK_EX){ 
      flock(TRACK, $LOCK_EX); #Locks the file
	}

$useurl = <TRACK>;
chomp($useurl);

close(TRACK);

#print "Content-type: text/html\n\n";
#print "$trackdir/$in{'which'}.urlfile<BR>";
#exit;

if ($in{'page'}) {
$in{'page'} =~ s/^\///;
}



$list = $in{'l'};
$page = $in{'page'};
$address = $in{'address'};
$fullpage = "$useurl/$page";
$which = "$in{'which'}";

# $newline2 = join
# ("\|",$date2,$page,0);
# $newline2 .= "\n";



unless (-e "$trackdir/$which.txt") {


$newline2 = join
("\|",$date2,$page,1,$address,0);
$newline2 .= "\n";


open(ID, ">$trackdir/$which.txt") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}
print ID "$newline2";
close (ID);
print "Location: $fullpage\n\n";
exit;

} 

open(ID, "<$trackdir/$which.txt") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}
 @tracker_db = <ID>;
 close (ID);

foreach $tlines(@tracker_db) {
@edit_tracker = split(/\|/,$tlines);


if ($edit_tracker[1] eq $page) {
$found = "1";
last;
}
}

if ($found) {

open(ID, "<$trackdir/$which.txt") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}
 @tracker_db = <ID>;
 close (ID);

open(ID, ">$trackdir/$which.txt") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file

foreach $tlines(@tracker_db) {
@edit_tracker = split(/\|/,$tlines);
	

 if ($edit_tracker[1] eq $page) {


 $edit_tracker[2]++;


 }
$newline2 = join
("\|",@edit_tracker);

chomp($newline2);
print ID "$newline2\n";
}
}
 
} else {

$newline2 = join
("\|",$date2,$page,1,$address,0);
$newline2 .= "\n";

open(ID, ">>$trackdir/$which.txt") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}

chomp($newline2);
print ID "$newline2\n";

}
close(ID);
print "Location: $fullpage\n\n";
exit;
}



sub viewtracking {
&sessioncheck;
# &blindcheck;

if ($in{'whichmailing'} eq "choose") {
print "Content-type: text/html\n\n";
print "Please choose which mailing you would like to view statistics on<BR>";
exit;
}


$url = $in{'whichmailing'};
$url =~ s/.txt/.urlfile/g;

open(URL, "<$trackdir/$url") or print "unable to create user info temp file.  Check your directory permission settings";
if ($LOCK_EX){ 
      flock(URL, $LOCK_EX); #Locks the file
	}
$link_name = <URL>;

close (URL);



open(ID, "<$trackdir/$in{'whichmailing'}") or print "unable to create user info temp file.  Check your directory permission settings";
print "Content-type: text/html\n\n";
&header;
$section_title = "Statistics Tracking";
&header2;

print<<EOF;

    <CENTER>
    <TABLE BORDER="0" WIDTH="550" CELLSPACING="2">
      <TR>
        <TD ALIGN="CENTER" WIDTH="50"><FONT SIZE="-1" FACE="arial, helvetica"><B>DATE</B></FONT></TD>
        <TD ALIGN="CENTER" WIDTH="450"><FONT SIZE="-1" FACE="arial, helvetica"><B>URL</B></FONT></TD>
        <TD ALIGN="CENTER" WIDTH="50"><FONT SIZE="-1" FACE="arial, helvetica"><B>CLICKS</B></FONT></TD>
      </TR>
    </TABLE></CENTER>
EOF

if ($LOCK_EX){ 
      flock(ID, $LOCK_EX); #Locks the file
	}
 @tracker_db = <ID>;
 close (ID);

foreach $tlines(@tracker_db) {
@edit_tracker = split(/\|/,$tlines);


print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="550" CELLPADDING="2" BGCOLOR="#FFFFFF" BORDERCOLOR="#400080">
      <TR>
        <TD WIDTH="50"><FONT SIZE="-2" FACE="arial, helvetica">$edit_tracker[0]</FONT></TD>
        <TD WIDTH="450"><A HREF="$link_name/$edit_tracker[1]" TARGET="_blank"><B><FONT SIZE="-2" FACE="arial, helvetica">$link_name/$edit_tracker[1]</FONT></B></A></TD>
        <TD WIDTH="50"><FONT SIZE="-2" FACE="arial, helvetica">$edit_tracker[2]</FONT></TD>
      </TR>
    </TABLE></CENTER>
EOF
}

&footer2;
&footer;

exit;
}



sub mailsent {

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;

<CENTER><BR>
    <TABLE BORDER="0" WIDTH="400">
      <TBODY>
      <TR>
        <TD>
        
        <P><B><FONT FACE="verdana, arial, helvetica"><FONT COLOR="#FF0000">Subscribe
          Me</FONT> Status: Mailing Success!</FONT></B></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Your mailing is now being sent to your Subscribe Me mailing list!  When your mailing is completed, you should receive and automated e-mail from Subscribe Me which will let you know the status of your mailing and the number of addresses delivered to.</FONT></P>
        
        <P><FONT SIZE="-1" FACE="verdana, arial, helvetica">Thank you for
          using Subscribe Me. Please let us know if there any improvements you
          would like us to consider for the next release of our program, at
          <A HREF="mailto:cgi\@elitehost.com">cgi\@elitehost.com</A>.</FONT></P>
        </TD>
      </TR></TBODY>
    </TABLE></CENTER>
EOF
&footer2;
&footer;
exit;
}    






sub copypaste {
print<<EOF;
<BR>
<TABLE BORDER="0" WIDTH="100%">
      <TR>
        <TD>
<CENTER>
    <TABLE BORDER="0">
      <TR>
        <TD WIDTH="400"><FONT SIZE="-1" FACE="verdana, arial, helvetica">Copy
        and paste the following code to your web pages. This will insert the
        Subscribe Me sign up form in any HTML page that you place it in.</FONT></TD>
      </TR>
    </TABLE></CENTER>
<FONT FACE="arial, helvetica" SIZE="-1">
<XMP>
EOF

&cgipathstrip;


print "            <!--START COPY HERE-->\n\n";
    
print "         <FORM ACTION=\"$progpath/";


if ($in{'extension'}) {

print<<EOF;
s.$in{'extension'}" METHOD="POST">
EOF

} else {
print<<EOF;
s.$extension" METHOD="POST">
EOF
}
print<<EOF;
         <TABLE BORDER="0">
           <TBODY>
           <TR>
             <TD BGCOLOR="#FFFFFF">
             <CENTER><FONT SIZE="-2" FACE="verdana, arial, helvetica"><B>Join our
              mailing list<BR>
              for new and<BR>
              updated information!</B></FONT><BR>
             <INPUT TYPE="TEXT" SIZE="10" NAME="e"></CENTER>
             <INPUT TYPE="RADIO" NAME="subscribe" VALUE="subscribe" CHECKED="CHECKED" ALIGN="TOP">
             <INPUT TYPE="HIDDEN" NAME="l" VALUE="$in{'list_name'}">
             <FONT SIZE="-2" FACE="verdana, arial, helvetica">subscribe</FONT><BR>
             <INPUT TYPE="RADIO" NAME="subscribe" VALUE="unsubscribe" ALIGN="TOP">
             <FONT SIZE="-2" FACE="verdana, arial, helvetica">unsubscribe</FONT><BR>
             <CENTER><INPUT TYPE="SUBMIT" VALUE="  Submit  "></CENTER></TD>
           </TR></TBODY>
         </TABLE></FORM>

             <!--END COPY HERE-->

</XMP>
<CENTER>
    <TABLE BORDER="0">
      <TR>
        <TD WIDTH="400"><FONT SIZE="-1" FACE="verdana, arial, helvetica">NOTE: If you prefer your HTML
      responses to load in a blank new window, be sure to change:</FONT></TD>
      </TR>
    </TABLE></CENTER>

<XMP>
      METHOD="POST">

      to

      METHOD="POST" TARGET="_blank">
</XMP>
</FONT>
</TD>
      </TR>
    </TABLE>
EOF
}

sub edit_manually {
&sessioncheck;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_list = split(/\|/,$lines);

if ($in{'list_name'} == $edit_list[0]) {
$listname = $edit_list[1];
last;
 }
}


#undef $/;
#open (LIST,"<$lists/$in{'list_name'}.list");
#if ($LOCK_EX){ 
#      flock(LIST, $LOCK_EX); #Locks the file
#	}
#$database_array = <LIST>;
#close (LIST);
#$/ = "\n";

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER">
        
        <P><FONT SIZE="-1" FACE="Arial, Helvetica"><B>Manual Edit of List:
          $listname</B></FONT><BR>
           </P>
        <TABLE BORDER="0">
          <TR>
            <TD><FONT SIZE="-1" FACE="Arial, Helvetica">Make sure <B>not</B> to enter any additional carriage returns or
            spaces after your last e-mail address. Also verify that each address
            is in proper e-mail address format. Improperly formatted e-mail
            addresses or additional carriage returns/spaces can cause your
            mailings to fail.</FONT></TD>
          </TR>
        </TABLE>
        <FORM METHOD="POST" ACTION="$cgiurl">
        <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
        <INPUT TYPE="HIDDEN" NAME="list_name" VALUE="$in{'list_name'}">
        <INPUT TYPE="HIDDEN" NAME="listname" VALUE="$listname">
        <P><TEXTAREA NAME="new_addresses" ROWS="20" COLS="35" WRAP="Off"></TEXTAREA></P>
        
        <P><INPUT TYPE="SUBMIT" NAME="manual_update" VALUE="    Manual Edit    "></P>
        </FORM></TD>
      </TR>
    </TABLE> </CENTER>
EOF
&footer2;
&footer;
exit;
}

sub edit_manually2 {
&sessioncheck;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_list = split(/\|/,$lines);

if ($in{'list_name'} == $edit_list[0]) {
$listname = $edit_list[1];
last;
 }
}


undef $/;
open (LIST,"<$lists/$in{'list_name'}.list");
if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
$database_array = <LIST>;
close (LIST);
$/ = "\n";

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
    <CENTER>
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD ALIGN="CENTER">
        
        <P><FONT SIZE="-1" FACE="Arial, Helvetica"><B>Manual Edit of List:
          $listname</B></FONT><BR>
           </P>
        <TABLE BORDER="0">
          <TR>
            <TD><FONT SIZE="-1" FACE="Arial, Helvetica">Make sure <B>not</B> to enter any additional carriage returns or
            spaces after your last e-mail address. Also verify that each address
            is in proper e-mail address format. Improperly formatted e-mail
            addresses or additional carriage returns/spaces can cause your
            mailings to fail.<BR><BR><B>Please note</B> that some browsers (some Netscape browsers, for instance) will not properly load all addresses
            into the screen below, which makes it impossible to properly manually edit your list using this feature.</FONT></TD>
          </TR>
        </TABLE>
        <FORM METHOD="POST" ACTION="$cgiurl">
        <INPUT TYPE="HIDDEN" NAME="session_id" VALUE="$in{'session_id'}">
        <INPUT TYPE="HIDDEN" NAME="list_name" VALUE="$in{'list_name'}">
        <INPUT TYPE="HIDDEN" NAME="listname" VALUE="$listname">
        <P><TEXTAREA NAME="new_addresses" ROWS="20" COLS="35" WRAP="Off">$database_array</TEXTAREA></P>
        
        <P><INPUT TYPE="SUBMIT" NAME="manual_update2" VALUE="    Manual Edit    "></P>
        </FORM></TD>
      </TR>
    </TABLE> </CENTER>
EOF
&footer2;
&footer;
exit;
}



sub manual_update {
&sessioncheck;
print "Content-type: text/html\n\n";
&header;
&header2;
#print "<BR>";
$new_addresses = $in{'new_addresses'};
$checklist = $new_addresses;
(@newlist) = split(/\n/, $checklist);
foreach $line(@newlist) {
chomp($line);
$line =~ s/\r//;

$line =~ s/\s//g;

unless ($line =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $line !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
         &already_listed;
        } else {
         $legalemail = 0;
         unless($line){
         $line = "Possibe extra carriage return";
         }
         print "<FONT SIZE=\"-1\" FACE=\"Arial, Helvetica\">Illegal address or character - <B>$line</B></FONT><BR>";
        }
 }
if (($legalemail !~ 1) || ($duplicate)) {
print<<EOF;
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD><BR><FONT SIZE="-1" FACE="Arial, Helvetica">The addresse(s) above is/are
        incorrectly formatted or are duplicates. Please recheck these addresses and press your
        browser's BACK button or if your browser supports Javascript press the
        <B><FONT COLOR="#FF0000"> BACK TO LIST EDIT FORM</FONT></B> button
        below.<BR>
        </FONT><BR>
        <CENTER>
        <FORM><INPUT TYPE="BUTTON" VALUE="BACK TO LIST EDIT FORM" 
        ONCLICK="history.go(-1)"></FORM></CENTER></TD>
      </TR>
    </TABLE>
EOF
&footer2;
&footer;
exit;
}

chomp($new_addresses);
open (LIST,">>$lists/$in{'list_name'}.list");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}

foreach $line(@newlist) {
chomp($line);
$line =~ s/\r//;
$line =~ tr/A-Z/a-z/;

print LIST "$line";
#print LIST "$new_addresses";
print LIST "\n";
}
close (LIST);

print<<EOF;
<P><FONT SIZE="-1" FACE="Arial, Helvetica"><B>List $in{'listname'} updated</B></FONT></P>
EOF
&footer2;
&footer;
exit;
}


sub manual_update2 {
&sessioncheck;
print "Content-type: text/html\n\n";
&header;
&header2;
#print "<BR>";
$new_addresses = $in{'new_addresses'};
$checklist = $new_addresses;
(@newlist) = split(/\n/, $checklist);
foreach $line(@newlist) {
chomp($line);
$line =~ s/\r//;

$line =~ s/\s//g;

unless ($line =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(,)/
	  || $line !~
	  /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
	  {
         $legalemail = 1;
         #&already_listed;
        } else {
         $legalemail = 0;
         unless($line){
         $line = "Possibe extra carriage return";
         }
         print "<FONT SIZE=\"-1\" FACE=\"Arial, Helvetica\">Illegal address or character - <B>$line</B></FONT><BR>";
        }
 }
if ($legalemail !~ 1) {
print<<EOF;
    <TABLE BORDER="0" WIDTH="400">
      <TR>
        <TD><BR><FONT SIZE="-1" FACE="Arial, Helvetica">The addresse(s) above is/are
        incorrectly formatted or are duplicates. Please recheck these addresses and press your
        browser's BACK button or if your browser supports Javascript press the
        <B><FONT COLOR="#FF0000"> BACK TO LIST EDIT FORM</FONT></B> button
        below.<BR>
        </FONT><BR>
        <CENTER>
        <FORM><INPUT TYPE="BUTTON" VALUE="BACK TO LIST EDIT FORM" 
        ONCLICK="history.go(-1)"></FORM></CENTER></TD>
      </TR>
    </TABLE>
EOF
&footer2;
&footer;
exit;
}

chomp($new_addresses);
open (LIST,">$lists/$in{'list_name'}.list");
 if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}

foreach $line(@newlist) {
chomp($line);
$line =~ s/\r//;
$line =~ tr/A-Z/a-z/;

print LIST "$line";
#print LIST "$new_addresses";
print LIST "\n";
}
close (LIST);

print<<EOF;
<P><FONT SIZE="-1" FACE="Arial, Helvetica"><B>List $in{'listname'} updated</B></FONT></P>
EOF
&footer2;
&footer;
exit;
}


sub already_listed {

open (DAT,"$lists/$in{'list_name'}.list");
if ($LOCK_EX){ 
      flock(DAT, $LOCK_EX); #Locks the file
	}
@database_array = <DAT>;
close(DAT);

        foreach $lines(@database_array) {
        chomp($lines);

$existing = $lines;
$email = $line;
$existing =~ tr/A-Z/a-z/;
$email =~ tr/A-Z/a-z/;

if ($existing eq $email) {
print "<FONT SIZE=\"-1\" FACE=\"Arial, Helvetica\">Address already subscribed - <B>$line</B></FONT><BR>";
$duplicate = 1;
  }
 }
}

sub cgipathstrip {

$progpath = $ENV{'SCRIPT_NAME'};
$subpath = $ENV{'SCRIPT_NAME'};
if ($subpath) {
@bb =split(/\//,$subpath);
$balen = push(@bb);
$balen = $balen -1;

$subpath = $bb[$balen];
}


$progpath =~ s/\/$subpath//;
}


sub list_backup {

&sessioncheck;

open (DB, "<$lists/lists.db");
if ($LOCK_EX){ 
      flock(DB, $LOCK_EX); #Locks the file
	}
@db_array = <DB>;
close (DB);

foreach $lines(@db_array) {
@edit_list = split(/\|/,$lines);

if ($in{'list_name'} == $edit_list[0]) {
$listname = $edit_list[1];
last;
 }
}


undef $/;
open (LIST,"<$lists/$in{'list_name'}.list");
if ($LOCK_EX){ 
      flock(LIST, $LOCK_EX); #Locks the file
	}
$database_array = <LIST>;
close (LIST);
$/ = "\n";


open (LIST,">$lists/$in{'list_name'}.backup");
print LIST "$database_array";
close(LIST);

print "Content-type: text/html\n\n";
&header;
&header2;
print<<EOF;
<P><FONT SIZE="-1" FACE="Arial, Helvetica"><B>Backup Created as
$in{'list_name'}.backup<BR>in your $lists directory</B></FONT></P>
EOF
&footer2;
&footer;
exit;

}
