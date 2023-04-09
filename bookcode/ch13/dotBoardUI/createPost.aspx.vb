Public Class createPost
    Inherits FormBase
    Protected WithEvents pnlShowThread As System.Web.UI.WebControls.Panel
    Protected WithEvents lblBoardName As System.Web.UI.WebControls.Label
    Protected WithEvents Label1 As System.Web.UI.WebControls.Label
    Protected WithEvents txtThreadSubject As System.Web.UI.WebControls.TextBox
    Protected WithEvents Label2 As System.Web.UI.WebControls.Label
    Protected WithEvents TextBox1 As System.Web.UI.WebControls.TextBox
    Protected WithEvents btnCreatePost As System.Web.UI.WebControls.Button
    Protected WithEvents lblThreadName As System.Web.UI.WebControls.Label

    Private mBoard As dotBoardObjects.Board
    Private mThread As dotBoardObjects.Thread
    Private mBoardName As String
    Protected WithEvents ValidationSummary1 As System.Web.UI.WebControls.ValidationSummary
    Protected WithEvents valSubject As System.Web.UI.WebControls.RequiredFieldValidator
    Protected WithEvents valBody As System.Web.UI.WebControls.RequiredFieldValidator
    Private mThreadID As Long
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
        'only logged in users are allow in this page
        If Me.IsLoggedIn = False Then
            Response.Redirect("default.aspx")
        End If

        mBoardName = Request.Item("boardName")
        If Request.Item("threadId") Is Nothing Then
            mThreadID = 0
        Else
            mThreadID = CLng(Request.Item("threadId"))
        End If

        mBoard = New dotBoardObjects.board(mBoardName)
        lblBoardName.Text = mBoard.Name

        If mThreadID = 0 Then
            pnlShowThread.Visible = False
        Else
            pnlShowThread.Visible = True
            mThread = mBoard.ChildThread(mThreadID)
        End If

        If Not Me.IsPostBack Then
            'put the default values in the thread and board text boxes
            If mThreadID <> 0 Then
                txtThreadSubject.Text = mThread.Subject
                lblThreadName.Text = mThread.Subject
            End If
        End If

        Me.ApplyStyles(Me.Controls)
    End Sub

    Private Sub btnCreatePost_Click(ByVal sender As System.Object, _
        ByVal e As System.EventArgs) Handles btnCreatePost.Click
        If Me.IsValid = True Then
            If mThreadID <> 0 Then
                'we're adding a post to a thread. do nothing here
            Else
                'we're creating a new thread and adding a post
                mBoard.CreateThread(txtThreadSubject.Text, Me.CurrentUser)
                'let's find that thread. it will be the first one in the list
                mThread = mBoard.ChildThreads.Item(0)
            End If

            mThread.CreatePost(txtThreadSubject.Text, _
                TextBox1.Text, Me.CurrentUser)
            'redirect the user to the current thread
            Response.Redirect("thread.aspx?boardId=" & mBoardName & _
                "&threadId=" & mThread.ID.ToString())
        End If
    End Sub
End Class
