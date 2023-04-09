<? 
////////////////////////////////////////////////////////////////////////////
//  Program:        Pearl Forums
//  First Release:  February 20, 2004
//  Version:        2.4 - April 6, 2005
//  Author:         Binh Thuong Nguyen
//  Copyright:      Pearlinger - http://www.pearlinger.com
//  Script File:    master.php - Master template containing the outter frame of 
//                  each page's output.  Content formats of each page can be found 
//                  in corresponding file names in the templates folder.
//  -----------------------------------------------------------------------
//  This program is free software and distributed under the terms of the
//  GNU General Public License by the Free Software Foundation, and is
//  WITHOUT ANY WARRANTY/LIABILITY (see license.txt for more details).
//  Copyright notices on outputs can be removed by contributing a small 
//  donation to help us offset costs of maintaining and further development,
//  distribution of Pearl.  Please visit pearlinger.com for more details.
////////////////////////////////////////////////////////////////////////////

	global $Document,$Member;
	if($Document[HTMLAreaMode])
		$Document[onLoad]="HTMLArea.init(); HTMLArea.onload = initEditor";

?>
<HTML>
<HEAD>
	<TITLE><? echo $Document['title'] ?></TITLE>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="<? echo $Document['title'] ?>">
	<meta name="description" content="<? echo $Document['title'] ?>">
	<style type="text/css">
  		@font-face {
		    font-family: Tahoma, Verdana;
		    font-style:  normal;
		    font-weight: normal;		    
	  	}
		a:alink { color: <? echo $Document['linkColor'] ?>; text-decoration: none }
		a:hover { color: <? echo $Document['linkColor'] ?>; text-decoration: underline }
		a:link { color: <? echo $Document['linkColor'] ?>; text-decoration: none }
		a:vlink { color: <? echo $Document['linkColor'] ?>; text-decoration: none }

		UL, OL, DIR, MENU, DIV, DT, DD, ADDRESS, BLOCKQUOTE, PRE, LI, P, OPTION, TD
		{
			color: <? echo $Document['textColor'] ?>;
			font-size: 8pt;
			font-weight: regular;
			font-family: Tahoma, Verdana; 
		}	
		.TinyText
		{
			font-size: 6pt;
			font-weight: regular;
			font-family: Tahoma, Verdana; 		
		}
		.SkinnyText
		{
			font-size: 8pt;
			font-weight: regular;
			font-family: Arial Narrow; 		
			color: #969D9C;	
			font-stretch: 0.3 pt
		}		
		.GreyText
		{
			color: #969D9C;			
		}
		.SmallText
		{
			font-size: 7pt;
			font-weight: regular;
			font-family: Tahoma, Verdana; 		
		}
		.TDStyle
		{

			color: <? echo $Document['textColor'] ?>;
			font-size: 8pt;
			font-family: Tahoma, Verdana; 		
			background-color:#FFFFFF
		}	
		.TDPlain
		{
			color: <? echo $Document['textColor'] ?>;
			font-size: 8pt;
			font-family: Tahoma, Verdana; 		
		}	
		.TDAltStyle
		{

			color: <? echo $Document['textColor'] ?>;
			font-size: 8pt;
			font-family: Tahoma, Verdana; 		
			background-color:#EFF3EF
		}	
		.TableStyle
		{
			border-width: 1px; 
			border-style: solid;
			border-color: #BFC4BF;
			background-color:#FFFFFF
		}
		.htmlAreaTable
		{
			border-width: 1px; 
			border-style: solid;
			border-color: #BFC4BF;
			background-color:#E7E4DE
		}		
  		.MainTR
  		{
    		font-weight: regular;
    		font-size: 13px;
    		background-image: url(images/maintr.gif);
  		}
  		.TitleTR
  		{
    		font-weight: regular;
    		font-size: 11px;
			background-color: #CED7D6; 
  		}
		.OuterTableStyle
		{
			background-color:#BFC4BF
		}

		input,select,textarea
		{						
			color: <? echo $Document['textColor'] ?>;	   	
			font-size: 8pt;
			font-weight: regular;
			font-family: Tahoma, Verdana; 	
			background-color:#F5F5F5
		}		
		.SubmitButtons
		{
			color: <? echo $Document['linkColor'] ?>
		}
		.GoButton
		{
			font-size:8pt;
			height:14pt;
			color: <? echo $Document['linkColor'] ?>

		}
		.BigGoButton
		{
			font-size:8pt;
			height: 15pt;
			color: <? echo $Document['linkColor'] ?>

		}
		.InputForms
		{			
			background-color: #F5F5F5;
		}		
  		.BorderColor
  		{
    		font-size: 12px;
    		font-family: verdana, arial, helvetica, serif;
    		background-color: #BFC4BF;
  		}		
		.Error
		{
			color: RED;
			font-size: 8pt;
			font-weight: regular;
			font-family: Tahoma, Verdana; 				
		}
		#MemberPhoto{
			z-index:100;
			width: <? echo $Document[avatarWidth] ?>;
			height: <? echo $Document[avatarHeight] ?>;
			overflow: hidden;
			border-width: 1px; 
			border-style: solid;
			border-color: #000000;
		}			
		#MemberFullPhoto{
			position:relative;
			z-index:100;
			width: <? echo $Document[avatarWidth] ?>;
			height: <? echo $Document[avatarHeight] ?>;
			border-width: 1px; 
			border-style: solid;
			border-color: #000000;
		}			
		
	</style>
	<? if($Document[HTMLAreaMode]){?>
		<script type="text/javascript">
		  _editor_url = "htmlarea/";
		  _editor_lang = "en";
		</script>
		<script type="text/javascript" src="htmlarea/htmlarea.js"></script>
		<script type="text/javascript">
		var editor = null;
		function initEditor() {
		  editor = new HTMLArea("message");

		  editor.generate();
		}
		function insertHTML(html) {
		  if (html) {
		    editor.insertHTML(html);
		  }
		}
		</script>
	
	<?}?>
