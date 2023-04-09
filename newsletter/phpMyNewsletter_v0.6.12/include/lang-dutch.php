<?

function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** Translation Needed ] -> $phrase");
}


/********* New translation style *******/


$lang=array("Adresse e-mail"=>"e-mail Adres",   
            "Inscription"=>"Inschrijven",
            "Désinscription"=>"Uitschrijven",
            "Nombre d'abonnés"=>"Aantal abonees",
            "Erreur ! Le mot de passe n'est pas valide"=>"Fout ! Verkeerd paswoord",
            "En attente de validation"=>"Wachten op validatie",
            "Nbr de NewsLetter déjà envoyées"=>"Aantal reeds verzonden nieuwsbrieven",
            "Numéro de la prochaine NewsLetter"=>"Nummer van de volgende nieuwsbrief",
            "Retour"=> "Terug",
            "Création de la base de donnée"=>"Database aangemaakt",
            "Création des tables"=>"Tabellen aangemaaakt",
            "Erreur"=>"Fout",
            "Déjà inscrit"=>"U bestaat reeds in de database",
            "Impossible de trouver la base"=>"Kan de database niet vinden",
            "Impossible de trouver le serveur"=>"Kan geen verbinding maken met de host",
            "Erreur lors du flush de la table temp"=>"Fout tijdens het maken van de tijdelijke tabel",
            "Appercu du message"=>"Bericht voorbeeld",
            "Réinitialiser"=>"Reset",
            "Sujet"=>"Onderwerp",
            "Rédiger un nouveau message"=>"Nieuw Bericht aanmaken",
            "Tous les champs doivent être remplis"=>"Alle velden dienen ingevuld te worden",
            "Texte"=>"Tekst",
            "Adresse Email non valide"=>"Ongeldig e-mail adres",
            "Administration"=>"Administrative zone",
            "Nouveau message"=>"Nieuw bericht",
            "Liste des abonnés"=>"Abonnee lijst",
            "Ajout d'un abonné"=>"Abonnee toevoegen",
            "Suppression d'un abonné"=>"Abonnee verwijderen",
            "Voir l'historique"=>"Logboek bekijken",
            "Pour vous désinscrire, rendez-vous à l'adresse suivante" =>"Om uit te schrijven, ga naar volgende URL",
            "Configuration"=>"Configuratie",
            "Se déconnecter"=>"Log Out",
            "Configuration de phpMyNewsletter"=>"Configuratie van phpMyNewsletter",
            "Editer la configuration"=>"Configuration aanpassen",
            "Editer les messages de bienvenue ..."=>"Welkomst bericht aanpassen ...",
            "Mise à jour de la configuration effectuée"=>"Configuratie is gewijzigd",
            "Supprimer des abonnés"=>"Abonnees verwijderen",
            "Sélectionner les abonnés à supprimer"=>"Selecteer de abonnee die u wil verwijderen",
            "Supprimer les abonnés sélectionnés"=>"Verwijder geselecteerde abonnees",
            "Les abonnés sélectionnés ont été supprimé"=>"Geselecteerde abonnees verwijderd",
            "Importer un fichier texte dans la base de donnée"=>"Importeer een tekst bestand in de database",
            "Importation effectuée"=>"Importering klaar",
            "Logs de phpMyNewsletter"=>"Logboek phpMyNewsletter",
            "Heure"=>"Uur",
            "Sujet du message de bienvenue"=>"Onderwerp van het welkomstbericht",
            "Message de bienvenue envoyé après la confirmation de l'abonné"=>"Welkomst bericht verzonden na bevestiging van de abonnee",
            "Corps du message de bienvenue"=>"Welkom tekst",
            "Pied des messages"=>"Voettekst",
            

            "Mettre à jour"=>"Aanpassen",
            "Réinitialiser"=>"Reset",
            "Message de demande de confirmation"=>"Bericht bevestiging",
            "Inscription"=>"Inschrijving",
            

            "Avertir de l'inscription par mail"=>"Inschrijving verwittigen per e-mail",
            "Un mail de d'information va être envoyé"=>"Een informatie e-mail werd verzonden",
            "Nombre total d'abonnés"=>"Nummer van de abonnee",
            "Vous n'avez pas d'abonnés"=>"Geen abonnees in de database",
            
            

            "Mot de passe"=>"Paswoord",
            "valider"=>"Login",
            "Identification"=>"Identificatie",
            "Accès à l'administration"=>"Administratie toegang",
            

            "Rendez-vous à l'adresse suivante pour confirmer votre inscription"=>"Volg deze link om uw inschrijving te bevestigen",
            "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message"=>"Indien u geen inschrijving op deze nieuwsbrief aangevraagd hebt, negeer dan deze e-mail",
            "Confirmation de l'inscription"=>"Inschrijf bevestiging",       
            

            "Votre inscription c'est bien déroulée"=>"Uw inschrijving is aanvaard",
            "L'inscription s'est bien déroulée"=>"De inschrijving werd aanvaard",
            "L'inscription c'est bien déroulée"=>"De inschrijving is aanvaard",
            "Vous allez recevoir un mail de confirmation"=>"Een bevestigings e-mail wordt naar u verzonden",
            "Vous êtes déjà inscrit"=>"U bent reeds ingeschreven",
            "Vous n'êtes pas inscrit à cette Newsletter"=>"U bent nog niet ingeschreven op deze nieuwsbrief",
            "Votre inscription a été confirmée"=>"Uw inschrijving werd bevestigd",
            "Désinscription de" =>"Uitschrijving van",
            "effectuée, merci de votre visite" =>"klaar, dank u voor het bezoek",
            "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante" =>"Indien u terug wilt inschrijven, klik dan hier" ,                
            "Nom de la lettre d'information"=>"Naam van de nieuwsbrief",
            "Hébergeur" =>"Provider",
            "autre" =>"Andere",
            "Adresse de provenance des messages envoyés" =>"Hoofdadres voor de ontvangen berichten",
            "Nombre de jours accordé pour la validation de l'abonnement"=>"Wachten op geldigheidscontrole",
            "jours"=>"dagen",
            "Base de données"=>"Database",
            "Serveur mysql"=>"MySQL Server",
            "Nom d'utilisateur"=>"Gebruikersnaam",
            "Mot de passe"=>"Paswoord",
            "Nom de la base de donnée"=>"Naam van de Database",
            "Nom de la table de stockage des adresses"=>"Adres tabel",
            "Nom de la table d'attente de validation"=>"Bevestigingstabel",
            "Nom de la table de logs"=>"Logboek tabel",
            "Nom de la table de config"=>"Configuratietabel",
            "Mot de passe d'accès au panneau d'administration"=>"Paswoord voor administrative zone",
            "Nombre de newsletter à afficher par page de logs"=>"Aantal logs per pagina",
            "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin" =>"Voorbeeld van een url:  http://www.myweb.com/ (vergeet de laatste / niet)", 
            "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin"=>"voorbeeld route naar phpMyNewsletter : tools/newsletter/ (vergeet de laatste / niet)",
            "Langue"=>"Taal",  
            "Activer le processus de validation des inscriptions"=>"Activeren van de inschrijvingsbevestigingcontrole",
            "OUI"=>"JA",
            "NON"=>"NEE",           
            "Export" => "Export",
            "Exporter les abonnés" => "Exporteren van abonnees",
            "exporter" => "export",
            "Collez les lignes suivantes dans le fichier include/config.inc.php3" => "Knip en plak inderstaande lijnen in de include/config.inc.php3",
            "Créé le fichier include/config.inc.php3, puis Collez les lignes suivantes dans ce fichier."=>"Maak het include/config.inc.php3 bestand aan, knip en plak dan onderstaande lijnen in dit bestand",
            

            "Message envoyé"=>"Bericht verzonden",
            "Lettre d'information N°"=>"Nieuwsbrief #",
            "Envoyer le message"=>"Bericht verzenden",
            "Retour"=>"Ga terug",





            "Créer la base de donnée"=>"Maak database aan",
            "Créer les tables"=>"Maak tabellen aan"




);
?>
