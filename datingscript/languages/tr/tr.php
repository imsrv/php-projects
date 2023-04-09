<?php
############################################################
# \-\-\-\-\-\-\     AzDG  - S C R I P T S    /-/-/-/-/-/-/ #
############################################################
# AzDGDatingLite          Version 2.1.1                    #
# Writed by               AzDG (support@azdg.com)          #
# Created 03/01/03        Last Modified 04/05/03           #
# Scripts Home:           http://www.azdg.com              #
############################################################
# File name               tr.php                           #
# File purpose            Turkish language file            #
# File created by         egerci <egerci@altikom.net>      #
############################################################

define('C_HTML_DIR','ltr'); // HTML direction for this language
define('C_CHARSET', 'iso-8859-9'); // HTML charset for this language

### !!!!! Please read it: RULES for translate!!!!! ###
### 1. Be carefull in translate - don`t use ' { } characters
###    You can use them html-equivalent - &#39; &#123; &#125;
### 2. Don`t translate {some_number} templates - you can only replace it - 
###    {0},{1}... - is not number - it templates
###################################

$w=array(
'<font color=red size=3>*</font>', //0 - Symbol for requirement field
'G�venlik Hatas�- #', //1
'Bu E-Posta adresi halihaz�rda veritaban�nda bulunmakta l�tfen ba�ka bir tane deneyiniz!', //2
'Haytal� �sim Giri�i. {0} - {1} Karakter aras�nda olmal�', //3 - Don`t change {0} and {1} - See rule 2 !!!
'Hatal� Soyad� Giri�i. {0} - {1} Karakter aras�nda olmal�', //4
'Hatal� Do�umg�n�', //5
'Hatal� �ifre. {0} - {1} Karakter aras�nda olmal�', //6
'L�tfen Cinsiyetinizi Se�iniz', //7
'L�tfen Arad���n�z Cinsiyeti se�iniz', //8
'�li�ki t�r�n� giriniz', //9
'�lkenizi Se�iniz', //10
'Yanl�� veya Bo� E-Posta', //11
'Yanl�� Web Adresi', //12
'Yanl�� ICQ Numaras�', //13
'Yanl�� AIM ', //14
'Telefon Numaran�z� Giriniz', //15
'�ehrinizi Giriniz', //16
'Medeni Durumunuz', //17
'Cocuk Durumunuz', //18
'Boyunuzu Se�iniz', //19
'Kilonuzu Se�iniz', //20
'Arad���n�z Boy', //21
'Arad���n�z Kilo', //22
'Sa� Renginizi Se�iniz', //23
'G�z Renginizi Se�iniz', //24
'Etnik Grubunuzu Se�iniz', //25
'L�tfen �nan� Grubunuzu Se�iniz', //26
'Arad���n�z Etnik Grup', //27
'Arad���n�z �nan� Grubu', //28
'Sigara Kullan�m�', //29
'��ki Kullan�m�', //30
'E�itim Durumu', //31
'��iniz Hakk�nda Bilgi', //32
'Arad���n�z Ya� Grubu', //33
'Bizi Nereden Buldunuz', //34
'Hobileriniz ve Al��kanl�klar�n�z ', //35
'Hatal� hobi giri�i. {0} Karakterden uzun olamaz', //36
'Hatal� hobi kelime uzunlu�u. {0} Karakterden uzun olamaz', //37
'L�tfen kendi hakk�n�zdaki a��klaman�z�/yaz�n�z� buraya yaz�n', //38
'Hatal� A��klama giri�i. {0} Karakterden uzun olamaz', //39
'Hatal� A��klama kelime uzunlu�u. {0} Karakterden uzun olamaz', //40
'Fotograf�n�z Gerekli!', //41
'Tebrikler! <br>Aktivasyon kodunuz -posta adresinize g�nderildi. <br>Onaylama i�leminizi e-posta ile yapabilirsiniz.!', //42 - Message after register if need confirm by email
'Kay�t Onay �ste�i', //43 - Confirm mail subject
'Sitemize kay�t oldu�unuz i�in te�ekk�r ederiz...
L�tfen bu ba�lant�ya girerek kay�t i�leminizi onaylay�n�z

', //44 - Confirm message
'Kay�t oldu�unuz i�in te�ekk�rler. Giri� i�leminiz k�sa bir s�re �nce onayland�. L�tfen sitemizi ziyaret etmeyi unutmay�n�z..', //45 - Message after registering if admin allowing is needed
'Tebrikler! <br>Kullan�c� hesab�n�z veritaban�m�za eklenmi�tir.!<br><br>Kullan�c� No:', //46
'<br>�ifreniz:', //47
'L�tfen �ifrenizi tekrar yaz�n�z', //48
'�ifreniz ge�erli de�il', //49
'Kullan�c� Kay�t Formu', //50
'�sminiz', //51
'Karakter', //52
'Soyad�n�z', //53
'�ifreniz', //54
'�ifreniz (tekrar)', //55
'Do�umg�n�', //56
'Cinsiyet', //57
'D���nd���n�z �li�ki', //58
'�lke', //59
'E-Posta', //60
'Web Sayfas�', //61
'ICQ', //62
'AIM', //63
'Telefon', //64
'�ehir', //65
'Medeni Durum', //66
'�ocuk', //67
'Boyunuz', //68
'Kilonuz', //69
'Sa� Rengi', //70
'G�z Rengi', //71
'Etnik Grup', //72
'�nan� Durumu', //73
'Sigara', //74
'��ki', //75
'E�itim', //76
'��iniz', //77
'Hobileriniz', //78
'L�tfen kendinizi ve d���nd���n�z veya arad���n�z partner tipini a��klay�n�z.', //79
'Arad���n�z Cinsiyet', //80
'Arad���n�z Etnik Grup', //81
'Arad���n�z �nan�', //82
'Arad���n�z Ya�', //83
'Arad���n�z Boy', //84
'Arad���n�z Kilo', //85
'Bizi Nas�l Buldunuz?', //86
'Resim', //87
'Ana Sayfa', //88
'Kay�t', //89
'�ye Alan�', //90
'Arama', //91
'Yorumlar�n�z', //92
'SSS', //93
'�statistik', //94
'�ye Men�s� ID#', //95
'Mesajlar', //96
'Favori Listem', //97
'Bilgilerim', //98
'Bilgilerimi De�i�tir', //99
'�ifre De�i�tir', //100
'Bilgilerimi Sil', //101
'��k��', //102
'��lem Zaman�:', //103
'San.', //104
'Online Kullan�c�lar:', //105
'Online Misafirler:', //106
'Powered by <a href="http://www.azdg.com" target="_blank" class="desc">AzDG</a>', //107 - Don`t change link - only for translate - read GPL!!!
'Sadece kay�tl� kullan�c�lar detayl� arama yapabilirler', //108
'�zg�n�m, "En az ya�" alan� "En �ok ya�" alan�ndan k���k olmal�d�r', //109
'Arama sonucunda ard���n�z kriterlere rastlanmad�', //110
'Yok', //111 Picture available?
'Evet', //112 Picture available?
'Sunucuya ba�lan�lamad�<br>MYsql kullan�c� ad� veya �ifreniz yanl��.<brConfig dosyas�nda kontrol ediniz', //113
'Sunucuya ba�lan�lamad�<br>Veritaban� bulunamad�.<br>Veya config dosyas�nda ismi de�i�tirildi', //114
'Sayfa :', //115
'Arama Sonu�lar�', //116
'Toplam : ', //117 
'Kullan�c� ID', //118
'Ama�lar', //119
'Ya�', //120
'�lke', //121
'�ehir', //122
'Son Eri�im', //123
'Kay�t Tarihi', //124
'Detayl� Arama', //125
'Kullan�c� ID#', //126
'�sim', //127
'Soyad', //128
'Burcu', //129
'Boy', //130
'Kilo', //131
'Cinsiyet', //132
'�li�ki �e�idi', //133
'Medeni Durum', //134
'�ocuk', //135
'Sa� Rengi', //136
'G�z Rengi', //137
'Etnik Grup', //138
'�nan�', //139
'Sigara', //140
'��ki', //141
'E�itim', //142
'Kullan�c�lar� Ara', //143
'Web Sayfas�', //144
'ICQ', //145
'AIM', //146
'Telefon', //147
'Kay�t Zaman� ', //148
'Sonu� Listeleme', //149
'Sayfadaki Sonu� Say�s�', //150
'Basit Arama', //151
'�ye olmayanlara kapal�', //152
'K�t� bilgi g�nderen kullan�c�alra kapal�', //153
'Kullan�c� halen k�t� kullan�c� tablosunda', //154
'Te�ekk�rler, Kullan�c� k�t� kullan�c� tablosuna eklendi ve k�sa bir s�re i�inde y�netici taraf�ndan konotrol edilecek', //155
'Favori listesi �zelli�i kapal�', //156
'Kullan�c� halen favori listenizde', //157
'Te�ekk�rler, Kullan�c� favori lisytenzie eklendi', //158
'Bilgileriniz/Profiliniz y�netici kontrol� i�in al�nd�!', //159
'Kullan�c� profiliniz veritaban�na ba�ar� ile eklendi ', //160
'Profil aktivasyon hatas�. halen aktif olabilir', //161
'SSS veritaban� bo�', //162
'SSS Cevap#', //163
'B�t�n alanlar doldurulmal�d�r', //164
'Mesaj�n�z ba�ar� ile g�nderildi', //165
'L�tfen Konu Giriniz.', //166
'L�tfen mesaj�n�z� giriniz', //167
'Konu', //168
'Mesaj', //169
'Mesaj G�nder', //170
'�yeler ��in', //171
'Kullan�c� ID', //172
'Kay�p �ifre', //173
'Bizi �nerin', //174
'Arkada�-{0} e-posta', //175
'Bug�n�n do�um g�nleri', //176
'Do�umg�n� yok', //177
'Sitemize Ho�geldiniz', //178 Welcome message header
'AzDGDatingLite - yeni arkada�l�klar, ili�kiler, eylence, bulu�ma vve uzun zamanl� ili�ki kurmak i�in tam ard���n�z sitedir. Bulu�ma ve soyal ili�ki insanlar i�in hem eylenceli hemde g�venlidir..<br><br>Size �zel e-posta sistemimizi kullanarak yeni arkada�l�klar kurabilirsiniz.Bu sistem sizin di�er �yeler ile ili�kiye ge�menize ve arkada�l�klar kurman�z� sa�lar...<br>', //179 Welcome message
'Son {0} kay�tl� kullan�c�', //180
'H�zl� Arama', //181
'Detayl� Arama', //182
'G�n�n Fotograf�', //183
'Basit �statistik', //184
'Kullan�c� ID niz say�sal olmal�', //185
'Yanl�� Kullan�c� ID si veya �ifre', //186
'Mesajlar�n e-postaya g�nderilmasi kapal�', //187
'Konullan�c� ID ye mesaj g�nderme', //188
'Online kullan�c� yok', //189
'Tavsiye etme sayfas� kapal�', //190
'{0} dan tebrikrek', //191 "Recommend Us" subject, {0} - username
' {0} : Merhaba!

Nas�ls�n :)

