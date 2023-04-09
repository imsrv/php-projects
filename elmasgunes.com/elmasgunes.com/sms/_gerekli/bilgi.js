var divname="elm_tip";
var divInnername="elm_inner";

var fixed=false;

var elmasgunes="<div id='elm_tip'><div id='elm_inner'></div></div>"

var CoordLeft=10;
var CoordRight=-15;

var hiddenTags = new Array();

function fm_MXY(XorY){
	var coord = 0;
	XorY=="x"?coord = event.clientX + document.body.scrollLeft:coord = event.clientY + document.body.scrollTop;
	if(coord<0)coord=0;
	return coord;
}

function bilgi_goster(){
	var NewCoordLeft=0,NewCoordRight=0; 
	var d=document;
	var thisObj = d.getElementById(divname);
	var browserwidth=document.body.clientWidth; 
	var browserheight=document.body.clientHeight+document.body.scrollTop+25;
	var soulwidth=thisObj.offsetWidth+10, soulheight=thisObj.offsetHeight+10;

	var activeObj=window.event.srcElement;
	var desc=activeObj.bilgi;
	
	if(desc!=null){	
		var x = fm_MXY("x"), y = fm_MXY("y");
		if(document.alldesc==desc){	
			NewCoordLeft=activeObj.offsetLeft+activeObj.offsetWidth-x;
			NewCoordRight=activeObj.offsetTop-y;
		}

		NewCoordLeft+=(x+soulwidth>browserwidth)?-soulwidth:CoordLeft; 
		NewCoordRight+=(y+soulheight>browserheight)?-soulheight:CoordRight;

		thisObj.style.left=x+NewCoordLeft+"px";  
		thisObj.style.top=y+NewCoordRight+"px"; 

		fm_writehelp(desc); 
		hy_collusion(thisObj); 
		
		if(fixed)document.alldesc=desc; 
	
	}else{
		hy_collusionRecover(); 
		thisObj.style.display="none";
	}
}

function fm_writehelp(val){ 
	var d=document;
	var thisObj = d.getElementById(divname);
	var innerObj = d.getElementById(divInnername);
	innerObj.innerHTML=val;
	thisObj.style.display="block";	
}

function hy_collusion(obj){ 
	var offsetLeft   = obj.offsetLeft;
	var offsetTop    = obj.offsetTop;
	var offsetWidth  = obj.offsetWidth;
	var offsetHeight = obj.offsetHeight;
	
	var topLeftX     = offsetLeft;
	var topLeftY     = offsetTop;
	var bottomRightX = offsetLeft + offsetWidth;
	var bottomRightY = offsetTop  + offsetHeight;
	var hyl = 0;
	
	if(document.getElementsByTagName){
		var selectTags = document.getElementsByTagName("select");
		
		for( ; hyl < selectTags.length; hyl++){
			var tag = selectTags[hyl];											
			var x1 = tag.offsetLeft;
			var y1 = tag.offsetTop;
			var x2 = x1 + tag.offsetWidth;
			var y2 = y1 + tag.offsetHeight;
			
			if( ((topLeftX < x1 && x1 < bottomRightX) || (topLeftX < x2 && x2 < bottomRightX)) &&
				((topLeftY < y1 && y1 < bottomRightY) || (topLeftY < y2 && y2 < bottomRightY)) ) {
			
				tag.style.visibility = "hidden";
				hiddenTags[ hiddenTags.length ] = tag;			
			}	
			else
				tag.style.visibility = "visible";
		}		
	}
}
function hy_collusionRecover(){
	var hyl = 0;
	
	for( ; hyl<hiddenTags.length; hyl++)
		hiddenTags[hyl].style.visibility = "visible";
}

if(document.all){ 
	document.write(elmasgunes);
	document.onmousemove=bilgi_goster;
}