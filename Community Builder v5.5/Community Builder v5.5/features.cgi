#!/usr/bin/perl
###
#######################################################
#		Community Builder v5.0
#     
#  		Created by Scripts
# 		Email: solutions@solutionscripts.com
#		Web: http://solutionscripts.com
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1999 Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################

require "variables.pl";
$|=1;

unless ($over_bg) { $over_bg= "white"; }
unless ($table_bg) { $table_bg= "white"; }
unless ($table_head_bg) { $table_head_bg= "\#003C84"; }
unless ($text_color) { $text_color= "black"; }
unless ($link_color) { $link_color= "blue"; }
unless ($text_table) { $text_table= "black"; }
unless ($text_table_head) { $text_table_head= "white"; }
unless ($text_highlight) { $text_highlight= "red"; }
unless ($font_face) { $font_face= "arial"; }
unless ($font_size) { $font_size= "-1"; }

@char_set = ('a'..'z','0'..'9');

print "Content-type: text/html\n\n ";

$start_head ="<!-- START HOME FREE HEADER CODE -->\n";
$start_foot ="<!-- START HOME FREE FOOTER CODE -->\n";
$end_head ="<!-- END HOME FREE HEADER CODE -->\n";
$end_foot ="<!-- END HOME FREE FOOTER CODE -->\n";

$version = "3.13";


@days =(Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday);
@months = (January,February,March,April,May,June,July,August,September,October,November,December);
$time = time;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) =  localtime($time);
$ampm = "a.m.";
if ($hour eq 12) { $ampm = "p.m."; }
if ($hour eq 0) { $hour = "12"; }
if ($hour > 12) {
	$hour = ($hour - 12);
	$ampm = "p.m.";
}
if ($min < 10) { $min = "0$min"; }
$year = $year + 1900;
$todaydate = "$days[$wday], $mday $months[$mon] $year, ";
$todaydate = $todaydate."at $hour\:$min $ampm";

$int =1000;
srand();
$rand_num = rand();
$rand_num = int($rand_num * $int); 
$rands = $rand_num + $time;

$cgiurl = $ENV{'SCRIPT_NAME'};
$temp=$ENV{'QUERY_STRING'};

if ($temp) {
	@pairs=split(/&/,$temp);
	foreach $item(@pairs) {
		($key,$content)=split (/=/,$item,2);
		$content=~tr/+/ /;
		$content=~ s/%(..)/pack("c",hex($1))/ge;
        unless ($content eq 'body') {
	    	$value =~ s/<([^>]|\n)*>//g;
        }
		$INPUT{$key}=$content;
	}
}
else {
	read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
	@pairs = split(/&/, $buffer);
	foreach $pair (@pairs) {
		($name, $value) = split(/=/, $pair);
		$value =~ tr/+/ /;
		$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
        unless ($name eq 'body') {
	    	$value =~ s/<([^>]|\n)*>//g;
        }
		if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
		else { $INPUT{$name} = $value; }
#print "<font size=1 face=verdana>$name -- $value<BR></FONT>\n";
	}
}

if($INPUT{'go_gbook'} || $INPUT{'gbook_admin'}) {
	&go_gbook;
}
elsif ($INPUT{'gbook'}) {
	&sign_gbook;
}
elsif ($INPUT{'sign_gbook'}) {
	&sign_gbook_final;
}


if ($INPUT{'wwwboard'} || $INPUT{'wwwboard_admin'}) {
	print "in here..";
	if ($INPUT{'wwwboard'}) {
		$account = $INPUT{'wwwboard'};
		$INPUT{'account'} = $INPUT{'wwwboard'};
	}
	else {
		$account = $INPUT{'wwwboard_admin'};	
		$INPUT{'account'} = $INPUT{'wwwboard_admin'};
	}
	

	&checkpword(1);

	unless (($wwwboard_stat && !($wwwboard_default)) || ($wwwboard_stat && $wwwboard_default && $acco[11])) {
&Header;
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
This account is unauthorized to use a Web Board at this time.
</TD></TR></TABLE><BR>
EOF
		&Footer;
		exit;	
	}
	
	$INPUT{'account'} = $account;
	&checkpword(1);
	$basedir = "$free_path/$base_dir/wwwboard";
	$baseurl = "$url/$base_dir/wwwboard";
	$mesgdir = "";
	$datafile = "data.txt";
	$mesgfile = "index.html";
	$faqfile = "faq.html";
	$ext = "html";
	$title = $acco[12];
	$use_time = 1;		# 1 = YES; 0 = NO

} 

if ($INPUT{'wwwboard'}) { &wwwboard; }
elsif ($INPUT{'save_temp'}) { &save_temp; }
elsif ($INPUT{'wwwboard_admin'}) { &wwwboard_admin; }
else { &main; }
exit;
sub main {
print "...";
exit;
}


########## Web Board 2.0 ##########

sub wwwboard {


$show_faq = 0;		# 1 - YES; 0 = NO
$allow_html = 0;	# 1 = YES; 0 = NO
$quote_text = 1;	# 1 = YES; 0 = NO
$subject_line = 0;	# 0 = Quote Subject Editable; 1 = Quote Subject 
			#   UnEditable; 2 = Don't Quote Subject, Editable.

# Check amount of posts

$num_posts = 0;

opendir (DIR, "$free_path/$base_dir/wwwboard");
@files = grep {!(/^\./)}  readdir(DIR);
close (DIR); 

$num_posts = push(@files);

if ($num_posts > 3) {
	$num_posts = $num_posts - 3;
}
if ($wwwboard_num && ($num_posts >= $wwwboard_num)) {
&Header;
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
We are sorry, This account has reached its limit for number of posts.<BR>
Some must be deleted before new posts can be made.
</TD></TR></TABLE><BR>
EOF
	&Footer;
	exit;	
}

# Get the Data Number
&get_number;
# Put items into nice variables
&get_variables;
# Open the new file and write inINPUTation to it.
&new_file;
# Open the Main WWWBoard File to add link
&main_page;
# Now Add Thread to Individual Pages
if ($num_followups >= 1) {
   &thread_pages;
}
# Return the user HTML
&return_html;
# Increment Number
&increment_num;
}
############################
# Get Data Number Subroutine

sub get_number {
   open(NUMBER,"$basedir/$datafile");
   $num = <NUMBER>;
   close(NUMBER);
   if ($num == 99999)  {
      $num = "1";
   }
   else {
      $num++;
   }
}

###############
# Get Variables

