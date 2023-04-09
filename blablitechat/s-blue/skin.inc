<?php

$skin_name='s-blue';
$skin_license='GPL';
$skin_author_url='http://hot-things.net';  // a 'mailto:' link can also be used: 'mailto:email@email.com'

//--------------------------------------------------------------------------------------------

// FRAMESET ROWS - set height for the top and bottom frames and leave '*' for the middle

$fset='100,*,51';

//--------------------------------------------------------------------------------------------

// IMAGE ARRAY
//
// the elements in this array are called by the function show_pic() which prints image tags
// the format of each element is:
//
// file_name|width|height|alt_attribute|onmouseover_image|additional_attribute
//
// ( separator: | - you should always have 5 '|' in each element )
//
//  - "alt_attribute" might be taken from the language file /if you don't need it must exist as a blank/
//  - "additional_attribute" - e.g. hspace=\"0\" or onclick=\"alert('bla-bla')\"
//  - additional attributes can also be set as a second argument of the function show_pic(): show_pic($pics[0],'hspace="0"')
// 
// the background images are set in: skin_dir/style.css

$pics[0]="admin1.png|72|26|$lang[12]|admin2.png|";  // admin
$pics[1]="smile1.png|72|26|$lang[13]|smile2.png|";  // smilies
$pics[2]="rooms1.png|72|26|$lang[14]|rooms2.png|";  // rooms
$pics[3]="rfrsh1.png|44|44|$lang[15]|rfrsh2.png|";  // refresh
$pics[4]="chatt1.png|60|26|$lang[16]|chatt2.png|";  // chat
$pics[5]="hstry1.png|80|26|$lang[17]|hstry2.png|";  // history
$pics[6]="exitt1.png|42|42|$lang[18]|exitt2.png|";  // logout
$pics[7]="offset.png|38|11|$lang[24]||";            // time offset
$pics[8]="set_av.png|22|15|$lang[10]||";            // set avatar image
$pics[9]="tempim.png|50|50|$lang[10]||";            // will be loaded if image loading is aborted

// $pics[10]-$pics[12] are not called by show_pic(). However, the format of the elements is the same

$pics[10]="mssg1.png|42|42|$lang[55]|mssg2.png|";   // sound alert (on/off)
$pics[11]="rrate1.png|12|10|$lang[19]|rrate2.png|"; // refresh rate pics (default/onmouseover)
$pics[12]="rrate1.png|12|10|$lang[19]|rrate3.png|"; // refresh rate pics (default/on)

//--------------------------------------------------------------------------------------------

// SMILEY ARRAY
// 
// the format of each element is:
//
// smiley_code|file_name|width|height|alt_attribute
//
// you can use :-), :( etc as smiley codes
// separator: | - you should always have 4 '|' in each element

$smilies=array();
$smilies[0]="[smile]|s-smile.png|18|18|$lang[39]";
$smilies[1]="[blink]|s-blink.png|18|18|$lang[40]";
$smilies[2]="[cheerful]|s-cheerful.png|18|18|$lang[41]";
$smilies[3]="[cool]|s-cool.png|18|18|$lang[42]";
$smilies[4]="[grin]|s-grin.png|18|18|$lang[43]";
$smilies[5]="[happy]|s-happy.png|18|18|$lang[44]";
$smilies[6]="[hmm]|s-hmm.png|18|18|$lang[45]";
$smilies[7]="[kissing]|s-kissing.png|18|18|$lang[46]";
$smilies[8]="[laughing]|s-laughing.png|18|18|$lang[47]";
$smilies[9]="[lost]|s-lost.png|18|18|$lang[48]";
$smilies[10]="[oops]|s-oops.png|18|18|$lang[49]";
$smilies[11]="[unhappy]|s-unhappy.png|18|18|$lang[50]";

//--------------------------------------------------------------------------------------------

// TURING NUMBER - foreground and background colors

$bg['r']=0x51;                       // bg color - RED
$bg['g']=0x80;                       // bg color - GREEN
$bg['b']=0xce;                       // bg color - BLUE
$fg['r']=0xff;                       // fg color - RED
$fg['g']=0xff;                       // fg color - GREEN
$fg['b']=0xff;                       // fg color - BLUE
?>