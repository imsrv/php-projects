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
# For Microsoft IIS Servers , you may need to uncomment the following line.
# print "HTTP/1.0 200 OK\n";
#==========================================================
#print "Content-type: text/html\n\n";
package Auction;
#==========================================================
# For Windows Servers , you may need set the following variable to you
# cgi-bin auction directoy example: d:/225.225.225.1/cgi-bin/auction.
BEGIN {
$Program_CGI_Directory="";
}
#==========================================================
# Unbuffer Output
$| = 1;
#use CGI::Carp qw(fatalsToBrowser); 
#==========================================================
BEGIN {
	if ( $Program_CGI_Directory)  {push @INC, $Program_CGI_Directory;}
	require "path.setup";
	use Cwd;
	$CWD = cwd;
	push @INC, $CWD;
	push @INC, "."; 
	push @INC, $Program_CGI_Directory; 
}
#==========================================================
BEGIN { 
	use vars qw (%Param  %Category_ID %Category_Count %Category_TFlag %Category_SortNo
	%Category_Description %All_SubCategories @Sub_Categories %Category_Name %Plugins
	@Main_Categories $All_SubCategories_Count $Sub_Categories_Count $Categories_Count
	@Item_Info   $Items_Count  $PageNumber $Domain $Doc_Root $Script_Name $Script_URL
	$Category_ON_Count @Category_ON %Category_Subs_URL  %Global
	%Category_Accept $SubCategory_Tree_Count @Bad_Words %Set_Cookies $Build_Pages
	@SubCategory_Tree_URL @Category_URL %Language %User_Info %Cookies $Delimiter
	@Title_Suffix @Title_Prefx
	@Regular_Fees_From @Regular_Fees_To @Regular_Fees_Fee
	@Reserve_Fees_From @Reserve_Fees_To @Reserve_Fees_Fee
	@Final_Fees_From @Final_Fees_To @Final_Fees_Fee
   );

}

&Initialize_Parameters;
&Load_Support;
#==========================================================
#======================Start of Main=========================#
&Initialization;
#==========================================================
# while (($key, $value)=each(%Param)) {	print ("$key =  $value<br>");}
#==========================================================
if ($Param{'action'} eq 'My_Auctions') {
	eval "use speciallist";
	eval "use displaylist";
	eval "use login";
	&My_Auctions;
 }
elsif ($Param{'action'} eq 'My_Auctions_Login' || $Param{'action'} eq 'Account_Current_Auctions') {
	eval "use login";
	eval "use speciallist";
	eval "use displaylist";
	&My_Auctions_Login;
 }
elsif ($Param{'action'} eq 'My_Closed_Auctions_Login') {
	eval "use login";
	eval "use speciallist";
	eval "use displaylist";
	&My_Closed_Auctions_Login;
 }
elsif ($Param{'action'} eq 'My_Closed_Auctions') {
	eval "use login";
	eval "use speciallist";
	eval "use displaylist";
	&My_Closed_Auctions;
 }

elsif ($Param{'action'} eq 'Seller_Auctions') {
	eval "use login";
	eval "use speciallist";
	eval "use displaylist";
	&Seller_Auctions;
 }
elsif ($Param{'action'} eq 'Seller_Closed_Auctions') {
	eval "use login";
	eval "use speciallist";
	eval "use displaylist";
	&Seller_Closed_Auctions;
 }
#----------------------------------------------------------
elsif ($Param{'action'} eq 'Account_Manager_Login'  || $Param{'action'} eq 'Account_Overview') {
	eval "use login";
	eval "use accountmgr";
	&Account_Manager_Login;
 }
elsif ($Param{'action'} eq 'Account_Manager') {
	eval "use login";
	eval "use accountmgr";
	&Account_Manager;
 }
elsif ($Param{'action'} eq 'Account_Activity') {
	eval "use login";
	eval "use accountmgr";
	&Account_Activity;
 }
elsif ($Param{'action'} eq 'Account_Feedback') {
	eval "use login";
	eval "use feedback";
	eval "use accountmgr";
	&Account_View_Feedback();
 }

#----------------------------------------------------------
elsif ($Param{'action'} eq 'New_Auctions') {
	eval "use speciallist";
	eval "use displaylist";
	&New_Auctions;
 }
elsif ($Param{'action'} eq 'Ending_Now') {
	eval "use speciallist";
	eval "use displaylist";
	&Ending_Now;
 }
