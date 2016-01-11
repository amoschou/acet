<?php
  $CorrectPassword = 0;
  $Connection = get_connection();
  
  $Email = $_POST['inputEmail1'];
  $Password = $_POST['inputPassword1'];
  if($Email === '')
  {
    $Password = '';
  }
  
  // See whether Blowfish lets us in
  $Query3 = "SELECT Blowfish FROM framy_Blowfish WHERE PersonalId = (SELECT PersonalId FROM framy_Personal WHERE Email = :email)";
  $Statement3 = $Connection->prepare($Query3);
  $Statement3->bindValue(':email',$Email);
  $Statement3->execute();
  $Row3 = $Statement3->fetchObject();
  $Statement3->closeCursor();
  $Row3Blowfish = $Row3->blowfish;
  $CorrectPassword = password_verify($Password,$Row3Blowfish);
  if($CorrectPassword)
  {
    if(password_needs_rehash($Row3Blowfish,PASSWORD_DEFAULT,array('cost' => Config::read('password.cost'))));
    {
      $NewBlowfish = encrypt_password($Password);
      $QueryNew = "UPDATE framy_Blowfish SET Blowfish = :a WHERE PersonalId = (SELECT PersonalId FROM framy_Personal WHERE Email = :b)";
      $StatementNew = $Connection->prepare($QueryNew);
      $StatementNew->bindValue(':a',$NewBlowfish);
      $StatementNew->bindValue(':b',$Email);
      $StatementNew->execute();
    }
  }

  // If that doesn’t work, see whether TempBlowfish lets us in
  if(!$CorrectPassword)
  {
    $Query = "SELECT TempBlowfish
              FROM framy_Blowfish
              WHERE TempBlowfish IS NOT NULL
                AND Expiry IS NOT NULL
                AND PersonalId = (SELECT PersonalId FROM framy_Personal WHERE Email = :email)";
                // and expiry is after NOW() ?
    $Statement = $Connection->prepare($Query);
    $Statement->bindValue(':email',$Email);
    $Statement->execute();
    $Row = $Statement->fetchObject();
    $Statement->closeCursor();
    $CorrectPassword = password_verify($Password,$Row->tempblowfish);
    if($CorrectPassword)
    {
      $Query2 = "UPDATE framy_Blowfish SET TempBlowfish = NULL,Expiry = NULL WHERE PersonalId = (SELECT PersonalId FROM framy_Personal WHERE Email = :email)";
      $Statement2 = $Connection->prepare($Query2);
      $Statement2->bindValue(':email',$Email);
      $Statement2->execute();
      $Statement2->closeCursor();
      // And force change the password
      $_SESSION['ForceChangePassword'] = 1;
    }
  }
  

  // If that doesn’t work, then we can’t get in.
  // We are not logged in until the password is changed (if necessary)
  if(isset($_SESSION['ForceChangePassword']))
  {
    $_SESSION['LoggedIn'] = FALSE;
  }
  else
  {
    $_SESSION['LoggedIn'] = $CorrectPassword;
  }
  if($CorrectPassword)
  {
    $_SESSION['Email'] = $Email;
    $_SESSION['PersonalId'] = select_from('PersonalId',"framy_Personal WHERE Email = ?",array($Email));
  }
?>
