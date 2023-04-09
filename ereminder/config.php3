<?
/*	This is where you set the default E-mail address	
	(i.e. if $default_email is set to @company.com, then any E-mail
	addresses entered without an @ symbol in them will automatically
	have @company.com appended to them)
*/ 
$hostmask="@associate.com";

/*	The web site location where E-reminders will be
	available.	*/
$site="http://associate.com/e-reminder";

/*	MySQL Database Information:  Read the README file for more
	information.  	*/

$dbhost= "localhost";
$dbuser= "root";
$dbpass= "";
$dbname= "reminders";

/* Specify the length of the generated random password for new users */
$passlength= "6";

/* Specify the timezone your MySQL server runs in */
$dbtimezone= "EST";

/* Timezone correction factor: in the list below, find your MySQL 
server's timezone and determine the number needed to make the first
number be zero.  For example, a server in Jakarta needs "-8" to cancel
out the first number. */

$dbtzcorrect= "4";  /* this server is in EST */

/*
1 = GMT Greenwich Mean Time, London, Dublin, Edinburgh
2 = GMT+1 Berlin,Rome,Paris,Stockholm,Warsaw,Amsterdam
3 = GMT+2 Israel, Cairo, Athens, Helsinki, Istanbul
4 = GMT+3 Moscow, St. Petersburg, Kuwait, Baghdad,
5 = GMT+4 Abu Dhabi, Muscat, Mauritius, Tbilisi, Kazan
6 = GMT+5 Islamabad, Karachi, Ekaterinburg, Tashkent
7 = GMT+6 Zone E7, Almaty, Dhaka
8 = GMT+7 Bangkok, Jakarta, Hanoi
9 = GMT+8 Hong Kong, Beijing, Singapore, Taipei
10 = GMT+9 Tokyo, Osaka, Seoul, Sapporo, Yakutsk
11 = GMT+10 Sydney, Melbourne, Guam, Vladivostok
12 = GMT+11 Zone E12, Magadan, Soloman Is.
-11 = GMT+12 Fiji, Wellington, Auckland, Kamchatka
-10 = GMT-11 Zone W11, Miway Island, Samoa
-9 = GMT-10 Hawaii
-8 = GMT-9 Alaska, Anchorage
-7 = GMT-8 PST-Pacific US, San Francisco, Los Angeles
-6 = GMT-7 MST-Mountain US, Denver, Arizona,
-5 = GMT-6 CST-Central US,Chicago,Mexico,Sackatchewan
-4 = GMT-5 EST-Eastern US, New York, Bogota, Lima
-3 = GMT-4 Atlantic, Canada, Barbados, Caracas,La Paz
-2 = GMT-3 Brazilia, Buenos Aries, Rio de Janeiro
-1 = GMT-2 Zone W2, Mid-Atlantic
0 = GMT-1 Zone W1, Azores, Cape Verde Is.  
*/
