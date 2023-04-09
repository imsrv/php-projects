print "HTTP/1.0 200 OK\n";
#
#
# CyberCart Pro Internet Commerce System, Version 3.042
# Copyright 1997, Richard Torzynski
# 2-12-98
# All rights reserved
# This is NOT a shareware script.
#
# support@cybercart.com
# sales@cybercart.com
# http://www.cybercart.com/
#
# License Agreement
# You should carefully read the following terms and conditions
# before using this software.  Unless you have a different license
# agreement signed by TMP Integrated Systems your use of this software
# indicates your acceptance of this license agreement and warranty.
#
# One copy of the CyberCart Pro Internet Commerce System may either
# be used by a single person or business, located on a single web server.
# Copies of this software may not be resold, leased, or distributed without
# the expressed written consent and approval of TMP Integrated 
# Systems.
#
# Disclaimer of Warranty
# THIS SOFTWARE AND ANY ACCOMPANYING FILES ARE SOLD "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY
# OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.  The user must
# assume the entire risk of using this software.  ANY LIABILITY OF
# THE SELLER WILL BE LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR
# REFUND OF PURCHASE PRICE.
# 
# 
# Define File Locations and Directories
# -------------------------------------------------------

# Merchant Setup File locations
$merchant_data = "c:\\merchant";

# sendmail location.  This may vary on systems. Try using unix "whereis smail"
# command at the unix prompt.
$mail_loc = "c:\\blat\\blat.exe";

# Mail server
$mail_server = "mail.name.com";

# Domain that script is running on
$domain = "www.name.com";

# Directory where shipping files are kept.  There should also be a subdirectory
# under this directory called Zones that contains the zone charts.
$shipping_dir = $merchant_data . "\\Shipping\\";

# location of creditcard checking subroutines
$ccmod = $merchant_data . "\\CreditCard.pl";
# require this set of routines
if (-s $ccmod) {
  require($ccmod);
}

# Onanalysis processing module - needed for realtime credit card 
# processing.  Must also be signed up through www.onanalysis.com.
$onanalysis_mod = $merchant_data . "\\onanalysis.pl";
if (-s $onanalysis_mod) {
  require($onanalysis_mod);
}
# onanalysis socklink program.  Needed only if using Onanalysis real-time 
# creditcard processing.
$socklink = "c:\\merchant\\socklink";

# location of shipping routines.  Pulled out to make the main script smaller
# in size.  These will be loaded when calculating shipping costs.
$ccship = $merchant_data . "\\ccship.pl";

%formname = ("Name","orname","Street","street","City","city","State","state",
"Zip","zip","Country","country","Phone","phone","Email","email");

%formnameb = ("Billing Name","ornameb","Billing Street","streetb","Billing City","cityb",
 "Billing State","stateb", "Billing Zip","zipb","Billing Country","countryb");

# --------------------------------------------------------------
#
# DO NOT EDIT BELOW HERE!
#
# --------------------------------------------------------------


# Decode the form
&decode2;



# if calculating shipping load ccship.pl
if ($post_query{'action'} eq "ship") {
  if (-s $ccship) {
    require("$ccship");
  } else {
    &error("Couldn't load shipping routines located at $ccship.");
  }
}


# Check to see if site has linked in
if ($ENV{'PATH_INFO'} =~ m/\:/ ) {
  &enter;
}

# Debug lines.  If you're having trouble installing the scripts,
# uncomment these lines and it'll print the environmental variables so
# you can check if your file and directory addressing is correct.
# &debug;

# Read merchant configuration file
&init_var;

# Assign ID
&assign_id;

# Set the default shipping country if not specified
if (!$shipping_base) {
  $shipping_base = "US";
}

# See if there is a page_name to pass on to the next form.  This will 
# be set to the $home_url variable if a page_name variable is not found.
# The $page_name is used in the $addtext variable below to provide
# a link back to the last catalog page.
&pagename;

# text printed after someone adds an item to their order
$addtext = qq[
<h2>Items Added</h2>
<UL>
<LI>The item(s) requested have been added to your order.
<LI>To review the items in your <I>Shopping Cart</I>, click on the View Cart
button below.</FONT>
<LI><a href=$page_name>Click here</a> to return to the last
catalog page you visited. You can also use the links at the bottom of the
page.</UL>
<P>
<center>
<table>
<tr><td>
<FORM METHOD=POST ACTION=$script_url>\n
<input type=hidden name=merchant value=$post_query{'merchant'}>
<INPUT TYPE=HIDDEN NAME="action" VALUE="order">
<INPUT TYPE=HIDDEN NAME="page_name" VALUE=$page_name>
<INPUT TYPE=SUBMIT VALUE="View Shopping Cart">
</FORM>
</td></tr>
</table></center>\n
</P>
];

# Print header unless an item is being added since a location: url
# is used to print the page ordered from again.
if ($post_query{'action'} ne "add" && $post_query{'action'} ne "send" && $post_query{'action'} ne "cc2") {
  &header;
}

# Set number of properties
$numprop = @properties;

# Set the path for taint check
$ENV{PATH} = "$merchant_data";


$order_file = "$order_dir" . "\\$session_id" . ".tmp";


$sec_file = "$invoice_dir" . "\\$session_id" . ".order";


# Exception for action to handle online and offline billing routines
if ($post_query{'action'} eq "billing") {
  if ($post_query{'processing'} eq "offline") {
        $action = "invoice";
  }
}

# if the script is not running on a secure server, make the secure script the same
# as the regular script.
if (!$secure || 
   ($post_query{'processing'} && $post_query{'processing'} ne "secure")) {
     $secure_url = $script_url;
     $secure = 0;
}  


# Goto appropriate subroutine
if ($post_query{'action'} eq "add") {
  &add;
} else {
  $action = $post_query{'action'};
  &$action;
}

exit;

# End Main Routine
#----------------------------------------------------#



sub add { 
# Add product to temporary order file

$orderflag = 0;
$numprop = @properties;

open(OUTPUT, ">>$order_file") || &error("Cant open $order_file in sub add!");
foreach $a (keys %post_query) {
  if ($a =~ m/quant/) {
    $quant = $post_query{$a};
    if ($quant>0) {
      ($code, $gar) = split(/_/,$a);

      $add_code = $code;

      # Check for min and max order amount
      $min_code = $code . "_min";
      if ($post_query{$min_code}) {
        if ($quant < $post_query{$min_code}) {
           $quant = $post_query{$min_code};
        }
      }
      $max_code = $code . "_max";
      if ($post_query{$max_code}) {
        if ($quant > $post_query{$max_code}) {
           $quant = $post_query{$max_code};
        }
      }
 
      if ($price_file eq "none") {
        $item_price = $code . "_price";
        $item_name = $code . "_name";

        if ($post_query{$item_price} !~ m/-\$/) {
          $add_name = "$post_query{$item_name}";
        } elsif ($post_query{$item_price} !~ m/-nt/) {
          ($opname,$post_query{$item_price})=split(/-/,$post_query{$item_price});
          $post_query{$item_price} =~ s/\$//;
          $add_name = "$post_query{$item_name}-$opname";
        }

      }

      # New code for minimum order
      if ($post_query{$min_code} && $post_query{$max_code}) {
        $add_quant = "$quant!$post_query{$min_code}to$post_query{$max_code}";
      } elsif ($post_query{$min_code} && !$post_query{$max_code}) {
        $add_quant = "$quant!$post_query{$min_code}";
      } elsif ($post_query{$max_code} && !$post_query{$min_code}) {
        $add_quant = "$quant!$post_query{$min_code}";
      } else {
        $add_quant = "$quant";
      }


      $item_price = $code . "_price";
      $curprice = $post_query{$item_price};

      # put item price into order file
      if ($price_file eq "none") {
               
	for ($i=1;$i<$numprop+1;$i++) {
          $item_prop = $code . "_prop" . $i;
          if ($post_query{$item_prop} =~ m/\+/) {
            ($post_query{$item_prop},$propadd) = split(/\+/,$post_query{$item_prop});
            $curprice = $curprice + $propadd;
          } elsif ($post_query{$item_prop} =~ m/\-/) {
            ($post_query{$item_prop},$propadd) = split(/\-/,$post_query{$item_prop});
            $curprice = $curprice - $propadd;
          }
        }

        
        # print (OUTPUT "$curprice:");
        $add_price = $curprice;
      }

      $item_hand = $code . "_handling";
      $add_hand = "$post_query{$item_hand}";

      $item_ship = $code . "_itemship";
      $add_ship = "$post_query{$item_ship}";

      $item_weight = $code . "_weight";
      $add_weight = "$post_query{$weight_ship}";
      


      for ($i=1;$i < 4;$i++) {
        $item_prop = $code . "_prop" . $i;
      }
 
      $item_prop1 = $code . "_prop1";
      $item_prop2 = $code . "_prop2";
      $item_prop3 = $cope . "_prop3";

      $add_prop1 = $post_query{$item_prop1};
      $add_prop2 = $post_query{$item_prop2};
      $add_prop3 = $post_query{$item_prop3};     

      $item_dlfile = $code . "_dlfile";
      $add_dlfile = $post_query{$item_dlfile};

      $add_string = join(':',$add_name,$add_code,$quant,$add_price,$add_hand,$add_ship,$add_weight,$add_prop1,$add_prop2,$add_prop3,$add_dlfile);

      print (OUTPUT "$add_string\n");
      $orderflag = 1;
    }
  }
}
close(OUTPUT);

if ($orderflag) {
  if ($action eq "addplus") {
    return;
  } else {
    &header;
    if ($showorder) {
      print "<center><h1>Current Order</h1></center>";
      print "<p>Your item(s) have been added to your order. Here is your ";
      print "current order:<p>";
      &show_order;
      &show_order2;
    } else {
      print "$addtext";
    }
    &print_links;
    &footer;
  }
} else {
  &header;
  print "<h1>No Item to Add!</h1>";
  print "To order an item, change the value in the order box to something ";
  print "greater than zero.<p>";
  &print_links;
  &footer;
}
}
# End sub add
#----------------------------------------------------#

sub addplus {
# Add an item, then go to checkout
&add;
$action = "place";
&place;
}
# End sub addplus
#----------------------------------------------------#


sub assign_id {
# This routine checks for and assigns a session_id.  If the browser is
# cookie capable then it uses the ip number and the process id to create
# a psuedo random number.  

%cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});

# Check to see which browser is using
$browser = $ENV{'HTTP_USER_AGENT'};
# &debug;

if ($browser =~ /MSIE/i || $browser =~/^Mozilla\/*/i && 
  ($browser !~ /lynx/i && $browser !~ /^Mozilla\/1.*/i)) { 
  if ($action eq "place2" && $secure_domain && $pq{'processing'} eq "secure") {
    # clause for when secure domain is different than unsecure.
    # Session id is passed as a hidden variable 
    $session_id = $post_query{'session_id'};
    print "Set-Cookie: ID=$session_id; path=/\n";
  } elsif ($cookies{'ID'} && $cookies{'ID'} ne "1") {
    # cookie exists and is not being replaced at end of order
    $get_id = $cookies{'ID'};
    # Taint check
    $get_id =~ m/([0-9]*)/;
    $session_id = $1;
  } else {
    # This is statement determining session and order id.  This can be
    # changed to a more random number in any number of ways.
    # ID + random number:
    # srand();
    # $rnum = int(rand(20000));
    # $session_id = $ENV('REMOTE_ADDR') . $rnum;
    # Pseudo random number based on system variables:
    $session_id = $$ . $ENV{'REMOTE_ADDR'};
    $session_id =~ s/\.//g;
    $session_id = substr($session_id,0,8);
    # Or use ip number:
    #$session_id = $ENV{'REMOTE_ADDR'};
    print "Set-Cookie: ID=$session_id; path=/\n";
 
    # run file cleanup routine 
    &cleanup;
  }
} else {
  # Routine for lynx and earlier versions of netscape
  $session_id = $ENV{'REMOTE_ADDR'};
  $session_id =~ s/\.//g;
  &cleanup;
}

}
# End sub assign
#----------------------------------------------------#


