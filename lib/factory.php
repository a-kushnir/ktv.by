<?php
include 'db_connection.php';

class Factory
{
    var $connection;
    
    public function __construct()
    {
        $this->connection = new DbConnection();
    }

	public function record_exists($table, $id)
	{
		$sql = "SELECT id FROM `".$table."` WHERE id = '".mysql_escape($id)."'";
    return $this->connection->execute_scalar($sql);
	}
  
	public function select($table, $columns, $conditions = '')
	{
		$cs = array();
		foreach ($columns as $column) {
      $cs[] = "`".$column."`";
		}
		
		$sql = "SELECT ".join(", ", $cs)." FROM `".$table."`";    
    if ($conditions) $sql.= " WHERE ".$conditions;
    return $this->connection->execute($sql);
	}
  
	public function create($table, $attributes)
	{
		$columns = array();
		$values = array();
		foreach ($attributes as $column => $value) {
      //if ($column != 'id') {
        $columns[] = "`".$column."`";
        $values[] =  is_null($value) ? "NULL" : "'".mysql_escape($value)."'";
      //}
		}
		
		$sql = "INSERT ".$table."(".join(", ", $columns).") VALUES (".join(", ", $values).")";    
		$this->connection->execute($sql);
    return $this->connection->execute_scalar('SELECT LAST_INSERT_ID();');
	}
	
	public function update($table, $id, $attributes, $conditions = null)
	{
		$values = array();
		foreach ($attributes as $column => $value) {
      if ($column != 'id') {
        $values[] = "`".$column."`=".(is_null($value) ? "NULL" : "'".mysql_escape($value)."'");
      }
		}
		
		$sql = "UPDATE ".$table." SET ".join(", ", $values)." WHERE id='".mysql_escape($id)."'";
    if ($conditions) $sql .= " AND ".$conditions;
    
		$this->connection->execute($sql);
    return mysql_affected_rows();
	}
	
	public function deactivate($table, $id)
	{
		return $this->update($table, $id, array(
      'active' => 0,
      'updated_at' => date(MYSQL_TIME, time()),
      'updated_by' => $_SESSION['user_id'])
    );
	}
	
	public function destroy($table, $id)
	{
		$sql = "DELETE FROM ".$table." WHERE id='".mysql_escape($id)."'";
		$this->connection->execute($sql);
    return mysql_affected_rows();
	}
  
  public function delete_all($table, $conditions = '')
	{
		$sql = "DELETE FROM `".$table."`";    
    if ($conditions) $sql.= " WHERE ".$conditions;
    return $this->connection->execute($sql);
	}
}
?>