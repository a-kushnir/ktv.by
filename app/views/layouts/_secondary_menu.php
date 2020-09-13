<?php 
function render_secondary_menu_item($link, $text) {
  $selected_class = ends_with($_SERVER["PHP_SELF"], $link.'.php') ? 'active' : '';
  return '<li class="'.$selected_class.'"><a href="'.$link.'"> <i class="icon-chevron-right"></i> '.$text.'</a>';
}
?>
<ul class="nav nav-list bs-docs-sidenav affix_menu">
<?php
  echo render_secondary_menu_item('/subscriber', 'Общая информация');
  echo render_secondary_menu_item('/statement', 'Выписка по счету');
?>
</ul>