sub billing {
# Routine to have customer choose billing method.

# New routine added 5-4-97 to check that shipping method is choosen
if ($shipping_cost ne "none" && !$post_query{'ship_cost'}) {
  print qq[
  <center>
  <table bgcolor=$Table_Body_Color cellpadding=10 border=1><tr><td>
  <h1>Please Choose Shipping Method</h1>
  In order to process your order, you must indicate a shipping
  method.
  </td>
  </tr>
  </table>
  </center>
  <p>
  ];
  &ship;
  exit;
}


print "<h1><center>Billing Method</h1></center>";
&show_order;
print "</form>";
print "<form method=post action=$secure_url>\n";
print "<input type=hidden name=merchant value=$post_query{'merchant'}>\n";
foreach $key (keys %post_query) {
  if ($key ne "action") {
    print "<input type=hidden name=\"$key\" value=\"$post_query{$key}\">\n";
  }
}   
print "<center>\n";
print "<table border=1 cellspacing=0 cellpadding=10 width=\"$Table_width\" bgcolor=\"$Table_Body_Color\">";
print "<tr valign=top><td colspan=2 align=left>\n";
print "<pre><u><b>Billing Information:</b></u><br></pre>";
print "<b>Payment Method:</b><p>\n";
if ($check) {
  print "<input type=radio name=cardtype value=Check><b> Check</b><br>\n";
}
foreach $a (@credit) {
  print "<input type=\"radio\" name=\"cardtype\" value=\"$a\"><b> $a</b><br>\n"; 
}
if ($credit_note) {
  print "<br><b>Note: </b>$credit_note<br>\n";
}
 
# print warning if not on a secure server
if (!$secure && $post_query{'processing'} ne "fax" && $creditcards ne "none") {
  print "<br><b>If you don't feel \n"; 
  print "comfortable sending your credit card number over email, you may call\n";
  print "us at $phone.  You creditcard number will be split up and sent \n";
  print "in two separate email messages.  Enter the first half below, and you ";
  print "will be asked for the second half later.</b><p>";
  print "<pre>";
  print "First Half of Credit Card \#:<input size=9 maxlength=8 name=\"CCN\">\n\n";
  print "               Name on Card:<input size=30 maxlength=256 name=\"card_name\">\n\n";
  print qq[           Expiration Month:<SELECT NAME="exp_month"><OPTION VALUE="">---
			 <OPTION VALUE="01">Jan
			 <OPTION VALUE="02">Feb
			 <OPTION VALUE="03">Mar
			 <OPTION VALUE="04">Apr
			 <OPTION VALUE="05">May
			 <OPTION VALUE="06">Jun
			 <OPTION VALUE="07">Jul
			 <OPTION VALUE="08">Aug
			 <OPTION VALUE="09">Sep
			 <OPTION VALUE="10">Oct
			 <OPTION VALUE="11">Nov
			 <OPTION VALUE="12">Dec
									
                   
                         </SELECT>

   ];
  print qq[                    Year:<SELECT NAME="exp_year">
			 <OPTION VALUE="">---
			 <OPTION VALUE="1998">1998
			 <OPTION VALUE="1999">1999
			 <OPTION VALUE="2000">2000
			 <OPTION VALUE="2001">2001
			 <OPTION VALUE="2002">2002
			 <OPTION VALUE="2003">2003
		         </SELECT>
  ];

} elsif ($secure && $creditcards ne "none") {
  print "<pre>";
  print "         Credit Card Number:<input size=20 maxlength=20 name=\"CCN\">\n\n";
  print "               Name on Card:<input size=30 maxlength=256 name=\"card_name\">\n\n";
  print qq[           Expiration Month:<SELECT NAME="exp_month"><OPTION VALUE="">---
                         <OPTION VALUE="01">Jan
                         <OPTION VALUE="02">Feb
                         <OPTION VALUE="03">Mar
                         <OPTION VALUE="04">Apr
                         <OPTION VALUE="05">May
                         <OPTION VALUE="06">Jun
                         <OPTION VALUE="07">Jul
                         <OPTION VALUE="08">Aug
                         <OPTION VALUE="09">Sep
                         <OPTION VALUE="10">Oct
                         <OPTION VALUE="11">Nov
                         <OPTION VALUE="12">Dec


                         </SELECT>

   ];
  print qq[                    Year:<SELECT NAME="exp_year">
                         <OPTION VALUE="">---
                         <OPTION VALUE="1998">1998
                         <OPTION VALUE="1999">1999
                         <OPTION VALUE="2000">2000
                         <OPTION VALUE="2001">2001
                         <OPTION VALUE="2002">2002
                         <OPTION VALUE="2003">2003
                         </SELECT>
  ];
}
print "</b></pre><p>";
printf "<INPUT TYPE=HIDDEN NAME=\"Total\" VALUE=\"%6.2f\">\n",  $order_total;
printf "<INPUT TYPE=HIDDEN NAME=\"Shipping\" VALUE=\"%5.2f\">\n",  $shipping;
printf "<INPUT TYPE=HIDDEN NAME=\"taxes\" VALUE=\"%5.2f\">\n", $taxes;
printf "<INPUT TYPE=HIDDEN NAME=\"discount\" VALUE=$post_query{'discount'}>\n";
printf "<INPUT TYPE=HIDDEN NAME=\"Grand Total\" VALUE=\"%6.2f\">\n", $grandtotal; 
print "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"invoice\">";
print "<center>";
print "To see your final order form, press this button:<p>\n";
print "<INPUT TYPE=SUBMIT VALUE=\"Continue - Final Order Form\">\n";
print "</center>";
print "</FORM>\n";
print "</td></td></table></center><p>\n";
&print_links;
&footer;
exit;
} 
#----------------------------------------------------#

sub check_form {
# routine to check for missing info in forms

$missinginfo="no";
foreach $a (@required) {
  if ($a eq "Zip") {
    if ($post_query{'country'} eq "US" || $post_query{'country'} eq "Canada") {
      if (!$post_query{'zip'}) {
        $missing{$a}=1;
        $missinginfo="yes";
      }
    }
  } else {
    unless ($post_query{$formname{$a}}) {
      $missing{$a}=1;
      $missinginfo="yes";
    }
  }
}

if (!$post_query{'billing'}) {
  foreach $b (@requiredb) {
    unless ($post_query{$formnameb{$b}}) {
	  $missing{$b}=1;
	  $missinginfo="yes";
	}
  }
}

if ($post_query{'email'} !~ /([\w-_.]+\@[\w-_.]+)/) {
  $badmail=1;
  $missinginfo="yes";
}

if ($missinginfo =~ m/yes/) { 
  print "<h1>Missing Information</h1>";
  print "<table width=580>";
  print "Before we can process your order, ";
  print "we need you to provide all the information in the previous form.";
  print "  Please provide the following pieces of necessary information:<p>";
  print "<form method=POST action=$secure_url>\n";
  print "<input type=hidden name=merchant value=$post_query{'merchant'}>\n";
  foreach $hidval (keys %post_query) {
    if ($post_query{$hidval}) {
      print "<input type=hidden name=\"$hidval\" value=\"$post_query{$hidval}\">\n";
    }
  }

  foreach $key (keys %missing) {
    if ($key =~ m/cardtype/) {
      print "<tr valign=top><td align=right><b>Payment<br>Method</b></td><td align=left>\n";
      foreach $a (@credit) {
        print "<input type=\"radio\" name=\"cardtype\" value=\"$a\">$a<br>";
      }
      print "</td></tr>\n";
    } elsif ($key ne "Email") {
    print "<tr valign=middle><td align=right><b>$key<br></b></td>\n";
    print "<td align=left><input type=text name=\"$formname{$key}\" size=40></td></tr>\n";
    }
  }
  # Check for a valid email address
  if ($badmail) {
    print "<tr valign=top><td align=right><b>Email</b><br></td>\n";
    print "<td valign=top>Please provide a valid email address:<br>";
    print "<input type=text name=email size=40></td></tr>";
  }



  print "</table>\n";
  print "<p><center>\n";
  print "<table>";
  print "<tr valing=top><td>";
  if ($post_query{'delivery'} ne "default") {
    print "<input type=hidden name=\"del_cost\" value=$delivery_method{$post_query{'delivery'}}>\n";
  }

  print "<input type=hidden name=\"taxes\" value=\"$taxes\">\n";  
  print "<input type=hidden name=\"action\" value=\"ship\">\n";
  print "<input type=SUBMIT value=\"Please Reprocess Form!\"></form>\n";
  print "</td><td>";
  print "<FORM METHOD=POST ACTION=$script_url>\n";
  print "<input type=hidden name=merchant value=>\n";
  print "<INPUT TYPE=HIDDEN NAME=\"action\" VALUE=\"clear\">";
  print "<INPUT TYPE=SUBMIT VALUE=\"Clear Order\">\n";
  print "</FORM>\n";
  print "</td></tr>";
  print "</table></center>\n";
  &print_links;
  &footer;
  exit(0);
  }
}
# End sub check_form
#----------------------------------------------------#

sub checkstatus {
# Print out the order status.  To use this feature, you have to add 
# some hidden form variables.

($status, $ordate) = &get_status;

print qq(
<table cellspacing=0 cellpadding=10 bgcolor=$Table_Header_Color Border=1>
<tr><td align=center colspan=4>
<h2>Status for Order \#$order_number</h2>
</td></tr>
<tr align=left>
<th>Name</th><th>Order Number</th><th>Date Received</th><th>Order Status</th>
</tr><tr align=left bgcolor=$Table_Body_Color>
<td>$customer</td><td>$order_number</td><td align=center>$ordate</td>
<td>$status</td></td></tr>
</table>);
&print_links;
&footer;
}
#-----------------------------------------------------------------------------


sub cleanup {
#Open merchant temp directory, delete files older than 2 days

opendir(ORD, "$order_dir") || &error("cant open $order_dir in sub cleanup.");
while ($name = readdir(ORD)) {
  if ($name =~ m/tmp/) {
    $name = $order_dir . "\\$name";
    if (-A $name > 2) {
      unlink($name);
    }
  } #close if
}  #close while
close(ORD);
}
# End Cleanup
#---------------------------------------------------------------

sub clear {
# Clear order
if (-s $order_file) {
  unlink($order_file) || &error("Cant unlink $order_file in sub clear!");
  print "<h1>Order Cleared</h1>";
  print "Your order has been cleared.<p>";
} else {
  $script_order = $home_page;
  print "<h1>Clear Order Failed</h1>\n";
  print "No order to clear!<p>\n";
}
&return_page;
&print_links;
&footer;
exit;
}
# End sub clear
#----------------------------------------------------#

sub credit_card_check {

# Check to see if creditcard number valid.  0000 is for debugging purposes.
if ($post_query{'CCN'} ne "0000" && -s $ccmod) {
  $creditcheck = &validate($post_query{'CCN'});
  if ($creditcheck == 0 || $cardname eq "Unknown" || $post_query{'CCN'} =~ m/[a-zA-Z]/i) {
    print qq[
<h1>Invalid Card Number</h1>
The $post_query{'cardtype'} card number you provided, $post_query{'CCN'},
does not appear to be a valid card number.  Please check the number
provided.  If there is an error, please contact 
<a href="mailto:$recipient">$recipient</a>.
 ];
&print_links;
&footer;
exit;
  }

}
}
#-----------------------------------------------------#

sub creditcard2_form {
# Get second part of credit card if not secure

print "<h3>Second Half of CC Number</h3>\n";
print "<table border=1 cellspacing=0 cellpadding=1 width=\"$Table_width\" bgcolor=\"$Table_Body_Color\">"; 
print "<td>";
print "To make sending your CC number safer, the number ";
print "is sent via to separate network packets, making interception ";
print "more difficult.</p>\n";
print "<form method=post action=$script_url>\n";
print "<input type=hidden name=merchant value=$post_query{'merchant'}>\n";
print "<input type=hidden name=email value=$post_query{'email'}>\n";
print "<input type=hidden name=zip value=$post_query{'zip'}>\n";
print "<input type=hidden name=exp_month value=$post_query{'exp_month'}>\n";
print "<input type=hidden name=exp_year value=$post_query{'exp_year'}>\n";
print "<input type=hidden name=\"Grand Total\" value=$post_query{'Grand Total'}>\n";
if (@dlfiles > 0) {
  print "<input type=hidden name=dlfiles value=yes>\n";
}
print "<b>Second Half of Number:</b>";
print "<input type=text name=\"CCN2\" size=8 maxlength=8>\n";
print "<input type=hidden name=\"action\" value=\"cc2\"><p>\n";
print "<center>";
print "<input type=submit value=\"Send 2nd Half\">\n";
print "</center>\n";
print "</form>\n";
print "</td></table><p>";
}
# sub End creditcard2_form
#----------------------------------------------------#

sub cc2 {
# Mail second half of credit card
if (!$post_query{'CCN2'} || $post_query{'CCN2'} eq "") {
  &header;
print qq[
<h3>Missing Second Half of Credit Card Info</h3>
In order to complete processing of your order, you must provide the
second half of your creditcard number.  Splitting up your creditcard
information greatly reduces the chance of interception.  Please use the
back button, provide the second half of the number, and resubmit the form.
];
  &print_links;
  &footer;
  exit;
}

$order_num = $session_id;
$order_num =~ s/\.//g;

$sec_file = "$invoice_dir" . "\\$order_num" . ".order";
$order_file = $order_dir . "\\$order_num" . ".tmp";

open(ORDER, "<$sec_file") || &error("Can't open sec_file $sec_file");
while (<ORDER>) {
  if ($_ =~ m/1st Half of Number/i) {
    ($gar,$fhnum) = split(/:/,$_);
    $fhnum =~ s/ //ig;
    last;
  }
}
close(ORDER);

$fullnum = $fhnum . "$post_query{'CCN2'}";

# Check to see if creditcard number valid.  0000 is for debugging purposes.
if ($fullnum =~ m/[a-zA-Z]/) {
  &header;
  print qq[<html><body>
<h3>Invalid Card Number</h3>
The $post_query{'cardtype'} card number you provided,
does not appear to be a valid card number. Credit card numbers cannot contain
letters.  Please check the number provided.  If there is an error, please contact
<a href="mailto:$recipient">$recipient</a>.
 ];
    &print_links;
    &footer;
    exit;
}

if ($fullnum ne "0000" && -s $ccmod) {
  $cardname = &cardtype($fullnum);
  $creditcheck = &validate($fullnum);
  if ($creditcheck == 0 || $cardname eq "Unknown") {
    &header;
    print qq[<html><body>
<h3>Invalid Card Number</h3>
The $post_query{'cardtype'} card number you provided,
does not appear to be a valid card number.  Please check the number
provided.  If there is an error, please contact
<a href="mailto:$recipient">$recipient</a>.
 ];
    &print_links;
    &footer;
    exit;
  } 
}


if ($onanalysis) {
  $post_query{'CCN'}=$fullnum;
  &run_transaction;
  &print_results;
} else {  
  $tempsec = $order_dir . "\\$order_num" . "cc.tmp";
  open(MAIL, ">$tempsec") || &error("Cant open $mail_loc in sub cc2.");
  print MAIL "Second half of CC: $post_query{'CCN2'}\n";
  close(MAIL);
  $subject = "Order \#$order_num Part 2";
  $mailcc ="$mail_loc $tempsec \-t $recipient \-s \"$subject\" -server $mail_server";
  system("$mailcc");
  unlink($tempsec);
}

if ($post_query{'dlfiles'}) {
  open(DL, "<$order_file") || &error("Couldn't open order_file $order_file");
  while (<DL>) {
    chop;
    ($name,$current_code,$amount,$price,$hand,$item_ship,
     $wt,$prop[1],$prop[2],$prop[3],$dl_file)=split(/:/);    
    if ($dl_file) {
      push(@dlfiles,$dl_file);
    }
  }
  close(DL);
  if (!$delorder) {
    unlink($order_file);
  }
  &download(@dlfiles);
} else {
  if (!$delorder) {
    unlink($order_file);
  }
  &print_thanks;
}

&footer;
}
# End sub cc2
#----------------------------------------------------#

sub debug {
# Debug routine used in development
%cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});

if (!$header) {
  # print header if one hasn't been printed
  &header;
}
print "action = $action<BR>\n";
print "shipping = $shipping_cost<br>\n";
print "session_id = $session_id<br>\n";
print "Variables passed through form:<br>";
foreach $key (keys %post_query) {
  print "$key - $post_query{$key}<br>";
}
print "<br>\n";
foreach $cook (keys %cookies) {
  print "$cook = $cookies{$cook}<br>";
}

print "cookies_id = $cookies{'ID'}<br>";

