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
sub Account_Manager{
my (%User_Info, $Template, $Balance, @Transactions);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Account_Manager_File'});

	if 	(&Check_User_Authentication($Param{'User_ID'}, $Param{'Password'}) == 0 ){
			$Plugins{'Body'}=&Msg($Language{'login_error'}, $Language{'login_error_help'}, 1);
			&Display($Global{'General_Template'});
			exit 0;
	}
	
	&Check_User_Login_Cookie;

	$Template =&Translate_File($Global{'Account_Manager_Main_Template'});

	%User_Info = &Get_User_Info($Param{'User_ID'});

	($Balance, @Transactions)  = &Get_User_Transactions($User_Info{'User_ID'});

	if (!$Balance) {$Balance ="0.00";}
	$Curr = $Global{'Currency_Symbol'};

	$Temp = $Curr . $Balance;
	if ($Balance <0) {$Temp = "-" . $Curr . abs($Balance);}
	
	$Template =~ s/<!--Current_Balance-->/$Temp/g;

	$Template =~ s/<!--User_ID-->/$User_Info{'User_ID'}/g;
	$Template =~ s/<!--First_Name-->/$User_Info{'FirstName'}/;
	$Template =~ s/<!--Last_Name-->/$User_Info{'LastName'}/;
	$Template =~ s/<!--Company-->/$User_Info{'Company'}/;
	
	$Temp =$User_Info{'Street1'};
	if ($User_Info{'Street2'}) { $Temp .= " ". $User_Info{'Street2'};}
	$Template =~ s/<!--Street_Address-->/$Temp/;

	$Template =~ s/<!--City-->/$User_Info{'City'}/;
	$Template =~ s/<!--State-->/$User_Info{'Stat'}/;
	$Template =~ s/<!--Zip-->/$User_Info{'Zip'}/;
	$Template =~ s/<!--Country-->/$User_Info{'Country'}/;
	$Template =~ s/<!--Phone-->/$User_Info{'Phone'}/;
	$Template =~ s/<!--Email-->/$User_Info{'EmailAddress'}/;

	if (!$User_Info{'PaymentType'}) {$User_Info{'PaymentType'}="";}
	$Template =~ s/<!--Payment_Menthod-->/$User_Info{'PaymentType'}/;
	if (!$User_Info{'NameOnCard'}) {$User_Info{'NameOnCard'}="";	}
	$Template =~ s/<!--CC_Name-->/$User_Info{'NameOnCard'}/;

	if (!$User_Info{'CreditCardNumber'}) {$User_Info{'CreditCardNumber'}="";}
	if (!$User_Info{'CardType'}) {$User_Info{'CardType'}="";}
	if (!$User_Info{'ExpiryMonth'}) {$User_Info{'ExpiryMonth'}="";}
	if (!$User_Info{'ExpiryYear'}) {$User_Info{'ExpiryYear'}="";}
	$Temp = substr($User_Info{'CreditCardNumber'}, -4, 4);
	$Temp .=", $User_Info{'ExpiryMonth'}/$User_Info{'ExpiryYear'}, $User_Info{'CardType'}";
	if (!$User_Info{'CreditCardNumber'}) {$Temp="-";}
	$Template =~ s/<!--CC_Info-->/$Temp/;

	$Plugins{'Body'} = $Template;
	&Display($Global{'Account_Manager_Template'});
}
#==========================================================
sub Account_Activity{
my (%User_Info, $Template, $Curr, $Transactions_Count);
my($Balance, @Transactions, @Row, $Last_Page);
my($Current_Page, $Next_Page, $Previous_Page);
my($Next_Page_Link, $Previous_Page_Link);
my($Table, $Class, $Temp, $Counter, $Start_Item, $End_Item);
my($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);

	if (!&Check_Previous_User_Login) {&Account_Manager_Login; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Account_Manager_File'});
	
	$Curr = $Global{'Currency_Symbol'};

	$Template = &Translate_File($Global{'Account_Manager_Activity_Template'});

	%User_Info = &Get_User_Info($Param{'User_ID'});

	($Balance, @Transactions)  = &Get_User_Transactions($User_Info{'User_ID'});
	$Transactions_Count = @Transactions;

	if (!$Balance) {$Balance ="0.00";}
	$Temp = $Curr . $Balance;
	if ($Balance <0) {$Temp = "-" . $Curr . abs($Balance);}
	$Template =~ s/<!--Current_Balance-->/$Temp/g;

	$Template =~ s/<!--User_ID-->/$User_Info{'User_ID'}/g;
	
	@Row = ($Global{'Account_Activity_Table_Row'}, $Global{'Account_Activity_Table_Row1'});
	#------------------------------------------------------
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}
	$Last_Page = int($Transactions_Count / $Global{'Transactions_Per_Page'});
	if (($Transactions_Count % $Global{'Transactions_Per_Page'})) { $Last_Page++; }

	$Current_Page=$Param{'Page'};
	$Next_Page=($Current_Page + 1);
	$Previous_Page = ($Current_Page - 1);
	if ($Next_Page > $Last_Page) {
			$Next_Page=$Last_Page;
	}

	$Next_Page_Link = qq!<A HREF="$Script_URL?action=Account_Activity&$Lang=$Param{'Language'}&Page=$Next_Page">$Language{'next_page_label'}</A>!;
	if ($Current_Page == $Last_Page || $Transactions_Count <= 0) {
			$Plugins{'Next_Page'}=$Language{'next_page_label'};
	}
	else{
			$Plugins{'Next_Page'}=$Next_Page_Link;
	}
	$Template =~ s/<!--Next_Page-->/$Plugins{'Next_Page'}/g;
	
	$Previous_Page_Link = qq!<A HREF="$Script_URL?action=Account_Activity&$Lang=$Param{'Language'}&Page=$Previous_Page">$Language{'previous_page_label'}</A>!;
	if ($Current_Page == 1) {
			$Plugins{'Previous_Page'}=$Language{'previous_page_label'};
	}
	else{
			$Plugins{'Previous_Page'}=$Previous_Page_Link;
	}
	$Template =~ s/<!--Previous_Page-->/$Plugins{'Previous_Page'}/g;
	#------------------------------------------------------
	$Temp = $Language{'showing_transactions_page'};
	$Temp =~ s/<!--Current_Page-->/$Current_Page/g;
	$Temp =~ s/<!--Total_Pages-->/$Last_Page/g;
	$Temp =~ s/<!--Total_Transactions-->/$Transactions_Count/g;
	$Template =~ s/<!--Showing_Page-->/$Temp/g;
	#------------------------------------------------------
	$Start_Item = ($Current_Page -1) * $Global{'Transactions_Per_Page'};
	$End_Item = $Start_Item + $Global{'Transactions_Per_Page'};
	if ($End_Item > $Transactions_Count) {$End_Item = $Transactions_Count;}

	$Table = "";
	for $Counter ($Start_Item..$End_Item-1) {
				$Row = $Row[int($Counter % 2)];
				$Temp = $Counter + 1;
				$Row =~ s/<!--COUNTER-->/$Temp/;

				$Row=~ m/(<!--)(DATE)(:)(\d{1,3})(-->)/i;
				$Class = $1 . $2 . $3 . $4 . $5;
				$Temp = &Get_Date_Formated($4, $Transactions[$Counter]{'Date'});
				if (!$Temp) {$Temp = " -";	}
				$Row =~ s/$Class/$Temp/;
				#------------------------------------------
				#Registratoin = 1; Post item = 2;user direct deposit = 3; admin desposit = 4, admin debit = 5;
				$Temp = "";
				if ($Transactions[$Counter]{'Transaction_Type'} == 1) {#Registratoin = 1
							$Temp = $Language{'transaction_new_account'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 2) {#Post item = 2
							$Temp = $Language{'transaction_post_item'};												
							($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS) = split( "~", $Transactions[$Counter]{'Details'});
							$RG = &Format_Decimal($RG);
							$Temp =~ s/<!--Regular_Fee-->/$RG/;
							$TF = &Format_Decimal($TF);
							$Temp =~ s/<!--Title_Fee-->/$TF/;
							$FH = &Format_Decimal($FH);
							$Temp =~ s/<!--Featured_Homepage_Fee-->/$FH/;
							$FC = &Format_Decimal($FC);
							$Temp =~ s/<!--Featured_Category_Fee-->/$FC/;
							$GI = &Format_Decimal($GI);
							$Temp =~ s/<!--Gift_Icon_Fee-->/$GI/;
							$FU = &Format_Decimal($FU);
							$Temp =~ s/<!--Files_Uploaded_Fee-->/$FU/;
							$RS = &Format_Decimal($RS);
							$Temp =~ s/<!--Reserve_Fee-->/$RS/;
							$Total_Fees = &Format_Decimal($Total_Fees);
							$Temp =~ s/<!--Total_Fees-->/$Total_Fees/;
							$Temp =~ s/<!--Currency-->/$Curr/g;
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 3) {#closed item fee, final value
							$Temp = $Language{'transaction_final_value_fee'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 4) {#reserve credit
							$Temp = $Language{'transaction_reserve_credit'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 5) {#relisted item fee
						#	$Temp = $Language{'transaction_user_deposit'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 6) {#user direct deposit
						#	$Temp = $Language{'transaction_user_deposit'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 7) {#admin desposit
							$Temp = $Language{'transaction_admin_deposit'};
				}
				elsif ($Transactions[$Counter]{'Transaction_Type'} == 8) {#admin desposit
							$Temp = $Language{'transaction_admin_debit'};
				}
				else {#unknown
							$Temp = "&nbsp;";
				}

				$Row =~ s/<!--TRANSACTION-->/$Temp/;
				#------------------------------------------
				if (!$Transactions[$Counter]{'Item'}) {$Transactions[$Counter]{'Item'} = "&nbsp;";}
				$Row =~ s/<!--ITEM-->/$Transactions[$Counter]{'Item'}/;

				if (!$Transactions[$Counter]{'Credit'}) {$Transactions[$Counter]{'Credit'} = 0;}
				if ($Transactions[$Counter]{'Credit'} < 0) {$Sign = "-";}else{$Sign = "";}
				$Temp = &Format_Decimal(abs($Transactions[$Counter]{'Credit'}));
				$Temp =$Sign . $Curr . $Temp;
				if (!$Transactions[$Counter]{'Credit'}) {$Temp ="&nbsp;";}
				$Row =~ s/<!--CREDIT-->/$Temp/;

				if (!$Transactions[$Counter]{'Debit'}) {$Transactions[$Counter]{'Debit'} = 0;}
				if ($Transactions[$Counter]{'Debit'} < 0) {$Sign = "-";}else{$Sign = "";}
				$Temp = &Format_Decimal(abs($Transactions[$Counter]{'Debit'}));
				$Temp =$Sign . $Curr . $Temp;
				if (!$Transactions[$Counter]{'Debit'}) {$Temp ="&nbsp;";}
				$Row =~ s/<!--DEBIT-->/$Temp/;

				if (!$Transactions[$Counter]{'Balance'}) {$Transactions[$Counter]{'Balance'} = 0;}
				if ($Transactions[$Counter]{'Balance'} < 0) {$Sign = "-";}
				$Temp = &Format_Decimal(abs($Transactions[$Counter]{'Balance'}));
				$Temp =$Sign . $Curr . $Temp;
				$Row =~ s/<!--BALANCE-->/$Temp/;
	
				$Table .= $Row;
	}
	#------------------------------------------------------
	if ($Transactions_Count<=0) {
			$Table = "";
			$Template =~ s/<!--No_Transaction-->/$Language{'no_transaction_label'}/;
	}

	$Template =~ s/<!--CLASS::Activity_List-->/$Table/g;

	$Plugins{'Body'} = $Template;
	&Display($Global{'Account_Manager_Template'});
}
#==========================================================
sub Get_User_Transactions{
my($User_ID) = @_;
my(%Balance, %Transactions, $Line);
my($Transactions, $Balance, @All);
my(@Transactions, $Counter);

	&DB_Exist($Global{'Transactions_File'});
	tie %Transactions, "DB_File", $Global{'Transactions_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$Transactions{$User_ID}) {$Transactions{$User_ID} = "";}
	$Transactions = $Transactions{$User_ID};
	untie %Transactions;
	undef %Transactions;

	&DB_Exist($Global{'Balance_File'});
	tie %Balance, "DB_File", $Global{'Balance_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!$Balance{$User_ID}) {$Balance{$User_ID} = 0;}
	$Balance = $Balance{$User_ID};
	untie %Balance;
	undef %Balance;

	@All = split('\~\|\~', $Transactions);
	$Counter = 0;
	foreach $Line(@All) {                            #($Date, $Transaction_Type, $Item, $Credit, $Debit, $Balance, $Details)
			@{$Transactions[$Counter++]}{qw(Date Transaction_Type Item Credit Debit  Balance Details)}=split('::', $Line);
	}

	@Transactions = sort { $b->{'Date'} <=> $a->{'Date'} } @Transactions;

	if (!$Transactions) {undef @Transactions;}
	return ($Balance, @Transactions);

}
#==========================================================
sub Post_User_Transaction{
my($User_ID, $Date, $Transaction_Type, $Item, $Credit, $Debit, $Details) = @_;
my($New_Transaction, %Transactions, %Balance, $Balance);
	
	if (!$User_ID) {return 0;}
	if (!$Date){$Date = &Time(time);}
	if (!$Transaction_Type){$Transaction_Type = 0;}
	if (!$Item) {$Item = "";}
	if (!$Credit){$Credit = 0;}
	if (!$Debit) {$Debit = 0;}
	if (!$Details) {$Details = "";	}
	
	$Debit = abs($Debit);
	$Debit = $Debit * -1;
	#------------------------------------------------------	
	if (!&Lock($Global{'Balance_File'})) {&Exit("Cannot Lock database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Balance, "DB_File", $Global{'Balance_File'}
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!$Balance{$User_ID}) {$Balance{$User_ID} = 0;}
	$Balance{$User_ID} += $Credit + $Debit;
	$Balance = $Balance{$User_ID};
	untie %Balance;
	undef %Balance;
	&Unlock($Global{'Balance_File'});
	#------------------------------------------------------
	$New_Transaction = join('::', ($Date, $Transaction_Type, $Item, $Credit, $Debit, $Balance, $Details));
	if (!&Lock($Global{'Transactions_File'})) {&Exit("Cannot Lock database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Transactions, "DB_File", $Global{'Transactions_File'}
						or &Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$Transactions{$User_ID}) {
				$Transactions{$User_ID} = $New_Transaction;
	}
	else{
				$Transactions{$User_ID} .= '~|~' . $New_Transaction;
	}
	untie %Transactions;
	undef %Transactions;
	&Unlock($Global{'Transactions_File'});
}
#==========================================================
sub Initialize_Fee_Parameters{

	@Regular_Fees_From=split(/\:/, $Global{'Regular_Fees_From'});
	@Regular_Fees_To=split(/\:/, $Global{'Regular_Fees_To'});
	@Regular_Fees_Fee=split(/\:/, $Global{'Regular_Fees_Fee'});
	
	@Reserve_Fees_From=split(/\:/, $Global{'Reserve_Fees_From'});
	@Reserve_Fees_To=split(/\:/, $Global{'Reserve_Fees_To'});
	@Reserve_Fees_Fee=split(/\:/, $Global{'Reserve_Fees_Fee'});

	@Final_Fees_From=split(/\:/, $Global{'Final_Fees_From'});
	@Final_Fees_To=split(/\:/, $Global{'Final_Fees_To'});
	@Final_Fees_Fee=split(/\:/, $Global{'Final_Fees_Fee'});

	if (!$Global{'Title_Enhancement_Fee'}) {$Global{'Title_Enhancement_Fee'} = 0;}
	if (!$Global{'Home_Page_Featured_Fee'}) {$Global{'Home_Page_Featured_Fee'} = 0;}
	if (!$Global{'Category_Featured_Fee'}) {$Global{'Category_Featured_Fee'} = 0;}
	if (!$Global{'Gift_Icon_Fee'}) {$Global{'Gift_Icon_Fee'} = 0;}
	if (!$Global{'Upload_One_File_Fee'}) {$Global{'Upload_One_File_Fee'} = 0;}
	if (!$Global{'Upload_Two_File_Fee'}) {$Global{'Upload_Two_File_Fee'} = 0;}
	if (!$Global{'Upload_Three_File_Fee'}) {$Global{'Upload_Three_File_Fee'} = 0;}
	if (!$Global{'Upload_Four_File_Fee'}) {$Global{'Upload_Four_File_Fee'} = 0;}
	if (!$Global{'Upload_Five_File_Fee'}) {$Global{'Upload_Five_File_Fee'} = 0;}
	if (!$Global{'Dutch_Max_Regular_Fees'}) {$Global{'Dutch_Max_Regular_Fees'} = 0;}
	if (!$Global{'Submit_Charge'}) {$Global{'Submit_Charge'} = 0;}

}
#==========================================================
sub Calculate_Open_Auction_Fee{
my($Title_Enhancement, $Featured_Homepage, $Featured_Category, $Gift_Icon, $Uploaded_Files, $Start_Bid, $Quantity, $Reserve, $BuyPrice, $Duration) = @_;
my($x, $Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);

	if ($Global{'Charge_For_Submitting'} eq "YES"){ 
					$Total_Fees = $Global{'Submit_Charge'};
					$TF = 0; $FH = 0;
					$FC = 0; $GI = 0;
					$FU = 0; $RG = 0;
					$RS = 0;
					return ($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);
	}

	$Total_Fees = 0; $TF = 0;
	if ($Title_Enhancement > 0) { 
					$Total_Fees += $Global{'Title_Enhancement_Fee'}; 
					$TF = $Global{'Title_Enhancement_Fee'};
	}

	$FH=0;
	if ($Featured_Homepage){	
					$Total_Fees += $Global{'Home_Page_Featured_Fee'}; 
					$FH = $Global{'Home_Page_Featured_Fee'}; 
	}
	
	$FC=0;
	if ($Featured_Category){
				$Total_Fees += $Global{'Category_Featured_Fee'}; 
				$FC = $Global{'Category_Featured_Fee'}; 
	}
				
	$GI=0;
	if ($Gift_Icon){
						$Total_Fees += $Global{'Gift_Icon_Fee'};
						$GI = $Global{'Gift_Icon_Fee'};
	}
				
	$FU=0;
	if ($Uploaded_Files){
			@Photos=split(/\|/, $Uploaded_Files);
			$Uploads=@Photos;
			if ($Uploads == 1) {$Total_Fees +=$Global{'Upload_One_File_Fee'}; $FU=$Global{'Upload_One_File_Fee'};}
			if ($Uploads == 2) {$Total_Fees +=$Global{'Upload_Two_File_Fee'};$FU=$Global{'Upload_Two_File_Fee'};}
			if ($Uploads == 3) {$Total_Fees +=$Global{'Upload_Three_File_Fee'};$FU=$Global{'Upload_Three_File_Fee'};}
			if ($Uploads == 4) {$Total_Fees +=$Global{'Upload_Four_File_Fee'};$FU=$Global{'Upload_Four_File_Fee'};}
			if ($Uploads >= 5) {$Total_Fees +=($Global{'Upload_Five_File_Fee'} * $Uploads);$FU=($Global{'Upload_Five_File_Fee'} * $Uploads);}
	}

	$RG=0;
	for $x(0..$#Regular_Fees_From) {
			if ($Start_Bid >= $Regular_Fees_From[$x] && $Start_Bid <= $Regular_Fees_To[$x]) {
					$Temp = $Regular_Fees_Fee[$x] * $Quantity;
					if ($Temp > $Global{'Dutch_Max_Regular_Fees'}){
								$Temp = $Global{'Dutch_Max_Regular_Fees'};
					}
					$RG=$Temp;
					$Total_Fees +=$Temp; 
					last;
			}
	}

	$RS=0;
	if ($Reserve) {
			for $x(0..$#Reserve_Fees_From) {
						if ($Reserve > $Reserve_Fees_From[$x] &&  $Reserve < $Reserve_Fees_To[$x]) {
							$Total_Fees += $Reserve_Fees_Fee[$x];
							$RS = $Reserve_Fees_Fee[$x];
							last;
						}
			}
	}

	return ($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);
}
#==========================================================
sub Account_View_Feedback{
	
	if (!&Check_Previous_User_Login) {&Account_Manager_Login; return;}

	&View_Feedback($Param{'User_ID'});

}
#==========================================================
sub Create_Billing_File{
my(%Users, %Fields, @Fields_Order, @Text, $Line);
my($Date, $Transaction_Type, $Item, $Credit, $Debit, $Balance, $Details);
my($Encapsulation, $Delimiter, $Total_Balance, $Total_Accounts_Balance);
my(%Transactions, %Transactionsx, %Balance, %Balancex);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

	%Users = &Get_Users;
	#------------------------------------------------------
	eval("use Time::Local");
	$mday = $Param{'Start_Day'};
	$mon = $Param{'Start_Month'} - 1;
	$year = $Param{'Start_Year'} - 1900;
	$Time = timelocal(0,0,0,$mday,$mon,$year);
	$Time = &Time($Time);
	$From_Time =$Time;
	$Start_Time = &Curent_Date_Time($Time);

	$mday = $Param{'End_Date'};
	$mon = $Param{'End_Month'} - 1;
	$year = $Param{'End_Year'} - 1900;
	$Time = timelocal(59,59,23,$mday,$mon,$year);
	$Time = int($Time + $Global{'GMT_Offset'} * 3600);
	$To_Time = &Time($Time);
	$End_Time = &Curent_Date_Time($Time);
	#------------------------------------------------------
	$Encapsulation = $Global{'Billing_Encapsulation'};
	$Encapsulation =~ s/\&quot\;/\"/;
	$Delimiter = $Global{'Billing_Delimiting'};
	$Delimiter =~ s/\&quot\;/\"/;
	#------------------------------------------------------
	$Text[1]="User ID: ";
	$Text[2]="Balance: ";
	$Text[3]="First name: ";
	$Text[4]="M.I.: ";
	$Text[5]="Last name: ";
	$Text[6]="Company: ";
	$Text[7]="Street Address: ";
	$Text[8]="City: ";
	$Text[9]="State: ";
	$Text[10]="Zip: ";
	$Text[11]="Country: ";
	$Text[12]="Phone: ";
	$Text[13]="Fax: ";
	$Text[14]="Email: ";
	$Text[15]="Credit Card #: ";
	$Text[16]="Name on Card: ";
	$Text[17]="Expiration Date: ";
	$Text[18]="Billing Street Address: ";
	$Text[19]="Billing City: ";
	$Text[20]="Billing State: ";
	$Text[21]="Billing Zip: ";
	$Text[22]="Billing Country: ";
	$Text[23]=$Global{'Billing_Custom_Filed_1'};
	$Text[24]=$Global{'Billing_Custom_Filed_2'};
	$Text[25]=$Global{'Billing_Custom_Filed_3'};
	$Text[26]=$Global{'Billing_Custom_Filed_4'};
	$Text[27]=$Global{'Billing_Custom_Filed_5'};
	#-----------------------------------------------------------------------------
	@Fields_Order = split(":", $Global{'Billing_Fields_Order'});

	&DB_Exist($Global{'Transactions_File'});
	tie %Transactionsx, "DB_File", $Global{'Transactions_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%Transactions = %Transactionsx;
	untie %Transactionsx;
	undef %Transactionsx;

	&DB_Exist($Global{'Balance_File'});
	tie %Balancex, "DB_File", $Global{'Balance_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	%Balance = %Balancex;
	untie %Balancex;
	undef %Balancex;

	open(FEE, ">$Global{'Billing_Fees_File'}") or &Exit("can't create file: $Global{'Billing_Fees_File'}");

	$Total_Accounts_Balance = 0;

	while (($User_ID, $Transactions) = each(%Transactions)) {
				@All = split('\~\|\~', $Transactions);
				$Total_Balance = 0;
				foreach $Line(@All) {                            #($Date, $Transaction_Type, $Item, $Credit, $Debit, $Balance, $Details)
						($Date, $Transaction_Type, $Item, $Credit, $Debit, $Balance, $Details) = split('::', $Line);
						if ($Date > $From_Time && $Date < $To_Time) {
								$Total_Balance += $Credit + $Debit;
						}
				}

				if ($Global{'Skip_Zero_Balance_Accounts'}){if ($Total_Balance >= 0 ){next;}}
				$Total_Accounts_Balance += $Total_Balance;
				
				($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
					$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf ) = split(/\|/, $Users{$User_ID} );
				
				$Fields{'1'} = $UN;
				$Fields{'2'} = $Total_Balance;
				$Fields{'3'} = $FN;
				$Fields{'4'} = $MI;
				$Fields{'5'} = $LN;
				$Fields{'6'} = $CM;
				$Fields{'7'} = $S1;
				if ($S2) {$Fields{'7'} .= " $S2";}
				$Fields{'8'} = $CT;
				$Fields{'9'} = $ST;
				$Fields{'10'} = $Z;
				$Fields{'11'} = $CY;
				$Fields{'12'} = $PH;
				$Fields{'13'} = $FX;
				$Fields{'14'} = $EM;
				$Fields{'15'} = $CCN;
				$Fields{'16'} = $NOC;
				$Fields{'17'} = "$EXM/$EY";
				$Fields{'18'} = "$S3";
				if ($S4) {$Fields{'18'} .= " $S4";}
				$Fields{'19'} = $CT1;
				$Fields{'20'} = $ST1;
				$Fields{'21'} = $Z1;
				$Fields{'22'} = $CY1;
				$Fields{'23'} = $Global{'Billing_Custom_Filed_1'};
				$Fields{'24'} = $Global{'Billing_Custom_Filed_2'};
				$Fields{'25'} = $Global{'Billing_Custom_Filed_3'};
				$Fields{'26'} = $Global{'Billing_Custom_Filed_4'};
				$Fields{'27'} = $Global{'Billing_Custom_Filed_5'};

				$Fields_Line = "";
				for $Count(0..27) {
							if ($Fields_Order[$Count] > 0) {
										$Fields_Line .= $Encapsulation . $Fields{$Count+1}. $Encapsulation . $Delimiter;
							}
				}

				$Fields_Line =~ s/$Delimiter$//;

				print FEE "$Fields_Line\n";
	}#end while
	close FEE;
	#----------------------------------------------------------
	&Admin_Msg("Billing File Created", "The billing file for the specified time period created.<br> Start date: $Start_Time<br>End date: $End_Time<br>Total balance due: $Global{'Currency_Symbol'}$Total_Accounts_Balance<br>", 1);
}
#==========================================================
sub Calculate_Closed_Auction_Fee{
my($Quantity, $Reserve, $Current_Bid, $Increment, $Bids) = @_;
my($Final_Price, $Reserve_Fee, $Final_Value_Fee);

	$Reserve_Fee = 0;
	$Final_Value_Fee = 0;

	if (($Reserve) &&  ($Quantity == 1)) {
		if ($Current_Bid >= $Reserve){
			for $x(0..$#Reserve_Fees_From) {
				if ($Reserve > $Reserve_Fees_From[$x] &&  $Reserve < $Reserve_Fees_To[$x]) {
					$Reserve_Fee = $Reserve_Fees_Fee[$x];
					last;
				}
			}
		}
	}
		
	if ($Bids > 0) {
		$Final_Price = $Current_Bid - $Increment;
		for $x(0..$#Final_Fees_From){
			if ($Final_Price > $Final_Fees_From[$x] &&  $Final_Price < $Final_Fees_To[$x]) {
				$Temp = (($Final_Fees_Fee[$x]/100) * $Final_Price)* $Quantity;
				$Final_Value_Fee = $Temp;
				last;
			}
		}
	}

	if ($Global{'Charge_For_Submitting'} eq "YES"){$Final_Value_Fee = 0; $Reserve_Fee = 0;}

	return ($Final_Value_Fee, $Reserve_Fee);
	
}
#==========================================================
sub Update_Accounts_Balances{
my($Credit, $Debit) = @_;
my(%Credit, %Debit, %Balance, %Transactions);

	%Credit =%{$Credit};
	%Debit =%{$Debit};

	if (!&Lock($Global{'Balance_File'})) {&Exit("Cannot Lock database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Balance, "DB_File", $Global{'Balance_File'}
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!&Lock($Global{'Transactions_File'})) {&Exit("Cannot Lock database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Transactions, "DB_File", $Global{'Transactions_File'}
						or &Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	$Date =&Time(time);
	$Transaction_Type = 7;
	$Item  = ""; $Details = "";
	while (($User_ID, $Deposit)=each %Credit) {
			if (!$Credit{$User_ID}) {$Credit{$User_ID} = 0;}
			if (!$Debit{$User_ID}) {$Debit{$User_ID} = 0;}

			$Credit = $Credit{$User_ID};
			$Debit = $Debit{$User_ID};

			if (!$Balance{$User_ID}) {$Balance{$User_ID} = 0;}

			if ($Credit) {
					$Balance{$User_ID} += $Credit;
					$Balance = $Balance{$User_ID};
					#------------------------------------------------------
					$New_Transaction = join('::', ($Date, 7, $Item, $Credit, 0, $Balance, $Details));

					if (!$Transactions{$User_ID}) {
								$Transactions{$User_ID} = $New_Transaction;
					}
					else{
								$Transactions{$User_ID} .= '~|~' . $New_Transaction;
					}
			}

			if ($Debit) {
					$Balance{$User_ID} += $Debit;
					$Balance = $Balance{$User_ID};
					$New_Transaction = join('::', ($Date, 8, $Item, 0, $Debit, $Balance, $Details));

					if (!$Transactions{$User_ID}) {
								$Transactions{$User_ID} = $New_Transaction;
					}
					else{
								$Transactions{$User_ID} .= '~|~' . $New_Transaction;
					}
			}

	}
	untie %Balance;
	untie %Transactions;
	&Unlock($Global{'Balance_File'});
	&Unlock($Global{'Transactions_File'});
}
#==========================================================
sub Delete_Accounts_Activities{
my(@Users_IDs) = @_;

	if (!&Lock($Global{'Balance_File'})) {&Exit("Cannot Lock database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Balance, "DB_File", $Global{'Balance_File'}
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!&Lock($Global{'Transactions_File'})) {&Exit("Cannot Lock database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Transactions, "DB_File", $Global{'Transactions_File'}
						or &Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	foreach $User_ID (@Users_IDs) {
		if ($Balance{$User_ID}) {delete $Balance{$User_ID};}
		if ($Transactions{$User_ID}) {delete $Transactions{$User_ID};}
	}

	untie %Balance;
	untie %Transactions;
	&Unlock($Global{'Balance_File'});
	&Unlock($Global{'Transactions_File'});
}
#==========================================================
1;
