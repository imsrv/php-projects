<?
/*
Todas as funções foram retiradas do tutorial do Mauricio Vivas .Você encontra no site
www.phpbrasil.com e www.phpfree.k8.com.br
*/
$host	= "localhost";//Host do banco de dados
$id		= "root"; //Identificação do usuario
$senha	= ""; //Senha para acesso ao banco de dados
$db		= "chat2"; //Banco de dados a ser acessado
$tmesg	= 1;//Tempo de vida mensagem em minutos
$tuser	= 1;//Tempo de vida do perfil do usuario em minutos
$ip= getenv ("REMOTE_ADDR");//IP do usuario
$refresh= 2;//Tempo em segundos do refresh

// Constantes com  características de elementos do chat
// ESQUEMA DE COR PADRÃO
define("botao_up", "#000000"); // define a cor do botão quando ele estiver normal
define("botao_over", "#666666"); // define a cor do botão quando o mouse estiver sobre ele
define("careta_up", "#FFFFFF"); // define a cor de fundo da careta quando estiver normal
define("careta_over", "lightblue"); // define a cor de fundo da careta quando o mouse estiver sobre ela
define("careta_titulo", "navy"); // define a cor da barra de título da caixa de caretas

/*ESQUEMA DE COR SUGERIDO COM O ARQUIVO romano2.css
	Para usar esse esquema, renomeie o arquivo romano.css para qualquer outro nome e em seguida
	renomeie o arquivo romano2.css para romano.css e comente o esquema de cor acima e descomente
	o esquema a seguir.
define("botao_up", "lightblue"); // define a cor do botão quando ele estiver normal
define("botao_over", "yellow"); // define a cor do botão quando o mouse estiver sobre ele
define("careta_up", "#F5FFFA"); // define a cor de fundo da careta quando estiver normal
define("careta_over", "lightblue"); // define a cor de fundo da careta quando o mouse estiver sobre ela
define("careta_titulo", "#FFD700");  // define a cor da barra de título da caixa de caretas
*/


//$lang	= "pt_BR"; // define a lingua usada no chat

/*
A classe comum possui todas as funções e variaveis comuns a outras classes .Assim
todas as outras classes são extensões da classe comum.
*/
class comum {
   var $conexao;// valor para conexão ao MySQL
   var $prefix;//É o numero da tabela

/*
 A função conect abre a comunicação ao banco de dados.
*/
   function conect ($host,$id,$pass,$db,$prefix="") {
     $this->prefix=$prefix;
     $this->conexao = mysql_connect($host,$id,$pass);
     mysql_select_db($db,$this->conexao);
   }
/*
 Fecha a conexão do banco de dados.
*/
   function close () {
     mysql_close($this->conexao);
   }
/*
  Insere valores em determinada tabela.As variaveis $campos e $valores são arrays.
  $campo recebe o nome dos campos a ser inseridos e $valores (como o nome dix) os valores
  a serem inseridos.
  Elas devem possuir o numero de elementos e possuir a mesma ordem .
  $tab é nome da tabela a receber os valores.Ex :
*/
   function insere ($campos,$valores,$tab){
     $inicio="INSERT INTO $tab";
     if($this->prefix != ""){
       $inicio.="_$this->prefix (";
     }else{
       $inicio.="(";
     }
     $meio=") VALUES (";
     $fim=")";
     $valor = sizeof($campos); //verifica o numero de elementos do array
     $strc="";
     for($i=0;$i <= ($valor-1);$i++){
        $strc.="$campos[$i]";
        if($i != ($valor-1)){
          $strc.=",";
        }
     }
     $strv="";
     for($k=0;$k <= ($valor-1);$k++){
        $strv.="\"$valores[$k]\"";
        if($k != ($valor-1)){
          $strv.=",";
        }
     }
     $insere="$inicio$strc$meio$strv$fim";
     mysql_query($insere,$this->conexao);
   }
/*
  Todas tabelas das salas tem um campo chamado time,logo todos elementos de uma tabela
  um tempo de vida.
  $tempo determina esse tempo de vida.
  $tab a tabela.
*/
   function atualiza ($tempo,$tab) {
     $time = @time();
     $timeout = time()-(60*$tempo);
     $consulta = "SELECT time FROM $tab";
     if($this->prefix != ""){
        $consulta .="_$this->prefix";
     }
     $resultado = mysql_query($consulta, $this->conexao);
     while ($linha = mysql_fetch_row($resultado)) {
       if($linha[0] < $timeout){
         $excluir = "DELETE FROM $tab";
         if($this->prefix != ""){
            $excluir .="_$this->prefix WHERE time = '$linha[0]'";
         }
         $atualiza = mysql_query($excluir, $this->conexao);
       }
     }
   }

/*
Seleciona todos campo na tabela
$campo nome do campo a ser consultado
$valor valor do campo a ser consultado
*/
   function select($campo,$valor,$tab="users") {
     $busca="SELECT * FROM $tab";
     if($this->prefix != ""){
        $busca.="_$this->prefix WHERE $campo=\"$valor\";";
     }else{
        $busca.=" WHERE $campo=\"$valor\";";
     }
     $recebe=mysql_query($busca,$this->conexao);
     $linha = mysql_fetch_row($recebe);
     return $linha;
   }

}

