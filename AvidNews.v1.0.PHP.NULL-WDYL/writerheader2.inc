<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
 <HEAD>
  <!-- $MVD$:app("MicroVision WebExpress","769") -->
  <!-- $MVD$:template("","0","0") -->
  <!-- $MVD$:color("15","95bf","Brown","1") -->
  <!-- $MVD$:color("18","ff3e3e","blue blue","1") -->
  <!-- $MVD$:color("19","aeffff","baje","1") -->
  <!-- $MVD$:color("20","e18344","bblue","1") -->
  <!-- $MVD$:color("21","42d0ff","idoogleyellow","1") -->
  <!-- $MVD$:color("22","e3e3e3","Lt Grey2","1") -->
  <!-- $MVD$:color("23","b3aaf0","Lt red","1") -->
  <!-- $MVD$:color("24","80ff","halloworange","1") -->
  <!-- $MVD$:color("25","552b00","dadablue","1") -->
  <!-- $MVD$:color("26","c08000","greyblue","1") -->
  <!-- $MVD$:color("27","f1c4a5","lighterblue","1") -->
  <!-- $MVD$:color("28","df987d","lavblue","1") -->
  <!-- $MVD$:color("29","241700","fade2","1") -->
  <!-- $MVD$:color("30","4b3201","fade3","1") -->
  <!-- $MVD$:color("31","694501","fade4","1") -->
  <!-- $MVD$:color("32","8a5a02","fade5","1") -->
  <!-- $MVD$:color("33","b67703","fade6","1") -->
  <!-- $MVD$:color("34","cf8803","fade7","1") -->
  <!-- $MVD$:color("35","f19e03","fade8","1") -->
  <!-- $MVD$:color("36","fcb530","fade9","1") -->
  <!-- $MVD$:color("37","fdc660","fade10","1") -->
  <!-- $MVD$:color("38","fdd284","fade11","1") -->
  <!-- $MVD$:color("39","fedd9e","fade12","1") -->
  <!-- $MVD$:color("40","fee9c2","fade13","1") -->
  <!-- $MVD$:color("41","feefd3","fade14","1") -->
  <!-- $MVD$:color("42","f5ebde","fade15","1") -->
  <!-- $MVD$:color("43","eeffff","baje2","1") -->
  <!-- $MVD$:color("44","fff9ec","realltblue","1") -->
  <!-- $MVD$:color("45","333333","coolgrey","1") -->
  <!-- $MVD$:color("46","cc99","grape green","1") -->
  <!-- $MVD$:color("47","dce5e5","Grey Baje","1") -->
  <!-- $MVD$:color("48","996666","Custom #1","0") -->
  <!-- $MVD$:color("49","cc9999","Custom #2","0") -->
  <!-- $MVD$:color("50","5e4746","real drk purple","1") -->
  <!-- $MVD$:color("51","d6d6d6","Custom #3","0") -->
  <!-- $MVD$:color("52","bebebe","Custom #4","0") -->
  <!-- $MVD$:color("53","0","fade1","1") -->
  <!-- $MVD$:color("54","ffffff","fade16","1") -->
  <!-- $MVD$:fontset("Untitled Font Set 2","Arial") -->
  <!-- $MVD$:fontset("Sans Serif","Arial","Helvetica","Monaco") -->
  <!-- $MVD$:fontset("Verdana","Verdana","Arial","Times New I2") -->
  <TITLE>A v i d  [News]&reg; v1.0 - Administration Panel</TITLE>
  <META NAME="GENERATOR" CONTENT="MicroVision Development / WebExpress">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <LINK REL="stylesheet" HREF="style.css" TYPE="text/css">
 <STYLE>
   body {margin: 0px 0px 0px 0px;}
</STYLE>
<style type="text/css">
<!--

