<html>
<head>
<TITLE><? echo "TR DESIGN - Livro de Visitas" ?></TITLE>



<META NAME="Author" CONTENT="Tony Rodrigues, Copyright by TR DESIGN, suporte@tr-designer.com">

<META NAME="Keywords" CONTENT="E-Book, Livro de visitas, Guestbook Script, Guestbook, Sign Guestbook">

<META NAME="Description" CONTENT="Contactform written in PHP copyright by tr-designer.com">
<STYLE>



FONT,body,td,table {font-family : Arial;font-size : 11px;}

b {

	font-family : Arial;

	font-weight : bold;

}

a,a:hover,.link{font-family: arial;font-size: 8pt;font-color: 66666;}

input, option

	{

		border-color:#3C3C3C;

		border-width:1;

		font-family:tahoma,verdana, Helvetica;

		font-size:11;

		background-color:#eeeeee;

		color:#3C3C3C;

	}

	select

	{

		border-color:#3C3C3C;

		border-width:1;

		font-family:Arial, Helvetica;

		font-size:12px;

		color:#3C3C3C;

		background-color:#FFFFFF;

	}

	textarea

	{

		border-color:#3C3C3C;

		border-width:1;

		overflow:hidden;

		font-family:tahoma,Arial, Helvetica;

		font-size:12;

		color:#000000;

		background-color:#eeeeee;

	}

input.submit {

   background-color: #e0e0e0;

   font-weight: bold;

  }

  A{

	color : #0066CC;

	text-decoration : none;

}

  

  A:visited {

	color : Gray;

}

  A:hover {

	color : #0099FF;

}



</STYLE>
</head>



<body bgcolor="#FFFFFF" leftmargin="0" topmargin="30" marginwidth="0" marginheight="0">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#005599">   

   <CENTER>
