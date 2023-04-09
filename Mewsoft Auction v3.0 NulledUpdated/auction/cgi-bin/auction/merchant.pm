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
sub Process_Payment{
my(%Customer)=@_;
my($Status, $Reason, $AVS, $Auth_Code, $Trans_ID);

# $Customer{'Test_Request'}"; #TRUE, FALSE
#$Global{'Authorize_Net_Method'} #CC, ECHECK
#$Global{'Authorize_Net_Type'} #AUTH_CAPTURE, AUTH_ONLY, CAPTURE_ONLY, CREDIT, VOID, PRIOR_AUTH_CAPTURE

	if ($Global{'Merchant_Account_Provider'} eq "Authorize_Net") {
				
					($Status, $Reason, $AVS, $Auth_Code, $Trans_ID) = &Process_AuthroizeNet(%Customer);

	}
	elsif ($Global{'Merchant_Account_Provider'} eq "iBill") {
				
					($Status, $Reason, $AVS, $Auth_Code, $Trans_ID) = &Process_iBill(%Customer);

	}
	elsif ($Global{'Merchant_Account_Provider'} eq "Quick_Commerce") {
				
					($Status, $Reason, $AVS, $Auth_Code, $Trans_ID) = &Process_QuickCommerce(%Customer);

	}
	elsif ($Global{'Merchant_Account_Provider'} eq "Planet_Payment") {
				
					($Status, $Reason, $AVS, $Auth_Code, $Trans_ID) = &Process_PlanetPayment(%Customer);

	}
	elsif ($Global{'Merchant_Account_Provider'} eq "PlugnPay") {
				
					($Status, $Reason, $AVS, $Auth_Code, $Trans_ID) = &Process_Plugnpay(%Customer);

	}
	#http://worldpay.com
	return ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID);
}
#==========================================================
sub Process_AuthroizeNet{
# return code ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)
# $Status         : 1 = Approved, 0 = Declined or Error
# $Reason       : Reasons for declined or error
# $AVS            : AVS explanation
# $Auth_Code : 6 digit approval code
# $Trans_ID    : Transaction ID
my(%Customer) = @_;
my($Fields, $Domain, $Sub_Domain);
my(@Response, $Response);
my(%AVS)=(
"A" => "Address (Street) matches, ZIP does not",
"B" => "Address Information Not Provided for AVS Check",
"E" => "AVS error",
"G" => "Non U.S. Card Issuing Bank",
"N" => "No Match on Address (Street) or ZIP",
"P" => "AVS not applicable for this transaction",
"R" => "Retry – System unavailable or timed out",
"S" => "Service not supported by issuer",
"U" => "Address information is unavailable",
"W" => "9 digit ZIP matches, Address (Street) does not",
"X" => "Address (Street) and 9 digit ZIP match",
"Y" => "Address (Street) and 5 digit ZIP match",
"Z" => "5 digit ZIP matches, Address (Street) does not"
);

		$Fields  = "x_ADC_URL=FALSE&";          #for ADC Direct Response
		$Fields .= "x_Version=3.0&"; 
		$Fields .= "x_ADC_Delim_Data=TRUE&"; 
		$Fields .= "x_Card_Num=$Customer{'CC_Number'}&";
		$Fields .= "x_Exp_Date=$Customer{'Exp_Month'}/$Customer{'Exp_Year'}&"; #mmyy, mm/yy, mm/yyyy
		$Fields .= "x_Login=$Global{'Authorize_Net_Login'}&";
		$Fields .= "x_Amount=$Customer{'Amount'}&";
		$Fields .= "x_Password=$Global{'Authorize_Net_Password'}&" if ($Global{'Authorize_Net_Password'});
		$Fields .= "x_Method=$Global{'Authorize_Net_Method'}&" if ($Global{'Authorize_Net_Method'});
		$Fields .= "x_Type=$Global{'Authorize_Net_Type'}&" if ($Global{'Authorize_Net_Type'});
		$Fields .= "x_First_Name=$Customer{'First_Name'}&" if ($Customer{'First_Name'});
		$Fields .= "x_Last_Name=$Customer{'Last_Name'}&" if ($Customer{'Last_Name'});
		$Fields .= "x_Address=$Customer{'Street_Address'}&" if ($Customer{'Street_Address'});
		$Fields .= "x_City=$Customer{'City'}&" if ($Customer{'City'});
		$Fields .= "x_State=$Customer{'State'}&" if ($Customer{'State'});
		$Fields .= "x_Zip=$Customer{'Zip'}&" if ($Customer{'Zip'});
		$Fields .= "x_Country=$Customer{'Country'}&" if ($Customer{'Country'});
		$Fields .= "x_Phone=$Customer{'Phone'}&" if ($Customer{'Phone'});
		$Fields .= "x_Email=$Customer{'Email'}&" if ($Customer{'Email'});
		$Fields .= "x_Company=$Customer{'Company'}&" if ($Customer{'Company'});
		$Fields .= "x_Cust_ID=$Customer{'Cust_ID'}&" if ($Customer{'Cust_ID'});
		$Fields .= "x_Description=$Customer{'Description'}&" if ($Customer{'Description'});
		$Fields .= "x_Email_Customer=$Customer{'Email_Customer'}&" if ($Customer{'Email_Customer'});
		$Fields .= "x_Email_Merchant=$Customer{'Email_Merchant'}&" if ($Customer{'Email_Merchant'});
		$Fields .= "x_Fax=$Customer{'Fax'}&" if ($Customer{'Fax'});
		$Fields .= "x_Invoice_Num=$Customer{'Invoice_Num'}&" if ($Customer{'Invoice_Num'});
		$Fields .= "x_Merchant_Email=$Customer{'Merchant_Email'}&" if ($Customer{'Merchant_Email'});
		$Fields .= "x_Test_Request=$Customer{'Test_Request'}"; #TRUE, FALSE
		$Fields =~ s/ /%20/g;
		#https://secure.authorize.net/gateway/transact.dll

		$Domain = "http://secure.authorize.net";
		$Sub_Domain = "/gateway/transact.dll";

		$Response=&Web_Server($Domain, $Sub_Domain, $Fields);
		@Response=split(",", $Response);
		if ($Response[0] == 1){
				return(1, $Response[3], $AVS{$Response[5]}, $Response[4], $Response[6]);
		}
		else{
				return(0, $Response[3], "@Response", "", "");
		}
}
#==========================================================
sub Process_QuickCommerce{
# return code ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)
# $Status         : 1 = Approved, 0 = Declined or Error
# $Reason       : Reasons for declined or error
# $AVS            : AVS explanation
# $Auth_Code : 6 digit approval code
# $Trans_ID    : Transaction ID
my(%Customer) = @_;
my($Fields, $Domain, $Sub_Domain);
my(@Response, $Response);
my(%AVS)=(
"A" => "Address (Street) matches, ZIP does not",
"E" => "AVS error",
"N" => "No Match on Address (Street) or ZIP",
"R" => "Retry – System unavailable or timed out",
"S" => "Service not supported by issuer",
"U" => "Address information is unavailable",
"W" => "9 digit ZIP matches, Address (Street) does not",
"X" => "Exact AVS Match",
"Y" => "Address (Street) and 5 digit ZIP match",
"Z" => "5 digit ZIP matches, Address (Street) does not"
);

		$Fields  = "x_ADC_URL=FALSE&";          #for ADC Direct Response
		$Fields .= "x_Version=3.0&"; 
		$Fields .= "x_ADC_Delim_Data=TRUE&"; 
		$Fields .= "x_Card_Num=$Customer{'CC_Number'}&";
		$Fields .= "x_Exp_Date=$Customer{'Exp_Month'}$Customer{'Exp_Year'}&"; #mmyy, mm/yy, mm/yyyy
		$Fields .= "x_Login=$Global{'QuickCommerce_Login'}&";
		$Fields .= "x_Amount=$Customer{'Amount'}&";
		$Fields .= "x_Password=$Global{'QuickCommerce_Password'}&" if ($Global{'Authorize_Net_Password'});
		$Fields .= "x_Method=$Global{'Authorize_Net_Method'}&" if ($Global{'Authorize_Net_Method'});
		$Fields .= "x_Type=$Global{'Authorize_Net_Type'}&" if ($Global{'Authorize_Net_Type'});
		$Fields .= "x_First_Name=$Customer{'First_Name'}&" if ($Customer{'First_Name'});
		$Fields .= "x_Last_Name=$Customer{'Last_Name'}&" if ($Customer{'Last_Name'});
		$Fields .= "x_Address=$Customer{'Street_Address'}&" if ($Customer{'Street_Address'});
		$Fields .= "x_City=$Customer{'City'}&" if ($Customer{'City'});
		$Fields .= "x_State=$Customer{'State'}&" if ($Customer{'State'});
		$Fields .= "x_Zip=$Customer{'Zip'}&" if ($Customer{'Zip'});
		$Fields .= "x_Country=$Customer{'Country'}&" if ($Customer{'Country'});
		$Fields .= "x_Phone=$Customer{'Phone'}&" if ($Customer{'Phone'});
		$Fields .= "x_Email=$Customer{'Email'}&" if ($Customer{'Email'});
		$Fields .= "x_Company=$Customer{'Company'}" if ($Customer{'Company'});
		$Fields .= "x_Cust_ID=$Customer{'Cust_ID'}&" if ($Customer{'Cust_ID'});
		$Fields .= "x_Description=$Customer{'Description'}&" if ($Customer{'Description'});
		$Fields .= "x_Email_Customer=$Customer{'Email_Customer'}&" if ($Customer{'Email_Customer'});
		$Fields .= "x_Email_Merchant=$Customer{'Email_Merchant'}&" if ($Customer{'Email_Merchant'});
		$Fields .= "x_Fax=$Customer{'Fax'}&" if ($Customer{'Fax'});
		$Fields .= "x_Invoice_Num=$Customer{'Invoice_Num'}&" if ($Customer{'Invoice_Num'});
		$Fields .= "x_Merchant_Email=$Customer{'Merchant_Email'}&" if ($Customer{'Merchant_Email'});
		$Fields .= "x_Test_Request=$Customer{'Test_Request'}"; #TRUE, FALSE
		$Fields =~ s/ /%20/g;
		#http://www.ecx.com/
		#https://secure.quickcommerce.net/gateway/transact.dll. 

		$Domain = "secure.quickcommerce.net";
		$Sub_Domain = "/gateway/transact.dll";

		$Response=&Web_Server($Domain, $Sub_Domain, $Fields);
		@Response=split(",", $Response);
		if ($Response[0] == 1){
				return(1, $Response[3], $AVS{$Response[5]}, $Response[4], $Response[6]);
		}
		else{
				return(0, $Response[3], "", "", "");
		}
}
#==========================================================
sub Process_PlanetPayment{ 
# return code ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)
# $Status         : 1 = Approved, 0 = Declined or Error
# $Reason       : Reasons for declined or error
# $AVS            : AVS explanation
# $Auth_Code : 6 digit approval code
# $Trans_ID    : Transaction ID
#----------------------------------------------------------
my(%Customer) = @_;
my($Fields, $Domain, $Sub_Domain);
my(@Response, $Response);
my(%AVS)=(
"A" => "Address (Street) matches, ZIP does not",
"B" => "Address Information Not Provided for AVS Check",
"E" => "AVS error",
"G" => "Non U.S. Card Issuing Bank",
"N" => "No Match on Address (Street) or ZIP",
"P" => "AVS not applicable for this transaction",
"R" => "Retry – System unavailable or timed out",
"S" => "Service not supported by issuer",
"U" => "Address information is unavailable",
"W" => "9 digit ZIP matches, Address (Street) does not",
"X" => "Address (Street) and 9 digit ZIP match",
"Y" => "Address (Street) and 5 digit ZIP match",
"Z" => "5 digit ZIP matches, Address (Street) does not"
);

	
		$Fields  = "x_ADC_URL=FALSE&";          #for ADC Direct Response
		$Fields .= "x_Version=3.0&"; 
		$Fields .= "x_ADC_Delim_Data=TRUE&"; 
		$Fields .= "x_Card_Num=$Customer{'CC_Number'}&";
		$Fields .= "x_Exp_Date=$Customer{'Exp_Month'}$Customer{'Exp_Year'}&"; #mmyy, mm/yy, mm/yyyy
		$Fields .= "x_Login=$Global{'PlanetPayment_Login'}&";
		$Fields .= "x_Password=$Global{'PlanetPayment_Password'}&" if ($Global{'Authorize_Net_Password'});
		$Fields .= "x_Method=$Global{'Authorize_Net_Method'}&" if ($Global{'Authorize_Net_Method'});
		$Fields .= "x_Type=$Global{'Authorize_Net_Type'}&" if ($Global{'Authorize_Net_Type'});
		$Fields .= "x_Amount=$Customer{'Amount'}&";
		$Fields .= "x_First_Name=$Customer{'First_Name'}&" if ($Customer{'First_Name'});
		$Fields .= "x_Last_Name=$Customer{'Last_Name'}&" if ($Customer{'Last_Name'});
		$Fields .= "x_Address=$Customer{'Street_Address'}&" if ($Customer{'Street_Address'});
		$Fields .= "x_City=$Customer{'City'}&" if ($Customer{'City'});
		$Fields .= "x_State=$Customer{'State'}&" if ($Customer{'State'});
		$Fields .= "x_Zip=$Customer{'Zip'}&" if ($Customer{'Zip'});
		$Fields .= "x_Country=$Customer{'Country'}&" if ($Customer{'Country'});
		$Fields .= "x_Phone=$Customer{'Phone'}&" if ($Customer{'Phone'});
		$Fields .= "x_Email=$Customer{'Email'}&" if ($Customer{'Email'});
		$Fields .= "x_Company=$Customer{'Company'}&" if ($Customer{'Company'});
		$Fields .= "x_Cust_ID=$Customer{'Cust_ID'}&" if ($Customer{'Cust_ID'});
		$Fields .= "x_Description=$Customer{'Description'}&" if ($Customer{'Description'});
		$Fields .= "x_Email_Customer=$Customer{'Email_Customer'}&" if ($Customer{'Email_Customer'});
		$Fields .= "x_Email_Merchant=$Customer{'Email_Merchant'}&" if ($Customer{'Email_Merchant'});
		$Fields .= "x_Fax=$Customer{'Fax'}&" if ($Customer{'Fax'});
		$Fields .= "x_Invoice_Num=$Customer{'Invoice_Num'}&" if ($Customer{'Invoice_Num'});
		$Fields .= "x_Merchant_Email=$Customer{'Merchant_Email'}&" if ($Customer{'Merchant_Email'});
		$Fields .= "x_Test_Request=$Customer{'Test_Request'}"; #TRUE, FALSE
		$Fields =~ s/ /%20/g;
		#https://secure.planetpayment.com/gateway/transact.dll
		#http://planetpayment.com/

		$Domain = "secure.planetpayment.com";
		$Sub_Domain = "/gateway/transact.dll";
		$Response=&Web_Server($Domain, $Sub_Domain, $Fields);
		@Response=split(",", $Response);
		if ($Response[0] == 1){
				return(1, $Response[3], $AVS{$Response[5]}, $Response[4], $Response[6]);
		}
		else{
				return(0, $Response[3], "", "", "");
		}
}
#==========================================================
sub Process_Plugnpay{ 
# return code ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)
# $Status         : 1 = Approved, 0 = Declined or Error
# $Reason       : Reasons for declined or error
# $AVS            : AVS explanation
# $Auth_Code : 6 digit approval code
# $Trans_ID    : Transaction ID
#----------------------------------------------------------
my(%Customer) = @_;
my($Fields, $Domain, $Sub_Domain);
my(@Response, $Response, %Response);
my(%AVS)=(
"A" => "Address (Street) matches, ZIP does not",
"E" => "Ineligible transaction",
"N" => "No Match on Address (Street) or ZIP",
"R" => "Retry – System unavailable or timed out",
"S" => "Service not supported by issuer",
"U" => "Address information is unavailable",
"W" => "9 digit ZIP matches, Address (Street) does not",
"X" => "Address (Street) and 9 digit ZIP match",
"Y" => "Address (Street) and 5 digit ZIP match",
"Z" => "5 digit ZIP matches, Address (Street) does not"
);

		$Fields = "publisher-name=$Global{'Plugnpay_Login'}&";
		$Fields .= "card-amount=$Customer{'Amount'}&";
		$Fields .= "card-name=$Customer{'Name_On_Card'}&";
		$Fields .= "card-address1=$Customer{'Street_Address'}&";
		$Fields .= "card-city=$Customer{'City'}&";
		$Fields .= "card-state=$Customer{'State'}&";
		$Fields .= "card-zip=$Customer{'Zip'}&";
		$Fields .= "card-country=$Customer{'Country'}&";
		$Fields .= "card-number=$Customer{'CC_Number'}&";
		$Fields .= "card-exp=$Customer{'Exp_Month'}/$Customer{'Exp_Year'}&";
		$Fields .= "publisher-email=$Customer{'Merchant_Email'}";
		$Fields =~ s/ /%20/g;
				
		#https://pay1.plugnpay.com/payment/directlink.cgi
		#http://plugnpay.com/

		$Domain = "pay1.plugnpay.com";
		$Sub_Domain = "/payment/directlink.cgi";
		$Response=&Web_Server($Domain, $Sub_Domain, $Fields);
		@Response=split(/&/, $Response);
		foreach $Response (@Response) {
				($Key, $Value)=split(/=/, $Response);
				$Response{$Key}=$Value;
		}

		if ($Response{'success'} =~ m/yes/i){
				return(1, $Response{'auth-msg'}, $AVS{$Response{'avs-code'}}, $Response{'auth-code'}, $Response{'orderid'});
		}
		else{
				return(0, $Response{'auth-msg'}, "", "", "");
		}
}
#==========================================================
sub Process_iBill{
# return code ($Status, $Reason, $AVS, $Auth_Code, $Trans_ID)
# $Status         : 1 = Approved, 0 = Declined or Error
# $Reason       : Reasons for declined or error
# $AVS            : AVS explanation
# $Auth_Code : 6 digit approval code
# $Trans_ID    : Transaction ID
#----------------------------------------------------------
my(%Customer) = @_;
my($Fields, $Domain, $Sub_Domain);
my(@Response, $Response, %Response);
my(%AVS)=(
"A" => "Address (Street) matches, ZIP does not",
"E" => "Ineligible transaction",
"N" => "No Match on Address (Street) or ZIP",
"R" => "Retry – System unavailable or timed out",
"S" => "Service not supported by issuer",
"U" => "Address information is unavailable",
"W" => "9 digit ZIP matches, Address (Street) does not",
"X" => "Address (Street) and 9 digit ZIP match",
"Y" => "Address (Street) and 5 digit ZIP match",
"Z" => "5 digit ZIP matches, Address (Street) does not"
);

		$Fields = "reqtype=authorize&";
		$Fields .= "account=$Global{'iBill_Login'}&";
		$Fields .= "password=$Global{'iBill_Password'}&";
		$Fields .= "crefnum=$Customer{'Reference_Nnumber '}&";
		$Fields .= "saletype=$Customer{'iBill_Sale_Type'}&"; #value="sale" or "refund" or "preauth"
		$Fields .= "cardnum=$Customer{'CC_Number'}&";
		$Fields .= "cardexp=$Customer{'Exp_Month'}$Customer{'Exp_Year'}&";
		$Fields .= "noc=$Customer{'Name_On_Card'}&";
		$Fields .= "address1=$Customer{'Street_Address'}&";
		$Fields .= "zipcode=$Customer{'Zip'}&";
		$Fields .= "amount=$Customer{'Amount'}&";
		$Fields =~ s/ /%20/g;
		#https://secure.iBill.com/cgi-win/ccard/tpcard.exe
		#http://ibill.com/Support/Setup/Gateway/Default.cfm
		#http://iBill.com/

		$Domain = "secure.ibill.com";
		$Sub_Domain = "/cgi-win/ccard/tpcard.exe";
		$Response=&Web_Server($Domain, $Sub_Domain, $Fields);
		$Response=~ s/\"//g;
		@Response=split(/,/, $Response);

		if ($Response[0] eq "authorized"){
				return(1, $Response[1], $Response[4], "", "");
		}
		else{
				return(0, $Response[1], "", "", "");
		}
}
#==========================================================
#==========================================================
1;
