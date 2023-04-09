<!-- BEGIN img_block -->
<img src="{IMG_PATH}{IMAGE}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}">
<!-- END img_block -->

<!-- BEGIN swf_block -->
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=4,0,2,0" width="{IMG_WIDTH}" height="{IMG_HEIGHT}"> 
<param name=movie value="{IMG_PATH}{IMAGE}"> 
<param name=quality value=high> 
<embed src="{IMG_PATH}{IMAGE}" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="{IMG_WIDTH}" height="{IMG_HEIGHT}"> 
</embed> 
</object>
<!-- END swf_block -->

<!-- BEGIN java_block -->
 <applet code="{IMAGE}" codebase="{IMG_PATH}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}">
{PARAMS}
alternative text
</applet> 
<!-- END java_block -->

<!-- BEGIN java_block2 -->
 <applet code="{APPLET_NAME}" codebase="{IMG_PATH}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}">
{PARAMS}
alternative text
</applet> 
<!-- END java_block2 -->


To use the following block, download JTed from http://www.jted.com and extract
into a directory named JTed underneath the directory containing sendcard.php
<!-- BEGIN java_block_Jted.class -->
<APPLET CODE="Jted.class" codebase="JTed/" WIDTH=500 HEIGHT=418 NAME=Jted ALT="JTed the Game">
<BR>
<H2>Your browser is either<BR><FONT COLOR=red>not Java enabled<BR> or uncapable</FONT><BR>to execute Java code</H2>
<BR>
<H2>Get the best browser at <BR><FONT COLOR=blue><U>http://www.netscape.com/</U></FONT></H2>
</APPLET>
<!-- END java_block_Jted.class -->

<!-- BEGIN java_block_PlasmaImage.class -->
<APPLET CODE="DS_PlasmaImage.class" codebase="{IMG_PATH}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}">
<PARAM NAME=credits VALUE="Applet by Dario Sciacca (www.dseffects.com)">
<PARAM NAME=image VALUE="{IMG_PATH}{IMAGE}">
<PARAM NAME=plasmasize VALUE="2">
<PARAM NAME=plasma1 VALUE="1">
<PARAM NAME=plasma2 VALUE="2">
</APPLET>
<!-- END java_block_PlasmaImage.class -->

<!-- BEGIN java_block_Lake.class -->
 <applet code="Lake.class" codebase="{IMG_PATH}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}">
<param name="image" value="{IMG_PATH}{IMAGE}">
<img src="{IMG_PATH}{IMAGE}">
</applet> 
<!-- END java_block_Lake.class -->

<!-- BEGIN quicktime_block -->
<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" WIDTH="{IMG_WIDTH}"HEIGHT="{IMG_HEIGHT}" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">
<PARAM name="SRC" VALUE="{IMG_PATH}{IMAGE}">
<PARAM name="AUTOPLAY" VALUE="true">
<PARAM name="CONTROLLER" VALUE="true">
<EMBED SRC="{IMG_PATH}{IMAGE}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}" AUTOPLAY="true" CONTROLLER="true" PLUGINSPAGE="http://www.apple.com/quicktime/download/">
</EMBED>
</OBJECT>
<!-- END quicktime_block -->

<!-- BEGIN embed_block -->
<embed src="{IMG_PATH}{IMAGE}" width="{IMG_WIDTH}" height="{IMG_HEIGHT}"></embed> 
<!-- END embed_block -->