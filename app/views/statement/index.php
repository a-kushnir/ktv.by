<?php echo page_header(); ?>

<?php if (count($billing_details) == 0) {
  echo no_data_tag();
} else { ?>

<h3>Сводка</h3>

<?php 
  $groups = array();
  foreach($billing_details as $billing_detail) {
    $group = $billing_detail['billing_detail_type'];
    if (!isset($groups[$group])) $groups[$group] = 0;
    $groups[$group] += $billing_detail['value'];
  }
?>

<table class="table table-condensed">
<thead>
  <th>Входящий остаток на <?php echo format_date($from_date); ?>:</td>
  <th class="align-right"><?php echo format_money($from_money); ?></td>
</thead>
</table>

<table class="table table-bordered table-striped table-condensed">
  <thead>
  <th>Тип операции</th>
  <th class="align-right">Сумма</th>
  </thead>
  <tbody>
<?php 
$amount = 0;
foreach($groups as $group => $value) {
  $amount += $value;
  echo '<tr>'.
  '<td>'.$group.'</td>'.
  '<td class="align-right">'.format_money($value).'</td>'.
  '</tr>';
}
?>

<tfoot>
  <td class="align-right">Итого</td>
  <td class="align-right"><?php echo format_money($amount); ?></td>
</tfoot>

</tbody>
</table>

<table class="table table-condensed">
<thead>
  <th>Исходящий остаток на <?php echo format_date($to_date); ?>:</td>
  <th class="align-right"><?php echo format_money($to_money); ?></td>
</thead>
</table>


<h3>Детализация</h3>

<table class="table table-condensed">
<thead>
  <th>Входящий остаток на <?php echo format_date($from_date); ?>:</td>
  <th class="align-right"><?php echo format_money($from_money); ?></td>
</thead>
</table>

<table class="table table-bordered table-striped table-condensed">
  <thead>
  <th>Дата</th>
  <th class="align-right">Расход</th>
  <th class="align-right">Приход</th>
  <th>Операция</th>
  </thead>
  <tbody>
<?php 
$debet = 0;
$credit = 0;

foreach($billing_details as $billing_detail) {
  if($billing_detail['value'] < 0) $debet += $billing_detail['value'];
  if($billing_detail['value'] > 0) $credit += $billing_detail['value'];

  echo '<tr>'.
  '<td>'.format_date($billing_detail['actual_date']).'</td>'.
  '<td class="align-right">'.($billing_detail['value'] < 0 ? format_money(-$billing_detail['value']) : '&nbsp;').'</td>'.
  '<td class="align-right">'.($billing_detail['value'] > 0 ? format_money($billing_detail['value']) : '&nbsp;').'</td>'.
  //'<td>'.$billing_detail['billing_detail_type'].'</td>'.
  '<td>'.$billing_detail['comment'].'</td>'.
  '</tr>';
}
?>

<tfoot>
  <td class="align-right">Оборот</td>
  <td class="align-right" nowrap><?php echo format_money(-$debet); ?></td>
  <td class="align-right" nowrap><?php echo format_money($credit); ?></td>
  <td>&nbsp;</td>
</tfoot>

</tbody>
</table>

<table class="table table-condensed">
<thead>
  <th>Исходящий остаток на <?php echo format_date($to_date); ?>:</td>
  <th class="align-right"><?php echo format_money($to_money); ?></td>
</thead>
</table>

<?php } ?>