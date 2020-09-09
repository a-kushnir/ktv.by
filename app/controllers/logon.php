<?php
$suppress_authorization = true;
include('../../lib/application.php');

function action_index()
{
  global $title, $subtitle;
  $title = "Вход в личный кабинет";
  $subtitle = null;

	global $factory;
  
  unset($_SESSION['user_id']);
  unset($_SESSION['subscriber_id']);
  unset($_SESSION['user_name']);
  unset($_SESSION['user_session_id']);
  unset($_SESSION['ip_address']);
  
	session_destroy();
}

function action_create()
{
  global $title, $subtitle;
  $title = "Вход в личный кабинет";
  $subtitle = null;

  $user = User::try_auth($_POST['login'], $_POST['password']);
  if ($user != null) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['subscriber_id'] = $user['subscriber_id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_session_id'] = $user['user_session_id'];
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    
    $message = 'Добро пожаловать, '.$user['short_name'].'!';
    
    flash_notice($message);
    redirect_to('/home');
  }
  else
  {
    flash_alert('Неправильное имя пользователя или пароль');
    redirect_to('/logon');
  }
}

?>