<?

/* thanks to 
"Fabio A. Martins" <cuzido@s2discos.com> */




function translate($phrase) {
 global $lang;
 if($lang[$phrase]!="") return $lang[$phrase];
else return ("[** Translation Needed ] -> $phrase");
}




/********* New translation style *******/


$lang=array("Adresse e-mail"=>"Endereco de email",      
            "Inscription"=>"Inscrição",
            "Désinscription"=>"Desinscrição",
            "Nombre d'abonnés"=>"Número de inscritos",
            "Erreur ! Le mot de passe n'est pas valide"=>"Erro ! Senha Inválida",
            "En attente de validation"=>"Esperando pela validação",
            "Nbr de NewsLetter déjà envoyées"=>"Número de newsletter ja eviando",
            "Numéro de la prochaine NewsLetter"=>"Número do próximo newsletter",
            "Retour"=> "Voltar",
            "Erreur"=>"Erro",
            "Déjà inscrit"=>"Ja está na base de dados",
            "Impossible de trouver la base"=>"Impossível achar no banco de dados",
            "Impossible de trouver le serveur"=>"Impossível conectar ao host",
            "Erreur lors du flush de la table temp"=>"Erro durante limpeza na tabela temporária",
            "Appercu du message"=>"Previa da mensagem ",
            "Réinitialiser"=>"Reiniciar",
            "Sujet"=>"Assunto",
            "Rédiger un nouveau message"=>"Escrever uma nova mensagem",
            "Tous les champs doivent être remplis"=>"Todos os campos devem ser preenchidos",
            "Texte"=>"Texto",
            "Adresse Email non valide"=>"Endereço de email inválido",
            "Administration"=>"Área de adminstração",
             "Nouveau message"=>"Mensagem de notícia",
            "Liste des abonnés"=>"Lista de inscritos",
            "Ajout d'un abonné"=>"Adicionar um inscrito",
            "Suppression d'un abonné"=>"Deletar um inscrito",
            "Voir les logs"=>"Ver registro (log) 
registros (logs)",
            "Pour vous désinscrire, rendez-vous à l'adresse suivante" =>"Para se desincrever, vá para a seguinte URL",


            "Configuration"=>"Configuração",
            "Se déconnecter"=>"Fechar Sessão",
            "Configuration de phpMyNewsletter"=>"Configuração do phpMyNewsletter",
            "Editer la configuration"=>"Editar Configuração",
            "Editer les messages de bienvenue ..."=>"Editar mensagem de boas vindas ...",
            "Mise à jour de la configuration effectuée"=>"Configuração Atualizada",
            "Supprimer des abonnés"=>"Apagar inscritos",
            "Sélectionner les abonnés à supprimer"=>"Selecionar inscritos que voce deseja deletar",
            "Supprimer les abonnés sélectionnés"=>"Deletar inscritos selecionados",
            "Les abonnés sélectionnés ont été supprimé"=>"Selecionar inscritos deletados",
            "Importer un fichier texte dans la base de donnée"=>"Importar um arquivo texto na base de dados",
            "Importation effectuée"=>"Importação feita",
            "Logs de phpMyNewsletter"=>"Registros do phpMyNewsletter (logs)",
            "Heure"=>"Hour",
            "Sujet du message de bienvenue"=>"Assunto da mensagem de boas vindas",
            "Message de bienvenue envoyé après la confirmation de l'abonné"=>"Mensagem de boas vindas enviada após confirmação do inscrito",
            "Corps du message de bienvenue"=>"Corpo da mensagem de boas vindas",
            "Pied des messages"=>"Rodapé da mensagem",
            

            "Mettre à jour"=>"Atualizar",
            "Réinitialiser"=>"Reinicia",
            "Message de demande de confirmation"=>"Message de confirmação",
            "Inscription"=>"Inscrição",
            

            "Avertir de l'inscription par mail"=>"Informar o inscrito",
            "Un mail de d'information va être envoyé"=>"Uma informação de email foi enviada",
            "Nombre total d'abonnés"=>"Número de inscritos",
            "Vous n'avez pas d'abonnés"=>"Sem inscrito na base de dados",
            
            

            "Mot de passe"=>"Senha",
            "valider"=>"Usuário",
            "Identification"=>"Identificação",
            "Accès à l'administration"=>"Acesso à administração",
            

            "Rendez-vous à l'adresse suivante pour confirmer votre inscription"=>"Apenas vá para o seguinte endereço para confirmar sua inscrição.",
            "Si vous n'avez pas demandé d'inscription à cette newsletter, ignorez simplement ce message"=>"Se voce não requisitou esta inscrição, apenas ignore essa mensagem",
            "Confirmation de l'inscription"=>"Inscrição confirmada",
            
            

            "Votre inscription s'est bien déroulée"=>"Inscrição efetuada com sucesso",
            "L'inscription c'est bien déroulée"=>"Inscrição efetuada com sucesso",
            "Vous allez recevoir un mail de confirmation"=>"Um email de confirmação foi enviado a voce",
            "Vous êtes déjà inscrit"=>"Voce já esta na base de dados",
            "Vous n'êtes pas inscrit à cette Newsletter"=>"Voce não esta na base de dados",
            "Votre inscription a été confirmée"=>"Inscrição confirmada",
            "Désinscription de" =>"Desinscrição de",
            "effectuée, merci de votre visite" =>"Efetuada, obrigado pela sua visita",
            "Si vous désirez vous réinscrire, rendez vous à l'adresse suivante" =>"Se voce quer voltar sua inscrição, apenas clique aqui" ,
            
            

            "Nom de la lettre d'information"=>"Nome do newsletter",
            "Hébergeur" =>"Provedor",
            "autre" =>"Nenhum desses acima",
            "Adresse de provenance des messages envoyés" =>"Endereço de expedição (Do campo email)",
            "Nombre de jours accordé pour la validation de l'abonnement"=>"Esperando pela validação",
            "jours"=>"dias",
            "Base de données"=>"Base de dados",
            "Serveur mysql"=>"Servidor MySQL",
            "Nom d'utilisateur"=>"Nome do usuário",
            "Mot de passe"=>"Senha",
            "Nom de la base de donnée"=>"Nome do banco de dados",
            "Nom de la table de stockage des adresses"=>"Nome da tabela de enderecos",
            "Nom de la table d'attente de validation"=>"Nome da tabela de validação",
            "Nom de la table de logs"=>"Nome da tabela de registros",
            "Nom de la table de config"=>"Nome da tabela de configuração",
            "Mot de passe d'accès au panneau d'administration"=>"Senha da área de adminstração",
            "Nombre de newsletter à afficher par page de logs"=>"Numero de registros por páginas",
            "Adresse de votre page ex : http://www.myweb.com/ avec un / à la fin" =>"Endereco da página:  http://www.myweb.com/ (Não esqueca da / no final)", 
            "Emplacement du répertoire de phpMyNewsletter ex : tools/newsletter/ avec un / à la fin"=>"Caminho para o phpMyNewsletter por exemplo: tools/newsletter/ (Não esqueca da / no final)",
            "Langue"=>"Language",  
            "Activer le processus de validation des inscriptions"=>"Processo de validação da inscrição ativada",
            "OUI"=>"SIM",
            "NON"=>"NÃO",
            

            "Export"=>"Exportar",
            "Message envoyé"=>"Mensagem enviada",
            "Lettre d'information N°"=>"Newsletter #",
                "Envoyer le message"=>"Enviar mensagem",
                "Retour"=>"Voltar");
?>
