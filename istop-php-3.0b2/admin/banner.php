<div align="center">
<?
require_once('../config.php');
require_once('../layout.php');
require_once('HTML/QuickForm.php');
$objDB=start_db();
$oLay=new Layout('pages/banner.htm');

if($_GET['a']=='del'){
	$objDB->query("DELETE FROM banners WHERE Id='$_GET[id]'");
}elseif($_GET['a']=='edit'){
	$res=$objDB->query("SELECT * FROM banners WHERE Id='$_GET[id]'");
	$res->fetchInto($aDef,DB_FETCHMODE_ASSOC);

	$oForm=new HTML_QuickForm('add','post');
	$oForm->addElement('Header','head','Editar Informações:');
	$oForm->addElement('Hidden','a','editb');
	$oForm->addElement('Hidden','id',$_GET[id]);
	$oForm->addElement('Text','banImg','Imagem:');
	$oForm->addElement('Text','banUrl','Url:');
	$oForm->addElement('Text','banW','Largura:');
	$oForm->addElement('Text','banH','Altura:');
	$oForm->addElement('Submit',NULL,'Salvar Informações');
	$oForm->setdefaults($aDef);
	$oForm->display();
	exit;
}elseif($_POST['a']=='editb'){
	//$objDB->query
	$objDB->query("UPDATE banners SET banImg='$_POST[banImg]', banUrl='$_POST[banUrl]', banW='$_POST[banW]', banH='$_POST[banH]' WHERE Id='$_POST[id]' ");	
}

$oForm=new HTML_QuickForm('add','post');
$oForm->addElement('Header','head','Adicionar Banner:');
$oForm->addElement('Hidden','a','add');
$oForm->addElement('Text','img','Imagem:');
$oForm->addElement('Text','url','Url:');
$oForm->addElement('Text','w','Largura:');
$oForm->addElement('Text','h','Altura:');
$oForm->addElement('Submit',NULL,'Salvar Informações');

if($oForm->validate() and $_POST['a']=='add'){
	$objDB->query("INSERT INTO banners(`banImg`,`banUrl`,`banW`,`banH`) VALUES('$_POST[img]','$_POST[url]','$_POST[w]','$_POST[h]')");
}

$oForm->setdefaults(array('img'=>'http://','url'=>'http://'));

$aBns=$objDB->getAll("SELECT * FROM banners");

for($n=0;$n<count($aBns);$n++){
	if($aBns[$n][4]==0)
		$aBns[$n]['apv']='0 %';
	else{
		$aBns[$n]['apv']=$aBns[$n][4]*100/$aBns[$n][3];
		$aBns[$n]['apv']=round($aBns[$n]['apv'],2);
		settype($aBns[$n]['apv'],'string');
		$aBns[$n]['apv'].=' %';
	}
	if(ereg("\.swf$",$aBns[$n][1])){
		$aBns[$n]['img']='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#3,0,0,0" width="'.$aBns[$n][5].'" height="'.$aBns[$n][6].'"><param name="SRC" value="'.$aBns[$n][1].'"><embed src="'.$aBns[$n][1].'" pluginspage="http://www.macromedia.com/shockwave/download/" type="application/x-shockwave-flash" width="'.$aBns[$n][5].'" height="'.$aBns[$n][6].'"></object>';
	}else{
		if($aBns[$n][5]>0 and $aBns[$n][6]>0){
			$aBns[$n]['img']='<img width="'.$aBns[$n][5].'" height="'.$aBns[$n][6].' " src="'.$aBns[$n][1].'">';
		}else{
			$aBns[$n]['img']='<img src="'.$aBns[$n][1].'">';
		}
	}
}
$oLay->loop_replace('b',$aBns);
$oLay->does();
$oForm->display();
?>
Use apenas banners em formatos de imagem e arquivos em flash (.swf)<br>
Os campos largura e altura são obrigatórios apenas para banners em flash
</div>