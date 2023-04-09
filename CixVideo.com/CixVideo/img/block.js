function getMessage() {
 var ans; 
 ans	= window.confirm('Girdiðiniz kategori 18 yaþ üstü unsurlar içermektedir.\nEðer 18 yaþýndan büyükseniz tamam tuþuna,\nDeðilseniz iptal tuþuna basýnýz.'); 
	if (ans == true) { 
		alert('Giriþiniz Onaylanmýþtýr.');
	} else { 
		alert('Giriþiniz Ýptal Edilmiþtir.');
		window.location.href="http://www.cixvideo.com/"
	}
}
getMessage();
