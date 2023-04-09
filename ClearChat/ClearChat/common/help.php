<?php
require "../common/config.php";
?>
<html>
<head>
<title>ClearChat Help/FAQ</title>
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">
<link rel="stylesheet" href="../common/clearchat.css" type="text/css">
</head>
<body bgcolor="#000044" class="view">

<a name="top">&nbsp;</a>
<nobr>
<a href="Javascript: top.close()">Close</a>
<span class="say"> : </span>
<a href="<?php echo $siteurl; ?>" target="_blank">Open site</a>
<span class="say"> : </span>
<a href="Javascript:void(0);" onClick='window.open("../copyright.php", "Copyright", "toolbar=no, location=no, directories=no, status=no, scrollbars=yes,  resizable=no, copyhistory=no, width=500, height=270")'>©</a>
</nobr>
<br><br>

<span class="heading">ClearChat help/FAQ</span>
<br>
<br>
<br>
<span class="nick">Questions overview</span>

<span class="say">
<ol>
<li><a href="#q1">How do I use ClearChat?</a>
<li><a href="#q2">Can I use BB code in the chat? What about HTML?</a>
<li><a href="#q3">Can I see what was said in the chat earlier?</a>
<li><a href="#q4">How do I know when a comment was posted?</a>
<li><a href="#q5">Who made this chat and where can I get a copy?</a>
</ol>
</span>

<br>
<br>

<span class="nick">Questions with answers</span>
<br>


<span class="say">
<ol>

<li><a name="q1"></a>
<span class="nick">How do I use ClearChat?</span>
<br>
<span class="say">ClarChat is integrated with the PHP-Nuke so you dont have to log in one more time to use the chat. Once you are logged in as a member in PHP-Nuke you are also logged in in the chat. Just type whatever you want to say in the input-field and hit enter or click on [Say]. This chat uses HTML (and PHP behind the scenes), and will not refresh the way IRC chats do. The main chat will refresh every <?php echo $refreshrate; ?> seconds and you will then see the new comments. However, when the input-field is empty you can click on [Say] to refresh the chat manually. To use smilies just click on a smiley to add it to the input field. When you submit, the text-smiley will be transformed into a graphic smiley (if it is correct). Click on =) just below the input field to see a list of the available smilies. If you want to chat without having the rest of the site up, you can click on [Undock] just below the input field and the chat will open in a new separate window.</span>


<br>
<br>

<a href="#top">[Return to top]</a>

<br>
<br>
<br>
<br>


<li><a name="q2"></a>
<span class="nick">Can I use BB code in the chat? What about HTML?</span>
<br>
<span class="say"><?php if ($allowbbcode == "yes") {
echo "Yes! This site lets you use BB code in the chat. The valid codes are [B] (bold), [I] (Italics), [U] (Underline), [S] (Strike-through text), [SMALL] (Small text), [BIG] (Big text). You use the BB codes by surrounding text with a starting- and ending-tag. Example: Typing [B] at the beginning and [/B] at the end will make everything in between bold text. Examples: [BIG]This will be big text[/BIG]&nbsp;&nbsp;&nbsp;[BIG][B]This will be big, bold text[/B][/BIG] ";
} else {
echo "No. The chat has BB code support, but the administrator of this site has turned that feature off. ";
} ?> Due to security reasons HTML is disabled by default.</span>

<br>
<br>

<a href="#top">[Return to top]</a>

<br>
<br>
<br>
<br>

<li><a name="q3"></a>
<span class="nick">Can I see what was said in the chat earlier?</span>
<br>
<span class="say">Yes, Click the <a href="log.php" target="_blank">log-link</a> just below the chats input field. The log will show the last <?php echo $logoutputnumber; ?> comments.</span>

<br>
<br>

<a href="#top">[Return to top]</a>

<br>
<br>
<br>
<br>

<li><a name="q4"></a>
<span class="nick">How do I know when a comment was posted?</span>
<br>
<span class="say">Just hover your mouse over a comment or nickname and you will see the date and time when it was posted. (You will also notice there is a timestamp at the top of the comments. This combined with the hovering-procedure I just explained, will give you an idea of when something was last posted. Just so you dont start talking with someone who left a few hours ago.)</span>

<br>
<br>

<a href="#top">[Return to top]</a>

<br>
<br>
<br>
<br>

<li><a name="q5"></a>
<span class="nick">Who made this chat and where can I get a copy?</span>
<br>
<span class="say">A norwegian guy with the nickname "Sensei" made the chat when <a href="http://www.streamingsoundtracks.com" target="_blank">StreamingSoundtracks.com</a> (where he was a forum moderator) switched to PHP-Nuke. We needed a new chat so we made one. Special thanks to <a href="http://www.geotrail.no" target="_blank">GeoTrail</a> for acting as a living PHP-bible, and the the audience of SST for beta testing the chat. Go <a href="http://www.streamingsoundtracks.com/modules.php?name=ChatInfo" target="_blank">here</a> to find out more about getting your own chat.</span>

<br>
<br>

<a href="#top">[Return to top]</a>


<br>
<br>
<br>
<br>
<br>
<br>

<div class="center">
<span class="nick">Got an unanswered question?</span>
<br>
<span class="say">Send an e-mail to <a href="mailto:sensei@streamingsoundtracks.com?subject=ClearChat question">sensei@streamingsoundtracks.com</a></span>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</body>
</html>