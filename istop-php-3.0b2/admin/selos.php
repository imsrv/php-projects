<div align="center">
<?php
require_once"../config.php";
require_once"HTML/Table.php";
require_once"HTML/QuickForm.php";

aut_admin();

$objDB=start_db();

$objForm=new HTML_QuickForm('up','post');
$objForm->addElement('header', 'header', 'Adicionar Selo');
$objForm->addElement('hidden', 'a', 'add');
$fUp=& $objForm->addElement('file', 'file', 'Imagem');
$objForm->addElement('submit', NULL, 'Enviar');
$objForm->display();

if($_GET['a']=='del'){
	unlink($path);
}elseif($_GET['a']='add'){
	if($objForm->validate()){
		$fUp->moveUploadedFile('../'.DIR_SELOS);	
	}
}

$resDir=opendir('../'.DIR_SELOS);
while($sFile=readdir($resDir)){
	if(ereg("\.gif|\.jpg|\.jpeg|\.bmp|\.png$",$sFile)){
		$sHTTP=HTTP_SELOS.$sFile;
		$sPath='../'.DIR_SELOS.$sFile;
		echo<<<END
			<center><img src="$sHTTP" border="0"><br>
			<a href="?a=del&path=$sPath">Remover</a></center>
			<br><br>
END;
	}
}

closedir($resDir);

?>
</div>