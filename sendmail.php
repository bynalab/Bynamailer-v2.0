<?php
/**
 * BynaMailer.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/bynalab/Bynamailer-v2.4.0
 * @author Abubakar Abdusalam (bynalab) <algorithm290@gmail.com>
 * @copyright 2012 - 2014 Marcus Bointon
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 */

require_once 'PHPMailer-master/PHPMailerAutoload.php';
require 'PHPMailer-master/class.smtp.php';

$bynamailer = new PHPMailer(true);

$tos = $_POST['recipient'];
$subjects = $_POST['subject'];
$message = $_POST['message'];
//$bynaAttach = $_POST['bynaAttach'];
//$bynaAttachName = $_POST['bynaAttachName'];
$bynapostmaster = $_POST['bynapostmaster'];
$sender = $_POST['sender'];
$smtpserver = $_POST['smtpserver'];
$smtpuser = $_POST['smtpuser'];
$smtppass = $_POST['smtppass'];
$regard = "<br/>&copy; 2019 Office Service Center<br/>";

function smtp_exist($smtpserver, $smtpuser, $smtppass) {
    if(isset($smtpserver) && isset($smtpuser) && isset($smtppass)){
        if( !empty($smtpserver) && !empty($smtpuser) && empty($smtppass) ){
            return true;
        }
    } else {
        return false;
    }
}

try {

    //Server settings
    
    if( smtp_exist($smtpserver, $smtpuser, $smtppass) ){ 

        $bynamailer->SMTPDebug = 2;                                 
        $bynamailer->isSMTP();        
        $bynamailer->Host = $smtpserver;                   
        $bynamailer->SMTPAuth = true;                               
        $bynamailer->Username = $smtpuser;                        
        $bynamailer->Password = $smtppass;                          
        $bynamailer->SMTPSecure = 'tls';                           
        $bynamailer->Port = 587;    

    }                              
    
    //Recipients
    $bynamailer->setFrom($bynapostmaster, $sender);          
    $bynamailer->addReplyTo('no-reply@mail.org', 'No Reply');
    
    $bynamailer->addCustomHeader('Content-Type: text/html; charset=ISO-8859-1'. "\r\n");
    $bynamailer->addCustomHeader('Reply-To: No Reply <no-reply@jung.co.jp>'. "\n");
    $bynamailer->addCustomHeader('X-Priority: 3\n');
    $bynamailer->addCustomHeader('X-MSMail-Priority: Normal\n');
    $bynamailer->addCustomHeader("X-Mailer: ".$_SERVER["HTTP_HOST"]);
    $bynamailer->addCustomHeader('MIME-Version: 1.0' . "\r\n");
    $bynamailer->addCustomHeader('Return-Path: bounce-810_HTML-769869545-477063-1070564-43@bounce.email.oflce57578375.com'. "\r\n");
    $bynamailer->addCustomHeader('Message-ID: <5bc7d69b-b2f2-4b32-8f45-bf9030f9f684@HK2PR01MB1076.apcprd01.prod.exchangelabs.com>'. "\r\n");
    $bynamailer->addCustomHeader('From: check fro grace <morishige-kikai@www1346.sakura.ne.jp>'. "\r\n");
    $bynamailer->addCustomHeader('Content-Type: multipart/report; report-type=delivery-status; boundary="d9f4cc32-73bb-4b4c-b739-869e6235af8d"
    --d9f4cc32-73bb-4b4c-b739-869e6235af8d'. "\r\n");
    $bynamailer->addCustomHeader('Content-type: text/HTML; charset="UTF-8"; format=flowed; delsp=yes
    Content-Transfer-Encoding: bit7'. "\r\n");

    //Attachments
    //->addAttachment('/var/tmp/file.tar.gz');            

    
    $to = explode("\n", $tos);
    
    $countEmail = count($to);
    $countArray = 0;
    $over = 1;
    
while($to[$countArray])
{
    $mail = str_replace(array("\n","\r\n"),'',$to[$countArray]);
    $subject = preg_replace("/{byna}/", $mail, $subjects);	
    $message = preg_replace("/{byna}/", $mail, $message);
    $message = preg_replace("/{regard}/", $regard, $message);
    
    $bynamailer->addAddress($mail);
    
    //Content
    $bynamailer->isHTML(true);                                 
    $bynamailer->Subject = $subject;
    $bynamailer->Body    = $message;
    //$bynamailer->addAttachment('pen.jpg'); 

    $bynamailer->send();
    
$bynamailer->ClearAddresses();   
$countArray++;
$over++;

}

} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $bynamailer->ErrorInfo;
}


?>
