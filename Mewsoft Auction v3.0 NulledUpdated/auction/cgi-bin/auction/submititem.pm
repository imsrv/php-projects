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
sub Submit_Item{
my ($msg, $Out,$Auth);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Submit_File'});

	$Auth=&Check_User_Authentication($Param{'User_ID'} , $Param{'Password'});

	if ($Auth == 0) {
		$msg="<b> $Language{'login_error'}</b> $Language{'login_error_msg'} ";
		$msg .="$Language{'missing_info_desc'}";
	}

	if ($msg) {
		$Out=&Msg($Language{'incorrect_information'}, $msg, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
		exit 0;
	}

	&Check_User_Login_Cookie;

	$Out=&Submit_Item_Form;
	&Display($Out, 1);
}
#==========================================================
sub Preferences{
my $Out="";
my %Preferences=();

	%Preferences=&Get_Language_File($Global{'Preferences_File'});

	$Out=qq!<SELECT NAME="Country" size="1">!;
	@Preferences=sort  keys %Preferences;

	$Value="";
	foreach $Key(@Preferences)  {
			$Value="";
			if ($Key eq "All") {$Value="selected"};
			$Out.=qq!<OPTION VALUE="$Key" $Value>$Preferences{$Key}</OPTION>!;
	}
	
	$Out .= "</SELECT>";
	return $Out;
}
#==========================================================
sub Enhancement_List{
my $Out="";
$Out=<<HTML;
	<select size="1" name="Enhancement">
        <option selected value=0>$Language{'none'}
        <option value=1>$Language{'featured_home_page'}
        <option value=2>$Language{'featured_category'}
      </select>
HTML
return $Out;
}
#==========================================================
sub Bit_Rating_List{
my $Out="";
$Out=<<HTML;
<SELECT name=BidRating size="1"> 
	<OPTION value=-5>$Language{'none'}
	<OPTION value=-1>-1
	<OPTION selected value=0>0
	<OPTION value=1>1
	<OPTION value=2>2
	<OPTION value=3>3
	<OPTION value=4>4
	<OPTION value=5>5
	<OPTION value=1000000>$Language{'all_bidders'}
</SELECT> 
HTML
return $Out;
}
#==========================================================
sub Duration_and_Cost{
my($Out, $temp)="";
my @Duration_Days;

		@Duration_Days=split(/\,/, $Global{'Duration_Days'});

		for $x(0..$#Duration_Days) {
			$temp.=qq!<OPTION value="$Duration_Days[$x]">$Duration_Days[$x] $Language{'day'}!;
			if ($Duration_Days[$x] > 1) { $temp.= $Language{'plural'}; }
		}

$Out = <<HTML;
		<SELECT name=Duration size="1">
		$temp
		</OPTION></SELECT>
HTML

	return $Out;
}
#==========================================================
sub Closing_Time_List{
my $Out="";

$Out=<<HTML;
<SELECT name=Closing_Time size="1">
		<OPTION value=0>$Language{'midnight'} - 1$Language{'AM'}
		<OPTION value=1>1$Language{'AM'} - 2$Language{'AM'}
		<OPTION value=2>2$Language{'AM'} - 3$Language{'AM'}
		<OPTION value=3>3$Language{'AM'} - 4$Language{'AM'}
		<OPTION value=4>4$Language{'AM'} - 5$Language{'AM'}
		<OPTION value=5>5$Language{'AM'} - 6$Language{'AM'}
		<OPTION value=6>6$Language{'AM'} - 7$Language{'AM'}
		<OPTION value=7>7$Language{'AM'} - 8$Language{'AM'}
		<OPTION value=8>8$Language{'AM'} - 9$Language{'AM'}
		<OPTION value=9>9$Language{'AM'} - 10$Language{'AM'}
		<OPTION value=10>10$Language{'AM'} - 11$Language{'AM'}
		<OPTION value=11>11$Language{'AM'} - $Language{'noon'} 
		<OPTION value=12>Noon - 1$Language{'PM'}
		<OPTION value=13>1$Language{'PM'} -  2$Language{'PM'}
		<OPTION selected value=14>2$Language{'PM'} - 3$Language{'PM'}
		<OPTION value=15>3$Language{'PM'} - 4$Language{'PM'}
		<OPTION value=16>4$Language{'PM'} - 5$Language{'PM'}
		<OPTION value=17>5$Language{'PM'} - 6$Language{'PM'}
		<OPTION value=18>6$Language{'PM'} - 7$Language{'PM'}
		<OPTION value=19>7$Language{'PM'} - 8$Language{'PM'}
		<OPTION value=20>8$Language{'PM'} - 9$Language{'PM'}
		<OPTION value=21>9$Language{'PM'} - 10$Language{'PM'}
		<OPTION value=22>10$Language{'PM'} - 11$Language{'PM'}
		<OPTION value=23>11$Language{'PM'} - $Language{'midnight'} 
		</SELECT> 
HTML
return $Out;
}
#==========================================================
sub Resumit_List{
my($Out, $x)="";

$Out=qq!	<SELECT name="Resubmit" size=1>
			<OPTION selected value=0>0 $Language{'times'}
			!;

	for ($x=1; $x<= $Global{'Resubmit_Number'} ; $x++) {
		$Out.=qq!<OPTION value=$x>$x $Language{'times'}!;
	}
		
	$Out.="</SELECT>";

	return $Out;
}
#==========================================================
sub Submit_Item_Form{
my ($Out, $List, $x);

	$Out=&Translate_File($Global{'Submit_Item_Template'});

	$List=qq!<FORM NAME="Submit_Auction" METHOD="POST" ACTION="$Script_URL">
					<input type="hidden" name="Lang" value="$Global{'Language'}">
					<input type="hidden" name="Cat_ID" value="$Param{'Cat_ID'}">
					<input type="hidden" name="User_ID" value="$Param{'User_ID'}">
					<input type="hidden" name="Password" value="$Param{'Password'}">
					<input type="hidden" name="action" value="Preview_Item">
					<input type="hidden" name="Clipboard" value="">
					!;

	$Out=~ s/<!--FORM_START-->/$List/;

	#$catname=$Category_Root{$Param{'Cat_ID'}};
	&Get_Menu_Bar;
	$List=$Plugins{'Menu_Bar'};
	$Plugins{'Menu_Bar'}="";
	$Out=~ s/<!--CATEGORY_MENU-->/$List/;

	$List=qq!<INPUT name="Title" value="" size=60 onFocus="select();">!;
	$Out=~ s/<!--ITEM_TITLE_BOX-->/$List/;

	$List=qq!<TEXTAREA cols=65 name="Description" rows=12 wrap=VIRTUAL><\/TEXTAREA>!;
	$Out=~ s/<!--ITEM_DECRIPTION_BOX-->/$List/;
	$List=&Preferences;
	$Out=~ s/<!--COUNTRY_REFINEMENT_BOX-->/$List/;

	$List=qq!<select size="1" name="Item_Language">!;
	@Languages=&Get_Languages;
	for $Lang(@Languages) {
			$selected="";
			if (lc($Lang) eq lc($Global{'Language'}) ) {$selected="selected"; }
			$List.=qq!<option value="$Lang" $selected> $Lang </option>!;
	}
	$List.="</select>";
	$Out=~ s/<!--LANGUAGE_REFINEMENT_BOX-->/$List/;
	
	$List=$Global{'Max_Title_Length'};
	$Out=~ s/<!--Max_Title_Length-->/$List/;
	
	$List=$Global{'Max_Decsription_Length'};
	$Out=~ s/<!--Max_Decsription_Length-->/$List/;
							  #AQUA    	 GRAY          NAVY           SILVER      BLACK        GREEN       
							 #OLIVE        TEAL     	  BLUE           LIME           PURPLE     WHITE         
							 #FUCHSIA 	 MAROON  RED  		 YELLOW

	$List=qq!<select size="1" name="Title_Enhancement">!;

	@Title_Enhancement = split('~#~', $Language{'title_enhancement_tags'});
	$x=0;
	foreach  $Title_Enhancement(@Title_Enhancement) {
				($Preffix, $Suffix, $Name)=split(/\|/, $Title_Enhancement);
				if ($x == 0) {
							$List.=qq!<OPTION selected value="$x">$Name</OPTION>!;
				}
				else{
							$List.=qq!<OPTION value="$x">$Name</OPTION>!;
				}
				$x++;
	}
	$List.=qq!</SELECT>!;
	$Out=~ s/(<!--TITLE_ENHANCEMENT_BOX-->)/$List/;

	$List=qq!<INPUT name="Featured_Homepage" type=checkbox value="yes">!;
	$Out=~ s/<!--FEATURED_HOMEPAGE-->/$List/;

	$List=qq!<INPUT name="Featured_Category" type=checkbox value="yes">!;
	$Out=~ s/<!--FEATURED_CATEGORY-->/$List/;

	@Icons=split(/\|/, $Language{'gift_icon_menu'});
	$List=qq!<select name ="Gift_Icon" size=1>!;
	$List.=qq!<option selected value="">$Language{'not_selected'}</option>!;

	foreach $Img(@Icons) {
		($Name, $Icon)=split(/\:/, $Img);
		$List.=qq!<option value="$Icon">$Name</option>!;
	}
	$List.="</select>";
	$Out=~ s/<!--GIFT_ICON-->/$List/;

	$List=qq!<INPUT name="ypChecks" type=checkbox value="yes">!;
	$Out=~ s/<!--ACCEPTS_PC-->/$List/;

	$List=qq!<INPUT name=yccMorders type=checkbox value="yes">!;
	$Out=~ s/<!--ACCEPTS_CCMO-->/$List/;

	$List=qq!<INPUT name="yCCards" type=checkbox value="yes">!;
	$Out=~ s/<!--ACCEPTS_CC-->/$List/;
	
	$List=qq!<INPUT name="escrow" type=checkbox value="yes">!;
	$Out=~ s/<!--ACCEPTS_ESCROW-->/$List/;
	
	$List=qq!<INPUT checked name="shipping" type=radio value="buyer">!;
	$Out=~ s/<!--BUYER_PAYS-->/$List/;
	
	$List=qq!<INPUT name="shipping" type=radio value="seller">!;
	$Out=~ s/<!--SELLER_PAYS-->/$List/;
	
	$List=qq!<INPUT checked  name="ship_time" type=radio value="Receipt_of_Payment">!;
	$Out=~ s/<!--SHIP_ON_RECEIPT-->/$List/;
	
	$List=qq!<INPUT name="ship_time" type=radio value="Auction_close">!;
	$Out=~ s/<!--SHIP_ON_CLOSE-->/$List/;
	
	$List=qq!<INPUT name="Ship_Internationally" type=checkbox value="yes">!;
	$Out=~ s/<!--SHIP_INTERNATIONAL-->/$List/;
	
	$List=qq!<INPUT  name="Quantity" size=13 onFocus="select();">!;
	$Out=~ s/<!--QUANTITY_BOX-->/$List/;
	
	$List=qq!<INPUT  name="Start_Bid" size=12 onFocus="select();">!;
	$Out=~ s/<!--BID_START_BOX-->/$List/;
	
	$List=qq!<INPUT name="Increment" size=12 onFocus="select();">!;
	$Out=~ s/<!--BID_INCREMENT_BOX-->/$List/;
	
	$Duration_Cost=&Duration_and_Cost;
	$Out=~ s/<!--DURATION_BOX-->/$Duration_Cost/;
	
	$List=qq!<textarea rows="3" name="Location" cols="12" onFocus="select();"></textarea>!;
	$Out=~ s/<!--LOCATION_BOX-->/$List/;
	
	$List=&Enhancement_List;
	$Out=~ s/<!--ENHANCEMENT_BOX-->/$List/;
	
	$List=qq!<INPUT name="Reserve" size=10  value="" onFocus="select();">!;
	$Out=~ s/<!--RESERVE_BOX-->/$List/;
	
	$List=qq!<INPUT  name="BuyPrice" size=10  value="" onFocus="select();">!;
	$Out=~ s/<!--BUY_BOX-->/$List/;

	$List=&Bit_Rating_List;
	$Out=~ s/<!--MIN_RATING_BOX-->/$List/;
	
	$List=&Closing_Time_List;
	$Out=~ s/<!--CLOSING_BOX-->/$List/;

	$List=&Resumit_List;
	$Out=~ s/<!--RESUBMIT_BOX-->/$List/;

	$List=qq!<INPUT  name="Homepage" size=30 value="http://" onFocus="select();">!;
	$Out=~ s/<!--HOMEPAGE_BOX-->/$List/;

	$Out=~ s/<!--CONTINUE_BUTTON-->/$Language{'submit_button'}/;
	$Out=~ s/<!--CLEAR_FORM_BUTTON-->/$Language{'clear_form_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$List = &Get_HTML_Tags_Menu;
	$Out=~ s/<!--Get_HTML_Tags_Menu-->/$List/;
	
	$List = &Get_Symbol_List_Menu;
	$Out=~ s/<!--Get_Symbol_List_Menu-->/$List/;

	$List = &Get_Font_List_Menu;
	$Out=~ s/<!--Get_Font_List_Menu-->/$List/;

	$List = &Get_Colors_List_Menu;
	$Out=~ s/<!--Colors_List_Menu-->/$List/;
	
	$Out=~ s/<!--SELECT_ALL_BOX-->/$Language{'select_all'}/;
	$Out=~ s/<!--CLEAR_ALL_BOX-->/$Language{'cut_all'}/;
	$Out=~ s/<!--PASTE_ALL_BOX-->/$Language{'past_all'}/;
	$Out=~ s/<!--COPY_ALL_BOX-->/$Language{'copy_all'}/;

	$Global{'Header'} =~ s/<\/HEAD>/$Language{'spell_checker_script_url'}\n<\/HEAD>/i;
	$Out=~ s/<!--SPELL_CHECKER_BUTTON-->/$Language{'spell_checker_button'}/;

	$List = &Get_Editor_Functions;
	$List .=qq!</FORM>!;
	$Out=~ s/<!--FORM_END-->/$List/;

	$Out =~ s/\&\#39\;/\'/g;

	return $Out;

}
#==========================================================
sub Get_HTML_Tags_Menu{
my($Editor_tags);

   $Editor_tags=<<HTML;
    <SELECT NAME="tag" onChange="Tag();">
     <OPTION>    HTML Tags
     <OPTION VALUE="\n&lt;H1&gt; &lt;/H1&gt;">H1
     <OPTION VALUE="\n&lt;H2&gt; &lt;/H2&gt;">H2
     <OPTION VALUE="\n&lt;H3&gt; &lt;/H3&gt;">H3
     <OPTION VALUE="\n&lt;H4&gt; &lt;/H4&gt;">H4
     <OPTION VALUE="\n&lt;H5&gt; &lt;/H5&gt;">H5
     <OPTION VALUE="\n&lt;H6&gt; &lt;/H6&gt;">H6
     <OPTION VALUE="\n&lt;B&gt; &lt;/B&gt;">Bold
     <OPTION VALUE="\n&lt;U&gt; &lt;/U&gt;">Underline
     <OPTION VALUE="\n&lt;I&gt; &lt;/I&gt;">Italics
     <OPTION VALUE="\n&lt;BLOCKQUOTE&gt;\n&lt;/BLOCKQUOTE&gt;">Blockquote
     <OPTION VALUE="\n&lt;IMG SRC='http://www.yourdomain.com/path/to/yourimage.gif' BORDER='0' ALT=''&gt;">Image Link
     <OPTION VALUE="\n&lt;CENTER&gt; &lt;/CENTER&gt;">Center
     <OPTION VALUE="\n&lt;P ALIGN='left'&gt; &lt;/P&gt;">Align Left
     <OPTION VALUE="\n&lt;P ALIGN='right'&gt; &lt;/P&gt;">Align Right
     <OPTION VALUE="\n&lt;table width= align= &gt;&lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;">Table

     <OPTION VALUE="\n&lt;ul&gt;
&lt;li&gt;First item
&lt;li&gt;Second item
&lt;li&gt;Third item
&lt;/ul&gt;">Bulleted List

<OPTION VALUE="\n&lt;ol&gt;
&lt;li&gt;First item
&lt;li&gt;Second item
&lt;li&gt;Third item
&lt;/ol&gt;">Numbered List
     <OPTION VALUE="&lt;br&gt;">Line Break
     <OPTION VALUE="&lt;p&gt;">Paragraph Break
     <OPTION VALUE="&lt;a href=&quot;$siteurl&quot;&gt;Linked site&lt;/a&gt;">Web site link
     <OPTION VALUE="&lt;a href=&quot;mailto:$master_admin_email_address&quot;&gt;Contact person&lt;/a&gt;">E-mail link
     <OPTION VALUE="&nbsp;">Nonbreaking Space
     <OPTION VALUE="&lt;HR COLOR=&quot; &quot; WIDTH=&quot; &quot;&gt;">HR
     <OPTION VALUE="&lt;!--  --&gt;">Comment
     <OPTION VALUE="&lt;SCRIPT LANGUAGE=&quot;JavaScript&quot;&gt;
&lt;!--

//--&gt;
&lt;/SCRIPT&gt;">JavaScript

     <OPTION VALUE="&lt;APPLET CODE=&quot;&quot; WIDTH=&quot;&quot; HEIGHT=&quot;&quot;&gt;

&lt;/APPLET&gt;">Applet

	 <OPTION VALUE="&lt;FORM NAME=&quot;&quot; METHOD=&quot;POST&quot; ACTION=&quot;&quot;&gt;

&lt;/FORM&gt;">Form

     <OPTION VALUE="&lt;INPUT TYPE=&quot;text&quot; NAME=&quot;&quot; VALUE=&quot;&quot;&gt;">Text Box
     <OPTION VALUE="&lt;SELECT SIZE=&quot;1&quot; NAME=&quot;&quot;&gt;
	&lt;option selected value=&quot;Item 1 Value&quot;&gt;Item 1&lt;/option&gt;
	&lt;option value=&quot;Item 2 Value&quot;&gt;Item 2&lt;/option&gt;
	&lt;option value=&quot;Item xx Value&quot;&gt;Item xx&lt;/option&gt;
&lt;/select&gt;">List Box

     <OPTION VALUE="&lt;INPUT TYPE=&quot;radio&quot; NAME=&quot;&quot; VALUE=&quot;&quot; CHECKED&gt;">Radio Button
     <OPTION VALUE="&lt;INPUT TYPE=&quot;checkbox&quot; NAME=&quot;&quot; VALUE=&quot;&quot; CHECKED&gt;">Check Box
     <OPTION VALUE="&lt;TEXTAREA NAME=&quot;&quot; ROWS=&quot;&quot; COLS=&quot;&quot; &gt; &lt;/TEXTAREA&gt;">Text Area
     <OPTION VALUE="&lt;INPUT TYPE=&quot;reset&quot; NAME=&quot;&quot; VALUE=&quot;&quot;&gt;">Reset Button
     <OPTION VALUE="&lt;INPUT TYPE=&quot;submit&quot; NAME=&quot;&quot; VALUE=&quot;&quot;&gt;">Submit Button
     <OPTION VALUE="&lt;INPUT TYPE=&quot;password&quot; NAME=&quot;&quot; VALUE=&quot;&quot;&gt;">Password Box
     <OPTION VALUE="&lt;INPUT TYPE=&quot;hidden&quot; NAME=&quot;&quot; VALUE=&quot;&quot;&gt;" >Hidden Field
     <OPTION VALUE="&lt;INPUT TYPE=&quot;image&quot; SRC=&quot;&quot; NAME=&quot;&quot; &gt;">Image Button

     <OPTION VALUE="&lt;MAP NAME=&quot;&quot;&gt;
	&lt;AREA SHAPE=&quot;&quot; HREF=&quot;&quot; COORDS=&quot;&quot; ALT=&quot;&quot;&gt;
&lt;/MAP&gt;">Image Map

	</SELECT>
HTML
	
		return $Editor_tags;
}
#==========================================================
sub Get_Symbol_List_Menu{
my($Editor_symbols);

   $Editor_symbols=<<HTML;
   <SELECT NAME="symbol" onChange="Symbols();">
     <OPTION>Symbol
     <OPTION  VALUE="&nbsp;">space
	 <OPTION  VALUE="&quot;">&quot;
     <OPTION  VALUE="&amp;">&amp;
     <OPTION  VALUE="&lt;">&lt;
     <OPTION  VALUE="&gt;">&gt;
	 	 
     <OPTION  VALUE="&iexcl;">&iexcl;
     <OPTION  VALUE="&cent;">&cent;
     <OPTION  VALUE="&pound;">&pound;
     <OPTION  VALUE="&curren;">&curren;
     <OPTION  VALUE="&yen;">&yen;
     <OPTION  VALUE="&brvbar;">&brvbar;
     <OPTION  VALUE="&sect;">&sect;
     <OPTION  VALUE="&copy;">&copy;
     <OPTION  VALUE="&laquo;">&laquo;
     <OPTION  VALUE="&not;">&not;
     <OPTION  VALUE="&reg;">&reg;
     <OPTION  VALUE="&deg;">&deg;
     <OPTION  VALUE="&plusmn;">&plusmn;
     <OPTION  VALUE="&sup2;">&sup2;
     <OPTION  VALUE="&sup3;">&sup3;
     <OPTION  VALUE="&acute;">&acute;
     <OPTION  VALUE="&micro;">&micro;
     <OPTION  VALUE="&para;">&para;
     <OPTION  VALUE="&middot;">&middot;
     <OPTION  VALUE="&sup1;">&sup1;
     <OPTION  VALUE="&raquo;">&raquo;
     <OPTION  VALUE="&frac14;">&frac14;
     <OPTION  VALUE="&frac12;">&frac12;
     <OPTION  VALUE="&frac34;">&frac34;
     <OPTION  VALUE="&iquest;">&iquest;
     <OPTION  VALUE="&Agrave;">&Agrave;
     <OPTION  VALUE="&times;">&times;
     <OPTION  VALUE="&Oslash;">&Oslash;
     <OPTION  VALUE="&szlig;">&szlig;
     <OPTION  VALUE="&divide;">&divide;

     <OPTION  value="&euro;">euro
     <OPTION  VALUE="&fnof;">fnof
     <OPTION  VALUE="&hellip;">hellip
     <OPTION  VALUE="&dagger;">dagger
     <OPTION  VALUE="&Dagger;">Dagger
     <OPTION  VALUE="&permil;">permil
     <OPTION  VALUE="&Scaron;">Scaron
     <OPTION  VALUE="&OElig;">OElig
     <OPTION  VALUE="&bull;">bull
     <OPTION  VALUE="&mdash;">mdash
     <OPTION  VALUE="&trade;">trade
     <OPTION  VALUE="&scaron;">scaron
     <OPTION  VALUE="&rsaquo;">rsaquo
     <OPTION  VALUE="&oelig;">oelig
     <OPTION  VALUE="&Yuml;">Yuml

    </SELECT>
HTML
	
	   return $Editor_symbols;

}
#==========================================================
sub Get_Font_List_Menu{
my($Editor_fonts);

   $Editor_fonts=<<HTML;
    <SELECT NAME="font" onChange="Font();">
     <OPTION >Font
     <OPTION >Arial,Helvetica
     <OPTION >Tahoma,Helvetica
     <OPTION >Verdana,Helvetica
     <OPTION >Impact,Helvetica
     <OPTION >Anglican,Helvetica
     <OPTION >Times Roman,Helvetica
     <OPTION >Comic Sans MS,Helvetica
     <OPTION >Courier,Helvetica
     <OPTION >MS Sans Serif,Helvetica
     <OPTION >Lucida Handwriting,Helvetica
     <OPTION >Abadi MT Condensed Light
     <OPTION >Algerian
     <OPTION >Allegro BT
     <OPTION >Almanac MT
     <OPTION >Arial
     <OPTION >Arial Black
     <OPTION >Arial Narrow
     <OPTION >Arial Rounded MT Bold
     <OPTION >AvantGarde Bk BT
     <OPTION >AvantGarde Md BT
     <OPTION >BankGothic Md BT
     <OPTION >Baskerville Old Face
     <OPTION >Bauhaus 93
     <OPTION >Beesknees ITC
     <OPTION >Bell MT
     <OPTION >Benguiat Bk BT
     <OPTION >Bernard MT Condensed
     <OPTION >BernhardFashion BT
     <OPTION >BernhardMod BT
     <OPTION >Blackadder ITC
     <OPTION >Book Antiqua
     <OPTION >Bookman Old Style
     <OPTION >Bookshelf Symbol 1
     <OPTION >Bookshelf Symbol 2
     <OPTION >Bookshelf Symbol 3
     <OPTION >Bradley Hand ITC
     <OPTION >Bremen Bd BT
     <OPTION >Britannic Bold
     <OPTION >Broadway
     <OPTION >Calisto MT
     <OPTION >Castellar
     <OPTION >Century Gothic
     <OPTION >Century Schoolbook
     <OPTION >Charlesworth
     <OPTION >Chiller
     <OPTION >Colonna MT
     <OPTION >Comic Sans MS
     <OPTION >CommonBullets
     <OPTION >Cooper Black
     <OPTION >Copperplate Gothic Bold
     <OPTION >Copperplate Gothic Light
     <OPTION >Courier
     <OPTION >Courier New
     <OPTION >Curlz MT
     <OPTION >Dauphin
     <OPTION >Edwardian Script ITC
     <OPTION >Elephant
     <OPTION >Engravers MT
     <OPTION >Eras Bold ITC
     <OPTION >Eras Demi ITC
     <OPTION >Eras Light ITC
     <OPTION >Eras Medium ITC
     <OPTION >Eras Ultra ITC
     <OPTION >Felix Titling
     <OPTION >Fixedsys
     <OPTION >Footlight MT Light
     <OPTION >Forte
     <OPTION >Franklin Gothic Demi
     <OPTION >Franklin Gothic Demi Cond
     <OPTION >Franklin Gothic Heavy
     <OPTION >Franklin Gothic Medium
     <OPTION >Franklin Gothic Medium Cond
     <OPTION >French Script MT
     <OPTION >Futura Lt BT
     <OPTION >Futura Md BT
     <OPTION >Futura XBlk BT
     <OPTION >FuturaBlack BT
     <OPTION >Garamond
     <OPTION >Georgia
     <OPTION >Gigi
     <OPTION >Gill Sans MT
     <OPTION >Gill Sans MT Condensed
     <OPTION >Gill Sans MT Ext Condensed Bold
     <OPTION >Gill Sans Ultra Bold
     <OPTION >Gill Sans Ultra Bold Condensed
     <OPTION >Gloucester MT Extra Condensed
     <OPTION >Goudy Old Style
     <OPTION >Goudy Stout
     <OPTION >GoudyHandtooled BT
     <OPTION >GoudyOlSt BT
     <OPTION >Haettenschweiler
     <OPTION >Harlow Solid Italic
     <OPTION >Harrington
     <OPTION >Holidays MT
     <OPTION >Humanst521 BT
     <OPTION >Impact
     <OPTION >Imprint MT Shadow
     <OPTION >Informal Roman
     <OPTION >Jokerman
     <OPTION >Juice ITC
     <OPTION >Kabel Bk BT
     <OPTION >Kabel Ult BT
     <OPTION >Kristen ITC
     <OPTION >Kunstler Script
     <OPTION >Lucida Calligraphy
     <OPTION >Lucida Console
     <OPTION >Lucida Handwriting
     <OPTION >Lucida Sans
     <OPTION >Lucida Sans Typewriter
     <OPTION >Lucida Sans Unicode
     <OPTION >Maiandra GD
     <OPTION >Map Symbols
     <OPTION >Marlett
     <OPTION >Matisse ITC
     <OPTION >Matura MT Script Capitals
     <OPTION >Modern No. 20
     <OPTION >Monotype Sorts
     <OPTION >Monotype Sorts 2
     <OPTION >MS Outlook
     <OPTION >MS Sans Serif
     <OPTION >MS Serif
     <OPTION >News Gothic MT
     <OPTION >OCR A Extended
     <OPTION >Onyx
     <OPTION >OzHandicraft BT
     <OPTION >Palace Script MT
     <OPTION >Papyrus
     <OPTION >Pepita MT
     <OPTION >Perpetua
     <OPTION >Perpetua Titling MT
     <OPTION >Playbill
     <OPTION >PosterBodoni BT
     <OPTION >Pristina
     <OPTION >Rage Italic
     <OPTION >Rockwell
     <OPTION >Rockwell Condensed
     <OPTION >Rockwell Extra Bold
     <OPTION >Script MT Bold
     <OPTION >Serifa BT
     <OPTION >Serifa Th BT
     <OPTION >Small Fonts
     <OPTION >Snap ITC
     <OPTION >Souvenir Lt BT
     <OPTION >Staccato222 BT
     <OPTION >Stencil
     <OPTION >Swiss911 XCm BT
     <OPTION >Symbol
     <OPTION >System
     <OPTION >Tahoma
     <OPTION >Tempus Sans ITC
     <OPTION >Terminal
     <OPTION >Times New Roman
     <OPTION >Trebuchet MS
     <OPTION >Tw Cen MT
     <OPTION >Tw Cen MT Condensed
     <OPTION >TypoUpright BT
     <OPTION >Vacation MT
     <OPTION >Verdana
     <OPTION >Viner Hand ITC
     <OPTION >Vivaldi
     <OPTION >Vladimir Script
     <OPTION >Webdings
     <OPTION >Westminster
     <OPTION >Wide Latin
     <OPTION >Wingdings
     <OPTION >Wingdings 2
     <OPTION >Wingdings 3
     <OPTION >ZapfEllipt BT
     <OPTION >Zurich BlkEx BT
     <OPTION >Zurich Ex BT
    </SELECT>
HTML
	
	return $Editor_fonts;
}
#==========================================================
sub Get_Editor_Functions{
my ($Out);
my $Editor_Filenames_Array;

#	$Editor_Filenames_Array = &Editor_Filenames_Array;

$Out=<<HTML;

    <SCRIPT LANGUAGE="javascript">

		function Clear_Editor() {
					document.Submit_Auction.filename.value='';
					document.Submit_Auction.Description.value='';
					document.Submit_Auction.Description.focus();
		}
		
		function Templates() {
					var Form_Text=document.Submit_Auction.Description.value;
					var Form_Index = document.Submit_Auction.templates.selectedIndex;
					var NewVal = document.Submit_Auction.templates[Form_Index].value;
					if(Form_Index > 0) {
						   Form_Text = NewVal;
						   document.Submit_Auction.Description.value=Form_Text;
							var custom_file= new Array(); 
							$Editor_Filenames_Array 
							document.Submit_Auction.filename.value=''+custom_file[Form_Index];
						   document.Submit_Auction.Description.focus();
					}
		}
	
		function Symbols() {
					var Form_Text=document.Submit_Auction.Description.value;
					var Form_Index = document.Submit_Auction.symbol.selectedIndex;
					var NewVal = document.Submit_Auction.symbol[Form_Index].value;
					if(Form_Index> 0) {
							   Form_Text = Form_Text + NewVal;
							   document.Submit_Auction.Description.value=Form_Text;
							   document.Submit_Auction.Description.focus();
					}
		}
		
	    function Font() {
					var Form_Text=document.Submit_Auction.Description.value;
					var Form_Index = document.Submit_Auction.font.selectedIndex;
					var NewVal = document.Submit_Auction.font[Form_Index].text;
					if(Form_Index > 0) {			
					   Form_Text = Form_Text + "<FONT FACE='" + NewVal + "' SIZE='2' COLOR='#000000'></FONT>";
					   document.Submit_Auction.Description.value=Form_Text;
					   document.Submit_Auction.Description.focus();
					}			   
		}		

	    function Class() {
		    var Form_Text=document.Submit_Auction.Description.value;
			var Form_Index = document.Submit_Auction.classes.selectedIndex;
			var NewVal = document.Submit_Auction.classes[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = Form_Text + NewVal;
			   document.Submit_Auction.Description.value=Form_Text;
			   document.Submit_Auction.Description.focus();
			}
		}

	    function Objects() {
		    var Form_Text=document.Submit_Auction.Description.value;
			var Form_Index = document.Submit_Auction.objects.selectedIndex;
			var NewVal = document.Submit_Auction.objects[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = Form_Text + NewVal;
			   document.Submit_Auction.Description.value=Form_Text;
			   document.Submit_Auction.Description.focus();
			}
		}

		function Tag() {
					var Form_Text=document.Submit_Auction.Description.value;
					var Form_Index = document.Submit_Auction.tag.selectedIndex;
					var NewVal = document.Submit_Auction.tag[Form_Index].value;
					if(Form_Index > 0) {
								   Form_Text = Form_Text + NewVal;
								   document.Submit_Auction.Description.value=Form_Text;
								   document.Submit_Auction.Description.focus();
					}
		}

	    function Colorx(New_Color) {
		    var Form_Text=document.Submit_Auction.Description.value;
			Form_Text = Form_Text + New_Color;
			document.Submit_Auction.Description.value=Form_Text;
			document.Submit_Auction.Description.focus();
		}

		function Color(){
					var Form_Text=document.Submit_Auction.Description.value;
					var Form_Index = document.Submit_Auction.color.selectedIndex;
					var NewVal = document.Submit_Auction.color[Form_Index].value;
					if (Form_Index>= 0) {
							   Form_Text = Form_Text + NewVal;
							   document.Submit_Auction.Description.value=Form_Text;
							   document.Submit_Auction.Description.focus();
					}
		}

				
	</SCRIPT>
HTML
	
	return $Out;
}
#==========================================================
sub Get_Colors_List_Menu{
my($Color_menu, @Colors, $Selected);
							  #AQUA    	 GRAY          NAVY           SILVER      BLACK        GREEN       
							 #OLIVE        TEAL     	  BLUE           LIME           PURPLE     WHITE         
							 #FUCHSIA 	 MAROON  RED  		 YELLOW

   @Colors=qw(  
							#000000       #003300     #006600     #009900      #00CC00      #00FF00
							  #000033      #003333      #006633     #009933      #00CC33      #00FF33 
							 #000066       #003366      #006666     #009966      #00CC66      #00FF66 
							 #000099       #003399      #006699     #009999      #00CC99      #00FF99 
							 #0000CC     #0033CC     #0066CC    #0099CC     #00CCCC    #00FFCC 
							 #0000FF      #0033FF      #0066FF     #0099FF      #00CCFF      #00FFFF 

							 #330000      #333300      #336600      #339900      #33CC00      #33FF00 
							 #330033      #333333      #336633      #339933      #33CC33      #33FF33 
							 #330066      #333366      #336666      #339966      #33CC66      #33FF66 
							 #330099      #333399      #336699      #339999      #33CC99      #33FF99 
							 #3300CC     #3333CC     #3366CC    #3399CC    #33CCCC      #33FFCC 
							 #3300FF      #3333FF      #3366FF     #3399FF      #33CCFF      #33FFFF 

							 #660000      #663300      #666600      #669900       #66CC00     #66FF00      
							#660033 		#663333      #666633       #669933      #66CC33      #66FF33      
							 #660066      #663366      #666666      #669966      #66CC66       #66FF66      
							 #660099      #663399      #666699      #669999       #66CC99      #66FF99     
							 #6600CC     #6633CC     #6666CC    #6699CC     #66CCCC     #66FFCC  
							 #6600FF      #6633FF      #6666FF     #6699FF      #66CCFF      #66FFFF  
							 
							 #990000      #993300      #996600       #999900       #99CC00      #99FF00     
							 #990033      #993333      #996633       #999933       #99CC33      #99FF33     
							 #990066      #993366      #996666       #999966       #99CC66      #99FF66     
							 #990099      #993399      #996699       #999999       #99CC99      #99FF99     
							 #9900CC    #9933CC     #9966CC     #9999CC      #99CCCC     #99FFCC  
							 #9900FF      #9933FF      #9966FF       #9999FF      #99CCFF      #99FFFF   

							 #CC0000      #CC3300      #CC6600     #CC9900      #CCCC00     #CCFF00  
							 #CC0033      #CC3333      #CC6633     #CC9933      #CCCC33     #CCFF33  
							 #CC0066      #CC3366      #CC6666      #CC9966     #CCCC66     #CCFF66  
							 #CC0099      #CC3399      #CC6699      #CC9999     #CCCC99     #CCFF99  
							 #CC00CC    #CC33CC     #CC66CC    #CC99CC    #CCCCCC    #CCFFCC
							 #CC00FF     #CC33FF      #CC66FF     #CC99FF     #CCCCFF     #CCFFFF 

							 #FF0000      #FF3300      #FF6600        #FF9900      #FFCC00      #FFFF00  
							 #FF0033      #FF3333      #FF6633        #FF9933      #FFCC33      #FFFF33  
							 #FF0066      #FF3366      #FF6666        #FF9966      #FFCC66      #FFFF66  
							 #FF0099      #FF3399      #FF6699        #FF9999      #FFCC99      #FFFF99  
							 #FF00CC    #FF33CC     #FF66CC     #FF99CC     #FFCCCC     #FFFFCC
							 #FF00FF     #FF33FF      #FF66FF       #FF99FF      #FFCCFF     #FFFFFF  
							 );

	$Color_menu = qq!<SELECT NAME="color" onChange="Color();">!;
	$Color_menu .= qq!<OPTION value="" SELECTED>Color</OPTION>!;

   foreach $Color_Code(@Colors) {
			$Selected="";
			#if ($Color_Code eq "#000000") {$Selected="SELECTED";}
			$Color_menu .= qq!<OPTION STYLE="background-color:$Color_Code; color:$Color_Code" value="$Color_Code" $Selected>$Color_Code</OPTION>!;
   }

   $Color_menu .= qq!</SELECT>!;

}
#==========================================================
1;