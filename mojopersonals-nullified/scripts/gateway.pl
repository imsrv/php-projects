############################################################
sub Upgrade{
	my($template);
	&MemberValidateSession;
	&PrintUpgrade unless $FORM{account};
	$MEMBER{account} = $FORM{account};
	&Gateway($TEMPLATE{payment});
}
############################################################
sub PrintUpgrade{
	my(@accounts, $count, $db, %DEF, $html, $header, $footer, $value,$status_message,$period);

	if ($MEMBER{status} eq 'expire') {
		 $status_message="Your subscription has expired.";
	}
	elsif ($MEMBER{status} eq 'pending') {
		$status_message="Your membership status is pending and waiting for payment.";
		$MEMBER{account}='';
		$MEMBER{status}='';
	}
	elsif ($MEMBER{status} eq 'active') {
		if ($FORM{action} ne 'upgrade') {$status_message.="If your access is limited, you can upgrade your account to have exclusive access.";}
		else {$status_message="You can prolong your subscription or change account type.";}
	}

	require "$CONFIG{program_files_path}/membership.txt";
	%DEF = &AccountDef;
	@accounts = &Subdirectories($CONFIG{account_path});
	$count=0;
	foreach $dir (@accounts){
		if (not $dir=~/guest$/){
			$count++;
		    %{$count} = &RetrieveAccountDB("$dir/account.pl");
	       	next unless ${$count}{ID};
			if ($MEMBER{account} eq ${$count}{ID}) {${$count}{name}.="\ (current)";}
		}
	}
###Build the body
	foreach $db (@order){
		$html .=qq|<tr><td $key_row_attributes>$DEF{$db}</td>|;
		for(my $i=1; $i <= $count; $i++){
			if($db =~ /ad_allowed|media_allowed|mailbox_size/){	$value = ${$i}{$db};		}
			elsif(${$i}{$db}){	$value =qq|<b>Yes!</b>|;	}
			else{						$value =qq||;	}
			$html .=qq|<td $value_row_attributes>$value</td>|;
		}
		$html .= qq|</tr>|;
	}
#price & period
	$html .=qq|<tr><td $key_row_attributes>price</td>|;
		for(my $i=1; $i <= $count; $i++){
			$html .=qq|<td $value_row_attributes>\$ ${$i}{recurring_amount}</td>|;
		}
	$html .= qq|</tr><tr><td $key_row_attributes>period</td>|;
		for(my $i=1; $i <= $count; $i++){
         	$period = (${$i}{recurring_length}<2**32-2)?int(${$i}{recurring_length}/86400)."\ days":"unlimited";
			$html .=qq|<td $value_row_attributes> $period</td>|;
		}
	$html.="</tr>";

###Now Build the header and footer
	$header =qq|<tr><td $header_row__attributes>$features</td>|;
	$footer =qq|<tr><td $footer_row_attributes>$order</td>|;
	for(my $i=1; $i <= $count; $i++){
		$header .=qq|<td>${$i}{name}</td>|;
		$footer .=qq|<td><a href="$CONFIG{program_url}&action=upgrade&account=${$i}{ID}">order</a></td>|;
	}
	$header .= qq|</tr>|;
	$footer .= qq|</tr>|;
	
	$html = qq|<table $table_attributes>$header $html $footer</table>|;

	my $template = &ParseCommonCodes($TEMPLATE{upgrade});
	$template =~ s/\[ACCOUNTS\]/$html/;
	$template =~ s/\[STATUS_MESSAGE\]/$status_message/;

	&PrintHeader;
	print $template;
	&PrintFooter;
}
############################################################
sub Gateway{
	my($amount, $ret, $template, $trial, $recurring);
		$ret = 0;
	($template, $ret) = @_;
#	&MemberWithNoAssociatedAccount unless $ACCOUNT{ID};
	unless (($ACCOUNT{trial_amount} > 0) or ($ACCOUNT{recurring_amount} > 0)){
		&GetFreeAccount;
		return "";
   	}
	
	if(-f "$CONFIG{account_path}/$ACCOUNT{ID}/2checkout.pl"){
		require "$CONFIG{account_path}/$ACCOUNT{ID}/2checkout.pl";
		&Build2CheckoutLink;
	}
	if(-f "$CONFIG{account_path}/$ACCOUNT{ID}/clickbank.pl"){
		require "$CONFIG{account_path}/$ACCOUNT{ID}/clickbank.pl";
		&BuildClickbankLink;
	}
	if(-f "$CONFIG{account_path}/$ACCOUNT{ID}/ibill.pl"){
		require "$CONFIG{account_path}/$ACCOUNT{ID}/ibill.pl";
		&BuildiBilllLink;
	}
	if(-f "$CONFIG{account_path}/$ACCOUNT{ID}/web900.pl"){
		require "$CONFIG{account_path}/$ACCOUNT{ID}/web900.pl";
		&BuildWeb900Link;
	}
	if(-f "$CONFIG{account_path}/$ACCOUNT{ID}/paypal.pl"){
		require "$CONFIG{account_path}/$ACCOUNT{ID}/paypal.pl";
		&BuildPaypalLink;
	}
	&BuildGatewayLinks;
	
	if($ACCOUNT{gateway}){
		if($ACCOUNT{gateway} eq "ibill"){			print "Location:$MOJO{ibill_cc}\n\n";		}
		elsif($ACCOUNT{gateway} eq "ibill_check"){print "Location:$MOJO{ibill_check}\n\n";	}
		elsif($ACCOUNT{gateway} eq "web900"){		print "Location:$MOJO{web900}\n\n";			}
		elsif($ACCOUNT{gateway} eq "clickbank"){	print "Location:$MOJO{clickbank}\n\n";		}
		elsif($ACCOUNT{gateway} eq "checkout"){	print "Location:$MOJO{checkout}\n\n";		}
		elsif($ACCOUNT{gateway} eq "paypal"){		print "Location:$MOJO{paypal}\n\n";			}
	}
	unless($template){		$template = $TEMPLATE{payment};	}
	$amount = $ACCOUNT{trial_amount}>0?$ACCOUNT{trial_amount}:$ACCOUNT{recurring_amount};
	$length = $ACCOUNT{trial_length}?int($ACCOUNT{trial_length}/86400):int($ACCOUNT{recurring_length}/86400);
	$trial = int($ACCOUNT{trial_length}/86400);
	$recurring = ($ACCOUNT{recurring_length}<2**32-2)?int($ACCOUNT{recurring_length}/86400):"unlimited";
	$trial = ($ACCOUNT{trial_length}<2**32-2)?int($ACCOUNT{trial_length}/86400):"unlimited";
	
	$template = &ParseMemberTemplate($template, \%MEMBER);
	
	$template =~ s/\[PAYPAL_URL\]/$MOJO{paypal}/ig;
	$template =~ s/\[CLICKBANK_URL\]/$MOJO{clickbank}/ig;
	$template =~ s/\[IBILL_URL\]/$MOJO{ibill_cc}/ig;
	$template =~ s/\[IBILLCHECK_URL\]/$MOJO{ibill_check}/ig;
	$template =~ s/\[WEB900_URL\]/$MOJO{web900}/ig;
	
	$template =~ s/\[CREDITCARD_LINKS\]/$MOJO{creditcard_links}/ig;
	$template =~ s/\[WEB900_LINKS\]/$MOJO{web900_links}/ig;
	$template =~ s/\[CHECK_LINKS\]/$MOJO{check_links}/ig;
	
#	$template =~ s/\[MEMBERSHIP_LENGTH\]/$length/ig;
	$template =~ s/\[TRIAL_LENGTH\]/$trial/ig;
	$template =~ s/\[RECURRING_LENGTH\]/$recurring/ig;
#	$template =~ s/\[MEMBERSHIP_AMOUNT\]/$amount/ig;
	$template =~ s/\[TRIAL_AMOUNT\]/$ACCOUNT{trial_amount}/ig;
	$template =~ s/\[RECURRING_AMOUNT\]/$ACCOUNT{recurring_amount}/ig;
	
	&PrintTemplate($template);
}
############################################################
sub Build2CheckoutLink{	}
sub BuildClickbankLink{
	$MOJO{clickbank}=  qq|$clickbank_cc?link=$clickbank_username/$clickbank_link/$ACCOUNT{ID}&seed=$clickbank_seed&username=$MEMBER{username}|;
}
sub BuildiBilllLink{
	$MOJO{ibill_cc}=   qq|   $ibill_cc?reqtype=$ibill_reqtype&account=$ibill_account&HELLOPAGE=$ibill_hellopage&LANGUAGE=$ibill_language&REF1=$MEMBER{username}&REF2=$MEMBER{password}&REF3=$MEMBER{account}|;
	$MOJO{ibill_check}=qq|$ibill_check?reqtype=$ibill_reqtype&account=$ibill_account&HELLOPAGE=$ibill_hellopage&LANGUAGE=$ibill_language&REF1=$MEMBER{username}&REF2=$MEMBER{password}&REF3=$MEMBER{account}|;
}
sub BuildWeb900Link{
	$MOJO{web900}=qq|$ibill_web900?reqtype=$ibill_reqtype&account=$ibill_account&return=$ibill_return|;
}
sub BuildPaypalLink{
	$paypal_notify = &Encode($paypal_notify);
	$paypal_return = &Encode($paypal_return);
	$paypal_cancel = &Encode($paypal_cancel);
	$paypal_username = &Encode($paypal_username);
	if($ACCOUNT{trial_period} eq "unlimited"){	$ACCOUNT{trial_period} = 5; $ACCOUNT{trial_time} ="Y";	}
	if($ACCOUNT{recurring_period} eq "unlimited"){	$ACCOUNT{recurring_period} = 5; $ACCOUNT{recurring_time} ="Y";	}
	$MOJO{paypal} = qq|$paypal_url=$paypal_username&item_name=$ACCOUNT{name}&item_number=$ACCOUNT{ID}&no_shipping=1&custom=$MEMBER{username}&notify_url=$paypal_notify&return=$paypal_return&cancel_return=$paypal_cancel|;
	if($ACCOUNT{trial_amount} > 0 or $ACCOUNT{trial_period}){
		$MOJO{paypal} .= qq|&a1=$ACCOUNT{trial_amount}&p1=$ACCOUNT{trial_period}&t1=$ACCOUNT{trial_time}|;
	}
	if($ACCOUNT{recurring_amount} > 0){
		$MOJO{paypal} .= qq|&a3=$ACCOUNT{recurring_amount}&p3=$ACCOUNT{recurring_period}&t3=$ACCOUNT{recurring_time}&src=1|;
	}
#### pass through varaibles
	my $string = "&cmd=_ext-enter&redirect_cmd=_xclick&first_name=$MEMBER{fname}&last_name=$MEMBER{lname}&address1=$MEMBER{address}&&address2=$MEMBER{address2}&city=$MEMBER{city}&state=$MEMBER{state}&zip=$MEMBER{zip}";
	$MOJO{paypal} .= $string;
}
############################################################
sub BuildGatewayLinks{
	my(%DEF) = ("clickbank"=>$clickbank_display?$clickbank_display:"Clickbank",
					"ibill_cc"=>$ibillcc_display?$ibillcc_display:"iBill",
					"ibill_check"=>$ibillcheck_display?$ibillcheck_display:"iBill checks payment",
					"web900"=>$web900_display?$web900_display:"web900",
					"paypal"=>$paypal_display?$paypal_display:"Paypal");
	
	foreach ("clickbank", "ibill_cc", "paypal"){
		if($MOJO{$_}){			$MOJO{creditcard_links} .= qq|<li><a href="$MOJO{$_}">$DEF{$_}</a></li>|;		}
	}
	foreach ("ibill_check"){
		if($MOJO{$_}){			$MOJO{check_links} .= qq|<li><a href="$MOJO{$_}">$DEF{$_}</a></li>|;		}
	}
	foreach ("web900"){
		if($MOJO{$_}){			$MOJO{web900_links} .= qq|<li><a href="$MOJO{$_}">$DEF{$_}</a></li>|;		}
	}
	unless($MOJO{creditcard_links}){	$MOJO{creditcard_links} =qq|<li>Sorry, We do not accept credit card payments at this time.</li>|;	}
	unless($MOJO{check_links}){		$MOJO{check_links} =qq|<li>Sorry, we do not accept online check payments at this time.</li>|;	}
	unless($MOJO{web900_links}){		$MOJO{web900_links} =qq|<li>Sorry, we do not accept telephone payments (iBill web900) at this time.</li>|;	}
}
############################################################
sub GatewayAvailable{
	my(@gateways);
	if(-f "$CONFIG{script_path}/checkout.$CONFIG{script_ext}"){		push(@gateways, "checkout");	}
	if(-f "$CONFIG{script_path}/ibill.$CONFIG{script_ext}"){			push(@gateways, "ibill");		}
	if(-f "$CONFIG{script_path}/paypal.$CONFIG{script_ext}"){		push(@gateways, "paypal");		}
	if(-f "$CONFIG{script_path}/clickbank.$CONFIG{script_ext}"){	push(@gateways, "clickbank");	}
	return @gateways;
}
############################################################
sub GatewayPaid{
	my ($oldaccount);
	my($gateway) = @_;
	$FORM{time}=$CONFIG{systemtime};
	$FORM{gateway} =$MEMBER{gateway}=$gateway;	
	$oldaccount=$MEMBER{account};
	$MEMBER{account}=$FORM{account};

	$MEMBER{ad_allowed}=$ACCOUNT{ad_allowed};
	$MEMBER{media_allowed}= $ACCOUNT{media_allowed};
	$MEMBER{mailbox_size}=$ACCOUNT{mailbox_size};

	$MEMBER{status}=           "active";
	$MEMBER{pincode}= 	   	   $FORM{pincode} if $FORM{pincode};
	$MEMBER{subscription_id}=  $FORM{subscription_id} if $FORM{subscription_id};;
	$MEMBER{transaction_id}=   $FORM{transaction_id} if $FORM{transaction_id};;
#	$MEMBER{date_end}=         &GiveMeTime($MEMBER{date_end});

	if ($oldaccount eq $MEMBER{account}) {	$MEMBER{account_end}=&GiveMeTime2($MEMBER{account_end});}
	else {
		$MEMBER{account_start}=$CONFIG{systemtime};
		$MEMBER{account_end}=&GiveMeTime2();
	}

#		if ($ACCOUNT{trial_length}){
#		      $MEMBER{account_end}=($ACCOUNT{trial_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{trial_length};
#		}
#		else {
#		      $MEMBER{account_end}=($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{recurring_length};
#		}
#	}
	&UpdateMemberDB(\%MEMBER);
	&AddReceiptDB("$CONFIG{this_account}/$gateway.rc", \%FORM);

##Take to the member page
	if($CONFIG{payment_notify}){
		&SendMail("$MEMBER{fname} $MEMBER{lname}", $MEMBER{email}, $myemail, "You have cash", "<a href=\"$CONFIG{admin_url}?type=member&action=detail&username=$FORM{username}&step=final\">$FORM{username}</a> subscribes to your site.<br>");
	}
	return if $gateway eq "paypal";
	%FORM = %MEMBER;
	$FORM{action} = "login";
	if($MEMBER{last_url}){
		$MEMBER{last_url} = "";
		&UpdateMemberDB(\%MEMBER);
			if($FORM{last_url} =~ /^http/){	print "Location:$FORM{last_url}\n\n";	}
			else{		print "Location:$CONFIG{program_url}&$FORM{last_url}\n\n";	}
	}
	&MemberPanel("Thank $MEMBER{username} for your payment. Please enjoy our service");	
}
############################################################
1;
