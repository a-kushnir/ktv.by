<?php

/////////////////////
// CONTROLLER-VIEW //

function get_controller() {
  preg_match('@^.*/([\w-]+)\.php$@i', $_SERVER["PHP_SELF"], $matches);
    return $matches[1];
}

function get_action() {
  return isset($_GET['action']) && $_GET['action'] != '' ? $_GET['action'] : 'index';
}

function redirect_to($url) {
  header('Location: '.$url);
  exit;
}

function render_action($action) {
  global $render_action;
  $render_action = $action;
}

///////////
// LINKS //

function url_for($model, $action = "index", $id = null, $params = null) {
  $url = null;
  if ($action == "index")
    $url = "/".$model;
  else if ($action == "show")
    $url = "/".$model."/".$id;
  else if ($action == "new")
    $url = "/".$model."/".$action;
  else if ($action == "edit" || $action == "destroy" || $id != null)
    $url = "/".$model."/".$id."/".$action;
  else
    $url = "/".$model."/".$action;
  
  if ($params)
    $url .= $params;
  
  return $url;
}

function link_to($url, $text, $html_options = null) {
  return "<a href='".$url."' ".field_attributes($html_options).">".$text."</a>";
}

function link_to_index($model, $text = "Список") {
  return "<a href='".url_for($model, 'index')."' class='icon icon-index'>".$text."</a>";
}

function link_to_new($model, $text = "Добавить") {
  return "<a href='".url_for($model, 'new')."' class='btn btn-large btn-success'>".$text."</a>";
}

function link_to_show($model, $id, $text = "Просмотр") {
  return "<a href='".url_for($model, 'show', $id)."'>".$text."</a>";
}

function link_to_edit($model, $id, $text = "Редактировать") {
  return "<a href='".url_for($model, 'edit', $id)."' rel='nofollow' class='btn btn-large btn-primary'>".$text."</a>";
}

function link_to_destroy($model, $id, $text = "Удалить") {
  return "<a href='".url_for($model, 'destroy', $id)."' rel='nofollow' data-method='delete' class='btn btn-large btn-danger' data-confirm='Вы уверены?'>".$text."</a>";
}

function link_to_back($url, $text = "Назад") {
  return link_to($url, $text, array('class' => 'btn btn-large'));
}

//////////////
// CONTROLS //

function page_header() {
  global $title, $subtitle;
  return custom_page_header($title, $subtitle);
}

function custom_page_header($title, $subtitle = null) {
  global $print_version;
  if ($print_version) {
    $html = "<h3>".htmlspecialchars($title);
    if ($subtitle != null) $html.= " <small>".htmlspecialchars($subtitle)."</small>";
    $html.= "</h3>"; 
  } else {
    $html = "<div class='page-header'><h1>";
    $html.= $title;
    if ($subtitle != null) $html.= " <small>".htmlspecialchars($subtitle)."</small>";
    $html.= "</h1></div>";
  }
  return $html;
}

function flash_alert($text) {
  $_SESSION['flash-alert'] = $text;
}

function flash_notice($text) {
  $_SESSION['flash-notice'] = $text;
}

function render_progress($value, $html_options = null) {
  return '<div class="progress progress-striped active" '.field_attributes($html_options).'>'.
         '<div class="bar" style="width: '.round($value*100).'%;">'.format_percent($value).'</div>'.
         '</div>';
}

function render_jumpers($value) {
  return arrow_image_bool($value & 1).
         arrow_image_bool($value & 2).
         arrow_image_bool($value & 4).
         arrow_image_bool($value & 8).
         arrow_image_bool($value & 16).
         arrow_image_bool($value & 32).
         arrow_image_bool($value & 64).
         arrow_image_bool($value & 128);
}

function search_highlight_part($value) {
  $filter = get_field_value('filter');
  if ($filter) {
    $words = array_filter(explode(' ', $filter), 'strlen');
    foreach($words as $word)
      $value = preg_replace("|($word)|iu" , "<span class='search_highlight'>$1</span>",$value);
  }
  return $value;
}

function search_highlight_full($value) {
  $filter = get_field_value('filter');
  if ($filter) {
    $words = array_filter(explode(' ', $filter), 'strlen');
    foreach($words as $word)
      if ($value == $word)
        $value = "<span class='search_highlight'>".$value."</span>";
  }
  return $value;
}

