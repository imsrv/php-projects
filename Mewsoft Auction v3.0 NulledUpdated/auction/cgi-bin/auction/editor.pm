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
sub Custom_Class_Body{
$Editor_Name=shift;
my $Class;
my $date;

$date=&Curent_Date_Time;
if ($Editor_Name eq "") {$Editor_Name="default"}
$Class=qq!
#------------------------------------------------------------------------------
#    File name : $Editor_Name.pm
#    Date      : $date
#    Version   : 1.0
#    Author    : Ahmed A. Elsheshtawy
#------------------------------------------------------------------------------
package Auction;\n
#------------------------------------------------------------------------------
sub $Editor_Name {
my \$Out;


     return \$Out;
}
#------------------------------------------------------------------------------
1;
#------------------------------------------------------------------------------
!;

	return $Class;
}
#================================================================
sub Read_File{
my $Filename=shift;
my @Lines;
my $Editor_TEXT;

	$Editor_TEXT="";
	
	if (-e $Filename) { 
		open(FILE,"$Filename") or die ("Error: Can't open file $Filename: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
			@Lines = <FILE>;
			$Editor_TEXT=join("", @Lines);
		close(FILE);
	}
	return $Editor_TEXT;
}
#==========================================================
sub Encode_HTML_Tags{
my $Temp =shift;

	$Temp =~ s/\"/\&quot\;/g;
	$Temp =~ s/\</\&lt\;/g;
	$Temp =~ s/\>/\&gt\;/g;
	return $Temp;

}
#==========================================================
sub Load_Editor_Files{
my ($Directory)=shift;
my (@dirlist, $x);
	
	undef @dirlist;
	opendir(Dir, "$Directory");
	foreach $File (  readdir(Dir)  ) {
			push (@dirlist, "$File");
    }

	closedir(Dir);

	@dirlist = sort @dirlist;

	$Editor_Count=0;

	for $x(0..$#dirlist) {
		$file=$dirlist[$x];
		if( -f "$Directory/$file" && $file ne "." && $file ne "..") { 
			$Editor_Files[$Editor_Count++]=$file;
		}
	}

	for $x(0..$Editor_Count -1) {
			 $Editor_Files_HTML[$x] = &Read_File("$Directory/$Editor_Files[$x]");
	}

	for $x(0..$Editor_Count -1) {
			 $Editor_Files_HTML[$x] = &Encode_HTML_Tags($Editor_Files_HTML[$x]);
	}

}
#================================================================
sub Editor_Filenames_Array{
my($Out);
 
	$Out="";
	for $x(0..$Editor_Count -1) {
			$y=$x+1;
			 $Out .= "custom_file[".$y."]=\'$Editor_Files[$x]\';\n";
	}

	return $Out;
}
#==========================================================
sub Create_New_Custom_Class{

	&Custom_Editor("x");
}
#==========================================================
sub Custom_Editor{ 
my ($New_File)=shift;

	&Load_Editor_Files($Global{'CustomDir'});

	if ($New_File eq "") {
		$Editor_TEXT=&Custom_Class_Body;											# Initial editor window template
		$Editor_TEXT=&Encode_HTML_Tags($Editor_TEXT);
		$Filename="default.pm";
	}
	else{
		$Editor_TEXT=&Custom_Class_Body("$Param{'New_File_Name'}");	# Initial editor window template
		$Editor_TEXT=&Encode_HTML_Tags($Editor_TEXT);
		$Filename="$Param{'New_File_Name'}.pm";

	}
	$Create_File_Action="Create_New_Custom_Class";
	$New_File_Name_Label="Create New Custom Script(.pm):";
	$Save_Action="Save_Class_File";
	&Editor($Filename, $Editor_TEXT, $Create_File_Action, $New_File_Name_Label, $Save_Action);

}
#==========================================================
sub Create_New_File{

	&Web_Editor("x");
}
#==========================================================
sub  Web_Editor{ 
my ($New_File)=shift;

	&Load_Editor_Files($Global{'TemplateDir'});

	if ($New_File eq "") {
		$Editor_TEXT=&New_HTML;											# Initial editor window template
		$Editor_TEXT=&Encode_HTML_Tags($Editor_TEXT);
		$Filename="default.html";
	}
	else{
		$Editor_TEXT=&New_HTML;
		$Editor_TEXT=&Encode_HTML_Tags($Editor_TEXT);
		$Filename="$Param{'New_File_Name'}.html";

	}
	$Create_File_Action="Create_New_File";
	$New_File_Name_Label="Create New Template (.html)";
	$Save_Action="Save_Template_File";
	&Editor($Filename, $Editor_TEXT, $Create_File_Action, $New_File_Name_Label, $Save_Action);

}
#==========================================================
sub Editor{
my ($Filename, $Editor_TEXT, $Create_File_Action, $New_File_Name_Label, $Save_Action)=@_;

	$Editor_Comments="";

	&Prepare_Custom_Editor;

	&Print_Headerx("Mewsoft Web Editor - www.mewsoft.com");

	$Editor_Template_Functions=&Custom_Template_Functions;

	print <<HTML;

	$Editor_Template_Functions

	<center>
	<p align="center">
	<form name="html_form" action="$Script_URL" method="post">
    <input type="hidden" name="password" value="$Global{'Admin_Password'}">
    <input type="hidden" name="action" value="$Save_Action">

	<table border=0 width=740 cellspacing=0 cellpadding=0>
	<tr>
	<td>
	  <table width="100%" border=0 bgcolor="#008080" cellspacing=0 cellpadding=0>
	    <tr><td align="center" valign="middle" bgcolor="#003300">
		  <font color="#99FFCC"  face="times,arial,helvetica" size=5>
		  <B>Mewsoft Web Editor</B>
		  </font>		  
		  </td></tr>

			<tr><td  align="center" valign="middle" bgcolor="#005329">

			$Editor_tags
			$Editor_fonts
			$Editor_symbols
	        $Editor_classes

			</td></tr>
			<tr><td  align="center" valign="middle" bgcolor="#aeffd7">
			</td></tr>
			<tr><td>

		<div align="center">
		<table border=0 width="100%"  cellspacing=0 cellpadding=0>
			<tr bgcolor="#AEFFD7">
			<td  width="10%"  align="center" valign="middle">
				<a href="$Script_URL">Home</a>
			</td>

			<td  width="10%"  align="center" valign="middle">
				<a href="#" onClick="window.open('$Script_URL?help=on&Lang=$Global{'Language'}','on_help','WIDTH=600,HEIGHT=500,scrollbars=yes,resizable=yes,left=100,top=10,screenX=150,screenY=100');return false">Help</a>
			</td>

			<td width="10%"  align="center" valign="middle">
				<input type=button value="Select All" onClick="javascript:this.form.Editor_Window.focus();this.form.Editor_Window.select();">
			</td>
			<td width="10%"  align="center" valign="middle">
				<input type=button value="Clear" onClick="javascript:Clear_Editor();">
			</td>
			<td width="20%"  align="center" valign="middle">

			$Editor_templates
			
			</td>
			<td width="20%"  align="center" valign="middle">
			
			$Editor_objects
			
			</td>
			<td width="20%" align="center" valign="middle">
				<a href="#" onClick="window.open('$Script_URL?action=Web_Editor','on_help','WIDTH=600,HEIGHT=500,scrollbars=yes,resizable=yes,left=100,top=10,screenX=150,screenY=100');return false">PopUp</a>
			</td>
		</tr>
</table>
<div>

</td></tr>
		<tr><td align="center" valign="top" bgcolor="#AEFFD7">
				<center>
				 <textarea name="Editor_Window" cols=85 rows=21>$Editor_TEXT</textarea>
				 <br>
		 </center>
	    </td></tr>

		<tr><td align="center" valign="top"  bgcolor="#AEFFD7">
		<center>
		<font color="#000000">File name:	</font><input type="text" name="filename" size="20" value=$Filename onFocus="select();">
		<input type="image" border="03" src="$Global{'HTML_URL'}/images/savefiler.gif" alt="Save File" >			 
		 </center>
 	    </td></tr>

	  </table>
	</td></tr>
	</table>
	</form>

    <B>Click on color to insert its value into the editor window</B><BR>
    <table border="0" cellspacing="0" bordercolorlight="#00FFFF" bordercolordark="#000080" cellPadding="0" bgcolor="#000000">
      <tr>

        $Editor_Color_Table

      </tr>
    </table>
  </center>

<div align="center">
<form method="POST" action="$Script_URL">
 <input type="hidden" name="action" value="$Create_File_Action"> 
  <table border="0"  >
    <tr>
      <td >
        <p align="right">$New_File_Name_Label </td>
      <td > 
		<input type="text" name="New_File_Name" size="25" onFocus="select();">
	  </td>
      <td >&nbsp;&nbsp; <input type="submit" value="Create" name="B1">&nbsp;
        <input type="reset" value="Reset" name="B2">
		</td>
    </tr>
  </table>
</form>
</DIV>


<br>
<div align="center">
  <center>
  <table border="0">
    <tr>
      <td valign="middle" align="center"><b><font face="Times New Roman" size="3">
	  Copyrights © 2001, <a href="https://www.safeweb.com/o/_i:http://www.mewsoft.com">Mewsoft</a>. All Rights Reserved.</font></b></td>
    </tr>
  </table>
  </center>
</div>

<BR>

HTML

&Print_Footerx;

}
#==========================================================
sub Custom_Template_Functions{
my $Out="";
my $Editor_Filenames_Array;

	$Editor_Filenames_Array = &Editor_Filenames_Array;

$Out=<<HTML;

    <SCRIPT LANGUAGE="javascript">

		function Clear_Editor() {
			document.html_form.filename.value='';
			document.html_form.Editor_Window.value='';
			document.html_form.Editor_Window.focus();
		}
		
		function Templates() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.templates.selectedIndex;
			var NewVal = document.html_form.templates[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = NewVal;

			   document.html_form.Editor_Window.value=Form_Text;

		    var custom_file= new Array(); 
			
			$Editor_Filenames_Array 

			document.html_form.filename.value=''+custom_file[Form_Index];
		   document.html_form.Editor_Window.focus();

			}
		}
	
		function Symbols() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.symbol.selectedIndex;
			var NewVal = document.html_form.symbol[Form_Index].text;
			if(Form_Index> 0) {
			   Form_Text = Form_Text + NewVal;
			   document.html_form.Editor_Window.value=Form_Text;
			   document.html_form.Editor_Window.focus();
			}
		}
		
	    function Font() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.font.selectedIndex;
			var NewVal = document.html_form.font[Form_Index].text;
			if(Form_Index > 0) {			
 			   Form_Text = Form_Text + "<FONT FACE='" + NewVal + "' SIZE='2' COLOR='#000000'>";
			   document.html_form.Editor_Window.value=Form_Text;
			   document.html_form.Editor_Window.focus();
			}			   
		}		

	    function Class() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.classes.selectedIndex;
			var NewVal = document.html_form.classes[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = Form_Text + NewVal;
			   document.html_form.Editor_Window.value=Form_Text;
			   document.html_form.Editor_Window.focus();
			}
		}

	    function Objects() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.objects.selectedIndex;
			var NewVal = document.html_form.objects[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = Form_Text + NewVal;
			   document.html_form.Editor_Window.value=Form_Text;
			   document.html_form.Editor_Window.focus();
			}
		}

		function Tag() {
		    var Form_Text=document.html_form.Editor_Window.value;
			var Form_Index = document.html_form.tag.selectedIndex;
			var NewVal = document.html_form.tag[Form_Index].value;
			if(Form_Index > 0) {
			   Form_Text = Form_Text + NewVal;
			   document.html_form.Editor_Window.value=Form_Text;
			   document.html_form.Editor_Window.focus();
			}
		}

	    function Color(New_Color) {
		    var Form_Text=document.html_form.Editor_Window.value;
			Form_Text = Form_Text + New_Color;
			document.html_form.Editor_Window.value=Form_Text;
			document.html_form.Editor_Window.focus();
		}
				
	</SCRIPT>
