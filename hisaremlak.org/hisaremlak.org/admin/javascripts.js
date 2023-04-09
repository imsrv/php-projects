// bilgi bölümü için
function BlokKatla(id){
	var katman = document.getElementById(id);
	var buton  = document.getElementById(id+'Buton');

	if(katman.style.display == 'block') {
		buton.src = 'images/bilgix.gif';
		katman.style.display = 'none';
	}
	else {
		buton.src = 'images/bilgix.gif';
		katman.style.display = 'block';
	}

	return;
}

var blok_liste = new Array();
blok_liste[0] = 'divid0';
blok_liste[1] = 'divid1';
blok_liste[2] = 'divid2';
blok_liste[3] = 'divid3';
blok_liste[4] = 'divid4';
blok_liste[5] = 'divid5';

function BlokDurum(durum){
	for(i=0; i < blok_liste.length; i++) {
		var katman = document.getElementById(blok_liste[i]);
		var buton  = document.getElementById(blok_liste[i]+'Buton');
		if(durum == 'none') {
			buton.src = 'images/bilgix.gif';
			katman.style.display = 'none';
		}
		else {
			buton.src = 'images/bilgix.gif';
			katman.style.display = 'block';
		}
	}
}



// Dosyayi yazdir
function printPage() { print(document); }



// kayitlari silmek için onay aliyoruz
function OnayIste(mesaj, linkegit){
var agree=confirm(mesaj);
if (agree)
window.location = linkegit
}


// POPUP PENCERE HESABI
function openpop(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


// SIK KULLANILANLARA EKLE
var bookmarkurl="http://www.mirrormag.net" 
var bookmarktitle="Mirror Dergisi" 
function addbookmark(){ 
if (document.all) 
window.external.AddFavorite(bookmarkurl,bookmarktitle) 
} 