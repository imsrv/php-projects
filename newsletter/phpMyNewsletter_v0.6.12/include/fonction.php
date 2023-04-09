<?
// fonction de phpMyNewsLetter 0.5 par Grégory KOKANOSKY

// fonction de validation d'adresse mail trouvée sur http://www.phpinfo.net/?p=trucs&rub=astuces
function EmailOK($email) {

  return( ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.
               '@'.
               '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
               '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$',
               $email) );
}



function unique_id()
{
  mt_srand((double)microtime()*1000000);
  return  md5( mt_rand(0,9999999) );
}






?>