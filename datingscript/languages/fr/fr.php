<?php
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.1.1                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 05/01/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               fr.php                           #
# File purpose            French language file             #
# File created by         AzDG <support@azdg.com>          #
# File translated by      Visum <admin@visum.fr.st>        #
############################################################

define('C_HTML_DIR','ltr'); // HTML direction for this language
define('C_CHARSET', 'iso-8859-1'); // HTML charset for this language

### !!!!! Please read it: RULES for translate!!!!! ###
### 1. Be carefull in translate - don`t use ' { } characters
###    You can use them html-equivalent - &#39; &#123; &#125;
### 2. Don`t translate {some_number} templates - you can only replace it - 
###    {0},{1}... - is not number - it templates
###################################

$w=array(
'<font color=red size=3>*</font>', //0 - Symbol for requirement field
'Erreur de s�curit� - #', //1
'Cette adresse e-mail est d�j� utilis�e. Veuillez en choisir une autre.', //2
'Pr�nom invalide. Le pr�nom doit comporter {0} - {1} caract�res', //3 - Don`t change {0} and {1} - See rule 2 !!!
'Nom de famille invalide. Le nom de famille doit comporter {0} - {1} caract�res', //4
'Date de naissance incorrecte', //5
'Mot de passe invalide. Le mot de passe doit comporter {0} - {1} caract�res', //6
'Vous �tes', //7
'Vous cherchez', //8
'Type de relation souhait�', //9
'Votre pays de r�sidence', //10
'Email incorrect ou vide', //11
'Adresse de la page web invalide', //12
'No ICQ invalide', //13
'Identifiant AIM invalide', //14
'Votre num�ro de t�l�phone', //15
'Votre ville', //16
'Votre statut actuel', //17
'Avez-vous des enfants?', //18
'Votre taille', //19
'Votre poids', //20
'Taille id�ale du (de la) partenaire recherch�(e)', //21
'Poids id�al du (de la) partenaire recherch�(e)', //22
'La couleur de vos cheveux', //23
'La couleur de vos yeux', //24
'Votre milieu ethnique', //25
'Votre religion', //26
'Milieu ethnique du (de la) partenaire recherch�(e)', //27
'Religion du (de la) partenaire recherch�(e)', //28
'Fumez-vous?', //29
'Consommez-vous de l&#39alcool?', //30
'Votre niveau d&#39�ducation', //31
'Votre secteur d&#39activit�', //32
'L&#39�ge id�al du (de la) partenaire recherch�(e)', //33
'Comment avez-vous entendu parler de ce site?', //34
'Quels sont vos loisirs?', //35
'Erreur dans le champ des loisirs. Vous ne devez pas d�passer {0} charact�res', //36
'Erreur dans le champ des loisirs. La longueur des mots doit �tre sup�rieure � {0} charact�res', //37
'Veuillez vous d�crire en quelques lignes', //38
'Erreur dans le champ de votre description. Vous ne devez pas d�passer {0} charact�res', //39
'Erreur dans le champ de votre description. La longueur des mots doit �tre sup�rieure � {0} symbols', //40
'Votre photo est requise!', //41
'F�licitations! <br>Votre code d&#39activation vous a �t� envoy� � votre adresse e-mail. <br>Vous devez confirmer votre inscription par le mail qui vous �t� envoy�!', //42 - Message after register if need confirm by email
'Confirmez votre inscription', //43 - Confirm mail subject
'Merci pour votre inscription sur ce site...
Veuillez maintenant cliquer sur ce lien afin de confirmer votre inscription:

', //44 - Confirm message
'Merci de vous �tre inscrit. Votre profil va �tre valid� prochainement par l&#39administrateur. Ne tardez donc pas � revenir...', //45 - Message after registering if admin allowing is needed
'F�licitations! <br>Votre profil a �t� ajout� � la base de donn�es!<br><br>Votre identifiant (ID):', //46
'<br>Votre mot de passe:', //47
'Veuillez confirmer votre mot de passe', //48
'Les mots de passe ne sont pas identiques!', //49
'Enregistrement membre', //50
'Votre pr�nom', //51
'Charact�res', //52
'Votre nom de famille', //53
'Mot de passe', //54
'Confirmation mot de passe', //55
'Votre date de naissance', //56
'Votre genre', //57
'Type de relation', //58
'Votre pays de r�sidence', //59
'Votre adresse e-mail', //60
'Votre site Internet', //61
'Votre no ICQ', //62
'Votre identifiant AIM', //63
'Votre no de t�l�phone', //64
'Votre ville', //65
'Votre statut actuel', //66
'Enfants', //67
'Votre taille', //68
'Votre poids', //69
'La couleur de vos cheveux', //70
'La couleur de vos yeux', //71
'Votre milieu ethnique', //72
'Votre religion', //73
'Fum�e', //74
'Alcool', //75
'Votre niveau d&#39�ducation', //76
'Votre travail, secteur d&#39activit�', //77
'Vos loisirs', //78
'D�crivez-vous vous-m�me et le genre de personne que vous recherchez.', //79
'Cherche', //80
'Milieu ethnique souhait�', //81
'Religion souhait�e', //82
'Age souhait�', //83
'Taille souhait�e', //84
'Poids souhait�', //85
'Comment nous avez-vous trouv�?', //86
'Photo', //87
'Page principale', //88
'S&#39enregistrer', //89
'Section membres', //90
'Recherche avanc�e', //91
'Commentaires', //92
'FAQ', //93
'Statistiques', //94
'Menu membre ID#', //95
'Voir les messages', //96
'Ma chambre � coucher', //97
'Mon profil', //98
'Changer mon profil', //99
'Changer mot de passe', //100
'Supprimer mon profil', //101
'Se d�connecter', //102
'Page g�n�r�e en ', //103
'sec.', //104
'Membres en ligne:', //105
'Invit�s en ligne:', //106
'Conception <a href="http://www.azdg.com" target="_blank" class="desc">AzDG</a>', //107 - Don`t change link - only for translate - read GPL!!!
'La recherche approfondie n&#39est accessible qu&#39aux membres inscrits', //108
'Pardon, &#39Age de&#39 doit �tre plus petit que &#39Age �&#39', //109
'Aucun profil ne r�pond � ces crit�res', //110
'Non', //111 Picture available?
'Oui', //112 Picture available?
'Impossible de se connecter au serveur<br>Votre identifiant ou votre mot de passe mysql sont faux.<br>Veuillez les contr�ler dans le fichier config', //113
'Impossible de se connecter au serveur<br>La base de donn�es n&#39existe pas.<br>Ou alors changez le nom de la base de donn�es dans le fichier config', //114
'Pages :', //115
'R�sultats de la recherche', //116
'Total : ', //117 
'Nom d&#39utilisateur', //118
'Buts', //119
'Age', //120
'Pays', //121
'Ville', //122
'Derni�re visite', //123
'Date d&#39enregistrement', //124
'Recherche approfondie', //125
'Identifiant ID#', //126
'Pr�nom', //127
'Nom de famille', //128
'Signe du Zodiac', //129
'Taille', //130
'Poids', //131
'Genre', //132
'Type de relation', //133
'Statut actuel', //134
'Enfants', //135
'Couleur des cheveux', //136
'Couleur des yeux', //137
'Milieu ethnique', //138
'Religion', //139
'Fum�e', //140
'Alcool', //141
'Education', //142
'Rechercher membres avec ', //143
'Site Internet', //144
'ICQ', //145
'AIM', //146
'No de t�l�phone', //147
'Inscrit ', //148
'Trier les r�sultats par', //149
'R�sultats par page', //150
'Recherche simple', //151
'Acces refus� aux visiteurs non-inscrits', //152
'Acc�s refus� pour abus et envoi de faux profils', //153
'Utilisateur d�j� inscrit dans la table des faux profils', //154
'Merci, l&#39utilisateur a �t� ajout� � la liste des profils douteux et va �tre contr�l� par l&#39administrateur d&#39ici peu.', //155
'Acc�s � la chambre � coucher refus�', //156
'L&#39utilisateur se trouve d�j� dans votre chambre � coucher', //157
'Merci, l&#39utilisateur a �t� ajout� dans votre chambre � coucher', //158
'Votre profil a �t� envoy� avec succ�s pour un contr�le de l&#39administrateur.', //159
'Votre profil a �t� ajout� avec succ�s � la base de donn�es', //160
'Erreur dans l&#39activation du profil. Il se peut que celui-ci soit d�j� actif.', //161
'FAQ la base de donn�es est vide', //162
'FAQ r�ponse#', //163
'Tous les champs doivent �tre remplis', //164
'Votre message a bien �t� envoy�', //165
'Sujet du message', //166
'Veuillez tapper votre message', //167
'Sujet', //168
'Message', //169
'Envoyer message', //170
'Pour les membres', //171
'Num�ro ID', //172
'Mot de passe oubli�', //173
'Recommandez ce site', //174
'Ami-{0} e-mail', //175
'Anniversaires du jour', //176
'Pas d&#39anniversaires', //177
'Bienvenue sur notre site AzDGDating', //178 Welcome message header
'AzDGDatingLite - est un moyen formidable pour se trouver des amis ou partenaires, pour le plaisir, des rencontres et des relations � long terme. Rencontrer et apprendre � conna�tre d&#39autres gens est � la fois s�r et amusant. Des pr�cautions relevant du bons sens devraient n�anmoins �tre prises si vous d�cidiez de rencontrer quelqu&#39un "pour de vrai".<br><br>Vous pouvez �galement trouver de nouveaux amis gr�ce � notre propre syst�me de messagerie. Celui-ci vous permettra de communiquer avec d&#39autres membres et d�velopper de nouvelles relations.<br>', //179 Welcome message
'Les {0} derniers membres inscrits', //180
'Recherche rapide', //181
'Recherche approfondie', //182
'Photo du jour', //183
'Statistiques simples', //184
'Votre ID doit �tre num�rique', //185
'Identifiant ID# incorrect ou mauvais mot de passe', //186
'Acc�s pour l&#39envoi de messages ferm�', //187
'Envoyez un message par e-mail � l&#39utilisateur ID#', //188
'Aucun membre en ligne', //189
'Page de recommandation non disponible', //190
'Salutations de {0}', //191 "Recommandez-nous" subject, {0} - username
'Coucou de {0}!

Comment vas-tu :)

