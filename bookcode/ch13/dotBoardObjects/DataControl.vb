Option Strict On

Imports System.Data
Imports System.Data.OleDb
Imports System.Configuration
Imports System.Collections.Specialized

Public Class DataControl
    Public Shared Function GetDataSet(ByVal SQL As String) As DataSet
        Dim connectionString As String
        Dim settings As ConfigurationSettings
        Dim appSettings As NameValueCollection

        appSettings = settings.AppSettings()
        connectionString = appSettings.Item("ConnectionString")

        Dim connection As New OleDbConnection(connectionString)
        connection.Open()

        Dim adapter As New OleDbDataAdapter(SQL, connection)
        Dim myData As New DataSet()

        adapter.Fill(myData, "data")
        adapter.Dispose()
        connection.Close()

        Return myData
    End Function

    Friend Shared Sub ExecuteNonQuery(ByVal SQL As String)
        Dim connectionString As String
        Dim settings As ConfigurationSettings
        Dim appSettings As NameValueCollection

        appSettings = settings.AppSettings()
        connectionString = appSettings.Item("ConnectionString")

        Dim connection As New OleDbConnection(connectionString)
        connection.Open()

        Dim myCommand As New OleDbCommand()
        myCommand.Connection = connection
        myCommand.CommandText = SQL
        myCommand.CommandType = CommandType.Text
        myCommand.ExecuteNonQuery()
        'clean up
        connection.Close()
        myCommand.Dispose()
        connection.Dispose()
    End Sub
End Class
