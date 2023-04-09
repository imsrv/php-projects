<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// layout object

?>
<html>

<script language="JavaScript">
<!--

function passCom(type)
{
	//alert(type)
	parent.title.clean_frame(type)
}

//-->
</script>

<style>

body 	{ background-color: #555555; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; font-weight : bold ; margin-top : 0px ; margin-right : 0px ; margin-left : 5px ; margin-bottom : 0px }
td 	{ color : #333333 ; font-family : tahoma ; font-size: 8pt ; font-weight : bold ; margin-top : 0px ; margin-right : 0px ; margin-left : 5px ; margin-bottom : 0px }
a:link		{ color: #ffffff ; font-family : tahoma ; font-size: 8pt }
a:active	{ color: #ffffff ; font-family : tahoma ; font-size: 8pt }
a:visited	{ color: #ffffff ; font-family : tahoma ; font-size: 8pt }

</style>

<body>


<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td><?print($txt);?></td>
		<?
		if (($type!="") AND ($session != "")):
		?>
		<td align="right"><a href="javascript: passCom(<?print($type);?>)">Empty</a></td>
		<?
		endif;
		?>
	</tr>
</table>


</body>

</html>

