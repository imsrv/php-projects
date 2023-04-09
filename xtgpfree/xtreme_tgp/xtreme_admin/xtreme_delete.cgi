#!/usr/bin/perl

######################################################################
#                        X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################
$path = "/home/darkforce/newraw";

#NOTHING BELOW THIS LINE NEEDS TO BE TOUCHED
###########################################################

$option = $ENV{'QUERY_STRING'};
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
        ($name, $value) = split(/=/, $pair);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/<([^>]|\n)*>//g;
        if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
        else { $INPUT{$name} = $value; }
}  



sub delete {
$data_file="aprove.txt";
open(DAT, "$path/$data_file") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);

foreach $main (@raw_data)
{
 chop($main);
 ($name,$email,$count,$url,$ip,$type)=split(/\|/,$main);
 $check = $check + 1;

if ($check == $cnt)
{
$mailprog = '/usr/sbin/sendmail';

# change this to your own email address
 
# this opens an output stream and pipes it directly to the sendmail
# program.  If sendmail can't be found, abort nicely by calling the
# dienice subroutine (see below)

open (MAIL, "|$mailprog -t") or &dienice("Can't access $mailprog!\n");

# here we're printing out the header info for the mail message. You must
# specify who it's to, or it won't be delivered:

print MAIL "To: $rec\n";

# Reply-to can be set to the email address of the sender, assuming you
# have actually defined a field in your form called 'email'.

print MAIL "Reply-to: webmaster\@cyphonic.net\n";

# print out a subject line so you know it's from your form cgi.
# The two \n\n's end the header section of the message.  anything
# you print after this point will be part of the body of the mail.

print MAIL "Subject: Submission Denied\n\n";
print MAIL "Dear $name\n";
print MAIL "\n";
print MAIL "We regret to inform you that your submission to\n";
print MAIL "EliteList Movie Post was denied.\n";
close(MAIL);
}
else
{
}
}      





$cnt = $cnt -1;
$sitedata="aprove.txt";

open(DAT,"$path/$sitedata") || die("Cannot Open File");
@raw_data=<DAT>; 
close(DAT);

splice(@raw_data,$cnt,1);

open(DAT,">$path/$sitedata") || die("Cannot Open File");
print DAT @raw_data; 
close(DAT);


print "Location: xtreme_admin.cgi?queue\n\n";

}

&delete;




