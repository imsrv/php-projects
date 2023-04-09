<?
// Incuindo o arquivos de configurações
include("../config.php");
include "../stl.php";
?>
<html>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">
  
<?
//Se o campo da senha do banco de dados ficar em branco ele emite um aviso.
if (empty($dbpassi)){
echo "<b>Você deixou o seu banco de dados sem senha isso é inseguro,
pois qualquer pessoa pode alterar dados cadastrados no mesmo!</b>";
	} 
?>

<?php
if($next) {
   switch($next) {
    case 'database':
      if(!$done) {
	 echo "Testando conexão...<br>";
	 flush();
	 if(!$db = mysql_connect("$dbserveri", "$dbuseri", "$dbpassi"))
	   die("<font color=\"#FF0000\">Erro, falha ao conectar no MySQL $dbserveri. Usando o nome $dbuseri e a senha $dbpassi.<BR>Volte por favor e confira os dados.");
	 echo "<font color=\"#000000\">DB Conexão Boa!</FONT><BR>";
	 flush();
	 echo "Selecionar DB $dbnamei...";
	 flush();
	 if(!@mysql_select_db("$dbnamei", $db)) {
	    echo "<font color=\"#FF0000\">Base de dados não existente!</font><BR>";
	    flush();
	    echo "Criando base de dados $dbnamei...";
	    flush();
	    if(!$r = mysql_query("CREATE DATABASE $dbnamei", $db))
	      die("<font color=\"#FF0000\">Error, count not select or create database $dbnamei, please create it manually or have your system administrator do it for you and try again.");
	    mysql_select_db("$dbnamei", $db);
	    echo "<font color=\"#000000\">Database Criada!</font><BR>";
	    flush();
	 }
	 else
	   echo "<font color=\"#000000\">Banco de Dados selecionado!</font><BR>";
	 flush();
	 echo "Criar tabelas e inserindo dados padrões...<BR>";
	 flush();
	 $tables = array ("Notícias" => "CREATE TABLE noticias (
							id int(5) NOT NULL auto_increment,
							fonte char(30) NOT NULL ,
							endfonte char(30) NOT NULL ,
							email char(80) ,
							data date NOT NULL,
							hora time NOT NULL ,
							titulo char(100) NOT NULL ,
							subtitulo text NOT NULL ,
							texto text NOT NULL ,
							atualiza text NOT NULL ,
							ver char(3) DEFAULT 'on' ,
							PRIMARY KEY (id),
							UNIQUE id (id)
							     )",
"Usuário" => "CREATE TABLE usuario (
							id int(5) NOT NULL auto_increment,
							nome char(80) ,
							email char(80) ,
							senha char(80) ,
							data date NOT NULL,
							hora time NOT NULL ,
							noticia char(70) NOT NULL ,
							nivel char(3) NOT NULL ,
							PRIMARY KEY (id),
							UNIQUE id (id)
							     )",


);
			 
	 echo "<TABLE BORDER=\"0\">\n";
	 while(list($name, $table) = each($tables)) {
	    echo "<TR><TD>Criando tabela $name</TD> ";
	    if(!$r = mysql_query($table, $db))
	      die("<TD><font color=\"#FF0000\">ERRO! a tabela não foi criada. Por que: <b>". mysql_error()."</b></TD></TR></TABLE>");
	    echo "<TD><font color=\"#000000\">[OK]</FONT></TD></TR>";
	    flush();
	 }

	 echo "</TABLE>";


	 echo "<font color=\"#000000\">Banco de Dados criado com Sucesso!<br>
<br>
A base de dados foi criada com sucesso!!<br>
Edite o arquivo <font size=4>config.php</font> e coloque os dados corretos, caso já tenha editado basta entrar em
admin.php para cadastrar, alterar, excluir e ver as notícias já cadastradas!
</FONT><BR>";
?>

<?php	   
	 
      }
      break;
    case 'user':
      if(!$db = mysql_connect("$dbserveri", "$dbuseri", "$dbpassi"))
	die("<font color=\"#FF0000\">Erro, Não consegui conectar a base de dados ao servidor $dbserveri. Usando ousuario $dbuseri e a senha $dbpassi.<BR>Volte e tente novamente.");
      mysql_select_db("$dbnamei", $db);
	 

      
}

      }
?>

	

</BODY>
</HTML>
