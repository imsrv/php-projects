<?php
//  Simon's Rock Event Calendar
//  Copyright (C) 1999-2001 Ryan Krebs and Simon's Rock College of Bard
//  Please read the accompanying files "COPYING" and "COPYRIGHT"
//  for more information
//  $Id: event.php3,v 1.14 2001/05/30 21:17:03 fluffy Exp $

if (!$EVENT_INCLUDED)
{
$EVENT_INCLUDED = 1;
include('error/error.php3');
include('sql/sql.php3');
include('pulldown.php3');
include('checkbox.php3');
include('gettext.php3');

class SRCEvent
{

// The base event class has everything from the table, as well as an error var
//   and string vars for those that are stored as IDs.
	var $event_id, $title, $description, $location_id, $audience_id;
	var $category_id, $start_time, $end_time, $submitted_time;
	var $submitter_id, $approver_id, $info_url, $info_email, $error;
	var $location, $audience, $category, $submitter, $approver, $hide_oc;
	var $weekday_id, $weekday, $modify_id, $modified_submitter;
	var $modified_submit_time, $modified_title;

// The constructor takes everything and sticks it into the instance's vars
	function SRCEvent($new_submitter, $new_title, $new_description,
		$new_location, $new_audience, $new_category, $new_start_time,
		$new_end_time = 0, $new_info_url = "", $new_info_email = "",
		$new_approver_id = 0, $new_hide_oc = 0, $new_weekday_id = "",
		$new_modify_id = "")
	{
		$this->submitter_id = $new_submitter;
// need to get rid of "s, since they don't work in value fields
		$this->title = stripSlashes($new_title);
		$this->title = ereg_replace("\"", "&quot;", $this->title);
		$this->title = addSlashes($this->title);
// the description, however, can keep quotes in html tags.
		$this->description = stripSlashes($new_description);
		$this->description = ereg_replace("\"", "&quot;", $this->description);
//		$this->description = ereg_replace("\"", "&quot;", $this->description);
		while (($new_description = ereg_replace( "(<.*)&quot;(.*>)", "\\1\"\\2", $this->description))
			!= $this->description)
		{
			$this->description = $new_description;
		}
		$this->description = addSlashes($this->description);
		$this->location_id = $new_location;
		if (!is_array($new_audience))
		{
			$this->audience_id[0] = $new_audience;
		}
		else
		{
			$this->audience_id = $new_audience;
		}

		if (!is_array($new_category))
		{
			$this->category_id[0] = $new_category;
		}
		else
		{
			$this->category_id = $new_category;
		}

		if (!isSet($new_weekday_id))
		{
			$this->weekday_id[0] = -1;
		}
		elseif (!is_array($new_weekday_id))
		{
			$this->weekday_id[0] = $new_weekday_id;
		}
		else
		{
			$this->weekday_id = $new_weekday_id;
		}

		$this->start_time = $new_start_time;
		$this->end_time = $new_end_time;
		$this->info_url = $new_info_url;
		$this->info_email = $new_info_email;
		$this->approver_id = $new_approver_id;
		$this->submitted_time = mktime();
		$this->hide_oc = $new_hide_oc;
		$this->modify_id = $new_modify_id;
	}

// Validate event looks at stuff like dates and empty strings
	function validateEvent()
	{
		if (($this->title == "") || ($this->description == ""))
		{
			$this->error = "A required field (" .
				($this->title ? "description" : "title")
				. ") was not filled.";
			return 0;
		}

// If the e-mail address is incomplete, stick a default ending on it.
		if (($this->info_email) && (!ereg( "@", $this->info_email)))
		{
			$this->info_email .= "@" . $GLOBALS["CONFIG"]["domain"];
		}

// If the URL doesn't start with anything recognizable, stick on http
		if (($this->info_url) && (!ereg("^(http|ftp|https)://", $this->info_url)))
		{
			$this->info_url = "http://" . $this->info_url;
		}
// And if there are no dots in the server name, append the domain from the config
		if (($this->info_url) && (ereg(
			"^(http|ftp|https)://([[:alnum:]]+)$", $this->info_url, $regs)))
		{
			$this->info_url .= "." . $GLOBALS["CONFIG"]["domain"] . "/";
		} 

		if ($this->info_url)
		{
			$this->info_url = ereg_replace( 
				"(^(http|ftp|https)://([^./]+))(/(([^[:space:]])*)$)",
				"\\1." . $GLOBALS["CONFIG"]["domain"] . "\\4",
				$this->info_url);
		}

		if ($this->end_time && ($this->start_time > $this->end_time))
		{
			$this->error = "The ending time is before the beginning time.";
			return 0;
		}

		if ($this->weekday_id[0] == -1)
		{
			if (!$this->end_time)
			{
				$this->weekday_id[0] = date("w", $this->start_time);
			}
			else
			{
				$temp_stamp = mktime(0, 0, 0,
					date("m",$this->start_time),
					date("j",$this->start_time),
					date("Y",$this->start_time));

				while (($temp_stamp <= $this->end_time) &&
					(!$included_weekday[date("w", $temp_stamp)]))
				{
					$included_weekday[date("w", $temp_stamp)] = 1;
					$temp_stamp += 86400;
				}

				$j=0;
				for ($i = 0; $i < 7; $i++)
				{
					if ($included_weekday[$i])
					{
						$this->weekday_id[$j++] = $i;
					}
				}
			}
		}
		else
		{
			if (!$this->end_time)
			{
				if ((count($this->weekday_id)>1) ||
					($this->weekday_id[0] !=
					date("w", $this->start_time )))
				{
					$this->error = "A day of the week that was"
						. "selected is invalid for the "
						. "time you specified.";
					return 0;
				}
			}
			else
			{
				$temp_stamp = mktime(0, 0, 0,
					date("m",$this->start_time),
					date("j",$this->start_time),
					date("Y",$this->start_time));

				while (($temp_stamp <= $this->end_time) &&
					(!$valid_weekday[date("w", $temp_stamp)]))
				{
					$valid_weekday[date("w", $temp_stamp)] = 1;
					$temp_stamp += 86400;
				}

				$j=0;
				for ($i = 0; $i < count($this->weekday_id); $i++)
				{
					if (!$valid_weekday[$this->weekday_id[$i]])
					{
						$this->error = "A selected day of the "
							. "week is not included in the"
							. " time interval you specified.";
						return 0;
					}
				}
			}
		}

		return 1;
	}

	function submitEvent()
	{
		if (!$this->submitter_id)
		{
$this->error = "Your user ID got lost somewhere along the way.  " .
"Either your session expired or you have cookies disabled in your web browser."
. "  Make sure you've got cookies enabled and log in again.  Then you can " .
"try clicking the back button a couple times to get back to the form, so " .
"you won't have to type everything in again.";
			return 0;
		}

// If this is an approved modification, then we can just update the existing event.
		if ($this->approver_id && $this->modify_id)
		{
			$this->event_id = $this->modify_id;
			$this->modify_id = "";
			return $this->updateEvent();
		}

		if (!$db_conn = connectRWToCalendar())
		{
			$this->error = $php_errormsg;
			return 0;
		}

		if (!$result_id = @pg_exec($db_conn, "BEGIN WORK"))
		{
			$this->error = $php_errormsg;
			$this->error .= " beginning work in submit.";
			return 0;
		}

// simple (or not) SQL statement to insert the event into the database
$query = "INSERT INTO srcevent( title, description, location_id,"
. " start_time, end_time, submitted_time, submitter_id, approver_id, info_url, "
. "info_email, hide_oc, modify_id ) VALUES ( '" . $this->title . "', '" .
$this->description . "', " . $this->location_id . ", " . $this->start_time .
", " . $this->end_time . ", " . $this->submitted_time . ", " .
$this->submitter_id . ", " .
($this->approver_id ? $this->approver_id : "NULL") . ", " .
($this->info_url ? "'".$this->info_url."'" : "NULL") . ", " .
($this->info_email ? "'".$this->info_email."'" : "NULL") . ", " .
($this->hide_oc ? $this->hide_oc : "NULL" ) . ", " .
($this->modify_id ? $this->modify_id : "NULL" ) .
")";

		if (!$result_id = @pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg . "at submit exec.";
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

// We need to search again to get the event_id.  The OID will be unique.
		$oid = pg_getLastOID($result_id);
		$query = "SELECT event_id from srcEvent where oid = " . $oid;
		if (!$result_id = @pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg . " at select in submit.";
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		if (!($this->event_id = pg_result($result_id, 0, "event_id")))
		{
			$this->error = $php_errormsg . " at select in submit.";
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

// with the event ID, we can add the things that are stored in other tables
		for ($i = 0; $i < count($this->audience_id); $i++)
		{
$query = "INSERT INTO srcAudienceList ( event_id, audience_id ) VALUES ( "
. $this->event_id . ", " . $this->audience_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting audiences";
				$this->error .= " QUERY= ". $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		for ($i = 0; $i < count($this->category_id); $i++)
		{
$query = "INSERT INTO srcCategoryList ( event_id, category_id ) VALUES ( "
. $this->event_id . ", " . $this->category_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting categories";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		for ($i = 0; $i < count($this->weekday_id); $i++)
		{
$query = "INSERT INTO srcweekdaylist ( event_id, day ) VALUES ( "
. $this->event_id . ", " . $this->weekday_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting weekdays";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		$timestamps = $this->generateTimestampArray();

		for ($i = 0; $i < count($timestamps); $i++)
		{
$query = "INSERT INTO srcindex ( event_id, timestamp ) VALUES ( "
. $this->event_id . ", " . $timestamps[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "updating index";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		if (!$result_id = @pg_exec($db_conn, "COMMIT WORK"))
		{
			$this->error = $php_errormsg;
			$this->error .= " committing work in submit.";
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}


// Bruce Tenison, generous guy that he is, supplied me with some code for
//  emailing location administrators when an event is submitted.
		if (!$this->approver_id)
		{
			if (!$db_conn = connectROToAuth())
			{
				$this->error = $php_errormsg;
				return 0;
			}

//  Select rows from the permissions table for this location or -1 (all)
			$query = "SELECT user_id, permissions, location_id "
				. "FROM permissions WHERE location_id = " .
				$this->location_id . " OR location_id = -1";
			if (!$result_id = @pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . " at select in submit.";
				$this->error .= " QUERY= " . $query;
				return 0;
			}

			$num_rows = pg_numrows($result_id);
			for($i = 0; $i < $num_rows ; $i++)
			{
				$stuff = pg_fetch_array($result_id, $i);
				$uid = $stuff["user_id"];
				$perms = $stuff["permissions"];
				$locationid = $stuff["location_id"];
// Now we need to check if the user has permission to approve this entry
// I'm going to look at this in two sections (makes more sense to me that way)
// 1)  If the submitter_id of the entry is the same as the permissions
//	user_id, check the approve_own bit
// 2)  If the submitter_id of the entry is NOT the same as the permissions
//	user_id, check the approve_other bit
				if ((($this->submitter_id == $uid) &&
						($perms & $GLOBALS["pApproveOwn"]))
					|| (($this->submitter_id != $uid) &&
						($perms & $GLOBALS["pApproveOther"])))
				{
					exec($GLOBALS["CONFIG"]["getuidinfo"]
						. " $uid", $dummy, $err_num);
					if ($err_num)
					{
						$this->error = "An administrator's "
							. "email address could not be"
							. " found.  The event will be"
							. " submitted anyway.";
						return 0;
					}
					$temp_array = split(":", $dummy[0]);
					unset($dummy);

					$mailto = $temp_array[0] . "@" . $GLOBALS["CONFIG"]["domain"];
					$mailfrom = $GLOBALS["CONFIG"]["webmaster"];
					$subject = "Event submission";
					$message = "An event was submitted to the " .
						"online event calendar, as included "
						. "below:\n\n";
					$message .= $this->returnEventText();

					mail($mailto, $subject, $message, "From: $mailfrom");
				}
			}
		}

		return $this->event_id;
	}

	function rejectEvent($rejecter_id, $reason = "")
	{
// remove the event from the database and notify the submitter
		$return = $this->deleteEvent();
		if (!$return)
		{
			return 0;
		}

// mail support to inform submitter of rejection.
		exec($GLOBALS["CONFIG"]["getuidinfo"] . " $this->submitter_id",
			$dummy, $err_num);
		if ($err_num)
		{
			$this->error = "The submitter's e-mail address could not be retrieved."; 
			if ($return)
			{
				$this->error .= " The event in question was deleted.";
			}
			return 0;
		}
		$temp_array = split(":", $dummy[0]);
		unset($dummy);
		$mailto = $temp_array[0] . "@" . $GLOBALS["CONFIG"]["domain"];

		exec($GLOBALS["CONFIG"]["getuidinfo"] . " $rejecter_id", 
			$dummy, $err_num);
		if ($err_num)
		{
			$this->error = "Your e-mail address could not be retrieved."; 
			if ($return)
			{
				$this->error .= " The event in question was deleted.";
			}
			return 0;
		}
		$temp_array = split(":", $dummy[0]);
		unset($dummy);
		$mailfrom = $temp_array[0] . "@" . $GLOBALS["CONFIG"]["domain"];

		$subject = "Event rejection";
		$message = "The event that you submitted for the " . $GLOBALS["CONFIG"]["abbrvname"] . " Event Calendar"
			. ", as included below,\nwas rejected" .
		($reason ? " for the following reason:\n" . $reason : ".");

		$message .= $this->returnEventText();

		mail($mailto, $subject, $message, "From: $mailfrom");

		return $return;
	}

	function deleteEvent()
	{
// pretty self-explanatory
		if (!$this->verifyAction("Delete"))
		{
			$this->error = "Permissions check failed.";
			return 0;
		}

		if (!$db_conn = connectRWToCalendar())
		{
			$this->error = $php_errormsg;
			return 0;
		}

		if (!$result_id = @pg_exec($db_conn, "BEGIN WORK"))
		{
			$this->error = $php_errormsg;
			$this->error .= " beginning work in delete.";
			return 0;
		}

		if ($this->deleteEventWithConnection($db_conn))
		{
			if(!$result_id = @pg_exec($db_conn, "COMMIT WORK"))
			{
				$this->error = $php_errormsg;
				$this->error .= " while committing work in delete.";
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}

			return 1;
		}
		else
		{
			return 0;
		}
	}

	function deleteEventWithConnection($db_conn, $do_rollback = 1)
	{
// delete the event using an existing connection,
//  allows deletion to be nested within another transaction

		// If there's a modification to this event, update that event
		$query = "UPDATE srcEvent SET modify_id = " .
			($this->modify_id ? $this->modify_id : "NULL") .
			" WHERE modify_id = " . $this->event_id;

		if (!$result_id = @pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg;
			$this->error .= " QUERY= " . $query;
			if ($do_rollback)
			{
				@pg_exec($db_conn, "ROLLBACK WORK");
			}
			return 0;
		}

		$tables = array("srcEvent", "srcAudienceList",
			"srcCategoryList", "srcWeekdayList", "srcIndex");

		for ($i = 0; $i < count($tables); $i++)
		{
			$query = "DELETE FROM " . $tables[$i] .
				" WHERE event_id = " . $this->event_id;

			if (!$result_id = @pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg;
				$this->error .= " QUERY= " . $query;
				if ($do_rollback)
				{
					@pg_exec($db_conn, "ROLLBACK WORK");
				}
				return 0;
			}
		}

		return 1;
	}

	function approveEvent($new_approver)
	{
// updates the event with the new approver_id
		if (!$db_conn = connectRWToCalendar())
		{
			$this->error = $php_errormsg;
			return 0;
		}

		if (!$result_id = @pg_exec($db_conn, "BEGIN WORK"))
		{
			$this->error = $php_errormsg;
			$this->error .= " beginning work in approve.";
			return 0;
		}

		// if this is a modification, remove the original event
		if ($this->modify_id)
		{
			$original_event = new SRCEventFromEventID($this->modify_id);

			if (!$original_event->deleteEventWithConnection($db_conn))
			{
				$this->error = $original_event->error;
				return 0;
			}

			$this->modify_id = $original_event->modify_id;

			$query = "UPDATE srcEvent SET modify_id = " .
				($this->modify_id ? $this->modify_id : "NULL") .
				" WHERE event_id = " . $this->event_id;

			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg;
				$this->error .= " QUERY= " . $query;
				pg_exec( $db_conn, "ROLLBACK WORK" );
				return 0;
			}
		}

// We only want to approve the event if it's no longer a modification
//  (so a long chain of modifications may have to be approved several times)
		if (!$this->modify_id)
		{
			$query = "UPDATE srcEvent SET approver_id = " . $new_approver .
				"WHERE event_id = " . $this->event_id;

			if (!$result_id = @pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg;
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		if (!$result_id = @pg_exec($db_conn, "COMMIT WORK"))
		{
			$this->error = $php_errormsg;
			$this->error .= " while committing work in approve.";
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		// the rest doesn't apply if this is still a modification
		if ($this->modify_id)
		{
			return 1;
		}

		$this->approver_id = $new_approver;

// mail support to inform submitter of approval.
		exec($GLOBALS["CONFIG"]["getuidinfo"]
			. " $this->submitter_id", $dummy, $err_num);
		if($err_num)
		{
$this->error = "The submitter's e-mail address could not be retrieved." .
	" The event was approved anyway.";
			return 0; 
		}
		$temp_array = split(":", $dummy[0]);
		unset($dummy);
		$mailto = $temp_array[0] . "@" . $GLOBALS["CONFIG"]["domain"];

		exec($GLOBALS["CONFIG"]["getuidinfo"]
			. " $new_approver", $dummy, $err_num);
		if ($err_num)
		{
$this->error = "Your e-mail address could not be retrieved." . 
	" The event was approved anyway."; 
			return 0;
		}
		$temp_array = split(":", $dummy[0]);
		unset($dummy);
		$mailfrom = $temp_array[0] . "@" . $GLOBALS["CONFIG"]["domain"];

		$subject = "Event approval";
		$message = "The event that you submitted for the " . $GLOBALS["CONFIG"]["abbrvname"] . " Event Calendar"
			. ", as included below,\nwas approved.\n";

		$message .= $this->returnEventText();

		mail($mailto, $subject, $message, "From: $mailfrom");

		return $this;
	}

	function updateEvent()
	{
		if (!$this->submitter_id)
		{
$this->error = "Your user ID got lost somewhere along the way.  " .
"Either your session expired or you have cookies disabled in your web browser."
. "  Make sure you've got cookies enabled and log in again.  Then you can " .
"try clicking the back button a couple times to get back to the form, so " .
"you won't have to type everything in again.";
			return 0;
		}

		if (!$this->event_id)
		{
			$this->submitEvent();
			return;
		}

// we'll assume that if the event has been approved, the approveEvent function
//  would have been called, so if there's a modify ID, it's probably an
//  inconsistency and we'll remove it.
		if ($this->approver_id && $this->modify_id)
		{
			$this->modify_id = "";
		}

		if (!$db_conn = connectRWToCalendar())
		{
			$this->error = $php_errormsg;
			return 0;
		}

		$query = "BEGIN WORK";
		if (!$result_id = @pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg . "beginning work in update.";
			$this->error .= " QUERY= " . $query;
			return 0;
		}

// simple (or not) SQL statement to insert the event into the database
// we could look for attributes that were modified and only update those,
//  but that would probably involve contacting the database again or
//  bloating the form with the old values, and in the long run would
//  likely be more expensive
$query = "UPDATE srcevent set title = '" . $this->title . "', description = '" .
$this->description . "', location_id = " . $this->location_id . ", start_time = "
. $this->start_time . ", end_time = " . $this->end_time . ", submitted_time = " .
$this->submitted_time . ", submitter_id = " . $this->submitter_id . ", approver_id = " .
($this->approver_id ? $this->approver_id : "NULL") . ", info_url = " .
($this->info_url ? "'".$this->info_url."'" : "NULL") . ", info_email = " .
($this->info_email ? "'".$this->info_email."'" : "NULL") . ", hide_oc = " .
($this->hide_oc ? $this->hide_oc : "NULL" ) . ", modify_id = " .
($this->modify_id ? $this->modify_id : "NULL" ) .
" WHERE event_id = " . $this->event_id;

		if (!$result_id = @pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg . "at exec in update.";
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

// deleting stuff and reinserting so I don't have to worry about the
//  new set having a different number of values
		$query = "DELETE from srcAudienceList WHERE event_id = " .
			$this->event_id;
		if (!$result_id = pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg;
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		for ($i = 0; $i < count($this->audience_id); $i++)
		{
$query = "INSERT INTO srcAudienceList ( event_id, audience_id ) VALUES ( "
. $this->event_id . ", " . $this->audience_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting audiences";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		$query = "DELETE from srcCategoryList WHERE event_id = " .
			$this->event_id;
		if (!$result_id = pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg;
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		for ($i = 0; $i < count($this->category_id); $i++)
		{
$query = "INSERT INTO srcCategoryList ( event_id, category_id ) VALUES ( "
. $this->event_id . ", " . $this->category_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting categories";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		$query = "DELETE from srcWeekdayList WHERE event_id = " .
			$this->event_id;
		if (!$result_id = pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg;
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		for ($i = 0; $i < count($this->weekday_id); $i++)
		{
$query = "INSERT INTO srcweekdaylist ( event_id, day ) VALUES ( "
. $this->event_id . ", " . $this->weekday_id[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "inserting weekdays";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		$query = "DELETE from srcIndex WHERE event_id = " .
			$this->event_id;
		if (!$result_id = pg_exec($db_conn, $query))
		{
			$this->error = $php_errormsg;
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		$timestamps = $this->generateTimestampArray();

		for ($i = 0; $i < count($timestamps); $i++)
		{
$query = "INSERT INTO srcindex ( event_id, timestamp ) VALUES ( "
. $this->event_id . ", " . $timestamps[$i] . " )";
			if (!$result_id = pg_exec($db_conn, $query))
			{
				$this->error = $php_errormsg . "updating index";
				$this->error .= " QUERY= " . $query;
				@pg_exec($db_conn, "ROLLBACK WORK");
				return 0;
			}
		}

		if (!$result_id = @pg_exec($db_conn, "COMMIT WORK"))
		{
			$this->error = $php_errormsg . "committing work.";
			$this->error .= " QUERY= " . $query;
			@pg_exec($db_conn, "ROLLBACK WORK");
			return 0;
		}

		return $this->event_id;
	}

	function generateTimestampArray()
	{
		$start_date = mktime(0, 0, 0,
			date("m", $this->start_time),
			date("j", $this->start_time),
			date("Y", $this->start_time));

		if (!$this->end_time)
		{
// If there's no end_time, the event is one day only
			$timestamps[0] = $start_date;
			return $timestamps;
		}
		else
		{
// also one day only if the end date is the same as the start date
			$end_date = mktime(0, 0, 0,
				date("m", $this->end_time),
				date("j", $this->end_time),
				date("Y", $this->end_time));

			if ($end_date == $start_date)
			{
				$timestamps[0] = $start_date;
				return $timestamps;
			}
		}

// Otherwise, let's get ready to run through the entire date range
		$current_stamp = $start_date;
		$j = 0;

// create an easy way to check the weekday, since in_array is a PHP4 feature
		for ($i = 0; $i < count($this->weekday_id); $i++)
		{
			$weekdays[$this->weekday_id[$i]] = 1;
		}

		while ($current_stamp <= $end_date)
		{
			if ($weekdays[date("w", $current_stamp)])
			{
				$timestamps[$j++] = $current_stamp;
			}

			$current_stamp = mktime(0, 0, 0,
				date("m", $current_stamp),
				date("j", $current_stamp) + 1,
				date("Y", $current_stamp));
		}
		return $timestamps;
	}

	function getStringsForIDs()
	{
		$db_conn = connectROToCalendar();

// will fetch the name column from a bunch of tables.
//  in those cases where there are multiple IDs, the strings will
//  be catted into a comma separated list
		$query = "SELECT name AS location FROM srcLocation " .
			"WHERE location_id = " . $this->location_id;

		$result_id = @pg_exec($db_conn, $query);
		$stuff = pg_fetch_array($result_id, 0);
		$this->location = $stuff["location"];

		$query = "SELECT name AS audience FROM srcAudience " .
			"WHERE audience_id IN ( ";

		for ($i = 0; $i < count($this->audience_id); $i++)
		{
			$query .= ($i ? "," : "") . $this->audience_id[$i];
		}

		$query .= " )";
		$result_id = pg_exec($db_conn, $query);
		$num_rows = pg_numrows($result_id);
		for ($i = 0; $i < $num_rows; $i++)
		{
			$stuff = pg_fetch_array($result_id, $i);
			($i ? $this->audience .= ", " . $stuff["audience"] :
				$this->audience = $stuff["audience"]);
		}

		$query = "SELECT name AS category FROM srcCategory " .
			"WHERE category_id IN ( ";

		for ($i = 0; $i < count($this->category_id); $i++)
		{
			$query .= ($i ? "," : "") . $this->category_id[$i];
		}

		$query .= " )";

		$result_id = pg_exec($db_conn, $query);
		$num_rows = pg_numrows($result_id);
		for ($i = 0; $i < $num_rows; $i++)
		{
			$stuff = pg_fetch_array($result_id, $i);
			($i ? $this->category .= ", " . $stuff["category"] :
				$this->category = $stuff["category"]);
		}

		// grab some information about the modified event
		if ($this->modify_id)
		{
			$query = "SELECT title, submitter_id, submitted_time "
				. "FROM srcEvent WHERE event_id = " .
				$this->modify_id;

			$result_id = pg_exec($db_conn, $query);
			$stuff = pg_fetch_array($result_id, 0);

			$this->modified_title = $stuff["title"];
			$this->modified_submit_time = $stuff["submitted_time"];

			exec($GLOBALS["CONFIG"]["getuidinfo"] . " " . 
				$stuff["submitter_id"], $dummy, $err_num);
			$stuff = $dummy[0];
			unset($dummy);
			if (!$err_num)
			{
				$array = split(":", $stuff);
				$gecos = split(",", $array[4]);
				$this->modified_submitter = $gecos[0];
			}

		}

// the usernames aren't stored in the database (unless there's an active session)
		exec($GLOBALS["CONFIG"]["getuidinfo"] . " " . 
			$this->submitter_id, $dummy, $err_num);
		$stuff = $dummy[0];
		unset($dummy);
		if (!$err_num)
		{
			$array = split(":", $stuff);
			$gecos = split(",", $array[4]);
			$this->submitter = $gecos[0];
		}

		if ($this->approver_id)
		{
			exec($GLOBALS["CONFIG"]["getuidinfo"] .
				" " . $this->approver_id, $dummy, $err_num);
			$stuff = $dummy[0];
			unset($dummy);
			if (!$err_num)
			{
				$array = split(":", $stuff);
				$gecos = split(",", $array[4]);
				$this->approver = $gecos[0];
			}
		}

		unset($this->weekday);
		if ($this->weekday_id[0] != -1)
		{
			$query = "SELECT name AS weekday FROM srcWeekday " .
				"WHERE day IN ( ";

			for ($i = 0; $i < count($this->weekday_id); $i++)
			{
				$query .= ($i ? "," : "") . $this->weekday_id[$i];
			}

			$query .= " )";
			$result_id = pg_exec($db_conn, $query);
			$num_rows = pg_numrows($result_id);
			for ($i = 0; $i < $num_rows; $i++)
			{
				$stuff = pg_fetch_array($result_id, $i);
				($i ? $this->weekday .= ", " . $stuff["weekday"] :
					$this->weekday = $stuff["weekday"]);
			}
		}
	}

// This function returns a string containing the details of an event,
//  suitable for including in e-mail messages
	function returnEventText()
	{

		$message = "\n\nTitle: $this->title\n"
			. "Description: $this->description\n"
			. "Location: $this->location\n"
			. "Audience: $this->audience\n"
			. "Category: $this->category\n"
			. "Submitted: " . date("F j, h:i A", $this->submitted_time)
			. "\n"
			. "Submitted by: " . $this->submitter . "\n"
			. "Starting: " . date("F j, h:i A", $this->start_time)
			. "\n";
		if ($this->end_time)
		{
			$message .= "Ending: " . date("F j, h:i A", $this->end_time) . "\n";
		}

		if ($this->weekday)
		{
			$message .= "On: $this->weekday\n";
		}

		if ($this->info_url)
		{
			$message .= "Info URL: $this->info_url\n";
		}

		if ($this->info_email)
		{
			$message .= "Info email: $this->info_email\n";
		}

		if ($this->hide_oc)
		{
			$message .= "*Hidden from off-campus browsers*\n";
		}

		if ($this->modify_id)
		{
			$message .= "This is a proposed modification to " .
				"the event titled \"" . $this->modified_title .
				"\" submitted by " . $this->modified_submitter .
				" on " .
				date( "F j, h:i A", $this->modified_submit_time )
				. "\n";
		}

		return $message;
	}

	function outputDetailView($prev_link = 1)
	{
		$scriptname = $GLOBALS["SCRIPT_NAME"];

// we want the names of things like location and audience, not just IDs
		echo("<BIG>" . stripSlashes($this->title) . "</BIG><BR>\n");
		echo("<B>" . _("Location") . ":</B>");
		echo("$this->location <BR>\n");
		echo("<B>" . _("When") . ":</B> ");
		echo(ucwords(strftime("%B %e, %Y", $this->start_time )) .
			(($temp = date(", h:i A", $this->start_time)) == ", 12:00 AM" ?
				"" : $temp)
		);

		if ($this->end_time)
		{
			echo( " - " );
			if (date("F j, Y", $this->start_time) !=
				($temp = date("F j, Y", $this->end_time)))
			{
				echo(ucwords(strftime(" %B %e, %Y", $this->end_time)));
				if (($temp = date(", h:i A", $this->end_time)) != ", 12:00 AM")
				{
					echo($temp);
				}
			}
			else
			{
				echo(date("h:i A", $this->end_time));
			}
		}
		echo("<BR>\n");

		if ($this->weekday)
		{
			echo("$this->weekday<BR>\n");
		}

		echo("<P>" . stripSlashes($this->description) . "</P>\n");

		if ($this->info_email)
		{
			echo("<B>" . _("Contact E-Mail") . ":</B>\n");
			echo("<A HREF=\"mailto:" . $this->info_email .
				"\">" . $this->info_email . "</A><BR>\n");
		}

		if ($this->info_url)
		{
			echo("<B>" . _("Info URL") . ":</B>\n" .
				"<A HREF=\"" . $this->info_url . "\">" .
				$this->info_url . "</A><BR>\n");
		}

		echo("<B>" . _("Category") . ":</B> ");
		echo($this->category . "<BR>\n");
		echo("<B>" . _("Audience") . ":</B> ");
		echo($this->audience . "<BR>\n");
		echo("<B>" . _("Submitted") . ":</B> ");
		echo(ucwords(strftime("%B %e, %Y %T", $this->submitted_time)) . "<BR>\n");
		echo("<B>" . _("Submitted by") . ":</B> ");
		echo($this->submitter . "<BR>\n");
		echo("<B>" . _("Approved by") . ":</B> ");
		echo($this->approver ? $this->approver : "<STRONG>" . _("Not Yet Approved") . "</STRONG>");
		echo("<BR>\n");
		if ($this->hide_oc)
		{
			echo("<STRONG>" . _("Hidden from off-campus browsers") . "</STRONG><BR>\n");
		}

		if ($this->modify_id)
		{
// FIXME - this is dependant on stuff outside the class
			$print_title = "&quot;" .
				"<A HREF=\"$scriptname?action=calendar&amp;cal_view=detail"
				. "&amp;event_id=" . $this->modify_id . "\">" .
				$this->modified_title . "</A>&quot;";
			$print_date = 
				date("F j, h:i A", $this->modified_submit_time);

			echo(_wv("This is a proposed modification to the event titled %s1 submitted by %s2 on %s3.",
				array($print_title, $this->modified_submitter,
				$print_date)) . "<BR>\n");
		}

		if ($prev_link)
		{
// FIXME - this is dependant on stuff outside the class
//  we're outputting links that load the appropriate boxes, provided the 
//  current session has the ability to delete/approve/modify the event
			if ($this->verifyAction("Delete"))
			{
echo("<A HREF=\"$scriptname?action=delete&amp;form_action=delete_event&amp;num_events=1"
	. "&amp;delete_0=delete&amp;event_0_id=" . $this->event_id .
	(isSet($GLOBALS["timestamp"]) ? "&amp;timestamp=" . $GLOBALS["timestamp"] : "") .
	"\">");
				echo(_("Delete"));
				echo("</A><BR>");
			}

			if (!$this->approver_id &&
				((!$this->modify_id &&
					$this->verifyAction("Approve"))
				|| ($this->modify_id &&
					$this->verifyAction("Modify"))))
			{ 
echo("<A HREF=\"$scriptname?action=approve&amp;form_action=approve_event&amp;num_events=1"
	. "&amp;approve_0=approve&amp;event_0_id=" . $this->event_id .
	(isSet($GLOBALS["timestamp"]) ? "&amp;timestamp=" . $GLOBALS["timestamp"] : "") .
	"\">");
				echo(_("Approve"));
				echo("</A><BR>");
			}

// We don't use verifyPermissions here because of submitted modifications.
// We should have a Modify link if the user is logged in.
			if (isSet($GLOBALS["SRCSessionKey"]))
			{
echo("<A HREF=\"$scriptname?action=modify&amp;form_action=output_form&amp;event_id="
	. $this->event_id . (isSet($GLOBALS["timestamp"]) ?
		"&amp;timestamp=" . $GLOBALS["timestamp"] : "") . "\">");
				echo(_("Modify"));
				echo("</A><BR>");
			}

// a link to the referring page, so we don't lose search results
			$string = getEnv("HTTP_REFERER");
			$string = ereg_replace("&", "&amp;", $string);
			echo("<A HREF=\"" . $string . "\">");
			echo(_("Previous page") . "</A>");
		}
	}

// this could possibly use some alternate layouts, but I just slapped this in here
	function outputTextOnly()
	{
		$temp_description = eregi_replace("<.*>", "", $this->description);

		echo("<P><B>$this->title:</B> $temp_description - <I>$this->location");
		if (($temp = date("h:i A", $this->start_time)) != "12:00 AM")
		{
			echo(", $temp");
		}
		if ($this->end_time)
		{
			if (($temp = date("h:i A", $this->end_time)) != "12:00 AM")
			{
				echo(" - $temp");
			}
		}
		echo("</I></P>\n");
	}

	function outputEditableEvent()
	{
// here we output some form elements with the appropriate values
//  the actual form tags will be handled by the various components that call this
		if (!$my_conn = @connectROToCalendar())
		{
			$this->error = $php_errormsg;
			return;
		}

		if ($this->event_id)
		{
			echo("<INPUT TYPE=hidden NAME=\"event_id\" VALUE=\"" .
				$this->event_id . "\">\n");
		}

		echo("<B>" . _("Event Title") . ":</B>" .
			"<INPUT TYPE=text NAME=\"title\"");
		if ($this->title)
		{
			echo(" VALUE=\"" . ereg_replace("\"", "&quot;",
				stripSlashes($this->title)) . "\"");
		}
		echo("><BR><B>" . _("Starting time") . "</B>");

                $temp_stamp = ($this->start_time ? $this->start_time : mktime());

		if ($GLOBALS["CONFIG"]["daybeforemonth"] == 0)
		{
			echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 " .
				"NAME=\"start_month\" VALUE=\"" .
				date("m", $temp_stamp) . "\"> / ");
		}

		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"start_date\"" .
			" VALUE=\"" . date("j", $temp_stamp) . "\"> / ");

		if ($GLOBALS["CONFIG"]["daybeforemonth"] != 0)
		{
			echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 " .
				"NAME=\"start_month\" VALUE=\"" .
				date("m", $temp_stamp) . "\"> / ");
		}

		echo("<INPUT TYPE=text SIZE=4 MAXLENGTH=4 NAME=\"start_year\"" .
			" VALUE=\"" . date("Y", $temp_stamp) . "\"> at "); 
		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"start_hour\"");
		if ($this->start_time)
		{
			echo("VALUE=\"" . date("h", $this->start_time) . "\"");
		}
		echo("> : ");

		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"start_minute\"");
		if ($this->start_time)
		{
			echo("VALUE=\"" . date("i", $this->start_time) . "\"");
		}
		echo("> ");

		echo("<INPUT TYPE=checkbox NAME=\"start_pm\" VALUE=\"yup\"");
		if ($this->start_time && (date("H", $this->start_time) > 11))
		{
			echo(" CHECKED");
		}
		echo(">PM<BR>");

		echo("<B>" . _("Ending time") . ":</B>");

		if ($GLOBALS["CONFIG"]["daybeforemonth"] == 0)
		{
			echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 " .
				"NAME=\"end_month\"");
			if ($this->end_time)
			{
				echo(" VALUE=\"" . date("m", $this->end_time) .
					"\"");
			}
			echo("> / ");
		}

		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"end_date\"");
		if ($this->end_time)
		{
			echo(" VALUE=\"" . date("j", $this->end_time) . "\"");
		}
		echo("> / ");

		if ($GLOBALS["CONFIG"]["daybeforemonth"]  != 0)
		{
			echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 " .
				"NAME=\"end_month\"");
			if ($this->end_time)
			{
				echo(" VALUE=\"" . date("m", $this->end_time) .
					"\"");
			}
			echo("> / ");
		}

		echo("<INPUT TYPE=text SIZE=4 MAXLENGTH=4 NAME=\"end_year\"");
		if ($this->end_time)
		{
			echo(" VALUE=\"" . date("Y", $this->end_time) . "\"");
		}
		echo("> at ");

		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"end_hour\"");
		if ($this->end_time)
		{
			echo(" VALUE=\"" . date("h", $this->end_time) . "\"");
		}
		echo("> : ");

		echo("<INPUT TYPE=text SIZE=2 MAXLENGTH=2 NAME=\"end_minute\"");
		if ($this->end_time)
		{
			echo(" VALUE=\"" . date("i", $this->end_time) . "\"");
		}
		echo("> ");

		echo("<INPUT TYPE=checkbox NAME=\"end_pm\" VALUE=\"yup\"");
		if ($this->end_time && (date("H", $this->end_time) > 11))
		{
			echo(" CHECKED");
		}
		echo(">PM<BR>\n");

		echo(_("If a long event only occurs on certain days of the week, check the appropriate days") . ":<BR>");

		if ($error = outputCheckboxFromTable($my_conn, "srcWeekday",
			"day", "name", "weekday", 3, 0, -1, 0, $this->weekday_id))
		{
			$this->error = $error;
		}

		echo("<BR>\n");
		echo("<B>" . _("Description") . ":</B><BR>\n");
		echo("<TEXTAREA NAME=\"description\" ROWS=5 COLS=30 WRAP=soft>");
		if ($this->description)
		{
			echo(stripSlashes($this->description));
		}
		echo("</TEXTAREA><BR>\n");

		echo("<B>" . _("Location") . "</B> <I>(" .
			_("make sure it's cleared with the proper people") . ")</I>\n");

		if ($error = outputPulldownFromTable($my_conn, "srcLocation",
			"location_id", "name", "location", $this->location_id))
		{
			$this->error = $error;
		}
		echo("<BR>\n");

		echo("<B>" . _("Category") . ":</B> (" .
			_wv("check all that apply, or none for %s1",
			array("&quot;general&quot;")));
		echo(")<BR>\n");

		if ($error = outputCheckboxFromTable($my_conn, "srcCategory",
			"category_id", "name", "category", 3, 0, 0, 1,
			$this->category_id))
		{
			$this->error = $error;
		}				
		echo("<BR>\n");

		echo("<B>" . _("Audience") . ":</B> (" .
			_wv("check all that apply, or none for %s1",
			array("&quot;" . _("all") . "&quot;")));
		echo(")<BR>\n");

		if ($error = outputCheckboxFromTable($my_conn, "srcAudience",
			"audience_id", "name", "audience", 3, 0, 0, 1,
			$this->audience_id))
		{
			$this->error = $error;
		}				
		echo("<BR>\n");

		echo("<B>" . _("Contact E-Mail") . ":</B> (" . _("optional") . ")\n");
		echo("<INPUT TYPE=text NAME=\"info_email\"");
		if ($this->info_email)
		{
			echo(" VALUE=\"" . $this->info_email . "\"");
		}
		echo("><BR>\n");

		echo("<B>" . _("URL for further info") . ":</B> (" . _("optional") . ", " .
			_("please include &quot;http://&quot") . ")\n");
		echo("<INPUT TYPE=text NAME=\"info_url\"");
		if ($this->info_url)
		{
			echo(" VALUE=\"" . $this->info_url . "\"");
		}
		echo("><BR>\n");

		echo("<INPUT TYPE=checkbox NAME=\"hide_oc\" VALUE=\"yup\"");
		if ($this->hide_oc)
		{
			echo(" CHECKED");
		}
                echo(">\n");
                echo(_("Check this box to keep the event hidden from off-campus browsers.") . "<BR>\n");

		if ($GLOBALS["session"]->permissions &
			$GLOBALS["pApproveOwn"])
		{
			echo("<INPUT TYPE=checkbox NAME=\"preapproved\" VALUE=\"whee\"");
			if ($this->approver_id &&
				($this->approver_id == $this->submitter_id))
			{
				echo(" CHECKED");
			}
			echo(">\n");
			echo(_("Preapprove this event.") . "<BR>\n");
		}

		if ($this->approver_id)
		{
			echo("<INPUT TYPE=hidden NAME=\"approver_id\" VALUE=\""
				. $this->approver_id . "\">\n");
		}
		echo("<BR>\n");
	}

	function verifyAction($action)
	{
// check permissions and make sure this person can do what they're trying to
		if (!isSet($GLOBALS["SRCSessionKey"]))
		{
			return 0;
		}
		$session = new SRCSession();
		$session->loadSession($GLOBALS["SRCSessionKey"]);

		$perms_list = $session->permissions_list;
		if ((($temp = $perms_list["-1"]) > 0)
			&& ((($temp & $GLOBALS["p". $action ."Own"]) &&
			($this->submitter_id == $session->user_id)) ||
			(($temp & $GLOBALS["p". $action ."Other"]) &&
			($this->submitter_id != $session->user_id))))
		{
			return 1;
		}

		if ((($temp = $perms_list[$this->location_id]) > 0)
			&& ((($temp & $GLOBALS["p". $action ."Own"]) &&
			($this->submitter_id == $session->user_id)) ||
			(($temp & $GLOBALS["p". $action ."Other"]) &&
			($this->submitter_id != $session->user_id))))
		{
			return 1;
		}
	}

}

// this is a subclass which can be initialized from the hash that
//  pg_fetch_array returns
class SRCEventFromArray extends SRCEvent
{
	function SRCEventFromArray($array)
	{
		$this->initFromArray($array);
	}

	function initFromArray($array)
	{
		$this->event_id = $array["event_id"];
		$this->submitter_id = $array["submitter_id"];
		$this->title = $array["title"];
		$this->description = $array["description"];
		$this->location_id = $array["location_id"];
		$this->audience_id = $array["audience_id"];
		$this->category_id = $array["category_id"];
		$this->start_time = $array["start_time"];
		$this->end_time = $array["end_time"];
		$this->submitted_time = $array["submitted_time"];
		$this->info_url = $array["info_url"];
		$this->info_email = $array["info_email"];
		$this->approver_id = $array["approver_id"];		
		$this->hide_oc = $array["hide_oc"];
		$this->weekday_id = $array["weekday_id"];
		$this->modify_id = $array["modify_id"];
	}
}

// this subclass is initiallized with an event_id, which it uses to search
//  the database and fetch the required information
class SRCEventFromEventID extends SRCEventFromArray
{
	function SRCEventFromEventID($new_id)
	{
		$this->initFromEventID($new_id);
	}

	function initFromEventID($new_id)
	{
		$db_conn = connectROToCalendar();
		$query = "SELECT * FROM srcEvent WHERE event_id = " . $new_id;

		$result_id = @pg_exec($db_conn, $query);
		$this->initFromArray(@pg_fetch_array($result_id, 0));

		$query = "SELECT audience_id FROM srcAudienceList WHERE " .
			"event_id = " . $new_id;
		$result_id = @pg_exec($db_conn, $query);
		$num_rows = pg_numrows($result_id);

		for ($i = 0; $i < $num_rows; $i++)
		{
			$stuff = @pg_fetch_array($result_id, $i);
			$this->audience_id[$i] = $stuff["audience_id"];
		}

		$query = "SELECT category_id FROM srcCategoryList WHERE " .
			"event_id = " . $new_id;
		$result_id = @pg_exec($db_conn, $query);
		$num_rows = pg_numrows($result_id);
		for ($i = 0; $i < $num_rows; $i++)
		{
			$stuff = @pg_fetch_array($result_id, $i);
			$this->category_id[$i] = $stuff["category_id"];
		}

		$query = "SELECT day FROM srcWeekdaylist WHERE " .
			"event_id = " . $new_id;
		$result_id = @pg_exec($db_conn, $query);
		$num_rows = pg_numrows($result_id);
		for ($i = 0; $i < $num_rows; $i++)
		{
			$stuff = @pg_fetch_array($result_id, $i);
			$this->weekday_id[$i] = $stuff["day"];
		}
	}
}

// this subclass also fetches the string name that goes with each ID
class SRCEventWithStringsFromEventID extends SRCEventFromEventID
{
	function SRCEventWithStringsFromEventID($new_id)
	{
		$this->initFromEventID($new_id);
		$this->getStringsForIDs();
	}
}

// this gives us an empty event, suitable for outputting an empty edittable event
class SRCEmptyEvent extends SRCEvent
{
	function SRCEmptyEvent()
	{
		$this->event_id = $this->title = $this->description =
		$this->location_id = $this->audience_id = $this->category_id =
		$this->start_time = $this->end_time = $this->submitted_time =
		$this->submitter_id = $this->approver_id = $this->info_url =
		$this->info_email = $this->error = $this->location =
		$this->audience = $this->category = $this->submitter =
		$this->approver = $this->hide_oc = $this->weekday_id =
		$this->weekday = $this->modify_id = "";
	}
}

// this class works for grabbing values from a form that was just submitted
class SRCEventFromGlobals extends SRCEvent
{
	function SRCEventFromGlobals($session_var = "")
	{
		$this->initFromGlobals($session_var);
	}

	function initFromGlobals($session_var = "session")
	{
		global $start_month, $start_date, $start_year, $end_month,
			$end_date, $end_year, $start_hour, $start_minute,
			$end_hour, $end_minute, $title, $description,
			$info_url, $info_email, $start_pm, $end_pm, $hide_oc,
			$preapproved, $approver_id, $modify_id;

// We can check to make sure the date is valid, but the validate function will
// validate the rest of it
		if (!isSet($start_hour))
		{
			$start_hour = 0;
		}

		if (isSet($start_pm))
		{
			if ($start_hour <= 11)
			{
				$start_hour += 12;
			}
		}
		elseif ($start_hour == 12)
		{
			$start_hour = 0;
		}

		if ($start_hour > 23)
		{
			$this->start_time = -1;
			$this->error = "The starting hour is invalid.";
		}
		else
		{
			if (!isSet($start_minute))
			{
				$start_minute = 0;
			}
			elseif ($start_minute > 59)
			{
				$this->start_time = -1;
				$this->error = "The starting minute is invalid.";
			}
		}

// We have to validate the date before-hand because otherwise the mktime()
// function will roll over into the next month or year, and still create a
//  valid timestamp
		if (!checkDate($start_month, $start_date, $start_year) ||
			($this->start_time == -1))
		{
			$this->start_time = -1;
			$this->error = "The starting date is invalid.";
		}
		else
		{
			$this->start_time = mktime($start_hour, $start_minute,
				0, $start_month, $start_date, $start_year);
		}

		if ($end_hour || $end_minute || $end_month ||
				$end_date || $end_year)
		{
			if (!$end_month)
			{
				$end_month = $start_month;
			}

			if (!$end_date)
			{
				$end_date = $start_date;
			}

			if (!$end_year)
			{
				$end_year = $start_year;
			}

			if (!$end_hour)
			{
				$end_hour = 0;
			}

			if (isSet($end_pm))
			{
				if ($end_hour <= 11)
				{
					$end_hour += 12;
				}
			}
			elseif ($end_hour == 12)
			{
				$end_hour = 0;
			}

			if ($end_hour > 23)
			{
				$this->end_time = -1;
				$this->error = "The ending hour is invalid.";
			}

			if (!$end_minute)
			{
				$end_minute = 0;
			}
			elseif ($end_minute > 59)
			{
				$this->end_time = -1;
				$this->error = "The ending minute is invalid.";
			}

			if (!checkDate($end_month, $end_date, $end_year))
			{
				$this->end_time = -1;
				$this->error = "The ending date is invalid.";
			}
			else
			{
				$this->end_time = mktime($end_hour, $end_minute,
					0, $end_month, $end_date, $end_year);
			}
		}
		else
		{
			$this->end_time = 0;
		}

		$this->location_id = parsePulldown("location");
		$new_audience_id = parseCheckbox("audience");
		if(!is_array($new_audience_id))
		{
			$this->audience_id[0] = $new_audience_id;
		}
		else
		{
			$this->audience_id = $new_audience_id;
		}

		$new_category_id = parseCheckbox("category");
		if(!is_array($new_category_id))
		{
			$this->category_id[0] = $new_category_id;
		}
		else
		{
			$this->category_id = $new_category_id;
		}

		$new_weekday_id = parseCheckbox("weekday", -1);
		if (!is_array($new_weekday_id))
		{
			$this->weekday_id[0] = $new_weekday_id;
		}
		else
		{
			$this->weekday_id = $new_weekday_id;
		}

		$this->submitter_id = $GLOBALS[$session_var]->user_id;
		$this->title = $title;
		$this->description = $description;
		$this->info_url = $info_url;
		$this->info_email = $info_email;
		$this->approver_id =
			($preapproved && $this->verifyAction("Approve") ?
				$this->submitter_id : 0);

		if (isSet($approver_id))
		{
			$this->approver_id = $approver_id;
		}

		$this->hide_oc = ($hide_oc ? 1 : 0);
		$this->submitted_time = mktime();

		if (isSet($GLOBALS["event_id"]))
		{
			$this->event_id = $GLOBALS["event_id"];
		}		
		$this->modify_id = $modify_id;
	}
}


} //if included
?>
