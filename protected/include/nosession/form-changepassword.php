<form class="form-horizontal" method="post" action="/" novalidate>
  <?php
    if(!(isset($_SESSION['ForceChangePassword']) && $_SESSION['ForceChangePassword']))
    {
  ?>
      <div class="form-group">
        <label for="inputOldPassword" class="col-sm-3 control-label">Old password</label>
        <div class="col-sm-6">
          <input type="password" class="form-control" id="inputOldPassword" name="inputOldPassword" required>
          <span class="help-block"></span>
        </div>
      </div>
  <?php
    }
    else
    {
  ?>
      <h1>Change password</h1>
  <?php
    }
  ?>
  <?php
    echo "<div class=\"alert alert-info\" role=\"alert\">";
    $algorithm = password_get_info(password_hash('',PASSWORD_DEFAULT))['algoName'];
    echo "Your password itself does not get stored, only the salted one-way hash using the best practice method which is currently the bcrypt algorithm.";
    echo "</div>";
  ?>
  <div class="form-group">
    <label for="inputNewPassword" class="col-sm-3 control-label">New password</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" required>
      <span class="help-block"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputConfirmNewPassword" class="col-sm-3 control-label">Confirm new password</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" id="inputConfirmNewPassword" name="inputConfirmNewPassword" data-validation-match-match="inputNewPassword" required>
      <span class="help-block"></span>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
      <button type="submit" name="submitChangePassword" class="btn btn-primary" value="Change password">Change password</button>
    </div>
  </div>
</form>
