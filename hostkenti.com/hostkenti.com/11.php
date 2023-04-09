<?php
// live score script
$scorefile = "http://livechat.rediff.com/sports/score/score.txt";
$score = file($scorefile); // Get the current score
if ( $score == NULL ){ // Check to see if there is a score
$disp = "No Score Available";
}
elseif ($score[1] != NULL) {
$match = substr($score[0], 3, -1); // Take the last letter (endline char) out of the first line
$match1 = substr($score[1], 3, -1);
$match2 = substr($score[3], 8, -1);
$disp = "LIVE----$match2----$match----$match1";
}
elseif ($score[1] == NULL) {
$disp = "LIVE----$match2----$match----$match1";
}
$width = strlen($disp) * 9 + 16; // Setting width of png
$prebackcolor = imagecolorallocate($img_disp,0,0,0); // Assign the background color
$backcolor = imagecolortransparent($img_disp,$prebackcolor); // Make the bg transparent, if the page is alone, make it black
$textcolor = imagecolorallocate($img_disp,255,0,0); // Assign the text color
imagefill($img_disp,0,0,$backcolor); // Fill the image with the background color
imagestring($img_disp,10,5,55,$disp,$textcolor);
header("Content-type: image/png");
imagepng($img_disp); // Draw the image
imagedestroy($img_disp); // Delete the image from the server's memory
?>