elsif ($Param{'action'} eq 'Hot_Auctions') {
	eval "use speciallist";
	eval "use displaylist";
	&Hot_Auctions;
 }
elsif ($Param{'action'} eq 'Cool_Auctions') {
	eval "use speciallist";
	eval "use displaylist";
	&Cool_Auctions;
 }
elsif ($Param{'action'} eq 'Big_Ticket') {
	eval "use speciallist";
	eval "use displaylist";
	&Big_Ticket;
 }
elsif ($Param{'action'} eq 'Featured') {
	eval "use speciallist";
	eval "use displaylist";
	eval "use login";
	&Featured;
 }
elsif ($Param{'action'} eq 'xitems') {
	eval "use xitems";
	&xitems;
 }
elsif ($Param{'action'} eq 'Feedback_Login') {
	eval "use login";
	eval "use feedback";
	&Feedback_Login;
 }
elsif ($Param{'action'} eq 'Feedback_Forum') {
	eval "use login";
	eval "use feedback";
	&Feedback_Forum;
 }
elsif ($Param{'action'} eq 'Leave_Feedback') {
	eval "use login";
	eval "use feedback";
	&Leave_Feedback;
 }
elsif ($Param{'action'} eq 'View_Feedback') {
	eval "use login";
	eval "use feedback";
	&View_Feedback($Param{'Feedback_User_ID'});
 }
elsif ($Param{'action'} eq 'Ask_Seller_Login') {
	eval "use login";
	&Ask_Seller_Login;
 }
elsif ($Param{'action'} eq 'Ask_Seller') {
	eval "use login";
	&Ask_Seller;
 }
elsif ($Param{'action'} eq 'Help') {
	&Help_Index;
 }
elsif ($Param{'action'} eq 'Get_Help') {
	&Get_Help;
 }
elsif ($Param{'action'} eq 'About_Us') {
	&About_Us;
 }
#-------------User Registration---------------------------------
elsif ($Param{'action'} eq 'Sign_in') {
	eval "use registration";
	&New_Registration;
 }
 elsif ($Param{'action'} eq 'Registration') {
	eval "use registration";
	eval "use maillib";
	eval "use users";
	eval "use ccverify";
	eval "use accountmgr";
	&Registration;
}
 elsif ($Param{'action'} eq "Edit_Profile_login") {
	eval "use login";
	eval "use editprofile";
	eval "use maillib";
	eval "use ccverify";
	&Login_Edit_Profile;
}
 elsif ($Param{'action'} eq "Edit_Profile") {
	eval "use login";
	eval "use editprofile";
	eval "use maillib";
	eval "use ccverify";
	&Edit_Profile;
}
 elsif ($Param{'action'} eq "Save_Edit_Profile") {
	eval "use maillib";
	eval "use login";	
	eval "use editprofile";
	eval "use ccverify";
	&Save_Edit_Profile;
}
 elsif ($Param{'action'} eq "Sign_off") {
	eval "use login";	
	eval "use maillib";
}
 #----------------New Item Submission------------------------
elsif ($Param{'action'} eq "Submit_Item_Login") {
	eval "use login";
	eval "use submititem";
	&Login_Submit_Item;
 }
elsif ($Param{'action'} eq "Submit_Item") {
	eval "use login";
	eval "use submititem";
	&Submit_Item;
 }