print "merchant = $merchant_data<br>\n";
print "script url = $script_url<br>\n";
print "order directory = $order_dir<br>\n";
print "pathinfo = $ENV{'PATH_INFO'}<br>\n";
print "client = $client<br>\n";
print "clientemail = $clientemail<br>";
print "order_file = $order_file<br>";
print "ordertotal = $ordertotal<br>";
exit;
}
# End sub debug
#----------------------------------------------------#


# New, more secure decoding routine from Matt's Script Archive Programs
sub decode2 {
if ($ENV{'REQUEST_METHOD'} eq 'GET') {
  @pairs = split(/&/, $ENV{'QUERY_STRING'});
} elsif ($ENV{'REQUEST_METHOD'} eq 'POST') {
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  @pairs = split(/&/, $buffer);
}
# print "Content-type: text/html\n\n";

foreach $pair (@pairs) {
  ($name, $value) = split(/=/, $pair);
  $name =~ tr/+/ /;
  $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

  $value =~ tr/+/ /;
  $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;

  # Take care of server side includes
  $value =~ s/<!--(.|\n)*-->//g;

  
  $post_query{$name} = $value;
  
}

}
# End sub decode2
#----------------------------------------------------#

sub discount {
# Calculates an order discount.
if ($discount eq "fixed_table") {
  # discount is fixed abount for a range
  foreach $range (keys %discount_table) {
    ($low,$high) = split(/-/,$range);
    if ($grandtotal >= $low && $grandtotal < $high) {
      $dis = $discount_table{$range};
    }
  }
} elsif ($discount eq "percent_table") {
  # discount is a given percentage for ranges
  foreach $range (keys %discount_table) {
    ($low,$high) = split(/-/,$range);
    if ($grandtotal >= $low && $grandtotal < $high) {
      $dis = $discount_table{$range} * $grandtotal;
    }
  }
} elsif ($discount eq "percent") {
  $dis = $discount_percent * $grandtotal;
}

# make discount a negative number
$dis *= -1;
}
#-----------------------------------------------------------------------------

