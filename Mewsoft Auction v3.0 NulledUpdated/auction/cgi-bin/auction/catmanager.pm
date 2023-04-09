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
sub Sort_Cats_by_Name {
        
		@All_SubCategories = sort { $a->{'Category'} cmp $b->{'Category'} } @All_SubCategories;
}
#==========================================================
sub Sort_Cats_by_Sort_Num {
    
		@All_SubCategories = sort { $a->{'SortNum'} <=> $b->{'SortNum'} } @All_SubCategories;
}
#==========================================================
sub Sort_Cats_by_Name_And_Sort_Num {

	@All_SubCategories= sort { $a->{'SortNum'} <=> $b->{'SortNum'} or $a->{'SubCategory'} cmp $b->{'SubCategory'} or $a->{'Category'} cmp $b->{'Category'} } @All_SubCategories;

}						
#==========================================================
sub Prepare_Categories{

	&Initialize_Categories;

}
#==========================================================
sub Initialize_Categories{
my ($cat, $subcat, $caty, $subcaty, $catx);
my ($x, $y, $Line, %data, @Raw_Categories);

	undef @All_SubCategories;
	undef @Category_URL;
	undef %Category_ID;
	undef %Category_Accept;
	undef %Category_Active;
	undef %Category_Count;
	undef %Category_TFlag;
	undef %Category_SortNum;
	undef %Category_Description;
	undef %Category_Name;
	undef %Cat_Language;
	
	$All_SubCategories_Count=0;
	$Categories_Count=0;
	#--------------------------------------------------------
	&DB_Exist($Global{'Categories_Data_File'});
	tie %data, "DB_File", $Global{'Categories_Data_File'}, O_RDONLY
						or die "Cannot open categories database file $Global{'Categories_Data_File'} : $!\n";

	@Raw_Categories = values %data;
	untie %data;
	undef %data;
	#--------------------------------------------------------

	foreach $Line (@Raw_Categories) {
		$Line=~ s/\n//;
		$Line=~ s/\cM//;
		$Line=~ s/^\s+//;
		$Line=~ s/\s+$//;
		if ($Line ne ""  &&  $Line !~ m/^\#/ ) {
			@{$All_SubCategories[$All_SubCategories_Count++]}
				 {qw(Category SubCategory ID Active Accept Count SortNum Under_Flag Description)}=split(/\|/, $Line);
		}
	}

	&Sort_Cats_by_Name_And_Sort_Num;

	%Cat_Language=&Get_Language_File($Global{'Language_Categories_File'});

	$Global{'Categories_Count'}=$All_SubCategories_Count;

	#Read and prepare all categories and subcategories
	for $x (0..$All_SubCategories_Count-1) {
			$cat="";
			$subcat="";
			$cat=$All_SubCategories[$x]{'Category'};
			$subcat=$All_SubCategories[$x]{'SubCategory'};

			 if ($subcat eq "" && $cat !~ m/\:/) {
						$Main_Categories[$Categories_Count++]=$cat;
						$catname=$cat;
			 }
			 else{
					$cat.=":".$subcat;
					$catname=$subcat;
			}

			$Category_URL[$x]=$cat;
			$Category_ID{$cat}=$All_SubCategories[$x]{'ID'};
			$Category_Accept{$cat}=$All_SubCategories[$x]{'Accept'};
			$Category_Active{$cat}=$All_SubCategories[$x]{'Active'};
			$Category_Count{$cat}=$All_SubCategories[$x]{'Count'};
			$Category_TFlag{$cat}=$All_SubCategories[$x]{'Under_Flag'};
			$Category_SortNum{$cat}=$All_SubCategories[$x]{'SortNum'};
			$Category_Description{$cat}=$All_SubCategories[$x]{'Description'};
			$Category_Name{$All_SubCategories[$x]{'ID'}}=$catname;
			$Category_Root{$All_SubCategories[$x]{'ID'}}=$cat;
	}

}
#==========================================================
sub Get_Category_Under{
my($Required_Cat)=shift;
my($y, $caty, $subcaty);
my(@Category_Under);

	undef @Category_Under;

	for $y(0..$All_SubCategories_Count-1) {
		$caty=$All_SubCategories[$y]{'Category'};
		$subcaty=$All_SubCategories[$y]{'SubCategory'};
		if ( $caty eq $Required_Cat){
			if ($All_SubCategories[$y]{'Under_Flag'} !=0 && $subcaty ne "") {
				push(@Category_Under, $subcaty);
			}
		}
	}

	return (@Category_Under);
}
#==========================================================
sub  Get_Sub_Categories{
my ($Required_Category)=shift;
my ($cat, $subcat, @Catgeories);
my ($x, $SubCategories_Count);

$SubCategories_Count=0;

if ($Required_Category eq "") {# Read the main (root) categories only.
	for $x (0..$All_SubCategories_Count-1) {
			  $cat=$All_SubCategories[$x]{'Category'};
			  $subcat=$All_SubCategories[$x]{'SubCategory'};
			  if ( ($subcat eq "" && $cat !~ /\:/)) {
					$Catgeories[$SubCategories_Count++]=$cat;
			  }
	}
}
else {# Read the required category only.
	for $x (0..$All_SubCategories_Count-1) {
		$cat=$All_SubCategories[$x]{'Category'};
		$subcat=$All_SubCategories[$x]{'SubCategory'};
		if ( ($Required_Category eq $cat)){
			if ($subcat ne ""){
	  			    $cat.=":".$subcat; 
					$Catgeories[$SubCategories_Count++]=$cat;
			}
		}
	}
}

	return @Catgeories;

}
#==========================================================
sub Get_Subcategory_Tree{
my $Required_Category=shift;
my ($x, $cat, $subcat);
my ($Caturl, $Catname);

# Read the main (root) categories only.
$SubCategory_Tree_Count=0;

	for $x (0..$All_SubCategories_Count-1) {
		$cat="";
		$subcat="";
		$cat=$All_SubCategories[$x]{'Category'};
		$subcat=$All_SubCategories[$x]{'SubCategory'};
		
		if ( ($Required_Category eq $cat)){
			if ($subcat ne ""){
	  			    $cat.=":".$subcat; 
					$SubCategory_Tree_Name[$SubCategory_Tree_Count]=$subcat;
					$SubCategory_Tree_URL[$SubCategory_Tree_Count]=$cat;
					$SubCategory_Tree_Count++;
			}
		}
		else{

					@URLs=split(/:/, $cat);
					$Last=pop (@URLs);

					if ($#URLs>=0) {
						for ($x=$#URLs; $x>=0 ; $x--) {
							$Catname=$URLs[$x];
							$Caturl=join(":", @URLs);
							$ID=$Category_ID{$Caturl}; 
							if ($Caturl eq $Required_Category) {
	  							$cat.=":".$subcat; 
								$SubCategory_Tree_Name[$SubCategory_Tree_Count]=$Catname;
								$SubCategory_Tree_URL[$SubCategory_Tree_Count]=$cat;
								$SubCategory_Tree_Count++;
							}#end if
							pop (@URLs);
						}#end for
					
				} # end if
		}#end if						

	}#end for
}#end sub
#==========================================================
sub Get_Accept_Active_Categories{
my ($x, $cat, $subcat);

$Category_ON_Count=0;

for $x (0..$All_SubCategories_Count-1) {
	$cat=$All_SubCategories[$x]{'Category'};
	$subcat=$All_SubCategories[$x]{'SubCategory'};
	if ($subcat ne ""){	$cat.=":".$subcat; }
	#$Category_URL[$x]=$cat;
	#$Category_ID{$cat}=$All_SubCategories[$x]{'ID'};
	if ($All_SubCategories[$x]{'Accept'} !=0 && $All_SubCategories[$x]{'Active'} !=0){
		$Category_ON[$Category_ON_Count++]=$cat;
	}
}

	@Category_ON =  @Category_ON;
}
#==========================================================
sub Save_Category{
my ($ID, $NewCat)=@_;
my %data;

if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

tie %data, "DB_File", $Global{'Categories_Data_File'}
        or &Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$data{$ID}=$NewCat;

untie %data;
undef %data;

&Unlock($Global{'Categories_Data_File'});
}
#==========================================================
sub Get_New_Category_ID{
my %data;
my $ID;

	&DB_Exist($Global{'Categories_Data_File'});
	tie %data, "DB_File", $Global{'Categories_Data_File'}, O_RDONLY
			or &Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$ID=1;
	while (defined ($data{$ID})) {$ID++;}

	untie %data;

	return $ID;

}
#==========================================================
sub Remove_Category{
my (@Cats_ID)=@_;
my %data;
my $x;

if (!&Lock($Global{'Categories_Data_File'})) {&Exit("Cannot Lock database file $Global{'Categories_Data_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

tie %data, "DB_File", $Global{'Categories_Data_File'} or
						&Exit("Cannot open database file $Global{'Categories_Data_File'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

foreach $ID (@Cats_ID) {
	delete $data{$ID};
}

untie %data;
undef %data;

&Unlock($Global{'Categories_Data_File'});

}
#==========================================================
sub Category_Tree_Form{
my ($Action, $Control)=@_;
my ($Out, @subs);
my($catname, $cat, @Categories);
my($x, $root, $t, $r, $ID);

	@Categories=sort @Category_URL;	

	$Out="";
	for $x (0..$All_SubCategories_Count-1) {
		$catname=$Categories[$x];
		$ID=$Category_ID{$catname};
		@subs=split(/\:/, $catname);
		$cat=pop (@subs);
		$Root_Cat=join(":",@subs);
		
		$root="";
		$root="&nbsp;" x length ($Root_Cat);

		$t="&nbsp;" ;
		$r=qq!<img src="$Global{'ImagesDir'}/sub_tree.gif" border=0>!;
		$root=~ s/$t$/$r/;
		
		if ($Control == 0) { #admin, display all categories with links
				if ( $catname !~ /\:/) { #Main categories highlighted
					$r=qq!<img src="$Global{'ImagesDir'}/book_open.gif" border=0>!;
					$cat=qq!$r<i><font size="$Global{'Category_Tree_Root_Font_Size'}" face="$Global{'Category_Tree_Root_Font_Face'}" color="$Global{'Category_Tree_Root_Font_Color'}">$catname</font></i>!;
				}

				$Out.=qq!$root<A HREF="$Script_URL?action=$Action&Cat_ID=$ID&Lang=$Global{'Language'}">
								<font size="$Global{'Category_Tree_Sub_Font_Size'}" face="$Global{'Category_Tree_Sub_Font_Face'}">
								<b>$cat</b></font></A>&nbsp;<small>($Category_Count{$catname})</small><BR>!;
		}
		elsif ($Control == 1) {#User browse categories
			if ($Category_Active{$catname} != 0) {
				if ( $catname !~ /\:/) { #Main categories highlighted
						$r=qq!<IMG SRC="$Global{'ImagesDir'}/book_open.gif" BORDER=0>!;
						$catname = $Cat_Language{$catname} if ($Cat_Language{$catname});
						$cat=qq!$r<I><FONT SIZE="$Global{'Category_Tree_Root_Font_Size'}" FACE="$Global{'Category_Tree_Root_Font_Face'}" COLOR="$Global{'Category_Tree_Root_Font_Color'}">$catname</FONT></I>!;
				}
				else{
						$cat = $Cat_Language{$cat} if ($Cat_Language{$cat});
				}

				$Out.=qq!$root<A HREF="$Script_URL?action=$Action&Cat_ID=$ID&Lang=$Global{'Language'}">
								<FONT SIZE="$Global{'Category_Tree_Sub_Font_Size'}" FACE="$Global{'Category_Tree_Sub_Font_Face'}">
								<B>$cat</B></FONT></A>&nbsp;<SMALL>($Category_Count{$catname})</SMALL><BR>!;
			}
		}
		elsif ($Control == 2) {#User accept submissions categories only
				if ( $catname !~ /\:/) { #Main categories highlighted
					$r=qq!<IMG SRC="$Global{'ImagesDir'}/book_open.gif" BORDER=0>!;
					$catname = $Cat_Language{$catname} if ($Cat_Language{$catname});
					$cat=qq!$r<i><FONT SIZE="$Global{'Category_Tree_Root_Font_Size'}" FACE="$Global{'Category_Tree_Root_Font_Face'}" COLOR="$Global{'Category_Tree_Root_Font_Color'}">$catname</FONT></I>!;
				}
				else{
						$cat = $Cat_Language{$cat} if ($Cat_Language{$cat});
				}

				if ($Category_Active{$catname} != 0) {
					if ($Category_Accept{$catname} != 0) {
							$Out.=qq!$root<A HREF="$Script_URL?action=$Action&Cat_ID=$ID&Lang=$Global{'Language'}">
									<font size="$Global{'Category_Tree_Sub_Font_Size'}" face="$Global{'Category_Tree_Sub_Font_Face'}">
									<b>$cat</b></font></A><BR>!;
					}
					else{
							$Out.=qq!$root<font size=$Global{'Regular_Font_Size'} face=$Global{'Regular_Font_Face'}>
									<b>$cat</b></font><BR>!;
					}	
				}
		
		}#--

	}#End for
	
	return $Out;
}
#==========================================================
sub Get_Root_Cat_ID{
my ($Required_Cat_ID)=shift;
my ($Cat_URL, @Cat_Name, $Root_Cat_ID);

	$Cat_URL = $Category_Root{$Required_Cat_ID};
	@Cat_Name=split(/\:/, $Cat_URL);
	$Root_Cat_ID=$Category_ID{$Cat_Name[0]};
	return $Root_Cat_ID;
}
#==========================================================
sub Get_Cat_DB{
my ($Required_Cat_ID) = shift;
my ($Cat_URL, @Cat_Name, $Root_Cat_ID, $Cat_File);

	$Cat_URL = $Category_Root{$Required_Cat_ID};
	@Cat_Name=split(/\:/, $Cat_URL);
	$Root_Cat_ID=$Category_ID{$Cat_Name[0]};
	$Cat_File = $Global{'ItemsDir'}."Category_"."$Root_Cat_ID".".dat";
	return $Cat_File;
}
#==========================================================
1;
