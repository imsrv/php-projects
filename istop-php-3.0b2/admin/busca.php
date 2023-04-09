<div align="center">
<?php
require_once"../config.php";
require_once"html/Table.php";
aut_admin();

$objDB=start_db();

$res=$objDB->query("EXPLAIN cadastros");
while($ar=$res->fetchRow()){
	$sqlcmp.=" `$ar[0]` LIKE '%".$_POST['str']."%' or";
}
$sqlcmp=ereg_replace(" or$",'',$sqlcmp);
$sqlcmp="SELECT Id, cadSnome, Votos FROM cadastros WHERE ".$sqlcmp;
$ar=$objDB->getAll($sqlcmp);

// Monta Tabela
$atr['bs']=array('style'=>"font-family: verdana, arial; font-size: 8 pt; text-align: center");
$atr['cels']=array('bgcolor'=>"#DDFFDD");
$atr['celtt']=array('bgcolor'=>"#CECEFF",
					'style'=>"font-family: verdana, arial; font-size: 8 pt;  font-weight: bold; text-align: center");
$atr['all']=array('cellpadding'=>2,'style'=>"border: 1 solid #C0C0C0, text-align: center");


$table = new HTML_Table($atr['all']);

$table->setCellContents(0,0,'Resultados da Pesquisa');

$table->setCellContents(1,0,'Id');
$table->setCellContents(1,1,'Website');
$table->setCellContents(1,2,'Votos');

for($n=0;$n<count($ar);$n++){
	for($s=0;$s<count($ar[$n]);$s++){
		$table->setCellContents($n+2,$s,$ar[$n][$s]);
	}
	$table->setCellContents($n+2,$s,'<a href="log.php?id='.$ar[$n][0].'">Log</a>');
	$table->setCellContents($n+2,$s+1,'<a href="edit.php?id='.$ar[$n][0].'">Editar</a>');
	$table->setCellContents($n+2,$s+2,'<a href=" rem.php?id='.$ar[$n][0].'">Remover Website</a>');
}


$table->setAllAttributes($atr['bs']);
$table->updateAllAttributes($atr['cels']);
$table->updateCellAttributes(0,0,' colspan=6');
$table->updateCellAttributes(0,0,$atr['celtt']);
$table->updateRowAttributes(1,$atr['celtt']);

echo $table->toHtml();


?>
</div>