sub enter {
# Routine to log where link is coming from for link connection type deal.

# &debug;
$ENV{'PATH_INFO'} =~ s/^([\w\:\\\_]*cybercart\.pl)//;
$ENV{'PATH_INFO'} =~ s/^\///;
($merid,$client) = split(/\:/,$ENV{'PATH_INFO'});

$post_query{'merchant'} = $merid;

&init_var;

$mid = $client;
print "Set-Cookie: MID=$mid \r\n";
print "Content-type: text/html\n\n";
print qq[
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=$home_page">];
print "<br>";
exit;
}



sub error {
# Print errors to web page instead of stdout
local($error_message) = @_;
# Print message indicating that there is an error
if (!$header) {
  # print header if one hasn't been printed
  &header;
}
print "<h1>CyberCart Error</h1>\n";
print "Please contact the webmaster of this site and let them know of ";
print "that the following error occurred:<p>$error_message<p>\n";
&return_page;

if ($mail_error) {
  ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
  $mon += 1;
  $Date = $mon . "-" . $mday . "-" . $year;

  $mail_err = $log_dir . "\\$session_id" . ".err";

  open(MAILERR, ">$mail_err");
  print MAILERR "To: $recipient\n";
  print MAILERR "From: $recipient\n";
  print MAILERR "Subject: CyberCart Error\n\n";
  print MAILERR "CyberCart Error: $error_message\n\n";
  print MAILERR "Script: $0\n";
  print MAILERR "URL: $ENV{'HTTP_REFERER'}\n";
  print MAILERR "Server: $ENV{'SERVER_SOFTWARE'}\n";
  print MAILERR "Date: $Date\n";
  print MAILERR "Browser: $ENV{'HTTP_USER_AGENT'}\n";
  print MAILERR "IP: $ENV{'REMOTE_ADDR'}\n";
  print MAILERR "Session_id: $session_id\n";
  close(MAILERR);
  $mailerr="$mail_loc $mail_err \-t $recipient \-s CyberCart -server $mail_server";
  system("$mailerr");
  unlink($mailerr);
}

exit;
}
# End sub error
#----------------------------------------------------#

sub footer {
# Print footer at bottom of script generated pages
print "$footer";
}
# End sub footer
#----------------------------------------------------#


sub get_status {
# Must have java script in place to use this feature.  Allows customers
# to check on the status of their order.

$order_number = $post_query{'ordernum'};
$customer = $post_query{'customer'};

open(STATUS, "$status_file");
while (<STATUS>) {
  if ($_ =~ m/$order_number/i && $_ =~ m/$customer/i) {
    ($ordern,$name,$date_received,$order_status) = split(/::/);
    $of = 1;
    last;
  }
}
if (!$of) {
  $order_status = "Order Not found";
  $date_received = " ";
}
$of = 0;
return ($order_status,$date_received);
}
#----------------------------------------------------------------------------

sub header {
# Print standard header and title
$header = 1;

# Flush the buffer
local($oldbar) = $|;
$cfh = select(STDOUT);
$| = 1;

# print the header
print "Content-type: text/html\n\n";

# turn buffer flushing off
$| = $oldbar;
select($cfh);

# Refresh if $showorder is not set
if ($action eq "add" && $redirect) {
  &header;
  print qq[<META HTTP-EQUIV="Refresh" CONTENT="$redirect;URL=$page_name">];
}

print "<HTML><HEAD><TITLE>$company</TITLE></HEAD>\n";
# Set the body attributes

$body = "<BODY ";
if ($bodyback ne "") {
  $body .= "background = \"$bodyback\" ";
}
if ($bodycolor ne "") {
  $body .= "bgcolor=\"$bodycolor\" ";
} else {
  $body .= "bgcolor=\"\#FFFFFF\" ";
}
if ($bodytext ne "") {
  $body .= "text=\"$bodytext\" ";
}
if ($bodylink ne "") {
  $body .= "link=\"$bodylink\" ";
}
if ($bodyvlink ne "") {
  $body .= "vlink=\"$bodyvlink\" ";
}
if ($bodyalink ne "") {
  $body .= "alink=\"$bodyalink\" ";
}
$body .= ">";
print "$body\n";


print "<a name=\"top\"></a>";
print "<center><table><tr valign=top align=center>";
if ($titlepict) {
  if ($post_query{'processing'} eq "secure") {
    if ($titlepict =~ m/https:/) {
       print "<td valign=top><img src=\"$titlepict\"></td>";
    } 
  } else {
    print "<td valign=top><img src=\"$titlepict\"></td>";
  }
  print "<td><font size=+1>$company</font><br>";
  print "$address<br>$phone<br>";
  if ($fax) {
    print "$fax<br>";
  }
  print "$recipient<br>";
  if ($addition_header) {
    print "$additional_header";
  }
  print "</td></tr></table></center>"
} else {
  print qq(
  <td>
  <font size=+1>$company</font><br>
  $address<br>
  $phone<br>);
  if ($fax) {
    print "$fax<br>\n";
  }
  print "$recipient<br>";
  if ($additional_header) {
    print "$additional_header";
  }
  print "</td></tr></table></center>";
}

}
# End sub header
#----------------------------------------------------#

sub init_var {
# Read the merchant file.  This should be in the root directory
$merchant_data = $merchant_data . "\\$post_query{'merchant'}\.pl";

if (-s $merchant_data) {
  require("$merchant_data");
} else {
  &init_error;
}
}

# End sub init_var
#----------------------------------------------------#



sub init_error {

# Error routine to make sure merchant files are loaded
if (!$header) {
  &header;
}

print "<h1>CyberCart Installation Error</h1>\n";

if (!$post_query{'merchant'}) {
  print qq( 
  There is no hidden variable for the merchant in the form submitted.  
  Each form must have the following code to point to the correct 
  merchant file:\<br>\n
  &lt;input type=hidden name=merchant value=merchant_name&gt;<br>
  where merchant_name is the name of the merchant data file.  Make
  sure this is after the &lt;form ...&gt; tag.<br>\n);
} else {
  print qq(
  The script cannot find the merchant data file called 
  $post_query{'merchant'} with the path being $merchant_data.  
  Make sure this file exists and is in the correct directory.<br>\n);
}
exit(0);
}
#------------------------------------------------------------------------


sub invoice {

# reformat expiration date
$post_query{'expdate'}= $post_query{'exp_month'} . "/$post_query{'exp_year'}";

# Check creditcard
if (($post_query{'cardtype'} =~ m/american express/i || 
     $post_query{'cardtype'} =~ m/visa/i ||
     $post_query{'cardtype'} =~ m/mastercard/i ||
     $post_query{'cardtype'} =~ m/diner/i ||
     $post_query{'cardtype'} =~ m/discover/i ) && -s $ccmod && $secure) {

     &credit_card_check;
}    

if (!$post_query{'cardtype'}) {

print qq[
<center>
<table bgcolor=$Table_Body_Color cellpadding=10 border=1><tr><td>
<h1>No Payment Method Indicated</h1>
In order to process, you must indicate your payment method.
</td>
</tr>
</table>
</center>
<p>
];
&billing;
}  
  
if ( $post_query{'processing'} ne "fax" &&
	($post_query{'cardtype'} =~ m/american express/i ||
     $post_query{'cardtype'} =~ m/visa/i ||
     $post_query{'cardtype'} =~ m/mastercard/i ||
     $post_query{'cardtype'} =~ m/diner/i ||
     $post_query{'cardtype'} =~ m/discover/i ) 
     &&
     ($post_query{'expdate'} eq "" || 
      $post_query{'CCN'} eq "" ||
      $post_query{'card_name'} eq "")) {

print qq[
<center>
<table bgcolor=$Table_Body_Color cellpadding=10 border=1><tr><td>
<h1>Insufficient Credit Card Information</h1>
In order to process your order using a credit card, you must
provide the Card Name, Card Number, Expiration Data, and the name 
on the card.
</td>
</tr>
</table>
</center>
<p>
];
&billing;
}

if ($post_query{'cardtype'} eq "onlinecheck") {
  &online_check_init;
  &online_check_info;
}


# subroutine to print an off-line invoice that the customer could print out and fax
print "<p>";
if ($post_query{'billing'} ne "1" && !$no_billing_address) { 
  print qq( 
  <center> 
  <table border=1 width=$Table_width cellspacing=0 cellpadding=10 bgcolor=$Table_Body_Color> 
  <tr> 
  <td><b>Bill To:</b><br>
  $post_query{'ornameb'}<br> 
  $post_query{'streetb'}<br> 
  ); 
  if ($post_query{'street2b'}) { 
    print "$post_query{'street2b'}<br>";
  }
  print qq( 
  $post_query{'cityb'},$post_query{'stateb'},$post_query{'zipb'}</br>
  $post_query{'phoneb'}<br>
  $post_query{'emailb'}<br>
  </td>
  <td><b>Ship To:</b><br>
  $post_query{'orname'}<br>
  $post_query{'street'}<br>
  );
  if ($post_query{'street2'}) {
    print "$post_query{'street2'}<br>";
  }
  print qq(
  $post_query{'city'},$post_query{'state'},$post_query{'zip'}</br>
  $post_query{'phone'}<br>
  $post_query{'email'}<br>
  </tr>
  </table> 
  <p> ); 
} else {
  print qq( 
  <center> 
  <table width=$Table_width border=1 cellpadding=10 bgcolor=$Table_Body_Color> 
  <tr><td> <b>Bill and Ship To:</b><br>
  $post_query{'orname'}<br> $post_query{'street'}<br> ); 
  if ($post_query{'street2'}) {
    print "$post_query{'street2'}<br>";
  }
  print qq(
  $post_query{'city'},$post_query{'state'},$post_query{'zip'}<br>
  $post_query{'phone'}<br>
  $post_query{'email'}
  </td></tr></table></center><p>
  );
}

&show_order;

if ($post_query{'processing'} eq "fax") {
  print qq(
  <center>
  <table width=$Table_width>
  <tr>
  <td>
  <pre>
  __ Check here for payment by check. 
     Note: We will send your order after 
     receiving your check.

  Credit Card Information:

  Card _________________________________

  Number________________________________

  Exp. Date ____________________________

  Name on Card _________________________

  Signature ____________________________
  </pre>
  </td>
  <td valign=top>
  <b>
  NOTE: Use your browser to print a copy of this order form, fill out the 
  Credit Card Information, and then either mail or fax it to us.
  </b>
  </td>
  </tr>
  </table>
  <p>
  );
  &return_page;
  print "</center>";
  &print_links;
  &footer;
  exit;

} elsif ($post_query{'CCN'}) {
  # Electronic billing with Credit Card
  print qq(
  <center>
  <table width=$Table_width cellpadding=10 border=1 bgcolor=$Table_Body_Color>
  <tr>
  <td>
  <font size=+1>Credit Card Information:</font><br>
  <b>Name:</b> $post_query{'cardtype'}<br>
  <b>Number:</b> $post_query{'CCN'}<br>
  <b>Exp. Date:</b> $post_query{'expdate'}<br>
  <b>Name on Card:</b> $post_query{'card_name'}<br>
  </td>
  <td valign=top>
  <b>NOTE: Use your browser to print out a copy of this order form for your
  records.  Then SUBMIT the order for electronic billing.</b>
  </td>
  </tr>
  </table>
  </center>
  );

} elsif ($post_query{'cardtype'} eq "Check") {
  # Electrontic billing with check
  print qq(
  <center>
  <table width=$Table_width cellspacing=0 cellpadding=10 border=1 bgcolor=$Table_Body_Color>
  <tr>
  <td>
  Payment by check.  <b>NOTE: Your order will be shipped when your check is 
  received.
  );
  if ($checks) {
    print "  Please make your check out to $checks.";
  }
  print qq(
  </b>
  <td valign=top>
  <b>NOTE: Use your broswer to print out a copy of this order form for your 
  records.  Then SUBMIT the order for electronic billing.</b>
  </td>
  </tr>
  </table>
  </center>
  );
}

print "</form>";

if ($post_query{'processing'} ne "offline") {
  if ($secure && $post_query{'processing'} eq "secure") {
    print "<form method=post action=$secure_url>\n";
#   print "<form method=post action=$onanalysis>\n";
  } else {	
    print "<form method=post action=$script_url>\n";
  }
  print "<form method=post action=$script_url>\n";
  print "<input type=hidden name=merchant value=$post_query{'merchant'}>\n";
  foreach $key (keys %post_query) {
    if ($key ne "action") {
      print "<input type=hidden name=\"$key\" value=\"$post_query{$key}\">\n";
    } 
  }
  print qq(
  <input type=hidden name=action value=send>\n
  <p>
  <center><input type=submit value="Send order now!"></center>   
  </form>
  <p>
  );
}

#&footer;

}
#----------------------------------------------------------------------------


sub load_prices {
# Routine used if prices stored in external data file
open(LOOKUP, "$product_data") || print "cant open $product_data\n";
while(<LOOKUP>) {
   chop;
   ($tcode, $tname, $tprice )=split(/:/, $_);
   $iprice{$tcode} = $tprice;
   $iname{$tcode} = $tname;
}
close(LOOKUP);
}
# End sub load_prices
#-----------------------------------------------------#





sub order {
# Show current order
if (-s $order_file) {
  print "<CENTER><h1>View Current Order</h1></CENTER>\n";
  &show_order; 
  &show_order2; 
} else {
  print "<h1>Error in Trying to Display Order</h1>";
  print "You haven't ordered anything yet!\n";
  # print "Can't open $order_file";
  &return_page;
  &footer;
  exit;
}
}
#----------------------------------------------------------------------------------------

sub pagename {
# Determine the full url just in case script is running through cgiwrap
if ($post_query{'page_name'}) {
  if ($post_query{'page_name'} =~ m/^http/) {
    $page_name = $post_query{'page_name'};
  } else {
    $page_name = $home_url . $post_query{'page_name'};
  }
} else {
  $page_name = $home_page;
}

}

sub place {
# Choose order processing method
print qq(
<p><center>
<table border=1 cellspacing=0 cellpadding=10 width=$Table_width bgcolor=$Table_Header_Color>\n
<tr><td colspan=2 bgcolor=$Table_Body_Color valign=middle>
<p>
<pre><b><u>Choose Order Processing Method:</u></b>\n</pre>
</td>
</tr>);

if ($secure) {
  print qq(
<tr><td bgcolor=$Table_Header_Color align=center valign=middle>
<form method=post action=$secure_url>
<input type=hidden name=merchant value=$post_query{'merchant'}>
);


  # If secure domain is different send a copy of the whole order over
  # and put it in a file there.
  if ($secure_domain) {
    open(ORDER, "<$order_file");
    @order_info = <ORDER>;
    for ($i=0; $i < $#order_info+1; $i++) {
      $order_info .= $order_info[$i];
    }
    close(ORDER);
    print "<input type=hidden name=order value=\"$order_info\">\n";

    if ($client) {
      open(CLIENT, "<$clientlist");
      while (<CLIENT>) {
        chop;
        ($cl,$em) = split(/\:/,$_);
        if ($cl eq $client) {
          print "<input type=hidden name=clientemail value=$em>\n";
          last;
        }
      }
    }
  }

  print qq(
<input type=hidden name=action value=place2>
<input type=hidden name=processing value=secure>
);
  if ($button_secure) {
    if ($post_query{'processing'} eq "secure") {
      if ($button_clear =~ m/https:/) {
        print "<INPUT TYPE=IMAGE SRC=$button_secure border=0>\n";
      } else {
        print "<INPUT TYPE=SUBMIT VALUE=\"SECURE ON-LINE\">\n";
      }
    } else {
      print "<INPUT TYPE=IMAGE SRC=$button_secure border=0>\n";
    }
  } else {
    print "<INPUT TYPE=SUBMIT VALUE=\"SECURE ON-LINE\">\n";
  }

  print qq(
</form>
</td>
<td bgcolor=$Table_Entry_Color>Secure Transaction using SSL.</td></tr>
);
} 

if (!$no_unsecure) {
  print qq(
<tr><td bgcolor=$Table_Header_Color align=center valign=middle>
<form method=post action=$script_url>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<input type=hidden name=action value=place2>
<input type=hidden name=processing value=unsecure>
);
  if ($button_online) {
    if ($post_query{'processing'} eq "secure") {
      if ($button_clear =~ m/https:/) {
        print "<INPUT TYPE=IMAGE SRC=$button_online border=0>\n";
      } else {
        print "<INPUT TYPE=SUBMIT VALUE=\"ON-LINE\">\n";
      }
    } else {
      print "<INPUT TYPE=IMAGE SRC=$button_online border=0>\n";
    }
  } else {
    print "<INPUT TYPE=SUBMIT VALUE=\"ON-LINE\">\n";
  }

  print qq(
</form>
<td bgcolor=$Table_Entry_Color>On-line through a unsecure web connection.  Choose this
if your browser does not support SSL. Your creditcard information will be
gathered and sent using two different packet transmission for increased
security.
</td></tr>
);
}

if (!$no_offline) {
  print qq(
<tr><td bgcolor=$Table_Header_Color valign=middle align=center>
<form method=post action=$script_url>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<input type=hidden name=action value=place2>
<input type=hidden name=processing value=fax>
);
  if ($button_offline) {
    if ($post_query{'processing'} eq "secure") {
      if ($button_clear =~ m/https:/) {
        print "<INPUT TYPE=IMAGE SRC=$button_offline border=0>\n";
      } else {
        print "<INPUT TYPE=SUBMIT VALUE=\"OFF-LINE\">\n";
      }
    } else {
      print "<INPUT TYPE=IMAGE SRC=$button_offline border=0>\n";
    }
  } else {
    print "<INPUT TYPE=SUBMIT VALUE=\"OFF-LINE\">\n";
  }

  print qq(
</form>
</td>
<td bgcolor=$Table_Entry_Color>Postal mail, telephone or fax ordering</td>
</tr>
);
}

print qq(
</table>
</center>
);
&footer;
}

# End sub place
#----------------------------------------------------------------------#

sub place2 {

# Goto routine to transfer order over to new server
if ($secure_domain && $post_query{'processing'} eq "secure" && $action ne 
"recalc") {
  &transfer_order;
}



if (-s $order_file) {
  print "<CENTER><h1>Check Out</h1></CENTER>\n";
} else {
     print "<h1>Error Trying to Place Order</h1>";
     print "You haven't ordered anything yet!\n";
     # print "Can't open $order_file";
     &return_page;
     exit;
}


&show_order;


if ($min_total && $order_total < $min_total) {

print qq[
<p>
<center>
<table><tr align=left><td>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<INPUT TYPE=HIDDEN NAME="last" VALUE="place">
<INPUT TYPE=HIDDEN NAME="action" VALUE="recalc">
<INPUT TYPE=SUBMIT VALUE="Update Quantities">
</FORM>
</td>
<td>
<FORM METHOD=POST ACTION=$script_url>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<INPUT TYPE=HIDDEN NAME="action" VALUE="clear">
<INPUT TYPE=SUBMIT VALUE="Clear Order">
</FORM>
</td>
];
# Prints a link to last page visited if available
if ($post_query{'page_name'}) {
  $script_return = $post_query{'page_name'};
} else {
  $script_return = $home_page;
}
print qq[
<td align=left>
<FORM METHOD=GET ACTION=$script_return>\n
<INPUT TYPE=SUBMIT VALUE="Continue Shopping">
</FORM>
</td>
</tr></table></center><p>

<p>
<center>
<table width=$Table_width bgcolor=$Table_Body_Color cellspacing=0 cellpadding=10 border=1> 
<tr align=left>
<td>
];
print "I'm sorry but the minimum order for $company is "; 
if ($no_decimal) {
  printf "<td align=right>%5.0f.", $min_total;
} else {
  printf "<td align=right>%5.2f.", $min_total;
}

print "If you would like to order from $company, please add more items.";
print qq[</td>
</tr>
</table>
</center>
<p>
];
&print_links;
&footer;
exit;
}



&load_countries;

print qq(
<center>
<table width=$Table_width><tr align=left>
<td>
To change the quantity, enter the quantity above and resubmit with 
this button.  Enter <b>0</b> in the quantity box to remove an item 
from your order.
</td>
<td align=left>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<INPUT TYPE=HIDDEN NAME="last" VALUE="place">
<INPUT TYPE=HIDDEN NAME="action" VALUE="recalc">
);

if ($button_update) {
  if ($post_query{'processing'} eq "secure") {
    if ($button_update =~ m/https:/) {
      print "<INPUT TYPE=IMAGE SRC=$button_update border=0>\n";
    } else {
      print "<INPUT TYPE=SUBMIT VALUE=\"Update Quantities\">\n";
    }
  } else {
    print "<INPUT TYPE=IMAGE SRC=$button_update border=0>\n";
  } 
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Update Quantities\">\n";
}

print qq(
</FORM>
</td></tr>

<tr align=left><td>
Press this button to clear your order.
</td><td>
<FORM METHOD=POST ACTION=$script_url>
<input type=hidden name=merchant value=$post_query{'merchant'}>
<INPUT TYPE=HIDDEN NAME="action" VALUE="clear">
);

if ($button_clear) {
  if ($post_query{'processing'} eq "secure") {
    if ($button_clear =~ m/https:/) {
      print "<INPUT TYPE=IMAGE SRC=$button_clear border=0>\n";
    } else {
      print "<INPUT TYPE=SUBMIT VALUE=\"Clear Order\">\n";
    }
  } else {
    print "<INPUT TYPE=IMAGE SRC=$button_clear border=0>\n";
  }
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Clear Order\">\n";
}

print qq(
</FORM>
</td></tr>\n
</table><p>\n
<FORM METHOD=POST ACTION=$secure_url>\n
<input type=hidden name=merchant value=$post_query{'merchant'}>\n
);



print qq(
<table border=1 width="$Table_width" bgcolor="$Table_Body_Color">\n
<td>\n
<pre><b><u>Ship To:</u></b>\n</pre>
<pre>
              Name:<input name="orname" size=47 maxlength=256>\n
            Street:<input name="street" size=47 maxlength=256>\n
           Street2:<input name="street2" size=47 maxlength=256>\n
              City:<input name="city" size=47 maxlength=256>\n
);
if ($rstate) {
  print " State or Province:";
  print "<input type=text name=state size=3 maxlength=3>\n\n"; 
} elsif ($state_textbox == 1) {
  print " State or Province:"; 
  print "<input type=text name=state size=47 maxlength=256>\n\n";
} elsif ($state_textbox == 2) {
  # Don't print a state input field
} else {
  print qq( State or Province:<select name="state">
  <option value=NA>Not Applicable
  <option value=AL>Alabama
  <option value=AK>Alaska
  <option value=AZ>Arizona
  <option value=AR>Arkansas
  <option value=CA>California 
  <option value=CO>Colorado
  <option value=CT>Connecticut
  <option value=DE>Delaware
  <option value=DC>District of Columbia
  <option value=FL>Florida
  <option value=GA>Georgia
  <option value=HI>Hawaii
  <option value=ID>Idaho
  <option value=IL>Illinois
  <option value=IN>Indiana
  <option value=IA>Iowa
  <option value=KS>Kansas
  <option value=KY>Kentucky
  <option value=LA>Louisiana
  <option value=ME>Maine
  <option value=MD>Maryland
  <option value=MA>Massachusetts
  <option value=MI>Michigan
  <option value=MN>Minnesota
  <option value=MS>Mississippi
  <option value=MO>Missouri
  <option value=MT>Montana
  <option value=NE>Nebraska
  <option value=NV>Nevada
  <option value=NH>New Hampshire
  <option value=NJ>New Jersey
  <option value=NM>New Mexico
  <option value=NY>New York
  <option value=NC>North Carolina
  <option value=ND>North Dakota
  <option value=OH>Ohio
  <option value=OK>Oklahoma
  <option value=OR>Oregon
  <option value=PA>Pennsylvania
  <option value=RI>Rhode Island
  <option value=SC>South Carolina
  <option value=SD>South Dakota
  <option value=TN>Tennessee
  <option value=TX>Texas
  <option value=UT>Utah 
  <option value=VT>Vermont
  <option value=VA>Virginia
  <option value=WA>Washington
  <option value=WV>West Virginia
  <option value=WI>Wisconsin
  <option value=WY>Wyoming
  <option value=AB>Alberta
  <option value=BC>British Columbia
  <option value=MB>Manitoba
  <option value=NB>New Brunswick
  <option value=NF>Newfoundland
  <option value=NT>NWT
  <option value=NS>Nova Scotia
  <option value=ON>Ontario
  <option value=PE>P.E.I.
  <option value=PQ>Quebec
  <option value=SK>Saskatchewan
  <option value=YT>Yukon
  </select>\n\n);
}
print "Zip or Postal Code:<input name=zip size=25 maxlength=256>\n\n"; 
print "           Country:";
print "<select name=country><option selected>US\n";
unless ($no_world_shipping) {
  for ($i = 0; $i < @countries; $i++) {
    print "<option>$countries[$i]";
  }
}
print "</select>\n";

print qq(
             Phone:<input name=phone size=25 maxlength=256>\n
             Email:<input name=email size=47 maxlength=256>\n); 
if (%additional_fields) {
  foreach $addit (keys %additional_fields) {
    # split this up, to print form tag and selection message
    ($ty,$field) = split(/\|/,$additional_fields{$addit});
    $padln = 18-length($ty);
    $pad = " " x $padln;
    if ($field =~ m/textarea/i) {
      print "\n$pad$ty:\n";
      $pad = " " x 19;
      print "$pad$field";
    } else {
      print "\n$pad$ty:$field";
    }
    print "\n\n";
  }
}

if (!$no_gift_message) {
  print qq(
      Gift Message: If order is a gift, enter message to attach here.\n
                   <textarea name="giftmessage" rows=8 cols=40 valign=top></textarea>\n);
}

if (!$no_billing_address) {
print qq(
<p><b>
<u>Billing Address:</u></b>   <input type=checkbox name=billing value="1" checked> Same as Shipping Address\n<br>

              Name:<input name=ornameb size=47 maxlength=256>\n
            Street:<input name=streetb size=47 maxlength=256>\n
           Street2:<input name=street2b size=47 maxlength=256>\n
              City:<input name=cityb size=47 maxlength=256>\n);
if ($state_textbox) {
print "\n State or Province:<input name=stateb size=47 maxlength=256>\n\n";
} else {
print qq(\n State or Province:<select name=stateb>
<option value=NA>Not Applicable
<option value=AL>Alabama
<option value=AK>Alaska
<option value=AZ>Arizona
<option value=AR>Arkansas
<option value=CA>California 
<option value=CO>Colorado
<option value=CT>Connecticut
<option value=DE>Delaware
<option value=DC>District of Columbia
<option value=FL>Florida
<option value=GA>Georgia
<option value=HI>Hawaii
<option value=ID>Idaho
<option value=IL>Illinois
<option value=IN>Indiana
<option value=IA>Iowa
<option value=KS>Kansas
<option value=KY>Kentucky
<option value=LA>Louisiana
<option value=ME>Maine
<option value=MD>Maryland
<option value=MA>Massachusetts
<option value=MI>Michigan
<option value=MN>Minnesota
<option value=MS>Mississippi
<option value=MO>Missouri
<option value=MT>Montana
<option value=NE>Nebraska
<option value=NV>Nevada
<option value=NH>New Hampshire
<option value=NJ>New Jersey
<option value=NM>New Mexico
<option value=NY>New York
<option value=NC>North Carolina
<option value=ND>North Dakota
<option value=OH>Ohio
<option value=OK>Oklahoma
<option value=OR>Oregon
<option value=PA>Pennsylvania
<option value=RI>Rhode Island
<option value=SC>South Carolina
<option value=SD>South Dakota
<option value=TN>Tennessee
<option value=TX>Texas
<option value=UT>Utah 
<option value=VT>Vermont
<option value=VA>Virginia
<option value=WA>Washington
<option value=WV>West Virginia
<option value=WI>Wisconsin
<option value=WY>Wyoming
<option value=AB>Alberta
<option value=BC>British Columbia
<option value=MB>Manitoba
<option value=NB>New Brunswick
<option value=NF>Newfoundland
<option value=NT>NWT
<option value=NS>Nova Scotia
<option value=ON>Ontario
<option value=PE>P.E.I.
<option value=PQ>Quebec
<option value=SK>Saskatchewan
<option value=YT>Yukon
</select>\n
);
}
print "Zip or Postal Code:<input name=zipb size=25 maxlength=256>\n\n"; 
print "           Country:";
print "<select name=countryb><option selected>US\n";
unless ($no_world_shipping) {
  for ($i = 0; $i < @countries; $i++) {
    print "<option>$countries[$i]";
  }
}

print "</select>\n\n";

print "             Phone:<input name=phoneb size=25 maxlength=256>\n\n";
print "             Email:<input name=emailb size=47 maxlength=256>\n\n"; 

} # end billing address

print "<u><b>Order Comments:</b></u>    Enter message to merchant here.\n\n";
print "                   <textarea name=comments cols=40 rows=8></textarea>\n"; 
if (%special_selections) {
  print "\n<u><b>Special Options:</b></u>\n\n";
  foreach $sel (keys %special_selections) {
    # split this up, to print form tag and selection message
    ($ty,$special_sel) = split(/\|/,$special_selections{$sel});
    print "$ty $special_sel\n\n";
  }
}
print "</pre>";

print "<center>";
print "When you are done shopping and ready to submit your order,  press\n";
print "this button.</center><p>\n";
printf "<INPUT TYPE=HIDDEN NAME=Total VALUE=\"%6.2f\">\n", $order_total;
print "<INPUT TYPE=HIDDEN NAME=action VALUE=\"ship\">";

# 11/25
print "<INPUT TYPE=HIDDEN NAME=discount value=$dis>\n";

print "<center>\n";
print "<input type=hidden name=processing value=$post_query{'processing'}>\n";

if ($button_continue) {
  if ($post_query{'processing'} eq "secure") {
    if ($button_clear =~ m/https:/) {
      print "<INPUT TYPE=IMAGE SRC=$button_continue border=0>\n";
    } else {
      print "<INPUT TYPE=SUBMIT VALUE=\"Continue\">\n";
    }
  } else {
    print "<INPUT TYPE=IMAGE SRC=$button_continue border=0>\n";
  }
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Continue\">\n";
}

print "</center>\n";
print "</FORM>\n";
print "</td></table>\n";
print "</center><p>";
&print_links;
&footer;
exit;
}
# End sub place2
#----------------------------------------------------#


sub print_links {
#Prints out the links to other pages
#Put in the catalog data filename for each page

print "<center><h5>";
foreach $p (keys %pagelinks) {
  $plink = $home_url . "$p";
  print "<A href=$plink>[$pagelinks{$p}]</A>\n";
}
print "</center></h5>";
}
# End sub print_links
#----------------------------------------------------#


sub print_thanks {

#expire the current cookie so they have to get another one to order
# $session_id = $$ . $ENV{'REMOTE_ADDR'};
# $session_id =~ s/\.//g;
# $session_id = substr($session_id,0,8);
# Or use ip number:
#$session_id = $ENV{'REMOTE_ADDR'};
print "Set-Cookie: ID=1; path=/\n";
&header;

if (!$thankyou) {
  print "<h1>Order Sent!</h1>\n";
  print "Thank you for ordering from $company!  ";
  if ($success) {
     print "<b>$success</b>";
  }
  print "You will receive an Email receipt shortly.<br><br>\n";
} else {
  print "$thankyou";
  if ($sucess) {
    print "<b>$success</b>";
  }
}
&return_page;

&print_links;

}
# End sub print_thanks
#----------------------------------------------------#

sub recalc {
# Recalculate order for changed quantities

open(OUTPUT, ">$order_file") || &error("Cant open $order_file in sub recalc");
  foreach $key (keys %post_query) {
    if ($key =~ m/quant/) {

      ($code, $gar) = split(/_/,$key);

      $add_key = $code;
      $quant_key = $code . "_quant";

      $min_key = $code . "_min";
      if ($post_query{$min_key}) {
        if ($post_query{$key} < $post_query{$min_key}) {
          $post_query{$key} = $post_query{$min_key};
        }
      }

      $max_key = $code . "_max";
      if ($post_query{$max_key}) {
        if ($post_query{$key} > $post_query{$max_key}) {
          $post_query{$key} = $post_query{$max_key};
        }
      }

      if ($post_query{$key} > 0) {
        $add_string = "";
	$order_exist = 1;
        ($code,$items) = split(/--/,$code);

        if ($price_file eq "none") {
          $item_name = $code . "--$items" . "_name";
          $add_string .= "$post_query{$item_name}:";
        } 
       
 	if ($post_query{$min_key} && $post_query{$max_key}) {
          $add_string .= "$code:$post_query{$key}\!$post_query{$min_key}to$post_query{$max_key}:";
	} elsif ($post_query{$min_key} && !$post_query{$max_key}) {
          $add_string .= "$code:$post_query{$key}\!$post_query{$min_key}:";
   	} elsif ($post_query{$max_key} && !$post_query{$min_key}) {
          $add_string .= "$code:$post_query{$key}\!0to$post_query{$max_key}:";
        } else {      
          $add_string .= "$code:$post_query{$key}:";
        }
     
        $item_price = $code . "--$items" . "_price";
        $add_string .= "$post_query{$item_price}:";


        $item_hand = $code . "--$items" . "_handling";
        $add_string .= "$post_query{$item_hand}:";

        # New shipping routine for per item
        $itemship = $code . "--$items" . "_itemship";
        $add_string .=  "$post_query{$itemship}:";

        $item_weight = $code . "--$items" . "_weight";
        $add_string .= "$post_query{$item_weight}:";

      
        $item_prop1 = $code . "--$items" . "_prop1";
        $item_prop2 = $code . "--$items" . "_prop2";
        $item_prop3 = $cope . "--$items" . "_prop3";

        $add_string .= "$post_query{$item_prop1}:";
        $add_string .= "$post_query{$item_prop2}:";
        $add_string .= "$post_query{$item_prop3}:";

        
        $item_dlfile = $code . "--$items" . "_dlfile";
        $add_string .= $post_query{$item_dlfile};


        print (OUTPUT "$add_string\n");
      }
   }
}
close(OUTPUT);
if ($post_query{'last'} =~ m/view/) {
  print "<CENTER><h1>View Current Order</h1></CENTER>\n";
  &show_order;
  &show_order2;
  &footer;
  } else {
  &place2;
}
}
# End sub recalc
#----------------------------------------------------#

sub return_page {
# Prints a link to last page visited if available
if ($post_query{'page_name'}) {
  if ($post_query{'page_name'} =~ m/^http/) {
    $script_return = $post_query{'page_name'};
  } else {
    $script_return = "$home_url" . "$post_query{'page_name'}";
  }
  print "<p><a href=$script_return>";
  print "Return to Last Visited Page</a>";
} else {
  $script_return = $home_page;
  print "<p><a href=$script_return>";
  print "Return to Home Page</a>";
}
}

# End sub return_page
#-----------------------------------------------------#


sub search {
# search engine routine
$search=$post_query{'term'};

if (!(-d $home_html)) {
$searchengine_error = qq(Cannot open $home_html.  Check the merchant
setup file to see if \$home_html = is set correctly.  Also, the merchant
html files must be on the same server as the cybercart script.  If not,
use the CyberSearch script as the search engine, by placing it
on the server with the merchant html files.  See the
<a href="http://www.lobo.net/~rtweb/Cybercart/searchengine.html">CyberSearch</a>
page for more info.);

  &error("$searchengine_error");
  exit;
}

if (length($search) < 3) {
 print "Search terms of less than three letters are not allowed.";
 exit 0;
}

$found=0;
print "<h1>Search Results</h1>\n";
print "Search term: $post_query{'term'}<br>\n";
&scan_files($home_html,$search);

if ($num == 0) {
  print "No matches found.<p>";
} else {
  print "</ol>\n";
}

&print_links;
&footer;
}
#-------------------------------------------------------------------------------------

sub scan_files {
  my $dir=$_[0];
  my $st=$_[1];
  my (@dirs,@files,@results,$filename,$newdir,$list);
  opendir(dir,$dir);
  @dirs=grep {!(/^\./) && -d "$dir/$_"} readdir(dir);
  rewinddir(dir);
  @files=grep {!(/^\./) && /htm/ && -T "$dir/$_"} readdir(dir);
  closedir (dir);
  for $list(0..$#dirs) {
    if (!($dirs[$list]=~/temp/ || $dirs[$list]=~/images/)) {
      $newdir=$dir."/".$dirs[$list];
      &scan_files ($newdir,$st);
    }
  }
  for $list(0..$#files) {
    $filename=$dir."/".$files[$list];
    $title=$files[$list];
    open file, $filename;
    $anchor = "top";
    while (<file>) {
      if (/<title>([^<]+)<\/title>/i) {
        $title=$1;
      }
      if (/<a name=\"([^<]+)\"/i) {
        $anchor = $1;
      }
    @terms = split(/\s/,$st);   
    $num_matches = 0;
    foreach $word (@terms) {  
      if ($_ =~ m/$word/i) {
        $num_matches += 1;
      }
    }
    $numterms = @terms;
    if ($num_matches == $numterms) {
      s/<[^>]*(>|$)//ig;
      s/^[^>]*>//i;
      $match = substr($_,0,80);
      if (/$st/i) {
        $num += 1;
        $found = 1;
        my $urlsearch=$st;
        $urlsearch=~s/ /+/g;

        $filename =~ s/$home_html/$home_url/i;

        if ($num == 1) {
          print "<ol>\n";
        }
        # $result_link = "$filename\#$anchor";
        $result_link = "$home_url" . "$files[$list]\#$anchor";
        if (!$printed_hit{$result_link}) {
          print "<li><a href=\"$result_link\">$match</a>";
        }

 	$printed_hit{$result_link} = 1;
              
      }
    }
  }
}
return 1;
}
# End scan_files
#--------------------------------------------------------------


sub send {
# Send email to customer and merchant

%cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});
# Define formats
&formats;

