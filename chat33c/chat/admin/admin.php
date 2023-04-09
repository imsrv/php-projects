<?
session_start();

include ("../config.php");

$time = @time();
$timer= time();

if(($login==$id) and ($vsenha==$senha)){
	$cria= new tab;
	$cria->conect($host,$id,$senha,$db);
}

#criação das tabelas iniciais
if($val==1){
	$cria->ini();
	?>
	<script>
		alert("<? echo $msg ?> \n <? echo $msg2 ?>");
	</script>
	<?
}

#criação das salas
if($val==2){
	$cria->nova($vsala,$descr);
	?>
	<script>
		alert("<? echo $msg ?> \n <? echo $msg2 ?>");
	</script>
	<?
}

#remoção de salas
if($val==3){
  $cria->remove($excluir);
	?>
	<script>
		alert("<? echo $msg ?> \n <? echo $msg2 ?>");
	</script>
	<?
}

#remove usuário
if($val==4){
  $user= new perfil;
  $user2= new tab;

  $user->conect($host,$id,$senha,$db,$vsala);
  $user2->conect($host,$id,$senha,$db);

  $user->remove ("ip",$vip);

  $mcampo[0]="time";
  $mcampo[1]="ip";

  $mvalor[0]="$timer";
  $mvalor[1]="$vip";

  $user2->insere($mcampo,$mvalor,"block");
  $user2->atualiza("300","block");

  $user->close();
  $user2->close();
}

if ($block)
{
$conexao = mysql_connect($host,$id,$senha);
mysql_select_db($db,$conexao);

	$consulta = mysql_query("DELETE FROM block WHERE codigo = $codigo", $conexao);
	if($consulta)
	{
		?>
		<script>
			alert('Usuário liberado com sucesso');
			document.location.href = 'admin.php';
		</script>
		<?
	}
	else
	{
		?>
		<script>
			alert('Aconteceu um erro ao tentar liberar o usuário, tente novamente');
			document.location.href = 'admin.php';
		</script>
		<?
	}
}
?>
<html>
<head>
<title>Romano Chat</title>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<link href="../romano.css" rel="stylesheet" type="text/css">
</head>
<BODY bgColor=#ffffff leftMargin=0 topMargin=0 marginheight="0" marginwidth="0">
<?
#abre o log da sala
if($val==5){
?>
<script>window.open("../vazio.php?vsala=<?echo $vsala;?>&timer=<?echo $timer;?>","log","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,WIDTH=800,HEIGHT=540, top=0, left=0");</script>
<? } ?>
<table border="0" width="100%">
  <tr>
	<td align="center"><img border="0" src="../images/logo.jpg" width="300"
      height="83"></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr> 
<td width="100%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><? if(!$careta){ ?><table width="70%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
<tr><td><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
<tr> 
                	  <td height="20" class="titulo"><b>Instru&ccedil;&otilde;es Iniciais </b></td>
              </tr>
              <tr> 
                <td><ul>
						  <li>Por este Chat estar baseado em Banco de Dados, inicialmente 
							dever&atilde;o ser criadas as tabelas no BD para o 
							correto funcionamento do Chat.</li>
						  <li> Certifique-se de que exista uma base de dados pronta 
							no MySQL e que o nome dela esteja corretamente colocada 
							no arquivo &quot;config.php&quot;.</li>
						  <li> Ap&oacute;s essa verifica&ccedil;&atilde;o, clique 
							em Criar Tabelas Iniciais para que o sistema possa 
							fazer automaticamente a cria&ccedil;&atilde;o das 
							tabelas no banco de dados.</li>
						  <li> Em seguida, crie as salas que desejar colocando 
							o seu Nome e uma Descri&ccedil;&atilde;o para a mesma 
							no formul&aacute;rio logo abaixo.</li>
						  <li>Caso as tabelas iniciais j&aacute; existam no BD, 
							o bot&atilde;o Criar Tabelas Iniciais n&atilde;o mais 
							aparecer&aacute;.</li>
						  <li>Toda opera&ccedil;&atilde;o efetuada gera uma mensagem 
							que aparecer&aacute; em uma caixa de alerta do navegador.</li>
						  <li>H&aacute; a op&ccedil;&atilde;o de enviar careta, 
							por&eacute;m ela &eacute; individual, cada um s&oacute; 
							tem direito a uma careta, e essa careta fica registrada 
							pelo IP que a pessoa estiver usando.</li>
						  <li>J&aacute; existe uma op&ccedil;&atilde;o para bloquear 
							usu&aacute;rios baderneiros, selecionando o usu&aacute;rio 
							e clicando em &quot;Remover&quot;, na &quot;Gerencia 
							de Salas&quot;.</li>
						  <li>Assim como &eacute; poss&iacute;vel bloquear, tamb&eacute;m 
							&eacute; poss&iacute;vel desbloquear usu&aacute;rios, 
							selecionando-os na caixa &quot;Usu&aacute;rios Bloqueados&quot; 
							e clicando em &quot;Desbloquear&quot;</li>
						</ul></td>
              </tr>
              <tr> 
