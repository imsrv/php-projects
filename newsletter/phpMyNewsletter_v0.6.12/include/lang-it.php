<?

function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** Translation Needed ] -> $phrase");
}



$lang=array(  "Adresse e-mail"=>"Indirizzo E-mail",
	      "Inscription"=>"Iscrizione",
	      "Désinscription"=>"Cancellazione",
	      "Nombre d'abonnés"=>"Numero degli iscritti",	 
	      "Erreur ! Le mot de passe n'est pas valide"=>"Errore ! Password Sbagliata",
	      "En attente de validation"=>"In Attesa di Convalida",
	      "Nbr de NewsLetter déjà envoyées"=>"Numeri delle NewsLetter già spedite",
	      "Numéro de la prochaine NewsLetter"=>"Numero della prossima NewsLetter",

	      "Retour"=>"Indietro",
	      "Erreur"=>"Errore",
	      "Déjà inscrit"=>"Iscritto già presente",
	      "Impossible de trouver la base"=>"Non trovo il Database",
	      "Impossible de trouver le serveur"=>"Non posso connettermi all host",
	      "Erreur lors du flush de la table temp"=>"Errore durante il flush",

	      
	      /*** ENVOI DE MESSAGE ***/
	      "Appercu du message"=>"Anteprima Messaggio",
	      "Réinitialiser"=>"Reset",
	      "Sujet"=>"Oggetto",
	      "Rédiger un nouveau message"=>"Componi un nuovo messaggio",
	      "Tous les champs doivent être remplis"=>"Tutti i campi devono essere riempiti",
	      "Texte"=>"Testo",
	      "Adresse Email non valide"=>"Indirizzo Email non valido",	
	      
	
	      /*** ADMININSTRATION ***/
	      "Administration"=>"Administration Area",
	      "Nouveau message"=>"Nuovi messaggi",
	      "Liste des abonnés"=>"Lista Iscritti",
	      "Ajout d'un abonné"=>"Aggiungi un iscritto",
	      "Suppression d'un abonné"=>"Cancella un iscritto",
	      "Voir l'historique"=>"Vedi logs",
	      "Pour vous désinscrire, rendez-vous à l'adresse suivante"=>"per cancellarti, vai al seguente URL",
	      "Configuration"=>"Configurazione",
	      "Se déconnecter"=>"Log Out",	
	      "Configuration de phpMyNewsletter"=>"phpMyNewsletter Configurazione",
	      "Editer la configuration"=>"Edit Configurazione",
	      "Editer les messages de bienvenue ..."=>"Modifica il messaggio di benvenuto",
	      "Mise à jour de la configuration effectuée"=>"Configurazione aggiornata",
	      "Supprimer des abonnés"=>"Cancella Iscritti",
	      "Sélectionner les abonnés à supprimer" =>"Seleziona iscritti che vuoi cancellare",
	      "Supprimer les abonnés sélectionnés"	=>"Cancella iscritti selezionati",
	      "Les abonnés sélectionnés ont été supprimé" =>"Iscritti selezionati Cancellati",
	      
	      "Importer un fichier texte dans la base de donnée" =>"Importa un file di testo nel database",
	      "Importation effectuée"	=>"Importazione OK",
	
	      "Logs de phpMyNewsletter" =>"phpMyNewsletter logs",
	      "Heure" =>"Ora",
	      
	      
	      "Sujet du message de bienvenue" 	=>"Oggetto del messaggio di benvenuto",
	      "Message de bienvenue envoyé après la confirmation de l'abonné"=>"messaggio di benvenuto dopo la conferma iscritto",
	      "Corps du message de bienvenue"=>"Testo messaggio di benvenuto",
	      "Pied des messages" =>"Piedipagina messaggio" ,
	      
	      "Mettre à jour"=>"Aggiorna",
	      "Réinitialiser" =>"Ripulisci",
	      "Message de demande de confirmation" =>"Messaggio di Conferma",
	      "Inscription"=>"Iscrizione",
	      
	      "Avertir de l'inscription par mail" =>"Informa di una iscrizione per posta",
	      "Un mail de d'information va être envoyé" =>"Una Email di iscrizione inviata",
	      "Nombre total d'abonnés" =>"Numero di iscritto",
	      "Vous n'avez pas d'abonnés" =>"Nessun iscritto nel database",
	      
	 
	      "Mot de passe"  		=>"Password",
	      "valider" =>"Login",
	      "Identification"=>"Identificazione",
	      "Accès à l'administration"=>"Administration Access",
	      
	      "Rendez-vous à l'adresse suivante pour confirmer votre inscription" =>"Vai a questo link per confermare la tua iscrizione",
	      "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message" =>"Se non ti sei iscritto, ignora questo messaggio",
	      "Confirmation de l'inscription"=>"Conferma Iscrizione",
	      
	      
	      "Votre inscription c'est bien déroulée" =>"Iscrizione avvenuta",
	      "L'inscription s'est bien déroulée" =>"Iscrizione avvenuta",
	      "Vous allez recevoir un mail de confirmation" =>"Ti ho spedito una Email di conferma spedita",
	      "Vous êtes déjà inscrit" =>"Sei già Iscritto nel Database",
	      "Vous n'êtes pas inscrit à cette Newsletter" =>"Non sei iscritto nel Database",
	      "Votre inscription a été confirmée" =>"Iscrizione confermata",
	      "Désinscription de"  =>"Cancellazione di",
	      "effectuée, merci de votre visite"  =>"fatto, grazie per la visita",
	      "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante"  =>"If you want to subscribe back, just click here " ,

	      
	      "Nom de la lettre d'information" =>"Nome della Newsletter",
	      "Hébergeur"  =>"Provider",
	      "autre"  =>"Nessuno in elenco",
	      "Adresse de provenance des messages envoyés"  =>"Indirizzo di Spedizione (da campo email)",
	      "Nombre de jours accordé pour la validation de l'abonnement" =>"Aspetto la convalida",
	      "jours" =>"giorni",
	      "Base de données" 			=>"DataBase",
	      "Serveur mysql" 				=>"MySQL Server",
	      "Nom d'utilisateur" 			=>"Username",
	      "Mot de passe"  				=>"Password",
	      "Nom de la base de donnée" 		=>"Database Name",
	      "Nom de la table de stockage des adresses" =>"Address table",
	      "Nom de la table d'attente de validation" =>"Validation table",
	      "Nom de la table de logs" 	=>"Logs table",
	      "Nom de la table de config"=>"Config table",
	      "Mot de passe d'accès au panneau d'administration" =>"Administration area password",
	      "Nombre de newsletter à afficher par page de logs" =>"Number of logs per page",
	      "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin" =>"Web page url by example:  http://www.myweb.com/ (don't forget the last / )", 
	      "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin" =>"Path to phpMyNewsletter by example: tools/newsletter/ (don't forget the last / )",
	      "Langue" 	=>"Language",  
	      "Activer le processus de validation des inscriptions" =>"Enable Subscription Validation Process",
	      "OUI" =>"SI",
	      "NON" =>"NO",
	      "Lettre d'information N°"=> "Newsletter ",
	      "Collez les lignes suivantes dans le fichier include/config.inc.php" => "Cut & paste the lines below in include/config.inc.php"
);



?>
