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
                        Gestion des Contacts
                    </div>
                    <br>
                    <span class="hlpsubtitle">
                        Type priv�, groupe et public :
                    </span>
                    <span class="hlpfont">
                        Les contacts sont les �l�ments de votre carnet d'adresse. Un contact est soit PRIVE soit GROUPE soit PUBLIC : <br>
                         - Un contact de type PRIVE n'est visible que par son cr�ateur (vous),
                         <br>
                         - un contact de type GROUPE est visible par les membres du ou des groupes choisis par son cr�ateur. Sa modification est r�serv�e � son cr�ateur),
                         <br>
                         - un contact de type PUBLIC est visible par le monde entier.
                    </span>
                    <br>
                    <br>
                    <span class="hlpsubtitle">
                        Cr�ation :
                    </span>
                   
                    <span class="hlpfont">
                        Pour cr�er un nouveau contact, choisissez le menu Nouveau Contact. Attention, le champ nom est obligatoire. Le type priv� est choisi par d�faut.  Cela signifie que par d�faut, un nouveau contact est suppos� priv�.
                    </span>
                    <br>
                    <br>
                    <span class="hlpsubtitle">
                        Modification :
                    </span>
                   
                    <span class="hlpfont">
                        Pour Modifier un contact, S�lectionnez l'ic�ne de modification. Attention, vous ne pouvez modifi� que les contacts que vous avez cr��s ou import�s.
                    </span>
                    <br>
                    <br>
                    <span class="hlpsubtitle">
                        Consultation :
                    </span>
                   
                    <span class="hlpfont">
                        Pour Consulter la fiche d'un contact, S�lectionnez l'ic�ne de consultation. Vous afficherez alors toute la fiche du contact.
                    </span>
                    <br>
                    <br>
                    <span class="hlpsubtitle">
                        Param�trage :
                    </span>
                   
                    <span class="hlpfont">
                        La rubrique Pr�f�rences explique comment param�trer les 4 champs principaux et les 6 champs suppl�mentaires visibles sur la page principale d'wa-boo
                    </span>
                    <br>
                    <br>
                </td>
            </tr>
        </table>
        
    </body>
</html>