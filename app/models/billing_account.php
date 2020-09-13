<?php
class BillingAccount extends BaseModel {

  static function load($id)
  {
    global $factory;
    
    $query = "SELECT * FROM billing_accounts WHERE id = '".mysql_escape($id)."'";
    return new BillingAccount($factory->connection->execute_row($query));
  }

  static function load_for_subscriber($subscriber_id)
  {
    global $factory;
    
    $query = "SELECT * FROM billing_accounts WHERE subscriber_id = '".mysql_escape($subscriber_id)."'";
    return new BillingAccount($factory->connection->execute_row($query));
  }
}
?>