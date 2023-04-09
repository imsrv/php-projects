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
$Program_CGI_Directory='';
}
#==========================================================
# Unbuffer Output
$| = 1;
use CGI::Carp qw(fatalsToBrowser); 
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
   );
}

$Demo = 0;
use Fcntl;
use DB_File;
use File::Copy;

eval "use configuration";
eval "use mewsoft";
eval "use catmanager";
eval "use language";
eval "use displaymgr";
eval "use general";
#eval "use displaymain";
#eval "use displaylist";
eval "use submititem";
eval "use registration";
#eval "use preview";
eval "use login";
#eval "use payments";
eval "use timedate";
#eval "use viewitem";
eval "use dbmanagar";
#eval "use editprofile";
#eval "use search";
#eval "use custom";
#eval "use uploadfile";
eval "use maillib";
#eval "use contact";
#eval "use alertme";
#eval "use emailfriend";
#eval "use announcements";
#eval "use previewbid";
#eval "use bidding";
#eval "use countdown";
#eval "use users";
#==========================================================
#======================Start of Main======================#
$Param{'action'}="";

&Get_Form;
&Get_Script_URL;
&Get_OS;
&Get_Cookies;
&Read_Configuration;
$Script_URL = "$Global{'CGI_URL'}/$Global{'AdminProg_Name'}";
&Get_Images_Links;

if (!$Demo) {
	&Check_Admin_Authentication;
}

#==========================================================
#==========================================================
if ($Param{'action'} eq 'Web_Editor') {
	eval "use editor";
	&Web_Editor;
 }
elsif ($Param{'action'} eq 'Create_New_File') {
	&Demo;
	eval "use editor";
	&Create_New_File;
 }
elsif ($Param{'action'} eq 'Save_Template_File') {
	&Demo;
	eval "use editor";
	&Save_Template_File;
 }
