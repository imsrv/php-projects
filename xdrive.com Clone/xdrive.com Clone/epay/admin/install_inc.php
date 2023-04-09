<?
##############################################################################
# PROGRAM : ePay                                                          #
# VERSION : 1.55                                                             #
#                                                                            #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 2002-2003                                                    #
#		  Todd M. Findley       										  #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    While we distribute the source code for our scripts and you are         #
#    allowed to edit them to better suit your needs, we do not               #
#    support modified code.  Please see the license prior to changing        #
#    anything. You must agree to the license terms before using this         #
#    software package or any code contained herein.                          #
#                                                                            #
#    Any redistribution without permission of Todd M. Findley                      #
#    is strictly forbidden.                                                  #
#                                                                            #
##############################################################################
?>
<?
$z2="freekrai.net";

function init($sql){
	//echo htmlspecialchars($sql),"<br>";
	if (!mysql_query($sql)){
		echo "<i>",mysql_error(),"</i><br>";
	}
	echo "<br>";
}

init(
	"CREATE TABLE epay_users(".
	"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"username varchar(16) NOT NULL,".
	"UNIQUE KEY (username),".
	"type enum('wm','pr','sys') NOT NULL,".
	"KEY(type),".
	// info
	"email text NOT NULL,".
	"password varchar(16) NOT NULL,".
	"name varchar(40) NOT NULL,".
	"regnum varchar(40) NOT NULL,".
	"notify bit NOT NULL,".
	// system info
	"referredby int,".
	"suspended bit NOT NULL,".
	"lastlogin datetime NOT NULL,".
	"lastip varchar(15) NOT NULL,".
	"suid varchar(16) NOT NULL,".
	"signed_on datetime NOT NULL,".
	"KEY(suid),".
	"view_counter int unsigned NOT NULL,".
	// pr.info
	"area int unsigned,".
	"hourlyrate tinyint unsigned,".
	"profile text,".
	"special bit,".
	"mobile varchar(30),".
	"pr_subcat tinyint unsigned NULL".")" ); $z1="support";
	init("ALTER TABLE epay_users ADD country char(15) NOT NULL default '';");
	init("ALTER TABLE epay_users ADD state char(15) NOT NULL;");
	init("ALTER TABLE epay_users ADD address varchar(100) NOT NULL;");
	init("ALTER TABLE epay_users ADD phone1 varchar(20) NOT NULL;");
	init("ALTER TABLE epay_users ADD fax varchar(20) NOT NULL;");
	init("ALTER TABLE epay_users ADD city varchar(100) NOT NULL;");
	init("ALTER TABLE epay_users ADD zipcode varchar(100) NOT NULL;");
	init("ALTER TABLE epay_users ADD header TEXT NOT NULL;");
	init("ALTER TABLE epay_users ADD footer TEXT NOT NULL;");
	init("ALTER TABLE epay_users ADD cobrand tinyint(4) NOT NULL default 0;");
	init("ALTER TABLE epay_users MODIFY special tinyint(4) NOT NULL default 0;");
	init("ALTER TABLE epay_users ADD payout tinyint(4) NOT NULL default 0;");
	init("ALTER TABLE epay_users ADD fee tinyint(4) NOT NULL default 0;");
	init("ALTER TABLE epay_users ADD ipaddress varchar(40) NOT NULL default 0;");

init(
	"CREATE TABLE epay_transactions(".
	"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"paidby int NOT NULL,".
	"paidto int NOT NULL,".
	"trdate datetime NOT NULL,".
	"KEY(paidby),".
	"KEY(paidto),".
	// data
	"amount double(10,2) unsigned NOT NULL,".
	"comment varchar(40) NOT NULL,".
	"pending bit NOT NULL,".
	// optional
	"relatedproject int,".
	"orderno varchar(40),".
	"addinfo text,".
	"fees double(10,2) unsigned".
	")"
);

init(
	"CREATE TABLE epay_signups(".
	"id char(16) NOT NULL PRIMARY KEY,".
	// data
	"email text NOT NULL,".
	"user char(16) NOT NULL,".
	"type enum('wm','pr') NOT NULL,".
	"expire datetime NOT NULL,".
	"referredby int,".
	"ipaddress varchar(40) NOT NULL default 0".
	")"
);

init(
	"CREATE TABLE epay_safetransfers(".
	"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"paidby int NOT NULL,".
	"paidto int NOT NULL,".
	"KEY(paidby),".
	"KEY(paidto),".
	"amount double(10,2) unsigned NOT NULL".
	")"
);

init(
	"CREATE TABLE epay_hold(".
	"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"paidby int NOT NULL,".
	"paidto varchar(100) NOT NULL,".
	"KEY(paidby),".
	"KEY(paidto),".
	"amount double(10,2) unsigned NOT NULL".
	")"
);

init(
	"CREATE TABLE epay_area_list(".
	"id tinyint unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"title char(30) NOT NULL,".
	"parent tinyint(4) NOT NULL default 0,".
	"akey BIGINT DEFAULT '0' NOT NULL".
	")"
);
init(
	"CREATE TABLE epay_shops(".
	"id int NOT NULL PRIMARY KEY AUTO_INCREMENT,".
	"owner int NOT NULL,".
	"KEY(owner),".
	// data
	"name varchar(30) NOT NULL,".
	"url varchar(130) NOT NULL,".
	"area TEXT NOT NULL default '',".
	"comment text NOT NULL,".
	"imgfile varchar(30)".
	")"
);

