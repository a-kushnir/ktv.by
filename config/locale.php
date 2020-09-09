<?php
date_default_timezone_set('Europe/Minsk');
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  // Windows
  DEFINE('OS', 'WIN');
  
  DEFINE('MONTH_FORMAT', 'm.Y');
  DEFINE('DATE_FORMAT', 'd.m.Y');
  DEFINE('DATETIME_FORMAT', 'd.m.Y H:i:s');
  DEFINE('TIME_FORMAT', 'H:i:s');
  DEFINE('SHORT_TIME_FORMAT', 'H:i');
  DEFINE('MYSQL_DATE', 'Y-m-d');
  DEFINE('MYSQL_TIME', 'Y-m-d H:i:s');   
} else {
  // Linux/Unix
  DEFINE('OS', 'UNIX');
  
  DEFINE('MONTH_FORMAT', '%m.%Y');
  DEFINE('DATE_FORMAT', '%d.%m.%Y');
  DEFINE('DATETIME_FORMAT', '%d.%m.%Y %H:%i:%s');
  DEFINE('TIME_FORMAT', '%H:%i:%s');
  DEFINE('SHORT_TIME_FORMAT', '%H:%i');
  DEFINE('MYSQL_DATE', '%Y-%m-%d');
  DEFINE('MYSQL_TIME', '%Y-%m-%d %H:%i:%s');
}

DEFINE('ERROR_BLANK', 'не может быть пустым');
DEFINE('ERROR_EXIST', 'уже существует');
DEFINE('ERROR_NOEXIST', 'не существует');
DEFINE('ERROR_NUMBER', 'не число');
DEFINE('ERROR_PAST', 'не может быть в прошлом');
DEFINE('ERROR_FUTURE', 'не может быть в будущем');
DEFINE('ERROR_BIG', 'слишком большое');
DEFINE('ERROR_LOW', 'слишком маленькое');

DEFINE('ERROR_OLD_PASSWORD', 'не совпадает');
DEFINE('ERROR_NEW_PASSWORD', 'слишком короткий');
DEFINE('ERROR_PASSWORD_CONFIRM', 'не совпадает');
?>