sub get_variables {

   if ($INPUT{'followup'}) {
      $followup = "1";
      @followup_num = split(/,/,$INPUT{'followup'});
      $num_followups = @followups = @followup_num;
      $last_message = pop(@followups);
      $origdate = "$INPUT{'origdate'}";
      $origname = "$INPUT{'origname'}";
      $origsubject = "$INPUT{'origsubject'}";
   }
   else {
      $followup = "0";
   }

   if ($INPUT{'name'}) {
      $name = "$INPUT{'name'}";
      $name =~ s/"//g;
      $name =~ s/<//g;
      $name =~ s/>//g;
      $name =~ s/\&//g;
   }
   else {
      &wwwboard_error(no_name);
   }

   if ($INPUT{'email'} =~ /.*\@.*\..*/) {
      $email = "$INPUT{'email'}";
   }

   if ($INPUT{'subject'}) {
      $subject = "$INPUT{'subject'}";
      $subject =~ s/\&/\&amp\;/g;
      $subject =~ s/"/\&quot\;/g;
   }
   else {
      &wwwboard_error(no_subject);
   }

   if ($INPUT{'url'} =~ /.*\:.*\..*/ && $INPUT{'url_title'}) {
      $message_url = "$INPUT{'url'}";
      $message_url_title = "$INPUT{'url_title'}";
   }

   if ($INPUT{'img'} =~ /.*tp:\/\/.*\..*/) {
      $message_img = "$INPUT{'img'}";
   }

   if ($INPUT{'body'}) {
      $body = "$INPUT{'body'}";
      $body =~ s/\cM//g;
      $body =~ s/\n\n/<p>/g;
      $body =~ s/\n/<br>/g;

      $body =~ s/&lt;/</g; 
      $body =~ s/&gt;/>/g; 
      $body =~ s/&quot;/"/g;
   }
   else {
      &error(no_body);
   }

   if ($quote_text == 1) {
      $hidden_body = "$body";
      $hidden_body =~ s/</&lt;/g;
      $hidden_body =~ s/>/&gt;/g;
      $hidden_body =~ s/"/&quot;/g;
   }

   ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

   if ($sec < 10) {
      $sec = "0$sec";
   }
   if ($min < 10) {
      $min = "0$min";
   }
   if ($hour < 10) {
      $hour = "0$hour";
   }
   if ($mon < 10) {
      $mon = "0$mon";
   }
   if ($mday < 10) {
      $mday = "0$mday";
   }

   $month = ($mon + 1);

   @months = ("January","February","March","April","May","June","July","August","September","October","November","December");

   if ($use_time == 1) {
      $date = "$hour\:$min\:$sec $month/$mday/$year";
   }
   else {
      $date = "$month/$mday/$year";
   }
   chop($date) if ($date =~ /\n$/);

   $long_date = "$months[$mon] $mday, 19$year at $hour\:$min\:$sec";
}      

#####################
# New File Subroutine

sub new_file {

open (HEAD, "$basedir/board.dat");
@datas = <HEAD>;
close (HEAD);

foreach $line(@datas) {
	chomp($line);
}

$datas[10] =~ s/\\n/\n/g;
$datas[11] =~ s/\\n/\n/g;

if ($wwwboard_header) {
	open (HEAD, "$path/wwwboard_header.txt");
	@header = <HEAD>;
	close (HEAD);
	
	open (HEAD, "$path/wwwboard_footer.txt");
	@footer = <HEAD>;
	close (HEAD);
}
else {
	open (HEAD, "$path/$file_head");
	@header = <HEAD>;
	close (HEAD);

	open (HEAD, "$path/$file_foot");
	@footer = <HEAD>;
	close (HEAD);
}

unless ($acco[7]) {
	$acco[7] = "on";
}

open(NEWFILE,">$basedir/$num\.$ext") || &error("Error opening new file");
print NEWFILE "<html>\n";
print NEWFILE "  <head>\n";
print NEWFILE "    <title>$subject</title>\n";
print NEWFILE "  </head>\n";
print NEWFILE "<BODY";
if ($datas[2]) { print NEWFILE " background=\"$datas[2]\""; }
if ($datas[1]) { print NEWFILE " bgcolor=\"$datas[1]\""; }
if ($datas[3]) { print NEWFILE " text=\"$datas[3]\""; }
if ($datas[4]) { print NEWFILE " link=\"$datas[4]\""; }
if ($datas[5]) { print NEWFILE " vlink=\"$datas[5]\""; }
print NEWFILE ">\n\n";

if ($acco[7] eq "on") {
	print NEWFILE "\n$start_head";
	print NEWFILE "@header\n";
	print NEWFILE "\n$end_head";	
}
print NEWFILE $datas[10];
print NEWFILE "\n<font face=arial size=-1><center>\n";
print NEWFILE "      <b>$subject</b>\n";
print NEWFILE "    </center>\n";
print NEWFILE "<hr size=1 noshade width=75%>\n";
print NEWFILE "<center>[ <a href=\"#followups\">Follow Ups</a> ] [ <a href=\"#postfp\">Post Followup</a> ] [ <a href=\"$baseurl/$mesgfile\">$title</a> ]</center>\n";
print NEWFILE "<hr size=1 noshade width=75%><p>\n";
print NEWFILE "<CENTER><TABLE BORDER=0><TR><TD><font face=arial size=-1>\n";
print NEWFILE "Posted by ";
if ($email) {
	print NEWFILE "<a href=\"mailto:$email\">$name</a> on $long_date:<p>\n";
}
else {
	print NEWFILE "$name on $long_date:<p>\n";
}

if ($followup == 1) {
	print NEWFILE "In Reply to: <a href=\"$last_message\.$ext\">$origsubject</a> posted by ";
	if ($origemail) {
		print NEWFILE "<a href=\"$origemail\">$origname</a> on $origdate:<p>\n";
    }
      else {
         print NEWFILE "$origname on $origdate:<p>\n";
      }
   }

   if ($message_img) {
      print NEWFILE "<center><img src=\"$message_img\"></center><p>\n";
   }
   print NEWFILE "$body\n";
   print NEWFILE "<br>\n";
   if ($message_url) {
      print NEWFILE "<ul><li><a href=\"$message_url\">$message_url_title</a></ul>\n";
   }
   print NEWFILE "<br><hr size=1 noshade width=75%><p>\n";
   print NEWFILE "<a name=\"followups\">Follow Ups:</a><br>\n";
   print NEWFILE "<ul><!--insert: $num-->\n";
   print NEWFILE "</ul><!--end: $num-->\n";
   print NEWFILE "<br><hr size=1 noshade width=75%><p>\n";
   print NEWFILE "<a name=\"postfp\">Post a Followup</a><p>\n";
   print NEWFILE "<FORM method=POST action=\"$cgiurl\">\n";
   print NEWFILE "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print NEWFILE "<input type=hidden name=\"wwwboard\" value=\"$account\">\n";
   print NEWFILE "<input type=hidden name=\"followup\" value=\"";
   if ($followup == 1) {
      foreach $followup_num (@followup_num) {
         print NEWFILE "$followup_num,";
      }
   }
   print NEWFILE "$num\">\n";
   print NEWFILE "<input type=hidden name=\"origname\" value=\"$name\">\n";
   if ($email) {
      print NEWFILE "<input type=hidden name=\"origemail\" value=\"$email\">\n";
   }
   print NEWFILE "<input type=hidden name=\"origsubject\" value=\"$subject\">\n";
   print NEWFILE "<input type=hidden name=\"origdate\" value=\"$long_date\">\n";
   print NEWFILE "Name: <input type=text name=\"name\" size=30><br>\n";
   print NEWFILE "E-Mail: <input type=text name=\"email\" size=30><p>\n";
   if ($subject_line == 1) {
      if ($subject_line =~ /^Re:/) {
         print NEWFILE "<input type=hidden name=\"subject\" value=\"$subject\">\n";
         print NEWFILE "Subject: <b>$subject</b><p>\n";
      }
      else {
         print NEWFILE "<input type=hidden name=\"subject\" value=\"Re: $subject\">\n";
         print NEWFILE "Subject: <b>Re: $subject</b><p>\n";
      }
   } 
   elsif ($subject_line == 2) {
      print NEWFILE "Subject: <input type=text name=\"subject\" size=30><p>\n";
   }
   else {
      if ($subject =~ /^Re:/) {
         print NEWFILE "Subject: <input type=text name=\"subject\"value=\"$subject\" size=30><p>\n";
      }
      else {
         print NEWFILE "Subject: <input type=text name=\"subject\" value=\"Re: $subject\" size=30><p>\n";
      }
   }
   print NEWFILE "Comments:<br>\n";
   print NEWFILE "<textarea name=\"body\" COLS=50 ROWS=10>\n";
   if ($quote_text == 1) {
      @chunks_of_body = split(/\&lt\;p\&gt\;/,$hidden_body);
      foreach $chunk_of_body (@chunks_of_body) {
         @lines_of_body = split(/\&lt\;br\&gt\;/,$chunk_of_body);
         foreach $line_of_body (@lines_of_body) {
            print NEWFILE ": $line_of_body\n";
         }
         print NEWFILE "\n";
      }
   }
   print NEWFILE "</textarea>\n";
   print NEWFILE "<p>\n";
   print NEWFILE "Optional Link URL: <input type=text name=\"url\" size=30><br>\n";
   print NEWFILE "Link Title: <input type=text name=\"url_title\" size=30><br>\n";
   print NEWFILE "Optional Image URL: <input type=text name=\"img\" size=30><p>\n";
   print NEWFILE "<input type=submit value=\"Submit Follow Up\"> <input type=reset>\n";
   print NEWFILE "</FORM></TD></TR></TABLE><hr size=1 noshade width=75%>\n";
   if ($show_faq == 1) {
      print NEWFILE "<center>[ <a href=\"#followups\">Follow Ups</a> ] [ <a href=\"#postfp\">Post Followup</a> ] [ <a href=\"$baseurl/$mesgfile\">$title</a> ] [ <a href=\"$baseurl/$faqfile\">FAQ</a> ]</center>\n";
   }
   else {
      print NEWFILE "<center>[ <a href=\"#followups\">Follow Ups</a> ] [ <a href=\"#postfp\">Post Followup</a> ] [ <a href=\"$baseurl/$mesgfile\">$title</a> ]</center>\n";
   }
print NEWLINE $g_foot;
if ($acco[7] eq "on") {
	print NEWFILE "\n$start_foot";
	print NEWFILE "@footer\n";
	print NEWFILE "$end_foot";	
}
   print NEWFILE "</body></html>\n";
   close(NEWFILE);
   
   	@stats = stat("$basedir/$num\.$ext");
	$size = $stats[7];
	$size = $size /1000;
	$t_size = $size + $acco[3];
	$total_size += $acco[6];

	if (($t_size > $total_size) && $wwwboard_size) {
		unlink ("$basedir/$num\.$ext");
		&Header;
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center>
<font color=$text_table face=$font_face size=$font_size>
We are sorry, This account has reached its size limit.<BR>
No more new posts can be made at this time.
</TD></TR></TABLE><BR>
EOF
		&Footer;
		exit;	

	}
}

