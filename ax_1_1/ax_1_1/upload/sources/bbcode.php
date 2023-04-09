<?
//+----------------------------------
//	AnnoucementX BBCode Recognizer
//	Version: 1.0
//	Author: Cat
//	Created: 2005/06/01
// 	Updated: 2005/10/12
//	Description: Handles the BBCode
//+----------------------------------

	
				$blah_1=array("[B]","[I]","[U]","[IMG]","[URL=","[EMAIL=","/]","[QUOTE]","[CODE]");
				$blah_2=array("[/B]","[/I]","[/U]","[/IMG]","[/URL]","[/EMAIL]","/]","[/QUOTE]","[/CODE]");
				$blah_3=array("<b>","<i>","<u>","<img src=","<a href=","<a href=mailto:",">","<div id=quote align=left style='margin-left: 2'><b>Quote:</b><br />","<div id=code align=left style='margin-left: 2'><b>Code:</b><br />");
				$blah_4=array("</b>","</i>","</u>"," border=0>","</a>","</a>",">","</div>","</div>");
				$blah_5=array("[b]","[i]","[u]","[img]","[url=","[email=","/]","[quote]","[code]");
				$blah_6=array("[/b]","[/i]","[/u]","[/img]","[/url]","[/email","/]","[/quote]","[/code]");
						
				$message=str_replace($blah_1,$blah_3,$message);
				$message=str_replace($blah_2,$blah_4,$message);	
				$message=str_replace($blah_5,$blah_3,$message);
				$message=str_replace($blah_6,$blah_4,$message);
				
				// Let's prune bad html tags now!!! :)
				
				$tags=array("<abbr","<acronym","<address","<applet","<area","<base","<basefont","<bdo","<bgsound","<big","<body","<button","<caption","<cite","<code","<colgroup","<dd","<dir","<div","<dfn","<dl","<dt","<em","<fieldset","<form","<frame","<frameset","<head","<html","<iframe", "<input","<ins","<kbd","<label","<legend","<map","<meta","<noframes","<object","<optgroup","<option","<param","<samp","<script","<select","<small","<style","<textarea","<title","<tt","<var","<xmp");
		
				$newtags=array("&lt;*abbr","&lt;*acronym","&lt;*address","&lt;*applet","&lt;*area","&lt;*base","&lt;*basefont","&lt;*bdo","&lt;*bgsound","&lt;*big","&lt;*body","&lt;*button","&lt;*caption","&lt;*cite", "&lt;*code","&lt;*colgroup","&lt;*dd","<dir","&lt;*div","&lt;*dfn","&lt;*dl","&lt;*dt","&lt;*em","&lt;*fieldset","&lt;*form","&lt;*frame","&lt;*frameset","&lt;*head","&lt;*html","&lt;*iframe", "&lt;*input","&lt;*ins","&lt;*kbd","&lt;*label","&lt;*legend","&lt;*map","&lt;*meta","&lt;*noframes","&lt;*object","&lt;*optgroup","&lt;*option","&lt;*param","&lt;*samp","&lt;*script","&lt;*select","&lt;*small","&lt;*style","&lt;*textarea","&lt;*title","&lt;*tt","&lt;*var","&lt;*xmp");
				
				$message=str_replace($tags,$newtags,$message);
					
?>