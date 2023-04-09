<table align="center">
<tr><td>

<form action="" method="post">
<table>
<tr>
<td>&nbsp;</td>
<td></td>

</tr>

  <tr>
  <td ><b><u>Newsletter</u></b></td>
  <td></td>
  </tr>



 <tr>
    <td ><? echo translate("Nom de la lettre d'information"); ?> </td>
    <td > <input type="text" name="nomnews" value="<? echo $news->nomnews ;?>"> </td>
  </tr>
   <tr>
    <td> <? echo translate("Hébergeur"); ?>  </td>
    <td> <select name="hebergeur">
        <option value="nexen" <? if(($news->hebergeur)=="nexen") print "selected"; ?> >nexen.net</option>
        <option value="online" <? if(($news->hebergeur)=="online") print "selected"; ?> >online.fr</option>
        <option value="" <? if(($news->hebergeur)=="") print "selected"; ?> ><? echo translate("autre"); ?></option>

    </select> </td>
  </tr>
   <tr>
    <td> <? echo translate("Adresse de provenance des messages envoyés");?> </td>
<?
$from=split("@",$news->from,2);
?>
    <td> <input type="text" name="fromonline" size="10" value="<? echo $news->fromonline ;?>" >@<input type="text" name="domaine" value="<? echo $from[1]; ?>" size="15"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nombre de jours accordé pour la validation de l'abonnement");?>  </td>
    <td> <input type="text" name="limitconf" value="<? echo $news->limitconf; ?>"size="3"> <? echo translate("jours"); ?></td>
  </tr>
<tr>
<td>&nbsp;</td>
<td></td>

</tr>



  <tr>
  <td><b><u><? echo translate("Base de données"); ?><u></b></td>
  <td></td>
  </tr>
  <tr>
    <td ><? echo translate("Serveur mysql"); ?> </td>
    <td > <input type="text" name="host" value="<? echo $news->host; ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nom d'utilisateur"); ?></td>
    <td> <input type="text" name="user" value="<? echo $news->user; ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Mot de passe"); ?> </td>
    <td> <input type="password" name="passwd" value="<? echo $news->passwd; ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nom de la base de donnée"); ?> </td>
    <td> <input type="text" name="db" value="<? echo $news->db; ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nom de la table de stockage des adresses");?> </td>
    <td> <input type="text" name="tablenews" value="<? echo ($news->tablenews=="" ? news : $news->tablenews); ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nom de la table d'attente de validation"); ?> </td>
    <td> <input type="text" name="tabletemp" value="<? echo ($news->tabletemp=="" ? temp : $news->tabletemp); ?>"> </td>
  </tr>
  <tr>
    <td><? echo translate("Nom de la table de logs"); ?> </td>
    <td> <input type="text" name="tablelog" value="<? echo ($news->tablelog=="" ? log : $news->tablelog); ?>"> </td>
  </tr>
  <tr>
    <td> <? echo translate("Nom de la table de config"); ?> </td>
    <td> <input type="text" name="tableconfig" value="<? echo ($news->tableconfig==""? nlconfig : $news->tableconfig); ?>"> </td>
  </tr>

  <tr>
        <td>&nbsp;</td>
        <td></td>
  </tr>
   <tr>
        <td><b><u><? echo translate("Administration"); ?><u></b></td>
        <td></td>
  </tr>

  <tr>
    <td> <? echo translate("Mot de passe d'accès au panneau d'administration");?> </td>
    <td> <input type="password" name="admin_pass" size="8" value="<? echo $news->admin_pass; ?>"> </td>
  </tr>

  <tr>
    <td> <? echo translate("Nombre de newsletter à afficher par page de logs"); ?> </td>
    <td> <input type="text" name="limitlog" size="3" value="<? echo $news->limitlog; ?>"> </td>
  </tr>
  <tr>
    <td> <? echo translate("Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin"); ?>  </td>
    <td> <input type="text" name="url" value="<? echo $news->url; ?>"> </td>
  </tr>
  <tr>
    <td> <? echo translate("Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin"); ?>  </td>
    <td> <input type="text" name="pathtopmn" size="30" value="<? echo $news->pathtopmn; ?>"> </td>
  </tr>
	<tr>
		<td> <?echo translate("Activer le processus de validation des inscriptions"); ?> </td>
		<td><input type="radio" name="validation" value=1 <? if ($news->validation==1) echo "checked";?> >  <? echo translate("OUI"); ?>  <input type="radio" name="validation" value=0 <? if ($news->validation==0) echo "checked";?>>  <? echo translate("NON"); ?></td>
	</tr>


<tr>
    <td><? echo translate("Langue"); ?> </td>
    <td> <select name="langfile">
    <option value="lang-french.php" <? if (($news->langfile)=="lang-french.php") echo "selected"; ?>>Francais</option>
    <option value="lang-en.php" <? if (($news->langfile)=="lang-en.php") echo "selected"; ?>>English</option>
    <option value="lang-it.php" <? if (($news->langfile)=="lang-it.php") echo "selected"; ?>>Italiano</option>
    <option value="lang-deutch.php" <? if (($news->langfile)=="lang-deutch.php") echo "selected"; ?>>Deutch</option>
    <option value="lang-spanish.php" <? if (($news->langfile)=="lang-spanish.php") echo "selected"; ?>>Spanish</option>
    <option value="lang-slovak.php" <? if (($news->langfile)=="lang-slovak.php") echo "selected"; ?>>Slovakia</option>
    <option value="lang-dutch.php" <? if (($news->langfile)=="lang-dutch.php") echo "selected"; ?>>Dutch</option>
    </select> </td>
  </tr>
<tr>
    <td>  </td>
    <td>  </td>
  </tr>

 <input type="hidden" name="ok" value="1">
 <input type="hidden" name="mode" value="config">
 <input type="hidden" name="op" value="conf">

</table>
<p align="center"><input type="submit" value="<? echo translate("Mettre à jour"); ?>" ><input type="reset" value="<? echo translate("Réinitialiser"); ?>"></p>
</form>
</td></tr></table>