<?
#script para verificar se as tabelas salas e block já existem
#cria a conexão com o banco e seleciona-o
$conexao = mysql_connect($host,$id,$senha);
mysql_select_db($db,$conexao);
#realiza a consulta na primeira tabela
$consulta = mysql_query("SELECT * FROM salas", $conexao);
#realiza a consulta na segunda tabela
$consulta2 = mysql_query("SELECT * FROM block", $conexao);

#verifica se achou as tabelas
if (!$consulta && !$consulta2)
{
?>
                <td height="50" align="center">
<form method="POST" action="admin.php" name="frmTabelas">
<input type="hidden" name="val" value="1">
<table border="0" width="180" cellpadding="0" cellspacing="0" bgcolor="#000000" align="center">
<tr onMouseOver="this.bgColor='#666666'" onMouseOut="this.bgColor='#000000'" onClick="document.frmTabelas.submit();">
<td align="left" width="10"><img src="../images/dobra.gif"></td>
<td align="center" class="button"><b>Criar Tabelas Iniciais</b></td>
<td align="right" width="10"><img src="../images/dobra2.gif"></td>
</tr></table>
</form>

</td>
              </tr>
<?
}
?>
            </table>
			</td>
        </tr>
      </table><? } ?>
</td></tr></table>
</td></tr>
  <tr><td>&nbsp;</td></tr>
<tr>
    <td>
	<table width="80%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#000000">
<tr><td>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
	<? if (!$careta){ ?>
			  <tr> 
				<td height="20" colspan="3" class="titulo"><strong>Gerenciador 
				  de Salas</strong></td>
			  </tr>
			  <tr> 
				<td width="260">&nbsp;</td>
				<td width="10" rowspan="2">&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr> 
				<td width="260"> 
<table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
					<tr> 
					  <td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
						  <tr> 
							<td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
								<tr> 
								  <td> <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
									  <tr> 
										<td height="20" class="titulo"><strong>Cria&ccedil;&atilde;o</strong></td>
									  </tr>
									  <tr> 
										<td>&nbsp;</td>
									  </tr>
									  <tr> 
										<td> <form method="POST" action="admin.php?val=2" name="frmCriacao">
											<table width="100%" border="0" cellspacing="2" cellpadding="0">
											  <tr> 
												<td align="right">Nome da sala:&nbsp; 
												</td>
												<td><input type="text" name="vsala" size="20" class="text"></td>
											  </tr>
											  <tr> 
												<td align="right">Descrição:&nbsp; 
												</td>
												<td><input type="text" name="descr" size="20" class="text"></td>
											  </tr>
											  <tr align="center"> 
												<td height="30" colspan="2">
												<table border="0" width="100" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>" align="center">
													<tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="document.frmCriacao.submit();">
													<td width="10" align="left" class="button"><img src="../images/dobra.gif"></td>
													  <td align="center" class="button"><b>Criar Sala</b></td>
													<td width="10" align="right" class="button"><img src="../images/dobra2.gif"></td>
													</tr>
												  </table></td>
											  </tr>
											</table>
										  </form></td>
									  </tr>
									</table></td>
								</tr>
							  </table></td>
						  </tr>
						</table></td>
					</tr>
				  </table>
				</td>
				<td> 
				  <!-- Inicío do Gerenciador -->
				  <table width="90%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
					<tr> 
					  <td> <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
						  <tr> 
							<td> <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
								<tr> 
								  <td> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
									  <tr> 
										<td height="20" class="titulo"><strong>Ger&ecirc;ncia</strong></td>
									  </tr>
									  <tr> 
										<td> 
										  <?
$cria->comp();
$cria->close();
?>
										</td>
									  </tr>
									</table></td>
								</tr>
							  </table></td>
						  </tr>
						</table></td>
					</tr>
				  </table></td>
			  </tr>
			  <tr> 
				<td colspan="3">&nbsp;</td>
			  </tr><? } ?>
			  <tr> 
				<td height="20" colspan="3" class="titulo"><b>Gerenciador do Chat</b></td>
			  </tr>
			  <tr>
				<td colspan="3"><table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr> 
					  <td width="50%">&nbsp;</td>
					  <td width="50%">&nbsp;</td>
					</tr>
					<tr> 
					  <td width="50%" valign="top"> 
