/* -------------------------------------------------------
*
* PhpConcept Javascript Color Chooser
* Created by Vincent Blavet (vincent@blavet.net) and with some modification made by bitmixsoft.com (Zsolt Mali)
* All right reserved by PhpConcept (http://www.phpconcept.net)
* GNU GPL Licence
* -------------------------------------------------------
*/

// ----- Specific global values
var PcjsDestObject;
var PcjsDestProperty;
NS4 = (document.layers) ? 1 : 0;

// ----- Start color chooser
function PcjsColorChooser2(destobject, destproperty, e) {
        object = 'PcjsPopup';
if (document.getElementById && document.getElementById(object) != null)
        node = document.getElementById(object).style.visibility='visible';
else if (document.layers && document.layers[object] != null) {
        document.layers[object].visibility = 'visible';
                document.layers[object].left = window.pageXOffset - 30;
                document.layers[object].top  = window.pageYOffset - 40;
                }
else if (document.all)
        document.all[object].style.visibility = 'visible';
}
function PcjsColorChooser(destobject, destproperty, destlayer, e)
{
// ----- Store the destination object
PcjsDestObject = destobject;
PcjsDestLayer = destlayer;
if (destproperty == "")
PcjsDestProperty = "value";
else
PcjsDestProperty = destproperty;

// ----- Get the initial value
eval("PcjsInternalSelectColor(PcjsDestObject."+PcjsDestProperty+")");

// ----- Select the ilayer
if (document.layers) {
        var obj = document.layers['PcjsPopup'];
}
else if (document.all) {
                var obj = document.all['PcjsPopup'];
}
else {
        var obj = document.getElementById('PcjsPopup');
}

// ----- Set the popup position
if (document.layers) {
                obj.left = window.pageXOffset-30;
                obj.top  = window.pageYOffset-10;
}
else if (document.all) {
        obj.style.left = e.x-300;
                if (navigator.appName.indexOf('Opera')!=-1) {
                        obj.style.top  = e.y;
                }
                else {
                        obj.style.top  = document.body.scrollTop+e.y;
                }
}
else {
                obj.style.left = e.pageX-300;
                obj.style.top = e.pageY-10;
}
// ----- Close the ilayer
if (document.layers) {
        obj.visibility = "show";
}
else if (document.all) {
        obj.style.visibility = "visible";
}
else {
        obj.style.visibility = "visible";
}
}

// ----- Close function for color chooser without selection
function PcjsInternalClosePopup()
{
// ----- Select the ilayer
if (document.layers) {
        var obj = document.layers['PcjsPopup'];
obj.visibility = "hide";
}
else if (document.all) {
        var obj = document.all['PcjsPopup'];
        obj.style.visibility = "hidden";
}
else {
        var obj = document.getElementById('PcjsPopup');
        obj.style.visibility = "hidden";
}
}

// ----- Close function for color chooser with selection
function PcjsInternalSelectClose()
{
// ----- Select the ilayer
if (document.layers) {
        var obj = document.layers['PcjsPopup'];
}
else if (document.all) {
        var obj = document.all['PcjsPopup'];
}
else {
        var obj = document.getElementById('PcjsPopup');
}

// ----- Get the value and paste it to destination object
PcjsDestObject.value = document.forms.pcjsform.color.value;

// ----- Look for object type
eval("PcjsDestObject."+PcjsDestProperty+" = document.forms.pcjsform.color.value");

// ----- Close the ilayer

if (document.layers) {
        obj.visibility = "hide";
}
else if (document.all) {
obj.style.visibility = "hidden";
}
else {
        obj.style.visibility = "hidden";
}
makecolor(PcjsDestObject, PcjsDestLayer);
}

// ----- Internal color selection
function PcjsInternalSelectColor(color)
{
// ----- Paste the color value
document.forms.pcjsform.color.value = color.toUpperCase();

// ----- Change the color viewer
if (document.layers) {
        document.layers['pcjscell'].bgColor = color.toUpperCase();
        document.layers['id2000'].bgColor = color.toUpperCase();
}
else if (document.all) {
        document.all.pcjscell.style.background = color.toUpperCase();
        document.all.id2000.style.background = color.toUpperCase();
}
else {
        document.getElementById('pcjscell').style.background = color.toUpperCase();
        document.getElementById('id2000').style.background = color.toUpperCase();
}
makeinit();
}

// ----- Popup window creator
function PcjsGeneratePopup()
{
}

function nwindow()
{
nWindow = this.open('','','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=200');
}

// ----- Call the Color Chooser Popup Window generator function

// +- red green blue

