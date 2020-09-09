<?php
include('../../lib/application.php');

function action_index()
{
  global $title, $subtitle, $read_only, $has_secondary_menu;
  $title = 'Общая информация';
  $has_secondary_menu = true;
  
  global $subscriber;
  $subscriber = Subscriber::load($_SESSION['subscriber_id']);
}
?>