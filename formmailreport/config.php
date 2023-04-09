<?php
/**************************************************************
* Formmail Abuse Reporting - Version 1.1
*
* (C)Copyright 2002 Home-port.net, Inc. All Rights Reserved 
* By using this software you release Home-port.net, Inc. from 
* all liability relating to this product.
*
* This module is released under the GNU General Public License. 
* See: http://www.gnu.org/copyleft/gpl.html
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*
* For latest version, visit:
* http://www.home-port.net/formmail/
***************************************************************/

// Url to your images dirctory that has the question_warning.gif
   $question = "http://yourdomain.com/report_directory/images/question_warning.gif";

// Your company name
   $company = "Your_company_name";
   
// The Reply e-mail address you want to use in the complaint e-mails.
   $from2 = "you@yourdomain.com";

// Send a copy of the information to this address for your records. 
// If you want a different address than above. Place it here.
   $to2 = "$from2";     
   
/************************ All Done Here ***********************/
    
include("to.php");

include("func.php");

include("complaint.php");

?>
