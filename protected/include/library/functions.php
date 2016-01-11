<?php

function get_outa_here()
{
  superendsession();
  header('Location: /');
  exit();
}

function get_connection()
{
  try
  {
    $Core = Core::getInstance();
    $Connection = $Core->dbh;
  }
  catch(PDOException $Error)
  {
    exception_error($Error);
    die();
  }
  return $Connection;
}

// EMAIL

function get_transport()
{
  switch(Config::read('email.transporttype'))
  {
    case('Smtp'):
      return Swift_SmtpTransport::newInstance()
        ->setHost(Config::read('smtp.host'))
        ->setPort(Config::read('smtp.port'))
        ->setEncryption(Config::read('smtp.encr'))
        ->setUsername(Config::read('smtp.user'))
        ->setPassword(Config::read('smtp.pass'));
      break;
    case('Sendmail'):
      return Swift_SendmailTransport::newInstance(Config::read('email.sendmail'));
      break;
    case('Mail'):
      return Swift_MailTransport::newInstance();
      break;
    default:
      echo "Incorrect configuration in Core::read('email.transporttype'). It is ".Config::read('email.transporttype').". This should never happen in get_transport().";
      die();
  }
}

// SECURITY

function my_fix($s)
{
  return trim(strip_tags($s));
}
function encrypt_password($p)
{
  return password_hash($p,PASSWORD_DEFAULT,["cost" => Config::read('password.cost')]);
}
function random_str($l)
{
  // returns a string of length $l with random characters from the 64 character alphabet
  return substr(base64_encode(openssl_random_pseudo_bytes(ceil(.75*$l))),0,$l);
}

// DB

  function select_from($What,$Where,$Array = NULL)
  {
    $Connection = get_connection();
    if(is_null($Array))
    {
      $Query = "SELECT $What FROM $Where";
      $Statement = $Connection->prepare($Query);
//      $Statement->bindValue(':a',$What,PDO::PARAM_STR);
//      $Statement->bindValue(':b',$Where,PDO::PARAM_STR);
      $Statement->execute();
    }
    else
    {
      $Query = "SELECT $What FROM $Where";
      $Statement = $Connection->prepare($Query);
      $Statement->execute($Array);
    }
    $Row = $Statement->fetch();
    $Statement->closeCursor();
    if($Row !== FALSE)
    {
      return $Row[0];
    }
    else
    {
      return NULL;
    }
  }


// Navigation

function is_in_session()
{
  return count($_SESSION) > 0 ? TRUE : FALSE;
}

function site_include($Filename)
{
  if(Config::read('site.includenone'))
  {
    ;
  }
  else
  {
    include $Filename;
  }
}



/*


    

  
  function correct_password($p,$h)
  {
    return crypt($p,$h) == $h;        
  }
  function is_loggedin()
  {
    return ((isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']) || isset($_SESSION['PA']));
  }

*/