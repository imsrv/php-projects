<?
session_start();
include ("./config.php");

$user=new perfil;
$user->conect($host,$id,$senha,$db,$sala);
$nome=$user->select("ip",$ip);
$user->close();
unset($user); //Destroi a variavel $user
$careta=$nome[4];

$ip     = getenv ("REMOTE_ADDR");//IP do usuario
$ip = str_replace(".", "", $ip);
?>
<html>
<head>
<title>Mudar Perfil</title>
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<script src="borderize.js"></script>
<link href="romano.css" rel="stylesheet" type="text/css">
</head>
<BODY leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="muda.php?sala" name="frmDados">
  <table width="100%" border="0" cellpadding="2" cellspacing="0">
	<tr>
	  <td width="15">&nbsp; </td>
	  <td><table width="200" border="0" cellspacing="0" cellpadding="1" bgcolor="#000000">
		  <tr>
			<td colspan="3" align="center" class="titulo"><b>Troca de Perfil</b></td>
		  </tr>
		  <tr>
			<td> <table width="100%" border="0" cellpadding="2" cellspacing="0">
				<tr bgcolor="#FFFFFF">
				  <td align="right" class="campos"><font size="2"><b> Nome:&nbsp; </b></font></td>
				  <td class="campos"> <input name="apelido" size="15" value="<? echo $nome[3];?>">
				  </td>
				</tr>
				<tr bgcolor="#FFFFFF">
				  <td align="right" class="campos"><font size="2"><b> Cor do nick:&nbsp; </b></font></td>
				  <td class="campos"> <select name="cor" size="1">
					  <option value="Preto" <? if($nome[5]=="Preto"){echo "selected";}?>>Preto</option>
					  <option value="Laranja" <? if($nome[5]=="Laranja"){echo "selected";}?>>Laranja</option>
					  <option value="Azul" <? if($nome[5]=="Azul"){echo "selected";}?>>Azul</option>
					  <option value="Roxo" <? if($nome[5]=="Roxo"){echo "selected";}?>>Roxo</option>
					  <option value="Verde" <? if($nome[5]=="Verde"){echo "selected";}?>>Verde</option>
					  <option value="Vermelho" <? if($nome[5]=="Vermelho"){echo "selected";}?>>Vermelho</option>
					</select> </td>
				</tr>
				<tr bgcolor="#FFFFFF">
				  <td align="right" class="campos"><font size="2"><b> Careta:&nbsp; </b></font></td>
				  <td class="campos"><a href="caretas.php?dest=novo&sala=<? echo $sala;?>">
					<? if($careta == ""){
                     $careta=69;
                }
                ?>
					<img src="caretas/<? echo $careta ?>.gif" name="imgcareta" width="30" height="30" border="1" id="careta"></a>
					<input type="hidden" name="careta" value="<? echo "$careta";?>"></td>
				</tr>
				<tr bgcolor="#FFFFFF">
				  <td height="30" colspan="3" align="center"> <table border="0" width="80" cellpadding="0" cellspacing="0" bgcolor="<? echo botao_up ?>" align="center">
                      <tr onClick="document.frmDados.submit();" onMouseOver="this.style.backgroundColor='<? echo botao_over ?>'" onMouseOut="this.style.backgroundColor='<? echo botao_up ?>'">
                        <td width="10" align="left" class="button"><img src="images/dobra.gif" width="10" height="20"></td>
                        <td class="button"><b>Entrar</b></td>
                        <td width="10" class="button"><img src="images/dobra2.gif" width="10" height="20"></td>
                      </tr>
                    </table></td>
				</tr>
			  </table></td>
		  </tr>
		</table></td>
	</tr>
  </table>
</form>
<div id="caretas" style="position:absolute; left:220; top:0; width:360; height:220; z-index:1; border: 1px none #000000;">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
		<td width="10" class="titulo"><img src="images/dobra.gif"></td>
		<td class="titulo" align="center" width="330"><b>Caretas</b></td>
		<td align="right" class="titulo" width="10"><img src="images/dobra2.gif"></td>
	</tr>
	<tr>
	  <td colspan="3" align="center">
