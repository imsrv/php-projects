<?php

	/*
		 SendStudio PHP Version: 4.0 - 17 November 2003
		 Copyright © 2003 Interspire (Instanse Pty. Ltd. + InterSpire Pty. Ltd.)
		 All Rights Reserved
		
		 THIS COPYRIGHT INFORMATION MUST REMAIN INTACT
		 AND MAY NOT BE MODIFIED IN ANY WAY
		
		 When you purchased this script you agreed to accept the terms
		 of this Agreement. This Agreement is a legal contract, which
		 specifies the terms of the license and warranty limitation between
		 you and 'InterSpire'. You should carefully read the following
		 terms and conditions before installing or using this software.
		 Unless you have a different license agreement obtained from
		 'SendStudio.com' or 'InterSpire', installation or use of this 
		 software indicates your acceptance of the license and warranty
		 limitation terms contained in this Agreement.
		 If you do not agree to the terms of this Agreement, promptly delete
		 and destroy all copies of the Software.
		
		 Versions of the Software
		 Only one licenced copy of SendStudio may be used on one web site.
		
		 License to Redistribute
		 Distributing the software and/or documentation with other products
		 (commercial or otherwise) by any means without prior written 
		 permission from 'SendStudio.com' or 'InterSpire' is forbidden.
		 All rights to the SendStudio software and documentation not expressly
		 granted under this Agreement are reserved to 'InterSpire'.
		
		 Disclaimer of Warranty
		 THIS SOFTWARE AND ACCOMPANYING DOCUMENTATION ARE PROVIDED "AS IS" 
		 AND WITHOUT WARRANTIES AS TO PERFORMANCE OF MERCHANTABILITY OR ANY 
		 OTHER WARRANTIES WHETHER EXPRESSED OR IMPLIED.   BECAUSE OF THE 
		 VARIOUS HARDWARE AND SOFTWARE ENVIRONMENTS INTO WHICH SENDSTUDIO 
		 MAY BE USED, NO WARRANTY OF FITNESS FOR A PARTICULAR PURPOSE IS 
		 OFFERED.  THE USER MUST ASSUME THE ENTIRE RISK OF USING THIS 
		 PROGRAM.  ANY LIABILITY OF 'INTERSPIRE' WILL BE LIMITED 
		 EXCLUSIVELY TO PRODUCT REPLACEMENT OR REFUND OF PURCHASE PRICE.
		 IN NO CASE SHALL 'SENDSTUDIO.COM' OR 'INTERSPIRE' BE LIABLE FOR 
		 ANY INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES OR LOSS, INCLUDING, 
		 WITHOUT LIMITATION, LOST PROFITS OR THE INABILITY TO USE EQUIPMENT 
		 OR ACCESS DATA, WHETHER SUCH DAMAGES ARE BASED UPON A BREACH OF 
		 EXPRESS OR IMPLIED WARRANTIES, BREACH OF CONTRACT, NEGLIGENCE, 
		 STRICT TORT, OR ANY OTHER LEGAL THEORY.
		 THIS IS TRUE EVEN IF 'SENDSTUDIO.COM' OR 'INTERSPIRE' IS ADVISED 
		 OF THE POSSIBILITY OF SUCH DAMAGES. IN NO CASE WILL 'SENDSTUDIO.COM' 
		 OR 'INTERSPIRE'S LIABILITY EXCEED THE AMOUNT OF THE LICENSE 
		 FEE ACTUALLY PAID BY LICENSEE TO 'SENDSTUDIO.COM' OR 'INTERSPIRE'.
		
		 Warning: This program is protected by copyright law. Unauthorized 
		 reproduction or distribution of this program, or any portion of it,
		 may result in severe civil and criminal penalties, and will be
		 prosecuted to the maximum extent possible under the law.
		
		 Credits:
		 Mitchell Harper - Concept, Logic Design, Programming, Implementation, GUI
		 Eddie Machaalani - Layout + Logo Design, Useability Testing
		
		 For more information about this script or other scripts see
		 http://www.sendstudio.com
		
		 Thank you for purchasing our script.
		 If you have any suggestions or ideas please direct them to 
		 info@sendstudio.com
	*/

	// Simply redirect to the admin folder
	$adminFolder = @str_replace("index.php", "admin", @$_SERVER["PHP_SELF"]);
	header("location: " . str_replace("//", "/", $adminFolder . "/index.php"));

?>