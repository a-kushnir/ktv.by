<?php 
function render_primary_menu_item($link, $text) {
  $selected_class = ends_with($_SERVER["PHP_SELF"], $link.'.php') ? 'active' : '';
  return '<li class="'.$selected_class.'"><a href="'.$link.'">'.$text.'</a>';
}
?>

<ul class="nav">
<?php 
  echo render_primary_menu_item('/tariffs', 'Our Services');
  echo render_primary_menu_item('/dvb-c', 'DVB-C Setup');
  echo render_primary_menu_item('/payments', 'Payment Methods');
  echo render_primary_menu_item('/about', 'About');
  echo render_primary_menu_item('/contact', 'Contact Us');
?>
<li class="visible-phone"><a href="#feedback-popup" role="button" data-toggle="modal">Message Us</a></li>
</ul>
<ul class="nav pull-right">
<?php if (isset($_SESSION['user_id'])) { 
  echo render_primary_menu_item('/home', $_SESSION['user_name']);
  echo render_primary_menu_item('/logout', 'Log Out');
} else {
  echo render_primary_menu_item('/logon', 'My Account');
} ?>
</ul>

