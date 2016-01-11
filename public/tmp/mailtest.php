<?php

define('CONST_DOCROOT',$_SERVER['DOCUMENT_ROOT']);
$DocRootSlash = substr($_SERVER['DOCUMENT_ROOT'],-1) === '/' ? '' : '/';
define('DIR_DOCROOT',$_SERVER['DOCUMENT_ROOT'].$DocRootSlash);
define('DIR_PROTECTED',DIR_DOCROOT.'../protected/');
define('DIR_INCLUDE',DIR_PROTECTED.'include/');
define('DIR_LIBRARY',DIR_INCLUDE.'library/');
require_once(DIR_LIBRARY.'swiftmailer-5.0.2/lib/swift_required.php');

$From = 'andmos@gmail.com';
$To = 'amoschou@gmail.com';


$Transport = Swift_SmtpTransport::newInstance()
  ->setHost('smtp.gmail.com')
  ->setPort('465')
  ->setEncryption('ssl')
  ->setUsername('andmos@gmail.com')
  ->setPassword('ttrezhjcrurgvlaq');
$Mailer = Swift_Mailer::newInstance($Transport);
$Message = Swift_Message::newInstance()
  ->setSubject('Subject 1')
  ->setFrom(array("$From" => "Andrew Moschou"))
  ->setTo(array("$To" => "Andrew Moschou"))
  ->setBody("<p>Hello 1</p>",'text/html')
  ->addPart("Hello 1",'text/plain');
$Result = $Mailer->send($Message);

var_dump($Result);