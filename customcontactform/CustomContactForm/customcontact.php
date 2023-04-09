<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
	  	<title>Custom Contact Form</title>
	</head>
<DIV ALIGN="center"><BODY background="backgroundbluelight.gif">
<TABLE BGCOLOR="#FFFFFF" BORDER="1" CELLSPACING="0" CELLPADDING="10" BORDERCOLOR="#000080">
<TR>
	<TD>
<h2 align="left">Custom Contact Form</h2>
<!-- change above headers to your liking -->
<DIV ALIGN="right"><form action="contactprocess.php" method="post">
Name: <input type="text" name="name" size="30" maxlength="30"><br>
Email: <input type="text" name="email" size="30" maxlength="30"><br>
Subject: <input type="text" name="subject" size="30" maxlength="30"><br>
<hr>
<!-- change the words Question # & Optional Text to your liking -->
Question 1: <input type="text" name="text1" value="Optional Text" size="15" maxlength="20"><br>
Question 2: <input type="text" name="text2" value="Optional Text" size="15" maxlength="20"><br>
Question 3: <input type="text" name="text3" value="Optional Text" size="15" maxlength="20"><br>
Question 4: <input type="text" name="text4" value="Optional Text" size="15" maxlength="20"><br>
Question 5: <input type="text" name="text5" value="Optional Text" size="15" maxlength="20"><br>
<!-- Add more Questions here. Be sure to change the "name=" value to "6" etc, & add to "contactprocess.php" -->
Message: <textarea name="message" rows=4 cols=25></textarea><br><br>
</DIV>

<input type="submit" name="submit" value="Send">
</form>
</TD>
</TR>
</TABLE>
<!-- Authors Link --> 
<font size="-2"><A HREF="http://www.mikemason.org">Custom Contact Form</A></font>
<!-- -->
</DIV>
</body>
</html>