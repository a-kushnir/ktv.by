<?php
$suppress_authorization = true;
include('../../lib/application.php');

function action_import()
{
  global $layout;
  $layout = null;
  
  include('../../lib/data_import.php');
  import_data();
}

?>