###############################
# Main WWWBoard Page Subroutine

sub main_page {
   open(MAIN,"$basedir/$mesgfile") || &error("open $basedir/$mesgfile");
   @main = <MAIN>;
   close(MAIN);

   open(MAIN,">$basedir/$mesgfile") || &error("write $basedir/$mesgfile");
   if ($followup == 0) {
      foreach $main_line (@main) {
         if ($main_line =~ /<!--begin-->/) {
            print MAIN "<!--begin-->\n";
	    print MAIN "<!--top: $num--><li><a href=\"$num\.$ext\">$subject</a> - <b>$name</b> <i>$date</i>\n";
            print MAIN "(<!--responses: $num-->0)\n";
            print MAIN "<ul><!--insert: $num-->\n";
            print MAIN "</ul><!--end: $num-->\n";
         }
         else {
            print MAIN "$main_line";
         }
      }
   }
   else {
      foreach $main_line (@main) {
	 $work = 0;
         if ($main_line =~ /<ul><!--insert: $last_message-->/) {
            print MAIN "<ul><!--insert: $last_message-->\n";
            print MAIN "<!--top: $num--><li><a href=\"$num\.$ext\">$subject</a> - <b>$name</b> <i>$date</i>\n";
            print MAIN "(<!--responses: $num-->0)\n";
            print MAIN "<ul><!--insert: $num-->\n";
            print MAIN "</ul><!--end: $num-->\n";
         }
         elsif ($main_line =~ /\(<!--responses: (.*)-->(.*)\)/) {
            $response_num = $1;
            $num_responses = $2;
            $num_responses++;
            foreach $followup_num (@followup_num) {
               if ($followup_num == $response_num) {
                  print MAIN "(<!--responses: $followup_num-->$num_responses)\n";
		  $work = 1;
               }
            }
            if ($work != 1) {
               print MAIN "$main_line";
            }
         }
         else {
            print MAIN "$main_line";
         }
      }
   }
   close(MAIN);
}

############################################
# Add Followup Threading to Individual Pages
sub thread_pages {

   foreach $followup_num (@followup_num) {
      open(FOLLOWUP,"$basedir/$followup_num\.$ext");
      @followup_lines = <FOLLOWUP>;
      close(FOLLOWUP);

      open(FOLLOWUP,">$basedir/$followup_num\.$ext");
      foreach $followup_line (@followup_lines) {
         $work = 0;
         if ($followup_line =~ /<ul><!--insert: $last_message-->/) {
	    print FOLLOWUP "<ul><!--insert: $last_message-->\n";
            print FOLLOWUP "<!--top: $num--><li><a href=\"$num\.$ext\">$subject</a> <b>$name</b> <i>$date</i>\n";
            print FOLLOWUP "(<!--responses: $num-->0)\n";
            print FOLLOWUP "<ul><!--insert: $num-->\n";
            print FOLLOWUP "</ul><!--end: $num-->\n";
         }
         elsif ($followup_line =~ /\(<!--responses: (.*)-->(.*)\)/) {
            $response_num = $1;
            $num_responses = $2;
            $num_responses++;
            foreach $followup_num (@followup_num) {
               if ($followup_num == $response_num) {
                  print FOLLOWUP "(<!--responses: $followup_num-->$num_responses)\n";
                  $work = 1;
               }
            }
            if ($work != 1) {
               print FOLLOWUP "$followup_line";
            }
         }
         else {
            print FOLLOWUP "$followup_line";
         }
      }
      close(FOLLOWUP);
   }
}

sub return_html {
   &Header("Message Added: $subject",1);
   print "<body bgcolor=white text=black link=blue vlink=blue alink=blue><font face=arial size=-1><center><B>Message Added: $subject</b></center>\n";
   print "<br><br>The following information was added to the message board:<p><hr size=1 noshade width=75%><p>\n";
   print "<CENTER><TABLE BORDER=0><TR><TD><font face=arial size=-1>\n";
   print "<b>Name:</b> $name<br>\n";
   print "<b>E-Mail:</b> $email<br>\n";
   print "<b>Subject:</b> $subject<br>\n";
   print "<b>Body of Message:</b><p>\n";
   print "$body<p>\n";
   if ($message_url) {
      print "<b>Link:</b> <a href=\"$message_url\">$message_url_title</a><br>\n";
   }
   if ($message_img) {
      print "<b>Image:</b> <img src=\"$message_img\"><br>\n";
   }
   print "<b>Added on Date:</b> $date<p>\n";
   print "</TD></TR></TABLE></CENTER><hr size=1 noshade width=75%>\n";
   print "<center>[ <a href=\"$baseurl/$num\.$ext\">Go to Your Message</a> ] [ <a href=\"$baseurl/$mesgfile\">$title</a> ]</center>\n";
	&Footer(1);
}

