<?
/********************************************************
	lang/es/main.inc
	(C)2001-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html

********************************************************/

function formatStatusString($num, $folder, $type){
	$str="";
	if ($type=="delete"){
		$str = "Eliminar mensaje $num ".($num>1?"s":"");
	}else if ($type == "move"){
		$str = "Se movió el mensaje $num ".($num>1?"s":"")." a $folder";
	}
	
	return $str;
}

$mainStrings=array(
	0=>"%n mensajes en total",
	1=>" mensajes encontrados",
	2=>"Previo",
	3=>" mensajes",
	4=>"Siguiente",
	5=>" mensajes",
	6=>"Asunto",
	7=>"Para",
	8=>"De",
	9=>"Fecha",
	10=>"Eliminar",
	11=>"Vaciar Basura",
	12=>"Archivo",
	13=>"Buscar",
	14=>"Tamaño",
	15=>"Sin Título",
	16=>"Mostrar",
	17=>"Check New",
	18=>"Delete All",
	19=>"Cancel"
);

$mainErrors=array(
	0=>"No se encontraron mensajes en esta carpeta",
	1=>"No hay mensajes en esta carpeta",
	2=>"No se pudieron mover los mensajes a la basura.",
	3=>"No se pudieron marcar los mensajes como borrados.",
	4=>"No se pudieron mover los mensajes.",
	5=>"Carpeta de Basura no especificada.",
	6=>"No se pudo tirar la basura",
    7=>"Are you sure you want to delete ALL messages in %f?"
);


?>
