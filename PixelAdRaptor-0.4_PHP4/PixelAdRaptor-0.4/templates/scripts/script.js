/**
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
 
/**
 *
 * Function to open a new window
 * Replaces _target since it's not implemented in xhtml strict
 *
 */
function nw(link) {

    window.open(link.href);
    
    return false;
    
}


/**
 *
 * Grid handler
 * 
 */
function getPosition(e) {

    if(confirm('Are you sure this is the place you want your ad placed?')) {
        
        y_sub = document.getElementById("grid").offsetTop;
        
        if (!e) var e = window.event;
        
        if (e.pageX || e.pageY) {
        
            var x = e.pageX;
            var y = e.pageY;
        
        } else if (e.clientX || e.clientY) {
        
            var x = e.clientX;
            var y = e.clientY;
        
        }
                                
        if (((x / 10) % 10) != 0) {
         
            x = Math.floor(x / 10) + 1;
         
        }
        
        if (((y - y_sub) % 10) != 0) {
         
            y = Math.floor((y - y_sub) / 10) + 1;
         
        }        
        
        var gForm = document.getElementById("grid_form");
                       
        gForm.x.value = x;
        gForm.y.value = y;
        
        gForm.submit();
        
    }

}
/**
 *
 * Grid mouse tip coordinates. Unused atm.
 * 
 */
function gridCoord(e) {

    y_sub = document.getElementById("grid").offsetTop;

    if (!e) var e = window.event;
        
    if (e.pageX || e.pageY) {
        
        var x = e.pageX;
        var y = e.pageY;
        
    } else if (e.clientX || e.clientY) {
        
        var x = e.clientX;
        var y = e.clientY;
        
    }

    if (((x / 10) % 10) != 0) {
         
        x = Math.floor(x / 10) + 1;
         
    }
        
    if (((y - y_sub) % 10) != 0) {
         
        y = Math.floor((y - y_sub) / 10) + 1;
         
    }
        
    window.status = "[ " + x + " ; " + y + " ]";

}
 
/**
 *
 * FAQ handler
 */
function faq(id) {

    var el = document.getElementById(id);
    
	displayType = (el.style.display == "none")?"block":"none";

	el.style.display = displayType;

}

/**
 *
 * Buy handler. 
 * Method to calculate the price dynamicaly
 */
function calculate() {

    var width = document.getElementById("width").value;
    var height = document.getElementById("height").value;
    var price = document.getElementById("predefined_price").value;
    
    if (!isNaN(parseInt(width)) && !isNaN(parseInt(height))) {
    
        document.getElementById("width").value = parseInt(width);
        document.getElementById("height").value = parseInt(height);    
        
        document.getElementById("price_").innerHTML = "$" + parseInt(width) * parseInt(height) * price * 100; 
        document.getElementById("hidden_price").value = parseInt(width) * parseInt(height) * price * 100;
        
    } else {
    
        document.getElementById("price_").innerHTML = "Not calculated yet.";
    
    }

}