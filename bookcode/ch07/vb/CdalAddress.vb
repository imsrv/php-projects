Option Explicit On 

Imports System
Imports System.Data
Imports System.Data.SqlClient
Imports System.Data.SqlTypes
Imports System.Data.OleDb

Public Class CdalAddress
    '// a conneciton string
    Private strConStr As String
    Private strError As String
    Private oConn As SqlConnection
    'Private oConn As OleDbConnection

    Public Property strConnection() As String
        Get
            Return strConStr
        End Get
        Set(ByVal Value As String)
            strConStr = Value
            Try
                oConn = New SqlConnection(Value)
                'oConn = New OleDbConnection(Value)
            Catch oleE As OleDbException
                Throw oleE
            Catch e As SqlException
                Throw e
            End Try
        End Set
    End Property



    Public Function getAll() As SqlDataReader
        'Public Function getAll() As OleDbDataReader
        Dim oCmd As SqlCommand
        'Dim oCmd As OleDbCommand
        Dim strSQL As String

        strSQL = "EXEC usp_tblAddress_sel"

        oCmd = New SqlCommand(strSQL, oConn)
        'oCmd = New OleDbCommand(strSQL, oConn)
        oCmd.CommandType = CommandType.Text

        Try
            If oConn.State = ConnectionState.Closed Then
                oConn.Open()
            End If
            Return oCmd.ExecuteReader
        Catch oErr As Exception
            Throw oErr
        End Try

    End Function

    Public Function getByID(ByVal AdrsID As Int32) As SqlDataReader
        Dim oCmd As SqlCommand
        Dim strSQL As String

        strSQL = "EXEC usp_tblAddress_sel_ByID " & AdrsID

        oCmd = New SqlCommand(strSQL, oConn)
        oCmd.CommandType = CommandType.Text

        Try
            If oConn.State = ConnectionState.Closed Then
                oConn.Open()
            End If
            Return oCmd.ExecuteReader
        Catch oErr As Exception
            Throw New Exception(oErr.ToString)


        End Try
    End Function


    Public Function Add(ByVal FName As String, _
                    ByVal LName As String, _
                    ByVal Phone As String, _
                    ByVal EMail As String, _
                    ByVal WebPage As String, _
                    ByVal Age As String, _
                    ByVal Comments As String) As Int32

        Dim oCmd As SqlCommand
        Dim oParam As SqlParameter
        Dim strSQL As String
        Dim AdrsID As Int32

        strSQL = "usp_tblAddress_ins"

        oCmd = New SqlCommand(strSQL, oConn)
        oCmd.CommandType = CommandType.StoredProcedure

        oParam = oCmd.Parameters.Add("@AdrsID", SqlDbType.Int, 4)
        oParam.Direction = ParameterDirection.Output

        oCmd.Parameters.Add("@FName", SqlDbType.VarChar, 50).Value = FName
        oCmd.Parameters.Add("@LName", SqlDbType.VarChar, 50).Value = LName
        oCmd.Parameters.Add("@Phone", SqlDbType.VarChar, 15).Value = Phone
        oCmd.Parameters.Add("@EMail", SqlDbType.VarChar, 255).Value = EMail
        oCmd.Parameters.Add("@WebPage", SqlDbType.VarChar, 255).Value = WebPage
        oCmd.Parameters.Add("@Age", SqlDbType.TinyInt, 2).Value = Age
        oCmd.Parameters.Add("@Comments", SqlDbType.VarChar, 2000).Value = Comments

        Try
            If oConn.State = ConnectionState.Closed Then
                oConn.Open()
            End If
            oCmd.ExecuteNonQuery()
            AdrsID = oCmd.Parameters("@AdrsID").Value
            Return AdrsID
        Catch oErr As Exception
            Throw oErr
        End Try

    End Function

    Public Function Update(ByVal AdrsID As Int32, _
                        ByVal FName As String, _
                        ByVal LName As String, _
                        ByVal Phone As String, _
                        ByVal EMail As String, _
                        ByVal WebPage As String, _
                        ByVal Age As String, _
                        ByVal Comments As String) As Int32

        Dim oConn As SqlConnection
        Dim oCmd As SqlCommand
        Dim oParam As SqlParameter
        Dim strSQL As String

        strSQL = "usp_tblAddress_upd"

        oConn = New SqlConnection(strConStr)
        oCmd = New SqlCommand(strSQL, oConn)
        oCmd.CommandType = CommandType.StoredProcedure
        oCmd.Parameters.Add("@AdrsID", SqlDbType.Int, 4).Value = AdrsID
        oCmd.Parameters.Add("@FName", SqlDbType.VarChar, 50).Value = FName
        oCmd.Parameters.Add("@LName", SqlDbType.VarChar, 50).Value = LName
        oCmd.Parameters.Add("@Phone", SqlDbType.VarChar, 15).Value = Phone
        oCmd.Parameters.Add("@EMail", SqlDbType.VarChar, 255).Value = EMail
        oCmd.Parameters.Add("@WebPage", SqlDbType.VarChar, 255).Value = WebPage
        oCmd.Parameters.Add("@Age", SqlDbType.TinyInt, 2).Value = Age
        oCmd.Parameters.Add("@Comments", SqlDbType.VarChar, 2000).Value = Comments

        Try
            If oConn.State = ConnectionState.Closed Then
                oConn.Open()
            End If
            oCmd.ExecuteNonQuery()
        Catch oErr As Exception
            Throw New Exception(oErr.ToString)

        End Try

    End Function

    Public Sub Delete(ByVal AdrsID As String)
        Dim oCmd As SqlCommand
        Dim strSQL As String

        strSQL = "EXEC usp_tblAddress_del " & AdrsID

        oCmd = New SqlCommand(strSQL, oConn)
        oCmd.CommandType = CommandType.Text

        Try
            If oConn.State = ConnectionState.Closed Then
                oConn.Open()
            End If
            oCmd.ExecuteNonQuery()
        Catch oErr As Exception
            Throw oErr

        End Try
    End Sub
End Class

