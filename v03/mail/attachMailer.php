<?php
/*
Attachment Mailer class - version 1.20
PHP class handles multiple attachment e-mails using the mime mail standard

Copyright (c) 2006, Olaf Lederer
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, 
	are permitted provided that the following conditions are met:

    * Redistributions of source code must retain the above copyright notice, 
  		this list of conditions and the following disclaimer.
    * Redistributions in binary form must reproduce the 
  		above copyright notice, this list of conditions and the following disclaimer 
  		in the documentation and/or other materials provided with the distribution.
    * Neither the name of the finalwebsites.com nor the names 
 		of its contributors may be used to endorse or promote products derived 
  		from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF 
	MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE 
 	COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 	OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
 	WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN 
 	ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

_________________________________________________________________________
available at http://www.finalwebsites.com/snippets.php?id=41
Comments & suggestions: http://www.finalwebsites.com/forums/forum/php-classes-support-forum

*************************************************************************

Updates / bugfixes

Ver. 1.01 - The new example demonstrates how to use this class together with some php upload functionality. 
 		This example form / script needs an object of the Easy Upload class available on finalwebsites.com.

ver 1.02 - The process_mail() method returns a boolean now to give more information to a 
 		possible next step inside an application. There was a small bug inside the upload_and_mail_example.php file. 
 		The delete file object must be changed to act with file upload class.

ver 1.03 - I noticed there is sometimes a problem with the mail function and the return path. 
 		Some mail servers need a valid notation if the mail can't be deliverd. I added the "-f" 
 		option to the process_mail method.

ver. 1.20 - Since this version the class is changed into a full featured html mailer class incl. 
 		html mail + (inline) attachments, alternative text format, inline attachments mixed with 
 		external attachments and much more. Most methods are changed and the structure how an objects is defined 
 		is updated, too. You need to update formerly mail scripts, check the updated documentation.
*/

define("LIBR", "\n"); // use a "\r\n" if you have problems
define("PRIORITY", 3); // 3 = normal, 2 = high, 4 = low
define("TRANS_ENC",	"7bit");
define("ENCODING", "utf-8");


class AttachMailer {
	
	const UID = 0;
	const ALTERNATIVE = 1;
	const RELATED = 2;
	const MESSAGE = 3;
	
	private $from;
	private $mail_to;
	private $mail_cc;
	private $mail_bcc;
	private $webmaster_email = "info@grafstal.ch";
	
	private $mail_subject;
	private $text_body = "";
	private $html_body = "";
	
	private $ids = array("", "", "", ""); // the unique value for the mail boundry
	
	private $html_images = array();
	private $att_files = array();
	
	private $msg = array();
	
	// functions inside this constructor
	// - validation of e-mail adresses
	// - setting mail variables
	public function __construct($name, $from, $to, $cc = "", $bcc = "", $subject = "") {
		$from_name = Helper::stripLineBreaks($name);
		$from_mail = Helper::stripLineBreaks($from);
		if ($from_name != "") {
			$this->from =  $from_name." <". $from_mail.">";
		} else {
			$this->from =  $from_mail;
		}			
		$this->mail_to = Helper::stripLineBreaks($to);
		$this->mail_cc = Helper::stripLineBreaks($cc);
		$this->mail_bcc = Helper::stripLineBreaks($bcc);
		$this->mail_subject = Helper::stripLineBreaks($subject);	
	}
	
	function get_file_data($filepath) {
		if (file_exists($filepath)) {
			if (!$str = file_get_contents($filepath)) {
				$this->msg[] = "Error while opening attachment \"".basename($filepath)."\"";
			} else {
				return $str;
			}
		} else {
			$this->msg[] = "Error, the file \"".basename($filepath)."\" does not exist.";
			return;
		}
	}
	
