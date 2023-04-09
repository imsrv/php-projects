#!/usr/bin/perl
#Payment Verifier 1.0
#Provided by CGI Connection
#http://www.CGIConnection.com

&parse_form;

$routing = $FORM{'routing'};
$account = $FORM{'account'};
$cardnumber = $FORM{'cardnumber'};
$method = $FORM{'method'};

print "Content-type: text/html\n\n";
print "<HTML><BODY>\n";

if ($method eq "")
 {
 &display_screen;
 exit;
 }

if ($method eq "credit")
 {
 if ($FORM{'cardtype'} eq "")
  {
  print "You must select a credit card type.\n";
  print "</BODY></HTML>\n";
  exit;
  }

 &verify_card;
 print "Credit card passed verification.\n";
 print "</BODY></HTML>\n";
 exit;
 }

if ($method eq "check")
 {
 if (length($routing) != 9)
  {
  print "Routing number must be 9 digits.";
  exit;
  }

 if ($account eq "")
  {
  print "You must enter your checking account number.";
  exit;
  }

 if (substr($routing, 0, 1) > 5 or substr($routing, 0, 1) < 0)
  {
  print "You have entered an invalid routing number.";
  exit;
  }

 print "Checking account verified!\n";
 print "</BODY></HTML>\n";
 exit;
 }

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

sub verify_card {

# Remove any spaces or dashes in card number
$cardnumber =~ s/ //g;
$cardnumber =~ s/-//g;
$length = length($cardnumber);

# Make sure that only numbers exist
if (!($cardnumber =~ /^[0-9]*$/)) {
 &invalid_cc;
 }

# Verify correct length for each card type
if ("\L$FORM{'cardtype'}\E" eq "visa") { &vlen; }
if ("\L$FORM{'cardtype'}\E" eq "mastercard") { &mclen; }
if ("\L$FORM{'cardtype'}\E" eq "amex") { &alen; }
if ("\L$FORM{'cardtype'}\E" eq "novus") { &nlen; }

sub vlen {
    &invalid_cc unless (($length == 13) || ($length == 16));
}
sub mclen {
    &invalid_cc unless ($length == 16);    
}
sub alen {
    &invalid_cc unless ($length == 15);    
}
sub nlen {
    &invalid_cc unless ($length == 16);    
}

# Now Verify via Mod 10 for each one
if ($FORM{'cardtype'} eq "visa") { &vver; }
if ($FORM{'cardtype'} eq "mastercard") { &ver16; }
if ($FORM{'cardtype'} eq "amex") { &ver15; }
if ($FORM{'cardtype'} eq "novus") { &ver16; }

# pick one for Visa
sub vver {
        if ($length == 13) { &ver13; }
        if ($length == 16) { &ver16; }
}

# For 13 digit cards
sub ver13 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);

        $cc1a = $cc1 * 2;
        $cc3a = $cc3 * 2;
        $cc5a = $cc5 * 2;
        $cc7a = $cc7 * 2;
        $cc9a = $cc9 * 2;
        $cc11a = $cc11 * 2;

        if ($cc1a >= 10) {
            $cc1b = substr($cc1a,0,1);
            $cc1c = substr($cc1a,1,1);
            $cc1 = $cc1b+$cc1c;
        } else {
            $cc1 = $cc1a;
        }
        if ($cc3a >= 10) {
            $cc3b = substr($cc3a,0,1);
            $cc3c = substr($cc3a,1,1);
            $cc3 = $cc3b+$cc3c;
        } else {
            $cc3 = $cc3a;
        }
        if ($cc5a >= 10) {
            $cc5b = substr($cc5a,0,1);
            $cc5c = substr($cc5a,1,1);
            $cc5 = $cc5b+$cc5c;
        } else {
            $cc5 = $cc5a;
        }
        if ($cc7a >= 10) {
            $cc7b = substr($cc7a,0,1);
            $cc7c = substr($cc7a,1,1);
            $cc7 = $cc7b+$cc7c;
        } else {
            $cc7 = $cc7a;
        }
        if ($cc9a >= 10) {
            $cc9b = substr($cc9a,0,1);
            $cc9c = substr($cc9a,1,1);
            $cc9 = $cc9b+$cc9c;
        } else {
            $cc9 = $cc9a;
        }
        if ($cc11a >= 10) {
            $cc11b = substr($cc11a,0,1);
            $cc11c = substr($cc11a,1,1);
            $cc11 = $cc11b+$cc11c;
        } else {
            $cc11 = $cc11a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
        }

