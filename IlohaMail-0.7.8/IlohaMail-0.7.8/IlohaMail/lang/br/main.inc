<?
/********************************************************
	lang/eng/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "Exclu&iacute;da(s) $num mensagem(ns)".($num>1?"":"");
	}else if ($type == "move"){
		$str = "Movida $num mensagem(ns)".($num>1?"":"")." para $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"Mostrando %p de %n",
	1=>" mensagens encontradas",
	2=>"Anterior",
	3=>" msgs",
	4=>"Pr&oacute;xima",
	5=>" msgs",
	6=>"Assunto",
	7=>"Para",
	8=>"De",
	9=>"Data",
	10=>"Excluir",
	11=>"Esvaziar Excluidas",
	12=>"Arquivo",
	13=>"Procurar",
	14=>"Tamanho",
	15=>"sem t&iacute;tulo",
	16=>"Mostrar",
	17=>"Checar correio",
	18=>"Apagar todas",
	19=>"Cancelar"
);

$mainErrors=array(
	0=>"Nenhuma mensagem encontrada nessa pasta",
	1=>"Nenhuma mensagem nessa pasta",
	2=>"Imposs&iacute;vel mover mensagens para a pasta Excluidas.",
	3=>"Imposs&iacute;vel marcar mensagens como excluidas.",
	4=>"Imposs&iacute;vel mover mensagens.",
    5=>"Pasta Excluidas n&atilde;o especificada.",
	6=>"Imposs&iacute;vel esvaziar Excluidas",
	7=>"Tem certeza de que quer excluir TODAS as mensagens em %f?"
);


?>
