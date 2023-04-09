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
sub Process_Bid{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Bidding_File'});

	$Param{'User_ID'}=$Param{'Bidder_ID'};

	if 	(&Check_User_Authentication($Param{'Bidder_ID'}, $Param{'Password'}) == 0 ){
			$Plugins{'Body'}=&Msg($Language{'login_error'}, $Language{'login_error_help'}, 1);
			&Display($Global{'General_Template'});
			exit 0;
	}
	
	&Check_User_Login_Cookie;

	&Get_Item($Param{'Item_ID'});

	if ($Param{'Bidder_ID'} eq $Item_Info[0]{'User_ID'}) {
		$Plugins{'Body'}=&Msg($Language{'invalid_bid'}, $Language{'cannot_bid_on_your_items'}, 1);
		&Display($Global{'General_Template'});
		exit;
	}

	if ($Param{'Item_Qty'} == 1 ) {
			&New_Single_Item_Bid;
	}
	else{
			&New_Dutch_Auction_Bid;
	}

	return;
}
#==========================================================
sub Get_Lowest_Bid{
my ($Low_ID, $Low_Bid);

	($Low_ID, $Low_Bid)=(each %Bidder_Bid);

	while ( ($ID, $Bid) = (each %Bidder_Bid) ) {
			if ($Bid < $Low_Bid) {
					$Low_ID=$ID;
					$Low_Bid=$Bid;
			}
			elsif ($Bid == $Low_Bid) {
					if ($Bidder_Bid_Time{$ID} > $Bidder_Bid_Time{$Low_ID}) {
							$Low_ID=$ID;
							$Low_Bid=$Bid;
					}
			}
	}

	return ($Low_ID, $Bidder_Win_Qty{$Low_ID}, $Low_Bid);
}
#==========================================================
sub New_Single_Item_Bid{
my ($Item_ID, %data, $Item);

	$Item_ID=$Param{'Item_ID'};
	$New_Bid=$Param{'New_Bid'};
	$New_User_ID=$Param{'Bidder_ID'};
	$New_Bid_Quantity=$Param{'New_Bid_Quantity'};

	$Item=&Get_Item_Bids($Item_ID);

	#($Item_ID, $Qty, $Start_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
	
	if ($New_Bid < $Current_Bid) {
		$Out=&Msg($Language{'invalid_bid'}, $Language{'invalid_bid_help'}, 2);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}
	
	undef $Out_Bidder_Email;

	@All_Bids = split(/=/, $Bids);
	if (@All_Bids > 0) { #Archive last bid
			$Last_Bid=pop @All_Bids;
			($Status, $User_ID, $Email, $Bid_Qty, $Win_Qty, $Bid_Time, $Bid, $Proxy, $Max_Bid)=split(/\:/, $Last_Bid);
			$Status=0;
			$Bids=join(":", ($Status, $User_ID, $Email, $Bid_Qty, $Win_Qty, $Bid_Time, $Bid, $Proxy, $Max_Bid));
			push (@All_Bids, $Bids);
			$Out_Bidder_Email=$Email;
			$Out_Bidder_Bid=$Bid;
			$Out_Bidder_Bid_Time = $Bid_Time;
	}

	$Status=1;
	($New_Bidder_Email, $Name)=&Get_User_Email_and_Name($New_User_ID);
	$Bid_Qty=1;
	$Win_Qty=1;
	$Bid_Time=&Time(time);
	$Success_Bid_Time=$Bid_Time;
	$Proxy=0; 
	$Bid=$New_Bid;
	$Max_Bid=$New_Bid;
	$User_ID=$New_User_ID;
	$Email=$New_Bidder_Email;
	$Current_Bid= $New_Bid + $Bid_Increment;

	$Bids=join(":", ($Status, $User_ID, $Email, $Bid_Qty, $Win_Qty, $Bid_Time, $Bid, $Proxy, $Max_Bid));
	push (@All_Bids, $Bids);
	$Bids=join("=", @All_Bids);
	$Number_of_Bids=@All_Bids;
	#	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	$Item=join("|", 	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Number_of_Bids, $Bids));

	&Save_Item_Bids($Item_ID, $Item);

	&Update_Item_Current_Bid($Item_ID, $Current_Bid, $Number_of_Bids);
	
	&Check_Buy_Item($Item_ID);
	
	if ($Out_Bidder_Email) {
			&Email_Out_Bid($Item_ID, $Out_Bidder_Email, $Out_Bidder_Bid, $Current_Bid, $Out_Bidder_Bid_Time);
	}
	&Email_Success_Bid($Item_ID, $New_Bidder_Email, $New_Bid, $Current_Bid, $Success_Bid_Time);
	
	$Out=&Msg($Language{'bid_success_title'}, $Language{'bid_success_help'},3);
	$Plugins{'Body'}=$Out;
	&Display($Global{'General_Template'});
}
#==========================================================
sub Sort_All_Bids{

	@Bidders = sort { $b->{'Bid'} <=> $a->{'Bid'} 
								or $a->{'Bid_Time'} <=> $b->{'Bid_Time'} } @Bidders;

}
#==========================================================
sub New_Dutch_Auction_Bid{
my ($Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids);
my (%data, $Item);

	$Item_ID= $Param{'Item_ID'};
	$Cat_ID = $Param{'Cat_ID'};
	$New_Bid = $Param{'New_Bid'};
	$New_Bid_Quantity = $Param{'New_Bid_Quantity'};
	$Item_Title = $Param{'Item_Title'};
	$Item_Qty=$Param{'Item_Qty'};
	$New_User_ID=$Param{'Bidder_ID'};

	$Item=&Get_Item_Bids($Item_ID);

	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
	#------------------------------------------------------	
	if ($New_Bid < $Current_Bid) {
		$Out=&Msg($Language{'invalid_bid'}, $Language{'invalid_bid_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit;
	}
	#------------------------------------------------------
	if ($New_Bid_Quantity > $Item_Qty) {
		$Out=&Msg($Language{'invalid_bid_quantity'}, $Language{'invalid_bid_quantity_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit;
	}
	#------------------------------------------------------

	undef @All_Bids;
	@All_Bids = split(/=/, $Bids);
	$Status = -1; #pending
	($New_Bidder_Email, $Name) =&Get_User_Email_and_Name($New_User_ID);
	$Bid_Qty = $New_Bid_Quantity;
	$Win_Qty = $New_Bid_Quantity;
	$Bid_Time = &Time(time);
	$Proxy = 0; 
	$Bid = $New_Bid;
	$Max_Bid = $New_Bid;
	$User_ID = $New_User_ID;
	$Email =$New_Bidder_Email;
	$New_Bidder = join(":", ($Status, $New_User_ID, $Email, $Bid_Qty, $Win_Qty, $Bid_Time, $Bid, $Proxy, $Max_Bid));
	push (@All_Bids, $New_Bidder);
	#------------------------------------------------------
	$Bid_Count = 0;
	foreach $Bidder(@All_Bids){
		@{$Bidders[$Bid_Count]}
		            {qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)}=split(/\:/, $Bidder);
		if ($Bidders[$Bid_Count]{'Status'} != 0) { $Bid_Count++; }
	}
	#------------------------------------------------------
	&Sort_All_Bids;
	#------------------------------------------------------
	$Left_Qty = $Item_Qty;
	for $x(0..$Bid_Count - 1){
		$Qty = $Bidders[$x]{'Bid_Qty'};
		$R=$Left_Qty - $Qty;
		if ( $R >= 0){
				$Left_Qty = $R;
				$Bidders[$x]{'New_Win_Qty'} = $Qty;
				$Bidders[$x]{'Win_Status'} = 1; #Winner, full quantity
		}
		else{ # $R<0
				if ($Left_Qty>0) {
						$Bidders[$x]{'New_Win_Qty'} = $Left_Qty;
						$Bidders[$x]{'Win_Status'} = -1; #winner partial quantity
						$Left_Qty = 0;
				}else{
						$Bidders[$x]{'New_Win_Qty'} = 0;
						$Bidders[$x]{'Win_Status'} = 0; #Looser, out of bid
						$Left_Qty = 0;
				}
		}
	}
	#------------------------------------------------------
	undef @All_Bids;
	$Total_Bid_Qty=0;

	for $x(0..$Bid_Count - 1){
		if ($Bidders[$x]{'Win_Status'} == 1){ #winners
				$Bidders[$x]{'Win_Qty'}=$Bidders[$x]{'New_Win_Qty'};
				if ($Bidders[$x]{'Status'} == -1) {
						$New_Bidder_Win_Qty= $Bidders[$x]{'New_Win_Qty'};
				}
				$Bidders[$x]{'Status'}=1;
				$Total_Bid_Qty += $Bidders[$x]{'Win_Qty'};
		}
		elsif($Bidders[$x]{'Win_Status'} == -1){ #partial winner
				$Bidders[$x]{'Win_Qty'}=$Bidders[$x]{'New_Win_Qty'};
				$Partial_Bidder_Win_Qty = $Bidders[$x]{'New_Win_Qty'};
				if ($Bidders[$x]{'Status'} == -1) {
						$New_Bidder_Win_Qty= $Bidders[$x]{'New_Win_Qty'};
				}
				$Bidders[$x]{'Status'}=1;
				$Total_Bid_Qty += $Bidders[$x]{'Win_Qty'};
		}
		else{# Out of bid
				$Bidders[$x]{'Win_Qty'}=0;
				if ($Bidders[$x]{'Status'} == -1) {
						$New_Bidder_Win_Qty= 0;
				}
				$Bidders[$x]{'Status'}=0;
		} #end if
	
		$All_Bids[$x]=join(":", @{$Bidders[$x]}{qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)} );
	}#end for
	#------------------------------------------------------
	$Number_of_Bids=@All_Bids;
	if ($Total_Bid_Qty == $Item_Qty){
			$Lowest_Bid = $Bidders[0]{'Bid'};
			for $x(0..$Bid_Count - 1){
					if ($Bidders[$x]{'Status'} == 1){
						if ($Bidders[$x]{'Bid'} < $Lowest_Bid) {
								 $Lowest_Bid = $Bidders[$x]{'Bid'};
						}
					}
			}
			$Current_Bid = $Lowest_Bid;
			$Current_Bid += $Bid_Increment;
	}
	&Update_Item_Current_Bid($Item_ID, $Current_Bid, $Number_of_Bids);
	#------------------------------------------------------

	$Bids=join("=", @All_Bids);
	#	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Number_of_Bids, $Bids)
	$Item=join("|", 	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Number_of_Bids, $Bids));
	
	&Save_Item_Bids($Item_ID, $Item);

	$Total_Bid = $New_Bid * $New_Bidder_Win_Qty;

	#$Bidders[$x]{qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)};
	for $x(0..$Bid_Count - 1){
		if ( ($Bidders[$x]{'Win_Status'} == 0) || ($Bidders[$x]{'Win_Status'} == -1)){
			$Email=$Bidders[$x]{'Email'};
			$Bid_Qty=$Bidders[$x]{'Bid_Qty'};
			$Win_Qty=$Bidders[$x]{'Win_Qty'};
			$Bid_Time=$Bidders[$x]{'Bid_Time'};
			$Bid=$Bidders[$x]{'Bid'};
			$Max_Bid=$Bidders[$x]{'Max_Bid'};
			if ($Email) {
					&Email_Out_Bid_Dutch($Item_ID, $Email, $Bid, $Current_Bid, $Bid_Time, $Bid_Qty, $Win_Qty);
			}
		}
	}

	&Email_Success_Bid_Dutch($Item_ID, $New_Bidder_Email, $New_Bid, $Current_Bid, $Success_Bid_Time, $New_Bid_Quantity, $New_Bidder_Win_Qty);

	&Check_Buy_Item($Item_ID);

	$Out=&Msg($Language{'bid_success_title'}, $Language{'bid_success_help'},3);
	$Plugins{'Body'}=$Out;
	&Display($Global{'General_Template'});
}
#==========================================================
#==========================================================
sub Email_Success_Bid{
my ($Item_ID, $Email, $Bid, $Current_Bid, $Time)=@_;
my ($Out, $Subject, $List);

		$Time=&Get_Date_Formated(10, $Time);

		$Out=$Language{'bid_success_email_body'};
		&Read_Classes;
		$Out=&Translate_Classes($Out);		
		$Out=&Translate($Out);

		&Get_Item($Item_ID);

		$Out=~ s/<!--BID-->/$Bid/g;
		$Out=~ s/<!--TIME-->/$Time/g;
		$Out=~ s/<!--CURRENT_BID-->/$Current_Bid/g;
		$Out=~ s/<!--ITEM_ID-->/$Item_Info[0]{'Item_ID'}/g;
		$Out=~ s/<!--USER_ID-->/$Item_Info[0]{'User_ID'}/;
		$Out=~ s/<!--ITEM_TITLE-->/$Item_Info[0]{'Title'}/g;
		$Out=~ s/<!--QUANTITY-->/$Item_Info[0]{'Quantity'}/g;
		$List=&Web_Decode($Item_Info[0]{'Description'});
		$Out=~ s/<!--DESCRIPTION-->/$List/g;

		$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID!;
		$Out=~ s/<!--ITEM_LINK->/$List/g;
		
		#Email($From, $TO, $Subject,   $Message);
		$Subject=&Translate_Classes($Language{'bid_success_email_subject'});
		$Subject=&Translate($Subject);

		&Email($Global{'Auction_Email'}, $Email, $Subject, $Out);
}
#==========================================================
sub Email_Out_Bid{
my ($Item_ID, $Email, $Bid, $Current_Bid, $Time)=@_;
my ($Out, $Subject, $List);

		$Time=&Get_Date_Formated(10, $Time);

		$Out=$Language{'out_bid_email_body'};

		&Read_Classes;
		$Out=&Translate_Classes($Out);		
		$Out=&Translate($Out);

		&Get_Item($Item_ID);

		$Out=~ s/<!--BID-->/$Bid/g;
		$Out=~ s/<!--TIME-->/$Time/g;
		$Out=~ s/<!--CURRENT_BID-->/$Current_Bid/g;

		$Out=~ s/<!--ITEM_ID-->/$Item_Info[0]{'Item_ID'}/g;
		$Out=~ s/<!--USER_ID-->/$Item_Info[0]{'User_ID'}/;
		$Out=~ s/<!--ITEM_TITLE-->/$Item_Info[0]{'Title'}/g;
		$Out=~ s/<!--QUANTITY-->/$Item_Info[0]{'Quantity'}/g;
		$List=&Web_Decode($Item_Info[0]{'Description'});
		$Out=~ s/<!--DESCRIPTION-->/$List/g;

		$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID!;
		$Out=~ s/<!--ITEM_LINK->/$List/g;

		#Email($From, $TO, $Subject,   $Message);
		$Subject=&Translate_Classes($Language{'out_bid_email_subject'});
		$Subject=&Translate($Subject);

		&Email($Global{'Auction_Email'}, $Email, $Subject, $Out);
}
#==========================================================
sub Email_Success_Bid_Dutch{
my ($Item_ID, $Email, $Bid, $Current_Bid, $Time, $Bid_Qty, $Win_Qty)=@_;
my ($Out, $Subject, $List);

		$Time=&Get_Date_Formated(10, $Time);

		$Out=$Language{'bid_success_email_dutch_body'};
		&Read_Classes;
		$Out=&Translate_Classes($Out);		
		$Out=&Translate($Out);

		&Get_Item($Item_ID);

		$Out=~ s/<!--BID-->/$Bid/g;
		$Out=~ s/<!--TIME-->/$Time/g;
		$Out=~ s/<!--BID_QUANTITY-->/$Bid_Qty/g;
		$Out=~ s/<!--WIN_QUANTITY-->/$Win_Qty/g;
		$Out=~ s/<!--CURRENT_BID-->/$Current_Bid/g;
		$Out=~ s/<!--ITEM_ID-->/$Item_Info[0]{'Item_ID'}/g;
		$Out=~ s/<!--USER_ID-->/$Item_Info[0]{'User_ID'}/;
		$Out=~ s/<!--ITEM_TITLE-->/$Item_Info[0]{'Title'}/g;
		$Out=~ s/<!--QUANTITY-->/$Item_Info[0]{'Quantity'}/g;
		$List=&Web_Decode($Item_Info[0]{'Description'});
		$Out=~ s/<!--DESCRIPTION-->/$List/g;
	
		$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID!;
		$Out=~ s/<!--ITEM_LINK->/$List/g;
		
		#Email($From, $TO, $Subject,   $Message);
		$Subject=&Translate_Classes($Language{'bid_success_email_subject'});
		$Subject=&Translate($Subject);
		&Email($Global{'Auction_Email'}, $Email, $Subject, $Out);
}
#==========================================================
sub Email_Out_Bid_Dutch{
my ($Item_ID, $Email, $Bid, $Current_Bid, $Time, , $Bid_Qty, $Win_Qty)=@_;
my ($Out, $Subject, $List);

		$Time=&Get_Date_Formated(10, $Time);

		$Out=$Language{'out_bid_email_dutch_body'};

		&Read_Classes;
		$Out=&Translate_Classes($Out);
		$Out=&Translate($Out);
		
		&Get_Item($Item_ID);

		$Out=~ s/<!--BID-->/$Bid/g;
		$Out=~ s/<!--TIME-->/$Time/g;
		$Out=~ s/<!--BID_QUANTITY-->/$Bid_Qty/g;
		$Out=~ s/<!--WIN_QUANTITY-->/$Win_Qty/g;
		$Out=~ s/<!--CURRENT_BID-->/$Current_Bid/g;
		$Out=~ s/<!--ITEM_ID-->/$Item_Info[0]{'Item_ID'}/g;
		$Out=~ s/<!--USER_ID-->/$Item_Info[0]{'User_ID'}/;
		$Out=~ s/<!--ITEM_TITLE-->/$Item_Info[0]{'Title'}/g;
		$Out=~ s/<!--QUANTITY-->/$Item_Info[0]{'Quantity'}/g;
		$List=&Web_Decode($Item_Info[0]{'Description'});
		$Out=~ s/<!--DESCRIPTION-->/$List/g;
		
		$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID!;
		$Out=~ s/<!--ITEM_LINK->/$List/g;
		
		#Email($From, $TO, $Subject,   $Message);
		$Subject=&Translate_Classes($Language{'out_bid_email_subject'});
		$Subject=&Translate($Subject);
		&Email($Global{'Auction_Email'}, $Email, $Subject, $Out);
}
#==========================================================
#==========================================================
1;

