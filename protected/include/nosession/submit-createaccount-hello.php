<h1>Hello, <?php echo $_SESSION['NameFirst']; ?></h1>
<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <span class="glyphicon glyphicon-remove"></span>
  </button>
  <p>To log in for the first time, please reset your password.</p>
</div>

<?php

$URL = Config::read('site.protocol').'://'.Config::read('site.domain').'/';
$SiteTitle = Config::read('site.title');

$MsgBodyHTML = <<<HTML
<p>Hello {$_SESSION['NameFirst']},</p>
<p>Thank you for registering an account at <a href="{$URL}">{$SiteTitle}</a>. To log in for the first time, please reset your password by visiting <a href="{$URL}">{$URL}</a>. Then click ‘Reset password’ and follow the instructions.</p>
<p>Do not reply to this message.</p>
<p>Regards,<br />$SiteTitle</p>
HTML;

$MsgBodyPlain = <<<Plain
Hello {$_SESSION['NameFirst']},\n\n
Thank you for registering an account at {$SiteTitle} ({$URL}). To log in for the first time, please reset your password by visiting {$URL}. Then click ‘Reset password’ and follow the instructions.\n\n
Do not reply to this message.\n\n
Regards,\n$SiteTitle
Plain;

$From = 'mail@'.Config::read('site.domain');
$ToName = "{$_SESSION['NameFirst']} {$_SESSION['NameLast']}";
$ToEmail = $_SESSION['Email'];

try
{

$Message = Swift_Message::newInstance()
  ->setSubject($SiteTitle.': Create account')
  ->setFrom(array($From => $SiteTitle))
  ->setTo(array($ToEmail => $ToName))
  ->setBody($MsgBodyHTML, 'text/html')
  ->addPart($MsgBodyPlain,'text/plain')
//  ->attach(Swift_Attachment::fromPath('my-document.pdf'))
  ;

$Transport = get_transport();
$Mailer = Swift_Mailer::newInstance($Transport);
$Result = $Mailer->send($Message);

}
catch(Exception $e)
{
  exception_error($e);
  die();
}

unset($_SESSION['NameFirst']);
unset($_SESSION['NameLast']);
unset($_SESSION['Email']);
