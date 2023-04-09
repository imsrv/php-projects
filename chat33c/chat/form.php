<?
session_start();
include ("./config.php");
?>
<HTML>
<HEAD>
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<script language="javascript">
<!--
function abre(theURL,winName,features) {
	window.open(theURL,winName,features);
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<? $cont++;?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="romano.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('images/informacoes_f2.gif','images/troca_f2.gif','images/arquivo02.gif'); document.Mensagens.e.focus();">
<form name="Mensagens" action="trata.php?cont=<? echo "$cont"; ?>" method="post">
<table width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr bgcolor="#FFFFFF">
  	  <td width="80" rowspan="3" align="center" class="campos">
		<?
	$user= new perfil;

	$user->conect($host,$id,$senha,$db,$sala);

	$linha=$user->select("ip",$ip);

	$perfila=$user->nick($linha[3]);  //Imprime perfil

	echo $perfila;

?>
	  </td>
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td colspan="4" valign="top" class="campos">
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#000000">
		  <tr>
			<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
				<tr align="center">
				  <td width="150" bgcolor="#FFFFFF" class="campos">
<select size=1 name=a>
					  <option value="fala para" selected>fala para</option>
					  <option value="pergunta para">pergunta para</option>
					  <option value="responde para">responde para</option>
					  <option value="concorda com">concorda com</option>
					  <option value="discorda de">discorda de</option>
					  <option value="desculpa-se com">desculpa-se com</option>
					  <option value="surpreende-se com">surpreende-se com</option>
					  <option value="murmura para">murmura para</option>
					  <option value="sorri para">sorri para</option>
					  <option value="suspira por">suspira por</option>
					  <option value="flerta com">flerta com</option>
					  <option value="entusiasma-se com">entusiasma-se com</option>
					  <option value="ri de">ri de</option>
					  <option value="dá um fora em">dá um fora em</option>
					  <option value="briga com">briga com</option>
					  <option value="grita com">grita com</option>
					  <option value=xinga>xinga</option>
					</select>
				  </td>
				  <td bgcolor="#FFFFFF" class="campos">
					<select size=1 name=b title="Menu das pessoas">
					  <?
$user->imprimir($sel); //Imprime o menu susoenso com nomes dos usuarioa

$user->close();

unset($user);//Destroi a variavel $user.
?>
					</select></td>
				  <td bgcolor="#FFFFFF" class="campos">&nbsp;&nbsp;<b><i><select size="1" name="f">
  <option selected value="nada">enviar som</option>
  <option value="beijo">beijo</option>
  <option value="pigarro">pigarro</option>
  <option value="beep">beep</option>
  <option value="cuco">cuco</option>
  <option value="explode">explosão</option>
  <option value="gargalhada">gargalhada</option>
  <option value="grito">grito</option>
  <option value="hello">hello</option>
  <option value="uivo">uivo</option>
  <option value="telefone">telefone</option>
  <option value="foto">foto</option>
  <option value="aplauso">aplauso</option>
  <option value="arroto">arroto</option>
  <option value="vaia">vaia</option>
  <option value="ronco">ronco</option>
  &nbsp;
  </select></i></b>&nbsp;&nbsp;
					<select size="1" name="c">
					  <option value="0" selected>enviar emoticons</option>
					  <option value="1">Alien</option>
					  <option value="2">Endiabrado</option>
					  <option value="3">Grito</option>
					  <option value="4">Envergonhado</option>
					  <option value="5">Pensativo</option>
					  <option value="6">Triste</option>
					  <option value="7">&Oacute;culos Escuros</option>
					  <option value="8">Sorriso Largo</option>
					  <option value="9">Feliz</option>
					  <option value="10">Frio</option>
					  <option value="11">Gargalhada</option>
					  <option value="12">Zangado</option>
					  <option value="13">Nerd</option>
					  <option value="14">Sem gra&ccedil;a</option>
					  <option value="15">Cafet&atilde;o</option>
					  <option value="16">Rolando de rir</option>
					  <option value="17">Enjoado</option>
					  <option value="18">Sorriso</option>
					  <option value="19">Fumando</option>
					  <option value="20">Dormindo</option>
					  <option value="21">Mostrando a l&iacute;ngua</option>
					  <option value="22">Piscando a olho</option>
					</select></td>
				  <td width="105" bgcolor="#FFFFFF" class="campos"> <a href="javascript:abre('envia_imagem.php?sala=<?echo $sala;?>','Imagem','width=550 , height=120, top=0, left=0')"><img src="images/arquivo.gif" name="arquivo" width="24" height="24" border=0 id="arquivo" onMouseOver="MM_swapImage('arquivo','','images/arquivo02.gif',1)" onMouseOut="MM_swapImgRestore()"></a>&nbsp;&nbsp;
					<a href="javascript:abre('novo.php?sala=<?echo $sala;?>','Imagem','width=600 , height=300, top=0, left=0, resizable=yes')" title="Trocar Personagem/Apelido"><img src="images/troca.gif" name="troca" width="25" height="25" border=0 id="troca" onMouseOver="MM_swapImage('troca','','images/troca_f2.gif',1)" onMouseOut="MM_swapImgRestore()"></a>&nbsp;&nbsp;
					<a href="#" onClick="abre('info.php', 'Informações', 'scrollbars=yes, resizable=yes, width=450, height=500, top=0, left=0');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('info','','images/informacoes_f2.gif',1)" title="Informações"><img src="images/informacoes.gif" alt="Informações" name="info" width="24" height="24" border="0"></a>
				  </td>
				</tr>
		</table>
		</td>
		  </tr>
	</table>
  </td>
</tr>
<tr bgcolor="#FFFFFF">
  <td colspan="4" valign="top">
	<table width="100%" border="0" cellpadding="1" cellspacing="0" bgcolor="#000000">
		  <tr>
			<td>
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
			<tr>
				  <td width="150" align="center" bgcolor="#FFFFFF" class="campos">
<input type=checkbox value=ON name=d <? echo "$chec";?>>
					<font face="Arial" color="#000000" size="1">Reservadamente</font></td>
				  <td align="center" bgcolor="#FFFFFF" class="campos">
					<input size=50 name="e">
				  </td>
				  <td width="81" align="center" bgcolor="#FFFFFF" class="campos"><table width="80" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
<tr onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'" onClick="document.Mensagens.submit();">
						<td width="10" align="left" class="button"><img src="images/dobra.gif"></td>
						<td class="button"><b>Enviar</b></td>
						<td width="10" class="button"><img src="images/dobra2.gif"></td>
					  </tr>
					</table> </td>
				  <td align="right" bgcolor="#FFFFFF" class="campos">
<table width="80" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>">
<tr onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'" onClick="window.top.location='sair.php?vsala=<?echo $sala;?>'">
<td width="10" class="button" align="left"><img src="images/dobra.gif"></td>
<td class="button"><b>Sair</b></td>
<td width="10" class="button"><img src="images/dobra2.gif"></td></tr>
</table>
				  </td>
				</tr>
		</table>
		</td>
		  </tr>
	</table>
  </td>
</tr>
</table>
</form>
</BODY>
</HTML>