<?php

// THIS SCRIPT IS COPYRIGHT (C) 2004 LIQUID FROG
// CHATTER BOX V1.0

// The URL of the folder where the chat is installed - *don't* add a trailing slash
$path_to_chat = "http://www.yoursite.com/chat_directory";

/* The dir on the server where the chat script is installed - *don't* add a trailing slash.
If you don't know what this path is, browse to www.yoursite.com/chat_directory/phpinfo.php.
The information you need for this field is about 17 lines down under Apache Environment ;) */
$dir_to_chat = "/home/httpd/vhost/yourdomain/httpdocs/chat_directory";


// The administrator's password
$admin_password = "pass";

// What to show the users on the index page
$title_chat_index = "Chat Now";

// The title of your chat window
$title_chat = "Chatter Box by Liquid Frog";

// The maximum of chatters allowed in chat at any one time (Max number is 8 - u could try 10 but it will slow your chat down)
$max_chatters = "8";


// The message to show when chat is full
$max_chatters_message = "CHAT is FULL! Please<br>wait until someone leaves";

// The message to show when a username is already in use
$username_taken_message = "Someone is already using that name - please choose another";

// The message to show when a login name is already used
$login_name_in_use_message = "This login name is already being used";

//The message to show if a connection isn't made to chat
$connection_error = "There was a problem connecting to chat!! Please close this window and try to connect again";

//The number of seconds before the chat is refreshed and new messages shown. Values below 3 not recommended. Between 3 and 8 is best
$refresh_period = "4";

//The label on the enter chat button
$submit_button_value = "Join Chat";

//The font for the invitation to chat page
$chat_index_font ="verdana";

//The font size for the invitation to chat page
$chat_index_font_size ="1";

//The width of the input field a user types his nick name into
$user_name_input_box_size = "10";

// The maximum number of characters a chatter can enter per message
$chat_msg_max_size = "180";

//The maximum length in characters the user name can be
$user_name_max_length = "10";

// The prompt to show to request user enters a nick name
$value_for_input_message ="Nick Name ";

//The message to invite the user to choose his color
$pick_a_color_message ="Your color";

//The message to invite the user to choose and use a gesture
$gestures_message = "Gestures";


//The message to show users whilst they are connecting
$connecting_message ="<BR>Attempting to connect..If you see this for more than<br> 10 secs just type in a space and press enter.<br>Please remember that if Chatter Box is near full, it may take a little <br>while to connect ;)";

$connected_ok = " - connected!";

// Whether to use banners or not. Values are true or false
$use_banners = true;

// Banner rotation method - can be "random" or "series". It defaults to "random". If series, banners are shown one after the other
$banner_rotation_method = "series";

// Refresh interval for banners. 5000 = 5 seconds
$banners_refresh_interval = 5000;

//The message to show when a chatter enters the chat room
$has_entered_the_room_message = "knocks on the door and enters chat";

// The chat username of the Admin user
$admin_chat_username = "Admin";

// Message for when admin enters the chat
$admin_has_entered_the_room_message = "Admin is online!";


//Prompt for the chat window where the user types his message
$text_your_msg = " Say this";

//The message to show when chat is empty
$nobody_chatting_message = "The chat room is<br>waiting for you";

//The message to show when there is one person in chat
$one_person_chatting_message ="There is 1 person<br>waiting to chat";

//The message to show when there is more than one person in chat
$more_than_one_person_chatting_message = "people are currently chatting";

//The number of items to show in the Back Chat history log
$chat_history_number = "200";

//The message to show users for who is chatting now?
$who_chatting_now_message = "(who is chatting now?)";

//The message to show in who is online
$who_in_chat_message = "Who is in the chat room?";

//The message to show in who is chatting now for the synopsis. Leave blank if you set $synopsis_value=0
$chatting_about_this = "This is what they are currently chatting about:";

//The number of messages to show in who is chatting now. Leave $chatting_about_this blank if this value is set to 0
$synopsis_value = "10";

//The message to show when a chatter wants to leave. The \\n is a line return
$sure_to_quit ="Leave chat? \\nare you mad?";

//The length of time a user can be idle before being disconnected
$time_out_value ="1000";

//The message to show when a user times out
$time_out_error = "You have been idle too long - Reconnect!";

// Connection delay - how many seconds to wait before disconnecting a user
$connection_delay = 300;

//
// These paths are automatically generated. It is best not touch them.
//
$path_to_help = $path_to_chat . "/help.php"; //The path to the help file. It must end with help.php e.g. http://www.yoursite.com/chat_directory/help.php
$path_to_chat_history = $path_to_chat . "/back_chat.php"; //The path to the chat history file. It must end with back_chat.php e.g. http://www.yoursite.com/chat_directory/back_chat.php
$path_to_who_is_chatting = $path_to_chat . "/who_is_chatting.php";//The path to the who_is_chatting file. It must end with who_is_chatting.php e.g. http://www.yoursite.com/chat_directory/who_is_chatting.php
$path_to_smilies =  $path_to_chat . "/smilies";
$path_to_banners = $path_to_chat . "/banners";

//+++++++++++++++++++++++++++++++++++++++++++++//

//OPTIONS: Make any changes you need by following the examples

//+++++++++++++++++++++++++++++++++++++++++++++//
$option=Array();

//+++++++++++++++++++++++++++++++++++++++++++++//

