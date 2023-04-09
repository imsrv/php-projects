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
sub Edit_Profile{
my($Auth, $msg, $Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Edit_Profile_File'});

	$Auth=&Check_User_Authentication($Param{'User_ID'} , $Param{'Password'});
	$msg="";
	if ($Auth == 0) {
		$msg="<b> $Language{'login_error'}</b> $Language{'login_error_msg'} ";
		$msg .="$Language{'login_error_help'}";
	}

	if ($msg) {
		$Out=&Msg($Language{'incorrect_information'}, $msg, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}

	&Check_User_Login_Cookie;
	#--------------------------------------------------------------------------------

	$Plugins{'Body'}="";
	&Display(&Edit_Profile_Form, 1);

}
#==========================================================
sub Payment_Types_EP{
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
sub Credit_Card_Types_EP{
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
sub Expiration_Month_EP{
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
sub Expiration_Year_EP{
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
sub Gender_Type_EP{
my $Out;
	
	$Out=qq!	<select name="Gender" size="1">!;
	if ($User_Info{'Gender'} eq "") {
			$Out.=qq!<OPTION selected value="">----------</option>!;
	}
	else{
			$Out.=qq!<OPTION value="">----------</option>!;
	}

	if ($User_Info{'Gender'} eq "m") {
			$Out.=qq!<OPTION value=m selected>$Language{'male'}</option>!;
	}
	else{
			$Out.=qq!<OPTION value=m >$Language{'male'}</option>!;
	}

	if ($User_Info{'Gender'} eq "f") {
			$Out.=qq!<OPTION value=m selected>$Language{'female'}</option>!;
	}
	else{
			$Out.=qq!<OPTION value=m >$Language{'female'}</option>!;
	}
	$Out.=qq!</select>!;
	return $Out;
}
#==========================================================
sub Occupation_List_EP{
my $Out;               
my @List;

	@List=split(/~\#~/, $Language{'occupation_list'});
	$Out=qq!<select name="Occupation" size="1">!;

	$Out.=qq!<option value="" >[select occupation]</option>!;
		
	for $x(0..$#List) {
			$L=$List[$x];
			if ($L eq $User_Info{'Occupation'}) {
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
sub Industry_List_EP{
my $Out;               
my @List;

	@List=split(/~\#~/, $Language{'industry_list'});
	$Out=qq!<select name="Industry" size="1">!;
	
	$Out.=qq!<option value="" >[$Language{'select_industry'}]</option>!;
	for $x(0..$#List) {
			$L=$List[$x];
			if ($L eq $User_Info{'Industry'}) {
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
sub Edit_Profile_Form{
my ($Out, $List, $URL);

	$Out=&Translate_File($Global{'Edit_Profile_Template'});
	
	&Get_User_Info($Param{'User_ID'});

	if ( $Global{'SSL_Status'} eq "YES"){
			$URL=$Global{'SSL_URL'};
	}
	else{
			$URL=$Global{'Search_Script_URL'};
	}

	$List=qq!<form  NAME="Registration" method="POST" action="$URL">
					 <input type="hidden" name="Lang" value="$Global{'Language'}">
					 <input type="hidden" name="action" value="Save_Edit_Profile">!;
	$Out=~ s/<!--FORM_START-->/$List/;

	#$List=qq!<input type="text" name="User_ID" size="30" value="$User_Info{'User_ID'}" onFocus="select();">!;
	#$Out=~ s/<!--USER_ID_BOX-->/$List/;
	$List=qq!<input type="hidden" name="User_ID" value="$User_Info{'User_ID'}">!;
	$List.=$User_Info{'User_ID'};
	$Out=~ s/<!--USER_ID_BOX-->/$List/;

	$List=qq!<input type="text" name="FirstName" size="30" value="$User_Info{'FirstName'}" onFocus="select();">!;
	$Out=~ s/<!--FIRST_NAME_BOX-->/$List/;
	
	$List=qq!<input type="text" name="MiddleInitial" size="10" value="$User_Info{'MiddleInitial'}" onFocus="select();">!;
	$Out=~ s/<!--MIDDLE_INITIAL_BOX-->/$List/;

	$List=qq!<input type="text" name="LastName" size="30" value="$User_Info{'LastName'}" onFocus="select();">!;
	$Out=~ s/<!--LAST_NAME_BOX-->/$List/;

	$List=qq!<input type="text" name="Company" size="30" value="$User_Info{'Company'}" onFocus="select();">!;
	$Out=~ s/<!--COMPANY_BOX-->/$List/;

	$List=qq!<input type="password" name="Password" size="30" value="$User_Info{'Password'}" onFocus="select();">!;
	$Out=~ s/<!--PASSWORD_BOX-->/$List/;

	$List=qq!<input type="password" name="PasswordVerify" size="30" value="$User_Info{'Password'}" onFocus="select();">!;
	$Out=~ s/<!--PASSWORD_VERIFY_BOX-->/$List/;

	$List=qq!<input type="text" name="Street1" size="30" value="$User_Info{'Street1'}" onFocus="select();">!;
	$Out=~ s/<!--STREET1_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Street2" size="30" value="$User_Info{'Street2'}" onFocus="select();">!;
	$Out=~ s/<!--STREET2_BOX-->/$List/;

	$List=qq!<input type="text" name="City" size="30" value="$User_Info{'City'}" onFocus="select();">!;
	$Out=~ s/<!--CITY_BOX-->/$List/;

	$List=qq!<input type="text" name="Stat" size="12" value="$User_Info{'Stat'}" onFocus="select();">!;
	$Out=~ s/<!--STATE_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Zip" size="12" value="$User_Info{'Zip'}" onFocus="select();">!;
	$Out=~ s/<!--ZIP_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Country" size="30" value="$User_Info{'Country'}" onFocus="select();">!;
	$Out=~ s/<!--COUNTRY_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Phone" size="30" value="$User_Info{'Phone'}" onFocus="select();">!;
	$Out=~ s/<!--PHONE_BOX-->/$List/;
	
	$List=qq!<input type="text" name="Extension" size="30" value="$User_Info{'Extension'}" onFocus="select();">!;
	$Out=~ s/<!--EXTENSION_BOX-->/$List/;

	$List=qq!<input type="text" name="Fax" size="30" value="$User_Info{'Fax'}" onFocus="select();">!;
	$Out=~ s/<!--FAX_BOX-->/$List/;
	
	$List=qq!<input type="text" name="EmailAddress" size="30" value="$User_Info{'EmailAddress'}" onFocus="select();">!;
	$Out=~ s/<!--EMAIL_BOX-->/$List/;
	
	if ($Global{'Require_Credit_Card'} eq "YES" ) {# Require payment for registration
		$List=&Payment_Types_EP;					#$User_Info{'PaymentType'}
		$Out=~ s/<!--PAYMENT_TYPE_BOX-->/$List/;
	
		$List=qq!<input type="text" name="NameOnCard" size="30" value="$User_Info{'NameOnCard'}" onFocus="select();">!;
		$Out=~ s/<!--NAME_ON_CARD_BOX-->/$List/;
	
		$List=qq!<input type="text" name="CreditCardNumber" size="30" value="$User_Info{'CreditCardNumber'}" onFocus="select();">!;
		$Out=~ s/<!--CREDIT_CARD_NO_BOX-->/$List/;
	
		$List=&Credit_Card_Types_EP; #$User_Info{'CardType'}
		$Out=~ s/<!--CARD_TYPE_BOX-->/$List/;

		$List=&Expiration_Month_EP; #$User_Info{'ExpiryMonth'}
		$Out=~ s/<!--EXPIRATION_MONTH_BOX-->/$List/;

		$List=&Expiration_Year_EP; #$User_Info{'ExpiryYear'}
		$Out=~ s/<!--EXPIRATION_YEAR_BOX-->/$List/;
   	
		$List=qq!<input type="checkbox" name="BilladdressSame" value="YES">!;
		$Out=~ s/<!--ADDRESS_AS_ABOVE_BUTTON-->/$List/;
	
		$List=qq!<input type="text" name="Street3" size="30" value="$User_Info{'Street3'}" onFocus="select();">!;
		$Out=~ s/<!--STREET3_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Street4" size="30" value="$User_Info{'Street4'}" onFocus="select();">!;
		$Out=~ s/<!--STREET4_BOX-->/$List/;
	
		$List=qq!<input type="text" name="City1" size="30" value="$User_Info{'City1'}" onFocus="select();">!;
		$Out=~ s/<!--CITY1_BOX-->/$List/;

		$List=qq!<input type="text" name="Stat1" size="12" value="$User_Info{'Stat1'}" onFocus="select();">!;
		$Out=~ s/<!--STATE1_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Zip1" size="12" value="$User_Info{'Zip1'}" onFocus="select();">!;
		$Out=~ s/<!--ZIP1_BOX-->/$List/;
	
		$List=qq!<input type="text" name="Country1" size="30" value="$User_Info{'Country1'}" onFocus="select();">!;
		$Out=~ s/<!--COUNTRY1_BOX-->/$List/;
	
	}#end of if require credit card

	else{
		my $S="<!--PAYMENT_START-->";
		my $E="<!--PAYMENT_END-->";
		$Out=~ s/$S(.*)$E//sg;
	}

	$Checked="";
	if ($User_Info{'Prefs_ent'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_ent type=checkbox value=ent $Checked>!;
	$Out=~ s/<!--ENTERTAINMENT_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_hf'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_hf type=checkbox value=hf $Checked>!;
	$Out=~ s/<!--HOME_FAMILY_BUTTON-->/$List/;

	$Checked="";
	if ($User_Info{'Prefs_hth'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_hth type=checkbox value=hlth $Checked>!;
	$Out=~ s/<!--HEALTH_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_mc'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_mc type=checkbox value=mc $Checked>!;
	$Out=~ s/<!--MUSIC_BUTTON-->/$List/;

	$Checked="";
	if ($User_Info{'Prefs_shg'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_shg type=checkbox value=shp $Checked>!;
	$Out=~ s/<!--SHOPPING_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_spt'} ) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_spt type=checkbox value=spt $Checked>!;
	$Out=~ s/<!--SPORT_BUTTON-->/$List/;

	$Checked="";
	if ($User_Info{'Prefs_bs'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_bs type=checkbox value=bs $Checked>!;
	$Out=~ s/<!--BUSINESS_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_pct'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_pct type=checkbox value=pct $Checked>!;
	$Out=~ s/<!--COMPUTERS_BUTTON-->/$List/;

	$Checked="";
	if ($User_Info{'Prefs_en'}) {$Checked="checked";}
	$List=qq!<INPUT name=Prefs_env type=checkbox value=en $Checked>!;
	$Out=~ s/<!--ELECTRONICS_BUTTON-->/$List/;

	$Checked="";
	if ($User_Info{'Prefs_pf'}) {$Checked="checked";}	
	$List=qq!<INPUT name=Prefs_pf type=checkbox value=pf $Checked>!;
	$Out=~ s/<!--PERSONAL_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_sb'} ) {$Checked="checked";}	
	$List=qq!<INPUT name=Prefs_sb type=checkbox value=sb $Checked>!;
	$Out=~ s/<!--SMALL_BUSINESS_BUTTON-->/$List/;
	
	$Checked="";
	if ($User_Info{'Prefs_tvl'} ) {$Checked="checked";}	
	$List=qq!<INPUT name=Prefs_tvl type=checkbox value=tvl $Checked>!;
	$Out=~ s/<!--TRAVEL_BUTTON-->/$List/;
	
	$List=&Gender_Type_EP;
	$Out=~ s/<!--GENDER_BOX-->/$List/;
	
	$List=&Occupation_List_EP;
	$Out=~ s/<!--OCCUPATION_BOX-->/$List/;
	
	$List=&Industry_List_EP;
	$Out=~ s/<!--INDUSTRY_BOX-->/$List/;

	$Checked="";
	if ($User_Info{'Contact_Me'} ) {$Checked="checked";}	
	$List=qq!<INPUT name="Contact_Me" type=checkbox value=yes $Checked>!;
	$Out=~ s/<!--CONTACT_ME_BOX-->/$List/;
	#-----------------------------------------------------------------------------------
	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_button'}/;
	$Out=~ s/<!--CLEAR_FORM_BUTTON-->/$Language{'clear_form_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/;

	return $Out;
}
#==========================================================
sub Save_Edit_Profile{
my($Title, $SameAddress, $msg, $x, %data);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Edit_Profile_File'});

	if ((!$Param{'User_ID'}) || (length($Param{'User_ID'})<5)) {
				$msg.=$Language{'choose_valid_id'};
	 }

	if (!$Param{'FirstName'}) {$msg.=$Language{'error_first_name'};}

	if (!$Param{'MiddleInitial'}) {#$msg.=$Language{'error_middle_initial'};
			$Param{'MiddleInitial'}="";
	}

	if (!$Param{'LastName'}) {$msg.=$Language{'error_last_name'};}
	if (!$Param{'Password'}) {$msg.=$Language{'error_valid_password'};}
	if (!$Param{'PasswordVerify'}) {$msg.=$Language{'error_verify_password'};}
	if ($Param{'Password'} ne $Param{'PasswordVerify'}) {	$msg.=$Language{'error_password_match'};}
	if (length($Param{'Password'})<5) {$msg.=$Language{'error_password_length'};}
	if (!$Param{'Street1'}) {	$msg.=$Language{'error_street_address'};}
	if (!$Param{'City'}) {$msg.=$Language{'error_city'};}
	if (!$Param{'Country'}) {$msg.=$Language{'error_country'};}
	if (!$Param{'Phone'}) {$msg.=$Language{'error_phone'};}

	if (!$Param{'EmailAddress'}) {$msg.=$Language{'error_email'};}
	if (!&Check_Email_Address($Param{'EmailAddress'})) {
			$msg.=$Language{'invalid_email'};
	}

	if ($Global{'Require_Credit_Card'} eq "YES"){
				if (!$Param{'NameOnCard'}) {$msg.=$Language{'error_name_on_cc'};}
				if (!$Param{'CreditCardNumber'}) {	$msg.=$Language{'error_cc_number'};}
				if (!&Verify_Credit_Card($Param{'CardType'}, $Param{'CreditCardNumber'})){
						$msg.=$Language{'invalid_credit_card_number'};
				}

				if ($Param{'BilladdressSame'}) {
						  # Biling address same as above
							$Param{'Street3'}=$Param{'Street1'};
							$Param{'Street4'}=$Param{'Street2'};
							$Param{'City1'}=$Param{'City'};
							$Param{'Stat1'}=$Param{'Stat'};
							$Param{'Zip1'}=$Param{'Zip'};
							$Param{'Country1'}=$Param{'Country'};
			  }
			 else { # Billing address not the same as above address
							if (!$Param{'Street3'}) {$msg.=$Language{'error_billing_Street_address'};} 
							if (!$Param{'City1'}) {$msg.=$Language{'error_billing_city'};}
							if (!$Param{'Country1'}) {$msg.=$Language{'error_billing_country'};}
			}
	} #end of if Require_Credit_Card

	if ($msg) {
					$Plugins{'Body'}=&Msg($Language{'missing_information'}, $msg, 1);
					Display($Global{'General_Template'});
					exit 0;
	}

	if (!$Param{'Prefs_hf'}) {$Param{'Prefs_hf'}="";}
	if (!$Param{'Prefs_hth'}) {$Param{'Prefs_hth'}="";}
	if (!$Param{'Prefs_mc'}) {$Param{'Prefs_mc'}="";}
	if (!$Param{'Prefs_shg'}) {$Param{'Prefs_shg'}="";}
	if (!$Param{'Prefs_spt'}) {$Param{'Prefs_spt'}="";}
	if (!$Param{'Prefs_bs'}) {$Param{'Prefs_bs'}="";}
	if (!$Param{'Prefs_pct'}) {$Param{'Prefs_pct'}="";}
	if (!$Param{'Prefs_env'}) {$Param{'Prefs_env'}="";}
	if (!$Param{'Prefs_pf'}) {$Param{'Prefs_pf'}="";}
	if (!$Param{'Prefs_sb'}) {$Param{'Prefs_sb'}="";}
	if (!$Param{'Prefs_tvl'}) {$Param{'Prefs_tvl'}="";}
	if (!$Param{'Gender'}) {$Param{'Gender'}="";}
	if (!$Param{'Occupation'}) {$Param{'Occupation'}="";}
	if (!$Param{'Industry'}) {$Param{'Industry'}="";}
	if (!$Param{'Contact_Me'}) {$Param{'Contact_Me'}="";}

	$Prefers=join(":",$Param{'Prefs_ent'},$Param{'Prefs_hf'},$Param{'Prefs_hth'},$Param{'Prefs_mc'},
									$Param{'Prefs_shg'},$Param{'Prefs_spt'},	$Param{'Prefs_bs'},$Param{'Prefs_pct'},
									$Param{'Prefs_env'},$Param{'Prefs_pf'},$Param{'Prefs_sb'},$Param{'Prefs_tvl'},
									$Param{'Gender'},$Param{'Occupation'},$Param{'Industry'},$Param{'Contact_Me'});
	$Param{'Prefers'}=$Prefers;
	#------------------------------------------------------------
	if (!$Param{'MiddleInitial'}) {$Param{'MiddleInitial'}="";}
	if (!$Param{'Company'}) {$Param{'Company'}="";}			  
	if (!$Param{'Street2'}) {$Param{'Street2'}="";}			  
	if (!$Param{'Stat'}) {$Param{'Stat'}="";}
	if (!$Param{'Zip'}) {$Param{'Zip'}="";}			  
	if (!$Param{'Extension'}) {$Param{'Extension'}="";}			  
	if (!$Param{'Fax'}) {$Param{'Fax'}="";}			  
	if (!$Param{'PaymentType'}) {$Param{'PaymentType'}="";}			  
	if (!$Param{'NameOnCard'}) {$Param{'NameOnCard'}="";}
	if (!$Param{'CreditCardNumber'}) {$Param{'CreditCardNumber'}="";}			  
	if (!$Param{'CardType'}) {$Param{'CardType'}="";}			  			  
	if (!$Param{'ExpiryMonth'}) {$Param{'ExpiryMonth'}="";}			  
	if (!$Param{'ExpiryYear'}) {$Param{'ExpiryYear'}="";}			  
	if (!$Param{'Street3'}) {$Param{'Street3'}="";}			  
	if (!$Param{'Street4'}) {$Param{'Street4'}="";}			  
	if (!$Param{'City1'}) {$Param{'City1'}="";}			  
	if (!$Param{'Stat1'}) {$Param{'Stat1'}="";}			  
	if (!$Param{'Zip1'}) {$Param{'Zip1'}="";}			  
	if (!$Param{'Country1'}) {$Param{'Country1'}="";}			  

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

	tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDWR | O_CREAT, 0640, $DB_HASH 
			or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$Param{'User_ID'}}=$User_Info;
	untie %data;

	&Update_Total_Users_Count;

	$Msg=$Language{'sign_in_email_message'};
	$Msg=~ s/<!--Name-->/$Param{'FirstName'}/g;
	$Msg=~ s/<!--User_ID-->/$Param{'User_ID'}/g;
	$Msg=~ s/<!--Password-->/$Param{'Password'}/g;

	#Email($From, $TO, $Subject,   $Message);
	&Email($Global{'Auction_Email'}, 
				$Param{'EmailAddress'},
				$Language{'sign_in_email_subject'},
				$Msg);


	$Plugins{'Body'}=&Msg($Language{'congratulations'},  $Language{'change_registration_complete'}, 2);
	Display($Global{'General_Template'});

}
#==========================================================
1;