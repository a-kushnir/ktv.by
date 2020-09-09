<?php
class BillingTariff extends BaseModel {
  var $table_name = 'billing_tariffs';

	static function load($id)
	{
    global $factory;
    
		$query = "SELECT * FROM billing_tariffs WHERE id = '".mysql_real_escape_string($id)."'";
    return new BillingTariff($factory->connection->execute_row($query));
	}
}

?>