$order_num = $session_id;
$order_num =~ s/\.//g;


# reformat expiration date
$post_query{'expdate'}= $post_query{'exp_month'} . "/$post_query{'exp_year'}";

if ($onanalysis && $post_query{'processing'} eq "secure"  && $post_query{'CCN'}) {
  &run_transaction;
  &print_results;
  
}

# Routine to check for referral link
if ($cookies{'MID'}) {
  $client=$cookies{'MID'};
} else {
  $client = $post_query{'merchant'};
}

# Mail receipt and order (save to file if secure)
$total = 0; 
$grandtotal=0;

($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
$mon += 1;
$Date = $mon . "-" . $mday . "-" . $year;
if ($min < 10) {
  $min = "0" . "$min";
}

if ($mon < 10) {
  $mon = "0" . "$mon";
}

if ($mday <10) {
  $mday = "0" . "$mday";
}



#define temporary mail files
$temprec = $invoice_dir . "\\$order_num" . ".order";
$tempcus = $invoice_dir . "\\$order_num" . "c.tmp";

open(MAIL2, ">$tempcus") || &error("Cant open $tempcus in sub send.");

$sec_file = "$invoice_dir" . "\\$order_num" . ".order"; 
open(MAIL, ">$temprec") || print "Cant open $sec_file!\n";

print MAIL "Order \#$order_num\n";        

$subject = "Order \#$order_num";

print MAIL "Time and Date: $hour:$min $Date\n";
print MAIL "Email Address: $post_query{'email'}\n";
if ($client) {
  print MAIL "Website referral id: $client\n";
}

print MAIL "Shipping Address:\n\n";
print MAIL "$post_query{'orname'}\n";
print MAIL "$post_query{'street'}\n";
if ($post_query{'street2'}) {
   print MAIL "$post_query{'street2'}\n";
}
print MAIL "$post_query{'city'}\n";
print MAIL "$post_query{'state'}\n";
print MAIL "$post_query{'country'}  $post_query{'zip'}\n";
print MAIL "$post_query{'phone'}\n\n";
print MAIL "$post_query{'email'}\n\n";

print MAIL2 "To: $post_query{'email'}\n";

print MAIL2 "From: $recipient\n";
if (@mailcc) {
  foreach $copies (@mailcc) {
    $maillist .= "$copies,";
  }
}
if ($clientemail && $sendclient) {
  $maillist .= "$clientemail,";
}
chop($maillist);

print MAIL2 "Bcc: $maillist\n";
print MAIL2 "Subject: Order \#$order_num\n";
print MAIL2 "Order \#: $order_num\n";
print MAIL2 "Time and Date: $hour:$min $Date\n";
print MAIL2 "Email Address: $post_query{'email'}\n";
if ($client) {
  print MAIL2 "Website referral id: $client.\n";
}

print MAIL2 "Shipping Address:\n\n";
print MAIL2 "$post_query{'orname'}\n";
print MAIL2 "$post_query{'street'}\n";
if ($post_query{'street2'}) {
  print MAIL2 "$post_query{'street2'}\n";
}
print MAIL2 "$post_query{'city'}, $post_query{'state'}\n";
print MAIL2 "$post_query{'country'}  $post_query{'zip'}\n";
print MAIL2 "$post_query{'phone'}\n";
print MAIL2 "$post_query{'email'}\n\n";

# Add billing address
if (!$post_query{'billing'} && !$no_billing_address) {
  print MAIL "\nBilling Address:\n\n";
  print MAIL "$post_query{'ornameb'}\n";
  print MAIL "$post_query{'streetb'}\n";
  if ($post_query{'street2b'}) {
    print MAIL "$post_query{'street2b'}\n";
  }
  print MAIL "$post_query{'cityb'}, $post_query{'stateb'}\n";
  print MAIL "$post_query{'countryb'}  $post_query{'zipb'}\n";
  print MAIL "$post_query{'phoneb'}\n\n";


  print MAIL2 "\nBilling Address:\n\n";
  print MAIL2 "$post_query{'ornameb'}\n";
  print MAIL2 "$post_query{'streetb'}\n";
  if ($post_query{'street2b'}) {
    print MAIL2 "$post_query{'street2b'}\n";
  }
  print MAIL2 "$post_query{'cityb'}, $post_query{'stateb'}\n";
  print MAIL2 "$post_query{'countryb'}  $post_query{'zipb'}\n";
  print MAIL2 "$post_query{'phoneb'}\n\n";
}

if ($price_file ne "none") {
  &load_prices;
}

open(INPUT, "$order_file") || &error("cant open $order_file!");

$log_file = $log_dir . "/item.log";

open(LOGITEM, ">>$log_dir" . "\\item.log") || &error("Cant open $log_dir log file!");

 
print MAIL qq(
Code     Description                          Weight   Price Quant   Total
==========================================================================
);

print MAIL2 qq(
Code     Description                          Weight   Price Quant   Total
==========================================================================
);

 
while(<INPUT>) { #while1
  chop;
 ($name,$current_code,$amount,$price,$hand,$item_ship,
  $wt,$prop[1],$prop[2],$prop[3],$dl_file)=split(/:/);

  # New code for minimum order amount
  if ($amount =~ m/\!/) {
    ($amount,$limits) = split(/\!/,$amount);
    ($min_order,$max_order) = split(/to/,$limits);
  }

   
  if ($amount != 0) { #if1
    if ($price_file ne "none" ) {
      ($name,$desc) = split(/-/,$iname{$current_code});
      $price=$iprice{$current_code};
    }

    # New code for quantity pricing
      if ($price =~ m/\!/) {
        $quantprice=1;
        $qprice = $price;
        @qprice = split(/\|/,$price);
        foreach $qp (@qprice) {
          ($range,$rangeprice) = split(/\!/,$qp);
          ($low,$high) = split(/to/,$range);
          $price = $rangeprice;
          if ($amount >= $low && $amount <= $high) {
             last;
          }
        }
      }



    # 11/24/96
    # split out marker for non-taxable itme
    ($price,$nontaxable) = split(/-/,$price);

    $itemprop = "";

    
    if ($prop[1]) {
      $itemprop .= "          " . $properties[0] . ":" . $prop[1] . " \n";
    }
 
    if ($prop[2]) {
      $itemprop .= "          " . $properties[1] . ":" . $prop[2] . " \n";
    }   
	
    if ($prop[3]) {
      $itemprop .= "          " . $properties[2] . ":" . $prop[3] . " \n";
    }
    # Calculate handling charges
    if ($hand) {
      $total_item_hand += $hand * $amount;
    }	
	
    $total = $price * $amount;
    $ordertotal = $ordertotal + $total;

    $total_items_ordered += $amount;
    $tweight = $wt * $amount; 
    $total_wt += $tweight;

    $oldhandle = select(MAIL);
    if ($weight || $shipping_cost eq "actual") {
      if ($no_decimal) {
        $~ = "NDITEMWT";  
      } else {
        $~ = "ITEMWT";
      }
    } else {
      if ($no_decimal) {
        $~ = "NDITEMNOWT";
      } else {
        $~ = "ITEMNOWT";
      }
    }
    write MAIL;

    select(MAIL2);
    if ($weight) {
      if ($no_decimal) {
        $~ = "NDITEMWT";
      } else {
        $~ = "ITEMWT";
      }
    } else {
      if ($no_decimal) {
        $~ = "NDITEMWT"; 
      } else {
        $~ = "ITEMNOWT";
      }
    }
    write MAIL2;

    if ($itemprop) {
      print MAIL "$itemprop";
      print MAIL2 "$itemprop";
    }

    if ($dl_file) {
      push(@dlfiles,$dl_file);
    }   
	
    
    #log item
    print(LOGITEM "$current_code:$name:$prop[1]:$prop[2]:$prop[3]|$amount|$total\n");             
         
  } #if1
} #while1    
close(INPUT);
close(LOGITEM);

print MAIL "\n";
print MAIL2 "\n";

select(MAIL);
if ($no_decimal) {
  $~ = "NDTOTAL";
} else {
  $~ = "TOTAL";
}
write(MAIL);

select(MAIL2);
if ($no_decimal) {
  $~ = "NDTOTAL";
} else {
  $~ = "TOTAL";
}
write(MAIL2);


if ($post_query{'discount'} < 0) {
  $dis = $post_query{'discount'};
  $ordertotal += $dis;
  select(MAIL);
  if ($no_decimal) {
    $~ = "NDDISCOUNT";
  } else {
    $~ = "DISCOUNT";
  }
  write MAIL;
  select(MAIL2);
  if ($no_decimal) {
    $~ = "NDDISCOUNT";
  } else {
    $~ = "DISCOUNT";
  }
  write MAIL2;
}

$taxable_total = $ordertotal;

if (!$tax_option) { 

  #&taxes;
  $taxes = $post_query{'taxes'};
  if ($taxes > 0) {
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDTAX";
    } else {
      $~ = "TAX";
    }
    write MAIL;
    select(MAIL2);
    if ($no_decimal) {
      $~ = "NDTAX";
    } else {
      $~ = "TAX";
    }
    write MAIL2;
  }
}

