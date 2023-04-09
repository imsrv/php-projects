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
sub Preview_Bid{
my ($Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Bidding_File'});

	if ($Param{'Item_Qty'} ==1) {
				$Out=&Validate_Bid;
	}
	else{
				$Out=&Validate_Dutch_Auction_Bid;
	}

}
#==========================================================
sub Validate_Bid{
my ($Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids);
my (%data, %datax, $Item);

	$Item_ID= $Param{'Item_ID'};
	$Cat_ID = $Param{'Cat_ID'};
	$New_Bid = $Param{'New_Bid'};
	$New_Bid_Quantity = $Param{'New_Bid_Quantity'};
	$Item_Title = $Param{'Item_Title'};
	$Total_Bid = $New_Bid * $New_Bid_Quantity;
	$Item_Qty=$Param{'Item_Qty'};

	&DB_Exist($Global{'ItemsBidsFile'});
	tie %datax, "DB_File", $Global{'ItemsBidsFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%data = %datax;
	untie %datax;
	undef %datax;

	if (defined $data{$Item_ID}) {
			$Item=$data{$Item_ID};
	}
	else{
			return 0;
	}


	#($Item_ID, $Qty, $Start_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
	
	if ($New_Bid < $Current_Bid) {
		$Out=&Msg($Language{'invalid_bid'}, $Language{'invalid_bid_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit;
	}

	if ($New_Bid_Quantity > $Item_Qty) {
		$Out=&Msg($Language{'invalid_bid_quantity'}, $Language{'invalid_bid_quantity_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit;
	}

	$Out = &Preview_Bid_Form($Item_ID, $Item_Title, $Cat_ID, $Item_Qty, $New_Bid, $New_Bid_Quantity, $Total_Bid);
	&Display($Out, 1);
}
#==========================================================
sub Sort_Bids{

	@Bidders = sort { $b->{'Bid'} <=> $a->{'Bid'} or $a->{'Bid_Time'} <=> $b->{'Bid_Time'} } @Bidders;

}
#==========================================================
sub Validate_Dutch_Auction_Bid{
my ($Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids);
my($Item_ID, $Cat_ID, $New_Bid, $New_Bid_Quantity, $Item_Title, $Item, $Out);
my (%data, %datax);

	$Item_ID= $Param{'Item_ID'};
	$Cat_ID = $Param{'Cat_ID'};
	$New_Bid = $Param{'New_Bid'};
	$New_Bid_Quantity = $Param{'New_Bid_Quantity'};
	$Item_Title = $Param{'Item_Title'};
	$Item_Qty=$Param{'Item_Qty'};

	&DB_Exist($Global{'ItemsBidsFile'});
	tie %datax, "DB_File", $Global{'ItemsBidsFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%data = %datax;
	untie %datax;
	undef %datax;

	if ($data{$Item_ID}) {
			$Item=$data{$Item_ID};
	}
	else{
			return 0;
	}
	#------------------------------------------------------
	#($Item_ID, $Qty, $Start_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
	#------------------------------------------------------	
	if ($New_Bid < $Current_Bid) {
			$Out=&Msg($Language{'invalid_bid'}, $Language{'invalid_bid_help'}, 1);
			$Plugins{'Body'}=$Out;
			&Display($Global{'General_Template'});
			return 0;
	}
	#------------------------------------------------------
	if ($New_Bid_Quantity > $Item_Qty) {
			$Out=&Msg($Language{'invalid_bid_quantity'}, $Language{'invalid_bid_quantity_help'}, 1);
			$Plugins{'Body'}=$Out;
			&Display($Global{'General_Template'});
			return 0;
	}
	#------------------------------------------------------
	$New_User_ID=$Param{'Bidder_ID'};

	undef @All_Bids;
	@All_Bids = split(/=/, $Bids);
	$Status = -1; #pending
	$New_Bidder_Email ="";# &Get_User_Email_and_Name($New_User_ID);
	$Bid_Qty = $New_Bid_Quantity;
	$Win_Qty = $New_Bid_Quantity;
	$Bid_Time = &Time(time);
	$Proxy = 0; 
	$Bid = $New_Bid;
	$Max_Bid = $New_Bid;
	$User_ID = $New_User_ID;
	$Email =""; # $New_Bidder_Email;
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
	&Sort_Bids;
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
						$Bidders[$x]{'Win_Status'} = -2; #winner partial quantity
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
		elsif($Bidders[$x]{'Win_Status'} == -2){ #partial winner
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
	
	}#end for
	#------------------------------------------------------
	#------------------------------------------------------

	$Total_Bid = $New_Bid * $New_Bidder_Win_Qty;
	$Plugins{'Body'} ="";
	$Out=&Preview_Bid_Form($Item_ID, $Item_Title, $Cat_ID, $Item_Qty, $New_Bid, $New_Bidder_Win_Qty, $Total_Bid);
	&Display($Out, 1);
}
#==========================================================
sub Preview_Bid_Form{
my ($Item_ID, $Item_Title, $Cat_ID, $Item_Qty, $New_Bid, $New_Bid_Quantity, $Total_Bid)=@_;
my ($Out, $Curr);

	$Out=&Translate_File($Global{'Preview_Bid_Template'});

	$List=qq!<FORM NAME="Preview_Bid" ACTION="$Script_URL" METHOD="POST">
					<input type="hidden" name="action" value="Process_Bid">
					<input type="hidden" name="Cat_ID" value="$Cat_ID">
					<input type="hidden" name="Item_ID" value="$Item_ID">
					<input type="hidden" name="New_Bid" value="$New_Bid">
					<input type="hidden" name="Item_Qty" value="$Item_Qty">
					<input type="hidden" name="New_Bid_Quantity" value="$New_Bid_Quantity">
					!;
	$Out=~ s/<!--FORM_START-->/$List/g;
	#----------------------------------------------------------------------------
	$Curr = "$Global{'Currency_Symbol'}";

	$Out=~ s/<!--ITEM_ID-->/$Item_ID/g;
	$Out=~ s/<!-ITEM_TITLE-->/$Item_Title/g;
	$Out=~ s/<!--BID_QUANTITY-->/$New_Bid_Quantity/g;
	$Out=~ s/<!--BID_PER_ITEM-->/$Curr$New_Bid/g;
	$Out=~ s/<!--TOTAL_BID-->/$Curr$Total_Bid/g;

	$User_ID=$Cookies{'User_User_ID'};
	$Password=$Cookies{'User_Password'};

	$List=qq!<INPUT NAME="Bidder_ID" SIZE=20 VALUE="$User_ID" onFocus="select();">!;
	$Out=~ s/<!--USER_ID_BOX-->/$List/g;

	$List=qq!<INPUT name="Password" size=20 type="password" value="$Password"  onFocus="select();">!;
	$Out=~ s/<!--USER_PASSWORD_BOX-->/$List/g;

	$List=qq!<input CHECKED name="Remember_login" type="checkbox" value="yes">!;
	$Out=~ s/<!--REMEMBER_LOGIN_BUTTON-->/$List/;

	$List=qq!<A HREF="$Script_URL?action=Forgot_Username">$Language{'forgot_username'}</A>!;
	$Out=~ s/<!--FORGOT_USERNAME-->/$List/g;

	$List=qq!<A HREF="$Script_URL?action=Forgot_Password">$Language{'forgot_password'}</A>!;
	$Out=~ s/<!--FORGOT_PASSWORD-->/$List/g;
	#-------------------------------------------------------------------------------------------
	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_button'}/;
	$Out=~ s/<!--RESET_BUTTON-->/$Language{'reset_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/g;

	return $Out;
}
#==========================================================
sub Sort_All_Bids_History{

	@Bidders = sort { $b->{'Bid'} <=> $a->{'Bid'} 
								or $a->{'Bid_Time'} <=> $b->{'Bid_Time'} } @Bidders;

}
#==========================================================
sub High_Bidder{
		
		&Show_Bid_History(1);
}
#==========================================================
sub Bid_History{
		
		&Show_Bid_History(0);
}
#==========================================================
sub Show_Bid_History{
my ($List_Winner_Only)= shift;
my ($Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids);
my (%data, $Item);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Bidding_File'});
	&Read_Language_File($Global{'Language_View_Item_File'});

	$Out=&Translate_File($Global{'Bid_History_Template'});
	@Listing_Row=($Global{'Bid_History_Table_Row'}, $Global{'Bid_History_Table_Row1'});

	&Get_Menu_Bar;
	&Categories_Form($Param{'Cat_ID'}, "View_Cat");
	#------------------------------------------------------
	$Item_ID = $Param{'Item_ID'};

	&DB_Exist($Global{'ItemsBidsFile'});
	tie %datax, "DB_File", $Global{'ItemsBidsFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%data = %datax;
	untie %datax;
	undef %datax;

	if ($data{$Item_ID}) {
			$Item = $data{$Item_ID};
	}
	else{
			return 0;
	}
	#------------------------------------------------------
	#($Item_ID, $Qty, $Start_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
	#------------------------------------------------------	
	undef @All_Bids;
	@All_Bids = split(/=/, $Bids);
	#------------------------------------------------------
	$Bid_Count = 0;
	foreach $Bidder(@All_Bids){
		@{$Bidders[$Bid_Count]}
		            {qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)}=split(/\:/, $Bidder);
		if ($List_Winner_Only == 1 ) {
				if ($Bidders[$Bid_Count]{'Status'} != 0) { $Bid_Count++; }
		}
		else{
				$Bid_Count++;
		}
	}
	#------------------------------------------------------
	&Sort_All_Bids_History;
	#------------------------------------------------------
	$Table="";
	for $x(0..$Bid_Count - 1){
				$Row=$Listing_Row[int($x % 2)];

				$Img="";
				if ($Bidders[$x]{'Status'} != 0) { 
					$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'High_Bidder_Icon'}" border=0 alt="$Language{'high_bidder_icon'}">!;
				}

				$Row=~ s/<!--HIGHEST_BIDDER-->/$Img/;

				$List=$Bidders[$x]{'User_ID'};
				$Row=~ s/<!--USER_ID-->/$List/;

				$List="-";
				$Row=~ s/<!--COMMENTS-->/$List/;
				
				$List=$Bidders[$x]{'Bid'};
				$Row=~ s/<!--BID_AMOUNT-->/$List/;
				
				$List=$Bidders[$x]{'Bid_Qty'};
				$Row=~ s/<!--BID_QUANTITY-->/$List/;
				
				$List=$Bidders[$x]{'Win_Qty'};
				if ($List == 0) {$List ="-";}
				$Row=~ s/<!--WIN_QUANTITY-->/$List/;

				$List=&Format_Time( $Bidders[$x]{'Bid_Time'} );
				$Row=~ s/<!--BID_TIME-->/$List/;

				$Table .= $Row;
	}
	
	if ($Bid_Count == 0) {
		$Table=$Language{'no_bids_on_this_item'};
	}
	$Plugins{'Bids_Listing'}=$Table;
	#------------------------------------------------------
	#          Show  Item Information
	#------------------------------------------------------
	$Ok=&Get_Item($Param{'Item_ID'});

	&Get_User_Info($Item_Info[0]{'User_ID'});

		($Item{'Country'},
		$Item{'Item_Language'},
		$Item{'ypChecks'},
		$Item{'yccMorders'},
		$Item{'yCCards'},
		$Item{'escrow'},
		$Item{'shipping'},
		$Item{'ship_time'},
		$Item{'Ship_Internationally'},
		$Item{'Start_Bid'},
		$Item{'Increment'},
		$Item{'Location'},
		$Item{'Featured_Homepage'},
		$Item{'Featured_Category'},
		$Item{'Reserve'},
		$Item{'BuyPrice'},
		$Item{'BidRating'},
		$Item{'Closing_Time'},
		$Item{'Resubmit'},
		$Item{'Homepage'},
		$Item{'Resubmited'}	) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});
	#-----------------------------------------------------------------		
	$Curr = "$Global{'Currency_Symbol'}";

	$Out=~ s/(<!--LANGUAGE-->)/$Item{'Item_Language'}/g;

	$List="$Curr$Item{'Start_Bid'}";
	$Out=~ s/(<!--START_BID-->)/$List/g;

	$List="$Curr$Item{'Increment'}";
	$Out=~ s/(<!--BID_INCREMENT-->)/$List/g;

	$Out=~ s/(<!--LOCATION-->)/$Item{'Location'}/;
	$Out=~ s/(<!--COUNTRY-->)/$Item{'Country'}/;
	
	$List=qq!<A HREF="$Script_URL?action=Email_Auction_to_Friend&Item_ID=$Item_Info[0]{'Item_ID'}"><img src="$Global{'ImagesDir'}/email_friend.gif" border=0></A>!;
	$List.=qq!<A HREF="$Script_URL?action=Email_Auction_to_Friend&Item_ID=$Item_Info[0]{'Item_ID'}">$Language{'email_to_friend'}</A>!;
	$Out=~ s/(<!--EMAIL_to_FRIEND-->)/$List/;
		
	$List="";
	if ($Item{'Featured_Homepage'}) {	$List=$Language{'featured_homepage'};}
	$Out=~ s/(<!--FEATURED_HOMEPAGE-->)/$List/;

	$List="";
	if ($Item{'Featured_Category'}) {	$List=$Language{'featured_category'};}
	$Out=~ s/(<!--FEATURED_CATEGORY-->)/$List/;

	#$Out=~ s/<!--RESERVE-->/$Item{'Reserve'}/;
	#$Out=~ s/<!--BUYPRICE-->/$Item{'BuyPrice'}/;
	#$Out=~ s/<!--RESUBMIT-->//;

	$List=qq!<A HREF="$Item{'Homepage'}">$Item{'Homepage'}</A>!;
	$Out=~ s/(<!--HOMEPAGE-->)/$List/;
	#------------------------------------------------------------------------
	$List="";
	if ($Item_Info[0]{'Gift_Icon'}) {
			$List=qq!<img src="$Global{'ImagesDir'}/$Item_Info[0]{'Gift_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
	}
	$Out=~ s/<!--GIFT_ICON-->/$List/;

	$Img="";
	if ($Item{'Featured_Homepage'} || $Item{'Featured_Category'}) {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'Featured_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
	}
	$Out=~ s/<!--FEATURED-->/$Img/g;
	#------------------------------------------------------------------------

	#------------------------------------------------------------------------
	$List="";
	if ($Item{'ypChecks'}) {
		$List=$Language{'payment_li'}.$Language{'accepts_pc_label'};
	}
	if ($Item{'yccMorders'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_ccmo_label'};
	}
	if ($Item{'yCCards'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_cc_label'};
	}
	if ($Item{'escrow'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_escrow_label'};
	}
	$img=qq!<img src="$Global{'Red_Ok_Icon'}" border="0">!;
	$List=~ s/<<ok_image>>/$img/g;
	$Out=~ s/(<!--PAYMENT-->)/$List/;
	#------------------------------------------------------------------------
	$List="";
	if ($Item{'shipping'} eq "buyer") {
			$List=$Language{'payment_li'}.$Language{'buyer_pays_label'};
	}
	else{
			$List=$Language{'payment_li'}.$Language{'seller_pays_label'};
	}

	if ($Item{'ship_time'} eq "Receipt_of_Payment") {
			if ($List ne "") {$List.=$Language{'payment_separator'};}
			$List.=$Language{'payment_li'}.$Language{'ship_on_receipt_label'};
	}
	else{
			if ($List ne "") {$List.=$Language{'payment_separator'};}
			$List.=$Language{'payment_li'}.$Language{'ship_on_close_label'};
	}

	if ($Item{'Ship_Internationally'}) {
			if ($List ne "") {$List.=$Language{'payment_separator'};}
			$List.=$Language{'payment_li'}.$Language{'ship_international_label'};
	}
	
	$img=qq!<img src="$Global{'Red_Ok_Icon'}" border="0">!;
	$List=~ s/<<ok_image>>/$img/g;
	$Out=~ s/(<!--SHIPPING-->)/$List/g;
	#------------------------------------------------------------------------
	$Out=~ s/(<!--ITEM_ID-->)/$Item_Info[0]{'Item_ID'}/g;
	$Out=~ s/(<!--USER_ID-->)/$Item_Info[0]{'User_ID'}/;
	
	$List= $Item_Info[0]{'Title'} ;
	$List= substr($List , 0 , $Global{'Max_Title_Length_List'});
	$Out=~ s/(<!--ITEM_TITLE-->)/$List/g;

	$List=&HTML_Treat($Item_Info[0]{'Description'}, $Global{'Treat_HTML'});
	$Out=~ s/(<!--DESCRIPTION-->)/$List/g;

	$Out=~ s/(<!--QUANTITY-->)/$Item_Info[0]{'Quantity'}/g;

	if ($Item_Info[0]{'Quantity'} ==1) {
			$Out=~ s/<!--DUTCH_AUCTION-->//;
	}
	else{
			$Out=~ s/<!--DUTCH_AUCTION-->/$Language{'dutch_auction_label'}/g;
	}

	$List="$Curr$Item_Info[0]{'Current_Bid'}";
	$Out=~ s/(<!--CURRENT_BID-->)/$List/g;
	
	$CB=$Item_Info[0]{'Bids'};
	if ($CB==0) { $CB="-"; }
	$Out=~ s/(<!--BIDS-->)/$CB/g;

	if ( $Item_Info[0]{'End_Time'} < &Time(time)) {
			$List=$Language{'item_closed'};
		}
		else{
			$List=&Time_Diff(&Time, $Item_Info[0]{'End_Time'});
	}
	$Out=~ s/(<!--TIME_LEFT-->)/$List/g;

	$ID=$Item_Info[0]{'Item_ID'};
	$List=qq!<A  HREF="#" onClick="window.open('$Script_URL?action=Countdown_Ticker&Item_ID=$ID','CountDown','WIDTH=400,HEIGHT=260,scrollbars=yes,resizable=yes,left=50,top=50,screenX=150,screenY=100');return false">$Language{'countdown_ticker_label'}</A>!;
	$Out=~ s/(<!--COUNT_DOWN_TICKER-->)/$List/;

	$List=&Format_Time($Item_Info[0]{'Start_Time'});
	$Out=~ s/(<!--START_TIME-->)/$List/;
	
	$List=&Format_Time($Item_Info[0]{'End_Time'});
	$Out=~ s/(<!--END_TIME-->)/$List/g;
	#-------------------------------------------------------------------------
	$List=&Format_Time(&Time(time));
	$Out=~ s/(<!--TIME_NOW-->)/$List/g;
	#-------------------------------------------------------------------------
	$List="$Curr$Item_Info[0]{'Current_Bid'}";
	$Out=~ s/(<!--MINIMUM_BID-->)/$List/g;
	#-------------------------------------------------------------------------
	@Photos=split(/\|/, $Item_Info[0]{'Uploaded_Files'});
	$List="";
	foreach $Photo (@Photos) {
		@Photoss=split(/\//,$Photo);
		$Photo=pop @Photoss;
		$Photo="$Global{'Base_Upload_URL'}/$Photo";
		$List.=qq!<IMG SRC="$Photo" border="0" alt="$Item_Info[0]{'Title'}">$Language{'photos_separator'}! if ($Photo ne "");
	}
	$Out=~ s/(<!--ITEM_PHOTOS-->)/$List/g;
	#------------------------------------------------------
	if ($List_Winner_Only == 1 ) {
					$Out=~ s/<!--PAGE_TITLE->/$Language{'high_bidder_title'}/g;
	}
	else{
					$Out=~ s/<!--PAGE_TITLE->/$Language{'bid_history_title'}/g;
	}
	#------------------------------------------------------
	$Plugins{'Body'} ="";
	&Display($Out, 1);

}
#==========================================================
#==========================================================
1;
