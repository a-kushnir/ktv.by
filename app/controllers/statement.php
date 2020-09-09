<?php
//include('../../lib/client_cards.php');
include('../../lib/application.php');

function action_index()
{
  global $factory, $has_secondary_menu;
  $has_secondary_menu = true;
  global $billing_account, $subscriber, $billing_details, $from_date, $to_date, $from_money, $to_money;
  
  $subscriber = Subscriber::load($_SESSION['subscriber_id']);
  $billing_account = BillingAccount::load_for_subscriber($_SESSION['subscriber_id']);
  
  $billing_details = BillingDetail::load($billing_account['id']);
  
  if (count($billing_details) > 0) {
    $from_date = $billing_details[0]['actual_date'];
    $to_date = $billing_details[count($billing_details) - 1]['actual_date'];
    
    // Search incoming and outcoming balance
    $min_id = $billing_details[0]['id'];
    $max_id = $billing_details[0]['id'];
    $from_money = $billing_details[0]['actual_balance'] - $billing_details[0]['value'];
    $to_money = $billing_details[0]['actual_balance'];
    foreach($billing_details as $billing_detail) {
      if ($min_id > $billing_detail['id']) {
        $min_id = $billing_detail['id'];
        $from_money = $billing_detail['actual_balance'] - $billing_detail['value'];
      } else if ($max_id < $billing_detail['id']) {
        $max_id = $billing_detail['id'];
        $to_money = $billing_detail['actual_balance'];
      }
    }
  }
  
  global $title, $subtitle;
  $title = 'Выписка по счету';
  $subtitle = $billing_account['lookup_code'];
}
?>