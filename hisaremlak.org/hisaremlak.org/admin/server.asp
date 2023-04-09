<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>Emlak Portalı - Yönetim Bölümü</title>
<link href="stil.css" rel="stylesheet" type="text/css">
<style>
.smText {
	font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
	color : #000000;
	font-size: 12px;
	font-weight: normal;
}
.smbText {
	font-family: Tahoma,Verdana, Arial, Helvetica, sans-serif;
	color : #0000FF;
	font-size: 12px;
	font-weight: normal;
}
.smrText {
	font-family: Tahoma,Verdana, Arial, Helvetica, sans-serif;
	color : #FF0000;
	font-size: 12px;
	font-weight: normal;
}
</style>
</head>

<body>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="4" class="tablogri2">
  <tr>
    <td valign="top" class="tablogri4"><!-- #include file = "menu.asp" --></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><table width="100%"  border="0" cellpadding="4" cellspacing="4" class="tablogri4">
      <tr>
        <td width="9%" height="55" class="tablogri3"><div align="center" class="baslik"><img src="images/icon5.gif" width="44" height="38"></div></td>
        <td width="91%" class="tablogri2"><span class="baslik">SERVER TEST </span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%"  border="0" cellpadding="0" cellspacing="2" class="vurgu">
            <tr valign="top">
              <td width="100%" height="28"><div align="justify" class="standart">Dosyalarınızın host edildiği sunucuya ait bilgileri aşağıda görebilirsiniz. </div></td>
            </tr>
            <tr valign="top">
              <td><%
	Dim emailList(4), uploadList(4), otherList(2), wLCID(124), inCount, rLang
	emailList(0) = Array( "ASP Mail","SMTPsvg.Mailer","N","Email" )
	emailList(1) = Array( "CDO NTS","CDONTS.NewMail","N","Email" )
	emailList(2) = Array( "CDOSYS","CDO.Message","N","Email" )
	emailList(3) = Array( "Dimac JMail","JMail.Message","N","Email" )
	emailList(4) = Array( "Persits ASPEmail","Persits.MailSender","N","Email" )
	uploadList(0) = Array( "ASP Simple Upload","ASPSimpleUpload.Upload","N","Upload" )
	uploadList(1) = Array( "ASP Smart Upload","aspSmartUpload.SmartUpload","N","Upload" )
	uploadList(2) = Array( "Dundas Upload","Dundas.Upload.2","N","Upload" )
	uploadList(3) = Array( "Persits File Upload","Persits.Upload.1","N","Upload" )
	uploadList(4) = Array( "Soft Artisans File Upload","SoftArtisans.FileUp","N","Upload" )
	otherList(0) = Array( "ActiveX Data Object","ADODB.Connection","Y" ,"Required for Database Operations")
	otherList(1) = Array( "File System Object","Scripting.FileSystemObject","Y", "Required for Upload Operations" )
	otherList(2) = Array( "Microsoft XML Engine","Microsoft.XMLDOM","N","Required for XML Operations" )
    wLCID(0) = Array( 1078,"Afrikaans","af" )
    wLCID(1) = Array( 1052,"Albanian","sq" )
    wLCID(2) = Array( 1025,"Arabic(Saudi Arabia)","ar-sa" )
    wLCID(3) = Array( 2049,"Arabic(Iraq)","ar-iq" )
    wLCID(4) = Array( 3073,"Arabic(Egypt)","ar-eg" )
    wLCID(5) = Array( 4097,"Arabic(Libya)","ar-ly" ) 
    wLCID(6) = Array( 5121,"Arabic(Algeria)","ar-dz" )
    wLCID(7) = Array( 6145,"Arabic(Morocco)","ar-ma" ) 
    wLCID(8) = Array( 7169,"Arabic(Tunisia)","ar-tn" )
    wLCID(9) = Array( 8193,"Arabic(Oman)","ar-om" ) 
    wLCID(10) = Array( 9217,"Arabic(Yemen)","ar-ye" )
    wLCID(11) = Array( 10241,"Arabic(Syria)","ar-sy" ) 
    wLCID(12) = Array( 11265,"Arabic(Jordan)","ar-jo" ) 
    wLCID(13) = Array( 12289,"Arabic(Lebanon)","ar-lb" ) 
    wLCID(14) = Array( 13313,"Arabic(Kuwait)","ar-kw" ) 
    wLCID(15) = Array( 14337,"Arabic(U.A.E.)","ar-ae" ) 
    wLCID(16) = Array( 15361,"Arabic(Bahrain)","ar-bh" ) 
    wLCID(17) = Array( 16385,"Arabic(Qatar)","ar-qa" ) 
    wLCID(18) = Array( 1069,"Basque","eu" ) 
    wLCID(19) = Array( 1026,"Bulgarian","bg" ) 
    wLCID(20) = Array( 1059,"Belarusian","be" ) 
    wLCID(21) = Array( 1027,"Catalan","ca" ) 
    wLCID(22) = Array( 1028,"Chinese(Taiwan)","zh-tw" ) 
    wLCID(23) = Array( 2052,"Chinese(PRC)","zh-cn" ) 
    wLCID(24) = Array( 3076,"Chinese(Hong Kong)","zh-hk" ) 
    wLCID(25) = Array( 4100,"Chinese(Singapore)","zh-sg" ) 
    wLCID(26) = Array( 1050,"Croatian","hr" )
    wLCID(27) = Array( 1029,"Czech","cs" ) 
    wLCID(28) = Array( 1030,"Danish","da" ) 
    wLCID(29) = Array( 1043,"Dutch(Standard)","n" ) 
    wLCID(30) = Array( 2067, "Dutch(Belgian)","nl-be" ) 
    wLCID(31) = Array( 9,"English","en" ) 
    wLCID(32) = Array( 1033,"English(United States)","en-us" ) 
    wLCID(33) = Array( 2057,"English(British)","en-gb" ) 
    wLCID(34) = Array( 3081,"English(Australian)","en-au" ) 
    wLCID(35) = Array( 4105,"English(Canadian)","en-ca" ) 
    wLCID(36) = Array( 5129,"English(New Zealand)","en-nz" ) 
    wLCID(37) = Array( 6153,"English(Ireland)","en-ie" ) 
    wLCID(38) = Array( 7177,"English(South Africa)","en-za" ) 
    wLCID(39) = Array( 8201,"English(Jamaica)","en-jm" ) 
    wLCID(40) = Array( 9225,"English(Caribbean)","en" ) 
    wLCID(41) = Array( 10249,"English(Belize)","en-bz" ) 
    wLCID(42) = Array( 11273,"English(Trinidad)","en-tt" ) 
    wLCID(43) = Array( 1061,"Estonian","et" ) 
    wLCID(44) = Array( 1080,"Faeroese","fo" ) 
    wLCID(45) = Array( 1065,"Farsi","fa" ) 
    wLCID(46) = Array( 1035,"Finnish","fi" ) 
    wLCID(47) = Array( 1036,"French(Standard)","fr" ) 
    wLCID(48) = Array( 2060,"French(Belgian)","fr-be" ) 
    wLCID(49) = Array( 3084,"French(Canadian)","fr-ca" ) 
    wLCID(50) = Array( 4108,"French(Swiss)","fr-ch" ) 
    wLCID(51) = Array( 5132,"French(Luxembourg)","fr-lu" ) 
    wLCID(52) = Array( 1071,"FYRO Macedonian","mk" ) 
    wLCID(53) = Array( 1084,"Gaelic(Scots)","gd" ) 
    wLCID(54) = Array( 2108,"Gaelic(Irish)","gd-ie" ) 
    wLCID(55) = Array( 1031,"German(Standard)","de" ) 
    wLCID(56) = Array( 2055,"German(Swiss)","de-ch" ) 
    wLCID(57) = Array( 3079,"German(Austrian)","de-at" ) 
    wLCID(58) = Array( 4103,"German(Luxembourg)","de-lu" ) 
    wLCID(59) = Array( 5127,"German(Liechtenstein)","de-li" ) 
    wLCID(60) = Array( 1032,"Greek ","e" )
    wLCID(61) = Array( 1037,"Hebrew","he" ) 
    wLCID(62) = Array( 1081,"Hindi","hi" ) 
    wLCID(63) = Array( 1038,"Hungarian","hu" ) 
    wLCID(64) = Array( 1039,"Icelandic","is" ) 
    wLCID(65) = Array( 1057,"Indonesian","in" ) 
    wLCID(66) = Array( 1040,"Italian(Standard)","it" ) 
    wLCID(67) = Array( 2064,"Italian(Swiss)","it-ch" ) 
    wLCID(68) = Array( 1041,"Japanese","ja" ) 
    wLCID(69) = Array( 1042,"Korean","ko" ) 
    wLCID(70) = Array( 2066,"Korean(Johab)","ko" ) 
    wLCID(71) = Array( 1062,"Latvian","lv" ) 
    wLCID(72) = Array( 1063,"Lithuanian","lt" ) 
    wLCID(73) = Array( 1086,"Malaysian","ms" ) 
    wLCID(74) = Array( 1082,"Maltese","mt" ) 
    wLCID(75) = Array( 1044,"Norwegian(Bokmal)","no" ) 
    wLCID(76) = Array( 2068,"Norwegian(Nynorsk)","no" ) 
    wLCID(77) = Array( 1045,"Polish","p" ) 
    wLCID(78) = Array( 1046,"Portuguese(Brazil)","pt-br" ) 
    wLCID(79) = Array( 2070,"Portuguese(Portugal)","pt" ) 
    wLCID(80) = Array( 1047,"Rhaeto-Romanic","rm" ) 
    wLCID(81) = Array( 1048,"Romanian","ro" ) 
    wLCID(82) = Array( 2072,"Romanian(Moldavia)","ro-mo" ) 
    wLCID(83) = Array( 1049,"Russian","ru" ) 
    wLCID(84) = Array( 2073,"Russian(Moldavia)","ru-mo" ) 
    wLCID(85) = Array( 1083,"Sami(Lappish)","sz" ) 
    wLCID(86) = Array( 3098,"Serbian(Cyrillic)","sr" ) 
    wLCID(87) = Array( 2074,"Serbian(Latin)","sr" ) 
    wLCID(88) = Array( 1051,"Slovak","sk" ) 
    wLCID(89) = Array( 1060,"Slovenian","s" ) 
    wLCID(90) = Array( 1070,"Sorbian","sb" ) 
    wLCID(91) = Array( 1034,"Spanish(Spain - Traditional Sort)","es" ) 
    wLCID(92) = Array( 2058,"Spanish(Mexican)","es-mx" ) 
    wLCID(93) = Array( 3082,"Spanish(Spain - Modern Sort)","es" ) 
    wLCID(94) = Array( 4106,"Spanish(Guatemala)","es-gt" ) 
    wLCID(95) = Array( 5130,"Spanish(Costa Rica)","es-cr" ) 
    wLCID(96) = Array( 6154,"Spanish(Panama)","es-pa" )
    wLCID(97) = Array( 7178,"Spanish(Dominican Republic)","es-do" ) 
    wLCID(98) = Array( 8202,"Spanish(Venezuela)","es-ve" )
    wLCID(99) = Array( 9226,"Spanish(Colombia)","es-co" )
    wLCID(100) = Array( 10250,"Spanish(Peru)","es-pe" )
    wLCID(101) = Array( 11274,"Spanish(Argentina)","es-ar" ) 
    wLCID(102) = Array( 12298,"Spanish(Ecuador)","es-ec" )
    wLCID(103) = Array( 13322,"Spanish(Chile)","es-c" )
    wLCID(104) = Array( 14346,"Spanish(Uruguay)","es-uy" )
    wLCID(105) = Array( 15370,"Spanish(Paraguay)","es-py" )
    wLCID(106) = Array( 16394,"Spanish(Bolivia)","es-bo" )
    wLCID(107) = Array( 17418,"Spanish(El Salvador)","es-sv" ) 
    wLCID(108) = Array( 18442,"Spanish(Honduras)","es-hn" )
    wLCID(109) = Array( 19466,"Spanish(Nicaragua)","es-ni" )
    wLCID(110) = Array( 20490,"Spanish(Puerto Rico)","es-pr" )
    wLCID(111) = Array( 1072,"Sutu","sx" )
    wLCID(112) = Array( 1053,"Swedish","sv" )
    wLCID(113) = Array( 2077,"Swedish(Finland)","sv-fi" )
    wLCID(114) = Array( 1054,"Thai","th" )
    wLCID(115) = Array( 1073,"Tsonga","ts" )
    wLCID(116) = Array( 1074,"Tswana","tn" )
    wLCID(117) = Array( 1055,"Turkish","tr" )
    wLCID(118) = Array( 1058,"Ukrainian","uk" )
    wLCID(119) = Array( 1056,"Urdu","ur" )
    wLCID(120) = Array( 1075,"Venda","ve" )
    wLCID(121) = Array( 1066,"Vietnamese","vi" )
    wLCID(122) = Array( 1076,"Xhosa","xh" )
    wLCID(123) = Array( 1085,"Yiddish","ji" )
    wLCID(124) = Array( 1077,"Zulu","zu" )
	Function checkObject( comIdentity )
		On Error Resume Next
		checkObject = False
		Err = 0
		Set xTestObj = Server.CreateObject( comIdentity )
		If Err = 0 Then checkObject = True
		Set xTestObj = Nothing
		Err = 0
	End Function
	Public Function CheckCOM(byVal comList, byRef inCount)
		Dim strTxt
		strTxt = ""
		inCount = 0
		For Idx = LBound( comList ) To UBound( comList )
			Provider = Idx
			If checkObject( comList(Idx)(1) ) Then
				strTxt = strTxt & vbTab & "<tr><td class=smtext>" & comList(Idx)(0) & "</font></td>" & VbCrlf
				strTxt = strTxt & "<td class=smbText>OK ( " & comList(Idx)(3) & " )</td>" & VbCrlf
				inCount = inCount + 1
			Else
				strTxt = strTxt & vbTab & "<tr><td class=smtext>" & comList(Idx)(0) & "</td>" & VbCrlf
				strTxt = strTxt & "<td class=smrText>Not Installed ( " & comList(Idx)(3) & " )</td>" & VbCrlf
			End If
		Next
		strTxt = strTxt & "</tr>" & VbCrlf
		CheckCOM = strTxt
	End Function
	SUB ShowServerVars()
		On Error Resume Next
		Response.Write "<tr>" & VbCrlf
		Response.Write "<td colspan=2 class=tablogri2><b>Server Variables</b></td>" & VbCrlf
		Response.Write "</tr>" & VbCrlf
		s=""
		For Each Key In Request.ServerVariables
			If Request.ServerVariables(Key)<>"" Then
				If Ucase(Key)="AUTH_PASSWORD" Then 
					t=String(len(Request.ServerVariables(Key)),"*") 
				Else 
					t=Request.ServerVariables(Key) 
					If Instr(1 ,Key,"ALL_",1)<>1 AND Instr(1 ,Key,"HTTP_AUTHORIZATION",1)=0 Then 
						s = s & "<tr><td valign=top class=smtext>" & Key & "</td>" & VbCrlf
						s = s & "<td valign=top class=smbtext>" & t & "</td></tr>#@#" & VbCrlf
					End If
				End If
			End If
		Next
		a=Split(s,"#@#")
		a=QuickSort(a,0,UBound(a))
		Response.Write Join(a,VbCrlf)
	End Sub
	Function QuickSort(Arr,loBound,hiBound)
		If hiBound - loBound = 1 then
			If Arr(loBound) > Arr(hiBound) then
				temp=Arr(loBound)
				Arr(loBound) = Arr(hiBound)
				Arr(hiBound) = temp
			End If
		End If
		pivot = Arr(int((loBound + hiBound) / 2))
		Arr(int((loBound + hiBound) / 2)) = Arr(loBound)
		Arr(loBound) = pivot
		loSwap = loBound + 1
		hiSwap = hiBound
		Do 
		While loSwap < hiSwap and Arr(loSwap) <= pivot
			loSwap = loSwap + 1
		Wend
		While Arr(hiSwap) > pivot
			hiSwap = hiSwap - 1
		Wend
		If loSwap < hiSwap then
			temp = Arr(loSwap)
			Arr(loSwap) = Arr(hiSwap)
			Arr(hiSwap) = temp
		End If
		Loop while loSwap < hiSwap
			Arr(loBound) = Arr(hiSwap)
			Arr(hiSwap) = pivot
			If loBound < (hiSwap - 1) then 
				Call QuickSort(Arr,loBound,hiSwap-1)
			End If
			If hiSwap + 1 < hibound then 
				Call QuickSort(Arr,hiSwap+1,hiBound)
			End If
		QuickSort=Arr
	End Function
	Function CheckMDAC
		On Error Resume Next
		Set obj=Server.CreateObject("ADODB.Connection")
		CheckMDAC=CheckMDAC & "<td class=smtext>MDAC (require 2.7)</td>" & VbCrlf
		If obj.version < "2.7" Then 
			CheckMDAC=CheckMDAC & " <td class=smrtext>Your Version " & obj.version & "&nbsp;(Needs updating!)<td>" & VbCrlf
		Else 
			CheckMDAC=CheckMDAC & " <td class=smbtext>Your Version " & obj.version & "&nbsp;(OK)<td>" & VbCrlf
		End if
		Set obj=Nothing
	End Function
	Function SetLCID(byRef rLang)
		Dim wLang, wPos, rCount
		wlang = Request.ServerVariables("HTTP_ACCEPT_LANGUAGE")
		wPos = InStr(1 , wLang,",")
		If wPos > 0 Then
			wLang = Left(wLang, wPos - 1)
		End If
		For rCount = 0 to UBound(wLCID)
			If LCase(wLang) = wLCID(rCount)(2) Then
				SetLCID = wLCID(rCount)(0)
				rLang = wLCID(rCount)(1)
				Exit Function
			End If
		Next
	End Function
	Response.write "<table border=0 width=100% cellpadding=1 cellspacing=3 align=left>" & VbCrlf
	Response.Write "<tr>" & VbCrlf
	Response.Write "<td colspan=2 class=tablogri2><b>Components</b></td>" & VbCrlf
	Response.Write "</tr>" & VbCrlf	
	Response.Write( CheckCOM(emailList,inCount) ) 
	If inCount = 0 Then
		Response.Write "<tr>" & VbCrlf
		Response.Write "<td colspan=2 class=smrText><b>At Least one Component is Required for Emailing</b></td>" & VbCrlf
		Response.Write "</tr>" & VbCrlf
	End If
	Response.Write( CheckCOM(uploadList,inCount) )
	If inCount = 0 Then
		Response.Write "<tr>" & VbCrlf
		Response.Write "<td colspan=2 class=smrText><b>At Least one Component is Required for Uploading</b></td>" & VbCrlf
		Response.Write "</tr>" & VbCrlf
	End If
	Response.Write( CheckCOM(otherList,inCount) )
	Response.Write "</tr>" & VbCrlf	
	Response.Write "<tr>" & VbCrlf
	Response.Write CheckMDAC
	Response.Write "</tr>" & VbCrlf	
	Response.Write "<tr>" & VbCrlf
	Response.Write "<td class=smText>" & ScriptEngine & " ( require 5.6 )</td>" & VbCrlf
	Response.Write "<td class=smbText>" & "Your Server Version " & ScriptEngineMajorVersion & "." & ScriptEngineMinorVersion & "." & ScriptEngineBuildVersion 
	If ScriptEngineMajorVersion & "." & ScriptEngineMinorVersion < "5.6" Then
		Response.Write " ( Needs Updating )"
	Else
		Response.Write " ( OK )"
	End If
	Response.Write "</td>" & VbCrlf
	Response.Write "</tr>" & VbCrlf
	Response.Write "<tr>" & VbCrlf
	Response.Write "<td class=smText>Browser LCID:</td>" & VbCrlf
	Response.Write "<td class=smbText>" & SetLCID(rLang) & "</td>" & VbCrlf
	Response.Write "</tr>" & VbCrlf
	Response.Write "<tr>" & VbCrlf
	Response.Write "<td class=smText>Server LCID:</td>" & VbCrlf
	response.write "<td class=smbText>" & session.lcid & "</td>" & VbCrlf
	Response.Write "</tr>" & VbCrlf
	call ShowServerVars()
	Response.Write "</table>" & VbCrlf
on error goto 0
%></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" class="tablogri4"><div align="center"><span class="standart">DCEmlak 2007© Gürkan KARA tarafından programlanmıştır. gurkan@designcube.net </span></div></td>
  </tr>
</table>
</body>
</html>
