<?
include ("../sources/global.php");
include ("../sources/header.php");
?>
<script language="javascript">
<!-- //JavaScript
        function populateFileSize() {
          var ix = document.forms[0].filesize_choice.selectedIndex;
          var selected_size = document.forms[0].filesize_choice.options[ix].value;                
          if (selected_size != "-") {
                        document.forms[0].file_size.value = selected_size;
          }
        }

        function populatePercentage() {
                var ix = document.forms[0].percentage_choice.selectedIndex;  
                var selected_percentage = document.forms[0].percentage_choice.options[ix].value;          
                if (selected_percentage != "-") { 
                        document.forms[0].percentage.value = selected_percentage;
                } 
        }



        function populatePageviews() {
                var ix = document.forms[0].pageviews_choice.selectedIndex;  
                var selected_pageviews = document.forms[0].pageviews_choice.options[ix].value;          
                if (selected_pageviews!= "-") { 
                        document.forms[0].pageviews.value = selected_pageviews;
                } 
        }

        function calculateDownloadTime() {      
                var fs = document.forms[0].file_size.value;
                var per = document.forms[0].percentage.value;
                var pv = document.forms[0].pageviews.value;

                if ((isNaN (parseInt(fs,10))) || (isNaN (parseInt(per,10))) || (isNaN (parseInt(pv,10))) ) { 
                        alert ("Lütfen deðerleri giriniz...");                
                        return false;
                }
                var week = 0;
                var portion = 0;
                var result = 0;
                var fraction = 0.5;  
                var answer;
                answer = "";

                week = pv * fs;
                portion= 0.01 * per / fraction;   
                result= (week * portion) / 3600;
	    result = result * 8;
                answer = answer + result;
                answer = Math.round(answer);
                document.forms[0].answer.value = answer;

                var line;
                var count = 0;
                var a = new Array("Host25 veya üzeri size uygundur. (Küçük Paketler)", "Host100 veya üzeri size uygundur (Standart Paketler)", "Host250 veya üzeri size uygundur (Standart Paketler)", "Host500 veya üzeri size uygundur (Standart Paketler)", "Host1000 veya üzeri size uygundur (Büyük Paketler)", "Host2500 veya üzeri size uygundur (Büyük Paketler)", "Host5000 veya Sunucu uygundur (Büyük Paketler)", "Size özel sunucu gerekmektedir.");

                var b = new Array(56,250,500,1000,1500,3000,45000,100000000);
                for(i = 0; answer >= b[i]; i++) {
                          count =i+1;
                }
                line = a[count];

                document.forms[0].line.value = line;
                return false;
        }
// -->  
</script>
<table class="line" align="center" border="0" cellpadding="0" cellspacing="0" width="775">
  <tbody><tr>
    <td><img src="<? echo ($adress); ?>images/sp.gif" alt="" height="12" width="1"></td>
  </tr>
</tbody></table>
<table class="border" align="center" border="0" cellpadding="0" cellspacing="0" width="775">
  <tbody><tr valign="top"> 
    <td bgcolor="#f7f3ea" width="552">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td valign="top"><img src="<? echo ($adress); ?>images/inpic.jpg" alt="" height="119" width="552"></td>
        </tr>
      </tbody></table>
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td class="here" valign="top"><img src="<? echo ($adress); ?>images/ar2.gif" alt="" height="11" width="11"> 
            <a class="w" href="<? echo ($adress); ?>index.php"> Hostkenti</a> <font color="#ffff00">&#8226; 
            </font>Web Hosting</td>
        </tr>
      </tbody></table>
      <table align="center" border="0" cellpadding="0" cellspacing="0" width="548">
        <tbody><tr> 
          <td height="5"><img src="<? echo ($adress); ?>images/spc.gif" alt="" height="1" width="1"></td>
        </tr>
        <tr> 
          <td class="content" valign="top"> <h2>Web Hosting: Açýklama</h2><p></p>
            <p>Hosting seçiminizi yaparken sitenizin tahmini kullanacaðý alana göre tercih yapmalýsýnýz..<BR>Firmamýz sizin için çesitli büyüklüklerde internet sitelerinin tahmini ihtiyaçlarýný göz önünde bulundurarak paketler hazýrladý.. Sað taraftaki menüden kurmak istediðiniz sitenin büyüklügüne göre size en uygun host paketini seçebilirsiniz.. </p>
            <p align="right"> <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a></p>            <p><strong>Tahmini ihtiyacýmý nasýl hesaplarým?<a name="vh2"></a><br>
            </strong>Tahmini ihtiyacýnýzý hesaplarken dosyalarýnýzýn kaplayacaðý alaný ve ziyaretçi sayýsýný göz önünde bulundurmalisiniz..  </p>
            <p align="right"> <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a></p>            <p><strong>Ýhtiyaçlarýmý bilmiyorum?<a name="vh3"></a><br>
              </strong>Internet sektöründe yenisiniz ve sitenizin ihtiyaçlarýný hesaplayamiyorsunuz.. Firmamýzýn sizin için tasarladigi "Paket Hesaplayici" yý doldurun, o ihtiyaçlarýnýza göre size uygun paket önerisinde bulunsun..</p>
