<?php echo page_header(); ?>

<div class="form-horizontal">
<?php 
  echo readonly_field("Абонент", format_name($subscriber));
  
  echo '<div class="control-group readonly_string">
<label class="control-label">Тарифный план</label>
<div class="controls"><div class="input">'.format_tariff($subscriber->billing_tariff()).'</div></div>
</div>';

  echo readonly_field("Лицевой счет", $subscriber['lookup_code']);
  echo readonly_field("Баланс", format_money($subscriber['actual_balance']));
 ?>
 </div>