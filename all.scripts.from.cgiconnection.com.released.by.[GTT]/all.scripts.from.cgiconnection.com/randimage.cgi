#!/usr/bin/perl
# Random Image Rotator
# Version 1.5
# Provided by CGI Connection
# http://www.CGIConnection.com



# Location where to read image/url files
# Eg. /path/to/your/data/files/
$rand_loc = "!SAVEDIR!/";

#DO NOT EDIT BELOW THIS LINE
#############################################

&parse_form;

$image_tag = $FORM{'imagetag'};
$rotate_time = $FORM{'rotatetime'};

if ($image_tag eq "")
 {
 $image_tag = "randomimage";
 }

if ($rotate_time eq "")
 {
 $rotate_time = 5;
 }


$timenown = "timenow$image_tag";
$counttimern = "counttimer$image_tag";
$timesetn = "timeset$image_tag";
$nimagen = "nimage$image_tag";
$imagesn = "images$image_tag";
$urlsn = "urls$image_tag";
$checktimen = "check_time$image_tag";
$beginimagen = "begin_image$image_tag";
$gourln = "go_url$image_tag";

$line_count = 0;

open(IMG, "<$rand_loc$FORM{'filename'}");

until(eof(IMG))
 {
 $line = <IMG>;
 chop($line);

 splice(@lines, 0);
 @lines = split(/\|/, $line);

 if ($line ne "")
  {
  @images[$line_count] = @lines[0];
  @urls[$line_count] = @lines[1];
  $line_count++;
  }
 }

close(IMG);

for ($x = 0; $x < @images; $x++)
 {
 if ($x == 0)
  {
  $all_images .= "'@images[$x]'";
  $all_urls .= "'@urls[$x]'";
  }
  else
  {
  $all_images .= ",'@images[$x]'";
  $all_urls .= ",'@urls[$x]'";
  }
 }

print "Content-type: text/html\n\n";

&script;

exit;

sub script
{
print<<END
var $timenown = 0;
var $counttimern = 0;
var $timesetn = $rotate_time;
var $nimagen = new Image;
var $imagesn = new Array($all_images);
var $urlsn = new Array($all_urls);

document.write('<A HREF="javascript:onClick=$gourln\(\);">');
document.write('<IMG NAME="$image_tag" SRC=' + $imagesn\[$counttimern\] + ' BORDER=0>');
document.write('</A>');

function $gourln\(\) {

if ($urlsn\[$counttimern\] != "")
 {
 location.href = $urlsn\[$counttimern\];
 }

}

function $beginimagen\(\) {

if ($counttimern >= ($imagesn.length - 1))
 {
 $counttimern = 0;
 }
 else
 {
 $counttimern++;
 }

$nimagen.src = $imagesn\[$counttimern\];
document.$image_tag.src = $nimagen.src;
}

function $checktimen\(\) {

$timenown++;

if ($timenown > $timesetn)
 {
 $timenown = 0;
 $beginimagen\(\);
 }

setTimeout('$checktimen\(\);', 1000);
}

$checktimen\(\);
END
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

