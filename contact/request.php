<?php


include 'config.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{

$name1 = stripslashes($_POST['name1']);
$name2 = stripslashes($_POST['name2']);
$email = trim($_POST['email']);
$subject = "Request download";
$message = "Name : ".$name1." ".$name2."\r\nEmail : ".$email."";

$error = '';



if(!$error)
{
$mail = mail(WEBMASTER_EMAIL, $subject, $message,
     "From: ".$name1." ".$name2." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());


if($mail)
{
echo 'OK';
}

}


}
?>