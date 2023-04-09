<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * LinkCycle version 2.0
 *
 * Copyright (c) 2002 Holotech Enterprises (linkcycle@holotech.net)
 *
 * You may freely distribute this script as-is, without modifications,
 * and with the accompanying files. You may use this script freely, and
 * modify it for your own purposes. This script is email-ware: if you
 * find it useful, you MUST e-mail me and let me know. This IS the pay-
 * ment that is required. If you do not make this payment, then you are
 * using this program illegally.
 *
 * Version 2.0 development sponsored by
 *   Creative Innovations
 *   http://get-signups.com/
 * 
 *                                                 Alan Little
 *                                                 May 2002
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
// The URL of the LinkCycle script
  $ScriptURL = "http://www.yourdomain.com/linkcycle.php3";

// Default URL to re-direct to if there are no links with hits
  $DefaultLink = "http://www.holotech.net/scripts.html";

// Default Text to display if there are no links with impressions
  $DefaultText = "Link Cycle";

// Encoding key for user login. It can be anything.
  $UserKey = "There are conditions worse than being unable to see, and that is imagining one sees.";

// LogData[] contains variables to include in the text log, in addition to 
// logging the URL clicked on. They can be any variables you want, these 
// two are included merely as examples.
  $LogData[0] = "HTTP_USER_AGENT";
  $LogData[1] = "HTTP_HOST";

// Indicates whether to decrement the hit counter and whether to consider 
// the hit count when re-directing. Set to true or false.
  $CountHits = true;

// Indicates whether to decrement the impression counter and whether to 
// consider the impression count when displaying. Set to true or false.
  $CountImps = true;

// Indicates whether to perform text logging. Set to true or false.
  $TextLog = true;

// Indicates whether to perform database logging. Set to true or false.
  $DBLog = true;

// Your database information.
  $DPass = "";
  $DUser = "";
  $DHost = "";
  $DBase = "";

/* Period: how often to cycle the displayed link. The link will also cycle 
   if $CountImps is true and a link runs out of impressions before the 
   specified time:
   0   = Every time the page loads.
   1-7 = Once a week on the specified day.
   8   = Every hour.
   9   = Every 12 hours.
   10  = Every day.
   11  = According to the daily schedule specified in linksched.inc
   12  = When the current link runs out of impressions
   -#  = Once a month on the specified day. If you specify the 31st,
         it will change on the last day of shorter months.           */
  $Period = 0;

/* HitPeriod: how often to cycle the hit link. The link will also cycle if
   $CountHits is true and a link runs out of hits before the specified 
   time:
   0   = Every time there's a hit.
   1-7 = Once a week on the specified day.
   8   = Every hour.
   9   = Every 12 hours.
   10  = Every day.
   11  = According to the daily schedule specified in linksched.inc
   12  = When the current link runs out of hits
   -#  = Once a month on the specified day. If you specify the 31st,
         it will change on the last day of shorter months.           */
  $HitPeriod = 0;

/*
  Examples for $Period and $HitPeriod:
  $Period = 2; Change every Monday
  $Period = -12; Change on the 12th of every month
  $Period = -31; Change on the last day of every month
*/
?>