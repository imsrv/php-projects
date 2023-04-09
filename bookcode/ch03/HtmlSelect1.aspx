<!-- Chapter3\HtmlSelect1.aspx -->
<%@ page language="VB" debug="true" %>
<html><head></head><form runat="server">
<select id= "lstFlowers"  size="3" runat="server" /><br/><br/>
<input id="btnSubmit" type="button" 
       runat="server" value="Submit"
       onServerClick="showSelection"><br/><br/>
<span id=spnMessage runat="server"/><br>
<span id=spnPrice runat="server"/><br>
</form></html>
<script language="VB" runat="server">
  Sub Page_Load(source As Object, e As EventArgs)
    If Not IsPostBack Then
       Dim sortedList1 As New SortedList()
       ' Load the SortedList object
       sortedList1.Add("Tulip", 10.75)
       sortedList1.Add("Poppy",20.22)
       sortedList1.Add("Azalea",30.33)
       Dim i As Integer
       ' Load the HtmlSelect control (list box) with the key values
       ' of the SortedList object
       'For i = 0 To sortedList1.Count - 1
       '  lstFlowers.Items.Add(sortedList1.GetKeyList(i))
       'Next
       lstFlowers.DataSource = sortedList1.Keys
       lstFlowers.DataBind()
       Session.Timeout=10 'Set the session timeout
        ' Save the populated SortedList in the session
       Session("savedList") = sortedList1
   End If
End Sub
Sub showSelection(sender As Object, e As EventArgs)
   Dim sortedList1 As New SortedList()
   ' Load the Session's savedList into an instance of a SortedList
   sortedList1 = Session("savedList")
   Dim i As Integer
   Dim msg As String
   Dim dblPrice as Double
   dblPrice =sortedList1.GetValueList(lstFlowers.SelectedIndex)
   spnMessage.InnerHtml = "You have selected " + lstFlowers.Value 
   spnPrice.InnerHtml = "Its price is: " + FormatCurrency(dblPrice)
End Sub 
</script>
