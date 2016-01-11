<ul class="nav nav-tabs">
  <li class="active"><a href="#login" data-toggle="tab">Log in</a></li>
  <li><a href="#createaccount" data-toggle="tab">Create account</a></li>
  <li><a href="#resetpassword" data-toggle="tab">Reset password</a></li>
</ul>
<div class="hgap"></div>
<div class="tab-content">
  <div class="tab-pane fade active in" id="login">
    <?php include DIR_NOSESSION.'form-login.php' ?>
  </div>
  <div class="tab-pane fade" id="createaccount">
    <?php include DIR_NOSESSION.'form-createaccount.php' ?>
  </div>
  <div class="tab-pane fade" id="resetpassword">
    <?php include DIR_NOSESSION.'form-resetpassword.php' ?>
  </div>
</div>