function search_button($params = '') {
  global $print_version;
  if (!$print_version) {
    $js_handler = 'window.location = \'?filter=\'+encodeURIComponent(jQuery(\'#filter\').val()) + \''.$params.'\'';
    return '<div class="well form-search align-center" style="float:right;">'.
    '<input id="filter" type="text" class="input-large search-query" value="'.get_field_value('filter').'" onkeypress="if(event.which == 13){'.$js_handler.'}" />&nbsp;
    <button type="submit" class="btn" onclick="'.$js_handler.'"><i class="icon-search"></i> Поиск</button>'.
    '</div>';
  }
  return '';
}

function print_version_button($params = '', $name = 'Версия для печати') {
  global $print_version, $android_version;
  if (!$print_version && !$android_version) {
    return '<div class="btn-toolbar align-right" style="float:right;">'.
    '<a class="btn" href="javascript://" onclick="window.open(\'?print_version'.$params.'\', \'ts_print_version_\'+Math.random());"><i class="icon-print"></i> '.$name.'</a>'.
    '</div>';
  }
  return '';
}

function breadcrumb($items) {
  global $print_version;
  if ($print_version) return '';

  $html = '';

  $count = count($items);
  if ($count > 0) 
  {
    $div = "<span class='divider'>&gt;</span>";
    $html .= "<ul class='breadcrumb'>";
    
    $index = 0;
    foreach($items as $name => $url) {
      $index += 1;
      $html.= ($url == '' || $url == null) ? 
        "<li>".$name.($index < $count ? $div : '')."</li>" :
        "<li><a href='".$url."'>".$name."</a>".($index < $count ? $div : '')."</li>";
    }
    $html.= "</ul>";
  }

  return $html;
}

function pagination($records, $page_size, $current_page = null, $params = null, $inside_window = 3, $outside_window = 2) {
  if ($current_page == null) $current_page = 1;
  $pages = ceil($records / $page_size);
  if ($pages > 1) {
    $html = '<div class="pagination pagination-centered">';
    $html.= '<ul>';
    
    $locked = false;
    for($i=1; $i<=$pages; $i++){
      $css_class = $i == $current_page ? 'active' : '';
      
      if ($i > $outside_window && $pages - $i >= $outside_window && abs($current_page - $i) > $inside_window) {
        if (!$locked) $html.= '<li class="disabled"><a href="#">...</a></li>';
        $locked = true;
      } else {
        if ($i == 1) $html.= '<li class="'.$css_class.'"><a href="?page='.($current_page-1).'">←<span class="hidden-phone"> Назад</span></a></li>';
        $html.= '<li class="'.$css_class.'"><a href="?page='.$i.$params.'">'.$i.'</a></li>';
        if ($i == $pages) $html.= '<li class="'.$css_class.'"><a href="?page='.($current_page+1).'"><span class="hidden-phone">Вперед </span>→</a></li>';
        $locked = false;
      }
    }
    
    $html.= '</ul>';
    $html.= '</div>';
    
    return $html;
  } else {
    return '';
  }  
}

function arrow_image($type)
{
  if ($type == 0)
    return '';
  else if ($type > 0)
    return '<i class="icon-arrow-up"></i>';
  else if ($type < 0)
    return '<i class="icon-arrow-down"></i>';
}

function arrow_image_bool($bool)
{
  global $print_version;
  if ($bool)
    return '1'; //$print_version ? '1' : '<i class="icon-arrow-up"></i>';
  else
    return '0'; //$print_version ? '0' : '<i class="icon-arrow-down"></i>';
}

function no_data_tag() {
  return "<div class='alert'>Нет данных для отображения</div>";
}

function required_tag() {
  return "<abbr title='Обязательно для заполнения'>*</abbr> ";
}

function readonly_field($label, $value) {
  return "<div class='control-group readonly_string'><label class='control-label'>".$label."</label><div class='controls'><div class='input'>".$value."</div></div></div>";
}

function get_field_value($method) {
  if (isset($_POST) && isset($_POST[$method]))
    return $_POST[$method];
  else if (isset($_GET) && isset($_GET[$method]))
    return $_GET[$method];
  else
    return null;
}

