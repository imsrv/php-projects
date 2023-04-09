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
                        Aide pour les administrateurs d'wa-boo
                    </div>
                    <br>
                    <span class="hlpsubtitle">
                        Introduction :
                    </span>
                   
                    <div class="hlpfont">
                        wa-boo est un logiciel de gestion de carnet d'adresse, partageable, multilingue et pratiquant l'import-export de ses donn�es.
                        <br>Fond� sur PHP4 / mySQL, wa-boo est distribu� sous <a href="GPL.php">licence GPL</a>. 
                    </div>
                    <br>
                    <span class="hlpsubtitle">
                        G�n�ralit�s :
                    </span>
                    <span class="hlpfont">
                        Les fonctions d'administration d'wa-boo permettent de cr�er, modifier et supprimer les comptes des utilisateurs au sens large, les groupes et les appartenances des utilisateurs aux groupes.
                        wa-boo int�gre 3 niveaux d'utilisation :
                        <br>- niveau 'UTILISATEURS', 
                        <br>- niveau 'ADMINISTRATEURS', 
                        <br>- niveau 'GODLIKE'.
                        <br>
                        
                    </span>
                    
                    <br>
                    <span class="hlpsubtitle">
                        Utilisateurs :
                    </span>
                    <span class="hlpfont">
                        C'est le niveau d'utilisation normal. Chaque utilisateur a son carnet d'adresse priv�. 
                        Certains utilisateurs sont inscrits dans un ou plusieurs groupes d'wa-boo. 
                        Ces groupes sont g�r�s par un ou plusieurs administrateurs
                    </span>
                    <br>
                    <br>
                    
                    <span class="hlpsubtitle">
                        Administrateurs :
                    </span>
                    <span class="hlpfont">
                        Les Administrateurs g�rent les utilisateurs des groupes. Un administrateur peut administrer un ou plusieurs groupes. 
                        Lorsqu'il se loge en tant qu'administrateur, le menu principal propose de choisir un des domaines � g�rer.
                        <br><br>Un administrateur peut cr�er un utilisateur et l'inclure dans un groupe qu'il administre. 
                        Un administrateur ne peut modifier et supprimer un utilisateur que si il est administrateur de tous les groupes de l'utilisateur.
                        Dans ce cas, s'il d�cide de supprimer un utilisateur qui a d�j� saisi des contacts priv�, tous les contacts seront supprim�s avec lui.
                        <br><br>
                        Dans le cas o� il n'administre pas tous les groupes de l'utilisateur, il peut pourtant inclure ou exclure cet utilisateur de son groupe, en cochant directement le 'v' � droite du nom de l'utilisateur.
                        Dans ce cas, l'administrateur n'a pas acc�s � la modification et � la suppression de cet utilisateur, il ne peut que l'inclure / exclure de son groupe.
                        Lorsqu'un utilisateur est exclu d'un groupe par un des administrateurs, le sous-ensemble de ses contacts qui �taient visibles par le groupe ne le sont plus. 
                        N�anmoins, ce sous ensemble des contacts de l'utilisateur lui reste attribu�e.
                        <br><br>Un utilisateur d'un groupe peut �tre administrateur d'un autre groupe. Ces profils hybrides sont consid�r�s par le syst�me comme des administrateurs.
                        Cela signifie qu'ils ne sont pas visibles par les autres administrateur
                    </span>
                    <br><br>
                    <span class="hlpsubtitle">
                        Godlike :
                    </span>
                    <span class="hlpfont">
                        Les profils Godlike ("comme Dieu") ont acc�s � toutes les fonctionnalit�s :
                        <br>- Cr�ation, modification et suppression des groupes.
                        <br>- Cr�ation / modification / suppression des utilisateurs, des administrateurs et des groupes.
                        <br>- Inclusions / exclusions des utilisateurs et administrateurs.
                    </span>
                    <br>
                    <br>
                </td>
            </tr>
        </table>
        
    </body>
</html>