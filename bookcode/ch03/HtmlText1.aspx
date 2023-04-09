<!-- Chapter3/HtmlText1.aspx -->
<html><form method="post" runat="server">
 Your Story:<br>
 <TextArea id="txtAreaStory" runat="server"
	                     cols="20" rows="3" /><br>
 Name? <input id="txtName" type="text" 
                          size="12" runat="server"/><br>
 Password? <input id="txtPwd"  runat="server"
                      type="password"  size="12" /> 
 <br>
 <input type="Button"   runat="server"  value="Enter" 
       OnServerClick="CheckPassword"/>
 <span id="spnMessage" runat="server"> </span></h2>
 </form></html>
    
<script language="VB" runat="server">
    Sub checkPassword(source As Object, e As EventArgs)
        If txtName.Value = "Pepsi" And txtPwd.Value = "Beagle" Then
            spnMessage.InnerHtml = "<b>Password Correct: Story Accepted!!"
        Else
            spnMessage.InnerHtml = "<b>Bad Password: Story Rejected!!"
        End If 
    End Sub 
</script>