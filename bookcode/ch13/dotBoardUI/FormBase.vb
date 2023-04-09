Option Strict Off

Imports System.Configuration
Imports System.Xml

Public Class FormBase
    Inherits System.Web.UI.Page

    Dim objXml As XmlDocument

    Private mCurrentUser As dotBoardObjects.User

    Public Property CurrentUser() As dotBoardObjects.User
        Get
            Return mCurrentUser
        End Get
        Set(ByVal Value As dotBoardObjects.User)
            mCurrentUser = Value
            'add the user's id to the session
            Session.Add("userid", Value.ID.ToString())
        End Set
    End Property

    Public Sub ApplyStyles(ByRef objControls As ControlCollection)
        If objXml Is Nothing Then
            Dim xmlLoc As String
            xmlLoc = ConfigurationSettings.AppSettings()("XmlConfigFile")
            objXml = New XmlDocument()
            Try
                objXml.Load(xmlLoc)
            Catch E As Exception
                Throw New Exception("XML Style Config file not found")
            End Try
        End If

        Dim objControl As Control
        For Each objControl In objControls
            Dim style As String
            style = GetStyleName(objControl.GetType.ToString())

            If style <> "" Then
                Dim objWebControl As WebControl
                objWebControl = CType(objControl, WebControl)
                'we only want to apply these styles if we
                'haven't already explicitly set them
                If objWebControl.CssClass.Trim() = "" Then
                    objWebControl.CssClass = style
                End If
            End If
            If objControl.HasControls() Then
                ApplyStyles(objControl.Controls)
            End If
        Next objControl
    End Sub

    Public Function GetStyleName(ByVal controlType As String) As String
        Dim objNode As XmlNode
        objNode = objXml.SelectSingleNode("styles/control[@type='" & _
            controlType & "']")
        If objNode Is Nothing Then
            'do nothing
            Return ""
        Else
            'get the css class specified by this node
            Return objNode.InnerText
        End If
    End Function

    Public ReadOnly Property IsLoggedIn() As Boolean
        Get
            Return Not mCurrentUser Is Nothing
        End Get
    End Property
End Class