L�tfen bu siteyi ziyaret et. �ok beyeneceksin:
{1}', //192 "Recommend Us" message, {0} - username, {1} - site url
'L�tfen do�ru yaz�n�z#{0} email', //193
'L�tfen isim ve e-posta yaz�n�z', //194
'{0} �ifreniz', //195 Reming password email subject
'Bu hesap aktif de�il veya veri taban�nda bulunmuyor.<br> L�tfen yorumlar�n�z k�sm�nda y�neticiye mesaj atarak bu konuyu bildirin.L�tfen mesaj�n�zda ID nizde bulunsun.', //196
'Merhaba!

Kullan�c� ID# :{0}
�ifre         :{1}

_________________________
{2}', //197 Remind password email message, Where {0} - ID, {1} - password, {2} - C_SNAME(sitename)
'�ifeniz e-posta adresinize ba�ar� ile g�nderildi.', //198
'L�tfen Kullan�c� No yu giriniz', //199
'�ifre G�nder', //200
'Mesaj G�nderme i�lemi kapal�', //201
'Kullan�c� ID# ye mesaj g�nderme', //202
'Kullan�c� mesaj� okudu�u zaman bana bildir', //203
'Database de kullan�c� yok', //204
'�statistik b�l�m� aktif de�il', //205
'Bu aktif ID bulunmuyor', //206
'Profil ID#', //207
'Kullan�c�n�n �smi', //208
'Kullan�c�n�n Soyad�', //209
'Do�um g�n�', //210
'E-Posta', //211
'Mesaj�n�z var', //212 - Subject for email
'��', //213
'Hobi', //214
'Hakk�nda', //215
'Pop�lerlik', //216
'E-Posta G�nder', //217
'K�t� Profil', //218
'Favori Listeme Ekle', //219
'Y�klenecek dosya yok , <br>veya y�klemek istedi�iniz dosya {0} Kb limitini a��yor. Dosya b�y�kl��� {1} Kb', //220
'Y�klemek istedi�iniz resmin geni�li�i {0} piksel den veya y�ksekli�i{1} pikselden daha b�y�k.', //221
'Y�klemek istedi�iniz dosya bi�imi yanl��t�r.(Sadece jpg, gif veya png olmal�). Sizinki - ', //222
'(Max. {0} Kb)', //223
'�lke istatistikleri', //224
'Mesaj�n�z Yok', //225
'Toplam Mesaj- ', //226
'S�ra', //227 Number
'Kimden', //228
'Tarih', //229
'Sil', //230 Delete
'<sup>Yeni</sup>', //231 New messages
'Se�ili Mesajlar� Sil', //232
'Gelen Mesaj - ', //233
'Cevapla', //234
'Merhaba, Mesaj�n�z {0}:\n\n_________________\n{1}\n\n_________________', //235 Reply to message {0} - date, {1} - message
'Mesaj�n�z Okundu', //236
'Mesaj�n�z:<br><br><span class=dat>{0}</span><br><br>{1} taraf�ndan okundu [ID#{2}] Okunma Zaman� {3}', //237 {0} - message, {1} - Username, {2} - UserID, {3} - Date and Time
'{0} mesaj ba�ar� ile silindi!', //238
'L�tfen eski �ifrenizi giriniz', //239
'L�tfen yeni �ifrenizi giriniz', //240
'L�tfen yeni �ifrenizi yendiden giriniz', //241
'�ifre De�i�tirme', //242
'Eski �ifre', //243
'Yeni �ifre', //244
'Yeni �ifrenizi yeniden giriniz', //245
'Favori Listenizde herhangibir kullan�c� bulunmuyor', //246
'Ekleme Tarihi', //247
'Se�ili kullan�c�lar� sil', //248
'Bilgilerinizi silmek istedi�inize emin misiniz?<br>B�t�n mesajlar, resimler silinecektir.', //249
'{0} nolu kullan�c� veritaban�ndan ba�ar� ile silindi', //250
'Bilgileriniz y�netici onay�ndan sonra silinecektir', //251
'{0} kullan�c� ba�ar�yla silindi!', //252
'Hatal� �ifre. ��fre karakterlerinde hatal� karakter bulunuyor olabilir', //253
'�ifer de�i�tirmek i�in hakk�n�z yok', //254
'Eski �ifreniz yanl��. L�tfen tekrar deneyiniz!', //255
'�ifreniz ba�ar� ile de�i�tirildi!', //256
'B�t�n resimleri silmek m�mk�n de�il', //257
'Bilgileriniz ba�ar� ile de�i�tirildi', //258
' - Resmi Sil', //259
'Sitedeki bilgileriniz ba�ar� ile temizlendi. Taray�c�n�z� kapatabilirsiniz', //260
'Bayrak Dosyas� Bulunamad�', //261
'Diller', //262
'Tamam', //263
'Giri� [3-16 Karakter[A-Za-z0-9_]]', //264
'Giri�', //265
'Kullan�c� NO: 3-6 karakter aras�nda olmal� ve  A-Za-z0-9_ karakterleri kullan�labilir', //266
'Bu giri� veritaban�nda bulunuyor. L�tfen tekrar deneyin!', //267
'Toplam Kullan�c� - {0}', //268
'The messages are not visible. You should be the privileged user see the messages.<br><br>You can purshase from <a href="'.C_URL.'/members/index.php?l=tr&a=r" class=head>here</a>', //269 change l=default to l=this_language_name
'User type', //270
'Purshase date', //271
'Search results position', //272
'Price', //273
'month', //274
'Purshase Last date', //275
'Higher than', //276
'Purshase', //277
'Purshase with', //278
'PayPal', //279
'Thanks for your registration. Payment has been succesfully send and will be checked by admin in short time.', //280
'Incorrect error. Please try again, or contact with admin!', //281
'Send congratulation letter about privilegies activating', //282
'User type has successfully changed.', //283
'Email with congratulations has been send to user.', //284
'ZIP',// 285 Zip code
'Congratulations, 

Your status is changed to {0}. This privilegies will be available in next {1} month.

Now you can check your messages in your box.

__________________________________
{2}', //286 {0} - Ex:Gold member, {1} - month number, {2} - Sitename from config
'Congratulations', //287 Subject
'ZIP code must be numeric', //288
'Keywords', //289
'We are sorry, but the following error occurred:', //290
'', //291
'', //292
'', //293
'', //294
'', //295
'', //296
'', //297
'', //298
'' //299
); 
?>
