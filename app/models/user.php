<?php
class User extends BaseModel {
  var $table_name = 'users';
  
  static function try_auth($login, $password)
  {
      global $factory;

      $login = prepare_phone($login);
      
      $query = "SELECT id FROM users WHERE login='".mysql_escape($login)."' and password=MD5('".mysql_escape($password)."')";
      $auth_user_id = $factory->connection->execute_scalar($query);

      if ($auth_user_id) {
      
        $us_id = User::creare_session($login, 1, $auth_user_id);
        $user = new User($factory->connection->execute_row("SELECT u.*, 
            CONCAT_WS(' ', s.first_name, s.middle_name) short_name,
            CONCAT_WS(' ', s.last_name, s.first_name, s.middle_name) full_name
          FROM users u JOIN subscribers s ON s.id = u.subscriber_id
          WHERE u.id = '".mysql_escape($auth_user_id)."'"));
        $user->attributes['user_session_id'] = $us_id;
        return $user;
        
      } else {
      
        $query = "SELECT id FROM users WHERE login='".mysql_escape($login)."'";
        $found_user_id = $factory->connection->execute_scalar($query);
        User::creare_session($login, 0, $found_user_id);
        return null;
        
      }
  }
  
  /*static function password_matches($id, $password)
  {
    global $factory;
    
    $query = "SELECT id FROM users WHERE id='".mysql_escape($id)."' and password=MD5('".mysql_escape($password)."')";
    return $factory->connection->execute_scalar($query);    
  }

  static function set_password($id, $new_password)
  {
    global $factory;
    
    $query = "UPDATE users SET password = MD5('".mysql_escape($new_password)."') WHERE id='".mysql_escape($id)."'";
    $factory->connection->execute($query);        
  }*/
  
  static function creare_session($login, $success, $user_id)
  {
    global $factory;
    
    $now = time();
    $attributes = array(
      'login' => $login,
      'success' => $success,
      'ip_address' => $_SERVER['REMOTE_ADDR'],
      'user_agent' => $_SERVER['HTTP_USER_AGENT'],
      'created_at' => mysql_time_from_ts($now),
      'updated_at' => mysql_time_from_ts($now),
    );
    if ($user_id) $attributes['created_by'] = $user_id;
    
    return $factory->create('user_sessions', $attributes);
  }
  
  static function update_session($session_id)
  {
    global $factory;
    
    $now = time();
    $attributes = array(
      'updated_at' => mysql_time_from_ts($now),
    );
    
    return $factory->update('user_sessions', $session_id, $attributes);
  }  
}

?>