Public Class deleteThread
    Inherits FormBase

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
        If Me.IsLoggedIn = True Then
            If Me.CurrentUser.IsAdmin = True Then
                Dim boardName As String
                Dim threadId As Long
                boardName = Request.QueryString.Item("boardName")
                threadId = CLng(Request.QueryString.Item("threadId"))

                Dim myBoard As dotBoardObjects.board
                myBoard = New dotBoardObjects.board(boardName)
                Dim myThread As dotBoardObjects.thread
                myThread = myBoard.ChildThread(threadId)

                myBoard.DeleteThread(myThread, Me.CurrentUser)
            End If
        End If

        Response.Redirect("default.aspx")
    End Sub

End Class