sub increment_num {
   open(NUM,">$basedir/$datafile") || die $!;
   print NUM "$num";
   close(NUM);
}

sub wwwboard_error {
   $error = $_[0];

   if ($error eq 'no_name') {
      &Header("$title ERROR: No Name</title></head>\n",1);
      print "<body bgcolor=white text=black link=blue vlink=blue alink=blue><font face=arial size=-1><center><B>ERROR: No Name</b></center>\n";
      print "<br><br>You forgot to fill in the 'Name' field in your posting.  Correct it below and re-submit.  The necessary fields are: Name, Subject and Message.<p><hr size=1 noshade width=75%><p>\n";
      &rest_of_INPUT;
   }
   elsif ($error eq 'no_subject') {
      &Header("$title ERROR: No Subject",1);
      print "<body bgcolor=white text=black link=blue vlink=blue alink=blue><font face=arial size=-1><center><B>ERROR: No Subject</b></center>\n";
      print "<br><br>You forgot to fill in the 'Subject' field in your posting.  Correct it below and re-submit.  The necessary fields are: Name, Subject and Message.<p><hr size=1 noshade width=75%><p>\n";
      &rest_of_INPUT;
   }
   elsif ($error eq 'no_body') {
      &Header("$title ERROR: No Message",1);
      print "<body bgcolor=white text=black link=blue vlink=blue alink=blue><font face=arial size=-1><center><B>ERROR: No Message</b></center>\n";
      print "<br><br>You forgot to fill in the 'Message' field in your posting.  Correct it below and re-submit.  The necessary fields are: Name, Subjectand Message.<p><hr size=1 noshade width=75%><p>\n";
      &rest_of_INPUT;
   }
   else {
      print "ERROR!  Undefined.\n";
   }
   exit;
}

sub rest_of_INPUT {

   print "</CENTER><FORM method=POST action=\"$cgiurl\">\n";
   print "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print "<input type=hidden name=\"wwwboard\" value=\"$account\">\n";
   if ($followup == 1) {
      print "<input type=hidden name=\"origsubject\" value=\"$INPUT{'origsubject'}\">\n";
      print "<input type=hidden name=\"origname\" value=\"$INPUT{'origname'}\">\n";
      print "<input type=hidden name=\"origemail\" value=\"$INPUT{'origemail'}\">\n";
      print "<input type=hidden name=\"origdate\" value=\"$INPUT{'origdate'}\">\n";
      print "<input type=hidden name=\"followup\" value=\"$INPUT{'followup'}\">\n";
   }
   print "Name: <input type=text name=\"name\" value=\"$INPUT{'name'}\" size=50><br>\n";
   print "E-Mail: <input type=text name=\"email\" value=\"$INPUT{'email'}\" size=50><p>\n";
   if ($subject_line == 1) {
      print "<input type=hidden name=\"subject\" value=\"$INPUT{'subject'}\">\n";
      print "Subject: <b>$INPUT{'subject'}</b><p>\n";
   } 
   else {
      print "Subject: <input type=text name=\"subject\" value=\"$INPUT{'subject'}\" size=50><p>\n";
   }
   print "Message:<br>\n";
   print "<textarea COLS=50 ROWS=10 name=\"body\">\n";
   $INPUT{'body'} =~ s/</&lt;/g;
   $INPUT{'body'} =~ s/>/&gt;/g;
   $INPUT{'body'} =~ s/"/&quot;/g;
   print "$INPUT{'body'}\n";
   print "</textarea><p>\n";
   print "Optional Link URL: <input type=text name=\"url\" value=\"$INPUT{'url'}\" size=45><br>\n";
   print "Link Title: <input type=text name=\"url_title\" value=\"$INPUT{'url_title'}\" size=50><br>\n";
   print "Optional Image URL: <input type=text name=\"img\" value=\"$INPUT{'img'}\" size=45><p>\n";
   print "<input type=submit value=\"Post Message\"> <input type=reset>\n";
   print "</FORM>\n";
	&Footer(1);

}







