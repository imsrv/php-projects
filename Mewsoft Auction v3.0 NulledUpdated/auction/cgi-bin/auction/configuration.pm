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
sub  Initialize_Language_Paths{ 

	$Global{'Lang_Dir'}="$Global{'Language_Dir'}/$Global{'Language'}/";

	$Global{'Language_General_File'}="$Global{'Lang_Dir'}"."general.pm";
	$Global{'Language_Submit_File'}="$Global{'Lang_Dir'}"."submititem.pm";
	$Global{'Language_Registration_File'}="$Global{'Lang_Dir'}"."registration.pm";
	$Global{'Language_Preview_File'}="$Global{'Lang_Dir'}"."previewitem.pm";

	$Global{'Language_Edit_Profile_File'}="$Global{'Lang_Dir'}"."editprofile.pm";
	$Global{'Language_View_Item_File'}="$Global{'Lang_Dir'}"."viewitem.pm";
	$Global{'Language_Upload_File'}="$Global{'Lang_Dir'}"."uploadfile.pm";
	$Global{'Set_Language_File'}="$Global{'Lang_Dir'}"."setlanguage.pm";
	$Global{'Access_Lock_File'}="$Global{'Lang_Dir'}"."accesslock.pm";
	$Global{'Preferences_File'}="$Global{'Lang_Dir'}"."preferences.pm";
	$Global{'Language_Contact_Us_File'}="$Global{'Lang_Dir'}"."contact.pm";
	$Global{'Language_Categories_File'}="$Global{'Lang_Dir'}"."categories.pm";
	$Global{'Language_Login_File'}="$Global{'Lang_Dir'}"."login.pm";
	$Global{'Language_Alert_Me_File'}="$Global{'Lang_Dir'}"."alertme.pm";
	$Global{'Language_Email_Auction_File'}="$Global{'Lang_Dir'}"."emailauction.pm";
	$Global{'Language_Announcements_File'}="$Global{'Lang_Dir'}"."announcements.pm";
	$Global{'Language_Bidding_File'}="$Global{'Lang_Dir'}"."bidding.pm";
	$Global{'Language_Search_Tips_File'}="$Global{'Lang_Dir'}"."searchtips.pm";
	$Global{'Language_User_Agreement_File'}="$Global{'Lang_Dir'}"."useragreement.pm";
	$Global{'Language_Privacy_Policy_File'}="$Global{'Lang_Dir'}"."privacypolicy.pm";
	$Global{'Language_Custom_File'}="$Global{'Lang_Dir'}"."custom.pm";
	$Global{'Language_About_Us_File'}="$Global{'Lang_Dir'}"."aboutus.pm";
	$Global{'Language_Help_File'}="$Global{'Lang_Dir'}"."help.pm";
	$Global{'Language_Help_Pages_File'}="$Global{'Lang_Dir'}"."helppages.pm";
	$Global{'Language_Special_List_File'}="$Global{'Lang_Dir'}"."speciallist.pm";
	$Global{'Language_Feedback_File'}="$Global{'Lang_Dir'}"."feedback.pm";
	$Global{'Account_Manager_File'}="$Global{'Lang_Dir'}"."accountmgr.pm";

}
#==========================================================
#==========================================================
sub Get_General_Classes{
#----------------------------------------------------------
$Global{'Listing_Table_Row'}=<<HTMLaxx;
<TR bgcolor="#FFFFFF">
<TD ALIGN="CENTER" VALIGN="MIDDLE">
  <!--!Uploaded_Files-->
  <!--THUMBNAIL-->
  </TD>
 <TD><!--Title--><!--GIFT--><!--NEW--><!--HOT--><!--COOL--><!--BUY--><!--FEATURED--></TD>
  <TD ALIGN="RIGHT"><!--Quantity--></TD>
    <TD ALIGN="RIGHT" VALIGN="MIDDLE">
      <!--Current_Bid--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE">
	   <!--Bids--></TD>
    <TD ALIGN="RIGHT" VALIGN="MIDDLE">
   <!--Duration--></TD>
  </TR>
HTMLaxx
#----------------------------------------------------------
$Global{'Listing_Table_Row1'}=<<HTMLbxx;
<TR bgcolor="#ececec">
   <TD ALIGN="CENTER" VALIGN="MIDDLE">
  <!--!Uploaded_Files-->
  <!--THUMBNAIL-->
  </TD>
 <TD><!--Title--><!--GIFT--><!--NEW--><!--HOT--><!--COOL--><!--BUY--><!--FEATURED--></TD>
<TD  ALIGN="RIGHT"> 
  <!--Quantity--></TD>
   <TD ALIGN="RIGHT" VALIGN="MIDDLE">
      <!--Current_Bid--></TD>
      <TD ALIGN="CENTER" VALIGN="MIDDLE">
   <!--Bids--></TD>
 <TD ALIGN="RIGHT" VALIGN="MIDDLE">
<!--Duration--></TD>
</TR>
HTMLbxx
#----------------------------------------------------------
$Global{'Bid_History_Table_Row'}=<<HTMLht;
<TR bgcolor="#FFFFFF">
 <TD><!--USER_ID--> <!--HIGHEST_BIDDER--></TD>
  <TD ALIGN="LEFT"><!--COMMENTS--></TD>
    <TD ALIGN="CENTER" VALIGN="MIDDLE">
      <!--BID_AMOUNT--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE">
	   <!--BID_QUANTITY--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE">
	   <!--WIN_QUANTITY--></TD>
       <TD ALIGN="LEFT" VALIGN="MIDDLE">
     <!--BID_TIME--></TD>
  </TR>
HTMLht
#----------------------------------------------------------
$Global{'Bid_History_Table_Row1'}=<<HTMLhtb;
<TR bgcolor="#ececec">
 <TD><!--USER_ID--> <!--HIGHEST_BIDDER--></TD>
  <TD ALIGN="LEFT"><!--COMMENTS--></TD>
    <TD ALIGN="CENTER" VALIGN="MIDDLE">
      <!--BID_AMOUNT--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE">
	   <!--BID_QUANTITY--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE">
	   <!--WIN_QUANTITY--></TD>
       <TD ALIGN="LEFT" VALIGN="MIDDLE">
     <!--BID_TIME--></TD>
  </TR>
HTMLhtb
#----------------------------------------------------------
#----------------------------------------------------------
$Global{'Listing_Featured_Home_Table_Row'}=<<HTMLfb;
<TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="03">
  <TR>
    <TD BGCOLOR="#FFFFFF">
			  <!--!Uploaded_Files-->
			  <!--THUMBNAIL-->
	</TD>
    <TD BGCOLOR="#FFFFFF">
			<!--Title--><BR>
			<<featured_current_Bid>>: <!--Current_Bid--><BR>
			<<featured_bids>>: <!--Bids--><BR>
			<<featured_end_time>>: <!--Duration--><BR>
	</TD>
  </TR>
</TABLE>
HTMLfb
#----------------------------------------------------------
$Global{'Listing_Featured_Home_Table_Row1'}=<<HTMLf1b;
<TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="03">
  <TR>
    <TD BGCOLOR="#ECECEC">
			  <!--!Uploaded_Files-->
			  <!--THUMBNAIL-->
	</TD>
    <TD BGCOLOR="#ECECEC">
			<FONT SIZE="2" FACE="ARIAL, TAHOMA, TIMES">
			<!--Title--><BR>
			<<featured_current_Bid>>: <!--Current_Bid--><BR>
			<<featured_bids>>: <!--Bids--><BR>
			<<featured_end_time>>: <!--Duration--><BR>
			</FONT>
	</TD>
  </TR>
</TABLE>
HTMLf1b
#----------------------------------------------------------
$Global{'Listing_Featured_Category_Table_Row'}=<<HTMLa;
<TR>
 <TD ALIGN="CENTER" VALIGN="MIDDLE">
  <!--!Uploaded_Files-->
  <!--THUMBNAIL-->
 </TD>
 <TD><!--Title--><!--GIFT--><!--NEW--><!--HOT--><!--COOL--></TD>
  <TD ALIGN="RIGHT"><!--Quantity--></TD>
    <TD ALIGN="RIGHT" VALIGN="MIDDLE">
      <!--Current_Bid--></TD>
       <TD ALIGN="CENTER" VALIGN="MIDDLE"><!--Bids--></TD>
    <TD ALIGN="RIGHT" VALIGN="MIDDLE">
   <!--Duration--></TD>
  </TR>
HTMLa
#----------------------------------------------------------
$Global{'Listing_Featured_Category_Table_Row1'}=<<HTMLb;
<TR bgcolor="#ececec">
 <TD ALIGN="CENTER" VALIGN="MIDDLE">
  <!--!Uploaded_Files-->
  <!--THUMBNAIL-->
 </TD>
<TD>
 <!--Title--><!--GIFT--><!--NEW--><!--HOT--><!--COOL-->
 </TD><TD  ALIGN="RIGHT"> 
  <!--Quantity--></TD>
   <TD ALIGN="RIGHT" VALIGN="MIDDLE">
      <!--Current_Bid--></TD>
      <TD ALIGN="CENTER" VALIGN="MIDDLE">
   <!--Bids--></TD>
 <TD ALIGN="RIGHT" VALIGN="MIDDLE">
<!--Duration--></TD></TR>
HTMLb
#----------------------------------------------------------
$Global{'Set_Language_Form'}=<<HTMLss;
<TR><TD WIDTH="30%" ALIGN="RIGHT" BGCOLOR="#FFFFFF">
	<INPUT TYPE="RADIO" value="<<Language>>" NAME="Language_Selected" <<CHECKED>> >
	</TD><TD WIDTH="70%" ALIGN="LEFT" BGCOLOR="#FFFFFF"><<Language_Name>></TD>
</TR>
HTMLss
#----------------------------------------------------------
$Global{'Header'}=<<HTMLy;
<HTML>
<HEAD>
<TITLE> Mewsoft Auction - Mewsoft.com </TITLE>
<META NAME="Generator" CONTENT="Mewsoft Editor">
<META NAME="Author" CONTENT="Ahmed A. Elsheshtawy">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<STYLE>
<!--
A:hover {color: #ff3300 ;} 
//-->
</STYLE>
<STYLE TYPE="text/css">
<!--
.lwr  a:link    { color: white; }
.lwr  a:visited { color: white; }
.lwr  a:active  { color: #80FF80; }
.lwr  a:hover   { color: red; background-color : yellow;}
.lwr  a{ text-decoration: underline }

.lbr  a:link    { color: blue; }
.lbr  a:visited { color: blue; }
.lbr  a:active  { color: #FF33FF; }
.lbr  a:hover   { color: red; background-color : yellow;}
.lbr  a{ text-decoration: underline }

.lbx  a:link    { color: blue; }
.lbx  a:visited { color: blue; }
.lbx  a:active  { color: #FF33FF; }
.lbx  a:hover   { color: red; }
.lbx  a{ text-decoration: underline }
-->
</STYLE>

</HEAD>
<BODY BGCOLOR="#FFFFFF">
<!--<BODY BGCOLOR="#FFFFFF" background="<!--CLASS::Image_URL-->/bb.gif">-->
HTMLy
#----------------------------------------------------------
$Global{'Footer'}=<<HTMLx;
<TABLE BORDER=0 WIDTH="100%" ALIGN=CENTER VALIGN=MIDDLE CELLSPACING="0" CELLPADDING="2">
<TR><TD WIDTH=75% ALIGN="CENTER">
<<copyright>><BR>
<<site_use>><!--CLASS::User_Agreement--> <<and>> <!--CLASS::Privacy_Policy--><BR>
</TD></TR>
</TABLE>

</BODY>
</HTML>
HTMLx
#----------------------------------------------------------
$Global{'Message_Form'}=<<HTML;
<DIV ALIGN="CENTER">
  <CENTER>
  <TABLE BORDER="0" WIDTH="605" BGCOLOR="#E7E7CF" CELLSPACING="0" CELLPADDING="5">
    <TR>
      <TD WIDTH="100%" ALIGN="CENTER"><B><FONT COLOR="#FF0000" FACE="TIMES NEW ROMAN, ARIAL">
	
	    <!--MESSAGE_TITLE-->
	
        </FONT></B></TD>
    </TR>
    <TR>
      <TD WIDTH="600">
        <DIV ALIGN="CENTER">
          <TABLE BORDER="0" WIDTH="600" CELLSPACING="0" CELLPADDING="10" BGCOLOR="#FFFFFF">
            <TR>
              <TD VALIGN="middle" ALIGN="left" WIDTH="100%">
				
				        <!--MESSAGE_BODY-->
				
              </TD>
            </TR>
            <TR>
              <TD VALIGN="middle" ALIGN="center" WIDTH="100%">
                <FORM>
                  <P ALIGN="CENTER">
				  <!--OK_BUTTON-->
                  </P>
                </TD>
              </TR>
            </TABLE>
          </DIV>
        </TD>
      </TR>
    </TABLE>
  </CENTER>
  </DIV>
HTML
#----------------------------------------------------------
$Global{'Error_Form'}=<<HTML;
<HTML>
<HEAD>
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
.lwr  a{ text-decoration: underline }

.lbr  a:link    { color: blue; }
.lbr  a:visited { color: blue; }
.lbr  a:active  { color: #ff3300; }
.lbr  a:hover   { color: red; background-color : #FFFF00;}
.lbr  a{ text-decoration: underline }
-->
</STYLE>
</HEAD>
<BODY BGCOLOR="#E1E1C4" >

<div class="lbr" align="center">
  <center>

<TABLE BORDER="0" WIDTH="405" BGCOLOR="#005329" >
  <TR>
    <TD WIDTH="100%" ALIGN="CENTER" HEIGHT="19"><B>
	<FONT COLOR="#FFFF00" FACE="TIMES NEW ROMAN, ARIAL">
	
	<!--ERROR_MESSAGE_TITLE-->
	
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
				
				<!--ERROR_MESSAGE_BODY-->
				
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

				<!--OK_BUTTON-->

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

</BODY>
</HTML>
HTML
#----------------------------------------------------------
$Global{'Top_Navigation'}=<<HTMLc;
<DIV ALIGN="center">
  <CENTER>
  <TABLE BORDER="0" WIDTH="610" CELLSPACING="04" CELLPADDING="0">
    <TR>
      <TD WIDTH="142" ROWSPAN="2" ALIGN="left" NOWRAP> 
		<A HREF="https://www.safeweb.com/o/_i:http://www.bidsea.com">
		<IMG SRC="<!--CLASS::Image_URL-->/bidsea_logo.gif" BORDER="0" ALT="Mewsoft Auction Software"></A>
	  </TD>
      <TD WIDTH="475" ALIGN="right">

			<DIV ALIGN="CENTER">
			<TABLE BORDER=0 WIDTH="100%" ALIGN=CENTER VALIGN=MIDDLE CELLSPACING="0" CELLPADDING="2">
			<TR ><TD WIDTH="100%" BGCOLOR="#FFFFFF" ALIGN="CENTER">
			<!--CLASS::Site_Home--> |
			<!--CLASS::Home--> |
			<!--CLASS::Sign_in--> |
			<!--CLASS::Submit_Item--> |
			<!--CLASS::Feedback--> |
			<!--CLASS::Category_Tree--> |
			<!--CLASS::Help--> |
			<!--CLASS::Language-->
			</TD></TR>
			<TR ><TD WIDTH="100%" ALIGN="CENTER">
			<!1--CLASS::My_Auctions--> 
			<!--CLASS::Account_Manager--> |
			<!--CLASS::New_Auctions--> |
			<!--CLASS::Hot_Auctions--> |
			<!--CLASS::Cool_Auctions--> |
			<!--CLASS::Ending_Now--> |
			<!--CLASS::Big_Ticket--> |
			<!--CLASS::Featured-->
			</TD></TR>
			<TR ><TD WIDTH="100%" ALIGN="CENTER" height="2" bgcolor="#FFFFFF">
			</TD></TR>
			</TABLE>

	  </TD>
    </TR>

    <TR>
      <TD WIDTH="475" ALIGN="right">
			</DIV>
			<DIV ALIGN=CENTER>
				<TABLE CELLSPACING="0" CELLPADDING="0">
					<TR><TD><FONT SIZE="7" COLOR="#FF0099">
					<a href="https://www.safeweb.com/o/_i:http://www.mewsoft.com"><IMG SRC="<!--CLASS::Image_URL-->/auction_logo.gif" BORDER=01 ALT="Mewsoft Auction"></a>
					</FONT></TD></TR>
				</TABLE>
			</DIV>
	  
	  </TD>
    </TR>
  </TABLE>
  </CENTER>
</DIV>
HTMLc
#----------------------------------------------------------
$Global{'Bottom_Navigation'}=<<HTMLd;
<DIV ALIGN="center">
  <CENTER>
  <TABLE BORDER="0" WIDTH="610" CELLSPACING="04" CELLPADDING="0">
    <TR><TD WIDTH="100%" ALIGN="center">
			<DIV ALIGN="CENTER">
			<TABLE BORDER=0 WIDTH="100%" ALIGN=CENTER VALIGN=MIDDLE CELLSPACING="0" CELLPADDING="2">
			<TR ><TD WIDTH="100%" BGCOLOR="#FFFFFF" ALIGN="CENTER">
				<!--CLASS::Site_Home--> |
				<!--CLASS::Home--> |
				<!--CLASS::Announcements--> |
				<!--CLASS::Sign_in--> |
				<!--CLASS::Submit_Item--> |
				<!--CLASS::Help--> |
				<!--CLASS::Contact_Us--> |
				<!--CLASS::About_Us--> |
				<!--CLASS::Log_off-->
			</TD></TR>
			<TR ><TD WIDTH="100%" ALIGN="CENTER" height="2" bgcolor="#FFFFFF">
			</TD></TR>
			</TABLE>

	  </TD>
    </TR>

    <TR>
      <TD WIDTH="100%" ALIGN="center">
			<DIV ALIGN=CENTER>
				<TABLE CELLSPACING="0" CELLPADDING="0">
					<TR><TD><FONT SIZE="7" COLOR="#FF0099">
					<A HREF="https://www.safeweb.com/o/_i:http://www.mewsoft.com"><IMG SRC="<!--CLASS::Image_URL-->/classified_logo.gif" BORDER=01 ALT="Mewsoft Auction"></a>
					</FONT></TD></TR>
				</TABLE>
			</DIV>
	  </TD>
    </TR>
  </TABLE>
  </CENTER>
</DIV>
HTMLd
#----------------------------------------------------------
$Global{'Side_Navigation'}=<<HTMLe;
<DIV CLASS="lwr" ALIGN="CENTER">
<TABLE BORDER=0 WIDTH="100%" ALIGN=CENTER VALIGN=MIDDLE CELLSPACING="1" CELLPADDING="4">
<TR><TD WIDTH="75%" BGCOLOR=#0091D7 ALIGN="CENTER">
<B>
<!--CLASS::Home--> &nbsp;
<!--CLASS::Sign_in--> &nbsp;
<!--CLASS::Edit_Profile-->&nbsp;
<!--CLASS::Submit_Item--> &nbsp;
<!--CLASS::Category_Tree--> &nbsp;
<!--CLASS::Contact_Us--> &nbsp;
<!--CLASS::Announcements--> &nbsp;
<!--CLASS::Language--> &nbsp;
<!--CLASS::Log_off-->&nbsp;&nbsp;    
</B>
</TD></TR>
</TABLE>
</DIV>
HTMLe
#----------------------------------------------------------
$Global{'Announcements_Form'}=<<HTMLw;
<DIV ALIGN="CENTER"> <CENTER>
<TABLE BORDER="0" WIDTH="100%" BGCOLOR="#FFFFFF" CELLSPACING="01" CELLPADDING="5">
  <TR><TD WIDTH="100%" BGCOLOR="#ECECD9" ALIGN="CENTER" COLSPAN="2">
      <B><FONT COLOR="#0000CC" SIZE="4">
      <!--ANNOUNCEMENT_TITLE-->
      </FONT></B></TD>
  </TR>

  <TR>
  <TD WIDTH="150" BGCOLOR="#EEEEEE" NOWARP>
		<B><<announcements_date_label>></B>
	</TD>
	<TD>
	      <!--ANNOUNCEMENT::Date_Time:10-->
    </TD>
  </TR>

  <TR>
    <TD WIDTH="150" BGCOLOR="#EEEEEE" NOWARP>
		<B><<announcements_url_label>></B>
	</TD>
	<TD>
	      <!--ANNOUNCEMENT_URL-->
    </TD>
  </TR>

  <TR>
    <TD WIDTH="150" BGCOLOR="#EEEEEE" NOWARP>
		<B><<announcements_message_label>></B>
	</TD>
	<TD WIDTH="80%">
              <!--ANNOUNCEMENT_MESSAGE-->
    </TD>
  </TR>
</TABLE>
</CENTER>
</DIV>
HTMLw
#----------------------------------------------------------
$Global{'General'}=<<HTMLg;
<DIV ALIGN="center">
  <CENTER>
	<TABLE BORDER="0" WIDTH="620" CELLSPACING="0" CELLPADDING="3" BORDERCOLOR="#A5CE80">
	<TR>
	  <TD WIDTH="100%">

		  <TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="3" BORDERCOLOR="#A5CE80">
            <TR>
              <TD WIDTH="100%">
			<TABLE BORDER="0">
			  <TR>
			    <TD ALIGN="right"><FONT COLOR="black" FACE="Times, Arial, Tahoma" SIZE="3"><<main_search_label>></FONT></TD>
			    <TD>
			      <P ALIGN="left">
				      <!--CLASS::Search_Main:26-->
			      </P>
			    </TD>
			  </TR>
			</TABLE>
	   </TD>
	</TR>

</TABLE>

	<TABLE WIDTH="100%">
	<TR BGCOLOR="#FFFFE8"><TD ALIGN="LEFT">
			<P ALIGN="LEFT">
			<FONT  COLOR="RED" FACE="TAHOMA,TIMES, ARIAL" SIZE="3"><B><I>
				<<welcome_user>>&nbsp; 
			</I></B></FONT>
			<FONT  COLOR="GREEN" FACE="TAHOMA,TIMES, ARIAL" SIZE="3"><B><I>
				<!--CLASS::Welcome_User-->
			</I></B></FONT>
			</TD>
		<TD ALIGN="LEFT"><P ALIGN="RIGHT"><!--CLASS::Date_Time:10-->	</P>
		 </TD>
	 </TR>
	</TABLE>

	 </TD>
	</TR>
	</TABLE>
 </CENTER>
</DIV>
HTMLg
#----------------------------------------------------------
$Global{'Extra'}=<<Extra;
<DIV ALIGN="center">
  <CENTER>
	<TABLE BORDER="0" WIDTH="640" CELLSPACING="0" CELLPADDING="3" BORDERCOLOR="#A5CE80">
	<TR>
	  <TD WIDTH="100%">
		<TABLE BORDER = "0" WIDTH="100%" CELLSPACING="0" CELLPADDING="2">
		  <TR ALIGN="LEFT" ><TD ALIGN="LEFT"  NOWRAP>
				<TABLE BORDER ="0" CELLSPACING="0" CELLPADDING="2" ><TR><TD  ALIGN="RIGHT" VALIGN="TOP" NOWRAP>
					<FONT COLOR="BLACK" FACE="Arial, Tahoma" SIZE="3"><<main_search_label>></FONT></TD>
					<TD ALIGN="LEFT"  NOWRAP><!--CLASS::Search_Category:20--></TD>
					<TD ALIGN="LEFT" NOWRAP VALIGN="TOP">	<!--CLASS::Search_Help_Link--></TD>
					</TR>
				</TABLE>
			</TD>
		</TR>
		</TABLE>

		<TABLE WIDTH="100%" BGCOLOR="#FFFFEE" BORDER="0" BORDERCOLOR="#FFEEEE" CELLSPACING="0" CELLPADDING="2"><TR ><TD ALIGN="left" NOWRAP><FONT  COLOR="RED" FACE="Tahoma,Times, Arial" size="3">
			<B><I><<welcome_user>>&nbsp; </I></B></FONT>
			<FONT  COLOR="GREEN" FACE="Tahoma,Times, Arial" SIZE="3"><I><B><!--CLASS::Welcome_User--></B></I></FONT>
		</TD ALIGN="RIGHT"><TD ALIGN="right" width="100%" NOWRAP><!--CLASS::Date_Time:10--></TD>
		</TR>
		</TABLE>

	 </TD>
	</TR>
	</TABLE>
 </CENTER>
</DIV>

Extra
}
#----------------------------------------------------------
$Global{'Search_Main_Form'}=<<HTMLp; 
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR><FORM METHOD="POST" NAME="Search_Main" ACTION="<!--Program_URL-->">
	<!--Search_Hidden_Fields-->
	<TD><!--Search_Box-->&nbsp;&nbsp;</TD>
	<TD><!--Submit_Button--></TD></TR>
	<TR><TD COLSPAN="2"><!--Search_Preferences--> <!--CLASS::Search_Help_Link--></TD></TR>
	<TR><TD  COLSPAN="2"><FONT  COLOR="BLACK" face="Times, Arial, Tahoma" SIZE="3">
		<!--CLASS::Search_Description--> <<search_description_button>></FONT>
	</TD>
	</FORM>
  </TR>
</TABLE>
HTMLp
#----------------------------------------------------------
$Global{'Search_Category_Form'} = <<HTMLp; 
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
  <TR>
  <FORM METHOD="POST" NAME="Search_Category" ACTION="<!--Program_URL-->">
	<!--Search_Hidden_Fields-->
	<TD><!--Search_Box--></TD>
	<TD><!--Search_Options--><!--Search_Preferences--></TD>
	<TD><!--Submit_Button--></TD>
	</TR>
	<TR><TD COLSPAN="3"><FONT  COLOR="BLACK" face="Times, Arial, Tahoma" SIZE="3">
		<!--CLASS::Search_Description--><<search_description_button>></FONT>
	</TD>
	</FORM>
  </TR>
</TABLE>
	
HTMLp
#----------------------------------------------------------
$Global{'Categories_Table'} = <<HTMLs;
<DIV ALIGN="center">
  <CENTER>
  <TABLE BORDER="0" WIDTH="100%" CELLPADDING="0" CELLSPACING="03">
    <TR ALIGN="LEFT">
	  <!--Categories-->
    </TR>
  </TABLE>
  </CENTER>
</DIV>
HTMLs

$Global{'Category_Form'}=<<HTMLp;
<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="03" WIDTH="100%">
<TR><TD ROWSPAN="2" VALIGN="TOP" ><!--Category_Folder--></TD>
<TD align="LEFT" WIDTH="100%">
	<A HREF="<!--Category_URL-->"><B><FONT SIZE="3" FACE="Arial, Tahoma,Verdana, Times, Helvetica"><!--Category_Name--></FONT></B></A> <!--Category_Count-->
<BR><!--Category_Teasers-->
</TD></TR>
<TR><TD VALIGN="TOP"  ALIGN="LEFT" HIEGHT="15"></TD></TR>

</TABLE>
HTMLp

$Global{'Under_Category_Form'}=qq|<FONT SIZE="-2" FACE="Arial, Tahoma,Verdana, Times, Helvetica" ><!--Under_Categories--> <!--Category_Count--></FONT>|;
#----------------------------------------------------------
$Global{'Feedback_Rating_Form'}=<<HTMLl;
<TR>
 <TD WIDTH="100%" >
	<TABLE BORDER="0" WIDTH="100%" CELLSPACING="1" CELLPADDING="3">
	  <TR>
		<TD WIDTH="80%" BGCOLOR="#DFEED2"><<comment_user>> <!--COMMENT_USER-->&nbsp;<<comment_date>> <!--CLASS::Comment_Time:10--></TD>
		<TD WIDTH="20%" ALIGN="left" NOWRAP BGCOLOR="#DFEED2"><!--ITEM_ID--></TD>
	  </TR>
	  <TR>
		<TD WIDTH="100%" COLSPAN="2"><!--COMMENT_TYPE--><!--USER_COMMENT--></TD>
	  </TR>
	</TABLE>
</TD>
</TR>
HTMLl
#----------------------------------------------------------
$Global{'Account_Activity_Table_Row'}=<<HTMLy;
	<TR BGCOLOR="#F1F1E4">
      <TD WIDTH="7%" ALIGN="left" NOWRAP><!--COUNTER--></TD>
      <TD WIDTH="25%" ALIGN="left" NOWRAP><!--DATE:08--></TD>
      <TD WIDTH="15%" ALIGN="left" ><!--TRANSACTION--></TD>
      <TD WIDTH="15%" ALIGN="center" NOWRAP><!--ITEM--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--CREDIT--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--DEBIT--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--BALANCE--></TD>
    </TR>
HTMLy
$Global{'Account_Activity_Table_Row1'}=<<HTMLf;
	<TR BGCOLOR="#FFFFFF">
      <TD WIDTH="7%" ALIGN="left" NOWRAP><!--COUNTER--></TD>
      <TD WIDTH="25%" ALIGN="left" NOWRAP><!--DATE:08--></TD>
      <TD WIDTH="15%" ALIGN="left" ><!--TRANSACTION--></TD>
      <TD WIDTH="15%" ALIGN="center" NOWRAP><!--ITEM--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--CREDIT--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--DEBIT--></TD>
      <TD WIDTH="10%" ALIGN="right" NOWRAP><!--BALANCE--></TD>
    </TR>
HTMLf
#==========================================================
#==========================================================
sub Read_Configuration{
my ($key, $value, %data);

#----------------------------------------------------------	
if ($ENV{'HTTP_HOST'}=~ /localhost/i) {
		$Global{'BaseDir'} = 'C:/Program Files/Apache Group/Apache/cgi-bin/auction';
		$Global{'HtmlDir'} = 'C:/Program Files/Apache Group/Apache/htdocs/auction';
		$Global{'CGI_URL'} = 'http://localhost/cgi-bin/auction';
		$Global{'HTML_URL'} = 'http://localhost/auction';
}
else{
		$Global{'BaseDir'} = $Program_CGI_Directory;
		$Global{'CGI_URL'} = $Program_CGI_Directory_URL;
		$Global{'HtmlDir'} = $Program_HTML_Directory;
		$Global{'HTML_URL'} = $Program_HTML_Directory_URL;
}
#----------------------------------------------------------	
$Global{'Regular_Font_Color'}="#000000";
$Global{'Regular_Font_Size'}=2;
$Global{'Regular_Font_Face'}="Times, Arial";
$Global{'Category_Tree_Root_Font_Size'}="4";
$Global{'Category_Tree_Root_Font_Face'}="Tahome,Time,Arial"; 
$Global{'Category_Tree_Root_Font_Color'}="red";
$Global{'Category_Tree_Sub_Font_Size'}="2";
$Global{'Category_Tree_Sub_Font_Face'}="Tahome,Time,Arial"; 

$Global{'Language'}="English";
$Global{'Access_Lock'}=0;

$Global{'Email_Status'} = 01; # 0 = disable all emails

$Global{'Cron_Minute'} = "0";
$Global{'Cron_Hour'} ="*";
$Global{'Cron_Day'} ="*";
$Global{'Cron_Month'} ="*";
$Global{'Cron_Weekday'} ="*";

$Global{'Home_Page_Under_Separator'} = ", ";
$Global{'Under_Separator'}=", ";
$Global{'GMT_Offset'}=0;
$Global{'MenuLine_Separator'}=" > ";
$Global{'MenuLine_Home'}=" >> ";
$Global{'Category_Browse_Columns'}=4;
$Global{'Homepage_Category_Columns'} = 1;
$Global{'Category_Columns'}=3;
$Global{'Category_HSpace'}=20;
$Global{'Category_VSpace'}=10;
$Global{'Category_Border'}=0;
$Global{'Category_Unders_Mode'} =1;
$Global{'More_Categories'} = ",...";

$Global{'Admin_Help_Window_Width'} = 620;
$Global{'Admin_Help_Window_Height'} = 450;
$Global{'Total_Users_Count'} = 0;

$Global{'Category_Count'}="YES";
$Global{'Under_Category_Count'} = "NO";
$Global{'Category_Folder'}="YES";
$Global{'Category_Folder_Image'}="folder.gif";
$Global{'Unique_Homepage_Category_Folder'} = "NO";
$Global{'Homepage_Category_Folder_Image'}="folder.gif";

$Global{'Admin_UserID'}="admin";
$Global{'Admin_Password'}="admin";
$Global{'MainProg_Name'}="auction.cgi";
$Global{'AdminProg_Name'}="admin.cgi";
#----------------------------------------------------------
$Global{'Items_Per_Page'}=20;
$Global{'Featured_Home_Items_Per_Page'}=7;
$Global{'Featured_Items_Per_Page'}=5;
#----------------------------------------------------------
$Global{'Maximum_Search_Results'}=1000;
$Global{'Comments_Per_Page'} = 25;
$Global{'Transactions_Per_Page'} = 25;
#----------------------------------------------------------
$Global{'Currency_Symbol'}="\$";
$Global{'Require_Credit_Card'} = "NO";
$Global{'Resubmit_Number'}=50;
$Global{'Thumbnail_Width'} = 64;
$Global{'Thumbnail_Height'} = 64;
$Global{'Home_Page_Thumbnail_Width'} = 120;
$Global{'Home_Page_Thumbnail_Height'} = 90;
$Global{'Category_Thumbnail_Width'} = 75;
$Global{'Category_Thumbnail_Height'} = 75;
$Global{'Admin_Users_Per_Page'} = 10;
#----------------------------------------------------------
$Global{'Regular_Fees_From'}="0.01:10.00:25.00:0:0:0:0:0:0:0";
$Global{'Regular_Fees_To'}="9.99:24.99:1000000000:0:0:0:0:0:0:0";
$Global{'Regular_Fees_Fee'}="0.25:0.5:2.0:0:0:0:0:0:0:0";

$Global{'Reserve_Fees_From'}="0.01:25:0:0:0:0:0:0:0:0";
$Global{'Reserve_Fees_To'}="24.99:1000000000:0:0:0:0:0:0:0:0";
$Global{'Reserve_Fees_Fee'}="0.5:1.00:0:0:0:0:0:0:0:0";

$Global{'Final_Fees_From'}="0:25.01:1000.01:0:0:0:0:0:0:0";
$Global{'Final_Fees_To'}="25:1000:1000000000:0:0:0:0:0:0:0";
$Global{'Final_Fees_Fee'}="5:2.5:1.25:0:0:0:0:0:0:0";

$Global{'Billing_Fields_Order'}="1:2:3:0:4:5:6:7:8:9:10:11:12:13:14:15:16:17:18:19:20:21:22:23:24:25:26:27:28:29:30:31:32";

$Global{'Billing_Custom_Filed_1'} = "AUTH_CAPTURE";
$Global{'Billing_Custom_Filed_2'} = "CC";
$Global{'Billing_Custom_Filed_3'} = "";
$Global{'Billing_Custom_Filed_4'} = "";
$Global{'Billing_Custom_Filed_5'} = "";

$Global{'Billing_Delimiting'}="\,";
$Global{'Billing_Encapsulation'}="&quot;";

$Global{'Charge_For_Registration'}="NO";
$Global{'Registration_Charge'} = 1.00;
$Global{'Charge_For_Submitting'}="NO";
$Global{'Submit_Charge'}=1.00;
$Global{'Skip_Zero_Balance_Accounts'}="YES";

$Global{'Web_Server_Connection'} = "Socket";
#----------------------------------------------------------
$Global{'Merchant_Account_Provider'}="Authorize_Net";
$Global{'Authorize_Net_Login'}="";
$Global{'Authorize_Net_Password'}="";
$Global{'Authorize_Net_Method'}="";
$Global{'Authorize_Net_Type'}="";

$Global{'QuickCommerce_Login'}="";
$Global{'QuickCommerce_Password'}="";
$Global{'PlanetPayment_Login'}="";
$Global{'PlanetPayment_Password'}="";
$Global{'Plugnpay_Login'}="";
$Global{'Plugnpay_Password'}="";
$Global{'iBill_Login'}="";
$Global{'iBill_Password'}="";
#----------------------------------------------------------
$Global{'Title_Enhancement_Fee'}=2.00;
$Global{'Category_Featured_Fee'}=14.95;
$Global{'Home_Page_Featured_Fee'}=99.95;
$Global{'Gift_Icon_Fee'}=1.0;
$Global{'Upload_One_File_Fee'}=1.75;
$Global{'Upload_Two_File_Fee'}=3.0;
$Global{'Upload_Three_File_Fee'}=4.0;
$Global{'Upload_Four_File_Fee'}=5.0;
$Global{'Upload_Five_File_Fee'}=1.15;
$Global{'Dutch_Max_Regular_Fees'}=5;
#----------------------------------------------------------
$Global{'New_Item_Houres'}=24;
$Global{'Cool_Item_Bids'}=5;
$Global{'Hot_Item_Bids'}=10;
$Global{'Ending_Items_Time_Minutes'}=5*60;
$Global{'Big_Ticket_Items_Price'} = 180;
$Global{'New_Icon'}="new.gif";
$Global{'Hot_Icon'}="hot.gif";
$Global{'Cool_Icon'}="cool.gif";
$Global{'High_Bidder_Icon'}="highbidder.gif";
$Global{'Featured_Icon'}="featured.gif";
#----------------------------------------------------------
$Global{'Backup_Command'}="tar cvf ";
$Global{'Compress_Command'}="gzip ";
$Global{'Server_Backup_Dir'}="/usr/local/plesk/apache/vhosts/mewsoft.com/httpdocs/auction/backup/server_backup.tar";
$Global{'Backup_Directories'}="/usr/local/plesk/apache/vhosts/mewsoft.com/cgi-bin/auction/*";
#----------------------------------------------------------
$Global{'Webmaster_Email'}="webmaster\@yourdomain.com";
$Global{'Auction_Email'}="auction\@yourdomain.com";
$Global{'Contact_Us_Email'}="contact\@yourdomain.com";
#----------------------------------------------------------
#$Global{'Languages'}="English";
$Global{'Languages'}="";
#----------------------------------------------------------
$Global{'Site_Name'}="Site_Name";
$Global{'SSL_Status'}="NO";
$Global{'SSL_URL'}="https://www.yourdomain.com/cgi-bin/auction/auction.cgi";
#----------------------------------------------------------
$Global{'Allow_File_Upload'} = "YES";
$Global{'Upload_Any_File'}  = "NO";
$Global{'Max_Upload_Files'} = 6;
$Global{'Max_Upload_File_Size'}=200; #in KB
$Global{'Max_Upload_Size'}=600;
$Global{'Files_Ext_Allowed'} = "gif jpg pcx bmp jif jpeg pic pbm ppm tif tiff";
#----------------------------------------------------------
$Global{'Max_Title_Length'}=80;
$Global{'Max_Decsription_Length'}=2000;
$Global{'Max_Title_Length_List'}=80;
$Global{'Treat_HTML'} = "Show_Safe_Code";
#----------------------------------------------------------
$Global{'Max_Comments_Length'}= 80;
#----------------------------------------------------------
$Global{'Search_Prefix'}=qq!<FONT COLOR="RED">!;
$Global{'Search_Suffix'}=qq!</FONT>!;
#----------------------------------------------------------
$Global{'Duration_Days'}=qq!1,3,5,7,10,14,20, 25, 30!;
$Global{'Duration_Days_Before'}="0:0";
#----------------------------------------------------------
$Global{'Time_left_To_Change_Color'}=24*60;
$Global{'Time_left_To_Change_Color_Preffix'}=qq!<FONT COLOR="#FF00FF">!;
$Global{'Time_left_To_Change_Color_Suffix'}=qq!</FONT>!;

$Global{'Time_left_To_Change_Color1'}=60;
$Global{'Time_left_To_Change_Color_Preffix1'}=qq!<b><blink><FONT COLOR="RED">!;
$Global{'Time_left_To_Change_Color_Suffix1'}=qq!</FONT></blink></b>!;
#----------------------------------------------------------
$Global{'Time_Format'} = 9;
#----------------------------------------------------------
@Bad_Words =qw (horny bitch bastard tits nymphomaniac fuck penis vagina asshole pussy shit pussies cunt cock nigger);
#----------------------------------------------------------
$Global{'Email_Format'} = 1;
$Global{'Email_X_Priority'} = 1;
$Global{'Mail_Program_Type'} = 0;
$Global{'Mail_Program_Or_SMTP_Server'}="/usr/lib/sendmail";
#----------------------------------------------------------
&Get_General_Classes;
#----------------------------------------------------------
$Global{'DataDir'}="$Global{'BaseDir'}/data";
$Global{'Configuration_File'}="$Global{'DataDir'}/config.dat";
#==========================================================
&DB_Exist($Global{'Configuration_File'});
tie %datax, "DB_File", $Global{'Configuration_File'}, O_RDONLY
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

%data=%datax;
untie %datax;
undef %datax;

while (($key, $value)=each(%data)) {
				$Global{$key}=$value;
}
undef %data;
#==========================================================
$Global{'ItemsDir'}="$Global{'DataDir'}/items/";
$Global{'ItemsPathDir'}="$Global{'DataDir'}/items";
$Global{'CustomDir'}="$Global{'DataDir'}/custom";
$Global{'Mail_Lists_Dir'}="$Global{'DataDir'}/maillists";
$Global{'Database_Dir'}="$Global{'DataDir'}/database";
$Global{'ItemsBackupDir'}="$Global{'Database_Dir'}/items";
$Global{'Mail_Lists_Backup_Dir'}="$Global{'Database_Dir'}/maillists";
$Global{'Temp_Dir'}="$Global{'DataDir'}/temp";
$Global{'TemplateDir'}="$Global{'DataDir'}/templates";
$Global{'ImagesDir'}="$Global{'HTML_URL'}/images";
$Global{'Archive_Dir'}="$Global{'DataDir'}/archive";
$Global{'Archive_Backup_Dir'}="$Global{'Database_Dir'}/archive";
$Global{'Upload_Dir'}="$Global{'HtmlDir'}/upload";
$Global{'Secure_Dir'}="$Global{'DataDir'}/secure";
$Global{'Export_Dir'}="$Global{'DataDir'}/export";
$Global{'Base_Upload_Dir'} = "$Global{'HtmlDir'}/upload";
$Global{'Base_Upload_URL'} = "$Global{'HTML_URL'}/upload";
$Global{'Language_Dir'}="$Global{'DataDir'}/language";
$Global{'Lock_Dir'}="$Global{'DataDir'}/lock";
#----------------------------------------------------------
$Global{'Default_Template'}="$Global{'TemplateDir'}/default.html";
$Global{'FrontPage_Template'}="$Global{'TemplateDir'}/frontpage.html";
$Global{'Category_Template'}="$Global{'TemplateDir'}/category.html";
$Global{'Listing_Template'} ="$Global{'TemplateDir'}/listingpage.html";
$Global{'SearchTemplate'}="$Global{'TemplateDir'}/searchlist.html";
$Global{'SearchBodyTemplate'}="$Global{'TemplateDir'}/searchlistbody.html";
$Global{'Submit_Item_Template'}="$Global{'TemplateDir'}/submititem.html";
$Global{'ViewItemTemplate'}="$Global{'TemplateDir'}/viewitem.html";
$Global{'Registration_Template'}="$Global{'TemplateDir'}/registration.html";
$Global{'Login_Template'}="$Global{'TemplateDir'}/login.html";
$Global{'Edit_Profile_Template'}="$Global{'TemplateDir'}/editprofile.html";
$Global{'Set_Language_Template'}="$Global{'TemplateDir'}/setlanguage.html";
$Global{'Countdown_Ticker_Template'}="$Global{'TemplateDir'}/ticker.html";
$Global{'Upload_File_Template'}="$Global{'TemplateDir'}/uploadfile.html";
$Global{'Contact_Us_Template'}="$Global{'TemplateDir'}/contact.html";
$Global{'ForgotLoginTemplate'}="$Global{'TemplateDir'}/forgotlogin.html";
$Global{'AlertMe_Template'}="$Global{'TemplateDir'}/alertme.html";
$Global{'AlertMe_Category_Template'}="$Global{'TemplateDir'}/alertmecategory.html";
$Global{'AlertMe_Seller_Template'}="$Global{'TemplateDir'}/alertmeseller.html";
$Global{'AlertMe_Keyword_Template'}="$Global{'TemplateDir'}/alertmekeywords.html";
$Global{'Edit_AlertMe_Template'}="$Global{'TemplateDir'}/viewalertme.html";
$Global{'LNavBarTemplate'} ="$Global{'TemplateDir'}/leftnavbar.html";
$Global{'RNavBarTemplate'}="$Global{'TemplateDir'}/rightnavbar.html";
$Global{'Email_Auction_Template'}="$Global{'TemplateDir'}/emailauction.html";
$Global{'Announcements_Template'}="$Global{'TemplateDir'}/announcements.html";
$Global{'AnnouncementsbodyTemplate'}="$Global{'TemplateDir'}/announcementsbody.html";
$Global{'Preview_Bid_Template'}="$Global{'TemplateDir'}/previewbid.html";
$Global{'Search_Tips_Template'}="$Global{'TemplateDir'}/searchtips.html";
$Global{'General_Template'}="$Global{'TemplateDir'}/general.html";
$Global{'Search_Template'}="$Global{'TemplateDir'}/search.html";
$Global{'User_Agreement_Template'}="$Global{'TemplateDir'}/useragreement.html";
$Global{'Privacy_Policy_Template'}="$Global{'TemplateDir'}/privacypolicy.html";
$Global{'Preview_Item_Template'}="$Global{'TemplateDir'}/previewitem.html";
$Global{'All_Categories_Template'}="$Global{'TemplateDir'}/allcategories.html";
$Global{'About_Us_Template'}="$Global{'TemplateDir'}/aboutus.html";
$Global{'Help_Template'}="$Global{'TemplateDir'}/help.html";
$Global{'Help_Pages_Template'}="$Global{'TemplateDir'}/helppages.html";
$Global{'Bid_History_Template'}="$Global{'TemplateDir'}/bidhistory.html";
$Global{'My_Auctions_Template'}="$Global{'TemplateDir'}/myauctions.html";
$Global{'Feedback_Forum_Template'}="$Global{'TemplateDir'}/feedback.html";
$Global{'View_User_Feedback_Template'}="$Global{'TemplateDir'}/viewfeedback.html";
$Global{'Account_Manager_Template'}="$Global{'TemplateDir'}/accountmgr.html";
$Global{'Account_Manager_Main_Template'}="$Global{'TemplateDir'}/accountoverview.html";
$Global{'Account_Manager_Activity_Template'}="$Global{'TemplateDir'}/accountactivity.html";

#----------------------------------------------------------
#----------------------------------------------------------
$Global{'Categories_Data_File'}="$Global{'DataDir'}/categories.dat";
$Global{'General_Data_File'}="$Global{'DataDir'}/general.dat";
$Global{'RegistrationFile'}="$Global{'DataDir'}/users.dat";
$Global{'UserBidsFile'}="$Global{'DataDir'}/userbids.dat";
$Global{'UserItemsFile'}="$Global{'DataDir'}/useritems.dat";
$Global{'ItemsBidsFile'}="$Global{'DataDir'}/itemsbids.dat";
$Global{'ItemsFile'}="$Global{'DataDir'}/items.dat";
$Global{'ItemsIndexFile'}="$Global{'ItemsDir'}"."itemsindex.dat";
$Global{'OpenItemsIndexFile'}="$Global{'ItemsDir'}"."openindex.dat";
$Global{'Registered_Useres_Email_List'}="$Global{'Mail_Lists_Dir'}/regusers.mail";
$Global{'Alert_Me_File'}="$Global{'DataDir'}/alertme.dat";
$Global{'Closed_Items_File'}="$Global{'Archive_Dir'}/closeditems.dat";
$Global{'Featured_Items_File'}="$Global{'ItemsDir'}"."featured.dat";
$Global{'Featured_Home_Items_File'}="$Global{'ItemsDir'}"."featuredhome.dat";
$Global{'View_Items_Count_File'} = "$Global{'DataDir'}/viewcount.dat";
$Global{'Auction_Close_Log'}="$Global{'Archive_Dir'}/closedlog.txt";
$Global{'Billing_Fees_File'} = "$Global{'Secure_Dir'}/balance.csv";
$Global{'Announcements_File'}="$Global{'DataDir'}/announcements.dat";
$Global{'User_Feedback_File'}="$Global{'DataDir'}/feedback.dat";
$Global{'Feedback_Track_File'}="$Global{'DataDir'}/feedbacktrack.dat";
$Global{'Feedback_Comments_File'}="$Global{'DataDir'}/feedbackcmts.dat";
$Global{'Transactions_File'} = "$Global{'Secure_Dir'}/transactions.dat";
$Global{'Balance_File'}="$Global{'Secure_Dir'}/balance.dat";
#---------------------------------------------------------------------------------------
$Global{'Midi_Icon_File'}="$Global{'ImagesDir'}/cam.gif";
$Global{'Red_Ok_Icon'}="$Global{'ImagesDir'}/ok_yellow.gif";
$Global{'Alert_Me_Status_Off'}="$Global{'ImagesDir'}/statusoff.gif";
$Global{'Alert_Me_Status_On'}="$Global{'ImagesDir'}/statuson.gif";
$Global{'Delete_Alert_Me'}="$Global{'ImagesDir'}/delete.gif";
$Global{'Edit_Alert_Me'}="$Global{'ImagesDir'}/edit.gif";
$Global{'Yes_Image'}="$Global{'ImagesDir'}/yes.gif";
$Global{'No_Image'}="$Global{'ImagesDir'}/no.gif";
#---------------------------------------------------------------------------------------
$Global{'Auction_Script_URL'} = "$Global{'CGI_URL'}/$Global{'MainProg_Name'}";
$Global{'Admin_Script_URL'} = "$Global{'CGI_URL'}/$Global{'AdminProg_Name'}";
#---------------------------------------------------------------------------------------
$Global{'Upgrade_URL'} = "https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/upgrade/upgrade.cgi";
#$Global{'Upgrade_URL'} ="http://localhost/cgi-bin/upgrade"."/upgrade.cgi";
$Global{'Help_URL'} = "https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/help/help.cgi";
#$Global{'Help_URL'}="http://localhost/cgi-bin/help/help.cgi";
$Global{'Mewsoft_Auto_Installer'} = "https://www.safeweb.com/o/_i:http://www.mewsoft.com/cgi-bin/installer/installer.cgi";
#---------------------------------------------------------------------------------------
#---------------------------------------------------------------------------------------
my (@Languages) = &Get_Languages;
if (!@Languages) {
			eval "use language";
			@Languages = &Get_Installed_Languages;
			if (!@Languages) {
					print "Content-type: text/html\n\n";
					print "<B>Error:</B><BR>Can not find any languages installed and initialized on your system. Please goto your admin center, Language Manager , Initialize Languages and also Set the default language.";
					exit 0;
			}
}

if ($Cookies{'User_Language'}) {
		$Global{'Language'} = $Cookies{'User_Language'};
}
elsif ($Param{'Lang'}) {
		$Global{'Language'} = $Param{'Lang'};
}
elsif (@Languages){
		if (!$Global{'Language'}) {
				$Global{'Language'} = $Languages[0];
		}
}
#---------------------------------------------------------------------------------------
&Initialize_Language_Paths;

$Language{'currency'}=$Global{'Currency_Symbol'};

}
#==========================================================
1;
