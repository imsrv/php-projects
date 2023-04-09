print "HTTP/1.0 200 OK\n";
#
#
# CyberCart Pro Internet Commerce System, Version 3.04
# Copyright 1997, Richard Torzynski
# 1-25-98
# All rights reserved
# This is NOT a shareware script.
#
# support@cybercart.com
# http://www.cybercart.com/

# License Agreement
# You should carefully read the following terms and conditions
# before using this script.  Unless you have a different license
# agreement signed by Rick Torzynski your use of this software
# indicates your acceptance of this license agreement and warranty.
#
# Multi-merchant Version
# One copy of the CyberCart IP Pro scripts may either
# be used by a single person or business, located on a single web server.
# Copies of this script may not be resold, leased, or distributed without
# the expressed written consent and approval of RT Web Design &
# Consulting.
#
# Disclaimer of Warranty
# THESE SCRIPTS AND THE ACCOMPANYING FILES ARE SOLD "AS IS" AND
# WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY
# OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.  The user must
# assume the entire risk of using the program.  ANY LIABILITY OF
# THE SELLER WILL BE LIMITED EXCLUSIVELY TO PRODUCT REPLACEMENT OR
# REFUND OF PURCHASE PRICE.

#Define File Locations and Directories
#-------------------------------------------------------

# Home directory for Merchant files
$home_dir = "c:\\Merchant\\";


# Script URL
$script_url = "http://www.name.com/cgi-bin/getorder.pl";

# File to store userid and password of Cybercart Users
# This file must be created using passwords encoded using the crypt function.
$user_file = $home_dir . "ccusers.dat";


# File used to verify users logged in properly
$current = $home_dir . "current.dat";

# Summary script for clients to check their order totals
$summary_url = "http://www.name.com/summary.pl";

# Number of cols for editing merchant files
$cols = 80;

# Number of rows for editing merchant files
$rows = 15;

$merchant_help = "http://www.cybercart.com/instruct.htm";

#--------------------------------------------------------


&decode2;

$action = $post_query{'action'};
%cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});

#&header;
#&debug;
#exit;

if ($action eq "logon") {
  &logon;
  &header;
  %cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});
} else {
  &header;
  &verify;
  %cookies = split('[;=] *',$ENV{'HTTP_COOKIE'});
}

$status_file = $home_dir . $userid . "\\status.dat";
$log_file = $home_dir . $userid . "\\Logs\\$userid.log";
$referrer_list = $home_dir . $userid . "\\referrer.dat";


$ENV{'PATH_INFO'} =~ s/\/scripts\/getordernt.pl//g;
if ($ENV{'PATH_INFO'}) {
  &show_order;
  exit;
}

if ($action eq "delete") {
  &delete;
} elsif ($action eq "list") {
  &list;
} elsif ($action eq "changestatus") {
  &changestatus;
} elsif ($action eq "summary") {
  &summary;
} elsif ($action eq "itemlog") {
  &itemlog;
} elsif ($action eq "add_ref_form") {
  &add_referrer_form;
} elsif ($action eq "add_referrer") {
  &add_referrer;
} else {
  &menu;
}

exit;
# end main