function makeSubs(color) {
var colore = new String(color);
rnum1=hex2num(colore.substring(1,2).toUpperCase());
rnum2=hex2num(colore.substring(2,3).toUpperCase());
gnum1=hex2num(colore.substring(3,4).toUpperCase());
gnum2=hex2num(colore.substring(4,5).toUpperCase());
bnum1=hex2num(colore.substring(5,6).toUpperCase());
bnum2=hex2num(colore.substring(6,7).toUpperCase());
}
function makeNN(colore) {
//alert("bg="+document.getElementById('id2000').style.backgroundColor);
var ccc = colore;
//alert(ccc.length+ccc.indexOf(","));
ccc = ccc.substring(4,ccc.length-1);
var nred = ccc.substring(0,ccc.indexOf(','));
ccc = ccc.substring(ccc.indexOf(',')+1,ccc.length);
var ngreen = ccc.substring(0,ccc.indexOf(','));
ccc = ccc.substring(ccc.indexOf(',')+1,ccc.length);
var nblue = ccc;
//alert(red+"-"+green+"-"+blue);
rnum1 = Math.floor(nred/16);
rnum2 = nred%16;
gnum1 = Math.floor(ngreen/16);
gnum2 = ngreen%16;
bnum1 = Math.floor(nblue/16);
bnum2 = nblue%16;
}
function makeColorNN(colore) {
var ccc = colore;
//alert(ccc.length+ccc.indexOf(","));
ccc = ccc.substring(4,ccc.length-1);
var nred = ccc.substring(0,ccc.indexOf(','));
ccc = ccc.substring(ccc.indexOf(',')+1,ccc.length);
var ngreen = ccc.substring(0,ccc.indexOf(','));
ccc = ccc.substring(ccc.indexOf(',')+1,ccc.length);
var nblue = ccc;
//alert(red+"-"+green+"-"+blue);
rnum1 = Math.floor(nred/16);
rnum2 = nred%16;
gnum1 = Math.floor(ngreen/16);
gnum2 = ngreen%16;
bnum1 = Math.floor(nblue/16);
bnum2 = nblue%16;
return prefix+num2hex(rnum1)+num2hex(rnum2)+num2hex(gnum1)+num2hex(gnum2)+num2hex(bnum1)+num2hex(bnum2);
}

function makeChanges(type) {
if (type==1) {
var tempred = 0;
tempred = document.forms.pcjsform.rcolor.value;
if (tempred>255) {
        alert("Invalid color number!!!");
        return false;
}
rnum1 = Math.floor(tempred/16);
rnum2 = tempred%16;
hexNumber2 = prefix+num2hex(rnum1)+num2hex(rnum2)+num2hex(gnum1)+num2hex(gnum2)+num2hex(bnum1)+num2hex(bnum2);
if (document.layers) {
document.layers.pcjscell.bgColor = hexNumber2;
document.layers.id2000.bgColor = hexNumber2;
}
else if (document.all) {
document.all.id2000.style.background = hexNumber2;
document.all.pcjscell.style.background = hexNumber2;
}
else {
document.getElementById('id2000').style.background = hexNumber2;
document.getElementById('pcjscell').style.background = hexNumber2;
}
document.forms.pcjsform.color.value = hexNumber2;
document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
}

if (type==2) {
var tempgreen = 0;
tempgreen = document.forms.pcjsform.gcolor.value;
if (tempgreen>255) {
        alert("Invalid color number!!!");
        return false;
}
gnum1 = Math.floor(tempgreen/16);
gnum2 = tempgreen%16;
hexNumber2 = prefix+num2hex(rnum1)+num2hex(rnum2)+num2hex(gnum1)+num2hex(gnum2)+num2hex(bnum1)+num2hex(bnum2);

if (document.layers) {
document.layers.pcjscell.bgColor = hexNumber2;
document.layers.id2000.bgColor = hexNumber2;
}
else if (document.all) {
document.all.id2000.style.background = hexNumber2;
document.all.pcjscell.style.background = hexNumber2;
}
else {
document.getElementById('id2000').style.background = hexNumber2;
document.getElementById('pcjscell').style.background = hexNumber2;
}
document.forms.pcjsform.color.value = hexNumber2;
document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
}

if (type==3) {
var tempblue = 0;
tempblue = document.forms.pcjsform.bcolor.value;
if (tempblue>255) {
        alert("Invalid color number!!!");
        return false;
}
bnum1 = Math.floor(tempblue/16);
bnum2 = tempblue%16;
hexNumber2 = prefix+num2hex(rnum1)+num2hex(rnum2)+num2hex(gnum1)+num2hex(gnum2)+num2hex(bnum1)+num2hex(bnum2);
if (document.layers) {
document.layers.pcjscell.bgColor = hexNumber2;
document.layers.id2000.bgColor = hexNumber2;
}
else if (document.all) {
document.all.id2000.style.background = hexNumber2;
document.all.pcjscell.style.background = hexNumber2;
}
else {
document.getElementById('id2000').style.background = hexNumber2;
document.getElementById('pcjscell').style.background = hexNumber2;
}
document.forms.pcjsform.color.value = hexNumber2;
document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
}

if (type == 0) {
color = new String(document.forms.pcjsform.color.value);
rnum1=hex2num(color.substring(1,2).toUpperCase());
rnum2=hex2num(color.substring(2,3).toUpperCase());
gnum1=hex2num(color.substring(3,4).toUpperCase());
gnum2=hex2num(color.substring(4,5).toUpperCase());
bnum1=hex2num(color.substring(5,6).toUpperCase());
bnum2=hex2num(color.substring(6,7).toUpperCase());

document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
if (document.layers) {
document.layers.pcjscell.bgColor = color;
document.layers.id2000.bgColor = color;
}
else if (document.all) {
document.all.id2000.style.background = color;
document.all.pcjscell.style.background = color;
}
else {
document.getElementById('id2000').style.background = color;
document.getElementById('pcjscell').style.background = color;
}

}

}

