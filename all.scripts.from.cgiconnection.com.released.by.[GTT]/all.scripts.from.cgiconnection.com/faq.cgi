#!/usr/bin/perl
# FAQ Generator
# Provided by CGI Connection
# http://www.CGIConnection.com
$| = 1;

# Location where FAQ files will be stored
# Eg. /path/to/faq/files/
$file_dir = "!SAVEDIR!/";

# Username to login to administration section
$username = "!USERNAME!";

# Password to login to administration section
$password = "!PASSWORD!";

# Default font used when displaying FAQ's
$font_face = "Arial";

# Allow HTML codes to be placed in FAQ's
# 0 = NO / 1 = YES
$allow_html = 1;

#################################################
# DO NOT EDIT BELOW THIS LINE                   #
#################################################

&parse_form;
$filename = $FORM{'filename'};
$area = $FORM{'area'};
$locks = $file_dir;
$lock_name = "$filename\.lock";

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

$question_count = 0;
splice(@all_questions, 0);
splice(@all_answers, 0);

&lock;
open(TEXT, "<$file_dir$filename");
$title = <TEXT>;
$titlebg = <TEXT>;
$questionbg = <TEXT>;
$answerbg = <TEXT>;
$width = <TEXT>;
chop($width);
chop($title);
chop($titlebg);
chop($questionbg);
chop($answerbg);
$title =~ s/\'/\\\'/g;

until (eof(TEXT))
 {
 $line = <TEXT>;
 chop($line);

 $line =~ s/\n/<BR>/g;
 $line =~ s/\cM/<BR>/g;
 $line =~ s/\'/\\\'/g;

 if ($line eq "<!--QUESTION-->")
  {
  $line = <TEXT>;
  chop($line);
  $line =~ s/\'/\\\'/g;

  @all_questions[$question_count] = $line;
  $question_count++;
  }
  else
  {
  @all_answers[$question_count - 1] .= $line;
  }
 }

close(TEXT);
&unlock;

if ($width < 200)
 {
 $width = 200;
 }

print "document.write('<TABLE BORDER=1 CELLPADDING=0 CELLSPACING=0 WIDTH=$width>');\n";
print "document.write('<TR><TD BGCOLOR=\"$titlebg\" ALIGN=CENTER><FONT FACE=\"$font_face\" SIZE=+2>$title</FONT></TD></TR>');\n";

for ($j = 0; $j < @all_questions; $j++)
 {
 print "document.write('<TR><TD BGCOLOR=\"$questionbg\"><FONT FACE=\"$font_face\" SIZE=-1><B>@all_questions[$j]</B></FONT></TD></TR>');\n";
 print "document.write('<TR><TD BGCOLOR=\"$answerbg\"><FONT FACE=\"$font_face\" SIZE=-1>@all_answers[$j]</FONT></TD></TR>');\n";
 }

print "document.write('</TABLE>');\n";
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
          $FORM{$name} = "$FORM{$name}\|$value";
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
<HTML>
<TITLE>FAQ Generator</TITLE>
<BODY>
<CENTER>
<H2>FAQ Generator</H2>

<TABLE BORDER=0>
<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="login2">
<INPUT TYPE=hidden NAME=filename VALUE="$FORM{'filename'}">
<TR><TD><B>Username:</B></TD> <TD><INPUT NAME=username></TD></TR>
<TR><TD><B>Password:</B></TD> <TD><INPUT TYPE=password NAME=password></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Login"></TD></TR>
</FORM>
</TABLE>
Provided by <A HREF="http://www.cgiconnection.com">CGI Connection</A>
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
print "<CENTER><H2>Choose FAQ to edit</H2>\n";
print "<A HREF=\"$ENV{'SCRIPT_NAME'}?area=login3&username=$FORM{'username'}&password=$FORM{'password'}\">Create New FAQ</A><BR><BR>\n";

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

$question_count = 0;

if (-e "$file_dir$filename")
 {
 open(FILE, "<$file_dir$filename");
 $title = <FILE>;
 $titlebg = <FILE>;
 $questionbg = <FILE>;
 $answerbg = <FILE>;
 $width = <FILE>;

 until (eof(FILE))
  {
  $line = <FILE>;
  chop($line);

  $line =~ s/<BR>/\n/g;

  if ($line eq "<!--QUESTION-->")
   {
   $line = <FILE>;
   chop($line);
   @all_questions[$question_count] = $line;
   $question_count++;
   }
   else
   {
   @all_answers[$question_count - 1] .= $line;
   }
  }

 close(FILE);
 }

