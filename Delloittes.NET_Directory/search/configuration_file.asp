<%

'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' deloittes.NET - Configuration file
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Option Explicit ' make sure we declare all variables throughout application

'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Specify which database to use. Access / SQLServer
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	Dim DatabaseType, MyConnStr 
		
	DatabaseType = "Access" ' uncomment to use Microsoft Access database
	'DatabaseType = "SQLServer" ' uncomment to use SQL Server database
	
	if DatabaseType = "Access" then
		MyConnStr = "Provider=Microsoft.Jet.OLEDB.4.0; Data Source=C:\Inetpub\Databases\search\database.mdb;"
	else
		MyConnStr = "PROVIDER=MSDASQL;DSN=deloittes_directory;DATABASE=deloittes.net_directory;UID=admin;PWD=admin;"
	end if
	
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Global URL to directory and administration pages.
' Replace these with your URLs.
' The URLs should have a forward slash at the end. /
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	Dim Path2Directory, Path2Admin	
		Path2Directory = "http://localhost/search/" 
		Path2Admin = "http://localhost/search/admin/" 
	
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Toggle SQL Statements for debugging purposes
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	Dim Debug
		Debug = False ' Set debug to a Boolean True / False to toggle SQL statements
	
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Specify where your company logo is
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Dim CompanyLogo
CompanyLogo = "images/logo.gif"

'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Date Stamp Used Throughout Application
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	Dim ShortDate, ShortDateIso
		ShortDate = FormatDateTime(now(),2) ' date stamp for access database
		ShortDateIso = IsoDate(FormatDateTime(now(),2)) ' ISO format date stamp for SQL Server
	
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' How many individual page links to show within the paging navigation. 
'
' 	intPGCount = 6 will display page links like:
' 	1 2 3 4 5 6 ... / ... 6 7 8 9 10 11 ...
' 	intPGCount = 8 will display page links like:
' 	1 2 3 4 5 6 7 8 ... / ... 8 9 10 11 12 13 14 15 ...
' 	intPGCount = 2 will display page links like:
' 	1 2 ... / ... 3 4 ... / ... 5 6 ...
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	Dim intPGCount, intPGCountMinus 
		intPGCount = 8 ' number of individual page links to show within paging navigation
		intPGCountMinus = (intPGCount - 1)
	
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' General Apperence Settings
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	Dim TableWidth, CellSpacing, CellPadding, Align
	Dim BorderWidth, BorderColor, BorderColorDark, BorderColorLight
	Dim CellBGColor, CellSpilt, FormBGColor
	
		TableWidth = "100%" ' 100% is default
		CellSpacing = "0"
		CellPadding = "7"
		BorderWidth = "0" ' 0 is default
		BorderColor = "#000000"
		BorderColorDark = "#00000"
		BorderColorLight = "#000000"
		CellBGColor = "#EEF0F3"
		CellSpilt = "#A8B1BC"
		FormBGColor = "#f8f8f8"

'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
' Grab global configuration settings from the del_Directory_Configuration table 
' and assign values to global variables for use throughout application
'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	Dim SQL, ConfigConnectionObj, ConfigurationRecords	
	Dim DirectoryName, EmailObject, SendEmailAfterLinkAddition, SendEmailAfterReviewSubmission, SendEmailAfterErrorSubmission
	Dim GlobalEmailAddress, MailServer, HowManyResourcesToShowInNewsletter	
	Dim HowManyNewLinksToShow, HowManyPopularLinksToShow, LinksPerPage, SearchResultsPerPage
	Dim NavigationSep, ShowSubCatAmount, NoOfFavoritesToShow

			' These settings cannot be personalised - grab default value
			
			SQL = "SELECT DirectoryName, EmailObjectToUse, SendEmailAfterLinkAddition, " &_
			"SendEmailAfterReviewSubmission, EmailAddress, MailServer, HowManyResourcesInNewsletter " &_
			"FROM del_Directory_Configuration WHERE ID = 1"
			
			if Debug = True then response.write SQL
			
			Set ConfigConnectionObj = Server.CreateObject("ADODB.Connection")
			ConfigConnectionObj.Open MyConnStr	
			Set ConfigurationRecords = ConfigConnectionObj.Execute(SQL)
			
			If ConfigurationRecords.EOF then
			Else
			
					' Global directory name
					DirectoryName = ConfigurationRecords("DirectoryName")
					' Email component to use for sending email	
					EmailObject = ConfigurationRecords("EmailObjectToUse")
					' Boolen to determine if to send an email notification for link submissions
					SendEmailAfterLinkAddition = ConfigurationRecords("SendEmailAfterLinkAddition")
					' Boolen to determine if to send an email notification for review submissions
					SendEmailAfterReviewSubmission = ConfigurationRecords("SendEmailAfterReviewSubmission")
					' Boolen to determine if to send an email notification for error submissions
					SendEmailAfterErrorSubmission = ConfigurationRecords("SendEmailAfterReviewSubmission")
					' string containing email address of person to alert for resource and review submissions
					GlobalEmailAddress = ConfigurationRecords("EmailAddress")
					' SMTP Server used to send emails
					MailServer = ConfigurationRecords("MailServer")
					' How many items to show in newsletter
					HowManyResourcesToShowInNewsletter = ConfigurationRecords("HowManyResourcesInNewsletter")
				
			End If
			
