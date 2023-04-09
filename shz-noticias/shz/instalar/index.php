<?

// Incuindo o arquivo de configuração
@include("../config.php");
@include "../stl.php";
?>
<html>
<title><? echo $tituloshz; ?></title>
<body bgcolor="<? echo $colorbg; ?>" onload="setTimeout ('window.location.reload(true)',900000)">

<FORM METHOD="POST" ACTION="valida.php">
	<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0" ALIGN="CENTER" VALIGN="TOP" WIDTH="95%">
	      <TR>
	      <TD >
	      <TABLE BORDER="1" CELLPADDING="1" CELLSPACING="1" WIDTH="100%">
	            <TR ALIGN="CENTER">
	            <TD COLSPAN="2"><b>Instalador SHZ</b></TD>
	            </TR>
	            <TR ALIGN="LEFT">
	            <TD COLSPAN="2">Esse instalador foi criado com o objetivo de facilitar a instalação dos scriptZ SHZ!<br>
		    Porem você pode utilizar o arquivo noticias.sql!
	            </TD>
	            </TR>
	            <TR ALIGN="LEFT">
                    <TD >Endereço do servidor de DB:</TD>
	            <TD><INPUT TYPE="TEXT" NAME="dbserveri" SIZE="30" VALUE="localhost"></TD>
	            </TR>
	            <TR>
                    <TD>Nome do DB:</TD>
	            <TD><INPUT TYPE="TEXT" NAME="dbnamei" SIZE="30" VALUE="noticias"></TD>
	            <TR>
	            <TD>Usuario do DB:</TD>
	            <TD><INPUT TYPE="TEXT" NAME="dbuseri" SIZE="30" VALUE="root"></TD>
	            </TR>
	            <TR>
                    <TD>Senha do DB:</TD>
	            <TD><INPUT TYPE="PASSWORD" NAME="dbpassi" SIZE="30"></TD>
	            </TR>
	            <TR ALIGN="Right">
	            <TD COLSPAN="2"><INPUT TYPE="HIDDEN" NAME="next" VALUE="database"><INPUT TYPE="SUBMIT" VALUE="Next >"></TD>
	            </TR>
	      </TABLE>
	</TD>
	</TR>
      </TABLE>

</BODY>
</HTML>