/*
A classe perfil é uma extensão da classe comum .Ela possui todas as funções para
manipulação dos usuarios.
*/
class perfil extends comum{
/*
A função update realiza uma atualização em um dado elemento da de controle de usuarios.
$ncampo nome do campo a ser atualizado.
$nvalor valor a ser alterado.
$campo  nome do campo a ser consultado.
$valor valor do campo a ser consultado
*/
   function update ($ncampo,$nvalor,$campo,$valor) {
     $resultado = "UPDATE users_$this->prefix SET $ncampo ='$nvalor' WHERE $campo ='$valor'";
     $atualiza = mysql_query($resultado,$this->conexao);
   }

/*
Remove determinado elemento da tabela de controle de usuarios
$campo nome do campo a ser consultado
$valor valor do campo a ser consultado
*/
   function remove ($campo,$valor) {
     $excluir = "DELETE FROM users_$this->prefix WHERE $campo ='$valor'";
     $atualiza = mysql_query($excluir,$this->conexao);
   }

/*
Imprimi em forma de menu suspenso os nome dos usuarios no chat.
*/
   function imprimir($sel) {
     echo "<option>TODOS</option>";
     $consulta = "SELECT nome FROM users_$this->prefix ORDER BY codigo ASC";
     $resultado = mysql_query($consulta,$this->conexao);
     while ($linha = mysql_fetch_row($resultado)) {
       $tar="";
       if($sel ==$linha[0]){
         $tar="selected";
       }
     echo "<option value=\"$linha[0]\" $tar>$linha[0]</option>";
     }
   }

/*
Pega o nome do usuario($valor) do chat e retorna em forma de tag o seu perfil.
*/
   function nick($valor) {
      $retval="TODOS";
      $busca="SELECT * FROM users_$this->prefix WHERE nome=\"$valor\";";
      $recebe=mysql_query($busca,$this->conexao);
      $linha = mysql_fetch_row($recebe);
      $teste=sizeof($linha);
      switch ($linha[5]){
        case "Azul":
           $cor="#0000FF";
           break;
        case "Vermelho":
           $cor="#FF0000";
           break;
        case "Preto":
           $cor="#000000";
           break;
        case "Verde":
           $cor="#339933";
           break;
        case "Roxo":
           $cor="#9900CC";
           break;
        case "Laranja":
           $cor="#FF9900";
           break;
      }
      if($teste != 1){
         if($linha[4] != 69){
           $retval="<img border=0 src=caretas/$linha[4].gif width='30' height='30' align='middle'><font color=$cor>$linha[3]</font>";
         }
         else{
           $retval="<font color=$cor>$linha[3]</font>";
         }
      }
      return $retval;
   }

}

/*
Extensão da classe comum.Responsavel pelas as mensagens do chat.
*/
class mensagem extends comum{
/*
Imprimi todas as mensagens do chat
*/
   function imprimir($nome,&$valor,$som) {
     $consulta = "SELECT * FROM msg_$this->prefix ORDER BY codigo ASC";
     $resultado = mysql_query($consulta,$this->conexao);
     $msg="";
     while ($linha = mysql_fetch_row($resultado))
     {
        if ($valor < $linha[0]){
           $valor=$linha[0];
           if($linha[5] != "ON"){
              require "./admin/som.php";
           }
           else{
             if(($linha[3]== $nome)||($linha[2]== $nome)){
                require "./admin/som.php";
             }
           }
        }
     }
     return $msg;
   }
}

