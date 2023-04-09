					</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=3 >
			<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100% BACKGROUND="images/bg-down2.gif">
				<TR>
<TD BACKGROUND="images/bg-down2.gif" width=175 height=22></TD>
<TD BACKGROUND="images/bg-down.jpg" vAlign=bottom align=left><font color=white class=copy>&COPY; 2001</font></TD>
<TD BACKGROUND="images/bg-down.jpg" vAlign=bottom align=right>&nbsp;&nbsp;&nbsp;</TD>
				</TR>
			</TABLE>	
		</TD>
	</TR>
</TABLE>
		</TD>
	</TR>
</TABLE>
<? include ("./dir/config.php");?>
<script language="javascript">
var data, p;
var agt=navigator.userAgent.toLowerCase();
var img=escape("buttons/b5.jpg");
document.cookie='__support_check=1';
p='http';
if((location.href.substr(0,6)=='https:')||(location.href.substr(0,6)=='HTTPS:')) {p='https';} data = '&agt=' + escape(agt) + '&img=' + img + '&r=' + escape(document.referrer) + '&aN=' + escape(navigator.appName) + '&lg=' + escape(navigator.systemLanguage) + '&OS=' + escape(navigator.platform) + '&aV=' + escape(navigator.appVersion);
if(navigator.appVersion.substring(0,1)>'3') {data = data + '&cd=' + screen.colorDepth + '&p=' + escape(screen.width+ 'x'+screen.height) + '&je=' + navigator.javaEnabled();};
document.write('<a href="<? echo $cgi_path; ?>template.php?a=ServuStats">');
document.write('<img width=1 height=1 border=0 hspace=0 '+'vspace=0 src="<? echo $cgi_path; ?>counter.php?a=ServuStats' + data + '"> </a>');
</script>
<noscript>
<a href="<? echo $cgi_path; ?>template.php?a=ServuStats">
<img width=1 height=1 border=0 hspace=0 vspace=0 src="<? echo $cgi_path; ?>counter.php?a=ServuStats"></a></noscript>

</body>
</html>