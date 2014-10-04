<?php
require_once('recaptchalib.php');
require_once('phpmailer/PHPMailerAutoload.php');
define("PRIVATE_KEY", "6LeVbvsSAAAAANuxOI902oq4zHowW-NwYmHeSm0N");
/**
 * Created by PhpStorm.
 * User: knobli
 * Date: 04.10.2014
 * Time: 10:40
 */

$response = recaptcha_check_answer(PRIVATE_KEY,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);

if (!$response->is_valid) {
    //die ("Das reCAPTCHA wurde nicht korrekt eingegeben. Geh zurück und versuch es erneut. (reCAPTCHA: " . $resp->error . ")");
}

if (!isset($_POST['name'], $_POST['password'], $_POST['email'], $_POST['web'], $_POST['date'], $_POST['prio'], $_POST['bugtype'], $_POST['text'], $_POST['reproducible'], $_FILES['picture'])) {
    die("INVALID_FORM");
}

if (($name = trim($_POST['name'])) == '' OR
    ($password = trim($_POST['password'])) == '' OR
    ($email = trim($_POST['email'])) == '' OR
    ($web = trim($_POST['web'])) == '' OR
    ($date = trim($_POST['date'])) == '' OR
    ($prio = trim($_POST['prio'])) == '' OR
    ($bugtype = trim($_POST['bugtype'])) == '' OR
    ($text = trim($_POST['text'])) == '' OR
    ($reproducible = trim($_POST['reproducible'])) == '' OR
    ($pictureName = trim($_FILES["picture"]["name"])) == ''
) {
    die("EMPTY_FORM");
}

if($_POST['password'] !== 'test'){
    die("Passwort stimmt nicht");
}

$recall='Nein';
if($_POST['recall']){
    $recall='Ja';
}

$mailRegex = '/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/';
if (!preg_match($mailRegex, $email)) {
    die("Mail Adresse stimmt nicht");
}

$urlRegex = '/^(http:\/\/www.|https:\/\/www.|www.){1}([0-9A-Za-z]+\.)/';
if (!preg_match($urlRegex, $web)) {
    die("Web Site stimmt nicht");
}

$pictureLocation = $_FILES['picture']['tmp_name'];
$targetFolder = "bugReport/";
list($errCode, $uploadName) = uploadFile($pictureLocation, $pictureName, $targetFolder);
if ($errCode == 0) {
    echo "Die Datei $uploadName wurde hoch geladen.<br>";
} else {
    die("Beim Hochladen ist leider ein Fehler aufgetretten");
}

$bugReport = "Name: " . $name . "<br>";
$bugReport .= "Web: " . $web . "<br>";
$bugReport .= "Date: " . $date . "<br>";
$bugReport .= "Priorität: " . $prio . "<br>";
$bugReport .= "Fehlertyp: " . $bugtype . "<br>";
$bugReport .= "Text: " . $text . "<br>";
$bugReport .= "Reproduzierbar: " . $reproducible . "<br>";
$bugReport .= "Recall: " . $recall . "<br>";
$bugReport .= "Bild: " . $uploadName . "<br>";

$bugReportForFile = preg_replace("/<br>/", "\r\n", $bugReport);
$bugReportFile = "bugReport_" . date("YmdHis") . ".txt";
file_put_contents($targetFolder . $bugReportFile, $bugReportForFile);

$mailText = "Der Fehlerbericht lautet wie folgt:<br>";
$mailText .= $bugReport;

$mail = new PHPMailer;
$mail->IsHTML(true);
$mail->SetFrom("info@knob.li", "PHP Module");
$mail->CharSet = 'utf-8';
$mail->addAddress($email, $name);
$mail->addAttachment($targetFolder . $uploadName);         // Add attachments

$mail->Subject = 'Bug Submission';
$mail->Body = $mailText;

if ($mail->send()) {
    echo 'Nachricht gesendet<br>';
} else {
    echo 'Nachricht konnnte nicht gesendet werden!<br>';
    echo $mail->ErrorInfo;
}

function uploadFile($fileLocation, $fileName, $targetFolder)
{
    if (file_exists($targetFolder)) {
        mkdir($targetFolder, true);
    }
    $fileName = replaceSpecialChars($fileName);
    $target = $targetFolder . $fileName;
    if (file_exists($target)) {
        $date = date("YmdHis");
        $renamingFileName = $date . $fileName;
        $renamingTarget = $targetFolder . $renamingFileName;
        rename($target, $renamingTarget);
        echo "Datei $fileName ist bereits vorhanden, alte Datei wird umbennent in $renamingFileName<br>";
    }
    return move_uploaded_file($fileLocation, $target) ? array(0, $fileName) : array(1, $fileName);
}

function replaceSpecialChars($string){
    $string=preg_replace(array("/ /", "/\//", "/ä/", "/ö/", "/ü/", "/é/", "/è/", "/ê/", "/à/", "/â/","/Ö/", "/Ä/", "/Ü/"), array("_", "_", "ae", "oe", "ue", "e", "e", "e", "a", "a", "Oe", "Ae", "Ue"), $string);
    return $string;
}