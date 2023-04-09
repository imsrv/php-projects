<!-- Chapter3\HtmlInputCheck1.aspx -->
<%@ page language="VB" debug="true" %>
<html><head></head><form runat="server">
Select a room type<br>
<input type="radio" id="radOceanFront" name="rgrView" runat="server"/>Ocean Front: $600.00<br>
<input type="radio" id="radOceanView" name="rgrView" runat="server"/>Ocean View: $400.00<br><br>
Select one or more special facilities: <br>
<input type="checkbox"  id= "chkFishing"  
runat="server" />Deep Sea Fishing: $450.00<br>
<input type="checkbox"  id= "chkGolf"  
  runat="server" />Golf at Diamond's Head: $150.00<br>
<input id="btnSubmit" type="button" 
       runat="server" value="Submit"
       onServerClick="showPrice"><br><br>
<span id=spnPrice runat="server"/><br>
</form></html>

<script language="VB" runat="server">
Sub showPrice(sender As Object, e As EventArgs)
   Dim totalPrice As Double = 0
   If radOceanFront.Checked Then
      totalPrice += 600.00
   End If
   If radOceanView.Checked Then
      totalPrice += 400.00
   End If
   If chkFishing.Checked Then
       totalPrice += 450.00
   End If   	
   If chkGolf.Checked Then
       totalPrice += 150.00
   End If
   spnPrice.InnerHtml = "Total Price is: " + FormatCurrency(totalPrice)
End Sub 
</script>
