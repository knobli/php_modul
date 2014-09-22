<?php
require 'attachMailer.php';
require 'mail.php';
require 'helper.php';
require 'upload_class.php';

if(!isset($_POST['mail'])){
	$mail = 1;
} else {
	$mail = $_POST['mail'];
}

if(!isset($_POST['betreff'])){
	$betreff = "";
} else {
	$betreff = $_POST['betreff'];
}

if(!isset($_POST['inhalt'])){
	$inhalt = "";
} else {
	$inhalt = $_POST['inhalt'];
}

if(!isset($_POST['salutation'])){
	$salutation = false;
} else {
	$salutation = true;
}

$finalMailList=array();
if(!isset($_POST['ownMembers'])){
	$ownMembers = "";
} else {
	$ownMembers = $_POST['ownMembers'];
	if ($ownMembers != ""){
		$dummyMemberList = preg_split('/;/', $ownMembers);
		foreach($dummyMemberList as $mailAddress){
			$finalMailList[trim($mailAddress)]="dummy";
		}
	}
}


if (isset($_POST['submit']) && 'Versenden' == $_POST['submit'] ) {
		
	$submitValue = 1;
		
	if (count($finalMailList) == 0){
		?><div class="alert alert-error"><b>Kein Empfänger ausgewählt.</b></div><?php
		$submitValue=0;
	}
	if ($betreff == ""){
		?><div class="alert alert-error"><b>Kein Betreff angegeben.</b></div><?php
		$submitValue=0;
	}
	if ($inhalt == ""){
		?><div class="alert alert-error"><b>Kein Inhalt angegeben.</b></div><?php
		$submitValue=0;
	}
	
	if ($submitValue == 1){
		$attachments=array();
		$attachmentCounter=0;
		$attachmentFiledName="attachement0";
		if(!empty($_FILES[$attachmentFiledName]['tmp_name'])){
			$attachments[$attachmentCounter]['tmp_name']=$_FILES[$attachmentFiledName]['tmp_name'];
			$attachments[$attachmentCounter]['name']=$_FILES[$attachmentFiledName]['name'];
			$attachments[$attachmentCounter]['error']=$_FILES[$attachmentFiledName]['error'];
			$attachmentCounter++;			
		}
		$attachmentFiledName="attachement1";
		if(!empty($_FILES[$attachmentFiledName]['tmp_name'])){
			$attachments[$attachmentCounter]['tmp_name']=$_FILES[$attachmentFiledName]['tmp_name'];
			$attachments[$attachmentCounter]['name']=$_FILES[$attachmentFiledName]['name'];
			$attachments[$attachmentCounter]['error']=$_FILES[$attachmentFiledName]['error'];
			$attachmentCounter++;			
		}
		$attachmentFiledName="attachement2";
		if(!empty($_FILES[$attachmentFiledName]['tmp_name'])){
			$attachments[$attachmentCounter]['tmp_name']=$_FILES[$attachmentFiledName]['tmp_name'];
			$attachments[$attachmentCounter]['name']=$_FILES[$attachmentFiledName]['name'];
			$attachments[$attachmentCounter]['error']=$_FILES[$attachmentFiledName]['error'];
			$attachmentCounter++;			
		}		
		$mailSend=false;
		if(count($finalMailList) != 0){
			$mailObject = new Mail($finalMailList, $betreff, $inhalt, "Raffael Santschi", "raffael@santschi.ch");
			$mailObject->setAttachments($attachments);
			$mailObject->setSalutation($salutation);
			$mailSend=$mailObject->send();																			
		}
		if($mailSend){
			?><div class="alert alert-success"><b>Mail wurde versendet.</b></div><?php
			$submitValue=0;
		} else {
			?><div class="alert alert-error"><b>Fehler beim Versenden aufgetretten.</b></div><?php
		}
	}
}

?>

<form method="post" enctype="multipart/form-data" id="mailForm" action="">
<table style="width:auto;">
	<tr>
    	<td>Empf&auml;nger 
        </td>
        <td><textarea name="ownMembers" placeholder="Bitte Mailadressen mit ';' separiert angeben"><?php echo $ownMembers; ?></textarea>
        </td>
    </tr>    
	<tr>
    	<td>Betreff
        </td>
        <td><input type="text" name="betreff" size="100" value="<?php echo $betreff; ?>" />
        </td>
    </tr>
    <tr>
    	<td>autom. Floskeln</td>
    	<td><input type="checkbox" name="salutation" id="salutation" <?php if($salutation){echo "checked=\"checked\"";} ?> />
    	<script>
    	$('#salutation').change(function(){
    		if(this.checked){
    			$('#anrede').show();
    			$('#grusszeile').show();    			
    		} else {
    			$('#anrede').hide();
    			$('#grusszeile').hide();
    		}
		});
		</script>
    	</td>
    </tr>
	<tr id="anrede" <?php if(!$salutation){echo "style=\"display: none;\"";} ?> >
    	<td>Begrüssung
        </td>
        <td><input type="text" disabled="true" name="betreff" size="100" value="Hoi ..." />
        </td>
    </tr>
	<tr>
    	<td>Inhalt
        </td>
        <td>
        	<textarea name="inhalt" id="inhalt" cols="200" class="field span6" rows="10"><?php echo $inhalt; ?></textarea> 
        </td>
    </tr>
	<tr id="grusszeile" <?php if(!$salutation){echo "style=\"display: none;\"";} ?>>
    	<td>Floskel
        </td>
        <td><input type="text" disabled="true" name="betreff" size="100" value="Turner Gruss" />
        </td>
    </tr>
    <tr>
    	<td>Anhang 1</td>
    	<td><input type="file" name="attachement0" /></td>
    </tr>
    <tr>
    	<td>Anhang 2</td>
    	<td><input type="file" name="attachement1" /></td>
    </tr>
    <tr>
    	<td>Anhang 3</td>
    	<td><input type="file" name="attachement2" /></td>
    </tr>        
	<tr>
    	<td>
        </td>
        <td>
        	<input type="submit" name="submit" value="Versenden" />
        </td>
    </tr>
</table>
</form>
