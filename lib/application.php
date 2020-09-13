<?php
// Benchmark and logging
$page_started_at = microtime(true);
$view_time = 0;
$action_time = 0;
$mysql_time = 0;
function save_user_hit(){
  global $factory, $page_started_at, $controller, $action, $layout;
  global $view_time, $action_time, $mysql_time;
  $user_hit = array();
  if (isset($_SESSION['user_session_id'])) $user_hit['user_session_id'] = $_SESSION['user_session_id'];
  $user_hit['request_method'] = $_SERVER['REQUEST_METHOD'];
  $user_hit['request_uri'] = $_SERVER['REQUEST_URI'];
  $user_hit['controller'] = $controller;
  $user_hit['action'] = $action;
  $user_hit['layout'] = $layout;
  $user_hit['action_time'] = round($action_time*1000);
  $user_hit['view_time'] = round($view_time*1000);
  $user_hit['mysql_time'] = round($mysql_time*1000);
  $user_hit['total_time'] = round((microtime(true) - $page_started_at) * 1000);
  if (isset($_SESSION['user_id'])) $user_hit['created_by'] = $_SESSION['user_id'];
  $user_hit['created_at'] = mysql_time_from_ts(time());
  $factory->create('user_hits', $user_hit);
}
register_shutdown_function('save_user_hit');

include('startup.php');

$controller = get_controller();
$render_action = $action = get_action();
$layout = 'application';
$title = 'ТелeCпутник';
$subtitle = null;
$has_secondary_menu = false;

// Before Filters BEGIN
session_start();

if (isset($_SESSION['user_session_id'])) {
  User::update_session($_SESSION['user_session_id']);
}

if(!isset($suppress_authorization) || !$suppress_authorization){
  if (!isset($_SESSION['user_id'])){
    redirect_to('/logon');
  }
}

if (isset($_SESSION['ip_address']) && $_SESSION['ip_address'] != $_SERVER['REMOTE_ADDR']) {
  unset($_SESSION['ip_address']);
  redirect_to('/logon');
}

// Which version?
$android_version = isset($_SERVER['HTTP_USER_AGENT']) && stripos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') !== false;
$print_version = isset($_GET['print_version']);
if ($print_version) $layout = 'print_version';

// Before Filters END

$action_started_at = microtime(true);
if ($action == 'index') {

$read_only = true;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
action_index();

} else if ($action == 'new') {

$read_only = false;
action_new();

} else if ($action == 'create') {

$read_only = false;
action_create();

} else if ($action == 'show') {

$read_only = true;
$id = isset($_GET['id']) ? $_GET['id'] : null;
action_show();

} else if ($action == 'edit') {

$read_only = false;
$id = isset($_GET['id']) ? $_GET['id'] : null;
action_edit();

} else if ($action == 'update') {

$read_only = false;
$id = isset($_GET['id']) ? $_GET['id'] : null;
action_update();

} else if ($action == 'destroy') {

$read_only = false;
$id = isset($_GET['id']) ? $_GET['id'] : null;
action_destroy();

} else if ($action != null && $action != '') {

$id = isset($_GET['id']) ? $_GET['id'] : null;
call_user_func('action_'.$action);
  
}
$action_time = microtime(true) - $action_started_at;

$view_started_at = microtime(true);
if ($layout != null) include('../views/layouts/'.$layout.'_header.php');
include '../views/'.$controller.'/'.$render_action.'.php';
if ($layout != null) include('../views/layouts/'.$layout.'_footer.php');
$view_time = microtime(true) - $view_started_at;
?>