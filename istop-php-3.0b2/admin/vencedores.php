<?php
require_once"../config.php";
require_once"HTML/Table.php";
require_once"../layout.php";
aut_admin();

$objDB=start_db();
$objLay=new Layout('../'.HTML_VENCEDORESMODELO);

$objLay->replace_once('data',date("d/m/Y"));

//Gera Ranking Geral
$arRg=$objDB->getAll("SELECT cadSnome, cadUrl, catNome,Votos 
					  FROM cadastros 
					  LEFT JOIN categorias ON categorias.Id=cadCategoria
					  ORDER BY Votos DESC 
					  LIMIT 10");

for($n=0;$n<count($arRg);$n++){
	$arRg[$n]['n']=(string)(int)($n+1);
}

$objLay->loop_replace('rg',$arRg);

// Gera Rankings por Categoria
$objMrc=$objLay->get_code('c');

$arCols=$objDB->getCol("SELECT Id FROM categorias");
foreach($arCols as $v){
	$arMrg=$objDB->getAll("SELECT cadSnome, cadUrl, Votos 
						   FROM cadastros 
						   WHERE cadastros.cadCategoria='$v'
						   ORDER BY Votos DESC 
						   LIMIT 3");
	if(count($arMrg)>0){
		$catNome=$objDB->getOne("SELECT catNome FROM categorias WHERE Id='$v'");

		for($n=0;$n<count($arMrg);$n++){
			$arMrg[$n]['n']=(string)(int)($n+1);
		}

		$objRc=$objMrc;
		$objRc->replace_once('catnome',$catNome);
		$objRc->loop_replace('rc',$arMrg);
		$code.=$objRc->code.'<br>';
	}
}
$objLay->code_replace('c',$code);

if($_GET['a']=='save'){
	$arq=fopen('../'.HTML_VENCEDORES,"w+");
	fwrite($arq,$objLay->code);
	fclose($arq);
	echo'<center>Arquivo vencedores.htm salvo na sua pasta de arquivos HTML: </center>';
}else{
	$objLay->does(NULL,'../');
	echo'<center><a href="?a=save">Salvar Página</a></center>';
}

?>