$order_total = $ordertotal;

if ($shipping_cost ne "None") {
  ($ship_type,$shipping) = split(/-/,$post_query{'ship_cost'});
  if ($total_wt > 0) {
    $shipinfo = "$ship_type $total_wt $weight";
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDSHIPPING_WT";
    } else {
      $~ = "SHIPPING_WT";
    }
    write(MAIL);
    select(MAIL2);
    if ($no_decimal) {
      $~ = "NDSHIPPING_WT";
    } else {
      $~ = "SHIPPING_WT";
    }
    write(MAIL2);
  } elsif ($shipping >0 ) { 
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDSHIPPING";
    } else {
      $~ = "SHIPPING";
    }
    write(MAIL);
    select(MAIL2);
    if ($no_decimal) {
      $~ = "NDSHIPPING";
    } else {
      $~ = "SHIPPING";
    }
    write(MAIL2);
  }
}

if ($post_query{'delivery'} && $post_query{'delivery'} ne "default") {
   select(MAIL);
   if ($no_decimal) {
      $~ = "NDDELIVERY";
    } else {
      $~ = "DELIVERY";
    }
   write MAIL;
   select(MAIL2);
   if ($no_decimal) {
      $~ = "NDDELIVERY";
    } else {
      $~ = "DELIVERY";
    }
   write MAIL2;
}   

if ($handling_order || $handling_item || $handling_special) {
  if ($handling_order) {
     $handling_charges = $handling_order;
  } elsif ($handling_item) {
    $handling_charges = $handling_item * $total_items_ordered;
  } elsif ($handling_special) {
    $handling_charges = $total_item_hand;
  }
  if ($handling_charges > 0) {
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDHANDLING";
    } else {
      $~ = "HANDLING";
    }
    write MAIL;
    select(MAIL2);
    if ($no_decimal) {
      $~ = "NDHANDLING";
    } else {
      $~ = "HANDLING";
    }
    write MAIL2;
  }
}

if (%special_selections) {
  foreach $sk (keys %special_selections) {
    if ($post_query{$sk}) {
      ($ty, $mes, $addedcost) = split(/\|/,$special_selections{$sk});
      if ($addedcost > 0) {
        $special_cost += $addedcost;
      }
    }
  }
  if ($special_cost > 0) {
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDSPECIAL";
    } else {
      $~ = "SPECIAL";
    }
    write MAIL;
    select(MAIL2);
    $~ = "SPECIAL";
    if ($no_decimal) {
      $~ = "NDSPECIAL";
    } else {
      $~ = "SPECIAL";
    }
    write MAIL2;
  }
}      
   
$grandtotal = $ordertotal + $shipping + $delivery_method{$post_query{'delivery'}} + $taxes + $special_cost + $handling_charges;


if ($tax_option && $tax_option ne "none") {
 
  $taxable_total += $shipping + $special_cost + $handling;      
  #&taxes;
  $taxes = $post_query{'taxes'};
  $grandtotal += $taxes;

  if ($taxes > 0) {
    select(MAIL);
    if ($no_decimal) {
      $~ = "NDTAX";
    } else {
      $~ = "TAX";
    }
    write MAIL;
    select(MAIL2);
    if ($no_decimal) {
      $~ = "NDTAX";
    } else {
      $~ = "TAX";
    }
    write MAIL2;
  }
}


select(MAIL);
if ($no_decimal) {
  $~ = "NDGRANDTOTAL";
} else {
  $~ = "GRANDTOTAL";   
}
write MAIL;
select(MAIL2);
if ($no_decimal) {
  $~ = "NDGRANDTOTAL";
} else {
  $~ = "GRANDTOTAL";
}
write MAIL2;

select(STDOUT);


print MAIL qq(
==========================================================================\n
);
print MAIL2 qq(
==========================================================================\n
);

if ($post_query{'comments'}) {
  print MAIL "\nComments: $post_query{'comments'}\n";
  print MAIL2 "\nComments: $post_query{'comments'}\n";
}

if ($post_query{'giftmessage'}) {
  print MAIL "\nGift Message: $post_query{'giftmessage'}\n";
  print MAIL2 "\nGift Message: $post_query{'giftmessage'}\n";
}

if (%special_selections) {
  foreach $sel (keys %special_selections) {
    if ($post_query{$sel}) {
      unless ($mes_head) {
        print MAIL "\nSpecial Selections (any costs included above):\n";
        print MAIL2 "\nSpecial Selections (any costs included above):\n";
        $mes_head=1;
      }
      ($ty, $mes, $ac) = split(/\|/,$special_selections{$sel});
      print MAIL "$mes\n";
      print MAIL2 "$mes\n";
    }
  }
}

#if (%additional_fields) {
  foreach $addit (keys %additional_fields) {
    if ($post_query{$addit}) {
      unless ($mes_head) {
        print MAIL "\nAdditional Fields\n";
        print MAIL2 "\nAdditional Fields\n";
        $mes_head=1;
      }
      ($ty,$field) = split(/\|/,$additional_fields{$addit});

      print MAIL "$ty : $post_query{$addit}\n";
      print MAIL2 "$ty : $post_query{$addit}\n";
    }
  }
#}


print MAIL "\n\nBilling Information\n";
print MAIL "Payment Method: $post_query{'cardtype'}\n";

if ($post_query{'processing'} eq "secure" && $post_query{'CCN'} && $onanalysis) {
  print MAIL "SocketLink Transaction ID: $socketlink_reference_number\n";
  print MAIL "SocketLink Response Code: $status\n";
  print MAIL "Processor Response Data: $processor_reference_number\n";
} elsif ($post_query{'CCN'} && !$secure) {
  print MAIL "Name on Card: $post_query{'card_name'}\n";
  print MAIL "Expiration Date: $post_query{'expdate'}\n";
  print MAIL "1st Half of Number: $post_query{'CCN'}";
} elsif ($post_query{'CCN'} && $secure) {
  print MAIL "Credit Card Number: $post_query{'CCN'}\n";
  print MAIL "Name on Card: $post_query{'card_name'}\n";
  print MAIL "Expiration Date: $post_query{'expdate'}\n";
} elsif ($post_query{'cardtype'} eq "onlinecheck") {
  &online_check_init;

  for ($i=0; $i < @online; $i++) {
    print MAIL "$online{$online[$i]}: $post_query{$online[$i]}\n";
  }

  print MAIL "\n\n";
}

print MAIL2 "\n\nBilling Information\n";

if ($post_query{'check'} eq "on") {
  print MAIL2 "\nWe will send your order as soon as we recieve your ";
  print MAIL2 "check!";
  if ($checks) {
    print MAIL2 "  Please make your check out to $checks.";
  }
} else {
  print MAIL2 "Payment Method: $post_query{'cardtype'}\n";
}

if ($mail_closing) {
  print MAIL2 "$mail_closing"
}

close(MAIL);
close(MAIL2);


if ($secure) {
  $tempnot = $invoice_dir . "\\$session_id" . "n.tmp";
  open(NOTIFY, ">$tempnot") || &error("Cant open $temprec in sub mail_results.\n");
  print NOTIFY "New order \#$order_num arrived!\n";
  print NOTIFY "New order arrived for $post_query{'merchant'}!\n";
  close(NOTIFY); 
  $mailnote = "$mail_loc $tempnot \-t $recipient \-s Order -server $mail_server";
  # print "mailnote = $mailnote<br>";
  system("$mailnote");
} 

$mail2="$mail_loc $tempcus \-t $post_query{'email'} \-s Receipt -server $mail_server";
system("$mail2");


# Print order info to status file
$info = "$order_num" . "::" . "$post_query{'orname'}" . "::$mon/$mday" . "::Received but not processed.";
open(STATUS, ">>$status_file") || &error("Can't open status file $status_file.");
print (STATUS "$info\n"); 
close(STATUS);

# new referrer function
&referrer;


if (!$secure || $post_query{'processing'} eq "unsecure") {
  $mailorder = "$mail_loc $temprec \-t $recipient \-s \"$subject\" -server $mail_server";
  system("$mailorder"); 
  if ($post_query{'CCN'}) {
    &header;
    &creditcard2_form;
  } else {
    # New code for download files
    if (@dlfiles > 0 && $dl_type) {
      &download(@dlfiles);
    }
    if (!$delorder) {
      unlink($order_file);
    }
    &print_thanks;
  }
} else {
  if (!$delorder) {
    unlink($order_file);
  }
  if (@dlfiles > 0 && $dl_type) {
    &download(@dlfiles);
  }
  &print_thanks;
}
&footer;
}   
# End sub send
#----------------------------------------------------#



