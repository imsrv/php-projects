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
BEGIN{
	eval "use login";
}
#==========================================================
sub Email_Auction_to_Friend_Login{
my ($Hidden);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});
	&Read_Language_File($Global{'Language_Email_Auction_File'});

	$Hidden=qq!<input type="hidden" name="Item_ID" value="$Param{'Item_ID'}">!;

	&Login("Do_Email_Auction_to_Friend",
					$Language{'login_email_auction_to_friend_title'},
					$Language{'login_email_auction_to_friend_help'},
					$Language{'login_email_auction_to_friend_user_id_label'},
					$Language{'login_email_auction_to_friend_password_label'},
					$Language{'login_email_auction_to_friend_remember_login_label'},
					$Language{'login_email_auction_to_friend_submit_button'},$Hidden
				);
}
#===============================================================#
sub Do_Email_Auction_to_Friend{
$Auth_Check =shift;

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Email_Auction_File'});

	#$Param{'Remember_Login'}
	if ($Auth_Check ne "OK") {
		if 	(&Check_User_Authentication($Param{'User_ID'}, $Param{'Password'}) == 0 ){
			$Plugins{'Body'}=&Msg($Language{'login_error'}, $Language{'login_error_help'}, 1);
			&Display($Global{'General_Template'});
			return 0;
		}
	}

	$Plugins{'Body'}="";
	&Display(&Email_Auction_to_Friend_Form, 1);

}
#==========================================================
sub Email_Auction_to_Friend_Form{
my (%Item, $Out, $List);
my($Curr);

	&Get_Item($Param{'Item_ID'});

	$Out=&Translate_File($Global{'Email_Auction_Template'});

	$List=qq!<FORM NAME="Email_Friend" ACTION="$Script_URL" METHOD="POST">
					<input type="hidden" name="action" value="Send_Email_Auction_to_Friend">
					<input type="hidden" name="User_ID" value="$Param{'User_ID'}">
					<input type="hidden" name="Password" value="$Param{'Password'}">
					<input type="hidden" name="Item_ID" value="$Param{'Item_ID'}">
					<input type="hidden" name="Lang" value="$Global{'Language'}">
					!;
	$Out=~ s/<!--FORM_START-->/$List/;
	#---------------------------------------------------------------------------------------
	$List=qq!<INPUT NAME="Friend_Email" SIZE=20 VALUE="" onFocus="select();">!;
	  #  <!--ITEM_ID-->     <!--ITEM_TITLE-->
	$Out=~ s/<!--FRIEND_EMAIL-->/$List/;

	$List=qq!<textarea rows="7" name="Optional_Message" cols="60"  onFocus="select();">$Language{'optional_message'}</textarea>!;
	$Out=~ s/<!--OPTIONAL_MESSAGE-->/$List/;
	#---------------------------------------------------------------------------------------

	(   $Item{'Country'},
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
		$Item{'Enhancement'},
		$Item{'Reserve'},
		$Item{'BuyPrice'},
		$Item{'BidRating'},
		$Item{'Closing_Time'},
		$Item{'Resubmit'},
		$Item{'Homepage'}) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});
	#-----------------------------------------------------------------		
	$Curr = "$Global{'Currency_Symbol'}";
	$Out=~ s/<!--LANGUAGE-->/$Item{'Item_Language'}/g;
	$List="$Curr$Item{'Start_Bid'}";
	$Out=~ s/<!--START_BID-->/$List/g;
	$List="$Curr$Item{'Increment'}";
	$Out=~ s/<!--BID_INCREMENT-->/$List/g;
	$Out=~ s/<!--LOCATION-->/$Item{'Location'}/;
	$Out=~ s/<!--COUNTRY-->/$Item{'Country'}/;
	$List=$Item{'Enhancement'};
	$Out=~ s/<!--FEATURED-->/$List/;
	$List=qq!<A HREF="$Item{'Homepage'}">$Item{'Homepage'}</A>!;
	$Out=~ s/<!--HOMEPAGE-->/$List/;
	#-----------------------------------------------------------------------------------
	$Out=~ s/<!--ITEM_ID-->/$Item_Info[0]{'Item_ID'}/g;
	$Out=~ s/<!--USER_ID-->/$Item_Info[0]{'User_ID'}/;
	$Out=~ s/<!--ITEM_TITLE-->/$Item_Info[0]{'Title'}/g;
	$List=$Item_Info[0]{'Description'};
	$Out=~ s/<!--DESCRIPTION-->/$List/g;
	$Out=~ s/<!--QUANTITY-->/$Item_Info[0]{'Quantity'}/g;
	$List="$Curr$Item_Info[0]{'Current_Bid'}";
	$Out=~ s/<!--CURRENT_BID-->/$List/g;
	$Out=~ s/<!--BIDS-->/$Item_Info[0]{'Bids'}/g;
	$List=&Time_Diff(&Time(time), $Item_Info[0]{'End_Time'});
	$Out=~ s/<!--TIME_LEFT-->/$List/g;
	my $ET=qq!End_Time=$Item_Info[0]{'End_Time'}!;
	$List=&Format_Time($Item_Info[0]{'Start_Time'});
	$Out=~ s/<!--START_TIME-->/$List/;
	$List=&Format_Time($Item_Info[0]{'End_Time'});
	$Out=~ s/<!--END_TIME-->/$List/g;
	$List="$Curr$Item_Info[0]{'Current_Bid'}";
	$Out=~ s/<!--MINIMUM_BID-->/$List/g;
	#------------------------------------------------------------------------------------
	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_email_auction_button'}/;
	$Out=~ s/<!--RESET_BUTTON-->/$Language{'reset_email_auction_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_email_auction_button'}/;

	$List=qq!</FORM>!;
	$Out=~ s/<!--FORM_END-->/$List/;
	
	return $Out;
}
#==========================================================
sub Send_Email_Auction_to_Friend{
my (%Item, $Curr, $Out, $Fullname);
my($Subject, $From, $Temp);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Email_Auction_File'});

	if (!&Check_Email_Address($Param{'Friend_Email'})) {
				$Plugins{'Body'}=&Msg($Language{'invalid_email'}, $Language{'invalid_email_help'}, 1);
				&Display($Global{'General_Template'});
				exit 0;
	}

	&Get_Item($Param{'Item_ID'});

	(   $Item{'Country'},
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
		$Item{'Enhancement'},
		$Item{'Reserve'},
		$Item{'BuyPrice'},
		$Item{'BidRating'},
		$Item{'Closing_Time'},
		$Item{'Resubmit'},
		$Item{'Homepage'}) = split(/\~\|\~/, $Item_Info[0]{'Item_Extra'});
		
	$Curr = "$Global{'Currency_Symbol'}";

	$Out = $Language{'friend_email_body'};
	$Out =~ s/<!--Item_ID-->/$Item_Info[0]{'Item_ID'}/g;
	$Out =~ s/<!--Title-->/$Item_Info[0]{'Title'}/g;
	$Out =~ s/<!--Quantity-->/$Item_Info[0]{'Quantity'}/g;

	$Temp = &Get_Date_Formated($Global{'Time_Format'}, $Item_Info[0]{'Start_Time'});
	$Out =~ s/<!--Start_Time-->/$Temp/g;

	$Temp = &Get_Date_Formated($Global{'Time_Format'}, $Item_Info[0]{'End_Time'});
	$Out =~ s/<!--End_Time-->/$Temp/g;

	$Temp = "$Curr$Item{'Start_Bid'}";
	$Out =~ s/<!--Start Bid-->/$Temp/g;

	$Temp = "$Curr$Item{'Increment'}";	
	$Out =~ s/<!--Bid_Increment-->/$Temp/g;

	$Out =~ s/<!--Location-->/$Item{'Location'}/g;
	$Out =~ s/<!--Country-->/$Item{'Country'}/g;
	$Out =~ s/<!--Language-->/$Item{'Item_Language'}/g;
	$Out =~ s/<!--Home Page-->/$Item{'Homepage'}/g;

	$Temp = &Web_Decode($Item_Info[0]{'Description'});
	$Out =~ s/<!--Description-->/$Temp/g;
	
	$Temp = qq!$Script_URL?action=View_Item&Item_ID=$Item_Info[0]{'Item_ID'}&Cat_ID=$Item_Info[0]{'Cat_ID'}&Lang=$Global{'Language'}!;
	$Out =~ s/<!--Link-->/$Temp/g;

	$Subject = $Language{'email_auction_to_friend_subject'};
	$Subject =~ s/<!--Item_ID-->/$Item_Info[0]{'Item_ID'}/g;
	$Subject =~ s/<!--Title-->/$Item_Info[0]{'Title'}/g;
	
	if (!$Param{'Optional_Message'}) {$Param{'Optional_Message'}="";}
	#&Email($From, $TO, $Subject,   $Message);
	($From, $Fullname) = &Get_User_Email_and_Name($Param{'User_ID'});
	&Email($From, $Param{'Friend_Email'}, $Subject,   $Param{'Optional_Message'} . $Out);
	
	$Plugins{'Body'}=&Msg($Language{'email_sent'}, $Language{'email_sent_help'}, 3);
	&Display($Global{'General_Template'});
}
#==========================================================
#==========================================================
1;