<?php

/* $destinatario = 'elcorreodepabloprieto@gmail.com';
$titulo = 'test correo';
$cuerpo = '<html><body><h1>Funciona!</h1></body></html>';
mail($destinatario,$titulo,$cuerpo); */


require_once "lib/TurboApiClient.php";

$titulo = 'test correo';
$cuerpo = '<html><body><h1>Funciona!</h1></body></html>';


$email = new Email();
$email->setFrom("pablo.makoki@gmail.com");
$email->setToList("elcorreodepabloprieto@gmail.com");
//$email->setCcList("dd@domain.com,ee@domain.com");
//$email->setBccList("ffi@domain.com,rr@domain.com");	
$email->setSubject($titulo);
$email->setContent($cuerpo);
$email->setHtmlContent("html content");
$email->addCustomHeader('X-FirstHeader', "value");
$email->addCustomHeader('X-SecondHeader', "value");
$email->addCustomHeader('X-Header-da-rimuovere', 'value');
$email->removeCustomHeader('X-Header-da-rimuovere');
$email->addAttachment('./files/turbosmtp.png');


$turboApiClient = new TurboApiClient("pablo.makoki@gmail.com", "_password");


$response = $turboApiClient->sendEmail($email);

var_dump($response);