function makeinit() {
if (document.layers) {
        color = document.layers['id2000'].bgColor;
}
else if (document.all) {
        color = document.all.id2000.style.background;
}
else {
        color = new String (makeColorNN(document.getElementById('id2000').style.backgroundColor));
}
rnum1=hex2num(color.substring(1,2).toUpperCase());
rnum2=hex2num(color.substring(2,3).toUpperCase());
gnum1=hex2num(color.substring(3,4).toUpperCase());
gnum2=hex2num(color.substring(4,5).toUpperCase());
bnum1=hex2num(color.substring(5,6).toUpperCase());
bnum2=hex2num(color.substring(6,7).toUpperCase());
document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
}

/*function changeBackground(hexNumber) {
document.bgColor=hexNumber
}*/

function num2hex(num) {
if (num==15) return "F";
else if (num==14) return "E";
else if (num==13) return "D";
else if (num==12) return "C";
else if (num==11) return "B";
else if (num==10) return "A";
else if (num==9) return "9";
else if (num==8) return "8";
else if (num==7) return "7";
else if (num==6) return "6";
else if (num==5) return "5";
else if (num==4) return "4";
else if (num==3) return "3";
else if (num==2) return "2";
else if (num==1) return "1";
else return "0";
}
function hex2num(num) {
if (num=="F") return 15;
else if (num=="E") return 14;
else if (num=="D") return 13;
else if (num=="C") return 12;
else if (num=="B") return 11;
else if (num=="A") return 10;
else if (num=="9") return 9;
else if (num=="8") return 8;
else if (num=="7") return 7;
else if (num=="6") return 6;
else if (num=="5") return 5;
else if (num=="4") return 4;
else if (num=="3") return 3;
else if (num=="2") return 2;
else if (num=="1") return 1;
else return 0;
}

