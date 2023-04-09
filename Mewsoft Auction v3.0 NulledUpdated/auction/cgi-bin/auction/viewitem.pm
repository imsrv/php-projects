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
sub View_Item{
my ($Required_Item_ID, $Item_Status)=@_;
my (%Item, $Line, @Templ, @Photos, $Rating) ;
my ($Out, $List, $img, $Photo, $Ok, $ET, %User_Info) ;

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_View_Item_File'});

	$Out=&Translate_File($Global{'ViewItemTemplate'});
	
	&Get_Menu_Bar;

	if ($Item_Status eq "Open") {
		$Ok=&Get_Item($Required_Item_ID);
	}
	elsif($Item_Status eq "Archived"){
		$Ok=&Get_Archived_Item($Required_Item_ID);
	}

		%User_Info = &Get_User_Info($Item_Info[0]{'User_ID'});

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
	$Curr = $Global{'Currency_Symbol'};

	$Out=~ s/(<!--LANGUAGE-->)/$Item{'Item_Language'}/g;

	$List = &Format_Decimal($Item{'Start_Bid'});
	$Out=~ s/(<!--START_BID-->)/$Curr$List/g;

	$List = &Format_Decimal($Item{'Increment'});
	$Out=~ s/(<!--BID_INCREMENT-->)/$Curr$List/g;

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

	$List=qq!<A HREF="$Item{'Homepage'}" TARGET="_blank">$Item{'Homepage'}</A>!;
	$Out=~ s/(<!--HOMEPAGE-->)/$List/;
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
	$List=~ s/\\\*/\*/g;
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

	$List = &Format_Decimal($Item_Info[0]{'Current_Bid'});
	$Out=~ s/(<!--CURRENT_BID-->)/$Curr$List/g;
	
	$CB=$Item_Info[0]{'Bids'};
	if ($CB==0) { $CB="-"; }
	$Out=~ s/(<!--BIDS-->)/$CB/g;
	#------------------------------------------------------
	if ($Item{'Reserve'}){
			if ($Item_Info[0]{'Current_Bid'}>$Item{'Reserve'}) {
						$Out=~ s/<!--RESERVE-->/$Language{'reserve_price_met'}/g;
			}
			else{
					$Out=~ s/<!--RESERVE-->/$Language{'reserve_price_not_met'}/g;
			}
	}
	else{
			$Out=~ s/<!--RESERVE-->/$Language{'no_reserve_price'}/g;
	}
	#------------------------------------------------------
	if ($Item{'BuyPrice'} && $Item_Info[0]{'Bids'}<=0){
			$Out=~ s/<!--BUY_ITEM-->/$Language{'item_buy_price'}/g;
			$List = &Format_Decimal($Item{'BuyPrice'});
			$Out=~ s/<!--BUYPRICE-->/$Curr$List/;
			$Img=qq!<img src="$Global{'ImagesDir'}/buyitnow.gif" border="0" alt="$Language{'buy_it_now_icon'}">!;
			$Img=qq!<A HREF="#bidding">$Img</A>!;
			$Out=~ s/<!--BUY_ICON-->/$Img/g;
	}
	else{
			$Out=~ s/<!--BUY_ITEM-->//g;
			$Out=~ s/<!--BUYPRICE-->//;
	}
	#------------------------------------------------------
	if ( $Item_Info[0]{'End_Time'} < &Time(time) || $Item_Status eq "Archived") {
			$List=$Language{'item_closed'};
		}
		else{
			$List=&Time_Diff(&Time(time), $Item_Info[0]{'End_Time'});
	}

	$Out=~ s/<!--TIME_LEFT-->/$List/g;
	#------------------------------------------------------
	$ID=$Item_Info[0]{'Item_ID'};
	$List=qq!<A  HREF="#" onClick="window.open('$Script_URL?action=Countdown_Ticker&Item_ID=$ID&Lang=$Global{'Language'}','CountDown','WIDTH=450,HEIGHT=300,scrollbars=yes,resizable=yes,left=50,top=50,screenX=0,screenY=0');return false">$Language{'countdown_ticker_label'}</A>!;
	$Out=~ s/<!--COUNT_DOWN_TICKER-->/$List/;

	$List=&Get_Date_Formated($Global{'Time_Format'}, $Item_Info[0]{'Start_Time'});
	$Out=~ s/<!--START_TIME-->/$List/;
	
	#if ($Item_Info[0]{'End_Time'} < time) {
	#			$List=$Language{'item_closed'};  
	#}
	#else{
				$List=&Get_Date_Formated($Global{'Time_Format'}, $Item_Info[0]{'End_Time'});
	#}
	$Out=~ s/<!--END_TIME-->/$List/g;
	#-------------------------------------------------------------------------
	$List=&Get_Date_Formated($Global{'Time_Format'}, &Time(time));
	$Out=~ s/<!--TIME_NOW-->/$List/g;
	#-------------------------------------------------------------------------
	$List = &Format_Decimal($Item_Info[0]{'Current_Bid'});
	$Out=~ s/<!--MINIMUM_BID-->/$Curr$List/g;
	#-------------------------------------------------------------------------
	if ($Item_Info[0]{'Quantity'} ==1) {
			$List="1";
			$List.=qq!<input type="hidden" name="New_Bid_Quantity" size="10" value="1">!;
	}
	else{
			$List=qq!&nbsp;&nbsp;<input type="text" name="New_Bid_Quantity" size="10" value="" onFocus="select();">!;
	}
	$Out=~ s/<!--BIDDING_QUANTITY_BOX-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!$Curr<input type="text" name="New_Bid" size="10" value="" onFocus="select();">!;
	$Out=~ s/<!--USER_BID_BOX-->/$List/g;
	#-------------------------------------------------------------------------

	$List=qq!<A HREF="$Script_URL?action=Bid_History&Cat_ID=$Item_Info[0]{'Cat_ID'}&Item_ID=$Item_Info[0]{'Item_ID'}&Lang=$Global{'Language'}">$Language{'bid_history'}</a>!;
	$Out=~ s/<!--BID_HISTORY-->/$List/g;
	
	$List=qq!<A HREF="$Script_URL?action=High_Bidder&Cat_ID=$Item_Info[0]{'Cat_ID'}&Item_ID=$Item_Info[0]{'Item_ID'}&Lang=$Global{'Language'}">$Language{'high_bidder'}</a>!;
	$Out=~ s/<!--HIGH_BIDDER-->/$List/g;
	#-------------------------------------------------------------------------
	#------------------------------------------------------------------------
	$List="";
	if ($Item_Info[0]{'Gift_Icon'}) {
			$List=qq!<img src="$Global{'ImagesDir'}/$Item_Info[0]{'Gift_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
	}
	$Out=~ s/<!--GIFT_ICON-->/$List/g;

	$Img="";
	$Img1="";
	if ($Item_Info[0]{'Bids'}>=$Global{'Hot_Item_Bids'}) {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'Hot_Icon'}" border=0 alt="$Language{'hot_icon'}">!;
	}
	elsif ($Item_Info[0]{'Bids'}>=$Global{'Cool_Item_Bids'}) {
			$Img1=qq!<img src="$Global{'ImagesDir'}/$Global{'Cool_Icon'}" border=0 alt="$Language{'cool_icon'}">!;

	}
	$Out=~ s/<!--HOT-->/$Img/g;
	$Out=~ s/<!--COOL-->/$Img1/g;

	$Img="";
	if (($Item{'Featured_Homepage'} ) || ($Item{'Featured_Category'})) {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'Featured_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
	}
	$Out=~ s/<!--FEATURED-->/$Img/g;
	#------------------------------------------------------------------------
	@Photos=split(/\|/, $Item_Info[0]{'Uploaded_Files'});
	$List="";
	foreach $Photo (@Photos) {
				@Photoss=split(/\//,$Photo);
				$Photo=pop @Photoss;
				$Photo="$Global{'Base_Upload_URL'}/$Photo";
				if ($Photo ne "") {
						$List.=qq!<IMG SRC="$Photo" border="0" alt="photo">$Language{'photos_separator'}!;
				}
	}
	$Out=~ s/<!--ITEM_PHOTOS-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=Sign_in&Lang=$Global{'Language'}">$Language{'register_label'}</A>!;
	$Out=~ s/<!--REGISTER-->/$List/g; 
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="mailto:$User_Info{'EmailAddress'}">$User_Info{'EmailAddress'}</A>!;
	$Out=~ s/<!--SELLER_EMAIL-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=View_Feedback&Feedback_User_ID=$Item_Info[0]{'User_ID'}&Lang=$Global{'Language'}">$Language{'seller_comments_label'}</A>!;
	$Out=~ s/<!--SELLER_COMMENTS-->/$List/g;
	#-------------------------------------------------------------------------
	($Rating, undef, undef, undef)=&Get_User_Rating($User_Info{'User_ID'});
	$List = $Rating;
	if (!$Rating) {
		$List = $Language{'new_rating'};
	}
	$List1=qq!<A HREF="$Script_URL?action=View_Feedback&Feedback_User_ID=$Item_Info[0]{'User_ID'}&Lang=$Global{'Language'}" >$List</a>!;
	$Out=~ s/<!--SELLER_RATING-->/$List1/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=Ask_Seller_Login&User_ID_To_Ask=$Item_Info[0]{'User_ID'}&Lang=$Global{'Language'}">$Language{'ask_seller_label'}</A>!;
	$Out=~ s/<!--ASK_SELLER_QUESTION-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=Seller_Auctions&User_ID=$Item_Info[0]{'User_ID'}&Page=1&Lang=$Global{'Language'}">$Language{'seller_other_auctions_label'}</A>!;
	$Out=~ s/<!--SELLER_OTHER_AUCTIONS-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=View_Feedback&Feedback_User_ID=$Item_Info[0]{'User_ID'}&Lang=$Global{'Language'}">$Language{'comments_about_seller_label'}</A>!;
	$Out=~ s/<!--COMMENTS_ABOUT_SELLER-->/$List/g;
	#-------------------------------------------------------------------------
	$List=qq!<A HREF="$Script_URL?action=Ask_Seller_Login&User_ID_To_Ask=$Item_Info[0]{'User_ID'}&Lang=$Global{'Language'}">$User_Info{'User_ID'}</A>!;
	$Out=~ s/<!--CONTACT_SELLER-->/$List/g;
	#-------------------------------------------------------------------------
	if ($Rating < 10) {$List = "star-0.gif";}
	if ($Rating > 10 &&  $Rating < 99) {$List = "star-1.gif";}
	if ($Rating > 100 &&  $Rating < 499) {$List = "star-2.gif";}
	if ($Rating > 500 &&  $Rating < 999) {$List = "star-3.gif";}
	if ($Rating > 1000 &&  $Rating < 9999) {$List = "star-4.gif";}
	if ($Rating > 10000) {$List = "star-5.gif";}

	$List =qq!<IMG SRC="$Global{'ImagesDir'}/$List" BORDER="0" ALT="RATING STARS">!;
	$List =qq!<A HREF="$Script_URL?action=Get_Help&Index=6&Lang=$Global{'Language'}">$List</A>!;

	$Out=~ s/<!--USER_STARS-->/$List/g;
	#-------------------------------------------------------------------------
	if ( $Item_Info[0]{'End_Time'} < &Time(time)) {
			$List= $Language{'item_closed_button'};
		}
		else{
			$List=$Language{'review_bid_button'};
	}

	$Out=~ s/<!--REVIEW_BID_BUTTON-->/$List/;
	$Out=~ s/<!--CLEAR_BID_BUTTON-->/$Language{'clear_bid_button'}/;
	$Out=~ s/<!--CANCEL_BID_BUTTON-->/$Language{'cancel_bid_button'}/;
	#-------------------------------------------------------------------------
	$List = $Language{'view_item_counter'};
	$Img = &Get_View_Item_Count_Image($Item_Info[0]{'Item_ID'});
	$List =~ s/<!--View_Item_Count-->/$Img/;
	$Out=~ s/<!--View_Item_Counter-->/$List/;
	#-------------------------------------------------------------------------
	$List=qq!<form NAME="Review_Bid_Form"  method="POST" action="$Script_URL">
					<input type="hidden" name="action" value="Preview_Bid">
					<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">
					<input type="hidden" name="Item_ID" value="$Required_Item_ID">
					<input type="hidden" name="Item_Qty" value="$Item_Info[0]{'Quantity'}">
					<input type="hidden" name="Item_Title" value="$Item_Info[0]{'Title'}">
					<input type="hidden" name="User_ID" value="$Item_Info[0]{'User_ID'}">
					<input type="hidden" name="Lang" value="$Global{'Language'}">
					!;

	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!</FORM>!;
	$Out=~ s/<!--FORM_END-->/$List/;

	$Plugins{'Body'}="";

	&Display($Out, 1);
}
#==========================================================
sub Get_View_Item_Count_Image{
my($Item_ID) = @_;
my($Count, $Counter, @Digits, $Digit);

	$Count = &Get_Updated_View_Item_Count($Item_ID);
	$Count = sprintf("%06d", $Count);

	@Digits = split("", $Count);

	$Counter = "";
	foreach $Digit (@Digits) {
				$Counter .= qq!<IMG SRC="$Global{'ImagesDir'}/dig$Digit\.gif" BORDER="0" ALT="$Digit" ALIGN="absmiddle">!;
	}
	
	return ($Counter);
}
#==========================================================
1;