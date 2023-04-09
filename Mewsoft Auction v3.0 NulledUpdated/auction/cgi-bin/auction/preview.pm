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
sub Preview_Item{
my( $Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Preview_File'});

	&Check_New_Item_Data;
	&Prepare_Item_Data;

	if (!&Check_User_Authentication($Param{'User_ID'} , $Param{'Password'})) {
					$msg="<b> $Language{'login_error'}</b> $Language{'login_error_msg'} ";
					$msg .="$Language{'missing_info_desc'}";
					$Plugins{'Body'}=&Msg($Language{'incorrect_information'}, $msg, 1);;
					&Display($Global{'General_Template'});
					exit 0;
	}
	else{
				 $Out=&Preview_Item_Form;
	}

	$Plugins{'Body'}="";	
	&Display($Out, 1);
}
#==========================================================
sub Check_New_Item_Data{
my ($msg)="";

	if (!&Check_User_Authentication($Param{'User_ID'} , $Param{'Password'})) {
			$msg .= "<b> $Language{'login_error'}</b> $Language{'login_error_msg'}<br>";
	}

	if (!$Param{'Title'}) {
			$msg .= "$Language{'missing_item_title'}";
	}

	if (!$Param{'Description'}) {
			$msg .= "$Language{'missing_description'}";
	}

	#($Param{'Quantity'} !~ /^(\d+\.?\d*|\.\d+)$/);
	if ($Param{'Quantity'}) {$Param{'Quantity'} =~ s/\s//g;}
	if ($Param{'Quantity'} !~ /^(\d+)$/) {
			$msg .= "$Language{'missing_quantity'}";
	}

	if ($Param{'Start_Bid'}) {$Param{'Start_Bid'} =~ s/\s//g;}
	if (!&Numeric($Param{'Start_Bid'})) {
			$msg.="$Language{'missing_start_price'}";
	}
	else{
			$Param{'Start_Bid'} = &Format_Decimal($Param{'Start_Bid'});
	}

	if ($Param{'Increment'}) {$Param{'Increment'} =~ s/\s//g;}
	if (!&Numeric($Param{'Increment'})) {
			$msg.="$Language{'missing_increment_price'}";
	}
	else{
			$Param{'Increment'} = &Format_Decimal($Param{'Increment'});
	}

	if ($Param{'Reserve'}) {$Param{'Reserve'} =~ s/\s//g;}
	if (!&Numeric($Param{'Reserve'})) {
			$Param{'Reserve'} = "";
	}
	else{
			$Param{'Reserve'} = &Format_Decimal($Param{'Reserve'});
	}

	if ($Param{'BuyPrice'}) {$Param{'BuyPrice'} =~ s/\s//g;}
	if (!&Numeric($Param{'BuyPrice'})) {
			$Param{'BuyPrice'} = "";
	}
	else{
			$Param{'BuyPrice'} = &Format_Decimal($Param{'BuyPrice'});
	}

	if ($msg) {
					$msg .="$Language{'missing_info_desc'}";
					$Out=&Msg($Language{'missing_information'}, $msg, 1);
					$Plugins{'Body'}=$Out;
					&Display($Global{'General_Template'});
					exit 0;
	}

}
#==========================================================
sub Preview_Item_Form{
my(@Regular_From, @Regular_To, @Regular_Fee);
my(@Reserve_From, @Reserve_To, @Reserve_Fee);
my($Out, $List, @Photos, @Photoss, $Photo, $Curr);
my($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);

	$Out=&Translate_File($Global{'Preview_Item_Template'});

	$List=qq!<FORM NAME="Preview_Auction" METHOD="POST" action="$Script_URL">!;
#								<input type="hidden" name="Lang" value="$Global{'Language'}">

	if ($Global{'Allow_File_Upload'} eq "YES") {
				$List.=qq!<input type="hidden" name="action" value="Submit_Upload_Files">!;
	}
	else{
				$List.=qq!<input type="hidden" name="action" value="Add_Item">!;
	}
	
	$List.=$Global{'Hidden_Item_Variables'}; 
	$Out=~ s/<!--FORM_START-->/$List/g;

	$Curr = $Global{'Currency_Symbol'};

	
	$List=&Get_Menu_Bar;
	$Out=~ s/<!--CATEGORY-->/$List/;
	
	$Out=~ s/<!--CATEGORY_ID-->/$Param{'Cat_ID'}/;

	$List=$Param{'Title'};
	$List= substr($List , 0 , $Global{'Max_Title_Length'});
	$Out=~ s/<!--ITEM_TITLE-->/$List/;

	$List="";
	$Out=~ s/<!--ITEM_ID-->//;

	$List="";
	if ($Param{'Gift_Icon'}) {
			$List=qq!<img src="$Global{'ImagesDir'}/$Param{'Gift_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
	}
	$Out=~ s/<!--GIFT_ICON-->/$List/;

	$List="";
	if (($Param{'Featured_Homepage'} ) || ($Param{'Featured_Category'})) {
			$List=qq!<img src="$Global{'ImagesDir'}/$Global{'Featured_Icon'}" border=0 alt="Featured">!;
	}
	$Out=~ s/<!--FEATURED-->/$List/g;

	$Out=~ s/<!--CATEGORY_NUMBER-->/$Param{'Cat_ID'}/g;

	$Param{'Description'}=&Web_Decode($Param{'Description'});
	$List=$Param{'Description'};
	$List=substr($List, 0, $Global{'Max_Decsription_Length'});
	$Out=~ s/<!--ITEM_DESCRIPTION-->/$List/;

	$List=$Curr.$Param{'Start_Bid'};
	$Out=~ s/<!--CURRENT_BID-->/$List/;
	$Out=~ s/<!--START_BID-->/$List/;
	
	$List=$Param{'Duration'};
	$Out=~ s/<!--TIME_LEFT-->/$List/;
	
	$List=$Param{'Quantity'};
	$Out=~ s/<!--QUANTITY-->/$List/;
	
	$List=$Curr.$Param{'Increment'};
	$Out=~ s/<!--BID_INCREMENT-->/$List/;
	
	$List=$Param{'Location'};
	$Out=~ s/<!--LOCATION-->/$List/;
	
	$List=$Param{'Country'};
	$Out=~ s/<!--COUNTRY-->/$List/;

	if ($Param{'Reserve'}){
			$Out=~ s/<!--RESERVE-->/$Param{'Reserve'}/;
	}
	else{
			$Out=~ s/<!--RESERVE-->/$Language{'no'}/;
	}

	if ($Param{'BuyPrice'}){
			$Out=~ s/<!--BUYPRICE-->/$Param{'BuyPrice'}/;
	}
	else{
			$Out=~ s/<!--BUYPRICE-->/$Language{'no'}/;
	}

	if ($Param{'Resubmit'}){
			$Out=~ s/<!--RESUBMIT-->/$Param{'Resubmit'}/;
	}
	else{
			$Out=~ s/<!--RESUBMIT-->/$Language{'no'}/;
	}

	if ($Param{'Featured_Homepage'}){
			$Out=~ s/<!--FEATURED_HOMEPAGE-->/$Language{'yes'}/;
	}
	else{
			$Out=~ s/<!--FEATURED_HOMEPAGE-->/$Language{'no'}/;
	}
	if ($Param{'Featured_Category'}){
			$Out=~ s/<!--FEATURED_CATEGORY-->/$Language{'yes'}/;
	}
	else{
			$Out=~ s/<!--FEATURED_CATEGORY-->/$Language{'no'}/;
	}

	 #($Format, $Time)
	$List=&Get_Date_Formated($Global{'Time_Format'}, $Param{'Start_Time'});
	$Out=~ s/<!--START_TIME-->/$List/;

	$List=&Get_Date_Formated($Global{'Time_Format'}, $Param{'End_Time'});
	$Out=~ s/<!--END_TIME-->/$List/;
	
	$List=$Param{'Item_Language'};
	$Out=~ s/<!--LANGUAGE-->/$List/;

	$Out=~ s/<!--USER_ID-->/$Param{'User_ID'}/g;
	
	$List="";
	if ($Param{'ypChecks'}) {
		$List=$Language{'payment_li'}.$Language{'accepts_pc_label'};
	}
	if ($Param{'yccMorders'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_ccmo_label'};
	}
	if ($Param{'yCCards'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_cc_label'};
	}
	if ($Param{'escrow'}) {
		if ($List ne "") {$List.=$Language{'payment_separator'};}
		$List.=$Language{'payment_li'}.$Language{'accepts_escrow_label'};
	}
	$Out=~ s/<!--PAYMENTS_ACCEPTED-->/$List/;
	

	$List="";
	if ($Param{'shipping'} eq "buyer") {
			$List=$Language{'payment_li'}.$Language{'buyer_pays_label'};
	}
	else{
			$List=$Language{'payment_li'}.$Language{'seller_pays_label'};
	}

	if ($Param{'ship_time'} eq "Receipt_of_Payment") {
			if ($List ne "") {$List.=$Language{'payment_separator'};}
			$List.=$Language{'payment_li'}.$Language{'ship_on_receipt_label'};
	}
	else{
			$List.=$Language{'payment_li'}.$Language{'ship_on_close_label'};
	}

	if ($Param{'Ship_Internationally'}) {
			if ($List ne "") {$List.=$Language{'payment_separator'};}
			$List.=$Language{'payment_li'}.$Language{'ship_international_label'};
	}
	
	$Out=~ s/<!--SHIPPING-->/$List/;

	$List=qq!<A HREF="$Param{'Homepage'}" >$Param{'Homepage'}</A>!;
	$Out=~ s/<!--HOME_PAGE-->/$List/;
#==========================================================
	@Regular_From=split(/\:/, $Global{'Regular_Fees_From'});
	@Regular_To=split(/\:/, $Global{'Regular_Fees_To'});
	@Regular_Fee=split(/\:/, $Global{'Regular_Fees_Fee'});
	
	@Reserve_From=split(/\:/, $Global{'Reserve_Fees_From'});
	@Reserve_To=split(/\:/, $Global{'Reserve_Fees_To'});
	@Reserve_Fee=split(/\:/, $Global{'Reserve_Fees_Fee'});

	@Final_From=split(/\:/, $Global{'Final_Fees_From'});
	@Final_To=split(/\:/, $Global{'Final_Fees_To'});
	@Final_Fee=split(/\:/, $Global{'Final_Fees_Fee'});
	#----------------------------------------------------------

	$Total_Fees = 0; $TF = 0;
	if ($Global{'Title_Enhancement_Fee'}) {
			if ($Param{'Title_Enhancement'}>0) { 
					$Total_Fees += $Global{'Title_Enhancement_Fee'}; 
					$TF = $Global{'Title_Enhancement_Fee'};
			}
	}

	$FH=0;
	if ($Global{'Home_Page_Featured_Fee'}) {
			if ($Param{'Featured_Homepage'}){	
					$Total_Fees += $Global{'Home_Page_Featured_Fee'}; 
					$FH = $Global{'Home_Page_Featured_Fee'}; 
			}
	}
	
	$FC=0;
	if ($Global{'Category_Featured_Fee'}) {
		if ($Param{'Featured_Category'}){
				$Total_Fees += $Global{'Category_Featured_Fee'}; 
				$FC = $Global{'Category_Featured_Fee'}; 
		}
	}
				
	$GI=0;
	if ($Global{'Gift_Icon_Fee'}) {
			if ($Param{'Gift_Icon'}){
						$Total_Fees += $Global{'Gift_Icon_Fee'};
						$GI = $Global{'Gift_Icon_Fee'};
			}
	}
				
	$FU=0;
	if ($Param{'Uploaded_Files'}) {
			@Photos=split(/\|/, $Param{'Uploaded_Files'});
			$Uploads=@Photos;
			if ($Uploads == 1) {$Total_Fees +=$Global{'Upload_One_File_Fee'}; $FU=$Global{'Upload_One_File_Fee'};}
			if ($Uploads == 2) {$Total_Fees +=$Global{'Upload_Two_File_Fee'};$FU=$Global{'Upload_Two_File_Fee'};}
			if ($Uploads == 3) {$Total_Fees +=$Global{'Upload_Three_File_Fee'};$FU=$Global{'Upload_Three_File_Fee'};}
			if ($Uploads == 4) {$Total_Fees +=$Global{'Upload_Four_File_Fee'};$FU=$Global{'Upload_Four_File_Fee'};}
			if ($Uploads >= 5) {$Total_Fees +=($Global{'Upload_Five_File_Fee'} * $Uploads);$FU=($Global{'Upload_Five_File_Fee'} * $Uploads);}
	}

	$RG=0;
	for $x(0..$#Regular_From) {
			if ($Param{'Start_Bid'} >= $Regular_From[$x] && $Param{'Start_Bid'} <= $Regular_To[$x]) {
					$Temp = $Regular_Fee[$x] * $Param{'Quantity'};
					if ($Temp > $Global{'Dutch_Max_Regular_Fees'}){
								$Temp = $Global{'Dutch_Max_Regular_Fees'};
					}
					$RG=$Temp;
					$Total_Fees +=$Temp; 
					last;
			}
	}

	$RS=0;
	if ($Param{'Reserve'}) {
			for $x(0..$#Reserve_From) {
						if ($Param{'Reserve'}>$Reserve_From[$x] &&  $Param{'Reserve'}<$Reserve_To[$x]) {
							$Total_Fees += $Reserve_Fee[$x];
							$RS = $Reserve_Fee[$x];
							last;
						}
			}
	}

	if ($Global{'Charge_For_Submitting'} eq "YES"){ 
			$Total_Fees = $Global{'Submit_Charge'};
			$TF = 0; $FH = 0;
			$FC = 0; $GI = 0;
			$FU = 0; $RG = 0;
			$RS = 0;
	}

	$Fees = $Curr.$RG;
	if (!$RG) {$Fees = $Language{'none'};}
	$Out=~ s/<!--INSERTIN_FEES-->/$Fees/;

	$Fees = $Curr.$TF;
	if (!$TF) {$Fees = $Language{'none'};}
	$Out=~ s/<!--TITLE_FEES-->/$Fees/;
	
	$Fees = $Curr.$FH;
	if (!$FH) {$Fees = $Language{'none'};}
	$Out=~ s/<!--FEATURED_HOME_FEES-->/$Fees/;

	$Fees = $Curr.$FC;
	if (!$FC) {$Fees = $Language{'none'};}
	$Out=~ s/<!--FEATURED_CATEGORY_FEES-->/$Fees/;

	$Fees = $Curr.$GI;
	if (!$GI) {$Fees = $Language{'none'};}
	$Out=~ s/<!--GIFT_ICON_FEES-->/$Fees/;

	$Fees = $Curr.$RS;
	if (!$RS) {$Fees = $Language{'none'};}
	$Out=~ s/<!--RESERVE_FEES-->/$Fees/;

	$Fees = $Curr.$FU;
	if (!$FU) {$Fees = $Language{'none'};}
	$Out=~ s/<!--FILE_UPLOAD_FEES-->/$Fees/;

	$Fees = $Curr.$Total_Fees;
	if (!$Total_Fees) {$Fees = $Language{'none'};}
	$Out=~ s/<!--TOTAL_FEES-->/$Fees/;
		
	#==========================================================

	if ($Global{'Allow_File_Upload'}  eq "YES") {
				$Out=~ s/<!--CONTINUE_BUTTON-->/$Language{'continue_button'}/;
				$Out =~ s/<!--CONTINUE_ACTION-->/$Language{'continue_button_help'}/;
	}
	else{
				$Out=~ s/<!--CONTINUE_BUTTON-->/$Language{'submit_button'}/;
				$Out=~ s/<!--CONTINUE_ACTION-->/$Language{'submit_button_help'}/;
	}
	
	$Out=~ s/<!--MAKE_CHANGES_BUTTON-->/$Language{'make_changes_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/g;

	return $Out;

}
#==========================================================
#==========================================================
1;