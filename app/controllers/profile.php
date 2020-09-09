<?php
include('../../lib/application.php');

function action_index()
{
  global $title, $subtitle;
  $title = 'Профиль';
  $subtitle = null;

	global $factory;
	global $user;
  
  $user = new User();
}

function action_create()
{
  global $title, $subtitle;
  $title = 'Профиль';
  $subtitle = null;

	global $factory;
	global $user;
  $user_id = $_SESSION['user_id'];

	if ($_POST) {
    $user = new User();
    
    if (get_field_value('old_password') == '') $user->errors['old_password'] = ERROR_BLANK;
    if (get_field_value('new_password') == '') $user->errors['new_password'] = ERROR_BLANK;
    if (get_field_value('password_confirm') == '') $user->errors['password_confirm'] = ERROR_BLANK;
    if (get_field_value('new_password') != get_field_value('password_confirm')) $user->errors['password_confirm'] = ERROR_PASSWORD_CONFIRM;
    if (count($user->errors) == 0 && get_field_value('new_password') != get_field_value('password_confirm')) $user->errors['password_confirm'] = ERROR_PASSWORD_CONFIRM;
    if (count($user->errors) == 0 && mb_strlen(get_field_value('new_password'), 'UTF-8') < 6) $user->errors['new_password'] = ERROR_NEW_PASSWORD;
    if (count($user->errors) == 0 && !User::password_matches($user_id, get_field_value('old_password'))) $user->errors['old_password'] = ERROR_OLD_PASSWORD;
    
    if (count($user->errors) == 0) {
      User::set_password($user_id, get_field_value('new_password'));
      flash_notice('Профиль был обновлен');
    }
    
	} else {
    $user = new User();
  }
}

?>