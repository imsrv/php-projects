<?php
/* dl("mysql.so"); */

/* this may require a full path (unix) */
require("database.php3");


/* Set up current date */
$curdate=date("YmdHis");
$unixtime=date("U");
$formdate=date("M d h:i a");


/* Query Database */
$result=mysql_query("	SELECT *
			FROM notify 
			WHERE date_field<$curdate      ");

/* Read each entry, and decide whether or not to send reminder */
while ($row=mysql_fetch_array($result)){
	$email=$row['email'];
	$subject=$row['subject'];
	$comment=$row['comment'];
	$date_field=$row['date_field'];
	$id=$row['id'];
	$recurring=$row['recurring'];
        $adv_notice=$row['adv_notice'];
        $notify_num=$row['notify_num'];
   	$notify_val=$row['notify_val'];
	$recur_num=$row['recur_num'];
	$recur_val=$row['recur_val'];

	/* If there is an advance notice, make sure to mention it in the
	headers.  Note: Time has already been adjusted for advance notice 
	in the insertdata.php3 file. */

	/* Query Password Database for person's reminder info */
	$presult=mysql_query("SELECT *
			FROM passwd 
			WHERE email='$email'");
	while ($row=mysql_fetch_array($presult)){
        	$edate=$row['edate'];
        	$eip=$row['eip'];
        	$epasswd=$row['epasswd'];
	}

	if ($recurring==""){
		$addcomment="\n\n--\nThis was a ONE-TIME non-recurring E*REMINDER event.\n";
		$addcomment=$addcomment."It was created on $edate by a web-browser\n";
		$addcomment=$addcomment."at Internet site $eip.  You can disable this ";
		$addcomment=$addcomment."\nor find your password by going to $site.";
	} else {
		$addcomment="\n\n--\nThis is a CONTINUOUSLY recurring E*REMINDER event.\n";
		$addcomment=$addcomment."It was created on $edate by a web-browser\n";
		$addcomment=$addcomment."at Internet site $eip.  You can disable this ";
		$addcomment=$addcomment."\nor find your password by going to $site.";
	}

	/* E-mail reminder */
        if ($adv_notice=="") {
		$formdate="[".$subject."]";
		$comment=$comment.$addcomment;
		mail ("$email","E*REMINDER: $formdate","$comment");
	} else {
		$comment="A ".$notify_num." ".$notify_val." advance notice for the event on ".$comment;
		$comment=$comment.$addcomment;
		$formdate="[".$subject."]";
		mail ("$email","Advance E*REMINDER: $formdate","$comment");
	}

	echo "Sent mail to: $email\n";

	/* Delete Entry from Database if and only if recurring == no */
	if ($recurring==""){
		mysql_query("	DELETE 
				FROM notify
				WHERE 
				id='$id'	");

	}
	/* otherwise, add time to the current time entry to match
	the next scheduled recurring reminder.  We're adding time
	in seconds.  Also, make sure the next reminder is in the
	future. */
	else {
		/* Find out what our interval will be: */
		switch ($recur_val) {
			case "day"	:	$interval=86400;
						break;
			case "minute"	:	$interval=60;
						break;
			case "hour"	:	$interval=3600;
						break;
			case "month"	:	$interval=2592000;
						break;
			case "year"	:	$interval=31536000;
						break;
		}
		/* Make the interval correct */	
		$interval=$interval*$recur_num;

		/* Get the timestamp stored in the database */
		$rs2=mysql_query("SELECT unix_timestamp(date_field)
				  FROM notify
				  WHERE id='$id'");
                $rw=mysql_fetch_array($rs2);
		$oldtime=$rw['unix_timestamp(date_field)'];

		/* 	If someone has a recurring reminder and he accidentally
			set it in the past, let's fix the timestamp so he
			doesn't get reminded every time the script runs.*/ 
		$timedif=$unixtime-$oldtime;

		echo "Interval: $interval";
		if ($timedif>0) {
			$factor=ceil($timedif/$interval);
			$newtime=$oldtime+$factor*$interval;
		} else 
		{	$newtime=$oldtime+$interval; }

		/* Update the database with the new time */
		mysql_query("	UPDATE notify
				SET date_field=FROM_UNIXTIME($newtime)
				WHERE id='$id'");
	}

}


/* Query Database for passwd entries unused in last 90 days */
$result=mysql_query("	SELECT email
			FROM passwd 
			WHERE esentpass+300000000<$curdate      ");

/* Delete accounts older than 90 days with no reminders pending */
while ($row=mysql_fetch_array($result)){
	$email=$row['email'];
	$pending=mysql_query("	SELECT email
				FROM notify 
				WHERE email='$email'");
	$exist=mysql_fetch_array($pending);
	if (!$exist){
		mysql_query("	DELETE FROM passwd 
				WHERE email='$email'");
	}
}

?>