# For 16 digit cards
sub ver16 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);
        $cc13 = substr($cardnumber,13,1);
        $cc14 = substr($cardnumber,14,1);
        $cc15 = substr($cardnumber,15,1);

        $cc0a = $cc0 * 2;
        $cc2a = $cc2 * 2;
        $cc4a = $cc4 * 2;
        $cc6a = $cc6 * 2;
        $cc8a = $cc8 * 2;
        $cc10a = $cc10 * 2;
        $cc12a = $cc12 * 2;
        $cc14a = $cc14 * 2;

        if ($cc0a >= 10) {
            $cc0b = substr($cc0a,0,1);
            $cc0c = substr($cc0a,1,1);
            $cc0 = $cc0b+$cc0c;
        } else {
            $cc0 = $cc0a;
        }
        if ($cc2a >= 10) {
            $cc2b = substr($cc2a,0,1);
            $cc2c = substr($cc2a,1,1);
            $cc2 = $cc2b+$cc2c;
        } else {
            $cc2 = $cc2a;
        }
        if ($cc4a >= 10) {
            $cc4b = substr($cc4a,0,1);
            $cc4c = substr($cc4a,1,1);
            $cc4 = $cc4b+$cc4c;
        } else {
            $cc4 = $cc4a;
        }
        if ($cc6a >= 10) {
            $cc6b = substr($cc6a,0,1);
            $cc6c = substr($cc6a,1,1);
            $cc6 = $cc6b+$cc6c;
        } else {
            $cc6 = $cc6a;
        }
        if ($cc8a >= 10) {
            $cc8b = substr($cc8a,0,1);
            $cc8c = substr($cc8a,1,1);
            $cc8 = $cc8b+$cc8c;
        } else {
            $cc8 = $cc8a;
        }
        if ($cc10a >= 10) {
            $cc10b = substr($cc10a,0,1);
            $cc10c = substr($cc10a,1,1);
            $cc10 = $cc10b+$cc10c;
        } else {
            $cc10 = $cc10a;
        }
        if ($cc12a >= 10) {
            $cc12b = substr($cc12a,0,1);
            $cc12c = substr($cc12a,1,1);
            $cc12 = $cc12b+$cc12c;
        } else {
            $cc12 = $cc12a;
        }
        if ($cc14a >= 10) {
            $cc14b = substr($cc14a,0,1);
            $cc14c = substr($cc14a,1,1);
            $cc14 = $cc14b+$cc14c;
        } else {
            $cc14 = $cc14a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12+$cc13+$cc14+$cc15;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
    }


