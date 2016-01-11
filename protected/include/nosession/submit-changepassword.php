<?php
  $Connection = get_connection();
  if($_POST['inputNewPassword'] != $_POST['inputConfirmNewPassword'])
  {
?>
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <p>Passwords do not match. Please start again.</p>
    </div>
<?php
    superendsession();
    die();
  }

  $NewBlowfish = encrypt_password($_POST['inputNewPassword']);

  $ChangePassword = 0;
  if(isset($_SESSION['ForceChangePassword']))
  {
    $ChangePassword = 1;
  }
  else
  {
    if(password_verify($_POST['inputOldPassword'],$_SESSION['PA']->blowfish))
    {
      $ChangePassword = 1;
    }
  }
  unset($_SESSION['PasswordIsChanged']);
  if($ChangePassword)
  {
    $Query = "UPDATE framy_Blowfish SET Blowfish = '$NewBlowfish' WHERE PersonalId = {$_SESSION['PersonalId']}";
    $Connection->exec($Query);
    $_SESSION['PasswordIsChanged'] = 1;
    $_SESSION['LoggedIn'] = 1;
    unset($_SESSION['ForceChangePassword']);
  }

  $_SESSION['submitChangePasswordMessage'] = 1;
?>
