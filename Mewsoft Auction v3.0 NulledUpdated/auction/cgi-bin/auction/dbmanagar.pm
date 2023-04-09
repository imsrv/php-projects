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
sub Prepare_Item_Data{
my $Days_in_Sec;
my $TimeNow;
my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst );

$Param{'Title'} =~ s/\<//g;  # html tag removal  "<"
$Param{'Title'} =~ s/\>//g;  # html tag removal ">"
$Param{'Title'} =~ s/\\\\\*/\*/g;  # for search match *
$Param{'Title'} =~ s/\\\*/\*/g;  # for search match *
$Param{'Title'} = substr($Param{'Title'} , 0 , $Global{'Max_Title_Length'});

$Param{'Description'}=&Web_Decode($Param{'Description'});
$Param{'Description'}=substr($Param{'Description'}, 0, $Global{'Max_Decsription_Length'});

$Param{'Description'}=&HTML_Treat($Param{'Description'}, $Global{'Treat_HTML'});
$Param{'Description'}=&Web_Encode($Param{'Description'});

$TimeNow=&Time(time);
$Param{'Start_Time'}=$TimeNow;
$Days_in_Sec= ($Param{'Duration'}-1) * 86400;

( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime(&Time(time));
$Param{'End_Time'}=$TimeNow + $Days_in_Sec + (($Param{'Closing_Time'} + 24 - $hour)*3600) ;

$Global{'Hidden_Item_Variables'}	= <<HTML;
	<input type="hidden" name="Lang" value="$Global{'Language'}">
	<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">
	<input type="hidden" name="User_ID" value="$Param{'User_ID'}">
	<input type="hidden" name="Password" value="$Param{'Password'}">
	<input type="hidden" name="Title" value="$Param{'Title'}">
	<input type="hidden" name="Description" value="$Param{'Description'}">
	<input type="hidden" name="Country" value="$Param{'Country'}">
	<input type="hidden" name="Item_Language" value="$Param{'Item_Language'}">
	<input type="hidden" name="ypChecks" value="$Param{'ypChecks'}">
	<input type="hidden" name="yccMorders" value="$Param{'yccMorders'}">
	<input type="hidden" name="yCCards" value="$Param{'yCCards'}">
	<input type="hidden" name="escrow" value="$Param{'escrow'}">
	<input type="hidden" name="shipping" value="$Param{'shipping'}">
	<input type="hidden" name="ship_time" value="$Param{'ship_time'}">
	<input type="hidden" name="Ship_Internationally" value="$Param{'Ship_Internationally'}">
	<input type="hidden" name="Quantity" value="$Param{'Quantity'}">
	<input type="hidden" name="Start_Bid" value="$Param{'Start_Bid'}">
	<input type="hidden" name="Increment" value="$Param{'Increment'}">
	<input type="hidden" name="Duration" value="$Param{'Duration'}">
	<input type="hidden" name="Location" value="$Param{'Location'}">
	<input type="hidden" name="Title_Enhancement" value="$Param{'Title_Enhancement'}">
	<input type="hidden" name="Featured_Homepage" value="$Param{'Featured_Homepage'}">
	<input type="hidden" name="Featured_Category" value="$Param{'Featured_Category'}">
	<input type="hidden" name="Gift_Icon" value="$Param{'Gift_Icon'}">
	<input type="hidden" name="Reserve" value="$Param{'Reserve'}">
	<input type="hidden" name="BuyPrice" value="$Param{'BuyPrice'}">
	<input type="hidden" name="BidRating" value="$Param{'BidRating'}">
	<input type="hidden" name="Closing_Time" value="$Param{'Closing_Time'}">
	<input type="hidden" name="Resubmit" value="$Param{'Resubmit'}">
	<input type="hidden" name="Homepage" value="$Param{'Homepage'}">
	<input type="hidden" name="Uploaded_Files" value="$Param{'Uploaded_Files'}">
	<input type="hidden" name="Uploaded_User_Size" value="$Param{'Uploaded_User_Size'}">
	<input type="hidden" name="Uploaded_User_Count" value="$Param{'Uploaded_User_Count'}">
HTML

}
#==========================================================
sub Add_Item{
my ($ID, $Item_Extra, $Item_all);
my ($Days_in_Sec, $TimeNow);
my ($Spare, $Item_ID);
my ($Email, $Name, $List, $Subject);
my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst );
my($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);
my($Credit, $Debit, $Details);

		$Param{'Resubmited'}=0; # Auto resubmited number;
		$Spare="";

		$TimeNow=&Time(time);
		$Param{'Start_Time'}=$TimeNow;
		$Days_in_Sec= ($Param{'Duration'}-1) * 86400;
		( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime(&Time(time));
		$Param{'End_Time'}=$TimeNow + $Days_in_Sec + (($Param{'Closing_Time'} + 24 - $hour)*3600) ;

$Item_Extra=join("~|~",
		$Param{'Country'},
		$Param{'Item_Language'},
		$Param{'ypChecks'},
		$Param{'yccMorders'},
		$Param{'yCCards'},
		$Param{'escrow'},
		$Param{'shipping'},
		$Param{'ship_time'},
		$Param{'Ship_Internationally'},
		$Param{'Start_Bid'},
		$Param{'Increment'},
		$Param{'Location'},
		$Param{'Featured_Homepage'},
		$Param{'Featured_Category'},
		$Param{'Reserve'},
		$Param{'BuyPrice'},
		$Param{'BidRating'},
		$Param{'Closing_Time'},
		$Param{'Resubmit'},
		$Param{'Homepage'},
		$Param{'Resubmited'},
		$Spare,
		$Spare,
		$Spare,
		$Spare,
		$Spare
		);
		#--------------------------------------------------

		$Param{'Uploaded_Files'}=~ s/\|$//; #remove | from the start of the files joined
		$Param{'Current_Bid'}=$Param{'Start_Bid'};
		$Param{'Bids'}=0;

$Item_all = join ('~#~', 
		$Param{'Cat_ID'},
		$Param{'User_ID'},
		$Param{'Title'},
		$Param{'Description'},
		$Param{'Quantity'},
		$Param{'Current_Bid'},
		$Param{'Bids'},
		$Param{'Duration'},
		$Param{'End_Time'},
		$Param{'Title_Enhancement'},
		$Param{'Uploaded_Files'},
		$Param{'Gift_Icon'},
		$Param{'Start_Time'},
		$Item_Extra,
		$Spare,
		$Spare,
		$Spare,
		$Spare,
		$Spare
		);
	#---------------------------------------------------------------------------------
	$Item_ID=&Save_Item($Param{'Cat_ID'}, $Item_all);

	if ($Param{'Featured_Homepage'}){
		&Add_Featured_Home_Item($Item_ID, $Item_all);
	}
	
	if ($Param{'Featured_Category'}){
		&Add_Featured_Item($Item_ID, $Param{'Cat_ID'});
	}

	&Update_Category_Count($Param{'Cat_ID'}, 1);
	#---------------------------------------------------------------------------------
	#	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	&Add_Item_For_Bid($Item_ID, $Param{'Quantity'}, $Param{'Current_Bid'},
												 $Param{'Increment'}, $Param{'Reserve'}, $Param{'BuyPrice'});
	#==========================================================
	&Initialize_Fee_Parameters;
	#($Title_Enhancement, $Featured_Homepage, $Featured_Category, $Gift_Icon, $Uploaded_Files, $Start_Bid, $Quantity, $Reserve, $BuyPrice, $Duration)
	($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS) = &Calculate_Open_Auction_Fee(	$Param{'Title_Enhancement'},
																																						$Param{'Featured_Homepage'},
																																						$Param{'Featured_Category'},
																																						$Param{'Gift_Icon'},
																																						$Param{'Uploaded_Files'},
																																						$Param{'Current_Bid'},
																																						$Param{'Quantity'},
																																						$Param{'Reserve'},
																																						$Param{'BuyPrice'},
																																						$Param{'Duration'}
																																					);
	#==========================================================
	#$Language{'submit_item_transaction'}
	#($User_ID, $Date, $Transaction_Type, $Item, $Credit, $Debit, $Details)
	$Credit = 0;	$Debit = $Total_Fees;
	$Details = join( "~", ($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS));
	&Post_User_Transaction($Param{'User_ID'}, &Time(time), 2, $Item_ID, $Credit, $Debit, $Details);
	#---------------------------------------------------------------------------------
	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Upload_File'});
	&Read_Language_File($Global{'Language_Submit_File'});
	#----------------------------------------------------------
	$End_Time=&Get_Date_Formated(10, $Param{'End_Time'});
	$Out=$Language{'submit_item_confirmation_body'};
	&Read_Classes;
	$Out=&Translate_Classes($Out);		

	($Email, $Name)=&Get_User_Email_and_Name($Param{'User_ID'});

	$Out=~ s/<!--ITEM_ID-->/$Item_ID/g;
	$Out=~ s/<!--USER_ID-->/$Param{'User_ID'}/g;
	$Out=~ s/<!--ITEM_TITLE-->/$Param{'Title'}/g;
	$Out=~ s/<!--START_BID-->/$Param{'Current_Bid'}/g;
	$Out=~ s/<!--QUANTITY-->/$Param{'Quantity'}/g;
	$List=&Web_Decode($Param{'Description'});
	$Out=~ s/<!--DESCRIPTION-->/$List/g;
	$Out=~ s/<!--END_TIME-->/$End_Time/g;
	$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID&Cat_ID=$Param{'Cat_ID'}!;
	$Out=~ s/<!--ITEM_LINK->/$List/g;

	#Email($From, $TO, $Subject,   $Message);
	$Subject=&Translate_Classes($Language{'submit_item_confirmation_subject'});
	&Email($Global{'Auction_Email'}, $Email, $Subject, $Out);
	#----------------------------------------------------------

	$Out=$Language{'your_item_submitted'};
	$Out=~ s/<!--ITEM_ID-->/$Item_ID/g;
	$List=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID&Cat_ID=$Param{'Cat_ID'}!;
	$Out=~ s/<!--ITEM_LINK-->/$List/g;
	$Out=~ s/<!--ITEM_TITLE-->/$Param{'Title'}/g;
	
	$Plugins{'Body'}=$Out;
    &Display($Global{'General_Template'});

}
#==========================================================
sub Parse_Item{
my($Item) = @_;
my(%Item);

	($Item{'Cat_ID'},
	$Item{'User_ID'},
	$Item{'Title'},
	$Item{'Description'},
	$Item{'Quantity'},
	$Item{'Current_Bid'},
	$Item{'Bids'},
	$Item{'Duration'},
	$Item{'End_Time'},
	$Item{'Title_Enhancement'},
	$Item{'Uploaded_Files'},
	$Item{'Gift_Icon'},
	$Item{'Start_Time'},
	$Item{'Item_Extra'}) = split( ':',  $Item);
	return %Item;
}
#==========================================================
sub Parse_Item_Extra{
my($Item) = @_;
my(%Item);

	($Item{'Cat_ID'},
	$Item{'User_ID'},
	$Item{'Title'},
	$Item{'Description'},
	$Item{'Quantity'},
	$Item{'Current_Bid'},
	$Item{'Bids'},
	$Item{'Duration'},
	$Item{'End_Time'},
	$Item{'Title_Enhancement'},
	$Item{'Uploaded_Files'},
	$Item{'Gift_Icon'},
	$Item{'Start_Time'},
	$Item{'Item_Extra'}) = split('~#~',  $Item);

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
	$Item{'Resubmited'}) = split('~\|~', $Item{'Item_Extra'});

	return %Item;

}
#==========================================================
sub Resubmit_Items{
my($Show)=shift;
my ($Item, @Item_Info, $Item_Extra, $Item_ID);
my (%Items, %featured, $Root_Cat_ID, $Spare);
my($Root_Cat, $Cat_File, $Time_Now, $Link);
my($Resubmitted_Items_Count);
my(@Required_Categories, %Resubmited);
my(@Users_ID,	%Users_Emails);
my($Message, $New_Time);
my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst );

	@Required_Categories= sort @Main_Categories;

	print "Content-type: text/html\n\n" if ($Show); 
	print "<center><b>Managing Closed Auctions</b></center>\n<br>" if ($Show);