'-----------------------------------------------------------------------
' These settings can be personalised.
' Check for personalisation ID within cookie and grab values from database
'-----------------------------------------------------------------------
	
			SQL = "SELECT HowManyNewLinksToShow, HowManyPopularLinksToShow, LinksPerPage, " &_
			"SearchResultsPerPage, NavigationSeperator, ShowSubCategoryCount, HowManyFavoritesToShow " &_
			"FROM del_Directory_Configuration WHERE ID = "
			
				if request.cookies("personlisationID") <> "" then
					SQL = SQL & request.cookies("personlisationID")
				else
					SQL = SQL & "1"
				end if
				
			if Debug = True then response.write SQL

			Set ConfigurationRecords = ConfigConnectionObj.Execute(SQL)
			
				If ConfigurationRecords.EOF then
				
					' Determine how many new links to show on homepage
					HowManyNewLinksToShow = 10
					' Determine how many popular links to show on homepage
					HowManyPopularLinksToShow = 5
					' Determine how links we show per page on the directory pages
					LinksPerPage = 10
					' Determine how links we show per pgae on the search results page
					SearchResultsPerPage = 10
					' character to seperate navigation titles
					NavigationSep = ":"
					' Amount of sub categories to display under a main categories	
					ShowSubCatAmount = 6
					' How Many Favorites To Show On Homepage
					NoOfFavoritesToShow = 10
					
				Else	
				
					' Determine how many new links to show on homepage
					HowManyNewLinksToShow = cInt(ConfigurationRecords("HowManyNewLinksToShow")) + 1
					' Determine how many popular links to show on homepage
					HowManyPopularLinksToShow = cInt(ConfigurationRecords("HowManyPopularLinksToShow")) + 1
					' Determine how links we show per page on the directory pages
					LinksPerPage = cInt(ConfigurationRecords("LinksPerPage"))
					' Determine how links we show per pgae on the search results page
					SearchResultsPerPage = cInt(ConfigurationRecords("SearchResultsPerPage"))
					' character to seperate navigation titles
					NavigationSep = ConfigurationRecords("NavigationSeperator")
					' Amount of sub categories to display under a main categories	
					ShowSubCatAmount = cint(ConfigurationRecords("ShowSubCategoryCount"))
					' How Many Favorites To Show On Homepage
					NoOfFavoritesToShow = cInt(ConfigurationRecords("HowManyFavoritesToShow")) + 1
					
				End If
			
			ConfigConnectionObj.Close
			Set ConfigurationRecords = Nothing			
			Set ConfigConnectionObj = Nothing
			
			
Function GrabEmailFromDomain(Email)

	if Email <> "" then
	GrabEmailFromDomain = right(Email,len(Email) - instr(1,Email,"@"))
	else
	GrabEmailFromDomain = "yourdomain.com"
	end if

End Function

Function characterPad(strWord,chCharacter,chLOR,intTotal)
	
	dim intNumChars
	
	 intNumChars = intTotal - len(strWord) 
	 if intNumChars > 0 then  
	 	if chLOR="l" then 
		 	characterPad=string(intNumChars,chCharacter) & strWord   
		else    
			characterPad=strWord & string(intNumChars,chCharacter)   
		end if 
	 else   
	 	characterPad = strWord 
	 end if
 
End Function

Function ISODate(dtmDate)

	ISODate = year(dtmDate) & "-" & characterPad(month(dtmDate),"0","l",2) & "-" & characterPad(day(dtmDate),"0","l",2)

End Function


			


%>