chop($width);
chop($title);
chop($titlebg);
chop($questionbg);
chop($answerbg);

if ($width < 200)
 {
 $width = 200;
 }

{
print<<END
<HTML>
<TITLE>FAQ Generator</TITLE>
<BODY>
<CENTER>
<H2>FAQ Generator</H2>

<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<INPUT TYPE=hidden NAME=area VALUE="save">
<INPUT TYPE=hidden NAME=username VALUE="$FORM{'username'}">
<INPUT TYPE=hidden NAME=password VALUE="$FORM{'password'}">
<TR><TD COLSPAN=4><HR></TD></TR>
<TR><TD><B>FAQ Title</B></TD> <TD><INPUT NAME=title VALUE="$title"></TD></TR>
<TR><TD><B>Title Background</B></TD> <TD><INPUT NAME=titlebg VALUE="$titlebg"></TD></TR>
<TR><TD><B>Questions Background</B></TD> <TD><INPUT NAME=questionbg VALUE="$questionbg"></TD></TR>
<TR><TD><B>Answers Background</B></TD> <TD><INPUT NAME=answerbg VALUE="$answerbg"></TD></TR>
<TR><TD><B>Table Width</B></TD> <TD><INPUT NAME=width VALUE="$width"></TD></TR>
END
}

for ($j = 0; $j < (@all_questions + 5); $j++)
 {
 $count = $j + 1;
 print "<TR><TD><B>Question #$count</B></TD> <TD><INPUT NAME=question VALUE=\"@all_questions[$j]\" SIZE=40></TD></TR>";
 print "<TR><TD><B>Answer #$count</B></TD> <TD><TEXTAREA COLS=40 ROWS=3 NAME=answer>@all_answers[$j]</TEXTAREA></TD></TR>";
 }

{
print<<END
<TR><TD><B>Save As:</B></TD> <TD><INPUT NAME=filename VALUE="$filename"></TD></TR>
<TR><TD><B>Delete this FAQ?</B></TD> <TD><INPUT TYPE=CHECKBOX NAME=delete VALUE="YES"></TD></TR>
<TR><TD COLSPAN=2><INPUT TYPE=submit NAME=submit value="Save FAQ"></TD></TR>
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

if ($filename eq "")
 {
 print "You must enter a filename.\n";
 exit;
 }

if ($FORM{'delete'} ne "")
 {
 unlink("$file_dir$filename");
 print "$filename has been deleted.<BR><BR>";
 print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$username&password=$password\">Go back</A>";
 exit;
 }

splice(@all_questions, 0);
splice(@all_answers, 0);

@all_questions = split(/\|/, $FORM{'question'});
@all_answers = split(/\|/, $FORM{'answer'});

&lock;
open(FILE, ">$file_dir$filename");
print FILE "$FORM{'title'}\n";
print FILE "$FORM{'titlebg'}\n";
print FILE "$FORM{'questionbg'}\n";
print FILE "$FORM{'answerbg'}\n";
print FILE "$FORM{'width'}\n";

for ($j = 0; $j < @all_questions; $j++)
 {
 print FILE "<!--QUESTION-->\n";
 print FILE "@all_questions[$j]\n";
 print FILE "@all_answers[$j]\n";
 }

close(FILE);
&unlock;

print "Saved $filename<BR><BR>";
print "<A HREF=\"$ENV{'ENV_SCRIPT'}?area=login2&username=$username&password=$password\">Go back</A>";
}

sub lock
{
$lock_timer = 0;
$lock_timer_stop = 0;
$lock_passed = 0;

while ($lock_timer_stop < 1)
 {
 for ($locka = 0; $locka < 10; $locka++)
  {
  if (not -e "$locks$lock_name")
   {
   $lock_timer_stop = 1;
   }
   else
   {
   $lock_timer_stop = 0;
   }
  }

 if ($lock_timer_stop == 1)
  {
  open (LOCKIT, ">$locks$lock_name");
  print LOCKIT "LOCKED\n";
  close (LOCKIT);
  }
  else
  {
  $idle_max = 30;
  splice(@lock_info, 0);
  @lock_info=stat("$locks$lock_name");
  ($dev,$irn,$perm,$hl,$uid,$gid,$dt,$size2,$la,$lm,$slc,$obs,$blocks)=@lock_info;

  $id_time = time() - $lm;

  if ($id_time > $idle_max and $lm > 0)
   {
   $lock_passed = 1;
   unlink ("$locks$lock_name");
   }

  select(undef,undef,undef,0.01);
  $lock_timer++;
  }
 }

}

sub unlock
{
unlink ("$locks$lock_name");
}