function text_field($object, $method, $label, $options = null, $html_options = null) {
  global $read_only;
  
  $value = (isset($html_options) && isset($html_options['value'])) ? 
    $html_options['value'] : 
    get_object_value($object, $method, "");
    
  $readonly = get_object_value($options, 'readonly');
  
  if ($read_only || $readonly){
    return readonly_field($label, $value);
  } else {
    
    $error = get_object_error($object, $method);
    $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
    
    $hint = get_object_value($options, 'hint');
    $hint_tag = ($hint != null ? "<p class='help-block'>".$hint."</p>" : '');
    
    $type = get_object_value($options, 'type');
    
    $required = get_object_value($options, 'required');
    
    return "<div class='control-group string".($error != null ? ' error' : null)."'>
    <label for='".$method."' class='control-label'>".($required ? required_tag() : '').$label."</label>
    <div class='controls'>
    <input type='".($type ? $type : 'text')."' id='".$method."' name='".$method."' value='".htmlspecialchars($value)."' ".field_attributes($html_options)." />".$error_tag.$hint_tag."
    </div>
    </div>";
  }
}

function password_field($object, $method, $label, $options = null, $html_options = null) {
  if ($options == null) $options = array();
  $options['type'] = 'password';
  
  return text_field($object, $method, $label, $options, $html_options);
}

function phone_field($object, $method, $label, $options = null, $html_options = null) {
  if ($html_options == null) $html_options = array();
  if (!isset($html_options['class'])) $html_options['class'] = '';
  $html_options['class'] = 'phone-number input-medium';
  
  $value = get_object_value($object, $method, "");
  $html_options['value'] = format_phone($value);
  
  return text_field($object, $method, $label, $options, $html_options);
}

function date_field($object, $method, $label, $options = null, $html_options = null) {
  if ($html_options == null) $html_options = array();
  if (!isset($html_options['class'])) $html_options['class'] = '';
  $html_options['class'] = 'date-picker input-small align-center';

  $value = get_object_value($object, $method, "");
  $html_options['value'] = format_date($value);
  
  return text_field($object, $method, $label, $options, $html_options);
}

function money_field($object, $method, $label, $options = null, $html_options = null) {
  $value = get_object_value($object, $method, "");
  $html_options['value'] = format_money($value);
  
  return text_field($object, $method, $label, $options, $html_options);
}

function text_area_field($object, $method, $label, $options = null, $html_options = null) {
  global $read_only;
  
  $value = (isset($html_options) && isset($html_options['value'])) ? 
    $html_options['value'] : 
    get_object_value($object, $method, "");
    
  $readonly = get_object_value($options, 'readonly');
  
  if ($read_only || $readonly){
    return readonly_field($label, nl2br($value));
  } else {
    $error = get_object_error($object, $method);
    $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
    
    $hint = get_object_value($options, 'hint');
    $hint_tag = ($hint != null ? "<p class='help-block'>".$hint."</p>" : '');
    
    $required = get_object_value($options, 'required');
  
    return "<div class='control-group string".($error != null ? ' error' : null)."'>
    <label for='".$method."' class='control-label'>".($required ? required_tag() : '').$label."</label>
    <div class='controls'>
    <textarea type='text' id='".$method."' name='".$method."' ".field_attributes($html_options).">".htmlspecialchars($value)."</textarea>".$error_tag.$hint_tag."
    </div>
    </div>";
  }
}

function checkbox_field($object, $method, $label, $options = null) {
  global $read_only;

  $value = get_object_value($object, $method);
  $checked = $value ? "checked='checked'" : "";

  $hint = get_object_value($options, 'hint');
  $hint_tag = ($hint != null ? "<p class='help-block'>".$hint."</p>" : '');
  
  if ($read_only){
    return "<div class='control-group boolean'><div class='controls'><label for='".$method."' class='checkbox'><input type='hidden' name='".$method."' value='0' /><input type='checkbox' id='".$method."' name='".$method."' value='1' ".$checked." disabled='disabled' />".$label."</label></div></div>";
  } else {
    return "<div class='control-group boolean'><div class='controls'><label for='".$method."' class='checkbox'><input type='hidden' name='".$method."' value='0' /><input type='checkbox' id='".$method."' name='".$method."' value='1' ".$checked." />".$label."</label>".$hint_tag."</div></div>";
  }  
}