	// use for $dispo "attachment" or "inline" (f.e. example images inside a html mail)
	function add_attach_file($file, $encoding = "base64", $dispo = "attachment", $type = "application/octet-stream") {
		$file_str = $this->get_file_data($file);
		if ($file_str == "") {
			return;
		} else {
			if ($encoding == "base64"){
				$file_str = base64_encode($file_str);
			}
			$this->att_files[] = array(
				"data"=>chunk_split($file_str),
				"name"=>basename($file), 
				"cont_type"=>$type, 
				"trans_enc"=>$encoding,
				"disposition"=>$dispo);
			
		}
	}
	
	function add_html_image($img_name) {
		$file_str = $this->get_file_data($img_name);
		$img_dim = getimagesize($img_name);
		if ($file_str == "") {
			return;
		} else {
			$this->html_images[] = array(
				"data"=>chunk_split(base64_encode($file_str)),
				"name"=>basename($img_name), 
				"cont_type"=>$img_dim['mime'],
				"cid"=>md5(uniqid(time()))."@".$_SERVER['SERVER_NAME']);
		}
	}

	function create_stand_headers() {
		$headers = "From: ".$this->from.LIBR;
		$headers .= "Reply-To: ".$this->from.LIBR;
		if ($this->mail_cc != ""){
			$headers .= "Cc: ".$this->mail_cc.LIBR;
		}
		if ($this->mail_bcc != ""){
			$headers .= "Bcc: ".$this->mail_bcc.LIBR;
		}
		$headers .= sprintf("Message-ID: <%s@%s>%s", $this->getMessageId(), $_SERVER['SERVER_NAME'], LIBR);
		$headers .= "X-Priority: ".PRIORITY.LIBR;
		$headers .= "X-Mailer: Attachment Mailer [version 1.2]".LIBR;
		$headers .= "MIME-Version: 1.0".LIBR;
		return $headers;
	}
	
	function create_html_image($img_array) {
		$img = "Content-Type: ".$img_array['cont_type'].";".LIBR.chr(9)." name=\"".$img_array['name']."\"".LIBR;
		$img .= "Content-Transfer-Encoding: base64".LIBR;
		$img .= "Content-ID: <image".$img_array['cid'].">".LIBR;
		$img .= "Content-Disposition: inline;".LIBR.chr(9)." filename=\"".$img_array['name']."\"".LIBR.LIBR;
		$img .= $img_array['data'];
		return $img;		
	}
	
	function create_attachment($data_array) {
		$att = "Content-Type: ".$data_array['cont_type'].";".LIBR.chr(9)." name=\"".$data_array['name']."\"".LIBR;
		$att .= "Content-Transfer-Encoding: ".$data_array['trans_enc'].LIBR;
		$att .= "Content-Disposition: ".$data_array['disposition'].";".LIBR.chr(9).
					" filename=\"".$data_array['name']."\"".LIBR.LIBR;
		$att .= $data_array['data'];
		return $att;		
	}
	
	function create_html_body() {
		$html = "Content-Type: text/html; charset=".ENCODING.LIBR;
		$html .= "Content-Transfer-Encoding: ".TRANS_ENC.LIBR.LIBR;
		foreach ($this->html_images as $img) {
			$this->html_body = str_replace($img['name'], "cid:image".$img['cid'], $this->html_body);
		}
		$html .= $this->html_body;
		return $html.LIBR.LIBR;
	}
	
	public function getHeaderInformationsForAttachments(){
		$headers = "Content-Type: multipart/mixed;".LIBR.chr(9)." boundary=\"".$this->getUID()."\"".LIBR.LIBR;
		$headers .= "This is a multi-part message in MIME format.".LIBR;
		return $headers;		
	}
	
	public function getAttachmentsAsString(){
		$string="";
		foreach ($this->att_files as $att) {
			$string .= "--".$this->getUID().LIBR;
			$string .= $this->create_attachment($att);
		}
		$string .= "--".$this->getUID()."--";
		return $string;		
	}
	
