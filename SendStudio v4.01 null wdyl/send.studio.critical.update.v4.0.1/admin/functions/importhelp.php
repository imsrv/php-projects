<?php

	@ob_start();

	include("../../includes/config.inc.php");
	include("../includes/templates.php");
	include("../includes/basic.inc.php");

	?>
		<html>
		<head>
		<title> Quick Start Guide </title>
		<?php OutputStyleSheet(); ?>
		</head>
		<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="60" class="menutop">
						<img src="<?php echo $ROOTURL; ?>admin/images/logo.gif" width=294 height=59 border=0>
						<div style="position:absolute; left:385; top:1">
							<a href="javascript:window.close()" class="topLink">[x] Close</a>
						</div>
					</td>
				</tr>
				<tr>
					<td height="160" background="<?php echo $ROOTURL; ?>admin/images/midbg.gif">
						<p style="margin-top:10; margin-left:30; margin-right:30">
							<span class="heading1"><br><i>Importing Subscribers: A Quick Tutorial</i></span>
							<br><br>
							If you already have an existing mailing list that you'd like to import, then follow these steps. Firstly, you will need to export your subscriber list from your other mailing program. You should export your subscriber list into a CSV (comma seperated value) file. A CSV file will contain a list of your subscribers details in a line-by-line format, such as:
							<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;user1@site.com,MALE,Y,20030101<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;user2@site.com,FEMALE,N,20031014<br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;user3@site.com,MALE,N,20020706
							<br><br>
							The example above includes three records, and each record is seperated with a new line. Each record contains four fields, and each field is seperated with a comma. The CSV file will typically have a .CSV or .TXT file extension. Start by clicking on the "Browse..." button in the form to select your CSV file from your hard drive.
							<br><br>
							Next, you will need to choose the newsletter format that your subscriber list should be flagged to receive. If you're going to create a text-based newsletter, then choose the text option. If you are going to create newsletters with rich text, images, links, etc, choose the HTML option.
							<br><br>
							Now comes the status field. Basically, you can have subscribers marked as active or inactive. When you come to send a newsletter, you can choose which type of subscribers (active or inactive) should receive it. Generally, you should choose the active option when importing your list of subscribers.
							<br><br>
							The "Field Seperator" character is used to specify how each field in your records is seperated. For example, if you have a line in your CSV file that looks like this:
							<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;user1@site.com,MALE,Y,20030101
							<br><br>
							.. then the field seperator would be the comma, as it seperates each field in the record. If you exported into a CSV file format, then a "record" is basically the content of a single line. Other popular field seperators include the space and semi-colon characters. You should enter the field seperator character used in your CSV file in the "Field Seperator" text box.
							<br><br>
							The record seperator character is used in much the same way as the field seperator character, expect that it is used to seperate records instead of fields. The most popular record seperator is a new line. Other popular record seperators include the pipe character "|", the semi-colon, and the underscore character. You should enter the record seperator used in your CSV file into the "Record Seperator" text box.
							<br><br>
							Some programs also give you the option to ouput a line containing field headers into your CSV file. If your CSV file contains a line of headers, it will look something like this:
							<br><br>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;email,first_name,last_name,sex,salary
							<br><br>
							If this is the case, tick the "Contains Headers" checkbox. These headers will then be shown on the next page to help you decide which import fields to link to which subscriber fields.
							<br><br>
						</p>
					</td>
				</tr>
				<tr>
					<td height="30" background="<?php echo $ROOTURL; ?>/admin/images/quickbg.gif" align="right">
						<a href="javascript:window.close()" class="topLink">Close window »</a>&nbsp;&nbsp;
					</td>
				</tr>
			</table>
		</body>
		</html>
