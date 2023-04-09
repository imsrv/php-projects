<?php

# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: email.inc,v 1.4 2000/04/12 23:23:20 prenagha Exp $
# ---------------------------------------------------------------
# This class modified from the original at
# http://phpbuilder.px.sklar.com/code-pretty.html?code_id=233
#
/*******************************************************************************
  Name:      Email.inc
  Description:  This class is used for sending emails.  
      These emails can be
      Plain Text, HTML, or Both. Other uses include file 
      Attachments and email Templates(from a file).

  Example Usage:
    $mail->setTo("myEmail@yo.com");
    $mail->send();

*******************************************************************************/

class email_class
{
  //---Global Variables
  var $mailTo        = "";           // array of To addresses
  var $mailCC        = "";           // copied recipients
  var $mailBCC      = "";            // hidden recipients
  var $mailFrom      = "";           // from address
  var $mailSubject  = "";            // email subject
  var $mailAddlHdrs  = "";           // email additional headers
  var $mailText      = "";           // plain text message
  var $mailHTML      = "";           // html message
  var $mailAttachments  = "";        // array of attachments
  var $mailAttachmentsNice  = "";    // array of attachments nice names
  var $mimeBoundary = "";            // Boundary to separate mime parts

/*******************************************************************************
  Function:    setTo($inAddress)
  Description:  sets the email To address
  Arguments:    $inAddress as string
          separate multiple values with comma
  Returns:    true if set
*******************************************************************************/
  function setTo($inAddress){
    //--split addresses at commas
    $addressArray = explode(",",$inAddress);
    //--loop through each address and exit on error
    for($i=0;$i<count($addressArray);$i++){
      if($this->checkEmail($addressArray[$i])==false) return false;
    }
    //--all values are OK so implode array into string
    $this->mailTo = implode($addressArray,",");
    return true;
  }
/*******************************************************************************
  Function:    setCC($inAddress)
  Description:  sets the email cc address
  Arguments:    $inAddress as string
          separate multiple values with comma
  Returns:    true if set
*******************************************************************************/
  function setCC($inAddress){
    //--split addresses at commas
    $addressArray = explode(",",$inAddress);
    //--loop through each address and exit on error
    for($i=0;$i<count($addressArray);$i++){
      if($this->checkEmail($addressArray[$i])==false) return false;
    }
    //--all values are OK so implode array into string
    $this->mailCC = implode($addressArray,",");
    return true;
  }
/*******************************************************************************
  Function:    setBCC($inAddress)
  Description:  sets the email bcc address
  Arguments:    $inAddress as string
          separate multiple values with comma
  Returns:    true if set
*******************************************************************************/
  function setBCC($inAddress){
    //--split addresses at commas
    $addressArray = explode(",",$inAddress);
    //--loop through each address and exit on error
    for($i=0;$i<count($addressArray);$i++){
      if($this->checkEmail($addressArray[$i])==false) return false;
    }
    //--all values are OK so implode array into string
    $this->mailBCC = implode($addressArray,",");
    return true;
  }
/*******************************************************************************
  Function:    setFrom($inAddress)
  Description:  sets the email FROM address
  Arguments:    $inAddress as string (takes single email address)
  Returns:    true if set
*******************************************************************************/
  function setFrom($inAddress){
    if($this->checkEmail($inAddress)){
      $this->mailFrom = $inAddress;
      return true;
    }
    return false;
  }
/*******************************************************************************
  Function:    setSubject($inSubject)
  Description:  sets the email subject
  Arguments:    $inSubject as string
  Returns:    true if set
*******************************************************************************/
  function setSubject($inSubject){
    if(strlen(trim($inSubject)) > 0){
      $this->mailSubject = ereg_replace("\n","",$inSubject);
      return true;
    }
    return false;
  }
/*******************************************************************************
  Function:    setAddlHdrs($inAddlHdrs)
  Description:  sets the email additional headers
  Arguments:    $inAddlHdrs as string
  Returns:    true if set
*******************************************************************************/
  function setAddlHdrs($inAddlHdrs){
    if(strlen(trim($inAddlHdrs)) > 0){
      $this->mailAddlHdrs = $inAddlHdrs;
      return true;
    }
    return false;
  }
/*******************************************************************************
  Function:    setText($inText)
  Description:  sets the email text
  Arguments:    $inText as string
  Returns:    true if set
*******************************************************************************/
  function setText($inText){
    if(strlen(trim($inText)) > 0){
      $this->mailText = $inText;
      return true;
    }
    return false;
  }
/*******************************************************************************
  Function:    setHTML($inHTML)
  Description:  sets the email HMTL
  Arguments:    $inHTML as string
  Returns:    true if set
*******************************************************************************/
  function setHTML($inHTML){
    if(strlen(trim($inHTML)) > 0){
      $this->mailHTML = $inHTML;
      return true;
    }
    return false;
  }
/*******************************************************************************
  Function:    setAttachments($inAttachments)
  Description:  stores the Attachment string
  Arguments:    $inAttachments as string with directory included
                $inAttachmentsNiceName as string without directory and nice extension.
    the nice name is used because if you use the PHP upload filename, you loose
    the nice extension which helps us build the correct mime body.
          separate multiple values with comma
  Returns:    true if stored
*******************************************************************************/
  function setAttachments($inAttachmentsFileName, $inAttachmentsNiceName){
    if(strlen(trim($inAttachmentsFileName)) > 0){
      $this->mailAttachments     = $inAttachmentsFileName;
      $this->mailAttachmentsNice = $inAttachmentsNiceName;
      return true;
    }    
    return false;
  }
/*******************************************************************************
  Function:    checkEmail($inAddress)
  Description:  checks for valid email
  Arguments:    $inAddress as string
  Returns:    true if valid
*******************************************************************************/
  function checkEmail($inAddress){
    return (ereg( "^[^@ ]+@([a-zA-Z0-9\-]+\.)+([a-zA-Z0-9\-]{2}|net|com|gov|mil|org|edu|int)\$",$inAddress));
  }
/*******************************************************************************
  Function:    setRandomBoundry($offset)
  Description:  sets a random boundary
  Returns:    string
*******************************************************************************/
  function setRandomBoundary(){
    srand(time());
    $this->mimeBoundary = ("------MIME-PART-BOUNDARY-" . md5(rand()));
  }
  function getStartBoundary(){
    return ("--" . $this->mimeBoundary . "\n");
  }
  function getEndBoundary(){
    return ("--" . $this->mimeBoundary . "--" . "\n");
  }
/*******************************************************************************
  Function:    getContentType($inFileName)
  Description:  returns content type for the file type
  Arguments:    $inFileName as file name string (can include path)
  Returns:    string
*******************************************************************************/
  function getContentType($inFileName){
    //--strip path
    $inFileName = basename($inFileName);
    //--check for no extension
        if(strrchr($inFileName,".") == false){
      return "application/octet-stream";
    }
    //--get extension and check cases
        $extension = strrchr($inFileName,".");
        switch($extension){
            case ".doc":  return "application/msword";
            case ".gif":  return "image/gif";
            case ".gz":   return "application/x-gzip";
            case ".htm":  return "text/html";
            case ".html": return "text/html";
            case ".jpg":  return "image/jpeg";
            case ".tar":  return "application/x-tar";
            case ".txt":  return "text/plain";
            case ".zip":  return "application/zip";
            default:    return "application/octet-stream";
        }
    return "application/octet-stream";
  }
/*******************************************************************************
  Function:    formatTextHeader
  Description:  returns a formated header for text
  Arguments:    none
  Returns:    string
*******************************************************************************/
  function formatTextHeader(){
    $outTextHeader = "";
    $outTextHeader .= "Content-Type: text/plain; charset=us-ascii\n";
    $outTextHeader .= "Content-Transfer-Encoding: 7bit\n\n";
    $outTextHeader .= $this->mailText."\n";
    return $outTextHeader;
  }
/*******************************************************************************
  Function:    formatHTMLHeader
  Description:  returns a formated header for HTML
  Arguments:    none
  Returns:    string
*******************************************************************************/
  function formatHTMLHeader(){
    $outHTMLHeader = "";
    $outHTMLHeader .= "Content-Type: text/html; charset=us-ascii\n";
    $outHTMLHeader .= "Content-Transfer-Encoding: 7bit\n\n";
    $outHTMLHeader .= $this->mailHTML."\n";
    return $outHTMLHeader;
  }
/*******************************************************************************
  Function:    formatAttachmentHeader($inFileLocation)
  Description:  returns a formated header for an attachment
  Arguments:    $inFileLocation as string with relative directory
  Returns:    string
*******************************************************************************/
  function formatAttachmentHeader($inFileLocation, $inNiceFileName){
    $outAttachmentHeader = "";
    //--get content type based on file extension
    $contentType = $this->getContentType($inNiceFileName);

    //--get contents of attachment file
    $aFile = fopen($inFileLocation,"rb");
    $aFileContents = fread($aFile, 2000000);
    fclose($aFile);

    //--if content type is TEXT the standard 7bit encoding
    if(ereg("text",$contentType)){
      //--format header
      $outAttachmentHeader .= "Content-Type: ".$contentType.";\n";
      $outAttachmentHeader .= ' name="'.basename($inNiceFileName).'"'."\n";
      $outAttachmentHeader .= "Content-Transfer-Encoding: 7bit\n";
      $outAttachmentHeader .= "Content-Disposition: inline;\n";  //--other: inline
      $outAttachmentHeader .= ' filename="'.basename($inNiceFileName).'"'."\n\n";
      $outAttachmentHeader .= $aFileContents."\n";

    }
    //--NON-TEXT use 64-bit encoding
    else{
      //--format header
      $outAttachmentHeader .= "Content-Type: ".$contentType.";\n";
      $outAttachmentHeader .= ' name="'.basename($inNiceFileName).'"'."\n";
      $outAttachmentHeader .= "Content-Transfer-Encoding: base64\n";
      $outAttachmentHeader .= "Content-Disposition: inline;\n";  //--other: inline
      $outAttachmentHeader .= ' filename="'.basename($inNiceFileName).'"'."\n\n";
      $outAttachmentHeader .= chunk_split (base64_encode($aFileContents));
      $outAttachmentHeader .= "\n";
    }  
    return $outAttachmentHeader;
  }
/*******************************************************************************
  Function:    send()
  Description:  sends the email
  Arguments:    none
  Returns:    true if sent
*******************************************************************************/
  function send(){
#
# make sure we have something to send.
#
    if  (empty($this->mailText) 
     &&  empty($this->mailHTML) 
     &&  empty($this->mailAttachments) ) {
      return false;
    }

    //--set  mail header to blank
    $mailHeader = "";

    //--add CC
    if($this->mailCC != "") $mailHeader .= "cc: ".$this->mailCC."\n";

    //--add BCC
    if($this->mailBCC != "") $mailHeader .= "bcc: ".$this->mailBCC."\n";

    //--add From
    if($this->mailFrom != "") $mailHeader .= "From: ".$this->mailFrom."\n";

    //--add Addl Headers
    if(!empty($this->mailAddlHdrs)) $mailHeader .= $this->mailAddlHdrs."\n";

#
# if there are any attachments or html in the message,
# then we need to use MIME. Otherwise we'll just send
# old-fashioned text.
#
    if($this->mailText != "" && $this->mailHTML == "" && $this->mailAttachments == ""){
      return mail($this->mailTo,$this->mailSubject,$this->mailText,$mailHeader);
    }    

    
    else {

// see RFC2045, 2046, 2049  for MIME Specifications
// http://www.faqs.org/rfcs/rfc2045.html
      
      //--get random boundary for deliniating mime parts
      $this->setRandomBoundary();

      //--ADDL MIME MESSAGE HEADERS
      $mailHeader .= "MIME-Version: 1.0\n";
      $mailHeader .= "Content-Type: multipart/mixed;\n";
      $mailHeader .= ' boundary="'.$this->mimeBoundary.'"'."\n\n";


      // MESSAGE BODY START
      $mailHeader .= "This is a multi-part message in MIME format...\n";
      
      //--TEXT PART
      if (!empty($this->mailText)) {
        $mailHeader .= $this->getStartBoundary();
        $mailHeader .= $this->formatTextHeader();
      }

      //--HTML PART
      if (!empty($this->mailHTML)) {
        $mailHeader .= $this->getStartBoundary();
        $mailHeader .= $this->formatHTMLHeader();
      }

      //--ATTACHMENT PARTS
      if (!empty($this->mailAttachments)) {
        //--get array of attachment filenames
        $attachmentArray     = explode(",",$this->mailAttachments);
        $attachmentArrayNice = explode(",",$this->mailAttachmentsNice);

        //--loop through each attachment
        for($i=0;$i<count($attachmentArray);$i++){

          //--Add each attachment
          $mailHeader .= $this->getStartBoundary();
          $mailHeader .= $this->formatAttachmentHeader($attachmentArray[$i], $attachmentArrayNice[$i]);
        }
      }

      // FINAL MIME Boundry
      $mailHeader .= $this->getEndBoundary();

      // Send the message
      return mail($this->mailTo,$this->mailSubject,"",$mailHeader);
    }
  }
}
?>
