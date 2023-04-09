<?php

	// This file will simply create a table and list all files in the directory
	// To add your own HTML, simply edit the two lines below:

	$topTemplateHTML = "";
	// Example:
	// $topTemplateHTML = "<b>MySite.com Newsletter Archive</b><hr>";

	$bottomTemplateHTML = "";
	// Example:
	// $topTemplateHTML = "<a href=mysite.com>Return to our home page</a>";

	$font = "Verdana";
	$fontSize = "10pt";

	echo $topTemplateHTML;

	// Do not modify below this line
	if($dHandle = @opendir("./"))
	{
	?>
		<h2 style="margin-left:20; font-family: <?php echo $font; ?>">Newsletter Archive</h2>
		<table width="90%" align="center" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
					&nbsp;
				</td>
				<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
					<b><i>Name</i></b>
				</td>
				<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
					<b><i>Issues</i></b>
				</td>
			</tr>
			<tr>
				<td colspan="5"><hr></td>
			</tr>

		<?php

		while (false !== ($file = readdir($dHandle)))
		{
			if($file != "." && $file != ".." && $file != "images")
			{
				// Workout the name of the newsletter
				$theFile = $file;

				if(is_dir($file))
				{
					if($fHandle = @opendir($file))
					{
						$numIssues = 0;
	
						while (false !== ($f = @readdir($fHandle)))
						{
							if($f != "." && $f != ".." && $f != "index.php")
							{
								$numIssues++;
							}
						}
					}

					@closedir($fHandle);
					?>
						<tr>
							<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
								<img src="images/folder.gif">
							</td>
							<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
								<a href="<?php echo urlencode($theFile); ?>"><?php echo $theFile; ?></a>
							</td>
							<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
								<?php echo $numIssues; ?>
							</td>
						</tr>
					<?php
				}
			}
		}
		echo "</table>";
	}
	else
	{
		echo "<div style='font-family: $font; font-size: $fontSize'>Can't list folders in archive.</font>";
	}

	echo $bottomTemplateHTML;
?>