<?php
class DbConnection
{
  var $link;
  var $available;
  
  public function __construct()
  {
    $this->available = true;
  
    if (USE_PCONNECT) {
      $this->link = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD);
      // Fixes "server has gone away" error
      if (!mysql_ping($this->link)) {
        $this->link = mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD);
      }
    } else {
      $this->link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    }
    
    if (!$this->link)
    {
      if (DB_REQUIRED) {
        echo "<p> В настоящий момент сервер базы данных не доступен, поэтому корректное отображение страницы невозможно.</p>";
        exit;
      } else {
        $this->available = false;
      }
    }
    if (!mysql_select_db(DB_DATABASE, $this->link))
    {
      if (DB_REQUIRED) {
        echo "<p> В настоящий момент база данных не доступна, поэтому корректное отображение страницы невозможно.</p>";
        exit;
      } else {
        $this->available = false;
      }
    }

    // UTF-8
    if ($this->available) {
      mysql_query ("SET NAMES utf8");
      mysql_query ("set character_set_client='utf8'");
      mysql_query ("set character_set_results='utf8'");
      mysql_query ("set collation_connection='utf8_general_ci'");
    }
  }
  
  public function execute($sql)
  {
    if (!$this->available) return null;
    
    //echo $sql.';</br>';
    global $mysql_time;
    $mysql_started_at = microtime(true);
    $result = mysql_query($sql, $this->link);
    $mysql_time += microtime(true) - $mysql_started_at;
    if (!$result) {
      //$this->rollback();
      echo $sql.'</br>';
      echo mysql_error().'</br>';
      print_r(debug_backtrace());
      exit;
    };
    
    return $result;
  }
  
  public function execute_row($sql, $default_value = null)
  {
    if (!$this->available) return null;
    
    $result = $this->execute($sql);
    if (mysql_num_rows($result)==0)
      return null;
    else
    {
      $row = mysql_fetch_array($result);
      unset($result);
      return $row;
    }
  }
  
  public function execute_scalar($sql, $default_value = null)
  {
    if (!$this->available) return null;
    
    $result = $this->execute($sql);
    if (mysql_num_rows($result)==0)
      return $default_value;
    else
      return mysql_result($result,0);
  }
  
  public function execute_void($sql)
  {
    $result = $this->execute($sql);
    unset($result);
  }
  
  /*public function begin()
  {
    echo 'begin->';
    $result = $this->execute("SET autocommit = 0");
    unset($result);
    $result = $this->execute("BEGIN");
    unset($result);
  }
  
  public function commit()
  {
    echo 'commit;';
    $result = $this->execute("COMMIT");
    unset($result);
    $result = $this->execute("SET autocommit = 1");
    unset($result);
  }
  
  public function rollback()
  {
    echo 'rollback;';
    $result = $this->execute("ROLLBACK");
    unset($result);
    $result = $this->execute("SET autocommit = 1");
    unset($result);
  }*/
}

?>