<?php
Header("Content-Type: image/png");
$im = ImageCreate(40, 25);
$verde = ImageColorAllocate($im, 0, 80, 0);
$white = ImageColorAllocate($im, 255, 255, 255);

$letras=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','z',0,1,2,3,4,5,6,7,8,9);

// Pega Número de divisão
list($div,$divi)=explode(".",$_GET['va']);
@$num=(string)($div/$divi);

// Pega Valores da query string
$code=$_GET['vb'];
$aRet=get_code($code);

for($n=0;$n<4;$n++){
	if($num[$n]==0) $mult=10;
	else $mult=$num[$n];
	$ref=$aRet[$n]/$mult;
	$aRet[$n]=$letras[$ref];
}

ImageString($im, 5, 2, 2, join('',$aRet) , $white);
ImagePng($im);
ImageDestroy($im);

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