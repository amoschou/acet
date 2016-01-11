<?php
  if(isset($_SESSION['PasswordIsChanged']))
  {
    $MaybeNot = '';
    $SuccessDanger = 'success';
  }
  else
  {
    $MaybeNot = 'not ';
    $SuccessDanger = 'danger';
  }
  unset($_SESSION['PasswordIsChanged']);
?>
<div class="alert alert-<?php echo $SuccessDanger; ?> alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
    <span class="glyphicon glyphicon-remove"></span>
  </button>
  <p>The password has <?php echo $MaybeNot; ?>been changed.</p>
</div>
