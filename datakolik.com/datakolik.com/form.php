<?
  # Oturumu baslat
  session_start();

  # Kodu dogrula
  if($_POST["gonder"]){

     # Kod dogrulandıysa
     if($_SESSION["kod"] == $_POST["kod"]){
       include'mailyollandi.php'; 
       }

     # Dogrulanmadıysa
     else{
 include'hata.php';

               }
     }
?>




<