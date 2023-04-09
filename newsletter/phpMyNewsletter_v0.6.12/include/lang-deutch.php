<?

function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** Translation Needed ] -> $phrase");
}



$lang=array("Adresse e-mail"                 =>"E-mail Adresse",
            "Inscription"                 =>"Abonnieren",
            "Désinscription"                 =>"Abbestellen",
            "Nombre d'abonnés"         =>"Anzahl Abonnenten",
            "Erreur ! Le mot de passe n'est pas valide"  =>"Fehler! Falsches Passwort",
            "En attente de validation"        =>"Warten auf Bestätigung",
            "Nbr de NewsLetter déjà envoyées" =>"Anzahl bereits gesendete Newsletter",
            "Numéro de la prochaine NewsLetter"        =>"Nummer des nächsten Newsletters",

            "Retour"                         =>"Zurück",
            "Erreur"                        =>"Fehler",
            "Déjà inscrit"                =>"Bereits in der Datenbank",
            "Impossible de trouver la base"  =>"Kann Datenbank nicht finden",
            "Impossible de trouver le serveur"  =>"Kann nicht mit dem Host verbinden",
            "Erreur lors du flush de la table temp" =>"Fehler während des temporären table-flush",


            /*** ENVOI DE MESSAGE ***/
            "Appercu du message"         =>"Newsletter Vorschau",
            "Réinitialiser"                =>"Reset",
            "Sujet"                        =>"Betreff",
            "Rédiger un nouveau message"  =>"Neue Nachricht erstellen",
            "Tous les champs doivent être remplis" =>"Alle Felder müssen ausgefüllt werden",
            "Texte"                        =>"Text",
            "Adresse Email non valide" =>"Ungültige Email-Adresse",


        /*** ADMININSTRATION ***/
         "Administration"  =>"Administrations-Seite",
         "Nouveau message"                =>"Neue Nachricht",
         "Liste des abonnés"        =>"Abonnentenliste",
            "Ajout d'un abonné"        =>"Abonnent hinzufügen",
            "Suppression d'un abonné"        =>"Abonnent löschen",
         "Voir l'historique"                =>"Logs ansehen",
         "Pour vous désinscrire, rendez-vous à l'adresse suivante" =>"Um den Newsletter abzubestellten gehen Sie bitte zu folgender URL",
            "Configuration"                =>"Konfiguration",
         "Se déconnecter"                =>"Ausloggen",
         "Configuration de phpMyNewsletter" =>"phpMyNewsletter Konfiguration",
         "Editer la configuration"        =>"Konfiguration editieren",
         "Editer les messages de bienvenue ..."        =>"Willkommensnachricht editieren...",
         "Mise à jour de la configuration effectuée"          =>"Konfiguration aktualisiert",
         "Supprimer des abonnés" =>"Abonnenten löschen",
         "Sélectionner les abonnés à supprimer" =>"Markieren Sie die Abonnenten, die Sie löschen wollen",
         "Supprimer les abonnés sélectionnés"        =>"Markierte Abonnenten löschen",
         "Les abonnés sélectionnés ont été supprimé" =>"Markierte Abonnenten gelöscht",
         "Importer un fichier texte dans la base de donnée" =>"Textdatei in die Datenbank importieren",
         "Importation effectuée"        =>"Import erfolgreich",

         /*** Eingefügt von Tom ***/
         "Export" =>"Textdatei exportieren",
         "exporter" =>"exportieren",
         "Envoyer le message" =>"Nachricht absenden",
         "Newsletter envoyée" =>"Nachricht versendet",
		 "Exporter les abonnés" =>"Abonnenten exportieren",

         "Logs de phpMyNewsletter" =>"phpMyNewsletter Logdateien",
         "Heure" =>"Stunde",
          "Pour vous desinscrire, cliquez ici" =>"Um den Newsletter abzubestellen, hier klicken",

         "Sujet du message de bienvenue"         =>"Betreff Willkommensnachricht",
         "Message de bienvenue envoyé après la confirmation de l'abonné"        =>"Willkommensnachricht, die nach Bestätigung des Abonnenten verschickt wird",
         "Corps du message de bienvenue"        =>"Text der Willkommensnachricht",
         "Pied des messages" =>"Nachrichtenfuß der Willkommensnachricht" ,

         "Mettre à jour"        =>"Aktualisieren",
         "Réinitialiser" =>"Reinitialisieren",
         "Message de demande de confirmation" =>"Bestätigungsnachricht",
         "Inscription"        =>"Abonnement",

         "Avertir de l'inscription par mail" =>"Abonnenten informieren",
         "Un mail de d'information va être envoyé" =>"Eine Inforamtions-EMail wurde verschickt",
         "Nombre total d'abonnés" =>"Anzahl der Abonnenten",
         "Vous n'avez pas d'abonnés" =>"Keine Abonnenten in der Datenbank",

        /****** FORMULAIRE d'IDENTIFICATION  *********/
         "Mot de passe"                  =>"Passwort",
         "valider"                 =>"Login",
         "Identification"                =>"Identifizierung",
         "Accès à l'administration"        =>"Administrations-Zugang",

         "Rendez-vous à l'adresse suivante pour confirmer votre inscription" =>"Bitte gehen Sie zu folgendem Link um Ihr Abonnement zu bestätigen",
         "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message" =>"Falls Sie unseren Newsletter nicht abonnieren möchten ignorieren Sie bitte diese Mail",
         "Confirmation de l'inscription"        =>"Bestätigung des Abonnements",


         "Votre inscription s'est bien déroulée" =>"Abonnement erfolgreich",
         "L'inscription c'est bien déroulée" =>"Abonnement erfolgreich",
         "Vous allez recevoir un mail de confirmation" =>"Eine Bestätigungs-EMail wurde an Sie versandt",
         "Vous êtes déjà inscrit" =>"Sie sind bereits Abonnent",
         "Vous n'êtes pas inscrit à cette Newsletter" =>"Sie sind nicht in unserer Abonnenten-Datenbank eingetragen",
         "Votre inscription a été confirmée" =>"Abonnement bestätigt",
         "Désinscription de"  =>"Austragen von",
         "effectuée, merci de votre visite"  =>"erledigt. Wir danken für Ihren Besuch",
         "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante"  =>"Falls Sie sich wieder eintragen möchten, klicken Sie bitte hier " ,


         "Nom de la lettre d'information" =>"Name des Newsletters",
         "Hébergeur"  =>"Provider",
         "autre"  =>"Keiner von diesen",
         "Adresse de provenance des messages envoyés"  =>"Absender Adresse (From email field)",
         "Nombre de jours accordé pour la validation de l'abonnement" =>"Warten auf Bestätigung",
         "jours" =>"days",
         "Base de données"                         =>"Datenbank",
         "Serveur mysql"                                 =>"MySQL Server",
         "Nom d'utilisateur"                         =>"Username",
         "Mot de passe"                                  =>"Passwort",
         "Nom de la base de donnée"                 =>"Datenbankname",
         "Nom de la table de stockage des adresses" =>"Addressen-Tabelle",
         "Nom de la table d'attente de validation" =>"Bestätigungs-Tabelle",
         "Nom de la table de logs"         =>"Log-Tabelle",
         "Nom de la table de config"        =>"Konfigurationstabelle",
         "Mot de passe d'accès au panneau d'administration" =>"Administrations Passwort",
         "Nombre de newsletter à afficher par page de logs" =>"Anzahl der Logs pro Seite",
         "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin"  =>"URL der Website, z.B.:  http://www.myweb.de/ (abschließenden Slash nicht vergessen)",
         "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin" =>"Pfad zu phpMyNewsletter, z.B.: tools/newsletter/ (abschließenden Slash nicht vergessen)",
            "Langue"         =>"Language",
            "Activer le processus de validation des inscriptions" =>"Abonnementsbestätigung aktivieren",
            "OUI" =>"JA",
	    "NON" =>"NEIN",
	    "Lettre d'information N°"=> "Newsletter ",
	    "Collez les lignes suivantes dans le fichier include/config.inc.php" => "Cut & paste the lines below in include/config.inc.php"
);





?>