sub show_order {

# Check to see if they cleared order by putting 0s in recalc
if ($action eq "recalc" && !$order_exist) {
    print "<h1>Order Cleared</h1>";
    print "Your order has been cleared.<p>";
    &print_links;
    &footer;
    exit;
}

# Show current session order
if ($post_query{'processing'} eq "secure" && (( $action eq "place2" || $action eq "ship") ||
  $action eq "recalc") ) {
  print "<FORM METHOD=POST ACTION=$secure_url>\n";
} else {
  print "<FORM METHOD=POST ACTION=$script_url>\n";
}
print "<input type=hidden name=merchant value=$post_query{'merchant'}>\n";

if ($page_name) {
  print "<input type=hidden name=page_name value=$page_name>\n";
}

# Send along processing method so if they update quantities in checkout
if ($post_query{'processing'}) {
  print "<input type=hidden name=processing value=$post_query{'processing'}>\n";
}

print "<center>\n";
print "<table border=1 cellspacing=0 cellpadding=10 width=\"$Table_width\" BGCOLOR=\"$Table_Header_Color\">\n"; 
print "<tr align=left>\n";

if ($print_code) {
  print "<th><tt>Item Code</tt></th>\n";
}

print "<th><tt>Product</tt></th>";
$numprop = @properties;

for ($i=0; $i<$numprop;$i++) {
  print "<th align=left><tt>$properties[$i]</tt></th>";
}

if ($weight) {
  print "<th align=center><tt>Weight</tt></th>";
  $numprop += 1;
}

print "<th align=right><tt>Price</tt></th>\n";
print "<th align=right><tt>Quantity</tt></th>";
print "<th align=right><tt>Total</tt></th></tr>";

if ($price_file ne "none") {
 &load_prices;
}

open(INPUT, "$order_file") || &error("Cant open $order_file!");

if (-s $order_file) {
  $total = 0; 
  $grandtotal = 0;
  $items = 0;
  while(<INPUT>) {
    chop;
    ($name,$current_code,$amount,$price,$hand,$item_ship,$wt,$prop[1],$prop[2],
    $prop[3],$dl_file)=split(/:/);

    # New code for minimum order amount
    if ($amount =~ m/\!/) {
      ($amount,$limits) = split(/\!/,$amount);
      ($min_order,$max_order) = split(/to/,$limits);
    }


    if ($amount != 0) {
      $items += 1;
      
      if ($price_file ne "none") {
        $price = $iprice{$current_code};
        ($name,$des) = split(/-/,$iname{$current_code});
      } 

      # New code for quantity pricing
      if ($price =~ m/\!/) {
        $quantprice=1;
	$qprice = $price;
        @qprice = split(/\|/,$price);
        foreach $qp (@qprice) {
          ($range,$rangeprice) = split(/\!/,$qp);
          ($low,$high) = split(/to/,$range);
          $price = $rangeprice;
          if ($amount >= $low && $amount <= $high) {
	     last;
  	  }
        }
      }         

      # 11/24/96
      # split out marker for non-taxable item or discount item
      $itemnt = 0;
      ($price,$nontaxable) = split(/-/,$price);

      $total = $price * $amount; 
      $num_items_ordered += $amount;

      # 11/24/96
      # differentiate between taxable and non-taxable item

      if ($nontaxable !~ m/nt/) {
        $taxable_total += $total;
      } else {
        $price = $price . "$nontaxable";
        $nontax_total += $total;
        $itemnt = 1;
      }   

      print "<tr valign=top BGCOLOR=\"\#$Table_Entry_Color\">";
      if ($print_code) {
        print "<td align=left>$current_code</td>";
      }
  
      print "<td align=left>$name";

      # New shipping routine for per item
      if ($shipping_cost eq "per_item") {#
 
         $itemship = $current_code . "--$items" . "_itemship";
         print "<input type=hidden name=$itemship value=$item_ship>";
         $shipping += $item_ship*$amount;
      }


      if ($itemnt) {
        print " (non-taxable) ";
      }
      if ($price_file eq "none") {
        $item_name = $current_code . "--$items" . "_name";
        print "<INPUT TYPE=HIDDEN NAME=$item_name VALUE=\"$name\">\n";
        if ($hand) {
          $item_hand = $current_code . "--$items" . "_handling";
          print "<input type=hidden name=$item_hand value=$hand>";
        }
        $item_dlfile = $current_code . "--$items" . "_dlfile";
        if ($dl_file) {
          print "<input type=hidden name=\"$item_dlfile\" value=\"$dl_file\">\n";
        }
	print "</td>\n";
      } else {
        print "</td>";
      }

      for ($i=1;$i<@properties+1;$i++) {
        if ($prop[$i]) {
          if ($prop[$i] =~ m/\+/) {
            ($prop[$i],$gar) = split(/\+/,$prop[$i]);
          } elsif ($prop[$i] =~ m/\-/) {
            ($prop[$i],$gar) = split(/\-/,$prop[$i]);
          }
          print "<td align=left>$prop[$i]";
          $item_prop = $current_code . "--$items" . "_prop" . $i;     
          print "<INPUT TYPE=HIDDEN NAME=$item_prop VALUE=\"$prop[$i]\"></td>\n";
        } else {
          print "<td align=center>---</td>\n";
        }
      }

      if ($hand) {
        $total_item_hand += $hand * $amount;
      }

      if ($weight) {
        printf "<td align=right>%3.1f\n", $wt*$amount;
        $item_wt = $current_code . "--$items" . "_weight";
        print "<INPUT TYPE=HIDDEN NAME=$item_wt VALUE=$wt></td>\n";
        $total_wt += $wt*$amount;
      }

      if ($no_decimal) {
        printf "<td align=right>%5.0f", $price;
      } else {
        printf "<td align=right>%5.2f", $price;
      }

      if ($price_file eq "none" && !$quantprice) {
        $item_price = $current_code . "--$items" . "_price";
        print "<INPUT TYPE=HIDDEN NAME=$item_price VALUE=$price></td>\n";
      } elsif ($quantprice) {
        $item_price = $current_code . "--$items" . "_price";
        print "<INPUT TYPE=HIDDEN NAME=$item_price value=$qprice></td>\n";
      } else {
        print "</td>\n";
      }

   

      $item_quant = $current_code . "--$items" . "_quant";
      $item_min = $current_code . "--$items" . "_min";
      $item_max = $current_code . "--$items" . "_max";
      print "<td align=right>";
      if ($action eq "order" || $action eq "place" || $action eq "recalc" 
	|| $action eq "place2" || $action eq "addplus" || $action eq "add") {
        print "<INPUT TYPE=TEXT NAME=$item_quant VALUE=$amount SIZE=4 MAXLENGTH=4>";
        if ($min_order > 0) {
          print "<INPUT TYPE=HIDDEN NAME=$item_min VALUE=$min_order>";
        }
        if ($max_order > 0) {
	  print "<INPUT TYPE=HIDDEN NAME=$item_max VALUE=$max_order>";
        }
	print "</TD>\n";
      } else {
        print "$amount</td>";
      }
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $total;
      } else {
        printf "<td align=right>%5.2f", $total;
      }
      print "</td></tr>";
    }
  }
  close(INPUT);

  # Figure number of cols and rows to print in order table
  $cols = $numprop+1;
  if ($print_code) {
    $cols += 1;
  }


  #  11/25
  $grandtotal = $taxable_total + $nontax_total;

  # discount added 11/25
  $rows=5;

  # handling
  if ($handling_order || $handling_item || 
     ($handling_special && $total_item_hand > 0)) {
    $rows += 1;
  }  

  if ($tax_option && $tax_option ne "none") {
    $rows += 2;
  } elsif ($tax_option eq "none") {
    # do nothing
  } else {
    $rows += 1;
  }

  if ($discount) {
    &discount;
    if ($dis < 0) {
      $rows += 2;
    }
  }

  if ($shipping_cost eq "None") {
    $rows += -1;
  }
  
  if (%special_selections) {
    foreach $sk (keys %special_selections) {
      if ($post_query{$sk}) {
        ($ty, $mes, $addedcost) = split(/\|/,$special_selections{$sk});
        if ($addedcost > 0) {
          $special_cost += $addedcost;
        }
      }
    }
    if ($special_cost > 0) {
      $rows += 1;
    }
  }



  print "<tr valign=top align=left BGCOLOR=\"$Table_Body_Color\">\n";
  print "<td rowspan=$rows colspan=$cols>";

  if ($order_note) {
    print "<b>NOTE:</b><br>$order_note<p>";
  }
 
  if ($post_query{'comments'}) {
    print "<b>NOTE TO MERCHANT:</b><br>$post_query{'comments'}<p>";
  } 

  if ($post_query{'giftmessage'}) {
    print "<p><b>GIFT MESSAGE:</b><br>$post_query{'giftmessage'}<p>";
  }

  if (%special_selections) {
    foreach $sk (keys %special_selections) {
      if ($post_query{$sk}) {
        unless ($mess_head) {
          print "<b>SPECIAL SELECTIONS:</b><br>";
          $mess_head = 1;
        }
        ($ty, $sel_mess, $addedcost) =split(/\|/,$special_selections{$sk});
        print "$sel_mess<p>";
      }
    }
    print "<br>";
  } else {
    print "<br>";
  }  

  print "</td>";
  print "<th align=right colspan=2>Total</th>";
  if ($no_decimal) {
    printf "<td align=right>%5.0f", $grandtotal;
  } else {
  printf "<td align=right>%5.2f", $grandtotal;
  }
  print "</td></tr>";

  if ($discount && $dis < 0) {
    $grandtotal += $dis;
    $taxable_total += $dis;
    print "<tr>\n";
    print "<th align=right colspan=2>Discount</th>"; 
    if ($no_decimal) {
      printf "<td align=right>%5.0f", $dis;
    } else {
      printf "<td align=right>%5.2f", $dis;
    }
    print "</td></tr>";
 
    print "<tr BGCOLOR=\"$Table_Body_Color\">\n";
    print "<th align=right colspan=2>Total with Discount</th>";
    if ($no_decimal) {
      printf "<td align=right>%5.0f", $grandtotal;
    } else {
      printf "<td align=right>%5.2f", $grandtotal;
    }
    printf"<input type=hidden name=discount value=%6.2f></td></tr>\n", $dis;
  }

  $order_total = $grandtotal;
  
  # Only do if they have enter shipping information
  if ($action eq "billing" || $action eq "invoice") { 

    # conditional for taxes - where shipping is taxed or not
    if (!$tax_option) { 

      &taxes;

      print "<tr>";
      print "<th align=right colspan=2>Tax";
      print "</th>";
      if ($taxes) {
        if ($no_decimal) {
          printf "<td align=right>%5.0f", $taxes;
        } else {
          printf "<td align=right>%5.2f", $taxes;
        }
        print "</td></tr>";
      } else {
        print "<td align=center>----</td></tr>";
      }

    }


    # &shipping;
    if ($shipping_cost ne "none") { 
      ($ship_name,$shipping) = split(/-/,$post_query{'ship_cost'});
      print "<th align=right colspan=2>$ship_name ";
      if ($weight) {
        printf "<br>\(%3.1f $weight\)", $total_wt;
      }
      print "</th>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $shipping;
      } else {
        printf "<td align=right>%5.2f", $shipping;
      }
      print "</td></tr>";

    }
  
    if ($handling_order) {
      print "<tr><th align=right colspan=2>Handling Charges</th>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $handling_order;
      } else {
        printf "<td align=right>%5.2f", $handling_order;
      }
      print "</td></tr>";
      $handling = $handling_order;
    }

    if ($handling_item) {
      print "<tr><th align=right colspan=2>Handling Charges</th>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $handling_item*$num_items_ordered;
      } else {
        printf "<td align=right>%5.2f", $handling_item*$num_items_ordered;
      }
      print "</td></tr>";
      $handling = $handling_item*$num_items_ordered;
    }

    if ($handling_special && $total_item_hand > 0) {
      print "<tr><th align=right colspan=2>Handling Charges</th>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $total_item_hand;
      } else {
        printf "<td align=right>%5.2f", $total_item_hand;
      }
      print "</td></tr>";

      $handling = $total_item_hand;
    }

    # special selections
    if ($special_cost > 0) {
      printf "<tr><th align=right colspan=2>Special Selections</th>";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $special_cost;
      } else {
        printf "<td align=right>%5.2f", $special_cost;
      }
      print "</td></tr>";
    }

    $grandtotal = $grandtotal + $shipping + $taxes + $special_cost + $handling;

    # for including shipping and handling in taxes (California)
    if ($tax_option && $tax_option ne "none") {
 
      $taxable_total += $shipping + $special_cost + $handling;      
      &taxes;
      $grandtotal += $taxes;
 
      print "<tr BGCOLOR=\"$Table_Body_Color\">";
      print "<th align=right colspan=2>Sub Total</th>\n";
      if ($no_decimal) {
        printf "<td align=right>%5.0f", $taxable_total;
      } else {
        printf "<td align=right>%5.2f", $taxable_total;
      }
      print "</td></tr>";       

      print "<tr>";
      print "<th align=right colspan=2>Tax";
      #foreach $state (keys %statetaxes) {
      #  print "$state ";
      #}
      print "</th>";
      if ($taxes) {
        if ($no_decimal) {
          printf "<td align=right>%5.0f", $taxes;
        } else {
          printf "<td align=right>%5.2f", $taxes;
        }
        print "</td></tr>";
      } else {
        print "<td align=center>----</td></tr>";
      }
 
    }



    print "<tr BGCOLOR=\"$Table_Body_Color\">";
    print "<th align=right colspan=2>Grand Total</th>\n";
    if ($no_decimal) {
      printf "<td align=right>%5.0f", $grandtotal;
    } else {
      printf "<td align=right>%5.2f", $grandtotal;
    }
    printf "<input type=hidden name=\"Grand Total\" value=\"%6.2f\"></td></tr>\n", $grandtotal;

  } # end ship else

  print "</table></center>";

} else {
  print "You haven't ordered anything yet!\n";
  &return_page;
  exit;
}
print "<p>";
}
# End sub show
#----------------------------------------------------#

