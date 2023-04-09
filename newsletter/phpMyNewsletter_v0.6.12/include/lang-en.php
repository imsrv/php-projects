<?





function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** Translation Needed ] -> $phrase");
}



/********* New translation style *******/

$lang=array("Adresse e-mail"=>"E-mail Address",	
	    "Inscription"=>"Subscription",
	    "Désinscription"=>"Unsubscription",
	    "Nombre d'abonnés"=>"Number of subscribers",
	    "Erreur ! Le mot de passe n'est pas valide"=>"Error ! Wrong password",
	    "En attente de validation"=>"Waiting for validation",
	    "Nbr de NewsLetter déjà envoyées"=>"Numbers of newsletter already sent",
	    "Numéro de la prochaine NewsLetter"=>"Number of the next newsletter",
	    "Retour"=> "Back",
	    "Erreur"=>"Error",
	    "Déjà inscrit"=>"Already in the Database",
	    "Impossible de trouver la base"=>"Unable to find Database",
	    "Impossible de trouver le serveur"=>"Unable to connect to host",
	    "Erreur lors du flush de la table temp"=>"Error during temporary table flush",
	    "Appercu du message"=>"Message Preview",
	    "Réinitialiser"=>"Reset",
	    "Sujet"=>"Subject",
	    "Rédiger un nouveau message"=>"Compose a new message",
	    "Tous les champs doivent être remplis"=>"All fields have to be filled in",
	    "Texte"=>"Text",
	    "Adresse Email non valide"=>"Invalid Email Address",
	    "Administration"=>"Administration Area",
	    "Nouveau message"=>"News message",
	    "Liste des abonnés"=>"Subscribers list",
	    "Ajout d'un abonné"=>"Add a subscriber",
	    "Suppression d'un abonné"=>"Delete a Subscriber",
	    "Voir l'historique"=>"View logs",
	    "Pour vous désinscrire, rendez-vous à l'adresse suivante" =>"To unsubscribe, go to the followig URL",

	    "Configuration"=>"Configuration",
	    "Se déconnecter"=>"Log Out",
	    "Configuration de phpMyNewsletter"=>"phpMyNewsletter Configuration",
	    "Editer la configuration"=>"Edit Configuration",
	    "Editer les messages de bienvenue ..."=>"Edit welcome message ...",
	    "Mise à jour de la configuration effectuée"=>"Configuration updated",
	    "Supprimer des abonnés"=>"Delete Subscribers",
	    "Sélectionner les abonnés à supprimer"=>"Select subscibers you want to delete",
	    "Supprimer les abonnés sélectionnés"=>"Delete selected subscribers",
	    "Les abonnés sélectionnés ont été supprimé"=>"Selected subscribers deleted",
	    "Importer un fichier texte dans la base de donnée"=>"Import a text file in the database",
	    "Importation effectuée"=>"Importation Done",
	    "Logs de phpMyNewsletter"=>"phpMyNewsletter logs",
	    "Heure"=>"Hour",
	    "Sujet du message de bienvenue"=>"Welcome message subject",
	    "Message de bienvenue envoyé après la confirmation de l'abonné"=>"Welcome message sent after subscriber confirmation",
	    "Corps du message de bienvenue"=>"Welcome message body",
	    "Pied des messages"=>"Message footer",
	    
	    "Mettre à jour"=>"Update",
	    "Réinitialiser"=>"Reset",
	    "Message de demande de confirmation"=>"Confirmation message",
	    "Inscription"=>"Subscription",
	    
	    "Avertir de l'inscription par mail"=>"Inform the subscriber",
	    "Un mail de d'information va être envoyé"=>"An information email has been sent",
	    "Nombre total d'abonnés"=>"Number of subscriber",
	    "Vous n'avez pas d'abonnés"=>"No subscriber in the database",
	    
	    
	    "Mot de passe"=>"Password",
	    "valider"=>"Login",
	    "Identification"=>"Identification",
	    "Accès à l'administration"=>"Administration Access",
	    
	    "Rendez-vous à l'adresse suivante pour confirmer votre inscription"=>"Just go to the the following link to confirm your subscription",
	    "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message"=>"If you didn't request this subscription, just ignore this message",
	    "Confirmation de l'inscription"=>"Subscription confirmation",
	    
	    
	    "Votre inscription c'est bien déroulée"=>"Subscription successfull",
	    "L'inscription s'est bien déroulée"=>"Subscription successfull",
	    "Vous allez recevoir un mail de confirmation"=>"A confirmation email has been sent to you",
	    "Vous êtes déjà inscrit"=>"You are already in the database",
	    "Vous n'êtes pas inscrit à cette Newsletter"=>"You're not in the database",
	    "Votre inscription a été confirmée"=>"Subscription confirmed",
	    "Désinscription de" =>"Unsubscription of",
	    "effectuée, merci de votre visite" =>"done, thank you for your visite",
	    "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante" =>"If you want to subscribe back, just click here " ,
	    
	    
	    "Nom de la lettre d'information"=>"Newsletter name",
	    "Hébergeur" =>"Provider",
	    "autre" =>"None of the above",
	    "Adresse de provenance des messages envoyés" =>"Expediting Address (From email field)",
	    "Nombre de jours accordé pour la validation de l'abonnement"=>"Waiting for validation",
	    "jours"=>"days",
	    "Base de données"=>"DataBase",
	    "Serveur mysql"=>"MySQL Server",
	    "Nom d'utilisateur"=>"Username",
	    "Mot de passe"=>"Password",
	    "Nom de la base de donnée"=>"Database Name",
	    "Nom de la table de stockage des adresses"=>"Address table",
	    "Nom de la table d'attente de validation"=>"Validation table",
	    "Nom de la table de logs"=>"Logs table",
	    "Nom de la table de config"=>"Config table",
	    "Mot de passe d'accès au panneau d'administration"=>"Administration area password",
	    "Nombre de newsletter à afficher par page de logs"=>"Number of logs per page",
	    "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin" =>"Web page url by example:  http://www.myweb.com/ (don't forget the last / )", 
	    "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin"=>"Path to phpMyNewsletter by example: tools/newsletter/ (don't forget the last / )",
	    "Langue"=>"Language",  
	    "Activer le processus de validation des inscriptions"=>"Enable Subscription Validation Process",
	    "OUI"=>"YES",
	    "NON"=>"NO",
	    
	    "Export" => "Export",
	    "Exporter les abonnés" => "Export subscribers",
	    "exporter" => "export",

	    "Collez les lignes suivantes dans le fichier include/config.inc.php" => "Cut & paste the lines below in include/config.inc.php",
	    "Créé le fichier include/config.inc.php, puis Collez les lignes suivantes dans ce fichier."=>"Create the include/config.inc.php file, then Cut & paste the lines below in this file",
	    
	    "Message envoyé"=>"Message Sent",
	    "Lettre d'information N°"=>"Newsletter #",
	    "Envoyer le message"=>"Send message",
	    "Retour"=>"Go Back",




	    "Créer la base de donnée"=>"Create database",
	    "Créer les tables"=>"Create database tables",
	    "inscrit"=>"subscriber",
	    "inscrits"=>"subscribers"

);
?>
