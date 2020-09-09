<?php
class Subscriber extends BaseModel {
  var $table_name = 'subscribers';

  static function load($id)
  {
    global $factory;
    
    $query = "SELECT 
      s.*, ba.id billing_account_id, ba.lookup_code, ba.actual_balance, ba.billing_tariff_id, bt.name billing_tariff
      FROM subscribers s 
      LEFT JOIN billing_accounts ba ON ba.subscriber_id = s.id 
      LEFT JOIN billing_tariffs bt ON ba.billing_tariff_id = bt.id
      WHERE s.id = '".mysql_real_escape_string($id)."'";
    
    return new Subscriber($factory->connection->execute_row($query));
  }
  
  function billing_tariff()
  {
    global $factory;
    return $this['billing_tariff_id'] ? BillingTariff::load($this['billing_tariff_id']) : null;
  }
}

?>