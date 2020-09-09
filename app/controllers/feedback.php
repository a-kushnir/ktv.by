<?php
$suppress_authorization = true;
include('../../lib/application.php');

function action_create()
{
  $to = 'info@ktv.by';
  $subject = 'Отправлено сообщение c www.ktv.by';
  $subject = "=?utf-8?b?". base64_encode($subject) ."?=";
  $message = "Телефон: ".$_POST['phone']."\nКомментарий:\n".$_POST['comment'];
  $headers = 'Content-type: text/plain; charset="utf-8"';
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
  mail($to, $subject, $message, $headers);
  
  flash_notice('Ваша заявка получена, спасибо!');
  
  redirect_to(base64_decode($_GET['back_url']));
}
?>