<?php
abstract class BaseModel extends ArrayObject {
  var $table_name;  
  var $attributes;
  var $errors;

  public function __construct($attributes = array())
  {
    $this->attributes = $attributes;
  }

  function valid() {
    $this->errors = array();
    $this->validate();
    return count($this->errors) == 0;
  }

  function is_new()
  {
    return !isset($this->attributes['id']) || $this->attributes['id'] == null;
  }
  
  function save()
  {
    if ($this->is_new())
      $this->create();
    else
      $this->update();
  }
  
  function create()
  {
    global $factory;
    
    $this->attributes['id'] = $factory->create($this->table_name, $this->attributes);
    return $this->attributes['id'];
  }
  
  function update($conditions = null)
  {
    global $factory;
    
    return $factory->update($this->table_name, $this->attributes['id'], $this->attributes, $conditions);
  }
  
  function deactivate()
  {
    global $factory;
    
    $id = $this->attributes['id'];
    
    $this->attributes = array();
    $this->attributes['id'] = $id;
    $this->attributes['active'] = 0;
    $this->add_userstamp();
    $this->add_timestamp();
    
    return $factory->update($this->table_name, $id, $this->attributes);
  }
  
  function destroy()
  {
    global $factory;
    
    return $factory->destroy($this->table_name, $this->attributes['id']);
  }
  
  function add_userstamp()
  {
    if ($this->is_new()) $this->attributes['created_by'] = $_SESSION['user_id'];
    $this->attributes['updated_by'] = $_SESSION['user_id'];
  }
  
  function add_timestamp()
  {
    $now = time();
    if ($this->is_new()) $this->attributes['created_at'] = mysql_time_from_ts($now);
    $this->attributes['updated_at'] = mysql_time_from_ts($now);
  }

  function offsetExists($offset) { return isset($this->attributes) && isset($this->attributes[$offset]); }
  function offsetGet($offset) { return isset($this->attributes) ? $this->attributes[$offset] : null; }
  function offsetSet($offset, $value) { if(!isset($this->attributes)) $this->attributes = array(); $this->attributes[$offset] = $value; }
  function offsetUnset($offset) { if (isset($this->attributes)) unset($this->attributes[$offset]); }
}
?>