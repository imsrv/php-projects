<?
	$signupsubject = "Welcome New Member!";
	$signupmessage = "Welcome new member. Your login information is below.\n\nUsername: <username>\nPassword: <password>\n<login_url>\n\nThanks,\nThe Site Administrator.\n\nThis Email Automatically Sent by System.";

	$admin25signupsubject = "You Have A New Member!";
	$admin25signupmessage = "A new mwmber has signed up. Their information is below.\n\nUsername: <username>\nPassword: <password>\nFirst Name: <first_name>\nLast Name: <last_name>\nEmail: <member_email>\n\nThis Email Automatically Sent by System";

	$paymentsubject = "Payment Received, Thank You";
	$paymentmessage = "Your payment was received!.\n\nThanks,\nThe Site Administrator.\n\nThis Email Automatically Sent by System.";

	$admin25paymentsubject = "You Have Received A Payment!";
	$admin25paymentmessage = "Payment received from Username <username> <member_email>\n\nThis Email Automatically Sent by System";

	$cancelsubject = "Cancelled Subscription?";
	$cancelmessage = "Hello <first_name>, we just noticed you cancelled your PayPal subscription to our site on your account with the username <username>. If you didn't mean to do this, you can contact us by replying to this email and we can tell you how to fix it. If we don't hear from you soon, we will be forced to delete your account, and all your sales records and products on file. Please contact us so we can sort this out.\n\nThanks,\nThe Site Admin";

	$admin25cancelsubject = "Subscription Cancelled";
	$admin25cancelmessage = "<username> <member_email>\nThis user has cancelled their PayPal subscription. Their account however was not deleted. Sometimes PayPal can cancel one of it's members subscriptions for a minor infraction, such as an expired credit card on file, and this is no reason for one of your members to lose all their info, and sales records, and products. They have been alerted, and informed to email you to sort this all out. They were also alerted to the fact that if they don't contact you to work this out, their account will be deleted eventually. You can delete this account permenately from the admin25 area.\n\nIf this user does contact you and wants to clear this up, you can send them to the URL below to re-subscribe and reactivate their account. This must be done only through the URL below, if this person tries to re-subscribe through the normal process of signing up, they will not be able to do so because their username is already in use, or they will wind up creating a new account with a new username which they don't really want to do.\n$resubscribe_url\n\nThis Email Automatically Sent by System";


	$email_bottomad = $sitename." --- ".$siteurl;
?>