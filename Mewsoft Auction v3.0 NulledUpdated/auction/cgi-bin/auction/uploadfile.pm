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
sub Submit_Upload_Files_Form{

	$Param{'Uploaded_Files'}="";
	$Param{'Uploaded_User_Size'}=0;
	$Param{'Uploaded_User_Count'}=0;
	$Global{'upload_error_msg'}="";
	
	&Prepare_Item_Data;
	
	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Upload_File'});

	$Plugins{'Body'}="";
    &Display(&Upload_Files_Form, 1);
}
#==========================================================
sub Upload_Files_Form{ 
my(@Regular_From, @Regular_To, @Regular_Fee);
my(@Reserve_From, @Reserve_To, @Reserve_Fee);
my($Out, $List, @Photos, @Photoss, $Photo, $Curr);
my($Total_Fees, $TF, $FH, $FC, $GI, $FU, $RG, $RS);

	$Out=&Translate_File($Global{'Upload_File_Template'});
	
	$Curr = $Global{'Currency_Symbol'};

	$List=qq!<FORM NAME="Upload_File" METHOD="POST" ACTION="$Script_URL" ENCTYPE="multipart/form-data">!;
	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!$Global{'upload_error_msg'}!;
	$Out=~ s/<!--UPLOAD_ERROR_MESSAGE-->/$List/;

    $List=qq!<input type="file" name="FILE1">!;
	$Out=~ s/<!--UPLOAD_FILE_BOX-->/$List/;

	#$List=qq!<input type="submit" value="Upload File">!;
	$Out=~ s/<!--UPLOAD_FILE_BUTTON-->/$Language{'upload_file_button'}/;

	$Out=~ s/<!--MAX_UPLOAD_FILES-->/$Global{'Max_Upload_Files'}/;
	$Out=~ s/<!--MAX_UPLOAD_FILE_SIZE-->/$Global{'Max_Upload_File_Size'}/;
	$Out=~ s/<!--MAX_UPLOAD_SIZE-->/$Global{'Max_Upload_Size'}/;
	$Out=~ s/<!--UPLOADED_USER_SIZE-->/$Param{'Uploaded_User_Size'}/;
	$Out=~ s/<!--UPLOADED_FILES_COUNT-->/$Param{'Uploaded_User_Count'}/;
	$Out=~ s/<!--ALLOWED_TYPES-->/$Global{'Files_Ext_Allowed'}/;

	if (!$Param{'Uploaded_Files'}) {$Param{'Uploaded_Files'}="";}
	
	@Photos=split(/\|/, $Param{'Uploaded_Files'});
	$List="";

	if ($Param{'Uploaded_Files'}){
				foreach $Photo (@Photos) {
							@Photoss=split(/\//,$Photo);
							$Photo=pop @Photoss;
							$Photo="$Global{'Base_Upload_URL'}/$Photo";
							if ($Photo) {
									$List.=qq!<IMG SRC="$Photo" border="01" alt="photo">$Language{'photos_separator'}!;
							}
				}
				$Out=~ s/<!--UPLOADED_PHOTOS-->/$List/g;
	}
	else{
				$Out=~ s/<!--UPLOADED_PHOTOS-->/$Language{'none'}/g;
	}
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
	$List=qq!
					<input type="hidden" name="action" value="Upload_File">
					<input type="hidden" name="Lang" value="$Global{'Language'}">
					<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">
					<input type="hidden" name="User_ID" value="$Param{'User_ID'}">
					<input type="hidden" name="Password" value="$Param{'Password'}">
					$Global{'Hidden_Item_Variables'}
				</FORM>
				!;
	$Out=~ s/<!--FORM_END-->/$List/;

	$List=qq!<FORM NAME="Submit_Auction" ACTION="$Script_URL" METHOD="POST">
					<input type="hidden" name="action" value="Add_Item">
					$Global{'Hidden_Item_Variables'}
					!;

	$Out=~ s/<!--SUBMIT_FORM_START-->/$List/;

	$List=qq!<input type="submit" value="$Language{'submit_auction_button'}">!;

	$Out=~ s/<!--SUBMIT_AUCTION_BUTTON-->/$Language{'submit_auction_button'}/;
	$Out=~ s/<!--MAKE_CHANGES_BUTTON-->/$Language{'make_changes_button'}/;

	$List=qq!</FORM>!;
	$Out=~ s/<!--SUBMIT_FORM_END-->/$List/;
	
	return $Out;

}
#==========================================================
sub Upload_File{
my(@File_Exts, $File_Ext, $Random_File, $Ext, $Err);
my(@Files_Ext_Allowed, $File_Allowed);
my($dev, $ino, $mode, $nlink, $uid, $gid, $rdev, $size, $atime, $mtime, $ctime, $blksize, $blocks);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Upload_File'});

	@File_Exts = split(/\./ , $Param{'Upload_File_Name'});
	$File_Ext = pop @File_Exts;
	$File_Ext = lc($File_Ext);

	$Random_File=&Get_Random_Filename($Global{'Base_Upload_Dir'}, $File_Ext);

	$Global{'Files_Ext_Allowed'}=~ s/\,/ /g;
	
	@Files_Ext_Allowed=split(/\s+/, $Global{'Files_Ext_Allowed'});

	$File_Allowed = 0;

	if ($Global{'Upload_Any_File'} eq "NO") {
				foreach $Ext(@Files_Ext_Allowed) {
						$Ext = lc($Ext);
						$Ext =~ s/\s+//g;
						if ($File_Ext eq $Ext){
								$File_Allowed =1; last;
						}
		      }
    }
    
	if ($File_Allowed ==1 || $Global{'Upload_Any_File'}  eq "YES") { 
				open(OUTFILE,">$Random_File")  || &Exit("Can 't write image file $Random_File: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__); 
				binmode OUTFILE;
				print OUTFILE $Param{'Upload_File_Content'}; 
				close(OUTFILE); 
				($dev, $ino, $mode, $nlink, $uid, $gid, $rdev, $size, $atime, $mtime, $ctime, $blksize, $blocks) = stat($Random_File);
				$Err = "";
	}
	else{
				# File ext. not allowed to upload
				$Err = $Language{'upload_file_type_error'};
	}

	if (!$Err) {
			if($Param{'Upload_File_Name'}) { 
						$Err = &Check_Uploaded_File($Random_File, $size);
				}
			else {
						$Err = $Language{'upload_file_no_name'};
						unlink ($Random_File);
			 }
	 }

	$Upload_Error_Msg = "";

	if ($Err) {
			$Global{'upload_error_msg'} = $Language{'upload_error_msg'} . $Err; 
	}

	&Prepare_Item_Data;

	$Plugins{'Body'} = "";
	&Display(&Upload_Files_Form, 1);

}
#==========================================================
sub Check_Uploaded_File{
my($Fname, $Fsize) = @_;
my($Msg) ="";

	$Fsize=int($Fsize/1000);

	if ($Param{'Uploaded_User_Count'}>= $Global{'Max_Upload_Files'} ){
				$Msg.="$Language{'error_max_upload_files'} <b>$Global{'Max_Upload_Files'}</b>.";
	}
	
	if ($Fsize>$Global{'Max_Upload_File_Size'}) {
			$Msg.="$Language{'error_max_upload_file_size'} <b>$Global{'Max_Upload_File_Size'} $Language{'kilo_bytes'}</b><br>";
	}
	
	if ( ( $Fsize+$Param{'Uploaded_User_Size'})> $Global{'Max_Upload_Size'}) {
			$Msg.="$language{'error_max_total_upload_size'} <b>$Global{'Max_Upload_Size'} $Language{'kilo_bytes'}</b><br>";
	}

	if (!$Msg) {
			$Param{'Uploaded_Files'}.="$Fname|";
			$Param{'Uploaded_User_Size'}+=$Fsize;
			$Param{'Uploaded_User_Count'}++;
	 }
	else {
			unlink ("$Fname");
	}

	return $Msg;
}
#==========================================================
sub Get_Random_Filename{
my($Temp_dir, $ext)=@_;
my($Fname, $Temp_file)=("", "");

   do {
			$Fname=int (rand(99999999999)).".".$ext;
			$Temp_file  = "$Temp_dir/$Fname";
   } until (!-e $Temp_file);

   return $Temp_file;
}
#==========================================================

#==========================================================
1;