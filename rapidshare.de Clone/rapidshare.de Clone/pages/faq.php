<?php
//  ___  ____       _  ______ _ _        _   _           _   
//  |  \/  (_)     (_) |  ___(_) |      | | | |         | |  
//  | .  . |_ _ __  _  | |_   _| | ___  | |_| | ___  ___| |_ 
//  | |\/| | | '_ \| | |  _| | | |/ _ \ |  _  |/ _ \/ __| __|
//  | |  | | | | | | | | |   | | |  __/ | | | | (_) \__ \ |_ 
//  \_|  |_/_|_| |_|_| \_|   |_|_|\___| \_| |_/\___/|___/\__|
//
// by MiniFileHost.co.nr                  version 1.1
//////////////////////////////////////////////////////// ?>
   <center><table style="margin-top:20px;width:790px;height:400px;"><tr><td style="border:1px #AAAAAA solid;height:100%;background-color:#FFFFFF;padding:20px;text-align:left;" valign=top>
 <h1>What is the largest file I can upload?</h1>
	<p>The maximum allowed file size is <?php echo $maxfilesize; ?> megabytes.</p>
    <h1>How long will my files stay hosted here?</h1>
	<p>Your files will be kept on our servers as long as it is downloaded every <?php echo $deleteafter; ?> days.</p>
    <h1>What are the limits for uploading and downloading files?</h1>
	<p>You may upload a file every <?php echo $uploadtimelimit; ?> minutes.<br />
	You may download a file every <?php echo $downloadtimelimit; ?> minutes.</p>
    <h1>What about smaller files?</h1>
	<p>Files less than <?php echo $nolimitsize; ?> megabytes don't count towards your upload or download limits.</p>
    <h1>How can I run a file hosting site like this?</h1>
	<p>Just visit <a href="http://www.minifilehost.co.nr">MiniFileHost.co.nr</a> and download the Mini File Host script. Its easy to set up and use!
</center></td></tr></table><p style="margin:3px;text-align:center">