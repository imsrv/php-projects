<!-- $Id: msie.quik-mark.tpl,v 1.3 2000/07/17 23:16:03 prenagha Exp $ -->
<li>Right-Click on this 
<A HREF="javascript:bk1='<?php echo $bookmarker->create_url;
?>?curl='+escape(location.href)+'&ctitle='+escape(document.title);window.open(bk1,'bkqm','width=430,height=400,resizable=1');window.focus();" OnClick = "alert('You must right-click this link, not left-click.'); return false;" >quik-mark</A>
link and select &quot;Add to Favorites&quot;. Please note that there is a bug in Microsoft's implementation of Javascript (big shocker!) which means I had to spend extra time investigating and implementing a workaround so that the quik-mark popup window will come to the front when it is opened.
