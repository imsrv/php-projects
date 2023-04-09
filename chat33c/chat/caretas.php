<?
include "config.php";
$ip	= getenv ("REMOTE_ADDR");//IP do usuario
$ip = str_replace(".", "", $ip);
?>
<html><head>
<META HTTP-EQUIV="Pragma" Content="No-cache">
<META HTTP-EQUIV="expires" CONTENT="Tue, 20 Aug 1996 4:25:27">
<META HTTP-EQUIV="Cache Control" Content="No-cache">
<link href="romano.css" rel="stylesheet" type="text/css">
<script src="borderize.js"></script>
</head>
<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Escolha sua careta:</font></b><br>
<br>
<table width="380" border="0" align="center" cellpadding="0" cellspacing="0">
<tr> 
	<td width="10" align="left" class="titulo"><img src="images/dobra.gif" width="10" height="20"></td>
	<td width="360" align="center" class="titulo"><b>Caretas</b></td>
	<td width="10" align="right" class="titulo"><img src="images/dobra2.gif" width="10" height="20"></td>
  </tr>
  <tr> 
	<td colspan="3" align="center">
	<table cellpadding="1" cellspacing="0" border="0" bgcolor="#000000" width="365"><tr><td>
	<table width="100%" height="200" border="0" align="center" cellpadding="0" cellspacing="0" bgColor="#FFFFFF" onMouseover="borderize_on(event)" onMouseout="borderize_off(event)">
<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<? echo "$dest";?>.php?careta=1"><img src="caretas/1.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=2"><img src="caretas/2.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=3"><img src="caretas/3.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=4"><img src="caretas/4.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=5"><img src="caretas/5.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=6"><img src="caretas/6.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=7"><img src="caretas/7.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=8"><img src="caretas/8.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=9"><img src="caretas/9.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=10"><img src="caretas/10.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=11"><img src="caretas/11.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=12"><img src="caretas/12.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=13"><img src="caretas/13.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=14"><img src="caretas/14.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=15"><img src="caretas/15.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=16"><img src="caretas/16.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=17"><img src="caretas/17.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=18"><img src="caretas/18.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=19"><img src="caretas/19.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=20"><img src="caretas/20.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=21"><img src="caretas/21.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=22"><img src="caretas/22.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=23"><img src="caretas/23.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=24"><img src="caretas/24.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=25"><img src="caretas/25.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=26"><img src="caretas/26.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=27"><img src="caretas/27.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=28"><img src="caretas/28.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=29"><img src="caretas/29.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=30"><img src="caretas/30.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=31"><img src="caretas/31.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=32"><img src="caretas/32.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=33"><img src="caretas/33.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=34"><img src="caretas/34.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=35"><img src="caretas/35.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=36"><img src="caretas/36.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=37"><img src="caretas/37.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=38"><img src="caretas/38.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=39"><img src="caretas/39.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=40"><img src="caretas/40.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=41"><img src="caretas/41.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=42"><img src="caretas/42.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=43"><img src="caretas/43.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=44"><img src="caretas/44.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=45"><img src="caretas/45.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=46"><img src="caretas/46.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=47"><img src="caretas/47.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=48"><img src="caretas/48.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=49"><img src="caretas/49.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=50"><img src="caretas/50.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=51"><img src="caretas/51.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=52"><img src="caretas/52.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=53"><img src="caretas/53.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=54"><img src="caretas/54.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=55"><img src="caretas/55.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=56"><img src="caretas/56.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=57"><img src="caretas/57.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=58"><img src="caretas/58.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=59"><img src="caretas/59.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=60"><img src="caretas/60.gif" width="30" height="30" border="0"></a></td>
		</tr>
		<tr align="center"> 
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=61"><img src="caretas/61.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=62"><img src="caretas/62.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=63"><img src="caretas/63.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=64"><img src="caretas/64.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=65"><img src="caretas/65.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=66"><img src="caretas/66.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=67"><img src="caretas/67.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=68"><img src="caretas/68.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"> 
			<a href="<?  echo "$dest";?>.php?careta=69"><img src="caretas/69.gif" width="30" height="30" border="0"></a></td>
		  <td class="fundo_careta" onMouseOver="this.style.backgroundColor='<? echo careta_over?>'" onMouseOut="this.style.backgroundColor='<? echo careta_up ?>'"><a href="<?  echo "$dest";?>.php?careta=<? echo $ip; ?>"><img src="caretas/<? echo $ip; ?>.gif" width="30" height="30" border="0"></a></td>
		</tr>
	  </table>
	  </td></tr></table>
	  </td>
  </tr>
</table>
</html>