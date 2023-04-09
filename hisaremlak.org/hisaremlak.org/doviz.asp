<%
private function GetRates(strAbbreviation, strCurrency, intExtraChar)

	Const strDivider = " &nbsp;&nbsp; "

	Dim lngStartPosition
	Dim strBuying
	Dim strSelling
	Dim strEffectiveBuying
	Dim strEffectiveSelling
	Dim strBuildRates

	lngStartPosition = InStr(strContent, strAbbreviation)
	if lngStartPosition <> 0 then

		strBuying = Trim(Mid(strContent, lngStartPosition +38 -intExtraChar, 8))
		strSelling = Trim(Mid(strContent, lngStartPosition +51 -intExtraChar, 8))
		strEffectiveBuying = Trim(Mid(strContent, lngStartPosition +67 -intExtraChar, 8))
		strEffectiveSelling = Trim(Mid(strContent, lngStartPosition +80 -intExtraChar, 8))

		if strBuying <> "" then strBuildRates = strBuildRates & "<strong>Alýþ :</strong> " & strBuying & strDivider
		if strSelling <> "" then strBuildRates = strBuildRates & "<strong>Satýþ :</strong> " & strSelling & strDivider

	end if

	'Return
	GetRates = strBuildRates

end function
%>

<%
Const strSourceURL = "http://www.tcmb.gov.tr/kurlar/today.html"

'Dim objAspTear
Dim strContent
Dim objXmlHttp
Dim strBuildRatesHTML

Set objXmlHttp = Server.CreateObject("Msxml2.XMLHTTP" )
objXmlHttp.Open "Get", strSourceURL, false
objXmlHttp.Send
strContent = objXmlHttp.ResponseText
Set objXmlHttp = Nothing

'Set objAspTear = Server.CreateObject("Softwing.AspTear")
'strContent = objAspTear.Retrieve(strSourceURL, 2, "", "", "")  
'Set objAspTear = Nothing

strBuildRatesHTML = GetRates("EUR", "EURO", 0) &" <br>"
strBuildRatesHTML = strBuildRatesHTML & GetRates("USD", "DOLAR", 0)

%>
<%=strBuildRatesHTML%>