<!-- Chapter3/TestTimeUserControl1.aspx -->
<%@ Page Language="VB" Debug="True"%>
<%@ Register tagprefix ="utoledo" 
                       tagname="Time" 
                       Src="TimeUserControl.ascx" %>
<html><head></head><form><body>

<b>I am a host page. Suppose that I don't know how to show the time.
Hence, I will use the TimeUserControl. 
I am using an instance of the TimeUserControl below:<p>
<utoledo:Time runat="server" /><br/>
Now I can do my other work... <b/>
</body></form></html>