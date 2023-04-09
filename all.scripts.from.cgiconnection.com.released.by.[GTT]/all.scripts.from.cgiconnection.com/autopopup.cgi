#!/usr/bin/perl
# Auto Pop Up 1.0
# Under no circumstances should this program be copied or altered in any way
# Developed By CGI Connection
# http://www.CGIConnection.com
# Copyright 2001

&parse_form;

$exptime = $FORM{'exptime'};
$url = $FORM{'url'};
$poptype = $FORM{'poptype'};
$height = $FORM{'height'};
$width = $FORM{'width'};
$resize = $FORM{'resize'};
$scrollbars = $FORM{'scrollbars'};

if ($exptime < 1)
 {
 $exptime = "0";
 }

if ($resize == 1)
 {
 $resize = "yes";
 }
 else
 {
 $resize = "no";
 }

if ($scrollbars == 1)
 {
 $scrollbars = "yes";
 }
 else
 {
 $scrollbars = "no";
 }

if ($poptype == 1)
 {
 $poptype = "1";
 }
 else
 {
 $poptype = "0";
 }

print "Content-type: text/html\n\n";

&all_code;
exit;

sub all_code
{
print <<END
function GetCookie (name) {
	var arg = name + "=";  
	var alen = arg.length;  
	var clen = document.cookie.length;  
	var i = 0;  
	while (i < clen) {    
	var j = i + alen;    
	if (document.cookie.substring(i, j) == arg)      
		return getCookieVal (j);    
		i = document.cookie.indexOf(" ", i) + 1;    
		if (i == 0) break;   
	}  
	return null;
}
function SetCookie (name, value) {  
	var argv = SetCookie.arguments;  
	var argc = SetCookie.arguments.length;  
	var expires = (argc > 2) ? argv[2] : null;  
	var path = (argc > 3) ? argv[3] : null;  
	var domain = (argc > 4) ? argv[4] : null;  
	var secure = (argc > 5) ? argv[5] : false;  
	document.cookie = name + "=" + escape (value) + 
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) + 
	((path == null) ? "" : ("; path=" + path)) +  
	((domain == null) ? "" : ("; domain=" + domain)) +    
	((secure == true) ? "; secure" : "");
}
function DeleteCookie (name) {  
	var exp = new Date();  
	exp.setTime (exp.getTime() - 1);  
	// This cookie is history  
	var cval = GetCookie (name);  
	document.cookie = name + "=" + cval + "; expires=" + exp.toGMTString();
}

var tmpamt;
var poptype = $poptype;
var expDays = $exptime;
var exp = new Date(); 
exp.setTime(exp.getTime() + (expDays*24*60*60*1000));

function amt(){
        var count = GetCookie('count');

	if(count < 1) {

                if (expDays > 0)
                 {
                 SetCookie('count','1',exp);
                 }

                if (poptype == 0)
                 {
                 popUp();
                 }
                 else
                 {
                 popUnder();
                 }

	}
	else {
               if (expDays > 0)
                {  
		var newcount = parseInt(count) + 1;
                DeleteCookie('count');

                SetCookie('count',newcount,exp);
                return count;
                }
	}
}
function getCookieVal(offset) {
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
    endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}

function popUnder() {
pUnder = window.open('$url','','toolbar=no,menubar=no,scrollbars=$scrollbars,resizable=$resize,location=no,height=$height,width=$width');
pUnder.blur();
}

function popUp() {
pUp = window.open('$url','','toolbar=no,menubar=no,scrollbars=$scrollbars,resizable=$resize,location=no,height=$height,width=$width');
pUp.focus();
}

tmpamt = amt();
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

exit;

