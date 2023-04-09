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
sub Search{
my (@Required_Categories);

	&Read_Language_File($Global{'Language_General_File'});

	$Param{'Terms'}=&Web_Decode($Param{'Terms'});
	$Param{'Terms_Encoded'}=&Web_Encode($Param{'Terms'});
	if (!$Param{'Search_Preferences'}) {$Param{'Search_Preferences'} = "All";}

	if ($Param{'Search'} eq "All") {
			@Required_Categories= sort @Main_Categories;
			  #$Param{'Title_and_Description'}=01;
			&Do_Search( "All", @Required_Categories );
	}
	elsif ($Param{'Search'} eq "Category") {
   	   #$Param{'Title_and_Description'}=01; 
		if ($Param{'Where'} eq "All_Auctions") {
			@Required_Categories= sort @Main_Categories;
			&Do_Search( "All",  @Required_Categories );
		}
		else{ # Just_This_Category
			&Do_Search( "Category", $Category_Root{$Param{'Cat_ID'}} );
		}
	}
	else{ #Smart search
			 # $Param{'Title_and_Description'}=01;
			@Required_Categories= sort @Main_Categories;
			&Do_Search( "All",  @Required_Categories );
	}
	#-------------------------------------------------------------------
	$Table = &Get_Items_Page_List("Search", "Sort_Page&View=Search", "View_Item");
	if (!$Table){$Table = $Language{'no_match_search_results'};}
	#$Table =~ s/(<!--SEARCH_TERMS-->)/$Param{'Terms'}/g;
	$Plugins{'Body'}=$Table;

	&Get_Menu_Bar;
	&Categories_Form($Param{'Cat_ID'}, "View_Cat");
	&Display($Global{'Search_Template'});
}
#==========================================================
sub Do_Search{
my ($Search_in, @Required_Categories)=@_;
my ($Title, $Description);
my($R_Score, $O_Score);
my($Found, $x, $cat, $Cat, $L);
my $Out="";
my $Short_Body;
my ($Terms, $Term, $Counter);
my $Matched;
my @Match;
my @Terms;
my %Match;
my %Required_Words;
my %Execlud_Words;
my %Optional_Words;
my ($Cat_ID, $Search_Cat);

		@Terms = &Perpare_Search_Keywords($Param{'Terms'});
		#------------------------------------------------------------------------------------------
		foreach $Term( @Terms ) {
			   #$Term=~ s/ing$//;
			   #$Term=~ s/ies$//;
			   #$Term=~ s/s$//;
  
				if( $Term=~/^\+/) { 
						$Term =~s/\+//;
						$Required_Words{$Term}=1;
				 }      
				elsif( $Term=~/^\-/) { 
						$Term =~s/\-//;
						$Execlud_Words{$Term}=1;
				}      
				elsif( $Term=~/^\|/) { 
						$Term =~s/\|//;
						 $Optional_Words{$Term}=1;
				}      
				else {
						$Required_Words{$Term}=1;
				 }
	}
#--------------------------------------------------------------------------

$Matched=0;

$R_Score=keys %Required_Words;
$O_Score=keys %Optional_Words;

foreach $Search_Cat(@Required_Categories) {
	$Cat_ID = $Category_ID{$Search_Cat};
	if ($Search_in eq "All") {
				&Read_Root_Category_Items($Cat_ID);
	}
	else{ #search just this category
				&Read_Category_Items($Cat_ID);
	}

	for $Counter(0..$Items_Count -1) {
		$Title = &Web_Decode($Item_Info[$Counter]{'Title'});
		$Description = &Web_Decode($Item_Info[$Counter]{'Description'});
		$Found = 0;

		foreach $Term(keys %Required_Words) {
                   $Term =~ s/\+/\\+/g; 
                   if ($Title =~ /\b$Term\b/i) { 
                      $Title =~ s/\b($Term)\b/$Global{'Search_Prefix'}$1$Global{'Search_Suffix'}/gi; 
                      $Found++; 
				   }
					
					if ($Param{'Title_and_Description'}) {
							if ($Description =~ /\b$Term\b/i) { 
								$Found++; 
							}
                   }
		}

		foreach $Term(keys %Optional_Words) {
                   $Term =~ s/\+/\\+/g;
                   if ($Title =~ /\b$Term\b/i) { 
                      $Title =~ s/\b($Term)\b/$Global{'Search_Prefix'}$1$Global{'Search_Suffix'}/gi; 
                      $Found += $R_Score; 
				   }

					if ($Param{'Title_and_Description'}) {
						if($Description =~ /\b$Term\b/i) { 
							$Found += $R_Score;
						}
				   }
		}

		$LINE="$Title";
		if ($Param{'Title_and_Description'}) {
				$LINE.=" $Description";
		}
		foreach $Term(keys %Execlud_Words) {
				if ($LINE =~ /\b$Term\b/i) { 
                       $Found=0;
				}
		}
		
#		if ($Found >= $R_Score) {
		if ($Found >0) {

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
				$Item{'Resubmited'}	) = split(/\~\|\~/, $Item_Info[$Counter]{'Item_Extra'});

				if ($Param{'Search_Preferences'} eq "All"){
						$Item_Info[$Counter]{'Title'} = $Title;
						$Item_Info[$Counter]{'Description'} = $Description;
						$Match[$Matched++]=$Item_Info[$Counter];
				}
				elsif ($Param{'Search_Preferences'} eq $Item{'Country'}){
						$Item_Info[$Counter]{'Title'} = $Title;
						$Item_Info[$Counter]{'Description'} = $Description;
						$Match[$Matched++]=$Item_Info[$Counter];
				}
		}
		
		if ($Matched>=$Global{'Maximum_Search_Results'}) {last;}

	}
} #end of all categories

	undef @Item_Info;
	@Item_Info=@Match;
	$Items_Count= @Item_Info;
	#----------------------------------------------------------
	#----------------------------------------------------------
	#										 Category match
	#----------------------------------------------------------
	$Cat_Matched=0;

	for $Counter(0..$All_SubCategories_Count - 1) {
		$Cat = $Category_URL[$Counter];
		$Cats=$Category_URL[$Counter]." ";
		$Cat =~ s/\:/ /g;
		$Cat .=" ";

		$Found=0;

		foreach $Term(keys %Required_Words) {
					$Term =~ s/\+/\\+/g;
					if ($Cat =~ /\b$Term\b/i) { 
						$Cats =~ s/\b($Term)\b/$Global{'Search_Prefix'}$1$Global{'Search_Suffix'}/gi; 
						$Found++; 
				   }
		}

		foreach $Term(keys %Optional_Words) {
                   $Term =~ s/\+/\\+/g;
                   if($Cat =~ /\b$Term\b/i) { 
                      $Cats =~ s/\b($Term)\b/$Global{'Search_Prefix'}$1$Global{'Search_Suffix'}/gi; 
                      $Found += $R_Score; 
				   }
		}

		foreach $Term(keys %Execlud_Words) {
				if($Cat =~ /\b$Term\b/i) { 
                       $Found=0;
				}
		}

		if ($Found >= $R_Score) {
				$Cats=~ s/\s+$//;
				$Cat_Match[$Cat_Matched]=$Cats;
				$Cat_Match_URL[$Cat_Matched]=$Category_URL[$Counter];
				$Cat_Matched++;
		}

	}
	
	$Home=qq!<A HREF="$Global{'Auction_Script_URL'}?Lang=$Global{'Language'}">$Language{'auction_home_bar'}</A>!;
	
	$Plugins{'Match_Category_Count'}=$Cat_Matched;

	if ($Cat_Matched > 0) {
			$Out1="";
			for $x (0..$#Cat_Match) {
				$c=$Cat_Match[$x];
				$c=~ s/\:/$Global{'MenuLine_Separator'}/g;
				$c =$Language{'auction_home_bar'} . $Global{'MenuLine_Home'} . $c;
				$L=qq!<A HREF="$Script_URL?action=View_Cat&Cat_ID=$Category_ID{$Cat_Match_URL[$x]}&Lang=$Global{'Language'}">$c</A><BR>!;
				$Out1.= $L;
			}
		
		$Plugins{'Match_Categories'}="$Out1";
	}
	else{
		$Plugins{'Match_Categories'}="";
	}
	
	
}
#==========================================================
sub Perpare_Search_Keywords{ 
my ($Terms)= shift;

		#$Terms =~ s/\$/dollar_sign/g;
		#$Terms =~ s/\?/question_mark/g; 
		#$Terms =~ s/\(/left_paren/g;
		#$Terms =~ s/\)/right_paren/g;
		#$Terms =~ s/\[/left_bracket/g;

		$Terms =~ s/\$//g;
		$Terms =~ s/\?//g; 
		$Terms =~ s/\(//g;
		$Terms =~ s/\)//g;
		$Terms =~ s/\[//g;
		$Terms =~ s/\]//g;

		$Terms = lc($Terms);
		$Terms =~ s/^\s+//;
		$Terms =~ s/\s+$//;
		$Terms =~ s/\s+/ /g;
		$Terms =~ s/\'//;
		$Terms =~ s/\"//g;
        $Terms =~ s/ and / \+/ig;
        $Terms =~ s/ not / -/ig;        
		$Terms =~ s/ or / \|/ig;
		$Terms =~ s/ and not / -/ig;
		$Terms =~ s/\*+/\\S*\\W/g;

		@Terms = split(/\s+/, $Terms);
		return (@Terms);
}
#==========================================================
1;