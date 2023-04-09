<!--#Include File="DSN_Connection.asp"-->
<!--#Include File="utility.asp"-->
<%

	'-------------------------------------------
	'Clicksee AdNow V 2.0
	'Product by http://www.clickseeadnow.com
	'Last modifed 8/3/2000
	'-------------------------------------------
	
	DIM adnowConn
	Const EmailServerName=""
	
	IF NOT Isobject(adnowConn) THEN
		
		SET adnowConn=Server.CreateObject ("ADODB.Connection")

		IF DSNad<>EMPTY THEN
			adnowConn.Open DSNad,uid,pwd
		ELSE
			Session("MSG")="Please set the program."
		END IF
		
	END IF
	
	IF instr(lcase(Request.ServerVariables ("SCRIPT_NAME")),"admin.asp")=0 AND instr(lcase(Request.ServerVariables ("SCRIPT_NAME")),"default.asp")=0 AND Session("MSG")=EMPTY THEN
		keepUser
	END IF
	
	'-------------------------------------------
	'Keep User.

	SUB keepUser

		IF Session("UserName")<>EMPTY AND Session("Password")<>EMPTY THEN
			SQL="select * from admin where Username='" &_
						encode(session("username")) & "' and password='" &_
						encode(session("password")) & "'"
			SET SearchAC=adnowConn.Execute (SQL)
			IF SearchAC.EOF THEN
				SearchAC.close
				SQL="select * from admin where Username='" &_
							(session("username")) & "' and password='" &_
							(session("password")) & "'"
				SET SearchAC=adnowConn.Execute (SQL)
				IF SearchAC.EOF THEN
					SearchAC.close
					EndSession
					Response.Redirect "default.asp"
				END IF
			End IF
		ELSE
				EndSession
				Response.Redirect "default.asp"
		END IF

	END SUB

	'-------------------------------------------
	'First Come.
	
	SUB CheckFirst
	DIM adnowConn
	
	SET adnowConn=Server.CreateObject ("ADODB.Connection")
	adnowConn.Open DSNad,uid,pwd
	
	SET AdminRs=adnowConn.Execute ("Select * from admin")
		IF AdminRs.EOF THEN
			PrintLn("<TR>")
			PrintLn("<TD bgcolor=""#CCCCCC"" align=""right""><p><font size=""-2"" face=""Verdana"">Confirm Password:</font></p></TD>")
			PrintLn("<TD bgcolor=""#CCCCCC""><INPUT type=""password"" name=password2></TD>")
			PrintLn("</TR>")
			PrintLn("<TR>")
			Response.Write "<TD colspan=""2"" align=""center""><TEXTAREA rows=20 cols=40 id=textarea1 name=textarea1>" &_