//If you want to add other colors you must set $option["chat_colors"]=12; to the total number of colors. Likewise if you want to remove colors. You can copy the last line and add your own details to add colors
$option["chat_colors"]=12;
$option["chat_color1"]="Green";
$option["chat_color2"]="Orange";
$option["chat_color3"]="Navy";
$option["chat_color4"]="Blue";
$option["chat_color5"]="Red";
$option["chat_color6"]="Lime";
$option["chat_color7"]="Black";
$option["chat_color8"]="Magenta";
$option["chat_color9"]="Gray";
$option["chat_color10"]="DarkGray";
$option["chat_color11"]="Pink";
$option["chat_color12"]="Cyan";
//$option["chat_color13"]="Enter color here";
//+++++++++++++++++++++++++++++++++++++++++++++//

//If you want to add other smilies you must set $option["chat_csmilies"]=12; to the total number of smilies. Likewise if you want to remove smilies. You can copy the last line and add your own details to add smilies
$option["chat_smilies"]=12;
$option["chat_smiley1"]=":)"; $option["chat_smiley_gif1"]="<IMG src='$path_to_smilies/icon_smile.gif' width=15 height=15 border=0>";
$option["chat_smiley2"]=":D"; $option["chat_smiley_gif2"]="<IMG src='$path_to_smilies/icon_biggrin.gif' width=15 height=15 border=0>";
$option["chat_smiley3"]=":EEK"; $option["chat_smiley_gif3"]="<IMG src='$path_to_smilies/icon_eek.gif' width=15 height=15 border=0>";
$option["chat_smiley4"]=":8"; $option["chat_smiley_gif4"]="<IMG src='$path_to_smilies/icon_cool.gif' width=15 height=15 border=0>";
$option["chat_smiley5"]=":S"; $option["chat_smiley_gif5"]="<IMG src='$path_to_smilies/icon_confused.gif' width=15 height=15 border=0>";
$option["chat_smiley6"]=":("; $option["chat_smiley_gif6"]="<IMG src='$path_to_smilies/icon_cry.gif' width=15 height=15 border=0>";
$option["chat_smiley7"]=":!"; $option["chat_smiley_gif7"]="<IMG src='$path_to_smilies/icon_exclaim.gif' width=15 height=15 border=0>";
$option["chat_smiley8"]=":LOL"; $option["chat_smiley_gif8"]="<IMG src='$path_to_smilies/icon_lol.gif' width=15 height=15 border=0>";
$option["chat_smiley9"]=":?"; $option["chat_smiley_gif9"]="<IMG src='$path_to_smilies/icon_question.gif' width=15 height=15 border=0>";
$option["chat_smiley10"]=":P"; $option["chat_smiley_gif10"]="<IMG src='$path_to_smilies/icon_razz.gif' width=15 height=15 border=0>";
$option["chat_smiley11"]=":ROLL"; $option["chat_smiley_gif11"]="<IMG src='$path_to_smilies/icon_rolleyes.gif' width=15 height=15 border=0>";
$option["chat_smiley12"]=";)"; $option["chat_smiley_gif12"]="<IMG src='$path_to_smilies/icon_wink.gif' width=15 height=15 border=0>";
//$option["chat_smiley13"]="Text shortcut in here"; $option["chat_smiley_gif13"]="<IMG src='smiley_to_use.gif' width=xx height=xx border=0>";


//If you want to add other gestures you must set $option["chat_festure"]=12; to the total number of gestures. Likewise if you want to remove gestures. You can copy the last line and add your own details to add getures
$option["chat_gesture"]=12;
$option["chat_gesture1"]="!LO!"; $option["chat_gesture_val1"]="Hi everyone! I have arrived so let the fun begin!!";
$option["chat_gesture2"]="!FT!"; $option["chat_gesture_val2"]="I fart in your general direction";
$option["chat_gesture3"]="!BF!"; $option["chat_gesture_val3"]="I barf all over you and use your hair to wipe myself clean";
$option["chat_gesture4"]="!CL!"; $option["chat_gesture_val4"]="I cuddle up to you purring like a pussy cat";
$option["chat_gesture5"]="!SL!"; $option["chat_gesture_val5"]="you are so boring that I fall asleep and snore loudly";
$option["chat_gesture6"]="!LN!"; $option["chat_gesture_val6"]="I'll ring the loony farm on your behalf 'cos you're obviously off your head";
$option["chat_gesture7"]="!SP!"; $option["chat_gesture_val7"]="I slap you in the face with a very cold wet haddock";
$option["chat_gesture8"]="!CF!"; $option["chat_gesture_val8"]="I cough and splutter in disbelief at your assenine statement - how can you say such a thing?";
$option["chat_gesture9"]="!FR!"; $option["chat_gesture_val9"]="I show you a single raised middle finger which I slowly rotate in the air ;)";
$option["chat_gesture10"]="!TR!"; $option["chat_gesture_val10"]="I throw down my rattle and stamp my foot in a fit of juvenille pique";
$option["chat_gesture11"]="!IG!"; $option["chat_gesture_val11"]="I turn my back on you, fold my arms, put my nose in the air and just ignore you";
$option["chat_gesture12"]="!SM!"; $option["chat_gesture_val12"]="I look smugly around the room at the other chatters who understand what has been said";
//$option["chat_gesture13"]="!AN!"; $option["chat_gesture_val13"]="This gesture has a text shortcut of !AN! - change this to match your needs";

$option["bad_word"]=1;
$option["bad_word1"]="arse"; $option["bad_word_repl1"]="%>*!";
//$option["bad_word2"]="some other bad word"; $option["bad_word_repl1"]="some other bad word replacement";
//+++++++++++++++++++++++++++++++++++++++++++++//

?>