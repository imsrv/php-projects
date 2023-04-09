<?php

	/*
		RANDOM EMAIL MARKETING TIPS:

		These tips display along the top of the SendStudio control panel, and can allow you or your users
		to learn email marketing best practices, tips and tricks to improve your email results. The "Read More..."
		link at the end of each tooltip links through to a complete article based on the tip being displayed.
		Feel free to take these articles from our site, Interspire.com and upload them to your own website.
		Then, you can change the links below to reference the articles on your site instead of ours.
	*/

	// This is the main link to the articles
	$articleLink = "http://www.interspire.com/articles/email_marketing/email_marketing_tips.php";
	
	$r = @rand(1, 15);
	$theTip = "";

	switch($r)
	{
		case 1:
		{
			$theTip = "To avoid having your email marked as spam, keep clear of words such as 'Free', '$$$', 'Save'  and 'Discount' in your subject line.";
			$articleLink .= "#ss1";
			break;
		}
		case 2:
		{
			$theTip = "For maximum click-thru rates when creating HTML newsletters, make sure your links are blue, underlined and optionally bold.";
			$articleLink .= "#ss2";
			break;
		}
		case 3:
		{
			$theTip = "Using personalization in your emails (such as 'Hi John' instead of 'Hi there') will increase your open rate by up to 650%";
			$articleLink .= "#ss3";
			break;
		}
		case 4:
		{
			$theTip = "Always make sure you include an unsubscribe link. You can do this by adding the text %BASIC:UNSUBLINK% anywhere in your newsletter.";
			$articleLink .= "#ss4";
			break;
		}
		case 5:
		{
			$theTip = "To reduce the number of bogus email addresses in your mailing list, always use a double opt-in subscription system.";
			$articleLink .= "#ss5";
			break;
		}
		case 6:
		{
			$theTip = "The best days to send a marketing or sales email to your subscribers has been proven to be Tuesday and Wednesday.";
			$articleLink .= "#ss6";
			break;
		}
		case 7:
		{
			$theTip = "Why not setup an autoresponder to send to your subscribers 1 hour after they signup. You can use it to tell them more abour your company, products or services.";
			$articleLink .= "#ss7";
			break;
		}
		case 8:
		{
			$theTip = "Keep the theme of your newsletter consistent. Create a text or HTML template and use that template whenever you create a new issue.";
			$articleLink .= "#ss8";
			break;
		}
		case 9:
		{
			$theTip = "For best results when sending a newsletter, always send it on the same day at the same time. For example, every 2nd Wednesday at 3pm.";
			$articleLink .= "#ss9";
			break;
		}
		case 10:
		{
			$theTip = "Make sure your subject line is persuasive and catches your readers attention. Instead of using something like 'OurSite Newsletter Issue #1', use a benefit, such as 'OurSite Newsletter: 10 Tips for Financial Freedom'.";
			$articleLink .= "#ss10";
			break;
		}
		case 11:
		{
			$theTip = "If running a newsletter, offer your customers a free bonus (such as an eBook or special report) for signing up. Then, create an autoresponder to email them a link to that bonus 1 hour after they subscribe.";
			$articleLink .= "#ss11";
			break;
		}
		case 12:
		{
			$theTip = "Always have some interesting content at the top of your email, as this is the part that will show in the preview window of your clients email program, such as MS Outlook.";
			$articleLink .= "#ss12";
			break;
		}
		case 13:
		{
			$theTip = "Try using different wording for links in your marketing emails. Then, click on the stats button above to track which links received the most clicks and use them for future campaigns.";
			$articleLink .= "#ss13";
			break;
		}
		case 14:
		{
			$theTip = "Setup an email-based course for your subscribers. To do this, simply create a series of autoresponders (for example, 5) containing unique content. Then, schedule the first one to go out after 24 hours, the second after 48 hours, etc.";
			$articleLink .= "#ss14";
			break;
		}
		case 15:
		{
			$theTip = "Always include a signature at the bottom of your emails. You can use your signature to link back to your website, and even to your other products. Here's a sample signature: Regards, John Doe. President - Company XYZ. Visit our website at www.companyxyz.com";
			$articleLink .= "#ss15";
			break;
		}
	}

	?>
		<table width="94%" align="center" cellspacing="0" cellpadding="0" class="infoBallon">
			<tr>
				<td height="25" style="padding:5">
					<img src="<?php echo $ROOTURL; ?>admin/images/infoballon.gif" align="left" width="23" height="16">
					<b>Email Marketing Tip #<?php echo $r; ?>:</b> <?php echo $theTip . " <a href=$articleLink target=_blank>Read More...</a>"; ?>
				</td>
			</tr>
		</table>
		<br>
