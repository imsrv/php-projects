<!-- $Id: ns.quik-mark.tpl,v 1.2 2000/07/17 23:16:03 prenagha Exp $ -->
<li>Right-Click on this 
<A HREF="javascript:bk1='<?php echo $bookmarker->create_url;
?>?curl='+escape(location.href)+'&ctitle='+escape(document.title);bkwin=window.open(bk1,'bkqm','width=430,height=400,resizable=1');bkwin.focus();" OnClick = "alert('You must right-click this link, not left-click.'); return false;" >quik-mark</A>
link and select &quot;Add Bookmark for Link&quot;.