<table width="95%" bgcolor="#000000" cellpadding="1" cellspacing="0"><tr><td>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" onMouseover="borderize_on(event)" onMouseout="borderize_off(event)">
<tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/1.gif',1); document.frmDados.careta.value = 1"><img src="caretas/1.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/2.gif',1); document.frmDados.careta.value = 2"><img src="caretas/2.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/3.gif',1); document.frmDados.careta.value = 3"><img src="caretas/3.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/4.gif',1); document.frmDados.careta.value = 4"><img src="caretas/4.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/5.gif',1); document.frmDados.careta.value = 5"><img src="caretas/5.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/6.gif',1); document.frmDados.careta.value = 6"><img src="caretas/6.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/7.gif',1); document.frmDados.careta.value = 7"><img src="caretas/7.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/8.gif',1); document.frmDados.careta.value = 8"><img src="caretas/8.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/9.gif',1); document.frmDados.careta.value = 9"><img src="caretas/9.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/10.gif',1); document.frmDados.careta.value = 10"><img src="caretas/10.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/11.gif',1); document.frmDados.careta.value = 11"><img src="caretas/11.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/12.gif',1); document.frmDados.careta.value = 12"><img src="caretas/12.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/13.gif',1); document.frmDados.careta.value = 13"><img src="caretas/13.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/14.gif',1); document.frmDados.careta.value = 14"><img src="caretas/14.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/15.gif',1); document.frmDados.careta.value = 15"><img src="caretas/15.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/16.gif',1); document.frmDados.careta.value = 16"><img src="caretas/16.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/17.gif',1); document.frmDados.careta.value = 17"><img src="caretas/17.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/18.gif',1); document.frmDados.careta.value = 18"><img src="caretas/18.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/19.gif',1); document.frmDados.careta.value = 19"><img src="caretas/19.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/20.gif',1); document.frmDados.careta.value = 20"><img src="caretas/20.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/21.gif',1); document.frmDados.careta.value = 21"><img src="caretas/21.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/22.gif',1); document.frmDados.careta.value = 22"><img src="caretas/22.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/22.gif',1); document.frmDados.careta.value = 22"><img src="caretas/23.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/24.gif',1); document.frmDados.careta.value = 24"><img src="caretas/24.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/25.gif',1); document.frmDados.careta.value = 25"><img src="caretas/25.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/26.gif',1); document.frmDados.careta.value = 26"><img src="caretas/26.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/27.gif',1); document.frmDados.careta.value = 27"><img src="caretas/27.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/28.gif',1); document.frmDados.careta.value = 28"><img src="caretas/28.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/29.gif',1); document.frmDados.careta.value = 29"><img src="caretas/29.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/30.gif',1); document.frmDados.careta.value = 30"><img src="caretas/30.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/31.gif',1); document.frmDados.careta.value = 31"><img src="caretas/31.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/32.gif',1); document.frmDados.careta.value = 32"><img src="caretas/32.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/33.gif',1); document.frmDados.careta.value = 33"><img src="caretas/33.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/34.gif',1); document.frmDados.careta.value = 34"><img src="caretas/34.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/35.gif',1); document.frmDados.careta.value = 35"><img src="caretas/35.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/36.gif',1); document.frmDados.careta.value = 36"><img src="caretas/36.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/37.gif',1); document.frmDados.careta.value = 37"><img src="caretas/37.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/38.gif',1); document.frmDados.careta.value = 38"><img src="caretas/38.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/39.gif',1); document.frmDados.careta.value = 39"><img src="caretas/39.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/40.gif',1); document.frmDados.careta.value = 40"><img src="caretas/40.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/41.gif',1); document.frmDados.careta.value = 41"><img src="caretas/41.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/42.gif',1); document.frmDados.careta.value = 42"><img src="caretas/42.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/43.gif',1); document.frmDados.careta.value = 43"><img src="caretas/43.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/44.gif',1); document.frmDados.careta.value = 44"><img src="caretas/44.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/45.gif',1); document.frmDados.careta.value = 45"><img src="caretas/45.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/46.gif',1); document.frmDados.careta.value = 46"><img src="caretas/46.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/47.gif',1); document.frmDados.careta.value = 47"><img src="caretas/47.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/48.gif',1); document.frmDados.careta.value = 48"><img src="caretas/48.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/49.gif',1); document.frmDados.careta.value = 49"><img src="caretas/49.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/50.gif',1); document.frmDados.careta.value = 50"><img src="caretas/50.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/51.gif',1); document.frmDados.careta.value = 51"><img src="caretas/51.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/52.gif',1); document.frmDados.careta.value = 52"><img src="caretas/52.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/53.gif',1); document.frmDados.careta.value = 53"><img src="caretas/53.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/54.gif',1); document.frmDados.careta.value = 54"><img src="caretas/54.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/55.gif',1); document.frmDados.careta.value = 55"><img src="caretas/55.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/56.gif',1); document.frmDados.careta.value = 56"><img src="caretas/56.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/57.gif',1); document.frmDados.careta.value = 57"><img src="caretas/57.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/58.gif',1); document.frmDados.careta.value = 58"><img src="caretas/58.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/59.gif',1); document.frmDados.careta.value = 59"><img src="caretas/59.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/60.gif',1); document.frmDados.careta.value = 60"><img src="caretas/60.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		  <tr align="center" bgcolor="#FFFFFF">
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/61.gif',1); document.frmDados.careta.value = 61"><img src="caretas/61.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/62.gif',1); document.frmDados.careta.value = 62"><img src="caretas/62.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/63.gif',1); document.frmDados.careta.value = 63"><img src="caretas/63.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/64.gif',1); document.frmDados.careta.value = 64"><img src="caretas/64.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/65.gif',1); document.frmDados.careta.value = 65"><img src="caretas/65.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/66.gif',1); document.frmDados.careta.value = 66"><img src="caretas/66.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/67.gif',1); document.frmDados.careta.value = 67"><img src="caretas/67.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/68.gif',1); document.frmDados.careta.value = 68"><img src="caretas/68.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/69.gif',1); document.frmDados.careta.value = 69"><img src="caretas/69.gif" width="30" height="30" border="0"></a></td>
			<td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="#" onClick="MM_swapImage('imgcareta','','caretas/<? echo $ip; ?>.gif',1); document.frmDados.careta.value = <? echo $ip; ?>"><img src="caretas/<? echo $ip; ?>.gif" width="30" height="30" border="0"></a></td>
		  </tr>
		</table>
		</td></tr></table>
		</td>
	</tr>
  </table>
</div>
</body>
</html>