function house_address_field($object, $label, $options = null) {
  global $read_only;
  global $factory;

  if ($read_only){
    return readonly_field($label, format_address($object));
  } else {
    $required = get_object_value($options, 'required');
  
	if (!$_SESSION['selected_city_id']) $cities = Address::get_cities();
    $city_id = get_object_value($object, 'city_id');
	if ($city_id == null && $_SESSION['selected_city_id']) $city_id = $_SESSION['selected_city_id'];
    $streets = Address::get_streets($city_id, true);
    $street_id = get_object_value($object, 'street_id');
    $house = get_object_value($object, 'house', "");
    $building = get_object_value($object, 'building', "");
    $include_blank = is_null(get_object_value($object, 'id', null)) ? '' : null;
    
    $error = get_object_error($object, 'address');
    $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
    
    $html = "<div class='control-group address".($error != null ? ' error' : null)."'><label for='city_id' class='control-label'>".($required ? required_tag() : '').$label."</label><div class='controls'>";

	if ($_SESSION['selected_city_id'])
	    $html.= "<span>".Address::city_name($city_id)."</span><input name='city_id' type='hidden' value='".$city_id."'/>&nbsp;&nbsp;";
	else
		$html.= select_tag('city_id', options_for_select($cities, 'id', 'name', $city_id, $include_blank), array('class' => 'span2'))."&nbsp;";

    $html.= "<span id='street_id_container'>";
    if ($city_id != null) {
      $html.= select_tag('street_id', options_for_select($streets, 'id', 'name', $street_id, $include_blank, array('class' => 'input-medium')));
    }
    $html.= "</span>";

    $html.= "<span class='street_id_selected nobr' ".($street_id == null ? 'style="display:none;"' : '').">";
    $html.= "<span class='help-inline'>дом&nbsp;&nbsp;</span><input type='text' name='house' value='".$house."' class='input-mini' />";
    $html.= "<span class='help-inline'>корпус&nbsp;&nbsp;</span><input type='text' name='building' value='".$building."' class='input-mini' />";
    $html.= "</span><i class='address_loading' style='display:none;'>  Загрузка...</i>".$error_tag;
    
    $html.= "</div></div>";
    
    return $html;
  }
}

function subscriber_address_field($object, $label) {
  global $read_only;
  global $factory;
  
  if ($read_only){
    return readonly_field($label, format_address($object));
  } else {

	if (!$_SESSION['selected_city_id']) $cities = Address::get_cities();
    $city_id = get_object_value($object, 'city_id');
	if ($city_id == null && $_SESSION['selected_city_id']) $city_id = $_SESSION['selected_city_id'];
    $streets = Address::get_streets($city_id);
    $street_id = get_object_value($object, 'street_id');
    $houses = Address::get_houses($street_id);
    $house_id = get_object_value($object, 'house_id', "");
    $apartment = get_object_value($object, 'apartment', "");
    $include_blank = is_null(get_object_value($object, 'id', null)) ? '' : null;
    
    $error = get_object_error($object, 'address');
    $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
    
    $html = "<div class='control-group address".($error != null ? ' error' : null)."'><label for='city_id' class='control-label'>".required_tag().$label."</label><div class='controls'>";

	if ($_SESSION['selected_city_id'])
	    $html.= "<span>".Address::city_name($city_id)."</span><input name='city_id' type='hidden' value='".$city_id."'/>&nbsp;&nbsp;";
	else
		$html.= select_tag('city_id', options_for_select($cities, 'id', 'name', $city_id, $include_blank), array('class' => 'span2'))."&nbsp;";

    $html.= "<span id='street_id_container'>";
    if ($city_id != null) {
      $html.= select_tag('street_id', options_for_select($streets, 'id', 'name', $street_id, $include_blank));
    }
    $html.= "</span>";

    $html.= "<span class='street_id_selected' ".($street_id == null ? 'style="display:none;"' : '').">";
    $html.= "<span class='help-inline'>дом&nbsp;&nbsp;</span><span id='house_id_container'>";
    if ($street_id != null) {
      $html.= select_tag('house_id', options_for_select($houses, 'id', 'name', $house_id, $include_blank), array('class' => 'span1'));
    }
    $html.= "</span>";
    $html.= "</span>";
    
    $html.= "<span class='house_id_selected' ".($house_id == null ? 'style="display:none;"' : '').">";
    $html.= "<span class='help-inline'>квартира&nbsp;&nbsp;</span><input type='text' id='apartment' name='apartment' value='".$apartment."' class='span1' />";
    $html.= "</span><i class='address_loading' style='display:none;'>  Загрузка...</i>".$error_tag;
    
    $html.= "</div></div>";
    
    return $html;
  }
}