HTML
	
	return $Out;
}
#==========================================================
sub Prepare_Custom_Editor{

   &Custom_Templates_List;
   &Custom_Symbol_List;
   &Custom_Font_List;
   &Custom_Class_List;
   &Custom_Objects_List;
   &Custom_Tags;
   &Custom_Colors;
}
#==========================================================
sub New_HTML{
$New_HTML=<<NEWHTML;
&lt;HTML&gt;
&lt;HEAD&gt;
&lt;TITLE&gt;TITLE&lt;/TITLE&gt;
&lt;META name=&quot;keywords&quot; content=&quot; &quot;&gt;
&lt;META name=&quot;description&quot; content=&quot; &quot;&gt;
&lt;/HEAD&gt;
&lt;BODY BGCOLOR=&quot;WHITE&quot; BACKGROUND=&quot; &quot; TEXT=&quot;black&quot; LINK=&quot;BLUE&quot; VLINK=&quot;RED&quot; ALINK=&quot;yellow&quot; &gt;

&lt;/BODY&gt;
&lt;/HTML&gt;
NEWHTML

}
#==========================================================
sub Custom_Templates_List {
   
   &New_HTML;

	$Editor_templates= qq! <SELECT NAME="templates" onChange="Templates();">
				 <OPTION>Select File
				 !;

	for $x(0..$Editor_Count -1) {
		$file = $Editor_Files[$x];
		$file =~ s/(\.pm)//;
		 $Editor_templates.= qq!<OPTION VALUE="$Editor_Files_HTML[$x]">$file!;
	}

   $Editor_templates.= "</SELECT>";

}
#==========================================================
#==========================================================
sub Custom_Class_List {

   $Editor_classes=<<HTML;
    <SELECT NAME="classes" onChange="Class();">
      <OPTION>Classes
     <option value="&lt;!--CLASS::Home--&gt;">CLASS::Home
     <option value="&lt;!--CLASS::Sign_in--&gt;">CLASS::Sign_in
     <option value="&lt;!--CLASS::Submit_Item--&gt;">CLASS::Submit_Item
     <option value="&lt;!--CLASS::Alert_Me--&gt;">CLASS::Alert_Me
     <option value="&lt;!--CLASS::Edit_Profile--&gt;">CLASS::Edit_Profile
     <option value="&lt;!--CLASS::Category_Tree--&gt;">CLASS::Category_Tree
     <option value="&lt;!--CLASS::Help--&gt;">CLASS::Help
     <option value="&lt;!--CLASS::Language--&gt;">CLASS::Language
     <option value="&lt;!--CLASS::My_Auctions--&gt;">CLASS::My_Auctions
     <option value="&lt;!--CLASS::New_Auctions--&gt;">CLASS::New_Auctions
     <option value="&lt;!--CLASS::Hot_Auctions--&gt;">CLASS::Hot_Auctions
     <option value="&lt;!--CLASS::Cool_Auctions--&gt;">CLASS::Cool_Auctions
     <option value="&lt;!--CLASS::Ending_Now--&gt;">CLASS::Ending_Now
     <option value="&lt;!--CLASS::Contact_Us--&gt;">CLASS::Contact_Us
     <option value="&lt;!--CLASS::About_Us--&gt;">CLASS::About_Us
     <option value="&lt;!--CLASS::Announcements--&gt;">CLASS::Announcements
     <option value="&lt;!--CLASS::Log_off--&gt;">CLASS::Log_off
     <option value="&lt;!--CLASS::Feedback--&gt;">CLASS::Feedback
     <option value="&lt;!--CLASS::Image_URL--&gt;">CLASS::Image_URL
     <option value="&lt;!--CLASS::User_Agreement--&gt;">CLASS::User_Agreement
     <option value="&lt;!--CLASS::Privacy_Policy--&gt;">CLASS::Privacy_Policy
     <option value="&lt;!--CLASS::Site_Home--&gt;">CLASS::Site_Home
     <option value="&lt;!--CLASS::Form_Start--&gt;">CLASS::Form_Start
     <option value="&lt;!--CLASS::Form_End--&gt;">CLASS::Form_End
     <option value="&lt;!--CLASS::Search_Main:25--&gt;">CLASS::Search_Main:25
     <option value="&lt;!--CLASS::Search_Help_Link--&gt;">CLASS::Search_Help_Link
     <option value="&lt;!--CLASS::Search_Description--&gt;">CLASS::Search_Description
     <option value="&lt;!--CLASS::Welcome_User--&gt;">CLASS::Welcome_User
     <option value="&lt;!--CLASS::Date_Time:10--&gt;">CLASS::Date_Time:10
     <option value="&lt;!--CLASS::Search_Category:20--&gt;">CLASS::Search_Category:20
     <option value="&lt;!--CLASS::Header--&gt;">CLASS::Header
     <option value="&lt;!--CLASS::Top_Navigation--&gt;">CLASS::Top_Navigation
     <option value="&lt;!--CLASS::General--&gt;">CLASS::General
     <option value="&lt;!--CLASS::Categories_Count--&gt;">CLASS::Categories_Count
     <option value="&lt;!--CLASS::Total_Items_Count--&gt;">CLASS::Total_Items_Count
     <option value="&lt;!--CLASS::Featured_Home_Count--&gt;">CLASS::Featured_Home_Count
     <option value="&lt;!--CLASS::Benchmark--&gt;">CLASS::Benchmark
     <option value="&lt;!--CLASS::Body--&gt;">CLASS::Body
     <option value="&lt;!--CLASS::Featured_Home_Listing--&gt;">CLASS::Featured_Home_Listing
     <option value="&lt;!--CLASS::Bottom_Navigation--&gt;">CLASS::Bottom_Navigation
     <option value="&lt;!--CLASS::Footer--&gt;">CLASS::Footer
     <option value="&lt;!--CLASS::Image_URL--&gt;">CLASS::Image_URL
     <option value="&lt;!--CLASS::Search_Terms--&gt;">CLASS::Search_Terms
     <option value="&lt;!--CLASS::Previous_Page_Link--&gt;">CLASS::Previous_Page_Link
     <option value="&lt;!--CLASS::Next_Page_Link--&gt;">CLASS::Next_Page_Link
     <option value="&lt;!--CLASS::Menu_Bar--&gt;">CLASS::Menu_Bar
     <option value="&lt;!--CLASS::Category_Tree_Link--&gt;">CLASS::Category_Tree_Link
     <option value="&lt;!--CLASS::Bids_Listing--&gt;">CLASS::Bids_Listing
     <option value="&lt;!--CLASS::Extra--&gt;">CLASS::Extra
     <option value="&lt;!--CLASS::Featured_Category_Listing--&gt;">CLASS::Featured_Category_Listing
     <option value="&lt;!--CLASS::Previous_Page--&gt;">CLASS::Previous_Page
     <option value="&lt;!--CLASS::Next_Page--&gt;">CLASS::Next_Page
     <option value="&lt;!--CLASS::Photo_Link--&gt;">CLASS::Photo_Link
     <option value="&lt;!--CLASS::Title_Link--&gt;">CLASS::Title_Link
     <option value="&lt;!--CLASS::Quantity_Link--&gt;">CLASS::Quantity_Link
     <option value="&lt;!--CLASS::Current_Bid_Link--&gt;">CLASS::Current_Bid_Link
     <option value="&lt;!--CLASS::Bids_Link--&gt;">CLASS::Bids_Link
     <option value="&lt;!--CLASS::End_Time_Link--&gt;">CLASS::End_Time_Link
     <option value="&lt;!--CLASS::Page_Select_Menu--&gt;">CLASS::Page_Select_Menu
     <option value="&lt;!--CLASS::Page_Select_Menu1--&gt;">CLASS::Page_Select_Menu1
     <option value="&lt;!--CLASS::Featured_Category_Count--&gt;">CLASS::Featured_Category_Count
     <option value="&lt;!--CLASS::Cool_Items_Count--&gt;">CLASS::Cool_Items_Count
     <option value="&lt;!--CLASS::Ending_Items_Count--&gt;">CLASS::Ending_Items_Count
     <option value="&lt;!--CLASS::Hot_Items_Count--&gt;">CLASS::Hot_Items_Count
     <option value="&lt;!--CLASS::Categories--&gt;">CLASS::Categories
     <option value="&lt;!--CLASS::Items_Listing--&gt;">CLASS::Items_Listing
     <option value="&lt;!--CLASS::My_Auctions_Listing--&gt;">CLASS::My_Auctions_Listing
     <option value="&lt;!--CLASS::My_Auctions_Open_Count--&gt;">CLASS::My_Auctions_Open_Count
     <option value="&lt;!--CLASS::My_Auctions_Archived_Count--&gt;">CLASS::My_Auctions_Archived_Count
     <option value="&lt;!--CLASS::New_Items_Count--&gt;">CLASS::New_Items_Count
     <option value="&lt;!--CLASS::Match_Categories--&gt;">CLASS::Match_Categories
	</SELECT>
HTML

}
#==========================================================
#&lt;&gt;&amp;&quot;
#==========================================================
sub Custom_Objects_List {

   $Editor_objects=<<HTML;
    <SELECT NAME="objects" onChange="Objects();">
      <OPTION>Objects
      <OPTION VALUE="">---------Short List-------------
	  <OPTION VALUE="&lt;&lt;Title&gt;&gt;">&lt;&lt;Title&gt;&gt;
      <OPTION VALUE="&lt;&lt;Quantity&gt;&gt;">&lt;&lt;Quantity&gt;&gt;
	  <OPTION VALUE="&lt;&lt;Current_Bid&gt;&gt;">&lt;&lt;Current_Bid&gt;&gt;
      <OPTION VALUE="&lt;&lt;Bids&gt;&gt;">&lt;&lt;Bids&gt;&gt;
      <OPTION VALUE="&lt;&lt;Uploaded_Files&gt;&gt;">&lt;&lt;Uploaded_Files&gt;&gt;
      <OPTION VALUE="&lt;&lt;Duration &gt;&gt;">&lt;&lt;Duration&gt;&gt;
      <OPTION VALUE="&lt;&lt;Menu Bar &gt;&gt;">&lt;&lt;&gt;&gt;
      <OPTION VALUE="&lt;&lt;Photo &gt;&gt;">&lt;&lt;&gt;&gt;

    </SELECT>
HTML

}
#==========================================================
sub Custom_Font_List {

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

}
#==========================================================
sub Custom_Tags {
   $Editor_tags=<<HTML;
    <SELECT NAME="tag" onChange="Tag();">
     <OPTION>    HTML Tags
     <OPTION VALUE="&lt;H1&gt; &lt;/H1&gt;">H1
     <OPTION VALUE="&lt;H2&gt; &lt;/H2&gt;">H2
     <OPTION VALUE="&lt;H3&gt; &lt;/H3&gt;">H3
     <OPTION VALUE="&lt;H4&gt; &lt;/H4&gt;">H4
     <OPTION VALUE="&lt;H5&gt; &lt;/H5&gt;">H5
     <OPTION VALUE="&lt;H6&gt; &lt;/H6&gt;">H6
     <OPTION VALUE="&lt;B&gt; &lt;/B&gt;">Bold
     <OPTION VALUE="&lt;U&gt; &lt;/U&gt;">Underline
     <OPTION VALUE="&lt;I&gt; &lt;/I&gt;">Italics
     <OPTION VALUE="&lt;BLOCKQUOTE&gt;\n&lt;/BLOCKQUOTE&gt;">Blockquote
     <OPTION VALUE="&lt;IMG SRC='/path/to/image.gif'&gt;">Image
     <OPTION VALUE="&lt;CENTER&gt; &lt;/CENTER&gt;">Center
     <OPTION VALUE="&lt;P ALIGN='left'&gt; &lt;/P&gt;">Align Left
     <OPTION VALUE="&lt;P ALIGN='right'&gt; &lt;/P&gt;">Align Right
     <OPTION VALUE="&lt;table width= align= &gt;&lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;">Table

     <OPTION VALUE="&lt;ul&gt;
&lt;li&gt;First item
&lt;li&gt;Second item
&lt;li&gt;Third item
&lt;/ul&gt;">Bulleted List

<OPTION VALUE="&lt;ol&gt;
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
}
#==========================================================
sub Frames_Set1{
$Frames_Set1=<<HTML;
&lt;html&gt;
&lt;head&gt;
&lt;meta http-equiv="Content-Type" content="text/html; charset=windows-1252"&gt;
&lt;title&gt;New Page&lt;/title&gt;
&lt;meta name="GENERATOR" content="Mewsoft Editor"&gt;
&lt;/head&gt;
&lt;frameset framespacing="0" rows="20%,80%"&gt;
  &lt;frame name="banner" src="banner.html" scrolling="no" noresize target="contents" marginwidth="0" marginheight="0"&gt;
  &lt;frameset cols="20%,80%"&gt;
    &lt;frame name="contents" src="contents.html" target="main" marginwidth="0" marginheight="0" scrolling="auto"&gt;
    &lt;frame name="main" src="main.html" marginwidth="0" marginheight="0" scrolling="auto"&gt;
  &lt;/frameset&gt;
  &lt;noframes&gt;
  &lt;body topmargin="0" leftmargin="0"&gt;
  &lt;p&gt;This page uses frames, but your browser doesn't support them.&lt;/p&gt;
  &lt;/body&gt;
  &lt;/noframes&gt;
&lt;/frameset&gt;
&lt;/html&gt;
HTML

}
#==========================================================
sub Custom_Symbol_List {

   $Editor_symbols=<<HTML;
   <SELECT NAME="symbol" onChange="Symbols();">
     <OPTION>Symbol
     <OPTION>&quot;
     <OPTION>&amp;
     <OPTION>&lt;
     <OPTION>&gt;
	 
	 
     <OPTION>&euro;
     <OPTION>&fnof;
     <OPTION>&hellip;
     <OPTION>&dagger;
     <OPTION>&Dagger;
     <OPTION>&permil;
     <OPTION>&Scaron;
     <OPTION>&OElig;
     <OPTION>&bull;
     <OPTION>&mdash;
     <OPTION>&trade;
     <OPTION>&scaron;
     <OPTION>&rsaquo;
     <OPTION>&oelig;
     <OPTION>&Yuml;
	 
	 
     <OPTION>&nbsp;
     <OPTION>&iexcl;
     <OPTION>&cent;
     <OPTION>&pound;
     <OPTION>&curren;
     <OPTION>&yen;
     <OPTION>&brvbar;
     <OPTION>&sect;
     <OPTION>&copy;
     <OPTION>&laquo;
     <OPTION>&not;
     <OPTION>&reg;
     <OPTION>&deg;
     <OPTION>&plusmn;
     <OPTION>&sup2;
     <OPTION>&sup3;
     <OPTION>&acute;
     <OPTION>&micro;
     <OPTION>&para;
     <OPTION>&middot;
     <OPTION>&sup1;
     <OPTION>&raquo;
     <OPTION>&frac14;
     <OPTION>&frac12;
     <OPTION>&frac34;
     <OPTION>&iquest;
     <OPTION>&Agrave;
     <OPTION>&times;
     <OPTION>&Oslash;
     <OPTION>&szlig;
     <OPTION>&divide;
    </SELECT>
HTML
   
}
#==========================================================
sub Custom_Colors {
							  #AQUA    	 GRAY          NAVY           SILVER      BLACK        GREEN       
							 #OLIVE        TEAL     	  BLUE           LIME           PURPLE     WHITE         
							 #FUCHSIA 	 MAROON  RED  		 YELLOW

   @Colors=qw(    #000000       #003300     #006600     #009900      #00CC00      #00FF00
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

   $x=0;
   foreach $Color_Code(@Colors) {
      $x++;
      $Editor_Color_Table .= qq!<TD width="14" height="13" BGCOLOR="$Color_Code">  
										<A HREF="javascript:Color('$Color_Code');">
										<font color=$Color_Code>&nbsp;&nbsp;&nbsp;</a></TD>\n!;

      if($x == 36) { $Editor_Color_Table .= "</TR><TR>"; $x=0; }
   }

}
#==========================================================
sub Print_Headerx{
	my ($title)=shift;
	print "Content-type: text/html\n\n";
	print "<HTML>";
	print <<HTML;
<head><title>$title</title>
<style >
<!--
 A:hover {color: #ff3300 ;} 
-->
</style>
	
	</head>
<body  bgcolor="#008080" text="#AEFFD7" >
HTML

}
#==========================================================
sub Save_Class_File{
my $File;
my $Command;	
my $Out;
my $Text;
my $temp;

	#&Get_Form;
	$File="$Global{'CustomDir'}/$Param{'filename'}";
	$temp="$Global{'Temp_Dir'}/compile.txt";

	open (FILE, ">$File") 
				or &Exit("Error: Can't create file $File: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Text = $Param{'Editor_Window'};
    $Text =~ s/\cM//g;
    print FILE $Text;
	close (FILE);
	
	chmod (0777, $File);
	$Command="perl -c $File 2> $temp";
	system( $Command );

	$Out="<B><center>Compiling Status:</center></B><BR>";
	open(FILE,"$temp");
	while(<FILE>) { 
			$Out.=$_."<BR>";
	}
	close(FILE);
	#$Out=`$Command`;
	&Admin_Msg("Script File <B>$File</B> Successfully Saved", " $Out", 2, 600);
}
#==========================================================
sub Save_Template_File{ 
my $File;
	
	$File=$Param{'filename'}; #This is the current template file in the editor window

	open(FILE,">$Global{'TemplateDir'}/$File") 
				or die "Error: Can't create file $File: $!";
	$Text = $Param{'Editor_Window'};
    $Text =~ s/\cM//g;

    print FILE "$Text";
	close (FILE);
	
	$Out="File <B>$File</B> has been Successfully saved.";
	&Admin_Msg("Template Successfully Saved", "$Out", 2);
}
#==========================================================
sub Print_Footerx{
	print "</BODY>";
	print "</HTML>";
}
#==========================================================
#==========================================================
1;