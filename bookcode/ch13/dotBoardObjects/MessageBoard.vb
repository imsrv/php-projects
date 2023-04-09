Option Strict On

Public Class MessageBoard
    Public Shared Function GetBoards() As ArrayList
        Dim list As New ArrayList()
        Dim sql As String
        Dim myData As DataSet
        Dim myRow As DataRow

        sql = "SELECT [BoardName] FROM [Board] ORDER BY [BoardName] Asc"
        myData = DataControl.GetDataSet(sql)

        For Each myRow In myData.Tables(0).Rows
            Dim myBoard As Board
            myBoard = New Board(CStr(myRow("BoardName")))
            list.Add(myBoard)
        Next myRow

        Return list
    End Function
End Class
