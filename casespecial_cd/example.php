<?
include('casespecial.php');
$UC= new casespecial();

$work_text = "äperhepäivähoitaja";
$temp=$UC->get_ucfirst($work_text);
echo $temp."\n";
$UC->ucfirst($work_text);
echo $work_text."\n";

$work_text = "äperhepäi vähoitaja";
$temp=$UC->get_ucwords($work_text);
echo $temp."\n";
$UC->ucwords($work_text);
echo $work_text."\n";

$work_text = "äperhepäi vähoitaja";
$temp=$UC->get_strtoupper($work_text);
echo $temp."\n";
$UC->strtoupper($work_text);
echo $work_text."\n";

$work_text = "ÄPERHEPÄI VÄHOITAJA";
$temp=$UC->get_strtolower($work_text);
echo $temp."\n";
$UC->strtolower($work_text);
echo $work_text."\n";

$work_text = "ÄPERHEPÄI VÄHOITAJA";
$temp=$UC->get_capitalize($work_text);
echo $temp."\n";
$UC->capitalize($work_text);
echo $work_text."\n";

$work_text = "ÄPERHEPÄI VÄHOITAJA";
$temp=$UC->get_capitalizewords($work_text);
echo $temp."\n";
$UC->capitalizewords($work_text);
echo $work_text."\n";
?>