<?

$counter_file_line = file($count_log_file);
$counter_file_line[0] = $counter_file_line[0] + 1;

$cf = fopen($count_log_file, "w");
flock($cf,2);
fputs($cf, "$counter_file_line[0]"); 
fclose($cf);

$display = $counter_file_line[0];

if ($counter_file_line[0] >= 10000000) {
	$display = round(($counter_file_line[0]/1000000))."M";
}

elseif ($counter_file_line[0] >= 100000) {
	$display = round(($counter_file_line[0]/1000))."K";
}

echo $display;

?>
