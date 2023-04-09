<?



function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** No disponemos de la traducción de esta frase: ] -> $phrase");
}





/********* New translation style *******/

$lang=array("Adresse e-mail"=>"Direccion de E-mail",	
	    "Inscription"=>"Inscripción",
	    "Désinscription"=>"Cancelar inscripción",
	    "Nombre d'abonnés"=>"Numero de inscritos",
	    "Erreur ! Le mot de passe n'est pas valide"=>"Clave incorrecta",
	    "En attente de validation"=>"A la espera de validar",
	    "Nbr de NewsLetter déjà envoyées"=>"Noticias enviadas",
	    "Numéro de la prochaine NewsLetter"=>"Número de la próxima noticia",
	    "Retour"=> "Volver",
	    "Erreur"=>"Error",
	    "Déjà inscrit"=>"Ya se encuentra en la base de datos",
	    "Impossible de trouver la base"=>"No se encuentra en la base de datos",
	    "Impossible de trouver le serveur"=>"Error de conexión con el servidor",
	    "Erreur lors du flush de la table temp"=>"Se ha producido un error al regenerar la tabla temporal",
	    "Appercu du message"=>"Mensaje anterior",
	    "Réinitialiser"=>"Reiniciar",
	    "Sujet"=>"Tema:",
	    "Rédiger un nouveau message"=>"Crear un nuevo mensaje",
	    "Tous les champs doivent être remplis"=>"Debe rellenar todos los campos",
	    "Texte"=>"Texto",
	    "Adresse Email non valide"=>"Dirección de correo electrónico no válida",
	    "Administration"=>"Área de Administración",
	     "Nouveau message"=>"Nuevo mensaje",
	    "Liste des abonnés"=>"Lista de inscritos",
	    "Ajout d'un abonné"=>"Agregar una inscripción",
	    "Suppression d'un abonné"=>"Eliminar una inscripción",
	    "Voir l'historique"=>"Ver el control de acciones",
	    "Pour vous désinscrire, rendez-vous à l'adresse suivante" =>"para cancelar la inscripción copie en su navegador de internet o pulse la siguiente dirección: ",

	    "Configuration"=>"Configuración",
	    "Se déconnecter"=>"Salir",
	    "Configuration de phpMyNewsletter"=>"Configuración de la Lista de Correos",
	    "Editer la configuration"=>"Editar la configuración",
	    "Editer les messages de bienvenue ..."=>"Editar el mensaje de bienvenida ...",
	    "Mise à jour de la configuration effectuée"=>"Se ha actualizado la configuración requerida",
	    "Supprimer des abonnés"=>"Eliminar inscritos",
	    "Sélectionner les abonnés à supprimer"=>"seleccione los correos electrónicos que desea borrar de su lista de correo",
	    "Supprimer les abonnés sélectionnés"=>"Borrar los correos electrónicos seleccionados",
	    "Les abonnés sélectionnés ont été supprimé"=>"registros borrados",
	    "Importer un fichier texte dans la base de donnée"=>"Importar un archivo de texto a la base de datos",
	    "Importation effectuée"=>"La transferencia de datos ha sido completada con éxito",
	    "Logs de phpMyNewsletter"=>"Acciones de la Lista de Correos",
	    "Heure"=>"Hora",
	    "Sujet du message de bienvenue"=>"Tema del mensaje de bienvenida",
	    "Message de bienvenue envoyé après la confirmation de l'abonné"=>"Mensaje de bienvenida enviado después de la confirmacion",
	    "Corps du message de bienvenue"=>"Cuerpo del mensaje de bienvenida",
	    "Pied des messages"=>"Pie de mensaje",
	    
	    "Mettre à jour"=>"Actualizar",
	    "Réinitialiser"=>"Reiniciar",
	    "Message de demande de confirmation"=>"Mensaje de confirmación",
	    "Inscription"=>"Inscripción",
	    
	    "Avertir de l'inscription par mail"=>"Informar al suscriptor por correo electrónico",
	    "Un mail de d'information va être envoyé"=>"Se ha enviado un mensaje al interesado informándole que su correo electrónico ha sido incluido en la Lista de Correos",
	    "Nombre total d'abonnés"=>"Número total de inscritos",
	    "Vous n'avez pas d'abonnés"=>"Numero de inscritos en la base de datos",
	    
	    
	    "Mot de passe"=>"Clave",
	    "valider"=>"Acceso",
	    "Identification"=>"Identificatión",
	    "Accès à l'administration"=>"Acceso al panel de administración",
	    
	    "Rendez-vous à l'adresse suivante pour confirmer votre inscription"=>"para confirmar su inscripción copie en su navegador de internet o pulse la siguiente dirección: ",
	    "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message"=>"Si usted no ha pedido esta inscripción ignore y borre este mensaje.",
	    "Confirmation de l'inscription"=>"Confirmacion de la inscripción",
	    
	    
	    "Votre inscription c'est bien déroulée"=>"Inscripción correcta",
	    "L'inscription s'est bien déroulée"=>"Inscripción correcta",
	    "Vous allez recevoir un mail de confirmation"=>"Acabamos de enviarle a su correo electrónico un mensaje para confirmar su inscripción.",
	    "Vous êtes déjà inscrit"=>"Correo electrónico ya se había incluído en su base de datos.",
	    "Vous n'êtes pas inscrit à cette Newsletter"=>"Sus datos no están incluídos en nuestra base de datos",
	    "Votre inscription a été confirmée"=>"Inscripción confirmada",
	    "Désinscription de" =>"Borrar de la lista a",
	    "effectuée, merci de votre visite" =>"Acción realizada. Muchas gracias por su visita",
	    "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante" =>"Para volver a inscribirse pulse aqui " ,
	    
	    
	    "Nom de la lettre d'information"=>"Nombre de la Lista de Correos",
	    "Hébergeur" =>"Proveedor",
	    "autre" =>"Ninguna de las anteriores",
	    "Adresse de provenance des messages envoyés" =>"Campo FROM en el email del newsletter",
	    "Nombre de jours accordé pour la validation de l'abonnement"=>"Esperando validacion",
	    "jours"=>"dias",
	    "Base de données"=>"DataBase",
	    "Serveur mysql"=>"MySQL Server",
	    "Nom d'utilisateur"=>"Username",
	    "Mot de passe"=>"Password",
	    "Nom de la base de donnée"=>"Nombre de la base de datos",
	    "Nom de la table de stockage des adresses"=>"Nombre para la tabla de direcciones",
	    "Nom de la table d'attente de validation"=>"Nombre para la tabla de validaciones",
	    "Nom de la table de logs"=>"Nombre para la tabla de control de acciones",
	    "Nom de la table de config"=>"Nombre para la tabla de configuración",
	    "Mot de passe d'accès au panneau d'administration"=>"Clave para accederal panel de administración",
	    "Nombre de newsletter à afficher par page de logs"=>"Número de accesos por pagina",
	    "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin" =>"Pagina web: ejemplo: http://www.myweb.com/ (incluya el último / )", 
	    "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin"=>"Ruta de la Lista de Correos, ejemplo: tools/newsletter/ (incluya el ultimo / )",
	    "Langue"=>"Idioma",  
	    "Activer le processus de validation des inscriptions"=>"Activar el proceso de validación de las inscripciones",
	    "OUI"=>"SI",
	    "NON"=>"NO",
	    "Export" => "Exportar",
	    "Message envoyé"=>"EL mensaje ha sido enviado.",
	    "Collez les lignes suivantes dans le fichier include/config.inc.php" => "Corta y pega la información que aparece debajo en el archivo: include/config.inc.php",
	    "Lettre d'information N°"=>"SLKE - Noticias & News No.");
	  

?>
