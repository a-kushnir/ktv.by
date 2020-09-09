<?php
class BillingAccount extends BaseModel {

	static function load($id)
	{
    global $factory;
    
		$query = "SELECT * FROM billing_accounts WHERE id = '".mysql_real_escape_string($id)."'";
    return new BillingAccount($factory->connection->execute_row($query));
	}

	static function load_for_subscriber($subscriber_id)
	{
    global $factory;
    
		$query = "SELECT * FROM billing_accounts WHERE subscriber_id = '".mysql_real_escape_string($subscriber_id)."'";
    return new BillingAccount($factory->connection->execute_row($query));
	}
  
  /*static function load_cards_for_subscriber($subscriber_id)
  {
    global $factory;
    
		$query = "SELECT ba.lookup_code, s.*, houses.house, houses.building, streets.name street, cities.name city
    FROM billing_accounts ba
    JOIN subscribers s ON s.id = ba.subscriber_id
    JOIN houses ON houses.id = s.house_id
		JOIN streets ON streets.id = houses.street_id
		JOIN cities ON cities.id = streets.city_id
    WHERE ba.active = true and s.active = true AND s.id = '".mysql_real_escape_string($subscriber_id)."'
		ORDER BY cities.name, streets.name, houses.house, houses.building, s.apartment";
    
    $row = $factory->connection->execute_row($query);
    
    $result = array();
    $result[] = new BillingAccount($row);
    while(count($result)<6)
      $result[] = $result[0];
    
    return $result;
  }*/
}
?>