.tooltiptitle{COLOR: #666699; TEXT-DECORATION: none; CURSOR: Default; font-family: arial; font-weight: bold; font-size: 8pt}
.tooltipcontent{COLOR: #000000; TEXT-DECORATION: none; CURSOR: Default; font-family: arial; font-size: 8pt}

#ToolTip{position:absolute; width: 100px; top: 0px; left: 0px; z-index:4; visibility:hidden;}

-->
</style>
<script language = "javascript">
<!--

var ie = document.all ? 1 : 0
var ns = document.layers ? 1 : 0

if(ns){doc = "document."; sty = ""}
if(ie){doc = "document.all."; sty = ".style"}



var initialize = 0
var Ex, Ey, topColor, subColor, ContentInfo


if(ie){
Ex = "event.x"
Ey = "event.y"

topColor = "#e3e3e3"
subColor = "#ffffff"
}

if(ns){
Ex = "e.pageX"
Ey = "e.pageY"
window.captureEvents(Event.MOUSEMOVE)
window.onmousemove=overhere

topColor = "#e3e3e3"
subColor = "#ffffff"
}



function MoveToolTip(layerName, FromTop, FromLeft, e){
if(ie){eval(doc + layerName + sty + ".top = "  + (eval(FromTop) + document.body.scrollTop))}
if(ns){eval(doc + layerName + sty + ".top = "  +  eval(FromTop))}
eval(doc + layerName + sty + ".left = " + (eval(FromLeft) + 15))
}






function ReplaceContent(layerName){

if(ie){document.all[layerName].innerHTML = ContentInfo}


if(ns){

with(document.layers[layerName].document) 
{ 
   open(); 
   write(ContentInfo); 
   close(); 
}

}


}



function Activate(){initialize=1}
function deActivate(){initialize=0}


function overhere(e){
if(initialize){

MoveToolTip("ToolTip", Ey, Ex, e)
eval(doc + "ToolTip" + sty + ".visibility = 'visible'")
}

else{
MoveToolTip("ToolTip", 0, 0)
eval(doc + "ToolTip" + sty + ".visibility = 'hidden'")
}


}









function EnterContent(layerName, TTitle, TContent){

ContentInfo = '<table border="0" width="150" cellspacing="0" cellpadding="0">'+
'<tr><td width="100%" bgcolor="#666699">'+

'<table border="0" width="100%" cellspacing="1" cellpadding="0">'+
'<tr><td width="100%" bgcolor='+topColor+'>'+

'<table border="0" width="90%" cellspacing="0" cellpadding="0" align="center">'+
'<tr><td width="100%">'+

'<font class="tooltiptitle">&nbsp;'+TTitle+'</font>'+

'</td></tr>'+
'</table>'+

'</td></tr>'+

'<tr><td width="100%" bgcolor='+subColor+'>'+

'<table border="0" width="90%" cellpadding="0" cellspacing="1" align="center">'+

'<tr><td width="100%">'+

'<font class="tooltipcontent">'+TContent+'</font>'+

'</td></tr>'+
'</table>'+

'</td></tr>'+
'</table>'+

'</td></tr>'+
'</table>';


ReplaceContent(layerName)

}





//-->
</script>
 </HEAD>
 <BODY BGCOLOR="WHITE" LINK="#00007F" VLINK="#00007F" ALINK="#00007F" onmousemove="overhere()">
 <div id="ToolTip"></div>
  <P>
   <TABLE WIDTH="100%" CELLPADDING="0" CELLSPACING="0" BORDER="0">
    <TR>
     <TD WIDTH="50%" BGCOLOR="BLACK" VALIGN=BOTTOM>
      <P>
       <TABLE WIDTH="100%" CELLPADDING="2" CELLSPACING="0" BORDER="0">
        <TR>
         <TD WIDTH="12%" VALIGN=TOP>
          <P>
           <FONT SIZE="2"><FONT COLOR="WHITE"><FONT FACE="Arial,Helvetica,Monaco"><IMG SRC="images/loginout.gif" WIDTH="116" HEIGHT="23" VSPACE="0" HSPACE="0" BORDER="0" USEMAP="#WBSMAP_topnav"></FONT></FONT></FONT></TD>
        </TR>
       </TABLE></TD>
     <TD WIDTH="50%" BGCOLOR="BLACK" VALIGN=BOTTOM>
      <P ALIGN=RIGHT>
       <IMG SRC="images/adminlogo.gif" WIDTH="221" HEIGHT="61" VSPACE="0" HSPACE="0" BORDER="0" LOOP="0"></TD>
    </TR>
   </TABLE>
   <TABLE WIDTH="100%" CELLPADDING="0" CELLSPACING="0" BORDER="0">
    <TR>
     <TD WIDTH="26%" BGCOLOR="#D6D6D6" VALIGN=TOP>
      <P>
       <TABLE WIDTH="100%" CELLPADDING="2" CELLSPACING="0" BORDER="0">
        <TR>
         <TD WIDTH="100%" BGCOLOR="#006666" VALIGN=TOP>
          <P>
           <TABLE WIDTH="100%" CELLPADDING="2" CELLSPACING="0" BORDER="0">
            <TR>
             <TD WIDTH="100%" VALIGN=TOP>
              <P ALIGN=LEFT>
               <FONT COLOR="#339999"><FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="4">NAVIGATION</FONT></FONT></FONT><BR>
               <HR ALIGN=LEFT WIDTH="100%" SIZE="1" NOSHADE COLOR="#339999">
               <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><FONT COLOR="WHITE">&#149;
                <A HREF="admin.php?action=news" CLASS="subnav1" onMouseover="EnterContent('ToolTip','Article Management','This area will allow you to edit and delete your articles.'); Activate();" onMouseout="deActivate()" >Article Management</A></FONT></FONT></FONT><BR>
               <HR ALIGN=LEFT WIDTH="100%" SIZE="1" NOSHADE COLOR="#339999">
               <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><FONT COLOR="WHITE">&#149;
                <A HREF="admin.php?action=categories" CLASS="subnav1" onMouseover="EnterContent('ToolTip','Category Management','This area will allow you to edit and delete your article categories.'); Activate();" onMouseout="deActivate()" >Category Management</A></FONT></FONT></FONT><BR>
               <HR ALIGN=LEFT WIDTH="100%" SIZE="1" NOSHADE COLOR="#339999">
               <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><FONT COLOR="WHITE">&#149;
                <A HREF="admin.php?action=templates" CLASS="subnav1" onMouseover="EnterContent('ToolTip','Template Management','This area will allow you to customize every aspect of your news and the way it is displayed'); Activate();" onMouseout="deActivate()" >Template Management</A></FONT></FONT></FONT><BR>
               <HR ALIGN=LEFT WIDTH="100%" SIZE="1" NOSHADE COLOR="#339999">
               <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><FONT COLOR="WHITE">&#149;
                <A HREF="admin.php?action=admins" CLASS="subnav1" onMouseover="EnterContent('ToolTip','Admin Management','The administration area allows you to add and delete other new writers'); Activate();" onMouseout="deActivate()" >Admin Management</A></FONT></FONT></FONT><BR>
               <HR ALIGN=LEFT WIDTH="100%" SIZE="1" NOSHADE COLOR="#339999">
               </P>
              <P>
               <!-- $MVD$:spaceretainer() -->&nbsp;</TD>
            </TR>
           </TABLE></TD>
        </TR>
        <TR>
         <TD WIDTH="100%" BGCOLOR="#D6D6D6" VALIGN=TOP>
          <P>
           <TABLE WIDTH="100%" CELLPADDING="7" CELLSPACING="0" BORDER="0">
            <TR>
             <TD WIDTH="100%" VALIGN=TOP>
              <P ALIGN=LEFT>
               <HR ALIGN=CENTER WIDTH="100%" SIZE="1" NOSHADE COLOR="#BEBEBE">
               <IMG SRC="images/previewicon.gif" ALIGN=ABSMIDDLE WIDTH="14" HEIGHT="17" VSPACE="0" HSPACE="0" BORDER="0" LOOP="0"> <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><A HREF="template.html" CLASS="subnav2">Preview
                Headline Layout</A></FONT></FONT><BR>
               <HR ALIGN=CENTER WIDTH="100%" SIZE="1" NOSHADE COLOR="#BEBEBE">
               <IMG SRC="images/previewicon.gif" ALIGN=ABSMIDDLE WIDTH="14" HEIGHT="17" VSPACE="0" HSPACE="0" BORDER="0" LOOP="0"> <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><A HREF="template.html" CLASS="subnav2">Preview
                Article Layout</A></FONT></FONT><BR>
               <HR ALIGN=CENTER WIDTH="100%" SIZE="1" NOSHADE COLOR="#BEBEBE">
               <IMG SRC="images/helpicon.gif" ALIGN=ABSMIDDLE WIDTH="17" HEIGHT="18" VSPACE="0" HSPACE="0" BORDER="0" LOOP="0"> <FONT FACE="Arial,Helvetica,Monaco"><FONT SIZE="2"><A HREF="template.html" CLASS="subnav2">Help</A></FONT></FONT><BR>
               <HR ALIGN=CENTER WIDTH="100%" SIZE="1" NOSHADE COLOR="#BEBEBE">
              </TD>
            </TR>
           </TABLE></P>
          <P>
           <!-- $MVD$:spaceretainer() -->&nbsp;</P>
          <P ALIGN=CENTER>
           <FONT SIZE="1"><FONT FACE="Arial,Helvetica,Monaco"><FONT COLOR="#666699">&copy;
            2003 AvidNewMedia. [WDYL]</FONT></FONT></FONT><BR>
           <FONT SIZE="1"><FONT FACE="Arial,Helvetica,Monaco"><FONT COLOR="#666699">All
            Rights Reserved.</FONT></FONT></FONT></TD>
        </TR>
       </TABLE></TD>
     <TD WIDTH="74%" VALIGN=TOP>
      <P>
       <TABLE WIDTH="100%" CELLPADDING="5" CELLSPACING="0" BORDER="0">
        <TR>
         <TD WIDTH="100%" VALIGN=TOP BACKGROUND="images/adminbgheader.gif" STYLE="background-repeat: no-repeat;">
          <P>