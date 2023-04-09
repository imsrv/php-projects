var imgA = new Array("default.gif","angry.gif","attachments.gif","blush.gif","cool.gif","cry.gif","explaination.gif","goaway.gif","grin.gif","hehe.gif","link.gif","love.gif","lovetalk.gif","mad.gif","robin.gif","sad.gif","smile.gif","sneaky.gif","stare.gif","wink.gif","wonder.gif");
var imgN = new Array(" Subject icon","Angry","Attachments","Blush","Cool","Cry","Explaination","GoAway!","Grin","Hehe!","Link","Love","Love Talk","Mad","Robin","Sad","Smile","Sneaky","Stare","Wink","Wonder");
var refe, refe1;
var htmlstr = "<TR>";
var j=0;
var fill=0;
for( var i=0; i<imgA.length; i++)
{
  	refe = '/pearlforums2.3/smileys/' + imgA[i];
  	htmlstr += "<TD CLASS='CursorOver' align=center><img src=" + refe + " title=" + imgN[i] + " onclick=insertSmiley('"+refe+"')></td>"
  	if(++j==4){ htmlstr += "</tr><tr>" ; j=0 ;}
 }
 while(j<4 && j!=0){  
	 htmlstr += "<td></td>"
	 j++
	 fill=1
 }
 if(fill==1){ htmlstr += "</tr>"}
 document.write(htmlstr);
