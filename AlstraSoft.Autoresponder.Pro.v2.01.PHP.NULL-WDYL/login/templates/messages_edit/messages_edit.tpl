<table cellSpacing="0" cellPadding="5" width="600" border="0" align="center">
<tr vAlign="center" align="middle" height="25">
	<td align="middle" align="center" height="40" width="70%" colSpan="2">
		<h3>Edit Autoresponders</h3>
	</td>
	<td align="middle" align="right" width="30%">
		User logged in: <br><b>{USER_NAME}</b>
	</td>
</tr>
</table>

<table cellSpacing="1" cellPadding="7" width="600" border="0" align="center" bgColor="#aaaaaa" >

<!-- HOME -->
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<a href="controlpanel.php">Home</a>&nbsp;|
		<a href="campaigns.php">Campaigns</a>&nbsp;|		
		<a href="messages.php"><b>Autoresponders</b></a>&nbsp;|
		<a href="newsletters.php">Newsletters</a>&nbsp;|
		<a href="prospects.php">Prospects</a>&nbsp;|
		<a href="account.php">Account</a>&nbsp;|
		<a href="help.php">Help</a>&nbsp;|
		<a href="logout.php">Logout</a>&nbsp;
	</td>
</tr>
<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		<b>Edit Autoresponders</b>&nbsp;|
		<a href="messages_test.php">Test Autoresponders</a>&nbsp;|
		<a href="messages_broadcast.php">Send Broadcast</a>
	</td>
</tr>

<form name="form_message_actions" action="do_on_message.php" method="post">
<tr>
	<td align="left" valign="top" width="25%" rowspan="1" bgColor="#FFFFFF">
		<b>All your Autoresponders: </b><br><br>
		(select one to edit)
	</td>
	<td bgColor="white" valign="top">
		{MESSAGE_LIST}
		{MESSAGE_MENU}
	</td>
</tr>
</form>

{MESSAGE_ADD_EDIT}

<tr>
	<td bgColor="#FFFFFF" valign="top">
		<b>Personalizing your Autoresponders</b>
	</td>
	<td bgColor="white">
		<br>
		<p>There are four pre-set merge words you may use in Body or Subject (see above) to personalize your Autoresponders.<br>
		<ul> 
			<li><b>[[firstname]]</b> will extract your prospect's first	name (i.e. 'Hi [[firstname]]' will print 'Hi John!', if your prospect's	first name is John).<br> 
			<li><b>[[name]]</b> will print your prospect's whole name (i.e. 'Mr. [[name]],' will print 'Mr. John Wayne', if your prospect's name is John Wayne).<br>
			<li><b>[[email]]</b> will extract your prospect's e-mail address (i.e. 'Your e-mail address is [[email]]' will output 'Your e-mail address is john2k@aol.com', if your prospect's e-mail address is john2k@aol.com.<br>
			<li><b>[[remove]]</b> will print removal URL, which can be used in your own unsubscribe instructions (i.e. 'If you wish to unsubscribe,	click &lt;A HREF="[[remove]]"&gt;here&lt;/A&gt;.').
		</ul>

		You can also predefine unlimited variables and use them in your	Autoresponders and broadcasts as <B>[[pre_XXXXX]]</B>
		(where XXXXX is the predefined variable name).
		To setup predefined variables, go to Prospects / Variables or click <A HREF="prospects_variables.php">here</A>.<BR><BR>

		You can go one step further using the Advanced Version and create up to 10 custom variables. These can be any bits of information you wish to collect from your prospects when they sign-up to receive information, a newsletter or purchase your products.  For example:
		<ul> 
			<li><b>[[custom_company_name]]</b> will extract your prospect's company name (i.e. [[custom_company_name]],' will print 'Whatsits, Inc.', if your prospect's company is called Whatsits, Inc.).
			<li><b>[[custom_phone]]</b> will extract your prospect's phone number (i.e. [[custom_phone]], will print 425-555-1212, if your prospect's phone number is 425-555-1212).
		</ul>
		Prior to using these personalized custom variables in your Autoresponder you must collect the information from your prospects using the <a href="prospects_htmlform.php">HTML Form</a> in Prospects.
		</font>
	</td>
</tr>

<tr>
	<td align="left" valign="top" bgColor="#FFFFFF" colSpan="2">
		&nbsp;
	</td>
</tr>

</table>