/*
Extensão da classe comum.Responsavel pela parte administrativa do chat.
*/
class tab extends comum {
/*
Cria as tabelas inicias do chat.
*/
	function ini (){
		#cria variavel para enviar mensagem
		global $msg;
		global $msg2;
		# primeira tabela: salas
		$cria1 = "CREATE TABLE salas (codigo INT AUTO_INCREMENT PRIMARY KEY, nome CHAR(20),descr CHAR(255))";
		if (mysql_query($cria1,$this->conexao)) {
			$msg = "Tabela salas criada com sucesso";
		} else {
			$msg = "Erro ao criar a tabela salas : ".mysql_error ();
		}
		# segunda tabela: block
		$cria2 = "CREATE TABLE block (codigo INT AUTO_INCREMENT PRIMARY KEY, time INT,ip CHAR(20))";
		if (mysql_query($cria2,$this->conexao)) {
			$msg2 = "Tabela block criada com sucesso";
		} else {
			$msg2 = "Erro ao criar a tabela block : ".mysql_error ();
		}
	}
/*
Crias todas as tabelas das salas de batepapo.
$nome nome da sala
$descr descrição da sla
*/
   function nova ($nome,$descr){
   	global $msg;
     $insere = "INSERT INTO salas (nome,descr) VALUES (\"$nome\",\"$descr\")";
     if (mysql_query($insere,$this->conexao)) {
        $msg = "Sala $nome criada com sucesso";
        $consulta = "SELECT * FROM salas ORDER BY codigo ASC";
        $resultado = mysql_query($consulta,$this->conexao);
        while ($linha = mysql_fetch_row($resultado)) {
          $prefix=$linha[0];
        }
        $cria1 = "CREATE TABLE msg_$prefix (codigo INT AUTO_INCREMENT PRIMARY KEY, time INT, remetente CHAR(20),destinatario CHAR(20),mensagem MEDIUMTEXT,status CHAR(3))";
        $cria2 = "CREATE TABLE users_$prefix (codigo INT AUTO_INCREMENT PRIMARY KEY, time INT,ip CHAR(20),nome CHAR(20),careta INT,cor CHAR(8),last INT)";
        $cria3 = "CREATE TABLE log_$prefix (codigo INT AUTO_INCREMENT PRIMARY KEY, time INT, remetente CHAR(20),destinatario CHAR(20),mensagem MEDIUMTEXT,status CHAR(3))";
        mysql_query($cria1,$this->conexao);
        mysql_query($cria2,$this->conexao);
        mysql_query($cria3,$this->conexao);
     } else {
        $msg = "Erro ao criar a sala $nome : ".mysql_error ();
     }
   }
/*
Construi todas tabelas(html) para entrado chat.
Essa função não deveria estar aqui ,mas caso precise de uma alteração é mais facil corigir aqui.
$apelido nick do usuario
$careta carinha a ser utilizada
$cor   cor do nick
*/
   function salas ($apelido,$careta,$cor){
      $consulta = "SELECT * FROM salas ORDER BY codigo ASC";
      $resultado = mysql_query($consulta,$this->conexao);
      while($linha = mysql_fetch_row($resultado)){
         $cont=0;
         $consulta2 = "SELECT Count(*) AS cont FROM users_$linha[0]";
         $resultado2 = mysql_query($consulta2,$this->conexao);
		 $cont = mysql_result($resultado2, 0, "cont");
         echo  "<table border=\"1\" width=\"100%\" bordercolor=\"#000000\">
                    <tr>
                    <form method=\"POST\" action=\"entra.php\">
                      <td width=\"100%\">Sala $linha[1]($cont)
                      <p>$linha[2]
                      <input border=\"0\" src=\"images/entrar.gif\" name=\"I1\"
                        align=\"right\" width=\"21\" height=\"21\" type=\"image\"></p>
                        <input type=\"hidden\" name=\"vsala\" value=\"$linha[0]\">
                        <input type=\"hidden\" name=\"cor\" value=\"$cor\">
                        <input type=\"hidden\" name=\"careta\" value=\"$careta\">
                        <input type=\"hidden\" name=\"apelido\" value=\"$apelido\">
                      </form>
                    </td>
                  </tr>
                </table>";
      }
   }

/*
Responsavel pela parte administrativa.
*/
   function comp(){
		require "./salas.php";
   }
/*
imprimi o log das mensagens da sala.
*/
   function imprimir($sala) {
     $consulta = "SELECT * FROM log_$sala ORDER BY codigo ASC";
     $resultado = mysql_query($consulta,$this->conexao);
     $msg="";
     while ($linha = mysql_fetch_row($resultado)){
        $pieces = explode("|",$linha[4]);
        $msg.="<p>$pieces[0]</p>";
     }
     return $msg;
   }

/*
Cria o menu suspenso para troca de salas
*/
   function troca ($sala) {
     echo "<option value=\"0\">Trocar de Sala</option>";
     $consulta = "SELECT * FROM salas ORDER BY codigo ASC";
     $resultado = mysql_query($consulta,$this->conexao);
     while ($linha = mysql_fetch_row($resultado)) {
       $cont=0;
       $consulta2 = "SELECT * FROM users_$linha[0] ORDER BY codigo ASC";
       $resultado2 = mysql_query($consulta2,$this->conexao);
       while($linha2 = mysql_fetch_row($resultado2)){
           $cont++;
       }
       if($linha[0] != $sala){
          echo "<option value=\"$linha[0]\">$linha[1]($cont)</option>";
       }
     }
   }
/*
Remove todas as tabelas de uma sala
*/
	function remove($num){
		global $msg;
		$excluir = "DELETE FROM salas WHERE codigo = '$num'";
		$atualiza = mysql_query($excluir, $this->conexao);
		$ret1 = "DROP TABLE msg_$num";
		$ret2 = "DROP TABLE users_$num";
		$ret3 = "DROP TABLE log_$num";
		mysql_query($ret1,$this->conexao);
		mysql_query($ret2,$this->conexao);
		mysql_query($ret3,$this->conexao);
		$msg = "Sala retirada com sucesso";
	}
}
?>