########## WEB BOARD 2.0 ADMIN ##########
sub wwwboard_admin {


$command = $INPUT{'command'}; 

 
if ($command eq 'remove') {
   &Header("Remove Messages From WebBoard");
   print "<font face=$font_face size=$font_size><B>Remove Messages From WebBoard</b></font><BR>\n";
   print "<table border=0 width=80%><TR align=center><TD><font face=$font_face size=$font_size>Select below to remove those postings you wish to remove.\n";
   print "Checking the Input Box on the left will remove the whole thread\n";
   print "while checking the Input Box on the right to remove just that posting.<p>\n";
   print "These messages have been left unsorted, so that you can see the order in\n";
   print "which they appear in the index page.  This will give you an idea of\n";
   print "what the threads look like and is often more helpful than the sorted method.\n";
   print "</font></TD></TR></TABLE>\n";
   print "<hr size=1 noshade width=75%><center><font size=$font_size>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "<input type=hidden name=\"wwwboard_admin\" value=\"$account\">\n";
   print "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print "<input type=hidden name=\"password\" value=\"$password\">\n";
   print "<input type=hidden name=\"action\" value=\"remove\">\n";
   print "<center><table border=1 cellpadding=4 cellspacing=1 bgcolor=$table_bg>\n";
   print "<tr bgcolor=$table_head_bg>\n";
   print "<th><font face=$font_face size=$font_size color=$text_table_head>Post # </th><th><font face=$font_face size=$font_size color=$text_table_head>Thread </th><th><font face=$font_face size=$font_size color=$text_table_head>Single </th><th><font face=$font_face size=$font_size color=$text_table_head>Subject </th><th><font face=$font_face size=$font_size color=$text_table_head> Author</th><th><font face=$font_face size=$font_size color=$text_table_head> Date</th></tr>\n";

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $line (@lines) {
      if ($line =~ /<!--top: (.*)--><li><a href="\1\.$ext">(.*)<\/a> - <b>(.*)<\/b>\s+<i>(.*)<\/i>/) {
         push(@ENTRIES,$1);
         $SUBJECT{$1} = $2;
         $AUTHOR{$1} = $3;
         $DATE{$1} = $4;
      }
   }

   @SORTED_ENTRIES = (sort { $a <=> $b } @ENTRIES);
   $max = pop(@SORTED_ENTRIES);
   $min = shift(@SORTED_ENTRIES);

   print "<input type=hidden name=\"min\" value=\"$min\">\n";
   print "<input type=hidden name=\"max\" value=\"$max\">\n";
   print "<input type=hidden name=\"type\" value=\"remove\">\n";

   foreach (@ENTRIES) {
      print "<tr>\n";
      print "<th><font face=$font_face size=$font_size color=$text_table><b>$_</b> </th><td><font face=$font_face size=$font_size color=$text_table><input type=radio name=\"$_\" value=\"all\"> </td><td><input type=radio name=\"$_\" value=\"single\"> </td><td><font face=$font_face size=$font_size color=$text_table><a href=\"$baseurl/$_\.$ext\">$SUBJECT{$_} </a></td><td><font face=$font_face size=$font_size color=$text_table>$AUTHOR{$_} </td><td><font face=$font_face size=$font_size color=$text_table>$DATE{$_}<br></td>\n";

      print "</tr>\n";
   }
   print "</table>\n";
   print "<center><p>\n";
   print "<input type=submit value=\"Remove Messages\"> <input type=reset>\n";
   print "</form>\n";
	&Footer;
}

###########################################################################
# Remove By Number                                                        #
#       This method is useful to see in what order the messages were      #
#   added to the wwwboard.html document.                                  #
###########################################################################

elsif ($command eq 'remove_by_num') {
   &Header("Remove Messages From WebBoard by Number");
   print "<font face=$font_face size=$font_size><B>Remove Messages From WebBoard by Number</b></font><br><BR>\n";
   print "<table border=0 width=80%><TR align=center><TD><font face=$font_face size=$font_size>Select below to remove those postings you wish to remove.\n";
   print "Checking the Input Box on the left will remove the whole thread\n";
   print "while checking the Input Box on the right to remove just that posting.\n";
   print "</font></TD></TR></TABLE>\n";
   print "<hr size=1 noshade width=75%>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print "<input type=hidden name=\"wwwboard_admin\" value=\"$account\">\n";
   print "<input type=hidden name=\"password\" value=\"$password\">\n";
   print "<input type=hidden name=\"action\" value=\"remove\">\n";
   print "<center><table border=1 cellpadding=4 cellspacing=1 bgcolor=$table_bg>\n";
   print "<tr bgcolor=$table_head_bg>\n";
   print "<th><font face=$font_face size=$font_size color=$text_table_head>Post # </th><th><font face=$font_face size=$font_size color=$text_table_head>Thread </th><th><font face=$font_face size=$font_size color=$text_table_head>Single </th><th><font face=$font_face size=$font_size color=$text_table_head>Subject </th><th> <font face=$font_face size=$font_size color=$text_table_head>Author</th><th> <font face=$font_face size=$font_size color=$text_table_head>Date</th></tr>\n";

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $line (@lines) {
      if ($line =~ /<!--top: (.*)--><li><a href="\1\.$ext">(.*)<\/a> - <b>(.*)<\/b>\s+<i>(.*)<\/i>/) {
         push(@ENTRIES,$1);
         $SUBJECT{$1} = $2;
         $AUTHOR{$1} = $3;
         $DATE{$1} = $4;
      }
   }

   @SORTED_ENTRIES = (sort { $a <=> $b } @ENTRIES);
   $max = pop(@SORTED_ENTRIES);
   $min = shift(@SORTED_ENTRIES);
   push(@SORTED_ENTRIES,$max);
   unshift(@SORTED_ENTRIES,$min);

   print "<input type=hidden name=\"min\" value=\"$min\">\n";
   print "<input type=hidden name=\"max\" value=\"$max\">\n";
   print "<input type=hidden name=\"type\" value=\"remove\">\n";

   foreach (@SORTED_ENTRIES) {
      print "<tr>\n";
      print "<th><font face=$font_face size=$font_size color=$text_table><b>$_</b> </th><td><input type=radio name=\"$_\" value=\"all\"> </td><td><input type=radio name=\"$_\" value=\"single\"> </td><td><font face=$font_face size=$font_size color=$text_table><a href=\"$baseurl/$_\.$ext\">$SUBJECT{$_} </a></td><td><font face=$font_face size=$font_size color=$text_table>$AUTHOR{$_} </td><td><font face=$font_face size=$font_size color=$text_table>$DATE{$_}<br></td>\n";

      print "</tr>\n";
   }
   print "</table>\n";
   print "<center><p>\n";
   print "<input type=submit value=\"Remove Messages\"> <input type=reset>\n";
   print "</form>\n";
	&Footer;
	exit;
}

###########################################################################
# Remove By Date                                                          #
#       Using this method allows you to delete all messages posted before #
#   a certain date.                                                       #
###########################################################################

elsif ($command eq 'remove_by_date') {
   &Header("Remove Messages From WebBoard by Date");
   print "<font face=$font_face size=$font_size><B>Remove Messages From WebBoard by Date</b></font><br><BR>\n";
   print "<table border=0 width=80%><TR align=center><TD><font face=$font_face size=$font_size>Select below to remove those postings you wish to remove.\n";
   print "Checking the input box beside a date will remove all postings \n";
   print "that occurred on that date.\n";
   print "</font></TD></TR></TABLE>\n";
   print "<hr size=1 noshade width=75%><center>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print "<input type=hidden name=\"wwwboard_admin\" value=\"$account\">\n";
   print "<input type=hidden name=\"password\" value=\"$password\">\n";
   print "<input type=hidden name=\"action\" value=\"remove_by_date_or_author\">\n";
   print "<input type=hidden name=\"type\" value=\"remove_by_date\">\n";
   print "<center>\n";
   print "<center><table border=1 cellpadding=4 cellspacing=1 bgcolor=$table_bg>\n";
   print "<tr bgcolor=$table_head_bg>\n";
   print "<th><font face=$font_face size=$font_size color=$text_table_head>X </th><th><font face=$font_face size=$font_size color=$text_table_head>Date </th><th><font face=$font_face size=$font_size color=$text_table_head># of Messages </th><th><font face=$font_face size=$font_size color=$text_table_head>Message Numbers<br></th></tr>\n";

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $line (@lines) {
      if ($line =~ /<!--top: (.*)--><li><a href="\1\.$ext">.*<\/a> - <b>.*<\/b>\s+<i>(.*)<\/i>/) {
         $date = $2;
         if ($use_time == 1) {
            ($time,$day) = split(/\s+/,$date);
         }
         else {
            $day = $date;
         }
         $DATE{$1} = $day;
      }
   }

   undef(@used_values);
   foreach $value (sort (values %DATE)) {
      $match = '0';
      $value_number = 0;
      foreach $used_value (@used_values) {
         if ($value eq $used_value) {
            $match = '1';
            last;
         }
      }
      if ($match == '0') {
         undef(@values); undef(@short_values);
         foreach $key (keys %DATE) {
            if ($value eq $DATE{$key}) {
               $key_url = "<a href=\"$baseurl/$key\.$ext\">$key</a>";
               push(@values,$key_url);
	       push(@short_values,$key);
               $value_number++;
            }
         }
         $form_value = $value;
         $form_value =~ s/\//_/g;
         print "<tr>\n";
         print "<td><input type=checkbox name=\"$form_value\" value=\"@short_values\"> </td><th><font face=$font_face size=$font_size color=$text_table>$value </th><td><font face=$font_face size=$font_size color=$text_table>$value_number </td><td><font face=$font_face size=$font_size color=$text_table>@values<br></td>\n";
         print "</tr>\n";
         push(@used_values,$value);
         push(@used_form_values,$form_value);
      }
   }
   print "</table><p>\n";
   print "<input type=hidden name=\"used_values\" value=\"@used_form_values\">\n";
   print "<input type=submit value=\"Remove Messages\"> <input type=reset>\n";
   print "</form></center>\n";
&Footer;
}

###########################################################################
# Remove By Author                                                        #
#       This option makes a list of all known authors and then groups     #
#    together there postings and allows you to remove them all at once.   #
###########################################################################

elsif ($command eq 'remove_by_author') {
   &Header("Remove Messages From WebBoard by Author");
   print "<font face=$font_face size=$font_size><B>Remove Messages From WebBoard by Author</b></font><br><BR>\n";
   print "<table border=0 width=80%><TR align=center><TD><font face=$font_face size=$font_size>Checking the checkbox beside the name of an author will remove \n";
   print "all postings which that author has created.\n";
   print "</font></TD></TR></TABLE>\n";
   print "<hr size=1 noshade width=75%><center>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "<input type=hidden name=\"cata\" value=\"$cata\">\n";
   print "<input type=hidden name=\"wwwboard_admin\" value=\"$account\">\n";
   print "<input type=hidden name=\"password\" value=\"$password\">\n";
   print "<input type=hidden name=\"action\" value=\"remove_by_date_or_author\">\n";
   print "<input type=hidden name=\"type\" value=\"remove_by_author\">\n";
   print "<center><table border=1 cellpadding=4 cellspacing=1 bgcolor=$table_bg>\n";
   print "<tr bgcolor=$table_head_bg>\n";
   print "<th><font face=$font_face size=$font_size color=$text_table_head>X </th><th><font face=$font_face size=$font_size color=$text_table_head>Author </th><th><font face=$font_face size=$font_size color=$text_table_head># of Messages </th><th><font face=$font_face size=$font_size color=$text_table_head>Message #'s<br></th></tr>\n";

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $line (@lines) {
      if ($line =~ /<!--top: (.*)--><li><a href="\1\.$ext">.*<\/a> - <b>(.*)<\/b>\s+<i>.*<\/i>/) {
         $AUTHOR{$1} = $2;
      }
   }

   undef(@used_values);
   foreach $value (sort (values %AUTHOR)) {
      $match = '0';
      $value_number = 0;
      foreach $used_value (@used_values) {
         if ($value eq $used_value) {
            $match = '1';
            last;
         }
      }
      if ($match == '0') {
         undef(@values); undef(@short_values);
         foreach $key (keys %AUTHOR) {
            if ($value eq $AUTHOR{$key}) {
               $key_url = "<a href=\"$baseurl/$key\.$ext\">$key</a>";
               push(@values,$key_url);
               push(@short_values,$key);
               $value_number++;
            }
         }
         $form_value = $value;
         $form_value =~ s/ /_/g;
         print "<tr>\n";
         print "<td><input type=checkbox name=\"$form_value\" value=\"@short_values\"> </td><th align=left><font face=$font_face size=$font_size color=$text_table>$value </th><td><font face=$font_face size=$font_size color=$text_table>$value_number </td><td><font face=$font_face size=$font_size color=$text_table>@values<br></td>\n";
         print "</tr>\n";
         push(@used_values,$value);
         push(@used_form_values,$form_value);
      }
   }
   print "</table><p>\n";
   print "<input type=hidden name=\"used_values\" value=\"@used_form_values\">\n";
   print "<input type=submit value=\"Remove Messages\"> <input type=reset>\n";
   print "</form></center>\n";
   &Footer;
   exit;
}

###########################################################################
# Remove Action                                                           #
#       This portion is used by the options remove and remove_by_num.     #
###########################################################################

elsif ($INPUT{'action'} eq 'remove') {

   for ($i = $INPUT{'min'}; $i <= $INPUT{'max'}; $i++) {
      if ($INPUT{$i} eq 'all') {
         push(@ALL,$i);
      }
      elsif ($INPUT{$i} eq 'single') {
         push(@SINGLE,$i);
      }
   }

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $single (@SINGLE) {
      foreach ($j = 0;$j <= @lines;$j++) {
         if ($lines[$j] =~ /<!--top: $single-->/) {
            splice(@lines, $j, 3);
            $j -= 3;
         }
         elsif ($lines[$j] =~ /<!--end: $single-->/) {
            splice(@lines, $j, 1);
            $j--;
         }
      }
      $filename = "$basedir/$single\.$ext";
      if (-e $filename) {
         unlink("$filename") || push(@NOT_REMOVED,$single);
      }
      else {
         push(@NO_FILE,$single);
      }
      push(@ATTEMPTED,$single);
   }

   foreach $all (@ALL) {
      undef($top); undef($bottom);
      foreach ($j = 0;$j <= @lines;$j++) {
         if ($lines[$j] =~ /<!--top: $all-->/) {
            $top = $j;
         }
         elsif ($lines[$j] =~ /<!--end: $all-->/) {
            $bottom = $j;
         }
      }
      if ($top && $bottom) {
         $diff = ($bottom - $top);
         $diff++;
         for ($k = $top;$k <= $bottom;$k++) {
            if ($lines[$k] =~ /<!--top: (.*)-->/) {
               push(@DELETE,$1);
            }
         }
         splice(@lines, $top, $diff);
         foreach $delete (@DELETE) {
            $filename = "$basedir/$delete\.$ext";
            if (-e $filename) {
               unlink($filename) || push(@NOT_REMOVED,$delete);
            }
            else {
               push(@NO_FILE,$delete);
            }
            push(@ATTEMPTED,$delete);
         }
      }
      else {
         push(@TOP_BOT,$all);
      }
   }

   open(WWWBOARD,">$basedir/$mesgfile");
   print WWWBOARD @lines;
   close(WWWBOARD);      

   &return_html_admin($INPUT{'type'});

}

###########################################################################
# Remove Action by Date or Author                                         #
#       This portion is used by the method remove_by_date or 		  #
#   remove_by_author.     		  				  #
###########################################################################

elsif ($INPUT{'action'} eq 'remove_by_date_or_author') {

   @used_values = split(/\s/,$INPUT{'used_values'});
   foreach $used_value (@used_values) {
      @misc_values = split(/\s/,$INPUT{$used_value});
      foreach $misc_value (@misc_values) {
         push(@SINGLE,$misc_value);
      }
   }

   open(MSGS,"$basedir/$mesgfile");
   @lines = <MSGS>;
   close(MSGS);

   foreach $single (@SINGLE) {
      foreach ($j = 0;$j <= @lines;$j++) {
         if ($lines[$j] =~ /<!--top: $single-->/) {
            splice(@lines, $j, 3);
            $j -= 3;
         }
         elsif ($lines[$j] =~ /<!--end: $single-->/) {
            splice(@lines, $j, 1);
            $j--;
         }
      }
      $filename = "$basedir/$single\.$ext";
      if (-e $filename) {
         unlink("$filename") || push(@NOT_REMOVED,$single);
      }
      else {
         push(@NO_FILE,$single);
      }
      push(@ATTEMPTED,$single);
   }

   open(WWWBOARD,">$basedir/$mesgfile");
   print WWWBOARD @lines;
   close(WWWBOARD);

   &return_html_admin($INPUT{'type'});

}


else {
   print "This is no place for a kid like you......\n";
}

}