function changeColor(number) {
if (document.layers) {
        makeSubs(document.layers.id2000.bgColor);
}
else if (document.all) {
        makeSubs(document.all.id2000.style.background);
}
else {
        //makeSubs(document.getElementById('id2000').style.background);
        makeNN(document.getElementById('id2000').style.backgroundColor);
}
//alert(rnum1);
if(number == 1) {
if ((rnum2 < 15) && (rnum1<15)) {
rnum2 += 1;
}
else {
        if ((rnum2 == 15) && (rnum1 <15)) {
                rnum1 += 1;
                rnum2 = 0;
        }
        if ((rnum2 == 15) && (rnum1 == 15)) {
                rnum1 = 0;
                rnum2 = 0;
        }
if ((rnum2 < 15) && (rnum1 == 15)) {
                rnum2 += 1;
        }
}
}

if(number == 2) {
if ((gnum2 < 15) && (gnum1<15)) {
gnum2 += 1;
}
else {
        if ((gnum2 == 15) && (gnum1 <15)) {
                gnum1 += 1;
                gnum2 = 0;
        }
        if ((gnum2 == 15) && (gnum1 == 15)) {
                gnum1 = 0;
                gnum2 = 0;
        }
if ((gnum2 < 15) && (gnum1 == 15)) {
                gnum2 += 1;
        }
}
}

if(number == 3) {
if ((bnum2 < 15) && (bnum1<15)) {
bnum2 += 1;
}
else {
        if ((bnum2 == 15) && (bnum1 <15)) {
                bnum1 += 1;
                bnum2 = 0;
        }
        if ((bnum2 == 15) && (bnum1 == 15)) {
                bnum1 = 0;
                bnum2 = 0;
        }
if ((bnum2 < 15) && (bnum1 == 15)) {
                bnum2 += 1;
        }
}
}

if(number == 4) {
if ((rnum2 > 0) && (rnum1>0)) {
rnum2 -= 1;
}
else {
        if ((rnum2 == 0) && (rnum1 ==0) ) {
                rnum1 = 15;
                rnum2 = 15;
        }
        if ((rnum2 == 0) && (rnum1 >0) ) {
                rnum1 -= 1;
                rnum2 = 15;
        }
        if ((rnum2 > 0) && (rnum1 ==0) ) {
                rnum2 -= 1;
        }

}
}

if(number == 5) {
if ((gnum2 > 0) && (gnum1>0)) {
gnum2 -= 1;
}
else {
        if ((gnum2 == 0) && (gnum1 ==0) ) {
                gnum1 = 15;
                gnum2 = 15;
        }
        if ((gnum2 == 0) && (gnum1 >0) ) {
                gnum1 -= 1;
                gnum2 = 15;
        }
        if ((gnum2 > 0) && (gnum1 ==0) ) {
                gnum2 -= 1;
        }

}
}

if(number == 6) {
if ((bnum2 > 0) && (bnum1>0)) {
bnum2 -= 1;
}
else {
        if ((bnum2 == 0) && (bnum1 ==0) ) {
                bnum1 = 15;
                bnum2 = 15;
        }
        if ((bnum2 == 0) && (bnum1 >0) ) {
                bnum1 -= 1;
                bnum2 = 15;
        }
        if ((bnum2 > 0) && (bnum1 ==0) ) {
                bnum2 -= 1;
        }

}
}

hexNumber2 = prefix+num2hex(rnum1)+num2hex(rnum2)+num2hex(gnum1)+num2hex(gnum2)+num2hex(bnum1)+num2hex(bnum2);
if (document.layers) {
        document.layers.id2000.bgColor = hexNumber2;
        document.layers.pcjscell.bgColor = hexNumber2;
}
else if (document.all) {
        document.all.id2000.style.background = hexNumber2;
        document.all.pcjscell.style.background = hexNumber2;
}
else {
        document.getElementById('id2000').style.background = hexNumber2;
        document.getElementById('pcjscell').style.background = hexNumber2;
}
document.forms.pcjsform.rcolor.value = rnum1*16+rnum2;
document.forms.pcjsform.gcolor.value = gnum1*16+gnum2;
document.forms.pcjsform.bcolor.value = bnum1*16+bnum2;
document.forms.pcjsform.color.value = hexNumber2;
}
function saviee() {
        document.layout.todo.value='save';
        document.layout.target='_self';
}
function prew() {
        document.layout.todo.value='preview';
        document.layout.target='_blank';
        document.layout.submit();
}
function makefields() {
                document.preview.custom_footer.value=document.myhome.footer.value;
                document.preview.custom_header.value=document.myhome.header.value;
                document.preview.custom_fontcolor.value=document.myhome.custom_fontcolor.value;
                document.preview.custom_fontface.value=document.myhome.custom_fontface.value;
                document.preview.custom_table_bgcolor.value=document.myhome.custom_table_bgcolor.value;
                document.preview.custom_maintitlebgcolor.value=document.myhome.custom_maintitlebgcolor.value;
                document.preview.custom_maintitlefontcolor.value=document.myhome.custom_maintitlefontcolor.value;
                document.preview.custom_desc_fontcolor.value=document.myhome.custom_desc_fontcolor.value;
                document.preview.custom_jobs_table_bgcolor.value=document.myhome.custom_jobs_table_bgcolor.value;
                document.preview.custom_table_header_color.value=document.myhome.custom_table_header_color.value;
                document.preview.custom_search_result_color.value=document.myhome.custom_search_result_color.value;
        return true;
}

function makecolor(myinput,tbl_id) {
                if ((isValidColor(myinput.value)==1) || (myinput.value.length<7)) {
                        alert("Invalid color " + myinput.value);
                        return false;
        }
                if (document.layers) {
                        document.layers[tbl_id].bgColor=myinput.value;
                }
                else if (document.all) {
                        document.all[tbl_id].style.background=myinput.value;
                }
                else {
                        document.getElementById(tbl_id).style.background=myinput.value;
                }
                return true;
}
function isValidColor(str)
{
// Return false if characters are not '0-9' or '.' .
for (var i = 0; i < str.length; i++)
{
var ch = str.substring(i, i + 1);
if ((ch < "0" || "9" < ch) && (ch < "a" || "f" < ch) &&  (ch < "A" || "F" < ch) && ch != '#')
        {
        return 1;
        }
}
return 0;
}