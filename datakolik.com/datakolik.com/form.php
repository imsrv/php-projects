<?
  # Oturumu baslat
  session_start();

  # Kodu dogrula
  if($_POST["gonder"]){

     # Kod dogruland�ysa
     if($_SESSION["kod"] == $_POST["kod"]){
       include'mailyollandi.php'; 
       }

     # Dogrulanmad�ysa
     else{
 include'hata.php';

               }
     }
?>




<