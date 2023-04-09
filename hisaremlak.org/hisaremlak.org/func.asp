<%
Public Function clearbadword(byVal strWords)
strBadWords = Array("SELECT", "DROP", ";", "--", "INSERT", "DELETE", "xp_", "UNION","'")
strBadWordsReplace = Array("&#83elect", "&#68rop", "&#59", "&#45-", "&#73nsert", "&#68elete", "&#120p&#95", "&#85nion","&#39")		
	For iSQL = 0 to uBound(strBadWords)
	strWords = Replace(strWords, strBadWords(iSQL), strBadWordsReplace(iSQL),1,-1,1)
	Next
clearbadword = strWords		
End Function


'MYSQL tarih formatlama
function mysqltarih(varDate)
if day(varDate) < 10 then
dd = "0" & day(varDate)
else
dd = day(varDate)
end if
if month(varDate) < 10 then
mm = "0" & month(varDate)
else
mm = month(varDate)
end if
mysqltarih = year(varDate) & mm & dd 
end function
%>