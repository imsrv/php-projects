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
sub Get_Title_Enhancement{
my(@Title_Enhancement, $x);
my($Title_Enhancement);
my($Preffix, $Suffix, $Name);

	@Title_Enhancement = split('~#~', $Language{'title_enhancement_tags'});
	$x=0;
	foreach  $Title_Enhancement(@Title_Enhancement) {
				($Preffix, $Suffix, $Name)=split(/\|/, $Title_Enhancement);
				$Title_Suffix[$x]=$Suffix;
				$Title_Preffix[$x]=$Preffix;
				$x++;
	}
}
#==========================================================
sub Sort_Items_By_Price_Up{
        @Item_Info = sort { $a->{'Current_Bid'} <=> $b->{'Current_Bid'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Price_Dn{
        @Item_Info = sort { $b->{'Current_Bid'} <=> $a->{'Current_Bid'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_End_Time_Up{
        @Item_Info = sort { $a->{'End_Time'} <=> $b->{'End_Time'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_End_Time_Dn{
        @Item_Info = sort { $b->{'End_Time'} <=> $a->{'End_Time'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Bids_Up{
        @Item_Info = sort { $a->{'Bids'} <=> $b->{'Bids'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Bids_Dn{
        @Item_Info = sort { $b->{'Bids'} <=> $a->{'Bids'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Title_Up{
        @Item_Info = sort { $a->{'Title'} cmp $b->{'Title'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Title_Dn{
        @Item_Info = sort { $b->{'Title'} cmp $a->{'Title'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Quantity_Up{
        @Item_Info = sort { $a->{'Quantity'} <=> $b->{'Quantity'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Quantity_Dn{
        @Item_Info = sort { $b->{'Quantity'} <=> $a->{'Quantity'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Photo_Up{
        @Item_Info = sort { $a->{'Uploaded_Files'} cmp $b->{'Uploaded_Files'} } @Item_Info;
}
#==========================================================
sub Sort_Items_By_Photo_Dn{
        @Item_Info = sort { $b->{'Uploaded_Files'} cmp $a->{'Uploaded_Files'} } @Item_Info;
}
#==========================================================
sub Prepare_Sorting{

	if ($Param{'Sort'} eq "Title"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'Title_Dir'} = "Dn";
			}
			else{
				$Param{'Title_Dir'} = "Up";
			}
	}

	if ($Param{'Sort'} eq "Qty"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'Qty_Dir'} = "Dn";
			}
			else{
				$Param{'Qty_Dir'} = "Up";
			}
	}

	if ($Param{'Sort'} eq "CurBid"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'CurBid_Dir'} = "Dn";
			}
			else{
				$Param{'CurBid_Dir'} = "Up";
			}
	}

	if ($Param{'Sort'} eq "Bids"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'Bids_Dir'} = "Dn";
			}
			else{
				$Param{'Bids_Dir'} = "Up";
			}
	}

	if ($Param{'Sort'} eq "Photo"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'Photo_Dir'} = "Dn";
			}
			else{
				$Param{'Photo_Dir'} = "Up";
			}
	}

	if ($Param{'Sort'} eq "End"){
			if ($Param{'Dir'} eq "Up"){
				$Param{'End_Dir'} = "Dn";
			}
			else{
				$Param{'End_Dir'} = "Up";
			}
	}

}
#==========================================================
sub Sort_Items{

	if ($Param{'Sort'} eq "Title"){
			if ($Param{'Dir'} eq "Up"){
					&Sort_Items_By_Title_Up;
			}
			else{
					&Sort_Items_By_Title_Dn;
			}
	}

	if ($Param{'Sort'} eq "Qty"){
			if ($Param{'Dir'} eq "Up"){
					&Sort_Items_By_Quantity_Up;
			}
			else{
					&Sort_Items_By_Quantity_Dn;
			}
	}

	if ($Param{'Sort'} eq "CurBid"){
			if ($Param{'Dir'} eq "Up"){
					&Sort_Items_By_Price_Up;
			}
			else{
					&Sort_Items_By_Price_Dn;
			}
	}

	if ($Param{'Sort'} eq "Bids"){
			if ($Param{'Dir'} eq "Up"){
					&Sort_Items_By_Bids_Up;
			}
			else{
					&Sort_Items_By_Bids_Dn;
			}
	}

	if ($Param{'Sort'} eq "Photo"){
			if ($Param{'Dir'} eq "Up"){
					&Sort_Items_By_Photo_Up;
			}
			else{
					&Sort_Items_By_Photo_Dn;
			}
	}

	if ($Param{'Sort'} eq "End"){
			if ($Param{'Dir'} eq "Up"){
				&Sort_Items_By_End_Time_Up;
			}
			else{
				&Sort_Items_By_End_Time_Dn;
			}
	}

}
#==========================================================
sub Sort_Page{

	if ($Param{'View'} eq "List") {
			&Read_Language_File($Global{'Language_General_File'});
			&Read_Category_Items($Param{'Cat_ID'});
			$Param{'Page'}=1;
			&Get_Menu_Bar;
			&Categories_Form($Param{'Cat_ID'}, "View_Cat");

			$Table = &Get_Items_Page_List("View_Page", "Sort_Page&View=List", "View_Item");
			if (!$Table){$Table = $Language{'no_items_in_this_category'};}
			$Plugins{'Body'}=$Table;

			&Get_Featured_Items_Form($Param{'Cat_ID'});
			&Display($Global{'Category_Template'});
	}
	else{
			&Search;
	}

}
#==========================================================
sub Get_Items_Page_List{
my($Action, $Sort_Action, $View_Item_Action) = @_;
my ($Temp, $ID, $Item_Link, $x, $Cat_ID);
my ($Start_Item, $End_Item, $Curr, $Menu_Top, $Menu_Bottom);
my ($Current_Page, $Next_Page, $Previous_Page, $Last_Page);
my ($Next_Page_Link, $Previous_Page_Link, @Item, $Counter);
my ($Table, $Row, $Menu, @Table_Rows, $Thumb_Width, $Thumb_Height);

	@Table_Rows = ($Global{'Listing_Table_Row'}, $Global{'Listing_Table_Row1'});

	&Get_Title_Enhancement;

	&Prepare_Sorting;
	&Sort_Items($Param{'Sort'}, $Param{'Dir'});

	$Curr = $Global{'Currency_Symbol'};
	if (!$Param{'User_ID'}) {$Param{'User_ID'} = "";}
	if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} = "";}
	$Cat_ID = $Param{'Cat_ID'};

	if (!$Param{'Sort'}){$Param{'Sort'} = "End";}
	if (!$Param{'Dir'}){$Param{'Dir'} = "Up";}
	if (!$Param{'Terms'}) {$Param{'Terms'} = "";}
	if (!$Param{'Terms_Encoded'}){$Param{'Terms_Encoded'} = "";}
	if (!$Param{'Where'}){$Param{'Where'} = "All_Auctions";}
	if (!$Param{'Search'}){$Param{'Search'} = "All";}
	if (!$Param{'Search_Preferences'}){$Param{'Search_Preferences'} = "";}
	if (!$Param{'Title_Dir'}){$Param{'Title_Dir'} = "Up";}
	if (!$Param{'Qty_Dir'}) {$Param{'Qty_Dir'} = "Up";}
	if (!$Param{'CurBid_Dir'}) {$Param{'CurBid_Dir'} = "Up";}
	if (!$Param{'Bids_Dir'}) {$Param{'Bids_Dir'} = "Up";}
	if (!$Param{'Photo_Dir'}) {$Param{'Photo_Dir'} = "Up";}
	if (!$Param{'End_Dir'}) {$Param{'End_Dir'} = "Up";}
	#------------------------------------------------------
	$Thumb_Width = $Global{'Thumbnail_Width'};
	$Thumb_Height = $Global{'Thumbnail_Height'};
	#------------------------------------------------------
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}
	$Last_Page=int($Items_Count / $Global{'Items_Per_Page'});
	if (($Items_Count % $Global{'Items_Per_Page'})) { $Last_Page++; }
	$Current_Page=$Param{'Page'};
	$Next_Page=($Current_Page + 1);
	$Previous_Page = ($Current_Page - 1);
	if ($Next_Page > $Last_Page) {$Next_Page = $Last_Page;}
	#------------------------------------------------------
	$Temp = qq!$Script_URL?action=$Action&Page=$Next_Page&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=$Param{'Sort'}&Dir=$Param{'Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Next_Page_Link = qq!<A HREF="$Temp">$Language{'next_page_label'}</A>!;

	$Temp = qq!$Script_URL?action=$Action&Page=$Previous_Page&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=$Param{'Sort'}&Dir=$Param{'Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Previous_Page_Link = qq!<A HREF="$Temp">$Language{'previous_page_label'}</A>!;
	#----------------------------------------------
	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=Title&Dir=$Param{'Title_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'Title_Link'} = qq!<A HREF="$Temp">$Language{'list_header_title'}</A>!;

	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=Qty&Dir=$Param{'Qty_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'Quantity_Link'} = qq!<A HREF="$Temp">$Language{'list_header_quantity'}</A>!;
	
	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=CurBid&Dir=$Param{'CurBid_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'Current_Bid_Link'} = qq!<A HREF="$Temp">$Language{'list_header_current_bid'}</A>!;

	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=Bids&Dir=$Param{'Bids_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'Bids_Link'} = qq!<A HREF="$Temp">$Language{'list_header_bids'}</A>!;
	
	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=Photo&Dir=$Param{'Photo_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'Photo_Link'} = qq!<A HREF="$Temp">$Language{'list_header_photo'}</A>!;

	$Temp = qq!$Script_URL?action=$Sort_Action&Page=1&Cat_ID=$Cat_ID&User_ID=$Param{'User_ID'}&Lang=$Global{'Language'}&Sort=End&Dir=$Param{'End_Dir'}&Search_Preferences=$Param{'Search_Preferences'}&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
	$Plugins{'End_Time_Link'} = qq!<A HREF="$Temp">$Language{'list_header_time_left'}</A>!;
	#------------------------------------------------------
	if ($Current_Page == $Last_Page || $Items_Count <= 0) {
			$Plugins{'Next_Page'}=$Language{'next_page_label'};
	}
	else{
			$Plugins{'Next_Page'}=$Next_Page_Link;
	}

	if ($Current_Page == 1) {
			$Plugins{'Previous_Page'}=$Language{'previous_page_label'};
	}
	else{
			$Plugins{'Previous_Page'}=$Previous_Page_Link;
	}
	#------------------------------------------------------
	$Menu_Top = qq!<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
									<TR><FORM NAME="Jump_Menu_Top" METHOD="POST" ACTION="$Script_URL"><TD>
								  !;
	$Menu_Bottom = qq!<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
										<TR><FORM NAME="Jump_Menu_Bottom" METHOD="POST" ACTION="$Script_URL"><TD>
									  !;
	$Menu = qq!<INPUT TYPE="hidden" NAME="Lang" VALUE="$Global{'Language'}">
						<INPUT TYPE="hidden" NAME="Cat_ID" VALUE="$Param{'Cat_ID'}">
						<INPUT TYPE="hidden" NAME="Sort" VALUE="$Param{'Sort'}">
						<INPUT TYPE="hidden" NAME="Dir" VALUE="$Param{'Dir'}">
						<INPUT TYPE="hidden" NAME="Terms" VALUE="$Param{'Terms_Encoded'}">			
						<INPUT TYPE="hidden" NAME="Where" VALUE="$Param{'Where'}">			
						<INPUT TYPE="hidden" NAME="Search" VALUE="$Param{'Search'}">			
						<INPUT TYPE="hidden" NAME="Search_Preferences" VALUE="$Param{'Search_Preferences'}">
						<input type="hidden" name="action" value="$Action">
						!;

	$Menu .= qq!<select NAME="Page" SIZE="1">!;
	for $x(1..$Last_Page) {
					$Temp="";
					if ($x == $Current_Page) {$Temp="selected"; }
					$Menu .= qq!<OPTION VALUE="$x" $Temp>$x!;
	}
	$Menu .= qq!</select></TD><TD>!;

	$Menu_Top .= $Menu . $Language{'page_select_menu_top_button'};
	$Menu_Bottom .= $Menu . $Language{'page_select_menu_bottom_button'};
	$Menu_Top .= qq!</TD></FORM></TR></TABLE>!;
	$Menu_Bottom .= qq!</TD></FORM></TR></TABLE>!;
	$Plugins{'Page_Select_Menu'} = $Menu_Top;
	$Plugins{'Page_Select_Menu1'} = $Menu_Bottom;

	if ($Items_Count <= 0) {$Plugins{'Page_Select_Menu'} = ""; $Plugins{'Page_Select_Menu1'} = "";}
	#---------------------------------------------------------------------------------------
	$Items_Count =~ s/\s+//g;
	$Current_Page =~ s/\s+//g;
	$Last_Page =~ s/\s+//g;
	$Plugins{'Items_Count'} = $Items_Count;
	$Plugins{'Current_Page'} = $Current_Page;
	$Plugins{'Total_Pages'} = $Last_Page; 
	#======================================================
	#======================================================
	$Start_Item = ($Current_Page -1) * $Global{'Items_Per_Page'};
	$End_Item = $Start_Item + $Global{'Items_Per_Page'};
	if ($End_Item > $Items_Count) {$End_Item = $Items_Count;}

	$Table = "";

    for $Counter($Start_Item..$End_Item-1) {
				$Row = $Table_Rows[int($Counter % 2)]; 
				$ID = $Item_Info[$Counter]{'Item_ID'};
				$Cat_ID = $Item_Info[$Counter]{'Cat_ID'};

				($Item[$Counter]{'Country'},
				$Item[$Counter]{'Item_Language'},
				$Item[$Counter]{'ypChecks'},
				$Item[$Counter]{'yccMorders'},
				$Item[$Counter]{'yCCards'},
				$Item[$Counter]{'escrow'},
				$Item[$Counter]{'shipping'},
				$Item[$Counter]{'ship_time'},
				$Item[$Counter]{'Ship_Internationally'},
				$Item[$Counter]{'Start_Bid'},
				$Item[$Counter]{'Increment'},
				$Item[$Counter]{'Location'},
				$Item[$Counter]{'Featured_Homepage'},
				$Item[$Counter]{'Featured_Category'},
				$Item[$Counter]{'Reserve'},
				$Item[$Counter]{'BuyPrice'},
				$Item[$Counter]{'BidRating'},
				$Item[$Counter]{'Closing_Time'},
				$Item[$Counter]{'Resubmit'},
				$Item[$Counter]{'Homepage'},
				$Item[$Counter]{'Resubmited'}) = split(/\~\|\~/, $Item_Info[$Counter]{'Item_Extra'});
				#-----------------------------------------------------------------		
				
				$Item_Link=qq!$Script_URL?action=$View_Item_Action&Item_ID=$ID&Cat_ID=$Cat_ID&Lang=$Global{'Language'}!;
				$Temp=qq!<A HREF="$Item_Link">$Title_Preffix[$Item_Info[$Counter]{'Title_Enhancement'}] $Item_Info[$Counter]{'Title'} $Title_Suffix[$Item_Info[$Counter]{'Title_Enhancement'}]</A>!;
				$Row=~ s/<!--Title-->/$Temp/;

				$Row=~ s/<!--Quantity-->/$Item_Info[$Counter]{'Quantity'}/;

				$Item_Info[$Counter]{'Current_Bid'} =~ s/\s//g;
				$Row=~ s/<!--Current_Bid-->/$Curr$Item_Info[$Counter]{'Current_Bid'}/;
				#--------------------------------------------------
				$Temp = "";
				if ($Item_Info[$Counter]{'Uploaded_Files'}) {
						@Photo=split(/\|/, $Item_Info[$Counter]{'Uploaded_Files'});
						@Photos=split(/\//, $Photo[0]);
						$Photo=pop @Photos;
						$Photo="$Global{'Base_Upload_URL'}/$Photo";
						if ($Photo) { 
								$Temp = qq!<A HREF="$Item_Link"><IMG SRC="$Photo" border="01" alt="photo"  ALIGN="absMiddle" WIDTH="$Thumb_Width" HEIGHT="$Thumb_Height"></A>!;
						}
				}
				$Row=~ s/<!--THUMBNAIL-->/$Temp/g;
				#-------------------------------------------------------------------------
				if ($Item_Info[$Counter]{'Bids'} == 0) { 
						$List="-"; 
				}
				else{
						$List=qq!<A HREF="$Script_URL?action=Bid_History&Cat_ID=$Item_Info[0]{'Cat_ID'}&Item_ID=$ID&Lang=$Global{'Language'}">$Item_Info[$Counter]{'Bids'}</a>!;
				}
				$Row=~ s/<!--Bids-->/$List/;
			#======================================================		
			$Temp = "";
			if ($Item_Info[$Counter]{'Gift_Icon'}) {
					$Temp = qq!<img src="$Global{'ImagesDir'}/$Item_Info[$Counter]{'Gift_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
			}
			$Row=~ s/<!--GIFT-->/$Temp/g;
			#------------------------------------------------------
			$Temp = "";
			if ($Item[$Counter]{'BuyPrice'}) {
					$Temp = qq! <img src="$Global{'ImagesDir'}/buyitnow.gif" border="0" alt="$Language{'buy_it_now_icon'}">!;
			}
			$Row=~ s/<!--BUY-->/$Temp/g;
			#------------------------------------------------------
			$Temp = "";
			$Time = int(&Time(time) - $Item_Info[$Counter]{'Start_Time'}) / (3600);	
			if ($Time < $Global{'New_Item_Houres'}) {
					$Temp = qq! <img src="$Global{'ImagesDir'}/$Global{'New_Icon'}" border=0 alt="$Language{'new_icon'}">!;
			}
			$Row =~ s/<!--NEW-->/$Temp/g;

			$Temp = "";
			$Temp1 = "";
			if ($Item_Info[$Counter]{'Bids'}>=$Global{'Hot_Item_Bids'}) {
					$Temp = qq! <img src="$Global{'ImagesDir'}/$Global{'Hot_Icon'}" border=0 alt="$Language{'hot_icon'}">!;
			}
			elsif ($Item_Info[$Counter]{'Bids'}>=$Global{'Cool_Item_Bids'}) {
					$Temp1 = qq! <img src="$Global{'ImagesDir'}/$Global{'Cool_Icon'}" border=0 alt="$Language{'cool_icon'}">!;

			}
			$Row=~ s/<!--HOT-->/$Temp/g;
			$Row=~ s/<!--COOL-->/$Temp1/g;
			#------------------------------------------------------------------------
			$Temp = "";
			if (($Item[$Counter]{'Featured_Homepage'} ) || ($Item[$Counter]{'Featured_Category'})) {
					$Temp = qq! <img src="$Global{'ImagesDir'}/$Global{'Featured_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
			}
			$Row=~ s/<!--FEATURED-->/$Temp/g;
			#------------------------------------------------------------------------

			if ($Item_Info[$Counter]{'End_Time'} < &Time(time)) {
						$Temp = $Language{'item_closed'};
				}
			else{
						$Temp = &Time_Diff($Item_Info[$Counter]{'End_Time'}, &Time(time));
						$Time = ($Item_Info[$Counter]{'End_Time'} - &Time(time));
						$Time = int($Time/ 60);
						if ($Time <= $Global{'Time_left_To_Change_Color1'}) {
							$Temp = $Global{'Time_left_To_Change_Color_Preffix1'} . $Temp . $Global{'Time_left_To_Change_Color_Suffix1'};
						}
						elsif ($Time <= $Global{'Time_left_To_Change_Color'}) {
							$Temp = $Global{'Time_left_To_Change_Color_Preffix'} . $Temp . $Global{'Time_left_To_Change_Color_Suffix'};
						}
			}
			$Row=~ s/<!--Duration-->/$Temp/;
			#------------------------------------------------------------------------
			$Table .= $Row;
	}#end for 
	#----------------------------------------------------------------------------

	#$Table =~ s/(<!--SEARCH_TERMS-->)/$Param{'Terms'}/g;
	$Plugins{'Search_Terms'} = $Param{'Terms'}; # if defined ($Param{'Terms'}); 	

	return $Table;	

}
#==========================================================
#==========================================================
1;