<form action="upload.php" method="post" enctype="multipart/form-data" name="frmAdicionar" id="frmAdicionar">
						  <table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
							<tr> 
							  <td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
								  <tr> 
									<td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
										<tr> 
										  <td> <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
											  <tr> 
												<td height="20" class="titulo"><strong>Inserir 
												  Careta personalizada</strong></td>
											  </tr>
											  <tr> 
												<td>&nbsp;</td>
											  </tr>
											  <tr> 
												<td> <table width="100%" border="0" cellspacing="2" cellpadding="0">
													<tr> 
													  <td align="right">Arquivo 
													  </td>
													  <td align="center">
														<input name="arquivo" type="file" size="15">
													  </td>
													</tr>
													<tr> 
													  <td height="30" colspan="2" align="center"><table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
														  <tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="document.frmAdicionar.submit();"> 
														  	<td align="left" width="10" class="button"><img src="../images/dobra.gif"></td>
															<td align="center" class="button"><b>Enviar</b></td>
															<td align="right" width="10" class="button"><img src="../images/dobra2.gif"></td>
														  </tr>
														</table></td>
													</tr>
												  </table></td>
											  </tr>
											</table></td>
										</tr>
									  </table></td>
								  </tr>
								</table></td>
							</tr>
						  </table>
						</form></td>
					  <td width="50%" align="center">
					  <? if(!$careta) { ?>
					  <table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
						  <tr> 
							<td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF">
								<tr> 
								  <td> <table width="250" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
									  <tr> 
										<td> <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
											<tr> 
											  <td height="20" class="titulo"><strong>Usu&aacute;rios 
												Bloqueados </strong></td>
											</tr>
											<tr> 
											  <td>&nbsp;</td>
											</tr>
											<tr> 
											  <td> <form method="POST" action="admin.php?block=1" name="frmBlock">
												  <table width="100%" border="0" cellspacing="2" cellpadding="0">
													<tr> 
													  <td>&nbsp; Esses s&atilde;o 
														os usu&aacute;rios bloqueados 
														ou expulsos de sala, voc&ecirc; 
														pode deixar bloqueado 
														ou liber&aacute;-lo.</td>
													</tr>
													<tr> 
													  <td align="center">
<select name="codigo" size="5">
<?
while ($campos = mysql_fetch_array($consulta2))
{
?>
<option value="<? echo $campos["codigo"] ?>"><? echo $campos["ip"] ?></option>
<?
}
?>
</select>
													  </td>
													</tr>
													<tr> 
													  <td height="30" align="center"> 
														<table border="0" width="90" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
															<tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="document.frmBlock.submit();"> 
															<td width="10" align="left" class="button"><img src="../images/dobra.gif"></td>
															<td align="center" class="button"><b>Desbloquear</b></td>
															<td width="10" align="right" class="button"><img src="../images/dobra2.gif"></td>
														  </tr>
														</table></td>
													</tr>
												  </table>
												</form></td>
											</tr>
										  </table></td>
									  </tr>
									</table></td>
								</tr>
							  </table></td>
						  </tr>
						</table><? } ?></td>
					</tr>
					<tr> 
					  <td width="50%">&nbsp;</td>
					  <td width="50%">&nbsp;</td>
					</tr>
				  </table></td>
			  </tr>
			  <tr> 
				<td colspan="3">&nbsp;</td>
			  </tr>
			</table> 
</td></tr></table>
    </td>
  </tr>
  <tr>
        <td width="100%"> </td>
  </tr>
</table>
<p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"
size="2">Copyleft <a href="mailto:romano@dcc.ufmg.br">Rodrigo Romano</a> - 2002.</font>&nbsp;</p>
<p align="center">
<table border="0" width="190" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>" align="center">
<tr onMouseOver="this.bgColor='<? echo botao_over ?>'" onMouseOut="this.bgColor='<? echo botao_up ?>'" onClick="document.location.href='../index.php'">
	<td width="10" align="left" class="button"><img src="../images/dobra.gif"></td>
	<td align="center" class="button"><b>Ir para a p&aacute;gina inicial</b></td>
	<td width="10" align="right" class="button"><img src="../images/dobra2.gif"></td>
</tr></table>
</html>