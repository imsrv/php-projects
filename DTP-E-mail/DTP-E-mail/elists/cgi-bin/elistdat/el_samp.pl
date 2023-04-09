#REFERENCE: DO NOT CHANGE THIS HTML/TEXT
# E-Lists 2.2 DO NOT EDIT
sub show {
	my $typ = shift; my $is,$cspn;
	($typ,$is) = split (/:/,$typ);
	$isDots = $is."::";
my $fRm = qq~<html>
<head><title>E-Lists Sample Forms</title></head>
<body bgcolor="#EFEFEF" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center>
<p><font face="verdana, arial, geneva, helvetica" size="2">List Type: <b>$typ</b> - List Name: <b>$is</b></font></p>

  <form method="POST" action="$prog_url">
    <input type="hidden" name="df" value="$isDots">
    <input type="hidden" name="return" value="http://www.path.to/success-returnlink.htm">
~;
if ($typ < 5) {$fRm .= qq~    <input type="hidden" name="this" value="http://www.path.to/this-subscribeform.htm">
    <input type="hidden"name="undo" value="http://www.path.to/unsubscribeform-ifNotThis.htm">

~;}
$fRm .= qq~    <table border="0" cellspacing="0" cellpadding="1">
            <tr bgcolor="#663300"> 
              <th width="100%" valign="top" colspan="2"><font face="verdana, arial, geneva, helvetica" size="2" color="#FFFFFF">E-Lists Sample test form</font></th>
            </tr>
            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"><font face="verdana, arial, geneva, helvetica" size="1">Enter your <b>E-mail Address</b></font><br>
                <input type="text" name="from" size="25" maxlength="75"></th>
            </tr>
~;
if ($typ < 5) {$fRm .= qq~            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"><font face="verdana, arial, geneva, helvetica" size="1" color="#CC0000">Repeat</font><font face="verdana, arial, geneva, helvetica" size="1"><b> E-mail Address</b></font><br>
                <input type="text" name="fromChk" size="25" maxlength="75"></th>
            </tr>
~;}
if ($typ < 3) {$fRm .= qq~            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"><font face="verdana, arial, geneva, helvetica" size="1">Enter your <b>Name</b></font><br>
                <input type="text" name="fstname" size="25" maxlength="35"></th>
            </tr>
~;}
$fRm .= qq~            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"> 
                <input type="radio" value="0" name="unsub" checked>
                <font face="verdana, arial, geneva, helvetica" size="1">Subscribe</font> 
                <input type="radio" value="1" name="unsub">
                <font face="verdana, arial, geneva, helvetica" size="1">Un-Subscribe</font></th>
            </tr>
~;
if ($typ < 5) {$fRm .= qq~            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"> 
                <input type="radio" name="ishtml" value="0" checked>
                <font face="verdana, arial, geneva, helvetica" size="1">Plain Text </font> 
                <input type="radio" name="ishtml" value="htm">
                <font face="verdana, arial, geneva, helvetica" size="1">HTML&nbsp;<font color="#990000">Mail&nbsp;Format</font></font></th>
            </tr>
~;}
$fRm .= qq~            <tr bgcolor="#FFFFFF"> 
              <th width="100%" colspan="2" valign="top"> 
                <input type="submit" value="   Submit   " name="send"></th>
            </tr>
            <tr bgcolor="#EFEFEF"> 
              <td width="100%" colspan="2" valign="top" align="center"> <font face="arial, geneva, helvetica" size="1">Information 
                used only for the stated purpose,<br>not given to others for any reason what so ever.</font></td>
            </tr>
          </table>
  </form>

</center>
</body>
</html>

<!-- OPTIONS
~;
if ($typ == 5) {$fRm .= qq~    NOTE: You MUST manually CREATE a "$is.pl" ADDRESS file for type 5 (from supplied master - see readme)
~;}
$fRm .= qq~
        <input type="hidden" name="unsub" value="0">  ... use IF no visible sub/un-sub buttons ... "0" = Subscribe

~;
if ($typ < 5) {$fRm .= qq~        <input type="checkbox" name="ishtml" value="htm">  ... HTML mail-out option as SINGLE checkbox

~;}
$fRm .= qq~        name="df"  ... value must match EXACTLY the "Allowed" list name activated via admin

        name="return"  ... imbedded link URL in error/success page

~;
if ($typ < 5) {$fRm .= qq~        name="this"  ... full URL included in mail auto-response, this = form used to subscibe

        name="undo"  ... full URL included in mail auto-response, where user can return to manually UN-Subscribe
            ( if no "undo" hidden tag, then "this" tag value is used )
            
~;}
$fRm .= qq~        name="thnx" value="http://?????"  ... full URL to YOUR OWN success page - overrides internal
    OR
        name="thnx" value="pop"  ... IF using a popup window, imbeds "Close Window" in success page

~;
if ($typ < 5) {$fRm .= qq~-------------------------
    Use following INSTEAD OF name="undo" hidden tag IF one common site page FOR ALL Un-Subscribing;
        CONFIG file  -  "\$unsthnxPage" ... do not use form specific "undo" hidden tag URLs with this variable
~;}
$fRm .= qq~-->
~;
$fRm =~ s/&/&amp;/gs;
print "Content-type: text/html\n\n"; 
print qq~<html><head>
<title>E-Lists Sample</title>
<script language="JavaScript"><!-- 
 function selectCode() {	
	document.sampFrm.samp.focus(); 
	document.sampFrm.samp.select();
 }
//-->
</script></head>
<body bgcolor="#F5F5F5" text="#000000" link="#0000FF" vlink="#0000FF" alink="#FF0000">
<center><p><font face="Verdana, Arial, Geneva, Helvetica"><font size="3"><b>E-Lists Sample Form</b> html code<br>[ <font color="#CC0000"><b>List TYPE : $typ</b></font> ]</font><br><font size="1">with options</font></font>
<form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form></center>
<form name="sampFrm"><center>
    <table border="0" width="595" cellspacing="0" cellpadding="1">
      <tr><th width="100%" align="center" bgcolor="#660000"><font size="2" face="verdana,arial,geneva,helvetica" color="#FFFFFF"> 
       [ List TYPE : $typ ] Copy as &quot;Master Reference&quot; for a new form</font></th>
      </tr><tr bgcolor="#E5E5E5"> 
       <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="8">
        <tr><td><font face="verdana, arial, geneva, helvetica" size="1">This box contains an E-Lists sample form. By <b>copying</b> the html 
         code and <b>pasting</b> in to a text or wysiwyg editor you will be able to <b>edit</b> and create the basic form tags for any new forms you want to install on your site.<br>&#149; In most cases only the code from the &lt;form......&gt; 
         to &lt;/form&gt; tag pair will be required.<br>&#149; Remove/include options a required.<br>&#149; The base of this html code contains reminders about variations to each form.<br>&#149; The default &quot;df&quot; hidden tag value is imbedded 
         with the list name currently displayed in the &quot;Allowed&quot; drop list. Change that value EXACTLY as required for a new form not yet listed.</font></td></tr></table></td>
      </tr><tr bgcolor="#E5E5E5"> 
       <td width="100%" align="center"> <font face="Verdana, Arial, Geneva, Helvetica" size="1"><b><a href="javascript:selectCode();">Click</a> 
        to Select All</b><i> - or [Control+A] in active box</i><br>...then right mouse button click [select 'Copy'], <i>OR</i> [Control+C], to copy to clip board.</font> <br>
        <textarea name="samp" cols="66" rows="30" wrap="OFF">$fRm</textarea></td>
      </tr><tr> 
       <td width="100%" align="center"><font face="Arial, Geneva, Helvetica" size="1">E-Lists 2.2 copyright</font></td>
      </tr></table>
</center></form>
<center><form><input type="button" value="  CLOSE WINDOW to Return  " onClick="window.close();" name="button"></form></center>
</body></html>~; exit(0);
}
1;
