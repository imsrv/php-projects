<?
/*
    Réalisation     : BIOT Nicolas pour PHPindex
    Contact        : BIOT Nicolas <nicolas@globalis-ms.com>

    ----------------------------------------------------------
    Fichier        : auth.inc.php
    Description    : Script d'authentification
    Date création    : 14/05/2001
    Date de modif    : 10/11/2001 Antoine Bajolet
*/
$user = PHPDIG_ADM_USER;
$pwd = PHPDIG_ADM_PASS;

function auth(){

    $realm="Administration PhpDig";

    Header("WWW-Authenticate: Basic realm='".$realm."'");
    Header("HTTP/1.0 401 Unauthorized");

    echo "Vous ne pouvez accéder à cette page";
    // la redirection est impossible
    // mais vous pouvez inclure une page html d'erreur
    exit;
}

if (PHPDIG_ADM_AUTH == 1)
{
if( !isset($PHP_AUTH_USER) && !isset($PHP_AUTH_PW) ) {
    auth();
}
else {
    if( $PHP_AUTH_USER==$user && $PHP_AUTH_PW==$pwd ) {
        // la suite du script sera exécutée
    }
    else{
        // rappel de la fonction d'identification
        auth();
    }
}
}
?>