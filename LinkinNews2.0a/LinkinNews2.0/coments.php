<?
###########################################
#       Sistema Criado e Desenvolvido     #
#          Igor Carvalho de Escobar       #
#                LK Design©               #
#  http://igorescobar.webtutoriais.com.br #
#      Suporte em:                        #
#      http://forum.webtutoriais.com.br   #
#      Por favor, Mantenham os Créditos   #
###########################################
?>
<html>
<head>
<title>LinkinNews 2.0 [ Comentarios] </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/css.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="images/top_logo.gif" width="200" height="50"></td>
  </tr>
  <tr>
    <td height="10%" bgcolor="#D64B10"></td>
  </tr>
</table>
<br>
<?
        include "includes/config.php";
        include "LKn_funcs.php";
        $file = "ips.txt";
        $ips = file($file);
        $your_ip = getenv("REMOTE_ADDR");
        for($i=0;$i<=count($ips);$i++)
        {
              $ips[$i] = preg_replace("(\n|\r)","", $ips[$i]);
              if($ips[$i]=="$your_ip")
              {
                  echo "<font face=verdana size=2 color=red>Por fins internos, o administrador preferiu que você não visualiza-se esta pagina.</font><BR><BR><BR><BR><center><a href=\"javascript:window.close();\"><img src=\"images/bt_close_window.gif\" width=\"100\" height=\"15\" border=\"0\"></a></center>";
                  $i= count($ips);
                  exit;
              }
        }
		conexao($host_db,$usuario_db,$senha_db,$BancoDeDados); 
		$id = $_GET['n_id'];
		$acao = $_GET['AcTion'];
		if($acao==4517)
		{
			$nome = $_POST['nome'];
			$comentario = $_POST['comentario'];
			$data = date ("d/m/Y",time());
			$hora = strftime("%H:%M:%S");
			if (empty($nome) || empty($comentario))
			{
				echo "<script>window.alert(\"Todos os campos são obrigatórios\");</script>";
				echo "<meta http-equiv='refresh' content='0;URL=$PHP_SELF?n_id=$id'>";
             exit;
			} 
			else 
			{    
			    $id = $_POST['n_id'];
			    $ip = getenv("REMOTE_ADDR");
				$sql = mysql_query("INSERT INTO lkn_coments (nome, comentario, data,hora, noticia_id,ip) VALUES ('$nome','$comentario','$data','$hora','$id','$ip')");
				if($sql)
				{
                    $palavrao = $_GET['u'];
					echo "<script>window.alert(\"Seu comentário foi computado com sucesso.\");</script>";
					echo "<meta http-equiv='refresh' content='0;URL=$PHP_SELF?n_id=$id'&u=$palavrao>";
		   	    }
		    }
		}
		$id = $_GET['n_id'];
        $u = $_GET['u'];
		$sql = mysql_query("SELECT * FROM lkn_coments WHERE noticia_id='$id' order by id desc");
		$n = @mysql_num_rows($sql);
		if($n=="0")
		{
			echo "<font face=verdana size=2>Não há comentários para está noticia</a>";
		} else {
		while ($dados = mysql_fetch_array($sql))
		{
			$nome = $dados['nome'];
			$comentario = $dados['comentario'];
			$data = $dados['data'];
			$hora = $dados['hora'];
            $comentario = nl2br($comentario);
			if($u==1){

            $comentario = filtro($comentario);
            }


         ?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Nome:</strong> 
      <? echo "$nome"; ?> </font></td>
  </tr>
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo "$comentario"; ?></font></td>
  </tr>
  <tr> 
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Data:</strong> 
      <? echo "$data"; ?> <strong> Hora: </strong> <? echo "$hora"; ?></font></td>
  </tr>
</table>
<? } } 
close_con();
?>
<br>
<form name="form1" method="post" action="<? echo "$PHP_SELF"; ?>?AcTion=4517&n_id=<? echo $id; ?>&u=<? echo $palavrao; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Quero 
        Comentar</strong></font></td>
    </tr>
    <tr> 
      <td width="7%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Nome:</font></td>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <input name="nome" type="text" class="botoes" id="nome" size="43">
        </font></td>
    </tr>
    <tr> 
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Comentario:</font></td>
      <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="comentario" cols="41" rows="4" class="botoes" id="comentario"></textarea>
        <input name="n_id" type="hidden" id="n_id" value="<? echo $_GET['n_id']; ?>">
        </font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" class="botoes" value="Quero enviar meu comentario!"></td>
    </tr>
  </table><br>
  <center>
    <a href="javascript:window.close();"><img src="images/bt_close_window.gif" width="100" height="15" border="0"></a>
  </center> 
</form>
</body>
</html>
