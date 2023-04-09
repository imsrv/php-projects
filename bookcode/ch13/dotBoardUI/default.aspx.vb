Public Class WebForm1
    Inherits FormBase
    Protected WithEvents Panel1 As System.Web.UI.WebControls.Panel
    Protected WithEvents Repeater1 As System.Web.UI.WebControls.Repeater

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
        Me.DisplayBoards()
    End Sub

    Private Sub DisplayBoards()
        Dim myBoards As DataSet = New DataSet()
        Dim list As ArrayList
        list = dotBoardObjects.MessageBoard.GetBoards()

        myBoards.Tables.Add("boards")
        Dim myTable As DataTable = myBoards.Tables(0)

        myTable.Columns.Add("BoardName", GetType(String))
        myTable.Columns.Add("BoardDescription", GetType(String))

        Dim i As Integer
        For i = 0 To list.Count - 1
            Dim myBoard As dotBoardObjects.Board
            myBoard = CType(list(i), dotBoardObjects.Board)
            Dim fields(1) As Object
            fields(0) = myBoard.Name
            fields(1) = myBoard.Description
            If Me.IsLoggedIn = True Then
                If Me.CurrentUser.IsAdmin = True Then
                    fields(1) &= "<br><br><a href='deleteBoard.aspx?boardName=" & _
                        myBoard.Name & "'>&gt;&gt;delete</a>"
                End If
            End If

            myTable.Rows.Add(fields)
            myTable.AcceptChanges()
        Next i

        myBoards.AcceptChanges()

        Repeater1.DataMember = "boards"
        Repeater1.DataSource = myBoards
        Repeater1.DataBind()
    End Sub

End Class
