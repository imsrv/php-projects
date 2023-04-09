<?
/*
Caso preciso colocar mais uma palavra no filtro é só seguir o exemplo :
$filtro[7]="bicha";
*/
$filtro[0]="viado";
$filtro[1]="viadinho";
$filtro[2]="viadão";
$filtro[3]="caralho";
$filtro[4]="buceta";
$filtro[5]="cú";
$filtro[6]="cu";
$filtro[7]="porra";
/*
Procura uma determinada palavra em uma palavra,caso haja a ocorrência retorna a mensagem vazia.
$filtro array com as palavras proibidas
$msg mensagem a ser verificada
*/
function familiar ($filtro,$msg) {
  $cont=0;
  for($i=0;$i < sizeof($filtro);$i++){
    $str=stristr($msg,$filtro[$i]);
    if(strlen($str)==strlen($filtro[$i])){
       $cont++;
       break;
    }
  }
  if($cont!=0){
    $msg="";
  }
  return $msg;
}
?>