sub summary {

$numorders = 0;


print qq[
<center>
<h1>Orders For $userid</h1>
</center>
];

open(LOG, "<$log_file") || &error("Can't open $log_file.  Check to
make sure logging features in CyberCart script are properly set.");
while (<LOG>) {
chop;
  (@order) = split(/:/,$_);

  if (exists($orderexist{$order[1]})) {
      # do nothing
  } else {
    
    $orderexist{$order[1]} = 1; 
    $count += 1;
      
    if ($count < 10) { 
      $count = "000" . $count;
    } elsif ($count < 100) {
      $count = "00" . $count;
    } elsif ($count < 1000) {
      $count = "000" . $count;
    }  
    

    $orderlist{$count} ="<td align=left>$order[0]</td><td align=left><a href=$script_url/$order[1]\.order>$order[1]</a></td><td>$order[2]</td>";

    $orderdate{$count} = $order[2];


    $orderamount{$count} = $order[3];
    $orderclient{$order[0]} += $order[3];

    # Add order to total
    $order_total{$count} = $order[3];
    $order_grand{$count} = $order[4];
    $order_total_client{$order[0]} += $order[3];
    $order_grand_client{$order[0]} += $order[4];

    $total_amount += $order[3];
    $grand_total += $order[4];
  }
}

if ($count == 0) {
  print qq[
There were no orders for merchant $userid.  If you think there is an
error, please contact <a href="mailto:$Admin">$Admin</a>.
];
} else {
 if (-s $referrer_list) {
  open(REF, "<$referrer_list") || &error("Cant open referrer_list at $referrer_list");
  while(<REF>) {
    chop;
    ($cn,$em,$pw) = split(/:/);
    $clientemail{$cn} = $em;
    $clientpass{$cn} = $pw;
  }
 }

foreach $client (sort keys %orderclient) {
if ($clientemail{$client}) {
  print qq[
  <font size=+2>Referrer $client</font>
  (<a href=mailto:$clientemail{$client}>$clientemail{$client}</a>)
  <p>
  ];
} else {
  print qq[
  <font size=+2>Referrer $client </font>
  ];
}
print qq[
<table width=450>
<tr align=right>
<th width=150><br></th>
<th align=left width=100>Order Number</th><th width=100>Date</th><th
width=100>Net</th><th width=100>Gross</th>
</tr>
<tr><td colspan=5><hr></td></tr>
];

@sorteddate = sort { $orderdate{$a} cmp $orderdate{$b} } keys(%orderdate);

# foreach $key (sort keys %orderlist) {
foreach $key (@sorteddate) {
  if ($orderlist{$key} =~ m/$client/) {
    print "<tr align=right>";
    printf "$orderlist{$key}<td align=right>\$%5.2f</td>\n",$order_total{$key};
    printf "<td align=right>\$%5.2f</td>\n", $order_grand{$key};
    print "</tr>";
  }
}
print "<tr><td colspan=5><hr></td></tr>";
if ($clientpass{$client}) {
  $sum_url = "$summary_url/$userid\+$client\+$clientpass{$client}";
} else {
  $sum_url = "$summary_url/$userid\+$client";
}
print "<tr><td colspan=3><a href=$sum_url>Show report for $client ONLY</a></td>";
printf "<th align=right>\$%5.2f</th>", $order_total_client{$client};
printf "<th align=right>\$%5.2f</th>", $order_grand_client{$client};
print "</table><p>";
}

}

printf "<font size=+2>Net for $userid: \$%5.2f</font><p>",
$total_amount;
printf "<font size=+2>Grand Total for $userid: \$%5.2f</font><p>",
$grand_total;

print "<p><a href=$script_url>Return to Main Menu</a><p>";

&footer;
exit;
}
# ------------------------------------------------------------------


sub changestatus {
$status_new = $status_file . "\.temp";

$order_num = $post_query{'order'};
open(OLDSTATUS, "<$status_file");
open(NEWSTATUS, ">$status_new");
while (<OLDSTATUS>) {
  if ($_ =~ m/$order_num/) {
    ($ordern,$name,$date_received,$order_status) = split(/::/);
    $newstat = $ordern . "::" . "$name" . "::" . "$date_received" . "::" .
"$post_query{'status'}\n";
    print (NEWSTATUS "$newstat");
  } else {
    print (NEWSTATUS "$_");
  }
}
close(OLDSTATUS);
close(NEWSTATUS);

open(OLD, ">$status_file");
open(NEW, "<$status_new");
while(<NEW>) {
  print OLD "$_";
}
close(NEW);
close(OLD);

if ($post_query{'last'} eq "list") {
  &list;
} else {
  &show_order;
}
}
# End sub changestatus
#--------------------------------------------------------------------

sub debug {
foreach $key (keys %cookies) {
  print "$key = $cookies{$key}<br>";
}
foreach $key (keys %post_query) {
  print "$key = $post_query{$key}<br>";
}
}
# End sub debug
#-----------------------------------------------------------

# New, more secure decoding routine from Matt's Script Archive Programs
sub decode2 {
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


sub delete {
$del_order = $home_dir . $userid . "\\Data\\" . "$post_query{'order'}\.order";
$del_items = $home_dir . $userid . "\\Data\\" . "$post_query{'order'}\.temp";

if (-s $del_order) {
  unlink($del_order) || &error("Couldn't delete $del_order");
}
if (-s $del_items) {
  unlink($del_items) || &error("Couldn't delete $del_items");
}
&list;
}
# End sub delete
#-----------------------------------------------------------

sub error {
local($error_message) = @_;
# Print message indicating that there is an error
if (!$header) {
  # print header if one hasn't been printed
  &header;
}
print "<h1>CyberCart Error</h1>\n";
print "$error_message<br>";
&footer;
exit;
}
# End sub error
#-----------------------------------------------------

sub footer {

print qq(
<p>
<h5>
<hr width=580 align=left>
CyberCart IP Pro, Copyright 1996 RT Web Design &amp Consulting<br>
</body>
</html>
);
}
# End sub footer
#-----------------------------------------------------------------


sub get_status {
$order_number = $_[0];

open(STATUS, "$status_file");
while (<STATUS>) {
  if ($_ =~ m/$order_number/i) {
    ($ordern,$name,$date_received,$order_status) = split(/::/);
    $of = 1;
    last;
  }
}
if (!$of) {
  $order_status = "Unknown";
}
$of = 0;
return ($order_status,$date_received,$name);
}
# sub get_status
#-------------------------------------------------------------

sub header {
print "Content-type: text/html\n\n";
print "<html>";
$header=1;
}
# End sub header
#------------------------------------------------------

sub list {
#list files
$user_dir = $home_dir . $userid . "\\Data";
opendir ORDERS, $user_dir;
@orders = readdir ORDERS;

foreach $filename (@orders) {
  my $tempname = $user_dir . "/$filename";
  $fileage = -M $tempname;
  $orderage{$filename} = $fileage;
}
@sortedage = sort {$orderage{$a} <=> $orderage{$b} } keys(%orderage);


print qq(
<head>
<script language="JavaScript">
  function confirmDelete(formObj) {
    var deleteStr = "Are you sure you wish to delete order " + formObj.order.value + "?"
    return confirm(deleteStr);
  }

  function GetStatus (formObj) {
    var promptStr = "Change status of order \#" + formObj.order.value + " to:"
    ans = prompt(promptStr,"");
    if (ans == null || ans.length == 0) return false;
    else {
    formObj.status.value = ans;
    return true;
    }
  }
</script>
</head>);

print "<body bgcolor=ffffff>";
print "<table cellspacing=0 cellpadding=10 border=1 bgcolor=C9CFF8 width=580>"; 
print "<tr><td align=center valign=top colspan=6>";
print "<h2>Current Orders for $userid</h2>";
print "</td></tr>";
print "<tr align=left><th>Order</th><th>Name</th>";
print "<th>Received</th><th>Status</th><th colspan=2 align=center>Order
Options</th>"; 
print "</tr>\n"; 
#foreach $a (@orders) {
foreach $a (@sortedage) {
 if ($a !~ m/log/ && $a !~ m/^\./ && $a =~ m/\.order/) {
 ($odn,$gar) = split(/\./,$a);
 ($status, $date_rec, $nm) = &get_status($odn);
 if (!$nm) {$nm = "<br>"; }
 print "<tr bgcolor=FFFFE1><td>";
 
 # This line may need to be changed depending on how path info is sent.
 # The info in $a should be passed as path info
 print "<a href=\"$script_url/$a\">$odn</a>\n";

 print "</td><td align=left>$nm</td>";
 print "<td align=center>$date_rec</td><td>$status</td>";
 print qq(
<td><form method=POST action=$script_url onSubmit="return GetStatus(this)">
<input type=hidden name=order value=$odn>
<input type=hidden name=status value="">
<input type=hidden name=action value=changestatus>
<input type=hidden name=last value=list>
<input type=submit value="Status">
</form>
</td><td>
<form method=POST
action="$script_url"
onSubmit="return confirmDelete(this)">
<input type=hidden name=action value=delete>
<input type=hidden name=order value=$odn>
<input type=submit value="Delete">
</form>
</td>
</tr>);
}
}
print qq(
<tr><td bgcolor=C9CFF8 align=center colspan=6>
<form method=post action=$script_url>
<input type=hidden name=action value=menu>
<input type=submit value="Return to Main Menu">
);
print "</table><br>\n";
&footer;
exit;
}
# End sub list
#----------------------------------------------------------


sub list_button {
print qq(
<form method=POST
action="$script_url">
<input type=hidden name=action value=list>
<input type=submit value="List Orders">
</form>
);
}
# End sub list_button
#----------------------------------------------------------
sub logon {

 open(DATA, "$user_file");
 while (<DATA>) {
  chop;
  ($u,$p) = split(/:/,$_);
  
  if ($post_query{'user'} =~ m/$u/) {
    if (crypt($post_query{'pwd'}, $p) eq $p) {
      # ok
      $useridnum = $post_query{'user'} . "_" . $$;
      print "Set-Cookie: USER=$useridnum; \r\n";
      # put process id in file - add lock later
      open(VERIFY, ">>$current");
      $info = $post_query{'user'} . "_" . $$;
      print (VERIFY "$info\n");
      close(VERIFY);
      $cookies{'USER'} = $post_query{'user'};
      $cookies{'SESSION'} = $$;
      $found = 1;
      $userid = $post_query{'user'};
      last;
    } else {
      &header;
      print "User password invalid.\n";
      print "</body></html>";
      exit;
    }
  }
 }
 if (!$found) {
  &header;
  print "User name not found.\n";
  print "</body></html>";
  exit;
 }


}
# End sub logon
#----------------------------------------------------------------

sub menu {
print qq(
<body bgcolor=ffffff>
<table cellpadding=10 cellspacing=0 border=1 bgcolor=C9CFF8 width=580>
<tr><td colspan=2 valign=top align=center>
<h2>Administrative Account for $userid</h2></td></tr> 
<tr><td valign=top>
<form method=POST 
action="$script_url">
Please select action:</td>
<td bgcolor=ffffe1 valign=top>
<select name=action>
);

print qq(
<option value=list>List Current Orders
<option value=summary>Summary of Orders
<option value=itemlog>Item Log
<option value=add_ref_form>Add Referrer
);

print qq(
</select>
<input type=submit value="Submit">
</form>
</td></tr></table>
);
&footer;
}
# End sub menu
#---------------------------------------------------------


sub show_order {
if ($ENV{'PATH_INFO'}) {
  $cur_order = $home_dir . $userid . "/Data" . $ENV{'PATH_INFO'};
  ($order_num,$gar) = split(/\./,$ENV{'PATH_INFO'});
  $order_num =~ s/\///;
} else {
  $cur_order = $home_dir . $userid . "\\Data\\" . $order_num . "\.order";
}
($status, $date_rec, $nm) = &get_status($order_num);
chop ($status);
open (ORDER, "$cur_order") || print "Cant open $cur_order!";
print qq(
<head><title>Order $ENV{'PATH_INFO'}</title>
<SCRIPT LANGUAGE="JavaScript">
<!--
  function confirmDelete() {
    return confirm('Are you sure you wish to Delete this order?');
  }
  function changeStatus() {
    change = window.open("","change","width=450,height=175")
    change.document.write("<html><body bgcolor=ffffff>")
    change.document.write("Order Number: $order_num<br>")
    change.document.write("Current Status: $status<br>")
    change.document.write("<form method=POST action='$script_url';onSubmit='window.close()'; target='_parent'>")
    change.document.write("Change Status To: ")
    change.document.write("<input type=text name=newstatus size=40 maxsize=100>")
    change.document.write("<input type=hidden name=action value='changestatus'>") 
    change.document.write("<input type=hidden name=order value=$order_num>")
    change.document.write("<center>")
    change.document.write("<br><input type=submit value='Change Status'>")
    change.document.write("</center>")
    change.document.write("</form></body></html>")
  }

  function GetStatus (formObj) {
    var order = $order_num
    var promptStr = "Change status of order \#" + order + " to:"
    ans = prompt(promptStr,"");
    if (ans == null || ans.length == 0) return false;
    else {
    formObj.status.value = ans;
    return true;
    }
  }
// end hiding -->
</SCRIPT>
</HEAD>
<Body bgcolor=ffffff>
);

print qq(
<table cellpadding=10 cellspacing=0 border=1 bgcolor=C9CFF8>
<tr><td colspan=3 align=center>
<h2>Order Number $order_num</h2>
</td></tr>
<tr><td colspan=3 bgcolor=ffffe1>
<pre>
Current Status: $status
);

#print "<pre>\n";
while (<ORDER>) {
  print "$_";
}
print "</pre>\n";
close(ORDER);
print qq(
</td></tr>
<tr align=center valign=center><td>
<form method=POST action=$script_url onSubmit="return GetStatus(this)">
<input type=hidden name=status value="">
<input type=hidden name=order value="$order_num">
<input type=hidden name=action value=changestatus>
<input type=submit value="Change Status">
</form>
</td><td>
<form method=POST
action="$script_url"
onSubmit="return confirmDelete()">
<input type=hidden name=action value=delete>
<input type=hidden name=order value="$order_num">
<input type=submit value="Delete Order">
</form>
</td>
<td>
<form method=POST
action="$script_url">
<input type=hidden name=action value=list>
<input type=submit value="List Orders">
</form>
</td></tr>
</table>
);

 exit;
}
# End sub show_order
#----------------------------------------------------------------

sub verify {

open(CUR, "$current");
while (<CUR>) {
  chop;
  if ($_ eq $cookies{'USER'}) {
    $verified = 1;
    ($userid,$gar) = split(/_/,$cookies{'USER'});
    last;
  }
}
if (!$verified) {
  print "User not verified!";
  exit;
}
}
# End sub verify
#------------------------------------------------------

sub itemlog {
 $logfile = $home_dir . "$userid\\Logs\\item.log";
  open(LOGFILE, $logfile) || &error("cant open $logfile!");
  while(<LOGFILE>) {
    ($code, $amount, $total) = split(/\|/, $_);
    $ittot{$code} += $total;
    $ittotal += $total;
    $itcount{$code} += $amount;
  }
  print "<CENTER><H1>Item Ordering</H1></CENTER>\n";
  print "<TABLE BORDER=0 WIDTH=600>\n";
  print "<TR><TH ALIGN=CENTER VALIGN=TOP WIDTH=25>\#</TH>";
  print "<TH ALIGN=LEFT WIDTH=75>Code</TH>";
  print "<TH ALIGN=LEFT WIDTH=150>Name</TH>";
  print "<TH ALIGN=LEFT WIDTH=75>Prop1</TH>";
  print "<TH ALIGN=LEFT WIDTH=75>Prop2</TH>";
  print "<TH ALIGN=LEFT WIDTH=75>Prop3</TH>";
  print "<TH ALIGN=RIGHT WIDTH=50>Total</TH>\n";
  print "<TR><TD COLSPAN=7><HR></TD></TR>\n";
  #sort by number of hits
   sub numerically {$itcount{$b}<=>$itcount{$a};}  

  # @words3 = keys %itcount;
  @sorted_list3 = sort numerically keys(%itcount);

  #loop through sorted list
  # foreach $target (keys %itcount) {
  foreach $target (@sorted_list3) {  
    if ($itcount{$target} > 0) {
      ($code,$name,$prop1,$prop2,$prop3) = split(/:/,$target);
      printf ("<TR><TD ALIGN=CENTER>%d</TD><TD ALIGN=LEFT>%s</TD>",
      $itcount{$target}, $code);
      # printf ("<TD ALIGN=LEFT>%s</TD></TR>\n", $iname{$code});
      print "<TD ALIGN=LEFT>$name<BR></TD>\n";
      print "<TD ALIGN=LEFT>$prop1<BR></TD>\n";
      print "<TD ALIGN=LEFT>$prop2<BR></TD>\n";
      print "<TD ALIGN=LEFT>$prop3<BR></TD>\n";
      printf ("<TD ALIGN=RIGHT>\$%5.2f</TD><TR>\n", $ittot{$target});
    }
  }
  print "<TR><TD COLSPAN=7><HR></TD></TR>\n";
  printf "<TR><TD COLSPAN=7 ALIGN=RIGHT>\$%5.2f</TD></TR>\n", $ittotal;
  print "</TABLE>";
  print "<p><a href=$script_url>Return to Main Menu</a><p>";
  print "</BODY></HTML>\n";
}     


sub add_referrer_form {

print qq[
<h1>Add Referrer</h1>
Enter the referrer's id, email address, and password (not required).  These 
will be added to the referrer_list at $referrer_list.<p>
<form method=$post action=$script_url>
<input type=hidden name=merchant>
<input type=hidden name=action value=add_referrer>
<table>
<tr valign=top>
  <th align=right>Referrer ID (no spaces):</th>
  <td align=left><input type=text name=ref_name size=20 maxsize=20></td>
</tr>
<tr align=right valign=top>
  <th align=right>Email Address:</th>
  <td align=left><input type=text name=ref_email size=40 maxsize=80></td>
</tr>
<tr align=right valign=top>
  <th align=right>Password (optional):</th>
  <td align=left><input type=text name=ref_pass size=40 maxsize=10></td>
</tr>
</table>
<input type=submit value="Add Referrer">
</form>
<p>
<a href=$script_url>Return to Main Menu</a>
];
&footer;
exit;
}

sub add_referrer {
if (-s $referrer_list) {
open(REF, "<$referrer_list") || &error("Cant open referrer_list at $referrer_list");
while(<REF>) {
  chop;
  ($rn,$rm,$rp) = split(/:/);
  if ($post_query{'ref_name'} eq $rn) {
    $found = 1;
    last;
  } 
}
close(REF);
}

if ($found) {
  print qq[
<h1>Referrer Name Found</h1>
The referrer name $post_query{'ref_name'} is already in the referrer_list.<br>
The values for the current referrer $post_query{'ref_name'} are:<br>
Referrer ID: $rn<br>
Email Address: $rm<br>
Password: $rp<p>
Please use the back button and choose another Referrer ID.
<p><a href=$script_url>Return to Main Menu</a><p>
];

  &footer;
} else {
  open(REF, ">>$referrer_list") || &error("Cant open referrer_list at $referrer_list");
  print REF "$post_query{'ref_name'}:$post_query{'ref_email'}";
  if ($post_query{'ref_pass'}) {
    print REF ":$post_query{'ref_pass'}";
  }
  print REF "\n";
  close(REF);
  print qq[
  <h1>Referrer Added</h1>
  The referrer $post_query{'ref_name'} has been added to $referrer_list.<p>
  <a href=$script_url>Return to Main Menu</a><p>
  ];
  &footer;
} 
exit;
}