elsif ($Param{'action'} eq "Custom_Class") { 
	eval "use editor";
	&Custom_Editor;
}
elsif ($Param{'action'} eq "Create_New_Custom_Class") {
	&Demo;
	eval "use editor";
	&Create_New_Custom_Class;
}
elsif ($Param{'action'} eq "Save_Class_File") {
	&Demo;
	eval "use editor";
	&Save_Class_File;
}
#----------------------------------------------------------
 elsif ($Param{'action'} eq 'Configuration') {
	&Configuration;
}
elsif ($Param{'action'} eq 'Save_Configuration') {
	&Demo;
	&Save_Configuration;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq 'General_Options') {
	&General_Options;
}
elsif ($Param{'action'} eq 'Save_General_Options') {
	&Demo;
	&Save_General_Options;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq 'Category_Options') {
	&Category_Options;
}
elsif ($Param{'action'} eq 'Save_Category_Options') {
	&Demo;
	&Save_Category_Options;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq 'Listing_Options') {
	&Listing_Options;
}
elsif ($Param{'action'} eq 'Save_Listing_Options') {
	&Demo;
	&Save_Listing_Options;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq 'File_Upload_Options') {
	&File_Upload_Options;
}
elsif ($Param{'action'} eq 'Save_File_Upload_Options') {
	&Demo;
	&Save_File_Upload_Options;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Category_Manager") {
	&Category_Manager;
}
elsif ($Param{'action'} eq "Create_Category") {
	&Demo;
	&Create_Category;
}
elsif ($Param{'action'} eq "Delete_Category_Confirm") {
	&Delete_Category_Confirm;
}
elsif ($Param{'action'} eq "Delete_Category") {
	&Demo;
	&Delete_Category;
}
elsif ($Param{'action'} eq "Edit_Category") {
	&Edit_Category;
}
elsif ($Param{'action'} eq "Save_Edit_Category") {
	&Demo;
	&Save_Edit_Category;
}
elsif ($Param{'action'} eq "Category_Tree") {
	&Admin_Category_Tree;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Language_Manager") {
	&Language_Manager;
}
elsif ($Param{'action'} eq "Create_New_Language") {
	&Demo;
	&Create_New_Language;
}
elsif ($Param{'action'} eq "Set_Default_Language") {
	&Demo;
	&Set_Default_Language;
}
elsif ($Param{'action'} eq "Edit_Language") {
	&Edit_Language;
}
elsif ($Param{'action'} eq "Delete_Language") {
	&Demo;
	&Delete_Language;
}
elsif ($Param{'action'} eq "Edit_Language_File") {
	&Edit_Language_File;
}
elsif ($Param{'action'} eq "Save_Language_File") {
	&Demo;
	&Save_Language_File;
}
elsif ($Param{'action'} eq "Initialize_Language") {
	&Initialize_Language;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Server_Test") {
	eval "use testserver";
	&Server_Test;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Lock_Access") {
	&Lock_Access;
}
elsif ($Param{'action'} eq "Save_Access_Lock") {
	&Demo;
	&Save_Access_Lock;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Database_Manager") {
	&Database_Manager;
}
elsif ($Param{'action'} eq "ASCII_Backup") {
	&Demo;
	&ASCII_Backup;
}
elsif ($Param{'action'} eq "Load_ASCII_Backup") {
	&Demo;
	&Load_ASCII_Backup;
}
elsif ($Param{'action'} eq "Database_Maintenance") {
	&Demo;
	&Database_Maintenance;
}
elsif ($Param{'action'} eq "Export_Users") {
	&Demo;
	&Export_Users;
}
elsif ($Param{'action'} eq "Export_Maillists") {
	&Demo;
	&Export_Maillists;
}
elsif ($Param{'action'} eq "Export_Balance") {
	&Demo;
	&Export_Balance;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Reset_Permissions") {
	&Reset_Permissions;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Server_Backup") {
	&Server_Backup;
}
elsif ($Param{'action'} eq "Do_Server_Backup") {
	&Demo;
	&Do_Server_Backup;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Mail_Manager") {
	&Mail_Manager;
}
elsif ($Param{'action'} eq "Create_Category_Specific_Lists") {
	&Create_Category_Specific_Lists;
}
elsif ($Param{'action'} eq "Add_New_Subscribers") {
	&Add_New_Subscribers;
}
elsif ($Param{'action'} eq "Save_New_Subscribers") {
	&Save_New_Subscribers;
}
elsif ($Param{'action'} eq "Delete_Subscribers") {
	&Delete_Subscribers;
}
elsif ($Param{'action'} eq "Do_Delete_Subscribers") {
	&Demo;
	&Do_Delete_Subscribers;
}
elsif ($Param{'action'} eq "Create_New_Lists") {
	&Create_New_Lists;
}
elsif ($Param{'action'} eq "Do_Create_New_Lists") {
	&Do_Create_New_Lists;
}
elsif ($Param{'action'} eq "Delete_Lists") {
	&Demo;
	&Delete_Lists;
}
elsif ($Param{'action'} eq "Do_Delete_Lists") {
	&Do_Delete_Lists;
}
elsif ($Param{'action'} eq "Send_Mass_Email") {
	&Send_Mass_Email;
}
elsif ($Param{'action'} eq "Do_Send_Mass_Email") {
	&Demo;
	&Do_Send_Mass_Email;
}
elsif ($Param{'action'} eq "Edit_Letters") {
	&Edit_Letters;
}
elsif ($Param{'action'} eq "Edit Letter" || ($Param{'action'} eq "View Letter")) {
	&Do_Edit_Letters;
}
elsif ($Param{'action'} eq "Save Letter") {
	&Demo;
	&Save_Edit_Letters;
}
elsif ($Param{'action'} eq "Delete Letter") {
	&Demo;
	&Delete_Letter;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Update_Category_Count") {
	&Do_Update_All_Category_Count;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Fees_Setup") {
	&Fees_Setup_Menu;
}
elsif ($Param{'action'} eq "Regular_Insertion_Fees_Setup") {
	&Regular_Insertion_Fees_Setup;
}
elsif ($Param{'action'} eq "Reserve_Fees_Setup") {
	&Reserve_Fees_Setup;
}
elsif ($Param{'action'} eq "Additional_Options_Insertion_Fees_Setup") {
	&Additional_Options_Insertion_Fees_Setup;
}
elsif ($Param{'action'} eq "Final_Value_Fees_Setup") {
	&Final_Value_Fees_Setup;
}
elsif ($Param{'action'} eq "Save_Regular_Insertion_Fees_Setup") {
	&Demo;
	&Save_Regular_Insertion_Fees_Setup;
}
elsif ($Param{'action'} eq "Save_Reserve_Fees_Setup") {
	&Demo;
	&Save_Reserve_Fees_Setup;
}
elsif ($Param{'action'} eq "Save_Final_Value_Fees_Setup") {
	&Demo;
	&Save_Final_Value_Fees_Setup;
}
elsif ($Param{'action'} eq "Save_Additional_Options_Insertion_Fees_Setup") {
	&Demo;
	&Save_Additional_Options_Insertion_Fees_Setup;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Edit_Announcements") {
	&Edit_Announcements;
}
elsif ($Param{'action'} eq "Edit Announcement" || ($Param{'action'} eq "View Announcement")) {
	&Do_Edit_Announcements;
}
elsif ($Param{'action'} eq "Save Announcement") {
	&Demo;
	&Save_Edit_Announcement;
}
elsif ($Param{'action'} eq "Delete Announcement") {
	&Demo;
	&Delete_Announcement;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Commander") {
	&Commander;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Upgrade") {
	&Upgrade;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "General_Classes") {
	&General_Classes;
}
elsif ($Param{'action'} eq "Save_General_Classes") {
	&Demo;
	&Save_General_Classes;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Help") {
	&Help;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "About") {
	&About;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Billing_Manager") {
	eval "use accountmgr";
	&Billing_Manager;
}
elsif ($Param{'action'} eq "Create_Billing_File") {
	#&Demo;
	eval "use accountmgr";
	&Create_Billing_File;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Auctions_Manager") {
	&Auctions_Manager;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Archive_Closed_Items") {
	eval "use accountmgr";
	&Archive_Closed_Items;
}
elsif ($Param{'action'} eq "Remove Closed Auctions") {
	eval "use accountmgr";
	&Remove_Closed_Auctions;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Users_Manager") {
	&Users_Manager;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Do_Delete_Users") {
	&Demo;
	eval "use accountmgr";
	eval "use users";
	&Do_Delete_Users;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Load_Users") {
	&Load_Users;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Delete_Open_Items") {
	&Demo;
	&Delete_Open_Items;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "View_Billing_Report") {
	&View_Billing_Report;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "View_Closed_Log") {
	&View_Closed_Log;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Setup_Billing_Fields") {
	&Setup_Billing_Fields;
}
elsif ($Param{'action'} eq "Manage_Accounts") {
	&Manage_Accounts;
}
elsif ($Param{'action'} eq "Load_Accounts") {
	&Load_Accounts;
}
elsif ($Param{'action'} eq "Save_Accounts_Balances") {
	eval "use accountmgr";
	&Save_Accounts_Balances;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Save_Setup_Billing_Fields") {
	&Demo;
	&Save_Setup_Billing_Fields;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Automation") {
	&Automation;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Save_Automation") {
	&Demo;
	&Save_Automation;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Install_Cron") {
	&Demo;
	&Install_Cron;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Merchant_Account_Setup") {
	&Merchant_Account_Setup;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Save_Merchant_Account_Setup") {
	&Demo;
	&Save_Merchant_Account_Setup;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Fixed_Fees_Setup") {
	&Fixed_Fees_Setup;
}
#----------------------------------------------------------
elsif ($Param{'action'} eq "Save_Fixed_Fees_Setup") {
	&Demo;
	&Save_Fixed_Fees_Setup;
}
#----------------------------------------------------------
else {
	&Admin_Menu;
}
#----------------------------------------------------------
exit 0;
#----------------------------------------------------------
#=======================End of Main========================
#==========================================================
sub Merchant_Account_Setup{

		&Print_Page(&Merchant_Account_Setup_Form);

}
#==========================================================
sub Save_Merchant_Account_Setup{
my(%data);

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Merchant_Account_Provider'} = $Param{'Merchant_Account_Provider'};
	$data{'Web_Server_Connection'} = $Param{'Web_Server_Connection'};
	$data{'Authorize_Net_Login'} = $Param{'Authorize_Net_Login'};
	$data{'Authorize_Net_Password'} = $Param{'Authorize_Net_Password'};
	$data{'QuickCommerce_Login'} = $Param{'QuickCommerce_Login'};
	$data{'QuickCommerce_Password'} = $Param{'QuickCommerce_Password'};
	$data{'PlanetPayment_Login'} = $Param{'PlanetPayment_Login'};
	$data{'PlanetPayment_Password'} = $Param{'PlanetPayment_Password'};
	$data{'Plugnpay_Login'} = $Param{'Plugnpay_Login'};
	$data{'Plugnpay_Password'} = $Param{'Plugnpay_Password'};
	$data{'iBill_Login'} = $Param{'iBill_Login'};
	$data{'iBill_Password'} = $Param{'iBill_Password'};
	
	untie %data;
	&Admin_Msg(" Saved ", "<br><center>Merchant Account Setup Saved.<br></center>", 1);

}
#==========================================================
sub Merchant_Account_Setup_Form{
my ($Out, $Help);
my($Merchants);

	$Help =&Help_Link("Merchant_Account_Setup");

	if ($Global{'Merchant_Account_Provider'} eq "Authorize_Net") {
			$Merchants=qq!<option value="Authorize_Net" selected>Authorize Net</option>!;
	}
	else{
			$Merchants=qq!<option value="Authorize_Net" >Authorize Net</option>!;
	}

	if ($Global{'Merchant_Account_Provider'} eq "iBill") {
			$Merchants.=qq!<option value="iBill" selected>iBill</option>!;
	}
	else{
			$Merchants.=qq!<option value="iBill" >iBill</option>!;
	}

	if ($Global{'Merchant_Account_Provider'} eq "Quick_Commerce") {
			$Merchants.=qq!<option value="Quick_Commerce" selected>Quick Commerce</option>!;
	}
	else{
			$Merchants.=qq!<option value="Quick_Commerce" >Quick Commerce</option>!;
	}

	if ($Global{'Merchant_Account_Provider'} eq "Planet_Payment") {
			$Merchants.=qq!<option value="Planet_Payment" selected>Planet Payment</option>!;
	}
	else{
			$Merchants.=qq!<option value="Planet_Payment" >Planet Payment</option>!;
	}

	if ($Global{'Merchant_Account_Provider'} eq "PlugnPay") {
			$Merchants.=qq!<option value="PlugnPay" selected>Plug 'n Pay</option>!;
	}
	else{
			$Merchants.=qq!<option value="PlugnPay" >Plug 'n Pay</option>!;
	}

	if ($Global{'Web_Server_Connection'} eq "LWP_Simple") {
			$Web_Server.=qq!<option value="LWP_Simple" selected>LWP Simple</option>!;
	}
	else{
			$Web_Server.=qq!<option value="LWP_Simple" >LWP Simple</option>!;
	}

	if ($Global{'Web_Server_Connection'} eq "LWP_UserAgent") {
			$Web_Server.=qq!<option value="LWP_UserAgent" selected>LWP UserAgent</option>!;
	}
	else{
			$Web_Server.=qq!<option value="LWP_UserAgent" >LWP UserAgent</option>!;
	}

	if ($Global{'Web_Server_Connection'} eq "Net_SSLeay") {
			$Web_Server.=qq!<option value="Net_SSLeay" selected>Net SSLeay</option>!;
	}
	else{
			$Web_Server.=qq!<option value="Net_SSLeay" >Net SSLeay</option>!;
	}

	if ($Global{'Web_Server_Connection'} eq "Socket") {
			$Web_Server.=qq!<option value="Socket" selected>Socket</option>!;
	}
	else{
			$Web_Server.=qq!<option value="Socket" >Socket</option>!;
	}


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type=hidden name="action" value="Save_Merchant_Account_Setup">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Merchant
                  Account Setup</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          <p align="left">Please choose your merchant account or billing system
          provider and also enter your billing system login or username and
          password. These information will be used for real time credit card
          processing.<br>
          <br>
          <div align="center">
          <table border="1" width="100%" cellspacing="0" cellpadding="4">

            <tr>
              <td width="41%" height="19">Select your merchant account
                provider&nbsp;</td>
              <td width="59%" height="19">
			  <select size="1" name="Merchant_Account_Provider">
				$Merchants
				</select>
			</td>
            </tr>

            <tr>
              <td width="41%" height="19">
                Choose connection method with your merchat server
				
				</td>
              <td width="59%" height="19">
			  <select size="1" name="Web_Server_Connection">
				$Web_Server
				</select>
				&nbsp;
				<a href="$Script_URL?action=Server_Test"><b>Test?</b></a>
			</td>
            </tr>

			<center>
            <tr>
              <td width="100%" height="19" colspan="2" bgcolor="#ECF9F7"><b>Authorize
                Net Merchant Account</b></td>
            </tr>
            <tr>
              <td width="41%" height="19">Merchant Login</td>
              <td width="59%" height="19"><input type="text" name="Authorize_Net_Login" size="30" value="$Global{'Authorize_Net_Login'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="41%" height="19">Merchant Password</td>
              <td width="59%" height="19"><input type="password" name="Authorize_Net_Password" size="30" value="$Global{'Authorize_Net_Password'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="100%" colspan="2" height="19" bgcolor="#ECF9F7"><b>Quick
                Commerce Merchant Account</b></td>
            </tr>
            <tr>
              <td width="41%" height="19">Merchant Login</td>
              <td width="59%" height="19"><input name="QuickCommerce_Login" size="30" value="$Global{'QuickCommerce_Login'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="41%" height="19">Merchant Password</td>
              <td width="59%" height="19"><input type="password" name="QuickCommerce_Password" size="30" value="$Global{'QuickCommerce_Password'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="100%" colspan="2" height="19" bgcolor="#ECF9F7"><b>Planet
                Payment Merchant Account</b></td>
            </tr>
            <tr>
              <td width="41%" height="19">Merchant Login</td>
              <td width="59%" height="19"><input type="text" name="PlanetPayment_Login" size="30" value="$Global{'PlanetPayment_Login'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="41%" height="20">Merchant Password</td>
              <td width="59%" height="20"><input type="password" name="PlanetPayment_Password" size="30" value="$Global{'PlanetPayment_Password'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="100%" height="20" colspan="2" bgcolor="#ECF9F7"><b>Plug
                'n Pay Merchant Account</b></td>
            </tr>
            <tr>
              <td width="41%" height="20">Merchant Login</td>
              <td width="59%" height="20"><input type="text" name="Plugnpay_Login" size="30" value="$Global{'Plugnpay_Login'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="41%" height="20">Merchant Password</td>
              <td width="59%" height="20"><input type="password" name="Plugnpay_Password" size="30" value="$Global{'Plugnpay_Password'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="100%" height="20" colspan="2" bgcolor="#ECF9F7"><b>iBill
                Merchant Account</b></td>
            </tr>
            <tr>
              <td width="41%" height="20">Merchant Login</td>
              <td width="59%" height="20"><input type="text" name="iBill_Login" size="30" value="$Global{'iBill_Login'}"  onFocus="select();"></td>
            </tr>
            <tr>
              <td width="41%" height="20">Merchant Password</td>
              <td width="59%" height="20"><input type="password" name="iBill_Password" size="30" value="$Global{'iBill_Password'}"  onFocus="select();"></td>
            </tr>
          </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
          <p align="center">
		  <input type="submit" value="Save Changes">
		  <input type="reset" value="Reset">&nbsp;
		  <input onclick="history.go(-1);" type="button" value="Cancel">
          
         </td>
      </tr>
    </table>
  </div>
</form>
HTML

	return $Out;
}
#==========================================================
sub Get_Images_Links{
	$Global{'R_Bullet'}=qq!<img src="$Global{'ImagesDir'}/415.gif">!;
	$Global{'G_Bullet'}=qq!<img src="$Global{'ImagesDir'}/407.gif">!;
	$Global{'Y_Bullet'}=qq!<img src="$Global{'ImagesDir'}/Yl_ball.gif">!;
	$Global{'O_Bullet'}=qq!<img src="$Global{'ImagesDir'}/orgball.gif">!;
	$Global{'G1_Bullet'}=qq!<img src="$Global{'ImagesDir'}/grn02dot.gif">!;
}
#==========================================================
sub Install_Cron{
	
	$File="$Global{'DataDir'}/cron.txt";
	open(CRON, ">$File") 
				or &Exit("can't create file: $File"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	print CRON "$Global{'Cron_Minute'} $Global{'Cron_Hour'} $Global{'Cron_Day'} $Global{'Cron_Month'} $Global{'Cron_Weekday'}";
	print CRON " $Global{'BaseDir'}/autoclose.cgi\n";
	close CRON;

	system("crontab $File  > $Global{'Temp_Dir'}/cron.txt");
	open(FILE,"$Global{'Temp_Dir'}/cron.txt");
	@Out=<FILE>;
	$Output .= join("", @Out);
	close(FILE);

	$Output=&Encode_HTML($Output);
	$Output=~ s/\n/<br>/g;
	$Output=~ s/\&lt;br\&gt;/<br>/ig;

	&Admin_Msg(" Installed ", "<br><center>Auction Services Automation Program Installed.<br>$Output</center>", 1);
}
#==========================================================
sub Save_Automation{
my(%data);

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Cron_Minute'} = $Param{'Cron_Minute'};
	$data{'Cron_Hour'} = $Param{'Cron_Hour'};
	$data{'Cron_Day'} = $Param{'Cron_Day'};
	$data{'Cron_Month'} = $Param{'Cron_Month'};
	$data{'Cron_Weekday'} = $Param{'Cron_Weekday'};

	untie %data;
	&Admin_Msg(" Saved ", "<br><center>Cron Job Setting Saved.<br>Cron command is ($Param{'Cron_Minute'} $Param{'Cron_Hour'} $Param{'Cron_Day'} $Param{'Cron_Month'} $Param{'Cron_Weekday'}).<br></center>", 1);
}
#==========================================================
sub Automation{

		&Print_Page(&Automation_Form);
}
#==========================================================
sub Automation_Form{
my($Minute, $Hour, $Day, $Month, $min, $hr, $mon);
my($Help, %Minutes, %Hours, %Days);
	
	$Help =&Help_Link("Automation");

	my (%Weekdays) = (0=>'Sunday', 1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday',  5=>'Friday', 6=>'Saturday', '*'=>'Every Day');
    
	my (%Months) = (1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June',  
		           7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December', '*'=>'Every Month');
	#------------------------------------------------------
	$Minute=qq!<select name="Cron_Minute" size="1">!;
	for $x(0..59) {
		$Minutes{$x}=$x;
	}
	$Minutes{'*'} = "Every Minute";

	foreach $min(sort keys %Minutes) {
			if ($min eq $Global{'Cron_Minute'}) {
					$Minute.=qq!<option selected value="$min">$Minutes{$min}</option>!;
			}
			else{
					$Minute.=qq!<option value="$min">$Minutes{$min}</option>!;
			}
	}
    $Minute.=qq!</select>!;
	#------------------------------------------------------
	$Hour=qq!<select name="Cron_Hour" size="1">!;
	for $x(0..23) {
		$Hours{$x}=$x;
	}
	$Hours{'*'} = "Every Hour";
	foreach $hr(sort keys %Hours) {
			if ($hr eq $Global{'Cron_Hour'}) {
					$Hour.=qq!<option selected value="$hr">$Hours{$hr}</option>!;
			}
			else{
					$Hour.=qq!<option value="$hr">$Hours{$hr}</option>!;
			}
	}
    $Hour.=qq!</select>!;
	#------------------------------------------------------
	$Day=qq!<select name="Cron_Day" size="1">!;
	for $x(1..31) {
		$Days{$x}=$x;
	}
	$Days{'*'} = "Every Day";
	foreach $day(sort keys  %Days) {
			if ($day eq $Global{'Cron_Day'}) {
					$Day.=qq!<option selected value="$day">$Days{$day}</option>!;
			}
			else{
					$Day.=qq!<option value="$day">$Days{$day}</option>!;
			}
	}
    $Day.=qq!</select>!;
	#------------------------------------------------------
	$Month=qq!<select name="Cron_Month" size="1">!;
	foreach $mon(sort keys  %Months) {
			if ($mon eq $Global{'Cron_Month'}) {
					$Month.=qq!<option selected value="$mon">$Months{$mon}</option>!;
			}
			else{
					$Month.=qq!<option value="$mon">$Months{$mon}</option>!;
			}
	}
    $Month.=qq!</select>!;
	#------------------------------------------------------
	$Weekday=qq!<select name="Cron_Weekday" size="1">!;
	foreach $day(sort keys  %Weekdays) {
			if ($day eq $Global{'Cron_Weekday'}) {
					$Weekday.=qq!<option selected value="$day">$Weekdays{$day}</option>!;
			}
			else{
					$Weekday.=qq!<option value="$day">$Weekdays{$day}</option>!;
			}
	}
     $Weekday.=qq!</select>!;
	#------------------------------------------------------

$Out=<<HTML;

<form method="POST" action="$Script_URL">
<input type=hidden name="action" value="Save_Automation">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="3">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Auction
                  Services Automation</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          The auction services automation process is done using unix cron job by
          installing and runing crontab program in the background. On windows
          servers automation can be done using scheduled tasks. This function
          will install and configure unix crontab only.<br>
          Auction services that will be automated are, closing the auctions,
          resubmitting unsold closed auctions that sellers choose to
          automatically resubmit, sending emails for bidders and sellers of
          closed auctions, moving closed auctions to the archive for users
          feedback and billing.
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          <b>1 - Cron Job Configuration:<br>
          <br>
          </b>Please choose the times you want to run the auction automation
          program automatically using crontab program:<br>
          <div align="center">
            <center>
            <table border="1" width="70%" cellspacing="0" cellpadding="3">
              <tr>
                <td width="50%">Minute</td>
                <td width="50%">$Minute</td>
              </tr>
              <tr>
                <td width="50%">Hour</td>
                <td width="50%">$Hour</td>
              </tr>
              <tr>
                <td width="50%">Day of the month</td>
                <td width="50%">$Day</td>
              </tr>
              <tr>
                <td width="50%">Month of the year</td>
                <td width="50%">$Month</td>
              </tr>
              <tr>
                <td width="50%">Day of the week</td>
                <td width="50%">$Weekday</td>
              </tr>
            </table>
            </center>
          </div>
          <br>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> 
          <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel">
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          <p align="left"><b>2 - Cron Job Installation:<br>
          </b>This will install a cron job program that will automate the
          auction services to run at the times specified above.</p>
          <p align="center">$Global{'G_Bullet'}<b><a href="$Script_URL?action=Install_Cron">Install Auction Automation
          Program</a></b></p>
          <p>&nbsp;</p>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
          <p align="center">&nbsp;
        </td>
      </tr>
    <center>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
          <p align="center">&nbsp;&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Load_Users{

		if (! $Param{'Group'}) {$Param{'Group'}="A";}

		&Print_Page(&Load_Users_Form($Param{'Group'}));

}
#==========================================================
sub Load_Users_Form{
my($Group)=shift;
my ($Out, $Help);
my($Count, @Users, @BGColor);

	$Help =&Help_Link("Users_Manager");

	undef @Users;
	@Users=&Get_Users_Group($Group);
	$Count=@Users;
	#------------------------------------------------------
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}

	$Last_Page=int($Count / $Global{'Admin_Users_Per_Page'});
	if (($Count % $Global{'Admin_Users_Per_Page'})) { $Last_Page++; }
	$Current_Page = $Param{'Page'};
	$Next_Page=($Current_Page + 1);
	$Previous_Page = ($Current_Page - 1);
	if ($Next_Page > $Last_Page) {$Next_Page = $Last_Page;}
	$Start = ($Current_Page -1) * $Global{'Admin_Users_Per_Page'};
	$End = $Start + $Global{'Admin_Users_Per_Page'};
	if ($End > $Count) {$End = $Count;}

	$Temp = qq!$Script_URL?action=Load_Users&Page=$Next_Page&Group=A!;
	$Next_Page_Link = qq!<A HREF="$Temp">Next Page</A>!;
	$Temp = qq!$Script_URL?action=Load_Users&Page=$Previous_Page&Group=A!;
	$Previous_Page_Link = qq!<A HREF="$Temp">Previous Page</A>!;
	#------------------------------------------------------
	$BGColor[0]="#FFF0E1";
	$BGColor[1]="#D9ECEC";
	$Users_Row="";
	for $Counter($Start..$End-1) {
			$Counter1 = $Counter+1;
			$BGColor=$BGColor[int($Counter %2)];

			$Edit_Account =qq!<A HREF="$Global{'Auction_Script_URL'}?action=Account_Manager&Remember_login=YES&User_ID=$Users[$Counter]{'User_ID'}&Password=$Users[$Counter]{'Password'}" TARGET="_BLANK"><B>Edit</B></A>!;
			if ($Demo) {$Edit_Account ="Edit (Disabled!)";}

			$Users_Row.=qq! <tr width = "100%">
										  <td width="5%" bgcolor="$BGColor">$Counter1</td>
										  <td width="15%" bgcolor="$BGColor"><a href="mailto: $Users[$Counter]{'EmailAddress'}"><b>$Users[$Counter]{'User_ID'}</b></a></td>
										  <td width="20%" bgcolor="$BGColor">$Users[$Counter]{'LastName'}, $Users[$Counter]{'FirstName'} $Users[$Counter]{'MiddleInitial'}</td>
										  <td width="20%" bgcolor="$BGColor">$Users[$Counter]{'Street1'}, $Users[$Counter]{'Street2'}, $Users[$Counter]{'City'}, $Users[$Counter]{'Stat'}, $Users[$Counter]{'Country'}</td>
										  <td width="15%" bgcolor="$BGColor" align="center">$Users[$Counter]{'Phone'}, Ext: $Users[$Counter]{'Extension'}</td>
										  <td width="15%" bgcolor="$BGColor" align="center">$Users[$Counter]{'Fax'}</td>
										  <td width="15%" bgcolor="$BGColor" align="center">$Edit_Account</td>
										  <td width="15%" bgcolor="$BGColor" align="center"><a href="$Script_URL?action=Do_Delete_Users&Users_IDs=$Users[$Counter]{'User_ID'}"><b>Delete</b></a></td>
				                  </tr>!;
	}

$Out=<<HTML;
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Users
                  Manager</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">
				  
				  $Help
				  
				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
		<b>The total number of registered users in this group is $Count</b>
		</td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
	
<table border="0" width="100%" cellspacing="1" cellpadding="2">
  <tr>
    <td width="5%" bgcolor="#E1E1C4">
      <p align="center">#</td>
    <td width="15%" bgcolor="#E1E1C4">
      <p align="center"><b>User/Email</b></td>
    <td width="20%" bgcolor="#E1E1C4">
      <p align="center"><b>Name</b></td>
    <td width="20%" bgcolor="#E1E1C4">
      <p align="center"><b>Address</b></td>
    <td width="15%" bgcolor="#E1E1C4">
      <p align="center"><b>Phone</b></td>
    <td width="15%" bgcolor="#E1E1C4">
      <p align="center"><b>Fax</b></td>
    <td width="10%" bgcolor="#E1E1C4" colspan="2" align="center">
      <p align="center"><b>Action</b></td>
  </tr>
  
  $Users_Row

</table>
		</td>
      </tr>

      <TR>
        <TD WIDTH="100%" HEIGHT="27" BGCOLOR="#B6DEDC">
		  <P ALIGN="RIGHT">
				Showing users page $Current_Page of $Last_Page &nbsp;&nbsp;
				$Previous_Page_Link &nbsp;&nbsp;
				$Next_Page_Link 

		  </TD>
      </TR>
    </TABLE>
  </DIV>
HTML
	return $Out;
}
#==========================================================
sub Do_Delete_Users{

	@Users_IDs = split("\n", $Param{'Users_IDs'});
	&Delete_Users(@Users_IDs);
	&Admin_Msg("Delete Users Done ", "The following users removed from the registration system:<br> $Param{'Users_IDs'}", 1);
}
#==========================================================
sub Users_Manager{
		&Print_Page(&Users_Manager_Form);
}
#==========================================================
sub Users_Manager_Form{
my ($Out, $Help, $Users);

$Help =&Help_Link("Users_Manager");

$Users=&Get_Users_Count;

$Out=<<HTML;
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Users
                  Manager</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">
				  
				  $Help
				  
				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
		<b>The total number of registered users is $Users</b>
		</td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
<div align="center">
  <center>
  <table border="0" width="100%">
    <tr>
      <td width="6%"  valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=[0-9]">#</a></b></td>
      <td width="73%" colspan="11" bgcolor="#E1E1C4">
        <p align="center">
		
		<b>Select Users Group to Load</b>

		</td>
      <td width="7%" bgcolor="#FFCE9D">&nbsp;</td>
    </tr>
    <tr>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=A">A</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=B">B</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=C">C</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=D">D</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=E">E</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=F">F</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=G">G</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=H">H</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=I">I</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=J">J</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=K">K</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=L">L</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=M">M</a></b></td>
    </tr>
    <tr>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=N">N</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=O">O</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=P">P</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=Q">Q</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=R">R</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=S">S</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=T">T</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=U">U</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=V">V</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=W">W</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=X">X</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=Y">Y</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Users&Group=Z">Z</a></b></td>
    </tr>
  </table>
  </center>
</div>

		</td>
      </tr>

      <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Delete_Users">

		  <p align="left"><b>Delete These Users:</b><br>
		  Please enter required users ID's each on one line and press enter at the end of line.<br>
          <p align="center"><b>Users ID's<br>

          <textarea rows="7" name="Users_IDs" cols="45"></textarea>&nbsp;&nbsp;&nbsp;&nbsp;<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </b>
		  <input type="submit" value="Do_Delete Users">&nbsp; 
		  <input type="reset" value="Clear Form"><br>
</form>
		</td>
      </tr>

    <center>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
		 <form method="POST" action="$Script_URL">
		  <p align="center">&nbsp;&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel">
		 </form>
		  </td>
      </tr>
    </table>
    </center>
  </div>
HTML
	return $Out;
}
#==========================================================
sub Auctions_Manager{

		&Print_Page(&Auctions_Manager_Form);

}
#==========================================================
sub Archive_Closed_Items{
my($Closed_Items_Count, $Resubmitted_Items_Count, $Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Bidding_File'});
	
	#print "Content-type: text/html\n\n" ;
	
	&Prepare_Categories;

	$Resubmitted_Items_Count = &Resubmit_Items(1);
	$Closed_Items_Count = &Move_Closed_Items(1);

	if (! -e "$Global{'Auction_Close_Log'}") {
		open(LOG, ">$Global{'Auction_Close_Log'}") 
				or &Exit("can't create log file: $Global{'Auction_Close_Log'}");
		close LOG;
	}

	open(LOG, ">>$Global{'Auction_Close_Log'}") 
													or &Exit("Can't open log file: $Global{'Auction_Close_Log'}");

	$Out=&Get_Local_Time(&Time(time));
	print LOG "$Out\n";
	$Out=qq!The number of resubmitted auctions is: $Resubmitted_Items_Count\n!;
	$Out.=qq!The number of archived auctions is: $Closed_Items_Count\n!;
	print LOG "$Out\n";
	close LOG;

	$Out=qq!<b>The number of resubmitted auctions is: $Resubmitted_Items_Count</b><br>\n!;
	$Out.=qq!<b>The number of archived auctions is: $Closed_Items_Count</b><br>\n!;
	print "$Out<br>\n";
	$Out=qq!<center><b><a href="javascript:window.close()">Close This Window</a></b></center><br>\n!;
	print "$Out";
}
#==========================================================
sub Remove_Closed_Auctions{
my($Removed_Items_Count, $Close_Time);
my($Time, $mday, $mon, $year);

	eval("use Time::Local");
=help start
	 $time = timelocal($sec,$min,$hours,$mday,$mon,$year);
	 $time = timegm($sec,$min,$hours,$mday,$mon,$year);
	 year is year-1900 and month is 0..11.
=help end
	Ahmed Elsheshtawy, Mewsoft
=cut

	$mday = $Param{'Close_Day'};
	$mon = $Param{'Close_Month'} - 1;
	$year = $Param{'Close_Year'} - 1900;
	
	$Time = timelocal(59,59,23,$mday,$mon,$year);
	 $Time = int($Time + $Global{'GMT_Offset'} * 3600);
	$Removed_Items_Count=&Remove_Closed_Items($Time);
	$Close_Time=&Curent_Date_Time($Time);
	
	&Admin_Msg("Done Removing Closed Auctions", "The number of removed auctions is: <b>$Removed_Items_Count</b> <br><br> All archived closed auctions before <b>$Close_Time</b> are removed from the archive.<br>", 1);

}
#==========================================================
sub Delete_Open_Items{
my(@Items, $Item, $Items, $Removed_Items_Count, $Status);

	@Items=split(/\n/, $Param{'Items_IDs'});
	$Removed_Items_Count=0;
	$Items="";

	&Prepare_Categories;

	foreach $Item(@Items){
		$Item=~ s/\n//g;
		$Item=~ s/\r//g;
		$Item=~ s/\s+//g;
		$Status=&Delete_Item($Item);
		if ($Status) {	
				$Removed_Items_Count ++;
				$Items .= "$Item".", ";
		}
	}
	$Items=~ s/\,\s+$//;
	&Update_All_Categories_Count(0);
	&Admin_Msg("Done Removing Open Auctions", "The number of removed auctions is: <b>$Removed_Items_Count</b> <br><br>These items has been removed from the system database: <br>$Items<br>", 1);

}
#==========================================================
sub Auctions_Manager_Form{
my ($Out, $Help, $Count);
my($Day, $Month, $Year, $x);

	$Help =&Help_Link("Auctions_Manager");

	$Count=&Get_Archived_Items_Count;

	$Month="";
	for $x(1..12) {
			$Month.=qq!<option value="$x">$x!;
	}

	$Day="";
	for $x(1..31) {
			$Day.=qq!<option value="$x">$x!;
	}

	$Year="";
	for $x(2000..2020) {
			$Year.=qq!<option value="$x">$x!;
	}

$Out=<<HTML;
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Auctions
                  Manager</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">

				  $Help

				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>
      <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
          <p align="left">
				<b>Check all current auctions and proceed the following functions:</b><br><br>
				1)- Resubmit unsold closed auctions if their resubmit number is still greater than zero<br>
				2)- Send email notifications for closed auctions sellers and bidders<br>
				3)- Archive all other closed auctions for billing and rating<br><br>

				<center>
				
				$Global{'G_Bullet'}<A  HREF="#" onClick="window.open('$Script_URL?action=Archive_Closed_Items','Archive_Closed_Items','WIDTH=600,HEIGHT=400,scrollbars=yes,resizable=yes,left=50,top=50,screenX=150,screenY=100');return false"><b>Check and Proceed Closed Auctions</b></A>

				<br>
				</center>
				</td>
		  </td>
      </tr>

      <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
		<br>
			<b>View Closed and Resubmited Auctions Statistics</b> 
			&nbsp;&nbsp;&nbsp;&nbsp;
			
				$Global{'G_Bullet'}<A  HREF="#" onClick="window.open('$Script_URL?action=View_Closed_Log','View_Closed_Log','WIDTH=600,HEIGHT=400,scrollbars=yes,resizable=yes,left=50,top=50,screenX=150,screenY=100');return false"><b>View Closed Auctions Log</b></A>

				<br><br>
				</td>
		  </td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
          <p align="left">
			
			<form method="POST" action="$Script_URL">
				<b>
				Delete Closed Auctions From The Archive
				</b>
				<br>
				<br>
				There are currently <b>$Count</b> items in the archive.
				<br><br>

            <center>
            <table border="1" width="80%" cellpadding="3" bordercolorlight="#808000" bordercolordark="#C0C0C0">
              <tr>
                <td width="100%" colspan="3" align="center" height="19" bgcolor="#000080">
                  <p align="center"><b><font color="#00FFFF">
				  
				  Delete all closed auction before this date
				  
				  </font></b></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#E1E1C4" height="21">
				<b><font color="#000000">day</font></b></td>
                <td align="center" bgcolor="#E1E1C4" height="21">
				<b><font color="#000000">month</font></b></td>
                <td align="center" bgcolor="#E1E1C4" height="21">
				<b><font color="#000000">year</font>
				</b></td>
              </tr>
              <tr>
                <td height="21" align="center">
				<select size="1" name="Close_Day">
                $Day
				  </select></td>

                <td height="21" align="center">
				<select size="1" name="Close_Month">
				$Month
                  </select>
				  </td>

                <td height="21" align="center">
				<select size="1" name="Close_Year">
				$Year
                  </select>
				  </td>
              </tr>
            </table>
            </center>
          </div>
			<br>
  		  <input type="submit" value="Remove Closed Auctions" name="action">
		  &nbsp;
		  <input onclick="history.go(-1);" type="button" value="Cancel">
			</form>
		  </td>
	  </tr>
	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
          <p align="left">
			<form method="POST" action="$Script_URL">
			<input type="hidden" name="action" value="Delete_Open_Items" >
				<b>Delete Open Auctions</b><br>
				Delete these open lots from the database. Please enter each Item ID number on one line.
				<p align="center"><b>Items ID's<br>
				<textarea rows="5" name="Items_IDs" cols="40"></textarea>
			<br>
			<p align="center">
  		  <input type="submit" value="Delete These Open Auctions">
		  &nbsp;
		  <input onclick="history.go(-1);" type="button" value="Cancel">
			</form>
		  </td>
	  </tr>

	</table>
    </center>
  </div>
HTML
	return $Out;
}
#==========================================================
sub View_Closed_Log{

	print "Content-type: text/html\n\n";

	if ( -e "$Global{'Auction_Close_Log'}") {
		open(LOG, "$Global{'Auction_Close_Log'}") 
				or &Exit("can't create log file: $Global{'Auction_Close_Log'}");
		@Lines=<LOG>;
		$Out=join("<br>", @Lines);
		close LOG;
	}
	else{
			$Out="File $Global{'Auction_Close_Log'} not created yet. This file will be created after any manual or auto auctions close process.";
	}

	print "$Out<br>";

	$Out=qq!<center><b><a href="javascript:window.close()">Close This Window</a></b></center><br>!;
	print "$Out<br>";


}
#==========================================================
sub Billing_Manager{
		
		&Print_Page(&Billing_Form);
}
#==========================================================
sub View_Billing_Report{
my($Out, @Lines);

	print "Content-type: text/html\n\n";

	if ($Param{'File'} == 1) {
				$File=$Global{'Billing_Fees_File'};
	}	
	elsif ($Param{'File'} == 2) {
				$File=$Global{'Billing_Invoice_File'};
	}
	elsif ($Param{'File'} == 3) {
				$File=$Global{'Billing_Report_File'};
	}
	else{
			return 0;
	}

	open(FILE, "$File") or &Exit("Error: Can't open file $File: $!. <br>Please try to create the billing file first."."<BR>Line ". __LINE__ . ", File ". __FILE__);
	@Lines = <FILE>;
	close(FILE);
	$Out=join("<br>", @Lines);

	print "$Out<br>";
	$Out=qq!<center><b><a href="javascript:window.close()">Close This Window</a></b></center><br>!;
	print "$Out<br>";
}
#==========================================================
sub Billing_Form{
my ($Out, $Help);

$Help =&Help_Link("Billing_Manager");
	
   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= localtime( time );
   $mon++;

	$Month="";
	for $x(1..12) {
		if ($x == $mon) {
			$Month.=qq!<option value="$x" selected>$x!;
		}
		else{
			$Month.=qq!<option value="$x">$x!;
		}
	}

	$Start_Day="";
	for $x(1..31) {
		if ($x == 1) {
			$Start_Day.=qq!<option value="$x" selected>$x!;
		}
		else{
			$Start_Day.=qq!<option value="$x">$x!;
		}
	}

	$End_Day="";
	for $x(1..31) {
		if ($x == 31) {
			$End_Day.=qq!<option value="$x" selected>$x!;
		}
		else{
			$End_Day.=qq!<option value="$x">$x!;
		}
	}

	$Year="";
	for $x(100..120) {
			$Y=$x+1900;
			if ($x == $year) {
					$Year.=qq!<option value="$Y" selected>$Y!;
			}
			else{
					$Year.=qq!<option value="$Y">$Y!;
			}
	}
if ($Global{'Skip_Zero_Balance_Accounts'} eq "YES") {$Skip_Zero_Balance_Accounts="checked";}else {$Skip_Zero_Balance_Accounts="";}

$Count=&Get_Archived_Items_Count;

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Create_Billing_File">

  <div align="center">
    <center>

    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Billing
                  System</font></b></p>
                </td>

				<td width="192">
                  <p align="center">
				  
				  $Help

                </td>
              </tr>
            </table>
            </center>
          </div>

        </td>
      </tr>

      <tr>
        <td width="100%"  bgcolor="#B6DEDC" align="left" height="30">
		 $Global{'G1_Bullet'} <A href="$Script_URL?action=Merchant_Account_Setup"><b><font size="3">Merchant Account Setup</font></b></a><br>
	  	 $Global{'G1_Bullet'} <A href="$Script_URL?action=Setup_Billing_Fields"><b><font size="3">Billing System Configuration</font></b></a><br>
	  	 $Global{'G1_Bullet'} <A href="$Script_URL?action=Manage_Accounts"><b><font size="3">Manage Accounts</font></b></a><br>

		 $Global{'G1_Bullet'} <A  HREF="#" onClick="window.open('$Script_URL?action=View_Billing_Report&File=1','View_Billing_Report','WIDTH=620,HEIGHT=400,scrollbars=yes,resizable=yes,left=50,top=50,screenX=150,screenY=100');return false"><b><font size="3">View Billing File</font></b></A><br>
		</td>
      </tr>

	  <tr>
        <td width="100%"  bgcolor="#B6DEDC" align="center">
		<p align="center">
				<b>Create Billing Files</b>
		</p>
          <p align="left">Create billing file for batch processing using your merchant account or billing system.<br> The file is a 
		  comma separated values format that can be viewed and edited with any spreedsheet program like Excel or MS Word .<br>
		   Please specify the start and end date for the billing period.
		  <br>

		<p>          
		  <div align="center">
            <center>
            <table border="1" width="80%" height="148" cellpadding="3" bordercolorlight="#808000" bordercolordark="#C0C0C0">
              <tr>
                <td width="100%" colspan="3" align="center" height="19" bgcolor="#000080">
                  <p align="center"><b><font color="#00FFFF">Billing Period Start Date</font></b></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#E1E1C4" height="21"><b><font color="#000000">day</font></b></td>
                <td align="center" bgcolor="#E1E1C4" height="21"><b><font color="#000000">month</font></b></td>
                <td align="center" bgcolor="#E1E1C4" height="21"><b><font color="#000000">year</font></b></td>
              </tr>
              <tr>
                <td height="21" align="center">
				<select size="1" name="Start_Day">
                $Start_Day
				  </select></td>

                <td height="21" align="center">
				<select size="1" name="Start_Month">
				$Month
                  </select>
				  </td>

                <td height="21" align="center">
				<select size="1" name="Start_Year">
				$Year
                  </select>
				  </td>
              </tr>
              <tr>
                <td width="100%" colspan="3" align="center" height="21" bgcolor="#808000">
                  <p align="center"><b><font color="#FFFFFF">Billing Period End Date</font></b></td>
              </tr>
              <tr>
                <td height="21" align="center" bgcolor="#E1E1C4"><b><font color="#000000">day</font></b></td>
                <td height="21" align="center" bgcolor="#E1E1C4"><b><font color="#000000">month</font></b></td>
                <td height="21" align="center" bgcolor="#E1E1C4"><b><font color="#000000">year</font></b></td>
              </tr>
              <tr>
                <td height="21" align="center">
				<select size="1" name="End_Date">
				$End_Day
                  </select>
				  </td>
                <td height="21" align="center">
				<select size="1" name="End_Month">
				$Month
                  </select>
				  </td>
                <td height="21" align="center">
				<select size="1" name="End_Year">
				$Year
                  </select>
				  </td>
              </tr>
            </table>
            </center>
          </div>
          <p align="left">
		  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		   <input type="checkbox" name="Skip_Zero_Balance_Accounts" value="YES" $Skip_Zero_Balance_Accounts>
		   Skip accounts that has <b>credit</b> balance of zero and up (These accounts that have no balance due).
		  <br>
        </td>
      </tr>
	  <tr>
        <td width="100%"  bgcolor="#B6DEDC">
          <p align="center">
		  <input type="submit" value="Create Billing File">
		  <input type="reset" value="Reset">&nbsp;
		  <input onclick="history.go(-1);" type="button" value="Cancel">
		  <br><br>
		  </td>
      </tr>

            </table>
            </center>
          </div>
        </td>
</form>
	  </tr>
    </table>
    </center>
  </div>

HTML
	return $Out;

}
#==========================================================
sub Save_Setup_Billing_Fields{
my (%data, $Fileds, $Count);

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	#$data{'Announcements_Form'}=$Param{'Announcements_Form'};
	$data{'Billing_Custom_Filed_1'} =$Param{'Billing_Custom_Filed_1'};
	$data{'Billing_Custom_Filed_2'} =$Param{'Billing_Custom_Filed_2'};
	$data{'Billing_Custom_Filed_3'} =$Param{'Billing_Custom_Filed_3'};
	$data{'Billing_Custom_Filed_4'} =$Param{'Billing_Custom_Filed_4'};
	$data{'Billing_Custom_Filed_5'} =$Param{'Billing_Custom_Filed_5'};

	$Param{'Billing_Delimiting'}=~ s/\"/&quot\;/;	
	$data{'Billing_Delimiting'}=$Param{'Billing_Delimiting'};
	
	$Param{'Billing_Encapsulation'}=~ s/\"/&quot\;/;
	$data{'Billing_Encapsulation'}=$Param{'Billing_Encapsulation'};
	
	$data{'Billing_Fields_Order'}="";
	for $Count(1..27) {
		$data{'Billing_Fields_Order'} .="$Param{$Count}:";
	}
	$data{'Billing_Fields_Order'}=~ s/\:$//;

	untie %data;
	undef %data;

	&Admin_Msg("Saved", "<br><center>Billing system configuration saved</center><br>", 1);
}
#==========================================================
sub Setup_Billing_Fields{

	&Print_Page(&Setup_Billing_Fields_Form);

}
#==========================================================
sub Setup_Billing_Fields_Form{
my ($Out, $Help);
my(@Fileds, %Fields);
my($Field, $Count, $x, $y);

	$Help =&Help_Link("Setup_Billing_Fields");

	@Fileds=split(":", $Global{'Billing_Fields_Order'});

	for $x(0..$#Fileds) {
		$y=$x+1;
		$Field = qq!<select name=$y size=1>\n!;
		for $Count(0..27) {
			if ($Count == 0) {$Value="Execlude";} else {$Value=$Count;}
			if ($Count == $Fileds[$x]) {
					$Field .= qq!<option value="$Count" selected>$Value</option>\n!;
			}
			else{
					$Field .= qq!<option value="$Count">$Value</option>\n!;
			}
		}
		$Field .=qq!</select>\n!;
		$Fields{$y}=$Field;
	}

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type=hidden name="action" value="Save_Setup_Billing_Fields">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Billing
                  System Configuration</font></b></p>
                </td>
                <td width="192">
                  <p align="center">
				  
				  $Help

				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC" align="center">
          &nbsp;
          <div align="center">
            <center>
          <table border="1" width="95%" cellspacing="1" cellpadding="4">
            <tr>
              <td width="100%">Please choose the order in which each filed
                should appear in the credit card batch processing file according
                to your merchant account or billing company configuration.</td>
            </tr>
          </table>
            </center>
          </div>
          
          <div align="center">
            <center>
            <table border="1" width="95%" cellspacing="0" cellpadding="3">
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC"><b>&nbsp;#</b></td>
                <td width="20%" align="center" bgcolor="#B6DEDC" nowrap><b>Filed
                  Name</b></td>
                <td width="40%" align="center" bgcolor="#B6DEDC"><b>Order</b></td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">1</td>
                <td width="20%" nowrap>User ID</td>
                <td width="40%">$Fields{'1'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">2</td>
                <td width="20%" nowrap>Balance Due</td>
                <td width="40%">$Fields{'2'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">3</td>
                <td width="20%" nowrap>First name</td>
                <td width="40%">$Fields{'3'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">4</td>
                <td width="20%" nowrap>M.I.</td>
                <td width="40%">$Fields{'4'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">5</td>
                <td width="20%" nowrap>Last name</td>
                <td width="40%">$Fields{'5'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">6</td>
                <td width="20%" nowrap>Company</td>
                <td width="40%">$Fields{'6'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">7</td>
                <td width="20%" nowrap>Street Address</td>
                <td width="40%">$Fields{'7'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">8</td>
                <td width="20%" nowrap>City</td>
                <td width="40%">$Fields{'8'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">9</td>
                <td width="20%" nowrap>State</td>
                <td width="40%">$Fields{'9'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">10</td>
                <td width="20%" nowrap>Zip</td>
                <td width="40%">$Fields{'10'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">11</td>
                <td width="20%" nowrap>Country</td>
                <td width="40%">$Fields{'11'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">12</td>
                <td width="20%" nowrap>Phone</td>
                <td width="40%">$Fields{'12'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">13</td>
                <td width="20%" nowrap>Fax</td>
                <td width="40%">$Fields{'13'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">14</td>
                <td width="20%" nowrap>Email</td>
                <td width="40%">$Fields{'14'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">15</td>
                <td width="20%" nowrap>Credit Card Number</td>
                <td width="40%">$Fields{'15'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">16</td>
                <td width="20%" nowrap>Name on card</td>
                <td width="40%">$Fields{'16'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">17</td>
                <td width="20%" nowrap>Expiration Date</td>
                <td width="40%">$Fields{'17'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">18</td>
                <td width="20%" nowrap>Billing Street Address</td>
                <td width="40%">$Fields{'18'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">19</td>
                <td width="20%" nowrap>Billing City</td>
                <td width="40%">$Fields{'19'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">20</td>
                <td width="20%" nowrap>Billing State</td>
                <td width="40%">$Fields{'20'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">21</td>
                <td width="20%" nowrap>Billing Zip</td>
                <td width="40%">$Fields{'21'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">22</td>
                <td width="20%" nowrap>Billing Country</td>
                <td width="40%">$Fields{'22'}</td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">23</td>
                <td width="20%" nowrap>Custom Filed 1</td>
                <td width="40%">$Fields{'23'}<input type="text" name="Billing_Custom_Filed_1" size="25" value="$Global{'Billing_Custom_Filed_1'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">24</td>
                <td width="20%" nowrap>Custom Filed 2</td>
                <td width="40%">$Fields{'24'}<input type="text" name="Billing_Custom_Filed_2" size="25" value="$Global{'Billing_Custom_Filed_2'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">25</td>
                <td width="20%" nowrap>Custom Filed 3</td>
                <td width="40%">$Fields{'25'}<input type="text" name="Billing_Custom_Filed_3" size="25" value="$Global{'Billing_Custom_Filed_3'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">26</td>
                <td width="20%" nowrap>Custom Filed 4</td>
                <td width="40%">$Fields{'26'}<input type="text" name="Billing_Custom_Filed_4" size="25" value="$Global{'Billing_Custom_Filed_4'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="10%" align="center" bgcolor="#B6DEDC">27</td>
                <td width="20%" nowrap>Custom Filed 5</td>
                <td width="40%">$Fields{'27'}<input type="text" name="Billing_Custom_Filed_5" size="25" value="$Global{'Billing_Custom_Filed_5'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="30%" colspan="2"><b>The delimiting character that
                  separates the fields</b></td>
                <td width="40%"><input type="text" name="Billing_Delimiting" size="5" value="$Global{'Billing_Delimiting'}" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="30%" colspan="2"><b>The encapsulation character that
                  encloses all of the data within a field</b></td>
                <td width="40%"><input type="text" name="Billing_Encapsulation" size="5" value="$Global{'Billing_Encapsulation'}" onFocus="select();"></td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes" name="Save_Changes">
 <input type="reset" value="Clear Form">&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Check_Admin_Authentication{
my ($Out);

	if ($Global{'Admin_UserID'} eq $Cookies{'Admin_UserID'} &&
			$Global{'Admin_Password'} eq $Cookies{'Admin_Password'}) {
			#Ok login to the system
			&Set_Cookies("Admin_UserID", $Cookies{'Admin_UserID'}, "");
			&Set_Cookies("Admin_Password", $Cookies{'Admin_Password'}, "");
	}
	elsif ($Global{'Admin_UserID'} eq $Param{'Admin_UserID'} &&
			$Global{'Admin_Password'} eq $Param{'Admin_Password'}) {
			#Ok login to the system
			&Set_Cookies("Admin_UserID", $Param{'Admin_UserID'}, "");
			&Set_Cookies("Admin_Password", $Param{'Admin_Password'}, "");
	}
	else{
			print "Content-type: text/html\n\n";
			$Out=&Admin_Login_Form;
			print "$Out";
			exit 0;
	}
}
#==========================================================
sub Admin_Login_Form{
my ($Out);

$Out=<<HTML;
<html>
<head>
<title>Mewsoft Auction Administration Login</title>
</head>

<body>

<form name="User_Login" method="POST" action="$Script_URL">
<div align="center">
  <center>

<table border="0" width="352" bgcolor="#005329" >
  <tr>
    <td width="352" align="center" height="19"><b><font color="#FFFF00" face="Times New Roman">Mewsoft
      Auction Administration</font></b><b><font color="#FFFF00" face="Times New Roman">
      Login</font></b>
    </td>
  </tr>
  
  </center>
  
  <tr>
    <td width="347">
      <div align="center">
      <table border="0" width="339" cellspacing="0" cellpadding="0" bgcolor="#E1E1C4" height="127">
        <tr>
          <td valign="middle" align="center" bgcolor="#FFFFD9" height="100" width="337">
          
          <p align="left"><b><font color="#FF0000">&nbsp;Please enter your login information</font></b></p>
          <table border="0" width="100%" cellpadding="4">
            <tr>
              <td width="45%" align="right"><b><font color="#000080">Admin User ID:</font></b></td>
              <td width="55%" align="left"><input type="text" name="Admin_UserID" size="20"></td>
            </tr>
            <tr>
              <td width="45%" align="right"><b><font color="#000080">Admin Password:</font></b></td>
              <td width="55%" align="left"><input type="password" name="Admin_Password" size="20"></td>
            </tr>
          </table>
          
          </td>
        </tr>
  <center>

        <center>
        <tr>
          <td valign="middle" align="center" bgcolor="#FFFFD9" height="27" width="337">
          
                <p align="center">
                <input type="submit" value="Login" name="Admin_Login">
          
          </td>
        </tr>
      </table>
        </center>
      </div>
    </td>
  </tr>
</table>
</div>
</form>

<script language="JavaScript">
<!--
document.User_Login.Admin_UserID.focus();
// -->
</script>

</body>
</html>
HTML
	return $Out;
}
#==========================================================
sub Load_Accounts{

		if (!$Param{'Group'}) {$Param{'Group'}="A";}

		&Print_Page(&Load_Accounts_Form($Param{'Group'}));

}
#==========================================================
sub Load_Accounts_Form{
my($Group)=shift;
my ($Out, $Help);
my($Count, @Users, @BGColor);
my(%Balance, %Balancex, $Curr);

	$Help =&Help_Link("Users_Manager");

	undef @Users;
	@Users = &Get_Users_Group($Group);
	$Count = @Users;
	$Curr = $Global{'Currency_Symbol'};
	#------------------------------------------------------
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}
	$Last_Page=int($Count / $Global{'Admin_Users_Per_Page'});
	if (($Count % $Global{'Admin_Users_Per_Page'})) { $Last_Page++; }
	$Current_Page = $Param{'Page'};
	$Next_Page=($Current_Page + 1);
	$Previous_Page = ($Current_Page - 1);
	if ($Next_Page > $Last_Page) {$Next_Page = $Last_Page;}
	$Start = ($Current_Page -1) * $Global{'Admin_Users_Per_Page'};
	$End = $Start + $Global{'Admin_Users_Per_Page'};
	if ($End > $Count) {$End = $Count;}

	$Temp = qq!$Script_URL?action=Load_Accounts&Page=$Next_Page&Group=$Param{'Group'}!;
	$Next_Page_Link = qq!<A HREF="$Temp">Next Page</A>!;
	$Temp = qq!$Script_URL?action=Load_Accounts&Page=$Previous_Page&Group=$Param{'Group'}!;
	$Previous_Page_Link = qq!<A HREF="$Temp">Previous Page</A>!;
	#------------------------------------------------------
	&DB_Exist($Global{'Balance_File'});
	tie %Balancex, "DB_File", $Global{'Balance_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%Balance = %Balancex;
	untie %Balancex;
	undef %Balancex;
	#------------------------------------------------------
	$BGColor[0] = "#FFF0E1";	$BGColor[1] = "#D9ECEC"; $Users_Row = "";

	for $Counter($Start..$End-1) {
			$Counter1 = $Counter+1;
			$BGColor = $BGColor[int($Counter %2)];
			$User = $Users[$Counter]{'User_ID'};
			if (!$Balance{$User}) {$Balance{$User} = 0;}
			$Balance = &Format_Decimal($Balance{$User});
			if ($Balance < 0) {$Balance =qq!<font color="red"> <b>-!.$Curr. abs($Balance).qq!</b></font>!;}else{$Balance = $Curr. $Balance;}
			
			$Edit_Account =qq!<A HREF="$Global{'Auction_Script_URL'}?action=Account_Manager&Remember_login=YES&User_ID=$Users[$Counter]{'User_ID'}&Password=$Users[$Counter]{'Password'}" TARGET="_BLANK"><B>Edit</B></A>!;
			if ($Demo) {$Edit_Account ="Edit (Disabled!)";}

			$Users_Row .= qq! <tr width = "100%">
											<td width="5%" bgcolor="$BGColor">$Counter1</td>
											<td width="15%" bgcolor="$BGColor"><a href="mailto: $Users[$Counter]{'EmailAddress'}"><b>$User</b></a></td>
											<td width="15%" bgcolor="$BGColor" align="center">$Balance</td>
											<td width="15%" bgcolor="$BGColor" align="center">$Curr<input type="text" name="Credit_Account:$User" value="" size="5"></td>
											<td width="15%" bgcolor="$BGColor" align="center">$Curr<input type="text" name="Debit_Account:$User" value="" size="5"></td>
											<td width="15%" bgcolor="$BGColor" align="center">$Edit_Account</td>
											<td width="20%" bgcolor="$BGColor">$Users[$Counter]{'Street1'}, $Users[$Counter]{'Street2'}, $Users[$Counter]{'City'}, $Users[$Counter]{'Stat'}, $Users[$Counter]{'Country'}</td>
											  </tr>!;
	}
	#------------------------------------------------------

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Accounts_Balances">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Users
                  Manager</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">
				  
				  $Help
				  
				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
		<b>The total number of registered users in this group is $Count</b>
		</td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
	
<table border="0" width="100%" cellspacing="1" cellpadding="2">
  <tr>
    <td width="5%" bgcolor="#E1E1C4">
      <p align="center">#</td>
    <td width="15%" bgcolor="#E1E1C4">
      <p align="center"><b>User/Email</b></td>
    <td width="20%" bgcolor="#E1E1C4"><p align="center"><b>Balance</b></td>
    <td width="15%" bgcolor="#E1E1C4"><p align="center"><b>Credit</b></td>
    <td width="15%" bgcolor="#E1E1C4"><p align="center"><b>Debit</b></td>
    <td width="15%" bgcolor="#E1E1C4"><p align="center"><b>Action</b></td>
    <td width="10%" bgcolor="#E1E1C4"><p align="center"><b>Address</b></td>
  </tr>
  
  $Users_Row

</table>
		</td>
      </tr>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC" Align="right">
		Showing accounts page $Current_Page of $Last_Page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			$Previous_Page_Link&nbsp;&nbsp; 
			$Next_Page_Link
		  </td>
      </tr>

      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
		  <p align="center">
		  <input type="submit" value="Update Accounts">&nbsp;&nbsp; 
		  <input type="reset" value="Clear Form">&nbsp;&nbsp; 
		  <input onclick="history.go(-1);" type="button" value="Cancel">

		  </td>
      </tr>
    </table>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Save_Accounts_Balances{
my(%Credit, %Debit);

	while (($Key, $Value)=each %Param) {
			if ($Key =~ "Credit_Account:") {
					(undef, $User) = split(":", $Key);
					if (!$Value) {$Value = 0;}
					$Credit{$User} = $Value;
			}

			if ($Key =~ "Debit_Account:") {
					(undef, $User) = split(":", $Key);
					if (!$Value) {$Value = 0;}
					$Debit{$User} = abs($Value) *-1;

			}
	}
	
	&Update_Accounts_Balances(\%Credit, \%Debit);
	
	&Admin_Msg("Updates Saved", "<br><center>Users account updates saved.</center><br>", 1);

}
#==========================================================
sub Manage_Accounts{
		&Print_Page(&Manage_Accounts_Form);
}
#==========================================================
sub Manage_Accounts_Form{
my ($Out, $Help, $Users);

$Help =&Help_Link("Users_Manager");

$Users=&Get_Users_Count;

$Out=<<HTML;
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Account
                  Manager</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">
				  
				  $Help
				  
				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
		<b>The total number of registered accounts is $Users</b>
		</td>
      </tr>

	  <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="left">
<div align="center">
  <center>
  <table border="0" width="100%">
    <tr>
      <td width="6%"  valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Group=[0-9]">#</a></b></td>
      <td width="73%" colspan="11" bgcolor="#E1E1C4">
        <p align="center">
		
		<b>Select Account Group to Load</b>

		</td>
      <td width="7%" bgcolor="#FFCE9D">&nbsp;</td>
    </tr>
    <tr>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=A">A</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=B">B</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=C">C</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=D">D</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=E">E</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=F">F</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=G">G</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=H">H</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=I">I</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=J">J</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=K">K</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=L">L</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=M">M</a></b></td>
    </tr>
    <tr>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=N">N</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=O">O</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=P">P</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=Q">Q</a></b></td>
      <td width="6%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=R">R</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=S">S</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=T">T</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=U">U</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=V">V</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=W">W</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=X">X</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=Y">Y</a></b></td>
      <td width="7%" valign="middle" align="center" bgcolor="#FFCE9D"><b><a href="$Script_URL?action=Load_Accounts&Page=1&Group=Z">Z</a></b></td>
    </tr>
  </table>
  </center>
</div>

		</td>
      </tr>

    <center>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
		 <form method="POST" action="$Script_URL">
		  <p align="center">&nbsp;&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel">
		 </form>
		  </td>
      </tr>
    </table>
    </center>
  </div>
HTML
	return $Out;
}
#==========================================================
sub ASCII_Backup{
my (%data, $CRLF_Key, $dir, %Dir, $file, @files);

	$CRLF_Key="\\n";
	undef %Dir;
	$Dir{$Global{'DataDir'}} =  $Global{'Database_Dir'};
	$Dir{$Global{'ItemsPathDir'}} =  $Global{'ItemsBackupDir'};
	$Dir{$Global{'Mail_Lists_Dir'}} = $Global{'Mail_Lists_Backup_Dir'};
	$Dir{$Global{'Archive_Dir'}} = $Global{'Archive_Backup_Dir'};

	foreach $dir (keys %Dir) {
		opendir(Dir, "$dir");
		@files=();
		foreach $file (  readdir(Dir)  ) {
				push (@files, $file);
		 }

		closedir(Dir);

		foreach $file(@files){
			if($file ne "." && $file ne ".." && $file=~/\.(dat|mail)$/i && !-d "$dir/$file") { 
					open (OUT, ">$Dir{$dir}/$file.txt") 
							or &Exit("Can not open file $Dir{$dir}/$file.txt: $!");

					tie %data, "DB_File", "$dir/$file", O_RDWR | O_CREAT, O_RDONLY
                                         or &Exit("Cannot open database file $dir/$file: $!\n");

					while (($key, $value)=each(%data)) {
							$value=~ s/\n/$CRLF_Key/g;
							print OUT  "$key~===~$value\n";
					}
					close OUT;
					untie %data;
					undef %data;
			}#end if file
		}#end for each file
	}#end for each directory

	&Admin_Msg("ASCII Backup Done", "The ASCII database files has been generated from the current system database. The database files are located under the directory \"data/database\" , these are flat text files, to FTP, do in ASCII mode", 1);

}
#==========================================================
sub Load_ASCII_Backup{
my (%data, $CRLF_Key, $dir, %Dir, $file, @files);
my($Line, $key, $value);

	$CRLF_Key="\\n";
	undef %Dir;
	$Dir{$Global{'Database_Dir'}} =  $Global{'DataDir'};
	$Dir{$Global{'ItemsBackupDir'}} =  $Global{'ItemsPathDir'};
	$Dir{$Global{'Mail_Lists_Backup_Dir'}}=$Global{'Mail_Lists_Dir'};
	$Dir{$Global{'Archive_Backup_Dir'}} = $Global{'Archive_Dir'};

	foreach $dir (keys %Dir) {
		opendir(Dir, "$dir");
		@files=();
		foreach $file (  readdir(Dir)  ) {
				push (@files, $file);
		 }

		closedir(Dir);

		foreach $file(@files){
			if($file ne "." && $file ne ".." && $file=~/\.txt$/i && !-d "$dir/$file") { 
					open (IN, "$dir/$file") 
							or &Exit("Can not open file $dir/$file: $!");

					$file=~ s/\.txt$//;
					unlink "$Dir{$dir}/$file";
					tie %data, "DB_File", "$Dir{$dir}/$file", O_RDWR | O_CREAT
                                         or &Exit("Cannot open database file $Dir{$dir}/$file: $!\n");

					while($Line=<IN>){
							($key, $value)=split("~===~" , $Line);
							$value=~ s/\n$//;
							$value=~ s/\\n/\n/g;
							$data{$key} = $value;
					}
					close IN;
					untie %data;
					undef %data;
			}#end if file
		}#end for each file
	}#end for each directory

	&Admin_Msg("ASCII Database Load Done", "The New system database has been loaded from the ASCII database files. The database files are loaded from the directory \"data/database\". ", 1);
}
#==========================================================
sub Export_Users{
my(%data, %datax, $User_ID, $User);

	&DB_Exist($Global{'RegistrationFile'});
	tie %datax, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%data = %datax;
	untie %datax;
	undef %datax;

	open (FILE, ">$Global{'Export_Dir'}/users.csv") or &Exit("Can not open file $Global{'Export_Dir'}/users.csv: $!");
	$QQ="\"";
	while (($User_ID, $User) = each %data) {
				($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
											$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf ) = split(/\|/, $User);

				($Prefs_ent, $Prefs_hf, $Prefs_hth, $Prefs_mc, $Prefs_shg, $Prefs_spt, $Prefs_bs, $Prefs_pct, $Prefs_en, 
				 $Prefs_pf, $Prefs_sb, $Prefs_tvl, $Gender, $Occupation, $Industry, $Contact_Me) = split(/\:/, $Prf);
				 print FILE "$QQ$UN$QQ,$QQ$PW$QQ,$QQ$FN$QQ,$QQ$MI$QQ,$QQ$LN$QQ,$QQ$CM$QQ,$QQ$S1$QQ,$QQ$S2$QQ,$QQ$CT$QQ,$QQ$ST$QQ,$QQ$Z$QQ,$QQ$CY$QQ,$QQ$PH$QQ,$QQ$EX$QQ,$QQ$FX$QQ,$QQ$EM$QQ,$QQ$PM$QQ,$QQ$NOC$QQ,$QQ$CCN$QQ,$QQ$CTP$QQ,$QQ$EXM$QQ,$QQ$EY$QQ,$QQ$S3$QQ,$QQ$S4$QQ,$QQ$CT1$QQ,$QQ$ST1$QQ,$QQ$Z1$QQ,$QQ$CY1$QQ,$QQ$Prefs_ent$QQ,$QQ$Prefs_hf$QQ,$QQ$Prefs_hth$QQ,$QQ$Prefs_mc$QQ,$QQ$Prefs_shg$QQ,$QQ$Prefs_spt$QQ,$QQ$Prefs_bs$QQ,$QQ$Prefs_pct$QQ,$QQ$Prefs_en$QQ,$QQ$Prefs_pf$QQ,$QQ$Prefs_sb$QQ,$QQ$Prefs_tvl$QQ,$QQ$Gender$QQ,$QQ$Occupation$QQ,$QQ$Industry$QQ,$QQ$Contact_Me$QQ\n";
	}

	close FILE
	
	&Admin_Msg("Users database exported", "The users database has been exported to a users.csv file under the export directory. ", 1);
}
#==========================================================
sub Export_Maillists{
my($dir, $file, @files);

		$dir = $Global{'Mail_Lists_Dir'};

		opendir(Dir, "$dir");
		@files=();
		foreach $file (readdir(Dir)) {
				push (@files, $file);
		}

		closedir(Dir);

		foreach $file(@files){
				if($file ne "." && $file ne ".." && $file=~ m/\.mail$/i && !-d "$dir/$file") { 
							&DB_Exist("$dir/$file");
							tie %data, "DB_File", "$dir/$file", O_RDONLY
												 or &Exit("Cannot open database file $dir/$file: $!\n");
							@List = sort keys %data;
							untie %data;

							$file=~ s/\.mail$//;
							$file .= "\.csv";
							open (OUT, ">$Global{'Export_Dir'}/$file")
									or &Exit("Can not open file $Global{'Export_Dir'}/$file: $!");

							foreach  $Address(@List){
									print OUT "$Address\n";
							}

							close OUT;
			}
	}

	&Admin_Msg("Users mail lists database exported", "The users mailing lists database has been exported to a regusers.csv and list_id_*.csv files under the secure directory. ", 1);

}
#==========================================================
sub Export_Balance{
my(%data, %datax, $User_ID, $Balance, $QQ);
my(%Balance, %Balancex);

	&DB_Exist($Global{'Balance_File'});
	tie %Balancex, "DB_File", $Global{'Balance_File'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'Balance_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	%Balance = %Balancex;
	untie %Balancex;
	undef %Balancex;

	open (FILE, ">$Global{'Export_Dir'}/balance.csv") or &Exit("Can not open file $Global{'Export_Dir'}/balance.csv: $!");
	$QQ = "\"";
	while (($User_ID, $Balance) = each %Balance) {
				 print FILE "$QQ$User_ID$QQ,$QQ$Balance$QQ\n";
	}

	close FILE
	
	&Admin_Msg("Account balance database exported", "The current accounts balance database has been exported to a balance.csv file under the export directory. ", 1);
}
#==========================================================
sub Database_Maintenance{

	@Dir = ("$Global{'DataDir'}", "$Global{'ItemsPathDir'}", "$Global{'Archive_Dir'}", "$Global{'Database_Dir'}", "$Global{'Mail_Lists_Dir'}");
	
	print "Content-type: text/html\n\n"; 
	print "<B>Optimizing database</B><br><br>";
	foreach $dir (@Dir) {
		opendir(Dir, "$dir");
		@files=();
		foreach $file (readdir(Dir)) {
				push (@files, $file);
		 }

		closedir(Dir);

		foreach $file(@files){
			if($file ne "." && $file ne ".." && $file=~/\.(dat|mail)$/i && !-d "$dir/$file") { 
					print "Optimizing file $dir/$file...";
					$Temp_File = "$dir/$file"."\.tmp";
					
					undef %data;
					undef %new_data;

					unlink($Temp_File);

					if (!&Lock($Temp_File)) {&Exit("Cannot Lock database file $Temp_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
					tie %new_data, "DB_File", "$Temp_File"
											or &Exit("Cannot open database file $Temp_File: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
					tie %data, "DB_File", "$dir/$file", O_RDONLY
										or &Exit("Cannot open database file $dir/$file: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
					$x = 0; print "<br>";
					while (($key, $value) = each(%data)) {
							$new_data{$key} = $value;
							print "."; $x++;
							if (!($x % 100)) {print "<br>";}
					}

					untie %new_data;
					&Unlock($Temp_File);
					
					unlink("$dir/$file");
					rename($Temp_File, "$dir/$file");
					unlink($Temp_File);

					untie %data;
					print "<BR><B>  Done.</B><BR><BR>";
			}#end if file
		}#end for each file
	}#end for each directory
	
	print qq!<center><b><a href="javascript:window.close()">Close This Window</a></b></center><br>\n!;
	#&Admin_Msg("Done Maintenance", "All  database file has been optimized by eliminating wasted disk space and removing empty rows.", 1);
}
#==========================================================
sub Database_Manager{

	&Print_Page(&Database_Manager_Form);

}
#==========================================================
sub Database_Manager_Form{
my $Out;
my($Help);

$Help =&Help_Link("Database_Manager");

$Out=<<HTML;

<form method="POST" action="$Script_URL">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="8">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Database
                  Manager</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">
				  
				  $Help
				  
				  </p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

      <tr>
        <td width="100%" align="center" bgcolor="#B6DEDC">
          <font size="4" color="#FF0000"><b>Database Exporter</b></td>
      </tr>

      <tr>
        <td width="100%" align="left" bgcolor="#B6DEDC">
			The database exporter will export the selected database to a comma separated values file which can be opened by any spreedsheet program like  Excel or MS Word. The files will be named *.csv. The exported files will be located under the export directory.
         </td>
      </tr>

      <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=Export_Users">Export users database to a CSV file (users.csv)</a></b>
		</td>
      </tr>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=Export_Maillists">Export mail lists database to a CSV files (regusers.csv, list_id_*.csv)</a></b>
		</td>
      </tr>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=Export_Balance">Export current accounts balance database to a CSV files (balance.csv)</a></b>
		</td>
      </tr>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b><font color="#FF0000" size="4">Warning!<br>
          </font></b>These tools are very destructive if you did not use it
          correctly and know what you are doing. Make backup copy first of your
          original program database files before attempting to load the new
          database files to the system.</td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=ASCII_Backup">Make
          ASCII Backup of The System Database</a> <font color="#FF0000" size="2"><sup>safe</sup></font></b></td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=Load_ASCII_Backup">Load&nbsp;
          System Database From The ASCII Backup</a><font size="4" color="#FF0000">!</font>
          <font size="2" color="#FF0000"><sup>be careful</sup></font></b></td>
      </tr>

      <tr>
        <td width="100%" align="center" bgcolor="#B6DEDC">
          <font size="4" color="#FF0000"><b>Database Maintanance</b></td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC">
		<b>$Global{'G1_Bullet'}<a href="$Script_URL?action=Database_Maintenance">
		<A  HREF="#" onClick="window.open('$Script_URL?action=Database_Maintenance','Mewsoft_Auction','WIDTH=600,HEIGHT=400,scrollbars=yes,resizable=yes,left=0,top=0,screenX=0,screenY=0');return false">
		Optimize Database Files and Eliminate Any Wasted Space
		</b></a>
		</td>
      </tr>

      <tr>
        <td width="100%"bgcolor="#B6DEDC">
          <p align="center"><input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML

	return $Out;
}
#==========================================================
sub About{

		$Out=&Msgs("About Mewsoft Auction Software", "<br>Program Name    : Mewsoft Auction<br>Program Author   : Elsheshtawy, Ahmed A.<br>Home Page          : http://www.mewsoft.com<br><br><center>Copyright&copy; 2001 Mewsoft. All rights reserved.</center><br><center>Nullified By: TNO</center><br>",1);
		&Print_Page($Out);	
}
#==========================================================
sub Help{
		
		#$Subject=$Param{'Subject'};

}
#==========================================================
sub Help_Link{
my($Subject, $Color)=@_;
my($Out);

$Width= $Global{'Admin_Help_Window_Width'};
$Height= $Global{'Admin_Help_Window_Height'};

if ($Color) { # do not change link color
$Out=<<HTML;
<A  HREF="#" onClick="window.open('$Global{'Help_URL'}?action=Help&Subject=$Subject&W=$Width&H=$Height','Mewsoft_Software_Help','WIDTH=$Width,HEIGHT=$Height,scrollbars=yes,resizable=yes,left=0,top=0,screenX=0,screenY=0');return false"><b>Help</b></A>	
HTML
}
else{
$Out=<<HTML;
<A  HREF="#" onClick="window.open('$Global{'Help_URL'}?action=Help&Subject=$Subject&W=$Width&H=$Height','Mewsoft_Software_Help','WIDTH=$Width,HEIGHT=$Height,scrollbars=yes,resizable=yes,left=0,top=0,screenX=0,screenY=0');return false"><font color="yellow"><b>Help</b></font></A>
HTML
}

	return $Out;
}
#==========================================================
sub General_Classes{
		&Print_Page(&General_Classes_Form);
}
#==========================================================
sub Save_General_Classes{
my (%data);

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

    $Param{'Message_Form'}=~ s/\cM//g;
	$data{'Message_Form'}=$Param{'Message_Form'};

	$Param{'Error_Form'}=~ s/\cM//g;
	$data{'Error_Form'}=$Param{'Error_Form'};

	$Param{'Header'}=~ s/\cM//g;
	$data{'Header'}=$Param{'Header'};

	$Param{'Footer'}=~ s/\cM//g;
	$data{'Footer'}=$Param{'Footer'};

	$Param{'Top_Navigation'}=~ s/\cM//g;
	$data{'Top_Navigation'}=$Param{'Top_Navigation'};

	$Param{'Bottom_Navigation'}=~ s/\cM//g;
	$data{'Bottom_Navigation'}=$Param{'Bottom_Navigation'};

	$Param{'General'}=~ s/\cM//g;
	$data{'General'}=$Param{'General'};

	$Param{'Extra'}=~ s/\cM//g;
	$data{'Extra'}=$Param{'Extra'};

	$Param{'Side_Navigation'}=~ s/\cM//g;
	$data{'Side_Navigation'}=$Param{'Side_Navigation'};

	$Param{'View_Alert_table'}=~ s/\cM//g;
	$data{'View_Alert_table'}=$Param{'View_Alert_Table'};
	
	$Param{'Announcements_Form'}=~ s/\cM//g;
	$data{'Announcements_Form'}=$Param{'Announcements_Form'};

	$Param{'Search_Category_Form'}=~ s/\cM//g;
	$data{'Search_Category_Form'}=$Param{'Search_Category_Form'};

	$Param{'Search_Main_Form'}=~ s/\cM//g;
	$data{'Search_Main_Form'}=$Param{'Search_Main_Form'};
		
	untie %data;
	undef %data;

	&Admin_Msg("Saved", "General Classes successfully saved.", 1);

}
#==========================================================
sub General_Classes_Form{
my ($Out);
my ($Help);

$Help =&Help_Link("General_Classes");

$Message_Form=&Encode_HTML($Global{'Message_Form'});
$Error_Form=&Encode_HTML($Global{'Error_Form'});
$Header=&Encode_HTML( $Global{'Header'});
$Footer=&Encode_HTML( $Global{'Footer'});
$Top_Navigation=&Encode_HTML( $Global{'Top_Navigation'});
$Bottom_Navigation=&Encode_HTML( $Global{'Bottom_Navigation'} );
$Side_Navigation=&Encode_HTML( $Global{'Side_Navigation'} );
$Announcements_Form=&Encode_HTML( $Global{'Announcements_Form'});
$General=&Encode_HTML( $Global{'General'});
$Extra=&Encode_HTML( $Global{'Extra'});

$Search_Category_Form=&Encode_HTML( $Global{'Search_Category_Form'});
$Search_Main_Form=&Encode_HTML( $Global{'Search_Main_Form'});

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_General_Classes">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">General
                  Classes</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC" valign="top" colspan="2">Please
          note that you may use any HTML or JS in any of these templates, but you
          can not use perl or any other programming code.</td>
      </tr>
      <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Messages Template.</b><br>
          <br>
          This template is used in many points in the program and is used to
          inform the user short messages like missing information in the
          registration or invalid bid. The message form is inserted inside the
          templates, so you do not need HTML header and footer for this
          template.<br>
        </td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Message_Form" cols="65" onFocus="select();">$Message_Form</textarea></td>
      </tr>
      <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>Error
          Messages Template.<br>
          <br>
          </b>This template is used only to show critical&nbsp; program error
          like file not found, configuration errors.</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Error_Form" cols="65" onFocus="select();">$Error_Form</textarea></td>
      </tr>
      <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Template Header Class.</b><br>
          <br>
          <br>
          <br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Header--&gt;</b></td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Header" cols="65" onFocus="select();">$Header</textarea></td>
      </tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Template Footer Class<br>
          <br>
          </b><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Footer--&gt;</b></td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Footer" cols="65" onFocus="select();">$Footer</textarea></td>
      </tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Template Top Navigation Class</b>
          <p><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Top_Navigation--&gt;</b></p>
        </td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Top_Navigation" cols="65" onFocus="select();">$Top_Navigation</textarea></td>
      </tr>
      <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Template Bottom Navigation Class</b>
          <p><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Bottom_Navigation--&gt;</b></p>
          &nbsp;</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Bottom_Navigation" cols="65" onFocus="select();">$Bottom_Navigation</textarea></td>
      </tr>
      <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Template Side Navigation Class</b>
          <p><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Side_Navigation--&gt;</b></p>
          &nbsp;</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Side_Navigation" cols="65" onFocus="select();">$Side_Navigation</textarea></td>
      </tr>
      <tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>General
          Class<br>
          <br>
          </b><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::General--&gt;</b></td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="General" cols="65" onFocus="select();">$General</textarea></td>
      </tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>Search Category Form Class<br>
          <br></b><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Search_Category:XX--&gt;</b>. Where XX is the text box width.</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="10" name="Search_Category_Form" cols="65" onFocus="select();">$Search_Category_Form</textarea></td>
      </tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>Main Search Form Class<br>
          <br></b><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Search_Main:XX--&gt;</b>. Where XX is the text box width.</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="10" name="Search_Main_Form" cols="65" onFocus="select();">$Search_Main_Form</textarea></td>
      </tr>

	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>
          Extra Class<br>
          <br>
          </b><br>
          Insert the CLASS in your templates:<br>
          <b>&lt;!--CLASS::Extra--&gt;</b></td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Extra" cols="65" onFocus="select();">$Extra</textarea></td>
      </tr>
	  
		<td width="25%" height="19" bgcolor="#B6DEDC" valign="top"><b>
          Announcements Form<br>
          </b>
          <p>This Form is used to display the Announcements on the Announcements page.</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">
		<textarea rows="15" name="Announcements_Form" cols="65" onFocus="select();">$Announcements_Form</textarea></td>
      </tr>


	  <tr>
        <td width="25%" height="19" bgcolor="#B6DEDC">&nbsp;</td>
        <td width="75%" height="19" bgcolor="#B6DEDC">&nbsp;</td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes">
		  <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Upgrade{
my($CGI_Directory, $HTML_Directory, $Var);
	
	$CGI_Directory = $Global{'BaseDir'};
	$CGI_Directory =~ s/\\$//g;
	$CGI_Directory =~ s/\/$//g;

	$HTML_Directory = $Global{'HtmlDir'};
	$HTML_Directory =~ s/|\\$//g;
	$HTML_Directory =~ s/\/$//g;

	$Var = qq!Domain_Name=Data Submission Blocked By: TNO&CGI_Directory=Data Submission Blocked By: TNO&HTML_Directory=Data Submission Blocked By: TNO&CGI_Directory_URL=Data Submission Blocked By: TNO&HTML_Directory_URL=Data Submission Blocked By: TNO!;
	$Var =~ s/ /%20/g;

	print qq!Location: $Global{'Mewsoft_Auto_Installer'}?$Var\n\n!; 
	exit 0;
}
#==========================================================
sub Get_Upgrade_Form{
my ($Out, $File_Info, $CWD);
	
$Out=<<HTML;
<form method="POST" action="$Global{'Upgrade_URL'}">
<input type="hidden" name="action" value="Upgrade">
<input type="hidden" name="Software" value="Mewsoft_Auction">

<table border="0" width="100%" cellpadding="6" bgcolor="#DFFFE8">
  <tr>
    <td width="100%" bgcolor="#003046">
      <p align="center"><b><font size="5" face="Times New Roman" color="#FFFFFF">Upgrade</font></b></td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#FFFFD9">The upgrade process is done automatically. This includes configuring perl path, setting cgi and html directories, and changing permissions for non windows systems.
	Please enter your server login
      information, Perl path, CGI directory, Html Directory,&nbsp; and your Mewsoft License Number for the
      product. </td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#DFFFE8">
      <div align="center">
        <center>
        <table border="0" width="550" bordercolorlight="#008000" bordercolordark="#003046" cellpadding="4">
          <tr>
            <td width="500" bgcolor="#003046" colspan="2">
              <p align="center"><font size="4" face="Tahoma" color="#FFFFFF">Licensed
              Customer Login</font></td>
          </tr>
          <tr>
            <td width="126" bgcolor="#FFFFD9">Domain Name</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="text" name="Domain" size="40" value="Data Submission Blocked By: TNO" onFocus="select();"></td>
          </tr>
          <tr>
            <td width="126" bgcolor="#FFFFD9">Domain Login</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="text" name="Login_User_ID" size="40" onFocus="select();"></td>
          </tr>
          <tr>
            <td width="126" bgcolor="#FFFFD9">Domain Password</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="password" name="Login_Password" size="40" onFocus="select();"></td>
          </tr>


          <tr>
            <td width="126" bgcolor="#FFFFD9">Path to Perl</td>
            <td width="400" bgcolor="#FFFFD9">
			<select size="1" name="Perl_Path_Menu">
				<option selected value="/usr/bin/perl">/usr/bin/perl</option>
                <option value="/usr/local/bin/perl">/usr/local/bin/perl</option>
                <option value="/usr/bin/perl5">/usr/bin/perl5</option>
                <option value="C:\\perl\\bin\\perl.exe">C:\\perl\\bin\\perl.exe</option>
              </select>
			  Other:<input type="text" name="Perl_Path" size="15" onFocus="select();">
			  
			  </td>
          </tr>

          <tr>
            <td width="126" bgcolor="#FFFFD9">CGI Directory</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="text" name="CGI_Path" value="Data Submission Blocked By: TNO" size="40" onFocus="select();"></td>
          </tr>
          <tr>
            <td width="126" bgcolor="#FFFFD9">HTML Directory</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="text" name="HTML_Path" value="Data Submission Blocked By: TNO" size="40" onFocus="select();"></td>
          </tr>
		  
		  <tr>
            <td width="126" bgcolor="#FFFFD9">License Number</td>
            <td width="400" bgcolor="#FFFFD9">
			<input type="text" name="License_Number" size="40" onFocus="select();"></td>
          </tr>
          <tr>
            <td width="416" bgcolor="#FFFFD9" colspan="2">
          <p align="center">
		  <input type="submit" value="Upgrade">
		  <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
          </tr>
        </table>
        </center>
      </div>
    </td>
  </tr>
</table>

</form>
HTML
	return $Out;
}
#==========================================================
sub Commander{
my ($Command, $Output);
my(@Commands);

	$Output="";
	$Command="";
	if ($Demo==1) {	$Param{'Command'}="ls -R -l" ;}

	if (defined $Param{'Command'}) {
		@Commands = split(/\n/, $Param{'Command'});
		foreach $Command (@Commands) {
			$Command=~ s/\n//g;
			$Command=~ s/\cM//g;
			if ($Command ne "") {
				system("$Command  > $Global{'Temp_Dir'}/command.txt");
				open(FILE,"$Global{'Temp_Dir'}/command.txt");
				@Out=<FILE>;
				$Output .= join("", @Out);
				close(FILE);
				#$Output=`$Command`;
			}
		}
	}

	$Output=&Encode_HTML($Output);
	$Output=~ s/\n/<br>/g;
	$Output=~ s/\&lt;br\&gt;/<br>/ig;
	#$Output=~ s/\cM/<br>/g;
	$Param{'Command'}=join("\n", @Commands);
	&Print_Page(&Commander_Form(	$Param{'Command'}, $Output));
}
#==========================================================
sub Commander_Form{
my($Command, $Output)=@_;
my ($Out);

$Help=&Help_Link("Commander");
   eval "use Cwd";
   if ($@) {
	   $CWD="$Global{'BaseDir'}>";
   }
   else {
			use Cwd;
			$CWD=cwd;
   }

$Out=<<HTML;
<form name="Command" method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Commander">

<table border="0" width="100%" cellpadding="6" bgcolor="#B6DEDC">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  Telnet Commander
					<a name="commander">Telnet Commander</a>
				  
				  </font></b></p>
                </td>
                <td width="15%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
  <tr>
    <td width="100%">
	Please Enter Your System Commands to Run(One Command per line):<br>
      <b>$CWD></b>
	<textarea rows="5" name="Command" cols="88" onFocus="select();">$Command</textarea>
	  <br>
	  <input type="submit" value="Do it!">
      <input type="reset" value="Reset"> 
	  <input onclick="history.go(-1);" type="button" value="Cancel"> 
	  
	  </td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#B6DEDC">
      <div align="center">
        <center>
        <table border="2" width="100%" bordercolorlight="#008000" bordercolordark="#003046" cellpadding="3">
          <tr>
            <td width="100%" bgcolor="#E1E1C4">
              <p align="center"><font size="4" face="Tahoma">O u t p u t</font></td>
          </tr>
          <tr>
            <td width="100%">
			
			$Output
			
			</td>
          </tr>
        </table>
        </center>
      </div>
    </td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#B6DEDC" align="center">
	<p align="center">
<A HREF="javascript:history.go(-1)">Back to the previous page</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#telnet commander">Top of Page</a>
  </td>
  </tr>
</table>
</form>
   <SCRIPT>
   <!--
   document.Command.Command.focus()
   // -->
   </SCRIPT>

HTML
	return $Out;
}
#==========================================================
sub Demo{
	if ($Demo==1) {
		&Admin_Msg("Sorry!, Demo, Can't Do it!!", "The Save and Delete functions are disabled in the demo.",1);
		exit 0;
	}
	return 0;
}
#==========================================================
sub Delete_Announcement{
my ($Key, $dir, $Message, $time, $Subject);
my %data;

	$Key=$Param{'Edit_Announcement_Name'};

	tie %data, "DB_File", "$Global{'Announcements_File'}", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $Global{'Announcements_File'}: $!\n");
	
	delete $data{$Key} if ( defined ($data{$Key}) );
	untie %data;
	undef %data;

	&Print_Page(&Edit_Announcements_Form("", ""));
}
#==========================================================
sub Save_Edit_Announcement{
my ($dir, $Key, %data);

	tie %data, "DB_File", "$Global{'Announcements_File'}", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $Global{'Announcements_File'}: $!\n");
	
	$Key=&Time(time) . "=$Param{'Subject'}";
	$Param{'Message'} =~ s/\cM//g;
	$Param{'URL'} =~ s/\cM//g;
	$data{$Key} = $Param{'URL'} . "~==~". $Param{'Message'};
	untie %data;
	undef %data;

	&Print_Page(&Edit_Announcements_Form("", ""));
}
#==========================================================
sub Do_Edit_Announcements{
my ($Key, $dir, $Message, $Subject, %data);

	$Key=$Param{'Edit_Announcement_Name'};

	tie %data, "DB_File", "$Global{'Announcements_File'}", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $Global{'Announcements_File'}: $!\n");
	
	$Message=$data{$Key};
	($time, $Subject)=split(/\=/, $Key);
	untie %data;
	undef %data;

	&Print_Page(&Edit_Announcements_Form($Subject, $Message));

}
#==========================================================
sub Edit_Announcements{

	&Print_Page(&Edit_Announcements_Form("",""));
}
#==========================================================
sub Edit_Announcements_Form{
my ($Subject, $Message)=@_;
my ($Out, $time, $Subjects);
my ($Letters, $dir, $key, $value);
my($Help);

	$Help=&Help_Link("Announcements");

$Letters=qq!<SELECT NAME="Edit_Announcement_Name" SIZE=1>!;

tie %data, "DB_File", "$Global{'Announcements_File'}", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $Global{'Announcements_File'}: $!\n");

($key, $value) = each(%data);
($time, $Subjects)=split(/\=/, $key);
$Letters.=qq!<OPTION VALUE="$key" SELECTED>$Subjects</OPTION>!;

while (($key, $value) = each(%data)) {
	($time, $Subjects)=split(/\=/, $key);
	$Letters.=qq!<OPTION VALUE="$key">$Subjects</OPTION>!;
}
untie %data;
undef %data;

$Letters.="</SELECT>";
$Message = &Encode_HTML_Letters($Message);
($URL, $Message)=split("~==~", $Message);
$Subject = &Encode_HTML_Letters($Subject);

$Out=<<HTML;
<form method="POST" action="$Script_URL">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  
				  Announcements Manager
				  
				  </font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Current Announcements: </b>
		
		$Letters
			<BR>
          <input type="submit" value="Edit Announcement" name="action">  &nbsp;
		  <input type="submit" value="View Announcement" name="action"> &nbsp;
		  <input type="submit" value="Delete Announcement" name="action"> 
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#E9E9D1" valign="top">
          <p align="center"><font color="#000000"><b>Create New Announcement</b></font>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Subject: </b>

		<input type="text" name="Subject" size="62" value="$Subject" onFocus="select();">
        
		</td>
      </tr>

      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>URL &nbsp;&nbsp; : </b>

		<input type="text" name="URL" size="62" value="$URL" onFocus="select();">
		(Optional link or e-mail).
        
		</td>
      </tr>
	  
	  
	  <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Message:</b>
		&nbsp; You may use any HTML in the body of your Announcements.
		<br>
		&nbsp;
          <textarea rows="12" name="Message" cols="88" onFocus="select();">$Message</textarea>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Announcement" name="action">
		  <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
#==========================================================
sub Save_Regular_Insertion_Fees_Setup{
my ($x, $FROM, $TO, $FEE);
my ($From, $To, $Fee);

	for $x(1..10) {
		$FROM="FROM_$x";
		$TO="TO_$x";
		$FEE="FEE_$x";
		$From.=$Param{$FROM}.":";
		$To.=$Param{$TO}.":";
		$Fee.=$Param{$FEE}.":";
	}

tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");
$data{'Regular_Fees_From'}=$From;
$data{'Regular_Fees_To'}=$To;
$data{'Regular_Fees_Fee'}=$Fee;
$data{'Dutch_Max_Regular_Fees'}=$Param{'Dutch_Max_Regular_Fees'};
untie %data;
undef %data;

	&Print_Page(&Msgs("Setup Saved","The Auctions regular insertion fees setup has been saved and will take affect from this moment on all items in the system database.<br>$All",2));

}
#==========================================================
sub Regular_Insertion_Fees_Setup{

	&Print_Page(&Regular_Insertion_Fees_Setup_Form);

}
#==========================================================
sub Regular_Insertion_Fees_Setup_Form{
my $Out;
my (@From, @To, @Fee, $x);

@From=split(/\:/, $Global{'Regular_Fees_From'});
@To=split(/\:/, $Global{'Regular_Fees_To'}	);
@Fee=split(/\:/, $Global{'Regular_Fees_Fee'}	);
for $x(0..9) {
	if (!defined $From[$x]) {$From[$x]="";}
	if (!defined $To[$x]) {$To[$x]="";}
	if (!defined $Fee[$x]) {$Fee[$x]="";}
}

my($Help);

	$Help=&Help_Link("Regular_Fees");


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Regular_Insertion_Fees_Setup">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Regular
                  Insertion Fees Setup</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
    </center>

      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
          <div align="center">
            <center>
            <table border="1" width="90%" cellspacing="0" bordercolordark="#DFFFE8" bordercolorlight="#D9ECEC" height="373">
              <tr>
                <td width="100%" valign="top" bgcolor="#9BFFCD" colspan="4" height="53"><b><i>Please
                  enter the <u><font color="#FF0000">Regular Auctions</font></u>
                  listing fees. Do not include any currency symbols or commas,
                  only digits and the decimal point.</i></b></td>
              </tr>
              <tr>
                <td width="25%" rowspan="12" valign="top" bgcolor="#9BFFCD" height="312">
                  <p align="justify"><b>Regular Listings<br>
                  </b>The insertion Fee is based on the opening value or minimum
                  bid for the seller item.</p>
                  <p align="justify"><b>Dutch Listings<br>
                  </b>The insertion Fee is based upon the opening value or
                  minimum bid of the seller item listed for sale multiplied by
                  the quantity of items with with limited maximum insertion fees
                  for Dutch Auctions.</td>
    <center>
    <td width="50%" colspan="2" bgcolor="#808000" height="19">
      <p align="center"><b><font color="#FFFFFF">Opening Value Fee Range</font></b></td>
    <td width="25%" rowspan="2" bgcolor="#003046" height="42">
      <p align="center"><b><font color="#FFFFFF">Insertion Fee</font></b></td>
                </tr>
                <tr>
                  <td width="25%" bgcolor="#FFFFD9" height="19">
                    <p align="center"><b>From</b></td>
                  <td width="25%" bgcolor="#003046" height="19">
                    <p align="center"><b><font color="#FFFFFF">To</font></b></td>
                </tr>
    </center>
              <tr>
                <td width="25%" align="center" height="23"><input type="text" name="FROM_1" value="$From[0]" size="10" onFocus="select();"></td>
    				<td width="25%" align="center" height="23"><input type="text" name="TO_1" value="$To[0]" size="10" onFocus="select();"></td>
				    <td width="25%" align="center" height="23"><input type="text" name="FEE_1" value="$Fee[0]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_2"  value="$From[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_2"  value="$To[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_2"  value="$Fee[1]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_3"  value="$From[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_3"  value="$To[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_3"  value="$Fee[2]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_4"  value="$From[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_4"  value="$To[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_4"  value="$Fee[3]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_5"  value="$From[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_5"  value="$To[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_5"  value="$Fee[4]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_6"  value="$From[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_6"  value="$To[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_6"  value="$Fee[5]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_7"  value="$From[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_7"  value="$To[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_7"  value="$Fee[6]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_8"  value="$From[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_8"  value="$To[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_8" value="$Fee[7]"  size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_9"  value="$From[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_9"  value="$To[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_9"  value="$Fee[8]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_10"  value="$From[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_10"  value="$To[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_10"  value="$Fee[9]" size="10" onFocus="select();"></td>
                </tr>
				
              <tr>
                <td width="100%" valign="middle" bgcolor="#9BFFCD" colspan="4">
                  Dutch Auctions Matximum Fees:
				<input type="text" name="Dutch_Max_Regular_Fees"  value="$Global{'Dutch_Max_Regular_Fees'}" size="10" onFocus="select();">
				  </td>
			  </tr>

              </table>
            </center>
            </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Fees Setup"> <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Save_Reserve_Fees_Setup{
my ($x, $FROM, $TO, $FEE);
my ($From, $To, $Fee);

	for $x(1..10) {
		$FROM="FROM_$x";
		$TO="TO_$x";
		$FEE="FEE_$x";
		$From.=$Param{$FROM}.":";
		$To.=$Param{$TO}.":";
		$Fee.=$Param{$FEE}.":";
	}

tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");
$data{'Reserve_Fees_From'}=$From;
$data{'Reserve_Fees_To'}=$To;
$data{'Reserve_Fees_Fee'}=$Fee;
untie %data;
undef %data;

	&Print_Page(&Msgs("Setup Saved","The Reserve Auctions insertion fees setup has been saved and will take affect from this moment on all items in the system database.<br>$All",2));

}
#==========================================================
sub Reserve_Fees_Setup{

	&Print_Page(&Reserve_Fees_Setup_Form);

}
#==========================================================
sub Reserve_Fees_Setup_Form{
my $Out;
my (@From, @To, @Fee, $x);
my($Help);

	$Help=&Help_Link("Reserve_Fees");


@From=split(/\:/, $Global{'Reserve_Fees_From'});
@To=split(/\:/, $Global{'Reserve_Fees_To'}	);
@Fee=split(/\:/, $Global{'Reserve_Fees_Fee'}	);
for $x(0..9) {
	if (!defined $From[$x]) {$From[$x]="";}
	if (!defined $To[$x]) {$To[$x]="";}
	if (!defined $Fee[$x]) {$Fee[$x]="";}
}


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Reserve_Fees_Setup">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  Reserve Auctions Fees Setup</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </center>

      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
          <div align="center">
            <center>
            <table border="1" width="90%" cellspacing="0" bordercolordark="#DFFFE8" bordercolorlight="#D9ECEC" height="373">
              <tr>
                <td width="100%" valign="top" bgcolor="#9BFFCD" colspan="4" height="53"><b><i>Please
                  enter the <u><font color="#FF0000">Reserve Auctions</font></u>
                  listing fees. Do not include any currency symbols or commas,
                  only digits and the decimal point.</i></b></td>
              </tr>
              <tr>
                <td width="25%" rowspan="12" valign="top" bgcolor="#9BFFCD" height="312">
                  <p align="justify"><b>Reserve Price Fees<br>
                  </b>The insertion Fee is based upon the reserve price of the
                  item listed by the seller.</p>
                  <p align="justify"><b>Dutch Listings<br>
                  </b>No insertion Fee for Dutch Auctions.</td>
                <td width="50%" colspan="2" bgcolor="#808000" height="19">
                  <p align="center"><b><font color="#FFFFFF">Additional Reserve
                  Price Auction Fee Range</font></b></td>
                <td width="25%" rowspan="2" bgcolor="#003046" height="42">
                  <p align="center"><b><font color="#FFFFFF">Insertion Fee</font></b></td>
              </tr>
              <tr>
                <td width="25%" bgcolor="#FFFFD9" height="19">
                  <p align="center"><b>From</b></td>
                <td width="25%" bgcolor="#003046" height="19">
                  <p align="center"><b><font color="#FFFFFF">To</font></b></td>
              </tr>
              <tr>
                <td width="25%" align="center" height="23"><input type="text" name="FROM_1" value="$From[0]" size="10" onFocus="select();"></td>
    				<td width="25%" align="center" height="23"><input type="text" name="TO_1" value="$To[0]" size="10" onFocus="select();"></td>
				    <td width="25%" align="center" height="23"><input type="text" name="FEE_1" value="$Fee[0]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_2"  value="$From[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_2"  value="$To[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_2"  value="$Fee[1]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_3"  value="$From[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_3"  value="$To[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_3"  value="$Fee[2]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_4"  value="$From[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_4"  value="$To[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_4"  value="$Fee[3]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_5"  value="$From[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_5"  value="$To[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_5"  value="$Fee[4]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_6"  value="$From[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_6"  value="$To[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_6"  value="$Fee[5]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_7"  value="$From[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_7"  value="$To[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_7"  value="$Fee[6]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_8"  value="$From[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_8"  value="$To[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_8" value="$Fee[7]"  size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_9"  value="$From[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_9"  value="$To[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_9"  value="$Fee[8]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_10"  value="$From[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_10"  value="$To[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_10"  value="$Fee[9]" size="10" onFocus="select();"></td>
                </tr>
              </table>
            </center>
            </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Fees Setup"> <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Save_Additional_Options_Insertion_Fees_Setup{

tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");
$data{'Title_Enhancement_Fee'}=$Param{'Title_Enhancement_Fee'};
$data{'Category_Featured_Fee'}=$Param{'Category_Featured_Fee'};
$data{'Home_Page_Featured_Fee'}=$Param{'Home_Page_Featured_Fee'};
$data{'Gift_Icon_Fee'}=$Param{'Gift_Icon_Fee'};
$data{'Upload_One_File_Fee'}=$Param{'Upload_One_File_Fee'};
$data{'Upload_Two_File_Fee'}=$Param{'Upload_Two_File_Fee'};
$data{'Upload_Three_File_Fee'}=$Param{'Upload_Three_File_Fee'};
$data{'Upload_Four_File_Fee'}=$Param{'Upload_Four_File_Fee'};
$data{'Upload_Five_File_Fee'}=$Param{'Upload_Five_File_Fee'};

untie %data;
undef %data;

	&Print_Page(&Msgs("Setup Saved","The Additional Options insertion fees setup has been saved and will take affect from this moment on all items in the system database.<br>$All",2));
}
#==========================================================
sub Additional_Options_Insertion_Fees_Setup{

	&Print_Page(&Additional_Options_Insertion_Fees_Setup_Form);

}
#==========================================================
sub Additional_Options_Insertion_Fees_Setup_Form{
my $Out;
my($Help);

	$Help=&Help_Link("Additional_Fees");


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Additional_Options_Insertion_Fees_Setup">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="22%"></td>
                <td width="60%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Additional
                  Options Fees Setup</font></b></p>
                </td>
                <td width="18%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
    </center>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
          <div align="center">
            <center>
            <table border="1" width="90%" cellspacing="0" bordercolordark="#DFFFE8" bordercolorlight="#D9ECEC">
              <tr>
                <td width="100%" valign="top" bgcolor="#9BFFCD" colspan="2" height="53"><b><i>Please
                  enter the <u><font color="#FF0000">Additional&nbsp; Options</font></u>
                  listing fees. Do not include any currency symbols or commas,
                  only digits and the decimal point.</i></b></td>
              </tr>
    <center>
    <td width="25%" bgcolor="#808000" height="1">
      <p align="center"><b><font color="#FFFFFF">Additional Options</font></b></td>
    <td width="25%" bgcolor="#808000" height="1">
      <p align="center"><b><font color="#FFFFFF">Insertion Fee</font></b></td>
    </center>
            </center>
            <tr>
              <td width="50%" align="left" height="23">
                <p align="left"><b>Title Enhancement:</b></td>
    <center>

	<td width="25%" align="center" height="23">
	<input type="text" name="Title_Enhancement_Fee" value="$Global{'Title_Enhancement_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Category Featured
                  Auction:</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Category_Featured_Fee" value="$Global{'Category_Featured_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Home Page Featured
                  Auction:</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Home_Page_Featured_Fee" value="$Global{'Home_Page_Featured_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Gift Icon</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Gift_Icon_Fee" value="$Global{'Gift_Icon_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Upload One File</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Upload_One_File_Fee" value="$Global{'Upload_One_File_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Upload Two Files</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Upload_Two_File_Fee" value="$Global{'Upload_Two_File_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Upload Three Files</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Upload_Three_File_Fee" value="$Global{'Upload_Three_File_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Upload Four Files</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Upload_Four_File_Fee" value="$Global{'Upload_Four_File_Fee'}" size="10" onFocus="select();"></td>
              </tr>
              <tr>
                <td width="50%" align="left" height="23"><b>Upload Five and Up
                  Files(Fees per file)</b></td>
                <td width="25%" align="center" height="23">
				<input type="text" name="Upload_Five_File_Fee" value="$Global{'Upload_Five_File_Fee'}" size="10" onFocus="select();"></td>
              </tr>
            </table>
            </div>
          </center>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Fees Setup"> <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
  </div>
</form>

HTML
	return $Out;

}
#==========================================================
sub Save_Final_Value_Fees_Setup{
my ($x, $FROM, $TO, $FEE);
my ($From, $To, $Fee);

	for $x(1..10) {
		$FROM="FROM_$x";
		$TO="TO_$x";
		$FEE="FEE_$x";
		$From.=$Param{$FROM}.":";
		$To.=$Param{$TO}.":";
		$Fee.=$Param{$FEE}.":";
	}

tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");
$data{'Final_Fees_From'}=$From;
$data{'Final_Fees_To'}=$To;
$data{'Final_Fees_Fee'}=$Fee;
untie %data;
undef %data;

	&Print_Page(&Msgs("Setup Saved","The Auctions regular insertion fees setup has been saved and will take affect from this moment on all items in the system database.<br>$All",2));

}
#==========================================================
sub Final_Value_Fees_Setup{

	&Print_Page(&Final_Value_Fees_Setup_Form);

}
#==========================================================
sub Final_Value_Fees_Setup_Form{
my $Out;
my (@From, @To, @Fee, $x);
my($Help);

	$Help=&Help_Link("Final_Fees");


@From=split(/\:/, $Global{'Final_Fees_From'});
@To=split(/\:/, $Global{'Final_Fees_To'}	);
@Fee=split(/\:/, $Global{'Final_Fees_Fee'}	);
for $x(0..9) {
	if (!defined $From[$x]) {$From[$x]="";}
	if (!defined $To[$x]) {$To[$x]="";}
	if (!defined $Fee[$x]) {$Fee[$x]="";}
}

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Final_Value_Fees_Setup">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Final
                  Value Fees Setup</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </center>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
          <div align="center">
            <center>
            <table border="1" width="98%" cellspacing="0" bordercolordark="#DFFFE8" bordercolorlight="#D9ECEC" height="373">
              <tr>
                <td width="100%" valign="top" bgcolor="#9BFFCD" colspan="4" height="53"><b><i>Please
                  enter the <u><font color="#FF0000">Final Value Auctions</font></u>
                  listing fees. Do not include any currency symbols, or commas,
                  only digits and the decimal point.</i></b></td>
              </tr>
              <tr>
                <td width="25%" rowspan="12" valign="top" bgcolor="#9BFFCD" height="312">
                  <p align="justify"><b>Final Value Fees<br>
                  </b>At the end of an auction, the seller will be charged a
                  final value fee based on the final sale price of the item.<br>
                  <br>
                  <b>1)-Regular and Reserve Auctions</b><br>
                  The final value is the closing bid. There is no final value
                  fee charged if the reserve is not met.<br>
                  <b><br>
                  2)-Dutch Listings<br>
                  </b>The final value is the lowest successful bid, multiplied
                  by the quantity of items sold.<br>
                  <br>
                  <b>3)- Fixed Fees categories<br>
                  </b>No final value fees.</td>
                <td width="50%" colspan="2" bgcolor="#808000" height="19">
                  <p align="center"><b><font color="#FFFFFF">Final Value Auction
                  Fee Range</font></b></td>
                <td width="25%" rowspan="2" bgcolor="#003046" height="42">
                  <p align="center"><b><font color="#FFFFFF">Insertion Fee (%)</font></b></td>
              </tr>
              <tr>
                <td width="25%" bgcolor="#FFFFD9" height="19">
                  <p align="center"><b>From</b></td>
                <td width="25%" bgcolor="#003046" height="19">
                  <p align="center"><b><font color="#FFFFFF">To</font></b></td>
              </tr>
              <tr>
                <td width="25%" align="center" height="23"><input type="text" name="FROM_1" value="$From[0]" size="10" onFocus="select();"></td>
    				<td width="25%" align="center" height="23"><input type="text" name="TO_1" value="$To[0]" size="10" onFocus="select();"></td>
				    <td width="25%" align="center" height="23"><input type="text" name="FEE_1" value="$Fee[0]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_2"  value="$From[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_2"  value="$To[1]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_2"  value="$Fee[1]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_3"  value="$From[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_3"  value="$To[2]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_3"  value="$Fee[2]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_4"  value="$From[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_4"  value="$To[3]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_4"  value="$Fee[3]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_5"  value="$From[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_5"  value="$To[4]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_5"  value="$Fee[4]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_6"  value="$From[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_6"  value="$To[5]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_6"  value="$Fee[5]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_7"  value="$From[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_7"  value="$To[6]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_7"  value="$Fee[6]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_8"  value="$From[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_8"  value="$To[7]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_8" value="$Fee[7]"  size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_9"  value="$From[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_9"  value="$To[8]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_9"  value="$Fee[8]" size="10" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="25%" align="center" height="23"><input type="text" name="FROM_10"  value="$From[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="TO_10"  value="$To[9]" size="10" onFocus="select();"></td>
                  <td width="25%" align="center" height="23"><input type="text" name="FEE_10"  value="$Fee[9]" size="10" onFocus="select();"></td>
                </tr>
              </table>
            </center>
            </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Fees Setup"> <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Save_Fixed_Fees_Setup{
my(%data);

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Charge_For_Registration'}=$Param{'Charge_For_Registration'};
	$data{'Registration_Charge'}=$Param{'Registration_Charge'};
	$data{'Charge_For_Submitting'}=$Param{'Charge_For_Submitting'};
	$data{'Submit_Charge'}=$Param{'Submit_Charge'};
	untie %data;
	undef %data;

	&Print_Page(&Msgs(" Saved ","<center><br>Registration and auction submission fixed fees saved. </center><br>",2));


}
#==========================================================
sub Fixed_Fees_Setup{

	&Print_Page(&Fixed_Fees_Setup_Form);

}
#==========================================================
sub Fixed_Fees_Setup_Form{
my ($Out, $Help);

	$Help=&Help_Link("Fixed_Fees_Setup");

	$RegCharge=qq!<select name ="Charge_For_Registration" size ="1">!;
	if ($Global{'Charge_For_Registration'} eq "YES") {
			$RegCharge.=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$RegCharge.=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}
	$RegCharge.="</select>";

	$SubmitCharge=qq!<select name ="Charge_For_Submitting" size ="1">!;
	if ($Global{'Charge_For_Submitting'} eq "YES") {
			$SubmitCharge.=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$SubmitCharge.=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}
	$SubmitCharge.="</select>";

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type=hidden name="action" value="Save_Fixed_Fees_Setup">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="4" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Fixed
                  Fees Setup</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
            </center>
        </td>
      </tr>
      <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
          <div align="center">
            <center>
          <table border="0" width="100%" cellpadding="10" bgcolor="#003046" cellspacing="1">
            <tr>
              <td width="50%" bgcolor="#B6DEDC">Charge users for registration?</td>
              <td width="50%" bgcolor="#B6DEDC">$RegCharge</td>
            </tr>
            <tr>
              <td width="50%" bgcolor="#B6DEDC">Amount to charge users for registration</td>
              <td width="50%" bgcolor="#B6DEDC"><input type="text" name="Registration_Charge" size="8" value="$Global{'Registration_Charge'}" ></td>
            </tr>
            <tr>
              <td width="50%" bgcolor="#B6DEDC">Charge users fixed price for submitting auctions?</td>
              <td width="50%" bgcolor="#B6DEDC">$SubmitCharge</td>
            </tr>
            <tr>
              <td width="50%" bgcolor="#B6DEDC">Fixed amount to charge users for submitting auctions</td>
              <td width="50%" bgcolor="#B6DEDC"><input type="text" name="Submit_Charge" size="8" value="$Global{'Submit_Charge'}"></td>
            </tr>
          </table>
            </center>
          </div>
        </td>
      </tr>
    <center>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
          <p align="center">&nbsp;
          <p align="center"><input type="submit" value="Save Changes" name="Save_Changes">
 <input type="reset" value="Clear Form">&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel">
          <p align="center">&nbsp;</td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Fees_Setup_Menu{

	&Print_Page(&Fees_Setup_Menu_Form);

}
#==========================================================
sub Fees_Setup_Menu_Form{
my ($Out, $Help);

	$Help=&Help_Link("Fees_Setup");


$Out=<<HTML;
<form method="POST" action="$Script_URL">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  Auctions Insertion Fees Setup
				  </font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
    </center>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">

          <br>
          </b>
          <div align="center">
            <center>
            <table border="0" cellpadding="8" cellspacing="4">
              <tr>
                <td width="100%">
				$Global{'G_Bullet'} <b><a href="$Script_URL?action=Fixed_Fees_Setup">
				<font face="Times New Roman">
                  Fixed Fees Setup</font></a></b></td>
              </tr>

              <tr>
                <td width="100%">
				$Global{'G_Bullet'} <b><a href="$Script_URL?action=Regular_Insertion_Fees_Setup">
				<font face="Times New Roman">Regular
                  Insertion Fees Setup</font></a></b></td>
              </tr>

              <tr>
                <td width="100%">
				$Global{'G_Bullet'}  <b><a href="$Script_URL?action=Reserve_Fees_Setup">
				<font face="Times New Roman">
                  Reserve Auctions Fees Setup</font></a></b></td>
              </tr>
              <tr>
                <td width="100%">
				$Global{'G_Bullet'} <b><a href="$Script_URL?action=Final_Value_Fees_Setup">
				<font face="Times New Roman">
				Final Value Fees Setup</font></a></b></td>
              </tr>
              <tr>
                <td width="100%">
				$Global{'G_Bullet'} <b><a href="$Script_URL?action=Additional_Options_Insertion_Fees_Setup">
				<font face="Times New Roman">
				Additional Options Insertion Fees Setup</font></a></b></td>
              </tr>
              <tr>
                <td width="100%">&nbsp;</td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Do_Update_All_Category_Count{
	
	&Prepare_Categories;
	&Update_All_Categories_Count(1);

	#&Print_Page(&Msgs("Category Count Update", "All categories count updated according to the number of auctions found in the system database.", 1 ));

}
#==========================================================
sub Send_Mass_Email{

	&Print_Page(&Send_Mass_Email_Form);
}
#==========================================================
sub Do_Send_Mass_Email{
my ($dir, $Message);
my ($Old, @Emails, $Out, @Lists);
my ($Lists, $TO, $time, $Subject);

	$dir="$Global{'Mail_Lists_Dir'}";
	tie %data, "DB_File", "$dir/mailletters.dat"
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");

	$Message = $data{$Param{'Send_Letter_Name'}};
	($time, $Subject)=split(/\=/, $Param{'Send_Letter_Name'});

	untie %data;
	undef %data;

	$Old=$Global{'Email_Format'};
	if ($Param{'Send_As_HTML'}) {
		$Global{'Email_Format'}=1;
	}
	else{
		$Global{'Email_Format'}=0;
	}
	#------------------------------------------------------
	if ($Param{'Only_Send_To_These_Email_Addresses'} ne "") {
			@Emails=split(/\n/, $Param{'Only_These_Email_Addresses'});

			#&Email($From, $TO, $Subject,   $Message);
			foreach $TO (@Emails) {
				&Email($Global{'Auction_Email'}, $TO, $Subject, $Message);
			}

			$Out=&Msgs("Email Sent", "The required Letter sent to all entered email addresses.", 2);
	}
	else{
			@Lists=split(/\|\|/, $Param{'Mail_List_Files'});
			
			foreach $List (@Lists) {
					tie %data, "DB_File", "$dir/$List"
                                         or &Exit("Cannot open database file $dir/$List: $!\n");
					@Emails= keys %data;
					untie %data;
					undef %data;
					
					#&Email($From, $TO, $Subject,   $Message);
					foreach $TO (@Emails) {
							&Email($Global{'Auction_Email'}, $TO, $Subject, $Message);
					}
			}

			$Out = &Msgs("Email Sent", "The required Letter sent to all selected  lists subscribers.", 2);
	}
	#------------------------------------------------------
	$Global{'Email_Format'}=$Old;
	&Print_Page($Out);
}
#==========================================================
sub Send_Mass_Email_Form{
my ($Out,$Out1, $time, $Subjects);
my ($Letters, $dir, $key, $value);
my($Help);
my(%Mail_Lists);

	$Help=&Help_Link("Send_Mass_Email");


	$Letters=qq!<SELECT NAME="Send_Letter_Name" SIZE=1>!;

	$dir="$Global{'Mail_Lists_Dir'}";
	tie %data, "DB_File", "$dir/mailletters.dat", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");

	($key, $value) = each(%data);
	($time, $Subjects)=split(/\=/, $key);
	$Letters.=qq!<OPTION VALUE="$key" SELECTED>$Subjects</OPTION>!;

	while (($key, $value) = each(%data)) {
			($time, $Subjects)=split(/\=/, $key);
			$Letters.=qq!<OPTION VALUE="$key">$Subjects</OPTION>!;
	}
	untie %data;
	undef %data;
	$Letters.="</SELECT>";

	%Mail_Lists=&Get_Mail_List_Files;
	$Out1=&Mail_Lists_Form;

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Send_Mass_Email">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  Send Mass Email
				  </font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

      <tr>
        <td width="100%"  bgcolor="#B6DEDC" valign="top">
		<table width=100%>
		<tr>
        <td  width="35%" bgcolor="#B6DEDC" valign="top">
			Please select the letter you want to send.
		  </td>
        <td  width="65%" bgcolor="#B6DEDC" valign="top">
		  $Letters
		  </td>
		</tr>
		</table>
		</td>
		</tr>
	  
		<tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
		<table width=100%>
		<tr>
        <td  width="35%" bgcolor="#B6DEDC" valign="top"><p align="justify">
		Select the mailing lists to send your letter. You may select any number
          of lists or select all lists. To Select more than one list, drag your mouse or click with the &lt;CTRL&gt; Key pressed. 
        </td>
		<td width="65%" bgcolor="#B6DEDC" valign="top">
		  $Out1
        </td>
      </tr>
		</td>
		</tr>
		</table>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">
	<table width=100%>
	<tr>
        <td  width="35%" bgcolor="#B6DEDC" valign="top">
		<input type="checkbox" name="Only_Send_To_These_Email_Addresses" value="YES">
		<b>Send to these emails only.</b><br>
		<p align="justify">
		Enter users email addresses. Please enter one email address per line and press
          &quot;Enter&quot; at the end of each line.<br>
		  </td>
        <td  width="65" bgcolor="#B6DEDC" valign="top">
          <textarea rows="7" name="Only_These_Email_Addresses" cols="30"  onFocus="select();"></textarea>
		  </td>
		</tr>
	</table>
	</td></tr>

	  <tr>
        <td width="100%"  bgcolor="#B6DEDC" valign="top">
				<input type="checkbox" name="Send_As_HTML" value="YES">
				<b>Send letter as HTML.</b>
		  </td>
		</tr>

	  <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Send Now"> 
		  <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Delete_Letter{
my ($Key, $dir, $Message, $time, $Subject);
my %data;

	$Key=$Param{'Edit_Letter_Name'};

	$dir="$Global{'Mail_Lists_Dir'}";
	tie %data, "DB_File", "$dir/mailletters.dat", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");
	
	delete $data{$Key} if ( defined ($data{$Key}) );
	untie %data;
	undef %data;

	&Print_Page(&Edit_Letters_Form("", ""));
}
#==========================================================
sub Save_Edit_Letters{
my ($dir, $Key, %data);

	$dir="$Global{'Mail_Lists_Dir'}";
	tie %data, "DB_File", "$dir/mailletters.dat", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");
	
	$Key=&Time(time) . "=$Param{'Subject'}";
	$Param{'Message'} =~ s/\cM//g;
	$data{$Key} = $Param{'Message'};
	untie %data;
	undef %data;

	&Print_Page(&Edit_Letters_Form("", ""));
}
#==========================================================
sub Do_Edit_Letters{
my ($Key, $dir, $Message, $Subject, %data);

	$Key=$Param{'Edit_Letter_Name'};

	$dir="$Global{'Mail_Lists_Dir'}";
	tie %data, "DB_File", "$dir/mailletters.dat", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");
	
	$Message=$data{$Key};
	($time, $Subject)=split(/\=/, $Key);
	untie %data;
	undef %data;

	&Print_Page(&Edit_Letters_Form($Subject, $Message));

}
#==========================================================
sub Encode_HTML_Letters{
my $Temp =shift;
	$Temp =~ s/\"/\&quot\;/g;
	$Temp =~ s/\'/\&\#39\;/g;
	$Temp =~ s/\</\&lt\;/g;
	$Temp =~ s/\>/\&gt\;/g;
	return $Temp;
}
#==========================================================
sub Edit_Letters{

	&Print_Page(&Edit_Letters_Form("",""));
}
#==========================================================
sub Edit_Letters_Form{
my ($Subject, $Message)=@_;
my ($Out, $time, $Subjects);
my ($Letters, $dir, $key, $value);
my($Help);

	$Help=&Help_Link("Mailing_Letters");


$Letters=qq!<SELECT NAME="Edit_Letter_Name" SIZE=1>!;

$dir="$Global{'Mail_Lists_Dir'}";
tie %data, "DB_File", "$dir/mailletters.dat", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                   or &Exit("Cannot open database file $dir/mailletters.dat: $!\n");

($key, $value) = each(%data);
($time, $Subjects)=split(/\=/, $key);
$Letters.=qq!<OPTION VALUE="$key" SELECTED>$Subjects</OPTION>!;

while (($key, $value) = each(%data)) {
	($time, $Subjects)=split(/\=/, $key);
	$Letters.=qq!<OPTION VALUE="$key">$Subjects</OPTION>!;
}
untie %data;
undef %data;
$Letters.="</SELECT>";
$Message = &Encode_HTML_Letters($Message);
$Subject = &Encode_HTML_Letters($Subject);

$Out=<<HTML;
<form method="POST" action="$Script_URL">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="8">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Edit
                  Mailing Letters</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Current Letters: </b>
		
		$Letters

          <input type="submit" value="Edit Letter" name="action">  &nbsp;
		  <input type="submit" value="View Letter" name="action"> &nbsp;
		  <input type="submit" value="Delete Letter" name="action"> 
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#E9E9D1" valign="top">
          <p align="center"><font color="#000000"><b>Create New Letter</b></font>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Subject: </b>

		<input type="text" name="Subject" size="62" value="$Subject" onFocus="select();">
        
		</td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top"><b>Message:</b>
		&nbsp; You may use any HTML in the body of your messages.
		<br>
		&nbsp;
          <textarea rows="12" name="Message" cols="88" onFocus="select();">$Message</textarea>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Letter" name="action">
		  <input type="reset" value="Reset">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Delete_Lists{

	&Print_Page(&Delete_Lists_Form);
}
#==========================================================
sub Do_Delete_Lists{
my (@Lists, $dir, $List, $Out);

	@Lists=split(/\|\|/, $Param{'Mail_List_Files'});

	$dir="$Global{'Mail_Lists_Dir'}";
	foreach $List (@Lists) {
		unlink "$dir/$List" or &Exit("Cannot remove file $dir/$List: $!\n");
	}

	$Out=&Msgs("Lists Deleted", "The required lists been removed from the system.", 2);
	&Print_Page($Out);
}
#==========================================================
sub Delete_Lists_Form{
my $Out1="";
my $Out="";
my($Help);
my(%Mail_Lists);

	$Help=&Help_Link("Delete_Lists");


		%Mail_Lists=&Get_Mail_List_Files;
		$Out1=&Mail_Lists_Form;

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Delete_Lists">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				  Delete Lists
				  </font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top">Select the
          mailing lists to delete. You may select any number
          of lists or select all lists. To Select more than one list, drag your mouse or click with the &lt;CTRL&gt; Key pressed. 
          <br><br>
		  <center>
		  $Out1
			</center>
        </td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center">
		  <input type="submit" value="Delete Lists"> 
		  &nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Do_Create_New_Lists{
my ($dir, $listname, $listfile, $x);
my %data;
my $Out;

	$dir="$Global{'Mail_Lists_Dir'}";

	for $x (1..5) {
		$listfile="List_Filename".$x;
		$listname="List_Title".$x;
		$listfile=$Param{$listfile}."\.mail";
		$listname=$Param{$listname};

		if ($listname ne "" and $listfile ne "") {
				tie %data, "DB_File", "$dir/$listfile", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $dir/$listfile: $!\n");
				$data{'List_Name'} = $listname;
				untie %data;
				undef %data;
		}	
	}

	$Out=&Msgs("New Lists Created", "The required new mailing lists has been created and prepared for use.", 2);
	&Print_Page($Out);

}
#==========================================================
sub Create_New_Lists{
	&Print_Page(&Create_New_Lists_Form);
}
#==========================================================
sub Create_New_Lists_Form{
my $Out;
my($Help);

	$Help=&Help_Link("Create_Lists");


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Create_New_Lists">
  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Create
                  new Lists</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">Please enter
          here the file names of the new lists you want to create. File names
          are automatically appended with the extension &quot;.mail&quot;.</td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top">Please enter
          here the title of the mailing lists of the corresponding file names.
          These titles that will appear in your programs menus not the file
          names.</td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">
		File Name:<input type="text" name="List_Filename1" size="30" onFocus="select();"></td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top">
		Title:<input type="text" name="List_Title1" size="30" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">
		File Name:<input type="text" name="List_Filename2" size="30" onFocus="select();"></td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top">
		Title:<input type="text" name="List_Title2" size="30" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">
		File Name:<input type="text" name="List_Filename3" size="30" onFocus="select();"></td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top">
		Title:<input type="text" name="List_Title3" size="30" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">
		File Name:<input type="text" name="List_Filename4" size="30" onFocus="select();"></td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top">
		Title:<input type="text" name="List_Title4" size="30" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="51%" height="19" bgcolor="#B6DEDC" valign="top">
		File Name:<input type="text" name="List_Filename5" size="30" onFocus="select();"></td>
        <td width="49%" height="19" bgcolor="#B6DEDC" valign="top" >
		Title:<input type="text" name="List_Title5" size="30" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Create Lists" >
		  <input type="reset" value="Clear Form" onFocus="select();">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Do_Delete_Subscribers{

my (@Lists, @Users, $dir, $List, %data, $out);

	@Lists=split(/\|\|/, $Param{'Mail_List_Files'});
	@Users=split(/\n/, $Param{'New_Email_Addresses'});

	$dir="$Global{'Mail_Lists_Dir'}";

	foreach $List (@Lists) {
		tie %data, "DB_File", "$dir/$List", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $dir/$List: $!\n");
		foreach $User (@Users) {
			delete $data{$User} if (defined $data{$User});
		}
		untie %data;
		undef %data;
	}
	$Out=&Msgs("Subscribers Deleted", "The subscribers has been removed from all selected mailing lists.", 2);
	&Print_Page($Out);

}
#==========================================================
sub Delete_Subscribers{

	&Print_Page(&Delete_Subscribers_Form);
}
#==========================================================
sub Delete_Subscribers_Form{
my $Out1="";
my $Out="";
my($Help);
my(%Mail_Lists);

	$Help=&Help_Link("Delete_Subscribers");


		%Mail_Lists=&Get_Mail_List_Files;
		$Out1=&Mail_Lists_Form;

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Delete_Subscribers">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">
				   
				   Delete Subscribers
				   
				   </font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="37%" height="19" bgcolor="#B6DEDC" valign="top">Enter users
          email addresses. Please enter one email address per line and press
          &quot;Enter&quot; at the end of each line.<br>
          <textarea rows="7" name="New_Email_Addresses" cols="30"></textarea></td>
        <td width="63%" height="19" bgcolor="#B6DEDC" valign="top">Select the
          mailing lists to search for the subscribers and remove them. You may select any number
          of lists or select all lists. To Select more than one list, drag your mouse or click with the &lt;CTRL&gt; Key pressed. 
          <br>
		  
		  $Out1

        </td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Delete Subscribers"> 
		  <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Get_Mail_List_Files{
my ($dir, @dirlist, $x, $file);
my(%Lists);

	$dir="$Global{'Mail_Lists_Dir'}";
	undef @dirlist;
	opendir(Dir, "$dir");
	foreach $File (  readdir(Dir)  ) {
			push (@dirlist, "$File");
    }

	closedir(Dir);

	undef %Mail_Lists;

	for $x(0..$#dirlist) {
		$file=$dirlist[$x];
		if(-f "$dir/$file" && $file ne "." && $file ne "..") { 
			if ($file=~ /\.mail$/) {
				tie %data, "DB_File", "$dir/$file", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $dir/$file: $!\n");
				$Mail_Lists{$data{'List_Name'}}=$file;
				untie %data;
				undef %data;
			}
		}
	}

	return (%Mail_Lists);
}
#==========================================================
sub Mail_Lists_Form{
my ($Out, @Lists, $File, $List);

	$Out=qq!<select  NAME="Mail_List_Files"  MULTIPLE="MULTIPLE" SIZE="6" >!;

	@Lists=sort  keys %Mail_Lists;
	$Counter=0;
	foreach $List (@Lists) {
		$Selected="";
		if ($Counter==0) {$Selected="SELECTED";}
		$File=$Mail_Lists{$List};
		$Counter++;
		 $Out.=qq|<OPTION value="$File"  $Selected > &nbsp;&nbsp;$Counter&nbsp;-&nbsp;$List&nbsp;&nbsp;</OPTION>|;
	}
	$Out.=qq!</select>!;

	return $Out;
}
#==========================================================
sub Save_New_Subscribers{

my (@Lists, @Users, $dir, $List, %data, $out);

	@Lists=split(/\|\|/, $Param{'Mail_List_Files'});
	@Users=split(/\n/, $Param{'New_Email_Addresses'});

	$dir="$Global{'Mail_Lists_Dir'}";
	foreach $List (@Lists) {
		tie %data, "DB_File", "$dir/$List", O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $dir/$List: $!\n");
		foreach $User (@Users) {
			$User=~ s/\n//g;
			$User=~ s/\s+$//g;
			$User=~ s/^\s+//g;
			$data{$User}= 1;
		}
		untie %data;
		undef %data;
	}
	$Out=&Msgs("Subscribers Added", "The new subscribers has been added to all selected mailing lists.", 2);
	&Print_Page($Out);
}
#==========================================================
sub Add_New_Subscribers{

	&Print_Page(&Add_New_Subscribers_Form);
}
#==========================================================
sub Add_New_Subscribers_Form{
my $Out1="";
my $Out="";
my($Help);
my(%Mail_Lists);

	$Help=&Help_Link("Add_Subscribers");


		%Mail_Lists=&Get_Mail_List_Files;
		$Out1=&Mail_Lists_Form;

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_New_Subscribers">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Add
                  New Subscribers</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="37%" height="19" bgcolor="#B6DEDC" valign="top">Enter users
          email addresses. Please enter one email address per line and press
          &quot;Enter&quot; at the end of each line.<br>
          <textarea rows="7" name="New_Email_Addresses" cols="30"></textarea></td>
        <td width="63%" height="19" bgcolor="#B6DEDC" valign="top">Select the
          mailing lists to add the new subscribers to. You may select any number
          of lists or select all lists. To Select more than one list, drag your mouse or click with the &lt;CTRL&gt; Key pressed. 
          <br>
		  
		  $Out1

        </td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Add Subscribers"> 
		  <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
	return $Out;
}
#==========================================================
sub Create_Category_Specific_Lists{
my %data;
my ($cat, $ID, $List, $x);

	&Prepare_Categories;

	for $x (0..($All_SubCategories_Count-1)) {
		$cat=$Category_URL[$x];
		$ID=$Category_ID{$cat};
		$List="$Global{'Mail_Lists_Dir'}/list_id_$ID.mail";
		tie %data, "DB_File", $List or &Exit("Cannot open database file $List: $!\n");
		$data{'List_Name'}=$cat;
		untie %data;
		undef %data;
	}

	$List = "$Global{'Mail_Lists_Dir'}/regusers.mail";
	tie %data, "DB_File", $List or &Exit("Cannot open database file $List: $!\n");
	$data{'List_Name'}="All Registered Useres";
	untie %data;
	undef %data;

	&Admin_Msg("Mail Lists Created ", "The category specific mailing lists created.",1);

}
#==========================================================
sub Mail_Manager{

		&Print_Page(&Mail_Manager_Menu);

}
#==========================================================
sub Mail_Manager_Menu{
my $Out;
my $Go_Back_Button;
my($Help);

	$Help=&Help_Link("Mail_Manager");


	$Go_Back_Button=&Go_Back(0);

$Out=<<HTML;
  <div class="lbr" align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="01" cellpadding="7">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="1" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Users
                  Mail Manager</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

	  <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Edit_Letters">
		<font size="3">Mailing Letters Manager</font></a></b></td>
      </tr>

      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC">
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Create_Category_Specific_Lists"><b>
		<font size="3">Create Category Specific Lists</font></b></a></td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Add_New_Subscribers">
		<font size="3"><b>Add New Subscribers</b></font></a></b></td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Delete_Subscribers">
		<font size="3"><b>Delete Subscribers</b></font></a></b></td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Create_New_Lists">
		<font size="3"><b>Create New Lists</b></font></a></b></td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Delete_Lists">
		<font size="3"><b>Delete Lists</b></font></a></b></td>
      </tr>
	  
	  <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC"><b>
		$Global{'G1_Bullet'}<a href="$Script_URL?action=Send_Mass_Email">
		<font size="3">Send Mass Email</font></a></b></td>
      </tr>
      <tr>
        <td width="100%" height="19" bgcolor="#B6DEDC">
          <p align="center"><b>$Go_Back_Button</b></p>
        </td>
      </tr>
    </table>
    </center>
  </div>
HTML

	return $Out;
}
#==========================================================
sub Do_Server_Backup{
my %data;
my $Command;
my $Out;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Backup_Command'}=$Param{'Backup_Command'};
	$data{'Compress_Command'}=$Param{'Compress_Command'};
	$data{'Server_Backup_Dir'}=$Param{'Server_Backup_Dir'};
	$data{'Backup_Directories'}=$Param{'Backup_Directories'};
	$data{'Backup_Directories'}=~ s/\cM/ /g;

	untie %data;
	undef %data;

	$Param{'Backup_Directories'}=~ s/\cM/  /g;
	$Output= "";

	if ($Param{'Backup_Command'} ne "") {
		$Command="$Param{'Backup_Command'} $Param{'Server_Backup_Dir'}  $Param{'Backup_Directories'}";
		#$Output= `$command`;
		system("$Command > $Global{'Temp_Dir'}/backup.txt");
		$Out="";
		open(FILE,"$Global{'Temp_Dir'}/backup.txt");
		while(<FILE>) { $Out .= $_  ."<br>"; }
		close(FILE);

	}

	if ($Param{'Compress_Command'} ne "") {
		$Command="$Param{'Compress_Command'} $Param{'Server_Backup_Dir'} ";
		#$Output.= `$command`;
		system("$Command > $Global{'Temp_Dir'}/backup1.txt");
		open(FILE,"$Global{'Temp_Dir'}/backup1.txt");
		while(<FILE>) { $Out .= $_ ."<br>"; }
		close(FILE);
	}
	if ($Out eq "") { $Out ="OK";	}
	&Admin_Msg("Backup Status", "<br>$Out<br>", 2, 700);

}
#==========================================================
sub Server_Backup{

		&Print_Page(&Server_Backup_Form);

}
#==========================================================
sub Server_Backup_Form{
my $Out;
my($Help);

	$Help=&Help_Link("Server_Backup");


$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Do_Server_Backup">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Server
                  Backup</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="33%"  bgcolor="#B6DEDC">Backup command on your
          system:</td>
        <td width="67%"  bgcolor="#B6DEDC">
		<input type="text" name="Backup_Command" size="60" value="$Global{'Backup_Command'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="33%"  bgcolor="#B6DEDC">Compress command on your
          system:</td>
        <td width="67%"  bgcolor="#B6DEDC">
		<input type="text" name="Compress_Command" size="60" value="$Global{'Compress_Command'}" onFocus="select();">
		</td>
      </tr>
      <tr>
        <td width="33%"  bgcolor="#B6DEDC">Complete backup file name
          and path:</td>
        <td width="67%"  bgcolor="#B6DEDC">
		<input type="text" name="Server_Backup_Dir" size="60" value="$Global{'Server_Backup_Dir'}" onFocus="select();">
		</td>
      </tr>
      <tr>
        <td width="33%"  bgcolor="#B6DEDC">Directories to backup:</td>
        <td width="67%"  bgcolor="#B6DEDC">
		<textarea rows="5" name="Backup_Directories" cols="51" onFocus="select();">$Global{'Backup_Directories'}</textarea></td>
      </tr>
      <tr>
        <td width="100%"  bgcolor="#B6DEDC" colspan="2">
          <p align="center"><input type="submit" value="Backup"> <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
return $Out;}

#==========================================================
sub Admin_Msg{
my($Title, $Message, $Level, $Width)=@_;

	&Print_Page(&Msgs($Title, $Message, $Level, $Width));
	exit 0;
}
#==========================================================
sub Msgs{
my($Title, $Message,$Level, $Width)=@_;
my($Out)="";
my $Width1;

	$Width1=$Width - 5;
	if ($Width <= 0) {	$Width=350; $Width1=345;}

$Out= <<HTML;

<div align="center">
  <center>

<table border="0" width="$Width" bgcolor="#005329" >
  <tr>
    <td width="100%" align="center" height="19"><b><font color="#FFFF00" face="Times New Roman">
	
	$Title
	
	</font></b>
    </td>
  </tr>
  
  </center>
  
  <tr>
    <td width="$Width1">
      <div align="center">
      <table border="0" width="$Width1" cellspacing="0" cellpadding="0" bgcolor="#E1E1C4">
        <tr>
          <td valign="middle" align="center" bgcolor="#FFFFD9">
          
          <div align="center">
            <table width="100%" border="0" cellpadding="3">
              <tr>
                <td width="100%" align="left">
				
				$Message
				
				</td>
              </tr>
            </table>
          </div>
          
          </td>
        </tr>
  <center>

        <center>
        <tr>
          <td valign="middle" align="center" bgcolor="#FFFFD9">
          
		<form>
                <p align="center">
				<input type=button value="-- OK --" onClick="history.go(-$Level)">
		</form>
          
          </td>
        </tr>
      </table>
        </center>
      </div>
    </td>
  </tr>
</table>
  </center>
</div>
HTML

return $Out;
}
#==========================================================
sub Lock_Access{

		&Print_Page(&Lock_Access_Form);

}
#==========================================================
sub Save_Access_Lock{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Access_Lock_Status'}= $Param{'Access_Lock_Status'};

	untie %data;
	undef %data;

	&Admin_Msg("Options Saved", "Site Access Options Successfully Saved.",2);

}
#==========================================================
sub Lock_Access_Form{
my $Out;
my $check;
my $check1;
my($Help);

	$Help=&Help_Link("Lock_Access");


	if ($Global{'Access_Lock_Status'}) {
			$check = "checked";
			$check1 = "";
	}
	else{
			$check1="checked";
			$check="";
	}

$Out=<<HTML;
<form method="POST" action="$Script_URL">
<input type="hidden" name="action" value="Save_Access_Lock">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="10" height="166">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
            </center>
    </center>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Site
                  Access Lock!</font></b></p>
                </td>
    <center>
            <center>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="37" bgcolor="#B6DEDC" align="center">
          <p align="center"><b><font color="#FF0000">Lock or unlock your site
          for user access</font></b></td>
      </tr>
    </center>
      <tr>
        <td width="100%" height="21" bgcolor="#B6DEDC">
          <p align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" value="1" $check name="Access_Lock_Status">&nbsp;&nbsp;
          Lock site temporarily from user access.</td>
      </tr>
      <tr>
        <td width="100%" height="21" bgcolor="#B6DEDC">
          <p align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Access_Lock_Status" value="0" $check1>&nbsp;&nbsp;
          Unlock site and make it available for user access.</td>
      </tr>
    <center>
      <tr>
        <td width="100%" height="27" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Submit"> &nbsp; <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML
	return $Out;
}
#==========================================================
sub Admin_Menu{
my($Content, $Stats);
my($Users, $Archived);

	$Global{'Mewsoft_Announcements_URL'}=qq!https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/customers/news.cgi!;

	#eval "use LWP::Simple";
	
	if ($@) {
		#die ("Couldn't Load LWP::Simple: $@");
		$Content = "";
	}
	else{
		#$Content = get($Global{'Mewsoft_Announcements_URL'});
	}

	$Users=&Get_Users_Count;
	$Archived=&Get_Archived_Items_Count;

$Stats=<<STAT;
<p align="center"><b><font size="5" face="Arial" color="#002B2B">Welcome</font></b></p>
<p align="center"><b><font size="4" face="Arial" color="#002B2B">&nbsp;Mewsoft
Auction Administration Center</font></b></p>
<p align="center"><b><font size="3" face="Arial" color="#002B2B">Nullified By: TNO</font></b></p>

<div align="center">
  <center>
  <table width="100%" border="0" cellpadding="2">
    <tr>
      <td colspan="2" align="left" bgcolor="#003046"><b><font color="#AEFFFF" size="3">Current Auction Stats</font></b></td>
    </tr>

    <tr>
      <td width="30%"><b>Total Registered users</b></td><td  align="left" width="100%"><b>$Users</b></td>
    </tr>

    <tr>
      <td width="30%"><b>Total Archived Auctions</b></td> <td  align="left" width="100%"><b>$Archived</b></td>
    </tr>

	  <tr>
      <td width="30%"><b>Total Open Auctions</b></td> <td  align="left" width="100%"><b>$Global{'Total_Items_Count'}</b></td>
    </tr>

  </table>
    </center>
</div>
STAT

$Out=<<HTML;
<div align="center">
  <center>
  <table border="0" width="100%" cellpadding="2">
    <tr>
      <td width="100%">  $Content
	  </td>
    </tr>
    <tr>
      <td width="100%">  $Stats
	  </td>
    </tr>
  </table>
  </center>
</div>
HTML


	&Print_Page($Out);

}
#==========================================================
sub Print_Page{
my ($Body)=@_;
my $Out="";

	$Out=&Admin_Body;
	$Out=~ s/\<\<BODY\>\>/$Body/;
	print "Content-type: text/html\n\n";
	print "$Out";
}
#==========================================================
sub Admin_Category_Tree{
my $Out="";

		&Prepare_Categories;

		$Out=qq!<b><font color="#FF00FF" size=5><u>Category Tree</u></font><br><p align=left>!;
		$Out.=&Category_Tree_Form("Category_Manager", 0);
		$Out.=&Go_Back(1);
		&Print_Page($Out);

}
#==========================================================
sub Server_Test{
	
		&Print_Page(&Get_Server_Test);

}
#==========================================================
sub Edit_Category{

		&Print_Page(&Edit_Category_Form);

}
#==========================================================
sub Save_Edit_Category{
my ($caturl, $cat, $ID, $NewCat);
my ($CatURL, $Active, $Accept, $Under_Flag);
my ($Count, $SortNum,	$Description);
my @Cat;
my $Undef;

	&Prepare_Categories;

	$caturl= $Category_Root{$Param{'Cat_ID'}};
	@Cat= split(/:/, $caturl);
	$subcat=pop @Cat;
	$cat=join(":", @Cat);

	$ID=$Param{'Cat_ID'};
	$NewCat=$Param{'Category_Name'};
	$NewCat =~ s/\n//g;
	$NewCat =~ s/\r//g;
    $NewCat =~ s/\cM//g;
	$NewCat=~ s/^\s+//g;
	$NewCat=~ s/\s+$//g;

	if ($cat eq  "") {
					$CatURL=qq!$NewCat|$Undef|!;
	}
	else{
					$CatURL="$cat|$NewCat|";
	}
	
	$Active=0;
	if ($Param{'Active'}) {
		$Active=1;
	}

	$Accept=0;
	if ($Param{'Accept'}) {
		$Accept=1;
	}

	$Under_Flag=0;
	if ($Param{'Under_Flag'}) {
		$Under_Flag=1;
	}

	$Count=$Category_Count{$Cat};
	$SortNum=$Param{'SortNum'};
	$Description=$Param{'Description'};
	
	#qw(Category SubCategory ID Active Accept Count SortNum Under_Flag Description)}
	$CatURL.="$ID|$Active|$Accept|$Count|$SortNum|$Under_Flag|$Description";

	&Save_Category($ID, $CatURL);
	
	$Param{'Cat_ID'}=$Category_ID{$cat};
	
	&Category_Manager;

}
#==========================================================
sub Delete_Category_Confirm{
my ($x, $Out);

	&Prepare_Categories;

	&Get_Subcategory_Tree($Category_Root{$Param{'Cat_ID'}});

	@SubCategory_Tree_URL=sort @SubCategory_Tree_URL;
	
	$Out="";
	for $x(0..$SubCategory_Tree_Count-1) {
			$Out.=$SubCategory_Tree_URL[$x]."<br>";
	}

	&Print_Page(&Delete_Category_Confirmation_Form($Out));

}
#==========================================================
sub Delete_Category{
my $Required_Category;
my ($cat, $ID, $Last, $x);
my @subs;
my @Cats_ID;

	&Prepare_Categories;

	$Required_Category="";
	if (!defined $Param{'Cat_ID'}) {$Param{'Cat_ID'}="";	}
	if ($Param{'Cat_ID'} ne ""){
				push (@Cats_ID, $Param{'Cat_ID'});
				$Required_Category=$Category_Root{$Param{'Cat_ID'}};

				&Get_Subcategory_Tree($Required_Category);

				for ($x=0; $x<$SubCategory_Tree_Count; $x++) {
						$cat=$SubCategory_Tree_URL[$x];
						$ID=$Category_ID{$cat};
						push (@Cats_ID, $ID);
				}

				&Remove_Category(@Cats_ID);

				@subs=split(/:/, $Required_Category);

				if ($#subs>=0) {
					$Last=pop (@subs);
					$cat=join(":", @subs);
				}
				$Param{'Cat_ID'}=$Category_ID{$cat};
	}

	&Category_Manager;

}
#==========================================================
sub Create_Category{
my $NewCat;
my $ID;
my $Cat;
my $CatURL;
my $Accept;
my $Active;
my $Count;
my $SortNum;
my $Under_Flag;
my $Description;
my @NewCats;
	
	undef @NewCats;
	@NewCats=split(/\n/,	 $Param{'New_Categories_Names'});

	&Prepare_Categories;

	foreach $NewCat (@NewCats) {
		$NewCat =~ s/\n//g;
		$NewCat =~ s/\r//g;
        $NewCat =~ s/\cM//g;
		$NewCat=~ s/^\s+//g;
		$NewCat=~ s/\s+$//g;

	if ($NewCat  ne  "") {
		$ID=&Get_New_Category_ID;
		$Cat="";

		if ($Param{'Cat_ID'} ne ""){
				$Cat=$Category_Root{$Param{'Cat_ID'}};
		}

		if ($Cat eq  "") {
					$CatURL="$NewCat||";
					$Accept=0;
		}
		else{
					$CatURL="$Cat|$NewCat|";
					$Accept=1;
		}

		$Active=1;
		$Count=0;
		$SortNum=0;
		$Under_Flag=0;
		$Description="";
		#qw(Category SubCategory ID Active Accept Count SortNum Under_Flag Description)}
		$CatURL.="$ID|$Active|$Accept|$Count|$SortNum|$Under_Flag|$Description";
		&Save_Category($ID, $CatURL);
	 } #end if
	} #end foreach

	&Category_Manager;
	#&Admin_Msg("Category created", "$Out", 2, 700);

}
#==========================================================
sub Guide_Bar{
my $Out="";
my $Cat;
my $CatLink;
my @URLs;
my $Home;
my ($x, $Last, $Catbar, $Caturl, $ID, $Catname);

	$Home="<A HREF=$Script_URL?action=Category_Manager&Cat_ID=>Top</A>";

	$Cat=$Category_Root{$Param{'Cat_ID'}};

	@URLs=split(/:/, $Cat);
	$Last=pop (@URLs);
	
	if ($#URLs>=0) {
	 for ($x=$#URLs; $x>=0 ; $x--) {
		$Catname=$URLs[$x];
		$Caturl=join(":", @URLs);
		$ID=$Category_ID{$Caturl}; 
		$Catbar[$x]= qq!<A HREF="$Script_URL?action=Category_Manager&Cat_ID=$ID">$Catname</A>!;
	 	pop (@URLs);
	 }
	}

	$Cat=join("$Global{'MenuLine_Separator'}", @Catbar);

	if ($Cat ne "") {
			$Cat="$Cat$Global{'MenuLine_Separator'}$Last";
	}
	else{
			$Cat="$Last";
	}

	return "$Home$Global{'MenuLine_Home'}$Cat";
}
#==========================================================
sub Edit_Category_Form{
my $Out="";
my $cat="";
my$ID;
my $Active;
my $Accept;
my $Category_TFlag;
my %caturl;
my @Cat;
my ($Description, $caturl);
my($Help);

	$Help=&Help_Link("Category_Manager");

	&Prepare_Categories;

	$caturl= $Category_Root{$Param{'Cat_ID'}};
	@Cat= split(/:/, $caturl);
	$cat=pop @Cat;

	$Accept="";
	if ($Category_Accept{$caturl}){
			$Accept="CHECKED";
	}
	$Active="";
	if ($Category_Active{$caturl}){
			$Active="CHECKED";
	}
	
	$Category_TFlag="";
	if ($Category_TFlag{$caturl}){
			$Category_TFlag="CHECKED";
	}

$Description=$Category_Description{$caturl};
$Description=~ s/~\#~/\cM/g;

$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Save_Edit_Category">
<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Category
                  Configuration</font></b></p>
                </td>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC" align="center">
          <div align="center">
            <center>
            <table border="0" width="80%">
              <tr>
                <td width="100%" colspan="2" bgcolor="#cFFFEF">
				<b>
				<font color="#000080">

				TOP::$caturl

				</font>
				</b>
				</td>
              </tr>


              <tr>
                <td width="34%">Category ID #</td>
                <td width="66%">

					$Category_ID{$caturl}

				</td>
              </tr>

			  <tr>
                <td width="34%">Category Active:</td>
                <td width="66%">
					<input type="checkbox" name="Active" value="YES" $Active>
					</td>
              </tr>
              <tr>
                <td width="34%">Accept Submissions:</td>
                <td width="66%">
					<input type="checkbox" name="Accept" value="YES" $Accept>
				</td>
              </tr>
              <tr>
                <td width="34%">Show Under Parent Category:</td>
                <td width="66%">
					<input type="checkbox" name="Under_Flag" value="YES" $Category_TFlag>
				</td>
              </tr>
              <tr>
                <td width="34%">Sort Order:</td>
                <td width="66%">
					<input type="text" name="SortNum" size="15" value="$Category_SortNum{$caturl}" onFocus="select();">
					</td>
              </tr>

              <tr>
                <td width="34%">Category Name</td>
					<td width="66%"><input type="text" name="Category_Name" size="40" onFocus="select();" value="$cat">
				</td>
              </tr>

              <tr>
                <td width="34%"><b>Description:</b></td>
                <td width="66%"></td>
              </tr>
              <tr>
                <td width="100%" colspan="2">
					<textarea rows="5" name="Description" cols="65">$Description</textarea>
				</td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes" name="Save_Changes">
          &nbsp;
		   <input type="reset" value="Clear Form">&nbsp; 
		  <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
return $Out;

}
#==========================================================
sub Delete_Category_Confirmation_Form{
my $Out;
my $Cats=shift;
my $Cat;
my($Help);

	$Help=&Help_Link("Category_Manager");


$Cat= $Category_Root{$Param{'Cat_ID'}};

$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Delete_Category">
<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">


  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="0" cellpadding="4">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Delete
                  Category!</font></b></p>
                </td>
                <td width="192">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC" align="center">
          <p align="center">&nbsp;</p>
          <p align="center"><b><font color="#FF0000" size="5">Are you sure you
          want to delete this category and all its subcategories</font></b></p>
          <p align="center"></td>
      </tr>
	  
	  <tr><td align="center" size=3 bgcolor="#B6DEDC">
	  <B><Font color=red ><U>Category:</U></font>  $Cat </B>
	  </td></tr>
	  <tr><td align="left" size=3 bgcolor="#B6DEDC">
	  <B><Font color=red ><U>Subcategories:</U></font>
	  <br>

	  $Cats

	   </B>
	  </td></tr>

      <tr>
        <td width="100%" height="25" bgcolor="#B6DEDC"><br>
          <p align="center">
		  <input type="submit" value="Delete it!"> &nbsp; 
		  <input onclick="history.go(-1);" type="button" value="Cancel">
		  <br>
		  </td>
      </tr>
	  <tr><td bgcolor="#B6DEDC">
	   &nbsp; 
	  </td></tr>
    </table>
    </center>
  </div>
</form>

HTML

	return $Out;
}
#==========================================================================
sub Category_Manager{
my $Required_Category;
my ($cat, $LL,$url, $x);
my ($catname, $Out);
my ($Active, $Accept, $Line);
my ($Under, $Sort, $ID, @Categories);
my ($editlink, $deletelink, $catlink);

	&Prepare_Categories;

	if (!defined $Param{'Cat_ID'}) {$Param{'Cat_ID'}="";	}
	$Required_Category=$Category_Root{$Param{'Cat_ID'}} ;
	
	@Categories = &Get_Sub_Categories($Required_Category);
	
	$Out="";
	
	foreach $cat(@Categories) {
			$ID=$Category_ID{$cat};
			$catname=$Category_Name{$ID};
			$url="$Script_URL?action=Category_Manager&Cat_ID=$ID";
			$catlink=qq!<A HREF="$url"><B>$catname</B></A>!;
			$url="$Script_URL?action=Edit_Category&Cat_ID=$ID";
			$editlink=qq!<A HREF="$url"><B>Edit</B></A>!;
			$url="$Script_URL?action=Delete_Category_Confirm&Cat_ID=$ID";
			
			#$deletelink=qq!<A HREF="javascript:Confirmation('Are you sure you want to delete this category and its subcategories?: $catname',?action=Delete_Category&Cat_ID=$ID')"><B>Delete</B></A>!;
			$deletelink=qq!<A HREF=$url><B>Delete</B></A>!;

			$Active = $Category_Active{$cat};
			$Accept = $Category_Accept{$cat};
			$Under = $Category_TFlag{$cat};
			$Sort =	 $Category_SortNum{$cat};

			$Line=&Category_Manager_Line($catlink,$Active,$Accept,$Under,$Sort,$editlink,$deletelink);
			$Out.=$Line;
	}			

	&Print_Page(&Category_Manager_Form($Out) );

}
#==========================================================
sub Category_Manager_Line{
my ($catlink,$Active,$Accept,$Under,$Sort,$editlink,$deletelink)=@_;
my ($YES, $No, $Out);
my ($Active_Image, $Accept_Image, $Under_Image);

	$Yes=qq!<img border="0" src="$Global{'Yes_Image'}" alt="YES">!;
	$No=qq!<img border="0" src="$Global{'No_Image'}" alt="NO">!;

if ($Active) {
	$Active_Image=$Yes;
}
else{
	$Active_Image=$No;
}

if ($Accept) {
	$Accept_Image=$Yes;
}
else{
	$Accept_Image=$No;
}


if ($Under) {
	$Under_Image=$Yes;
}
else{
	$Under_Image=$No;
}

$Out=<<HTML;
			<tr>
              <td width="93%" bgcolor="#DFFFE8">
						$catlink
			  </td>
              <td width="11%" bgcolor="#DFFFE8" valign="middle" align="center">
						$Active_Image
			  </td>
				<td width="11%" valign="middle" align="center" bgcolor="#DFFFE8">
						$Accept_Image
			  </td>
			  <td width="8%" valign="middle" align="center" bgcolor="#DFFFE8">
						$Under_Image
			  </td>
              <td width="12%" valign="middle" align="center" bgcolor="#DFFFE8">
						$Sort
			  </td>
              <td width="10%" valign="middle" align="center" bgcolor="#DFFFE8">
						$editlink
			 </td>
              <td width="9%" valign="middle" align="center" bgcolor="#DFFFE8">
						$deletelink
			  </td>
            </tr>
HTML

return $Out;

}
#==========================================================
sub Category_Manager_Form{
my $Line_Body=shift;
my $Out="";
my $Guide_Bars;
my $Category_Tree_Link;
my $Update_Category_Count;
my($Help);

	$Help=&Help_Link("Category_Manager");

	$Guide_Bars=&Guide_Bar;
	$Category_Tree_Link=qq!$Global{'G1_Bullet'}<A HREF="$Script_URL?action=Category_Tree">Category Tree</A>!;
	$Update_Category_Count=qq!$Global{'G1_Bullet'}<A  HREF="#" onClick="window.open('$Script_URL?action=Update_Category_Count','Category_Manager','WIDTH=620,HEIGHT=400,scrollbars=yes,resizable=yes,left=50,top=50,screenX=150,screenY=100');return false">Update Categories Count</font></A>!;

$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Create_Category">
<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">


  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="8" height="380">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="148"></td>
                <td valign="middle" align="center" width="437">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Category
                  Manager</font></b></p>
                </td>
                <td width="150">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="50%" height="18" bgcolor="#B6DEDC">
          <font color="#000000" face="Verdana,Arial, Helvetica" size="2">
	  
		  $Guide_Bars

		  </font>
		 </td>
      </tr>

      <tr width= 100%>
        <td  align="right" height="18" bgcolor="#B6DEDC">
          <font color="#000000" face="tahoma,Verdana,Arial, Helvetica" size="3">
			
			<b>$Category_Tree_Link</b>&nbsp;&nbsp;
			<b>$Update_Category_Count</b>
			<br><br>

		  <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
            <tr>
              <td width="100%" bgcolor="#004800">
                <p align="center"><font color="#00FF00"><b>Category</b></font></td>
              <td width="11%" bgcolor="#004800" valign="middle" align="center"><font color="#00FF00"><b>Active</b></font></td>
              <td width="11%" valign="middle" align="center" bgcolor="#004800"><font color="#00FF00"><b>Accept</b></font></td>
              <td width="8%" valign="middle" align="center" bgcolor="#004800"><font color="#00FF00"><b>Under</b></font></td>
              <td width="12%" valign="middle" align="center" bgcolor="#004800"><font color="#00FF00"><b>Sort</b></font></td>
              <td width="19%" valign="middle" align="center" bgcolor="#004800" colspan="2"><font color="#00FF00"><b>Action</b></font></td>
            </tr>

		$Line_Body
		  
		  </table>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top" align="left">
          <b><font color="#800000">Create New Categories:</font></b>
          <div align="left">
            <table border="0" width="100%">
              <tr>
                <td valign="top" align="left">
				
				<textarea rows="7" name="New_Categories_Names" cols="53"></textarea></td>

                <td valign="top" align="left">Please write each category name on
                  one line and press enter at the end of each line. Categories
                  will be created under the current category shown by the guide
                  bar. You may create categories as many as you need.
                  <p>&nbsp;</td>
              </tr>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td width="100%" bgcolor="#B6DEDC" valign="top" align="center">
          <p align="center">
		  <input type="submit" value="Create Categories">
		  <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML

return $Out;

}

#==========================================================
sub 	File_Upload_Options{

	&Print_Page(&File_Upload_Options_Form);

}
#==========================================================
sub Save_File_Upload_Options{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");


	$data{'Allow_File_Upload'}= $Param{'Allow_File_Upload'};
	$data{'Max_Upload_Files'}= $Param{'Max_Upload_Files'};
	$data{'Max_Upload_File_Size'}= $Param{'Max_Upload_File_Size'};
	$data{'Max_Upload_Size'}= $Param{'Max_Upload_Size'};
	$data{'Upload_Any_File'}= $Param{'Upload_Any_File'};
	$data{'Files_Ext_Allowed'}= $Param{'Files_Ext_Allowed'};

	untie %data;
	undef %data;

	&Admin_Msg("Options Saved", "File Upload Options Successfully Saved.",2);

}
#==========================================================
sub Category_Options{

	&Print_Page(&Category_Options_Form);

}
#==========================================================
sub Save_Category_Options{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Category_Columns'}=$Param{'Category_Columns'};
	$data{'Category_Browse_Columns'}=$Param{'Category_Browse_Columns'};
	$data{'Homepage_Category_Columns'}=$Param{'Homepage_Category_Columns'};
	$data{'Under_Separator'}=$Param{'Under_Separator'};
	$data{'Home_Page_Under_Separator'}=$Param{'Home_Page_Under_Separator'};
	$data{'Category_HSpace'}=$Param{'Category_HSpace'};
	$data{'Category_VSpace'}=$Param{'Category_VSpace'};
	$data{'Category_Border'}=$Param{'Category_Border'};
	$data{'MenuLine_Separator'}=$Param{'MenuLine_Separator'};
	$data{'MenuLine_Home'}=$Param{'MenuLine_Home'};
	$data{'Category_Unders_Mode'}  =$Param{'Category_Unders_Mode'};
	$data{'Category_Count'}=$Param{'Category_Count'};
	$data{'Under_Category_Count'}=$Param{'Under_Category_Count'};
	
	$data{'Category_Folder'}=$Param{'Category_Folder'};
	$data{'Category_Folder_Image'}=$Param{'Category_Folder_Image'};
	$data{'Homepage_Category_Folder_Image'}=$Param{'Homepage_Category_Folder_Image'};
	$data{'Unique_Homepage_Category_Folder'}=$Param{'Unique_Homepage_Category_Folder'};

	$Param{'Category_Form'}=~ s/\cM//g;
	$data{'Category_Form'}=$Param{'Category_Form'};
	$Param{'Under_Category_Form'}=~ s/\cM//g;
	$data{'Under_Category_Form'}=$Param{'Under_Category_Form'};
	
	untie %data;
	undef %data;

	&Admin_Msg("Category Options Saved", "Category Options Successfully Saved.",2);

}
#==========================================================
sub Configuration{

	&Print_Page(&Configuration_Form);

}
#==========================================================
sub Reset_Permissions {
my($Out);

	$Out= "<center><b><font color=red size=6>Setting System Permissions</font></b></center><BR><BR>\n";

	$Out.="<p align=\"left\">";

	$Out.= "<font color=blue> Main CGI Directory            ...Finished</font><BR>\n";
	 system("chmod -R 755  $Global{'BaseDir'}/*.cgi  $Global{'BaseDir'}/*.pm  $Global{'BaseDir'}/*.shtml");

	 $Out.="<font color=blue> Main HTML Directory            ...Finished</font><BR>\n";
	 system("chmod -R 755 $Global{'HtmlDir'}");

	$Out.= "<font color=blue> Data Directory            ...Finished</font><BR>\n";
	system("chmod -R 777 $Global{'DataDir'}");

	$Out.="<font color=blue> Backup Directory             ...Finished</font><BR>\n";
	system("chmod -R 777 $Global{'HtmlDir'}/backup");

	$Out.="<font color=blue> Upload Directory             ...Finished</font><BR>\n";
	system("chmod -R 777 $Global{'HtmlDir'}/upload");

	$Out.="<font color=Green>If you are on Windows system, or non Unix System, this function will not work for you, Please check your server manual for setting permisssions</font><BR>\n";
	
	$Out.= qq!<I><CENTER><A HREF="javascript:history.go(-1)">
										Back to Previous Page</A></I></CENTER>!;

	&Print_Page($Out);

 }
#==========================================================
sub  Save_Configuration{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'CGI_URL'}=$Param{'CGI_URL'};
	$data{'HTML_URL'}=$Param{'HTML_URL'};
	$data{'HtmlDir'}=$Param{'HtmlDir'};
	$data{'BaseDir'}=$Param{'BaseDir'};

	$data{'SSL_Status'}=$Param{'SSL_Status'};
	$data{'SSL_URL'}=$Param{'SSL_URL'};
	
	$data{'Site_Name'}=$Param{'Site_Name'};
	
	$data{'Webmaster_Email'}=$Param{'Webmaster_Email'};
	$data{'Auction_Email'}=$Param{'Auction_Email'};
	$data{'Contact_Us_Email'}=$Param{'Contact_Us_Email'};
	$data{'Mail_Program_Type'}=$Param{'Mail_Program_Type'};
	$data{'Mail_Program_Or_SMTP_Server'}=$Param{'Mail_Program_Or_SMTP_Server'};
	

	$data{'Admin_UserID'}=$Param{'Admin_UserID'};
	$data{'Admin_Password'}=$Param{'Admin_Password'};

	$data{'MainProg_Name'}=$Param{'MainProg_Name'};
	$data{'AdminProg_Name'}=$Param{'AdminProg_Name'};

	$data{'CGI_Extension'}=$Param{'CGI_Extension'};
	$data{'GMT_Offset'}=$Param{'GMT_Offset'};
	$data{'Admin_Help_Window_Width'}=$Param{'Admin_Help_Window_Width'};
	$data{'Admin_Help_Window_Height'}=$Param{'Admin_Help_Window_Height'};

	untie %data;
	undef %data;

	&Admin_Msg("Configuration Saved", "Program Configuration Successfully Saved.",2);

}
#==========================================================
sub Admin_Body{
my $Out="";
my($Help);

	$Help=&Help_Link("Main", 1);

$Out=<<HTML;
<html>

<head>
<TITLE>Mewsoft - Online Business Software Solutions</TITLE>
<META name="description" content="Mewsoft Auction Software Is A Fully Multilingual Auction Software Solution Designed For Any Size Business, Comes Complete With All Source Code In Perl.">
<META name="keywords" content="auction software, software auction, auction management software, internet auction software, auction and software, auction bid software, online auction software, online software auction, online auction & software, where can i get software for online auction, online and auction and software, software for online auction, auction program, auction and program, program auction, auction bidding program, auction affiliate program, auction software program, classified ad software, classified software, consulting software computer classified, classified ad submission software, classified advertising software, classified ad software program, business software, internet business software, small business software, small business accounting software, business management software, custom business software, software solution, auction software solution, custom software solution, b2b ecommerce software solution, ecommerce solution software, internet software solution, b2b software solution">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">

<SCRIPT LANGUAGE="JavaScript">
<!--
//	DISCLAIMER & COPYRIGHT
//	This script idea has been created for specific use at www.mewsoft.com
//	Using this on any other site without permission and payment
//	is strictly prohibited and will be treated as violation of copyright law.
//	For further information please contact webmaster\@mewsoft.com

is_ns4up = (document.layers)? true:false
is_ie4up = (document.all)? true:false

function showIt(id) {
        if (is_ns4up) document.layers[id].visibility = "show"
        else if (is_ie4up) document.all[id].style.visibility = "visible"
}

function hideIt(id) {
        if (is_ns4up) document.layers[id].visibility = "hide"
        else if (is_ie4up) document.all[id].style.visibility = "hidden"
}
//-->
</SCRIPT>

<style type="text/css">
<!--
a            { color: #00344B; font-family: 'Arial,MS Sans serif', verdana, tahoma; font-size: 12px; font-weight: bold; text-decoration: none }
a:hover      { color: #00a0c0; text-decoration: underline }

.hilite      {position: relative; visibility: hidden}
.navbar  a    {color: #00e0e0; font-family: 'Arial,MS Sans serif, verdana, tahoma'; font-size: 13px; font-weight: bold;}
.navbar  a:hover { color: #ffffc0; font-family: 'Arial,MS Sans serif, verdana, tahoma'; font-size: 13px; font-weight: bold;}

#blocks      { text-align: justify }
ul           { list-style-type: square; color: #c60000 }
#label1      { color: #000040; font-size: 14px; font-family: 'ms sans serif', verdana, tahoma }
#label2      { color: #000040; font-size: 13px; font-family: 'ms sans serif', verdana, tahoma; 
               font-weight: bold }
.navlnk a       { font-family: Arial, Helvetica; color: #00e0e0; font-size: 12px; 
               text-decoration: none; font-weight: bold }
.navlnk a:hover { font-family: Arial, Helvetica; color: #B9E9FF; font-size: 12px; text-decoration: underline }
                    
-->
</style>
</head>

<body background="$Global{'ImagesDir'}/msbg.jpg" bgcolor="#ffffee" text="#000040" link="#ffffc0" vlink="#ffffc0" alink="#00c0c0" leftmargin="5" topmargin="3" marginheight="3" marginwidth="5">


<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#000040">
  <tr>
    <td><a href="https://www.safeweb.com/o/_i:http://www.mewsoft.com"><img border="0" src="$Global{'ImagesDir'}/mewsoftlogo.jpg" width="232" height="72"></a></td>
    <td align="right">
      <p align="center"><font color="#CAEEFF" size="5"><b>Auction Administration</b></font></td>
  </tr>
</table>
<table border="0" width="100%" bgcolor="#800000" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><img border="0" src="$Global{'ImagesDir'}/dot_red2x2.gif" width="2" height="2"></td>
  </tr>
</table>
<table border="0" width="100%" bgcolor="#000000" cellpadding="2">
  <tr>
    <td class="navlnk" width="70%" align="left" nowrap><font color="#CAEEFF"><b><a href="$Script_URL">Home</a> |
      <a href="$Global{'Auction_Script_URL'}" target="_blank">Auction</a> | $Help | <a href="$Script_URL?action=About"> About</a> |
      <a href="$Script_URL?action=Upgrade"> Upgrade</a></b></font></td>
    <td class="navlnk" width="30%" align="right" nowrap><b><font color="#CAEEFF"><a href="https://www.safeweb.com/o/_i:http://www.mewsoft.com" target="_blank">Mewsoft</a></font></b></td>
  </tr>
</table>

<table border="0" width="100%" bgcolor="#FF9224" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%"><img border="0" src="$Global{'ImagesDir'}/dot_yel2x2.gif" width="2" height="2"></td>
  </tr>
</table>

<table border="0" width="100%" cellspacing="3" cellpadding="0" bgcolor="#006080">
  <tr>
    <td width="160" valign ="top" align="left">

      <table border="0" width="100%" cellspacing="1" cellpadding="0">
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot1"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Configuration" target="_top" onmouseover="showIt('dot1');return true" onmouseout="hideIt('dot1');return true">Configuration</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot2"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=General_Options" target="_top" onmouseover="showIt('dot2');return true" onmouseout="hideIt('dot2');return true">General
            Options</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot3"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Category_Manager" target="_top" onmouseover="showIt('dot3');return true" onmouseout="hideIt('dot3');return true">Category
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot4"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Language_Manager" target="_top" onmouseover="showIt('dot4');return true" onmouseout="hideIt('dot4');return true">Language
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot5"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Billing_Manager" target="_top" onmouseover="showIt('dot5');return true" onmouseout="hideIt('dot5');return true">Billing
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot6"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Users_Manager" target="_top" onmouseover="showIt('dot6');return true" onmouseout="hideIt('dot6');return true">Users
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot7"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Fees_Setup" target="_top" onmouseover="showIt('dot7');return true" onmouseout="hideIt('dot7');return true">Fees
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot8"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Auctions_Manager" target="_top" onmouseover="showIt('dot8');return true" onmouseout="hideIt('dot8');return true">Auctions
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot9"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Database_Manager" target="_top" onmouseover="showIt('dot9');return true" onmouseout="hideIt('dot9');return true">Database
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot10"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Mail_Manager" target="_top" onmouseover="showIt('dot10');return true" onmouseout="hideIt('dot10');return true">Mail
            Manager</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot11"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Web_Editor" target="_top" onmouseover="showIt('dot11');return true" onmouseout="hideIt('dot11');return true">Template
            Editor</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot12"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Custom_Class" target="_top" onmouseover="showIt('dot12');return true" onmouseout="hideIt('dot12');return true">Script
            Editor</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot13"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Category_Options" target="_top" onmouseover="showIt('dot13');return true" onmouseout="hideIt('dot13');return true">Category
            Options</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot14"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=General_Classes" target="_top" onmouseover="showIt('dot14');return true" onmouseout="hideIt('dot14');return true">General
            Classes</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot15"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Listing_Options" target="_top" onmouseover="showIt('dot15');return true" onmouseout="hideIt('dot15');return true">Listing
            Options</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot16"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=File_Upload_Options" target="_top" onmouseover="showIt('dot16');return true" onmouseout="hideIt('dot16');return true">File
            Upload Options</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot17"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span><a href="$Script_URL?action=Edit_Announcements" target="_top" onmouseover="showIt('dot17');return true" onmouseout="hideIt('dot17');return true">
            Announcements</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot18"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Automation" target="_top" onmouseover="showIt('dot18');return true" onmouseout="hideIt('dot18');return true">Automation
            Control</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot19"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Lock_Access" target="_top" onmouseover="showIt('dot19');return true" onmouseout="hideIt('dot19');return true">Lock
            Access</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot20"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Server_Backup" target="_top" onmouseover="showIt('dot20');return true" onmouseout="hideIt('dot20');return true">Server
            Backup</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot21"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Commander" target="_top" onmouseover="showIt('dot21');return true" onmouseout="hideIt('dot21');return true">Telnet
            Commander</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot22"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Server_Test" target="_top" onmouseover="showIt('dot22');return true" onmouseout="hideIt('dot22');return true">Server
            Configuration</a></td>
        </tr>
        <tr>
           <td  class="navbar" bgcolor="#000045" nowrap>&nbsp;<span class="hilite" id="dot23"><img src="$Global{'ImagesDir'}/msdot1.gif" border="0" width="10" height="10"></span>&nbsp;<a href="$Script_URL?action=Reset_Permissions" target="_top" onmouseover="showIt('dot23');return true" onmouseout="hideIt('dot23');return true">Reset
            Permissions</a></td>
        </tr>
      </table>
    </td>

    <td bgcolor="#B6DEDC" valign="top" align="left">
	
	<<BODY>> 


	</td>
	</tr>
</table>


      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td width="100%" bgcolor="#000045"><img src="$Global{'ImagesDir'}/msdot1x1.gif" border="0" width="1" height="1"></td>
        </tr>
      </table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#006080">
        <tr>
          <td width="100%"><center><font face="ms sans serif,verdana" size="1" color="#80ffff">Copyright&nbsp;<font size="2"><b>©</b></font>&nbsp;2001
            Mewsoft. All Rights Reserved.</font></center></td>
        </tr>
      </table>

</body>

</html>

HTML
	return $Out;

}
#==========================================================
sub Configuration_Form{
my ($Out, $GMT, $Check, $x, $y, @Check, $Mail_Program);
my($Help);

	$Help=&Help_Link("Configuration");


	$Check = "";
	$GMT = "";
	     
	for ($x=-12; $x<=12; $x+=0.25) {
		$Check="";
		if ($x == $Global{'GMT_Offset'} ) { $Check="selected"};
		$y=$x;
		if ($x>0){ $y="+".$y;}
		$GMT.=qq!<option value=$x $Check>$y!;
	}



$Check[0]=""; $Check[1]=""; $Check[2]=""; $Check[3]="";
$Check[$Global{'Mail_Program_Type'}]="selected";
$Mail_Program=qq!<select name="Mail_Program_Type" size=1>
								<option value=1  $Check[1]>Blat (Windows)</option>
								<option value=0 $Check[0] >Sendmail (Unix)</option>
								<option value=3  $Check[3]>SMTP (Unix / Windows)</option>
								<option value=2  $Check[2]>Windmail (Windows)</option>
								<option value=4 $Check[4] >Sendmail.pm (Unix/Windows)</option>
								</select>
								!; 

$SSL=qq!<select name ="SSL_Status" size ="1">!;
if ($Global{'SSL_Status'} eq "YES") {
			$SSL.=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
}
else{
			$SSL.=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
}
$SSL.="</select>";


$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Save_Configuration">


  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
                  <div align="center">
                    <center>
                    <table border="0" width="738" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="middle" align="center" width="67"></td>
                        <td valign="middle" align="center" width="589">
                  <p align="center"><font color="#00FFFF" face="Tahoma" size="4"><b>Program Configuration</b></font></p>
                        </td>
                        <td valign="middle" align="center" width="76">$Help</td>
                      </tr>
                    </table>
                    </center>
                  </div>
        </td>
      </tr>
      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<font face="Times New Roman">Site Name:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Site_Name" size="40" value="$Global{'Site_Name'}" onFocus="select();"></td>
      </tr>


      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		CGI Directory:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="BaseDir" size="40" value="$Global{'BaseDir'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  CGI Directory URL:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="CGI_URL" size="40" value="$Global{'CGI_URL'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		HTML Directory:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="HtmlDir" size="40" value="$Global{'HtmlDir'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  HTML Directory URL:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="HTML_URL" size="40" value="$Global{'HTML_URL'}" onFocus="select();"></td>
      </tr>
	  
	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Use Secure Server:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
			$SSL	
		</td>
      </tr>

	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Secure Server URL:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="SSL_URL" size="40" value="$Global{'SSL_URL'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Select mail program and platform:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">

		$Mail_Program
		
		</td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Location of mail program(or SMTP server address):</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Mail_Program_Or_SMTP_Server" size="40" value="$Global{'Mail_Program_Or_SMTP_Server'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Main Program Name:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="MainProg_Name" size="40" value="$Global{'MainProg_Name'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Main Admin Program Name:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="AdminProg_Name" size="40" value="$Global{'AdminProg_Name'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Admin Help Screen Width:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Admin_Help_Window_Width" size="40" value="$Global{'Admin_Help_Window_Width'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Admin Help Screen Height:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Admin_Help_Window_Height" size="40" value="$Global{'Admin_Help_Window_Height'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Webmaster E-mail Address:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Webmaster_Email" size="40" value="$Global{'Webmaster_Email'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<font face="Times New Roman">
		Contact Us E-mail Address:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Contact_Us_Email" size="40" value="$Global{'Contact_Us_Email'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC"><font face="Times New Roman">
		Auction E-mails Reply-to Address:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC">
		<input type="text" name="Auction_Email" size="40" value="$Global{'Auction_Email'}" onFocus="select();"></td>
      </tr>
	  
	  <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Admin User ID:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC"><input type="text" name="Admin_UserID" size="40" value="$Global{'Admin_UserID'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%" height="23" bgcolor="#B6DEDC">
                  <font face="Times New Roman">
                  Admin Password:</font></td>
        <td width="50%" height="23" bgcolor="#B6DEDC"><input type="text" name="Admin_Password" size="40" value="$Global{'Admin_Password'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%" height="26" bgcolor="#B6DEDC"><font face="Times New Roman">Time Offset
                  Based on GMT in Hours(-12.00 to +12.00)</font></td>

        <td width="50%" height="26" bgcolor="#B6DEDC">
				<input type="text" name="GMT_Offset" size="5" value="$Global{'GMT_Offset'}" onFocus="select();">
		</td>
      </tr>

      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> 
		  <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel">
		  </td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML

return $Out;

}
#==========================================================
sub Save_General_Options{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Regular_Font_Color'}=$Param{'Regular_Font_Color'};
	$data{'Maximum_Search_Results'}=$Param{'Maximum_Search_Results'};
	$data{'Time_Format'}=$Param{'Time_Format'};
	
	$data{'Email_X_Priority'}=$Param{'Email_X_Priority'};
	$data{'Admin_Users_Per_Page'}=$Param{'Admin_Users_Per_Page'};

	$data{'Email_Format'}=$Param{'Email_Format'};

	$data{'Comments_Per_Page'}=$Param{'Comments_Per_Page'};
	$data{'Regular_Font_Size'}=$Param{'Regular_Font_Size'};
	$data{'Regular_Font_Face'}=$Param{'Regular_Font_Face'};
		
	$data{'Category_Tree_Root_Font_Size'} =$Param{'Category_Tree_Root_Font_Size'};
	$data{'Category_Tree_Root_Font_Face'}=$Param{'Category_Tree_Root_Font_Face'};
	$data{'Category_Tree_Root_Font_Color'}=$Param{'Category_Tree_Root_Font_Color'};
	$data{'Category_Tree_Sub_Font_Size'}=$Param{'Category_Tree_Sub_Font_Size'};
	$data{'Category_Tree_Sub_Font_Face'}=$Param{'Category_Tree_Sub_Font_Face'};

	$data{'Currency_Symbol'}=$Param{'Currency_Symbol'};
	$data{'Require_Credit_Card'}=$Param{'Require_Credit_Card'};
	$data{'Resubmit_Number'}=$Param{'Resubmit_Number'};

	$Param{'Search_Prefix'}=~ s/\cM//g;
	$data{'Search_Prefix'}=$Param{'Search_Prefix'};
	$Param{'Search_Suffix'}=~ s/\cM//g;
	$data{'Search_Suffix'}=$Param{'Search_Suffix'};

	$Param{'Duration_Days'}=~ s/\s+//g;
	$data{'Duration_Days'}=$Param{'Duration_Days'};

	untie %data;
	undef %data;

	&Admin_Msg("General Options Saved", "General Options Successfully Saved.",2);

}
#==========================================================
sub General_Options{
	
	&Print_Page(&General_Options_Form);

}
#==========================================================
sub General_Options_Form{
my ($Out, $CCard, $Prefx, $Sufx) ="";
my($Help);

	$Help=&Help_Link("General_Options");

	$CCard=qq!<select name ="Require_Credit_Card" size ="1">!;
	if ($Global{'Require_Credit_Card'} eq "YES") {
			$CCard.=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$CCard.=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}
	$CCard.="</select>";

	$Prefx=&Encode_HTML($Global{'Search_Prefix'});
	$Sufx=&Encode_HTML($Global{'Search_Suffix'});

	$Time_Format[0] = "mm/dd/yyyy";
	$Time_Format[1] = "dd/mm/yyyy";
	$Time_Format[2] = "yyyy/mm/dd";
	$Time_Format[3] = "yyyy/dd/mm";
	$Time_Format[4] = "mm/dd/yyyy HH:MM AM/PM";
	$Time_Format[5] = "dd/mm/yyyy HH:MM AM/PM";
	$Time_Format[6] = "yyyy/mm/dd HH:MM AM/PM";
	$Time_Format[7] = "yyyy/dd/mm HH:MM AM/PM";
	$Time_Format[8] = "Month dd, yyyy";
	$Time_Format[9] = "Weekday, Month dd, yyyy";
	$Time_Format[10] = "Weekday, dd Month yyyy HH:MM AM/PM";
	$Time_Format[11] = "Weekday, Month dd, yyyy HH:MM AM/PM";

	$Time_Format = "";
	for $x(0..11){
	$Selected = "";
	if ($x == $Global{'Time_Format'}){$Selected = "selected";}
	$Time_Format .= qq!<OPTION VALUE="$x" $Selected>$Time_Format[$x]</OPTION>!;
	}

	$Email_Format=qq!<select name ="Email_Format" size ="1">!;
	if ($Global{'Email_Format'} == 1) {
			$Email_Format.=qq!<option selected value="1">HTML</option>
												<option value="0">Text</option>!;
	}
	else{
			$Email_Format.=qq!<option value=1>HTML</option>
												<option  selected  value=0>Text</option>!;
	}
	$Email_Format.="</select>";

$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Save_General_Options">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5" height="379">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center" height="33">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15%"></td>
                <td width="69%" align="center">
                  <p align="center"><b><font size="4" face="Tahoma" color="#00FFFF">General
          Options&nbsp;</font></b></p>
                </td>
                <td width="16%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
           Require Credit Card for Registration:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
			$CCard
		</td>
      </tr>


	  
	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
          Default Currency Symbol:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Currency_Symbol" size="10" value="$Global{'Currency_Symbol'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">None Class Based Date-Time Format:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Time_Format">
				$Time_Format
			</select>
		  </td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
           Maximum Number for Search results:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Maximum_Search_Results" size="10" value="$Global{'Maximum_Search_Results'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
           Default Feedback Forum Comments Per Page:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Comments_Per_Page" size="10" value="$Global{'Comments_Per_Page'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
           Number of Times allowed for Auto Resubmit:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Resubmit_Number" size="10" value="$Global{'Resubmit_Number'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
          Allowed Auctions Periods, Separate With Comma:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Duration_Days" size="45" value="$Global{'Duration_Days'}" onFocus="select();"></td>
      </tr>

	  
	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
           Search Terms in Search Results Tags:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Search_Prefix" size="30" value="$Prefx" onFocus="select();">
		&nbsp;
		<input type="text" name="Search_Suffix" size="15" value="$Sufx" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
                  Outgoing Email Format:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		$Email_Format
		</td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
                 Outgoing Email X-Priority:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Email_X_Priority" size="10" value="$Global{'Email_X_Priority'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
                 Admin Users Per Page:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Admin_Users_Per_Page" size="10" value="$Global{'Admin_Users_Per_Page'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">
                  Regular Font Size:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Regular_Font_Size" size="10" value="$Global{'Regular_Font_Size'}" onFocus="select();"></td>
      </tr>

	  <tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
                  Regular Font Face:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Regular_Font_Face" size="40" value="$Global{'Regular_Font_Face'}" onFocus="select();"></td>
      </tr>
		
	  <tr>
        <td width="50%" height="25" bgcolor="#B6DEDC">Regular Font Color:</td>
        <td width="50%" height="25" bgcolor="#B6DEDC">
		<input type="text" name="Regular_Font_Color" size="20" value="$Global{'Regular_Font_Color'}" onFocus="select();"></td>
      </tr>

		<tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
            Category Tree Root-categories Font Size:</td>
            <td width="50%" height="25" bgcolor="#B6DEDC">
		    <input type="text" name="Category_Tree_Root_Font_Size" size="10" value="$Global{'Category_Tree_Root_Font_Size'}" onFocus="select();">
		   </td>
      </tr>

		<tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
            Category Tree Root-categories Font Face:</td>
            <td width="50%" height="25" bgcolor="#B6DEDC">
		    <input type="text" name="Category_Tree_Root_Font_Face" size="40" value="$Global{'Category_Tree_Root_Font_Face'}" onFocus="select();">
		   </td>
      </tr>

		<tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
             Category Tree Root-categories Font Color:</td>
            <td width="50%" height="25" bgcolor="#B6DEDC">
		    <input type="text" name="Category_Tree_Root_Font_Color" size="20" value="$Global{'Category_Tree_Root_Font_Color'}" onFocus="select();">
		   </td>
      </tr>

		<tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
             Category Tree Sub-categories Font Size:</td>
            <td width="50%" height="25" bgcolor="#B6DEDC">
		    <input type="text" name="Category_Tree_Sub_Font_Size" size="10" value="$Global{'Category_Tree_Sub_Font_Size'}" onFocus="select();">
		   </td>
      </tr>
	  
		<tr>
		<td width="50%" height="25" bgcolor="#B6DEDC">
            Category Tree Sub-categories Font Face:</td>
            <td width="50%" height="25" bgcolor="#B6DEDC">
		    <input type="text" name="Category_Tree_Sub_Font_Face" size="40" value="$Global{'Category_Tree_Sub_Font_Face'}" onFocus="select();">
		   </td>
      </tr>

	  <tr>
        <td width="100%" colspan="2" height="27" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML
return $Out;
}

#==========================================================
sub Category_Options_Form{
my ($Out, $Category_Count, $Category_Folder, $Category_Unders_Mode);
my($x, @Select, $Category_Form, $Under_Category_Form, $Categories_Table);
my($Help);

	$Help=&Help_Link("Category_Options");


	$Category_Form = &Encode_HTML($Global{'Category_Form'});
	$Under_Category_Form = &Encode_HTML($Global{'Under_Category_Form'});
	$Categories_Table  = &Encode_HTML($Global{'Categories_Table'});

	if ($Global{'Category_Count'} eq "YES") {
			$Category_Count=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$Category_Count=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}

	if ($Global{'Under_Category_Count'} eq "YES") {
			$Under_Category_Count=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$Under_Category_Count=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}

	if ($Global{'Category_Folder'} eq "YES") {
			$Category_Folder=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$Category_Folder=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}

	if ($Global{'Unique_Homepage_Category_Folder'} eq "YES") {
			$Homepage_Category_Folder=qq!<option selected value="YES">YES</option>
												<option value="NO">NO</option>!;
	}
	else{
			$Homepage_Category_Folder=qq!<option value="YES">YES</option>
												<option  selected  value="NO">NO</option>!;
	}

			
	for $x(0..4) {
		$Select[$x]="";
	}

	$Select[$Global{'Category_Unders_Mode'}]="selected";

	$Category_Unders_Mode=qq!
			<option $Select[0] value="0">Non</option>
			<option $Select[1] value="1">Only selected subcategories</option>
            <option $Select[2] value="2">Description of the categories only</option>
            <option $Select[3] value="3">All sub categories in a list</option>
            <option $Select[4] value="4">Description and selected subcategories</option>!;

#------------------------------------------------------------------------------------------
$Out=<<HTML;
<form method="POST" action="$Script_URL" ENCTYPE="x-www-form-urlencoded" >
<input type="hidden" name="action" value="Save_Category_Options" >

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="155"></td>
                <td valign="middle" align="center" width="461">
                  <p align="center"><b><font size="4" color="#00FFFF" face="Tahoma">Category
          Display Options</font></b></td>
                <td width="119">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Category Columns in Category Browse Mode:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Category_Browse_Columns" size="20" value="$Global{'Category_Browse_Columns'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Homepage Category Columns:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Homepage_Category_Columns" size="20" value="$Global{'Homepage_Category_Columns'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Non Homepage Category Columns:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Category_Columns" size="20" value="$Global{'Category_Columns'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Subcategories Separator
          (HTML allowed):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Under_Separator" size="20" value="$Global{'Under_Separator'}" onFocus="select();"></td>
      </tr>
	  
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Homepage Subcategories Separator
          (HTML allowed):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Home_Page_Under_Separator" size="20" value="$Global{'Home_Page_Under_Separator'}" onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Categories Horizontal
          Spacing :</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Category_HSpace" size="20" value="$Global{'Category_HSpace'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Categories Vertical
          Spacing:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Category_VSpace" size="20" value="$Global{'Category_VSpace'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Category Layout Border
          size(0,1,2,...):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Category_Border" size="20" value="$Global{'Category_Border'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Under Categories More... :</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="More_Categories" size="20" value="$Global{'More_Categories'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Menu Line Separator (HTML
          allowed):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="MenuLine_Separator" size="20" value="$Global{'MenuLine_Separator'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Menu Line and Home
          Separator (HTML allowed):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="MenuLine_Home" size="20" value="$Global{'MenuLine_Home'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Display Categories Count:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Category_Count">

			$Category_Count

			</select>
		  </td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Display SubCategories Count:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Under_Category_Count">

			$Under_Category_Count

			</select>
		  </td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Use Category Folders:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Category_Folder">
			
			$Category_Folder

			</select>
		  </td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Category Folders Image
          File:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Category_Folder_Image" size="40" value="$Global{'Category_Folder_Image'}"  onFocus="select();"></td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Use Unique Homepage Category Folders:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Unique_Homepage_Category_Folder">
			
			$Homepage_Category_Folder

			</select>
		  </td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Homepage Category Folders Image
          File:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Homepage_Category_Folder_Image" size="40" value="$Global{'Homepage_Category_Folder_Image'}"  onFocus="select();"></td>
      </tr>


      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Under Categories Display
          Mode:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<select size="1" name="Category_Unders_Mode">

			$Category_Unders_Mode

          </select></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Category Table:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<TEXTAREA NAME="Categories_Table" ROWS="8" COLS="42" onFocus="select();">$Categories_Table</TEXTAREA>
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Category Form:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<TEXTAREA NAME="Category_Form" ROWS="8" COLS="42" onFocus="select();">$Category_Form</TEXTAREA>
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Under Category Form:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<TEXTAREA NAME="Under_Category_Form" ROWS="6" COLS="42" onFocus="select();">$Under_Category_Form</TEXTAREA>
		</td>
      </tr>
    
	  
	  <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>

	</table>
    </center>
  </div>
</form>

HTML

return $Out;

}
#==========================================================
sub Listing_Options{
	
	&Print_Page(&Listing_Options_Form);

}
#==========================================================
sub Save_Listing_Options{
my %data;

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0666, $DB_HASH 
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n");

	$data{'Items_Per_Page'}= $Param{'Items_Per_Page'};
	$data{'Treat_HTML'}= $Param{'Treat_HTML'};

	$data{'Max_Title_Length'}= $Param{'Max_Title_Length'};
	$data{'Max_Decsription_Length'}= $Param{'Max_Decsription_Length'};
	$data{'Max_Title_Length_List'}= $Param{'Max_Title_Length_List'};
	
	$Param{'Listing_Table_Row'}=~ s/\cM//g;
	$data{'Listing_Table_Row'}=$Param{'Listing_Table_Row'};

	$Param{'Listing_Table_Row1'}=~ s/\cM//g;
	$data{'Listing_Table_Row1'}=$Param{'Listing_Table_Row1'};

	$data{'Time_left_To_Change_Color'}=$Param{'Time_left_To_Change_Color'};
	$Param{'Time_left_To_Change_Color_Preffix'}=~ s/\cM//g;
	$data{'Time_left_To_Change_Color_Preffix'}=$Param{'Time_left_To_Change_Color_Preffix'};
	
	$Param{'Time_left_To_Change_Color_Suffix'}=~ s/\cM//g;
	$data{'Time_left_To_Change_Color_Suffix'}=$Param{'Time_left_To_Change_Color_Suffix'};
	
	$data{'Time_left_To_Change_Color1'}=$Param{'Time_left_To_Change_Color1'};
	$Param{'Time_left_To_Change_Color_Preffix1'}=~ s/\cM//g;
	$data{'Time_left_To_Change_Color_Preffix1'}=$Param{'Time_left_To_Change_Color_Preffix1'};

	$Param{'Time_left_To_Change_Color_Suffix1'}=~ s/\cM//g;
	$data{'Time_left_To_Change_Color_Suffix1'}=$Param{'Time_left_To_Change_Color_Suffix1'};

	$Param{'Listing_Featured_Home_Table_Row'}=~ s/\cM//g;
	$data{'Listing_Featured_Home_Table_Row'}=$Param{'Listing_Featured_Home_Table_Row'};

	$Param{'Listing_Featured_Home_Table_Row1'}=~ s/\cM//g;
	$data{'Listing_Featured_Home_Table_Row1'}=$Param{'Listing_Featured_Home_Table_Row1'};

	$Param{'Listing_Featured_Category_Table_Row'}=~ s/\cM//g;
	$data{'Listing_Featured_Category_Table_Row'}=$Param{'Listing_Featured_Category_Table_Row'};

	$Param{'Listing_Featured_Category_Table_Row1'}=~ s/\cM//g;
	$data{'Listing_Featured_Category_Table_Row1'}=$Param{'Listing_Featured_Category_Table_Row1'};

	$Param{'Bid_History_Table_Row'}=~ s/\cM//g;
	$data{'Bid_History_Table_Row'}=$Param{'Bid_History_Table_Row'};

	$Param{'Bid_History_Table_Row1'}=~ s/\cM//g;
	$data{'Bid_History_Table_Row1'}=$Param{'Bid_History_Table_Row1'};

	$data{'New_Item_Houres'}=$Param{'New_Item_Houres'};
	$data{'Cool_Item_Bids'}=$Param{'Cool_Item_Bids'};
	$data{'Hot_Item_Bids'}=$Param{'Hot_Item_Bids'};
	$data{'New_Icon'}=$Param{'New_Icon'};
	$data{'Hot_Icon'}=$Param{'Hot_Icon'};
	$data{'Cool_Icon'}=$Param{'Cool_Icon'};
	$data{'High_Bidder_Icon'}=$Param{'High_Bidder_Icon'};
	$data{'Featured_Items_Per_Page'}=$Param{'Featured_Items_Per_Page'};
	$data{'Featured_Home_Items_Per_Page'}=$Param{'Featured_Home_Items_Per_Page'};
	$data{'Ending_Items_Time_Minutes'}=$Param{'Ending_Items_Time_Minutes'};
	$data{'Home_Page_Thumbnail_Width'}=$Param{'Home_Page_Thumbnail_Width'};
	$data{'Home_Page_Thumbnail_Height'}=$Param{'Home_Page_Thumbnail_Height'};

	$data{'Category_Thumbnail_Width'}=$Param{'Category_Thumbnail_Width'};
	$data{'Category_Thumbnail_Height'}=$Param{'Category_Thumbnail_Height'};

	$data{'Thumbnail_Width'}=$Param{'Thumbnail_Width'};
	$data{'Thumbnail_Height'}=$Param{'Thumbnail_Height'};

	untie %data;
	undef %data;

	&Admin_Msg("Listing Options Saved", "Listing Options Successfully Saved.",2);

}
#==========================================================
sub Listing_Options_Form{
my $Out="";
my ($Allow_HTML, $x);
my  @Select;
my($Help);

	$Help=&Help_Link("Listing_Options");

	if ($Global{'Treat_HTML'} eq "Show_Code") {
		$Allow_HTML=qq!<option selected value="Show_Code">Disable All HTML</option>!;
	}
	else{
		$Allow_HTML=qq!<option value="Show_Code">Disable All HTML</option>!;
	}	
	if ($Global{'Treat_HTML'} eq "Show_Safe_Code") {
		$Allow_HTML.=qq!<option selected value="Show_Safe_Code">Allow Safe HTML</option>!;
	}
	else{
		$Allow_HTML.=qq!<option value="Show_Safe_Code">Allow Safe HTML</option>!;
	}	
	if ($Global{'Treat_HTML'} eq "Remove_Code") {
		$Allow_HTML.=qq!<option selected value="Remove_Code">Remove All HTML</option>!;
	}
	else{
		$Allow_HTML.=qq!<option value="Remove_Code">Remove  All HTML</option>!;
	}	


$Listing_Table_Row=&Encode_HTML($Global{'Listing_Table_Row'});
$Listing_Table_Row1=&Encode_HTML($Global{'Listing_Table_Row1'});

$Time_left_To_Change_Color_Preffix=&Encode_HTML($Global{'Time_left_To_Change_Color_Preffix'});
$Time_left_To_Change_Color_Suffix=&Encode_HTML($Global{'Time_left_To_Change_Color_Suffix'});
$Time_left_To_Change_Color_Preffix1=&Encode_HTML($Global{'Time_left_To_Change_Color_Preffix1'});
$Time_left_To_Change_Color_Suffix1=&Encode_HTML($Global{'Time_left_To_Change_Color_Suffix1'});

$Bid_History_Row=&Encode_HTML($Global{'Bid_History_Table_Row'});
$Bid_History_Row1=&Encode_HTML($Global{'Bid_History_Table_Row1'});

$Listing_Featured_Home_Table_Row=&Encode_HTML($Global{'Listing_Featured_Home_Table_Row'});
$Listing_Featured_Home_Table_Row1=&Encode_HTML($Global{'Listing_Featured_Home_Table_Row1'});
$Listing_Featured_Category_Table_Row=&Encode_HTML($Global{'Listing_Featured_Category_Table_Row'});
$Listing_Featured_Category_Table_Row1=&Encode_HTML($Global{'Listing_Featured_Category_Table_Row1'});


$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Save_Listing_Options">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">Listing
          Display Options</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Number of Items Displayed
          Per Page:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Items_Per_Page" size="10" value="$Global{'Items_Per_Page'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Category Items Per Page:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Featured_Items_Per_Page" size="10" value="$Global{'Featured_Items_Per_Page'}" onFocus="select();">
		</td>
      </tr>


	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Home Items Per Page:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Featured_Home_Items_Per_Page" size="10" value="$Global{'Featured_Home_Items_Per_Page'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Home Items Thumbnail Width (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Home_Page_Thumbnail_Width" size="10" value="$Global{'Home_Page_Thumbnail_Width'}" onFocus="select();">
		</td>
      </tr>
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Home Items Thumbnail Height (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Home_Page_Thumbnail_Height" size="10" value="$Global{'Home_Page_Thumbnail_Height'}" onFocus="select();">
		</td>
      </tr>
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Category Items Thumbnail Width (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Category_Thumbnail_Width" size="10" value="$Global{'Category_Thumbnail_Width'}" onFocus="select();">
		</td>
      </tr>
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Featured Category Items Thumbnail  Hieght (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Category_Thumbnail_Height" size="10" value="$Global{'Category_Thumbnail_Height'}" onFocus="select();">
		</td>
      </tr>
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Listing Items Thumbnail Width (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Thumbnail_Width" size="10" value="$Global{'Thumbnail_Width'}" onFocus="select();">
		</td>
      </tr>
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Listing Items Thumbnail Height (Pixels):</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Thumbnail_Height" size="10" value="$Global{'Thumbnail_Height'}" onFocus="select();">
		</td>
      </tr>
	  
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
		Time in Minutes for Ending Items Link:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Ending_Items_Time_Minutes" size="10" value="$Global{'Ending_Items_Time_Minutes'}" onFocus="select();">
		</td>
      </tr>

	  
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">HTML Manipulation in Item
          Submission:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Treat_HTML">
				$Allow_HTML
			</select>
		  </td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Item Title Size in
          Bytes:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Title_Length" size="20" value="$Global{'Max_Title_Length'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Item Description
          Size in Bytes:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Decsription_Length" size="20" value="$Global{'Max_Decsription_Length'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Item Title Length
          Displayed in Bytes:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Title_Length_List" size="20" value="$Global{'Max_Title_Length_List'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          New Icon Life in Hours:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="New_Item_Houres" size="20" value="$Global{'New_Item_Houres'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Number of Bids for Cool Items:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="Cool_Item_Bids" size="20" value="$Global{'Cool_Item_Bids'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Number of Bids for Hot Items:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="Hot_Item_Bids" size="20" value="$Global{'Hot_Item_Bids'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          New Item Graphics File:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="New_Icon" size="20" value="$Global{'New_Icon'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Cool Item Graphics File:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="Cool_Icon" size="20" value="$Global{'Cool_Icon'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Hot Item Graphics File:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="Hot_Icon" size="20" value="$Global{'Hot_Icon'}" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          High Bidder Graphics File:
		  </td>
          <td width="50%"  bgcolor="#B6DEDC">
  		 <input type="text" name="High_Bidder_Icon" size="20" value="$Global{'High_Bidder_Icon'}" onFocus="select();">
		</td>
      </tr>

	  
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Auction Time Left Yellow  Light in minutes:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Time_left_To_Change_Color" size="20" value="$Global{'Time_left_To_Change_Color'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Auction Time Left Yellow  Light code:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Time_left_To_Change_Color_Preffix" size="30" value="$Time_left_To_Change_Color_Preffix" onFocus="select();">
		<input type="text" name="Time_left_To_Change_Color_Suffix" size="20" value="$Time_left_To_Change_Color_Suffix" onFocus="select();">
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Auction Time Left Red Light in minutes:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Time_left_To_Change_Color1" size="20" value="$Global{'Time_left_To_Change_Color1'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Auction Time Left Red Light code:</td>
        <td width="50%"  bgcolor="#B6DEDC">
		<input type="text" name="Time_left_To_Change_Color_Preffix1" size="30" value="$Time_left_To_Change_Color_Preffix1" onFocus="select();">
		<input type="text" name="Time_left_To_Change_Color_Suffix1" size="20" value="$Time_left_To_Change_Color_Suffix1" onFocus="select();">
		</td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Listing Items Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Table_Row" cols="58" onFocus="select();">$Listing_Table_Row</textarea>
		</td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Listing Items Table Alternate Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Table_Row1" cols="58" onFocus="select();">$Listing_Table_Row1</textarea>
		</td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Bid History Listing Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Bid_History_Table_Row" cols="58" onFocus="select();">$Bid_History_Row</textarea>
		</td>
      </tr>

      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Bid History Listing Alternate Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Bid_History_Table_Row1" cols="58" onFocus="select();">$Bid_History_Row1</textarea>
		</td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Featured Homepage Listing Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Featured_Home_Table_Row" cols="58" onFocus="select();">$Listing_Featured_Home_Table_Row</textarea>
		</td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">
          Featured Homepage Listing Alternate Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Featured_Home_Table_Row1" cols="58" onFocus="select();">$Listing_Featured_Home_Table_Row1</textarea>
		</td>
      </tr>

        <td width="50%"  bgcolor="#B6DEDC">
          Featured Category Listing Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Featured_Category_Table_Row" cols="58" onFocus="select();">$Listing_Featured_Category_Table_Row</textarea>
		</td>
      </tr>

		<td width="50%"  bgcolor="#B6DEDC">
          Featured Category Listing Alternate Table Row:
		  </td>
        <td width="50%"  bgcolor="#B6DEDC">
		<textarea rows="10" name="Listing_Featured_Category_Table_Row1" cols="58" onFocus="select();">$Listing_Featured_Category_Table_Row1</textarea>
		</td>
      </tr>

	  <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>
HTML

return $Out;
}
#==========================================================
sub File_Upload_Options_Form {
my $Out="";
my $Allow_File_Upload;
my $Upload_Any_File;
my($Help);

	$Help=&Help_Link("Upload_Options");


	if ($Global{'Allow_File_Upload'} eq "YES") {
            $Allow_File_Upload=qq!<option selected value="YES">YES</option>
            <option value="NO">NO</option>!;
	}
	else{
           $Allow_File_Upload=qq!<option selected value="NO">NO</option>
           <option value="YES">YES</option>!;
	}


	if ($Global{'Upload_Any_File'} eq "YES") {
            $Upload_Any_File=qq!<option selected value="YES">YES</option>
            <option value="NO">NO</option>!;
	}
	else{
           $Upload_Any_File=qq!<option selected value="NO">NO</option>
           <option value="YES">YES</option>!;
	}


$Out=<<HTML;
<form method="POST" action="$Script_URL">

<input type="hidden" name="action" value="Save_File_Upload_Options">

  <div align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" colspan="2" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="741" cellspacing="0" cellpadding="0">
              <tr>
                <td width="176"></td>
                <td valign="middle" align="center" width="367">
                  <p align="center"><b><font color="#00FFFF" size="4" face="Tahoma">File
          Upload Options</font></b></p>
                </td>
                <td width="192">
                  <p align="center">
				  	$Help
					</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Allow User to Upload Files
          in Item Submission</td>
        <td width="50%"  bgcolor="#B6DEDC">
		
		<select size="1" name="Allow_File_Upload">

			$Allow_File_Upload

		  </select>

		  </td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Number of Files
          Allowed to Upload:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Upload_Files" size="10" value="$Global{'Max_Upload_Files'}" onFocus="select();"></td>
      </tr>

	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Number of Files
          Allowed to Upload:</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Upload_Files" size="10" value="$Global{'Max_Upload_Files'}" onFocus="select();"></td>
      </tr>
	  
	  <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Upload File Size in Kbytes
          (Per File):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Upload_File_Size" size="10" value="$Global{'Max_Upload_File_Size'}" onFocus="select();">KB</td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Maximum Upload Combined
          Total Files Size in Kbytes</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Max_Upload_Size" size="10" value="$Global{'Max_Upload_Size'}" onFocus="select();">KB</td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Allow any File Type&nbsp;
          to Upload:</td>
        <td width="50%"  bgcolor="#B6DEDC">
			<select size="1" name="Upload_Any_File">
				
				$Upload_Any_File

			</select>
		  </td>
      </tr>
      <tr>
        <td width="50%"  bgcolor="#B6DEDC">Files Extensions Allowed
          (Separated by a Space):</td>
        <td width="50%"  bgcolor="#B6DEDC"><input type="text" name="Files_Ext_Allowed" size="35" value="$Global{'Files_Ext_Allowed'}" onFocus="select();"></td>
      </tr>
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center"><input type="submit" value="Save Changes"> <input type="reset" value="Clear Form">&nbsp;
          <input onclick="history.go(-1);" type="button" value="Cancel"></td>
      </tr>
    </table>
    </center>
  </div>
</form>

HTML

return $Out;

}
#==========================================================
sub Error_Msg{
my ($Title, $Msg, $Level)=@_;
my $Out;

$Out=<<HTML;
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Mewsoft - www.mewsoft.com</title>
<STYLE >
<!--
 A:hover {color: #ff3300 ;} 
-->
</STYLE>

<STYLE TYPE="text/css">
<!--
.lwr  a:link    { color: white; }
.lwr  a:visited { color: white; }
.lwr  a:active  { color: #ff3300; }
.lwr  a:hover   { color: red; background-color : yellow;}
.lwr  a{ text-decoration: none }

.lbr  a:link    { color: blue; }
.lbr  a:visited { color: blue; }
.lbr  a:active  { color: #ff3300; }
.lbr  a:hover   { color: red; background-color : #FFFF00;}
.lbr  a{ text-decoration: none }
-->
</STYLE>
</head>

<body bgcolor="#E1E1C4" >

<div class="lbr" align="center">
  <center>

<TABLE BORDER="0" WIDTH="405" BGCOLOR="#005329" >
  <TR>
    <TD WIDTH="100%" ALIGN="CENTER" HEIGHT="19"><B>
	<FONT COLOR="#FFFF00" FACE="TIMES NEW ROMAN, ARIAL">
	
	$Title
	
	</FONT></B>
    </TD>
  </TR>
  <TR>
    <TD WIDTH="400">
      <DIV ALIGN="CENTER">
      <TABLE BORDER="0" WIDTH="400" CELLSPACING="0" CELLPADDING="0" BGCOLOR="#E1E1C4">
        <TR>
          <TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#FFFFD9">
          <DIV ALIGN="CENTER">
            <TABLE WIDTH="100%" BORDER="0" CELLPADDING="3">
              <TR>
                <TD WIDTH="100%" ALIGN="LEFT">
				
				$Msg
				
				</TD>
              </TR>
            </TABLE>
          </DIV>
          </TD>
        </TR>
        <TR>
          <TD VALIGN="MIDDLE" ALIGN="CENTER" BGCOLOR="#FFFFD9">
		  <FORM>
                <P ALIGN="CENTER">

				<input type=button value="--OK--" onClick="history.go(-$Level)">

  		  </FORM>
          </TD>
        </TR>
      </TABLE>
      </DIV>
    </TD>
  </TR>
</TABLE>
</CENTER>
</DIV>
</body>
</html>

HTML
	return $Out;
}
#==========================================================
sub Exit{
my($Msg, $Title, $Level)=@_;
my ($Out);

	if ($Title eq "") {$Title="Critical Error";}
	if ($Level !~ /^\d+$/) {$Level=1;}

	$Out=&Error_Msg($Title, $Msg, $Level);
	print "Content-type: text/html\n\n";
	print "$Out";
	exit (0);
}

#======================End of File=========================
#==========================================================
