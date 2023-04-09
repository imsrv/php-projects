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
 * Method to add <b></b> tags to the element
 */
function addBold(id) {

    document.getElementById(id).value += "<b></b>";
    document.getElementById(id).focus();
    
}

/**
 *
 * Method to add <i></i> tags to the element
 */
function addItalic(id) {

    document.getElementById(id).value += "<i></i>";
    document.getElementById(id).focus();

}

/**
 *
 * Method to add <u></u> tags to the element
 */
function addUnderline(id) {

    document.getElementById(id).value += "<u></u>";
    document.getElementById(id).focus();

}