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
					<b><i>Date Sent</i></b>
				</td>
				<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
					<b><i>Size</i></b>
				</td>
				<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
					<b><i>Format</i></b>
				</td>
			</tr>
			<tr>
				<td colspan="5"><hr></td>
			</tr>

		<?php

		while (false !== ($file = readdir($dHandle)))
		{
			if($file != "." && $file != ".." && $file != "index.php")
			{
				// Workout the name of the newsletter
				$arrN = explode("_", $file);
				$realName = "";
				$realDate = "";

				for($i = 0; $i < sizeof($arrN)-3; $i++)
					$realName .= $arrN[$i] . " ";

				for($j = sizeof($arrN)-3; $j < sizeof($arrN); $j++)
					$realDate .= $arrN[$j] . " ";

				// Strip the .html or .txt from the date
				$realDate = str_replace(".html", "", $realDate);
				$realDate = str_replace(".txt", "", $realDate);

				if(is_numeric(strpos($file, ".html")))
				{
				?>
					<tr>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<img src="../images/html_file.gif">
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<a href="<?php echo urlencode($file); ?>"><?php echo $realName; ?></a>
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<?php echo $realDate; ?>
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<?php echo @(int)@ceil(@filesize($file)/1024); ?>k
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							HTML
						</td>
					</tr>
				<?php
				}
				else if(is_numeric(strpos($file, ".txt")))
				{
				?>
					<tr>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<img src="../images/text_file.gif">
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<a href="<?php echo urlencode($file); ?>"><?php echo $realName; ?></a>
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<?php echo $realDate; ?>
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							<?php echo @(int)@ceil(@filesize($file)/1024); ?>k
						</td>
						<td style="font-family: <?php echo $font; ?>; font-size: <?php echo $fontSize; ?>">
							Text
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
		echo "<div style='font-family: $font; font-size: $fontSize'>Can't list files in archive folder.</font>";
	}

	echo $bottomTemplateHTML;
?>