sub return_html_admin {
   $type = $_[0];
   if ($type eq 'remove') {
      &Header("Results of Message Board Removal\n");
      print "<center><font face=$font_face size=$font_size><B>Results of Message Board Removal</b></font></center>\n";
   }
   elsif ($type eq 'remove_by_num') {
      &Header("Results of Message Board Removal by Number\n");
      print "<center><font face=$font_face size=$font_size><B>Results of Message Board Removal by Number</b></font></center>\n";
   }
   elsif ($type eq 'remove_by_date') {
      &Header("Results of Message Board Removal by Date\n");
      print "<center><font face=$font_face size=$font_size><B>Results of Message Board Removal by Date</b></font></center>\n";
   }
   elsif ($type eq 'remove_by_author') {
      &Header("Results of Message Board Removal by Author\n");
      print "<center><font face=$font_face size=$font_size><B>Results of Message Board Removal by Author</b></font></center>\n";
   }
   if ($type =~ /^remove/) {
      print "<Table width=80% border=0><TR><TD><font face=$font_face size=$font_size>Below is a short summary of what messages were removed\n";
      print ".  All files that the script attempted to remove, were removed,\n";
      print "unless there is an error message stating otherwise.</TD></TR></TABLE>\n";
 
      print "<b>Removed #s:</b> @ATTEMPTED<p>\n";
      if (@NOT_REMOVED) {
         print "<b>Files That Could Not Be Deleted:</b> @NOT_REMOVED<p>\n";
      }
      if (@NO_FILE) {
         print "<b>Files Not Found:</b> @NO_FILE<p>\n";
      }
      print "<hr size=1 noshade width=75%><center>\n";

print <<EOF;
<FORM METHOD=POST ACTION="$url_to_cgi/manager.cgi">
<input type=hidden name="cata" value="$cata">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$account">
<INPUT TYPE="HIDDEN" NAME="password" VALUE="$password">
<input type="Submit" name="log" value=" Back to Account Manager">
</form>
EOF

&Footer;
	}
}

