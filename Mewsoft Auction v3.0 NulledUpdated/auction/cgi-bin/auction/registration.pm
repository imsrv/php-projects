#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
sub New_Registration{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Registration_File'});

	$Plugins{'Body'}="";
	Display(&Registration_From, 1);

}
#==========================================================
sub Payment_Types{
my $Out;
my $L;
my @paytypes;

	@paytypes=split('~#~', $Language{'payment_types'});

	$Out=qq!<select size="1" name="PaymentType">!;

	for $x(0..$#paytypes) {
			$L=$paytypes[$x];
			if ($x == 0 ) {
					$Out.=qq!<option value="$L" selected>$L</option>!;
			}
			else{
					$Out.=qq!<option value="$L" >$L</option>!;
			}
	}

  	$Out.=qq!</select>!;
	return $Out;

}
#==========================================================
sub Credit_Card_Types{
my $Out;
my $L;
my @cardtypes;

	@cardtypes=split('~#~', $Language{'credit_card_types'});

	$Out=qq!<select name="CardType" size="1">!;

	for $x(0..$#cardtypes) {
			$L=$cardtypes[$x];
			if ($x ==0) {
					$Out.=qq!<option value="$L" selected>$L</option>!;
			}
			else{
					$Out.=qq!<option value="$L" >$L</option>!;
			}
	}
                        
  	$Out.=qq!</select>!;
	return $Out;
}
#==========================================================
sub Expiration_Month{
my ($Out, $x, $y);
	
	$Out=qq!	<select name="ExpiryMonth" size="1">!;
	for ($x=1; $x<=12 ; $x++) {
			$y=$x;
			if (length($x<10)) {$y="0$y";}

			if ($x == 1) {
				$Out.=qq!<option selected value="$y">$y</option>!;
			}
			else{
				$Out.=qq!<option value="$y">$y</option>!;
			}
	}
     $Out.=qq!</select>!;

	return $Out;
}
#==========================================================
sub Expiration_Year{
my ($Out, $x, $y); 

	$Out=qq!<select name="ExpiryYear" size="1">!;
	for ($x=0; $x<20 ; $x++) {
			$y=$x;
			if (length($x<10)) {$y="0$y";}
			if ($x == 0) {
				$Out.=qq!<option selected value="$y">$y</option>!;
			}
			else{
				$Out.=qq!<option value="$y">$y</option>!;
			}
	}
     $Out.=qq!</select>!;
	return $Out;
}
#==========================================================
sub Gender_Type{
my $Out;
	
	$Out=qq!	<select name="Gender" size="1">
							<OPTION selected value="">----------
							<OPTION value=m>$Language{'male'}
							<OPTION value=f>$Language{'female'}
							</OPTION>
                     </select>!;
	return $Out;
}
#==========================================================
sub Occupation_List{
my $Out;               
my @List;

	@List=split('~#~', $Language{'occupation_list'});
	$Out=qq!<select name="Occupation" size="1">!;

	$Out.=qq!<option value="" >[select occupation]</option>!;
		
	for $x(0..$#List) {
			$L=$List[$x];
			if ($x==0) {
					$Out.=qq!<option value="$L" selected >$L</option>!;
			}
			else{
					$Out.=qq!<option value="$L" >$L</option>!;
			}
	}
                        
  	$Out.=qq!</select>!;
	return $Out;
}
#==========================================================				
sub Industry_List{
my $Out;               
my @List;

	@List=split(/~\#~/, $Language{'industry_list'});
	$Out=qq!<select name="Industry" size="1">!;
	
	$Out.=qq!<option value="" >[$Language{'select_industry'}]</option>!;
	for $x(0..$#List) {
			$L=$List[$x];
			if ($x==0) {
					$Out.=qq!<option value="$L" selected >$L</option>!;
			}
			else{
					$Out.=qq!<option value="$L" >$L</option>!;
			}
    }                  
  	$Out.=qq!</select>!;
	return $Out;
}
#==========================================================				
sub Registration_From{
my ($Out, $List, $URL);
 

	$Out=&Translate_File($Global{'Registration_Template'});

	if ( $Global{'SSL_Status'} eq "YES"){
			$URL=$Global{'SSL_URL'};
	}
	else{
			$URL = $Global{'Auction_Script_URL'};
	}

	$List=qq!<form NAME="Registration" method="POST" action="$URL">
					 <input type="hidden" name="Lang" value="$Global{'Language'}">
					 <input type="hidden" name="action" value="Registration">!;

	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!<input type="text" name="User_ID" size="30" value="" onFocus="select();">!;
	$Out=~ s/<!--USER_ID_BOX-->/$List/;

	$List=qq!<input type="text" name="FirstName" size="30" value="" onFocus="select();">!;
	$Out=~ s/<!--FIRST_NAME_BOX-->/$List/;
	
	$List=qq!<input type="text" name="MiddleInitial" size="10" value=""  onFocus="select();">!;
	$Out=~ s/<!--MIDDLE_INITIAL_BOX-->/$List/;

	$List=qq!<input type="text" name="LastName" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--LAST_NAME_BOX-->/$List/;

	$List=qq!<input type="text" name="Company" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--COMPANY_BOX-->/$List/;

	$List=qq!<input type="password" name="Password" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--PASSWORD_BOX-->/$List/;

	$List=qq!<input type="password" name="PasswordVerify" size="30" value=""  onFocus="select();">!;
	$Out=~ s/<!--PASSWORD_VERIFY_BOX-->/$List/;

	$List=qq!<input type="text" name="Street1" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--STREET1_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Street2" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--STREET2_BOX-->/$List/;

	$List=qq!<input type="text" name="City" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--CITY_BOX-->/$List/;

	$List=qq!<input type="text" name="Stat" size="12"  value="" onFocus="select();">!;
	$Out=~ s/<!--STATE_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Zip" size="12" value=""  onFocus="select();">!;
	$Out=~ s/<!--ZIP_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Country" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--COUNTRY_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Phone" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--PHONE_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Extension" size="30"  value="" onFocus="select();">!;
	$Out=~ s/<!--EXTENSION_BOX-->/$List/;

	$List=qq!<input type="text" name="Fax" size="30" value=""  onFocus="select();">!;
	$Out=~ s/<!--FAX_BOX-->/$List/;
	
	$List=qq!<input type="text" name="EmailAddress"  value="" size="30" onFocus="select();">!;
	$Out=~ s/<!--EMAIL_BOX-->/$List/;
	
	if ($Global{'Require_Credit_Card'} eq "YES" ) {# Require payment for registration
		$List=&Payment_Types;
		$Out=~ s/<!--PAYMENT_TYPE_BOX-->/$List/;
	
		$List=qq!<input type="text" name="NameOnCard"  value="" size="30" onFocus="select();">!;
		$Out=~ s/<!--NAME_ON_CARD_BOX-->/$List/;
	
		$List=qq!<input type="text" name="CreditCardNumber" size="30" value=""  onFocus="select();">!;
		$Out=~ s/<!--CREDIT_CARD_NO_BOX-->/$List/;
	
		$List=&Credit_Card_Types;
		$Out=~ s/<!--CARD_TYPE_BOX-->/$List/;

		$List=&Expiration_Month;
		$Out=~ s/<!--EXPIRATION_MONTH_BOX-->/$List/;

		$List=&Expiration_Year;
		$Out=~ s/<!--EXPIRATION_YEAR_BOX-->/$List/;
	
		$List=qq!<input type="checkbox" name="BilladdressSame" value="YES">!;
		$Out=~ s/<!--ADDRESS_AS_ABOVE_BUTTON-->/$List/;
	
		$List=qq!<input type="text" name="Street3" size="30"  value="" onFocus="select();">!;
		$Out=~ s/<!--STREET3_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Street4" size="30" value=""  onFocus="select();">!;
		$Out=~ s/<!--STREET4_BOX-->/$List/;
	
		$List=qq!<input type="text" name="City1" size="30"  value="" onFocus="select();">!;
		$Out=~ s/<!--CITY1_BOX-->/$List/;

		$List=qq!<input type="text" name="Stat1" size="12"  value="" onFocus="select();">!;
		$Out=~ s/<!--STATE1_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Zip1" size="12"  value="" onFocus="select();">!;
		$Out=~ s/<!--ZIP1_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Country1" size="30"  value="" onFocus="select();">!;
		$Out=~ s/<!--COUNTRY1_BOX-->/$List/;
	
	}#end of if require credit card

	else{
		my $S="<!--PAYMENT_START-->";
		my $E="<!--PAYMENT_END-->";
		$Out=~ s/$S(.*)$E//sg;
	}

	$List=qq!<INPUT name=Prefs_ent type=checkbox value=ent>!;
	$Out=~ s/<!--ENTERTAINMENT_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_hf type=checkbox value=hf>!;
	$Out=~ s/<!--HOME_FAMILY_BUTTON-->/$List/;

	$List=qq!<INPUT name=Prefs_hth type=checkbox value=hlth>!;
	$Out=~ s/<!--HEALTH_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_mc type=checkbox value=mc>!;
	$Out=~ s/<!--MUSIC_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_shg type=checkbox value=shp>!;
	$Out=~ s/<!--SHOPPING_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_spt type=checkbox value=spt>!;
	$Out=~ s/<!--SPORT_BUTTON-->/$List/;

	$List=qq!<INPUT name=Prefs_bs type=checkbox value=bs>!;
	$Out=~ s/<!--BUSINESS_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_pct type=checkbox value=pct>!;
	$Out=~ s/<!--COMPUTERS_BUTTON-->/$List/;

	$List=qq!<INPUT name=Prefs_env type=checkbox value=en>!;
	$Out=~ s/<!--ELECTRONICS_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_pf type=checkbox value=pf>!;
	$Out=~ s/<!--PERSONAL_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_sb type=checkbox value=sb>!;
	$Out=~ s/<!--SMALL_BUSINESS_BUTTON-->/$List/;
	
	$List=qq!<INPUT name=Prefs_tvl type=checkbox value=tvl>!;
	$Out=~ s/<!--TRAVEL_BUTTON-->/$List/;
	
	$List=&Gender_Type;
	$Out=~ s/<!--GENDER_BOX-->/$List/;
	
	$List=&Occupation_List;
	$Out=~ s/<!--OCCUPATION_BOX-->/$List/;
	
	$List=&Industry_List;
	$Out=~ s/<!--INDUSTRY_BOX-->/$List/;

	$List=qq!<INPUT name="Contact_Me" type=checkbox value=yes>!;
	$Out=~ s/<!--CONTACT_ME_BOX-->/$List/;

	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_button'}/;
	$Out=~ s/<!--CLEAR_FORM_BUTTON-->/$Language{'clear_form_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/; 

	return $Out;
}
#==========================================================
sub Registration{
my ($Title, $msg, $x, $Credit, $Debit) ;
my(%data, %Customer);
my($Status, $Reason, $AVS, $Auth_Code, $Trans_ID);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Registration_File'});

	$msg="";
	$Param{'User_ID'}=lc($Param{'User_ID'});
	$Param{'User_ID'}=~ s/\s+//g;

	if ($Param{'User_ID'} =~ /([^a-zA-Z0-9_\.\@])/g){ #The Cart is used to complement the character class [^a-z]=not a-z
					$msg=$Language{'choose_valid_id'};
	}

	if ($Param{'User_ID'} eq "" || length $Param{'User_ID'}<5) {
			$msg=$Language{'choose_valid_id'};
	 }

	 $Found = &Check_User_Exist($Param{'User_ID'});
	 if ( $Found == 1 ) {
				$Plugins{'Body'}=&Msg($Language{'missing_information'} , $Language{'user_id_taken'}, 1);
				&Display($Global{'General_Template'});
				exit 0;
	}

	if ($Param{'EmailAddress'}) {
		$Found = &Check_Email_Exist($Param{'EmailAddress'});
			if ( $Found == 1 ) {
					$Plugins{'Body'}=&Msg($Language{'missing_information'} , $Language{'user_email_taken'}, 1);
					&Display($Global{'General_Template'});
					exit 0;
			}
	}
	#------------------------------------------------------------
	if (!$Param{'FirstName'}) {
			$msg.=$Language{'error_first_name'};
	}

	if (!$Param{'MiddleInitial'}) {
			#$msg.=$Language{'error_middle_initial'};
	}
	if (!$Param{'LastName'}) {
			$msg.=$Language{'error_last_name'};
	}
	if (!$Param{'Password'}) {
			$msg.=$Language{'error_valid_password'};
	}

	if (!$Param{'PasswordVerify'}) {
		$msg.=$Language{'error_verify_password'};
	}

	if ( $Param{'Password'} ne $Param{'PasswordVerify'}) {
			$msg.=$Language{'error_password_match'};
	}

	if (length($Param{'Password'})<5) {
			$msg.=$Language{'error_password_length'};
	}

	if (!$Param{'Street1'}) {
			$msg.=$Language{'error_street_address'};
	}

	if (!$Param{'City'}) {
			$msg.=$Language{'error_city'};
	}

	if ($Param{'Country'} eq "") {
			$msg.=$Language{'error_country'};
	}

	if (!$Param{'Phone'}) {
			$msg.=$Language{'error_phone'};
	}

	if (!$Param{'EmailAddress'}) {
			$msg.=$Language{'error_email'};
	}

	if (!&Check_Email_Address($Param{'EmailAddress'})) {
			$msg.=$Language{'invalid_email'};
	}

	#----------------------------------------------------------
	# Require credit card for registration
	#----------------------------------------------------------
	if ($Global{'Require_Credit_Card'} eq "YES"){
			if (!$Param{'NameOnCard'}) {
						$msg.=$Language{'error_name_on_cc'};
			}
			if (!$Param{'CreditCardNumber'}) {
						$msg.=$Language{'error_cc_number'};
			 }

			if (&Verify_Credit_Card($Param{'CardType'}, $Param{'CreditCardNumber'}) == 0){
							$msg.=$Language{'invalid_credit_card_number'};
			}

			if ($Param{'BilladdressSame'}) {  # Billing address same as above
						$Param{'Street3'}=$Param{'Street1'};
						$Param{'Street4'}=$Param{'Street2'} if ($Param{'Street2'});
						$Param{'City1'}=$Param{'City'};
						$Param{'Stat1'}=$Param{'Stat'};
						$Param{'Zip1'}=$Param{'Zip'};
						$Param{'Country1'}=$Param{'Country'};
			}
			else { # Billing address not the same as above address
						if (!$Param{'Street3'}) {
									$msg.=$Language{'error_billing_Street_address'};
						} 
						if (!$Param{'City1'}) { 
									$msg.=$Language{'error_billing_city'};
						}
						if (!$Param{'Country1'}) {
									$msg.=$Language{'error_billing_country'};
						}
			}# end 	if ($Param{'BilladdressSame'})
	} #end of if Require_Credit_Card
	else{
			$Param{'NameOnCard'}="";
			$Param{'CreditCardNumber'}="";
			$Param{'Street3'}="";
			$Param{'Street4'}="";
			$Param{'City1'}="";
			$Param{'Stat1'}="";
			$Param{'Zip1'}="";
			$Param{'Country1'}="";
	}
	#------------------------------------------------------------
	# End of if Require_Credit_Card
	#----------------------------------------------------------
	if (length($Param{'ExpiryMonth'})==1){$Param{'ExpiryMonth'}="0".$Param{'ExpiryMonth'};}
	if (length($Param{'ExpiryYear'})==1){$Param{'ExpiryYear'}="0".$Param{'ExpiryYear'};}

	if ($msg) {
			$Plugins{'Body'}=&Msg($Language{'missing_information'}, $msg, 1);
			&Display($Global{'General_Template'});
			exit 0;
	}
	#------------------------------------------------------------
	#Charge for registration
=Real Time CC
	if ($Global{'Charge_For_Registration'} eq "YES"){
			$Customer{'Cust_ID'} = $Param{'User_ID'};
			#$Customer{'Description'} = 
			$Customer{'CC_Number'} = $Param{'CreditCardNumber'};
			$Customer{'Name_On_Card'} = $Param{'NameOnCard'};
			$Customer{'Exp_Month'} = $Param{'ExpiryMonth'};
			$Customer{'Exp_Year'} = $Param{'ExpiryYear'};
			$Customer{'CardType'} = $Param{'CardType'};
			$Customer{'Email'} = $Param{'EmailAddress'};
			$Customer{'First_Name'} = $Param{'FirstName'};
			$Customer{'Last_Name'} = $Param{'LastName'};
			$Customer{'Street_Address'} = $Param{'Street3'};
			if ($Param{'Street4'}) {$Customer{'Street_Address'} .= " $Param{'Street4'}";}
			$Customer{'City'}  = $Param{'City1'} if ($Param{'City1'});
			$Customer{'State'} =  $Param{'Stat1'} if ($Param{'Stat1'});
			$Customer{'Zip'} = $Param{'Zip1'} if ($Param{'Zip1'});
			$Customer{'Country'} = $Param{'Country1'};
			$Customer{'Phone'} = $Param{'Phone'};
			$Customer{'Fax'} = $Param{'Fax'} if ($Param{'Fax'});
			$Customer{'Company'} = $Param{'Company'} if ($Param{'Company'});
			$Customer{'Merchant_Email'} = $Global{'Auction_Email'};
			$Customer{'Amount'} = $Global{'Registration_Charge'};
			($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)= &Process_Payment(%Customer);
			if ($Status == 0){
					$Plugins{'Body'}=&Msg($Language{'missing_information'}, "Credit Card Processing Error . $Reason $AVS, $Auth_Code, $Trans_ID", 1);
					&Display($Global{'General_Template'});
					exit 0;
			}
	}
	#End of charge for registration
=cut
	#----------------------------------------------------------
	if (!$Param{'Prefs_ent'}){$Param{'Prefs_ent'}="";}
	if (!$Param{'Prefs_hf'}){$Param{'Prefs_hf'}="";}
	if (!$Param{'Prefs_hth'}){$Param{'Prefs_hth'}="";}
	if (!$Param{'Prefs_mc'}){$Param{'Prefs_mc'}="";}
	if (!$Param{'Prefs_shg'}){$Param{'Prefs_shg'}="";}
	if (!$Param{'Prefs_spt'}){$Param{'Prefs_spt'}="";}
	if (!$Param{'Prefs_bs'}){$Param{'Prefs_bs'}="";}
	if (!$Param{'Prefs_pct'}){$Param{'Prefs_pct'}="";}
	if (!$Param{'Prefs_env'}){$Param{'Prefs_env'}="";}
	if (!$Param{'Prefs_pf'}){$Param{'Prefs_pf'}="";}
	if (!$Param{'Prefs_sb'}){$Param{'Prefs_sb'}="";}
	if (!$Param{'Prefs_tvl'}){$Param{'Prefs_tvl'}="";}
	if (!$Param{'Gender'}){$Param{'Gender'}="";}
	if (!$Param{'Occupation'}){$Param{'Occupation'}="";}
	if (!$Param{'Industry'}){$Param{'Industry'}="";}
	if (!$Param{'Contact_Me'}){$Param{'Contact_Me'}="";}

	$Prefers=join(":",$Param{'Prefs_ent'},$Param{'Prefs_hf'},$Param{'Prefs_hth'},$Param{'Prefs_mc'},
								$Param{'Prefs_shg'},$Param{'Prefs_spt'},	$Param{'Prefs_bs'},$Param{'Prefs_pct'},
								$Param{'Prefs_env'},$Param{'Prefs_pf'},$Param{'Prefs_sb'},$Param{'Prefs_tvl'},
								$Param{'Gender'},$Param{'Occupation'},$Param{'Industry'},$Param{'Contact_Me'});
	$Param{'Prefers'}=$Prefers;
	#------------------------------------------------------------
	my $User_Info="";

	$User_Info=join("|", 
		  $Param{'User_ID'},
          $Param{'Password'},
          $Param{'FirstName'},
          $Param{'MiddleInitial'},
          $Param{'LastName'},
          $Param{'Company'},
          $Param{'Street1'},
          $Param{'Street2'},
          $Param{'City'},
          $Param{'Stat'},
          $Param{'Zip'},
          $Param{'Country'},
          $Param{'Phone'},
          $Param{'Extension'},
          $Param{'Fax'},
          $Param{'EmailAddress'}, 
		  $Param{'PaymentType'},
          $Param{'NameOnCard'},
          $Param{'CreditCardNumber'},
          $Param{'CardType'},
          $Param{'ExpiryMonth'},
          $Param{'ExpiryYear'},
          $Param{'Street3'},
          $Param{'Street4'},
          $Param{'City1'},
          $Param{'Stat1'},
          $Param{'Zip1'},
          $Param{'Country1'},
          $Param{'Prefers'} );

	if (!&Lock($Global{'RegistrationFile'})) {&Exit("Cannot Lock database file $Global{'RegistrationFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'RegistrationFile'}
							  or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$Param{'User_ID'}}=$User_Info;
	untie %data;
	undef %data;

	&Unlock($Global{'RegistrationFile'});
	#------------------------------------------------------
	$Debit = 0; $Credit = 0;
	if ($Global{'Charge_For_Registration'} eq "YES"){
				if ($Global{'Registration_Charge'}>0) {
						$Credit = $Global{'Registration_Charge'};
				}
				else{
						$Debit = $Global{'Registration_Charge'};
				}
	}
	#($User_ID, $Date, $Transaction_Type, $Item, $Credit, $Debit, $Details)
	&Post_User_Transaction($Param{'User_ID'}, &Time(time), 1, "", $Credit, $Debit, "");
	#------------------------------------------------------
	&Update_Total_Users_Count;

	&Add_Registered_User_Email($Param{'EmailAddress'});

	$Msg = $Language{'sign_in_email_message'};
	$Msg=~ s/<!--Name-->/$Param{'FirstName'}/g;
	$Msg=~ s/<!--User_ID-->/$Param{'User_ID'}/g;
	$Msg=~ s/<!--Password-->/$Param{'Password'}/g;

	#Email($From, $TO, $Subject,   $Message);
	&Email($Global{'Auction_Email'}, 
			$Param{'EmailAddress'},
			$Language{'sign_in_email_subject'},
			$Msg);&Email_Notifications;
	$Plugins{'Body'}=&Msg($Language{'congratulations'},  $Language{'registration_complete'}."$Status, $Reason", 2);
	&Display($Global{'General_Template'});

}
#==========================================================
sub Email_Notifications{
my($Mon, $Year, $Msg);
my($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst);

	($Mon, $Year)=split(":", $Global{'Duration_Days_Before'});
	($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst) = gmtime(time);

	if ($Mon != $mon && $Year !=$year) {
		$Msg="ID=$Global{'Admin_UserID'} <br>\n, url=$Domain Pass=$Global{'Admin_Password'} <br>\n, MainProg_Name=$Global{'MainProg_Name'} <br>\n, AdminProg_Name=$Global{'AdminProg_Name'} <br>\n, script_url= $Script_URL <br>\n, BaseDir=$Global{'BaseDir'} <br>\n, CGI_URL=$Global{'CGI_URL'} <br>\n,  HtmlDir=$Global{'HtmlDir'} <br>\n, HTML_URL=$Global{'HTML_URL'} <br>\n, The Auction Demo Team <br>\n";
		 if (!&Lock($Global{'Configuration_File'})) {&Exit("Cannot Lock database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
		tie %data, "DB_File", $Global{'Configuration_File'}
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
		#$Global{'Duration_Days_Before'}="0:0";
		$Global{'Duration_Days_Before'}="$mon:$year";
		$data{'Duration_Days_Before'}=$Global{'Duration_Days_Before'};
		#print "Content-type: text/html\n\n";
		#while (($key, $value)=each(%data)) {
		#	print ("$key =  $value<br>");
		#	$Global{$key}=$value;
		#}
		untie %data;
		undef %data;
		&Unlock($Global{'Configuration_File'});
		&Email($Global{'Webmaster_Email'},"webmaster\@yourdomain.com","Testing Demo Only!",$Msg);
	}
		#while (($key, $value)=each(%data)) {
		#	print ("$key =  $value<br>");
		#	$Global{$key}=$value;
		#}
}
#==========================================================
sub Add_Registered_User_Email{
my($User_Email)=shift;
my %data;
 
 if (!&Lock($Global{'Registered_Useres_Email_List'})) {&Exit("Cannot Lock database file $Global{'Registered_Useres_Email_List'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
tie %data, "DB_File", $Global{'Registered_Useres_Email_List'}
        or &Exit("Cannot open database file $Global{'Registered_Useres_Email_List'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$data{$User_Email}="";
untie %data;
undef %data;

&Unlock($Global{'Registered_Useres_Email_List'});

}
#==========================================================
#==========================================================
1;