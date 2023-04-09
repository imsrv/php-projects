#!/usr/bin/perl
# Content Creator
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location where text (content) files will be stored
# Eg. /path/to/text/files/
$file_dir = "!SAVEDIR!/";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

#################################################
# DO NOT EDIT BELOW THIS LINE                   #
#################################################

&parse_form;
$filename = $FORM{'filename'};
$area = $FORM{'area'};

print "Content-type: text/html\n\n";

if ($area eq "login")
 {
 &login_screen;
 exit;
 }

if ($area eq "login2")
 {
 &show_files;
 exit;
 }

if ($area eq "login3")
 {
 &read_files;
 exit;
 }

if ($area eq "save")
 {
 &save_code;
 exit;
 }

if (not -e "$file_dir$filename" or $filename eq "")
 {
 print "document.write('$file_dir$filename does not exist');\n";
 exit;
 }

open(TEXT, "<$file_dir$filename");
until(eof(TEXT))
 {
 $line = <TEXT>;
 chomp($line);
 $line =~ s/\n//g;
 $line =~ s/\cM//g;

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

sub login_screen
{

{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>Content Creator</TITLE>
<H2>Content Creator</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<INPUT TYPE=hidden NAME=filename VALUE="$FORM{'filename'}">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub show_files
{
if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

opendir(FILES, "$file_dir");
@all_files = readdir(FILES);
closedir(FILES);

@all_files = sort(@all_files);

if (@all_files < 3)
 {
 &read_files;
 exit;
 }

print "<HTML><BODY>";
print "<CENTER><H2>Choose file to edit</H2>\n";

for ($j = 2; $j < @all_files; $j++)
 {
 print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}&filename=@all_files[$j]\">@all_files[$j]</A><BR>\n";
 }

print "</CENTER></BODY></HTML>\n";
}

sub read_files
{

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

$content_stuff = "";

open(FILE, "<$file_dir$filename");

until(eof(FILE))
 {
 $line = <FILE>;
 $content_stuff .= $line;
 }

close(FILE);

{
print<<END
<HTML><BODY>
<CENTER>
<TITLE>Content Creator</TITLE>
<H2>Content Creator</H2>

<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="save">
<INPUT TYPE=hidden NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$FORM{'password'}">
<TR><TD COLSPAN=2><HR></TD></TR>
<TR><TD VALIGN=TOP><B>Content:</B></TD> <TD><TEXTAREA NAME=content ROWS=20 COLS=40>$content_stuff</TEXTAREA></TD></TR>
<TR><TD><B>Save As:</B></TD> <TD><INPUT NAME=filename VALUE="$filename"></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Save"></TD></TR>
</FORM>
</TABLE>
</CENTER>
</BODY></HTML>
END
}

}

sub save_code
{

if ($username ne $FORM{'username'})
 {
 print "Invalid Username!\n";
 exit;
 }

if ($password ne $FORM{'password'})
 {
 print "Invalid Password!\n";
 exit;
 }

open(FILE, ">$file_dir$filename");
print FILE "$FORM{'content'}";
close(FILE);

print "Saved $filename<BR><BR>";
print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$username&password=$password\">Go back</A>";
}
