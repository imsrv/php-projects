Option Strict On

Imports System.Collections

Public Class ThreadList
    Private list As ArrayList
    Private mBoardID As Long

    Public Sub New(ByVal BoardID As Long)
        mBoardID = BoardID
        Me.InitializeThreads()
    End Sub

    Public Sub InitializeThreads()
        Dim myData As DataSet
        Dim sql As String
        sql = "SELECT [Threads].*, [Users].* FROM [Threads] " & _
            "INNER JOIN [Users] " & _
            "ON [Users].[UserID] = [Threads].[CreatorID] " & _
            "WHERE " & _
            "[BoardID] = " & mBoardID.ToString() & _
            " ORDER BY [Threads].[ThreadID] DESC"
        myData = DataControl.GetDataSet(sql)

        list = New ArrayList()

        Dim myRow As DataRow
        For Each myRow In myData.Tables(0).Rows
            list.Add(myRow)
        Next
    End Sub

    Public Function Item(ByVal index As Integer) As Thread
        Dim myObject As Object = list.Item(index)
        If myObject.GetType() Is GetType(Thread) Then
            'it is already a thread, so nothing further is needed
        Else
            Dim myThread As Thread
            myThread = New Thread(CType(list.Item(index), DataRow))
            'replace the item in the list with 
            'an actual thread object
            list.Item(index) = myThread
        End If

        Return CType(list.Item(index), Thread)
    End Function

    Public ReadOnly Property Count() As Integer
        Get
            Return list.Count
        End Get
    End Property
End Class
