Imports dotBoardObjects

Public MustInherit Class userArea
    Inherits System.Web.UI.UserControl
    Protected WithEvents pnlNotLoggedIn As System.Web.UI.WebControls.Panel
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents txtUsername As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents txtPassword As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnLogIn As System.Web.UI.WebControls.Button
    Protected WithEvents lblError As System.Web.UI.WebControls.Label
    Protected WithEvents LinkButton1 As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lblWelcome As System.Web.UI.WebControls.Label
    Protected WithEvents lnkLogOut As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lnkProfile As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lnkAdmin As System.Web.UI.WebControls.LinkButton
    Protected WithEvents lnkCreateBoard As System.Web.UI.WebControls.LinkButton
    Protected WithEvents pnlLoggedIn As System.Web.UI.WebControls.Panel


    'This call is required by the Web Form Designer.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()

    End Sub

    Private Sub Page_Init(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Init
        'CODEGEN: This method call is required by the Web Form Designer
        'Do not modify it using the code editor.
        InitializeComponent()

        pnlNotLoggedIn.Visible = True
        pnlLoggedIn.Visible = False
        lnkAdmin.Visible = False

        'attempt to log the user in
        If Not Session.Contents().Item("userid") Is Nothing Then
            Dim userId As Long
            userId = CLng(Session.Contents.Item("userid"))

            Dim myUser As User
            Try
                myUser = New User(userId)
                Dim objPage As FormBase
                objPage = CType(Me.Page, FormBase)
                objPage.CurrentUser = myUser

                pnlNotLoggedIn.Visible = False
                pnlLoggedIn.Visible = True

                lblWelcome.Text = myUser.FirstName & " " & myUser.LastName

                If myUser.IsAdmin Then
                    lnkAdmin.Visible = True
                End If
            Catch Ex As Exception
                lblError.Text = Ex.Message
            End Try
        End If
    End Sub


    Private Sub Page_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'Put user code to initialize the page here
    End Sub

    Private Sub btnLogIn_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles btnLogIn.Click
        'attempt to log in the user
        If txtUsername.Text.Trim() <> "" And _
            txtPassword.Text.Trim() <> "" Then
            Try
                Dim myUser As User = User.Validate(txtUsername.Text, _
                    txtPassword.Text)
                Dim objPage As FormBase
                objPage = CType(Me.Page, FormBase)
                objPage.CurrentUser = myUser
                'if it got this far it succeeded
                'redirect, to allow the whole page to refresh
                Response.Redirect(Request.RawUrl)
            Catch Ex As Exception
                lblError.Text = Ex.Message
            End Try
        End If
    End Sub

    Private Sub LinkButton1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles LinkButton1.Click
        'redirect to the register page
        Response.Redirect("register.aspx")
    End Sub

    Private Sub lnkLogOut_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lnkLogOut.Click
        Session.Remove("userid")
        Response.Redirect("default.aspx")
    End Sub

    Private Sub lnkProfile_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lnkProfile.Click
        Response.Redirect("profile.aspx")
    End Sub

    Private Sub lnkAdmin_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lnkAdmin.Click
        Response.Redirect("admin.aspx")
    End Sub

    Private Sub lnkCreateBoard_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles lnkCreateBoard.Click
        Response.Redirect("createboard.aspx")
    End Sub
End Class
