Imports dotBoardObjects

Public Class register
    Inherits FormBase
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents Label3 As System.Web.UI.WebControls.Label
    Protected WithEvents Label4 As System.Web.UI.WebControls.Label
    Protected WithEvents Label5 As System.Web.UI.WebControls.Label
    Protected WithEvents Label6 As System.Web.UI.WebControls.Label
    Protected WithEvents Label7 As System.Web.UI.WebControls.Label
    Protected WithEvents txtFirstName As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtLastName As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtUsername As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtPassword As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtConfirmPassword As System.Web.UI.WebControls.TextBox
    Protected WithEvents txtEmailAddress As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnRegister As System.Web.UI.WebControls.Button
    Protected WithEvents valFirstName As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valLastName As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valUsername As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valConfirmPassword As System.Web.UI.WebControls.CompareValidator
    Protected WithEvents valEmail1 As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valEmail2 As System.Web.UI.WebControls.RegularExpressionValidator
    Protected WithEvents valConfirmPassword2 As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valSummary As System.Web.UI.WebControls.ValidationSummary
    Protected WithEvents valPassword As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valCustom As System.Web.UI.WebControls.CustomValidator
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label

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
        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub btnRegister_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnRegister.Click
        'attempt to register the user
        If Me.Page.IsValid Then
            Try
                Dim myUser As dotBoardObjects.User
                myUser = dotBoardObjects.User.CreateUser( _
                    txtUsername.Text, txtPassword.Text, _
                    txtFirstName.Text, txtLastName.Text, _
                    txtEmailAddress.Text)
                'if we've made it this far, the create worked
                Dim objPage As FormBase
                objPage = CType(Me.Page, FormBase)
                objPage.CurrentUser = myUser
                'redirect to the default page
                Response.Redirect("default.aspx")
            Catch Ex As Exception
                valCustom.ErrorMessage = Ex.Message
                valCustom.IsValid = False
            End Try
        End If
    End Sub
End Class
