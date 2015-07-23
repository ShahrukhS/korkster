<?php
header('Access-Control-Allow-Origin: *');
$name = $_POST['name-contact'];
$email = $_POST['name-contact'];
$message = $_POST['name-contact'];

$to = 'WalknSell <info@avialdo.com>';
$subject = 'WalknSell Contact Form Response';
$headers = 'From: '.$name.' <'.email.'>' . "\r\n" .
    'Reply-To: '.$name.' <'.email.'>' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$flag = mail($to, $subject, $message, $headers);
if($flag){
    echo 'success';
}else{
    echo 'failed';
}
?>