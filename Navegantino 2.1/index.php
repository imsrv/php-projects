<?	if(!IsSet($_GET['dir'])){$dir="";}else{$dir=$_GET['dir'];}
	if(!IsSet($_GET['order'])){$order="nc";}else{$order=$_GET['order'];}
	$letra = $_GET['letra'];
	$busca=$_GET['busca'];
	
	$handle=opendir($dir); 
	while ($arquivo = readdir($handle)) { 
		if ($arquivo == '.' OR $arquivo == '..'){echo"";}else { 
			if(($busca=='' AND $letra=='') OR ($busca<>'' AND eregi($busca,$arquivo,$er))  OR ($letra<>'' AND (substr($arquivo,0,1)==$letra OR substr($arquivo,0,1)==strtolower($letra))))
			{
				$s				= $s+1; //Valor Sequencial adicionado a cada Loop do Array
				$nome[$s]		= ucfirst("$arquivo");
				//////////////// DEFININDO O TAMANHO DO ARQUIVO
				$tamanho[$s]	= @filesize($dir.$arquivo);
				
				//////////////// DEFININDO A DATA DA CRIACAO DO ARQUIVO
				$data[$s]		= @filemtime($dir.$arquivo);

				//////////////// DEFININCO O TIPO DE ARQUIVO
				if(@filetype($dir.$arquivo)=='dir'){$tipo[$s]="PASTA";}
				else{$exp=array_reverse(explode(".",$arquivo));
					$tipo[$s]=strtoupper($exp[0]);}
			}
			else
			{
				echo"";
			}	
		}//fecha if que vê se é "." ou ".."
	}//fecha while
	closedir($handle); 

