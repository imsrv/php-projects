function getMessage() {
 var ans; 
 ans	= window.confirm('Girdi�iniz kategori 18 ya� �st� unsurlar i�ermektedir.\nE�er 18 ya��ndan b�y�kseniz tamam tu�una,\nDe�ilseniz iptal tu�una bas�n�z.'); 
	if (ans == true) { 
		alert('Giri�iniz Onaylanm��t�r.');
	} else { 
		alert('Giri�iniz �ptal Edilmi�tir.');
		window.location.href="http://www.cixvideo.com/"
	}
}
getMessage();
