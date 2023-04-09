Option Strict On

Imports System.Collections

Public Class PostList
    Private list As ArrayList
    Private mThreadID As Long

    Public Sub New(ByVal ThreadID As Long)
        mThreadID = ThreadID
        Me.InitializePosts()
    End Sub

    Public Sub InitializePosts()
        Dim myData As DataSet
        Dim sql As String
        sql = "SELECT [Users].*, [Posts].* FROM " & _
            "[Posts] INNER JOIN [Users] " & _
            "ON [Users].[UserID] = [Posts].[CreatorID] " & _
            "WHERE " & _
            "[ThreadID] = " & mThreadID.ToString() & _
            " ORDER BY PostDate ASC"
        myData = DataControl.GetDataSet(sql)

        list = New ArrayList()

        Dim myRow As DataRow
        For Each myRow In myData.Tables(0).Rows
            list.Add(myRow)
        Next
    End Sub

    Public Function Item(ByVal index As Integer) As Post
        Dim myObject As Object = list.Item(index)
        If myObject.GetType() Is GetType(Post) Then
            'it is already a post, so nothing further is needed
        Else
            Dim myPost As Post
            myPost = New Post(CType(list.Item(index), DataRow))
            'replace the item in the list with 
            'an actual post object
            list.Item(index) = myPost
        End If

        Return CType(list.Item(index), Post)
    End Function

    Public ReadOnly Property Count() As Integer
        Get
            Return list.Count
        End Get
    End Property
End Class