function billing_tariff_field($object, $label, $billing_tariffs, $options = null)
{
  $name = 'billing_tariff_id';

  $error = get_object_error($object, $name);
  $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');

  $required = get_object_value($options, 'required');
  
  $html = "<div class='city_id_selected' ".(get_object_value($object, 'city_id') == null && get_object_value($object, 'house_id') == null ? 'style="display:none;"' : '').">";
  $html.= '<div class="control-group select">';
  $html.= '<label class="control-label" for="'.$name.'">'.required_tag().$label.'</label>';
  $html.= '<div class="controls" id="billing_tariff_id_container">';
  $html.= select_tag($name, options_for_select($billing_tariffs, 'id', 'name', get_object_value($object, $name))).$error_tag;
  $html.= "</div></div></div>";
    
  return $html;
}

function passport_field($object, $label, $options = null) {
  global $read_only;
  
  if ($read_only){
    return readonly_field($label, format_passport($object));
  } else {

    $passport_identifier = get_object_value($object, 'passport_identifier');;
    $passport_issued_by = get_object_value($object, 'passport_issued_by');
    $passport_issued_on = format_date(get_object_value($object, 'passport_issued_on'));

    $error = get_object_error($object, 'passport');
    $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
    
    $required = get_object_value($options, 'required');
    
    $html = "<div class='control-group passport".($error != null ? ' error' : null)."'><label for='passport_identifier' class='control-label'>".($required ? required_tag() : '').$label."</label><div class='controls'>";
    $html.= "<input type='text' name='passport_identifier' value='".$passport_identifier."' class='input-small passport-id' />";
    $html.= "<span class='help-inline'>выдан&nbsp;&nbsp;</span><input type='text' name='passport_issued_on' value='".$passport_issued_on."' class='date-picker input-small align-center' />";
    $html.= "<span class='help-inline'>кем&nbsp;&nbsp;</span><input type='text' name='passport_issued_by' value='".$passport_issued_by."' class='span4'/>".$error_tag;
    $html.= "</div></div>";
    
    return $html;
  }
}

function select_field($object, $name, $label, $values, $options = null, $html_options = null)
{
  $required = get_object_value($options, 'required');
  
  $error = get_object_error($object, $name);
  $error_tag = ($error != null ? "<span class='help-inline error'>".$error."</span>" : '');
  
  return '<div class="control-group select '.($error != null ? ' error' : null).'">
    <label class="control-label" for="'.$name.'">'.($required ? required_tag() : '').$label.'</label>
    <div class="controls">'.select_tag($name, $values, $html_options).$error_tag.'</div></div>';
}

function options_for_select($values, $key, $value, $selected = null, $include_blank = null) {
  $result = "";
  
  if (!is_null($include_blank)) {
    $result .= "<option value=''>".htmlspecialchars($include_blank)."</option>";
  }
  
  foreach($values as $option)
  {
    $select = $option[$key] == $selected ? "selected='selected'" : "";
    $result .= "<option value='".$option[$key]."' ".$select.">".htmlspecialchars($option[$value])."</option>";
  }
  return $result;
}

function select_tag($name, $values, $html_options = null) {
  return "<select id='".$name."' name='".$name."' ".field_attributes($html_options).">".$values."</select>";
}

function submit_button($name, $options = null) {
  return "<input type='submit' value='".$name."' class='btn btn-large btn-primary' ".field_attributes($options)." />";
}

function get_object_value($object, $method, $default = null) {
  return isset($object) && isset($object[$method]) ? $object[$method] : $default;
}