<FONT color="#000000" face=Verdana>
   <B>Assine nosso livro de visitas.</B>

   </FONT>

   </CENTER></td>
  </tr>
  <tr>
  <td height="50"></td>
  </tr>
  <tr>
    <td><form action="<?PHP_SELF?>" method="post">
      <table width="498" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr> <marquee>Estes são os codigos para smiles: :-)=<img src="smile.gif"> :-(=<img src="notsmile.gif"> :-o=<img src="osmile.gif"> :-P=<img src="tongue.gif"> ;-)=<img src="zwinker.gif">:-x=<img src="xsmile.gif">!(coloqueos na area de texto)!</marquee>
          <td>Nome</td>
          <td> 
            <input name="name" size=30 value="">
          </td>
        </tr>
        <tr> 
          <td>E-Mail</td>
          <td> 
            <input name="email" size=30 value="">
          </td>
        </tr>
        <tr> 
          <td>Homepage:</td>
          <td> 
            <input name="url" size=30 value="http://">
          </td>
        </tr>
        <tr> 
          <td>Compania:</td>
          <td> 
            <input name="company" size=30 value="">
          </td>
        </tr>
        <tr> 
          <td valign="top">Mensagem:</td>
          <td> 
            <textarea name="message" cols=50 rows=10 wrap=soft></textarea>
          </td>
        </tr>
        <tr>
          <td valign="top">
            <input type="hidden" value="ok" name="send_status">
          </td>
          <td>
            <input type="submit" value="Assinar Guestbook" name="submit">
            <input type="submit" value="Ler Guestbook" name="view_guestbook">
          </td>
        </tr>
      </table></form>
    </td>
  </tr>
  <tr>
    <td> <center>
      <?



			 







	/******************************************************************/

	if ($name == "" || $email == "" || $company == "" || $message == "")

	   {

			 	echo "Veja as assinaturas";

				for ($i=0; $i<3; $i++)

				{

				echo ".";

				sleep(1);

				flush();

				}

		$filesize = filesize("entry.dat"); 

		$file = fopen("entry.dat","r");

		$buffer = fread($file,$filesize);

		/********************** SMILE PARSING **(beta)********************/
		$smile_parse1 = str_replace(":-)","<IMG SRC=smile.gif border=\"0\">",$buffer);
		$smile_parse2 = str_replace(":-P","<IMG SRC=tongue.gif border=\"0\">",$smile_parse1);
		$smile_parse3 = str_replace(":-p","<IMG SRC=tongue.gif border=\"0\">",$smile_parse2);
		$smile_parse4 = str_replace(":P","<IMG SRC=tongue.gif border=\"0\">",$smile_parse3);
		$smile_parse5 = str_replace(":)","<IMG SRC=smile.gif border=\"0\">",$smile_parse4);
		$smile_parse6 = str_replace(":-(","<IMG SRC=notsmile.gif border=\"0\">",$smile_parse5);
		$smile_parse7 = str_replace(":(","<IMG SRC=notsmile.gif border=\"0\">",$smile_parse6);
		$smile_parse8 = str_replace(":-o","<IMG SRC=osmile.gif border=\"0\">",$smile_parse7);
		$smile_parse9 = str_replace(";-)","<IMG SRC=zwinker.gif border=\"0\">",$smile_parse8);
		$smile_parse10 = str_replace(";)","<IMG SRC=zwinker.gif border=\"0\">",$smile_parse9);

		/********************** CENSURES **************************/
		$smile_parse11 = str_replace("buceta","<IMG SRC=censured.gif border=\"0\">",$smile_parse10);
		$smile_parse12 = str_replace("merda","<IMG SRC=censured.gif border=\"0\">",$smile_parse11);
		$smile_parse13 = str_replace("caralho","<IMG SRC=censured.gif border=\"0\">",$smile_parse12);
		$smile_parse14 = str_replace("porra","<IMG SRC=censured.gif border=\"0\">",$smile_parse13);
		$smile_parse15 = str_replace("puta","<IMG SRC=censured.gif border=\"0\">",$smile_parse14);
		$smile_parse16 = str_replace("bicha","<IMG SRC=censured.gif border=\"0\">",$smile_parse15);

		$buffer_parsed = str_replace(":-x","<IMG SRC=xsmile.gif border=\"0\">",$smile_parse16);
		echo "$buffer_parsed";

		fclose($file);

	   }

	else if ($send_status == "ok")

	   		{



			/********* GET VARIABLE **********/

			 $filesize = filesize("entry.dat"); 

			 $file = fopen("entry.dat","r");

			 $buffer = fread($file,$filesize);

			 $buffer_parsed = str_replace(":-)","<IMG SRC=smile.gif border=0",$buffer);

			 fclose($file);

$today = getdate(); 
$month = $today[month]; 
$mday = $today[mday]; 
$year = $today[year]; 
$zeituhr = "$month $mday, $year";







			/******* WRITING MESSAGE TO FILE ****/

			 $file = fopen("entry.dat","w");

			 $parsed_message = strip_tags($message,"<a>,<i>");
			 $parsed_message_br = str_replace("\n","<br>",$parsed_message); 
			 $today = date( "Ymd", time() );
			 $message_table ="<TABLE BORDER=\"0\" CELLPADDING=\"1\" CELLSPACING=\"0\" bgcolor=EEEEEE width=\"500\"><TD bg=\"top.gif\" colspan=\"2\"><IMG SRC=\"top.gif\" width=\"100%\" height=\"5\" border=\"0\"></TD></TR><TR><TD align=\"right\" colspan=\"2\"><i>$zeituhr</i></TD></TR><TR><TR><TD width=\"30%\"><B>Nome:</B></TD><TD>$name</TD></TR><TR><TD><B>E-Mail:</B></TD><TD><A HREF=\"mailto:$email\">$email</A></TD></TR><TR><TD><B>Homepage:</B></TD><TD><A HREF=\"$url\" target=\"_blank\">$url</A></TD></TR><TR><TD><B>Compania:</B></TD><TD>$company</TD></TR><TR><TD valign=\"top\" colspan=\"1\"><B>Mensagem:</B></TD><TD>$parsed_message_br</TD></TR><TR><TD bg=\"bottom.gif\" colspan=\"2\"><IMG SRC=\"bottom.gif\" width=\"100%\" height=\"13\" border=\"0\"></TD></TR></TABLE>";

 			 fputs($file,"$message_table \n $buffer");

			 fclose($file);

		

			}

	else if ($view_guestbook == "View Guestbook"){

			/************ READING OUT **************/

			 $filesize = filesize("entry.dat"); 

			 $file = fopen("entry.dat","r");

			 $buffer = fread($file,$filesize);

			 $buffer_parsed = str_replace(":-)","<IMG SRC=smile.gif border=0",$buffer);

			 echo "$buffer_parsed";

			 fclose($file);

			/************************************/

		}

	$copyright = "   <!-- PLEASE DO NOT REMOVE THIS TAG AND SUPPORT MY WORK ----------------------------------------->
	
   <span class=\"link\">TR DESIGN, Copyright by <A HREF=\"http://www.tr-designer.com\" target=\"_blank\">tr-designer.com</A> &copy;
	
   <!-- PLEASE DO NOT REMOVE THIS TAG AND SUPPORT MY WORK ----------------------------------------->";


	?></center>
    </td>
  </tr>
    </tr>
  <tr>
  <td height="50"></td>
  </tr>
  <tr>
    <td bgcolor="#005599">
   <CENTER>
        <FONT color="#000000"><?echo"$copyright"?></FONT> 
      </CENTER></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
