<?

/*

	PHP Chatengine version 1.9
	by Michiel Papenhove
	e-mail: michiel@mipamedia.com
	http:// www.mipamedia.com
	
	Software is supplied "as is". You cannot hold me responsible for any problems that
	might of occur because of the use of this chat
	
*/

// layout.php3

// function end_page()
function end_page($mysql_link)
{
	?>
	</body>
	</html>
	<?
}
// end function end_page()

if (($scriptname != "control.php3")):

?>
<html>

<title><? print($page_title); ?></title>
<style>

body		{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 10pt ; margin-top : 0px ; margin-right : 0px ; margin-left : 0px ; margin-bottom : 0px ;}
td		{ font-family : tahoma ; font-size: 8pt }
input.text	{ background-color: #ffffff; color: #000000 ; font-family : tahoma ; font-size: 8pt ; }
input.blacktext	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; border : 1px, solid ; border-color : #555555 ;}
input.button	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; border : 1px, solid}
input.submit	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; border : 1px, solid}
#typetext	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; border : 1px, solid}


select.typetext	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt ; border : 1px, solid}

a:link		{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt }
a:active	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt }
a:visited	{ background-color: #000000; color: #ffffff ; font-family : tahoma ; font-size: 8pt }

a.b1:link	{ background-color: #000000; color: red; font-family : tahoma ; font-size: 8pt; text-decoration: underline }
a.b1:active	{ background-color: #000000; color: red; font-family : tahoma ; font-size: 8pt; text-decoration: underline }
a.b1:visited	{ background-color: #000000; color: red; font-family : tahoma ; font-size: 8pt; text-decoration: underline }
a.b1:hover	{ background-color: #FFFCC; color: white; font-family : tahoma ; font-size: 8pt; text-decoration: underline }

</style>

<body <? print($extra_info); ?>>

<?

endif;

// end

?>
