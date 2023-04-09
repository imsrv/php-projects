ctwice=0;amp='&';refr=20000;rndom=0;ldd=0;onff=1;timezone=0

if(typeof document.layers=='object'){window.location='info.php?why=netscape'}

if(typeof document.all=='object'){use_rnd=1
document.write('<meta http-equiv="Page-Enter" content="revealtrans(duration=0)"><meta http-equiv="Page-Exit" content="revealtrans(duration=0)">')
document.write('<link rel="stylesheet" type="text/css" href="'+skin_dir+'/msie.css" />');}

/* bottom frame accessible */
function cdone(){
if((parent.length!=0)&&(typeof parent.c=='object')&&(typeof parent.c.ldd=='number')&&(parent.c.ldd==1)){
return true}else{return false}}

/* add smiley */
function add_smiley(z){
if(window.opener&&window.opener.parent.length!=0&&window.opener.cdone()){
obj=window.opener.parent.c.document.fms.entry
tt=obj.value;obj.value=tt+z
window.opener.set_focus();self.close()}return false}

/* print email address */
function print_mail(a,b){document.write('<a href="mailto:'+a+'@'+b+'">'+a+'@'+b+'</a>')}

/* set random number */
function rand_number(){if(use_rnd!=0){rndom=Math.round(99999999*Math.random())}}

/* refresh chat frame */
function chat(){rand_number()
t=document.fms.time_offset.value
u=document.fms.name.value
v=document.fms.xpas.value
j=document.fms.last.value
parent.b.location='chat.php?time_offset='+t+amp+'name='+u+amp+'xpas='+v+amp+'last='+j+amp+'r='+rndom
return false}

/* change refresh rate */
function change_rate(a,b,c,d){refr=a*1000;
document.im0.src=c;document.im1.src=c;
document.im2.src=c;document.im3.src=c;
document.im4.src=c;b.src=d;chat()
set_focus();return false}

/* onmouseover/onmouseout 'refresh rate' images */
function over_out(a,b,c){
if(a.src.indexOf(b)==-1){a.src=c}
return true}

/* set refresh timeout */
function set_rtime(){self.scrollTo(0,1000)
if(cdone()){refr=parent.c.refr
nn=setTimeout('parent.c.chat()',refr)}
else{url=self.location.toString()
nn=setTimeout('self.location=url',refr)}}

/* clear refresh timeout */
function clear_rtime(){if(typeof nn=='number'){clearTimeout(nn)}}

/* check entry */
function entry_ok(){e=document.fms.entry;
if(e.value.length>0&&ctwice==0){ctwice=1
if((parent.length!=0)&&(typeof parent.b=='object')&&(typeof parent.b.nn=='number')){parent.b.clear_rtime()}
setTimeout('e.value="";e.focus();ctwice=0',500)
return true}else{chat()}e.focus();return false}

/* go to url */
function go_url(o,p,r){
rand_number();if(r==1){amp='?'}
if(p<3&&parent.length!=0){
parent.frames[p].location=o+amp+'r='+rndom}
else{self.location=o+amp+'r='+rndom}return false}

/* logout */
function log_out(){
n=parent.c.document.fms.name.value
parent.location='index.php?name='+n
return false}

/* print online user */
function usr(q,p){document.write('<span title="'+p+'">'+q+'</span><br />')}

/* focus entry */
function set_focus(){if(cdone()){
parent.c.document.fms.entry.focus()}}

/* set the latest message */
function set_last(r){if(cdone()){parent.c.document.fms.last.value=r}}

/* play sound */
function snd(){if(cdone()&&parent.c.onff==1){
if(typeof document.all=='object'){document.write('<object type="application/x-shockwave-flash" data="'+skin_dir+'/sound.swf" width="1" height="1"><param name="movie" value="'+skin_dir+'/sound.swf"></object>')}
else{document.write('<embed type="application/x-shockwave-flash" src="'+skin_dir+'/sound.swf" quality="high" width="1" height="1" name="movie" pluginspage="http://www.macromedia.com/go/getflashplayer">')}
}}

/* set time */
function time_win(n){rand_number();timezone=1
dd=window.open('time_offset.php?time_offset='+n+amp+'r='+rndom,'offset','width=160,height=390,resizable=1');
dd.focus();return false}

/* set time offset */
function set_offset(n){if(window.opener){
if(window.opener&&window.opener.parent.length!=0&&window.opener.cdone()){
window.opener.parent.c.document.fms.time_offset.value=n;window.opener.parent.c.chat()}
}self.location='time_offset.php?time_cookie='+n;return false}

/* load history */
function show_hist(){rand_number()
t=document.fms.time_offset.value
u=document.fms.name.value
v=document.fms.xpas.value
go_url('history.php?time_offset='+t+amp+'name='+u+amp+'xpas='+v,1,0)
return false}