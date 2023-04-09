print "HTTP/1.0 200 OK\n";
#
#
# CyberCart Pro Internet Commerce System, Version 3.04
# Copyright 1997, Richard Torzynski
# 1-25-98
# All rights reserved
# This is NOT a shareware script.
#
# CyberCart Referrer Summary Script
# Script to give merchants and referrers a summary of their orders
#
############################################################### 
#
# Script setup variables:
#
# Location of merchant file directories
$merchant_dir = "C:\\Merchant\\";

# Email address of CyberCart Administrator
$Admin = "userid\@name.com";

# Mail program location
$mail_loc = "c:\\blat\\blat.exe";

# Mail server
$mail_server = "mail.name.com";

# URL of this script
$script_url = "http://www.name.com/cgi-bin/summary.pl";
#
#
###############################################################


&decode;

($merchant, $client, $passnum) = split(/\:/,$ENV{'PATH_INFO'});

$merchant =~ s/[\w\_\\\/\:]*summary.pl//;
$merchant =~ s/\///;


$referrer_dir = $merchant_dir . "$merchant";
$referrer_list = $referrer_dir . "\\referrer.dat";

print "Content-type: text/html\n\n";

open(REF, "<$referrer_list") || print "Couldn't open $referrer_list.";
while(<REF>) {
  chop;
  ($ref_name,$ref_email,$ref_passnum) = split(/:/);
  if ($ref_passnum && $passnum eq "sendpass") {
    if ($ref_name eq $client) {
      $found = 1;
      last;
    }
  } elsif ($ref_passnum) {
    if ($ref_name eq $client && $ref_passnum eq $passnum) {
      $found = 1;
      last;
    } 
  } elsif ($ref_name eq $client) {
      $found = 1;
      last;
  }
}
close(REF);


if ($passnum eq "sendpass") {
  $temp_pass = $merchant_dir . "$merchant\\Orders\\$ref_name" . ".tmp";
  open(MAIL, ">$temp_pass") || print("Cant open $temp_pass in sub send.");
  print MAIL "Your Referrer passnum is $ref_passnum.  To get a summary of orders\n";
  print MAIL "referred to $merchant, use the following URL:\n";
  print MAIL $script_url . "/$merchant\:$client\:$ref_passnum";
  close(MAIL);

  $mailpass = "$mail_loc $temp_pass \-t $ref_email \-s Referrer -server $mail_server";
  system("$mailpass");
 
  print "<html><body><h1>Password Sent</h1>";
 
  print "command: $mailpass<br>";

  print "Your referrer password has been sent by email to you.";
  print "</body></html>";
 
  unlink($temp_pass);

  exit;
}

if (!$found) {

  $send_url = $script_url . "/$merchant\:$client\:sendpass";

  print qq[<html>
<body bgcolor=ffffff>
<h1>Referrer Name Not Found</h1>
The referrer name and/or password is incorrect.  Please contact 
<a href=mailto:$Admin>$Admin</a> if this is an error.<p>
If you've forgotten your referrer password,  
<a href=$send_url>email password<a/>.
</body>
</html>
  ];
  exit;
}

&header;

if (!$merchant || !$client) {
  print qq[
<h1>Error</h1>
No merchant or client id specified.  To get a summary of your orders, make sure you add the merchant id and client id to the cgi call:<p>
&lt;$script_url/MerchantID+Client &gt;
<p>
];
  &footer;    
  exit;
} 

$numorders = 0;
$merchant_log = $merchant_dir . "/$merchant/Logs/$merchant.log";

print qq[
<h1>Summary for Referrer $client</h1>
];

open(LOG, "<$merchant_log") || print "Can't open $merchant_log";
while (<LOG>) {
  (@order) = split(/:/,$_);
  if ($order[0] =~ m/$client/i) {

    if (exists($orderexist{$order[1]})) {
      # do nothing
    } else {
      $orderexist{$order[1]} = 1; 
      $count += 1;
      if ($count < 10) { 
        $count = "00" . $count;
      } elsif ($count < 100) {
        $count = "0" . $count;
      }
      $orderdate{$count} = $order[2];
      $orderlist{$count} ="<td align=left>$order[1]</td><td>$order[2]</td>";
      # Add order to total
      $order_total{$count} = $order[3];
      $total_amount += $order[3];

      $order_grand{$count} = $order[4];
      $grand_total += $order[4];

    }
  }
}

if ($count == 0) {
  print qq[
There were no orders for client $client.  If you think there is an
error, please contact <a href="mailto:$Admin">$Admin</a>.
];
} else {
@sortedcount = sort {$orderdate{$a} cmp $orderdate{$b} } keys(%orderdate);



print qq[
<table width=350>
<tr align=right>
<th align=left>Order Number</th><th>Date</th><th>Net</th><th>Gross</th>
</tr>
<tr><td colspan=4><hr></td></tr>
];

# foreach $key (sort keys %orderlist) {
foreach $key (@sortedcount) {
  print "<tr align=right>";
  printf "$orderlist{$key}<td align=right>\$%5.2f</td>\n",$order_total{$key};
  printf "<td align=right>\$%5.2f</td>\n", $order_grand{$key};
  print "</tr>";
}
print "<tr><td colspan=4><hr></td></tr>\n";
printf "<tr><th colspan=3 align=right>\$%5.2f</th>\n", $total_amount;
printf "<th align=right>\$%5.2f</th>\n", $grand_total;
print "</tr>\n";
print "</table>\n";
}
&footer;
exit;

# ------------------------------------------------------------------





sub header {
print qq[
<html>
<head>
<title>Client Summary</title>
</head>
<body bgcolor=fffffff>
];
}

sub footer {
print qq[
</body>
</html>
];
}


# New, more secure decoding routine from Matt's Script Archive Programs
sub decode {
if ($ENV{'REQUEST_METHOD'} eq 'GET') {
  @pairs = split(/&/, $ENV{'QUERY_STRING'});
} elsif ($ENV{'REQUEST_METHOD'} eq 'POST') {
  read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
  @pairs = split(/&/, $buffer);
}

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



