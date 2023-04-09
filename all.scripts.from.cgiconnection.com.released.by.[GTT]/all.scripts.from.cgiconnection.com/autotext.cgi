#!/usr/bin/perl
# AutoText 1.0
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location where text files will be stored
# Eg. /path/to/text/files/
$file_dir = "!SAVEDIR!/";

#################################################
# DO NOT EDIT BELOW THIS LINE                   #
#################################################


&parse_form;
$file = $FORM{'file'};

if ($file eq "")
 {
 $file = "text.txt";
 }

print "Content-type: text/html\n\n";

if (not -e "$file_dir$file")
 {
 print "document.write('$file_dir$file does not exist');\n";
 exit;
 }

open(TEXT, "<$file_dir$file");
until(eof(TEXT))
 {
 $line = <TEXT>;
 chop($line);
 
 if ($line ne "")
  {
  $line =~ s/\'/\\\'/g;
  print "document.write('$line');\n";
  }  
 }

close(TEXT);
exit;

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

            if ($webchatter == 1)
             {
             @chatter_lines1[$chatter_lines_count] = $name;
             @chatter_lines2[$chatter_lines_count] = $value;
             $chatter_lines_count++;
             }
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
