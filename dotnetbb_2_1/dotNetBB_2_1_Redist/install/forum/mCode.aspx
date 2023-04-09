<%@ Page Language="vb" %>
<%@ Import Namespace="ATPSoftware.dotNetBB" %>
<script runat="server">
	Dim siteRoot as String = ""
	Sub Page_Load
		Dim boardItems as new bbForum			'-- Initializes the message board
		Dim userGUID as String = ""
		Dim sendToNull as String = ""
		siteRoot = boardItems.siteRoot
		userGUID = boardItems.getUserCookie("uld")
		If userGUID = "" Then		
			userGUID = boardItems.GUEST_GUID				
		End If			
		sendToNull = boardItems.initializeBoard(userGUID)		
		headItems.Text = boardItems.getHeadItems()	
		emoticon.Text = boardItems.emoticonList()
		
		'-- End initialize
	End Sub	
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>    
		<asp:Literal ID="headItems" runat="server" />
		
		
		
	</head>
	<body topmargin="5" marginheight="0" leftmargin="0" marginwidth="0">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td background="<% =siteroot %>/images/help/navbar.gif">&nbsp;</td>
				<td background="<% =siteroot %>/images/help/navbar.gif" align="right"><a href="http://www.dotnetbb.com" target="_blank"><img src="<% =siteroot %>/images/help/nav_logo.gif" alt="dotNetBB Forums" border="0"></a></td>
			</tr>
		</table>
		<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
				<td class="msgFormHead" align="center"><b>mCode Listing</b></td>
			</tr>
			<tr>
				<td class="msgHelpBody">
					mCode is a simple to use set of replacement tags for common HTML code.  They allow you to change the formatting of your posting by allowing things
					such as <b>bold text</b>, <a href="http://www.dotNetBB.com" target="_blank">URL Hyperlinks</a> and more. Since HTML is not allowed in forum postings, 
					mCode can be used to replace selected HTML items.  Below you will find a listing of the available mCode tags with brief descriptions on how to use
					them.<br />&nbsp;
				</td>
			</tr>			
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.1"></a>
					<b>BOLD TEXT : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;b&gt;&lt;/b&gt;<br />
					mCode Tag : [b][/b]<br /><br />
					Example : [b]Make This Bold[/b] becomes <b>Make This Bold</b>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.2"></a>
					<b>ITALIC TEXT : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;i&gt;&lt;/i&gt;<br />
					mCode Tag : [i][/i]<br /><br />
					Example : [i]Make This Italic[/i] becomes <i>Make This Italic</i>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.3"></a>
					<b>UNDERLINED TEXT : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;u&gt;&lt;/u&gt;<br />
					mCode Tag : [u][/u]<br /><br />
					Example : [u]Make This Underlined[/u] becomes <u>Make This Underlined</u>
				</td>
			</tr>
			
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.4"></a>
					<b>SUBSCRIPT TEXT : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;sub&gt;&lt;/sub&gt;<br />
					mCode Tag : [sub][/sub]<br /><br />
					Example : This is [sub]Subscript[/sup] becomes This is <sub>Subscript</sub>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.5"></a>
					<b>SUPERSCRIPT TEXT : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;sup&gt;&lt;/sup&gt;<br />
					mCode Tag : [sup][/sup]<br /><br />
					Example : This is [sup]Superscript[/sup] becomes This is <sup>Superscript</sup>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.6"></a>
					<b>FONT COLOR : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;font color=...&gt;&lt;/font&gt;<br />
					mCode Tag : This has multiple types for different tag types as shown.<br /><br />
					
					[red]Red Text[/red] becomes <font style="color:990000;">Red Text</font><br />
					[green]Green Text[/green] becomes <font style="color:009900;">Green Text</font><br />
					[cyan]Cyan Text[/cyan] becomes <font style="color:008B8B;">Cyan Text</font><br />
					[blue]Blue Text[/blue] becomes <font style="color:000099;">Blue Text</font><br />
					[purple]Purple Text[/purple] becomes <font style="color:800080;">Purple Text</font><br />
					[white]White Text[/white] becomes <font style="color:FFFFFF;">White Text</font><br />
					[gray]Gray Text[/gray] becomes <font style="color:CCCCCC;">Gray Text</font><br />
					[black]Black Text[/black] becomes <font style="color:000000;">Black Text</font><br />
					[yellow]Yellow Text[/yellow] becomes <font style="color:FFFF00;">Yellow Text</font><br />
					[orange]Orange Text[/orange] becomes <font style="color:FFA500;">Orange Text</font><br />					
										
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.7"></a>
					<b>FONT SIZE : </b><br />					
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;font size=...&gt;&lt;/font&gt;<br />
					mCode Tag : This has multiple types for different tag types as shown.<br /><br />
					
					[small]Small Text[/small] becomes <font style="font-size:7.5pt;">Small Text</font><br />
					[medium]Meduim Text[/medium] becomes <font style="font-size:8pt;">Medium Text</font><br />
					[large]Large Text[/large] becomes <font style="font-size:10pt;">Large Text</font><br />
					[x-large]X-Large Text[/x-large] becomes <font style="font-size:12pt;">X-Large Text</font><br />
					[huge]Huge Text[/huge] becomes <font style="font-size:14pt;">Huge Text</font><br />				
										
				</td>
			</tr>

			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.8"></a>
					<b>IMAGE TAG : </b><br />				
				</td>
			</tr>
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;img src=...&gt;<br />
					mCode Tag : [img][/img]<br /><br />
					Example : [img]http://www.dotNetBB.com/logo.gif[/img] becomes<br /> <img src="<% =siteroot %>/images/dotnetbblogo.gif" border="0">
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.9"></a>
					<b>HYPERLINK TAG : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;a href=...&gt;&lt;/a&gt;<br />
					mCode Tag : This has multiple types for different tag types as shown.<br /><br />
					&nbsp;&nbsp;&nbsp;[url]URL[/url]<br />
					&nbsp;&nbsp;&nbsp;[url=URL]LINK TEXT[/url]<br />
					&nbsp;&nbsp;&nbsp;[url]EMAIL[/url]<br />
					&nbsp;&nbsp;&nbsp;[url=EMAIL]LINK TEXT[/url]<br /><br />
					Examples of each :<br />
					&nbsp;&nbsp;&nbsp;[url]http://www.dotNetBB.com[/url] becomes <a href="http://www.dotNetBB.com" target="_blank">www.dotNetBB.com</a><br />
					&nbsp;&nbsp;&nbsp;[url=http://www.dotNetBB.com]dotNetBB[/url] becomes <a href="http://www.dotNetBB.com" target="_blank">dotNetBB</a><br />
					&nbsp;&nbsp;&nbsp;[url]info@dotNetBB.com[/url] becomes <a href="mailto:info@dotNetBB.com">info@dotNetBB.com</a><br />
					&nbsp;&nbsp;&nbsp;[url=info@dotNetBB.com]Mail me[/url] becomes <a href="mailto:info@dotNetBB.com">Mail Me</a><br />
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.10"></a>
					<b>LIST : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;ul&gt;&lt;li&gt;&lt;/li&gt;&lt;/ul&gt;<br />
					mCode Tag : [list]*[/list]<br /><br />
					Example : [list]<br>*item 1<br>*item 2<br>*item 3<br>[/list] becomes <br />
					<ul><li>item 1</li><li>item 2</li><li>item 3</li></ul>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.11"></a>
					<b>QUOTE : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : N/A<br />
					mCode Tag : This has multiple types for different tag types as shown.<br />
					&nbsp;&nbsp;&nbsp;[quote][/quote]<br />
					&nbsp;&nbsp;&nbsp;[quote="Name"][/quote]<br /><br />
					Example : [quote]This is a quote[/quote] becomes
					<div class="msgQuoteWrap"><div class="msgQuote"><b>Somebody said...</b><br />This is a quote</div></div><br />
					Example : [quote="Joe Blow"]This is a quote[/quote] becomes
					<div class="msgQuoteWrap"><div class="msgQuote"><b>Joe Blow said...</b><br />This is a quote</div></div>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.12"></a>
					<b>CODE : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : N/A<br />
					mCode Tag : [code][/code]<br /><br />
					Example : [code]&lt;This is a code&gt;[/code] becomes
					<div class="msgQuoteWrap"><div class="msgCode">&lt;This is a code&gt;</This></div></div>
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.13"></a>
					<b>FLASH : </b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					HTML Tag : &lt;embed src=...&gt;&lt;/embed&gt;<br />
					mCode Tag : This has multiple types for different tag types as shown.<br />
					&nbsp;&nbsp;&nbsp;[flash][/flash] (defaults to 200px high x 200px wide)<br />
					&nbsp;&nbsp;&nbsp;[flash|200|200][/flash] (numeric values are height and width, up to 600px each in 50px increments)<br />
					<br />
										
					Example : [flash]http://www.dotNetBB.com/dotnetbb.swf[/flash] becomes (200px high x 200px wide) <br />
					<embed src="dotnetbb.swf" height="200" width="200" quality="high" loop="infinite" TYPE="application/x-shockwave-flash" PLUGINSPAGE="www.macromedia.com/shockwave/download/index.cgiP1_Prod_Version=Shockwaveflash">
					<br />
					Example : [flash|100|300]http://www.dotNetBB.com/dotnetbb.swf[/flash] becomes (100px high x 300px wide) <br />
					<embed src="dotnetbb.swf" height="100" width="300" quality="high" loop="infinite" TYPE="application/x-shockwave-flash" PLUGINSPAGE="www.macromedia.com/shockwave/download/index.cgiP1_Prod_Version=Shockwaveflash">
				</td>
			</tr>
			<tr>
				<td class="msgTopicHead" style="border-top: 1px outset threedshadow;">
					<a name="1.14"></a>
					<b>EMOTICONS :</b><br />
				</td>
			</tr>			
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
					For those moments when typed words aren't enough, we offer emoticons to fill the gap.  On this forum you can type the text listed in the 'Code' column to have the corresponding image
					be replaced in the text of your post.<br />&nbsp;
					<asp:Literal ID="emoticon" Runat="server" />
				</td>
			</tr>
			<tr>
				<td class="msgHelpBody" style="border-top: 1px outset threedshadow;">
				&nbsp;
				</td>
			</tr>
		</table>
		<table border="0" cellpadding="3" cellspacing="0" style="width:100%;height:100px;">
			<tr>
				<td class="copyRight" align="center" valign="bottom">
					Forum powered by dotNetBB v2.1<br />
					<a href="http://www.dotnetbb.com" target="_blank">dotNetBB</a>&nbsp; 
					&copy;&nbsp;2000-2002 <a href="mailto:Andrew@dotNetBB.com">Andrew Putnam</a>
				</td>
			</tr>
		</table>
	</body>
</html>
