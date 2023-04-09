<?
/********************************************************
	lang/eng/compose.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

$composeHStrings=array(
	0=>"Assunto",
	1=>"De",
	2=>"Para",
	3=>"CC",
	4=>"BCC",
	5=>"Data"
);

$composeStrings=array(
	0=>"Composi&ccedil;&atilde;o de Mensagem",
	1=>"Enviar Mensagem",
	2=>"Anexar",
	3=>"Inserir assinatura",
	4=>"Anexar",
	5=>"Mostrar contatos",
	6=>"Esconder contatos",
	7=>"Corpo da mensagem:",
	8=>"Adicionar",
	9=>"Em %d, %s escreveu:\n",
	10=>"--- Mensagem Original ---\n",
	11=>"Fechar Janela"
);

$composeErrors=array(
	0=>"The subject field is empty. Please enter a subject or click \"".$composeStrings[1]."\" again to send.",
	1=>"The \"from\" field is empty.  Please enter your email address.",
	2=>"The \"To\" field is empty.  Please specify the destination address.",
	3=>"Upload failed",
	4=>"No files received.",
    5=>"For spam prevention reasons, you may only send to %1 people (%2 total per session) every %3 seconds."
);
?>