</HEAD>
<BODY LINK="<? echo $Document['linkColor'] ?>" VLINK="<? echo $Document['linkColor'] ?>" TEXT="#<? echo $Document['textColor'] ?>" LEFTMARGIN="0" TOPMARGIN="0" MARGINWIDTH="0" MARGINHEIGHT="0" <? if($Document['onLoad']){print "onLoad=\"$Document[onLoad]\"";}?> <? if($Document['onUnload']){print "onUnload=\"$Document[onUnload]\"";}?>>
<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" WIDTH="<? echo $Document['width'] ?>" ALIGN="CENTER">
<TR>
	<TD COLSPAN="2">
		<A HREF="http://www.pearlinger.com"><IMG SRC="images/logo.gif" VSPACE="0" BORDER="0" TITLE="replace with your logo here" /></A>
	</TD>
</TR>
<TR>
	<TD COLSPAN="2" ALIGN="CENTER"><BR />
		<TABLE WIDTH="100%" CELLSPACING="0" CELLPADDING="0" BORDER="0">
		<TR>
			<TD CLASS="TDPlain">
				<? echo $Member['name'] . " <SPAN CLASS=GreyText>" . $Member['adminPosition'] ?></SPAN>
			</TD>
			<TD ALIGN="RIGHT" CLASS="TDPlain">
				<? echo $Document['navigation'] ?>	
			</TD>
		</TR>		
		</TABLE>
	</TD>
</TR>
<TR>
	<TD COLSPAN="2">&nbsp;</TD>
</TR>
<TR>
	<TD CLASS="TDPlain">
		<NOBR><? echo $Document['forumNavigation']?></NOBR>
	</TD>
	<TD CLASS="TDPlain" ALIGN="RIGHT">
	<NOBR><? echo $Document['previousNextNavigation'] ?></NOBR>
	</TD>
</TR>
<TR>
	<TD COLSPAN="2" CLASS="TDStyle">
	<!-- C O N T E N T S   B E G I N -->
	<? echo $Document['contents'] ?>
	<? echo $Document['footerLinks'] ?>
	<!-- E N D   O F   C O N T E N T S  -->	
	</TD>
</TR>
</TABLE>
<BR /><BR />
<TABLE WIDTH="<? echo $Document[width] ?>" ALIGN="CENTER">
<TR>
	<TD CLASS="TDStyle" ALIGN="CENTER">
		<?
		// You can remove the copyright line below by making a small donation
		// to support further development of Pearl.  Please visit http://www.pearlinger.com 
		// for more details.
		?>
		&copy 2004 - 2005 <A HREF="http://www.pearlinger.com">Pearl Forums 2.4</A> - Developed by Pearlinger.com <BR /><BR />
	</TD>
</TR>
</TABLE>
</BODY>
</HTML>