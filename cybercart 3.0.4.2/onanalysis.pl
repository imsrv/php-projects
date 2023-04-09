# CyberCart module for incorporating Onanalysis realtime credit card 
# processing.

sub run_transaction{

if ($post_query{exp_year} eq "---" || $post_query{exp_month} eq "---") {
  &header;
  &error("Invalid expiration date given");
  exit;
}


$grandtotal = $post_query{'Grand Total'};
$expdate = $post_query{exp_month}.(substr($post_query{exp_year}, 2, 2));	
$command = "$socklink www2.onanalysis.com 443 $oa_ref $vendor_id $oa_password $transaction_type $post_query{CCN} $post_query{zip} $expdate $grandtotal \"comment1\" \"comment2\" |";
$command =~ m/([\w\.\_\|\" \_\/\-]*)/;
$command = $1;

#&header;
#print "Command2 = $command";
#exit;

open (RESULTS, "$command");

  $status=<RESULTS>;
  chomp($status);
    
  $socketlink_reference_number=<RESULTS>;
  chomp($socketlink_reference_number);

  $processor_reference_number=<RESULTS>;
  chomp($processor_reference_number);

close RESULTS;

} ###  <-- end of subroutine


sub print_results{

$oa_log = "$session_id:$socketlink_reference_number:$status:$processor_reference_number:$transaction_type:$post_query{'grandtotal'}\n";
&oa_log;

if ($status ne "0") {
  &header;
  &oa_error("The charge was denied.  Return value: $status");
  exit;
} else {

  if ($transaction_type eq "C6") {
    $trans_type = "Authorization Only";
  } elsif ($transaction_type eq "C7") {
    $trans_type = "Manual Transaction";
  } elsif ($transaction_type eq "C1") {
    $trans_type = "Authorization and Capture";
  }


  $success = "Your credit card has been processed successfully.";


}
}

sub oa_log {

open(OALOG, ">>$oa_log_file") || &error("Cant open oa log at $oa_log_file!");
print OALOG "$oa_log";
close(OALOG);

}




sub oa_error {

print <<"EOM";

<CENTER>
<H2> @_ </H2>
</CENTER>
<br><br>
$transaction_error_message
EOM

if ( $status ) 
	{ print "The transaction returned the following result code:
<b>$status</b>"; 
	  print "<br><br>";}
	  
if ( $socketlink_reference_number ) 
	{ print "SocketLink Transaction ID number:
<B>$socketlink_reference_number</B>"; 
	  print "<br><br>";}
	  
if ( $processor_reference_number ) 
	{ print "Processor response data:
<B>$processor_reference_number</B>"; 
	  print "<br><br>";}
	  
print <<"EOM2";

Please review your input, go back and try again.
<CENTER>
<br><br>
<TABLE BORDER=1>
	<TR><TD>trans type:			</TD><TD>
<B>Authorization
($transaction_type)</B>	</TD></TR>
	<TR><TD>ccnum:				</TD><TD>
<B>$post_query{'CCN'}</B>		</TD></TR>
	<TR><TD>zip:				</TD><TD>
<B>$post_query{zip}</B>		</TD></TR>
	<TR><TD>expiration month:	</TD><TD>
<B>$post_query{exp_month}</B>	</TD></TR>
	<TR><TD>expiration year:	</TD><TD>
<B>$post_query{exp_year}</B>	</TD></TR>
	<TR><TD>amt:				</TD><TD>
<B>$grandtotal</B>		</TD></TR>
</TABLE>
</CENTER>

</BODY>
</HTML>
EOM2

} ###  <-- end of subroutine

1;