Visite ce site - simplement g�nial :
{1}', //192 "Recommend Us" message, {0} - username, {1} - site url
'Ecrivez l&#39adresse correcte d&#39un ami pour un e-mail #{0}', //193
'Entrez votre nom et votre adresse e-mail', //194
'Votre mot de passe de {0}', //195 Reming password email subject
'Ce compte a �t� d�sactiv� ou n&#39existe pas dans la base de donn�es.<br>Veuillez vous adresser directement � l&#39administrateur en passant par le lien "Feedback". N&#39oubliez pas d&#39y indiquer votre identifiant (ID).', //196
'Coucou!

Votre identifiant ID#:{0}
Votre mot de passe:{1}

_________________________
{2}', //197 Remind password email message, Where {0} - ID, {1} - password, {2} - C_SNAME(sitename)
'Votre mot de passe vous a �t� renvoy� � votre adresse e-mail.', //198
'Veuillez entrer votre ID', //199
'Envoyer le mot de passe', //200
'Acc�s ferm� pour l&#39envoi de messages', //201
'Envoyer un message � l&#39utilisateur ID#', //202
'M&#39avertir quand l&#39utilisateur lira le message', //203
'Aucun utilisateur dans la base de donn�es', //204
'Statistiques non disponibles', //205
'Cet ID n&#39existe pas', //206
'Profil ID#', //207
'Pr�nom du membre', //208
'Nom de famille du membre', //209
'Anniversaire', //210
'E-mail', //211
'Message de AzDGDating', //212 - Subject for email
'Travail', //213
'Loisirs', //214
'A propos', //215
'Popularit�', //216
'Envoyer un message', //217
'Profil douteux', //218
'Dans ma chambre � coucher', //219
'Aucun fichier n&#39a �t� envoy�, <br>ou alors votre fichier d�passait la limite de {0} Kb. La taille de votre fichier fait {1} Kb', //220
'Le fichier que vous avez envoy� �tait plus large que la limite fix�e � {0} px ou plus haut que les {1} px autoris�s.', //221
'Le type de fichier que vous avez essay� d&#39envoyer est incorrect (seuls les fichiers jpg, gif et png sont autoris�s). Votre fichier - ', //222
'(Max. {0} Kb)', //223
'Statistiques par pays', //224
'Vous n&#39avez pas de messages', //225
'Total messages - ', //226
'Numm�ro', //227 Number
'De', //228
'Date', //229
'Supprimer', //230 Delete
'<sup>Nouveau</sup>', //231 New messages
'Supprimer les messages s�lectionn�s', //232
'Message de - ', //233
'R�pondre', //234
'Bonjour, vous avez �crit {0}:\n\n_________________\n{1}\n\n_________________', //235 Reply to message {0} - date, {1} - message
'Votre message a �t� lu', //236
'Votre message:<br><br><span class=dat>{0}</span><br><br>a �t� lu par {1} [ID#{2}] le {3}', //237 {0} - message, {1} - Username, {2} - UserID, {3} - Date and Time
'{0} messages supprim�s avec succ�s!', //238
'Entrez l&#39ancien mot de passe', //239
'Entrez le nouveau mot de passe', //240
'Confirmez le nouveau mot de passe', //241
'Changer le mot de passe', //242
'Ancien mot de passe', //243
'Nouveau mot de passe', //244
'Confirmation du mot de passe', //245
'Vous n&#39avez aucun membre dans votre chambre � coucher', //246
'Date d&#39ajout', //247
'Supprimer les utilisateurs s�lectionn�s', //248
'Etes-vous s�r(e) de vouloir supprimer votre propre profil?<br>Tous vos messages, images, vont �tre supprim�s de la base de donn�es.', //249
'L&#39utilisateur ID#={0} a bien �t� supprim� de la base de donn�es', //250
'Votre profil va �tre supprim� apr�s un contr�le de s�curit� de l&#39administrateur', //251
'{0} membres chass�s de votre chambre � coucher!', //252
'Les mots de passe n&#39�taient pas identiques ou contenaient des caract�res interdits', //253
'Vous n&#39avez pas d&#39acc�s pour changer de mot de passe', //254
'Ancien mot de passe incorrect. Retournez en arri�re et recommencez.', //255
'Le mot de passe a �t� chang� avec succ�s!', //256
'Il n&#39est pas possible de supprimer toutes les photos', //257
'Votre profil a bien �t� mis � jour', //258
' - Supprimer l&#39image', //259
'Votre session est termin�e. Vous pouvez fermer votre navigateur.', //260
'Images miniatures non disponibles', //261
'Langues', //262
'Entrer', //263
'Login [3-16 chars [A-Za-z0-9_]]', //264
'Login', //265
'Your login must consist of 3-16 chars and only A-Za-z0-9_ chars is available', //266
'This is login already in database. Please select another!', //267
'Total users - {0}', //268
'The messages are not visible. You should be the privileged user see the messages.<br><br>You can purshase from <a href="'.C_URL.'/members/index.php?l=fr&a=r" class=head>here</a>', //269 change l=default to l=this_language_name
'User type', //270
'Purshase date', //271
'Search results position', //272
'Price', //273
'month', //274
'Purshase Last date', //275
'Higher than', //276
'Purshase', //277
'Purshase with', //278
'PayPal', //279
'Thanks for your registration. Payment has been succesfully send and will be checked by admin in short time.', //280
'Incorrect error. Please try again, or contact with admin!', //281
'Send congratulation letter about privilegies activating', //282
'User type has successfully changed.', //283
'Email with congratulations has been send to user.', //284
'ZIP',// 285 Zip code
'Congratulations, 

Your status is changed to {0}. This privilegies will be available in next {1} month.

Now you can check your messages in your box.

__________________________________
{2}', //286 {0} - Ex:Gold member, {1} - month number, {2} - Sitename from config
'Congratulations', //287 Subject
'ZIP code must be numeric', //288
'Keywords', //289
'We are sorry, but the following error occurred:', //290
'', //291
'', //292
'', //293
'', //294
'', //295
'', //296
'', //297
'', //298
'' //299
); 
?>
