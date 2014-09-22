<?php
class Mail{
	
	const CONST_TYPE_MEMBER_ID = "memberid";
	const CONST_TYPE_MAIL = "email";
	
	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	private $entityManager;	
	
	private $mailAddresses;
	private $receiverSurname;
	private $subject;
	private $message;
	private $senderName;
	private $senderMail;
	
	/*
	 * not mandatory: default values
	 */
	private $attachements = array();
	private $replaceReturns = true;
	private $salutation = true;
	private $sendCC = true;
	
	public function __construct($members, $subject, $message, $sender, $senderMail) {
		$this->setMailAddresses($members);
		$this->subject = $subject;
		$this->message = $message;
		$this->setSender($sender, $senderMail);
	}	
	
	public function getMailAddresses(){
		return $this->mailAddresses;
	}
	  
	public function setMailAddresses($members){
		if(is_array($members)){
			$this->receiverSurname = "z&auml;me";	
			foreach($members as $tmpMail => $dummy){
				if($this->mailAddresses == ""){
					$this->mailAddresses = "$tmpMail";
				} else {
					$this->mailAddresses .= ", $tmpMail";
				}
			}
		} else {
			$this->mailAddresses = $members;
		}
	}

	public function getSubject(){
		return $this->subject;
	}
	
	public function setSubject($subject){
		$this->subject = $subject;
	}	
	
	public function getMessage(){
		return $this->message;
	}
	
	public function setMessage($message){
		$this->message = $message;
	}										

	public function getSender(){
		return $this->sender;
	}
	
	public function setSender($sender, $senderMail){
		$this->senderName = $sender;
		$this->senderMail = $senderMail;
	}	
	
	public function addAttachment($attachment){
		$this->attachements[] = $attachment;
	}
	
	public function setAttachments($attachments){
		if($attachments != ""){
			$this->attachements = $attachments;
		}	
	}
	
	public function getAttachments(){
		return $this->attachements;
	}
	
	public function setReplaceReturns($bool){
		$this->replaceReturns = $bool;
	}
	
	public function isReplaceReturns(){
		return $this->replaceReturns;
	}
	
	public function setSalutation($bool){
		$this->salutation = $bool;
	}
	
	public function hasSalutation(){
		return $this->salutation;
	}	
	
	public function setSendCC($bool){
		$this->sendCC = $bool;
	}
	
	public function hasSendCC(){
		return $this->sendCC;
	}		
	
	public function send(){
		$message=$this->message;
		
		$finalMessage = "<html><head>";
		$finalMessage .= "<meta charset=\"UTF-8\" />";
		$finalMessage .= "</head>";
		$finalMessage .= "<body>";
		$finalMessage .= "<div style=\"font-family:arial;font-size:11pt;\">";
		if(!empty($this->salutation)){
			$finalMessage .= "Hoi " . $this->receiverSurname . "<br><br>";
		}
		$finalMessage .= "$message<br>";
		if(!empty($this->salutation)){
			$finalMessage .= "<br>Turner Gruss<br>" . $this->senderName . "<br>";
		}		
		$finalMessage .= "</div>";		
		$finalMessage .= "</body></html>";
		
		if(count($this->attachements) == 0){
			return $this->sendMailWithoutAttachment($finalMessage);
		} else {	
			return $this->sendMailWithAttachment($finalMessage);
		}
	}	

	private function sendMailWithoutAttachment($finalMessage){
		
		$header="MIME-Version: 1.0\r\n"; 
		$header.="Content-type: text/html; charset=utf-8\r\n";
		$header.="From: " . $this->senderName . " <" . $this->senderMail . ">\r\n"; 
		if($this->sendCC){
			$header.="Cc: " . $this->senderName . " <" . $this->senderMail . ">\r\n";
		} 

		$ret=mail($this->mailAddresses, $this->subject, $finalMessage, $header);

	    return (bool)$ret;			
	}

	private function sendMailWithAttachment($finalMessage){	
	    $errorDedected=0;
		$error = "";
		$ccMail='';
		if($this->sendCC){
			$ccMail="" . $this->senderName . " <" . $this->senderMail . ">";
		} 
		$my_mail = new AttachMailer($this->senderName, $this->senderMail, $this->mailAddresses, $ccMail, '', $this->subject);
		$my_mail->setHtmlBody($finalMessage);
		$num_files = count($this->attachements);
		for ($i = 0; $i < $num_files; $i++) {
			if ($this->attachements[$i]['name'] != '' && empty($this->attachements[$i]['ALREADYUPLOADED'])) {
	
				$my_upload = new file_upload;
				$my_upload->upload_dir = dirname(__FILE__)."/mailfiles/"; 
				$my_upload->extensions = array(".png", ".jpg", ".gif", ".doc", ".docx", ".xls", ".xlsx", ".pdf", ".txt"); 
				$my_upload->the_temp_file = $this->attachements[$i]['tmp_name'];
				$my_upload->the_file = $this->attachements[$i]['name'];
				$my_upload->http_error = $this->attachements[$i]['error'];
				$my_upload->replace = "y"; 
				if ($my_upload->upload()) { 
					$full_path = $my_upload->upload_dir.$my_upload->file_copy;
					$my_mail->add_attach_file($full_path);
					$error .= 'File &quot;'.$my_upload->file_copy.'&quot; uploaded<br />';
				} else {
					$error = 'Error uploading file(s): ' . $my_upload->show_error_string();
					$errorDedected = 1;
					break;
				}
			} else if ($this->attachements[$i]['name'] != '' && $this->attachements[$i]['ALREADYUPLOADED'] != "") {
				$my_mail->add_attach_file(dirname(__FILE__). "/" . $this->attachements[$i]['name']);
			}
		}
		
		if($errorDedected == 0){
			if ($my_mail->process_mail()) {
				return true;
			} else {
				echo $my_mail->get_msg_str();
				return false;
			}
		} else {
			echo $my_mail->get_msg_str();
			echo $error;
			return false;
		}		
	}
      
}
?>