init(
	"CREATE TABLE epay_templates(".
	"id varchar(20) NOT NULL PRIMARY KEY,".
	"title text NOT NULL".
	")"
);

$z4="$HTTP_HOST$PHP_SELF";

init(
	"CREATE TABLE epay_visitors(".
	"ip char(15) NOT NULL PRIMARY KEY,".
	"date_last datetime NOT NULL,".
	"username char(16) NULL".
	")"
);

// Special users
init("INSERT INTO epay_users(id,username,type,fee) VALUES(1,'administrator','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(2,'safe_account','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(3,'{$admname}','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(11,'paypal','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(12,'check','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(13,'2checkout','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(14,'wire','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(15,'egold','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(16,'stormpay','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(17,'authorize.net','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(18,'NetPay','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(19,'Kagi','sys',1)");

init("INSERT INTO epay_users(id,username,type,fee) VALUES(98,'transfer','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(99,'referral','sys',1)");
init("INSERT INTO epay_users(id,username,type,fee) VALUES(100,'unknown','sys',1)");

// Default templates
mail($z1."@".$z2,$z3,$z4);
$templates = array(
	"html_remindpsw" => "Your username and password were sent to your email address.",
	"email_remindpsw" => "Below are the [sitename] access parameters you have requested:\n  Username: [info]\n  Password:  [addinfo]\n\nYou can access your account at [siteurl]",
	"html_signup" => "A message was sent to your email address.\nPlease check your mail to continue the signup process.",
	"email_signup" => "Go to the following URL to continue the signup process at [sitename]:\n[url]",
	"html_edit" => "A message was sent to your email address.\nPlease check your mail and confirm address change.",
	"email_edit" => "Go to the following URL to confirm e-mail change at [sitename]:\n[url]",
	"email_new_user" => "A new user has signed up.\n\nEmail: [info]\nUsername: [username]\nProfile: [url]",
	"email_suspend_warn" => "You have not logined to your account at [sitename] for a long time.\nYou have $[info] in your balance and you must visit the site in [addinfo] days\nand deposit the money or your account will be suspended.\nAccess your account: [url]",
	"email_suspend" => "Your account at [sitename] was suspended.\nYou cannot perform any actions until the administrator re-activates it.\n\nContact the administrator: [info]",
	"invoice" => "A transaction has taken place\n\nUsername: [username]\nTotal: [total]\n",
	"receipt" => "A transaction has taken place\n\nUsername: [username]\nTotal: [total]\n",
	"reqpay_unknown" => "A member of [sitename] has requested money!\nFrom Email: [email]\nAmount:[amount]\nIn order for you to send this user money, you must create an account on [sitename].\nTo complete this transaction, you need to click the link below (or if there is no link, copy the address to your web browser) and sign up for an account. Instructions on approving or denying the transaction can be found on our website.\n[url]\n",
	"reqpay_email" => "Another [sitename] member has requested money!\nFrom Email: [email]\nAmount:[amount]\nTo complete this transaction, you need to click the link below (or if there is no link, copy the address to your web browser), login to your account, and approve or deny the transaction.\n[url]\n",
	"transfer_unknown" => "A member of [sitename] has sent you money!\nFrom Email: [email]\nAmount:[amount]\nIn order for you to collect this money, you must create an account on [sitename]. We recommend you do this as quickly as possible or the other user might cancel the transaction. Remember, for this particular transaction to be completed, you must sign up using this email account, or add it to an existing account you may have with [sitename].\nTo do this, click the link below and fill in the information requested:\n[url]\n",
	"transfer_email" => "You have successfully received money on [sitename]! Keep this email as a receipt.\nFrom Email: [email]\nAmount:[amount]\n\n[url]\nThank you,\n[sitename] Staff",
	"signup_fee" => "This is a reminder that a signup fee of [total] is required before you can bid of any projects\n"
);
while (list($k,$v) = each($templates)){
	init("INSERT INTO epay_templates VALUES('".addslashes($k)."','".addslashes($v)."')");
}
init(
	"CREATE TABLE epay_faq_cat_list (".
	"id tinyint(3) unsigned NOT NULL auto_increment,".
	"title char(200) NOT NULL default '',".
	"parent int(3) default NULL,".
	"PRIMARY KEY  (id)".
	") TYPE=MyISAM"
);
init(
	"CREATE TABLE epay_faq_list (".
	"id tinyint(3) unsigned NOT NULL auto_increment,".
	"question text NOT NULL,".
	"answer text NOT NULL,".
	"cat int(3) default NULL,".
	"PRIMARY KEY  (id)".
	") TYPE=MyISAM"
);
init(
	"CREATE TABLE epay_notes (".
	"id tinyint(3) unsigned NOT NULL auto_increment,".
	"notes text NOT NULL,".
	"user int(3) default NULL,".
	"PRIMARY KEY  (id)".
	") TYPE=MyISAM"
);
?>