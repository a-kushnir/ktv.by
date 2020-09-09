<?php 
function render_primary_menu_item($link, $text) {
	$selected_class = ends_with($_SERVER["PHP_SELF"], $link.'.php') ? 'active' : '';
	return '<li class="'.$selected_class.'"><a href="'.$link.'">'.$text.'</a>';
}
?>

<ul class="nav">
<?php 
  //echo render_primary_menu_item('/join', 'Подключиться');
  echo render_primary_menu_item('/tariffs', 'Услуги и Тарифы');
  echo render_primary_menu_item('/dvb-c', 'Настройка DVB-C');
  echo render_primary_menu_item('/payments', 'Способы оплаты');
  echo render_primary_menu_item('/about', 'О компании');
  echo render_primary_menu_item('/contact', 'Контакты');
?>
<li class="visible-phone"><a href="#feedback-popup" role="button" data-toggle="modal">Отправить сообщение</a></li>
</ul>
<ul class="nav pull-right">
<?php if (isset($_SESSION['user_id'])) { 
  echo render_primary_menu_item('/home', $_SESSION['user_name']);
  //echo render_primary_menu_item('/profile', $_SESSION['user_name']);
  //echo render_primary_menu_item('/help', 'Помощь');
	echo render_primary_menu_item('/logout', 'Выход');
} else {
	echo render_primary_menu_item('/logon', 'Личный кабинет');
} ?>
</ul>

