<?php
class BillingDetail extends BaseModel {
  var $table_name = 'billing_details';
  
	static function load($billing_account_id)
	{
    global $factory;
    
    $query = "SELECT bd.*, ba.subscriber_id, ba.lookup_code, bt.name billing_tariff, bdt.name billing_detail_type
      FROM billing_details bd
      LEFT JOIN billing_accounts ba ON bd.billing_account_id = ba.id
      LEFT JOIN billing_tariffs bt ON ba.billing_tariff_id = bt.id
      LEFT JOIN billing_detail_types bdt ON bd.billing_detail_type_id = bdt.id
      WHERE billing_account_id = '".mysql_escape($billing_account_id)."'
      ORDER BY bd.actual_date ASC";
    
    $result = array();
    $rows = $factory->connection->execute($query);
    while($row = mysql_fetch_array($rows))
      $result[] = new BillingDetail($row);
    unset($rows);
    
    return $result;
	}
}

?>