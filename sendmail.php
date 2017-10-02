<?php
/**
 * BynaMailer.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Abubakar Abdusalam (bynalab) <algorithm290@gmail.com>
 * @copyright 2012 - 2014 Marcus Bointon
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 */

require_once 'PHPMailer-master/PHPMailerAutoload.php';

$to = $_POST['recipient'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$bynaAttach = $_POST['bynaAttach'];
$bynaAttachName = $_POST['bynaAttachName'];
$bynapostmaster = $_POST['bynapostmaster'];
$sender = $_POST['sender'];
$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";  
$headers .= "From: $sender <$bynapostmaster>"."\n";
$headers.= "Reply-To: No Reply <no-reply@mail.org>". "\n";
$headers .= "X-Priority: 3\n";
$headers .= "X-MSMail-Priority: Normal\n";
$headers .= "X-Mailer: ".$_SERVER["HTTP_HOST"];

$bynamailer = new PHPMailer;

$bynamailer->addAttachment($bynaAttach, $bynaAttachName);

if (empty($to)){
    echo 'Input atleast 1 Recipient';
}

elseif (empty ($subject)) {
    echo 'Please input a subject';
}

elseif (empty ($message)) {
    echo 'Input atleast  an alphabet in the message field';
}

elseif (empty ($_POST['sender'])) {
    echo "Sender's name is required";
}

if(!isset($_GET['c']))
{
	$to = explode("\n", $to);
}else{
	$to = explode(",", $to);
}

$countEmail = count($to);
$countArray = 0;
$over = 1;

while($to[$countArray])
{
    
    $mail = str_replace(array("\n","\r\n"),'',$to[$countArray]);
    $subject = preg_replace("%byna%", $mail, $subject);	
    $message1 = preg_replace("%byna%", $mail, $message);
    $mail_sent = mail($mail, $subject, $message1, $headers);
    

echo $mail_sent ? "<font color=green face=verdana size=2>BynaMailer successfully sent to ".trim($mail)." (".$over." OF ".$countEmail.") <br>\n" : "<font color=red face=verdana size=2>Oops! BynaMailer thinks there was a problem sending your mails to ".trim($mail)."... Please go back and resend your mails. <br>\n";
    
$countArray++;
$over++;

}




?>