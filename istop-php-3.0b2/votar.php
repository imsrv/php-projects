<?
require_once('config.php');
require_once('layout.php');

$objDB=start_db();
$objLay=new Layout(HTML_LAYOUT);

$arInfo=$objDB->getRow('SELECT cadastros.Id, cadSnome, catNome, Votos FROM cadastros, categorias WHERE cadCategoria=categorias.Id and cadastros.Id='.$_REQUEST['id']);

if(isset($arInfo[1]))
	$arInfo[1]=htmlspecialchars($arInfo[1]);

if (count($arInfo)<4){
	$objCad=$objLay->open(HTML_VOTARERRO);
	$objCad->replace_once('erro','Website não encontrado');
	$objLay->make($objCad);
	$objDB->disconnect();
	exit;
}

if(isset($_POST['a']) and $_POST['a']=='conf' and !empty($_POST['code']) and verifica()){
	$objDB->query("DELETE FROM log WHERE Time<unix_timestamp()-(60*60*24)");

	if($objDB->getOne("SELECT COUNT(*) FROM log WHERE Id='$_POST[id]' and Ip='".getenv("REMOTE_ADDR")."'")<1){
		$objDB->query("UPDATE cadastros SET Votos=Votos+1 WHERE Id='$_POST[id]' LIMIT 1");
		$objDB->query("INSERT INTO log VALUES('$_POST[id]','".getenv("REMOTE_ADDR")."',unix_timestamp())");
		$objCad=$objLay->open(HTML_VOTARFINAL);

		$infoRow=$objDB->getRow("SELECT cadSnome, Votos, categorias.Id, categorias.catNome FROM cadastros, categorias WHERE cadastros.cadCategoria=categorias.Id and cadastros.Id=$_POST[id] LIMIT 1");
		$objCad->replace('c',$infoRow);

		$arq=fopen(DIR_LOG.date('d-m-Y'),"a+");
		fputs($arq,"$_POST[id]|".getenv('REMOTE_ADDR')."|".TIME("U")."|\n");
		fclose($arq);
	}else{
		$objCad=$objLay->open(HTML_VOTARERRO);
		$objCad->replace_once('erro','Você já votou neste website nas últimas 24 horas');
	}
	$objLay->make($objCad);
	$objDB->disconnect();
	exit;
}else
	unset($_POST);

$rand=gera_numeros();
list($va,$vb)=gera_dados($rand);


$objCad=$objLay->open(HTML_VOTAR);
$objCad->replace('f',$arInfo);
$objCad->replace_once('va',$va);
$objCad->replace_once('vb',$vb);
$objCad->replace_once('id',$_REQUEST['id']);

$objLay->make($objCad);
$objDB->disconnect();

function gera_dados($rand){
	$num=(string)rand(1001,9999);
	for($n=0;$n<4;$n++){
		if($num[$n]==0) $mult=10;
		else $mult=$num[$n];
		$ger=$mult*$rand[$n];
		$gerado.=strlen($ger).$ger;
	}
	$mult=rand(101,999);
	$toform=($mult*$num).'.'.$mult;
	return array($toform,$gerado);
}

function gera_numeros(){
	$rand[0]=rand(0,32);
	$rand[1]=(int)date("s");
	if($rand[1]>32)
		$rand[1]-=33;

	$rand[2]=(string)microtime();
	$rand[2]=(int)substr($rand[2],2,2);
	while($rand[2]>32)
		$rand[2]-=33;

	$rand[3]=(int)((date("s")+1)*(date("i")+1));
	while($rand[3]>32)
		$rand[3]-=33;

	//$letras=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','z',0,1,2,3,4,5,6,7,8,9);
	//echo $letras[$rand[0]].$letras[$rand[1]].$letras[$rand[2]].$letras[$rand[3]];

	return $rand;
}

function verifica(){
	GLOBAL $_POST;

	list($div,$divi)=explode(".",$_POST['va']);
	$num=(string)($div/$divi);
	$letras=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','z',0,1,2,3,4,5,6,7,8,9);

	$aRet=get_code($_POST['vb']);

	for($n=0;$n<4;$n++){
		if($num[$n]==0) $mult=10;
		else $mult=$num[$n];
		$ref=$aRet[$n]/$mult;
		$aRet[$n]=$letras[$ref];
	}
	$gtCode=join('',$aRet);

	if($gtCode==$_POST['code'])
		return True;
	else
		return False;
}

function get_code($code){
	for($n=0;$n<strlen($code);$n++){
		if($verificador or $n==0){
			$numloop=$code[$n];
			$verificador=False;
		}else{
			$ret='';
			for($s=0;$s<$numloop;$s++){
				$ret.=$code[$n+$s];
			}
			$aRet[]=$ret;
			$n+=$numloop-1;		
			$verificador=True;
		}
	}

	return $aRet;
}
?>