<form onsubmit="return (calculateDownloadTime());">
<center>
<table style="border-collapse: collapse;" border="1" bordercolor="#EDE4D1" cellpadding="2" cellspacing="1" width="500"><tr height="25">
		<td colspan="2" bgcolor="#EDE4D1" width="100%">
		<p align="left"><font face="verdana" size="2"><b>Paket Hesaplayýcý</b></font></p></td>
        	</tr>

        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Sayfalarýn Boyutu:</font></p></td>

        	<td width="70%">
        	<p align="left"><font face="verdana" size="1"><input size="5" name="file_size" type="text"> kb (veya <select name="filesize_choice" onchange="populateFileSize()"><option value="-"> - - -&nbsp; Örnekler  &nbsp;- - -

        </option><option value="3"> Sadece yazýdan oluþan sayfa
        </option><option value="20"> Basit web sayfasý
        </option><option value="50"> Grafikli web sayfasý
        </option><option value="100"> Zengin web sayfasý
        </option></select>)</font></p></td>
        	</tr>

        	<tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Ziyaret oraný:</font></p></td>
        	<td width="70%">

        	<p align="left"><font face="verdana" size="1"><input size="5" value="" name="percentage" type="text"> % (veya <select name="percentage_choice" onchange="populatePercentage()"><option value="-"  selected="selected"> - - -&nbsp; Örnekler  &nbsp;- - -
        </option><option value="0.5"> Çok az

        </option><option value="1"> Az
        </option><option value="1.5"> Normal

        </option><option value="2"> Biraz fazla
        </option><option value="2.5"> Fazla

        </option><option value="3"> Çok Fazla

        </option><option value="5"> Aþýrý Fazla

        </option></select>)</font></p></td>
        	</tr><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Sayfa Görüntüleme: <font face="verdana" size="1">(haftada)</font></p></td>
        	<td width="70%">

        	<p align="left"><font face="verdana" size="1"><input size="6" name="pageviews" type="text"> sayfa (veya 
        <select name="pageviews_choice" onchange="populatePageviews()"><option value="-"> - - -&nbsp; Örnekler  &nbsp;- - -
        </option><option value="500"> Kiþisel Site
        </option><option value="10000"> Normal Bilgi/Þirket Sitesi
        </option><option value="50000"> Popüler Þirket Sitesi
        </option><option value="100000"> Yeni Forum veya Toplist
        </option><option value="1000000"> Forum veya Toplist
        </option><option value="10000000"> Çok Geliþmiþ Site
        </option></select>)</font></p></td>
        	</tr><tr>
        	<td colspan="2">
        	<center><input value=" Hesapla " type="submit"></center></td>
        	</tr><tr>
        	<td width="30%" valign="top">
        	<p align="left"><font face="verdana" size="2">Tavsiye edilen paket:</font></p></td>
        	<td width="70%">

        	<p align="left"><font face="verdana" size="1"><input name="answer" type="hidden"><input size="50" name="line" type="text"></font></p></td>
        	</tr>
		</table></form><br></CENTER><p align="right"> <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a></p>            <p><strong>Hatýrlatma<a name="vh4"></a><br>
            </strong>Sipariþ vermeden önce lütfen "Servis Koþullarý" ve "Kullaným Sözleþmesi"ni okuyunuz.</p>
            <p align="right"> <img src="<? echo ($adress); ?>images/ar4.gif" alt="" height="7" width="7"> <a href="#top">Sayfa Baþý</a></p></td>
        </tr>
      </tbody></table> </td>
    <td class="bgright"><table cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr> 
          <td class="subm" valign="top">Web Hosting</td>
        </tr>
        <tr> 
          <td align="right" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="98%">
              <tbody><tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hosting/sunucu_ozellikleri.php">Genel Sunucu Özellikleri</a></td>
              </tr><tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hosting/kucuk.php">Küçük Hosting Paketleri</a></td>
              </tr>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hosting/standart.php">Standart Hosting Paketleri</a></td>
              </tr>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hosting/buyuk.php">Büyük Hosting Paketleri</a></td>
              </tr>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>hosting/bayii.php">Bayii Hosting Paketleri</a></td>
              </tr>
              <tr> 
                <td valign="top"><a class="ln" href="<? echo ($adress); ?>siparis/hosting.php">Sipariþ Verin</a></td>
              </tr>
            </tbody></table></td>
        </tr>
      </tbody></table>
      
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
          <td><img src="<? echo ($adress); ?>images/esp.gif" alt="" height="6" width="215"></td>
        </tr>
      </tbody></table>
      
    </td>
  </tr>
</tbody></table>
<?
include ("../sources/footer.php");
?>