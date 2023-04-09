<?
function write_file($filename,$newdata) {
  $f=fopen($filename,"w");
  fwrite($f,$newdata);
  fclose($f);
  return 1;
}
?>