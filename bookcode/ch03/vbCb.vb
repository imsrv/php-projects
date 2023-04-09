  ' Chapter3\vbCb.vb
  Option Strict Off
  Imports System
  Imports System.Web.UI.WebControls
  Namespace myVbCodeBehind
  Public Class vbCb : Inherits System.Web.UI.Page
     Public lstFlowers As System.Web.UI.WebControls.ListBox
     Public lblMessage As System.Web.UI.WebControls.Label
     Public btnSubmit As System.Web.UI.WebControls.Button
     Protected Sub Page_Load(ByVal sender As Object, ByVal e As EventArgs)
       If Not IsPostBack Then
           lblMessage.Text = "No Selection Yet"
           lstFlowers.Items.Add(new ListItem("Tulip"))
           lstFlowers.Items.Add(new ListItem("Rose"))
           lstFlowers.Items.Add(new ListItem("Redbud"))
           lstFlowers.SelectedIndex=0
       End If
      End Sub
      Protected Sub showSelection(ByVal obj As Object, ByVal e As EventArgs)
              lblMessage.Text = "You have selected " + lstFlowers.SelectedItem.Text
      End Sub  
    End Class
End Namespace