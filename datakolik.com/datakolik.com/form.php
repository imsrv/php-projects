<?
  # Oturumu baslat
  session_start();

  # Kodu dogrula
  if($_POST["gonder"]){

     # Kod dogrulandýysa
     if($_SESSION["kod"] == $_POST["kod"]){
       include'mailyollandi.php'; 
       }

     # Dogrulanmadýysa
     else{
 include'hata.php';

               }
     }
?>




<