# For 15 digit (Amex) cards
sub ver15 {
        $cc0 = substr($cardnumber,0,1);
        $cc1 = substr($cardnumber,1,1);
        $cc2 = substr($cardnumber,2,1);
        $cc3 = substr($cardnumber,3,1);
        $cc4 = substr($cardnumber,4,1);
        $cc5 = substr($cardnumber,5,1);
        $cc6 = substr($cardnumber,6,1);
        $cc7 = substr($cardnumber,7,1);
        $cc8 = substr($cardnumber,8,1);
        $cc9 = substr($cardnumber,9,1);
        $cc10 = substr($cardnumber,10,1);
        $cc11 = substr($cardnumber,11,1);
        $cc12 = substr($cardnumber,12,1);
        $cc13 = substr($cardnumber,13,1);
        $cc14 = substr($cardnumber,14,1);

        $cc1a = $cc1 * 2;
        $cc3a = $cc3 * 2;
        $cc5a = $cc5 * 2;
        $cc7a = $cc7 * 2;
        $cc9a = $cc9 * 2;
        $cc11a = $cc11 * 2;
        $cc13a = $cc13 * 2;

        if ($cc1a >= 10) {
            $cc1b = substr($cc1a,0,1);
            $cc1c = substr($cc1a,1,1);
            $cc1 = $cc1b+$cc1c;
        } else {
            $cc1 = $cc1a;
        }
        if ($cc3a >= 10) {
            $cc3b = substr($cc3a,0,1);
            $cc3c = substr($cc3a,1,1);
            $cc3 = $cc3b+$cc3c;
        } else {
            $cc3 = $cc3a;
        }
        if ($cc5a >= 10) {
            $cc5b = substr($cc5a,0,1);
            $cc5c = substr($cc5a,1,1);
            $cc5 = $cc5b+$cc5c;
        } else {
            $cc5 = $cc5a;
        }
        if ($cc7a >= 10) {
            $cc7b = substr($cc7a,0,1);
            $cc7c = substr($cc7a,1,1);
            $cc7 = $cc7b+$cc7c;
        } else {
            $cc7 = $cc7a;
        }
        if ($cc9a >= 10) {
            $cc9b = substr($cc9a,0,1);
            $cc9c = substr($cc9a,1,1);
            $cc9 = $cc9b+$cc9c;
        } else {
            $cc9 = $cc9a;
        }
        if ($cc11a >= 10) {
            $cc11b = substr($cc11a,0,1);
            $cc11c = substr($cc11a,1,1);
            $cc11 = $cc11b+$cc11c;
        } else {
            $cc11 = $cc11a;
        }
        if ($cc13a >= 10) {
            $cc13b = substr($cc13a,0,1);
            $cc13c = substr($cc13a,1,1);
            $cc13 = $cc13b+$cc13c;
        } else {
            $cc13 = $cc13a;
        }

        $val = $cc0+$cc1+$cc2+$cc3+$cc4+$cc5+$cc6+$cc7+$cc8+$cc9+$cc10+$cc11+$cc12+$cc13+$cc14;
        if (substr($val,1,1) !=0 ) {
            &invalid_cc;
        }
    }


}

sub invalid_cc
 {
 print "The credit card number you have supplied is invalid.\n";
 &footer;
 exit;
 }

sub display_screen
{

{
print <<END
<CENTER>
<H2>Payment Verifier</H2>

<FORM METHOD=POST ACTION="$ENV{'SCRIPT_NAME'}">
<TABLE BORDER=0>
<TR><TD><B>Method:</B></TD> <TD><INPUT TYPE=RADIO NAME=method VALUE="credit"> Credit <INPUT TYPE=RADIO NAME=method VALUE="check"> Check</TD></TR>
<TR><TD><B>Card Type:</b></TD> <TD><FONT SIZE=-1><INPUT TYPE=radio NAME="cardtype" VALUE="Visa"> Visa <INPUT TYPE=radio NAME="cardtype" VALUE="MasterCard"> MasterCard <INPUT TYPE=radio NAME="cardtype" VALUE="amex"> Amex <INPUT TYPE=radio NAME="cardtype" VALUE="novus"> Discover</FONT></TD></TR>
<TR><TD><B>Card Number:</B></TD> <TD><INPUT TYPE=TEXT NAME=cardnumber></TD></TR>
<TR><TD><BR><BR></TD> <TD><BR><BR></TD></TR>

<TR><TD><B>Checking Account #:</B></TD> <TD><INPUT TYPE=TEXT NAME=account SIZE=16></TD></TR>
<TR><TD><B>Checking Routing #:</B></TD> <TD><INPUT TYPE=TEXT NAME=routing SIZE=9></TD></TR>
<TR><TD></TD> <TD><INPUT TYPE=SUBMIT NAME=submit VALUE="Verify"></TD></TR>
</TABLE>
</FORM>

</CENTER>
</BODY></HTML>
END
}

}

