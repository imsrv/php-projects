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
sub Feedback_Forum{
my($Auth, $msg, $Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Feedback_File'});

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

	$Plugins{'Body'}="";
	&Display(&Feedback_Forum_Form, 1);
}
#==========================================================
sub Leave_Feedback{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Feedback_File'});

	if (&Check_Archived_Item($Param{'Item_ID'}) == 0){
		$Out=&Msg($Language{'incorrect_item'}, $Language{'item_not_found'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}
	
	&Get_Archived_Item($Param{'Item_ID'});

	if ($Param{'User_ID'}  eq $Param{'User_ID_to_Rate'}) {
		$Plugins{'Body'}=&Msg($Language{'invalid_user'}, $Language{'cannot_rate_your_self'}, 1);
		&Display($Global{'General_Template'});
		exit;
	}

	if (&Check_Previous_Rate($Param{'Item_ID'}, $Param{'User_ID'}, $Param{'User_ID_to_Rate'}) == 0){
		$Out=&Msg($Language{'invalid_rate'}, $Language{'invalid_rate_again'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}
	
	if ($Param{'User_ID'} eq $Item_Info[0]{'User_ID'}){

		$Winner_ID=$Param{'User_ID_to_Rate'};
	}
	elsif($Param{'User_ID_to_Rate'} eq $Item_Info[0]{'User_ID'}){

		$Winner_ID=$Param{'User_ID'};

	}
	else{

		$Out=&Msg($Language{'invalid_users'}, $Language{'invalid_users_for_feedback'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;

	}

	if (&Validate_Item_Winner($Param{'Item_ID'}, $Winner_ID) == 0){
		$Out=&Msg($Language{'invalid_users'}, $Language{'invalid_users_for_feedback'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}
	
	if (!$Param{'Comments'}) {$Param{'Comments'} = "";}

	&Add_User_Rate($Param{'Item_ID'}, $Param{'User_ID'}, $Param{'User_ID_to_Rate'}, $Param{'Rating'}, $Param{'Comments'});

	&View_Feedback($Param{'User_ID_to_Rate'});
}
#==========================================================
sub Validate_Item_Winner{
my($Item_ID, $User_ID)=@_;

	$Item=&Get_Item_Bids($Item_ID);

	($Item_ID, $Item_Qty, $Current_Bid, $Bid_Increment, $Reserve, $Buy, $Counter, $Bids)=split(/\|/, $Item);

	undef @All_Bids;
	@All_Bids = split(/=/, $Bids);

	$Bid_Count = 0;
	foreach $Bidder(@All_Bids){
		@{$Bidders[$Bid_Count]}
		            {qw(Status User_ID Email Bid_Qty Win_Qty Bid_Time Bid Proxy Max_Bid)}=split(/\:/, $Bidder);
		if ($Bidders[$Bid_Count]{'Status'} != 0) { $Bid_Count++; }
	}

	$OK=0;
	for $x(0..$Bid_Count - 1){
			if ($User_ID eq $Bidders[$x]{'User_ID'}){
				$OK=1;
				last;
			}
	}

	return $OK;

}
#==========================================================
sub 	Add_User_Rate{
my($Item_ID, $User_ID1, $User_ID2, $Rating, $Comments)=@_;
my(%data, %track, %Comments);
my($Total, $Positive, $Neutral, $Negative);

	if (!&Lock($Global{'User_Feedback_File'})) {&Exit("Cannot Lock database file $Global{'User_Feedback_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", "$Global{'User_Feedback_File'}"
										or &Exit("Cannot open database file$Global{'User_Feedback_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	($Total, $Positive, $Neutral, $Negative)=split(":", $data{$User_ID2});

	if ($Rating==1) {
					$Positive++;
	}
	elsif ($Rating==0){
					$Neutral++
	}
	elsif($Rating==-1){
					$Negative++;
	}

	$Total = $Positive - $Negative;
	
	$data{$User_ID2}=join(":", ($Total, $Positive, $Neutral, $Negative));

	untie %data;
	undef %data;
	&Unlock($Global{'User_Feedback_File'});
	#------------------------------------------------------
	if (!&Lock($Global{'Feedback_Track_File'})) {&Exit("Cannot Lock database file $Global{'Feedback_Track_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %track, "DB_File", "$Global{'Feedback_Track_File'}"
										or &Exit("Cannot open database file $Global{'Feedback_Track_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	if ($track{$Item_ID}) {
				$Users= $track{$Item_ID};
				$Users.="|$User_ID1:$User_ID2";
				delete $track{$Item_ID};
	}
	else{
				$Users="$User_ID1:$User_ID2";

	}
	
	$track{$Item_ID}=$Users;
	untie %track;
	undef %track;
	&Unlock($Global{'Feedback_Track_File'});
	#------------------------------------------------------
	if (!&Lock($Global{'Feedback_Comments_File'})) {&Exit("Cannot Lock database file $Global{'Feedback_Comments_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %Comments, "DB_File", "$Global{'Feedback_Comments_File'}"
										or &Exit("Cannot open database file $Global{'Feedback_Comments_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!$Comments{$User_ID2}) {$Comments{$User_ID2} ="";}

	$Time=&Time(time);
	$Comments{$User_ID2} .= qq!$Item_ID\:\:$User_ID1\:\:$Rating\:\:$Time\:\:$Comments||!;
	untie %Comments;
	&Unlock($Global{'Feedback_Comments_File'});
}
#==========================================================
sub Check_Previous_Rate{
my($Item_ID, $User_ID1, $User_ID2)=@_;
my(%data, $OK);

	&DB_Exist("$Global{'Feedback_Track_File'}");
	tie %data, "DB_File", "$Global{'Feedback_Track_File'}", O_RDONLY or
						&Exit("Cannot open database file $Global{'Feedback_Track_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	if ($data{$Item_ID}) {
				$Users= $data{$Item_ID};
				@Users=split(/\|/, $Users);
				
				$OK=1;
				foreach $Rate (@Users) {
					($User1, $User2)=split(/\:/, $Rate);
					if ($User1 eq $User_ID1 && $User2 eq $User_ID2) {
						$OK=0;
						last;
					}
				}
	}
	else{
				$OK = 1;
	}

	untie %data;
	return $OK;
}
#==========================================================
sub 	Get_User_Rating{
my($User_ID)=shift;
my(%data, $Total, $Positive, $Neutral, $Negative);
my($Comments, %Comments);

	&DB_Exist("$Global{'User_Feedback_File'}");
	tie %data, "DB_File", "$Global{'User_Feedback_File'}", O_RDONLY or
						&Exit("Cannot open database file$Global{'User_Feedback_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	if ($data{$User_ID}) {
			($Total, $Positive, $Neutral, $Negative)=split(":", $data{$User_ID});
	}
	else{
			$Total=0;$Positive=0; $Neutral=0; $Negative=0;
	}
	untie %data;
	undef %data;

	&DB_Exist("$Global{'Feedback_Comments_File'}");
	tie %Comments, "DB_File", "$Global{'Feedback_Comments_File'}", O_RDONLY or
						&Exit("Cannot open database file $Global{'Feedback_Comments_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	if (!$Comments{$User_ID}) {$Comments{$User_ID} = "";}
	$Comments = $Comments{$User_ID};
	untie %Comments;

	return ($Total, $Positive, $Neutral, $Negative, $Comments);
}
#==========================================================
sub View_Feedback{
my($User_ID)=shift;
my($Total, $Positive, $Neutral, $Negative, $Comments);
my($Out, $Total_Comments, @Comments);
my($Pages, $Current_Page, $Next_Page, $List, $Link);
my($Previous_Page, $Last_Page,  $Line, @All, $x, $y);


	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Feedback_File'});

	$Out=&Translate_File($Global{'View_User_Feedback_Template'});

	if (!&Check_User_Exist($User_ID)) {
			$Plugins{'Body'}=&Msg($Language{'user_id_error'}, $Language{'user_id_error_help'}, 1);
			&Display($Global{'General_Template'});
			exit 0;
	}

	if (!$Param{'Page'}) {$Param{'Page'} = 1;}

	$Out=~ s/<!--USER_ID-->/$User_ID/g;
	#($Total, $Positive, $Neutral, $Negative, $Comments)
	($Total, $Positive, $Neutral, $Negative, $Comments) = &Get_User_Rating($User_ID);

	if (!$Positive) {$Positive=0;}
	if (!$Neutral) {$Neutral=0;}
	if (!$Negative) {$Negative=0;}

	$Out=~ s/<!--POSITIVE-->/$Positive/g;
	$Out=~ s/<!--NEUTRAL-->/$Neutral/g;
	$Out=~ s/<!--NEGATIVE-->/$Negative/g;
	$Out=~ s/<!--TOTAL-->/$Total/g;

	@All = split(/\|\|/, $Comments);

	$x = 0;
	foreach $Line (@All) { #qItem_ID::$User_ID1::$Rating::$Time::$Comments||
			@{$Comments[$x++]}{qw(Item_ID User_ID Rating Time Comments)}=split(/\:\:/, $Line);
	}
    
	@Comments = sort { $b->{'Time'} <=> $a->{'Time'} } @Comments;
	$Total_Comments = @Comments;

	$Last_Page=int($Total_Comments / $Global{'Comments_Per_Page'});
	if (($Total_Comments % $Global{'Comments_Per_Page'})) { $Last_Page++; }

	$Current_Page=$Param{'Page'};
	$Next_Page=($Current_Page + 1);
	$Previous_Page = ($Current_Page - 1);
	if ($Next_Page > $Last_Page) {$Next_Page = $Last_Page;}

	$Pages = "";
	for $x(0..$Last_Page-1){
			$List = $Language{'feedback_page_link'};
			$y = $x +1;
			if ($y == $Current_Page) {
					$List =~ s/<!--PAGE_LINK-->//;
					$List =~ s/<!--PAGE_NUMBER-->//;
					$Pages .= $y;
			}
			else{
					$Link=qq!$Script_URL?action=View_Feedback&Page=$y&Lang=$Global{'Language'}&Feedback_User_ID=$User_ID!;
					$List =~ s/<!--PAGE_LINK-->/$Link/;
					$List =~ s/<!--PAGE_NUMBER-->/$y/;
					$Pages .= $List;
			}
	}

	$Out=~ s/<!--EXTRA_PAGES_LINK-->/$Pages/g;

	$List =$Language{'next_page'};
	$Link=qq!$Script_URL?action=View_Feedback&Page=$Next_Page&Lang=$Global{'Language'}&Feedback_User_ID=$User_ID!;
	$List=~ s/<!--NEXT_PAGE_LINK-->/$Link/g;
	if ($Current_Page == $Last_Page || $Last_Page==0) {$List = "";}
	$Out=~ s/<!--NEXT_PAGE-->/$List/g;

	$List =$Language{'previous_page'};
	$Link=qq!$Script_URL?action=View_Feedback&Page=$Previous_Page&Lang=$Global{'Language'}&Feedback_User_ID=$User_ID!;
	$List=~ s/<!--PREVIOUS_PAGE_LINK-->/$Link/g;
	if ($Current_Page == 1) {$List = "";}
	$Out=~ s/<!--PREVIOUS_PAGE-->/$List/g;
	
	$Start_Item = ($Current_Page -1) * $Global{'Comments_Per_Page'};
	$End_Item = $Start_Item + $Global{'Comments_Per_Page'};
	if ($End_Item > $Total_Comments) {$End_Item = $Total_Comments;}

	$List = $Language{'showing_feedback_range'};
	$x = $Start_Item +1;
	if ($Total_Comments <=0){$x = 0;}
	$List =~ s/<!--FROM_ITEM-->/$x/;
	$List =~ s/<!--TO_ITEM-->/$End_Item/;
	$List =~ s/<!--TOTAL_ITEMS-->/$Total_Comments/;
	$Out =~ s/<!--FEEDBACK_RANGE-->/$List/g;
	
	$Comments ="";
	for $x($Start_Item..$End_Item-1){
			$Form =&Translate($Global{'Feedback_Rating_Form'});
			
			$List=qq!<A HREF="$Script_URL?action=View_Feedback&Feedback_User_ID=$Comments[$x]{'User_ID'}&Lang=$Global{'Language'}">$Comments[$x]{'User_ID'}</A>!;
			$Form =~ s/<!--COMMENT_USER-->/$List/g;

			$Form=~ m/(<!--)(CLASS::Comment_Time)(:)(\d{1,3})(-->)/;
			$Class = $1 . $2 . $3 . $4 . $5;
			$List = &Get_Date_Formated($4, $Comments[$x]{'Time'});
			$Form =~ s/$Class/$List/g;

			$List = qq!<A HREF="$Script_URL?action=View_Archived_Item&Item_ID=$Comments[$x]{'Item_ID'}&Lang=$Global{'Language'}">$Comments[$x]{'Item_ID'}</A>!;
			$Form =~ s/<!--ITEM_ID-->/$List/g;

			if ($Comments[$x]{'Rating'} == 1) {
					$Form =~ s/<!--COMMENT_TYPE-->/$Language{'praise_label'}/g;
			}
			elsif ($Comments[$x]{'Rating'} == 0) {
					$Form =~ s/<!--COMMENT_TYPE-->/$Language{'neutral_label'}/g;
			}
			elsif ($Comments[$x]{'Rating'} == -1) {
					$Form =~ s/<!--COMMENT_TYPE-->/$Language{'complaint_label'}/g;
			}

			$Form =~ s/<!--USER_COMMENT-->/$Comments[$x]{'Comments'}/g;

			$Comments .= $Form;
	}

	if ($Total_Comments <= 0) {$Comments = $Language{'no_feedback_comments'};}
	$Out =~ s/<!--FEEDBACK_COMMENTS-->/$Comments/g;

	$Plugins{'Body'}="";
	&Display($Out, 1);

}
#==========================================================
sub Feedback_Forum_Form{
my ($Out, $List);

	$Out=&Translate_File($Global{'Feedback_Forum_Template'});

	$List=qq!<form NAME="See_Feedback" method="POST" action="$Script_URL">
				     <input type="hidden" name="Lang" value="$Global{'Language'}">
					 <input type="hidden" name="action" value="View_Feedback">!;

	$Out=~ s/<!--FORM_START-->/$List/;

	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'see_feedback_submit_button'}/;
	$Out=~ s/<!--CLEAR_FORM_BUTTON-->/$Language{'see_feedback_reset_button'}/g;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'see_feedback_cancel_button'}/g;

	$List=qq!<input type="text" name="Feedback_User_ID" size="30" value="" onFocus="select();">!;
	$Out=~ s/<!--VIEW_USER_FEEDBACK-->/$List/;
	#------------------------------------------------------
	$List=qq!<form NAME="Leave_Feedback" method="POST" action="$Script_URL"> 
					<input type="hidden" name="Lang" value="$Global{'Language'}">
					 <input type="hidden" name="action" value="Leave_Feedback">
					 <input type="hidden" name="User_ID" value="$Param{'User_ID'}">
					 <input type="hidden" name="Password" value="$Param{'Password'}">!;

	$Out=~ s/<!--FORM_STARTX-->/$List/;

	$List=qq!<input type="text" name="User_ID_to_Rate" size="30" value="" onFocus="select();">!;
	$Out=~ s/<!--USER_ID_TO_RATE-->/$List/;

	$List=qq!<input type="text" name="Item_ID" size="30" value="" onFocus="select();">!;
	$Out=~ s/<!--ITEM_ID-->/$List/;
	#-----------------------------------------------------------------------------------
	$List=qq!<INPUT name="Rating" type=radio value=1>!;
	$Out=~ s/<!--POSITIVE-->/$List/;

	$List=qq!<INPUT checked name="Rating" type=radio value=0>!;
	$Out=~ s/<!--NEUTRAL-->/$List/;

	$List=qq!<INPUT name="Rating" type=radio value=-1>!;
	$Out=~ s/<!--NEGATIVE-->/$List/;
	#-----------------------------------------------------------------------------------
	$Out=~ s/<!--LEAVE_FEEDBACK_SUBMIT_BUTTON-->/$Language{'leave_feedback_submit_button'}/;
	$Out=~ s/<!--LEAVE_FEEDBACK_CLEAR_FORM_BUTTON-->/$Language{'leave_feedback_clear_button'}/g;
	$Out=~ s/<!--LEAVE_FEEDBACK_CANCEL_BUTTON-->/$Language{'leave_feedback_cancel_button'}/g;

	
	$List=qq!<input type="text" name="Comments" size="60" value="" onFocus="select();">!;
	$Out=~ s/<!--COMMENTS_BOX-->/$List/;
	
	$List=$Language{'comments_label'};
	$List=~ s/<!--MAX_COMMENTS_LENGTH-->/$Global{'Max_Comments_Length'}/;
	$Out=~ s/<!--COMMENTS_LABEL-->/$List/;
	#-----------------------------------------------------------------------------------
	$Out=~ s/<!--FORM_END-->/<\/FORM>/g;

	return $Out;

}
#==========================================================
1;