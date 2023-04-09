<?php
/***************************************************************
** Title.........: CaLogic Reminder Config file
** Version.......: 1.0
** Author........: Philip Boone <philip@boone.at>
** Filename......: remcfg.php
** Last changed..: 
** Notes.........: 
** Use...........: This File configures how reminders get dealt with
                   If you do not plan to use reminders, then you don't
                   need to change anything in this file

The script that sends reminders is named srxclr.php and is
located in the CaLogic root directory.
READ THE TEXT FILE README_REMINDERS.TXT FOR INFORMATION ON
SETTING UP REMINDERS.                    

** VARIABLES TO SET AND THIER EXPLANATIONS
** $rfrequency, $rinterval and $rdahead

** $rfrequency
** NOTE: The frequency at which you will call the reminder script
         you should not call the script more often than every
         5 minutes, unless you are sure your server can handle
         the load. And you should at least call it once a day.
           
** $rinterval
** NOTE: This is the interval of the frequency
         1 = minutes
         2 = hours
         3 = days

** EXAMPLES:

** every 5 minutes 
** $rfrequency = 5;
** $rinterval = 1;

** every 1 hours
** $rfrequency = 1;
** $rinterval = 2;

** every 1 days 
** $rfrequency = 1;
** $rinterval = 3;


** $rdahead
** NOTE: This tells CaLogic how many days into the future to
         check for events with reminders. Valid ranges are 
         from 1 to 365. A good setting would be 30.

END OF EXAMPLES         

ADDITIONAL INFORMATION:

These three variables also effect what a user can set the reminder
to in an event. i.e. the minimum and maximum values that en event
reminder can be set to is controled by these three variables.

For example:
we set the variables to the following values:

$rfrequency = 10;
$rinterval = 1;
$rdahead = 30;

Which means you will run the event script every ten minutes, and
the script will look a maximum of 30 days into the future for
repeating events with reminders. Non repeating events will be checked
no matter how far into the future they are.

Also with this setting, in the event form, the user would only be able to 
define a reminder between 10 minutes and 30 days.


***************************************************************/   

/*** SET VARIABLES HERE *****/ 

$rfrequency = 5;
$rinterval = 1;
$rdahead = 30;

?>