?>
<style>
body{font-family: Verdana;font-size: 10px;color: #000066;text-decoration: none;}
td{font-family: Verdana;font-size: 10px;color: #000066;text-decoration: none;}
a{font-family: Verdana;font-size: 10px;font-weight: bold;color: #0000FF;text-decoration: underline;}
a:hover{font-family: Verdana;font-size: 10px;font-weight: bold;color: #FF0000;text-decoration: underline;}
</style><title>Navegando por Localhost/<?echo$dir?></title>
<body link="#0000FF">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="5">Foram encontrados <b><? echo count($nome);?> arquivos </b>nesse 
      diretório 
      <? if($busca<>''){echo "<br>Você está pesquisando por <b>$busca</b>";} ?>
      <? if($letra<>''){echo "<br>Você está exibindo somente arquivos começados com <b>$letra</b>";} ?>
    </td>
    <td colspan="5" align="right"><form name="buscar" method="post" action="?<? echo"letra=$letra&busca=$busca&dir=$dir";?>">
        <input name="busca" type="text" size="20" onFocus="if(this.value=='Digite aqui a Palavra')this.value='';" onBlur="if(this.value=='')this.value='Digite aqui a Palavra';" value="Digite aqui a Palavra">
        <input name="botao" type="image" value="Pesquisar" src="navegantino/buscar.gif" align="top" >
      </form></td>
  </tr>
  <tr> 
    <td colspan="10">Filtrar pela Primeira Letra: 
      <?
	for($u=65;$u<=90;$u++){$letra = chr($u);echo "<a href='?busca=$busca&letra=$letra&order=$order&dir=$dir' style='text-decoration:none'>&nbsp;&nbsp;$letra&nbsp;&nbsp;</a>";}
	?>
    </td>
  </tr>
  <tr> 
    <td colspan="10">Você está em <a href="?dir=">Localhost</a> 
      <?
	$quebradir=@explode("/",$dir);
	foreach($quebradir as $chave=> $diretorios)
	{
		$diratual.=$diretorios."/";
			echo"/<a href=?dir=$diratual>$diretorios</a>";
	}
	?>
    </td>
  </tr>
  <tr> 
    <td colspan="10">&nbsp; </td>
  </tr>
  <tr bgcolor="#3366cc"> 
    <td width="3" align=right bgcolor="3366cc"> </td>
    <td style="color:white" width="40"><b></b></td>
    <td width="334" style="color:white"><b><font size="2"><a href="?<?echo"dir=$dir&busca=$busca"?>&order=nd"><img src=navegantino/d.gif border="0" align="absmiddle"></a><a href="?<?echo"dir=$dir&busca=$busca"?>&order=nc"><img src=navegantino/c.gif border="0" align="absmiddle"></a> 
      Nome</font></b></td>
    <td width="3" align=right bgcolor="white"> </td>
    <td width="115" align="left" style="color:white"><b><font size="2"><a href="?<?echo"dir=$dir&busca=$busca"?>&order=tipod"> 
      <img src=navegantino/d.gif border="0" align="absmiddle"></a><a href="?<?echo"dir=$dir&busca=$busca"?>&order=tipoc"><img src=navegantino/c.gif border="0" align="absmiddle"></a> 
      Tipo</font></b></td>
    <td width="3" align=right bgcolor="white"> </td>
    <td width="141" align="left" style="color:white"><b><font size="2"><a href="?<?echo"dir=$dir&busca=$busca"?>&order=td"> 
      <img src=navegantino/d.gif border="0" align="absmiddle"></a><a href="?<?echo"dir=$dir&busca=$busca"?>&order=tc"><img src=navegantino/c.gif border="0" align="absmiddle"></a> 
      Tamanho</font></b></td>
    <td width="3" align=right bgcolor="white"> </td>
    <td width="130" align="left" style="color:white"><b><font size="2"><a href="?<?echo"dir=$dir&busca=$busca"?>&order=dd"><img src=navegantino/d.gif border="0" align="absmiddle"></a><a href="?<?echo"dir=$dir&busca=$busca"?>&order=dc"><img src=navegantino/c.gif border="0" align="absmiddle"></a>Data 
      </font></b></td>
    <td width="3" align=right bgcolor="3366cc"> </td>
  </tr>
  <?
	
	switch($order)
	{
		case 'tc':		@asort($tamanho);	$variavel=$tamanho;	break;
		case 'td':		@arsort($tamanho);	$variavel=$tamanho;	break;
		case 'dc':		@asort($data);		$variavel=$data;	break;
		case 'dd':		@arsort($data);		$variavel=$data;	break;
		case 'nc':		@asort($nome);		$variavel=$nome;	break;
		case 'nd':		@arsort($nome);		$variavel=$nome;	break;
		case 'tipoc':	@asort($tipo);		$variavel=$tipo;	break;
		case 'tipod':	@arsort($tipo);		$variavel=$tipo;	break;
	}
	
	if(count($variavel)<>0)
	{
		foreach($variavel as $chave => $arquivo)
		{
			$contador=$contador+1;
			if(is_integer($contador/2)==1){$bg_color="";}else{$bg_color="ffffdd";}
			if(file_exists("navegantino/$tipo[$chave].gif")==0){}
			echo "<tr bgcolor=$bg_color>
			<td width=3 align=right bgcolor=3366cc> </td>
			<td align=center>";if(file_exists("navegantino/$tipo[$chave].gif")==1){echo"<img align=middle src=navegantino/$tipo[$chave].gif>";}else{echo"<img align=middle src=navegantino/default.gif>";}
			echo"</td><td>";
			if($tipo[$chave]=='PASTA'){echo"<a href='?dir=$dir$nome[$chave]/'>";
			}else{echo"<a href='$dir$nome[$chave]'>";}
			echo"$nome[$chave]</a></td>
			<td align=center bgcolor=EDC629> </td>
			<td align=center>$tipo[$chave]</td>
			<td align=right bgcolor=EDC629> </td>
			<td align=center>";
			if($tamanho[$chave]==0){echo"-";}
			elseif(($tamanho[$chave]/1024)>1){echo number_format(($tamanho[$chave]/1024),2,",",".")." kB";}
			else{echo $tamanho[$chave]." bytes";}
	
			echo"<td align=right bgcolor=EDC629> </td>
			<td align=center>".date("d/m/Y H:i:s",$data[$chave])."</td>
			<td width=3 align=right bgcolor=3366cc> </td>
			</tr>
			<tr height=1 bgcolor=EDC629><td bgcolor=3366cc></td><td colspan=8></td><td bgcolor=3366cc></td></tr>";
		}
	}////////fecha if que verifica se existe algum elemento no array
	else
	{
		echo "<tr><td height=25 colspan=1 bgcolor=3366cc></td><td colspan=8 align=center><h4>Não foi encontrado nenhum arquivo nesse diretório</td><td bgcolor=3366cc></td></tr>";
	}
?>
  <tr> 
    <td bgcolor="3366cc"></td>
    <td colspan="8" height="20"> <b><? echo $_SERVER['SERVER_SOFTWARE']?></b> 
      IP: <b> 
      <?  echo $_SERVER['REMOTE_ADDR']?>
      </b></td>
    <td bgcolor="3366cc"></td>
  </tr>
  <tr> 
    <td bgcolor="3366cc"  height="3" colspan="10"></td>
  </tr>
</table>
</body>