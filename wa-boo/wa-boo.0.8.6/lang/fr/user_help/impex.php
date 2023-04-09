<?
    include ("../../../includes/global_vars.php");
    include ("../../../includes/fotools.php");

    session_start();
?>
<html>
    <head>
    <title>wa-boo</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style><? include ("../../../includes/css.php"); ?></style> 
    </head>

    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" background="../../../images/bg1.gif">
        <table border="0" cospan="0">
            <tr>
                <td>
                    <div align="center" class="hlptitle">
                         Import et Export [Menu]
                    </div>
                    
                    <br>
                   
                    <span class="hlpfont">
                        Ces fonctions d'Import et d'export permettent � wa-boo de communiquer avec les autres applications. Les fonctions d'entretien compl�tent la panoplie d'import-export.
                        Ces deux fonctions sont clairement document�es lors de leur r�alisation, mais nous rappelons ici les grandes lignes.
                        <br><br>Attention ! Alors que l'export permet d'exporter tous les types de contacts (y compris le type GROUPE - voir rubrique Contacts), l'import cr�e toujours des contacts de type PRIVE (tout du moins dans cette version). 
                        <br>
                    </span>
                    
                    <br>
                    <span class="hlpsubtitle">
                        Import : 
                    </span>
                    <span class="hlpfont">
                        L'import permet d'int�grer dans wa-boo des informations provenant d'un autre logiciel.
                        La proc�dure est compos�e de 4 phases successives (en consid�rant que vous disposez d�j� d'un fichier export� � partir d'un autre logiciel)
                        <br>- Etape 1 : Choix du fichier dans votre ordinateur et envoi au serveur wa-boo
                        <br>- Etape 2 : Analyse du fichier. wa-boo vous indique le nombre de lignes, de colonnes, le nombre de contacts maximum dans la base.
                        <br>- Etape 3 : S�lection des champs � importer. Vous indiquez � wa-boo les champs que vous d�sirez importer.
                        <br>- Etape 4 : Contr�le des doublons. Attention !, pour fonctionner, cette option doit �tre activ�e � l'installation d'une part. 
                        D'autre part, si vous commencez l'import � partir d'une base contenant des doublons, cette �tape sera ignor�e
                        <br>- Etape 5 : R�sultat de l'importation. wa-boo pr�cise ce qu'il s'est pass� lors de l'importation (nombre de contacts, de doublons, etc.).
                         
                    </span>
                   
                    <br><br>
                    <span class="hlpsubtitle">
                        Export :
                    </span>
                   
                    <span class="hlpfont">
                        L'export permet de cr�er un fichier compos� de tout ou partie de vos contacts afin de les r�importer dans un autre logiciel (ou dans wa-boo).
                        <br>- Etape 1 : S�lection des contacts,
                        <br>- Etape 2 : R�cup�ration du fichier. Vous pouvez choisir de t�l�charger le fichier ou d'afficher son contenu dans votre navigateur.  

                    </span>
                    <br>
                    <br>
                    
                </td>
            </tr>
        </table>
        
    </body>
</html>