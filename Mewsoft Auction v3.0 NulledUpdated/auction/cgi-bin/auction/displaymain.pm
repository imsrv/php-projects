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
sub Display_Categories_Tree{
my($Temp);

	$PageNumber=0;
	$Plugins{'Menu_Bar'}="";
	&Read_Language_File($Global{'Language_General_File'});

	$Plugins{'Category_Tree_Link'}=qq!<A HREF="$Script_URL?action=Display_Categories&Lang=$Global{'Language'}">$Language{'display_categories_page'}</a>!;
	$Plugins{'Body'}=&Category_Tree_Form("View_Cat", 1);
	&Display($Global{'All_Categories_Template'});

}
#==========================================================
sub Display_Categories{
my($Temp, $Temp1);

	$PageNumber=0;
	$Plugins{'Menu_Bar'}="";
	&Read_Language_File($Global{'Language_General_File'});

	$Plugins{'Category_Tree_Link'}=qq!<A HREF="$Script_URL?action=Display_Categories_Tree&Lang=$Global{'Language'}">$Language{'display_all_categories'}</a>!;

	$Temp=$Global{'Category_Unders_Mode'};
	$Temp1=$Global{'Category_Columns'};

	$Global{'Category_Unders_Mode'} = 3;
	$Global{'Category_Columns'}=$Global{'Category_Browse_Columns'};

	$Plugins{'Body'}=&Categories_Form("", "Browse_Categories");
	
	$Global{'Category_Unders_Mode'}=$Temp;
	$Global{'Category_Columns'}=$Temp1;

	&Display($Global{'All_Categories_Template'});

}
#==========================================================
sub Browse_Categories{
my ($Out, $Temp, $Temp1);

	$PageNumber=0;
	$Plugins{'Menu_Bar'}="";
	&Read_Language_File($Global{'Language_General_File'});

	$Plugins{'Category_Tree_Link'}=qq!<A HREF="$Script_URL?action=Display_Categories_Tree&Lang=$Global{'Language'}">$Language{'display_all_categories'}</a>!;

	&Get_Menu_Bar;

	$Temp=$Global{'Category_Unders_Mode'};
	$Temp1=$Global{'Category_Columns'};

	$Global{'Category_Unders_Mode'} = 3;
	$Global{'Category_Columns'}=$Global{'Category_Browse_Columns'};

	$Out=&Categories_Form($Param{'Cat_ID'}, "Browse_Categories");

	$Plugins{'Body'}=$Out;
	
	$Global{'Category_Unders_Mode'}=$Temp;
	$Global{'Category_Columns'}=$Temp1;

	if ($Out eq "") {
		$Plugins{'Body'}="";
		 eval "use displaylist";
		&Display_SubCategory;
		exit 0;
	}

	&Display($Global{'All_Categories_Template'});

}
#==========================================================
sub Display_Front_Page{

	$Param{'Page'}=1;
	$Plugins{'Menu_Bar'}="";

	&Read_Language_File($Global{'Language_General_File'});

	$Plugins{'Body'}=&Categories_Form("", "View_Cat");
	&Get_Featured_Items_Form("");
	&Display($Global{'FrontPage_Template'});

}
#==========================================================
sub Display_SubCategory{

	&Read_Language_File($Global{'Language_General_File'});

	&Read_Category_Items($Param{'Cat_ID'});
	$Param{'Page'}=1;
	$Param{'Sort'}="End";
	$Param{'Dir'}="Up";
	&Get_Menu_Bar;

	&Categories_Form($Param{'Cat_ID'}, "View_Cat");
	$Table = &Get_Items_Page_List("View_Page", "Sort_Page&View=List", "View_Item");
	if (!$Table){$Table = $Language{'no_items_in_this_category'};}
	#$Table =~ s/(<!--SEARCH_TERMS-->)/$Param{'Terms'}/g;
	$Plugins{'Body'}=$Table;

#my($Action, $Sort_Action);
#("action=Search",
#search, next, previous pages
#$url=qq!action=Search&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
#sort
#$url=qq!action=Sort_Page&View=Search&Search=$Param{'Search'}&Terms=$Param{'Terms_Encoded'}&Where=$Param{'Where'}!;
# category browse, next & previous
#action=View_Page
#$Sort_Action = "action=Sort_Page&View=List";
#$Menu_Action
#List: = View_Page, 
#search
#Search: = Search

	&Get_Featured_Items_Form($Param{'Cat_ID'});

	&Display($Global{'Category_Template'});
}
#==========================================================
sub Display_Listing_Page{

	if ($Param{'Page'}==1) {&Display_SubCategory; return;	}

	&Read_Language_File($Global{'Language_General_File'});

	&Read_Category_Items($Param{'Cat_ID'});
	&Get_Menu_Bar;
	&Categories_Form($Param{'Cat_ID'}, "View_Cat");

	$Table = &Get_Items_Page_List("View_Page", "Sort_Page&View=List", "View_Item");
	if (!$Table){$Table = $Language{'no_items_in_this_category'};}
	#$Table =~ s/(<!--SEARCH_TERMS-->)/$Param{'Terms'}/g;
	$Plugins{'Body'}=$Table;

	&Display($Global{'Listing_Template'});
}
#==========================================================
sub Categories_Form{
my ($Required_Category_ID, $Action) = @_;
my ($Required_Category, $Out, @all);
my($ID, $IDT, $t, $Unders, $Category_Columns);
my ($x, $y, $s, $cat, $url, @Category_Under);
my ($Under_url, $ColCounter, $Cat_Name);
my ($scat,$ssub, $sID, $VS, $Cat_ID);
my ($scaturl, @html, $L, $LL, $Lx, $Under_Separator);
my ($CatLine, $SubCatLine, $DescriptionLine, $Temp);
my ($Unders1,$Unders2, @Categories);

	 $CatLine = $Global{'Category_Form'};
	 $SubCatLine = $Global{'Under_Category_Form'};

	if (!$Required_Category_ID) {
			$Category_Columns = $Global{'Homepage_Category_Columns'};
			$Under_Separator = $Global{'Home_Page_Under_Separator'};
	}
	else{
			$Category_Columns = $Global{'Category_Columns'};
			$Under_Separator = $Global{'Under_Separator'};
	}

	$Required_Category=$Category_Root{$Required_Category_ID};
	@Categories=&Get_Sub_Categories($Required_Category);

	#--------------------------Sort Alphabatically-------------------------------------------------------
	#@Categories = sort @Categories;
	$Cat_Num = @Categories;
	
	$Out = "";
	$ColCounter = 0;
	$Cats_Per_Col = int ($Cat_Num / $Category_Columns);
	if (($Cats_Per_Col *  $Category_Columns) < $Cat_Num){$Cats_Per_Col++;}
	#--------------------------------------------------------------
	foreach $cat_url(@Categories) {
			$ID=$Category_ID{$cat_url};
			$Cat_Name = $Category_Name{$ID};
			
			$Unders="";	$Unders1=""; $Unders2="";
			#----------------------------------------------------------------------
			if ($Global{'Category_Unders_Mode'} ==1 || $Global{'Category_Unders_Mode'} ==4) { # display only selected subs
				undef @Category_Under;
				@Category_Under=&Get_Category_Under($cat_url);
				#@Category_Under=sort @Category_Under;

				$Under_url="";
				$Lx=""; $L=""; $LL="";
				foreach $t (@Category_Under) {
					$tr=$cat_url.":".$t;
					$IDT=$Category_ID{$tr};
					$t = $Cat_Language{$t} if ($Cat_Language{$t});
					$LL=qq!<A HREF="$Script_URL?action=$Action&Cat_ID=$IDT&Lang=$Global{'Language'}">$t</A>!;
					$L= $SubCatLine;
					$L=~ s/<!--Under_Categories-->/$LL/;
					if ($Global{'Under_Category_Count'} eq "YES") {
									$Temp = $Language{'under_category_count_class'};
									$Temp=~ s/<!--Category_Count-->/$Category_Count{$tr}/g;
									$L=~ s/<!--Category_Count-->/$Temp/g;
					}

					$Lx.= $L;
					$Lx.= $Under_Separator;
				}

				$Under_url =$Lx;
				$Under_url =~ s/$Under_Separator$//;
				if ($Under_url ne "") { $Under_url .= $Global{'More_Categories'};}
				$Unders=$Under_url;
				$Unders1=$Under_url;
			}
			#----------------------------------------------------------------------
			if ($Global{'Category_Unders_Mode'} == 2  || $Global{'Category_Unders_Mode'} == 4) { # display category description
							$LL="";
							$LL = $Category_Description{$cat_url} if (defined $Category_Description{$cat_url});
							$Unders=$LL;
							$Unders2=$LL;
		    }
			#----------------------------------------------------------------------
			if ($Global{'Category_Unders_Mode'} ==3) { # display all subcategories underneath
				$Under_url="";

				@SubCategories=&Get_Sub_Categories($cat_url);
				#@SubCategories=sort @SubCategories;

				foreach $s(@SubCategories) {
					$sID=$Category_ID{$s};
					$Cats_Name = $Category_Name{$sID};
					$Cats_Name = $Cat_Language{$Cats_Name} if ($Cat_Language{$Cats_Name});
					$LL=qq!<A HREF="$Script_URL?action=$Action&Cat_ID=$sID&Lang=$Global{'Language'}">$Cats_Name</A>!;
					$L= $SubCatLine;
					$L=~ s/<!--Under_Categories-->/$LL/g;
					if ($Global{'Under_Category_Count'} eq "YES") {
							$Temp = $Language{'under_category_count_class'};
							$Temp=~ s/<!--Category_Count-->/$Category_Count{$s}/g;
							$L=~ s/<!--Category_Count-->/$Temp/g;
					}

					$L.=$Under_Separator;
					$Under_url.=$L;

				}
				$Under_url =~ s/$Under_Separator$//;
				$Unders=$Under_url;
			}
			#----------------------------------------------------------------------
			if ($Global{'Category_Unders_Mode'} ==4) { # display both decription and subs
					$Unders=$Unders2 . $Unders1;
			}
			#----------------------------------------------------------------------
			if ($Global{'Category_Unders_Mode'} >4 || $Global{'Category_Unders_Mode'} <1) {
					$Unders="";
			}

			$url=qq!$Script_URL?action=$Action&Cat_ID=$ID&Lang=$Global{'Language'}!;

			$L=$CatLine;

			$Cat_Name = $Cat_Language{$Cat_Name} if ($Cat_Language{$Cat_Name});	
			
			$L=~ s/<!--Category_Name-->/$Cat_Name/g;
			$L=~ s/<!--Category_URL-->/$url/g;

			#Category folder
			$Folder = "";
			if ($Global{'Category_Folder'} eq "YES"){
				if (!$Required_Category) {
					if ($Global{'Unique_Homepage_Category_Folder'} eq "YES") {
							$Folder = qq!<A HREF="$url"><img src="$Global{'ImagesDir'}/$ID.gif" border="0"></A>!;
					}
					else{
							$Folder = qq!<A HREF="$url"><img src="$Global{'ImagesDir'}/$Global{'Homepage_Category_Folder_Image'}" border="0"></A>!;
					}
				}
				else{
							$Folder = qq!<A HREF="$url"><img src="$Global{'ImagesDir'}/$Global{'Category_Folder_Image'}" border="0"></A>!;
				}
			}
			
			$L=~ s/<!--Category_Folder-->/$Folder/g;

			if ($Global{'Category_Count'} eq "YES") {
							$Temp = $Language{'category_count_class'};
							$Temp=~ s/<!--Category_Count-->/$Category_Count{$cat_url}/g;
							$L=~ s/<!--Category_Count-->/$Temp/g;
			}

			$L =~ s/<!--Category_Teasers-->/$Unders/;
			if ($ColCounter == $Cats_Per_Col) {$Out .= qq!</TD>\n<TD WIDTH=$Global{'Category_HSpace'}></TD>\n!; $ColCounter=0;}
			if ($ColCounter == 0) {$Out.=qq!<TD ALIGN="LEFT" VALIGN="TOP">\n!;}
			$Out .= $L;
			$ColCounter++;
	}

	$Out.=qq!</TD>\n!;
	$Categories_Form = $Global{'Categories_Table'};
	$Categories_Form =~ s/<!--Categories-->/$Out/;

	$Plugins{'Categories'}= $Categories_Form;
	if (@Categories == 0) {$Plugins{'Categories'}=""; $Out="";}

	return $Categories_Form;
}
#==========================================================
sub Get_Menu_Bar{
my($Full_Bar) = @_;
my ($Out, $Cat, $CatLink, @URLs, $Home);
my ($x, $Last, $Catbar, $Caturl, $ID, $Cat_Name);

	#&Initialize_Categories;
	$Out = ""; $Last = "";
	$Home=qq!<A HREF="$Global{'Auction_Script_URL'}?Lang=$Global{'Language'}">$Language{'auction_home_bar'}</A>!;

	$Cat=$Category_Root{$Param{'Cat_ID'}};
	$CatLink=qq!<A HREF=$Script_URL?action=View_Cat&Lang=$Global{'Language'}!;

	@URLs=split(/:/, $Cat);
	if (!$Full_Bar) {$Last=pop (@URLs);}
	
	if ($#URLs>=0) {
	for ($x=$#URLs; $x>=0 ; $x--) {
		$Cat_Name=$URLs[$x];
		$Caturl=join(":", @URLs);
		$ID=$Category_ID{$Caturl};
		$Cat_Name = $Cat_Language{$Cat_Name} if ($Cat_Language{$Cat_Name});
		$Catbar[$x]= qq!<A HREF="$Script_URL?action=View_Cat&Cat_ID=$ID&Lang=$Global{'Language'}">$Cat_Name</A>!;
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

	$Plugins{'Menu_Bar'} = "$Home$Global{'MenuLine_Home'}$Cat";
	return $Plugins{'Menu_Bar'};
}
#==========================================================
sub Get_Featured_Items_Form{
my($Cat_ID) = shift;
my($Out);

	if (!$Cat_ID) {
			&Get_Featured_Home_Items;
			$Out = &List_Featured_Items("", $Global{'Featured_Home_Items_Per_Page'});
			$Plugins{'Featured_Home_Listing'}=$Out;
	}
	else{
			&Get_Featured_Category_Items($Cat_ID);
			$Out=&List_Featured_Items($Cat_ID, $Global{'Featured_Items_Per_Page'});
			$Plugins{'Featured_Category_Listing'}=$Out;
	}

	return $Out;

}
#==========================================================
sub List_Featured_Items{
my($Featured_Cat_ID, $Items_Per_Page)=@_;
my ($CatID, $title, $titleurl, $ID);
my ($midiurl, $midi, $StartItem);
my ($Time_left, $x, $Cat_ID, $Curr);
my ($Listing_Body, $Listing_Row);
my ($Current_Page, $Next_Page, $Previous_Page, $Last_Page);
my ($Next_Page_Link, $Previous_Page_Link, $url);
my ($Out, $L, $Count, $Img, $Img1, $List);	
my($Thumbnail_Width, $Thumbnail_Height);

	if (!$Featured_Cat_ID) {
			@Listing_Row=(&Translate($Global{'Listing_Featured_Home_Table_Row'}), &Translate($Global{'Listing_Featured_Home_Table_Row1'}));
			$Thumbnail_Width = $Global{'Home_Page_Thumbnail_Width'};
			$Thumbnail_Height = $Global{'Home_Page_Thumbnail_Height'};
	}
	else{
			@Listing_Row=(&Translate($Global{'Listing_Featured_Category_Table_Row'}), &Translate($Global{'Listing_Featured_Category_Table_Row1'}));
			$Thumbnail_Width = $Global{'Category_Thumbnail_Width'};
			$Thumbnail_Height = $Global{'Category_Thumbnail_Height'};
	}

	$Param{'Sort'}="End";
	$Param{'Dir'}="Up";
	&Sort_Items($Param{'Sort'}, $Param{'Dir'});
	$Curr = $Global{'Currency_Symbol'};

    for ($Count=0; $Count < $Items_Per_Page;  $Count++) {
	  if ($Count >= $Items_Count) {last;}
		$L = $Listing_Row[int($Count % 2)]; 
		$title=$Item_Info[$Count]{'Title'};
		$ID=$Item_Info[$Count]{'Item_ID'};
		$CatID=$Item_Info[$Count]{'Cat_ID'};

		($Item[$Count]{'Country'},
		$Item[$Count]{'Item_Language'},
		$Item[$Count]{'ypChecks'},
		$Item[$Count]{'yccMorders'},
		$Item[$Count]{'yCCards'},
		$Item[$Count]{'escrow'},
		$Item[$Count]{'shipping'},
		$Item[$Count]{'ship_time'},
		$Item[$Count]{'Ship_Internationally'},
		$Item[$Count]{'Start_Bid'},
		$Item[$Count]{'Increment'},
		$Item[$Count]{'Location'},
		$Item[$Count]{'Featured_Homepage'},
		$Item[$Count]{'Featured_Category'},
		$Item[$Count]{'Reserve'},
		$Item[$Count]{'BuyPrice'},
		$Item[$Count]{'BidRating'},
		$Item[$Count]{'Closing_Time'},
		$Item[$Count]{'Resubmit'},
		$Item[$Count]{'Homepage'},
		$Item[$Count]{'Resubmited'}) = split(/\~\|\~/, $Item_Info[$Count]{'Item_Extra'});
		#-----------------------------------------------------------------		
		
		$url=qq!$Script_URL?action=View_Item&Item_ID=$ID&Cat_ID=$CatID&Lang=$Global{'Language'}!;
		$titleurl=qq!<A HREF="$url">$title</A>!;
		$L=~ s/<!--Title-->/$titleurl/;

		$L=~ s/<!--Quantity-->/$Item_Info[$Count]{'Quantity'}/;

		$Item_Info[$Count]{'Current_Bid'} =~ s/\s//g;
		$L=~ s/<!--Current_Bid-->/$Curr$Item_Info[$Count]{'Current_Bid'}/;
		#--------------------------------------------------
		$List="";
		if ($Item_Info[$Count]{'Uploaded_Files'}) {
				@Photo=split(/\|/, $Item_Info[$Count]{'Uploaded_Files'});
				@Photos=split(/\//, $Photo[0]);
				$Photo=pop @Photos;
				$Photo="$Global{'Base_Upload_URL'}/$Photo";
				if ($Photo ne "") {
						$List = qq!<A HREF="$url"><IMG SRC="$Photo" border="01" alt="photo"  ALIGN="absMiddle" WIDTH="$Thumbnail_Width" HEIGHT="$Thumbnail_Height"></A>!;
				}
		}
		$L=~ s/<!--THUMBNAIL-->/$List/g;
		#-------------------------------------------------------------------------
		if ($Item_Info[$Count]{'Bids'} == 0) { 
				$List="-"; 
		}
		else{
				$List=qq!<A HREF="$Script_URL?action=Bid_History&Cat_ID=$Item_Info[$Count]{'Cat_ID'}&Item_ID=$Item_Info[$Count]{'Item_ID'}&Lang=$Global{'Language'}">$Item_Info[$Count]{'Bids'}</a>!;
		}
		$L=~ s/<!--Bids-->/$List/;
		#--------------------------------------------------
		if ( $Item_Info[$Count]{'Uploaded_Files'}) {
			$midiurl=qq!<img border="0" src="$Global{'Midi_Icon_File'}" alt="$Language{'photo_alt_text'}">!;
			$L=~ s/<!--Uploaded_Files-->/$midiurl/;
		  }
		else {
		      $L=~ s/<!--Uploaded_Files-->/&nbsp;/; 
		}
		#------------------------------------------------------
		$Img="";
		if ($Item[$Count]{'BuyPrice'}) {
				$Img=qq!<img src="$Global{'ImagesDir'}/buyitnow.gif" border="0" alt="$Language{'buy_it_now_icon'}">!;
		}
		$L=~ s/<!--BUY-->/$Img/g;
		#------------------------------------------------------
		$Img="";
		if ($Item_Info[$Count]{'Gift_Icon'} ne "") {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Item_Info[$Count]{'Gift_Icon'}" border=0 alt="$Language{'gift_icon'}">!;
		}
		$L=~ s/<!--GIFT-->/$Img/g;

		$Img="";
		$Time=int(&Time(time) - $Item_Info[$Count]{'Start_Time'}) / (3600);	
		if ($Time < $Global{'New_Item_Houres'}) {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'New_Icon'}" border=0 alt="$Language{'new_icon'}">!;
		}
		$L=~ s/<!--NEW-->/$Img/g;

		$Img="";
		$Img1="";
		if ($Item_Info[$Count]{'Bids'}>=$Global{'Hot_Item_Bids'}) {
			$Img=qq!<img src="$Global{'ImagesDir'}/$Global{'Hot_Icon'}" border=0 alt="$Language{'hot_icon'}">!;
		}
		elsif ($Item_Info[$Count]{'Bids'}>=$Global{'Cool_Item_Bids'}) {
			$Img1=qq!<img src="$Global{'ImagesDir'}/$Global{'Cool_Icon'}" border=0 alt="$Language{'cool_icon'}">!;

		}
		$L=~ s/<!--HOT-->/$Img/g;
		$L=~ s/<!--COOL-->/$Img1/g;
		#======================================================		
		if ($Item_Info[$Count]{'End_Time'} < &Time(time)) {
				$Time_left=$Language{'item_closed'};
		}
		else{
				($days, $hours, $minutes)= &Time_Left($Item_Info[$Count]{'End_Time'}, &Time(time));
				$Time_left= &Format_Time_Left($days, $hours, $minutes);
				$Time=abs($Item_Info[$Count]{'End_Time'} - &Time(time));
				$Time = int($Time/ 60);
				if ($Time<=$Global{'Time_left_To_Change_Color1'}) {
					$Time_left=$Global{'Time_left_To_Change_Color_Preffix1'}.$Time_left.$Global{'Time_left_To_Change_Color_Suffix1'};
				}
				elsif ($Time<=$Global{'Time_left_To_Change_Color'}) {
					$Time_left=$Global{'Time_left_To_Change_Color_Preffix'}.$Time_left.$Global{'Time_left_To_Change_Color_Suffix'};
				}
		}
		$L=~ s/<!--Duration-->/$Time_left/;
		$Out.=$L;
	}
	#----------------------------------------------------------------------------
	return $Out;	

}
#==========================================================
1;