"License Agreement"&vbCrlf&vbCrlf&_
"Clicksee Network Co., Ltd. (""Clicksee Network"") and its suppliers " &vbCrlf&_
"provide computer software products contained in the download file " &vbCrlf&_
"(the ""Software"") and the associated documentation contained in the " &vbCrlf&_
"download file (the ""Documentation"") and license their use under " &vbCrlf&_
"the terms set forth herein. You assume responsibility for the " &vbCrlf&_
"selection of the Software to achieve your intended results, and " &vbCrlf&_
"for the installation, use and result obtained from the Software." &vbCrlf&vbCrlf&_
"1. You are granted a personal, non-transferable and non-exclusive "&vbCrlf&_
"license to use one copy of the Software on each of a single domain "&vbCrlf&_
"and to use the Documentation under the terms stated in this "&vbCrlf&_
"Agreement. Title and ownership of the Software and Documentation "&vbCrlf&_
"remain in Clicksee Network or its suppliers."&vbCrlf&vbCrlf&_
"2. You, your employees, and/or agents may not distribute or "&vbCrlf&_
"otherwise make the Software or Documentation available to any "&vbCrlf&_
"third party."&vbCrlf&vbCrlf&_
"3. You may not assign, sublicense or transfer this license and may "&vbCrlf&_
"not decompile, reverse engineer, modify, or copy the Software or "&vbCrlf&_
"Documentation for any purpose, except you may copy the Software "&vbCrlf&_
"into machine readable or printed form for backup purposes in "&vbCrlf&_
"support of your use of the Software on each of a single domain."&vbCrlf&vbCrlf&_
"4. The Software and Documentation are copyrighted by Clicksee "&vbCrlf&_
"Network and/or its suppliers. You agree to respect and not to "&vbCrlf&_
"remove or conceal from view any copyright, trademark or "&vbCrlf&_
"confidentiality notices appearing on the Software or "&vbCrlf&_
"Documentation, and to reproduce any such copyright, trademark or "&vbCrlf&_
"confidentiality notices on all copies of the Software and "&vbCrlf&_
"Documentation or any portion thereof made by you as permitted "&vbCrlf&_
"hereunder and on all portions contained in or merged into other "&vbCrlf&_
"computer software products and documentation."&vbCrlf&vbCrlf&_
"YOU MAY NOT USE, COPY, MODIFY, OR TRANSFER THE SOFTWARE OR "&vbCrlf&_
"DOCUMENTATION, OR ANY COPY, MODIFICATION OR MERGED PORTION, IN "&vbCrlf&_
"WHOLE OR IN PART, EXCEPT AS EXPRESSLY PROVIDED FOR IN THIS "&vbCrlf&_
"LICENSE. IF YOU TRANSFER POSSESSION OF ANY COPY, MODIFICATION OR "&vbCrlf&_
"MERGED PORTION OF THE SOFTWARE OR DOCUMENTATION TO ANOTHER PARTY, "&vbCrlf&_
"YOUR LICENSE IS AUTOMATICALLY TERMINATED."&vbCrlf&_
"TERMINATION "&vbCrlf&vbCrlf&_
"This license is effective until terminated. You may terminate it "&vbCrlf&_
"at any time by destroying the Software and Documentation with all "&vbCrlf&_
"copies, modifications and merged portions in any form. It will "&vbCrlf&_
"also terminate upon conditions set forth elsewhere in this "&vbCrlf&_
"Agreement if you fail to comply with any term or condition of this "&vbCrlf&_
"Agreement. You agree upon such termination to destroy the Software "&vbCrlf&_
"and Documentation together with all copies, modifications and "&vbCrlf&_
"merged portions in any form. "&vbCrlf&vbCrlf&_
"LIMITED WARRANTY "&vbCrlf&_
"Except as specifically provided herein, Clicksee Network makes no "&vbCrlf&_
"warranty, representation, promise or guarantee, either express or "&vbCrlf&_
"implied, statutory or otherwise, with respect to the Software, "&vbCrlf&_
"Documentation or related technical support, including their "&vbCrlf&_
"quality, performance, merchantability or fitness for a particular "&vbCrlf&_
"purchase. The warranty and remedies set forth herein are exclusive "&vbCrlf&_
"and in lieu of all others, oral or written, express or implied. No "&vbCrlf&_
"Clicksee Network dealer, distributor, agent or employee is "&vbCrlf&_
"authorized to make any modification or addition to this warranty."&vbCrlf&vbCrlf&_
"LIMITATION OF LIABILITY "&vbCrlf&_
"TO THE MAXIMUM EXTENT PERMITTED BY APPLICABLE LAW, IN NO EVENT, "&vbCrlf&_
"SHALL CLICKSEE NETWORK CO., LTD. OR ITS SUPPLIERS OR RESELLERS BE "&vbCrlf&_
"LIABLE TO YOU OR ANY OTHER PERSON FOR ANY INDIRECT, SPECIAL, "&vbCrlf&_
"INCIDENTAL, OR CONSEQUENTIAL DAMAGES OF ANY CHARACTER INCLUDING, "&vbCrlf&_
"WITHOUT LIMITATION, DAMAGES FOR LOSS OF GOODWILL, WORK STOPPAGE, "&vbCrlf&_
"COMPUTER FAILURE OR MALFUNCTION, OR ANY AND ALL OTHER COMMERCIAL "&vbCrlf&_
"DAMAGES OR LOSSES ARISING OUT OF THE USE OF OR INABILITY TO USE "&vbCrlf&_
"THE SOFTWARE, EVEN IF CLICKSEE NETWORK CO., LTD. HAS BEEN ADVISED "&vbCrlf&_
"OF THE POSSIBILITY OF SUCH DAMAGES.</TEXTAREA></TD></TR>"
		END IF
	adminRs.CLose
	
	END SUB

	'-------------------------------------------
	'Error Massage.
	
	Function ErrMSG
	
		IF Session("MSG")<>EMPTY THEN
			PrintLn("<div align=center><font color='#FFFFFF'>" & Session("MSG") & "</font></div>")
			Session("MSG")=Abandon
		END IF
	
	END Function

	'-------------------------------------------
	'End Program
	SUB EndSession
	
		FOR EACH Item IN Session.Contents
			IF lcase(Item)<>"username" AND lcase(Item)<>"password" AND lcase(Item)<>"msg" Then
				Session.Contents (Item)=Abandon
			END IF
		NEXT
		IF IsObject(adnowConn) THEN
			adnowConn.Close 
		END IF
		
	END SUB
	
	'-------------------------------------------

%>

<SCRIPT LANGUAGE=JScript RUNAT=Server>
function encode(str) {
	return escape(str);
}

function decode(str) {
	return unescape(str);
}
</SCRIPT>
