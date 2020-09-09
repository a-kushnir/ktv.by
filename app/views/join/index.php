<div class="page-header">
<h1>Подключиться</h1>
</div>

<div class="row">
<div class="span6 offset3">

<form class="form-horizontal">
<?php 
  $read_only = false;
  if (!isset($message)) $message = null;
  echo text_field($message, "address", "Адрес", array('required' => true));
  echo phone_field($message, "cell_phone", "Телефон", array('required' => true));
  echo text_area_field($message, "comment", "Примечание", null, array('rows' => 5));
?>

<div class="form-actions">
  <?php echo submit_button("Отправить"); ?>
</div>
</form>

</div>
</div>