 </table>
            
          </td>
         
        </tr>
      </table>
    </td>
  </tr>
</table>

            <div align="center">
            <center>
<table border=0 width=700 cellspacing="0" cellpadding="0">
<tr>
<td width=100% height=25 align=center><font size=2 color=white face=arial>© Copyright
  2001. All rights reserved. </font></td>
<br><img src="./images/logban2.gif" width="468" height="60"></tr>
</table>

              <font size="1" face="Verdana, Arial, Helvetica, sans-serif" color=white></div>


<? include ("./dir/config.php");?>
<script language="javascript">
var data, p;
var agt=navigator.userAgent.toLowerCase();
var img=escape("buttons/b5.jpg");
document.cookie='__support_check=1';
p='http';
if((location.href.substr(0,6)=='https:')||(location.href.substr(0,6)=='HTTPS:')) {p='https';} data = '&agt=' + escape(agt) + '&img=' + img + '&r=' + escape(document.referrer) + '&aN=' + escape(navigator.appName) + '&lg=' + escape(navigator.systemLanguage) + '&OS=' + escape(navigator.platform) + '&aV=' + escape(navigator.appVersion);
if(navigator.appVersion.substring(0,1)>'3') {data = data + '&cd=' + screen.colorDepth + '&p=' + escape(screen.width+ 'x'+screen.height) + '&je=' + navigator.javaEnabled();};
document.write('<a href="<? echo $cgi_path; ?>template.php?a=LoggerX">');
document.write('<img width=1 height=1 border=0 hspace=0 '+'vspace=0 src="<? echo $cgi_path; ?>counter.php?a=LoggerX' + data + '"> </a>');
</script>
<noscript>
<a href="<? echo $cgi_path; ?>template.php?a=LoggerX">
<img width=1 height=1 border=0 hspace=0 vspace=0 src="<? echo $cgi_path; ?>counter.php?a=LoggerX"></a></noscript>

</body>
</html>