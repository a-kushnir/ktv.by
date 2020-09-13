<?php echo page_header(); ?>

<div class="row">
<div class="span6 offset3">
<form method="post" class="form-horizontal">

<div class="control-group">
  <label class="control-label" for="login"><?php echo required_tag() ?> Cell Phone</label>
  <div class="controls">
    <input type="text" name="login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : null; ?>" size="20" class="phone-number" />
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="password"><?php echo required_tag() ?> Password</label>
  <div class="controls">
    <input type="password" name="password" size="20" />
    <span class="help-block">Passport number (digits only)</span>
  </div>
</div>

<div class="form-actions">
  <?php echo submit_button('Sign In') ?>
</div>

</form>
</div>
</div>