########## ERROR RESPONCE ##########
sub error {
&Header;

$error = $_[0] ;
print <<EOF;

<table cellpadding=5 border=1 cellspacing=0 bgcolor="#E0C2C2">
<TR><TD><font face=$font_face size=$font_size>
<B>We are sorry, the system is done at the moment, please try again later<BR><BR>
Thank you<BR><BR><BR>
To help us correct this problem, please let <A HREF="mailto:$your_email">$your_email</A> of the error in red below.<BR><BR>
<I><FONT COLOR="#FF0000">$error -- $!</FONT></I><BR><BR></TD></TR></TABLE>
EOF
&Footer;
exit;
}

########## HEADER ##########
sub Header {
unless ($_[0]) {
	$_[0] = $free_name;
}
if ($_[1]) {
	unless ($file_header) { $file_header="header.txt"; }
	return if $header_printed;
	$header_printed=1;
	print "<HTML><HEAD><TITLE>$_[0]</TITLE></HEAD>\n";
	print "<body bgcolor=$over_bg text=$text_color link=$link_color alink=$link_color vlink=$link_color>\n";
	undef $/;
	open (HEAD, "$path/$file_header");
	$head = <HEAD>;
	close (HEAD);
	unless ($file_header eq "header.txt") {
		$head =~ s/.*\n//;
	}
	print "$head";
	$/="\n";
	print "<br><BR><center>";
}
else {
	unless ($manager_header) { $manager_header="header.txt"; }
	return if $header_printed;
	$header_printed=1;
	print "<HTML><HEAD><TITLE>$_[0]</TITLE></HEAD>\n";
	print "<body bgcolor=$over_bg text=$text_color link=$link_color alink=$link_color vlink=$link_color>\n";
	undef $/;
	open (HEAD, "$path/$manager_header");
	$head = <HEAD>;
	close (HEAD);
	unless ($manager_header eq "header.txt") {
		$head =~ s/.*\n//;
	}
	print "$head";
	$/="\n";
	print "<br><BR><center>";
}

}

########## FOOTER ##########
sub Footer {
if ($_[0]) {
	unless ($file_footer) { $file_footer="footer.txt"; }
	print HTML"</center>";
	undef $/;
	open (HEAD, "$path/$file_footer");
	$foot = <HEAD>;
	close (HEAD);
	unless ($file_footer eq "footer.txt") {
		$foot =~ s/.*\n//;
	}
	print "$foot";
	$/="\n";
}
else {
	unless ($manager_footer) { $manager_footer="footer.txt"; }
	print HTML"</center>";
	undef $/;
	open (HEAD, "$path/$manager_footer");
	$foot = <HEAD>;
	close (HEAD);
	unless ($manager_footer eq "footer.txt") {
		$foot =~ s/.*\n//;
	}
	print "$foot";
	$/="\n";
	if ($credit) {
		print "<center><font size=-1><hr width=525 noshade size=1><a href=\"http://www.freedomain.com\">Community Builder</a> v$version<br>Created by <a href=\"http://www.freedomain.com\"> Scripts</a><br><br>";
	}
	print "</BODY></HTML>\n";
}

}

########## CHECKPASSWORD ##########
sub checkpword {

$skip = $_[0];
$cata = $INPUT{'cata'};
$account = $INPUT{'account'};
$password = $INPUT{'password'};

unless ($cata) { $cata="accounts"; }

@accarray = split(//,$account);

$accfile = "$path/members/$cata/$accarray[0]/$account.dat";

unless (-e "$accfile") {
	&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
The account name you entered could not be found in our database
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}

undef $/;
open (ACC, "$accfile") || &error("Error reading $accfile");
$acc_data = <ACC>;
close (ACC);
$/ = "\n";

@acco = split(/\n/,$acc_data);

if ($acco[18]) {
	&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, this account is currently on hold for the following reason:
<BR><BR>
$acco[18]
<BR><BR>
If you have a question about the status of your account, please contact<BR>
us at <A href="mailto:$your_email">$your_email</A>.<BR><BR>
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}


unless (($INPUT{'password'} eq $acco[2]) || $skip) {
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You have entered the wrong password for this account
</TD></TR></TABLE>
EOF
untie(%acc);
exit;
&Footer;
}
	
$dir_acc = "$account";

unless ($cata eq "accounts") {

	open (ACC, "$path/categories.txt") || &error("Error reading category file");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		if ($key eq $cata) {
			$dir_acc = "$abbo[0]/$account";
			$file_header = $abbo[3];
			$file_footer = $abbo[4];
			$manager_header = $abbo[5];
			$manager_footer = $abbo[6];
			last;
		}
	}
}

unless ($file_header) { $file_header="header_html.txt"; }
unless ($file_footer) { $file_footer="footer_html.txt"; }
unless ($manager_header) { $manager_header="header.txt"; }
unless ($manager_footer) { $manager_footer="footer.txt"; }
if (($manager_header eq "Default") || ($manager_header eq "default")) { $manager_header="header.txt"; }
if (($manager_footer eq "Default") || ($manager_footer eq "default")) { $manager_footer="footer.txt"; }

	&Header;

if ($INPUT{'active_dir'} =~ /\./) { &error("Sorry...."); }
if ($INPUT{'current_dir'} =~ /\./) { &error("Sorry...."); }

$base_dir = $dir_acc;

if ($INPUT{'log'} eq 'Jump to selected dir.') {
	if ($INPUT{'current_dir'} eq 'Main Dir') { 
		$active_dir = '';
		$text_dir = 'Base Directory';

	}
	elsif ($INPUT{'current_dir'}) {
		$active_dir = $INPUT{'current_dir'};
		$dir_acc .= "/$INPUT{'current_dir'}";
		$text_dir = $INPUT{'current_dir'};
	}
}
elsif ($INPUT{'log'} eq 'Go To Dir.') {
	if ($INPUT{'active_dir'}) {
		$active_dir = "$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
		$dir_acc .=  "/$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
		$text_dir = "$INPUT{'active_dir'}/$INPUT{'current_dirs'}";
	}
	else {
		$active_dir = $INPUT{'current_dirs'};
		$dir_acc .=  "/$INPUT{'current_dirs'}";
		$text_dir = $INPUT{'current_dirs'};	
	}
}	
else {
	if ($INPUT{'active_dir'}) {
		$active_dir = $INPUT{'active_dir'};
		$dir_acc .=  "/$INPUT{'active_dir'}";
		$text_dir = $INPUT{'active_dir'};
	}
	else {
		$active_dir = '';
		$text_dir = 'Base Directory';
	}
}

return ($dir_acc);
}