sub show_order2 {
# Prints change quantity, clear, and checkout form buttons

print qq(
<center>\n
<table><tr align=left><td>
<input type=hidden name=merchant value=$post_query{'merchant'}>\n
<INPUT TYPE=HIDDEN NAME="last" VALUE="view">
<INPUT TYPE=HIDDEN NAME="action" VALUE="recalc">
);

if ($page_name) {
  print "<input type=hidden name=page_name value=$page_name>\n";
}

if ($button_update) {
  print "<INPUT TYPE=IMAGE SRC=$button_update border=0>\n";
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Update Quantities\">\n";
}
print qq(
</FORM>\n
</td>

<td>
<FORM METHOD=POST ACTION=$script_url>\n
<input type=hidden name=merchant value=$post_query{'merchant'}>\n
<INPUT TYPE=HIDDEN NAME="action" VALUE="clear">
);

if ($page_name) {
  print "<input type=hidden name=page_name value=$page_name>\n";
}

if ($button_clear) {
  print "<INPUT TYPE=IMAGE SRC=$button_clear border=0>\n";
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Clear Order\">\n";
}

print qq(
</FORM>\n
</td>

<td align=left>
<FORM METHOD=POST ACTION=$script_url>\n
<input type=hidden name=merchant value=$post_query{'merchant'}>\n
<INPUT TYPE=HIDDEN NAME="action" VALUE="place">
);

if ($page_name) {
  print "<input type=hidden name=page_name value=$page_name>\n";
}

if ($button_check) {
  print "<INPUT TYPE=IMAGE SRC=$button_check border=0>\n";
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Check Out\">\n";
}

print qq(
</FORM>\n
</td><td>);
# Prints a link to last page visited if available

print qq(
<td align=left>
<FORM METHOD=GET ACTION=$page_name>\n
);

if ($button_shop) {
  print "<INPUT TYPE=IMAGE SRC=$button_shop border=0>\n";
} else {
  print "<INPUT TYPE=SUBMIT VALUE=\"Continue Shopping\">\n";
}

print qq(
</FORM>\n
</td>
</tr></table></center><p>\n
);

unless ($min_total && $order_total < $min_total) {
  &print_links; 
  &footer;
  exit;
}
}
# End sub show_order2
#----------------------------------------------------#


sub taxes {
# calculate taxes
foreach $st (keys %statetaxes) {
  if ($st eq $post_query{'state'} || $st eq $post_query{'country'}) {
    $taxes = $taxes + $statetaxes{$st} * $taxable_total;
  }
}
}
# end sub taxes
#----------------------------------------------------#





sub load_countries {
@countries=("Albania", "Algeria", "American Samoa", "Andorra", "Angola", 
"Anguilla", "Antigua \& Barbuda", "Argentina", "Aruba", "Australia", "Austria", 
"Azores", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", 
"Belgium", "Belize", "Benin", "Bermuda", "Bolivia", "Bonaire", 
"Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", 
"Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canary Islands",
"Canada", 
"Cape Verde", "Cayman Islands", "Central African Republic", "Chad", 
"Channel Islands", "Chile", "Colombia", "Congo", "Cook Islands", 
"Costa Rica", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", 
"Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", 
"Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", 
"Estonia", "Ethiopia", "Faeroe Islands", "Federated States of Micronesia", 
"Fiji", "Finland", "France", "French Guiana", "French Polynesia", 
"Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", 
"Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", 
"Guinea-Bissau", "Guyana", "Haiti", "Holland", "Honduras", "Hong Kong", 
"Hungary", "Iceland", "India", "Indonesia", "Israel", "Italy", 
"Ivory Coast", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", 
"Kiribati", "Kosrae", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", 
"Lebanon", "Lesotho", "Liberia", "Liechtenstein", "Lithuania", 
"Luxembourg", "Macau", "Macedonia", "Madagascar", "Madeira", "Malawi", 
"Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", 
"Mauritania", "Mauritius", "Mexico", "Moldova", "Monaco", "Montserrat", 
"Morocco", "Mozambique", "Myanmar", "Namibia", "Nepal", "Netherlands", 
"Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", 
"Niger", "Nigeria", "Norfolk Island", "Northern Ireland", 
"Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", 
"Panama", "Papua New Guinea", "Paraguay", "Peoples Republic of China", 
"Peru", "Philippines", "Poland", "Ponape", "Portugal", "Qatar", 
"Republic of Ireland", "Republic of Yemen", "Reunion", "Romania", 
"Rota", "Russia", "Rwanda", "Saba", "Saipan", "Saudi Arabia", 
"Scotland", "Senegal", "Seychelles", "Sierra Leone", "Singapore", 
"Slovakia", "Slovenia", "Solomon Islands", "South Africa", "South Korea", 
"Spain", "Sri Lanka", "St. Barthelemy", "St. Christopher", "St. Croix", 
"St. Eustatius", "St. John", "St. Kitts & Nevis", "St. Lucia", 
"St. Maarten", "St. Martin", "St. Thomas", "St. Vincent and the Grenadines",
"Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", 
"Tahiti", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Tinian", 
"Togo", "Tonga", "Tortola", "Trinidad &Tobago", "Truk", "Tunisia", 
"Turkey", "Turks & Caicos Islands", "Tuvalu", "Uganda", "Ukraine", 
"Union Island", "United Arab Emirates", "United Kingdom", "Uruguay", 
"US Virgin Islands", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", 
"Virgin Gorda", "Wake Island", "Wales", "Wallis & Futuna Islands", 
"Western Samoa", "Yap", "Zaire", "Zambia", "Zimbabwe");
}


# End load_countries


sub transfer_order {
# Routine to transfer order over to a different, secure server if
# required

open(NEW, ">$order_file") || &error("Couldnt open new file on secure server");
print NEW "$post_query{'order'}";
close(NEW);

if ($client) {
  open(CLIENT, "<$clientlist");
  while (<CLIENT>) {
    chop;
    ($cl,$em) = split(/\:/,$_);
    if ($cl eq $client) {
      $clientemail = $em;
      $found=1;
      last;
    }
  }
  close(CLIENT);

  if (!$found) {
    $clientemail = $post_query{'clientemail'};
    open(CLIENT, ">>$clientlist");
    print CLIENT "$client:$clientemail\n";
    close(CLIENT);
  }

}

}





sub formats {

# Define formats

format NDITEMWT =
@<<<<<<< @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< @###.# @#####   @### @#####
$current_code, $name,               $tweight,$price,$amount,$total
.

format NDITEMNOWT =
@<<<<<<< @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  @#####   @### @#####
$current_code, $name,		    		$price, $amount, $total
.

format NDTOTAL = 
                                                             Total @#####
$ordertotal
.

format NDGRANDTOTAL =
                                                       Grand Total @#####
$grandtotal
.

format NDTAX =
                                                         Sales Tax @#####
$taxes
.

format NDDISCOUNT =
                                                          Discount @#####
$dis
                                                         Sub-Total @#####
$ordertotal
.

format NDSHIPPING = 
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @#####
$ship_type,                                                     $shipping
.

format NDSHIPPING_WT = 
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @#####
$shipinfo, $shipping
. 


format NDDELIVERY =
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @#####
$post_query{'delivery'}, $delivery_method{$post_query{'delivery'}}
.
format NDHANDLING =
                                                   Handling Charges @#####
$handling_charges
.



format NDSPECIAL =
                                                 Special Selections @#####
$special_cost
.


format ITEMWT =
@<<<<<<< @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< @###.# @###.##  @### @###.##
$current_code, $name,               $tweight,$price,$amount,$total
.

format ITEMNOWT =
@<<<<<<< @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<  @###.##  @### @###.##
$current_code, $name,		    		$price, $amount, $total
.

format TOTAL = 
                                                             Total @###.##
$ordertotal
.

format GRANDTOTAL =
                                                       Grand Total @###.##
$grandtotal
.

format TAX =
                                                         Sales Tax @###.##
$taxes
.

format DISCOUNT =
                                                          Discount @###.##
$dis
                                                         Sub-Total @###.##
$ordertotal
.

format SHIPPING =
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @###.##
$ship_type,                                                      $shipping
.

format SHIPPING_WT = 
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @###.##
$shipinfo, $shipping
. 


format DELIVERY =
                                @>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> @###.##
$post_query{'delivery'}, $delivery_method{$post_query{'delivery'}}
.
format HANDLING =
                                                  Handling Charges @###.##
$handling_charges
.



format SPECIAL =
                                                Special Selections @###.##
$special_cost
.


}


sub download {

my @dl_files = @_;

# Subroutine to download files
# Three types of download: 
# $dl_type=1  Files immediately displayed for download
# $dl_type=2  Message mailed to customer automatically
# $dl_type=3  Message mailed to merchant for forwarding after payment processing                       


if ($dl_type == 1) {

  # Write file
  $download_list = $invoice_dir . "\\$session_id" . ".files";

  open (LIST, ">$download_list") || &error("Cant open $download_list");
  foreach $df (@dl_files) {
    print LIST "$df\n";
  }
  close(LIST);
  

  print "Set-Cookie: Download=$merchant_name\-$session_id; Expires=Mon, 01-Jan-99 2:00:00 GMT;path=/\n";
  print "Set-Cookie: ID=1; path=/\n";
  &header;
  print qq[
<h1>Order Received - Download Files</h1>
Your order has been received.  To download your files, click on the link(s)
below to download.  If you have any problems, contact 
<a href=mailto:$admin>$admin</a>.
<p>
Files to download:<br>
<ol>
  ];
  foreach $df (@dl_files) {
    print "<li><a href=$dl_url/$merchant_name\+$session_id\+$df>$df</a>";
  }
  print "</ol>";

} elsif ($dl_type == 2 || $dl_type == 3) {

  # Generate a random download number
  srand();
  $rnum = int(rand(20000));
  $num = $rnum . $session_id;
  $num =~ s/\.//g;
  $num =~ substr($num,0,8);

  # Write file
  $download_list = $invoice_dir . "\\$num" . ".files";
  

  open (LIST, ">$download_list") || &error("Cant open $download_list");
  foreach $df (@dl_files) {
    print LIST "$df\n";
  }
  close(LIST); 
 
  # Set Cookie
  print "Set-Cookie: ID=1; path=/\n";

  $tempmess = $invoice_dir . "\\$order_num" . "c.tmp";

  open(MAIL, ">$tempmess") || &error("Cant open $tempmess in sub download.");

  print MAIL qq[
Thank you for ordering from $company.  To retrieve your purchased files,
use your browser to go to $dl_page 
and enter your download authorization code.  

Your download authorization code is: $num

If you have any problems, please contact $recipient.

];
  close(MAIL);

  if ($dl_type == 2) {
    $sendto = $post_query{'email'};
  } else {
    $sendto = $recipient;
  }

  $mail="$mail_loc $tempmess \-t $sendto \-s Download -server $mail_server";
  system("$mail");

  # recorder ordernum and download number incase of problems
  open(DLOG, ">>$dl_log");
  print DLOG "$session_id:$num\n";
  close(DLOG);

  &header;
  print qq[
<h1>Thank You</h1>
Thank you for ordering from $company!  You will recieve your download authorization 
code by email shortly.  Go to <a href=$dl_page>$dl_page</a> and enter your 
code to retrieve your files.<p>
  ];
}

&print_links;
&footer;

unlink($tempmess);

exit;
}



sub referrer {

# Log the client referral info
$client_file = $home_dir . "\\Logs\\$post_query{'merchant'}.log";


if (-s $client_file) {
  open(CLIENT, "<$client_file") || &error("Couldn't open $client_file.");
  while(<CLIENT>) {
    chop;
    @orderinfo = split(/:/);
    $order{$orderinfo[1]} = $orderinfo[2];
  }
  close(CLIENT);
}

unless (exists($order{$order_num})) {
  open(CLIENT, ">>$client_file") || &error("Couldn't open $client_file.");
  print CLIENT "$client:$order_num:$mon\/$mday:$ordertotal:$grandtotal\n";
  close(CLIENT);
}

if ($sendclient && -s $clientlist) {

  open(REF, "<$clientlist") || &error("Cant open $clientlist file.");
  while(<REF>) {
    chop;
    ($ref,$remail) = split(/:/);
    if ($ref eq $client) {
      $rfound = 1;
      last;
    }
  }
  close(REF);

  if ($rfound) {

    $mail_temp = $home_dir . "\\Orders\\$order_num" . ".dat";

    open(MAILREF, ">$mail_temp") || &error("Cant open $mail_temp in sub send.");
    print MAILREF "Order received by $company through your referral link.\n";
    print MAILREF "Date: $mon\/$mday\n";
    print MAILREF "Order: $order_num\n";
    print MAILREF "Total: $ordertotal\n";
    print MAILREF "Grand Total (including handling,shipping,taxes, etc.): $grandtotal\n";
    close(MAILREF);
    $mail4="$mail_loc $mail_temp \-t $recipient \-s Referral -server $mail_server";
    system("$mail4");
 
  }
}


}


sub online_check {

print qq[
<input type=radio name=cardtype value=onlinecheck><b>Online Check</b><br>
To electronically debit your checking account, put in all the numbers at
the bottom of your check below.  Please note: all numbers on the bottom of 
your check must be entered in the order they appear from left to right.

            9 Digit ABA\#:<input name=ocABA size=10 maxsize=9>
               Account \#:<input name=ocAccount size=20 maxsize=20>
                 Check \#:<input name=ocCheckNo size=10 maxsize=10>
	       Bank Name:<input name=ocBank size=20 maxsize=20>
          Street Address:<input name=ocBankAddress size=20 maxsize=60>
                    City:<input name=ocBankCity size=20 maxsize=60>
                   State:<input name=ocBankState size=20 maxsize=60>
                     Zip:<input name=ocBankZip size=10 maxsize=12>
            Branch Phone:<input name=ocBankPhone size=20 maxsize=20>

];

}

sub online_check_init {
%online = (
  "ocABA" => "ABA \#",
  "ocAccount" => "Account \#",
  "ocCheckNo" => "Check Number",
  "ocBank" => "Bank Name",
  "ocBankAddress" => "Bank Address",
  "ocBankCity" => "Bank City",
  "ocBankState" => "Bank State",
  "ocBankZip" => "Bank Zip",
  "ocBankPhone" => "Bank Phone",
  );
@online = ("ocABA","ocAccount","ocCheckNo","ocBank","ocBankAddress","ocBankCity",
 "ocBankState","ocBankZip","ocBankPhone");

}

sub online_check_info {

foreach $key (keys %online) {
  if (!$post_query{$key}) {
    $missing_oc = 1;
  }
}

if ($missing_oc) {
  print qq[
<h1>Missing Info</h1>
To pay by Online Check, please use the back button and fill out all 
of the form fields for Online Check.<p>
];
  &print_links;
  &footer;
  exit;
}

}



# END OF CYBERCART IP PRO
