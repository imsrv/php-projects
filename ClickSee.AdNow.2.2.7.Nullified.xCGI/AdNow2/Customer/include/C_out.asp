<%
  'Clear Session (username & password) in case user logout
  'Increase security, others cannot view some pages inside customer section without login first 
	   Session("U") = Empty 
	   Session("P") = Empty
  
%>
