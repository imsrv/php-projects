<?php 
	// Open the counter file
	
	$file = "stats";
	if(!($fp = fopen($file , "r"))) 
		die ("Could not open the requested file!  You may need to CHMOD 777 it!");
	$count = trim(fgets($fp));
	$selection = trim(fgets($fp));
	
	fclose($fp);
	
	$count++;
	
	$fp = fopen($file , "w");
	
	fwrite($fp, $count);
	fwrite($fp, "\n");
	fwrite($fp, $selection);
	
	fclose($fp);
	$count_image = "<img src='images/".$selection."/";
	for($i = 0; $i < strlen($count); $i++){
		$temp = $count_image.substr($count, $i, 1).".gif' />";
		print $temp;
		
	}
	
	
	
	// Increment the counter
	
	// Write to the file
	
	// Loop through to print out the counter pictures
	
	
	


?>