function get_object_error($object, $method) {
  return isset($object) && isset($object->errors) && isset($object->errors[$method]) ? $object->errors[$method] : null;
}

function field_attributes($attributes) {
  if (isset($attributes)) {
    $result = ' ';
    foreach ($attributes as $element => $value) {
      $result .= $element.'="'.$value.'" ';
    }
    return $result;
  }
  return '';
}

////////////////
// FORMATTING //

function mysql_time_from_ts($value) {
  return str_replace('%', '', date(MYSQL_TIME, $value));
}

function mysql_date_from_ts($value) {
  return str_replace('%', '', date(MYSQL_DATE, $value));
}

function prepare_phone($value) {
  if ($value) {
    $value = preg_replace('/[^0-9]/', '', $value);

    if (preg_match('/^375\d{9}$/', $value))
      $value = '+'.$value;

    else if (preg_match('/^3750\d{9}$/', $value))
      $value = '+375'.substr($value,4);

    else if (preg_match('/^\d{9}$/', $value))
      $value = '+375'.$value;

    # Converts it to international format.
    else if (preg_match('/^80\d{9}$/', $value))
      $value = '+375'.substr($value,2);
      
  }
  return $value;
}

function format_phone($value) {
  if (!$value) return $value;
  $value = prepare_phone($value);
  return '8 (0'.substr($value,4,2).') '.substr($value,6,3).'-'.substr($value,9,2).'-'.substr($value,11,2);
}

function prepare_name($value) {
  return mb_ucfirst(mb_strtolower(mb_trim($value), "UTF-8"));
}

function format_name($subscriber) {
  return $subscriber['last_name'].' '.$subscriber['first_name'].' '.$subscriber['middle_name'];
}