# if($ARGV[0] =~ "Close" || $ENV{'QUERY_STRING'} =~ "Close") 

	if (!&Lock($Global{'Featured_Home_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %featured, "DB_File", "$Global{'Featured_Home_Items_File'}"
										or &Exit("Cannot open database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	#------------------------------------------------------
	$Time_Now=&Time(time);
	$Resubmitted_Items_Count=0;
	$Counter=0;

	foreach $Root_Cat(@Required_Categories){
		print "<br>\n<b>Resubmitting Auctions in Category: $Root_Cat </b><br>\n" if ($Show);
		$Cat_File = &Get_Cat_File($Category_ID{$Root_Cat});

		if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
		tie %Items, "DB_File", $Cat_File or 
						&Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

		while (($Item_ID, $Item) = (each %Items))  {
			@{$Item_Info[0]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
							End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $Item);

			$Counter++;
			 if ($Show) {if (!($Counter % 10)) {print "<br>\n";} }

			if ($Item_Info[0]{'End_Time'} > $Time_Now){
					print "........."  if ($Show);
					next;
			}

			($Item_Info[0]{'Country'},
			$Item_Info[0]{'Item_Language'},
			$Item_Info[0]{'ypChecks'},
			$Item_Info[0]{'yccMorders'},
			$Item_Info[0]{'yCCards'},
			$Item_Info[0]{'escrow'},
			$Item_Info[0]{'shipping'},
			$Item_Info[0]{'ship_time'},
			$Item_Info[0]{'Ship_Internationally'},
			$Item_Info[0]{'Start_Bid'},
			$Item_Info[0]{'Increment'},
			$Item_Info[0]{'Location'},
			$Item_Info[0]{'Featured_Homepage'},
			$Item_Info[0]{'Featured_Category'},
			$Item_Info[0]{'Reserve'},
			$Item_Info[0]{'BuyPrice'},
			$Item_Info[0]{'BidRating'},
			$Item_Info[0]{'Closing_Time'},
			$Item_Info[0]{'Resubmit'},
			$Item_Info[0]{'Homepage'},
			$Item_Info[0]{'Resubmited'}) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});

			if ($Item_Info[0]{'Resubmited'} >= $Item_Info[0]{'Resubmit'}) {next;}

			if ($Item_Info[0]{'Reserve'}) {
					if ($Item_Info[0]{'Current_Bid'}>=$Item_Info[0]{'Reserve'}) {	next;}
			}

			if ($Item_Info[0]{'Bids'} >0){next;}
			
			print "$Item_ID."  if ($Show);

			$Resubmitted_Items_Count++;
			$Item_Info[0]{'Resubmited'}++;

			$New_Time =&Time(time);
			$Item_Info[0]{'Start_Time'} = $New_Time;
			$Days_in_Sec = ($Item_Info[0]{'Duration'}-1) * 86400;
			( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst ) = gmtime(&Time(time));
			$Item_Info[0]{'End_Time'} = $New_Time + $Days_in_Sec + (($Item_Info[0]{'Closing_Time'} + 24 - $hour) * 3600) ;

			$Spare="";

			$Item_Extra = join("~|~",
				($Item_Info[0]{'Country'},
				$Item_Info[0]{'Item_Language'},
				$Item_Info[0]{'ypChecks'},
				$Item_Info[0]{'yccMorders'},
				$Item_Info[0]{'yCCards'},
				$Item_Info[0]{'escrow'},
				$Item_Info[0]{'shipping'},
				$Item_Info[0]{'ship_time'},
				$Item_Info[0]{'Ship_Internationally'},
				$Item_Info[0]{'Start_Bid'},
				$Item_Info[0]{'Increment'},
				$Item_Info[0]{'Location'},
				$Item_Info[0]{'Featured_Homepage'},
				$Item_Info[0]{'Featured_Category'},
				$Item_Info[0]{'Reserve'},
				$Item_Info[0]{'BuyPrice'},
				$Item_Info[0]{'BidRating'},
				$Item_Info[0]{'Closing_Time'},
				$Item_Info[0]{'Resubmit'},
				$Item_Info[0]{'Homepage'},
				$Item_Info[0]{'Resubmited'},
				$Spare,
				$Spare,
				$Spare,
				$Spare,
				$Spare	));

			$Item = join ('~#~', (
					$Item_Info[0]{'Cat_ID'},
					$Item_Info[0]{'User_ID'},
					$Item_Info[0]{'Title'},
					$Item_Info[0]{'Description'},
					$Item_Info[0]{'Quantity'},
					$Item_Info[0]{'Current_Bid'},
					$Item_Info[0]{'Bids'},
					$Item_Info[0]{'Duration'},
					$Item_Info[0]{'End_Time'},
					$Item_Info[0]{'Title_Enhancement'},
					$Item_Info[0]{'Uploaded_Files'},
					$Item_Info[0]{'Gift_Icon'},
					$Item_Info[0]{'Start_Time'},
					$Item_Extra,
					$Spare,
					$Spare,
					$Spare,
					$Spare,
					$Spare
						));

			#$New_Items{$Item_ID}=$Item;
			$Items{$Item_ID} = $Item;

			if ($Item_Info[0]{'Featured_Homepage'}){
						$featured{$Item_ID} = $Item;
			}

			$Resubmited{$Item_ID} = $Item_Info[0]{'User_ID'};
		}#while
		
		untie %Items;
		undef %Items;
		&Unlock($Cat_File);
	} #end foreach $Root_Cat(@Required_Categories){
	
	untie %featured;
	undef %featured;
	&Unlock($Global{'Featured_Home_Items_File'});

	print "<br>\nDone Resubmitting Closed Auctions.<br>\n" if ($Show);
	#------------------------------------------------------
	print "<br>\nSending Email Notifications for Resubmitted Auctions Sellers.<br>\n" if ($Show);
	
	@Users_ID = values %Resubmited;
	%Users_Emails =&Get_Users_Emails(@Users_ID);

	while(($Item_ID, $User_ID) = each %Resubmited){
			if ($Users_Emails{$User_ID}) {
				print "$User_ID, " if ($Show);
				$Message=$Language{'your_item_resubmitted_email'};
				$Message=~ s/<!--ITEM_ID-->/$Item_ID/g;
				$Message=~ s/<!--USER_ID-->/$User_ID/g;
				$Link=qq!$Global{'Auction_Script_URL'}?action=View_Item&Item_ID=$Item_ID!;
				$Message=~ s/<!--ITEM_LINK-->/$Link/g;

				#Email($From, $TO, $Subject,   $Message);
				&Email($Global{'Auction_Email'},
								$Users_Emails{$User_ID},
								$Language{'your_item_resubmitted_subject'},
								$Message);
			}# End if
	}#End while
	#------------------------------------------------------
	return $Resubmitted_Items_Count;
}
#==========================================================
sub Move_Closed_Items{
my($Show) = shift;
my ($Item, @Item_Info, $Item_Extra, @Required_Categories);
my (%Items, %closed, %featured, $Root_Cat_ID, $Spare);
my($Root_Cat, $Cat_File, $Time_Now, @Closed_Items);
my($Closed_Items_Count, $Item_ID, $Counter);
my(%Closed_Items, %featured_cat, %Itemsx);
my($Final_Value_Fee, $Reserve_Fee, $New_Transaction);
my(%Balance, %Transactions);

	&Initialize_Fee_Parameters;
	print "\n<br><b>Moving Closed Auctions to The Archive... Please wait...</b>\n<br>" if ($Show);
	
	@Required_Categories = sort @Main_Categories;
	
	undef %Closed_Items;

	if (!&Lock($Global{'Featured_Home_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %featured, "DB_File", "$Global{'Featured_Home_Items_File'}" or
										&Exit("Cannot open database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'Featured_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %featured_cat, "DB_File", "$Global{'Featured_Items_File'}" or
										&Exit("Cannot open database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'OpenItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %openindex, "DB_File", "$Global{'OpenItemsIndexFile'}" or
										&Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'Closed_Items_File'})) {&Exit("Cannot Lock database file $Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %closed, "DB_File", "$Global{'Closed_Items_File'}" or
										&Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'Balance_File'})) {&Exit("Cannot Lock database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Balance, "DB_File", "$Global{'Balance_File'}" or
						&Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'Transactions_File'})) {&Exit("Cannot Lock database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Transactions, "DB_File", "$Global{'Transactions_File'}" or
						&Exit("Cannot open database file $Global{'Transactions_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Time_Now = &Time(time);
	$Closed_Items_Count = 0;
	$Counter = 0;

	foreach $Root_Cat(@Required_Categories){
			print "\n<br><b>Moving Closed Auctions From Category: $Root_Cat </b>\n<br>" if ($Show);

			$Cat_File = &Get_Cat_File($Category_ID{$Root_Cat});
			undef %Itemsx;
			if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
			tie %Items, "DB_File", $Cat_File or
						&Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
			
			while (($Item_ID, $Item) = each %Items){
					@{$Item_Info[0]}
							{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $Item);

					$Counter++;
					 if ($Show) {if (!($Counter % 10)) {print "<br>\n";}}

					if ($Item_Info[0]{'End_Time'} > $Time_Now){ 
							print "........." if ($Show);
							$Itemsx{$Item_ID} = $Items{$Item_ID};
							next;
					}

					print "$Item_ID, " if ($Show);

					($Item_Info[0]{'Country'},
					$Item_Info[0]{'Item_Language'},
					$Item_Info[0]{'ypChecks'},
					$Item_Info[0]{'yccMorders'},
					$Item_Info[0]{'yCCards'},
					$Item_Info[0]{'escrow'},
					$Item_Info[0]{'shipping'},
					$Item_Info[0]{'ship_time'},
					$Item_Info[0]{'Ship_Internationally'},
					$Item_Info[0]{'Start_Bid'},
					$Item_Info[0]{'Increment'},
					$Item_Info[0]{'Location'},
					$Item_Info[0]{'Featured_Homepage'},
					$Item_Info[0]{'Featured_Category'},
					$Item_Info[0]{'Reserve'},
					$Item_Info[0]{'BuyPrice'},
					$Item_Info[0]{'BidRating'},
					$Item_Info[0]{'Closing_Time'},
					$Item_Info[0]{'Resubmit'},
					$Item_Info[0]{'Homepage'},
					$Item_Info[0]{'Resubmited'}) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});
										
					if (!$Item_Info[0]{'Bids'}) {$Item_Info[0]{'Bids'} = 0;}
					($Final_Value_Fee, $Reserve_Fee) = &Calculate_Closed_Auction_Fee($Item_Info[0]{'Quantity'}, $Item_Info[0]{'Reserve'}, $Item_Info[0]{'Current_Bid'}, $Item_Info[0]{'Increment'}, $Item_Info[0]{'Bids'});

					if ($Final_Value_Fee > 0) {
							if (!$Balance{$Item_Info[0]{'User_ID'}}) {$Balance{$Item_Info[0]{'User_ID'}} = 0;}
							$Balance{$Item_Info[0]{'User_ID'}} -= $Final_Value_Fee;
							$New_Transaction = join('::', ($Time_Now, 3, $Item_ID, 0, $Final_Value_Fee, $Balance{$Item_Info[0]{'User_ID'}}, ""));
							if (!$Transactions{$Item_Info[0]{'User_ID'}}) {$Transactions{$Item_Info[0]{'User_ID'}} = "";}
							$Transactions{$Item_Info[0]{'User_ID'}} .= '~|~' . $New_Transaction;
					}

					if ($Reserve_Fee > 0) {
							if (!$Balance{$Item_Info[0]{'User_ID'}}) {$Balance{$Item_Info[0]{'User_ID'}} = 0;}
							$Balance{$Item_Info[0]{'User_ID'}} += $Reserve_Fee;
							$New_Transaction = join('::', ($Time_Now, 4, $Item_ID, $Reserve_Fee, 0, $Balance{$Item_Info[0]{'User_ID'}}, ""));
							if (!$Transactions{$Item_Info[0]{'User_ID'}}) {$Transactions{$Item_Info[0]{'User_ID'}} = "";}
							$Transactions{$Item_Info[0]{'User_ID'}} .= '~|~' . $New_Transaction;
					}

					delete $openindex{$Item_ID} if ($openindex{$Item_ID});
					delete $featured{$Item_ID} if ($featured{$Item_ID});
					delete $featured_cat{$Item_ID} if ($featured_cat{$Item_ID});
					
					$Closed_Items_Count++;
					$closed{$Item_ID} = $Item;
					$Closed_Items{$Item_ID} = $Item_Info[0]{'User_ID'};
					#delete  $Items{$Item_ID};
			}#while (($Item_ID, $Item) = (each %Items))
			%Items = %Itemsx;
			untie %Items;
			undef %Items;
			&Unlock($Cat_File);

	} #end foreach $Root_Cat(@Required_Categories){

	untie %featured;
	undef %featured;
	&Unlock($Global{'Featured_Home_Items_File'});

	untie %featured_cat;
	undef %featured_cat;
	&Unlock($Global{'Featured_Items_File'});

	untie %openindex;
	undef %openindex;
	&Unlock($Global{'OpenItemsIndexFile'});

	untie %closed;
	undef %closed;
	&Unlock($Global{'Closed_Items_File'});

	untie %Balance;
	undef %Balance;
	&Unlock($Global{'Balance_File'});

	untie %Transactions;
	undef %Transactions;
	&Unlock($Global{'Transactions_File'});

	print "<br>\n<b>Done Moving Closed Auctions.<b><br>\n" if ($Show);
	print "<br>\n<b>Updating Categories Count..." if ($Show);

	&Update_All_Categories_Count(0);
	
	print "      Done.<b><br>\n"  if ($Show);
	print "<br>\n<b>Sending Email Notifications for Closed Auctions Sellers and Bidders.<b><br>\n" if ($Show);
	
	&Send_Closed_Auctions_Emails($Show, %Closed_Items);

	print "<br>\n<b>Finished Managing Closed Auctions.<b><br>\n" if ($Show);

	return ($Closed_Items_Count);

}
#==========================================================
sub Send_Closed_Auctions_Emails{
my($Show, %Closed_Items)=@_;
my(%Item_Bids, %Users, @All_Bids, $x, $Line, $Seller_Email, $Seller_ID);
my($Item, $Bidder, @Bidders, $Bid_Count, $Msg, $Counter,$Count, $Link);
my($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Bids);
my($Item_Price, $Subj);

	#$Closed_Items{$Item_ID}=$Item_Info[0]{'User_ID'};
	%Item_Bids=&Get_Items_Bids(keys %Closed_Items);
	%Users=&Get_Users_Emails(values %Closed_Items);
	$Count=0;

	while ( ($Item_ID, $Item) = each %Item_Bids){
			$Seller_ID=$Closed_Items{$Item_ID};
			$Seller_Email=$Users{$Seller_ID};

			$Link=qq!$Global{'Auction_Script_URL'}?action=View_Archived_Item&Item_ID=$Item_ID!;

			print "$Item_ID, " if ($Show);

			if ($Show){if (!($Count % 8)) {print "<br>\n";} }

			$Count++;

			($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);
			@All_Bids = split(/=/, $Bids);
			
			$Bid_Count = 0;
			foreach $Bidder(@All_Bids){
				@{$Bidders[$Bid_Count]}
					   {qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)}=split(/\:/, $Bidder);
				if ($Bidders[$Bid_Count]{'Status'} != 0) { $Bid_Count++; }
			}

			@Bidders = sort { $a->{'Bid'} <=> $b->{'Bid'} 
								or $a->{'Bid_Time'} <=> $b->{'Bid_Time'} } @Bidders;

			$Item_Price = $Bidders[0]{'Bid'};
			#----------------------------------------------
			#   Seller notification
			$Msg=$Language{'seller_auction_close_email_body'};
			$Msg=~ s/<!--ITEM_ID-->/$Item_ID/g;
			$Msg=~ s/<!--SELLER_ID-->/$Seller_ID/g;
			$Msg=~ s/<!--ITEM_LINK-->/$Link/g;
			$Msg=~ s/<!--ITEM_PRICE-->/$Item_Price/g;

			for $x(0..$Bid_Count - 1){
					$Line=$Language{'winner_email_line'};
					$Line=~ s/<!--BIDDER_ID-->/$Bidders[$x]{'User_ID'}/g;
					$Line=~ s/<!--BIDDER_EMAIL-->/$Bidders[$x]{'Email'}/g;
					$Line=~ s/<!--BIDDER_QTY-->/$Bidders[$x]{'Win_Qty'}/g;
					$Line=~ s/<!--BIDDER_PRICE-->/$Bidders[$x]{'Bid'}/g;
					$Msg .=$Line;
			}
			$Msg = &Translate($Msg);
			$Subj=$Language{'seller_auction_close_email_subject'};
			$Subj=~ s/<!--ITEM_ID-->/$Item_ID/g;

			&Email($Global{'Auction_Email'},
							$Seller_Email,
							$Subj,
							$Msg);
			#----------------------------------------------
			#   winners notification
			for $x(0..$Bid_Count - 1){
				if ($Bidders[$x]{'Bid'} >= $Reserve){
							$Msg=$Language{'winner_email_body'};
							$Msg=~ s/<!--ITEM_ID-->/$Item_ID/g;
							$Msg=~ s/<!--WINNER_ID-->/$Bidders[$x]{'User_ID'}/g;
							$Msg=~ s/<!--SELLER_ID-->/$Seller_ID/g;
							$Msg=~ s/<!--SELLER_EMAIL-->/$Seller_Email/g;
							$Msg=~ s/<!--WINNER_QTY-->/$Bidders[$x]{'Win_Qty'}/g;
							$Msg=~ s/<!--ITEM_LINK-->/$Link/g;
							$Msg=~ s/<!--BIDDER_PRICE-->/$Bidders[$x]{'Bid'}/g;
							$Msg = &Translate($Msg);
							$Subj=$Language{'winner_email_subject'};
							$Subj=~ s/<!--ITEM_ID-->/$Item_ID/g;

							&Email($Global{'Auction_Email'},
									$Bidders[$x]{'Email'},
									$Subj,
									$Msg);
				}
				else{
							$Msg=$Language{'non_winner_email_body'};
							$Msg=~ s/<!--ITEM_ID-->/$Item_ID/g;
							$Msg=~ s/<!--BIDDER_ID-->/$Bidders[$x]{'User_ID'}/g;
							$Msg=~ s/<!--SELLER_ID-->/$Seller_ID/g;
							$Msg=~ s/<!--SELLER_EMAIL-->/$Seller_Email/g;
							$Msg=~ s/<!--BIDDER_QTY-->/$Bidders[$x]{'Win_Qty'}/g;
							$Msg=~ s/<!--ITEM_LINK-->/$Link/g;
							$Msg=~ s/<!--BIDDER_PRICE-->/$Bidders[$x]{'Bid'}/g;
							$Msg = &Translate($Msg);
							$Subj= $Language{'non_winner_email_subject'};
							$Subj=~ s/<!--ITEM_ID-->/$Item_ID/g;

							&Email($Global{'Auction_Email'},
									$Bidders[$x]{'Email'},
									$Subj,
									$Msg);
				}
			}
			#----------------------------------------------
	}#End while
	
}
#==========================================================
sub Get_Archived_Items_Count{
my (%Items, $Items_Count);

	if (!-e $Global{'Closed_Items_File'}) {return 0;}
	&DB_Exist("$Global{'Closed_Items_File'}");
	tie %Items, "DB_File", "$Global{'Closed_Items_File'}", O_RDONLY or
										&Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$Items_Count=keys %Items;
	untie %Items;

	return $Items_Count;

}
#==========================================================
sub Remove_Closed_Items{
my($Close_Time)=shift;
my ($Item, $Item_ID, @Item_Info);
my (%Items, %index, %itembid, $Removed_Items_Count);
my(@Photos, $Upload, @Photo, $Photo);

	&Unlock($Global{'Closed_Items_File'});

	if (!&Lock($Global{'ItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'ItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %index, "DB_File", $Global{'ItemsIndexFile'} or
									&Exit("Cannot open database file $Global{'ItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'ItemsBidsFile'})) {&Exit("Cannot Lock database file $Global{'ItemsBidsFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %itembid, "DB_File", $Global{'ItemsBidsFile'} or
									&Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Global{'Closed_Items_File'})) {&Exit("Cannot Lock database file $Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Items, "DB_File", "$Global{'Closed_Items_File'}" or
									&Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Removed_Items_Count=0;

	while ( ($Item_ID, $Item) = (each %Items) )  {
			@{$Item_Info[0]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
							End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $Item);

			if ($Item_Info[0]{'End_Time'} < $Close_Time){
					$Removed_Items_Count++;
						
					@Photos=split(/\|/, $Item_Info[0]{'Uploaded_Files'});
							foreach $Upload (@Photos) {
							@Photo=split(/\//,$Upload);
							$Photo=pop @Photo;
							unlink "$Global{'Upload_Dir'}/$Photo";
					}

					delete ($Items{$Item_ID});
					delete ($index{$Item_ID});
					delete ($itembid{$Item_ID});
			}
	}

	untie %index;
	untie %itembid;
	untie %Items;
	&Unlock($Global{'ItemsIndexFile'});
	&Unlock($Global{'ItemsBidsFile'});
	&Unlock($Global{'Closed_Items_File'});

	return ($Removed_Items_Count);
}
#==========================================================
sub Check_Archived_Item{
my($Item_ID)=shift;
my(%data, $OK);

	&DB_Exist($Global{'Closed_Items_File'});
	tie %data, "DB_File", "$Global{'Closed_Items_File'}", O_RDONLY or
										&Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$OK = 0;
	if ($data{$Item_ID}) {
				$OK = 1;
	}

	untie %data;

	return ($OK);
}
#==========================================================
sub Delete_Item{
my($Item_ID)=shift;
my(%data, $Cat_ID, $Root_Cat_ID, $Cat_File, $Status);
	
	if (!&Lock($Global{'OpenItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", "$Global{'OpenItemsIndexFile'}" or
										&Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	$Cat_ID = 0;
	if ($data{$Item_ID}) {
			$Cat_ID=$data{$Item_ID}; 
			delete $data{$Item_ID};
	}

	 untie %data;
	 undef %data;
	 &Unlock($Global{'OpenItemsIndexFile'});
	
	if ($Cat_ID){
			$Root_Cat_ID=&Get_Root_Cat_ID($Cat_ID);
			$Cat_File = &Get_Cat_File($Root_Cat_ID);

			if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
			tie %data, "DB_File", $Cat_File or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

			$Status=0;

			if ($data{$Item_ID}) {
					@{$Item_Info[0]}
							{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $data{$Item_ID});

					@Photos=split(/\|/, $Item_Info[0]{'Uploaded_Files'});
					foreach $Upload (@Photos) {
							@Photo=split(/\//,$Upload);
							$Photo=pop @Photo;
							unlink "$Global{'Upload_Dir'}/$Photo";
					}

					delete $data{$Item_ID};
					$Status=1;
			}

			untie %data;
			undef %data;
			&Unlock($Cat_File);
	}

	if (!&Lock($Global{'Featured_Home_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", "$Global{'Featured_Home_Items_File'}" or
										&Exit("Cannot open database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	delete $data{$Item_ID};
	untie %data;
	undef %data;
	&Unlock($Global{'Featured_Home_Items_File'});

	if (!&Lock($Global{'Featured_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'Featured_Items_File'} or
									&Exit("Cannot open database file $Global{'Featured_Items_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	delete $data{$Item_ID};
	untie %data;
	undef %data;
	&Unlock($Global{'Featured_Items_File'});

	if (!&Lock($Global{'ItemsBidsFile'})) {&Exit("Cannot Lock database file $Global{'ItemsBidsFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'ItemsBidsFile'} or
									&Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	delete $data{$Item_ID};
	untie %data;
	undef %data;
	&Unlock($Global{'ItemsBidsFile'});

	if (!&Lock($Global{'ItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'ItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'ItemsIndexFile'} or
									&Exit("Cannot open database file $Global{'ItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	delete $data{$Item_ID};
	untie %data;
	undef %data;
	&Unlock($Global{'ItemsIndexFile'});

	return ($Status);
}
#==========================================================
sub Get_Archived_Items{
my(%Items, %data);

	&DB_Exist("$Global{'Closed_Items_File'}");
	tie %data, "DB_File", "$Global{'Closed_Items_File'}", O_RDONLY
										 or &Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%Items=%data;
	untie %data;

	return (%Items);
}
#==========================================================
sub Add_Featured_Item{
my ($Item_ID , $Cat_ID)=@_;
my (%data);	

	if (!&Lock($Global{'Featured_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Featured_Items_File'} or
						&Exit("Cannot open database file $Global{'Featured_Items_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$Item_ID}=$Cat_ID;
	untie %data;
	&Unlock($Global{'Featured_Items_File'});

}
#==========================================================	
sub Add_Featured_Home_Item{
my ($Item_ID , $Item)=@_;
my (%data);	

	if (!&Lock($Global{'Featured_Home_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Featured_Home_Items_File'} or
						&Exit("Cannot open database file $Global{'Featured_Home_Items_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$Item_ID}=$Item;
	untie %data;

	&Unlock($Global{'Featured_Home_Items_File'});

}
#==========================================================	
sub Reset_Category_Count{ 
my ($Cat_ID)=shift;
my (%data, $cat);
my ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description);

	if (!$Cat_ID) {return 0;}

	if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Categories_Data_File'} or
					    &Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if ($data{$Cat_ID}) {
			$cat=$data{$Cat_ID};
			($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description) = split(/\|/, $cat);
			$Count =0;
			$cat=join("|", ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description));
			$data{$Cat_ID}="$cat";
	}

	untie %data;
	undef %data;
	&Unlock($Global{'Categories_Data_File'});
	return 1;
}
#==========================================================
sub Reset_All_Category_Count{ 
my ($Reset_Count)=shift;
my ($Cat_ID, %data);
my ($cat, $Cat, @Category);
my ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description);

	if (!$Reset_Count) {$Reset_Count = 0;}
	&Initialize_Categories;

	if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Categories_Data_File'} or
						&Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	foreach $Cat(@Category_URL) {
			$Cat_ID=$Category_ID{$Cat};
			$cat=$data{$Cat_ID};
			($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description) = split(/\|/, $cat);
			$Count =$Reset_Count;
			$cat=join("|", ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description));
			$data{$Cat_ID}="$cat";
	}

	untie %data;
	undef %data;
	&Unlock($Global{'Categories_Data_File'});

}
#==========================================================
sub Update_Category_Count{ 
my ($Cat_ID, $Value)=@_;
my ($Required_Category, @Subs, @Categoy, %data);
my ($cat, $S, @SubCat, $SS, $CC, @AT);
my ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description);

	if (!$Cat_ID) {return 0;}
	if (!$Value) {return 0;}

	$Required_Category = $Category_Root{$Cat_ID}; #Full cat url

	if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Categories_Data_File'} or
						&Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	@Subs=split(/\:/, $Required_Category);
	@SS=@Subs;

	foreach $CC (@SS) {
				$Required_Category=join(":", @Subs);
				$S=pop (@Subs);
				$Cat_ID=$Category_ID{$Required_Category};
				$cat=$data{$Cat_ID};

				($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description) = split(/\|/, $cat);
				$Count += $Value;

				$cat=join("|", ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description));
				$data{$Cat_ID}="$cat";
	}

	untie %data;
	undef %data;
	&Unlock($Global{'Categories_Data_File'});

	&Update_Total_Items_Count;

}
#==========================================================
sub 	Get_Catgories_Count{
my (%data, %Count, %Categories);
my($Item_ID, $Cat_ID);

	&DB_Exist($Global{'Categories_Data_File'});
	tie %Categories, "DB_File", $Global{'Categories_Data_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	foreach $Cat (keys %Categories) {
			$Count{$Cat}=0;
	}
	untie %Categories;

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %data, "DB_File", $Global{'OpenItemsIndexFile'}, O_RDONLY
					or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	undef %Count;

	while (($Item_ID, $Cat_ID)=each(%data)) {
			$Count{$Cat_ID}++;
	}

	untie %data;

	return (%Count);

}
#==========================================================
sub Update_All_Categories_Count{ 
my($Show)=@_;
my ($Cat_ID, $Required_Category, $Sub_Cat_ID, $cat, $subcat);
my (@Subs, %data, %Cat_Count, $x, $S);
my($Full_Cat, @Sub_Cats, $Sub_Cat, $Out);
my ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description);

	if ($Show) {print "Content-type: text/html\n\n";}

	&Reset_All_Category_Count(0);
	
	if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Categories_Data_File'} or
								&Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%Cat_Count = &Get_Catgories_Count();

	@Category_URL = sort @Category_URL;
	$Cat_Count = @Category_URL;

	if ($Show) {print "<CENTER><FONT COLOR=\"RED\" SIZE=\"5\"><B>Updating Categories Count</B></FONT></CENTER><BR>";}
	if ($Show) {print "<FONT COLOR=\"RED\"><B>Total Number Of Categories: $Cat_Count</B></FONT><BR><BR>";}


	foreach $Full_Cat (@Category_URL) {
			@Sub_Cats=split(/\:/, $Full_Cat);
			@Subs=@Sub_Cats;
			$Sub_Cat_ID = $Category_ID{$Full_Cat};
			$Subcat_Count = $Cat_Count{$Sub_Cat_ID};
			if (!$Subcat_Count) {$Subcat_Count = 0;	}

			if ($Show) {print "<B>$Full_Cat: $Subcat_Count</B><BR>";}

			for $x (0..$#Sub_Cats) {
						$Sub_Category=join(":", @Subs); 
						$Sub = pop (@Subs);
						$Sub_Cat_ID = $Category_ID{$Sub_Category};
						$cat = $data{$Sub_Cat_ID};
						
						($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description) = split(/\|/, $cat);
						if (!$Count) {$Count=0;}
						$Count += $Subcat_Count;
						$cat=join("|", ($Category, $SubCategory, $ID, $Active, $Accept, $Count, $SortNum, $Under_Flag, $Description));
						$data{$Sub_Cat_ID}=$cat;
			}
	}

	untie %data;
	undef %data;

	&Unlock($Global{'Categories_Data_File'});

	&Prepare_Categories;

	&Update_Total_Items_Count;

	if ($Show) {
			$Out = "<BR>     Done... Bye<BR>";
			$Out .= qq!<center><b><a href="javascript:window.close()">Close This Window</a></b></center><br>!;
			print "$Out<br>";
	}
	
}
#==========================================================
sub Get_Category_Items_Count{
my ($Required_Cat_ID)=shift;
my (%data, $Count);
my($Item_ID, $Cat_ID);

	if (!$Required_Cat_ID) {return 0;}

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %data, "DB_File", $Global{'OpenItemsIndexFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Count=0;
	while (($Item_ID, $Cat_ID)=each(%data)) {
			if ($Required_Cat_ID == $Cat_ID) {
						$Count++;
			}
	}

	untie %data;
	return ($Count);
}
#==========================================================
sub Update_Total_Items_Count{
my(%data, %Count);
my($cat, $subcat, $x, $Total);	

	&Initialize_Categories;

	$Total = 0;

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %Count, "DB_File", $Global{'OpenItemsIndexFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Total = keys %Count;
	untie %Count;
	undef %Count;

	if (!&Lock($Global{'Configuration_File'})) {&Exit("Cannot Lock database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Configuration_File'} or
						&Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Total_Items_Count'} = $Total;

	untie %data;
	&Unlock($Global{'Configuration_File'});

	$Global{'Total_Items_Count'} = $Total;

}
#==========================================================
sub Save_Item{
my ($Cat_ID, $Item)=@_;
my (%data, %index, $Cat_File);
my ($ID, $Root_Cat_ID);

	if (!$Cat_ID) {return 0;}
	if (!$Item) {return 0;}

	$Root_Cat_ID = &Get_Root_Cat_ID($Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	if (!&Lock($Global{'ItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'ItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %index, "DB_File", $Global{'ItemsIndexFile'}
						or &Exit("Cannot open database file $Global{'ItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$ID=int (rand(999999999));
	do{
				$ID++;
	} while ( $index{$ID} );

	$index{$ID}= $Cat_ID;

	 untie %index;
	 undef %index;
	&Unlock($Global{'ItemsIndexFile'});

	if (!&Lock($Global{'OpenItemsIndexFile'})) {&Exit("Cannot Lock database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %index, "DB_File", $Global{'OpenItemsIndexFile'}
						or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$index{$ID}= $Cat_ID;
	 untie %index;
	 undef %index;
	&Unlock($Global{'OpenItemsIndexFile'});

	if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Cat_File
						or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$ID}= $Item;
	 untie %data;
	 undef %data;
	&Unlock($Cat_File);

	  return ($ID);
}
#==========================================================
sub Get_Item{ 
my ($Item_ID)=shift;
my ($Item, $Root_Cat_ID);
my (%data, $Cat_ID);

	$Items_Count = 0;
	undef @Item_Info;
	if (!$Item_ID) {return 0;}

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %data, "DB_File", "$Global{'OpenItemsIndexFile'}", O_RDONLY
				or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$data{$Item_ID}) {
				 untie %data;
				 undef %data;
				 &Get_Archived_Item($Item_ID);
				 return 0;
	}
	
	$Cat_ID = $data{$Item_ID};
	untie %data;
	undef %data;

	$Root_Cat_ID =&Get_Root_Cat_ID($Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	&DB_Exist($Cat_File);
	tie %data, "DB_File", $Cat_File, O_RDONLY
					or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$data{$Item_ID}) {
				 untie %data;
				 undef %data;
				 return 0;
	}

	$Item = $data{$Item_ID};
	@{$Item_Info[0]}
	   {qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
			End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $Item);
   @{$Item_Info[0]}{'Item_ID'} = $Item_ID;
	$Items_Count = 1;

	untie %data;
	undef %data;
	return 1;
}
#==========================================================
sub Check_Buy_Item{
my($Item_ID)=shift;
my($Item_Extra, $Spare, $Item, $TimeNow);
	
		&Get_Item($Item_ID);

		($Item_Info[0]{'Country'},
		$Item_Info[0]{'Item_Language'},
		$Item_Info[0]{'ypChecks'},
		$Item_Info[0]{'yccMorders'},
		$Item_Info[0]{'yCCards'},
		$Item_Info[0]{'escrow'},
		$Item_Info[0]{'shipping'},
		$Item_Info[0]{'ship_time'},
		$Item_Info[0]{'Ship_Internationally'},
		$Item_Info[0]{'Start_Bid'},
		$Item_Info[0]{'Increment'},
		$Item_Info[0]{'Location'},
		$Item_Info[0]{'Featured_Homepage'},
		$Item_Info[0]{'Featured_Category'},
		$Item_Info[0]{'Reserve'},
		$Item_Info[0]{'BuyPrice'},
		$Item_Info[0]{'BidRating'},
		$Item_Info[0]{'Closing_Time'},
		$Item_Info[0]{'Resubmit'},
		$Item_Info[0]{'Homepage'},
		$Item_Info[0]{'Resubmited'}) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});

	if ($Item_Info[0]{'BuyPrice'}){
		 if ($Item_Info[0]{'Current_Bid'} >= $Item_Info[0]{'BuyPrice'}) {
			$TimeNow=&Time(time);
			$Item_Info[0]{'End_Time'}=$TimeNow;
			$Spare="";

			$Item_Extra=join("~|~",
				($Item_Info[0]{'Country'},
				$Item_Info[0]{'Item_Language'},
				$Item_Info[0]{'ypChecks'},
				$Item_Info[0]{'yccMorders'},
				$Item_Info[0]{'yCCards'},
				$Item_Info[0]{'escrow'},
				$Item_Info[0]{'shipping'},
				$Item_Info[0]{'ship_time'},
				$Item_Info[0]{'Ship_Internationally'},
				$Item_Info[0]{'Start_Bid'},
				$Item_Info[0]{'Increment'},
				$Item_Info[0]{'Location'},
				$Item_Info[0]{'Featured_Homepage'},
				$Item_Info[0]{'Featured_Category'},
				$Item_Info[0]{'Reserve'},
				$Item_Info[0]{'BuyPrice'},
				$Item_Info[0]{'BidRating'},
				$Item_Info[0]{'Closing_Time'},
				$Item_Info[0]{'Resubmit'},
				$Item_Info[0]{'Homepage'},
				$Item_Info[0]{'Resubmited'},
				$Spare,
				$Spare,
				$Spare,
				$Spare,
				$Spare	));

			$Item = join ('~#~', 
					($Item_Info[0]{'Cat_ID'},
					$Item_Info[0]{'User_ID'},
					$Item_Info[0]{'Title'},
					$Item_Info[0]{'Description'},
					$Item_Info[0]{'Quantity'},
					$Item_Info[0]{'Current_Bid'},
					$Item_Info[0]{'Bids'},
					$Item_Info[0]{'Duration'},
					$Item_Info[0]{'End_Time'},
					$Item_Info[0]{'Title_Enhancement'},
					$Item_Info[0]{'Uploaded_Files'},
					$Item_Info[0]{'Gift_Icon'},
					$Item_Info[0]{'Start_Time'},
					$Item_Extra,
					$Spare,
					$Spare,
					$Spare,
					$Spare,
					$Spare
						));

			&Update_Item($Item_ID, $Item);
		 }
	}

}
#==========================================================
sub Update_Item{
my($Item_ID, $Item)=@_;
my ($Root_Cat_ID, $Cat_File);
my (%data, %index, $Cat_ID);

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %index, "DB_File", "$Global{'OpenItemsIndexFile'}", O_RDONLY
							or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Cat_ID = $index{$Item_ID};
	 untie %index;
	 undef %index;

	$Root_Cat_ID=&Get_Root_Cat_ID($Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Cat_File
					or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	delete $data{$Item_ID};
	$data{$Item_ID} = $Item;
	untie %data;
	&Unlock($Cat_File);
}
#==========================================================
sub Read_Category_Items{ 
my ($Required_Cat_ID)=shift;
my (%data, %datax, $Root_Cat_ID);
my ($key, $value, $Cat_File);

	$Items_Count=0;
	undef @Item_Info;
	if (!$Required_Cat_ID) {return 0;}

	$Root_Cat_ID = &Get_Root_Cat_ID($Required_Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	&DB_Exist($Cat_File);
	tie %data, "DB_File", $Cat_File, O_RDONLY
						or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%datax = %data;
	 untie %data;
	 undef %data;
	#--------------------------------------------------------------------------------------

	while (($key, $value ) = each(%datax)) {
			($Cat_ID, $Item)=split( '~#~',  $value);
			if ($Cat_ID == $Required_Cat_ID) {			
				@{$Item_Info[$Items_Count]}
						{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
								End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
			
				@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
				$Items_Count++;
		   }
	}

}
#==========================================================
sub Read_Root_Category_Items{ 
my ($Root_Cat_ID)=shift;
my (%data);
my ($key, $value, $Cat_File);

	$Items_Count=0;
	undef @Item_Info;
	if (!$Root_Cat_ID) {return 0;}

	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	&DB_Exist($Cat_File);
	tie %data, "DB_File", $Cat_File, O_RDONLY
						or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Items_Count = 0;
	undef @Item_Info;

	while (($key, $value ) = each(%data)) {
			@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
			
			@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
			$Items_Count++;
	}

	untie %data;
}
#==========================================================
sub Read_From_Category_Items{ 
my ($Required_Cat_ID)=shift;
my(@Items_ID)=@_;
my (%data, $Root_Cat_ID, $Cat_File);
my ($key, $value, $Item_ID);

	$Items_Count=0;
	undef @Item_Info;
	if (!$Required_Cat_ID) {return 0;}

	$Root_Cat_ID = &Get_Root_Cat_ID($Required_Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	&DB_Exist($Cat_File);
	tie %data, "DB_File", $Cat_File, O_RDONLY
					or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);


	foreach $Item_ID(@Items_ID) {
			@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $data{$Item_ID});
					@{$Item_Info[$Items_Count]}{'Item_ID'}=$Item_ID;
					$Items_Count++;
	}
	if ($Items_Count==0) {undef @Item_Info;}
	 untie %data;
	 undef %data;

}
#==========================================================
sub Get_Featured_Home_Items{ 
my (%data, %Index, @Items_IDs, @IDs, $Items_Countx);
my ($key, $value, $Start_Item, $Total_Items, $x, $Count);

	$Start_Item = 0;
	&DB_Exist($Global{'General_Data_File'});
	tie %data, "DB_File", "$Global{'General_Data_File'}", O_RDONLY
						or &Exit("Cannot open database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%Index = %data; 
	untie %data;
	undef %data;

	if ($Index{'Featured_Home_Start_Item'}) {
			$Start_Item = $Index{'Featured_Home_Start_Item'};
	}

	&DB_Exist($Global{'Featured_Home_Items_File'});
	tie %data, "DB_File", "$Global{'Featured_Home_Items_File'}", O_RDONLY
						or &Exit("Cannot open database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	@IDs = sort(keys %data);
	$Total_Items=@IDs;

	if ($Start_Item > $Total_Items) {$Start_Item=0;}

	$Plugins{'Featured_Home_Count'} = $Total_Items;

	if ($Total_Items <= $Global{'Featured_Home_Items_Per_Page'}) {
			@Items_IDs=@IDs;
			$Items_Countx=$Total_Items;
	}
	else{
			$Items_Countx=0;
			for $x(0..$Global{'Featured_Home_Items_Per_Page'}-1) {
				$Count = $x + $Start_Item;
				if ($Count< $Total_Items) {
					$Items_IDs[$Items_Countx]=$IDs[$Count];
					$Items_Countx++;
				}
			}
			
			$Start_Item += $Global{'Featured_Home_Items_Per_Page'};

			if ($Items_Countx < $Global{'Featured_Home_Items_Per_Page'}) {
				$Count=$Global{'Featured_Home_Items_Per_Page'} - $Items_Countx;
				$Start_Item=0;
				for $x(0..$Count-1) {
					$Items_IDs[$Items_Countx]=$IDs[$x];
					$Items_Countx++;
				}
				$Start_Item=$Count + 1;
			}
	}

	if (!&Lock($Global{'General_Data_File'})) {&Exit("Cannot Lock database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Index, "DB_File", "$Global{'General_Data_File'}"
						or &Exit("Cannot open database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$Index{'Featured_Home_Start_Item'} = $Start_Item;
	untie %Index;
	undef %Index; 
	&Unlock($Global{'General_Data_File'});

	$Items_Count = 0;
	undef @Item_Info;

	foreach $Item_ID(@Items_IDs) {
			@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $data{$Item_ID});
			@{$Item_Info[$Items_Count]}{'Item_ID'} = $Item_ID;
			$Items_Count++;
	}

	 untie %data;
}
#==========================================================
sub Get_Featured_Category_Items{
my($Required_Cat_ID)=shift;
my(@Items_IDs, @IDs);
my (%Index, %data);
my ($key, $value);
my($Item_ID, $Cat_ID);
my($Start_Item_Index, $Start_Item, $Items_Countx);

	$Start_Item = 0;

	&DB_Exist($Global{'General_Data_File'});
	tie %data, "DB_File", "$Global{'General_Data_File'}", O_RDONLY
						or &Exit("Cannot open database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%Index = %data; 
	untie %data;
	undef %data;
	$Start_Item_Index = "Featured_Cat_". $Required_Cat_ID. "Start_Item";
	if ($Index{$Start_Item_Index}) {
			$Start_Item=$Index{$Start_Item_Index};
	}
	&DB_Exist($Global{'Featured_Items_File'});
	tie %data, "DB_File", "$Global{'Featured_Items_File'}", O_RDONLY
						or &Exit("Cannot open database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Items_Countx=0;

	while(($Item_ID, $Cat_ID)=(each %data)){
			if ($Cat_ID == $Required_Cat_ID) {
				$Items_IDs[$Items_Countx++]=$Item_ID;
			}
	}

	 untie %data;
	 undef %data;

	@IDs=sort(@Items_IDs);
	$Total_Items=@IDs;
	undef @Items_IDs;

	if ($Start_Item > $Total_Items) {$Start_Item=0;}

	$Plugins{'Featured_Category_Count'}=$Total_Items;

	if ($Total_Items <= $Global{'Featured_Items_Per_Page'}) {
			@Items_IDs=@IDs;
	}
	else{
			$Items_Countx=0;
			for $x(0..$Global{'Featured_Items_Per_Page'}-1) {
				$Count=$x + $Start_Item;
				if ($Count < $Total_Items) {
					$Items_IDs[$Items_Countx++]=$IDs[$Count];
				}
			}
			
			$Start_Item += $Global{'Featured_Items_Per_Page'};

			if ($Items_Countx < $Global{'Featured_Items_Per_Page'}) {
				$Count=$Global{'Featured_Items_Per_Page'} - $Items_Countx;
				for $x(0..$Count-1) {
					$Items_IDs[$Items_Countx++]=$IDs[$x];
				}
				$Start_Item=$Count + 1;
			}
	}

	if (!&Lock($Global{'General_Data_File'})) {&Exit("Cannot Lock database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %Index, "DB_File", "$Global{'General_Data_File'}"
						or &Exit("Cannot open database file $Global{'General_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$Index{$Start_Item_Index} = $Start_Item;
	untie %Index;
	undef %Index; 
	&Unlock($Global{'General_Data_File'});

	&Read_From_Category_Items($Required_Cat_ID, @Items_IDs);

}
#==========================================================
sub Add_Item_For_Bid{
my 	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy)=@_;
my %data;
	
	if (!$Item_ID) {return 0;}

	if (!&Lock($Global{'ItemsBidsFile'})) {&Exit("Cannot Lock database file $Global{'ItemsBidsFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'ItemsBidsFile'}
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	#	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)
	$data{$Item_ID} = join("\|", ($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, 0, ""));

	untie %data;
	undef %data;
	&Unlock($Global{'ItemsBidsFile'});

}
#==========================================================
sub 	Update_Item_Current_Bid{
my ($Item_ID, $New_Current_Bid, $Number_of_Bids) = @_;
my (%data, %featured, $Cat_ID,  $Item);
my(@Item_Info, $Items_Count);

	if (!$Item_ID) {return 0;}

	&DB_Exist($Global{'ItemsIndexFile'});
	tie %data, "DB_File", $Global{'ItemsIndexFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsIndexFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Cat_ID = $data{$Item_ID};
	untie %data;
	undef %data;

	$Root_Cat_ID = &Get_Root_Cat_ID($Cat_ID);
	$Cat_File = &Get_Cat_File($Root_Cat_ID);

	if (!&Lock($Global{'Featured_Home_Items_File'})) {&Exit("Cannot Lock database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %featured, "DB_File", "$Global{'Featured_Home_Items_File'}"
			or &Exit("Cannot open database file $Global{'Featured_Home_Items_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!&Lock($Cat_File)) {&Exit("Cannot Lock database file $Cat_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Cat_File
		    or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Items_Count=0;

	if (defined $data{$Item_ID}) {
			$Item=$data{$Item_ID};
			@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $Item);

			($Cat_ID, $User_ID , $Title, $Description, $Quantity, $Current_Bid, $Bids, $Duration, 
				$End_Time, $Title_Enhancement, $Uploaded_Files, $Gift_Icon, $Item_Extra)=split( '~#~',  $Item);

			$Item_Info[$Items_Count]{'Current_Bid'}=$New_Current_Bid;
			$Item_Info[$Items_Count]{'Bids'}=$Number_of_Bids;

			#$Item=join("~#~", ($Cat_ID, $User_ID , $Title, $Description, $Quantity, $Current_Bid, $Bids, $Duration, 
			#			$End_Time, $Title_Enhancement, $Uploaded_Files, $Gift_Icon, $Item_Extra));
			$Item = join("~#~", @{$Item_Info[$Items_Count]}{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}); 

			$data{$Item_ID} = $Item;
			if (defined $featured{$Item_ID}) {$featured{$Item_ID} = $Item;}
			$Success = 1;
	}
	else{
			$Success=0;
	}

	untie %data;
	undef %data;
	&Unlock($Global{'Featured_Home_Items_File'});

	untie %featured;
	undef %featured;
	&Unlock($Cat_File);

	return $Success;
}
#==========================================================
sub Get_Item_Bids{
my($Item_ID)=shift;
my($Item, %data);

	$Item = undef;

	&DB_Exist($Global{'ItemsBidsFile'});
	tie %data, "DB_File", $Global{'ItemsBidsFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if ($data{$Item_ID}) {
			$Item = $data{$Item_ID};
	}

	untie %data;

	return $Item;
}
#==========================================================
sub Save_Item_Bids{
my($Item_ID, $Bids)=@_;
my($Item, %data);

	if (!&Lock($Global{'ItemsBidsFile'})) {&Exit("Cannot Lock database file $Global{'ItemsBidsFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'ItemsBidsFile'}
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{$Item_ID} = $Bids;
	untie %data;
	&Unlock($Global{'ItemsBidsFile'});
}
#==========================================================
sub Get_Items_Bids{
my(@Items_ID)=@_;
my($Item_ID, %Item_Bids, %data);

	undef %Item_Bids;

	&DB_Exist($Global{'ItemsBidsFile'});
	tie %data, "DB_File", $Global{'ItemsBidsFile'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'ItemsBidsFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	foreach $Item_ID(@Items_ID){
			$Item_Bids{$Item_ID}=$data{$Item_ID} if ($data{$Item_ID});
	}

	untie %data;

	return %Item_Bids;
}
#==========================================================
sub Get_User_Open_Items{
my($User_ID) = shift;
my(@User_Items, @Required_Categories, $x);
my($Search_Cat, $Cat_ID, $User_Items_Count);

	$Items_Count = 0;
	undef @Item_Info;
	if (!$User_ID) {return 0;}

	undef @Required_Categories;
	undef @User_Items;
	@Required_Categories= sort @Main_Categories;
	$User_Items_Count=0;

	foreach $Search_Cat (@Required_Categories) {
			$Cat_ID = $Category_ID{$Search_Cat};
			&Read_Root_Category_Items($Cat_ID);
			for $x(0..$Items_Count-1) {
						if ($User_ID eq $Item_Info[$x]{'User_ID'}) {
								$User_Items[$User_Items_Count++] = $Item_Info[$x];
						}
			}
	}

	undef @Item_Info;
	@Item_Info = @User_Items;
	$Items_Count = @User_Items;
}
#==========================================================
sub Get_User_Closed_Items{
my($User_ID)=shift;
my(%data, $key, $value );

	$Items_Count = 0;
	undef @Item_Info;
	if (!$User_ID) {return 0;}

	&DB_Exist($Global{'Closed_Items_File'});
	tie %data, "DB_File", "$Global{'Closed_Items_File'}", O_RDONLY
										or &Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	while ( ($key, $value ) = each(%data)) {
			@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
			if ($User_ID eq $Item_Info[$Items_Count]{'User_ID'}) {
					@{$Item_Info[$Items_Count]}{'Item_ID'}=$key;
					$Items_Count++;
			}
	}

	untie %data;

}
#==========================================================
sub Get_Archived_Item{
my($Required_Item_ID)=shift;
my(%data );

	$Items_Count = 0;
	undef @Item_Info;
	if (!$Required_Item_ID) {return 0;}

	&DB_Exist($Global{'Closed_Items_File'});
	tie %data, "DB_File", "$Global{'Closed_Items_File'}", O_RDONLY
										or &Exit("Cannot open database file$Global{'Closed_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if ($data{$Required_Item_ID}) {
		@{$Item_Info[$Items_Count]}
					{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
					End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $data{$Required_Item_ID});
				@{$Item_Info[$Items_Count]}{'Item_ID'}=$Required_Item_ID;
		$Items_Count++;
	}

	untie %data;
}
#==========================================================
sub Get_New_Items{
my($Time, $Required_Cat_ID) = @_;
my(@Required_Categories);
my($Root_Cat, $Cat_ID);
my($key, $value, %data );

	undef @Required_Categories;
	$Items_Count = 0;
	undef @Item_Info;
	if (!$Time) {return	0;}

	if (!$Required_Cat_ID) {
				@Required_Categories = sort @Main_Categories;

				foreach $Root_Cat (@Required_Categories) {
						$Cat_ID = $Category_ID{$Root_Cat};
						$Cat_File = &Get_Cat_File($Cat_ID);
						
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
								@{$Item_Info[$Items_Count]}
										{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
										End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
								if ($Item_Info[$Items_Count]{'Start_Time'} > $Time) {
										@{$Item_Info[$Items_Count]}{'Item_ID'}=$key;
										$Items_Count++;
								}
						}
						untie %data;
						undef %data;
				}#End foreach
	}
	else{
						$Cat_File = &Get_Cat_DB($Required_Cat_ID);
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
								@{$Item_Info[$Items_Count]}
										{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
										End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
								if ($Item_Info[$Items_Count]{'Start_Time'} > $Time && $Item_Info[$Items_Count]{'Cat_ID'}==$Required_Cat_ID) {
										@{$Item_Info[$Items_Count]}{'Item_ID'}=$key;
										$Items_Count++;
								}
						}
						untie %data;
						undef %data;
	}

}
#==========================================================
sub Get_Ending_Items{
my($Time, $Required_Cat_ID) =@_;
my(@Required_Categories);
my($Root_Cat, $Cat_ID);
my($key, $value, %data );

	undef @Required_Categories;
	$Items_Count = 0;
	undef @Item_Info;
	if (!$Time) {return	0;}

	if (!$Required_Cat_ID) {
				@Required_Categories = sort @Main_Categories;
				foreach $Root_Cat (@Required_Categories) {
						$Cat_ID = $Category_ID{$Root_Cat};
						$Cat_File = &Get_Cat_File($Cat_ID);
						
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
								@{$Item_Info[$Items_Count]}
										{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
										End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
								if ($Item_Info[$Items_Count]{'End_Time'} < $Time) {
									@{$Item_Info[$Items_Count]}{'Item_ID'}=$key;
									$Items_Count++;
								}
						}

						untie %data;
						undef %data;
				}#End foreach
	}
	else{
						$Cat_File = &Get_Cat_DB($Required_Cat_ID);
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
								@{$Item_Info[$Items_Count]}
										{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
										End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
								if ($Item_Info[$Items_Count]{'End_Time'} < $Time && $Item_Info[$Items_Count]{'Cat_ID'}==$Required_Cat_ID) {
									@{$Item_Info[$Items_Count]}{'Item_ID'}=$key;
									$Items_Count++;
								}
						}

						untie %data;
						undef %data;
	}
	
}
#==========================================================
sub Get_High_Bids_Items{
my($Required_Bid, $Required_Cat_ID) = @_;
my(@Required_Categories);
my($Root_Cat, $Cat_ID);
my($key, $value, %data );

	$Items_Count = 0;
	undef @Required_Categories;
	undef @Item_Info;
	if (!$Required_Bid) {return 0;}

	if (!$Required_Cat_ID) {
				@Required_Categories = sort @Main_Categories;

				foreach $Root_Cat (@Required_Categories) {
						$Cat_ID = $Category_ID{$Root_Cat};
						$Cat_File = &Get_Cat_File($Cat_ID);
						
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
							@{$Item_Info[$Items_Count]}
									{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
							if ($Item_Info[$Items_Count]{'Bids'} >= $Required_Bid) {
									@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
									$Items_Count++;
							}
						}

						untie %data;
						undef %data;
				}#End foreach
	}
	else{
						$Cat_File = &Get_Cat_DB($Required_Cat_ID);
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
						while (($key, $value ) = each(%data)) {
							@{$Item_Info[$Items_Count]}
									{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
							if ($Item_Info[$Items_Count]{'Bids'} >= $Required_Bid  && $Item_Info[$Items_Count]{'Cat_ID'}==$Required_Cat_ID) {
									@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
									$Items_Count++;
							}
						}

						untie %data;
						undef %data;
	}

}
#==========================================================
sub Get_Big_Tickets_Items{
my($Required_Price, $Required_Cat_ID) = @_;
my(@Required_Categories);
my($Root_Cat, $Cat_ID);
my($key, $value, %data );

	$Items_Count = 0;
	undef @Required_Categories;
	undef @Item_Info;
	if (!$Required_Price) {return 0;}

	if (!$Required_Cat_ID) {
				@Required_Categories = sort @Main_Categories;

				foreach $Root_Cat (@Required_Categories) {
						$Cat_ID = $Category_ID{$Root_Cat};
						$Cat_File = &Get_Cat_File($Cat_ID);
						
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

						while (($key, $value ) = each(%data)) {
							@{$Item_Info[$Items_Count]}
									{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
							if ($Item_Info[$Items_Count]{'Current_Bid'} >= $Required_Price) {
									@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
									$Items_Count++;
							}
						}

						untie %data;
						undef %data;
				}#End foreach
	}
	else{
						$Cat_File = &Get_Cat_DB($Required_Cat_ID);
						&DB_Exist($Cat_File);
						tie %data, "DB_File", $Cat_File, O_RDONLY
																or &Exit("Cannot open database file $Cat_File : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
						while (($key, $value ) = each(%data)) {
							@{$Item_Info[$Items_Count]}
									{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
									End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $value);
							if ($Item_Info[$Items_Count]{'Current_Bid'} >= $Required_Price && $Item_Info[$Items_Count]{'Cat_ID'}==$Required_Cat_ID) {
									@{$Item_Info[$Items_Count]}{'Item_ID'} = $key;
									$Items_Count++;
							}
						}

						untie %data;
						undef %data;
	}

}
#==========================================================
sub Get_Featured_Items{
my($Required_Cat_ID) = @_;
my($Item_ID, $Cat_ID, @Item_ID, %data, $Counter, %data1);

	$Items_Count = 0;
	undef @Item_Info;

	if (!$Required_Cat_ID) {
				&DB_Exist($Global{'Featured_Home_Items_File'});
				tie %data, "DB_File", "$Global{'Featured_Home_Items_File'}", O_RDONLY
									or &Exit("Cannot open database file $Global{'Featured_Home_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

				@Item_ID = sort(keys %data);
				%data1 = %data;
				 untie %data;
				 undef %data;

				foreach $Item_ID(@Item_ID) {
						@{$Item_Info[$Items_Count]}
								{qw(Cat_ID User_ID Title Description Quantity Current_Bid Bids Duration 
								End_Time Title_Enhancement Uploaded_Files Gift_Icon Start_Time Item_Extra)}=split( '~#~',  $data1{$Item_ID});
						@{$Item_Info[$Items_Count]}{'Item_ID'} = $Item_ID;
						$Items_Count++;
				}

	}
	else{
				&DB_Exist($Global{'Featured_Items_File'});
				tie %data, "DB_File", "$Global{'Featured_Items_File'}", O_RDONLY
									or &Exit("Cannot open database file $Global{'Featured_Items_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

				$Counter = 0;
				while(($Item_ID, $Cat_ID)=(each %data)){
						if ($Cat_ID == $Required_Cat_ID) {
							$Item_ID[$Counter++] = $Item_ID;
						}
				}
				 untie %data;
				 undef %data;

				&Read_From_Category_Items($Required_Cat_ID, @Item_ID);
	}

}
#==========================================================
sub Update_View_Item_Count{
my($Item_ID, $Count) = @_;
my($Item, %data);

	if ((!$Item_ID) || (!$Count)) {return 0;}

	if (!&Lock($Global{'View_Items_Count_File'})) {&Exit("Cannot Lock database file $Global{'View_Items_Count_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'View_Items_Count_File'}
			or &Exit("Cannot open database file $Global{'View_Items_Count_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$data{$Item_ID}) {$data{$Item_ID} = 0;}
	$data{$Item_ID} += $Count;
	untie %data;

	&Unlock($Global{'View_Items_Count_File'});

}
#==========================================================
sub Get_Updated_View_Item_Count{
my($Item_ID) = @_;
my($New_Count, %data);

	if (!$Item_ID) {return 0;}

	if (!&Lock($Global{'View_Items_Count_File'})) {&Exit("Cannot Lock database file $Global{'View_Items_Count_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'View_Items_Count_File'}
			or &Exit("Cannot open database file $Global{'View_Items_Count_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if (!$data{$Item_ID}) {$data{$Item_ID} = 0;}
	$data{$Item_ID} ++;
	$New_Count = $data{$Item_ID};
	untie %data;

	&Unlock($Global{'View_Items_Count_File'});

	return $New_Count;

}
#==========================================================
sub Get_Cat_File{
my($Root_Cat_ID)=shift;
my($Cat_File);

		$Cat_File = $Global{'ItemsDir'}."Category_"."$Root_Cat_ID".".dat";
		return $Cat_File;
}
#==========================================================
#==========================================================
1; 