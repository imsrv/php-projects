<?
	include("include/common.php");
	include("include/header.php");
?>
	<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		
    <td> <p><b>Rules for 
        <?=$sitename?>
        </b></p>
      <p><b>What is this? How do I use it?</b><br>
        This is free file hosting. You click the browse button, select a file 
        on your computer, and click upload. We'll store your files online, give 
        you a URL you can access it at, share it with friends, and post it on 
        forums. Yes, it's 100% free. <br>
        <br>
        HOWEVER, this service is not meant for hosting all the Files on your 
        website. It is for people without websites or that don't want to use their 
        own web space to share Files. If you use our service to host many Files 
        on an active website, we will delete the Files. <br>
        <br>
        <b>What can I do to help?</b><br>
        Tell your friends and family about this site!<br>
        <br>
        <b>Is registration required?</b><br>
        No, you do not have to register to use our service. It's 100% free for 
        you to use. However using the free, anonymous upload does not allow you 
        to delete and change Files. You must register to use these features.<br>
        <br>
        <b>What file formats do your support?</b><br>
        You can upload 
        <?=implode(",",explode("|",$att_filetypes))?>
        files. Your files should have the correct extensions, and the filenames 
        should not include spaces or invalid characters. <br>
        <br>
        <b>What is the maximum filesize?</b><br>
        The maximum filesize is 
        <?=$att_max_size?>
        KB. <br>
        <br>
        <b>How long will you host my files?</b><br>
        We keep files online at least 30 days. Sometimes we delete old files 
        less often, but if you need to share a file longer than that, upload 
        it again every couple weeks. <br>
        <br>
        <b>What kinds of files will you host?</b><br>
        We'll host any file you have the legal rights to use. Anything illegal in nature, or a file you don't 
        have rights to, will be deleted and your IP address turned over to the 
        authorities. <br>
        <br>
        Also, make sure you read our <a href="rules.php">rules</a> before uploading 
        anything. </p>
      </td>
	</tr>
	</table>
<?
	include("include/footer.php");
?>