##############################################################################
#
# GUEST BOOK #
#
##############################################################################
sub sign_gbook {

print <<EOF;
<CENTER>
<FORM METHOD=POST ACTION="$cgiurl">
<INPUT TYPE="HIDDEN" NAME="cata" VALUE="$INPUT{'cata'}">
<INPUT TYPE="HIDDEN" NAME="account" VALUE="$INPUT{'gbook'}">
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Your Name:
</TD><TD>
<input type="Text" name="g_name">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Your Email Address:
</TD><TD>
<input type="Text" name="g_email">
</TD></TR>
<TR><TD><font color=$text_table face=$font_face size=$font_size>
Where are you from:
</TD><TD>
<input type="Text" name="g_from">
</TD></TR>
<TR><TD colspan=2><font color=$text_table face=$font_face size=$font_size>
Your Comments:
</TD></TR>
<TR><TD colspan=2>
<textarea name="g_comments" cols="35" rows="8" wrap="OFF"></textarea>
</TD></TR>
<TR><TD colspan=2 align=center>
<input type="Submit" name="sign_gbook" value="  Sign the Guestbook  ">
</TD></TR>
</TABLE>
</FORM>
EOF
&Footer;
exit;
}

########## RECORD GBOOK ENTRIES ##########
sub sign_gbook_final {

&checkpword(1);

unless (($gbook_stat && !($gbook_default)) || ($gbook_stat && $gbook_default && $acco[33])) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font color=$text_table face=$font_face size=$font_size>
This account is not authorized to use a guestbook at this time
</TD></TR></TABLE>
EOF
&Footer;
exit;
}

unless($INPUT{'g_name'} || $INPUT{'g_comments'}) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font color=$text_table face=$font_face size=$font_size>
We thank you for taking interest in signing our guestbook,
<BR><BR>But you must fill in the text boxes labeled
name and comments for your entry to be added.
<BR><BR>
Please hit your back button and make sure these two fields are filled out.<BR>
</TD></TR></TABLE>
EOF
&Footer;
exit;
}

if ( -e "$free_path/$base_dir/gbook.dat" ) { 
	open( GB, "+<$free_path/$base_dir/gbook.dat");
	if ($flock) {
		flock GB, 2; 
	}
	@datas = <GB>;
	seek (GB, 0, 0);
	truncate (GB,0);
	
	chomp ($datas[12]);
	chomp ($datas[13]);
	$l_name = $datas[12];
	$l_email = $datas[13];
	$datas[12] = $INPUT{'g_name'};
	$datas[13] = $INPUT{'g_email'};	

	foreach $line(@datas) {
		chomp($line);
		print GB "$line\n";
	}

	close (GB);
}
else {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font color=$text_table face=$font_face size=$font_size>
This guestbook has not yet been set up, therefore can not be written to.
<BR>
</TD></TR></TABLE>
EOF
	&Footer,
	exit;
}

if (($l_name eq $INPUT{'g_name'}) || ($l_email eq $INPUT{'g_email'})) {
print <<EOF;
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font color=$text_table face=$font_face size=$font_size>
Thank you for signing our guestbook.
<BR><BR>
If you would like to view your entry along with all the others,<BR>
you can find our guestbook here<BR>
<a href="$url/$base_dir/guestbook.html">$url/$base_dir/guestbook.html</A><BR>
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
} 

$INPUT{'g_comments'} =~ s/\r/<BR>/gi;
unless ($INPUT{'g_comments'} =~ /<BR>$/i) {
	$INPUT{'g_comments'} .= "<BR><BR>";
}

if ( -e "$free_path/$base_dir/guestbook.html" ) { 
	open( GB, "+<$free_path/$base_dir/guestbook.html");
	if ($flock) {
		flock GB, 2; 
	}
	@gbook = <GB>;
	seek (GB, 0, 0);
	truncate (GB,0);
	foreach $line(@gbook) {
	
		if ($line =~ /<!-- INSERT -->/) {
			print GB "$line";
			print GB "<!-- NUM $rands -->\n";
			print GB "<!-- TABLE 1 -->\n";
			print GB "<TR";
			if ($datas[6]) {
				print GB " bgcolor=$datas[6]";
			}
			print GB "><TD><font face=verdana size=1";
			if ($datas[8]) {
				print GB " color=$datas[8]";
			}
			print GB ">\nName - $INPUT{'g_name'}";
			if ($INPUT{'g_email'}) {
				print GB "\&nbsp\;&nbsp\;\&nbsp\;\&nbsp\;";
				print GB "Email - <A HREF=\"mailto:$INPUT{'g_email'}\">$INPUT{'g_email'}</A><BR>\n";
			}
			print GB "Date -- $todaydate";
			if ($INPUT{'g_from'}) {
				print GB "\&nbsp\;&nbsp\;\&nbsp\;\&nbsp\;";
				print GB "From - $INPUT{'g_from'}\n";
			}
			print GB "</TD></TR>\n";
			print GB "<!-- TABLE 2 -->\n";
			print GB "<TR";
			if ($datas[7]) {	
				print GB " bgcolor=$datas[7]";
			}
			print GB "><TD><font face=verdana size=1";
			if ($datas[9]) {
				print GB " color=$datas[9]";
			}
			print GB ">\n$INPUT{'g_comments'}\n</TD></TR>\n";
		}
		else {
			print GB $line;
		}
	}
	close (GB);
}

print <<EOF;
<CENTER><table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD align=center><font color=$text_table face=$font_face size=$font_size>
Thank you for signing our guestbook.
<BR><BR>
If you would like to view your entry along with all the others,<BR>
you can find our guestbook here:<BR>
<a href="$url/$base_dir/guestbook.html">$url/$base_dir/guestbook.html</A><BR>
</TD></TR></TABLE>
</CENTER>
EOF
&Footer;
exit;
}

##############################################################################
# WWWBoard                      Version 2.0 ALPHA 2                          #
# Copyright 1996 Matt Wright    mattw@worldwidemart.com                      #
# Created 10/21/95              Last Modified 11/25/95                       #
# Scripts Archive at:           http://www.worldwidemart.com/scripts/        #
##############################################################################
# COPYRIGHT NOTICE                                                           #
# Copyright 1996 Matthew M. Wright  All Rights Reserved.                     #
#                                                                            #
# WWWBoard may be used and modified free of charge by anyone so long as      #
# this copyright notice and the comments above remain intact.  By using this #
# code you agree to indemnify Matthew M. Wright from any liability that      #  
# might arise from it's use.                                                 #  
#                                                                            #
# Selling the code for this program without prior written consent is         #
# expressly forbidden.  In other words, please ask first before you try and  #
# make money off of my program.                                              #
#                                                                            #
# Obtain permission before redistributing this software over the Internet or #
# in any other medium.  In all cases copyright and header must remain intact.#
##############################################################################