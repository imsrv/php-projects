<?
include('casespecial.php');
$UC= new casespecial();

$work_text = "�perhep�iv�hoitaja";
$temp=$UC->get_ucfirst($work_text);
echo $temp."\n";
$UC->ucfirst($work_text);
echo $work_text."\n";

$work_text = "�perhep�i v�hoitaja";
$temp=$UC->get_ucwords($work_text);
echo $temp."\n";
$UC->ucwords($work_text);
echo $work_text."\n";

$work_text = "�perhep�i v�hoitaja";
$temp=$UC->get_strtoupper($work_text);
echo $temp."\n";
$UC->strtoupper($work_text);
echo $work_text."\n";

$work_text = "�PERHEP�I V�HOITAJA";
$temp=$UC->get_strtolower($work_text);
echo $temp."\n";
$UC->strtolower($work_text);
echo $work_text."\n";

$work_text = "�PERHEP�I V�HOITAJA";
$temp=$UC->get_capitalize($work_text);
echo $temp."\n";
$UC->capitalize($work_text);
echo $work_text."\n";

$work_text = "�PERHEP�I V�HOITAJA";
$temp=$UC->get_capitalizewords($work_text);
echo $temp."\n";
$UC->capitalizewords($work_text);
echo $work_text."\n";
?>