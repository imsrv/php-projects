<?

	global $ROOTURL;
	global $IsSetup;

	$time_start = getmicrotime();
	$advanced = "";
	$list = array();

	OutputPageHeader();

	//get the current time!
	function getmicrotime()
	{ 
		list($usec, $sec) = explode(" ",microtime()); 
		return ((float)$usec + (float)$sec); 
	}

	if((int)$IsSetup == 0)
		$tdWidth = "0";
	else
		$tdWidth = "0";
?>

	<table border="0" cellpadding="0" cellspacing="0" class="maintable" width="95%" align="center">
		<tr>
			<td valign="top">
				<table width="100%" cellpadding="0">
					<tr>
						<td>
							<?echo $OUTPUT;?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php OutputPageFooter(); ?>
