<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();

if(empty($_GET['id']) or !($catNome=$objDB->getOne("SELECT catNome FROM categorias WHERE Id=$_GET[id] LIMIT 1")) )
	Header("Location: ".HTTP_INDEX);

$objLay=new Layout(HTML_LAYOUT);
$objCad=$objLay->open(HTML_RANKCATEGORIA);

if(!isset($_GET['n']))
	$_GET['n']=0;

$page=$_GET['n']*PAGINA_RESULTADOS;

$arInfo=$objDB->getAll("SELECT cadastros.Id, cadSnome, votos, if(SUM(log.Id)/log.Id>0,SUM(log.Id)/log.Id,0) as Votoshoje
FROM cadastros, categorias
LEFT JOIN log ON (log.Id=cadastros.Id)
WHERE cadastros.cadCategoria=categorias.Id and categorias.Id=$_GET[id]
GROUP BY cadastros.Id
ORDER BY votos DESC, Votoshoje DESC
LIMIT $page,".PAGINA_RESULTADOS);

for($n=0;$n<count($arInfo);$n++){
	$arInfo[$n]['n']=(string)(($n+1)+($page));
	$arInfo[$n][3]=@(string)(int)$arInfo[$n][3];
	$arInfo[$n][1]=@htmlspecialchars($arInfo[$n][1]);
}

if($_GET['n']>0)
	$objCad->replace_once('ant',$_GET['n']-1);
else
	$objCad->remove(0);

$numpages=$objDB->getOne('SELECT if(FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.')=COUNT(*)/'.PAGINA_RESULTADOS.',FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.'),FLOOR(COUNT(*)/'.PAGINA_RESULTADOS.')+1) FROM cadastros WHERE cadastros.cadCategoria='.$_GET['id']);

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

$objCad->replace_once('cat',$catNome);
$objCad->replace_once('id',$_GET['id']);

$objCad->loop_replace('r',$arInfo);
$objLay->make($objCad);
$objDB->disconnect();

?>