function parse_db_date($value) {
  if ($value != null) {
    $ts = strptime($value, MYSQL_DATE);
    return time($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
  } else {
    return null;
  }
}

function prepare_date($value) {
  if ($value != null) {
    $value = str_replace(',','.',$value);
    $ts = strptime($value, DATE_FORMAT);
    $ts = time($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
    return date(MYSQL_DATE, $ts);
  } else {
    return null;
  }
}

function format_month($value) {
  if ($value != null) {
    $ts = strptime($value, MYSQL_DATE);
    $ts = time($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'], $ts['tm_mday'], ($ts['tm_year'] + 1900));
    return date(MONTH_FORMAT, $ts);
  } else {
    return null;
  }
}

function format_date($value) {
  if ($value != null) {
    $ts = strptime($value, MYSQL_DATE);
    $adj_mon = OS == 'UNIX' ? 1 : 0;
    $ts = time($ts['tm_hour'], $ts['tm_min'], $ts['tm_sec'], $ts['tm_mon'] + $adj_mon, $ts['tm_mday'], ($ts['tm_year'] + 1900));
    return date(str_replace('%','', DATE_FORMAT), $ts);
  } else {
    return null;
  }
}

function format_datetime($value, $format = DATETIME_FORMAT) {
  if ($value != null) {
    $ts = strtotime($value);
    return date($format, $ts);
  } else {
    return null;
  }
}

function format_float($value, $decimals = 0) {
  return str_replace('.', ',', str_replace(',', ' ', number_format($value, $decimals)));
}

function prepare_float($value) {
  return $value === null || $value === '' ? null : str_replace(',', '.', str_replace(' ', '', $value));
}

function format_percent($value) {
  return str_replace('.', ',', number_format($value * 100, 2)).'%';
}

function format_money($value) {
  return format_float($value, 0).' р.';
}

function format_address($subscriber) {
  $address = '';
  $address .= $subscriber['city'].', ';
  $address .= $subscriber['street'].', ';
  $address .= $subscriber['house'];
  
//    $entrance = null; //calc_entrance();
//    $flat = null; //calc_flat();
//($entrance != null ? "&nbsp;&nbsp;подъезд <b>".$entrance."</b>" : "").
//($flat != null ? "&nbsp;&nbsp;этаж <b>".$flat."</b>" : "").
  
  
  if ($subscriber['building'] != '') $address .= '/'.$subscriber['building'];
  if (isset($subscriber['apartment']) && $subscriber['apartment'] != '') $address .= '-'.$subscriber['apartment'];
  return $address;
}

function format_passport($subscriber) {
  $passport = '';
  $passport .= $subscriber['passport_identifier'].', ';
  $passport .= $subscriber['passport_issued_by'].', ';
  $passport .= format_date($subscriber['passport_issued_on']);
  return $passport;
}

function format_tariff($billing_tariff) {
  return $billing_tariff ? 
    '<a class="tooltip-balloon" data-content="'.
      $billing_tariff['description'].'<br>'.
      'Абонентская плата: <b>'.format_money($billing_tariff['subscription_fee']).'</b><br>'.
      
      '" rel="popover" href="#" data-original-title="'.$billing_tariff['name'].'">'.$billing_tariff['name'].'</a>'
    : null;
}

////////////
// RENDER //

function render_house($house) {
  global $factory;
  
  $good_subscribers = array();
  $subs = Subscriber::good_subscribers($house['id']);
  foreach($subs as $sub) 
    $good_subscribers[$sub['apartment']] = $sub['id'];

  $evil_subscribers = array();
  $subs = Subscriber::evil_subscribers($house['id']);
  foreach($subs as $sub) 
    $evil_subscribers[$sub['apartment']] = $sub['id'];
  
  $schema = House::generate_schema($house);

  $max_floors = 0;
  for($e = 0; $e < count($schema); $e++) {
    if ($max_floors < count($schema[$e]))
      $max_floors = count($schema[$e]);
  }
  
  $html =  "<table style='margin:0 auto;'><tr>";
  $html .= "<td class='align-top' style='padding: 0 10px;'><table class='table table-bordered table-striped table-condensed'>";
  for ($f = $max_floors; $f >= 1; $f--) {
    $html .= "<tr><td style='font-weight:bold;' nowrap>".$f." этаж</td></tr>";
  }
  $html .= "</table></td>";
  
  for($e = 0; $e < count($schema); $e++) {
    $html .= "<td class='align-bottom' style='padding: 0 10px;'><table class='table table-bordered table-striped table-condensed'>";
    
    $max_apartments = 0; // Max apartments per entrance
    for($f = count($schema[$e]) - 1; $f >= 0; $f--) {
      if ($max_apartments < count($schema[$e][$f]))
        $max_apartments = count($schema[$e][$f]);
    }
    
    for($f = count($schema[$e]) - 1; $f >= 0; $f--) {
      if (count($schema[$e][$f]) > 0) {
        $html .= "<tr>";
        for($a = 0; $a < $max_apartments; $a++) {
          if ($a < count($schema[$e][$f])) {
            $apartment = $schema[$e][$f][$a];
            
            if (isset($good_subscribers[$apartment])) {
              $subscriber_id = $good_subscribers[$apartment];
              $apartment_class = 'good-subscriber';
            } else if (isset($evil_subscribers[$apartment])) {
              $subscriber_id = $evil_subscribers[$apartment];
              $apartment_class = 'evil-subscriber';
            } else {
              $subscriber_id = null;
              $apartment_class = 'not-subscriber';
            }
            
            $html .= "<td class='align-right ".$apartment_class."'>".($subscriber_id ? link_to_show('subscribers', $subscriber_id, $apartment) : $apartment)."</td>";
          } else {
            $html .= "<td>&nbsp;</td>";
          }
        }
        $html .= "</tr>";
      }
    }
    
    $html .= "</table>";
    $html .= "<table class='table table-bordered table-striped table-condensed'><tr><td class='align-center'><span style='font-weight:bold;'>".($e+1)." подъезд</span></td></tr></table>";
    $html .= "</td>";
    
  }
  $html .= "</tr></table>";
  
  return "<div>".$html."</div>";
}

//////////////
// SECURITY //

define('ROLE_ROOT', 'root');
define('ROLE_MASTER', 'master');
define('ROLE_OPERATOR', 'operator');
define('ROLE_ACCOUNTANT', 'accountant');

function logged_in() {
  return isset($_SESSION['user_id']);
}

// has_role(ROLE_ROOT, ROLE_OPERATOR);
function has_role() {
  $has_access = false;
  foreach (func_get_args() as $role)
    $has_access = $has_access || ($_SESSION['user_role'] == $role);
  return $has_access;
}

// only_role(ROLE_ROOT, ROLE_OPERATOR);
function only_role() {
  $has_access = false;
  foreach (func_get_args() as $role)
    $has_access = $has_access || ($_SESSION['user_role'] == $role);
  
  if (!$has_access) {
    flash_alert('В доступе отказано');
    redirect_to('/logon');
  }
}

/////////////
// STRINGS //

function starts_with($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function ends_with($haystack, $needle) {
    $length = strlen($needle);
    $start  = $length * -1; //negative
    return (substr($haystack, $start) === $needle);
}

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) { 
  function mb_ucfirst($string) {  
    $string = mb_ereg_replace("^[\ ]+","", $string);  
    $string = mb_strtoupper(mb_substr($string, 0, 1, "UTF-8"), "UTF-8").mb_substr($string, 1, mb_strlen($string), "UTF-8" );  
    return $string;  
  }  
}

function mb_trim( $string ) { 
     $string = preg_replace( "/(^\s+)|(\s+$)/us", "", $string ); 
     return $string; 
}

function rand_string($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
{
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

///////////
// OTHER //

function date_since($date) {
    $sec_since = (time() - parse_db_date($date)) / (60 * 60 * 24);

    $chunks = array(
        array(5, 365.25, 'лет'),
        array(2, 365.25, 'года'),
        array(1, 365.25, 'год'),
        array(5, 30.4, 'месяцев'),
        array(2, 30.4, 'месяца'),
        array(1, 30.4, 'месяц'),
        array(2, 7, 'недели'),
        array(1, 7, 'неделя'),
        array(5, 1, 'дней'),
        array(2, 1, 'дня'),
        array(1, 1, 'день'),
    );

    $sign = $sec_since >= 0 ? 1 : -1;
    $sec_since = $sign * $sec_since;
    
    $count = 0;
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $days = $chunks[$i][0] * $chunks[$i][1];
        if (floor($sec_since / $days) != 0) {
            $name = $chunks[$i][2];
            $count = floor($sec_since / $chunks[$i][1]);
            break;
        }
    }

    return $count == 0 ? "сегодня" : ($sign*$count)." ".$name;
}

function time_since($sec_since) {
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'год'),
        array(60 * 60 * 24 * 30 , 'мес'),
        array(60 * 60 * 24 * 7, 'нед'),
        array(60 * 60 * 24 , 'ден'),
        array(60 * 60 , 'час'),
        array(60 , 'мин'),
        array(1 , 'сек')
    );

    $sign = $sec_since >= 0 ? 1 : -1;
    $sec_since = $sign * $sec_since;
    
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        if (($count = floor($sec_since / $seconds)) != 0) {
            break;
        }
    }

    return ($sign*$count)." ".$name;
}


if (!function_exists('strptime')) { 
  function strptime($date, $format) { 
   $masks = array( 
     'd' => '(?P<d>[0-9]{2})', 
     'm' => '(?P<m>[0-9]{2})', 
     'Y' => '(?P<Y>[0-9]{4})', 
     'H' => '(?P<H>[0-9]{2})', 
     'M' => '(?P<M>[0-9]{2})', 
     'S' => '(?P<S>[0-9]{2})', 
    // usw.. 
   ); 

   $rexep = "#".strtr(preg_quote($format), $masks)."#"; 
   if(!preg_match($rexep, $date, $out)) 
     return false; 
     
   $ret = array( 
     "tm_sec"  => isset($out['S']) ? (int) $out['S'] : 0, 
     "tm_min"  => isset($out['M']) ? (int) $out['M'] : 0, 
     "tm_hour" => isset($out['H']) ? (int) $out['H'] : 0, 
     "tm_mday" => (int) $out['d'], 
     "tm_mon"  => $out['m'] ? $out['m'] : 0, 
     "tm_year" => $out['Y'] > 1900 ? $out['Y'] - 1900 : 0, 
   ); 
   return $ret; 
  }
}

function inspect_array($array) {
  $result = '';
  foreach ($array as $element => $value) {
    $result .= $element.'='.$value.';';
  }
  return $result;
}
?>