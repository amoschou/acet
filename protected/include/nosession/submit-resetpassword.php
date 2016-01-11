<?php
  $Email = my_fix($_POST['inputEmail3']);
  if($Email === ''){get_outa_here();}
  $_SESSION['Email'] = $Email;
  $Connection = get_Connection();

  $q1 = "SELECT PersonalId,NameLast,NameFirst,Email FROM framy_personal WHERE Email = :a";
  $s1 = $Connection->prepare($q1);
  $s1->bindValue(':a',$Email);
  $s1->execute();
  // Email is UNIQUE KEY. Either zero or one record returned.
  // But just in case database fails, only take the first pass:
  $UniquePass1 = TRUE;
  foreach($s1 as $row1)
  {
    if($UniquePass1)
    {
      $UniquePass1 = FALSE;
      $NameLast = $row1['namelast'];
      $NameFirst = $row1['namefirst'];
      $Password = random_str(8);
      if(Config::read('dev.noemail'))
      {
        $_SESSION['dev']['pw'] = $Password;
      }
      $TempBlowfish = encrypt_password($Password);
      $q2 = "UPDATE framy_blowfish SET TempBlowfish = '$TempBlowfish',Expiry = NOW() + INTERVAL '15 MINUTES' WHERE PersonalId = :a";
      $s2 = $Connection->prepare($q2);
      $s2->bindValue(':a',$row1['personalid']);
      $s2->execute();
      $UniquePass2 = TRUE;
      foreach($s2 as $row2)
      {
        if($UniquePass2)
        {
          $UniquePass2 = FALSE;

          $URL = Config::read('site.protocol').'://'.Config::read('site.domain').'/';
          $SiteTitle = Config::read('site.title');

          $MsgBodyHTML = <<<HTML
<p>Hello $NameFirst,</p>
<p>Somebody (probably you!) would like to reset the password to your account at <a href="{$URL}">{$SiteTitle}</a>. Your temporary password is “<strong>{$Password}</strong>”. This password can be used only once within a fifteen minute period since this email was sent. If this time period has expired, just request another password reset. If you have a previously existing password, that password will still remain valid until you change it after logging in.</p>
<p>If you did not request this password reset, you can safely disregard this message.</p>
<p>Regards,<br />{$SiteTitle}</p>
HTML;
          $MsgBodyPlain = <<<Plain
Hello $NameFirst,\n\n
Somebody (probably you!) would like to reset the password to your account at {$SiteTitle} ({$URL}). Your temporary password is “{$Password}”. This password can be used only once within a fifteen minute period since this email was sent. If this time period has expired, just request another password reset. If you have a previously existing password, that password will still remain valid until you change it after logging in.\n\n
If you did not request this password reset, you can safely disregard this message.\n\n
Regards,\n{$SiteTitle}
Plain;

          $From = 'mail@'.Config::read('site.domain');
          $ToName = "{$NameFirst} {$NameLast}";
          $ToEmail = $_SESSION['Email'];

          $Message = Swift_Message::newInstance()
            ->setSubject($SiteTitle.': Reset password')
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
      }
    }
  }

  $_SESSION['submitResetPasswordHello'] = 1;
?>