elsif ($Param{'action'} eq "Preview_Item") {
	eval "use login";
	eval "use preview";
	eval "use feedback";
	&Preview_Item;
}
elsif ($Param{'action'} eq "Submit_Upload_Files") {
	eval "use login";
	eval "use uploadfile";
	&Submit_Upload_Files_Form;
}
elsif ($Param{'action'} eq "Upload_File") {
	eval "use login";
	eval "use uploadfile";
	&Upload_File;
}
elsif ($Param{'action'} eq "Add_Item") {
	eval "use maillib";
	eval "use users";
	eval "use accountmgr";
	&Add_Item;
}
#----------End New Item Submission-----------------------
 elsif ($Param{'action'} eq "View_Page"){
	eval "use displaylist";
	&Display_Listing_Page($Param{'Cat_ID'});
}
 elsif ($Param{'action'} eq "View_Item"){
	eval "use viewitem";
	eval "use users";
	eval "use feedback";
	&View_Item($Param{'Item_ID'}, "Open");
}
 elsif ($Param{'action'} eq "View_Archived_Item"){
	eval "use viewitem";
	eval "use users";
	eval "use feedback";
	&View_Item($Param{'Item_ID'}, "Archived");
}
elsif ($Param{'action'} eq "Countdown_Ticker"){
	eval "use countdown";
	&Countdown_Ticker;
}
elsif ($Param{'action'} eq "Browse_Categories"){
	&Browse_Categories;
}
elsif ($Param{'action'} eq "Display_Categories"){
	&Display_Categories;
}
elsif ($Param{'action'} eq "Display_Categories_Tree"){
	&Display_Categories_Tree;
}
 elsif ($Param{'action'} eq "View_Cat"){
	 eval "use displaylist";
	&Display_SubCategory;
}
elsif ($Param{'action'} eq "Search"){
	eval "use search";
	eval "use displaylist";
	&Search;
}
#---------------------------------------------------------------------
elsif ($Param{'action'} eq "Set_Language"){
	&Set_Language;
}
elsif ($Param{'action'} eq "Set_Current_Language"){
	eval "use displaylist";
	&Set_Current_Language;
}
#---------------------------------------------------------------------
elsif ($Param{'action'} eq "Custom"){
	eval "use displaylist";
	&Custom_Body;
}
#---------------------------------------------------------------------
elsif ($Param{'action'} eq "Contact_Us"){
	eval "use contact";
	&Contact_Us;
}
elsif ($Param{'action'} eq "Send_Contact_Us"){
	eval "use maillib";
	eval "use contact";
	&Send_Contact_Us;
}
#---------------------------------------------------------------------
elsif ($Param{'action'} eq "Forgot_Username"){
	eval "use login";
	&Forgot_Username;
}
elsif ($Param{'action'} eq "Send_Forgot_Username"){
	eval "use login";
	eval "use maillib";
	&Send_Forgot_Username;
}
elsif ($Param{'action'} eq "Forgot_Password"){
	eval "use login";
	&Forgot_Password;
}
elsif ($Param{'action'} eq "Send_Forgot_Password"){
	eval "use login";
	eval "use maillib";
	&Send_Forgot_Password;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Alert_Me"){
	eval "use alertme";
	&Alert_Me;
}
elsif ($Param{'action'} eq "Edit_View_Alert_Me"){
	eval "use alertme";
	&Edit_View_Alert_Me;
}
elsif ($Param{'action'} eq "Create_Category_Alert_Me"){
	eval "use alertme";
	&Create_Category_Alert_Me;
}
elsif ($Param{'action'} eq "Do_Create_Category_Alert_Me"){
	eval "use alertme";
	&Do_Create_Category_Alert_Me;
}
elsif ($Param{'action'} eq "Save_Alert_Me"){
	eval "use alertme";
	&Save_Alert_Me;
}
elsif ($Param{'action'} eq "Create_Seller_Alert_Me"){
	eval "use alertme";
	&Create_Seller_Alert_Me;
}
elsif ($Param{'action'} eq "Do_Create_Seller_Alert_Me"){
	eval "use alertme";
	&Do_Create_Seller_Alert_Me;
}
elsif ($Param{'action'} eq "Create_Keyword_Alert_Me"){
	eval "use alertme";
	&Create_Keyword_Alert_Me;
}
elsif ($Param{'action'} eq "Do_Create_Keyword_Alert_Me"){
	eval "use alertme";
	&Do_Create_Keyword_Alert_Me;
}
elsif ($Param{'action'} eq "Change_Alert_Me_Status"){
	eval "use alertme";
	&Change_Alert_Me_Status;
}
elsif ($Param{'action'} eq "Edit_Alert_Me"){
	eval "use alertme";
	&Edit_Alert_Me;
}
elsif ($Param{'action'} eq "Do_Edit_View_Alert_Me"){
	eval "use alertme";
	&Do_Edit_View_Alert_Me;
}
elsif ($Param{'action'} eq "Delete_Alert_Me"){
	eval "use alertme";
	&Delete_Alert_Me;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Email_Auction_to_Friend"){
	eval "use emailfriend";
	&Email_Auction_to_Friend_Login;
}
elsif ($Param{'action'} eq "Do_Email_Auction_to_Friend"){
	eval "use emailfriend";	 
	&Do_Email_Auction_to_Friend;
}
elsif ($Param{'action'} eq "Send_Email_Auction_to_Friend"){
	eval "use maillib";
	eval "use emailfriend";
	&Send_Email_Auction_to_Friend;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Announcements"){
	eval "use announcements";
	&Announcements;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Preview_Bid"){
	eval "use previewbid";
	&Preview_Bid;
}
elsif ($Param{'action'} eq "Process_Bid"){
	eval "use login";
	eval "use bidding";
	eval "use maillib";
	&Process_Bid;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Search_Help"){
	&Search_Help;
}
elsif ($Param{'action'} eq "Sort_Page"){
	eval "use displaylist";
	eval "use search";
	&Sort_Page;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "User_Agreement"){
	&User_Agreement;
}
elsif ($Param{'action'} eq "Privacy_Policy"){
	eval "use displaylist";
	&Privacy_Policy;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Bid_History"){
	eval "use users";
	eval "use displaylist";
	eval "use previewbid";
	&Bid_History;
}
elsif ($Param{'action'} eq "High_Bidder"){
	eval "use users";
	eval "use displaylist";
	eval "use previewbid";
	&High_Bidder;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Log_off"){
	&Log_off;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "BidFind"){
	eval "use bidfind";
	&Get_BidFind_Pages;
}
#----------------------------------------------------------
 else {
	eval "use displaylist";
	&Display_Front_Page;
}
#----------------------------------------------------------
exit 0;
#=======================End of Main=========================#
#==========================================================
#==========================================================
sub Access_Lock_Status{

	if ($Global{'Access_Lock_Status'} == 0) {
		return 0;
	}
	else{
		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Access_Lock_File'});
		print "Content-Type: text/html\n\n";
		print  $Language{'access_lock_header'};
		print  $Language{'access_lock_title'};
		print  $Language{'access_lock_description'};
		print  $Language{'access_lock_time'};
		print &Long_Date_Time;
		print  $Language{'access_lock_signature'};
		exit 0;
	}
	
}
#==========================================================
sub Initialize_Parameters{
	undef %Param;
	undef %Global;
	undef %Set_Cookies;
	undef %Category_ID;
	undef %Category_Count;
	undef %Category_TFlag;
	undef %Category_SortNo;
	undef %Category_Description;
	undef %All_SubCategories;
	undef %Category_Subs_URL;
	undef %Category_Accept;
	undef %Language;
	undef %User_Info;
	undef %Cookies;
	undef %Plugins;
	undef %Category_Name;
	undef @Sub_Categories;
	undef @Main_Categories;
	undef $All_SubCategories_Count;
	undef $Categories_Count;
	undef @Item_Info;
	undef $Items_Count;
	undef $PageNumber;
	undef $Domain;
	undef $Doc_Root;
	undef $Script_Name;
	undef $Script_URL;
	undef $Category_ON_Count;
	undef @Category_ON;
	undef $SubCategory_Tree_Count;
	undef @SubCategory_Tree_URL;
	undef @Category_URL;
	undef @Title_Suffix;
	undef @Title_Prefx;
	undef $Delimiter;

	$Param{'action'}='';
}
#==========================================================
sub Exit{
my($Msg, $Title, $Level)=@_;
my ($Out);
	#$Line ="<BR>Line ". __LINE__ . ", File ". __FILE__;
	if (!$Title) {$Title="Error";	}
	$Out=&Error($Msg, $Title, $Level);
	print "Content-type: text/html\n\n";
	print "$Out";
	exit 0;
}
#==========================================================
sub Initialization{

	$Global{'Program_Start_Time'} = time;

	if ($ENV{'CONTENT_TYPE'} =~ "multipart") {
			&Get_Form_Multipart;
	}
	else {
			&Get_Form;
	};

	&Get_Script_URL;
	&Get_OS;
	&Get_Cookies;
	&Read_Configuration;
	$Script_URL = "$Global{'CGI_URL'}/$Global{'MainProg_Name'}";
	&Access_Lock_Status;
	&Prepare_Categories;
	
	#&Check_Previous_User_Login;

	srand (time | $$);
}
#==========================================================
sub Load_Support{

	use Fcntl;
	use DB_File;
	eval "use configuration";
	eval "use mewsoft";
	eval "use catmanager";
	eval "use displaymgr";
	eval "use displaymain";
	eval "use timedate";
	eval "use dbmanagar";
	eval "use custom";
	eval "use general";
	eval "use http_lib";
	eval "use merchant";
	eval "use ssiinterface";
}
#=========================End of File=====================#
#==========================================================

