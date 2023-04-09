#!/usr/bin/perl
# visitor Tracker
# Provided by CGI Connection
# http://www.CGIConnection.com


# Your actual domain name should be here
# You shouldn't use www or anything else before it
# Eg. yourserver.com
$domain = "!SITEURL!";

# Where to store files to count users
# Eg. /path/to/store/files
$save_dir = "!TMPDIR!";

# Maximum time in seconds to no longer count a visitor as being on your web site
# Should not be set too low to ensure an accurate count.
# Set higher if you plan to call the script only once or on a couple of your pages.
# If you call the script on multiple pages, you can set the value lower.
$max_time = 60;

# What to display on the browser screen.
# The variable !USERS! will be replaced with the number of users currently online
# The variable !BACKGROUND! will be replace with the background color you specify
$return_line = "<TABLE BORDER=1><TR><TD BGCOLOR=!BACKGROUND!><FONT FACE=\"Arial\">There are !USERS! people online</FONT></TD></TR></TABLE>";

####################################
# DO NOT EDIT BELOW THIS LINE      #
####################################

&parse_form;
&parse_cookies;

$session = $COOKIE{'session'};
$background = $FORM{'background'};

if ($session eq "")
 {
 $new_session = &get_session;
 &write_session("$new_session");
 print "Content-type: text/html\n";
 print "Set-Cookie: session=$new_session; path=/; domain=.$domain;\n\n";
 }
 else
 {
 print "Content-type: text/html\n\n";
 &write_session("$session");
 }

$total_users = &read_sessions;

$return_line =~ s/\!USERS\!/$total_users/ig;
$return_line =~ s/\!BACKGROUND\!/$background/ig;
print "document.write('$return_line');\n";
exit;

sub read_sessions
{
splice(@all_files, 0);

opendir(FILES, "$save_dir");
@all_files = readdir(FILES);
closedir(FILES);

$total_files = @all_files - 2;

for ($j = 2; $j < @all_files; $j++)
 {
 splice(@file_info, 0);
 @file_info = stat("$save_dir\/@all_files[$j]");
 ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks) = @file_info;

 $total_time = time() - $lm;

 if ($total_time > $max_time and $lm > 0)
  {
  unlink("$save_dir\/@all_files[$j]");
  $total_files = $total_files - 1;
  }
 }

return($total_files);
}

sub write_session
{
my ($session) = @_[0];

open(FILE, ">$save_dir\/$session");
print FILE "$ENV{'REMOTE_ADDR'}\n";
close(FILE);
}

sub parse_form {

   if ("\U$ENV{'REQUEST_METHOD'}\E" eq 'GET') {
      # Split the name-value pairs
      @pairs = split(/&/, $ENV{'QUERY_STRING'});
   }
   elsif ("\U$ENV{'REQUEST_METHOD'}\E" eq 'POST') {
      # Get the input
      read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
 
      # Split the name-value pairs
      @pairs = split(/&/, $buffer);
   }
   else {
      &error('request_method');
   }

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
 
      $name =~ tr/+/ /;
      $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # If they try to include server side includes, erase them, so they
      # arent a security risk if the html gets returned.  Another 
      # security hole plugged up.

      $value =~ s/<!--(.|\n)*-->//g;


      # Remove HTML Tags

      $allow_html = 1;
      if ($allow_html == 0)
       {
       $value =~ s/<([^>]|\n)*>//g;
       }
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($FORM{$name} && ($value)) {
          $FORM{$name} = "$FORM{$name}, $value";
	 }
         elsif ($value ne "") {
            $FORM{$name} = $value;

         }
  }
}

sub error
{
local($msg) = @_;
print "Content-Type: text/html\n\n";
print "<CENTER><H2>$msg</H2></CENTER>\n";
exit;
}

sub parse_cookies {
splice(@pairs, 0);
      @pairs = split(/; /, $ENV{'HTTP_COOKIE'});

   foreach $pair (@pairs) {
      ($name, $value) = split(/=/, $pair);
 
      $name =~ tr/+/ /;
      $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      $value =~ tr/+/ /;
      $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

      # If they try to include server side includes, erase them, so they
      # arent a security risk if the html gets returned.  Another 
      # security hole plugged up.

      $value =~ s/<!--(.|\n)*-->//g;


      # Remove HTML Tags

      if ($allow_html == 0)
       {
       $value =~ s/<([^>]|\n)*>//g;
       }
    
      # Create two associative arrays here.  One is a configuration array
      # which includes all fields that this form recognizes.  The other
      # is for fields which the form does not recognize and will report 
      # back to the user in the html return page and the e-mail message.
      # Also determine required fields.

      if ($COOKIE{$name} && ($value)) {
          $COOKIE{$name} = "$COOKIE{$name}, $value";
	 }
         elsif ($value ne "") {
            $COOKIE{$name} = $value;
         }
  }
}

sub get_session
{
my $j;
my $rndval;
my $passcode;

for ($j = 0; $j < 15; $j++)
 {
 until(($rndval > 96 and $rndval < 123) or ($rndval > 64 and $rndval < 91))
  {
  $rndval = int(rand(122));
  }

 $passcode .= chr($rndval);
 $rndval = 0;
 }

return("$passcode");
}
 