	function build_message() {
		$this->headers = $this->create_stand_headers();
		$msg = "";
		$has_attachment = (count($this->att_files) > 0) ? true : false;
		if ($has_attachment) {
			$this->headers .= $this->getHeaderInformationsForAttachments();
		}
		 
		$is_html = ($this->html_body != "") ? true : false;
		if($is_html){
			$msg = $this->buildHtmlMessageText($has_attachment);
		} else {
			$msg = $this->buildMessageText($has_attachment);
		} 	
			
		if ($has_attachment) {
			$msg .= $this->getAttachmentsAsString();
		}
		return $msg;		
	}
	
	function buildMessageText($has_attachment){
		$msg="";
		$body_head = "Content-Type: text/plain; charset=".ENCODING."; format=flowed".LIBR;
		$body_head .= "Content-Transfer-Encoding: ".TRANS_ENC.LIBR.LIBR;
		if ($has_attachment) {
			$msg .= "--".$this->getUID().LIBR;
			$msg .= $body_head;
		} else {
			$this->headers .= $body_head;
		}
		$msg .= trim($this->text_body).LIBR.LIBR;
		return $msg;		
	}
	
	function buildHtmlMessageText($has_attachment) {
		$msg = "";
		$has_images = (count($this->html_images) > 0) ? true : false;
		if ($has_attachment) {
			$this->headers .= "--".$this->getUID().LIBR;
		}
		$this->headers .= "Content-Type: multipart/alternative;".LIBR.chr(9).
							" boundary=\"".$this->getAlternativeUID()."\"".LIBR.LIBR;
		if (!$has_attachment) {
			$this->headers .= "This is a multi-part message in MIME format.".LIBR;
		}
		$msg .= LIBR."--".$this->getAlternativeUID().LIBR;
		$body_head = "Content-Type: text/plain; charset=".ENCODING."; format=flowed".LIBR;
		$body_head .= "Content-Transfer-Encoding: ".TRANS_ENC.LIBR.LIBR;
		$msg .= $body_head;
		$msg .= trim($this->text_body).LIBR.LIBR;
		$msg .= "--".$this->getAlternativeUID().LIBR;
		if ($has_images) {
			$msg .= "Content-Type: multipart/related;".LIBR.chr(9).
						" boundary=\"".$this->getRelatedUID()."\"".LIBR.LIBR.LIBR;
			$msg .= "--".$this->getRelatedUID().LIBR;
			$msg .= $this->create_html_body();
			foreach ($this->html_images as $img) {
				$msg .= "--".$this->getRelatedUID().LIBR;
				$msg .= $this->create_html_image($img);
			}
			$msg .= LIBR."--".$this->getRelatedUID()."--";
		} else {
			$msg .= $this->create_html_body();
		}
		$msg .= LIBR.LIBR."--".$this->getAlternativeUID()."--".LIBR.LIBR;
		return $msg;		
	}	
	
	function process_mail() {
		$msg = $this->build_message(); 
		if (mail($this->mail_to, $this->mail_subject, $msg, $this->headers, "-f".$this->webmaster_email)) {
			$this->msg[] = "Your mail is succesfully submitted.";
			return true;
		} else {
			$this->msg[] = "Error while sending you mail.";
			return false;
		}
	}
	
	public function setTextBody($textBody){
		$this->text_body = $textBody;
	}
	
	public function setHtmlBody($htmlBody){
		$this->html_body = $htmlBody;
	}
	
	public function getUID(){
		if($this->ids[self::UID] == ""){
			$this->ids[self::UID] = md5(uniqid(time()));
		}
		return $this->ids[self::UID];
	}
	
	public function getAlternativeUID(){
		if($this->ids[self::ALTERNATIVE] == ""){
			$this->ids[self::ALTERNATIVE] = md5(uniqid(time()));
		}
		return $this->ids[self::ALTERNATIVE];
	}
	
	public function getRelatedUID(){
		if($this->ids[self::RELATED] == ""){
			$this->ids[self::RELATED] = md5(uniqid(time()));
		}
		return $this->ids[self::RELATED];
	}	
	
	public function getMessageId(){
		if($this->ids[self::MESSAGE] == ""){ 
			$this->ids[self::MESSAGE] = md5(uniqid(time()));
		}
		return $this->ids[self::MESSAGE];
	}	
}
	
?>