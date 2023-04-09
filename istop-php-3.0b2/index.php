<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();

$objLay=new Layout(HTML_LAYOUT);
$objCad=$objLay->open(HTML_RANK);

if(!isset($_GET['n']))
	$_GET['n']=0;

$page=$_GET['n']*PAGINA_RESULTADOS;

$arInfo=$objDB->getAll("SELECT cadastros.Id, cadSnome, votos, catNome, if(SUM(log.Id)/log.Id>0,SUM(log.Id)/log.Id,0) as Votoshoje
FROM cadastros, categorias
LEFT JOIN log ON (log.Id=cadastros.Id)
WHERE cadastros.cadCategoria=categorias.Id
GROUP BY cadastros.Id
ORDER BY votos DESC, Votoshoje DESC
LIMIT $page,".PAGINA_RESULTADOS);

for($n=0;$n<count($arInfo);$n++){
	$arInfo[$n]['n']=(string)(($n+1)+($page));
	$arInfo[$n][4]=@(string)(int)$arInfo[$n][4];
	$arInfo[$n][1]=@htmlspecialchars($arInfo[$n][1]);
}

if($_GET['n']>0)
	$objCad->replace_once('ant',$_GET['n']-1);
else
	$objCad->remove(0);

$numpages=$objDB->getOne('SELECT if(FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.')=COUNT(*)/'.PAGINA_RESULTADOS.',FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.'),FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.')+1) FROM cadastros');

if($_GET['n']<$numpages-1)
	$objCad->replace_once('prox',$_GET['n']+1);
else
	$objCad->remove(1);

if($numpages>1){
	$objNs=$objCad->get_code(0);
	$objNsn=new Layout;
	$code='';
	for($n=0;$n<$numpages;$n++){
		$objNsn->code=$objNs->code;
		$objNsn->replace_once('n',$n);
		$objNsn->replace_once('m',$n+1);
		$code.=$objNsn->code;
	}
	$objCad->code_replace(0,$code);
}else
	$objCad->code_remove(0);

$objCad->loop_replace('r',$arInfo);
$objLay->make($objCad);
$objDB->disconnect();

?>