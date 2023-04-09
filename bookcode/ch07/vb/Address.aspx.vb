Option Explicit On 

Imports Chapter7_vb

Public Class Address
    Inherits System.Web.UI.Page
    Protected WithEvents dlAddress As System.Web.UI.WebControls.DataList
        Protected WithEvents lblTitle As System.Web.UI.WebControls.Label
                
#Region " Web Form Designer Generated Code "

    'This call is required by the Web Form Designer.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()

    End Sub

    Private Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        'CODEGEN: This method call is required by the Web Form Designer
        'Do not modify it using the code editor.
        InitializeComponent()
    End Sub

#End Region

    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'Put user code to initialize the page here
        If Not IsPostBack Then
            BindData()
        End If
    End Sub

    Private Sub BindData()
        Dim oDb As New CdalAddress()

        oDb.strConnection = ConfigurationSettings.AppSettings("appStrConnection")
        With dlAddress
            .DataSource = oDb.getAll()
            .DataBind()
        End With
        oDb = Nothing
    End Sub


    Public Sub addContact_Click(ByVal source As Object, ByVal e As EventArgs)
        '// Add a blank record and set the current index to the new row.
        '// display the record in edit style.
        Dim oDb As New CdalAddress()
        Dim adrsID As Int32
        oDb.strConnection = ConfigurationSettings.AppSettings("appStrConnection")

        '// Add a new record with some defaults.  store the New ID for the next step
        adrsID = oDb.Add("fname", "lname", "() -", "@", "http://", 0, "")

        '// Use the Id above to fill the DataList in the edit mode
        With dlAddress
            .DataSource = oDb.getByID(adrsID)
            .EditItemIndex = 0
            .DataBind()
        End With
        oDb = Nothing
    End Sub

    Public Sub UpdateAddress_Click(ByVal sender As Object, ByVal e As DataListCommandEventArgs)

        Dim oDb As New CdalAddress()
        Dim tmpTextBox As TextBox
        Dim arValues(7) As String

        arValues(0) = CType(e.Item.FindControl("txtadrsID"), TextBox).Text
        arValues(1) = CType(e.Item.FindControl("txtFName"), TextBox).Text
        arValues(2) = CType(e.Item.FindControl("txtLName"), TextBox).Text
        arValues(3) = CType(e.Item.FindControl("txtPhone"), TextBox).Text
        arValues(4) = CType(e.Item.FindControl("txtEMail"), TextBox).Text
        arValues(5) = CType(e.Item.FindControl("txtWebPage"), TextBox).Text
        arValues(6) = CType(e.Item.FindControl("txtAge"), TextBox).Text
        arValues(7) = CType(e.Item.FindControl("txtComments"), TextBox).Text

        oDb.strConnection = ConfigurationSettings.AppSettings("appStrConnection")

        oDb.Update(arValues(0), arValues(1), arValues(2), arValues(3), arValues(4), arValues(5), CType(arValues(6), Int16), arValues(7))

        dlAddress.EditItemIndex = -1
        BindData()
        oDb = Nothing
    End Sub

    Public Sub EditAddress_Click(ByVal sender As Object, ByVal e As DataListCommandEventArgs)

        '// Set the edit index to the selected row
        dlAddress.EditItemIndex = e.Item.ItemIndex
        BindData()

    End Sub

    Public Sub DeleteAddress_Click(ByVal sender As Object, ByVal e As DataListCommandEventArgs)
        Dim oDb As New CdalAddress()
        Dim strAdrsID As String

        oDb.strConnection = ConfigurationSettings.AppSettings("appStrConnection")

        strAdrsID = CType(e.Item.FindControl("txtAdrsID"), TextBox).Text

        oDb.Delete(strAdrsID)
        dlAddress.EditItemIndex = -1
        BindData()
    End Sub

    Public Sub Cancel_Click(ByVal sender As Object, ByVal e As DataListCommandEventArgs)

        '// Clear the edit Item index
        dlAddress.EditItemIndex = -1
        BindData()

    End Sub

End Class
